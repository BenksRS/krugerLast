<?php

namespace Modules\Gdrive\Services\Labeling\Contracts;

interface ImageLabeler
{
    /**
     * Envia um lote de imagens pra análise assíncrona.
     *
     * @param array<int,array{custom_id:string,jpeg:string}> $images
     * @return string  id do batch
     */
    public function submit(array $images): string;

    /**
     * Analisa um lote de imagens de forma síncrona (em paralelo).
     *
     * @param array<int,array{custom_id:string,jpeg:string}> $images
     * @return array<string,array{description?:string,category?:string,from_vocabulary?:bool,confidence?:float,error?:string}>  indexado por custom_id
     */
    public function labelSync(array $images, int $concurrency): array;

    /**
     * Consulta um batch.
     *
     * @return array{
     *   status: string,                       // in_progress | ended | error
     *   error?: string,
     *   results?: array<string,array{description?:string,category?:string,from_vocabulary?:bool,confidence?:float,error?:string}>
     * }
     */
    public function fetch(string $batchId): array;
}
