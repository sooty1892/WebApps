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
    <link href="css/lightbox.css" rel="stylesheet">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.easing.1.3.js"></script>
    <script src='js/jquery.autosize.js'></script>
    <script src="js/updateChanges.js"></script>
    <script src="js/lightbox.min.js"></script>

    <script>
      $(function(){
          $('.normal').autosize();
          $('.animated').autosize();
      });
    </script>

    <!-- For autocomplete -->
    <link href="http://code.jquery.com/ui/1.10.4/themes/excite-bike/jquery-ui.css" rel="stylesheet">
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

  

  <link href="uploadfile.css" rel="stylesheet">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="jquery.uploadfile.min.js"></script>
  
  </head>
  <body>
    <div id ="navbar" class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
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
        </div>
      </div>
      <!--/.nav-collapse -->
    </div>
    <!--/.container-fluid -->
    <div class="container" style = "margin-top: 50px">
      <div class="profilesection">
        <img id="profile_pic" class="img-circle" style = "margin-left: 10px; margin-top: 10px ; margin-bottom: 10px; height: 200px; width: 200px; " src="http://placehold.it/200x200">
        <img src="web_icons/user.png" style="float: right">
        <div class="profilesection-details">
          <h3 class = "profilewrap" style="font-weight: bold"><?php echo $user['username']; ?></h3>
          <input disabled id ="userRealName" type="text" class ="profileEntry" style="width: 330px" placeholder="Real Name">
          <br>
          <button id="btnEdit" type="button" class="btn-info editpos" onclick="editModeUser()">Edit Info</button>
          <div id="btnsChanges" class="editpos" style="display: none">
            
            <button type ="button" class="btn-default" onclick="cancelUser()">Cancel</button>
            <button type="submit" class="btn-success" onclick="saveChangesUser()">Save Changes</button>
 

              <div id="mulitplefileuploader">New Photo</div>

            <div id="status"></div>
              <script>
              $(document).ready(function()
              {
              var settings = {
                  url: "upload.php",
                  dragDrop:true,
                  fileName: "myfile",
                  allowedTypes:"jpg,png,gif,doc,pdf,zip", 
                  returnType:"json",
                 onSuccess:function(files,data,xhr)
                  {
                     alert((data));
                     $("#profile_pic").attr("src", 'uploads/Me.jpg');
                  },
                  showDelete:true,
                  deleteCallback: function(data,pd)
                {
                  for(var i=0;i<data.length;i++)
                  {
                      $.post("delete.php",{op:"delete",name:data[i]},
                      function(resp, textStatus, jqXHR)
                      {
                          //Show Message  
                          $("#status").append("<div>File Deleted</div>");      
                      });
                   }      
                  pd.statusbar.hide(); //You choice to hide/not.

              }
              }
              var uploadObj = $("#mulitplefileuploader").uploadFile(settings);


              });
              </script>
              
          </div>
        </div>
      </div>
      <br>
      <div class="profilesection">
        <img src="web_icons/about.png" style = "float:right">
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
          <input id = "skillField" type="text" placeholder="Add your talents..." style="width:300px"><button type="submit" class="btn-success" style="background-color: #3498db" onclick="addSkills()">Add</button>
          <button type="button" class="btn-success" onclick="cancelSkills()">Save Changes</button>
        </div>
      </div>
      <br>
      <div class="profilesection">
        <img src="web_icons/sounds.png" style = "float:right">
        <h1 style = "margin-left: 25px">My Sounds</h1>
        <div id = "sound-container" class = "infoSection" style="padding-bottom: 5px">
          <ul id="songs-list">
            <li><button type="button" class="btn-default btn-lg btn-block" onclick="activateSong()">
              <img src="web_icons/now_playing.png" style="display: none">The Art of Peer Pressure<span class="close close-music">x</span></button>
            </li>
            <li><button type="button" class="btn-default btn-lg btn-block" onclick="activateSong()">
              <img src="web_icons/now_playing.png" style="display: none">Time of the Seasons<span class="close close-music">x</span></button>
            </li>
          </ul>
        </div>
        <div id="audioPlayer">
        </div>
        <audio controls style = "margin-left: 25px; width: 500px; display: none">
          Your browser does not support the audio element.
        </audio>
        <div id="songUploadBtns" style = "padding-bottom: 10px">
          <button type="button" class="btn-info" style ="margin-left:25px">Upload Song</button>
          <button id="btnRemoveSong" type="button" class="btn-danger" onclick="removeSongs()">Remove Songs</button>
          <button id="btnSaveSong" type="button" class="btn-success" onclick="saveSongs()" style = "display:none">Save Changes</button>
        </div>
      </div>
      <br>
      <div class = "profilesection">
        <img src="web_icons/portfolio.png" style = "float:right">
        <h1 style = "margin-left: 25px">Portfolio</h1>
        <div id="portfolio" style = "padding-top: 50px; padding-left: 25px; padding-right: 25px; padding-bottom: 25px">
          <div class="row">
            <div class="col-md-4 portfolio-item">
              <a href="portfolio-item.html">
              <img class="img-responsive" src="http://placehold.it/400x400">
              </a>
            </div>
            <div class="col-md-4 portfolio-item">
              <a href="portfolio-item.html">
              <img class="img-responsive" src="http://placehold.it/400x400">
              </a>
            </div>
            <div class="col-md-4 portfolio-item">
              <a href="portfolio-item.html">
              <img class="img-responsive" src="http://placehold.it/400x400">
              </a>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-4 portfolio-item">
              <a href="portfolio-item.html">
              <img class="img-responsive" src="http://placehold.it/400x400">
              </a>
            </div>
            <div class="col-md-4 portfolio-item">
              <a href="portfolio-item.html">
              <img class="img-responsive" src="http://placehold.it/400x400">
              </a>
            </div>
            <div class="col-md-4 portfolio-item">
              <a href="portfolio-item.html">
              <img class="img-responsive" src="http://placehold.it/400x400">
              </a>
            </div>
          </div>
        </div>
      </div>
      <br>
    </div>
    <!-- /container -->
  </body>
</html>