<?php

namespace Modules\Gdrive\Services\Labeling;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Modules\Assignments\Entities\Assignment;
use Modules\Assignments\Entities\AssignmentsStatus;
use Modules\Assignments\Entities\AssignmentsStatusPivot;
use Modules\Gdrive\Entities\Gdrive;
use Modules\Gdrive\Entities\QueeLabeling;
use Modules\Gdrive\Services\Labeling\Contracts\ImageLabeler;

class LabelingService
{
    /** @var array<string,mixed> */
    protected $cfg;

    /** @var \Illuminate\Contracts\Filesystem\Filesystem */
    protected $storage;

    /** @var KnowledgeBase */
    protected $kb;

    /** @var ImageDeduper */
    protected $deduper;

    /** @var LabelStamper */
    protected $stamper;

    /** @var ImageLabeler|null */
    protected $labeler;

    protected $imageExt = ['jpg', 'jpeg', 'png', 'webp'];

    public function __construct()
    {
        $this->cfg = config('gdrive.labeling');
        $this->storage = Storage::disk('google');
        $this->kb = new KnowledgeBase();
        $this->deduper = new ImageDeduper();
        $this->stamper = new LabelStamper($this->cfg['label'], $this->kb->fontFile());
    }

    protected function labeler(): ImageLabeler
    {
        if ($this->labeler === null) {
            $this->labeler = $this->makeLabeler();
        }

        return $this->labeler;
    }

    protected function makeLabeler(): ImageLabeler
    {
        switch ($this->cfg['driver']) {
            case 'anthropic':
                if (empty($this->cfg['anthropic']['api_key'])) {
                    throw new \RuntimeException('ANTHROPIC_API_KEY não configurada.');
                }

                return new AnthropicLabeler($this->cfg, $this->kb);
            default:
                throw new \RuntimeException("Driver de labeling desconhecido: {$this->cfg['driver']}");
        }
    }

    /* ===================================================================== */
    /*  Fase 1 — coleta + dedup + envio do batch                              */
    /* ===================================================================== */

    public function prepare(QueeLabeling $queue): void
    {
        $assignmentId = (int) $queue->assignment_id;
        $this->log($queue, 'Start');

        $gdrive = Gdrive::where('assignment_id', $assignmentId)->first();
        if (!$gdrive || empty($gdrive->job_path) || empty($gdrive->{$this->cfg['source_folder_key']})) {
            throw new \RuntimeException('Gdrive do job sem job_path / pasta de origem.');
        }

        $sourceRoot = $gdrive->{$this->cfg['source_folder_key']};

        // 1. lista recursiva de imagens em Kruger Pictures
        $files = $this->listImages($sourceRoot);
        $this->log($queue, 'Fotos encontradas: ' . count($files));
        if (empty($files)) {
            throw new \RuntimeException('Nenhuma imagem em Kruger Pictures.');
        }

        // 2. baixa + hash + nitidez
        $workDir = rtrim($this->cfg['work_dir'], '/') . '/' . $assignmentId;
        $this->rmDir($workDir);
        @mkdir($workDir . '/orig', 0775, true);

        $items = [];
        foreach ($files as $i => $file) {
            try {
                $bin = $this->storage->get($file['read']);
            } catch (\Throwable $e) {
                continue;
            }
            file_put_contents($workDir . '/orig/' . $i . '.jpg', $bin);
            $items[$i] = [
                'index' => $i,
                'name' => $file['name'],
                'hash' => $this->deduper->hash($bin),
                'sharpness' => $this->deduper->sharpness($bin),
            ];
        }
        $items = array_values($items);
        $this->log($queue, 'Baixadas: ' . count($items));

        // 3. dedup
        $hashInput = [];
        foreach ($items as $it) {
            $hashInput[] = ['hash' => $it['hash'], 'sharpness' => $it['sharpness']];
        }
        $selection = $this->deduper->select(
            $hashInput,
            (int) $this->cfg['min_photos'],
            (int) $this->cfg['dedupe']['hamming_threshold'],
            (int) $this->cfg['dedupe']['relax_step']
        );
        $this->log($queue, sprintf('Após dedup: %d mantidas, %d descartadas', count($selection['keep']), count($selection['drop'])));

        // 4. pastas de saída
        $labelingPath = $this->ensureDir($gdrive->job_path, $this->cfg['output_folder']);
        $discardedPath = $this->ensureDir($labelingPath, basename($this->cfg['discarded_folder']));

        // 5. sobe as descartadas (originais)
        foreach ($selection['drop'] as $idx) {
            $orig = $workDir . '/orig/' . $items[$idx]['index'] . '.jpg';
            if (is_file($orig)) {
                $this->storage->put($discardedPath . '/' . $this->safeName($items[$idx]['name']), file_get_contents($orig));
            }
        }

        // 6. monta o lote pra IA (imagem reduzida)
        $manifestItems = [];
        $batchImages = [];
        foreach ($selection['keep'] as $order => $idx) {
            $customId = 'img-' . $items[$idx]['index'];
            $orig = $workDir . '/orig/' . $items[$idx]['index'] . '.jpg';
            $batchImages[] = [
                'custom_id' => $customId,
                'jpeg' => $this->downscale(file_get_contents($orig)),
            ];
            $manifestItems[$customId] = [
                'index' => $items[$idx]['index'],
                'name' => $items[$idx]['name'],
                'source_order' => $order,
            ];
        }

        $batchId = $this->labeler()->submit($batchImages);
        $this->log($queue, 'Batch enviado: ' . $batchId . ' (' . count($batchImages) . ' fotos)');

        $queue->update([
            'status' => 'awaiting_ai',
            'batch_id' => $batchId,
            'payload' => [
                'gdrive_id' => $gdrive->id,
                'job_path' => $gdrive->job_path,
                'labeling_path' => $labelingPath,
                'work_dir' => $workDir,
                'items' => $manifestItems,
                'submitted_at' => Carbon::now()->toIso8601String(),
            ],
        ]);
    }

