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
<html > 
<head>
	<meta charset="utf-8">
  	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

  	<script type="text/javascript" src="js/jquery.fileuploadmulti.min.js"></script>

  	<script> 
	$(document).ready(function(){

		var user = '<?php echo $user['username'];?>';

		var settings = {
        url: "scripts/sectionmusic.php",
        method: "POST",
        allowedTypes:"mp3",
        fileName: "myfile",
        multiple: true,

         formData: {
		   "username": user,  
         	"name": 'Melody', 
         	"idproject":'1'

           },

          onSuccess:function(files,data,xhr) {

            $("#status").html("<font color='green'>Upload is success</font>");

          },

          afterUploadAll:function() {
            //alert("all images uploaded!!");
          },
          onError: function(files,status,errMsg){   
            $("#status").html("<font color='red'>Upload is Failed</font>");
          }
        }

        $("#mulitplefileuploader").uploadFile(settings);


	});

</script>


</head>

<body>
	<div id="mulitplefileuploader">Upload</div>

</body>

</html>