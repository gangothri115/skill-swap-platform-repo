<?php
include("config.php");

$notification_id = $_POST['notification_id'];

mysqli_query($conn,
"DELETE FROM notifications WHERE id='$notification_id'");
?>