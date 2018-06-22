<?php

class Pantonify
{

    const PANTONE_NUMBERS_JSON = 'https://raw.githubusercontent.com/Margaret2/pantone-colors/master/pantone-numbers.json';
    public $filename;
    public $image;
    public $matrice;
    public $pantones;

    public function __construct($filename)
    {
        $this->filename = $filename;
        $this->image = imagecreatefrompng($this->filename);
        $this->getPantones();
        $this->getMatrice();
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
        foreach ($this->matrice as $x) {
            foreach ($x as $color) {
                echo '<div>
                        <div class="color-block" style="background-color:rgba(' . $color['r'] . ', ' . $color['g'] . ', ' . $color['b'] . ')"></div>
                        <div class="patone-block">
                            <strong>' . $color['pantone']['code'] . '</strong>
                            <span>' . $color['pantone']['name'] . '</span>
                        </div>
                      </div>';
            }
        }
    }
}

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Pantonify</title>
    <style>
        .container {
            display: grid;
            grid-template-columns: repeat(12, 80px);
            grid-column-gap: 2px;
        }

        .container > div {
            margin-bottom: 2px;
        }

        .patone-block {
            color: #4a4a4a;
            font-family: Helvetica, Arial, sans-serif;
            padding: 5%;
            font-size: 7px;
        }

        .patone-block strong, .patone-block span {
            display: block;
            text-transform: capitalize;
        }

        .color-block {
            height: 80px;
        }
    </style>
</head>

<body>
    <div class="container"><?php (new Pantonify('mouleyre.png'))->display(); ?></div>
</body>

</html>