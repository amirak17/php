<?php

// mail('amir.aakhan@gmail.com', 'test 2', print_r($_GET, true));
// echo '1';
	$filename = $_GET['image'];
	$mime 	  = $_GET['mime'];
	$param    = $_GET['param'];
	$action   = $_GET['action'];

	if($mime == 1) {
		$image = imagecreatefromgif($filename);
	}
	if($mime == 2) {
		$image = imagecreatefromjpeg($filename);
	}
	if($mime == 3) {
		$image = imagecreatefrompng($filename);
	}

	if($action == 'rotate') {
		$apply = imagerotate($image, $param, 0);
	}
	if($action == 'brightness') {
		$apply = imagefilter($image, IMG_FILTER_BRIGHTNESS, $param);

	}
	if($action == 'contrast') {
		$apply = imagefilter($image, IMG_FILTER_CONTRAST, $param);

	}

	if($mime == 1) {
		imagegif($apply, $filename);
	}
	if($mime == 2) {
		imagejpeg($image, $filename);
	}
	if($mime == 3) {
		imagepng($image, $filename);
	}

	imagedestroy($image);
	imagedestroy($apply);


?>