<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
require 'vendor/autoload.php';
require 'src/Pantonify.php';

$html = (new Pantonify('image.jpg'))->display();

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Pantonify</title>
    <link rel="stylesheet" href="css/main.css" />
</head>

<body>
    <div class="container"><?=$html?></div>
</body>

</html>