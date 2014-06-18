<?php
	include 'common.php';

	//check we have username post var
	if(isset($_POST["usersend"]) && isset($_POST["useraccept"]) && isset($_POST["idproject"])) {

	    //check if its an ajax request, exit if not
	    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
	        die();
	    }

		$usersend  = $_POST['usersend'];
		$useraccept  = $_POST['useraccept'];
		$id = $_POST["idproject"];
		$desc = $usersend . " invites you to join project: ";
		$query = "INSERT INTO notifications (usersend, useraccept, idproject, description) VALUES ('{$usersend}', '{$useraccept}', '{$id}', '{$desc}')";
		pg_query($con, $query);	
	}

?>



