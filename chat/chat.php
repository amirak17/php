<?php session_start();?>
<html>
	<head>
		<title>Chat</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link rel="stylesheet" href="css/main.css" />
		<script src="js/jquery.min.js"></script>
		<style type="text/css"></style>
	</head>
	<body>
		<?php if(isset($_SESSION['usrname']) && $_SESSION['usrname'] != '') { ?>
			<audio id="alarm" src="ding.mp3" muted></audio>
			<script src="js/main.js"></script>
			<script type="text/javascript"> var hash = "<?php echo $_GET['hash'];?>"; </script>
			<a href="./logout.php?hash=<?php echo $_GET['hash'];?>" style="float: right; color: #333; text-decoration: none;">End Chat</a>
			<div id="view_ajax"></div>
			<textarea type="text" id="chatInput" /></textarea>
			<img src="send.png" id="btnSend" />
		<?php } ?>
	</body>
</html>
