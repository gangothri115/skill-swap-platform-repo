<?php
include "config.php";

$session_id = $_POST['session_id'];
$sender_id = $_POST['sender_id'];
$message = $_POST['message'];

$sql = "INSERT INTO messages (session_id, sender_id, message)
VALUES ('$session_id','$sender_id','$message')";

mysqli_query($conn,$sql);

header("Location: ../chat.php?session_id=$session_id");
?>