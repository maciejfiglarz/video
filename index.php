<?php

require 'vendor/autoload.php';

header("Content-Type: application/json");
header("Acess-Control-Allow-Origin: *");
header("Acess-Control-Allow-Methods: POST");
header("Acess-Control-Allow-Headers: Acess-Control-Allow-Headers,Content-Type,Acess-Control-Allow-Methods, Authorization");

$ffmpeg = FFMpeg\FFMpeg::create();


var_dump($_POST);


echo php_ini_loaded_file(); ?>

