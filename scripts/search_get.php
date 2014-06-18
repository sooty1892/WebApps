<?php
	
include 'common.php';
global $con;

//$fp = fopen("log.txt", 'w');
//global $fp;

function parse_sql_timestamp($timestamp, $format = 'd-m-Y')
{
    $date = new DateTime($timestamp);
    return $date->format($format);
}

function getFilterArray($str) {
	$filter = explode(",", $str);
	foreach (array_keys($filter, ',') as $key) {
	    unset($filter[$key]);
	}
	return $filter;
}

function getSkills() {
	global $con;

	$skillList = array();
	//array of skills from database
	$query = "SELECT skill FROM skills";
	$res = pg_query($con, $query);
	while ($row = pg_fetch_assoc($res)) {
	    array_push($skillList, $row['skill']);
	}
	return $skillList;
}

function getGenres() {
	global $con;

	$genreList = array();
	//array of genres from database
	$query = "SELECT genre FROM genres";
	$res = pg_query($con, $query);
	while ($row = pg_fetch_assoc($res)) {
	   	array_push($genreList, $row['genre']);
	}
	return $genreList;
}

function getProjectSkills($idproject) {
	global $con;

	$results = array();
	$query = "SELECT skills.skill FROM projectskills
			  INNER JOIN skills ON projectskills.idproject = '$idproject' AND skills.idskill = projectskills.idskill";
	if ($data = pg_query($con, $query)) {
		while ($row = pg_fetch_assoc($data)) {
			array_push($results, $row['skill']);
		}
	}
	return $results;
}

function getProjectGenres($idproject) {
	global $con;

	$results = array();
	$query = "SELECT genres.genre FROM projectgenres
			  INNER JOIN genres ON projectgenres.idproject = '$idproject' AND genres.idgenre = projectgenres.idgenre";
	if ($data = pg_query($con, $query)) {
		while ($row = pg_fetch_assoc($data)) {
			array_push($results, $row['genre']);
		}
	}
	return $results;
}

function getUserSkills($username) {
	global $con;

	$results = array();
	$query = "SELECT skills.skill FROM userskills
			  INNER JOIN skills ON userskills.username = '$username' AND skills.idskill = userskills.idskill";
	if ($data = pg_query($con, $query)) {
		while ($row = pg_fetch_assoc($data)) {
			array_push($results, $row['skill']);
		}
	}
	return $results;
}

function existsOne($filter, $userSkills) {
	foreach ($filter as $fil) {
		if (in_array($fil, $userSkills)) {
			return true;
		}
	}
	return false;
}

function existsAll($filter, $userSkills) {
	foreach ($filter as $fil) {
		if (!in_array($fil, $userSkills)) {
			return false;
		}
	}
	return true;
}

function checkRequire($require, $filter, $sg) {
	if ($require == 'all') {
		//all
		if (!existsAll($filter, $sg)) {
			return false;
		}
	} else {
		//one
		if (!existsOne($filter, $sg)) {
			return false;
		}
	}
	return true;
}

function getProjectData($search, $order, $require, $skillFilter, $genreFilter) {
	global $con;
	//global $fp;

	if ($order == 'name') {
		//name
		$query = "SELECT * FROM projects WHERE LOWER(name) LIKE '%{$search}%' ORDER BY LOWER(name) ASC";
	} else if ($order == 'new') {
		//new -> old
		$query = "SELECT * FROM projects WHERE LOWER(name) LIKE '%{$search}%' ORDER BY datecreated DESC";
	} else {
		//old -> new
		$query = "SELECT * FROM projects WHERE LOWER(name) LIKE '%{$search}%' ORDER BY datecreated ASC";
	}

	$result = array();

	if ($data = pg_query($con, $query)) {
		while ($row = pg_fetch_assoc($data)) {
			unset($fields);
			unset($tempE);
			unset($tempF);
			$fields = array();
			$tempE = array();
			$tempF = array();
			$fields["name"] = $row['name'];
			$fields["description"] = $row['description'];
			$fields["path"] = $row['path'];
			$fields["datecreated"] = parse_sql_timestamp($row['datecreated']);
			$skills = getProjectSkills($row['idproject']);
			$genres = getProjectGenres($row['idproject']);
			if ($skillFilter[0] != 'none' && $genreFilter[0] != 'none') {
				if ($skillFilter[0] == 'none') {
					//only check genres
					if (!checkRequire($require, $genreFilter, $genres)) {
						continue;
					}
				} else if ($genreFilter[0] == 'none') {
					//only check skills
					if (!checkRequire($require, $skillFilter, $skills)) {
						continue;
					}
				} else {
					//check skills and genres
					if (!checkRequire($require, $skillFilter, $skills)) {
						continue;
					}
					if (!checkRequire($require, $genreFilter, $genres)) {
						continue;
					}
				}
			}
			foreach($skills as $tempSkill) {
				array_push($tempE, $tempSkill);
			}
			foreach($genres as $tempGenre) {
				array_push($tempF, $tempGenre);
			}
			array_push($fields, $tempE);
			array_push($fields, $tempF);
			//fwrite($fp, $fields);
			array_push($result, $fields);
		}
	}

	return $result;
}

