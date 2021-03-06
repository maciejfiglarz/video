<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require 'vendor/autoload.php';

header("Content-Type: application/json");
header("Acess-Control-Allow-Origin: *");
header("Acess-Control-Allow-Methods: POST");
header("Acess-Control-Allow-Headers: Acess-Control-Allow-Headers,Content-Type,Acess-Control-Allow-Methods, Authorization");





$uploaddir = '/uploads/';
$uploadfile = __DIR__ . $uploaddir . basename($_FILES['video']['name']);
$fileName = $_POST["fileName"];


$expire = strtotime('-1 DAYS');

$files = glob(__DIR__ ."/uploads" . '/*');

foreach ($files as $file) {

    // Skip anything that is not a file
    if (!is_file($file)) {
        continue;
    }

    // Skip any files that have not expired
    if (filemtime($file) > $expire) {
        continue;
    }

    unlink($file);
}


$expire = strtotime('-1 DAYS');

$files = glob(__DIR__ ."/files" . '/*');

foreach ($files as $file) {

    // Skip anything that is not a file
    if (!is_file($file)) {
        continue;
    }

    // Skip any files that have not expired
    if (filemtime($file) > $expire) {
        continue;
    }

    unlink($file);
}


// var_dump($_FILES['video'],$_FILES['video']['name'],$_FILES['video']['tmp_name'],move_uploaded_file($_FILES['video']['tmp_name'], $uploadfile));


// if (move_uploaded_file($_FILES['video']['tmp_name'], $uploadfile)) {
//     echo "File is valid, and was successfully uploaded.\n";
// } else {
//     echo "Possible file upload attack1!\n";
// }

// 97mb - 02:09 min 

// vps-3563b155.vps.ovh.net


// echo $uploadfile;
$isSuccess = "0";

if (move_uploaded_file($_FILES["video"]["tmp_name"], $uploadfile)) {
    $isSuccess  = "1";
    // echo "<b>The " .  $_FILES["video"]["name"] . " has been uploaded.</b>";
}
// else {
//     echo "<b>" .  $_FILES["video"]["name"] . " fail</b>";
// }

$ffmpeg = FFMpeg\FFMpeg::create();
$video = $ffmpeg->open($uploadfile);
$mode = FFMpeg\Filters\Video\ResizeFilter::RESIZEMODE_SCALE_WIDTH;
$video
    ->filters()
    ->resize(new FFMpeg\Coordinate\Dimension(320, 240), $mode)
    ->synchronize();

$format = new FFMpeg\Format\Video\X264();
$format->on('progress', function ($video, $format, $percentage) {
    echo "$percentage % transcoded";
});

$format
    ->setKiloBitrate(60);
// ->setAudioChannels(1)
// ->setAudioKiloBitrate(170);

$video->save($format, __DIR__ . "/files/" . $fileName . '_mobile.mp4');

$video
    ->frame(FFMpeg\Coordinate\TimeCode::fromSeconds(2))
    ->save(__DIR__ . "/files/" . $fileName . '_cover.jpg');

// $ffmpeg = FFMpeg\FFMpeg::create();

// $video = $ffmpeg->open($uploadfile);

// $video
//     ->filters()
//     ->resize(new FFMpeg\Coordinate\Dimension(720, 550))
//     ->synchronize();

// $video->save(new \FFMpeg\Format\Video\X264(), 'desktop.mp4');

header('Content-type: application/json');
echo json_encode(['isSuccess' => $isSuccess]);



// echo php_ini_loaded_file();


// phpinfo();
