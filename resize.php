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

// //define the quality from 1 to 100
// $quality = 10;

// //detect the width and the height of original image
// list($width, $height) = getimagesize($source_url);
// $width;
// $height;

// //define any width that you want as the output. mine is 200px.
// $after_width = $w;

// //resize only when the original image is larger than expected with.
// //this helps you to avoid from unwanted resizing.
// if ($width > $after_width) {
    
//     //get the reduced width
//     $reduced_width = ($width - $after_width);
//     //now convert the reduced width to a percentage and round it to 2 decimal places
//     $reduced_radio = round(($reduced_width / $width) * 100, 2);
    
//     //ALL GOOD! let's reduce the same percentage from the height and round it to 2 decimal places
//     $reduced_height = round(($height / 100) * $reduced_radio, 2);
//     //reduce the calculated height from the original height
//     $after_height = $height - $reduced_height;
    
//     //Now detect the file extension
//     //if the file extension is 'jpg', 'jpeg', 'JPG' or 'JPEG'
//     echo "resize " . $extension . "\n";
//     if ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'JPG' || $extension == 'JPEG') {
//         //then return the image as a jpeg image for the next step
//         $img = imagecreatefromjpeg($source_url);
//     } elseif ($extension == 'png' || $extension == 'PNG') {
//         //then return the image as a png image for the next step
//         $img = imagecreatefrompng($source_url);
//       } else {
//         //show an error message if the file extension is not available
//         echo 'image extension is not supporting';
//       }
      
//       //HERE YOU GO :)
//       //Let's do the resize thing
//       //imagescale([returned image], [width of the resized image], [height of the resized image], [quality of the resized image]);
//       $imgResized = imagescale($img, $after_width, $after_height, $quality);
//       imagealphablending($imgResized, false);
//       imagesavealpha($imgResized, true);
//       $black = imagecolorallocate($imgResized, 0, 0, 0);
//       imagecolortransparent($imgResized, $black);
    
//     //now save the resized image with a suffix called "-resized" and with its extension. 
//     if ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'JPG' || $extension == 'JPEG') {
//       imagejpeg($imgResized, $filename . '.'.$extension);
//     } elseif ($extension == 'png' || $extension == 'PNG') {
//       imagepng($imgResized, $filename . '.'.$extension);
//     }
    
//     //Finally frees any memory associated with image
//     //**NOTE THAT THIS WONT DELETE THE IMAGE
//     imagedestroy($img);
//     imagedestroy($imgResized);
//     echo 'successfully resized'. "\n";
// }

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

imagepng(resizePng(imagecreatefrompng($source_url), $w, $h), $filename . '.'.$extension);

// refer - https://github.com/gayanSandamal/easy-php-image-resizer/blob/master/php-image-resizer.php
// refer - https://stackoverflow.com/questions/32243/can-png-image-transparency-be-preserved-when-using-phps-gdlib-imagecopyresample

// refer - https://stackoverflow.com/questions/279236/how-do-i-resize-pngs-with-transparency-in-php