function getUserData($search, $order, $require, $skillFilter) {
	global $con;
	//global $fp;

	if ($order == 'username') {
		//order by username
		//fwrite($fp, "ORDER BY USERNAME\n" . $require);
		$query = "SELECT * FROM users WHERE LOWER(username) LIKE '%{$search}%' OR LOWER(name) LIKE '%{$search}%' ORDER BY LOWER(username) ASC";
	} else {
		//order by realname
		//fwrite($fp, "ORDER BY REAL NAME\n" . $require);
		$query = "SELECT * FROM users WHERE LOWER(username) LIKE '%{$search}%' OR LOWER(name) LIKE '%{$search}%' ORDER BY LOWER(name) ASC";
	}

	$results = array();

	if ($data = pg_query($con, $query)) {
		while ($row = pg_fetch_assoc($data)) {
			unset($fields);
			unset($tempD);
			$fields = array();
			$tempD = array();
			$fields["path"] = $row['path'];
			$fields["username"] = $row['username'];
			$fields["about"] = $row['about'];
			$fields["name"] = $row['name'];
			$skills = getUserSkills($row['username']);
			if ($skillFilter[0] != 'none') {
				if (!checkRequire($require, $skillFilter, $skills)) {
					continue;
				}
			}
			foreach($skills as $tempSkill) {
				array_push($tempD, $tempSkill);
			}
			array_push($fields, $tempD);
			array_push($results, $fields);
		}
	}
	return $results;
}

function getAllData($search) {
	global $con;

	$results = array();
	$userProject = array();

	$query = "SELECT * FROM projects WHERE LOWER(name) LIKE '%{$search}%'";
	if ($data = pg_query($con, $query)) {
		while ($row = pg_fetch_array($data)) {
			unset($fields);
			unset($tempB);
			unset($tempC);
			$fields = array();
			$tempB = array();
			$tempC = array();
			$fields["name"] = $row['name'];
			$fields["description"] = $row['description'];
			$fields["path"] = $row['path'];
			$fields["datecreated"] = parse_sql_timestamp($row['datecreated']);
			foreach(getProjectSkills($row['idproject']) as $tempSkill) {
				array_push($tempB, $tempSkill);
			}
			foreach(getProjectGenres($row['idproject']) as $tempGenre) {
				array_push($tempC, $tempGenre);
			}
			array_push($fields, $tempB);
			array_push($fields, $tempC);
			array_push($userProject, $fields);
		}
	}
	array_push($results, $userProject);


	unset($userProject);
	$userProject = array();

	$query = "SELECT * FROM users WHERE LOWER(username) LIKE '%{$search}%' OR LOWER(name) LIKE '%{$search}%'";
	if ($data = pg_query($con, $query)) {
		while ($row = pg_fetch_array($data)) {
			unset($fields);
			unset($tempA);
			$fields = array();
			$tempA = array();
			$fields["path"] = $row['path'];
			$fields["username"] = $row['username'];
			$fields["about"] = $row['about'];
			$fields["name"] = $row['name'];
			$tempA = array();
			foreach(getUserSkills($row['username']) as $temp) {
				array_push($tempA, $temp);
			}
			array_push($fields, $tempA);
			array_push($userProject, $fields);
		}
	}
	array_push($results, $userProject);

	return $results;
}

// if the 'term' variable is not sent with the request, exit
if (isset($_POST)) {
	//global $fp;

	$type = $_POST['type'];
	$search = strtolower($_POST['search']);
	$order = $_POST['order'];
	$require = $_POST['require'];

	$skillFilter = false;
	$genreFilter = false;

	//fwrite($fp, $_POST['filter']);

	if (isset($_POST['filter'])) {
		$filter = getFilterArray($_POST['filter']);

	    $skillList = getSkills();
		$genreList = getGenres();

	    $skillFilter = array_diff($filter, $genreList);
	    $genreFilter = array_diff($filter, $skillList);
	}

	switch($type) {
		case "project":
			$result = getProjectData($search, $order, $require, $skillFilter, $genreFilter);
			break;
		case "user":
			$result = getUserData($search, $order, $require, $skillFilter);
			break;
		case "all":
			$result = getAllData($search);
			break;
	}

	echo json_encode($result);
	flush();
}
?>