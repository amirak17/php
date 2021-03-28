<!DOCTYPE html>
<html lang="en-US">
<head>
<title>Google Fonts</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<?php 
error_reporting(2);
$font_arr = array('Lato', 'Open Sans', 'Titillium Web', 'Roboto', 'Oxygen', 'Poppins', 'Montserrat', 'Exo 2');
isset($_POST['google_font']) && $_POST['google_font'] != '' ?  array_unshift($font_arr, $_POST['google_font']) : '';

for($i = 0; $i < count($font_arr); $i++) { ?>
	<link href="https://fonts.googleapis.com/css?family=<?php echo str_replace(' ', '+', $font_arr[$i]);?>:400,400,500,600,700,800,300italic,400italic,500italic,600italic,700italic,800italic" rel="stylesheet">
<?php } ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<style type="text/css">
	.the-font { font-size: 22px; font-weight: 400; }
</style>
<script type="text/javascript">
	var theFontSize = 22;
</script>

</head>

<body>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div style="position: fixed; background-color: #fff; width: auto;">
				<br /><a href="./" style="text-decoration: none;"><h1>Google Fonts</h1></a>
					<form name="form1" id="form1" method="post" action="" style="display: inline;">
						<input name="google_font" value="<?php echo $_POST['google_font'];?>" style="font-size: 14px; margin: 2px 20px 0px 0px;" maxlength="100" size="22" placeholder="Enter Google Font Name" /> &nbsp;&nbsp;&nbsp;&nbsp;
					</form>
					<span style="font-size: 22px; cursor: pointer;" onclick="theFontSize = theFontSize + 1; jQuery('.the-font').css('font-size', theFontSize+'px')">A+&nbsp;&nbsp;&nbsp;&nbsp;</span>
					<span style="font-size: 18px; cursor: pointer; margin-top: 3px;" onclick="theFontSize = theFontSize - 1; jQuery('.the-font').css('font-size', theFontSize+'px')">A-&nbsp;&nbsp;&nbsp;&nbsp;</span>
				<hr /><br />
			</div>
		</div>
	</div>
	<br /><br /><br /><br /><br /><br /><br />

	<?php for($i = 0; $i < count($font_arr); $i++) { ?>
		<h3 style="font-family: '<?php echo $font_arr[$i]?>'" ><?php echo $font_arr[$i]?></h3>
		<p style="font-family: '<?php echo $font_arr[$i]?>'" class="the-font">Lorem ipsum dolor sit amet, 1234567890 consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
		<br /><hr /><br />
	<?php } ?>
</div>

</body>
</html>
