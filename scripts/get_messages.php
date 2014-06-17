<?php
	include 'common.php';

	//check we have username post var
	if(isset($_GET["idproject"])) {

	    //check if its an ajax request, exit if not
	    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
	        die();
	    }

	    $idproject = $_GET["idproject"];
	    $last = $_GET["last"];

	    $query = "SELECT idmessage, message, username FROM chat WHERE idproject = '$idproject' AND idmessage > '$last' ORDER BY datesent ASC";
	    $results = pg_query($con, $query);

	    $messages = array();
	    while ($row = pg_fetch_assoc($results)) {
	    	$messages[] = $row;
	    }

	    echo json_encode($messages);
	}
?>