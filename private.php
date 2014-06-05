<?php
	include 'common.php';

	$logged_in_user = "";

	//check if user is logged in or not
	if (!loggedin()) {
		header("Location: index.php");
		exit();
	} else {
		if (isset($_COOKIE["user"])) {
			$logged_in_user = $_COOKIE["user"];
		} else {
			$logged_in_user = $_SESSION["user"];
		}
	}
?>

<html>
<body>

Hello <?php echo htmlentities($logged_in_user, ENT_QUOTES, 'UTF-8'); ?>, secret content!<br />
<a href="memberlist.php">Memberlist</a><br />
<a href="edit_account.php">Edit Account</a><br />
<a href="create_project.php">Create Project</a><br />
<a href="logout.php">Logout</a>

</body>
</html>