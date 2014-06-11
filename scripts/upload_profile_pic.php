<?php

include 'common.php';
global $con;

error_reporting(E_ALL | E_STRICT);
require('UploadHandler.php');

$custom_dir = "../uploads/profile_pics/";

$options = array(
    'delete_type' => 'POST',
    'upload_dir' => $custom_dir
);

class CustomUploadHandler extends UploadHandler {

    protected function initialize() {
        global $con;
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

}

$upload_handler = new CustomUploadHandler($options);