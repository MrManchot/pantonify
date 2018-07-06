<?php

require 'config.php';

if(isset($_FILES['file']['tmp_name'])) {
    $destination = Pantonify::UPLOAD_DIR . $_FILES['file']['name'];
    if(!move_uploaded_file($_FILES['file']['tmp_name'], $destination)) {
        die('Can not write : '. $destination);
    }
} elseif(isset($_POST['filename'])) {
    echo (new Pantonify(Pantonify::UPLOAD_DIR . $_POST['filename']))->display();
}