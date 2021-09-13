<?php 

    error_reporting(2);  

	$step = 1; include('config.php'); // step 1 - title, headings and main table - index.php & response.php

	if($_GET['action'] == 'table_data') {
		$sql = 'SELECT * FROM ' . $db_table;
		$res = mysqli_query($conn, $sql);
		$num_rows = mysqli_num_rows($res);
		$data = array();

		while($r = mysqli_fetch_assoc($res)) {
	        $id = $r['id'];
	        $row = array();

			$step = 2; include('config.php'); // step 2 - table rows - response.php

	        $data[] = $row;
		}
			
		$output = array(
				'draw' => 1, 
				'recordsTotal' => $num_rows, 
				'recordsFiltered' => $num_rows, 
				'data' => $data
		);
		echo json_encode($output);
	}

	if($_GET['action'] == 'form_data') {
	   $res = mysqli_query($conn, "SELECT * FROM ".$db_table." WHERE id='$_GET[id]'");
	   $data  = mysqli_fetch_assoc($res);	
	   echo json_encode($data);
	}

	if($_GET['action'] == 'insert') {
		$step = 5; include('config.php'); // step 5 - insert update columns string - response.php
		mysqli_query($conn, "INSERT INTO ".$db_table." SET ".$col_str);
	}

	if($_GET['action'] == 'update') {
		$step = 5; include('config.php'); // step 5 - insert update columns string - response.php
	 	mysqli_query($conn, "UPDATE ".$db_table." SET ".$col_str." WHERE id ='$_POST[id]'");
	}

	if($_GET['action'] == 'delete') {
	   mysqli_query($conn, "DELETE FROM ".$db_table." WHERE id = '$_GET[id]'");
	}

?>