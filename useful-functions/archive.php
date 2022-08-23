<?php 
function zip($zip_file, $path_dir) {
	// https://www.geeksforgeeks.org/how-to-zip-a-directory-in-php/
	$zip = new ZipArchive;	   
	if($zip -> open($zip_file, ZipArchive::CREATE ) === TRUE) {
	    $dir = opendir($path_dir);
	    while($file = readdir($dir)) {
	        if(is_file($path_dir.$file)) {
	            $zip -> addFile($path_dir.$file, $file);
	        }
	    }
	    $zip ->close();
	}
}

function unzip($file, $dir) {
	// https://www.geeksforgeeks.org/how-to-zip-a-directory-in-php/
	$zip = new ZipArchive;
	$zip->open($file);
	$zip->extractTo($dir);
	$zip->close(); 	
}

?>