<?php

// Limitation type de fichier
// 1 Seul uplaod
// prevoir PDF A3 - juste feuille print

require 'config.php';
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Pantonify</title>
    <link rel="stylesheet" href="dist/css/pantonify.min.css" />
</head>

<body>
    <form action="ajax.php" class="dropzone" id="pantonify-dropzone"></form>
    <div id="pantonify-container" class="container"></div>
    <script src="dist/js/pantonify.min.js"></script>
</body>

</html>