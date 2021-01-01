<?php

// echo '<pre>'; print_r($_POST); echo '</pre>'; exit();

require_once('../suppliers_dev/lib.php');


function image_padding($src, $dest, $pad_side) {

	$src = imagecreatefromjpeg($src);

	$src_wide = imagesx($src);
	$src_high = imagesy($src);

	if($pad_side == 'b') {
		$tb_pad = 200;
		$rl_pad = 200;
		$tb_pad2 = 100;
		$rl_pad2 = 100;

	}
	else if($pad_side == 'tb') {
		$tb_pad = 200;
		$rl_pad = 0;
		$tb_pad2 = 100;
		$rl_pad2 = 0;
	}
	if($pad_side == 'rl') {
		$tb_pad = 0;
		$rl_pad = 200;
		$tb_pad2 = 0;
		$rl_pad2 = 100;
	}

	$dst_wide = $src_wide + $rl_pad;
	$dst_high = $src_high + $tb_pad;
	$dst = imagecreatetruecolor($dst_wide, $dst_high);

	$white = imagecolorallocate($dst, 255, 255, 255);
	imagefill($dst, 0, 0, $white);

	imagecopymerge($dst, $src, $rl_pad2, $tb_pad2, 0, 0, $src_wide, $src_high, 100);
	imagejpeg($dst, $dest, 100);
	imagedestroy($src);
	imagedestroy($dst); 
}


$product_rnd = $_POST['product_code'] . '-' . rand(1000, 9999);
$product_img = str_replace('.', $product_rnd . '.', end(explode('/', $_POST['edit_image'])));

copy($_POST['edit_image'], '../../shop/image/original/' . $product_img);

// header('Content-Type: image/jpeg');

$product_id = $_POST['product_id'];
$filename 	= $_POST['edit_image'];
$mime 		= $_POST['edit_image_mime'];


$width 		= $_POST['orig_width'];
$height 	= $_POST['orig_height'];

$new_width 	= $_POST['width'];
$new_height = $_POST['height'];

$crop_x 	= $_POST['fcx'];
$crop_y		= $_POST['fcy'];
$crop_w 	= $_POST['fcw'];
$crop_h 	= $_POST['fch'];


// process
if($mime == 1) {
	$image = imagecreatefromgif($filename);
}
if($mime == 2) {
	$image = imagecreatefromjpeg($filename);
}
if($mime == 3) {
	$image = imagecreatefrompng($filename);
}

$image_res = imagecreatetruecolor($new_width, $new_height);
imagecopyresampled($image_res, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

// pad

(isset($_POST['pad_tb']) && $_POST['pad_tb'] != '') ? $pad_tb = $_POST['pad_tb'] : $pad_tb = '';
(isset($_POST['pad_rl']) && $_POST['pad_rl'] != '') ? $pad_rl = $_POST['pad_rl'] : $pad_rl = '';

$pad_side1 = '';

if($pad_tb == 'on' && $pad_rl == 'on') {
	$pad_side1 = 'b';
}
else if($pad_tb == 'on' && $pad_rl != 'on') {
	$pad_side1 = 'tb';
}
else if($pad_tb != 'on' && $pad_rl == 'on') {
	$pad_side1 = 'rl';
}
else if($pad_tb != 'on' && $pad_rl != 'on') {
	$pad_side1 = '';
}

// resize
if($crop_w == 0) {
	imagejpeg($image_res, $_POST['edit_image'], 100);

	if($pad_side1 != '') {
		image_padding($_POST['edit_image'], $_POST['edit_image'], $pad_side1);
	}
	//mysql_query("INSERT INTO z_product_image_backup (product_id, image, dt_stamp) VALUES ($product_id, 'original/$product_img', NOW())");
}

// crop
if($crop_w != 0) {
	$image_crop = imagecreatetruecolor($crop_w, $crop_h);
	imagecopyresampled($image_crop, $image_res, 0, 0, $crop_x, $crop_y, $crop_w, $crop_h, $crop_w, $crop_h);

	$product_path_img = $_POST['edit_image']; // '../../shop/image/products/' . $product_img;
	imagejpeg($image_crop, $product_path_img, 100);
	if($pad_side1 != '') {
		image_padding($product_path_img, $product_path_img, $pad_side1);
	}
	//mysql_query("INSERT INTO oc_product_image (product_id, image, sort_order) VALUES ($product_id, 'products/$product_img', 1000)");
}

?>

<script type="text/javascript">
	function goto_parent() {
		e = window;
		while (e.frameElement !== null) {e = e.parent;}
		e.parent.focus();
	}
</script>

<body onload="window.opener.location.reload(false); goto_parent(); window.close();"></body>
