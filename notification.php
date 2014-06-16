<?php 

  include 'scripts/common.php';

    $logged_in_user = "";

    //check if user is logged in or not
    if (!loggedin()) {
        header("Location: index.php");
        exit();
    } else {
        if (isset($_COOKIE["user"])) {
            $logged_in_user = $_COOKIE["user"];
        } else {
            $logged_in_user = $_SESSION["user"];
        }
    }

?>


<!DOCTYPE HTML >

<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Username - Profile Page</title>

    <!-- For autocomplete -->
    <link href="http://code.jquery.com/ui/1.10.4/themes/excite-bike/jquery-ui.css" rel="stylesheet">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/profile_styles.css" rel="stylesheet">
    <link href="css/list_style.css" rel="stylesheet">
    <!-- For blueimp file upload -->
    <!-- For profile pic upload form -->
    <link href="css/profile_pic_upload.css" rel="stylesheet" type="text/css">
    <style type="text/css">
      img {border-width: 0}
      * {font-family:'Lucida Grande', sans-serif;}
    </style>
    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.easing.1.3.js"></script>
    <script src='js/jquery.autosize.js'></script>
    <script src="js/updateChanges.js"></script>
    <script src="js/create_project_add.js"></script>
    <!-- For autocomplete -->
    <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <!-- For blueimp file upload -->
 <script type="text/javascript" src="js/jquery.form.min.js"></script>
<script> 
	
$(document).ready(function(){

	$("#notify").click(function(){ 

	

	});

});
	

</script>
</head>

<body> 
 <!-- Start of Navbar -->
    <div id ="navbar" class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">MusicMan</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Profile</a></li>
          </ul>
          <form class="navbar-form navbar-left" style="margin-left: 150px" role="search">
            <div class="form-group">
              <input type="text" class="form-control" style="width: 300px;" placeholder="Search for people, projects and skills...">
            </div>
            <button type="submit" class="btn btn-success" style = "margin-left: -2px">
              <span class="glyphicon glyphicon-search"></span>
            </button>
          </form>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#" onclick="showModal()">Create Project</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Username<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#">Profile Page</a></li>
                <li><a href="logout.php">Logout</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <!-- End of Navbar -->

<div class="btn-group">
      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
        Invite to Project
        <span class="caret"></span>
      </button>
      <ul class="dropdown-menu">
	<?php

	  $query = "SELECT projects.name FROM projects INNER JOIN projectusers ON projectusers.owner AND projects.idproject = projectusers.idproject";

	 $results = pg_query($con, $query);
         $array  = pg_fetch_array($results);
	
	// while($row = $array){
	  // echo "<li class=\"projectinvite\">".$row['name']."</li>";   
	// }
	echo implode("|",$array);

	?>
       </ul>
    </div>
</body>


