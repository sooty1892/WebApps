<?php
	session_start();

	// $username = "ashleyhemingway";
	// $host = "localhost";
	// $port = 5432;
	// $dbname = "ashleyhemingway";

    // $username = "cts12";
    // $host = "db.doc.ic.ac.uk";
    // $port = 5432;
    // $dbname = "cts12";
    // $password = "WkMRCTUhEN";

	//used to destroy cookie
	$expireNow = time()-(60*60*24*365);
	//cookie to expire after a year
	$expire = time()+(60*60*24*365);

	// $con = pg_connect("host=localhost port=5432 dbname=ashleyhemingway user=ashleyhemingway");
	// // Check connection
	// if (!$con) {
	// 	die("Error in connection: " . pg_last_error());
	// }

    // $con = pg_connect("host=db.doc.ic.ac.uk port=5432 dbname=cts12 user=cts12 password=WkMRCTUhEN");
    // // Check connection
    // if (!$con) {
    //  die("Error in connection: " . pg_last_error());
    // }

    $con = pg_connect("host=ec2-54-225-103-9.compute-1.amazonaws.com port=5432 dbname=d8lv9hi070ru8r user=hauutfyawsyzpo password=hmxc6ZyFmCAN3tffETT2eBuoz_");
    // Check connection
    if (!$con) {
        die("Error in connection: " . pg_last_error());
    }

	// This block of code is used to undo magic quotes.  Magic quotes are a terrible 
    // feature that was removed from PHP as of PHP 5.4.  However, older installations 
    // of PHP may still have magic quotes enabled and this code is necessary to 
    // prevent them from causing problems.  For more information on magic quotes: 
    // http://php.net/manual/en/security.magicquotes.php 
    if(function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) 
    { 
        function undo_magic_quotes_gpc(&$array) 
        { 
            foreach($array as &$value) 
            { 
                if(is_array($value)) 
                { 
                    undo_magic_quotes_gpc($value); 
                } 
                else 
                { 
                    $value = stripslashes($value); 
                } 
            } 
        } 
     
        undo_magic_quotes_gpc($_POST); 
        undo_magic_quotes_gpc($_GET); 
        undo_magic_quotes_gpc($_COOKIE); 
    }

    header('Content-Type: text/html; charset=utf-8');

    //login check function
	function loggedin() {
		if (isset($_SESSION['user']) || isset($_COOKIE['user'])) {
			return TRUE;
		}
	}

    //basic string validation
    function valInput($data) {
        //strip whitespace from beggining and end of a string
        $date = trim($data);
        //un-quotes a quoted string
        $data = stripslashes($data);
        //convert special charactes to HTML entities
        $data = htmlspecialchars($data);
        return $data;
    }

    //validate emails
    function valEmail($email) {
        $result = "";
        if (empty($email)) {
            $result = "Email is required";
        } else {
            $email = valInput($email);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $result = "Please enter a valid email address";
            } else if (strlen($email) > 256) {
                $result = "Email address too long (max 256 characters)";
            }
        }
        return $result;
    }

    //validate usernames
    function valUsername($username) {
        $result = "";
        if (empty($username)) {
            $result = "Username is required";
        } else {
            $username = valInput($username);
            if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
                $result = "Only letters and numbers allowed";
            } else if (strlen($username) > 20) {
                $result = "Username too long (max 20 characters)";
            }
        }
        return $result;
    }

    //validate names
    function valName($name) {
        $result = "";
        if (empty($name)) {
            $result = "Name is required";
        } else {
            $name = valInput($name);
            if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
                $result = "Only letters allowed";
            } else if (strlen($name) > 50) {
                $result = "Name too long (max 50 characters)";
            }
        }
        return $result;
    }

    //validate passwords
    function valPassword($password) {
        $result = "";
        if (empty($password)) {
            $result = "Password is required";
        } else {
            $password = valInput($password);
            if (strlen($password) < 6) {
                $result = "Password needs to have at least 6 characters!";
            } else if (strlen($password) > 20) {
                $result = "Password needs to have less than 20 characters!";
            } else if (!preg_match("#[0-9]+#", $password)) {
                $result = "Password must include at least one number!";
            } else if (!preg_match("#[a-z]+#", $password)) {
                $result = "Password must include at least one letter!";
            } else if (!preg_match("#[A-Z]+#", $password)) {
                $result = "Password must include at least one uppercase letter!";
            }
        }
        return $result;
    }
?>