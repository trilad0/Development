
<?php

//all needs updating once in the correct environment. 
include_once 'db_connection.php';  
session_start();
$trilado_username = $_SESSION['userid'];
$a=date("Y-m-d H:i:s");
$query = "INSERT INTO messages(senderID,recipientID,messagetext,status,date)
VALUES ('".$_POST['from']."','".$_POST['to']."','".$_POST['messagetext']."','unread','".$a."')";
if ($pdo->exec($query))
{
}
else
{
  echo "an error occurred please resend your message";
}



?>