<title>Upload and Edit Images</title>
<h4>Upload and Edit Images</h4>

<?php 
if(isset($_POST['submit']) && $_POST['submit'] != '') {
	?><p>Click on the image(s) below to edit:</p><?php
	for($i = 0; $i < count($_FILES['upload']['name']); $i++) {
		if ($_FILES['upload']['tmp_name'][$i] != '') {
			$newFilePath = './uploads/' . $_FILES['upload']['name'][$i];
			if(move_uploaded_file($_FILES['upload']['tmp_name'][$i], $newFilePath)) {
				?><a href="editor2.php?file=<?php echo $newFilePath?>" target="_blank"><img src="<?php echo $newFilePath;?>" height="300" /></a>&nbsp;&nbsp;&nbsp;<?php
			}
		}
	}
}
?>

<br /><br />
<form id="form1" name="form1" enctype="multipart/form-data" method="post" action="">
	<input name="upload[]" type="file" multiple="multiple" />
    <br /><br />
    <input type="submit" value="Upload" name="submit" />
</form>