    /* ===================================================================== */
    /*  Fase 2 — coleta resultados + carimba + sobe + muda status             */
    /* ===================================================================== */

    public function finalize(QueeLabeling $queue): void
    {
        $payload = $queue->payload ?: [];
        $batchId = $queue->batch_id;
        if (!$batchId || empty($payload['items'])) {
            throw new \RuntimeException('Fila sem batch_id / manifesto.');
        }

        $res = $this->labeler()->fetch($batchId);

        if ($res['status'] === 'in_progress') {
            $submittedAt = Carbon::parse($payload['submitted_at'] ?? $queue->updated_at);
            if ($submittedAt->diffInHours(Carbon::now()) >= (int) $this->cfg['batch_timeout_hours']) {
                throw new \RuntimeException('Batch travado (timeout): ' . $batchId);
            }

            return; // continua esperando
        }

        if ($res['status'] !== 'ended') {
            throw new \RuntimeException('Batch com erro: ' . ($res['error'] ?? 'desconhecido'));
        }

        $results = $res['results'] ?? [];
        $workDir = $payload['work_dir'];
        $labelingPath = $payload['labeling_path'];

        // ordena: categoria (ordem do vocabulary.md) -> ordem original
        $rows = [];
        foreach ($payload['items'] as $customId => $meta) {
            $r = $results[$customId] ?? ['error' => 'sem resultado no batch'];
            $description = $this->sanitizeDescription($r['description'] ?? '', $r['category'] ?? 'Other');
            $rows[] = [
                'custom_id' => $customId,
                'index' => $meta['index'],
                'name' => $meta['name'],
                'source_order' => $meta['source_order'],
                'category' => $r['category'] ?? 'Other',
                'description' => $description,
            ];
        }

        usort($rows, function ($a, $b) {
            $ca = $this->kb->categoryRank($a['category']);
            $cb = $this->kb->categoryRank($b['category']);

            return $ca === $cb ? ($a['source_order'] <=> $b['source_order']) : ($ca <=> $cb);
        });

        // carimba + sobe
        $n = 0;
        $uploaded = 0;
        foreach ($rows as $row) {
            $n++;
            $seq = sprintf('%03d', $n);
            $orig = $workDir . '/orig/' . $row['index'] . '.jpg';
            if (!is_file($orig)) {
                continue;
            }

            $caption = $seq . ' - ' . $row['description'];
            try {
                $stamped = $this->stamper->stamp(file_get_contents($orig), $caption);
                $this->storage->put($labelingPath . '/' . $this->safeName($caption) . '.jpg', $stamped);
                $uploaded++;
            } catch (\Throwable $e) {
                $this->log($queue, 'Falha ao carimbar ' . $row['name'] . ': ' . $e->getMessage());
            }
        }

        $this->log($queue, "Carimbadas e enviadas: {$uploaded}/" . count($rows));

        $this->moveToNextStatus((int) $queue->assignment_id, $queue);

        $this->rmDir($workDir);
        $queue->update(['status' => 'complete']);
        $this->log($queue, 'Done');
    }

