<?php
	include 'common.php';

	if(!loggedin()) {
		header("Location: log_in.php");
		exit();
	}

	$query = "SELECT * FROM users";
	$results = pg_query($con, $query);

	echo "<table border='1'>
	<tr>
	<th>Username</th>
	<th>Firstname</th>
	<th>Surname</th>
	<th>Email</th>
	<th>Password</th>
	</tr>";

	while ($array = pg_fetch_array($results)) {
		echo "<tr>";
		echo "<td>" . $array['username'] . "</td>";
		echo "<td>" . $array['firstname'] . "</td>";
		echo "<td>" . $array['surname'] . "</td>";
		echo "<td>" . $array['email'] . "</td>";
		echo "<td>" . $array['password'] . "</td>";
		echo "</tr>";
	}

	echo "</table>";
?>

<html>
<body>

<a href="private.php">Go Back</a><br />

</body>
</html>