<?php
	include 'common.php';
	include 'libraries/passwordLib.php';

	if (loggedin()) {
		header("Location: private.php");
		exit();
	}

	$submitted_username = '';
	if (!empty($_POST)) {
		//set to 'on' if ticked and empty if not
		$rm = $_POST['rememberMe'];
		$un = $_POST['username'];
		$pw = $_POST['password'];

		$query = "SELECT * FROM users WHERE username =  '{$un}'";
		$results = pg_query($con, $query);

		$login_ok = FALSE;
		if (pg_num_rows($results) == 1) {
			$array = pg_fetch_array($results);
			if (password_verify($pw, $array['password'])) {
				$login_ok = TRUE;
			}
		}

		if ($login_ok) {
			if ($rm == "on") {
				setcookie("user", $un, $expire);
			} else if ($rm == "") {
				$_SESSION['user'] = $un;
			}
			header("Location: private.php");
			exit();
		} else {
			echo "Login failed!";
			$submitted_username = htmlentities($un, ENT_QUOTES, 'UTF-8');
		}
	}
?>

<html>
<body>

<h1>LOG IN</h1>

</br>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
Username: <input type="text" name="username" value="<?php echo $submitted_username; ?>">
</br>
Password: <input type="password" name="password">
</br>
Remember Me: <input type="checkbox" name="rememberMe">
</br>
<input type="submit">
</form>
<br>
<a href="index.php">Home</a>

</body>
</html>