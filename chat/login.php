<?php
	require_once("config.php");
	session_start();
	$_SESSION['usrname'] = strip_tags($_POST['usrname']);
	$r = md5(rand(100,999));

	require_once("inc/chatClass.php");
	chatClass::setChatLines($_POST['usrname'], $_POST['question'], $r);

	$headers = 	'X-Mailer: PHP/' . phpversion();
	$chat_admin  = str_replace('login.php', '', get_url()) . 'chat_admin.php?';
	$chat_admin .= 'admin_name='.$_POST['admin_name'].'&hash='.$r;
	$msg  = 'Please click on the link below to join chat:' . "\r\n\r\n";
	$msg .= $chat_admin  . "\r\n\r\n";
	$msg .= 'Name: ' . $_POST['usrname'] . "\r\n";
	$msg .= 'Email: ' . $_POST['email'] . "\r\n";
	$msg .= 'Phone: ' . $_POST['phone'] . "\r\n";
	$msg .= 'Question: ' . $_POST['question'] . "\r\n";
	mail($_POST['admin_email'], 'Website New chat request', $msg, $headers);

	header("Location: chat.php?hash=".$r);
	die();

	function get_url() {
		$base_url = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 'https' : 'http' ) . '://' .  $_SERVER['HTTP_HOST'];
		$url = $base_url . $_SERVER["REQUEST_URI"];
		return $url;
	}	
?>
