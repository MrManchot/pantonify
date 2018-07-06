<?php

// Limitation type de fichier
// 1 Seul uplaod
// prevoir PDF A3 - juste feuille print

ini_set('display_errors', 1);
error_reporting(E_ALL);
require 'vendor/autoload.php';
require 'src/Pantonify.php';

if(isset($_FILES['file']['tmp_name'])) {
    $destination = Pantonify::UPLOAD_DIR . $_FILES['file']['name'];
    if(!move_uploaded_file($_FILES['file']['tmp_name'], $destination)) {
        die('Can not write : '. $destination);
    }
} elseif(isset($_POST['filename'])) {
    echo (new Pantonify(Pantonify::UPLOAD_DIR . $_POST['filename']))->display();
}