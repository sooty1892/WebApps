<?php
include 'common.php';

if (isset($_FILES["imageFiles"])) {
    $output_dir = '../uploads/profile_album_art/';

    $username = $_POST['username'];
    
    foreach ($_FILES["imageFiles"]["error"] as $key => $error) {
        if ($error == UPLOAD_ERR_OK) {
            $name = $_FILES["imageFiles"]["name"][$key];
            $ext = substr($name, strrpos($name, '.'));
            $newName = rand(0, 9999999999) . $ext;
            $path = $output_dir . $newName;
            $tempPath = $_FILES["imageFiles"]["tmp_name"][$key];
            move_uploaded_file($tempPath, $path);

            $newPath = substr($path, 3);

            $query = "INSERT INTO userimagefiles (username, path) VALUES ('$username', '$newPath')";
            pg_query($con, $query);
        }
    }
}

?>