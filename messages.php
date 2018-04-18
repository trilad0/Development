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

#message{
    width:60%;
    background-color:#5391f6;
    border-radius:8px;
    color:white;
    display:inline-block;
}
#message:hover{
    background-color:#3d6fc1;
    margin:2%;
}
#buttons {
    -webkit-transition-duration: 0.4s;
    transition-duration: 0.4s;
    width:40%;
    margin-left:7%;
    margin-bottom:10%;
    padding:10%;
    border-radius: 8px;
    background-color: #5391f6;
    border:0px;
    opacity: 0.5;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}

#buttons2 {
    -webkit-transition-duration: 0.4s;
    transition-duration: 0.4s;
    width:100%;
    padding:5%;
    border-radius: 8px;
    background-color: #5391f6;
    border:0px;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}

#buttons:hover {
    background-color: #3d6fc1; 
    color: white;
    opacity: 1;
}
#buttons2:hover {
    background-color: #3d6fc1; 
    color: white;
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
		<div class="col-md-5">
    <?php
    include_once 'db_connection.php';
session_start();
if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}

$trilado_username = $_SESSION['userid'];

echo "<h1 align='center'>Recent Conversations</h1> <br><br>";
//$friendswithconvos = " SELECT DISTINCT RecipientID FROM messages WHERE senderID = ".$_SESSION['userid'];
//$friends = $pdo->query($friendswithconvos);
$friendswithconvos2 = " SELECT DISTINCT senderID FROM messages WHERE RecipientID = ".$_SESSION['userid'];
$friends2 = $pdo->query($friendswithconvos2);
while ($row = $friends2->fetch()){
    $results = $pdo->query("SELECT Username FROM users WHERE ID = ".$row['senderID']);
    $row2 = $results->fetch();
    $results = $pdo->query("SELECT Messagetext,ID,RecipientID,senderID status FROM messages WHERE senderID = ".$row['senderID']." OR RecipientID = ".$row['senderID']." ORDER BY ID DESC");
    $row3 = $results->fetch();
    echo "<form action = personalmessage.php method = post>";
    echo "<button id='buttons2'";
    echo " name='userID'  value='".$row['senderID']."' type='submit'> <b><h1>".strtoupper($row2['Username'])."</b></h1><br>";
    if ($row3['status'] == 'unread' && $row3['RecipientID'] == $_SESSION['userid'] )
    echo "<font color='red'>(NEW MESSAGE)  </font>";
    echo $row3['Messagetext']." </button>";
    echo "</form> <br><br>";
    }

?>
		</div>
		<div class="col-md-1">
    </div>
    <div class="col-md-4" id="col-md-4-panel">
      <?php
echo "<h1 align='center'> Friends <br></h1>";

$results = $pdo->query("SELECT Username,ID FROM users");
echo "<form action = personalmessage.php method = post>";
$row = $results->fetchAll();
foreach ($row as &$value) {
echo "<button id='buttons' name='userID'  value='".$value['ID']."' type='submit'> <h1>".strtoupper($value['Username'])."</h1></button>";
}
echo "</form> <br><br>";


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
