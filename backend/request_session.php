<?php
include("config.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){

$teacher_id = $_POST['teacher_id'];
$learner_id = $_POST['learner_id'];
$skill_name = $_POST['skill_name'];

/* Insert request into sessions table */

$sql = "INSERT INTO sessions
(teacher_id, learner_id, skill_name, status, teacher_confirm, learner_confirm)
VALUES ('$teacher_id','$learner_id','$skill_name','pending',0,0)";

$result = mysqli_query($conn,$sql);

if($result){

/* Create notification for teacher */

$message = "You received a skill swap request for $skill_name";

mysqli_query($conn,
"INSERT INTO notifications(user_id,message)
VALUES('$teacher_id','$message')");

echo "Skill Swap Request Sent Successfully! 🎉";

}else{

echo "Error sending request.";

}

}
?>