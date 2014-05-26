<?php
	include 'common.php';

	if (loggedin()) {
		header("Location: private.php"); 
		exit();
	}
?>

<html>
<body>

<h1>MUSIC COLLABORATION</h1>

<a href="sign_up.php">SIGN UP</a>
</br>
</br>
<a href="log_in.php">LOG IN</a>

</body>
</html>