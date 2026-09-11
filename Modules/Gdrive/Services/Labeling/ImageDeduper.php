<?php

namespace Modules\Gdrive\Services\Labeling;

use Intervention\Image\Facades\Image;

/**
 * Deduplicação perceptual (dHash 64 bits) + remoção de fotos "muito parecidas".
 * Sem dependências novas — usa intervention/image (já no projeto).
 */
class ImageDeduper
{
    /** dHash de 64 bits em hex (16 chars). '' se a imagem não decodificar. */
    public function hash(string $binary): string
    {
        try {
            $img = Image::make($binary)->greyscale()->resize(9, 8);
        } catch (\Throwable $e) {
            return '';
        }

        $bits = '';
        for ($y = 0; $y < 8; $y++) {
            for ($x = 0; $x < 8; $x++) {
                $left = $img->pickColor($x, $y, 'array');
                $right = $img->pickColor($x + 1, $y, 'array');
                $bits .= ($left[0] < $right[0]) ? '1' : '0';
            }
        }

        $hex = '';
        foreach (str_split($bits, 4) as $nibble) {
            $hex .= dechex(bindec($nibble));
        }

        return $hex;
    }

    public function hamming(string $a, string $b): int
    {
        if ($a === '' || $b === '' || strlen($a) !== strlen($b)) {
            return 64;
        }

        $distance = 0;
        for ($i = 0, $n = strlen($a); $i < $n; $i++) {
            $x = hexdec($a[$i]) ^ hexdec($b[$i]);
            $distance += substr_count(decbin($x), '1');
        }

        return $distance;
    }

    /** Nitidez relativa (energia de gradiente numa grade 16x16). Maior = mais nítida. */
    public function sharpness(string $binary): float
    {
        try {
            $img = Image::make($binary)->greyscale()->resize(16, 16);
        } catch (\Throwable $e) {
            return 0.0;
        }

        $grid = [];
        for ($y = 0; $y < 16; $y++) {
            for ($x = 0; $x < 16; $x++) {
                $grid[$y][$x] = $img->pickColor($x, $y, 'array')[0];
            }
        }

        $energy = 0.0;
        for ($y = 0; $y < 16; $y++) {
            for ($x = 0; $x < 15; $x++) {
                $dx = $grid[$y][$x] - $grid[$y][$x + 1];
                $dy = $grid[$x][$y] - $grid[$x + 1][$y];
                $energy += ($dx * $dx) + ($dy * $dy);
            }
        }

        return $energy;
    }

    /**
     * Seleciona as fotos a manter. Agrupa near-duplicates e mantém a mais nítida
     * de cada grupo. Se sobrar menos que $minKeep, aperta o limiar até chegar perto.
     *
     * @param array<int,array{hash:string,sharpness:float}> $items  indexado por posição
     * @return array{keep:int[], drop:int[]}
     */
    public function select(array $items, int $minKeep, int $threshold, int $relaxStep): array
    {
        $threshold = max(0, $threshold);

        do {
            [$keep, $drop] = $this->cluster($items, $threshold);
            if (count($keep) >= $minKeep || $threshold === 0) {
                break;
            }
            $threshold = max(0, $threshold - max(1, $relaxStep));
        } while (true);

        sort($keep);
        sort($drop);

        return ['keep' => $keep, 'drop' => $drop];
    }

    /**
     * @param array<int,array{hash:string,sharpness:float}> $items
     * @return array{0:int[],1:int[]}
     */
    protected function cluster(array $items, int $threshold): array
    {
        $reps = [];   // idx do representante de cada cluster
        $drop = [];

        foreach ($items as $idx => $item) {
            if ($item['hash'] === '') {
                // não deu pra ler -> mantém, a IA/stamp lida depois
                $reps[] = $idx;
                continue;
            }

            $matchedRep = null;
            foreach ($reps as $repIdx) {
                if ($items[$repIdx]['hash'] === '') {
                    continue;
                }
                if ($this->hamming($item['hash'], $items[$repIdx]['hash']) <= $threshold) {
                    $matchedRep = $repIdx;
                    break;
                }
            }

            if ($matchedRep === null) {
                $reps[] = $idx;
                continue;
            }

            // fica com a mais nítida como representante
            if ($item['sharpness'] > $items[$matchedRep]['sharpness']) {
                $drop[] = $matchedRep;
                $reps[array_search($matchedRep, $reps, true)] = $idx;
            } else {
                $drop[] = $idx;
            }
        }

        return [array_values($reps), array_values($drop)];
    }
}
