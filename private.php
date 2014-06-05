<?php
    include 'php_scripts/common.php';

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

    $query = "SELECT * FROM users WHERE username = '{$logged_in_user}'";
    $result = pg_query($con, $query);
    $user = pg_fetch_array($result);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Username - Profile Page</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/profile_styles.css" rel="stylesheet">
    <!-- For autocomplete -->
    <link href="http://code.jquery.com/ui/1.10.4/themes/excite-bike/jquery-ui.css" rel="stylesheet">
      
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.easing.1.3.js"></script>
    <script src='js/jquery.autosize.js'></script>
    <script src="js/updateChanges.js"></script>
    <script>
        $(function(){
            $('.normal').autosize();
            $('.animated').autosize();
        });
    </script>
    <!-- For autocomplete -->
    <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script>
        $(document).ready(function($){
            $('#skillField').autocomplete({
                source:'suggest_skill.php'
            });
        });
    </script>
    <style>
          .ui-autocomplete {
            max-height: 150px;
            overflow-y: auto;
            /* prevent horizontal scrollbar */
            overflow-x: hidden;
          }
          /* IE 6 doesn't support max-height
           * we use height instead, but this forces the menu to always be this tall
           */
          * html .ui-autocomplete {
            height: 150px;
          }
    </style>
  </head>
  <body>
    <div class="container">
      <!-- Static navbar -->
      <div id ="navbar" class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Username</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li class="active"><a href="#">Profile</a></li>
              <li><a href="#">Option 1</a></li>
            </ul>
            <form class="navbar-form navbar-left" style= "margin-left: 150px" role="search">
                <div class="form-group">
                    <input type="text" class="form-control" style = "width: 300px;" placeholder="Search for people, projects and skills...">
                </div>
                <button type="submit" class="btn btn-success" style = "margin-left: -2px">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </form>  
         <ul class="nav navbar-nav navbar-right">
                <li><a href="#">Settings</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </div>
        <div class="profilesection">
            <img class="img-circle" style = "margin-left: 10px; margin-top: 10px ; margin-bottom: 10px" src="http://placehold.it/200x200">
            <img src="web_icons/user.png" style="float: right">
            <div class="profilesection-details">
                <h3 class = "profilewrap" style="font-weight: bold"><?php echo $user['username']; ?></h3>
                <p class = "profilewrap">
                    <?php 
                        if (!empty($user['firstname']) || !empty($user['surname'])) {
                            echo $user['firstname'] . " " . $user['surname'];
                        } else {
                            echo "Enter name here";
                        }
                    ?>
                </p>
                <input disabled id = "tag-line" type="text" class = "profileEntry" style= "width: 330px" placeholder="Witty tagline"><br>
                <button id ="btnEdit" type="button" class="btn-info editpos" onclick="editModeUser()">Edit Info</button>
                <div id = "btnsChanges" class ="editpos" style ="display: none">
                    <button type ="button" class="btn-default" onclick="cancelUser()">Cancel</button>
                    <button type="button" class="btn-primary">Upload Photo</button>
                    <button type="submit" class="btn-success" onclick="saveChangesUser()">Save Changes</button>
                </div>
            </div>
        </div>
        <br>
        <div class="profilesection">
            <img src="web_icons/about.png" style = "float:right">
            <!--<h3 class = "labelSection">About me</h3>-->
            <h1 style = "margin-left: 25px; margin-top: 35px">All about me</h1>
            <?php
                if (empty($user['about'])) {
                    echo "<textarea id = \"aboutArea\" class=\"animated infoSection\" disabled>Please, tell us about yourself...</textarea>";
                } else {
                    echo "<textarea id = \"aboutArea\" class=\"animated infoSection\" disabled>" . $user['about'] . "</textarea>";
                }
            ?>
            <br>
            <button id = "btnEditAbout" onclick="editAboutMe()" type="button" class="btn-info btnMargin">Edit Info</button>
            <div id = "aboutChanges" style = "display:none" class = "btnMargin">
                <button onclick="cancelAboutMe()" type ="button" class="btn-default">Cancel</button>
                <button onclick="saveAboutMe('<?php echo $user['username']; ?>')" type="submit" class="btn-success">Save Changes</button>
            </div>
        </div>
        <br>
        <div class="profilesection">
            <h1 style = "margin-left: 25px">Skills &#38; Talents</h1>
            <ul id="skill-list" style = "padding-bottom: 10px">
                <li><button type="button" class="btn-primary">Lyrics<span class="close">x</span></button></li>
                <li><button type="button" class="btn-primary">Guitar<span class="close">x</span></button></li>
                <li><button type="button" class="btn-primary">Vocalist<span class="close">x</span></button></li>
                <li><button type="button" class="btn-primary">Piano<span class="close">x</span></button></li>
            </ul>
            <button id ="btnEditSkills" type="button" class="btn-info" style = "margin-left: 25px; margin-bottom: 10px" onclick=editSkills()>Edit Skills</button>
            <div id="btnsSkillEdits" style ="margin-left: 25px; padding-bottom: 10px; display: none">
                <!-- <input id="skillField" type="text" placeholder="Add your talents..." style="width:300px"> -->
                <input id="skillField" type="text" placeholder="Add your talents..." style="width:300px">
                <button type="submit" class="btn-success" style="background-color: #3498db" onclick="addSkills()">Add</button>
                <button type="button" class="btn-success" onclick="cancelSkills()">Save Changes</button>
            </div>
        </div>
        <br>
        <div class="profilesection">
            <img src="web_icons/sounds.png" style = "float:right">
            <h1 style = "margin-left: 25px">Sounds</h1>
            <div id = "sound-container" class = "infoSection" style="padding-bottom: 5px">
                <button type="button" class="btn btn-default btn-lg btn-block" onclick="activateSong()">
                    <img src="web_icons/now_playing.png" style = "display: none">The Art of Peer Pressure<span class="close close-music">x</span>
                </button>
                <button type="button" class="btn btn-default btn-lg btn-block" onclick="activateSong()">
                    <img src="web_icons/now_playing.png" style = "display: none">Time of the Seasons<span class="close close-music">x</span>
                </button>
            </div>
            <audio controls style = "margin-left: 25px; width: 500px; display: none">
                Your browser does not support the audio element.
            </audio>
            <div id = "songUploadBtns" style = "padding-bottom: 10px">
                <button type="button" class="btn-info" style ="margin-left:25px">Upload Song</button>
                <button type="button" class="btn-danger">Remove Songs</button>
            </div>
        </div>
        <br>
    </div> <!-- /container -->
  </body>
</html>