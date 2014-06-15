<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Music Collaborator</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
      <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script> 




  <script>
      
    $(document).ready(function(){
 
    $.ajax({
        url: 'scripts/pull_project_data.php',
        type: 'GET',
        dataType: 'json',
        data: {idproject: '6'},
        success: function(response) {
          console.log(response); 
          for (var i in response) {
            $('#print').append($("<p>" + response[i].description + " " + response[i].name + "</p>"));
            for (var a in response[i][0]) {
              $('#print').append($("<p>" + response[i][0][a].extension + " " + response[i][0][a].name + " " + response[i][0][a].path + " " + response[i][0][a].username + "</p>"));
            }
          }    
        },
        error: function(xhr,err){
                alert("readyState: "+xhr.readyState+"\nstatus: "+xhr.status);
                alert("responseText: "+xhr.responseText);
              }
      });


    });
  </script>

  </head>

  

  <body>

  

    <h1>TESTING PROJECT</h1>

    <div id="print"></div>
  </body>
</html>
