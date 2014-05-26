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

		if (empty($_POST['username'])) {
			$unError = "Username is required";
		} else {
			$un = test_input($_POST["username"]);
			if (!preg_match("/^[a-zA-Z0-9 ]*$/", $un)) {
				$unError = "Only letters and numbers allowed";
			}
		}

		if (empty($_POST['firstname'])) {
			$fnError = "Firstname is required";
		} else {
			$fn = test_input($_POST["firstname"]);
			if (!preg_match("/^[a-zA-Z ]*$/", $fn)) {
				$fnError = "Only letters allowed";
			}
		}

		if (empty($_POST['surname'])) {
			$snError = "Surname is required";
		} else {
			$sn = test_input($_POST["surname"]);
			if (!preg_match("/^[a-zA-Z ]*$/", $sn)) {
				$snError = "Only letters allowed";
			}
		}

		if (empty($_POST['email'])) {
			$emailError = "Email is required";
		} else {
			$email = test_input($_POST["email"]);
			if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email)) {
	  			$emailErr = "Invalid email format"; 
			}
		}

		if (empty($_POST['password'])) {
			$pwError = "Password is required";
		} else {
			$pw = test_input($_POST["password"]);
			//validation test?
		}

		if (empty($_POST['passwordCheck'])) {
			$pwCheckError = "Password is required";
		} else {
			$pwCheck = test_input($_POST["passwordCheck"]);
			//validation test?
		}

		if (strcmp($pw, $pwCheck) != 0) {
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
			$un = pg_escape_string($_POST['username']);
			$fn = pg_escape_string($_POST['firstname']);
			$sn = pg_escape_string($_POST['surname']);
			$email = pg_escape_string($_POST['email']);
			$pw = pg_escape_string($_POST['password']);
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

	function test_input($data) {
		$date = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
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