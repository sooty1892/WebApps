<?php
	include 'common.php';

	//check we have username post var
	if(isset($_GET['idproject'])) {

	    //check if its an ajax request, exit if not
	    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
	        die();
	    }

	    $idproject = $_GET["idproject"];

	    //get order correct from text field on project table

	    $a_json = array();
		$a_json_row = array();
		$a_json_row_more = array();
		$sections = array();

	    $query = "SELECT description, name, idsection FROM sections WHERE idproject = '$idproject'";
	    $results = pg_query($con, $query);
	    while ($row = pg_fetch_assoc($results)) {
	    	unset($a_json_row);
			unset($a_json_row_more);
			$a_json_row = array();
			$a_json_row_more = array();
	    	$a_json_row["description"] = $row['description'];
	    	$a_json_row["name"] = $row['name'];

	    	$newQuery = "SELECT path, name, extension, username FROM sectionmusic WHERE idsection = '{$row['idsection']}'";
	    	$newResults = pg_query($con, $newQuery);
	    	while ($newRow = pg_fetch_assoc($newResults)) {
	    		unset($sections);
	    		$sections = array();
	    		$sections["path"] = $newRow['path'];
	    		$sections["name"] = $newRow['name'];
	    		$sections["extension"] = $newRow['extension'];
	    		$sections["username"] = $newRow['username'];
	    		array_push($a_json_row_more, $sections);
	    	}
	    	array_push($a_json_row, $a_json_row_more);
	    	array_push($a_json, $a_json_row);
	    }

	    echo json_encode($a_json);
	    flush();
	} else {echo "ERRORERRORERROR";}
?>