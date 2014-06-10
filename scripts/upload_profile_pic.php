<?php
include 'common.php';

$output_dir = "../uploads/profile_pics/";
if(isset($_FILES["myfile"]) && isset($_POST["username"])) {
	$ret = array();

	$error = $_FILES["myfile"]["error"];

	if(!is_array($_FILES["myfile"]["name"])) {
		//single file
 	 	$fileName = $_FILES["myfile"]["name"];
 		move_uploaded_file($_FILES["myfile"]["tmp_name"], $output_dir.$fileName);
    	$ret[]= $fileName;

    	$user = $_POST["username"];
    	$path = $output_dir . $fileName;

    	$query = "UPDATE users SET path = '{$path}' where username = '{$user}'";
    	pg_query($con, $query);
	} else {
		//Multiple files, file[]
	 	$fileCount = count($_FILES["myfile"]["name"]);
	 	for($i = 0; $i < $fileCount; $i++) {
	  		$fileName = $_FILES["myfile"]["name"][$i];
			move_uploaded_file($_FILES["myfile"]["tmp_name"][$i], $output_dir.$fileName);
	  		$ret[]= $fileName;
	  	}
	}
	echo json_encode(substr($output_dir . $fileName, 3));
}

?>