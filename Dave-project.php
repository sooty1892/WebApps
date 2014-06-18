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

    function parse_sql_timestamp($timestamp, $format = 'd-m-Y') {
        $date = new DateTime($timestamp);
        return $date->format($format);
    }

    $query = "SELECT * FROM projects WHERE idproject = '1'";
    $results = pg_query($con, $query);
    $pro = pg_fetch_array($results);

    $projectid = $pro['idproject'];
    $projectname = $pro['name'];
    $projectdesc = $pro['description'];
    $projectprivacy = $pro['private'];
    $projectlicense = $pro['license'];
    $projectdate = $pro['datecreated'];
    $projectsectionorder = $pro['sectionorder'];

    $query = "SELECT username FROM projectusers WHERE idproject = '{$projectid}'";
    $users = pg_query($con, $query);

    $query = "SELECT genres.genre FROM projectgenres
              INNER JOIN genres ON projectgenres.idproject = '$projectid' AND genres.idgenre = projectgenres.idgenre";
    $genres = pg_query($con, $query);

    $query = "SELECT skills.skill FROM projectskills
              INNER JOIN skills ON projectskills.idproject = '$projectid' AND skills.idskill = projectskills.idskill";
    $skills = pg_query($con, $query); 

    //$fp = fopen('scripts/log.txt', 'w');

    if (!empty($_POST['edit_submit'])) {
      $sections = explode(',', $_POST['hiddenSections']);
      // fwrite($fp, $_POST['hiddenSections']);
      foreach (array_keys($sections, ',') as $key) {
          unset($sections[$key]);
      }

      $new = array();
      foreach ($sections as $sec) {
        array_push($new, substr($sec, 3));
      }
      foreach (array_keys($new, '') as $key) {
          unset($new[$key]);
      }
      foreach (array_keys($sections, "\n") as $key) {
          unset($new[$new]);
      }

      $order = array();
      foreach($new as $sec) {
        $test = stripslashes($sec);
        $query = "SELECT * FROM sections WHERE name = '{$test}' AND idproject = '1'";
        $result = pg_query($con, $query);
        if (pg_num_rows($result) == 0) {
          $query = "INSERT INTO sections (name, idproject) VALUES ('{$test}', '1')";
          pg_query($con, $query);
        }

        $query = "SELECT idsection FROM sections INNER JOIN projects ON projects.idproject = sections.idproject AND projects.idproject = '1' AND sections.name = '{$test}'";
        $res = pg_query($con, $query);
        $rese = pg_fetch_assoc($res);
        array_push($order, $rese['idsection']);
      }
      $newOrder = implode(',', $order);

      $query = "UPDATE projects SET sectionorder = '{$newOrder}' WHERE idproject = '1'";
      pg_query($con, $query);
    }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Music Collaborator</title>
    <link rel="stylesheet" href="css/jquery.simplecolorpicker.css">
    <link href="css/player.css" rel="stylesheet">
    <link href="css/jquery.simplecolorpicker.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/lightbox.css" rel="stylesheet">
    <link href="css/project_styles.css" rel="stylesheet">
    <!-- For autocomplete -->
    <link href="http://code.jquery.com/ui/1.10.4/themes/excite-bike/jquery-ui.css" rel="stylesheet">
   

   <link href="css/chat.css" rel="stylesheet">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script>
      var last = 0;

      $(document).ready(function() {
        getMessages();
        setInterval(function() {
          getMessages();
        }, 1000);

      $('#sendie').keyup(function(e) {
        if (e.keyCode == 13) {
          if ($('#sendie').val() == "\n") {
            $('#sendie').val('');
          } else {
            sendMessage($('#sendie').val());
            //$('#chat-area').append($("<p>" + $('#sendie').val() + "</p>"));
            $('#sendie').val('');
          }
        }
      });
    });

    function sendMessage(message) {
      $.ajax({
        url: 'scripts/save_message.php',
        type: 'POST',
        data: {message: message,
             username: 'admin',
             idproject: '1'}
      });
    } 

    function getMessages() {
      $.ajax({
        url: 'scripts/get_messages.php',
        type: 'GET',
        dataType: 'json',
        data: {idproject: '1',
             last: last},
        success: function(response) {
          console.log(response);
          for (var i in response) {
            $('#chat-area').append($("</p>" +"<span>" + response[i].username + "</span>" + ":\n" + response[i].message + "</p>"));
            if (response[i].idmessage > last) {
              last = response[i].idmessage;
            }
          }       
        }
      });
    }
    </script>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script> 
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery.jplayer.min.js"></script>
    <script type="text/javascript" src="js/jplayer.playlist.min.js"></script>  
    <script type="text/javascript" src="js/jquery.pagescroller.lite.js"></script>
    <script src="js/create_project_add.js"></script>
    <script src="js/edit_project_add.js"></script>

    <script src="js/jquery.simplecolorpicker.js"></script>
    <script src="js/project.js"></script>
    <script type="text/javascript"> 
      $(document).ready(function(){
        var x = '<?php echo $projectprivacy ?>';
        if (x == 'f') {
          $('#edit_public').attr("checked","");
        } else {
          $('#edit_private').attr("checked","");
        }
      });
    </script>
    <script>
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
    
  </head>

  <body>






    <div class="container">
