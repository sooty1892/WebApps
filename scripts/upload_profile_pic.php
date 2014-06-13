<?php

include 'common.php';

if(isset($_FILES["FileInput"]) && $_FILES["FileInput"]["error"]== UPLOAD_ERR_OK) {

	$UploadDirectory	= '../uploads/profile_pics/';
	
	//check php.ini for max file sizez
	//check if this is an ajax request
	if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
		die("AJAX Problem");
	}
	
	switch(strtolower($_FILES['FileInput']['type'])) {
		//allowed file types
        case 'image/png': 
		case 'image/gif': 
		case 'image/jpeg': 
		case 'image/pjpeg':
			break;
		default:
			die('Unsupported File!');
	}
	
	$File_Name = strtolower($_FILES['FileInput']['name']);
	$File_Ext = substr($File_Name, strrpos($File_Name, '.'));
	$NewFileName = rand(0, 9999999999) . $File_Ext;
	$path = $UploadDirectory . $NewFileName;
	$username = $_POST['username'];
	
	if(!move_uploaded_file($_FILES['FileInput']['tmp_name'], $path)) {
		die('error uploading File!');
	} else {
		$newPath = substr($path,3);
		$query = "UPDATE users SET path = '$newPath' where username = '$username'";
		pg_query($con, $query);
		echo json_encode(substr($path, 3));
	}
	
} else {
	die('Something wrong with profile pic upload!');
}
?>