    /* ===================================================================== */
    /*  Helpers                                                               */
    /* ===================================================================== */

    /**
     * @return array<int,array{read:string,name:string}>
     */
    protected function listImages(string $root): array
    {
        $out = [];
        foreach ($this->storage->listContents($root, true) as $item) {
            if (($item['type'] ?? null) !== 'file') {
                continue;
            }
            $ext = strtolower($item['extension'] ?? pathinfo($item['path'] ?? '', PATHINFO_EXTENSION));
            $isImage = in_array($ext, $this->imageExt, true)
                || strpos((string) ($item['mimetype'] ?? ''), 'image/') === 0;
            if (!$isImage) {
                continue;
            }

            $name = $item['filename'] ?? pathinfo($item['path'] ?? 'photo', PATHINFO_FILENAME);
            $out[] = [
                'read' => $item['path'] ?? $item['basename'],
                'name' => $name . ($ext ? '.' . $ext : '.jpg'),
            ];
        }

        return $out;
    }

    protected function ensureDir(string $parentPath, string $name): string
    {
        $existing = collect($this->storage->listContents($parentPath, false))
            ->where('type', 'dir')
            ->where('filename', $name)
            ->first();

        if ($existing) {
            return $existing['basename'] ?? $existing['path'];
        }

        $this->storage->makeDirectory($parentPath . '/' . $name);

        $created = collect($this->storage->listContents($parentPath, false))
            ->where('type', 'dir')
            ->where('filename', $name)
            ->first();

        if (!$created) {
            throw new \RuntimeException("Não consegui criar a pasta {$name} no Drive.");
        }

        return $created['basename'] ?? $created['path'];
    }

    protected function downscale(string $bin): string
    {
        $img = \Intervention\Image\Facades\Image::make($bin);
        $img->orientate();
        $max = (int) $this->cfg['ai_max_dimension'];
        if (max($img->width(), $img->height()) > $max) {
            $img->resize($max, $max, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            });
        }

        return (string) $img->encode('jpg', (int) $this->cfg['ai_jpeg_quality']);
    }

    protected function sanitizeDescription(string $description, string $category): string
    {
        $description = trim(preg_replace('/\s+/', ' ', $description));

        if ($description === '' || mb_strlen($description) > 60 || $this->kb->isBanned($description)) {
            $fallback = ($category && $category !== 'Other' && !$this->kb->isBanned($category)) ? $category : 'Job Site View';

            return $fallback;
        }

        return $description;
    }

    protected function safeName(string $s): string
    {
        $s = preg_replace('#[/\\\\:*?"<>|]+#', ' ', $s);
        $s = trim(preg_replace('/\s+/', ' ', $s));

        return $s === '' ? 'photo' : mb_substr($s, 0, 120);
    }

    protected function moveToNextStatus(int $assignmentId, QueeLabeling $queue): void
    {
        $statusId = AssignmentsStatus::where('class', $this->cfg['next_status_class'])->value('id');
        if (!$statusId) {
            $this->log($queue, 'Status "' . $this->cfg['next_status_class'] . '" não encontrado — status do job não alterado.');

            return;
        }

        $assignment = Assignment::find($assignmentId);
        if (!$assignment) {
            return;
        }

        AssignmentsStatusPivot::create([
            'assignment_id' => $assignmentId,
            'assignment_status_id' => $statusId,
            'created_by' => 73,
            'description' => 'Auto: labeling concluído',
        ]);
        $assignment->update(['status_id' => $statusId, 'updated_by' => 73]);

        if (function_exists('integration')) {
            try {
                integration('assignments')->set($assignmentId);
            } catch (\Throwable $e) {
                // best effort
            }
        }
    }

    protected function rmDir(string $dir): void
    {
        if (!is_dir($dir)) {
            return;
        }
        $it = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST
        );
        foreach ($it as $file) {
            $file->isDir() ? @rmdir($file->getPathname()) : @unlink($file->getPathname());
        }
        @rmdir($dir);
    }

    public function log(QueeLabeling $queue, string $message): void
    {
        $line = '<b>' . e($message) . ':</b> ' . Carbon::now();
        $queue->history = trim(($queue->history ? $queue->history . '<br>' : '') . $line);
        $queue->save();
    }
}
