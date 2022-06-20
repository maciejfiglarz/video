<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require 'vendor/autoload.php';

header("Content-Type: application/json");
header("Acess-Control-Allow-Origin: *");
header("Acess-Control-Allow-Methods: POST");
header("Acess-Control-Allow-Headers: Acess-Control-Allow-Headers,Content-Type,Acess-Control-Allow-Methods, Authorization");

$ffmpeg = FFMpeg\FFMpeg::create();



$uploaddir = '/uploads/';
$uploadfile = __DIR__ . $uploaddir . basename($_FILES['video']['name']);

// var_dump($_FILES['video'],$_FILES['video']['name'],$_FILES['video']['tmp_name'],move_uploaded_file($_FILES['video']['tmp_name'], $uploadfile));


// if (move_uploaded_file($_FILES['video']['tmp_name'], $uploadfile)) {
//     echo "File is valid, and was successfully uploaded.\n";
// } else {
//     echo "Possible file upload attack1!\n";
// }

// 97mb - 02:09 min 

// vps-3563b155.vps.ovh.net


// echo $uploadfile;

if (move_uploaded_file($_FILES["video"]["tmp_name"], $uploadfile)) {

    echo "<b>The " .  $_FILES["video"]["name"] . " has been uploaded.</b>";
} else {
    echo "<b>Error : " . $_FILES["video"]["error"] .
        " Sorry, there was an error uploading your file.";
}


$ffmpeg = FFMpeg\FFMpeg::create();
$video = $ffmpeg->open($uploadfile);

$video
    ->filters()
    ->resize(new FFMpeg\Coordinate\Dimension(320, 240))
    ->synchronize();
$video
    ->frame(FFMpeg\Coordinate\TimeCode::fromSeconds(2))
    ->save('frame.jpg');

$video->save(new \FFMpeg\Format\Video\X264(), 'mobile.mp4');

// $ffmpeg = FFMpeg\FFMpeg::create();

// $video = $ffmpeg->open($uploadfile);

// $video
//     ->filters()
//     ->resize(new FFMpeg\Coordinate\Dimension(720, 550))
//     ->synchronize();

// $video->save(new \FFMpeg\Format\Video\X264(), 'desktop.mp4');

header('Content-type: application/json');
echo json_encode(['status' => "ok"]);



// echo php_ini_loaded_file();


// phpinfo();
