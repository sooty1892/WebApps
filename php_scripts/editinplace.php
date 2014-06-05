<?php
	include 'common.php';

	if(isset($_POST['value']) && isset($_POST['id']))
	{
		//check if its an ajax request, exit if not
	    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
	        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
	        die();
	    }
	}

	$desc = $_POST['value'];
	$id = $_POST['id'];

	 $query = "UPDATE projects SET description = '{$desc}' WHERE id = '{$id}'" ;

	 pg_query($con, $query);

	echo $desc;

?>