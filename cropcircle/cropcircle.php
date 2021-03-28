<?php

// STEP 1: Crop inner square
$dst_x = 0;   
$dst_y = 0;   
$src_x = $_REQUEST['x1']; 
$src_y = $_REQUEST['y1']; 
$dst_w = $_REQUEST['w']; 
$dst_h = $_REQUEST['h']; 
$src_w = $_REQUEST['w']; 
$src_h = $_REQUEST['h']; 

$src_image = imagecreatefromjpeg($_REQUEST['file']);
$dst_image = imagecreatetruecolor($dst_w, $dst_h);
imagecopyresampled($dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
$temp_file = 'temp' . $n = rand(0,100000) . '.jpg';
imagejpeg($dst_image, $temp_file, 100);

imagedestroy($src_image);
imagedestroy($dst_image);


// STEP 2: Crop transparent circle
$img1 = imagecreateFromjpeg($temp_file);
$x=imagesx($img1)-$width ;
$y=imagesy($img1)-$height;

$img2 = imagecreatetruecolor($x, $y);
$bg = imagecolorallocate($img2, 255, 255, 255);
imagefill($img2, 0, 0, $bg);
$e = imagecolorallocate($img2, 0, 0, 0);

$r = $x <= $y ? $x : $y;
imagefilledellipse($img2, ($x/2), ($y/2), $r, $r, $e); 
imagecolortransparent($img2, $e);
imagecopymerge($img1, $img2, 0, 0, 0, 0, $x, $y, 100);
imagecolortransparent($img1, $bg);

header("Content-type: image/png");
imagepng($img1);

unlink($temp_file);
imagedestroy($img2);
imagedestroy($img1);

?>