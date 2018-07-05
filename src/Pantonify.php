<?php

use Intervention\Image\ImageManagerStatic as Image;

class Pantonify
{

    const PANTONE_NUMBERS_JSON = 'https://raw.githubusercontent.com/Margaret2/pantone-colors/master/pantone-numbers.json';
    public $filename;
    public $image;
    public $matrice;
    public $pantones;

    public function __construct($filename)
    {
        $this->filename = $this->resample($filename);
        $this->image = imagecreatefrompng($this->filename);
        $this->getPantones();
        $this->getMatrice();
    }

    public function resample($filename) {
        $resample_filename = 'resample.png';
        $image = Image::make($filename)->resize(12, 9);
        $image->save($resample_filename);
        return $resample_filename;
    }

    public function getPantones()
    {
        $this->pantones = json_decode(file_get_contents(self::PANTONE_NUMBERS_JSON), true);
        foreach ($this->pantones as $code => &$pantone) {
            list($r, $g, $b) = sscanf($pantone['hex'], "%02x%02x%02x");
            $pantone['r'] = $r;
            $pantone['g'] = $g;
            $pantone['b'] = $b;
            $pantone['code'] = $code;
        }
    }

    function getMatrice()
    {
        $size = getimagesize($this->filename);
        $this->matrice = array();
        for ($y = 0; $y < $size[1]; $y++) {
            for ($x = 0; $x < $size[0]; $x++) {
                $this->matrice[$y][$x] = $this->getPixelColor($x, $y);
            }
        }
    }

    public function getPixelColor($x, $y)
    {
        $rgb = imagecolorat($this->image, $x, $y);
        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;
        $color = array(
            'r' => $r,
            'g' => $g,
            'b' => $b
        );
        $color['pantone'] = $this->getNearestPantone($color);
        return $color;
    }

    public function getNearestPantone($color)
    {
        $best_rank = 768;
        foreach ($this->pantones as $pantone) {
            $rank = 0;
            $rank += abs($color['r'] - $pantone['r']);
            $rank += abs($color['g'] - $pantone['g']);
            $rank += abs($color['b'] - $pantone['b']);
            if ($rank <= $best_rank) {
                $best_rank = $rank;
                $nearest_pantone = $pantone;
            }
        }
        return $nearest_pantone;
    }

    public function display()
    {
        $html = '';
        foreach ($this->matrice as $x) {
            foreach ($x as $color) {
                $html .= '<div>
                        <div class="color-block" style="background-color:rgba(' . $color['r'] . ', ' . $color['g'] . ', ' . $color['b'] . ')"></div>
                        <div class="patone-block">
                            <strong>' . $color['pantone']['code'] . '</strong>
                            <span>' . $color['pantone']['name'] . '</span>
                        </div>
                      </div>';
            }
        }
        return $html;
    }
}