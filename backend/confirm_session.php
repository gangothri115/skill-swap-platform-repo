<?php
include("config.php");

$session_id = $_POST['session_id'];
$user_id = $_POST['user_id'];

$session = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT * FROM sessions WHERE id='$session_id'"));

if($session['teacher_id'] == $user_id){

mysqli_query($conn,
"UPDATE sessions SET teacher_confirm=1
WHERE id='$session_id'");

}

if($session['learner_id'] == $user_id){

mysqli_query($conn,
"UPDATE sessions SET learner_confirm=1
WHERE id='$session_id'");

}

echo "Confirmation saved.";
?>