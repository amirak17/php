<?php

mail('amir.aakhan@gmail.com', 'test 2', print_r($_GET, true));
echo '1';
	// $filename = $_GET['image'];
	// $mime 	  = $_GET['mime'];
	// $angle    = $_GET['angle'];

	// if($mime == 1) {
	// 	$image = imagecreatefromgif($filename);
	// }
	// if($mime == 2) {
	// 	$image = imagecreatefromjpeg($filename);
	// }
	// if($mime == 3) {
	// 	$image = imagecreatefrompng($filename);
	// }

	// $rotate = imagerotate($image, $angle, 0);

	// if($mime == 1) {
	// 	imagegif($rotate, $filename);
	// }
	// if($mime == 2) {
	// 	imagejpeg($rotate, $filename);
	// }
	// if($mime == 3) {
	// 	imagepng($rotate, $filename);
	// }

	// //file_put_contents($filename, $rotate);
	// imagedestroy($image);
	// imagedestroy($rotate);


?>