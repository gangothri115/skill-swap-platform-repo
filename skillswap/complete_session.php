<?php
include("config.php");
include("update_level.php");

/* Values from form */
$teacher_id = $_POST['teacher_id'];
$learner_id = $_POST['learner_id'];
$skill_name = $_POST['skill_name'];

/* 1️⃣ Insert session */
mysqli_query($conn,"INSERT INTO sessions
(teacher_id, learner_id, skill_name, status)
VALUES ('$teacher_id','$learner_id','$skill_name','completed')");

/* 2️⃣ Credit System */
mysqli_query($conn,
"UPDATE users SET credits = credits + 2 WHERE id='$teacher_id'");

mysqli_query($conn,
"UPDATE users SET credits = credits + 1 WHERE id='$learner_id'");

/* 3️⃣ Increase completed skills for learner */
mysqli_query($conn,
"UPDATE users SET completed_skills = completed_skills + 1
WHERE id='$learner_id'");

/* 4️⃣ Generate Certificate */
mysqli_query($conn,
"INSERT INTO certificates (user_id, skill_name, issue_date)
VALUES ('$learner_id','$skill_name',CURDATE())");

/* 5️⃣ Badge Logic */
$user = mysqli_fetch_assoc(
mysqli_query($conn,
"SELECT completed_skills FROM users WHERE id='$learner_id'")
);

if($user['completed_skills'] >= 3){
    mysqli_query($conn,
    "UPDATE users SET badge='Skill Explorer'
     WHERE id='$learner_id'");
}

/* 6️⃣ Update Levels */
updateLevel($teacher_id,$conn);
updateLevel($learner_id,$conn);

echo "Session Completed Successfully!";
?>