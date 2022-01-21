#!/usr/bin/php

<?php
// $filename = $argv[1];
$w = $argv[2];
$h = $argv[3];

//path for the image
$source_url = $argv[1];

//separate the file name and the extention
$source_url_parts = pathinfo($source_url);
$filename = $source_url_parts['filename'];
$extension = $source_url_parts['extension'];

// copy as favicon
exec('cp ' . $source_url . ' favicon.ico', $output, $retval);
if ($retval !== 0) {
  echo 'copy as favicon fail';
  exit;
}
exec('cp ' . $source_url . ' apple-touch-icon.png', $output, $retval);
// copy as png
if ($retval !== 0) {
  echo 'copy as png fail';
  exit;
}

function resizePng($im, $dst_width, $dst_height) {
  $width = imagesx($im);
  $height = imagesy($im);

  $newImg = imagecreatetruecolor($dst_width, $dst_height);

  imagealphablending($newImg, false);
  imagesavealpha($newImg, true);
  $transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127);
  imagefilledrectangle($newImg, 0, 0, $width, $height, $transparent);
  imagecopyresampled($newImg, $im, 0, 0, 0, 0, $dst_width, $dst_height, $width, $height);

  return $newImg;
}

imagepng(resizePng(imagecreatefrompng('apple-touch-icon.png'), 192, 192), 'apple-touch-icon' . '.'. $extension);

// refer - https://github.com/gayanSandamal/easy-php-image-resizer/blob/master/php-image-resizer.php
// refer - https://stackoverflow.com/questions/32243/can-png-image-transparency-be-preserved-when-using-phps-gdlib-imagecopyresample

// refer - https://stackoverflow.com/questions/279236/how-do-i-resize-pngs-with-transparency-in-php