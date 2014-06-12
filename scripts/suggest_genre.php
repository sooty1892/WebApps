<?php
	
include 'common.php';

// if the 'term' variable is not sent with the request, exit
if (!isset($_REQUEST['term'])) {
	exit("ERROR WITH SUGGEST GENRE");
}

$term = trim(strip_tags($_GET['term']));

$query = "SELECT * FROM genres WHERE genre LIKE '%$term%'";

$a_json = array();
$a_json_row = array();
if ($data = pg_query($con, $query)) {
	while ($row = pg_fetch_array($data)) {
		$genre = htmlentities(stripslashes($row['genre']));
		$a_json_row["value"] = $genre;
		$a_json_row["label"] = $genre;
		array_push($a_json, $a_json_row);
	}
}

echo json_encode($a_json);
flush();
?>