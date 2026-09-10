<?php

namespace Modules\Gdrive\Services\Labeling;

use Barryvdh\DomPDF\Facade\Pdf;
use Intervention\Image\Facades\Image;

/**
 * Monta o PDF "Professional Labeled Photo Report" a partir das fotos já
 * carimboadas pelo pipeline de labeling. Layout A4 retrato, capa + páginas de
 * grade, marca Kruger (letterhead versionado) como fundo de todas as páginas.
 */
class PhotoReportBuilder
{
    /** @var KnowledgeBase */
    protected $kb;

    public function __construct(KnowledgeBase $kb = null)
    {
        $this->kb = $kb ?: new KnowledgeBase();
    }

    /**
     * @param array<int,array{seq:string,description:string,section:string,jpeg:string}> $rows
     *        fotos na ordem cronológica final (mesma do pipeline).
     * @param array<string,mixed> $job
     *        customer_name, job_number, service_type, service_date, address, summary
     * @param array<string,mixed> $cfg  config('gdrive.labeling.photo_report')
     *
     * @return array{pdf:string,pages:int,photo_count:int,sections:array<int,string>,warnings:array<int,string>}
     */
    public function build(array $rows, array $job, array $cfg): array
    {
        $perPage = max(1, (int) ($cfg['photos_per_page'] ?? 4));
        $quality = (int) ($cfg['img_quality'] ?? 80);

        $rows = array_values($rows);

        // 1. suaviza as seções (foto isolada entre dois blocos da mesma seção)
        $sections = [];
        foreach ($rows as $r) {
            $sections[] = $this->kb->normalizeSection($r['section'] ?? '');
        }
        $sections = $this->smoothSections($sections);

        // 2. downscale + data URI
        $photos = [];
        foreach ($rows as $i => $r) {
            $desc = trim((string) $r['description']) !== '' ? trim((string) $r['description']) : 'Job Site View';
            $photos[] = [
                'seq' => $r['seq'],
                'caption' => $r['seq'] . ' - ' . $desc,
                'section' => $sections[$i],
                'src' => 'data:image/jpeg;base64,' . base64_encode($this->thumbnail($r['jpeg'], $quality)),
            ];
        }

        // 3. quebra em páginas: nova página ao encher perPage OU ao trocar de seção
        $pages = [];
        $cur = [];
        $curSection = null;
        foreach ($photos as $p) {
            if ($curSection !== null && ($p['section'] !== $curSection || count($cur) >= $perPage)) {
                $pages[] = ['section' => $curSection, 'photos' => $cur];
                $cur = [];
            }
            $curSection = $p['section'];
            $cur[] = $p;
        }
        if (!empty($cur)) {
            $pages[] = ['section' => $curSection, 'photos' => $cur];
        }

        $presentSections = [];
        foreach ($pages as $pg) {
            $presentSections[$pg['section']] = true;
        }
        $presentSections = array_values(array_intersect($this->kb->sectionOrder(), array_keys($presentSections)));

        if (empty($job['summary'])) {
            $job['summary'] = $this->defaultSummary($presentSections);
        }
        $job['company'] = $cfg['company'] ?? 'KRUGER DISASTER RECOVERY';
        $job['photo_count'] = count($photos);

        // 4. render
        $pdf = Pdf::loadView('gdrive::labeling.photo-report', [
            'job' => $job,
            'pages' => $pages,
        ]);
        $pdf->setPaper('A4', 'portrait')->setWarnings(false);

        $dom = $pdf->getDomPDF();
        $pdf->render();
        $pageCount = (int) $dom->getCanvas()->get_page_count();
        $binary = (string) $pdf->output();

        $warnings = $this->verify($photos, $binary, $pageCount);

        return [
            'pdf' => $binary,
            'pages' => $pageCount,
            'photo_count' => count($photos),
            'sections' => $presentSections,
            'warnings' => $warnings,
        ];
    }

    /**
     * @param array<int,string> $sections
     * @return array<int,string>
     */
    protected function smoothSections(array $sections): array
    {
        $n = count($sections);
        for ($i = 1; $i < $n - 1; $i++) {
            if ($sections[$i] !== $sections[$i - 1]
                && $sections[$i - 1] === $sections[$i + 1]) {
                $sections[$i] = $sections[$i - 1];
            }
        }

        return $sections;
    }

    /**
     * Miniatura de tamanho fixo 4:3 (1000x750) com a foto encaixada no centro e
     * o resto preenchido de cinza (letterbox). Proporção e orientação
     * preservadas — nada é esticado nem cortado. Tamanho uniforme deixa o grid
     * do PDF previsível (dompdf não lida bem com `max-height` em <img>).
     */
    protected function thumbnail(string $bin, int $quality): string
    {
        try {
            $photo = Image::make($bin);
            $photo->resize(1200, 800, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            });

            $canvas = Image::canvas(1200, 800, '#ededed');
            $canvas->insert($photo, 'center');

            return (string) $canvas->encode('jpg', $quality);
        } catch (\Throwable $e) {
            return $bin;
        }
    }

    /**
     * @param array<int,string> $sections
     */
    protected function defaultSummary(array $sections): string
    {
        $list = strtolower(implode(', ', $sections));

        return 'This report documents the property condition and the emergency '
            . 'storm-restoration work performed on site'
            . ($list !== '' ? ' (' . $list . ')' : '')
            . '. Every photograph is chronologically numbered and individually '
            . 'labeled according to the work or condition visible in it.';
    }

    /**
     * Checagens programáticas (req. 57-59, no que dá pra fazer via PHP).
     *
     * @param array<int,array<string,mixed>> $photos
     * @return array<int,string>
     */
    protected function verify(array $photos, string $binary, int $pageCount): array
    {
        $w = [];
        $count = count($photos);

        $seqs = array_map(function ($p) {
            return (int) ltrim($p['seq'], '0') ?: 0;
        }, $photos);

        for ($i = 0; $i < $count; $i++) {
            if ($seqs[$i] !== $i + 1) {
                $w[] = sprintf('numeração fora de sequência na posição %d (esperado %03d, veio %s)', $i + 1, $i + 1, $photos[$i]['seq']);
                break;
            }
        }
        if (count(array_unique($seqs)) !== $count) {
            $w[] = 'há números de foto repetidos';
        }
        foreach ($photos as $p) {
            if (strpos($p['caption'], ' - ') === false || trim(explode(' - ', $p['caption'], 2)[1]) === '') {
                $w[] = 'foto ' . $p['seq'] . ' sem descrição na legenda';
                break;
            }
        }
        if (substr($binary, 0, 4) !== '%PDF' || strlen($binary) < 1000) {
            $w[] = 'saída não parece um PDF válido';
        }
        if ($pageCount < 2) {
            $w[] = 'PDF com menos de 2 páginas';
        }

        return $w;
    }
}
