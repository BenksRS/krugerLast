<?php

namespace Modules\Gdrive\Services\Labeling;

use Illuminate\Support\Facades\Http;
use Modules\Gdrive\Services\Labeling\Contracts\ImageLabeler;

/**
 * Driver de labeling usando a Messages Batch API da Anthropic (Claude).
 * Assíncrono e ~50% mais barato que chamadas em tempo real.
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

    protected function client()
    {
        $anthropic = $this->cfg['anthropic'];

        return Http::baseUrl(rtrim($anthropic['base_url'], '/'))
            ->withHeaders([
                'x-api-key' => $anthropic['api_key'],
                'anthropic-version' => $anthropic['version'],
                'content-type' => 'application/json',
            ])
            ->timeout(120)
            ->retry(2, 2000);
    }

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
                'params' => [
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
                ],
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

            $results[$row['custom_id']] = $this->parseResult($row);
        }

        return ['status' => 'ended', 'results' => $results];
    }

    /**
     * @param array<string,mixed> $row
     * @return array<string,mixed>
     */
    protected function parseResult(array $row): array
    {
        $type = $row['result']['type'] ?? 'unknown';
        if ($type !== 'succeeded') {
            $detail = $row['result']['error']['error']['message']
                ?? $row['result']['error']['type']
                ?? $type;

            return ['error' => 'result ' . $type . ': ' . (is_string($detail) ? $detail : json_encode($detail))];
        }

        $text = '';
        foreach ($row['result']['message']['content'] ?? [] as $block) {
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
