<?php
	include 'common.php';
	$log = 'log.txt';

	//check we have username post var
	if(isset($_POST["username"]) && isset($_POST["skills"]))
	{
	    //check if its an ajax request, exit if not
	    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
	        die();
	    }
	    
	    $user = $_POST['username'];

	 	$fp = fopen($log, 'w+');

	    //array of skills from form
	    $formSkills = explode(",", $_POST['skills']);
	    foreach (array_keys($formSkills, '') as $key) {
	    	unset($formSkills[$key]);
	    }
	    foreach (array_keys($formSkills, ',') as $key) {
	    	unset($formSkills[$key]);
	    }

	    fwrite($fp, $_POST['skills']);

	   	//array of skills from database
	    $dbSkills = array();
	    $query = "SELECT idskill FROM userskills WHERE username = '$user'";
	    while ($row = pg_fetch_array(pg_query($con, $query))) {
	    	array_push($dbSkills, $row['idskill']);
	    }

	    $inDbNotInForm = array_diff($dbSkills, $formSkills);
	    $inFormNotInDb = array_diff($formSkills, $dbSkills);

	    foreach($inDbNotInForm as $skill) {
	    	$query = "SELECT idskill FROM skills WHERE skill = '$skill'";
	    	$idskill = pg_fetch_row(pg_query($con, $query))['0'];
	    	$query = "DELETE FROM userskills WHERE idskill = '$idskill' AND username = '$user'";
	    	pg_query($con, $query);
	    }

	    foreach($inFormNotInDb as $skill) {
	    	$query = "SELECT idskill FROM skills WHERE skill = '$skill'";
            $re = pg_query($con, $query);
            $row = pg_fetch_row($re);
            $idskill = $row['0'];
            $query = "INSERT INTO userskills (username, idskill)
                      VALUES ('$user', '$idskill')";
            pg_query($con, $query);
	    }

	    fclose($fp);
	}
?>