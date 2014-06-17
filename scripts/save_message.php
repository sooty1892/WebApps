<?php
	include 'common.php';

	//check we have username post var
	if(isset($_POST["message"]) && isset($_POST["username"]) && isset($_POST["idproject"])) {

	    //check if its an ajax request, exit if not
	    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
	        die();
	    }
	    
	    $message = $_POST["message"];
	    $username = $_POST["username"];
	    $idproject = $_POST["idproject"];

	    $query = "INSERT INTO chat (idproject, datesent, username, message) VALUES ('$idproject', 'NOW()', '$username', '$message')";
	    pg_query($con, $query);
	}
?>