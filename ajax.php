<?php

require 'config.php';

if(isset($_FILES['file']['tmp_name'])) {
    $destination = Pantonify::UPLOAD_DIR . $_FILES['file']['name'];
    if(!move_uploaded_file($_FILES['file']['tmp_name'], $destination)) {
        die('Can not write : '. $destination);
    } else {
        @chmod($destination, 0755);
    }
} elseif(isset($_POST['filename'])) {
    $filename = Pantonify::UPLOAD_DIR . $_POST['filename'];
    if(!file_exists($filename)) {
        die($filename . ' does not exit');
    } else {
        $json = (new Pantonify($filename))->display();
        echo json_encode($json);
        die();
    }
}

