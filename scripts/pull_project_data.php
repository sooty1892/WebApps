<?php
	include 'common.php';

	//check we have username post var
	if(isset($_POST["idproject"])) {

	    //check if its an ajax request, exit if not
	    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
	        die();
	    }

	    $idproject = $_POST["idproject"];

	    //get order correct from text field on project table

	    $a_json = array();
		$a_json_row = array();
		$a_json_row_more = array();

	    $query = "SELECT description, name, idsection FROM sections WHERE idproject = '$idproject'";
	    $results = pg_query($con, $query);
	    while ($row = pg_fetch_assoc($results)) {
	    	unset($a_json_row);
			unset($a_json_row_more);
			$a_json_row = array();
			$a_json_row_more = array();
	    	$a_json_row["description"] = $row['description'];
	    	$a_json_row["name"] = $row['name'];
	    	$newQuery = "SELECT path, name, extension, description, username, rating FROM sectionmusic WHERE idsection = '{$row['idsection']}'";
	    	$newResults = pg_query($con, $newQuery);
	    	while ($newRow = pg_fetch_assoc($newResults)) {
	    		$a_json_row_more["path"] = $newRow['path'];
	    		$a_json_row_more["name"] = $newRow['name'];
	    		$a_json_row_more["extension"] = $newRow['extension'];
	    		$a_json_row_more["description"] = $newRow['description'];
	    		$a_json_row_more["username"] = $newRow['username'];
	    		$a_json_row_more["rating"] = $newRow['rating'];
	    		array_push($a_json_row, $a_json_row_more);
	    	}
	    	array_push($a_json, $a_json_row);
	    }

	    echo json_encode($a_json);
	}
?>