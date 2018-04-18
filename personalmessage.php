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

#main{
    width:70%;
    background-color:white;
    margin-left:15%;
    border: 2px solid #dedede;
    background-color: white;
    border-radius: 5px;
    border:0px;
    overflow: scroll;
    max-height:20%;
    overflow-x:hidden;
}
#messagesto{
    margin-left:60%;
    max-width:20%;
    height:20%;
    background-color:#3d6fc1;
    border-radius:12px;
    color:white;
    padding:2%;
    text-align:right;
   
}
#messagesfrom{
    max-width:30%;
    height:20%;
    margin-left:20%;
    background-color:#5391f6;
    border-radius:12px;
    color:white;
    padding:2%;
    margin-right:2%;
}
#message{
  margin-left:15%;
}


.textarea{
    background-color:white;
    width:70%;
    margin-left:15%;
    height:10%;
    background:transparent;
}
.button {
    background-color: #3d6fc1;
    border: none;
    color: white;
    text-align: center;
    text-decoration: none;
    font-size: 16px;
    cursor: pointer;
    height:10%;
    margin-left:15%;
    width:70%;
}
.button:hover{
    background-color: #5391f6;
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
    include_once 'db_connection.php';
session_start();
$writemessageto = $_POST['userID'];
$query = "SELECT username from users where id = $writemessageto";
$result = $pdo->query($query);
$row2 = $result->fetch();
echo "<span><h1 align='center'>Conversation with: ".$row2['username']."</h1></span><br> <br> ";
$trilado_username = $_SESSION['userid'];

$convowith = $writemessageto;

$query = "UPDATE messages SET status = 'read' WHERE senderID = '$convowith' AND recipientID = '$trilado_username'";
$pdo->exec($query);

//print each message showing who from, message and date.
$query = "SELECT senderID, recipientID, messagetext, date,status FROM messages WHERE senderID = '$trilado_username' AND recipientID = '$convowith'
OR senderID = '$convowith' AND recipientID = '$trilado_username'";
$result = $pdo->query($query);
echo "<div id='main'>";
while ($row = $result->fetch()){
    if ($row["senderID"] == $convowith) {
        echo "<div id='right'>";
        echo "<div id='messagesto'>";
        echo $row["messagetext"]."<br>";
        echo "</div>";
        echo "</div>";
        echo "</p>";
    }
    else {
        echo '<p style="text-align: left">';
        echo "<div id='messagesfrom'>";
        echo $row["messagetext"]."<br>";
        echo "</div>";
        echo "</p>";
    }

    
    
    
}
echo "</div>";

?>
<br>
<textarea class = "textarea" rows="8" cols="50" id = "message" placeholder="Type your message here">
</textarea>
<br>
<button type="button" onclick = "myfunc()" class = "button">Send</button>

<script>
//function to pass message to sendmessage.php which adds it to database.Then reset the page or do some ajax shit
//to get newest messages.
var elem = document.getElementById('main');
  elem.scrollTop = elem.scrollHeight;

window.setInterval(function(){
    $.ajax({
    type: 'POST',
    url: 'retreivemessages.php',
    data: { from: "<?php echo $trilado_username ?>", to: "<?php echo $convowith ?>"},
    success: function(response) {
        if (response)
       document.getElementById("main").innerHTML +=  response ;
    }
    
});
}, 60);


function myfunc(){
    console.log('<?php echo $convowith. $trilado_username ?>');
    $.ajax({
    type: 'POST',
    url: 'sendmessage.php',
    data: { from: "<?php echo $trilado_username ?>", to: "<?php echo $convowith ?>",messagetext: document.getElementById("message").value},
    success: function(response) {
		document.getElementById("main").innerHTML += '<p align="left">';
        document.getElementById("main").innerHTML += "<div id='messagesfrom'>" + document.getElementById("message").value + "</div> </p>";
    }
});

}

</script>
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
