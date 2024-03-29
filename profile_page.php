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

    if (!isset($_GET['id'])) {
     $_GET['id'] = $logged_in_user;
    }

    $follow = 'no';
    $access;
    if ($_GET['id'] != $logged_in_user) {
      $access = 'false';
      $query = "SELECT * FROM following WHERE follower = '$logged_in_user' AND followee = '{$_GET['id']}'";
      $res = pg_query($con, $query);
      if (pg_num_rows($res) > 0) {
        $follow = 'yes';
      }
    } else {
	$access = 'true';
    }

    $query = "SELECT * FROM users WHERE username = '{$_GET['id']}'";
    $result = pg_query($con, $query);
    $user = pg_fetch_array($result);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (isset($_POST['projectName']) && isset($_POST['projectDescription']) && isset($_POST['projectPrivacy'])) {
        $name = pg_escape_string(valInput($_POST['projectName']));
        $desc = pg_escape_string(valInput($_POST['projectDescription']));

        $skills = explode(",", $_POST['hiddenSkills']);
        $genres = explode(",", $_POST['hiddenGenres']);
        foreach (array_keys($skills, ',') as $key) {
          unset($skills[$key]);
        }
        foreach (array_keys($genres, ',') as $key) {
          unset($genres[$key]);
        }

        $license = $_POST['selectLicense'];

        if ($_POST['projectPrivacy'] != 'option1') {
          $query = "INSERT INTO projects (name, description, private, license, datecreated, path)
                  VALUES ('$name', '$desc', 'true', '$license', 'NOW()', 'images/dj.jpg') RETURNING idproject";
        } else {
          $query = "INSERT INTO projects (name, description, private, license, datecreated, path)
                  VALUES ('$name', '$desc', 'false', '$license', 'NOW()', 'images/dj.jpg') RETURNING idproject";
        }
        $result = pg_query($con, $query);
        $row = pg_fetch_row($result);
        $idproject = $row['0'];

        foreach($skills as $skill) {
            $query = "SELECT idskill FROM skills WHERE skill = '$skill'";
            $idskill = pg_fetch_row(pg_query($con, $query))['0'];

            $query = "INSERT INTO projectskills (idproject, idskill)
                      VALUES ('$idproject', '$idskill')";
            pg_query($con, $query);
        }
        foreach($genres as $genre) {
            $query = "SELECT idgenre FROM genres WHERE genre = '$genre'";
            $idgenre = pg_fetch_row(pg_query($con, $query))['0'];

            $query = "INSERT INTO projectgenres (idproject, idgenre)
                      VALUES ('$idproject', '$idgenre')";
            pg_query($con, $query);
        }

        $query = "INSERT INTO projectusers (username, idproject, owner) VALUES ('$logged_in_user', '$idproject', 'true')";
        pg_query($con, $query);

        header("Location: temp.php?id=". $idproject); 
      }
    }
?>

