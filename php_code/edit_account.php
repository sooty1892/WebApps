<?php
	include 'common.php';

	if(empty($_SESSION['user'])) {
		header("Location: log_in.php");
		exit();
	}

	echo "EDIT ACCOUNT HERE!";
?>