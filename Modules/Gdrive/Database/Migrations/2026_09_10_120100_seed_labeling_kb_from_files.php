<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Importa o conteúdo atual de vocabulary.md / rules.md / banned.md pras tabelas
 * editáveis. Só roda se a tabela estiver vazia — não sobrescreve edições feitas
 * pela página.
 */
class SeedLabelingKbFromFiles extends Migration
{
    public function up()
    {
        $dir = base_path('Modules/Gdrive/Resources/labeling');

        $this->seedSectioned("$dir/vocabulary.md", 'labeling_vocabulary', 'category', 'term');
        $this->seedSectioned("$dir/rules.md", 'labeling_rules', 'section', 'body');
        $this->seedBanned("$dir/banned.md");
    }

    public function down()
    {
        // não remove nada — os dados agora são de responsabilidade dos usuários
    }

    protected function seedSectioned(string $path, string $table, string $sectionCol, string $valueCol): void
    {
        if (!is_file($path) || DB::table($table)->count() > 0) {
            return;
        }

        $lines = preg_split('/\R/', file_get_contents($path));
        $section = 'General';
        $sort = 0;
        $rows = [];
        $current = null;

        foreach ($lines as $line) {
            if (preg_match('/^##\s+(.+?)\s*$/', $line, $m)) {
                if ($current !== null) {
                    $rows[] = $this->makeRow($sectionCol, $valueCol, $current['section'], $current['value'], $sort += 10);
                    $current = null;
                }
                $section = trim($m[1]);
                continue;
            }

            if (preg_match('/^\-\s+(.+?)\s*$/', $line, $m)) {
                if ($current !== null) {
                    $rows[] = $this->makeRow($sectionCol, $valueCol, $current['section'], $current['value'], $sort += 10);
                }
                $current = ['section' => $section, 'value' => trim($m[1])];
                continue;
            }

            // linha de continuação (indentada, não vazia) do bullet atual
            if ($current !== null && preg_match('/^\s+\S/', $line)) {
                $current['value'] .= ' ' . trim($line);
                continue;
            }

            // linha em branco / outra -> encerra o bullet atual
            if ($current !== null) {
                $rows[] = $this->makeRow($sectionCol, $valueCol, $current['section'], $current['value'], $sort += 10);
                $current = null;
            }
        }

        if ($current !== null) {
            $rows[] = $this->makeRow($sectionCol, $valueCol, $current['section'], $current['value'], $sort += 10);
        }

        $rows = array_values(array_filter($rows));

        if ($rows) {
            DB::table($table)->insert($rows);
        }
    }

    /** @return array<string,mixed>|null */
    protected function makeRow(string $sectionCol, string $valueCol, string $section, string $value, int $sort): ?array
    {
        $value = trim(preg_replace('/\s+/', ' ', $value));
        if ($value === '' || strpos($value, '(') === 0) {
            return null;
        }

        return [
            $sectionCol => $section,
            $valueCol => $value,
            'active' => 1,
            'sort' => $sort,
            'created_by' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    protected function seedBanned(string $path): void
    {
        if (!is_file($path) || DB::table('labeling_banned')->count() > 0) {
            return;
        }

        $rows = [];
        foreach (preg_split('/\R/', file_get_contents($path)) as $line) {
            if (preg_match('/^\-\s+(.+?)\s*$/', $line, $m)) {
                $rows[] = [
                    'term' => trim($m[1]),
                    'active' => 1,
                    'created_by' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        if ($rows) {
            DB::table('labeling_banned')->insert($rows);
        }
    }
}
