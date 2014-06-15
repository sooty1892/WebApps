<?php
include 'common.php';

function uploadFile($tempPath, $name) {
    $output_dir = '../uploads/profile_album_art/';
    $File_Ext = substr($name, strrpos($name, '.'));
    $NewFileName = rand(0, 9999999999) . $File_Ext;
    $path = $output_dir . $NewFileName;
    move_uploaded_file($tempPath, $path);
    return substr($path, 3);
}

if (isset($_FILES["myfile"]) && isset($_POST['username'])) {
    $username = $_POST['username'];
    
    if(!is_array($_FILES["myfile"]['name'])) {
        $File_Name = strtolower($_FILES['myfile']['name']);

        $newPath = uploadFile($_FILES["myfile"]["tmp_name"], $File_Name);

        $query = "INSERT INTO userimagefiles (username, path) VALUES ('$username', '$newPath')";
        pg_query($con, $query);

    } else {
        $fileCount = count($_FILES["myfile"]['name']);
    	for($i = 0; $i < $fileCount; $i++) {            
            $File_Name = strtolower($_FILES['myfile']['name'][$i]);

    		$newPath = uploadFile($_FILES["myfile"]["tmp_name"][$i], $File_Name);

            $query = "INSERT INTO userimagefiles (username, path) VALUES ('$username', '$newPath')";
            pg_query($con, $query);
    	}
    }
}

?>