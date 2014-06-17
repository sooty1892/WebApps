<?php
	include 'common.php';

	//check we have username post var
	if(isset($_POST["username"]) && isset($_POST["name"]))
	{
	    //check if its an ajax request, exit if not
	    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
	        die();
	    }
	    
	    $user = $_POST['username'];
	    $name = $_POST['name'];

	    $query = "UPDATE users SET name = '{$name}' WHERE username = '{$user}'";
	    $results = pg_query($con, $query);
	}
?>