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
<style>
input[type=text2]{
  width:100%;
}
</style>
  </head>
  <body>
<?php
?>
  <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-4" id = "clear">

            </div>
            <div class="col-md-4" id = "clear">
              <img src="logo.png" alt="Trilado" style="width:400px;height:150px;">
            </div>
            <div class="col-md-4" id = "clear">
            </div>
          </div>
        </div>
      </div>
    </div>

	<div class="row">

		<?php

	include_once 'db_connection.php';
		session_start();
		if (isset($_SESSION['userid'])) {
      $_SESSION['msg'] = "You must log in first";
			header('location: homepage.php');
	} 

?>
<div class="col-md-4" id ="clear">
</div>
		<div class="col-md-4" id ="clear">
      <form action = search.php method = post>
          <input type="text2" name="search" placeholder="Search..">
        </form>
    </div>
    <div class="col-md-4" id ="clear">
    <a href="login.php" style = "color:white">LOG-IN  </a>
                |
                 <a href="register.php" style = "color:white">  SIGN-UP</a>
    </div>
  </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/scripts.js"></script>
  </body>
</html>
