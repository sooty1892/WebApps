<?php
	include 'common.php';

	//check we have username post var
	if(isset($_POST['username']))
	{
	    //check if its an ajax request, exit if not
	    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
	        die();
	    }

	    $un = $_POST['username'];
	    
	    $query = "SELECT * FROM users WHERE username = '{$un}'"
	    $results = pg_query($con, $query);
	    
	    if (pg_num_rows($results) == 1) {
	    	echo true;
	    } else {
	        echo false;
	    }
	}
?>