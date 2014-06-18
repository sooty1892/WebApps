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
    <!-- For profile pic upload form -->
    <link href="css/profile_pic_upload.css" rel="stylesheet" type="text/css">
    <link href="css/notify.css" rel="stylesheet" type="text/css">
 

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.easing.1.3.js"></script>
    <script src='js/jquery.autosize.js'></script>
    <script src="js/updateChanges.js"></script>
    <script src="js/create_project_add.js"></script>
    <!-- For autocomplete -->
    <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script type="text/javascript" src="js/jquery.form.min.js"></script>

    <script>  
      $(document).ready(function(){
        getNotificationData();
        setInterval(function() {
          getNotificationData();
        }, 10000);


        $(".invite").click(function(){
          //console.log("HERE");
          //var name = "<?php echo $logged_in_user;?>";
        	$.ajax({
        	  type: 'POST',
        	  url: "scripts/notify.php",
        	  data: {usersend: 'admin',
                   useraccept: 'cts12',
                   idproject: '1'}
        	});
        }); 
      });

      function reply_click(clicked_id, usersen){
        // alert("This object's ID attribute is set to \"" + usersend + "\"."); 

        $(document).ready(function(){
         	var name = "<?php echo $logged_in_user; ?>";
          //console.log("HI");
          $.ajax({
        	  type: 'POST',
            url: "scripts/accept.php",
            data: {useraccept: 'admin', 
                  idproject: '1',
                  usersend: 'admin'},
          });
        });
      }

      function reply_decline(clicked_id, usersen){
        // alert("This object's ID attribute is set to \"" + usersend + "\"."); 

        $(document).ready(function(){
          var name = "<?php echo $logged_in_user; ?>";
          //console.log("HI");
          $.ajax({
            type: 'POST',
            url: "scripts/decline.php",
            data: {useraccept: 'admin', 
                  idproject: '1',
                  usersend: 'admin'},
          });
        });
      }

      function getNotificationData() {
        var name = "<?php echo $logged_in_user; ?>";
        $.ajax({
          type: 'POST',
          url: "scripts/get_notifications.php",
          dataType: 'json',
          data: {name: name},
          success: function(res) {
            console.log(res);
            $('#responseList').empty();
            $('#notifi').html(res.length);
            for (var i in res) {
              var output = "<li class=\"response\"> <a href=\"#\">" + res[i].usersend + " " + res[i].description + " </br> </br> <button type=\"button\" class=\"btn btn-warning accept\" id=\"" + res[i].idproject + "\"  onClick=\"reply_click(this.id, '" + res[i].usersend + "')\">Accept</button><button type=\"button\" class=\"btn btn-danger decline\" id=\"" + res[i].idproject + "\"  onClick=\"reply_decline(this.id, '" + res[i].usersend + "')\">Decline</button></li>";
              $('#responseList').append(output);
            } 
          }
        });
      }
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
      <button type="button" class="btn btn-default dropdown-toggle" id="id" data-toggle="dropdown">
        Invite to Project
        <span class="caret"></span>
      </button>
      <ul class="dropdown-menu"> 
      	<?php
      	  $query = "SELECT projects.name FROM projects INNER JOIN projectusers ON projectusers.owner = 't' AND projects.idproject = projectusers.idproject";
          if ($data = pg_query($con, $query)) {
            while ($row = pg_fetch_assoc($data)) {
              //	<li><a href="#">Dropdown link</a></li>
              echo "<li class=\"invite\"> <a href=\"#\">" . $row['name'] . "</li>";
            }
          }
      	?>
      </ul>
    </div>
    
    <ul class="nav nav-pills">
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
          Notifications <span class="badge" id="notifi">0</span>
        </a>
        <ul class="dropdown-menu" id="responseList">
          <li class="divider"></li>
        </ul>
      </li>
    </ul>

  </body>
</html>


