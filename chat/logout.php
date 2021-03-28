<?php
	// session_start();
	// session_destroy();
	require_once('config.php');
	$conn = mysqli_connect(mysqlServer, mysqlUser, mysqlPass, mysqlDB);
	mysqli_query($conn, 'DELETE FROM chat WHERE hash = "' . $_GET['hash'] . '"');
	header("Location: index.php");

?>