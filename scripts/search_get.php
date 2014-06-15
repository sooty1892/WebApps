<?php
	
include 'common.php';

// if the 'term' variable is not sent with the request, exit
if (isset($_POST)) {
	$type = $_POST['type'];
	$search = strtolower($_POST['search']);
	$filter = explode(",", $_POST['filter']);

	$a_json = array();
	$a_json_row = array();
	$a_json_row_more = array();

	switch($type) {
		case "project":
			$query = "SELECT * FROM projects WHERE LOWER(name) LIKE '%{$search}%'";
			if ($data = pg_query($con, $query)) {
				while ($row = pg_fetch_array($data)) {
					$a_json_row["name"] = $row['name'];
					$a_json_row["description"] = $row['description'];
					array_push($a_json, $a_json_row);
				}
			}
			break;
		case "user":
			$query = "SELECT * FROM users WHERE LOWER(username) LIKE '%{$search}%' OR LOWER(name) LIKE '%{$search}%'";
			if ($data = pg_query($con, $query)) {
				while ($row = pg_fetch_array($data)) {
					$a_json_row["path"] = $row['path'];
					$a_json_row["username"] = $row['username'];
					$a_json_row["about"] = $row['about'];
					array_push($a_json, $a_json_row);
				}
			}
			break;
		case "all":
			$query = "SELECT * FROM projects WHERE LOWER(name) LIKE '%{$search}%'";
			if ($data = pg_query($con, $query)) {
				while ($row = pg_fetch_array($data)) {
					$a_json_row_more["name"] = $row['name'];
					$a_json_row_more["description"] = $row['description'];
					array_push($a_json_row, $a_json_row_more);
				}
			}
			array_push($a_json, $a_json_row);
			unset($a_json_row);
			unset($a_json_row_more);
			$a_json_row = array();
			$a_json_row_more = array();
			$query = "SELECT * FROM users WHERE LOWER(username) LIKE '%{$search}%' OR LOWER(name) LIKE '%{$search}%'";
			if ($data = pg_query($con, $query)) {
				while ($row = pg_fetch_array($data)) {
					$a_json_row_more["path"] = $row['path'];
					$a_json_row_more["username"] = $row['username'];
					$a_json_row_more["about"] = $row['about'];
					array_push($a_json_row, $a_json_row_more);
				}
			}
			array_push($a_json, $a_json_row);
			break;
	}

	echo json_encode($a_json);
	flush();
}
?>