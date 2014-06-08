<?php
	include 'common.php';

	//check we have username post var
	if(isset($_POST["username"]) && isset($_POST["about"]))
	{
	    //check if its an ajax request, exit if not
	    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
	        die();
	    }
	    
	    $user = $_POST['username'];
	    $about = $_POST['about'];

	    $query = "UPDATE users SET about = '{$about}' WHERE username = '{$user}'";
	    $results = pg_query($con, $query);
	}
?>