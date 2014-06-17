<?php
	include 'common.php';

	if (isset($_POST['name']) && isset($_POST['section']) && isset($_POST['idproject'])) {
		$name = $_POST['name'];
		$section = $_POST['section'];
		$idproject = $_POST['idproject'];

		$query = "SELECT idsection FROM sections WHERE idproject = '{$idproject}' AND name = '{$name}'";
		$res = pg_query($con, $query);
		$section_id;
		while ($row = pg_fetch_assoc($res)) {
        	$song_id = $row['idsection'];
        }

        $query = "DELETE FROM sectionmusic WHERE idsection = '{$section_id}' AND name = '{$name}'";
        pg_query($con, $query);

	}
?>