<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>trilado</title>


    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style2.css" rel="stylesheet">

  </head>
  <body>
<?php 
?>
  <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-4" id = "clear">
                <img src="logo.png" alt="Trilado" style="width:200px;height:75px;">
            </div>
            <div class="col-md-4" id = "clear">
                <form action = search.php method = post>
                    <input type="text2" name="search" placeholder="Search..">
                  </form>
            </div>
            <div class="col-md-4" id = "clear">
                <a href="friends.php" style = "color:white">FRIENDS  </a> 
                |
                 <a href="messages.php" style = "color:white">  MESSAGES</a> 
            </div>
          </div>
        </div>
      </div>
    </div>

	<div class="row">
		<div class="col-md-1">
      
		</div>
		<div class="col-md-10">
    <?php
     include_once 'db_connection.php';
     include_once 'updatespopulater.php';

   
?>
<button type="button", id= "sendMessage"onclick = "myfunc()" button class="button">Send</button> 
		</div>
		<div class="col-md-1">
		</div>
	</div>
</div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/scripts.js"></script>
    <script>

    function myfunc(){
    console.log('adding');
    $.ajax({  
    type: 'POST',  
    url: 'Updatespopulater.php', 
    data: { update: "true"},
    success: function(response) {
        console.log('done');
    }
});

}


    </script>
  </body>
</html>