<!DOCTYPE html>
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
    <link href="css/jquery.fileupload.css" rel="stylesheet">

    <!-- For profile pic upload form -->
    <link href="css/profile_pic_upload.css" rel="stylesheet" type="text/css">
    <link href="css/upload_style.css" rel="stylesheet">
    <link href="css/lightbox.css" rel="stylesheet">
    <link href="css/notify.css" rel="stylesheet" type="text/css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.easing.1.3.js"></script>
    <script src='js/jquery.autosize.js'></script>
    <script src="js/updateChanges.js"></script>
    <script src="js/create_project_add.js"></script>
    <script src="js/lightbox.min.js"></script>
    <!-- For autocomplete -->
    <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

    <!-- For profile pic upload form -->
    <script type="text/javascript" src="js/jquery.form.min.js"></script>

    <script>
      $(function(){
          $('.normal').autosize();
          $('.animated').autosize();
      });
    </script>

    <!-- For autocomplete -->
    <script>
      $(document).ready(function($){
        $('#skillField').autocomplete({
          source:'scripts/suggest_skill.php',
          change: function (event, ui) {
            if (!ui.item) {
              $(event.target).val("");
            }
          },
          focus: function (event, ui) {
            return false;
          }
        });
      });

      $(document).ready(function($){
        $('#inputSkill').autocomplete({
          source:'scripts/suggest_skill.php',
          change: function (event, ui) {
            if (!ui.item) {
              $(event.target).val("");
            }
          },
          focus: function (event, ui) {
            return false;
          }
        });
      });

      $(document).ready(function($){
        $('#inputGenre').autocomplete({
          source:'scripts/suggest_genre.php',
          change: function (event, ui) {
            if (!ui.item) {
              $(event.target).val("");
            }
          },
          focus: function (event, ui) {
            return false;
          }
        });
      });
    </script>
    <style>
          .ui-autocomplete {
            max-height: 150px;
            overflow-y: auto;
            /* prevent horizontal scrollbar */
            overflow-x: hidden;
            z-index:2147483647;
          }
    </style>

    <!-- For profile pic upload form -->
    <script type="text/javascript">
      $(document).ready(function() {

        var options = { 
          target: '#output', 
          beforeSubmit: beforeSubmit,
          success: function(a,b,c,d) {
            $('#submit-btn').show(); //hide submit button
            $('#loading-img').hide(); //hide submit button
            $('#progressbox').delay( 1000 ).fadeOut(); //hide progress bar
            $("#profile_pic").attr("src", a);
          },
          uploadProgress: OnProgress,
          resetForm: true,
          data: {username: '<?php echo $user['username']; ?>'},
          dataType: 'json'
        }; 
      
        $('#MyUploadForm').submit(function() { 
          $(this).ajaxSubmit(options);         
          return false; 
        });

        function beforeSubmit() {
          //check whether browser fully supports all File API
          if (window.File && window.FileReader && window.FileList && window.Blob) {
      
            if( !$('#FileInput').val()) {
              $("#output").html("Please select a file");
              return false;
            }

            var ftype = $('#FileInput')[0].files[0].type;
    
            switch(ftype) {
              case 'image/png': 
              case 'image/gif': 
              case 'image/jpeg': 
              case 'image/pjpeg':
                break;
              default:
                $("#output").html("<b>"+ftype+"</b> Unsupported file type!");
              return false
            }
          
            $('#submit-btn').hide(); //hide submit button
            $('#loading-img').show(); //hide submit button
            $("#output").html("");  
          } else {
            $("#output").html("Please upgrade your browser, because your current browser lacks some new features we need!");
            return false;
          }
        }

        function OnProgress(event, position, total, percentComplete) {
          $('#progressbox').show();
          $('#progressbar').width(percentComplete + '%');
          $('#statustxt').html(percentComplete + '%');
          if (percentComplete > 50) {
            $('#statustxt').css('color','#000');
          }
        }

        function bytesToSize(bytes) {
          var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
          if (bytes == 0) {
            return '0 Bytes';
          }
          var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
          return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
        }
      });
    </script>
    <script>
      $(document).ready(function() {
        var input = document.getElementById("songFiles");
        formdata = new FormData();
        document.getElementById("songButt").style.display = "none";

        input.addEventListener("change", function (evt) {
          for (var i = 0; i < this.files.length; i++ ) {
            formdata.append("songFiles[]", this.files[i]);
          }

          var user = "<?php echo $user['username']; ?>";

          formdata.append("username", user);

          if (formdata) {
            $.ajax({
              url: "scripts/upload_profile_song.php",
              type: "POST",
              data: formdata,
              processData: false,
              contentType: false,
              dataType: 'json',
              success: function (res) {
                for(var i = 0; i < input.files.length; ++i) {
                  var name = input.files.item(i).name;
                  var id = $("#songs-list li").length + 1;
                  $("#songs-list").append('<li><button id="' + id + '" type="button"' + 
                    ' class="btn-default btn-lg btn-block">' +
                    '<img src="web_icons/now_playing.png" style="display: none">' 
                    + name + '</button></li>');
                  $('#' + id).on('click', activate);
                  var audio_id = 'audio' + id;
                  $("#audioPlayer").append('<audio loop controls style="display:none" id="' 
                    + audio_id +'"><source src="' + res[i] + '"></audio>');
                  setTimeout(function() {
                    $("#song-preview-list").fadeOut(400, function() {
                      $("#song-preview-list").empty();
                    });
                  } ,3000);
                }
              }
            });
          }
        });
      });
    </script>
    <script>
      $(document).ready(function() {
        var input = document.getElementById("imageFiles");

        var user = "<?php echo $user['username']; ?>";

        formdata = new FormData();
        document.getElementById("imageButt").style.display = "none";
        input.addEventListener("change", function (evt) {

          for (var i = 0; i < this.files.length; i++ ) {
            formdata.append("imageFiles[]", this.files[i]);
          }

          formdata.append("username", user);

          if (formdata) {
            $.ajax({
              url: "scripts/upload_profile_portfolio.php",
              type: "POST",
              data: formdata,
              processData: false,
              contentType: false,
              dataType: 'json',
              success: function (res) {
                var row_count = $("#portfolio").children(".row").length;
                var pics_in_fst_row = $("#portfolio .row:first").children().length;
                var last_row = $("#portfolio .row:last"); 
                var current_row_count = last_row.children().length;

                if(row_count == 0) {
                  $("#portfolio").append('<div class="row"></div>');
                  row_count = 1;
                  last_row = $("#portfolio .row:last");
                }

                for(var i = 0; i < input.files.length; ++i) {
                  if(row_count == 1 && pics_in_fst_row < 3) {
                    last_row.append('<div class="col-md-3'
                      + ' portfolio-item"> <a data-lightbox="portfolio" href="' + res[i] + '"><img ' +
                      'class="img-responsive" src="' + res[i] +'"></a></div>');
                    pics_in_fst_row++;
                  } else {
                    if(row_count == 1 || current_row_count == 4) {
                      $("#portfolio").append('<br><div class="row"></div>');
                      current_row_count = 1;
                      last_row = $("#portfolio .row:last"); 
                      last_row.append('<div class="col-md-3'
                      + ' portfolio-item"> <a data-lightbox="portfolio" href="' + res[i] + '"><img ' +
                      'class="img-responsive" src="' + res[i] +'"></a></div>');
                      row_count++;
                    } else {
                      last_row.append('<div class="col-md-3'
                      + ' portfolio-item"> <a data-lightbox="portfolio" href="' + res[i] + '"><img ' +
                      'class="img-responsive" src="' + res[i] +'"></a></div>');
                      current_row_count++;
                    }
                  }
                }
              }
            });
          }
        });
      });
    </script>
    <script>
      $( document ).ready(function() {
        var access = '<?php echo $access; ?>';
        if (access == 'true') {
          $('#btnFollow').hide();
          //console.log("TRUE");
        } else {
          //console.log("FALSE");
          $('#btnEdit').hide();
          $('#btnEditSkills').hide();
          $('#btnSddSongs').hide();
          $('.fileinput-button').hide();
          $('.editSkillsBtn').hide();
          $('#btnEditAbout').hide();
          var fo = '<?php echo $follow; ?>';
          if (fo == 'yes') {
            $("#btnFollow").html('<i class="glyphicon glyphicon-ok"></i> Following');
            $("#btnFollow").val("following");
            $("#btnFollow").css("opacity", "0.6");
          }
        }
      });

      function followUser() {
        if($("#btnFollow").val() == "not_following"){
            $("#btnFollow").html('<i class="glyphicon glyphicon-ok"></i> Following');
            $("#btnFollow").val("following");
            $("#btnFollow").css("opacity", "0.6");
            $.ajax({
              url: 'scripts/follow.php',
              type: "POST",
              data: {what: 'follow',
                     from: '<?php echo $logged_in_user; ?>',
                     to: '<?php echo $_GET['id']; ?>'
              }
            });
        } else {
            $("#btnFollow").html('<i class="glyphicon glyphicon-user"></i> Follow');
            $("#btnFollow").val("not_following");
            $("#btnFollow").css("opacity", "1");
            $.ajax({
              url: 'scripts/follow.php',
              type: "POST",
              data: {what: 'unfollow',
                     from: '<?php echo $logged_in_user; ?>',
                     to: '<?php echo $_GET['id']; ?>'
              }
            });
        }
    }
    </script>
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
    <!-- Start of Modal -->
    <div id ="newProject" class="modal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title">Make a new project</h4>
          </div>
          <div class="modal-body">
            <form onsubmit="return generateTabs();" class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
              <fieldset>
                <legend>Enter project details and get creating</legend>
                <div class="form-group">
                  <label for="inputProjectName" class="col-lg-2 control-label">Project Name</label>
                  <div class="col-lg-10">
                    <input name="projectName" type="text" class="form-control" id="inputEmail" placeholder="Enter a project name">
                  </div>
                </div>
                 <div class="form-group">
                  <label for="textArea" class="col-lg-2 control-label">Project Description</label>
                  <div class="col-lg-10">
                    <textarea name="projectDescription" class="form-control" rows="3" id="textArea"></textarea>
                    <span class="help-block">A description about your musical project</span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-lg-2 control-label">Privacy level</label>
                  <div class="col-lg-10">
                    <div class="radio">
                      <label>
                        <input type="radio" name="projectPrivacy" id="private" value="option1">
                        Public
                      </label>
                    </div>
                    <div class="radio">
                      <label>
                        <input type="radio" name="projectPrivacy" id="public" value="option2">
                        Private
                      </label>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputSkills" class="col-lg-2 control-label">Skills & Talents</label>
                  <div class="col-lg-8">
                    <input type="text" class="form-control" id="inputSkill" placeholder="Add skills that you are looking for...">
                    <ul id="skill-list-p" style="padding: 10px; margin-left: -10px">
                    </ul>
                  </div>
                  <button type="button" class="btn btn-info" onclick = "addSkillsProject()">Add</button>
                </div>
                <div class="form-group">
                  <label for="inputGenre" class="col-lg-2 control-label">Genre</label>
                  <div class="col-lg-8">
                    <input type="text" class="form-control" id="inputGenre" placeholder="Add genres that the project is...">
                    <ul id="genre-list" style = "padding: 10px; margin-left: -10px">
                    </ul>
                  </div>
                  <input type="hidden" name="hiddenSkills" id="hiddenSkills" value="">
                  <input type="hidden" name="hiddenGenres" id="hiddenGenres" value="">
                  <button type="button" class="btn btn-info" onclick="addGenre()">Add</button>
                 </div> 
                  <div class="form-group">
                    <label for="select" class="col-lg-2 control-label">License - <a href="http://creativecommons.org/licenses/">More</a></label>
                    <div class="col-lg-8">
                    <select class="form-control" id="select" name='selectLicense'>
                      <option selected="selected">Public Domain</option>
                      <option>All Rights Reserved</option>
                      <option>CC Commons Attribution</option>
                      <option>CC Commons Attribution-Noncommercial</option>
                      <option>CC Attribution-Share Alike</option>
                      <option>CC Attribution-Noncommercial-Share Alike</option>
                      <option>CC Attribution-No Derivative Works</option>
                      <option>CC Attribution-Noncommercial-No Derivative Works</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputProjectName" class="col-lg-2 control-label"></label>
                  <div class="col-lg-10">
                    <button type="submit" class="btn btn-success">Submit</button>
                  </div>
                </div>
              </fieldset>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!-- End of Modal -->

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
          <a class="navbar-brand" href="index.php">projectjam</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="profile_page.php">Profile</a></li>
          </ul>
          <form class="navbar-form navbar-left" style="margin-left: 150px" role="search" action="search.php" method="GET">
            <div class="form-group">
              <input name="search" type="text" class="form-control" style="width: 300px;" placeholder="Search for people, projects and skills...">
            </div>
            <button type="submit" class="btn btn-success" style="margin-left: -2px">
              <span class="glyphicon glyphicon-search"></span>
            </button>
          </form>
          <ul class="nav navbar-nav navbar-right">
            <li><a onclick="showModal()">Create Project</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $user['username']; ?><b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="profile_page.php">Profile Page</a></li>
                <li><a href="logout.php">Logout</a></li>
              </ul>
            </li>
            <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
          Notifications <span class="badge" id="notifi">0</span>
        </a>
        <ul class="dropdown-menu" id="responseList">
          <li class="divider"></li>
        </ul>
      </li>
          </ul>
        </div>
      </div>
    </div>
    <!-- End of Navbar -->


    <!--Start of Container -->
    <div class="container" style="margin-top: 50px">
          <div class="sidebar">
          <h4 style = "margin-top: 0px; padding : 5px; text-align: center; background-color: #34495e">Music Feeds</h4>
          <div id = "feed-list" style = "margin-top: -10px; margin-bottom: 5px">
              <div class = "feed-element">
                <i class="glyphicon glyphicon-user"></i>
                <strong>User1</strong> has created a new project
              </div>
              <div class = "feed-element">
                <i class="glyphicon glyphicon-music"></i>
                <strong>User9</strong> has finished a new song
              </div>
              <div class = "feed-element">
                <i class="glyphicon glyphicon-user"></i>
                <strong>User1</strong> has created a new project
              </div>
              <div class = "feed-element">
                <i class="glyphicon glyphicon-plus"></i>
                <strong>User17</strong> has uploaded to <strong>Project Funk</strong>
              </div>
              <div class = "feed-element">
                <i class="glyphicon glyphicon-music"></i>
                <strong>User12</strong> has finished a new song
              </div>
          </div>
          <h4 style = "margin-top: 0px; padding : 5px; text-align: center; background-color: #34495e">Current Projects</h4>
          <ul id = "projects-list" style="margin-top: -10px; margin-right: 20px">
            <?php
              $query = "SELECT projects.idproject, projects.name FROM projects INNER JOIN projectusers ON projectusers.username = '{$logged_in_user}' AND projects.idproject = projectusers.idproject";
              $results = pg_query($con, $query);
              while ($row = pg_fetch_assoc($results)) {
                echo "<li><a href=\"temp.php?id=" . $row['idproject'] . "\"><button type=\"button\" class=\"btn-default btn-lg btn-block\">" . $row['name'] . "</button></a></li>";
              }
            ?>
          </ul>
      </div>
      <!-- Start of Profile -->
      <div class="profilesection">
        <?php
          echo "<img id=\"profile_pic\" class=\"img-circle\" style=\"margin-left: 10px; margin-top: 10px ; margin-bottom: 10px; height: 200px; width: 200px; \" src=\"" . $user['path'] . "\">";
        ?>
        <img src="web_icons/user.png" style="float: right">
        <div class="profilesection-details">
          <h3 class="profilewrap" style="font-weight: bold"><?php echo $user['username']; ?></h3>
          <h4 class="profilewrap" style="font-weight: bold"><?php echo $user['email']; ?></h3>
          <input disabled id="userRealName" type="text" class ="profileEntry" style="width: 330px" placeholder="Real Name" value="<?php echo $user['name']; ?>">
          <br>
          <button id="btnFollow" value="not_following" type="button" class="btn-success editpos" onclick="followUser()">
            <i class="glyphicon glyphicon-user"></i>
            Follow
          </button>
          <button id="btnEdit" type="button" class="btn-info editpos" onclick="editModeUser()">Edit Info</button>
          <div id="btnsChanges" class="editpos" style="display: none">
            
            <button type ="button" class="btn-default" onclick="cancelUser()">Cancel</button>
            <button type="submit" class="btn-success" onclick="saveChangesUser('<?php echo $user['username']; ?>')">Save Changes</button>
            <div style = "margin-top : 3px">
                <form action="scripts/upload_profile_pic.php" method="post" enctype="multipart/form-data" id="MyUploadForm">
                  <button class="btn-info fileinput-button" id="btnAddPhoto">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Add photo...</span>
                    <input name="FileInput" id="FileInput" type="file" onchange="updateOutputSelection()">
                  </button>
                  <button type="submit" style="margin-top:5px" class="btn-primary" id="submit-btn" value="Upload">Change Photo</button>
                </form>
                <div id="progressbox"><div id="progressbar"></div><!--<div id="statustxt">0%</div>--></div>
                <div id="output"></div>
            </div>   
          </div>
        </div>
      </div>
      <!-- End of Profile Section -->

      <br>

      <!-- Start of About Section -->
      <div class="profilesection">
        <img src="web_icons/about.png" style = "float:right">
        <h1 style = "margin-left: 25px; margin-top: 35px">About Me</h1>
        <?php
          if (empty($user['about'])) {
            echo "<textarea id = \"aboutArea\" class=\"animated infoSection\" disabled>Please, tell us about yourself...</textarea>";
          } else {
            echo "<textarea id = \"aboutArea\" class=\"animated infoSection\" disabled>" . $user['about'] . "</textarea>";
          }
        ?>
        <br>
        <button id="btnEditAbout" onclick="editAboutMe()" type="button" class="btn-info btnMargin">Edit Info</button>
        <div id = "aboutChanges" style = "display:none" class = "btnMargin">
          <button onclick="cancelAboutMe()" type ="button" class="btn-default">Cancel</button>
          <button onclick="saveAboutMe('<?php echo $user['username']; ?>')" type="submit" class="btn-success">Save Changes</button>
        </div>
      </div>
      <br>

      <!-- Start of Skills Section -->
      <div class="profilesection">
        <h1 style = "margin-left: 25px">Skills &#38; Talents</h1>
        <ul id="skill-list" style = "padding-bottom: 10px">
          <?php
            $username = $user['username'];
            $query = "SELECT * FROM userskills WHERE username = '$username'";
            $result = pg_query($con, $query);
            while($row = pg_fetch_array($result)) {
              $id = $row['idskill'];
              $query = "SELECT skill FROM skills WHERE idskill = '$id'";
              $re = pg_query($con, $query);
              $hi = pg_fetch_row($re);
              $skill = $hi['0'];
              echo "\n<li><button type=\"button\" class=\"btn-primary\" value=\"" . $skill . "\">" . $skill . "<span class=\"close\" style =\"display: none\">x</span></button></li>";
            }
          ?>
        </ul>
        <button id="btnEditSkills" type="button" class="btn-info" style = "margin-left: 25px; margin-bottom: 10px" onclick="editSkills()">Edit Skills</button>
        <div id="btnsSkillEdits" style ="margin-left: 25px; padding-bottom: 10px; display: none">
          <input id="skillField" type="text" placeholder="Add your talents..." style="width:300px"><button type="submit" class="btn-success" style="background-color: #3498db" onclick="addSkills()">Add</button>
          <button type="button" class="btn-success" onclick="cancelSkills('<?php echo $user['username']; ?>')">Save Changes</button>
        </div>
      </div>
      <!-- End of Skills Section -->

      <br>

      <!-- Start of Sounds Section -->
      <div class="profilesection">
        <img src="web_icons/sounds.png" style = "float:right">
        <h1 style = "margin-left: 25px">My Sounds</h1>
        <div id = "sound-container" class = "infoSection" style="padding-bottom: 5px">
          <ul id="songs-list">
            <?php
              $query = "SELECT path, name FROM usermusicfiles WHERE username = '{$user['username']}'";
              $results = pg_query($con, $query);
              $count = 0;
              while ($row = pg_fetch_assoc($results)) {
                $count++;
                echo '<li><button id="';
                echo $count;
                echo '" type="button"';
                echo ' class="btn-default btn-lg btn-block">';
                echo '<img src="web_icons/now_playing.png" style="display: none">';
                echo $row['name'] ;
                echo '</button></li>';
                echo '<script>';
                echo '$(\'#\' + ' . $count . ').on(\'click\', activate);';
                echo '</script>';
              }
            ?>
          </ul>
        </div>
        <div id="audioPlayer">
          <?php
              $query = "SELECT path FROM usermusicfiles WHERE username = '{$user['username']}'";
              $results = pg_query($con, $query);
              $count = 0;
              while ($row = pg_fetch_assoc($results)) {
                $count++;
                $audio_id = "audio" . $count;
                echo "<audio loop controls style=\"display:none\" id=\"";
                echo $audio_id;
                echo "\"><source src=\"";
                echo $row['path'];
                echo "\"></audio>";
              }
            ?>
        </div>
        <audio controls style = "margin-left: 25px; width: 500px; display: none">
          Your browser does not support the audio element.
        </audio>
        <div style= "margin-left: 25px; margin-bottom: 10px">
          <form method="post" enctype="multipart/form-data"  action="scripts/upload_profile_song.php">
              <button class="btn-info fileinput-button" id="btnSddSongs">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Add songs...</span>
                    <input type="file" name="songFiles" id="songFiles" multiple onchange="fileNamesList()">                  
              </button>
              <button type="submit" id="songButt">Upload</button>
            </form>
            <div id = "song-preview-list" style= "margin-top: 5px">
            </div>
        </div>
      </div>
      <!-- End of Sounds Section -->

      <!-- for(var i = 0; i < input.files.length; ++i) {
                  var name = input.files.item(i).name;
                  var id = $("#songs-list li").length + 1;
                  $("#songs-list").append('<li><button id="' + id + '" type="button"' + 
                    ' class="btn-default btn-lg btn-block"">' +
                    '<img src="web_icons/now_playing.png" style="display: none">' 
                    + name + '</button></li>');
                  $('#' + id).on('click', activate);
                  var audio_id = 'audio' + id;
                  $("#audioPlayer").append('<audio loop controls style="display:none" id="' 
                    + audio_id +'"><source src="' + res[i] + '"></audio>');
 
                } -->



      <br>

      <!-- Start of Portfolio Section -->
      <div class = "profilesection">
        <img src="web_icons/portfolio.png" style = "float:right">
        <h1 style = "margin-left: 25px">Portfolio</h1>
        <div id="portfolio" style="padding-left: 25px; padding-right: 25px; padding-bottom: 10px">
          <?php
            $query = "SELECT path FROM userimagefiles WHERE username = '{$user['username']}'";
            $results = pg_query($con, $query);
            $numOfImages = pg_num_rows($results);
            $row_count = 0;
            $total = 0;
            while ($row = pg_fetch_assoc($results)) {
              $row_count++;
              $total++;

              if ($total <= 3) {
                if ($row_count == 1) {
                  echo "<div class=\"row\">";
                }
                echo "<div class=\"col-md-3 portfolio-item\">";
                echo '<a data-lightbox="portfolio" href="';
                echo $row['path'];
                echo '"><img ';
                echo 'class="img-responsive" src="';
                echo $row['path'];
                echo '"></a></div>';
                if ($row_count == 3 || $total == $numOfImages) {
                  echo "</div><br>";
                  $row_count = 0;
                }
              } else {
                if ($row_count == 1) {
                  echo "<div class=\"row\">";
                }
                echo "<div class=\"col-md-3 portfolio-item\">";
                echo '<a data-lightbox="portfolio" href="';
                echo $row['path'];
                echo '"><img ';
                echo 'class="img-responsive" src="';
                echo $row['path'];
                echo '"></a></div>';
                if ($row_count == 4 || $total == $numOfImages) {
                  echo "</div><br>";
                  $row_count = 0;
                }
              }
            }
          ?>

        </div>
        <div style= "margin-left: 25px; margin-bottom: 10px">
            <form method="post" enctype="multipart/form-data"  action="scripts/upload_profile_portfolio.php">
              <button class="btn-info fileinput-button">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Add photos...</span>
                    <input type="file" name="imageFiles" id="imageFiles" multiple onchange="fileNamesList()">                  
              </button>
              <button type="submit" id="imageButt">Upload</button>
            </form>
        </div>
        </div>
      </div>
      <!-- End of Portfolio Section -->

      <br>
    </div>
    <!-- End of Container -->

  </body>
</html>

