<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require 'vendor/autoload.php';

header("Content-Type: application/json");
header("Acess-Control-Allow-Origin: *");
header("Acess-Control-Allow-Methods: POST");
header("Acess-Control-Allow-Headers: Acess-Control-Allow-Headers,Content-Type,Acess-Control-Allow-Methods, Authorization");

$video = $_FILES["video"]["tmp_name"];
$bitrate = $_POST["bitrate"];
 
$command = "/usr/local/bin/ffmpeg -i $video -b:v $bitrate -bufsize $bitrate output.mp4";
system($command);
 
echo "File has been converted";