<?php
	include 'common.php';

	//check we have username post var
	if(isset($_POST["usersend"]) && isset($_POST["useraccept"]) && isset($_POST["idproject"])) {

		$usersend  = $_POST['usersend'];
		$useraccept  = $_POST['useraccept'];
		$id = $_POST["idproject"];

		$query = "INSERT INTO projectusers (username, idproject, owner) VALUES ('{$usersend}', '{$id}', 'false')";
	    $results = pg_query($con, $query);

	    $query = "DELETE FROM notifications WHERE usersend = '{$usersend}' AND idproject = '{$id}' AND useraccept = '{$useraccept}'";
	    $results = pg_query($con, $query);
	}
?>