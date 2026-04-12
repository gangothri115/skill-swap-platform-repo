<?php
include("config.php");
include("update_level.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){

$teacher_id = $_POST['teacher_id'];
$learner_id = $_POST['learner_id'];
$skill_name = $_POST['skill_name'];

/* Get session */

$session = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT * FROM sessions
WHERE teacher_id='$teacher_id'
AND learner_id='$learner_id'
AND skill_name='$skill_name'"
));

if(!$session){
echo "Session not found";
exit();
}

/* Update session status */

mysqli_query($conn,
"UPDATE sessions
SET status='completed'
WHERE id='".$session['id']."'"
);

/* Credit system */

mysqli_query($conn,
"UPDATE users
SET credits = credits + 2
WHERE id='$teacher_id'"
);

mysqli_query($conn,
"UPDATE users
SET credits = credits + 1
WHERE id='$learner_id'"
);

/* Increase completed skills */

mysqli_query($conn,
"UPDATE users
SET completed_skills = completed_skills + 1
WHERE id='$learner_id'"
);

/* Generate certificate */

mysqli_query($conn,
"INSERT INTO certificates (user_id, skill_name, issue_date)
VALUES ('$learner_id','$skill_name',CURDATE())"
);

$cert_id = mysqli_insert_id($conn);

/* Badge logic */

$result = mysqli_query($conn,
"SELECT completed_skills FROM users WHERE id='$learner_id'"
);

$user = mysqli_fetch_assoc($result);

if($user['completed_skills'] >= 3){

mysqli_query($conn,
"UPDATE users
SET badge='Skill Explorer'
WHERE id='$learner_id'"
);

}

/* Update level */

updateLevel($teacher_id,$conn);
updateLevel($learner_id,$conn);

/* Redirect to certificate */

echo "<script>
alert('Session Completed Successfully 🎉');
window.location='../certificate.php?cert_id=$cert_id';
</script>";

}
?>