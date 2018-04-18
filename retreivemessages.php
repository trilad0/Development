
<?php

//all needs updating once in the correct environment.
include_once 'db_connection.php';   
session_start();
$trilado_username = $_SESSION['userid'];

$query = "SELECT messagetext, date, status FROM messages WHERE SenderID = '".$_POST['to']. "' AND RecipientID = '".$_POST['from']."' AND status = 'unread'";
$result = $pdo->query($query);
while ($row = $result->fetch()){
    echo "<div id='messagesfrom'>".$row["messagetext"]." </div> </p> <br>";
}


$query = "UPDATE messages SET status = 'read' WHERE SenderID = '".$_POST['to']."' AND RecipientID = '".$_POST['from']."'";
$pdo->exec($query);


?>