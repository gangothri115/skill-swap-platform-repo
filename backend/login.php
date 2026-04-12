<?php
session_start();
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

$email = trim($_POST['email']);
$password = trim($_POST['password']);

$sql = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {

$user = $result->fetch_assoc();

if($password == $user['password']){

$_SESSION['user_id'] = $user['id'];
$_SESSION['name'] = $user['name'];

header("Location: ../dashboard.php?user_id=".$user['id']);

} else {

echo "Invalid password";

}

} else {

echo "User not found";

}

}
?>