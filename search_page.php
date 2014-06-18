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

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Search Results</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/search_styles.css" rel="stylesheet">
    <!-- For autocomplete -->
    <link href="http://code.jquery.com/ui/1.10.4/themes/excite-bike/jquery-ui.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.easing.1.3.js"></script>
    <script>
      $(document).ready(function($){
        getAllData();
      });

      function getSkillGenre() {
        var divSkillGenres = $("#skills-genre-list div");
        var skillGenres = "";

        for(var i = 0; i < divSkillGenres.length ; ++i) {
          skillGenres = skillGenres + "," + divSkillGenres[i].getAttribute("value");
        }

        if (skillGenres == "") {
          skillGenres = "none";
        }

        return skillGenres;
      }

      function getSkill() {
        var divSkill = $("#skills-list div"); 
        var skill = "";

        for(var i = 0; i < divSkill.length ; ++i) {
          skill = skill + "," + divSkill[i].getAttribute("value");
        }

        if (skill == "") {
          skill = "none";
        }

        return skill;
      }

      function getProjectData() {
        //console.log("Project");
        var search = "<?php echo $_SESSION['search'];?>";
        var filter = getSkillGenre();
        if ($('#orderProject').val() == '1') {
          //name
          var order = "name";
        } else if ($('#orderProject').val() =='2') {
          //new -> old
          var order = "new";
        } else {
          //old -> new
          var order = "old";
        }
        if ($('#radioProjectOne').is(':checked')) {
          var require = "one";
        } else {
          var require = "all";
        }
        $.ajax({
          type: 'POST',
          url: 'scripts/search_get.php',
          data: {search: search,
                 type: 'project',
                 filter: filter,
                 order: order,
                 require: require},
          dataType: 'json',
          success: function(response) {
            //console.log(response);
            $('#search-results').empty();
            for (var i in response) {
              projectOutput = "<div class=\"result\"><img style=\"height: 100px; width: 100px;\" src=\"" . response[i].path . "\"><div class=\"result-info\"><h4>" +  response[i].name + "</h4><p><strong>" + response[i].description + "</strong></p><p><strong>Skills Needed</strong>";
              for (var a in response[i][0]) {
                projectOutput += " <span class=\"label label-primary\">" + response[i][0][a] + "</span> ";
              }
              projectOutput += "</p><p><strong>Genre</strong>";
              for (var b in response[i][1]) {
                projectOutput += " <span class=\"label label-primary\">" + response[i][1][b] + "</span> ";
              }
              projectOutput += "</p></div></div>";
              $('#search-results').append($(projectOutput));
            }
          },
          error: function(xhr,err){
            alert("readyState: "+xhr.readyState+"\nstatus: "+xhr.status);
            alert("responseText: "+xhr.responseText);
          }
        })
      }

      function getUserData() {
        //console.log("User");
        var search = "<?php echo $_SESSION['search'];?>";
        var filter = getSkill();
        console.log(filter);
        if ($('#orderUser').val() == '2') {
          //username
          var order = "real";
        } else {
          //real name
          var order = "username";
        }
        if ($('#radioUserOne').is(':checked')) {
          var require = "one";
        } else {
          var require = "all";
        }
        $.ajax({
          type: 'POST',
          url: 'scripts/search_get.php',
          data: {search: search,
                 type: 'user',
                 filter: filter,
                 order: order,
                 require: require},
          dataType: 'json',
          success: function(response) {
            //console.log(response);
            $('#search-results').empty();
            var userOutput;
            for (var i in response) {
              userOutput = "<div class=\"result\"><img style=\"height: 100px; width: 100px;\" class=\"img-circle\" src=\"" + response[i].path + "\"><div class=\"result-info\"><h4>" + response[i].username + "</h4><p><strong>" + response[i].about + "</strong></p><p><strong>Skills</strong>";
              for (var a in response[i][0]) {
                userOutput += " <span class=\"label label-primary\">" + response[i][0][a] + "</span> ";
              }
              userOutput += "</p></div></div>";
              $('#search-results').append($(userOutput));
            }
          },
          error: function(xhr,err){
            alert("readyState: "+xhr.readyState+"\nstatus: "+xhr.status);
            alert("responseText: "+xhr.responseText);
          }
        })
      }

      function getAllData() {
        var search = "<?php echo $_SESSION['search'];?>";
        $.ajax({
          type: 'POST',
          url: 'scripts/search_get.php',
          data: {search: search,
                 type: 'all',
                 filter: 'none',
                 order: 'none',
                 require: 'none'},
          dataType: 'json',
          success: function(response) {
            $('#search-results').empty();
            //console.log(response);
            var projectOutput;
            for (var i in response[0]) {
              projectOutput = "<div class=\"result\"><img style=\"height: 100px; width: 100px;\" src=\"" . response[0][i].path . "\"><div class=\"result-info\"><h4>" +  response[0][i].name + "</h4><p><strong>" + response[0][i].description + "</strong></p><p><strong>Skills Needed</strong>";
              for (var a in response[0][i][0]) {
                projectOutput += " <span class=\"label label-primary\">" + response[0][i][0][a] + "</span> ";
              }
              projectOutput += "</p><p><strong>Genre</strong>";
              for (var b in response[0][i][1]) {
                projectOutput += " <span class=\"label label-primary\">" + response[0][i][1][b] + "</span> ";
              }
              projectOutput += "</p></div></div>";
              $('#search-results').append($(projectOutput));
            }
            var userOutput;
            for (var i in response[1]) {
              userOutput = "<div class=\"result\"><img style=\"height: 100px; width: 100px;\" class=\"img-circle\" src=\"" + response[1][i].path + "\"><div class=\"result-info\"><h4>" + response[1][i].username + "</h4><p><strong>" + response[1][i].about + "</strong></p><p><strong>Skills</strong>";
              for (var a in response[1][i][0]) {
                userOutput += " <span class=\"label label-primary\">" + response[1][i][0][a] + "</span> ";
              }
              userOutput += "</p></div></div>";
              $('#search-results').append($(userOutput));
            }
          },
          error: function(xhr,err){
            alert("readyState: "+xhr.readyState+"\nstatus: "+xhr.status);
            alert("responseText: "+xhr.responseText);
          }
        })
      }
    </script>
    <script src="js/search_page.js"></script>
    <script>
      $(document).ready(function($){
        $('#filterProject').autocomplete({
          source: 'scripts/suggest_both.php',
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
        $('#filterUser').autocomplete({
          source: 'scripts/suggest_skill.php',
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
            <li class="active"><a href="search.php">Search</a></li>
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
            <li><a href="#" onclick="showModal()">Create Project</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $logged_in_user; ?><b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="profile_page.php">Profile Page</a></li>
                <li><a href="logout.php">Logout</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
      <!--/.nav-collapse -->
    </div>


    <br>
    <br>
    <br>


    <div class = "container">
      <div id="wrapper">
        <div class = "search-section">

          <h4 class="subheading">Search Filters</h4>
          <div id="filters" style ="padding-left: 10px; margin-top: -5px; margin-bottom: 10px">
              <div id="filterAddingProject" style="display:none">
                  <select class="form-control" id="orderProject" onchange="getProjectData()">
                    <option value="1">Order by Project Name</option>
                    <option value="2">Order by new projects</option>
                    <option value="3">Order by old projects</option>
                  </select>
                  <br>
                  <div class="radio">
                    <label>
                      <input type="radio" name="radioProject" id="radioProjectOne" value="radioProjectOne" onchange="getProjectData()" checked>
                      Require at least 1 skill/genre
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="radioProject" id="radioProjectAll" onchange="getProjectData()" value="radioProjectAll">
                      Require all skills/genres
                    </label>
                  </div>
                  <br>
                  <input id="filterProject" type="text" name="skillGenreEnter" style="margin-bottom: 5px" placeholder="Filter by skill or genre">
                  <ul id="skills-genre-list" style="margin-left: -40px">
                    <li><div class="tag">Guitar<span class="close">x</span></div></li>
                  </ul>
              </div>
              <div id="filterAddingUser" style="display:none">
                  <select class="form-control" id="orderUser" onchange="getUserData()">
                    <option value="1">Order by username</option>
                    <option value="2">Order by real name</option>
                  </select>
                  <br>
                  <div class="radio">
                    <label>
                      <input type="radio" name="radioUser" id="radioUserOne" value="radioUserOne" onchange="getUserData()" checked>
                      Require at least 1 skill
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="radioUser" id="radioUserAll" value="radioUserAll" onchange="getUserData()">
                      Require all skills
                    </label>
                  </div>
                  <br>
                  <input id="filterUser" type="text" name="skillEnter" style="margin-bottom: 5px" placeholder="Filter by skill">
                  <ul id="skills-list" style="margin-left: -40px">
                   
                  </ul>
              </div>
              <div style = "margin-top: -8px">
                  <input id="allResults" type="checkbox" name="allResults" checked onclick="hideFiltering()"> All Results<br>
                  <input id="projects" type="radio" name="projectsUsers" onclick="showFilteringProject()"> Projects<br>
                  <input id="users" type="radio" name="projectsUsers" onclick="showFilteringUser()"> Users<br>
              </div>
          </div>
      </div>


      <div id="search-results" style="margin-left: 260px; float:left">

    </div>


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
          <ul id = "projects-list" style="margin-top: -10px; padding: 10px">
            <?php
              $query = "SELECT projects.idproject, projects.name FROM projects INNER JOIN projectusers ON projectusers.username = '{$logged_in_user}' AND projects.idproject = projectusers.idproject";
              $results = pg_query($con, $query);
              while ($row = pg_fetch_assoc($results)) {
                echo "<li><a href=\"temp.php?id=" . $row['idproject'] . "\"><button type=\"button\" class=\"btn-default btn-lg btn-block\">" . $row['name'] . "</button></a></li>";
              }
            ?>
          </ul>
      </div>
    </div>


    </div>
  </body>
</html>