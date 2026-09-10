<?php

namespace Modules\Gdrive\Services\Labeling;

use Illuminate\Support\Facades\Http;
use Modules\Gdrive\Services\Labeling\Contracts\ImageLabeler;

/**
 * Driver de labeling usando a API da Anthropic (Claude).
 *
 * - modo `sync`  : POST /v1/messages em paralelo (Http::pool) — rápido, ~2x o custo.
 * - modo `batch` : Messages Batch API — assíncrono e ~50% mais barato.
 */
class AnthropicLabeler implements ImageLabeler
{
    /** @var array<string,mixed> */
    protected $cfg;

    /** @var KnowledgeBase */
    protected $kb;

    public function __construct(array $cfg, KnowledgeBase $kb)
    {
        $this->cfg = $cfg;
        $this->kb = $kb;
    }

    /* ---------------------------------------------------------------- infra */

    protected function base(): string
    {
        return rtrim($this->cfg['anthropic']['base_url'], '/');
    }

    /** @return array<string,string> */
    protected function headers(): array
    {
        return [
            'x-api-key' => $this->cfg['anthropic']['api_key'],
            'anthropic-version' => $this->cfg['anthropic']['version'],
            'content-type' => 'application/json',
        ];
    }

    protected function client()
    {
        return Http::baseUrl($this->base())
            ->withHeaders($this->headers())
            ->timeout(120)
            ->retry(2, 2000);
    }

    /**
     * @param array{custom_id:string,jpeg:string} $image
     * @param array<int,array<string,mixed>> $system
     * @return array<string,mixed>
     */
    protected function messageParams(array $image, array $system): array
    {
        return [
            'model' => $this->cfg['model'],
            'max_tokens' => 300,
            'system' => $system,
            'messages' => [[
                'role' => 'user',
                'content' => [
                    [
                        'type' => 'image',
                        'source' => [
                            'type' => 'base64',
                            'media_type' => 'image/jpeg',
                            'data' => base64_encode($image['jpeg']),
                        ],
                    ],
                    [
                        'type' => 'text',
                        'text' => 'Label this single photograph. Respond with only the JSON line.',
                    ],
                ],
            ]],
        ];
    }

    /* ---------------------------------------------------------------- sync */

    public function labelSync(array $images, int $concurrency): array
    {
        if (empty($images)) {
            return [];
        }

        $concurrency = max(1, min(12, $concurrency ?: 5));
        $system = $this->kb->systemBlocks();

        $pending = [];
        foreach ($images as $img) {
            $pending[$img['custom_id']] = $img;
        }

        $out = [];
        for ($attempt = 1; $attempt <= 3 && !empty($pending); $attempt++) {
            $retry = [];

            foreach (array_chunk(array_values($pending), $concurrency) as $chunk) {
                $responses = Http::pool(function ($pool) use ($chunk, $system) {
                    $calls = [];
                    foreach ($chunk as $img) {
                        $calls[] = $pool->as($img['custom_id'])
                            ->withHeaders($this->headers())
                            ->timeout(90)
                            ->post($this->base() . '/v1/messages', $this->messageParams($img, $system));
                    }

                    return $calls;
                });

                foreach ($chunk as $img) {
                    $cid = $img['custom_id'];
                    $resp = $responses[$cid] ?? null;

                    if ($resp instanceof \Throwable) {
                        $retry[$cid] = $img;
                        continue;
                    }
                    if (!$resp || $resp->status() === 429 || $resp->serverError()) {
                        $retry[$cid] = $img;
                        continue;
                    }
                    if (!$resp->successful()) {
                        $out[$cid] = ['error' => 'http ' . $resp->status() . ': ' . mb_substr($resp->body(), 0, 160)];
                        continue;
                    }

                    $out[$cid] = $this->parseContent($resp->json('content') ?? []);
                }

                usleep(300000);
            }

            $pending = $retry;
            if (!empty($pending)) {
                sleep(5 * $attempt);
            }
        }

        foreach ($pending as $cid => $img) {
            $out[$cid] = ['error' => 'falhou após retries (rate limit / servidor)'];
        }

        return $out;
    }

