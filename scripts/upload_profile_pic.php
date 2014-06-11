<?php
// include 'common.php';

// $output_dir = "../uploads/profile_pics/";

// if(isset($_FILES["myfile"]) && isset($_POST["username"])) {
// 	$ret = array();

// 	$error = $_FILES["myfile"]["error"];

// 	if(!is_array($_FILES["myfile"]["name"])) {
// 		//single file
//  	 	$fileName = $_FILES["myfile"]["name"];
//  		move_uploaded_file($_FILES["myfile"]["tmp_name"], $output_dir.$fileName);
//     	$ret[]= $fileName;

//     	$user = $_POST["username"];
//     	$path = $output_dir . $fileName;

//     	$query = "UPDATE users SET path = '{$path}' where username = '{$user}'";
//     	pg_query($con, $query);
// 	} else {
// 		//Multiple files, file[]
// 	 	$fileCount = count($_FILES["myfile"]["name"]);
// 	 	for($i = 0; $i < $fileCount; $i++) {
// 	  		$fileName = $_FILES["myfile"]["name"][$i];
// 			move_uploaded_file($_FILES["myfile"]["tmp_name"][$i], $output_dir.$fileName);
// 	  		$ret[]= $fileName;
// 	  	}
// 	}
// 	echo json_encode(substr($output_dir . $fileName, 3));
// }



include 'common.php';

error_reporting(E_ALL | E_STRICT);
require('UploadHandler.php');

$custom_dir = "../uploads/profile_pics/";

$options = array(
    'delete_type' => 'POST',
    'db_host' => 'localhost',
    'db_user' => 'ashleyhemingway',
    'db_pass' => '',
    'db_name' => 'ashleyhemingway',
    'db_table' => 'users',
    'upload_dir' => $custom_dir
);

class CustomUploadHandler extends UploadHandler {

    protected function initialize() {
    	$con = pg_connect("host=localhost port=5432 dbname=ashleyhemingway user=ashleyhemingway");
	    // Check connection
	    if (!$con) {
	        die("Error in connection: " . pg_last_error());
	    }
        $this->con = $con;
        parent::initialize();
    }

    protected function handle_form_data($file, $index) {
        $file->username = @$_REQUEST['username'];
    }

    protected function handle_file_upload($uploaded_file, $name, $size, $type, $error,
            $index = null, $content_range = null) {
        $file = parent::handle_file_upload(
            $uploaded_file, $name, $size, $type, $error, $index, $content_range
        );
        if (empty($file->error)) {
        	$path = "../uploads/profile_pics/" . $file->name;
        	$query = "UPDATE users SET path = '$path' where username = '$file->username'";
	    	pg_query($this->con, $query);

        }
        return $file;
    }

    // protected function set_additional_file_properties($file) {
    //     parent::set_additional_file_properties($file);
    //     if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    //         $sql = 'SELECT `id`, `type`, `title`, `description` FROM `'
    //             .$this->options['db_table'].'` WHERE `name`=?';
    //         $query = $this->db->prepare($sql);
    //         $query->bind_param('s', $file->name);
    //         $query->execute();
    //         $query->bind_result(
    //             $id,
    //             $type,
    //             $title,
    //             $description
    //         );
    //         while ($query->fetch()) {
    //             $file->id = $id;
    //             $file->type = $type;
    //             $file->title = $title;
    //             $file->description = $description;
    //         }
    //     }
    // }

    // public function delete($print_response = true) {
    //     $response = parent::delete(false);
    //     foreach ($response as $name => $deleted) {
    //         if ($deleted) {
    //             $sql = 'DELETE FROM `'
    //                 .$this->options['db_table'].'` WHERE `name`=?';
    //             $query = $this->db->prepare($sql);
    //             $query->bind_param('s', $name);
    //             $query->execute();
    //         }
    //     } 
    //     return $this->generate_response($response, $print_response);
    // }

}

$upload_handler = new CustomUploadHandler($options);