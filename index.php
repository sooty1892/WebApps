<?php
  include 'php_scripts/common.php';
  include 'libraries/passwordLib.php';

  if (loggedin()) {
    header("Location: private.php");
    exit();
  }

  $unError = $emailError = $pwError = $pwCheckError = "";
  $submitted_username = '';

  //login form
  if (!empty($_POST['login_submit'])) {
    //rememberMe set to 'on' if ticked and empty if not

    $un = $_POST['usernameLogin'];
    $pw = $_POST['passwordLogin'];

    $query = "SELECT * FROM users WHERE username='{$un}'";
    $results = pg_query($con, $query);

    $login_ok = FALSE;
    if (pg_num_rows($results) == 1) {
      $array = pg_fetch_array($results);
      if (password_verify($pw, $array['password'])) {
        $login_ok = TRUE;
      } else {
        die("ERROR");
      }
    }
    //die($un . " " . pg_num_rows($results) . " " . $pw);

    if ($login_ok) {
      // if ($_POST['rememberMe'] == "on") {
      //   setcookie("user", $un, $expire);
      // } else if ($_POST['rememberMe'] == "") {
      //   $_SESSION['user'] = $un;
      // }
      setcookie("user", $un, $expire);
      header("Location: private.php");
      exit();
    } else {
      //die($un . " " . $pw);
      $submitted_username = htmlentities($un, ENT_QUOTES, 'UTF-8');
    }
  } else if (!empty($_POST['signup_submit'])) {
    //signup form

    $unError = valUsername($_POST["usernameSignup"]);
    $emailError = valEmail($_POST["emailSignup"]);
    $pwError = valPassword($_POST["passwordSignup"]);
    $pwCheckError = valPassword($_POST["passwordCheckSignup"]);

    if (empty($pwError) && empty($pwCheckError) && strcmp($pw, $pwCheck) != 0) {
      die("Passwords don't match!");
      //$pwCheck = "Passwords don't match!";
      //$pwCheckError = "Passwords don't match!";
    }

    if (empty($unError)) {
      $sql = " SELECT * FROM users WHERE username = '{$_POST['usernameSignup']}'";
      $result = pg_query($con, $sql);
      if (pg_num_rows($result) > 0) {
        die("Username is already in use");
        //$unError = "Username is already in use";
      }
    }

    if (empty($emailError)) {
      $sql = " SELECT * FROM users WHERE email = '{$_POST['emailSignup']}'";
      $result = pg_query($con, $sql);
      if (pg_num_rows($result) > 0) {
        die("Email is already in use");
        //$emailError = "Email is already in use";
      }
    }

    if (empty($unError) && empty($emailError) && empty($pwError) && empty($pwCheckError)) {

      // escape variables for security
      $un = pg_escape_string(valInput($_POST['usernameSignup']));
      $email = pg_escape_string(valInput($_POST['emailSignup']));
      $pw = pg_escape_string(valInput($_POST['passwordSignup']));
      $hashpw = password_hash($pw, PASSWORD_DEFAULT);

      if ($hashpw == false) {
        die("Password hasing error");
        //echo "PASSWORD HASHING ERROR";
      } else {
        $sql = "INSERT INTO users (username, name, email, password, created)
            VALUES ('$un', '', '$email', '$hashpw', NOW())";
        $result = pg_query($con, $sql);
        if (!$result) {
          die("Error in SQL query: " . pg_last_error());
        }
      }

      // if ($rm == "on") {
      //   setcookie("user", $un, $expire);
      // } else if ($rm == "") {
      //   $_SESSION['user'] = $un;
      // }
      setcookie("user", $un, $expire);
      header("Location: private.php");
      exit();
    }
  }
?>

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
    <script src="js/validation.js"></script>
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
                <!-- LOGIN FORM -->
                <form onsubmit="return valLoginForm();" name="login" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="navbar-form navbar-right" role="search" style="margin-top: 5px">
                    <div class="form-group">
                        <input id="username" type="text" class="form-control login-height" value="<?php echo $submitted_username; ?>" name="usernameLogin" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <input id="password" type="password" class="form-control login-height" name="passwordLogin" placeholder="Password">
                    </div>
                    <input id="btnLogin" type="submit" value="Login" name="login_submit" class="btn btn-sm btn-success">
                </form>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </div>
        <div>
            <p id="login-error" style="margin-top: -20px; text-align: right; display: none">
                <font color="orange">Incorrect username/password. Please try again.</font>
            </p>
       </div>

      <!-- Main component for a primary marketing message or call to action -->
<div id="jumbo" class="jumbotron slide-in">
    <div class="container">
    <!-- SIGN UP -->
    <form onsubmit="return valSubmitForm();" name="signup" method="post" class="sign-up" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">    
        <dl class="form">
            <dd><input id="user-login" type="text" name="usernameSignup" class="textfield sign-up-width" placeholder="Choose a username"></dd>
        </dl>
        <h5 id="username-error" class="sign-in-error-message">Username has been taken!</h5>
        <dl class="form">
            <dd><input id="user-email" type="text" name="emailSignup" class="textfield sign-up-width" placeholder="Enter your e-mail address"></dd>
        </dl>
        <h5 id="email-error" class="sign-in-error-message">E-mail address is in use!</h5>
        <dl class="form">
            <dd><input id="user-password" type="password" name="passwordSignup" class="textfield sign-up-width" placeholder="Choose a password"></dd>
        </dl>
        <h5 id="password-error" class="sign-in-error-message"></h5>
        <dl class="form">
            <dd><input type="password" id="user-password-confirm" name="passwordCheckSignup" class="textfield sign-up-width" placeholder="Confirm your password"></dd>
        </dl>
        <h5 id="password-match-error" class="sign-in-error-message"></h5>
        <input type="submit" value="Sign Up" name="signup_submit" id="btnSignUp" class="btn-success">
    </form>
    <h1 class="signup-heading">Make music, together!</h1>
    <p class="signup-heading">Sign up and experience a new world!</p>
    </div>
</div>
    <section id="about" class="page slide-in-right">
      <div class="container-about" style = "background: #4e5d6c">
        <div class="content text-center">
          <div class="heading">
            <h2 style="margin-bottom : 5px">Collaborate, create and publish</h2>
            <p>Make music with friends or complete strangers and share with the world.</p>
          </div>
          <div class="row">
            <div class="col-lg-4 service animated hiding">
              <img src="web_icons/collaboration.png"></img>
              <h3 style "margin-top: 10px">Colloboration</h3>
              <p>This app allows you to collaborate with people from all over the globe and create music together. It brings people with different expertises within the music industry together, while also allowing you to make new friends allong the way.</p>
            </div>
            <div class="col-lg-4 service animated hiding" data-animation="fadeInUp" data-delay="600">
              <img src="web_icons/learning.png"></img>
              <h3 style="margin-top: 10px">Learning</h3>
              <p>Learn from the best! This app allows you to learn from other more experienced people in an interactive way. Simply share music within a project to find out what works and doesn't.</p>
            </div>
            <div class="col-lg-4 service animated hiding" data-animation="fadeInUp" data-delay="900">
              <img src="web_icons/creation.png"></img>
              <h3 style="margin-top: 10px">Creation</h3>
              <p>Make a project to focus on a specfic piece of music, gaining help from other people to create your own personalised music.</p>
            </div>
          </div>
        </div>
      </div>
    </section>    
    </div> <!-- /container -->
  </body>
</html>