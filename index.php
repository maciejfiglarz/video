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
$uploadfile = $uploaddir . basename($_FILES['video']['name']);

// var_dump($_FILES['video'],$_FILES['video']['name'],$_FILES['video']['tmp_name'],move_uploaded_file($_FILES['video']['tmp_name'], $uploadfile));


// if (move_uploaded_file($_FILES['video']['tmp_name'], $uploadfile)) {
//     echo "File is valid, and was successfully uploaded.\n";
// } else {
//     echo "Possible file upload attack1!\n";
// }

// echo __DIR__;

if (move_uploaded_file($_FILES["video"]["tmp_name"], __DIR__ . "/uploads/" . $_FILES['video']['name'])) {

    echo "<b>The " .  $_FILES["video"]["name"] . " has been uploaded.</b>";
} else {
    echo "<b>Error : " . $_FILES["video"]["error"] .
        " Sorry, there was an error uploading your file.";
}


  $ffmpeg = FFMpeg::create();
        $video = $ffmpeg->open('upload/test.mp4');
        $video
            ->filters()
            ->resize(new Dimension(320, 240))
            ->synchronize();
        $video
            ->frame(TimeCode::fromSeconds(2))
            ->save('frame.jpg');

        $video->save(new \FFMpeg\Format\Video\X264(), 'export-x264.mp4');



echo php_ini_loaded_file();
