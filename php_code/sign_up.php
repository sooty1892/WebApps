<?php
	//law required, will you accept cookies?
	//validation email

	include 'common.php';
	include 'libraries/passwordLib.php';

	if (loggedin()) {
		header("Location: private.php");
		exit();
	}

	$un = $fn = $sn = $email = $pw = $pwCheck = $rm = "";
	$unError = $fnError = $snError = $emailError = $pwError = $pwCheckError = "";

	if (!empty($_POST) && $_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST["rememberMe"])) {
			$rm = $_POST["rememberMe"];
		}

		$unError = valUsername($_POST["username"]);
		$fnError = valName($_POST["firstname"]);
		$snError = valName($_POST["surname"]);
		$emailError = valEmail($_POST["email"]);
		$pwError = valPassword($_POST["password"]);
		$pwCheckError = valPassword($_POST["passwordCheck"]);

		if (empty($pwError) && empty($pwCheckError) && strcmp($pw, $pwCheck) != 0) {
			$pwCheck = "Passwords don't match!";
			$pwCheckError = "Passwords don't match!";
		}

		if (empty($unError)) {
			$sql = " SELECT * FROM users WHERE username = '{$_POST['username']}'";
			$result = pg_query($con, $sql);
			if (pg_num_rows($result) > 0) {
				$unError = "Username is already in use";
			}
		}

		if (empty($emailError)) {
			$sql = " SELECT * FROM users WHERE email = '{$_POST['email']}'";
			$result = pg_query($con, $sql);
			if (pg_num_rows($result) > 0) {
				$emailError = "Email is already in use";
			}
		}

		if (empty($unError) && empty($fnError) && empty($snError) && empty($emailError) && empty($pwError) && empty($pwCheckError)) {

			// escape variables for security
			$un = pg_escape_string(valInput($_POST['username']));
			$fn = pg_escape_string(valInput($_POST['firstname']));
			$sn = pg_escape_string(valInput($_POST['surname']));
			$email = pg_escape_string(valInput($_POST['email']));
			$pw = pg_escape_string(valInput($_POST['password']));
			$hashpw = password_hash($pw, PASSWORD_DEFAULT);

			if ($hashpw == false) {
				echo "PASSWORD HASHING ERROR";
			} else {
				$sql = "INSERT INTO users (username, firstname, surname, email, password, created)
						VALUES ('$un', '$fn', '$sn', '$email', '$hashpw', NOW())";
				$result = pg_query($con, $sql);
				if (!$result) {
					die("Error in SQL query: " . pg_last_error());
				}
			}

			if ($rm == "on") {
				setcookie("user", $un, $expire);
			} else if ($rm == "") {
				$_SESSION['user'] = $un;
			}
			header("Location: private.php");
			exit();
		}
	}
?>

<html>
<body>

<h1>SIGN UP</h1>

</br>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
Username: <input type="text" name="username" value="<?php echo $un;?>">
<span class="error">* <?php echo $unError;?></span>
<br><br>
Firstname: <input type="text" name="firstname" value="<?php echo $fn;?>">
<span class="error">* <?php echo $fnError;?></span>
<br><br>
Surname: <input type="text" name="surname" value="<?php echo $sn;?>">
<span class="error">* <?php echo $snError;?></span>
<br><br>
Email: <input type="text" name="email" value="<?php echo $email;?>">
<span class="error">* <?php echo $emailError;?></span>
<br><br>
Password: <input type="password" name="password" value="<?php echo $pw;?>">
<span class="error">* <?php echo $pwError;?></span>
<br><br>
Re-Enter Password: <input type="password" name="passwordCheck" value="<?php echo $pwCheck;?>">
<span class="error">* <?php echo $pwCheckError;?></span>
<br><br>
Remember Me: <input type="checkbox" name="rememberMe" value="<?php echo $rm;?>">
<br>
<br>
<input type="submit">
</form>

<br>
<a href="index.php">Home</a>

</body>
</html>