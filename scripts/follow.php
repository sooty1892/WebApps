<?php
include 'common.php';

if(isset($_POST["what"]) && $_POST["from"] && isset($_POST['to']))
{
	$what = $_POST["what"];
	$to = $_POST["to"];
	$from = $_POST["from"];

	if ($what == 'follow') {
		$query = "INSERT INTO following (follower, followee) VALUES ('$from', '$to')";
		pg_query($con, $query);
	} else {
		$query = "DELETE FROM following WHERE follower = '$from' AND followee = '$to'";
		pg_query($con, $query);
	}
}

?>