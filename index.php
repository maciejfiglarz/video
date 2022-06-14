<?php

require 'vendor/autoload.php';

header("Content-Type: application/json");
header("Acess-Control-Allow-Origin: *");
header("Acess-Control-Allow-Methods: POST");
header("Acess-Control-Allow-Headers: Acess-Control-Allow-Headers,Content-Type,Acess-Control-Allow-Methods, Authorization");

$ffmpeg = FFMpeg\FFMpeg::create();


var_dump($_FILES);

$uploaddir = '/uploads/';
$uploadfile = $uploaddir . basename($_FILES['video']['name']);


if (move_uploaded_file($_FILES['video']['tmp_name'], $uploadfile)) {
    echo "File is valid, and was successfully uploaded.\n";
} else {
    echo "Possible file upload attack1!\n";
}


echo php_ini_loaded_file();
