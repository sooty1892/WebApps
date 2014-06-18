<?php
include 'common.php';

if (isset($_FILES["songFiles"])) {
    $output_dir = '../uploads/profile_songs/';

    $username = $_POST['username'];

    $results = array();
    
    foreach ($_FILES["songFiles"]["error"] as $key => $error) {
        if ($error == UPLOAD_ERR_OK) {
            $name = $_FILES["songFiles"]["name"][$key];
            $ext = substr($name, strrpos($name, '.'));
            $newName = rand(0, 9999999999) . $ext;
            $path = $output_dir . $newName;
            $tempPath = $_FILES["songFiles"]["tmp_name"][$key];
            move_uploaded_file($tempPath, $path);

            $newPath = substr($path, 3);

            array_push($results, $newPath);

            $query = "INSERT INTO usermusicfiles (username, path, name) VALUES ('$username', '$newPath', '$name')";
            pg_query($con, $query);
        }
    }

   echo json_encode($results);
}

?>