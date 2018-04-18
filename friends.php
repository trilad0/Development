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

#buttons {
  -webkit-transition-duration: 0.4s;
    transition-duration: 0.4s;
    width:100%;
    border-radius: 8px;
    background-color: #5391f6;
    border:0px;
    opacity: 0.9;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}

#buttons:hover {
    background-color: #3d6fc1;
    color: white;
    opacity:1;
}
.col-md-10 {
  padding:0;
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
            <div class="col-md-4" id = "clear" >             
            </div>         
            <div class="col-md-4" id = "clear" >
            <p style="text-align:center;">
            <img src="logo.png" alt="Trilado" style="width:300px;height:110px;">
            </p>
                <form action = search.php method = post>
                <p style="text-align:center;">
                    <input type="text2" name="search" placeholder="Search..">
                    </p>
                  </form>                 
            </div>
            <div class="col-md-4" id = "clear" >
            <p style="text-align:right;">
                <a href="friends.php" style = "color:white">FRIENDS  </a>
                |
                 <a href="messages.php" style = "color:white">  MESSAGES</a>
                 |
                 <a href="logout.php" style = "color:white">  LOG OUT   </a>
                 <img src="head.png" alt="profile"style="width:50px;height:50px;">
                 </p>
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
session_start();
		if (!isset($_SESSION['userid'])) {
      $_SESSION['msg'] = "You must log in first";
			header('location: index.php');
	}
include_once 'db_connection.php';
echo "<h1 align='center'> Friends </h1>";
$trilado_username = $_SESSION['userid'];
$query = "SELECT * FROM Friend WHERE RecipientID = '$trilado_username' OR SenderID = '$trilado_username'";
$result = $pdo->query($query);

while ($row = $result->fetch()) {
if ($row['RecipientID'] == $trilado_username){
  $query = "SELECT username ,id FROM users WHERE ID = ".$row['SenderID'];
  $results = $pdo->query($query);
  echo "<form action = user.php method = post>";
  while ($row2 = $results->fetch()){
echo "<button id='buttons' name='userid'  value='".$row2['id']."' type='submit'> <h1>".$row2['username']."</h1></button>";
  }
  echo "</form> ";
}

if ($row['senderID'] == $trilado_username){
  $query2 = "SELECT username ,id FROM users WHERE ID = ".$row['RecipientID'];
  $results2 = $pdo->query($query2);
  echo "<form action = user.php method = post>";
  while ($row3 = $results2->fetch()){
echo "<button id='buttons' name='userid'  value='".$row3['id']."' type='submit'> <h1>".$row3['username']."</h1></button>";
  }
  echo "</form> ";
}

}

?>
		</div>
		<div class="col-md-1">
		</div>
	</div>
</div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/scripts.js"></script>
  </body>
</html>
