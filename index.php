<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Music Collaborator</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.easing.1.3.js"></script>
    <script src="js/sliding.js"></script>
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
            <ul class="nav navbar-nav navbar-right">
              <!--<li class="dropdown" id="menuLogin">
                <a class="dropdown-toggle" href="#" data-toggle="dropdown" id="navLogin">Login</a>
                <div class="dropdown-menu" style="padding:17px;">
                  <form class="form" id="formLogin"> 
                    <input name="username" id="username" type="text" placeholder="Username" style = "margin-bottom: 5px"> 
                    <input name="password" id="password" type="password" placeholder="Password">
                    <input type="checkbox" name="checkbox" value="rememberMe">Remember Me<br>
                  <button type="button" id="btnLogin" class="btn-success" style = "float: right;">Login</button>
                </form>
                </div>
              </li>-->
                <form class="navbar-form navbar-right" role="search" style = "margin-top: 5px">
                    <div class="form-group">
                        <input type="text" class="form-control login-height" name="username" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control login-height" name="password" placeholder="Password">
                    </div>
                    <button type="submit" class="btn btn-sm btn-success">Login</button>
                </form>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </div>

      <!-- Main component for a primary marketing message or call to action -->
<div id="jumbo" class="jumbotron slide-in">
    <div class = "container">
    <form class = "sign-up">    
        <dl class = "form">
            <dd><input type="text" name="user-login" class="textfield sign-up-width" placeholder="Choose a username"></dd>
        </dl>
        <dl class = "form">
            <dd><input type="text" name="user-email" class="textfield sign-up-width" placeholder="Enter your e-mail address"></dd>
        </dl>
        <dl class = "form">
            <dd><input type="password" name="user-password" class="textfield sign-up-width" placeholder="Choose a password"></dd>
        </dl>
        <dl class = "form">
            <dd><input type="password" name="user-password-confirm" class="textfield sign-up-width" placeholder="Confirm your password"></dd>
        </dl>
        <button type = "button" id = "btnSignUp" class = "btn-success" form="">Sign Up</button>
    </form>
    <h1 class = "signup-heading">Make music, together!</h1>
    <p class = "signup-heading"> Say something here, and sign up!</p>
    </div>
</div>
    <section id="about" class="page slide-in-right">
      <div class="container-about" style = "background: #4e5d6c">
        <div class="content text-center">
          <div class="heading">
            <h2>What it's all about</h2>
            <div class="border"></div>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa, alias enim placeat earum quos ab.</p>
          </div>
          <div class="row">
            <div class="col-lg-4 service animated hiding">
              <img src="web_icons/collaboration.png"></img>
              <h3 style = "margin-top: 10px">Colloboration</h3>
              <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod. Nullam id dolor id nibh ultricies vehicula ut id elit. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Praesent commodo cursus magna.</p>
            </div>
            <div class="col-lg-4 service animated hiding" data-animation="fadeInUp" data-delay="600">
              <img src="web_icons/learning.png"></img>
              <h3 style = "margin-top: 10px">Learning</h3>
              <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque lau dantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta.</p>
            </div>
            <div class="col-lg-4 service animated hiding" data-animation="fadeInUp" data-delay="900">
              <img src="web_icons/creation.png"></img>
              <h3 style = "margin-top: 10px">Creation</h3>
              <p>Aliquam aliquet, est a ullamcorper condimentum, tellus nulla fringilla elit, a iaculis nulla turpis sed wisi. Fusce volutpat. Etiam sodales ante id nunc. Proin ornare dignissim lacus.</p>
            </div>
          </div>
        </div>
      </div>
    </section>    
    <section id = "connect">
        
    </section>
    </div> <!-- /container -->
  </body>
</html>