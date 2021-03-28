<?php session_start();?>
<html>
	<head>
		<title>Online Chat</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link rel="stylesheet" href="css/main.css" />
		<script src="js/jquery.min.js"></script>
	</head>
	<body>
		<?php $_SESSION['usrname'] = strip_tags($_GET['admin_name']);	?>
		<audio id="alarm" src="ding.mp3" muted></audio>
		<script src="js/main.js"></script>
		<script type="text/javascript"> var hash = "<?php echo $_GET['hash'];?>"; </script>
		<a href="./logout.php?hash=<?php echo $_GET['hash'];?>" style="float: right; color: #333;">End Chat</a>
		<div id="view_ajax"></div>
		<textarea type="text" id="chatInput" /></textarea>
		<img src="send.png" id="btnSend" />
	</body>
</html>
