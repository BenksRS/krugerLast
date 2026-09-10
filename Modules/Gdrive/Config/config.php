<?php

return [
    'name' => 'Gdrive',

    /*
    |--------------------------------------------------------------------------
    | Auto-labeling (status `labeling`)
    |--------------------------------------------------------------------------
    | Pipeline: copia fotos de `Kruger Pictures/` do Drive do job -> deduplica
    | -> IA descreve cada foto -> carimba a label na imagem -> sobe em `Labeling/`.
    */
    'labeling' => [
        // driver de IA: anthropic | (futuro: openai | local)
        'driver' => env('LABELING_AI_DRIVER', 'anthropic'),
        'model'  => env('LABELING_AI_MODEL', 'claude-sonnet-5'),

        // sync  = POST /v1/messages em paralelo, termina em minutos (~2x custo)
        // batch = Messages Batch API, assíncrono e ~50% mais barato (SLA até 24h)
        'mode' => env('LABELING_AI_MODE', 'sync'),
        'sync_concurrency' => (int) env('LABELING_SYNC_CONCURRENCY', 5),

        'anthropic' => [
            'api_key'  => env('ANTHROPIC_API_KEY'),
            'base_url' => env('ANTHROPIC_BASE_URL', 'https://api.anthropic.com'),
            'version'  => '2023-06-01',
        ],

        // campo da tabela `gdrive` usado como raiz das fotos de origem
        'source_folder_key' => 'kruger_pictures_path',

        // pastas de saída (relativas ao `job_path` do Drive)
        'output_folder'    => 'Labeling',
        'discarded_folder' => 'Labeling/_discarded',

        // mínimo de fotos que devem sobrar após dedup (afrouxa o limiar até chegar perto)
        'min_photos' => 50,

        // downscale enviado pra IA (não afeta a foto final carimbada)
        'ai_max_dimension' => 1024,
        'ai_jpeg_quality'  => 82,

        'dedupe' => [
            'hamming_threshold' => 10,   // distância dHash <= isto  => "muito parecida"
            'relax_step'        => 4,
            'relax_max'         => 30,
        ],

        // status pra onde o job vai depois de rotular (resolvido por `class`)
        'next_status_class' => 'preparing_billing',

        'work_dir' => storage_path('app/labeling'),

        'label' => [
            'bar_opacity'    => 0.78,   // 0..1
            'bar_min_height' => 46,     // px
            'bar_height_pct' => 0.09,   // fração da altura da imagem
            'font_width_pct' => 0.028,  // fração da largura da imagem
            'font_min_size'  => 15,     // px
            'font_file'      => null,   // null => DejaVuSans-Bold do módulo
        ],

        // batch expira / é considerado travado após X horas em awaiting_ai
        'batch_timeout_hours' => 26,

        // quantos jobs a rota poll_labeling processa por chamada
        'poll_batch_size' => 3,

        // PDF "Professional Labeled Photo Report" gerado ao fim do pipeline
        // e enviado para a raiz do job no Drive (job_path).
        'photo_report' => [
            'enabled'         => env('LABELING_PHOTO_REPORT', true),
            'photos_per_page' => (int) env('LABELING_REPORT_PPP', 2),
            'img_quality'     => 80,
            'company'         => 'KRUGER DISASTER RECOVERY',
            'default_service' => 'Storm Damage Restoration',
        ],
    ],
];