<div id="page-wrap">
    
        <div id="chat-wrap">
          <div id="chat-area">
                <h3 style="text-align:center;border: 2px solid #49a2df;position:fixed;background-color:#222222;width:200px;left :120px;top:400px;">Group Chat</h3>
          </div>
        </div>
        
        <form id="send-message-area">
            <!-- <p>Your message: </p> -->
            <textarea id="sendie" maxlength='100'></textarea>
        </form>
    
    </div>
      <!-- Static navbar -->
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
            <form class="navbar-form navbar-left" style= "margin-left: 150px" role="search">
              <div class="form-group">
                <input type="text" class="form-control" style = "width: 300px;" placeholder="Search for people, projects and skills...">
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

      <!-- Right sidebar -->
      <ul id = "sideNav"class="nav nav-pills nav-stacked" style="max-width: 300px;">
        <li>
          <div id="controlButton"class="btn-group">
            <button href='#'onclick="showEditModal()"style="width:98px"type="button" class="btn btn-info"><img src="glyphicons_free/glyphicons/png/glyphicons_157_show_thumbnails_with_lines.png"></button>
          </div>
        </li>
        <li class="divider" style="background-color:#222222"></li>  
        <ul id="menu"class="nav nav-pills nav-stacked">
        </ul>
      </ul>
      <!-- End of Right sidebar -->

      <!-- Start of Edit Project Modal-->
      <div id ="editProject" class="modal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h4 class="modal-title">Edit your project</h4>
            </div>
            <div class="modal-body">
              <form onsubmit="return generateTabsEdit();" class="form-horizontal" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <fieldset>
                  <legend>Enter project details and get creating</legend>
                  <div class="form-group">
                    <label for="inputProjectName" class="col-lg-2 control-label">Project Name</label>
                    <div class="col-lg-10">
                      <input type="text" value=<?php echo $projectname;?> class="form-control" id="edit_inputEmail" placeholder="Enter a project name">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="textArea" class="col-lg-2 control-label">Project Description</label>
                    <div class="col-lg-10">
                      <textarea name="edit_projectDescription"class="form-control" rows="3" id="textArea"><?php echo $projectdesc;?></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="edit_inputSkills" class="col-lg-2 control-label">Skills & Talents</label>
                    <div class="col-lg-8">
                      <input type="text" class="form-control" id="edit_inputSkill" placeholder="Add skills that you are looking for...">
                      <ul id="edit_skill-list-p" style = "padding: 10px; margin-left: -10px">
                     </ul>
                    </div>
                    <button type="button" class="btn btn-info" onclick = "addSkills()">Add</button>
                  </div>  
                  <div class="form-group">
                    <label for="edit_inputGenre" class="col-lg-2 control-label">Genre</label>
                    <div class="col-lg-8">
                      <input type="text" class="form-control" id="edit_inputGenre" placeholder="Add genres that you are looking for...">
                      <ul id="edit_genre-list" style = "padding: 10px; margin-left: -10px">
                      </ul>
                    </div>
                    <input type="hidden" name="edit_hiddenSkills" id="edit_hiddenSkills" value="">
                    <input type="hidden" name="edit_hiddenGenres" id="edit_hiddenGenres" value="">
                    <button type="button" class="btn btn-info" onclick="edit_addGenre()">Add</button>
                  </div>
                  <div class="sectionEdit">
                    <ul class="sectionList" id="sortable">  
                    </ul>
                    <div style="position:relative;top:0px"class="form-group">
                      <label for="editSections" class="col-lg-2 control-label">Insert a new section</label>
                      <div class="col-lg-8">
                        <input type="text" class="form-control" id="edit_inputSection" placeholder="Section name">   
                      </div>
                      <button id="edit_sectionsButton"type="button" class="btn btn-info" >Add</button>
                      <input type="hidden" name="hiddenSections" id="hiddenSections" value="">
                    </div>
                  </div>
                </fieldset>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <!-- <button type="submit" class="btn btn-success" name="edit_submit">Submit</button> -->
                  <input id="btnLogin" type="submit" value="Submit" name="edit_submit" class="btn btn-sm btn-success">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- End of Edit Project -->

      <!-- Start of New Project Modal -->
      <div id ="newProject" class="modal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h4 class="modal-title">Make a new project</h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <fieldset>
                  <legend>Enter project details and get creating</legend>
                  <div class="form-group">
                    <label for="inputProjectName" class="col-lg-2 control-label">Project Name</label>
                    <div class="col-lg-10">
                      <input type="text" class="form-control" id="inputEmail" placeholder="Enter a project name">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="textArea" class="col-lg-2 control-label">Project Description</label>
                    <div class="col-lg-10">
                      <textarea class="form-control" rows="3" id="textArea"></textarea>
                      <span class="help-block">A description about your musical project</span>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-2 control-label">Privacy level</label>
                    <div class="col-lg-10">
                      <div class="radio">
                        <label>
                          <input type="radio" name="optionsRadios" id="private" value="option1" checked="">
                          Public
                        </label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="optionsRadios" id="public" value="option2">
                          Private
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputSkills" class="col-lg-2 control-label">Skills & Talents</label>
                    <div class="col-lg-8">
                      <input type="text" class="form-control" id="inputSkill" placeholder="Add skills that you are looking for...">
                      <ul id="skill-list-p" style = "padding: 10px; margin-left: -10px">
                      </ul>
                    </div>
                    <button type="button" class="btn btn-info" onclick = "addSkills()">Add</button>
                  </div>
                  <div class="form-group">
                    <label for="inputGenre" class="col-lg-2 control-label">Genre</label>
                    <div class="col-lg-8">
                      <input type="text" class="form-control" id="inputGenre" placeholder="Add genres that the project is...">
                      <ul id="genre-list" style = "padding: 10px; margin-left: -10px">
                      </ul>
                    </div>
                    <button type="button" class="btn btn-info" onclick="addGenre()">Add</button>
                  </div>
                   <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" name="new_submit">Submit</button>
                  </div>
                </fieldset>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Main Section -->
      <div class="middlePanel"id="middlePanel">
        <div class="projectSection" >
          <img src="images/dj.jpg" width="250px" id="albumArt">
          <div class="projectInfo">
            <h3 ><?php echo $projectname; ?></h3>
            <h4><?php echo $projectdesc; ?></h4>
            <p><strong>Date started:</strong> <?php echo parse_sql_timestamp($projectdate);?> </p>
            <p><strong>Genre:</strong>
              <?php
                if ($genres != false) {
                  while ($row = pg_fetch_assoc($genres)) {
                    echo "<span class=\"label label-primary\">" . $row['genre'] . "</span> ";
                  }
                }
              ?>
            </p>
            <p><strong>Skills Required:</strong>
              <?php
                if ($skills != false) {
                  while ($row = pg_fetch_assoc($skills)) {
                    echo "<span class=\"label label-primary\">" . $row['skill'] . "</span> ";
                  }
                }
              ?>
            </p>
            <p><strong>Personal:</strong>
              <?php
                if ($users != false) {
                  while ($row = pg_fetch_assoc($users)) {
                    echo "<span>" . $row['username'] . "</span> ";
                  }
                }
              ?>
            </p>
          </div><br>  
        </div><br>
      </div>
      <!-- End of Main Section -->

      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
      <br>
    </div>
  </body>
</html>
