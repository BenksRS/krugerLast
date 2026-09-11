<?php

namespace Modules\Gdrive\Services\Labeling;

use Illuminate\Support\Facades\Schema;
use Modules\Gdrive\Entities\LabelingBanned;
use Modules\Gdrive\Entities\LabelingExample;
use Modules\Gdrive\Entities\LabelingRule;
use Modules\Gdrive\Entities\LabelingVocabulary;

/**
 * Base de conhecimento do labeling.
 *
 * - `system_prompt.md`  -> sempre do arquivo (instrução de engenharia).
 * - regras / vocabulário / palavras proibidas / exemplos -> do BANCO, editáveis
 *   pela página /gdrive/labeling. Enquanto as tabelas estiverem vazias, cai de
 *   volta pros arquivos `.md` versionados (seed inicial).
 */
class KnowledgeBase
{
    /** @var string */
    protected $dir;

    /** @var array<string,string> */
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

    protected function hasTable(string $table): bool
    {
        try {
            return Schema::hasTable($table);
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function fontFile(): string
    {
        return $this->dir . '/fonts/DejaVuSans-Bold.ttf';
    }

    /** Caminho absoluto de um asset versionado do labeling (ex.: letterhead.png). */
    public function assetPath(string $name): string
    {
        return $this->dir . '/' . ltrim($name, '/');
    }

    /* ------------------------------------------------------------ system */

    /**
     * @return array<int,array<string,mixed>>
     */
    public function systemBlocks(): array
    {
        $body = implode("\n\n", array_filter([
            $this->file('system_prompt.md'),
            "# sections.md\n\n" . $this->file('sections.md'),
            "# vocabulary.md\n\n" . $this->vocabularyText(),
            "# rules.md\n\n" . $this->rulesText(),
            "# banned.md\n\nNever output any of these words, as a whole word, inside a description:\n\n"
                . implode("\n", array_map(function ($t) { return '- ' . $t; }, $this->bannedTerms())),
        ]));

        return [[
            'type' => 'text',
            'text' => $body,
            'cache_control' => ['type' => 'ephemeral'],
        ]];
    }

    public function vocabularyText(): string
    {
        if ($this->hasTable('labeling_vocabulary') && LabelingVocabulary::where('active', true)->exists()) {
            $out = "Each `-` item is a preferred description; use it verbatim when it "
                . "accurately fits. The `##` sections are only a grouping aid — the photos "
                . "keep the order of the source folders (Front > Inside > Before > After).\n";

            $rows = LabelingVocabulary::where('active', true)
                ->orderBy('sort')->orderBy('id')->get()
                ->groupBy('category');

            foreach ($rows as $category => $terms) {
                $out .= "\n## " . $category . "\n";
                foreach ($terms as $t) {
                    $out .= '- ' . $t->term . "\n";
                }
            }

            return trim($out);
        }

        return $this->file('vocabulary.md');
    }

    public function rulesText(): string
    {
        if ($this->hasTable('labeling_rules') && LabelingRule::where('active', true)->exists()) {
            $out = '';
            $rows = LabelingRule::where('active', true)
                ->orderBy('sort')->orderBy('id')->get()
                ->groupBy('section');

            foreach ($rows as $section => $items) {
                $out .= "\n## " . $section . "\n";
                foreach ($items as $rule) {
                    $out .= '- ' . trim(preg_replace('/\s+/', ' ', $rule->body)) . "\n";
                }
            }

            return trim($out);
        }

        return $this->file('rules.md');
    }

    /* ------------------------------------------------------------ banned */

    /** @return array<int,string> */
    public function bannedTerms(): array
    {
        if ($this->hasTable('labeling_banned') && LabelingBanned::where('active', true)->exists()) {
            return LabelingBanned::where('active', true)->orderBy('term')->pluck('term')->all();
        }

        $terms = [];
        foreach (preg_split('/\R/', $this->file('banned.md')) as $line) {
            if (preg_match('/^\-\s+(.+?)\s*$/', $line, $m)) {
                $terms[] = trim($m[1]);
            }
        }

        return $terms;
    }

    public function isBanned(string $description): bool
    {
        $haystack = mb_strtolower($description);
        foreach ($this->bannedTerms() as $term) {
            $term = mb_strtolower(trim($term));
            if ($term !== '' && preg_match('/\b' . preg_quote($term, '/') . '\b/u', $haystack)) {
                return true;
            }
        }

        return false;
    }

    /* ------------------------------------------------------------ few-shot */

    /**
     * @return array<int,array<string,mixed>>
     */
    public function fewShotMessages(): array
    {
        $pairs = $this->hasTable('labeling_examples')
            ? $this->examplePairsFromDb()
            : [];

        if (empty($pairs)) {
            $pairs = $this->examplePairsFromFile();
        }

        if (empty($pairs)) {
            return [];
        }

        $lastKey = array_key_last($pairs);
        $pairs[$lastKey]['user'][1]['cache_control'] = ['type' => 'ephemeral'];

        $messages = [];
        foreach ($pairs as $pair) {
            $messages[] = ['role' => 'user', 'content' => $pair['user']];
            $messages[] = ['role' => 'assistant', 'content' => $pair['assistant']];
        }

        return $messages;
    }

    /** @return array<int,array<string,mixed>> */
    protected function examplePairsFromDb(): array
    {
        $pairs = [];
        $rows = LabelingExample::where('active', true)->orderByDesc('id')->limit(8)->get();

        foreach ($rows as $ex) {
            $path = $ex->absolutePath();
            if (!is_file($path)) {
                continue;
            }
            $pairs[] = $this->buildPair(
                file_get_contents($path),
                strtolower(pathinfo($path, PATHINFO_EXTENSION)),
                $ex->description,
                $ex->category
            );
        }

        return $pairs;
    }

    /** @return array<int,array<string,mixed>> */
    protected function examplePairsFromFile(): array
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
            $pairs[] = $this->buildPair(
                file_get_contents($path),
                strtolower(pathinfo($path, PATHINFO_EXTENSION)),
                $entry['description'] ?? '',
                $entry['category'] ?? 'Other'
            );
        }

        return $pairs;
    }

