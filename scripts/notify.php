<?php

include 'common.php';


$user  = $_POST['usersend'];

$query = "INSERT INTO notifications(usersend, useraccept, description) VALUES ('{$user}', 'cts12', 'I would like you to')";


$results = pg_query($con, $query);




?>



