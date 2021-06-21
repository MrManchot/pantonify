<?php

require_once 'config.php';
require_once __DIR__ . '/vendor/autoload.php';

// Calcul des dimensions en pixel en dynamique
// Calcul formats landcape / portrait
// Centrage dans le PDF

$filename = __DIR__ . '/test.jpg';
$return = (new Pantonify($filename))->display();
$width = 1029;
$html = '<html>
        <head><style>' . file_get_contents(__DIR__ . '/css/pdf.css') . '</style></head>
        <body>
        <div id="pantonify-container">' . $return['html'] . '</div>
        </body>
        </html>';

$dompdf = new Dompdf\Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A3', 'portrait');
$dompdf->render();
$dompdf->stream();
// file_put_contents('Brochure.pdf', $dompdf->output());
//echo $html;