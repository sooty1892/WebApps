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
    <title>Music Collaborator</title>
    <link rel="stylesheet" href="css/jquery.simplecolorpicker.css">
    <link href="css/player.css" rel="stylesheet">
    <link href="css/jquery.simplecolorpicker.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/lightbox.css" rel="stylesheet">
    <link href="css/project_styles.css" rel="stylesheet">
    <link href="css/chat.css" rel="stylesheet">
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
						$('#chat-area').append($("<p>" +"<span>" + response[i].username + "</span>" + "\n" + response[i].message + "</p>"));
						if (response[i].idmessage > last) {
							last = response[i].idmessage;
						}
					}			  
				}
			});
		}
  	</script>

  </head>
  <body>
  	<div id="page-wrap">
    
        
        <div id="chat-wrap">
        	<div id="chat-area">
        	</div>
        </div>
        
        <form id="send-message-area">
            <!-- <p>Your message: </p> -->
            <textarea id="sendie" maxlength='100'></textarea>
        </form>
    
    </div>
  </body>
</html>
