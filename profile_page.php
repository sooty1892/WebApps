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

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (isset($_POST['projectName']) && isset($_POST['projectDescription']) && isset($_POST['projectPrivacy'])) {
        $name = pg_escape_string(valInput($_POST['projectName']));
        $desc = pg_escape_string(valInput($_POST['projectDescription']));

        $skills = explode(",", $_POST['hiddenSkills']);
        $genres = explode(",", $_POST['hiddenGenres']);
        foreach (array_keys($skills, '') as $key) {
          unset($skills[$key]);
        }
        foreach (array_keys($skills, ',') as $key) {
          unset($skills[$key]);
        }
        foreach (array_keys($genres, '') as $key) {
          unset($genres[$key]);
        }
        foreach (array_keys($genres, ',') as $key) {
          unset($genres[$key]);
        }

        $fp = fopen('scripts/log.txt', "w+");

        foreach ($skills as $skill) {
          fwrite($fp, $skill . "\n");
        }
        foreach ($genres as $genre) {
          fwrite($fp, $genre . "\n");
        }

        if ($_POST['projectPrivacy'] != 'option1') {
          $query = "INSERT INTO projects (name, description, private)
                  VALUES ('$name', '$desc', 'true') RETURNING idproject";
        } else {
          $query = "INSERT INTO projects (name, description, private)
                  VALUES ('$name', '$desc', 'false') RETURNING idproject";
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
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/profile_styles.css" rel="stylesheet">
    <link href="css/lightbox.css" rel="stylesheet">
    <link href="css/list_style.css" rel="stylesheet">
    
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
    </script>
    <script>
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

    <!-- For blueimp file upload -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="http://blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
    <link rel="stylesheet" href="css/jquery.fileupload.css">
    <link rel="stylesheet" href="css/jquery.fileupload-ui.css">
    <script src="js/jquery.ui.widget.js"></script>
    <script src="http://blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
    <script src="http://blueimp.github.io/JavaScript-Load-Image/js/load-image.min.js"></script>
    <script src="http://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="http://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
    <script src="js/jquery.iframe-transport.js"></script>
    <script src="js/jquery.fileupload.js"></script>
    <script src="js/jquery.fileupload-process.js"></script>
    <script src="js/jquery.fileupload-image.js"></script>
    <script src="js/jquery.fileupload-audio.js"></script>
    <script src="js/jquery.fileupload-video.js"></script>
    <script src="js/jquery.fileupload-validate.js"></script>
    <script src="js/jquery.fileupload-ui.js"></script>

    <script src="js/create_project_add.js"></script>

  </head>
  <body>
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
                  <ul id="skill-list-p" style = "padding: 10px; margin-left: -10px">
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
              <button type="submit" class="btn btn-success">Submit</button>
            </fieldset>
          </form>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>





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
          <li><a href="#">Logout</a></li>
        </ul>
        </li>
      </ul>
    </div>
  </div>
  <!--/.nav-collapse -->
</div>


    <!--/.container-fluid -->
    <div class="container" style = "margin-top: 50px">

      <div class="profilesection">
        <?php
          if (empty($user['path'])) {
            echo "<img id=\"profile_pic\" class=\"img-circle\" style=\"margin-left: 10px; margin-top: 10px ; margin-bottom: 10px; height: 200px; width: 200px; \" src=\"http://placehold.it/200x200\">";
          } else {
            echo "<img id=\"profile_pic\" class=\"img-circle\" style=\"margin-left: 10px; margin-top: 10px ; margin-bottom: 10px; height: 200px; width: 200px; \" src=\"" . substr($user['path'],3) . "\">";
          }
        ?>
        <img src="web_icons/user.png" style="float: right">
        <div class="profilesection-details">
          <h3 class="profilewrap" style="font-weight: bold"><?php echo $user['username']; ?></h3>
          <h4 class="profilewrap" style="font-weight: bold"><?php echo $user['email']; ?></h3>
          <input disabled id="userRealName" type="text" class ="profileEntry" style="width: 330px" placeholder="Real Name" value="<?php echo $user['name']; ?>">
          <br>
          <button id="btnEdit" type="button" class="btn-info editpos" onclick="editModeUser()">Edit Info</button>
          <div id="btnsChanges" class="editpos" style="display: none">
            
            <button type ="button" class="btn-default" onclick="cancelUser()">Cancel</button>
            <button type="submit" class="btn-success" onclick="saveChangesUser('<?php echo $user['username']; ?>')">Save Changes</button>
 
            <!-- <span class="btn btn-success fileinput-button">
                <i class="glyphicon glyphicon-plus"></i>
                <span>Select files...</span> -->
                <!-- The file input field used as target for the file upload widget -->
                <!-- <input id="fileuploading" type="file" name="files[]" multiple>
            </span>
            <br>
            <br> -->
            <!-- The global progress bar -->
            <!-- <div id="progress" class="progress">
                <div class="progress-bar progress-bar-success"></div>
            </div> -->
            <!-- The container for the uploaded files -->
            <!-- <div id="files" class="files"></div> -->
            
              
          </div>
        </div>
      </div>


      <script>
        /*jslint unparam: true */
        /*global window, $ */
        $(function () {
          'use strict';
          // Change this to the location of your server-side upload handler:
          $('#fileuploading').fileupload({
            url: 'scripts/upload_profile_pic.php',
            dataType: 'json',
            done: function (e, data) {
              // $.each(data.result.files, function (index, file) {
              //   $('<p/>').text(file.name).appendTo('#files');
              // });
              alert(data);
            },
            progressall: function (e, data) {
              var progress = parseInt(data.loaded / data.total * 100, 10);
              $('#progress .progress-bar').css(
                'width',
                progress + '%'
              );
            }
          }).prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');
        });
      </script>

      <br>

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
        <button id ="btnEditSkills" type="button" class="btn-info" style = "margin-left: 25px; margin-bottom: 10px" onclick="editSkills()">Edit Skills</button>
        <div id="btnsSkillEdits" style ="margin-left: 25px; padding-bottom: 10px; display: none">
          <input id="skillField" type="text" placeholder="Add your talents..." style="width:300px"><button type="submit" class="btn-success" style="background-color: #3498db" onclick="addSkills()">Add</button>
          <button type="button" class="btn-success" onclick="cancelSkills('<?php echo $user['username']; ?>')">Save Changes</button>
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
        <div id="audioPlayer"></div>
        <audio controls style = "margin-left: 25px; width: 500px; display: none">
          Your browser does not support the audio element.
        </audio>
        <div id="songUploadBtns" style = "padding-bottom: 10px">
          <button type="button" class="btn-info" style ="margin-left:25px">Upload Song</button>
          <button id="btnRemoveSong" type="button" class="btn-danger" onclick="removeSongs()">Remove Songs</button>
          <button id="btnSaveSong" type="button" class="btn-success" onclick="saveSongs()" style = "display:none">Save Changes</button>
        </div>

        <!-- The file upload form used as target for the file upload widget -->
        <!-- <form id="fileupload" action="" method="POST" enctype="multipart/form-data"> -->
          <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
          <!-- <div class="row fileupload-buttonbar">
            <div class="col-lg-7"> -->
              <!-- The fileinput-button span is used to style the file input field as button -->
              <!-- <span class="btn btn-success fileinput-button">
                <i class="glyphicon glyphicon-plus"></i>
                <span>Add files...</span>
                <input type="file" name="files[]" multiple>
              </span>
              <button type="submit" class="btn btn-primary start">
                <i class="glyphicon glyphicon-upload"></i>
                <span>Start upload</span>
              </button>
              <button type="reset" class="btn btn-warning cancel">
                <i class="glyphicon glyphicon-ban-circle"></i>
                <span>Cancel upload</span>
              </button>
              <button type="button" class="btn btn-danger delete">
                <i class="glyphicon glyphicon-trash"></i>
                <span>Delete</span>
              </button>
              <input type="checkbox" class="toggle"> -->
              <!-- The global file processing state -->
              <!-- <span class="fileupload-process"></span>
            </div> -->
            <!-- The global progress state -->
            <!-- <div class="col-lg-5 fileupload-progress fade"> -->
              <!-- The global progress bar -->
              <!-- <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar progress-bar-success" style="width:0%;"></div>
              </div> -->
              <!-- The extended global progress state -->
              <!-- <div class="progress-extended">&nbsp;</div>
            </div>
          </div> -->
          <!-- The table listing the files available for upload/download -->
          <!-- <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
        </form> -->

        <script>
          $(function () {
            'use strict';

            // Initialize the jQuery File Upload widget:
            $('#fileupload').fileupload({
              url: 'scripts/upload_profile_song.php',
              formData: {username: 'test'},
              dataType: 'text',
              fail: function(e, data) {
                alert(data.errorThrown);
              },
              done: function (e, data) {
                // data.result
                // data.textStatus;
                // data.jqXHR;
                // alert(data.result);
              }
            });
          });
        </script>

        <!-- The blueimp Gallery widget -->
       <!--  <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
          <div class="slides"></div>
          <h3 class="title"></h3>
          <a class="prev">‹</a>
          <a class="next">›</a>
          <a class="close">×</a>
          <a class="play-pause"></a>
          <ol class="indicator"></ol>
        </div> -->
        <!-- The template to display files available for upload -->
        <script id="template-upload" type="text/x-tmpl">
        {% for (var i=0, file; file=o.files[i]; i++) { %}
            <tr class="template-upload fade">
                <td>
                    <span class="preview"></span>
                </td>
                <td>
                    <p class="name">{%=file.name%}</p>
                    <strong class="error text-danger"></strong>
                </td>
                <td>
                    <p class="size">Processing...</p>
                    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
                </td>
                <td>
                    {% if (!i && !o.options.autoUpload) { %}
                        <button class="btn btn-primary start" disabled>
                            <i class="glyphicon glyphicon-upload"></i>
                            <span>Start</span>
                        </button>
                    {% } %}
                    {% if (!i) { %}
                        <button class="btn btn-warning cancel">
                            <i class="glyphicon glyphicon-ban-circle"></i>
                            <span>Cancel</span>
                        </button>
                    {% } %}
                </td>
            </tr>
        {% } %}
        </script>
        <!-- The template to display files available for download -->
        <script id="template-download" type="text/x-tmpl">
        {% for (var i=0, file; file=o.files[i]; i++) { %}
            <tr class="template-download fade">
                <td>
                    <span class="preview">
                        {% if (file.thumbnailUrl) { %}
                            <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                        {% } %}
                    </span>
                </td>
                <td>
                    <p class="name">
                        {% if (file.url) { %}
                            <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                        {% } else { %}
                            <span>{%=file.name%}</span>
                        {% } %}
                    </p>
                    {% if (file.error) { %}
                        <div><span class="label label-danger">Error</span> {%=file.error%}</div>
                    {% } %}
                </td>
                <td>
                    <span class="size">{%=o.formatFileSize(file.size)%}</span>
                </td>
                <td>
                    {% if (file.deleteUrl) { %}
                        <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                            <i class="glyphicon glyphicon-trash"></i>
                            <span>Delete</span>
                        </button>
                        <input type="checkbox" name="delete" value="1" class="toggle">
                    {% } else { %}
                        <button class="btn btn-warning cancel">
                            <i class="glyphicon glyphicon-ban-circle"></i>
                            <span>Cancel</span>
                        </button>
                    {% } %}
                </td>
            </tr>
        {% } %}
        </script>
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