    /* --------------------------------------------------------------- batch */

    public function submit(array $images): string
    {
        if (empty($images)) {
            throw new \RuntimeException('AnthropicLabeler::submit chamado sem imagens.');
        }

        $system = $this->kb->systemBlocks();
        $requests = [];
        foreach ($images as $image) {
            $requests[] = [
                'custom_id' => $image['custom_id'],
                'params' => $this->messageParams($image, $system),
            ];
        }

        $response = $this->client()->post('/v1/messages/batches', ['requests' => $requests]);

        if (!$response->successful()) {
            throw new \RuntimeException('Anthropic batch create falhou: ' . $response->status() . ' ' . $response->body());
        }

        $id = $response->json('id');
        if (!$id) {
            throw new \RuntimeException('Anthropic batch create sem id: ' . $response->body());
        }

        return $id;
    }

    public function fetch(string $batchId): array
    {
        $response = $this->client()->get('/v1/messages/batches/' . $batchId);

        if (!$response->successful()) {
            return ['status' => 'error', 'error' => 'batch retrieve ' . $response->status() . ' ' . $response->body()];
        }

        if ($response->json('processing_status') !== 'ended') {
            return ['status' => 'in_progress'];
        }

        $resultsUrl = $response->json('results_url');
        if (!$resultsUrl) {
            return ['status' => 'error', 'error' => 'batch ended sem results_url'];
        }

        $raw = $this->client()->get($resultsUrl);
        if (!$raw->successful()) {
            return ['status' => 'error', 'error' => 'results download ' . $raw->status()];
        }

        $results = [];
        foreach (preg_split('/\R/', trim($raw->body())) as $line) {
            $line = trim($line);
            if ($line === '') {
                continue;
            }

            $row = json_decode($line, true);
            if (!is_array($row) || !isset($row['custom_id'])) {
                continue;
            }

            $results[$row['custom_id']] = $this->parseBatchRow($row);
        }

        return ['status' => 'ended', 'results' => $results];
    }

    /* --------------------------------------------------------------- parse */

    /**
     * @param array<string,mixed> $row
     * @return array<string,mixed>
     */
    protected function parseBatchRow(array $row): array
    {
        $type = $row['result']['type'] ?? 'unknown';
        if ($type !== 'succeeded') {
            $detail = $row['result']['error']['error']['message']
                ?? $row['result']['error']['type']
                ?? $type;

            return ['error' => 'result ' . $type . ': ' . (is_string($detail) ? $detail : json_encode($detail))];
        }

        return $this->parseContent($row['result']['message']['content'] ?? []);
    }

    /**
     * @param array<int,array<string,mixed>> $content
     * @return array<string,mixed>
     */
    protected function parseContent(array $content): array
    {
        $text = '';
        foreach ($content as $block) {
            if (($block['type'] ?? null) === 'text') {
                $text .= $block['text'];
            }
        }

        $json = $this->extractJson($text);
        if ($json === null) {
            return ['error' => 'resposta sem JSON: ' . mb_substr(trim($text), 0, 180)];
        }

        return [
            'description' => trim((string) ($json['description'] ?? '')),
            'category' => trim((string) ($json['category'] ?? 'Other')),
            'from_vocabulary' => (bool) ($json['from_vocabulary'] ?? false),
            'confidence' => (float) ($json['confidence'] ?? 0),
        ];
    }

    /** @return array<string,mixed>|null */
    protected function extractJson(string $text): ?array
    {
        $text = trim($text);
        $text = preg_replace('/^```(?:json)?|```$/m', '', $text);

        $start = strpos($text, '{');
        $end = strrpos($text, '}');
        if ($start === false || $end === false || $end <= $start) {
            return null;
        }

        $decoded = json_decode(substr($text, $start, $end - $start + 1), true);

        return is_array($decoded) ? $decoded : null;
    }
}
