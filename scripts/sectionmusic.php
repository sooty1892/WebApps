<?php
	
	if(isset($_POST["idproject"]) && isset($_POST["name"]))
	{
	    //check if its an ajax request, exit if not
	    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
	        die();
	    }

	$UploadDirectory	= '../sectionmusic/';

	$sectionname = $_POST['name'];
	$user = $_POST['username'];
	$File_Name = strtolower($_FILES['myfile']['name']);
	$File_Ext = substr($File_Name, strrpos($File_Name, '.'));
	$NewFileName = rand(0, 9999999999) . $File_Ext;
	$path = $UploadDirectory . $NewFileName;

	if(!move_uploaded_file($_FILES['myfile']['tmp_name'], $path)) {

		die('error uploading File!');
	} else {
		$newPath = substr($path,3);
		$query = "INSERT INTO sectionmusic (path, name, extension, description, username) VALUES ('$newPath',
										 '$sectionname','$File_Ext' ,'blahblah', '$user') ";
		pg_query($con, $query);
		echo json_encode(substr($path, 3));
	}


	}




?>