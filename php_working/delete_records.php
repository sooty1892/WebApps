<?php
	$con = pg_connect("host=localhost port=5432 dbname=test user=ashleyhemingway");
	// Check connection
	if (!$con) {
	  die("Error in connection: " . pg_last_error());
	}

	$query = "DELETE FROM users"; 

	pg_query($query);

	pg_close($con);
?>
