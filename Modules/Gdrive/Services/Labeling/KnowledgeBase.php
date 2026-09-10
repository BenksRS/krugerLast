<?php

namespace Modules\Gdrive\Services\Labeling;

/**
 * Carrega a base de conhecimento versionada em Resources/labeling/ e monta
 * o prompt de sistema + utilidades de ordenação/validação.
 */
class KnowledgeBase
{
    /** @var string */
    protected $dir;

    /** @var array<string,string> cache de arquivos lidos */
    protected $files = [];

    public function __construct(?string $dir = null)
    {
        $this->dir = $dir ?: dirname(__DIR__, 2) . '/Resources/labeling';
    }

    protected function file(string $name): string
    {
        if (!array_key_exists($name, $this->files)) {
            $path = $this->dir . '/' . $name;
            $this->files[$name] = is_file($path) ? trim(file_get_contents($path)) : '';
        }

        return $this->files[$name];
    }

    public function fontFile(): string
    {
        return $this->dir . '/fonts/DejaVuSans-Bold.ttf';
    }

    /**
     * Blocos `system` para a Messages API. O último recebe cache_control para
     * reaproveitar o prompt entre todas as fotos do mesmo job.
     *
     * @return array<int,array<string,mixed>>
     */
    public function systemBlocks(): array
    {
        $body = implode("\n\n", array_filter([
            $this->file('system_prompt.md'),
            "# vocabulary.md\n\n" . $this->file('vocabulary.md'),
            "# rules.md\n\n" . $this->file('rules.md'),
            "# banned.md\n\n" . $this->file('banned.md'),
        ]));

        return [
            [
                'type' => 'text',
                'text' => $body,
                'cache_control' => ['type' => 'ephemeral'],
            ],
        ];
    }

    /**
     * Nomes das seções (## ...) de vocabulary.md, na ordem — é a ordem de
     * numeração das fotos na pasta final.
     *
     * @return array<int,string>
     */
    public function categoryOrder(): array
    {
        $cats = [];
        foreach (preg_split('/\R/', $this->file('vocabulary.md')) as $line) {
            if (preg_match('/^##\s+(.+?)\s*$/', $line, $m)) {
                $cats[] = trim($m[1]);
            }
        }

        return $cats ?: ['Other'];
    }

    /**
     * Exemplos few-shot (imagem + label esperado) pra reforçar casos difíceis.
     * Lê examples/examples.json:
     *   [{ "image": "arq.jpg", "description": "...", "category": "...", "from_vocabulary": true }]
     * As imagens ficam em examples/. Retorna turnos user/assistant prontos pra
     * Messages API; o último turno de imagem recebe cache_control.
     *
     * @return array<int,array<string,mixed>>
     */
    public function fewShotMessages(): array
    {
        $manifest = $this->dir . '/examples/examples.json';
        if (!is_file($manifest)) {
            return [];
        }

        $entries = json_decode((string) file_get_contents($manifest), true);
        if (!is_array($entries)) {
            return [];
        }

        $pairs = [];
        foreach (array_slice($entries, 0, 8) as $entry) {
            $img = $entry['image'] ?? '';
            $path = $this->dir . '/examples/' . $img;
            if ($img === '' || !is_file($path)) {
                continue;
            }

            $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
            $pairs[] = [
                'user' => [
                    [
                        'type' => 'image',
                        'source' => [
                            'type' => 'base64',
                            'media_type' => $ext === 'png' ? 'image/png' : 'image/jpeg',
                            'data' => base64_encode((string) file_get_contents($path)),
                        ],
                    ],
                    [
                        'type' => 'text',
                        'text' => 'Label this single photograph. Respond with only the JSON line.',
                    ],
                ],
                'assistant' => json_encode([
                    'description' => $entry['description'] ?? '',
                    'category' => $entry['category'] ?? 'Other',
                    'from_vocabulary' => (bool) ($entry['from_vocabulary'] ?? false),
                    'confidence' => 0.95,
                ]),
            ];
        }

        if (empty($pairs)) {
            return [];
        }

        // cache_control no último bloco de texto de exemplo -> cacheia system + few-shot
        $lastKey = array_key_last($pairs);
        $pairs[$lastKey]['user'][1]['cache_control'] = ['type' => 'ephemeral'];

        $messages = [];
        foreach ($pairs as $pair) {
            $messages[] = ['role' => 'user', 'content' => $pair['user']];
            $messages[] = ['role' => 'assistant', 'content' => $pair['assistant']];
        }

        return $messages;
    }

    public function categoryRank(?string $category): int
    {
        $order = $this->categoryOrder();
        $idx = array_search((string) $category, $order, true);

        return $idx === false ? count($order) + 10 : (int) $idx;
    }

    /** @return array<int,string> termos proibidos (lowercase) */
    public function bannedTerms(): array
    {
        $terms = [];
        foreach (preg_split('/\R/', $this->file('banned.md')) as $line) {
            if (preg_match('/^\-\s+(.+?)\s*$/', $line, $m)) {
                $terms[] = mb_strtolower(trim($m[1]));
            }
        }

        return $terms;
    }

    public function isBanned(string $description): bool
    {
        $haystack = mb_strtolower($description);
        foreach ($this->bannedTerms() as $term) {
            if ($term !== '' && preg_match('/\b' . preg_quote($term, '/') . '\b/u', $haystack)) {
                return true;
            }
        }

        return false;
    }
}
