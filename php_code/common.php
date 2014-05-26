<?php
	session_start();

	$username = "ashleyhemingway";
	$host = "localhost";
	$port = 5432;
	$dbname = "test";
	//used to destroy cookie
	$expireNow = time()-(60*60*24*365);
	//cookie to expire after a year
	$expire = time()+(60*60*24*365);

	$con = pg_connect("host=localhost port=5432 dbname=test user=ashleyhemingway");
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
?>