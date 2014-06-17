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
        	$section_id = $row['idsection'];
        }

        $query = "SELECT idmusic FROM sectionmusic WHERE idsection = '{$section_id}' AND name = '{$name}'";
        $res = pg_query($con, $query);
		$song_id;
		while ($row = pg_fetch_assoc($res)) {
        	$song_id = $row['idmusic'];
        }

        $query = "SELECT COUNT(rated) FROM raters WHERE idmusic = '{$song_id}' AND raters = 't'";
        $res = pg_query($con, $query);
        $num;
		while ($row = pg_fetch_assoc($res)) {
        	$num = $row['rated'];
        }

        echo $num;
	}
?>