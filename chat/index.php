<html>
	<head>
		<title>Online Chat</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<link rel="stylesheet" href="css/main.css" />
		<script src="js/jquery.min.js"></script>
		<style type="text/css">
			input, textarea { margin-bottom: 12px; }
			form { padding-left: 10px; }
		</style>
	</head>
	<body style="background-color: #f7f7f7; ">
		<script type="text/javascript">
			function validate_form() {
				if(jQuery("#usrname").val() != '' && jQuery("#email").val() != '' && jQuery("#question").value != '') {
					jQuery('#form1').submit();
				}
				else {
					alert('Please check missing fields!');
					return false;
				}
			}
		</script>
		<h5 style="margin-top: 15px;">&nbsp;Online Chat</h5>
		<form name="form1" id="form1" action="login.php" method="post" onsubmit="return validate_form();">
			Name <br /><input type="text" name="usrname" id="usrname" maxlength="25" class="start-boxes" /><br />
			Email <br /><input type="text" name="email" id="email" maxlength="25" class="start-boxes" /><br />
			Phone (optional) <br /><input type="text" name="phone" id="phone" maxlength="25" class="start-boxes" /><br />
			Question <br /><textarea name="question" id="question" class="start-boxes" rows="3" /></textarea><br />
			<button class="btn btn-primary" type="submit"> Start Chat</button>
 			<input type="hidden" value="contact@luxehomeservices.ca" name="admin_email" />
			<input type="hidden" value="Agent" name="admin_name" />
			<!-- <input type="hidden" value="amir.aakhan@gmail.com" name="admin_email" /> -->
 		</form>			
	</body>
</html>
