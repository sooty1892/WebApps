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
  	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
  	<script>
  		var last = 0;

  		$(document).ready(function() {
  			setInterval(function() {
  				getMessages();
  			}, 1000);

			$('#sendie').keyup(function(e) {
				if (e.keyCode == 13) {
					sendMessage($('#sendie').val());
					//$('#chat-area').append($("<p>" + $('#sendie').val() + "</p>"));
					$('#sendie').val('');
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
						$('#chat-area').append($("</p>" + response[i].message + "</p>"));
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
    
        <h2>LIMITED TO 100 CHARACTERS ATM</h2>
        
        <div id="chat-wrap">
        	<div id="chat-area">
        	</div>
        </div>
        
        <form id="send-message-area">
            <p>Your message: </p>
            <textarea id="sendie" maxlength='100'></textarea>
        </form>
    
    </div>
  </body>
</html>