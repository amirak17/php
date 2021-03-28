<?php
	session_start();
	require_once("config.php");
	require_once("inc/chatClass.php");
	$chattext = strip_tags( $_GET['chattext'] );
	chatClass::setChatLines($_SESSION['usrname'], $chattext, $_GET['hash']);
?>