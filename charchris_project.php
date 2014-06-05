<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Music Collaborator</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <link href="css/override.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.easing.1.3.js"></script>
    <script src="js/sliding.js"></script>
    <script src="js/editinplace.js"></script> 
    <script src="js/jquery.jeditable.js"></script>

  </head>
  <body>


    <div class="container">
      <!-- Static navbar -->
      <div class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Music Collaborator</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li class="active"><a href="#">Home</a></li>
              <li><a href="#">About</a></li>
            </ul>

            <!-- This is the right hand side list of the navbar -->
            <ul class="nav navbar-nav navbar-right">


            </ul>


          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </div>

        <ul class="nav nav-pills tab-bar">

          <!-- <li class="active"><a href="#">Home</a></li> -->

          <li class="dropdown edit">

            <a class="dropdown-toggle edit-toggle" data-toggle="dropdown" href="#">

              Edit <span class="caret"></span>
            </a>
            <ul class="dropdown-menu edit-menu">
              <li><a href="#">Action</a></li>
              <li><a href="#">Another action</a></li>
              <li><a href="#">Something else here</a></li>
              <li class="divider"></li>
              <li><a href="#">Separated link</a></li>
            </ul>
          </li>

          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
              Personnel <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <li><a href="#">Action</a></li>
              <li><a href="#">Another action</a></li>
              <li><a href="#">Something else here</a></li>
              <li class="divider"></li>
              <li><a href="#">Separated link</a></li>
            </ul>
          </li>
      </ul>


      <!-- This is where all the project work and description is -->
       <ul class="project-list">

        <li class="list-group-item list-description">
          <!-- update to actual name soon -->
          <P> Project Name:  </p>
             <p class ="project-desc"> Project Description:- </p> 
              <div class="edit_area" id="1"> description goes here </div>

          <table class="description">
            <tr class="image-holder">
              <td class="picture-cell">
                <img src="images/album-art.jpg" alt="Insert project photo" class="project-picture">
              </td> 
            </tr>
          </table> 


        </li>


        </ul>

  </body>
</html>