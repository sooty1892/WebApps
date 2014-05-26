<?php
    //law required, will you accept cookies?
    //validation email

    include 'common.php';
    include 'libraries/passwordLib.php';

    if (loggedin()) {
        header("Location: private.php");
        exit();
    }

    $un = $fn = $sn = $email = $pw = $pwCheck = $rm = "";
    $unError = $fnError = $snError = $emailError = $pwError = $pwCheckError = "";

    if (!empty($_POST) && $_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["rememberMe"])) {
            $rm = $_POST["rememberMe"];
        }

        if (empty($_POST['username'])) {
            $unError = "Username is required";
        } else {
            $un = test_input($_POST["username"]);
            if (!preg_match("/^[a-zA-Z0-9 ]*$/", $un)) {
                $unError = "Only letters and numbers allowed";
            }
        }

        if (empty($_POST['firstname'])) {
            $fnError = "Firstname is required";
        } else {
            $fn = test_input($_POST["firstname"]);
            if (!preg_match("/^[a-zA-Z ]*$/", $fn)) {
                $fnError = "Only letters allowed";
            }
        }

        if (empty($_POST['surname'])) {
            $snError = "Surname is required";
        } else {
            $sn = test_input($_POST["surname"]);
            if (!preg_match("/^[a-zA-Z ]*$/", $sn)) {
                $snError = "Only letters allowed";
            }
        }

        if (empty($_POST['email'])) {
            $emailError = "Email is required";
        } else {
            $email = test_input($_POST["email"]);
            if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email)) {
                $emailErr = "Invalid email format"; 
            }
        }

        if (empty($_POST['password'])) {
            $pwError = "Password is required";
        } else {
            $pw = test_input($_POST["password"]);
            //validation test?
        }

        if (empty($_POST['passwordCheck'])) {
            $pwCheckError = "Password is required";
        } else {
            $pwCheck = test_input($_POST["passwordCheck"]);
            //validation test?
        }

        if (strcmp($pw, $pwCheck) != 0) {
            $pwCheckError = "Passwords don't match!";
        }

        if (empty($unError)) {
            $sql = " SELECT * FROM users WHERE username = '{$_POST['username']}'";
            $result = pg_query($con, $sql);
            if (pg_num_rows($result) > 0) {
                $unError = "Username is already in use";
            }
        }

        if (empty($emailError)) {
            $sql = " SELECT * FROM users WHERE email = '{$_POST['email']}'";
            $result = pg_query($con, $sql);
            if (pg_num_rows($result) > 0) {
                $emailError = "Email is already in use";
            }
        }

        if (empty($unError) && empty($fnError) && empty($snError) && empty($emailError) && empty($pwError) && empty($pwCheckError)) {

            // escape variables for security
            $un = pg_escape_string($_POST['username']);
            $fn = pg_escape_string($_POST['firstname']);
            $sn = pg_escape_string($_POST['surname']);
            $email = pg_escape_string($_POST['email']);
            $pw = pg_escape_string($_POST['password']);
            $hashpw = password_hash($pw, PASSWORD_DEFAULT);

            if ($hashpw == false) {
                echo "PASSWORD HASHING ERROR";
            } else {
                $sql = "INSERT INTO users (username, firstname, surname, email, password, created)
                        VALUES ('$un', '$fn', '$sn', '$email', '$hashpw', NOW())";

                $result = pg_query($con, $sql);

                if (!$result) {
                    die("Error in SQL query: " . pg_last_error());
                }
            }

            if ($rm == "on") {
                setcookie("user", $un, $expire);
            } else if ($rm == "") {
                $_SESSION['user'] = $un;
            }
            header("Location: private.php");
            exit();
        }
    }

    function test_input($data) {
        $date = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Grayscale - Free One Page Theme for Bootstrap 3</title>

    <!-- Bootstrap Core CSS -->
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet" type="text/css">

    <!-- Fonts -->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

    <!-- Custom Theme CSS -->
    <link href="css/grayscale.css" rel="stylesheet">

</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-custom">

    <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="#page-top">
                    <i class="fa fa-play-circle"></i>  <span class="light">Music</span> Collaboration
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">
                    <!-- Hidden li included to remove active class from about link when scrolled up past about section -->
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li class="page-scroll">
                        <a href="#about">About</a>
                    </li>
                    <li class="page-scroll">
                        <a href="#download">Download</a>
                    </li>
                    <li class="page-scroll">
                        <a href="#contact">Sign Up</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

     <h1 class="brand-heading"> Music Man </h1>
    
    <section class="intro">
        <div class="intro-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                       <!-- <h1 class="brand-heading"> Music Man </h1> -->
                        <p class="intro-text"> </p>
                        <div class="page-scroll">
                            <a href="#about" class="btn btn-circle">
                                <i class="fa fa-angle-double-down animated"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="about" class="container content-section text-center">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <h2>About Grayscale</h2>
                <p>Grayscale is a premium quality, free Bootstrap 3 theme created by Start Bootstrap. It can be yours right now, all you need to do is download the template on the preview page. You can use this template for any purpose, personal or commercial.</p>
                <p>This striking, black and white theme features stock photographs by <a href="http://gratisography.com/">Gratisography</a> along with a custom Google Map skin courtesy of <a href="http://snazzymaps.com/">Snazzy Maps</a>.</p>
                <p>With this template, just the slightest splash of color can make a huge impact on the overall presentation and design.</p>
            </div>
        </div>
    </section>

    <section id="download" class="content-section text-center">
        <div class="download-section">
            <div class="container">
                <div class="col-lg-8 col-lg-offset-2">
                    <h2>Download Grayscale</h2>
                    <p>You can download Grayscale for free on the download page at Start Bootstrap. You can also get the source code directly from GitHub if you prefer. Additionally, Grayscale is the first Start Bootstrap theme to come with a LESS file for easy color customization!</p>
                    <a href="http://startbootstrap.com/grayscale" class="btn btn-default btn-lg">Visit Download Page</a>
                </div>
            </div>
        </div>
    </section>

    <section id="contact" class="container content-section text-center">
           <!-- ========================================================================== -->
    <div class="jumbotron">
    <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
  <fieldset>
  <!--  <legend>Legend</legend> -->
  <div class="form-group">
      <label for="inputUserName" class="col-lg-2 control-label">UserName</label>
      <div class="col-lg-10">
        <input class="form-control" id="inputUserName" placeholder="UserName" type="text" name="username" value="<?php echo $un;?>">
        <span class="error">* <?php echo $unError;?></span>
      </div>
    </div>

    <div class="form-group">
      <label for="inputFirstName" class="col-lg-2 control-label">First Name</label>
      <div class="col-lg-10">
        <input class="form-control" id="inputFirstName" placeholder="FirstName" type="text" name="firstname" value="<?php echo $fn;?>">
        <span class="error">* <?php echo $fnError;?></span>
      </div>
    </div>

    <div class="form-group">
      <label for="inputSurname" class="col-lg-2 control-label">Surname</label>
      <div class="col-lg-10">
        <input class="form-control" id="inputSurname" placeholder="Surname" type="text" name="surname" value="<?php echo $sn;?>">
        <span class="error">* <?php echo $snError;?></span>
      </div>
    </div>


    <div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label">Email</label>
      <div class="col-lg-10">
        <input class="form-control" id="inputEmail" placeholder="Email" type="text" name="email" value="<?php echo $email;?>">
        <span class="error">* <?php echo $emailError;?></span>
      </div>
    </div>
    <div class="form-group">
      <label for="inputPassword" class="col-lg-2 control-label">Password</label>
      <div class="col-lg-10">
        <input class="form-control" id="inputPassword" placeholder="Password" type="password" name="password" value="<?php echo $pw;?>">
        <span class="error">* <?php echo $pwError;?></span>
      </div>
    </div>

     <div class="form-group">
      <label for="inputPassword" class="col-lg-2 control-label">Re-type Password</label>
      <div class="col-lg-10">
        <input class="form-control" id="Re-Type Password" placeholder="Re-type Password" type="password" name="passwordCheck" value="<?php echo $pwCheck;?>">
        <span class="error">* <?php echo $pwCheckError;?></span>
      </div>
    </div>

       <div class="checkbox">
          <label>
            <input type="checkbox" name="rememberMe" value="<?php echo $rm;?>"> Remember Me
          </label>
        </div>
    <div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
        <button class="btn btn-default2">Cancel</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </div> 
  </fieldset>
</form>  
</div>

<!-- ====================================================================== -->

        <!-- <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <h2>Contact Start Bootstrap</h2>
                <p>Feel free to email us to provide some feedback on our templates, give us suggestions for new templates and themes, or to just say hello!</p>
                <p>feedback@startbootstrap.com</p>
                <ul class="list-inline banner-social-buttons">
                    <li><a href="https://twitter.com/SBootstrap" class="btn btn-default btn-lg"><i class="fa fa-twitter fa-fw"></i> <span class="network-name">Twitter</span></a>
                    </li>
                    <li><a href="https://github.com/IronSummitMedia/startbootstrap" class="btn btn-default btn-lg"><i class="fa fa-github fa-fw"></i> <span class="network-name">Github</span></a>
                    </li>
                    <li><a href="https://plus.google.com/+Startbootstrap/posts" class="btn btn-default btn-lg"><i class="fa fa-google-plus fa-fw"></i> <span class="network-name">Google+</span></a>
                    </li>
                </ul>
            </div>
        </div> -->
    </section>

    <!-- <div id="map"></div> -->

    <!-- Core JavaScript Files -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

    <!-- Google Maps API Key - You will need to use your own API key to use the map feature -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCRngKslUGJTlibkQ3FkfTxj3Xss1UlZDA&sensor=false"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/grayscale.js"></script>

</body>

</html>