    /** @return array<string,mixed> */
    protected function buildPair(string $bin, string $ext, string $description, string $category): array
    {
        return [
            'user' => [
                [
                    'type' => 'image',
                    'source' => [
                        'type' => 'base64',
                        'media_type' => $ext === 'png' ? 'image/png' : 'image/jpeg',
                        'data' => base64_encode($bin),
                    ],
                ],
                [
                    'type' => 'text',
                    'text' => 'Label this single photograph. Respond with only the JSON line.',
                ],
            ],
            'assistant' => json_encode([
                'description' => $description,
                'category' => $category ?: 'Other',
                'from_vocabulary' => true,
                'confidence' => 0.95,
            ]),
        ];
    }

    /* ------------------------------------------------------------ categorias */

    /** @return array<int,string> */
    public function categoryOrder(): array
    {
        if ($this->hasTable('labeling_vocabulary') && LabelingVocabulary::where('active', true)->exists()) {
            return LabelingVocabulary::where('active', true)
                ->orderBy('sort')->orderBy('id')
                ->pluck('category')->unique()->values()->all();
        }

        $cats = [];
        foreach (preg_split('/\R/', $this->file('vocabulary.md')) as $line) {
            if (preg_match('/^##\s+(.+?)\s*$/', $line, $m)) {
                $cats[] = trim($m[1]);
            }
        }

        return $cats ?: ['Other'];
    }

    public function categoryRank(?string $category): int
    {
        $order = $this->categoryOrder();
        $idx = array_search((string) $category, $order, true);

        return $idx === false ? count($order) + 10 : (int) $idx;
    }

    /* ------------------------------------------------------------ seções (relatório) */

    /**
     * Lista canônica de seções do relatório profissional, lida de sections.md
     * ("## Canonical order"). Fallback fixo se o arquivo sumir.
     *
     * @return array<int,string>
     */
    public function sectionOrder(): array
    {
        $text = $this->file('sections.md');
        if (preg_match('/##\s*Canonical order.*$/is', $text, $m)) {
            $names = [];
            foreach (preg_split('/\R/', $m[0]) as $line) {
                if (preg_match('/^\-\s+(.+?)\.?\s*$/', $line, $mm)) {
                    $names[] = trim($mm[1]);
                }
            }
            if (!empty($names)) {
                return $names;
            }
        }

        return [
            'Property Overview', 'Damage Before Work', 'Tarp Installation',
            'Tree Removal Operations', 'Debris Removal', 'Yard Clean',
            'Completed Work', 'Debris Curbside', 'Measurements', 'Other',
        ];
    }

    /**
     * Casa o texto livre da IA com um nome de seção canônico (case-insensitive).
     * Sem match => "Other".
     */
    public function normalizeSection(?string $section): string
    {
        $section = trim((string) $section);
        foreach ($this->sectionOrder() as $canonical) {
            if (strcasecmp($section, $canonical) === 0) {
                return $canonical;
            }
        }

        return 'Other';
    }
}
