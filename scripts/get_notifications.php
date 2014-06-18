<?php
	include 'common.php';

	//check we have username post var
	if(isset($_POST["name"])) {

	    //check if its an ajax request, exit if not
	    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
	        die();
	    }

	    $name = $_POST["name"];

	    $query = " SELECT * FROM notifications WHERE useraccept='{$name}'";
	    $results = pg_query($con, $query);

	    $ret = array();
	    while ($row = pg_fetch_assoc($results)) {
	    	unset($not);
	    	$not = array();
	    	$not['usersend'] = $row['usersend'];
	    	$not['useraccept'] = $row['useraccept'];
	    	$not['description'] = $row['description'];
	    	$not['idproject'] = $row['idproject'];
	    	array_push($ret, $not);
	    }
	    echo json_encode($ret);
	}
?>