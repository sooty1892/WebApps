<?php
	session_start();

	//destroy session
	session_destroy();

	//unset cookie
	setcookie("user", "", $expireNow);

	header("Location: log_in.php"); 
    exit();
?>