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




  

  </head>

  

  <body>

  

    <div class="container">
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
          <li><a href="#">Logout</a></li>
        </ul>
      </li>
      </ul>
    </div>
  </div>


</div>

<ul id = "sideNav"class="nav nav-pills nav-stacked" style="max-width: 300px;">
  <li><div id="controlButton"class="btn-group">
    <button href='#'onclick="showEditModal()"style="width:98px"type="button" class="btn btn-info"><img src="glyphicons_free/glyphicons/png/glyphicons_157_show_thumbnails_with_lines.png"></button>
  </div></li>
  <li class="divider" style="background-color:#222222"></li>
  
  <ul id="menu"class="nav nav-pills nav-stacked">
  <li ><a href="#">Bio</a></li>
  
  </ul>
</ul>

<div id ="editProject" class="modal">
       <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Edit your project</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal">
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
            Private
          </label>
        </div>
        <div class="radio">
          <label>
            <input type="radio" name="optionsRadios" id="public" value="option2">
            Public
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
        <input type="text" class="form-control" id="inputGenre" placeholder="Add genres that you are looking for...">
        <ul id="genre-list" style = "padding: 10px; margin-left: -10px">
        </ul>
      </div>
      <button type="button" class="btn btn-info" onclick="addGenre()">Add</button>
    </div>

    <div class="sectionEdit">
              <ul class="sectionList">
                <li id="id_Intro"class="listItem">Intro
</li>
                
              </ul>

              <div style="position:relative;top:0px"class="form-group">
      <label for="editSections" class="col-lg-2 control-label">Genre</label>
      <div class="col-lg-8">
        <input type="text" class="form-control" id="inputSection" placeholder="Section name">
        
      </div>
      <button id="davebutton"type="button" class="btn btn-info" >Add</button>
    </div>
    </div>

  </fieldset>
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">Submit</button>
      </div>
    </div>
     </div>
     </div>

<div id ="newProject" class="modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Make a new project</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal">
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
          </fieldset>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">Submit</button>
      </div>
    </div>
  </div>
</div>



<div class="middlePanel"id="middlePanel">
  <div class="projectSection" >
    <img src="images/dj.jpg" width="250px" id="albumArt">
    <button type="button" class="btn btn-default" id="changeAlbumArt">:::</button>
    <div class="projectInfo">
      <h3  >Project x</h3>
      <p>Date started: 10/03/14 </p>
      <p>Genre: Hard eco rock</p>
      <p>Personal: Charki, Ashley the moaner,EDDIETHEBLACK,DAVE</p>
    </div><br>  
  </div><br>
  
</div>

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
  </body>
</html>
