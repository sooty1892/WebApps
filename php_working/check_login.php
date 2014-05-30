<?php
	include 'common.php';

	//check we have username post var
	if(isset($_POST["username"]) && isset($_POST["password"]))
	{
	    //check if its an ajax request, exit if not
	    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
	        die();
	    }

	    $un = $_POST['username'];
	    $pw = $_POST['password'];
	    
	    $query = "SELECT * FROM users WHERE username = '{$un}'";
	    $results = pg_query($con, $query);
	    
	    if (pg_num_rows($results) == 1) {
	    	$array = pg_fetch_array($results);
	    	if (password_verify($pw, $array['password'])) {
	    		echo true;
	    		exit();
	    	}
	    }
	    echo false;
	}
?>