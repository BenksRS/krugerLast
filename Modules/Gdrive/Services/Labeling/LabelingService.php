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
                'folder' => $file['folder'],
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

        // 4. pastas de saída — se `Labeling/` já existe, zera o conteúdo antes
        //    (re-run = regeração limpa; a pasta em si é mantida p/ preservar o link)
        $labelingPath = $this->ensureDir($gdrive->job_path, $this->cfg['output_folder']);
        $removed = $this->purgeDirContents($labelingPath);
        if ($removed > 0) {
            $this->log($queue, "Labeling/ já existia — {$removed} item(ns) antigos removidos.");
        }
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
                'folder' => $items[$idx]['folder'] ?? '',
                'source_order' => $order,
            ];
        }

        $payload = [
            'gdrive_id' => $gdrive->id,
            'job_path' => $gdrive->job_path,
            'labeling_path' => $labelingPath,
            'work_dir' => $workDir,
            'items' => $manifestItems,
            'submitted_at' => Carbon::now()->toIso8601String(),
        ];

        // modo síncrono: resolve tudo agora (billing não pode esperar a fila do batch)
        if (($this->cfg['mode'] ?? 'sync') === 'sync') {
            $queue->update(['payload' => $payload]);
            $this->log($queue, 'Analisando ' . count($batchImages) . ' fotos (síncrono)...');
            $results = $this->labeler()->labelSync($batchImages, (int) $this->cfg['sync_concurrency']);
            $this->applyResults($queue, $payload, $results);

            return;
        }

        // modo batch: envia e deixa o poll_labeling coletar depois
        $batchId = $this->labeler()->submit($batchImages);
        $this->log($queue, 'Batch enviado: ' . $batchId . ' (' . count($batchImages) . ' fotos)');

        $queue->update([
            'status' => 'awaiting_ai',
            'batch_id' => $batchId,
            'payload' => $payload,
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

        $this->applyResults($queue, $payload, $res['results'] ?? []);
    }

    /**
     * Ordena, carimba, sobe no Drive e move o job de status.
     *
     * @param array<string,mixed> $payload
     * @param array<string,array<string,mixed>> $results  indexado por custom_id
     */
    protected function applyResults(QueeLabeling $queue, array $payload, array $results): void
    {
        $workDir = $payload['work_dir'];
        $labelingPath = $payload['labeling_path'];

        // ordem = ordem da história do job (subpastas Front > Inside > Before > After),
        // já calculada em prepare() como source_order. NÃO reordenar por categoria.
        $rows = [];
        foreach ($payload['items'] as $customId => $meta) {
            $r = $results[$customId] ?? ['error' => 'sem resultado da IA'];
            $description = $this->sanitizeDescription($r['description'] ?? '', $r['category'] ?? 'Other');
            $rows[] = [
                'custom_id' => $customId,
                'index' => $meta['index'],
                'name' => $meta['name'],
                'source_order' => $meta['source_order'],
                'description' => $description,
                'section' => $this->kb->normalizeSection($r['section'] ?? ''),
            ];
        }

        usort($rows, function ($a, $b) {
            return $a['source_order'] <=> $b['source_order'];
        });

        // carimba + sobe
        $n = 0;
        $uploaded = 0;
        $reportRows = [];
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
                $reportRows[] = [
                    'seq' => $seq,
                    'description' => $row['description'],
                    'section' => $row['section'],
                    'jpeg' => $stamped,
                ];
            } catch (\Throwable $e) {
                $this->log($queue, 'Falha ao carimbar ' . $row['name'] . ': ' . $e->getMessage());
            }
        }

        $this->log($queue, "Carimbadas e enviadas: {$uploaded}/" . count($rows));

        if (!empty($this->cfg['photo_report']['enabled'])) {
            try {
                $this->buildAndUploadReport($queue, $payload, $reportRows);
            } catch (\Throwable $e) {
                $this->log($queue, 'PDF do relatório falhou (job segue mesmo assim): ' . $e->getMessage());
            }
        }

        $this->moveToNextStatus((int) $queue->assignment_id, $queue);

        $this->rmDir($workDir);
        $queue->update(['status' => 'complete']);
        $this->log($queue, 'Done');
    }

    /* ===================================================================== */
    /*  Helpers                                                               */
    /* ===================================================================== */

    /**
     * Lista as imagens de Kruger Pictures NA ORDEM DA HISTÓRIA do job:
     * subpastas em ordem natural (1- Front > 2- Inside > 3- Before > 4- After)
     * e, dentro de cada uma, por nome de arquivo natural. Fotos soltas na raiz
     * vão por último.
     *
     * @return array<int,array{read:string,name:string,folder:string,folder_rank:int}>
     */
    protected function listImages(string $root): array
    {
        $out = [];

        $subdirs = collect($this->storage->listContents($root, false))
            ->where('type', 'dir')
            ->sortBy('filename', SORT_NATURAL | SORT_FLAG_CASE)
            ->values();

        $rank = 0;
        foreach ($subdirs as $dir) {
            $rank++;
            $this->collectImages(
                $dir['basename'] ?? $dir['path'],
                $dir['filename'] ?? ('folder-' . $rank),
                $rank,
                true,
                $out
            );
        }

        // imagens soltas direto em Kruger Pictures -> depois de todas as subpastas
        $this->collectImages($root, '(root)', 99, false, $out);

        usort($out, function ($a, $b) {
            return $a['folder_rank'] === $b['folder_rank']
                ? strnatcasecmp($a['name'], $b['name'])
                : ($a['folder_rank'] <=> $b['folder_rank']);
        });

        return $out;
    }

    /**
     * @param array<int,array<string,mixed>> $out  (por referência)
     */
    protected function collectImages(string $dirId, string $folder, int $rank, bool $recursive, array &$out): void
    {
        foreach ($this->storage->listContents($dirId, $recursive) as $item) {
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
                'folder' => $folder,
                'folder_rank' => $rank,
            ];
        }
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

    /**
     * Apaga TUDO que está dentro de $dirPath no Drive (arquivos e subpastas),
     * mantendo a pasta $dirPath. Best-effort — falha em um item não interrompe.
     *
     * @return int quantos itens de 1º nível foram removidos
     */
    protected function purgeDirContents(string $dirPath): int
    {
        $removed = 0;

        foreach ($this->storage->listContents($dirPath, false) as $item) {
            $path = $item['path'] ?? ($item['basename'] ?? null);
            if (!$path) {
                continue;
            }

            try {
                if (($item['type'] ?? null) === 'dir') {
                    $this->storage->deleteDirectory($path);
                } else {
                    $this->storage->delete($path);
                }
                $removed++;
            } catch (\Throwable $e) {
                // segue — item que não deu pra apagar é raro e não deve travar o run
            }
        }

        return $removed;
    }

    protected function downscale(string $bin): string
    {
        $img = \Intervention\Image\Facades\Image::make($bin);
        if (function_exists('exif_read_data')) {
            try {
                $img->orientate();
            } catch (\Throwable $e) {
                // exif ausente — segue sem auto-rotacionar
            }
        }
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

    /**
     * Gera o PDF "Professional Labeled Photo Report" e sobe na RAIZ do job
     * (job_path) — não em Labeling/. Não toca no PDF de fotos já existente.
     *
     * @param array<string,mixed> $payload
     * @param array<int,array<string,mixed>> $reportRows
     */
    protected function buildAndUploadReport(QueeLabeling $queue, array $payload, array $reportRows): void
    {
        if (empty($reportRows)) {
            $this->log($queue, 'Relatório: nenhuma foto carimbada — PDF não gerado.');

            return;
        }

        $assignment = Assignment::find((int) $queue->assignment_id);
        if (!$assignment) {
            throw new \RuntimeException('Assignment não encontrado para o relatório.');
        }

        $jobPath = $payload['job_path'] ?? null;
        $labelingPath = $payload['labeling_path'] ?? null;
        if (!$jobPath) {
            throw new \RuntimeException('payload sem job_path.');
        }

        $customer = trim($assignment->first_name . ' ' . $assignment->last_name);
        $jobNumber = (string) $assignment->id;

        $serviceDate = '';
        $rawDate = $assignment->start_date ?: ($assignment->scheduling->start_date ?? null);
        if ($rawDate) {
            try {
                $serviceDate = Carbon::parse($rawDate)->format('F j, Y');
            } catch (\Throwable $e) {
                $serviceDate = (string) $rawDate;
            }
        }

        $street = trim((string) $assignment->street);
        $cityLine = trim(trim(sprintf('%s, %s %s', $assignment->city, $assignment->state, $assignment->zipcode), " ,"));
        $address = trim($street . ($street !== '' && $cityLine !== '' ? ', ' : '') . $cityLine, " ,");

        $serviceType = '';
        try {
            $types = $assignment->job_types()->pluck('name')->filter()->all();
            $serviceType = implode(' + ', $types);
        } catch (\Throwable $e) {
            // sem tipos — usa default abaixo
        }
        if ($serviceType === '') {
            $serviceType = $this->cfg['photo_report']['default_service'] ?? 'Storm Damage Restoration';
        }

        $job = [
            'customer_name' => $customer !== '' ? $customer : ('Job ' . $jobNumber),
            'job_number' => $jobNumber,
            'service_type' => $serviceType,
            'service_date' => $serviceDate,
            'address' => $address,
            'street' => $street,
            'city_line' => $cityLine,
            'summary' => '',
        ];

        $result = app(PhotoReportBuilder::class)->build($reportRows, $job, $this->cfg['photo_report']);

        $filename = $this->safeName(sprintf(
            '%s (%s) - Professional Labeled Photo Report',
            $job['customer_name'],
            $jobNumber
        )) . '.pdf';

        $pdfPath = rtrim($jobPath, '/') . '/' . $filename;

        // se já existe um PDF com esse nome na raiz do job, apaga antes de recriar
        // (o Drive aceita nomes duplicados — não dá pra confiar só no overwrite)
        $baseName = pathinfo($filename, PATHINFO_FILENAME);
        $deleted = 0;
        foreach ($this->storage->listContents(rtrim($jobPath, '/'), false) as $item) {
            if (($item['type'] ?? null) !== 'file') {
                continue;
            }
            $itemName = $item['filename'] ?? pathinfo($item['path'] ?? $item['basename'] ?? '', PATHINFO_FILENAME);
            if (strcasecmp((string) $itemName, $baseName) !== 0) {
                continue;
            }
            try {
                $this->storage->delete($item['path'] ?? $item['basename']);
                $deleted++;
            } catch (\Throwable $e) {
                // segue — tenta o put mesmo assim
            }
        }
        if ($deleted > 0) {
            $this->log($queue, "PDF anterior removido ({$deleted}) antes de recriar.");
        }

        $this->storage->put($pdfPath, $result['pdf']);

        foreach ($result['warnings'] as $warn) {
            $this->log($queue, 'Relatório WARN: ' . $warn);
        }

        $labeledCount = $result['photo_count'];
        $folderLink = $labelingPath ? $this->safeUrl($labelingPath) : '';
        $pdfLink = $this->safeUrl($pdfPath);

        $this->log($queue, implode('<br>', [
            '<b>== Relatório profissional gerado ==</b>',
            'Customer: ' . e($job['customer_name']),
            'Job number: ' . $jobNumber,
            'Fotos em Labeling/: ' . $labeledCount,
            'Páginas do PDF: ' . $result['pages'],
            'Seções: ' . (implode(' · ', $result['sections']) ?: '—'),
            'Todas as fotos incluídas: ' . ($result['warnings'] ? 'VERIFICAR (ver WARN acima)' : 'sim'),
            'Pasta Labeling: ' . ($folderLink ? '<a href="' . e($folderLink) . '">' . e($folderLink) . '</a>' : '—'),
            'PDF: ' . ($pdfLink ? '<a href="' . e($pdfLink) . '">' . e($pdfLink) . '</a>' : '—'),
        ]));
    }

    protected function safeUrl(string $path): string
    {
        try {
            return (string) $this->storage->url($path);
        } catch (\Throwable $e) {
            return '';
        }
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
