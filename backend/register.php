<?php
include "config.php";

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$skill_offer = $_POST['skill_offer'];
$skill_want = $_POST['skill_want'];


// insert into users
$sql1 = "INSERT INTO users (name, email,password)
         VALUES ('$name', '$email','$password')";

mysqli_query($conn, $sql1);


// get user id
$user_id = mysqli_insert_id($conn);


// insert into skills table
$sql2 = "INSERT INTO skills (user_id, skill_offer, skill_want)
         VALUES ('$user_id', '$skill_offer', '$skill_want')";

mysqli_query($conn, $sql2);


header("Location: ../dashboard.php?user_id=$user_id");

?>