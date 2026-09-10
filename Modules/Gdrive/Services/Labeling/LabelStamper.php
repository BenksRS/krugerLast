<?php

namespace Modules\Gdrive\Services\Labeling;

use Intervention\Image\Facades\Image;

/**
 * Carimba a label na foto: faixa preta semitransparente no rodapé + texto
 * branco em negrito, sempre legível (sombra + contorno).
 */
class LabelStamper
{
    /** @var array<string,mixed> */
    protected $cfg;

    /** @var string */
    protected $fontFile;

    public function __construct(array $labelCfg, string $fontFile)
    {
        $this->cfg = $labelCfg;
        $this->fontFile = $labelCfg['font_file'] ?: $fontFile;
    }

    /**
     * @return string  binário JPEG da imagem carimbada
     */
    public function stamp(string $binary, string $text): string
    {
        $img = Image::make($binary);
        if (function_exists('exif_read_data')) {
            try {
                $img->orientate();
            } catch (\Throwable $e) {
                // exif ausente/ilegível — segue sem auto-rotacionar
            }
        }

        $w = $img->width();
        $h = $img->height();

        $barHeight = (int) max(
            $this->cfg['bar_min_height'],
            round($h * $this->cfg['bar_height_pct'])
        );
        $barTop = $h - $barHeight;
        $opacity = (int) round(max(0, min(1, $this->cfg['bar_opacity'])) * 100);

        $img->rectangle(0, $barTop, $w, $h, function ($draw) use ($opacity) {
            $draw->background('rgba(0, 0, 0, ' . ($opacity / 100) . ')');
        });

        $fontSize = (int) max(
            $this->cfg['font_min_size'],
            round($w * $this->cfg['font_width_pct'])
        );

        $cx = (int) round($w / 2);
        $cy = (int) round($barTop + $barHeight / 2);

        // sombra/contorno pra garantir legibilidade mesmo sobre a faixa
        foreach ([[2, 2], [-2, 2], [2, -2], [-2, -2]] as $offset) {
            $img->text($text, $cx + $offset[0], $cy + $offset[1], function ($font) use ($fontSize) {
                $font->file($this->fontFile);
                $font->size($fontSize);
                $font->color('rgba(0, 0, 0, 0.85)');
                $font->align('center');
                $font->valign('middle');
            });
        }

        $img->text($text, $cx, $cy, function ($font) use ($fontSize) {
            $font->file($this->fontFile);
            $font->size($fontSize);
            $font->color('#ffffff');
            $font->align('center');
            $font->valign('middle');
        });

        return (string) $img->encode('jpg', 90);
    }
}
