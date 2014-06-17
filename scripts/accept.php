<?php
  $accept = $_POST['useraccept'];
  $project = $_POST['idproject'];
  $send = $_POST['usersend'];


  $query = "INSERT INTO notifications (useraccept, idproject, usersend, description) 
	    VALUES('{$accept}', '{$project}', '{$send}', 'Has Accepted your Project request')";


 $query2 = "INSERT INTO projectusers (iduser, idproject, owner) VALUES ('{$send}', '{$project}','f')";


  $query3 = "DELETE FROM notifications WHERE usersend='{$send}' AND idproject='{$project}'";

  $results = $pg_query($con, $query);

 $results = $pg_query($con, $query2);
 $results = $pg_query($con, $query3);






?>



