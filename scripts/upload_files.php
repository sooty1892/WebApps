<?php
include 'common.php';

if (isset($_FILES["projectFiles"]) && isset($_POST["idproject"]) && isset($_POST["section"]) && isset($_POST["username"])) {
	$output_dir = '../uploads/project_songs/';

	$idproject = $_POST['idproject'];
	$section = $_POST['section'];
	$username = $_POST['username'];

	$results = array();

	foreach ($_FILES["projectFiles"]["error"] as $key => $error) {
        if ($error == UPLOAD_ERR_OK) {
        	unset($fi);
        	$fi = array();
            $name = $_FILES["projectFiles"]["name"][$key];
            $ext = substr($name, strrpos($name, '.'));
            $newName = rand(0, 9999999999) . $ext;
            $path = $output_dir . $newName;
            $tempPath = $_FILES["projectFiles"]["tmp_name"][$key];
            move_uploaded_file($tempPath, $path);

            $newPath = substr($path, 3);
           	$newNewPath = substr($newPath, 1);

            array_push($fi, $username);
            array_push($fi, $_FILES["projectFiles"]["name"][$key]);

            array_push($fi, $ext . ": " . $newNewPath);

            array_push($results, $fi);

            //$query = "INSERT INTO userimagefiles (username, path) VALUES ('$username', '$newPath')";
            //pg_query($con, $query);
        }
    }

    echo json_encode($results);

}
?>