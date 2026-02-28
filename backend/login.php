<?php
session_start();
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {

        $user = $result->fetch_assoc();

        if(password_verify($password, $user['password'])){

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];

            header("Location: ../frontend/dashboard.php");

        } else {
            echo "Invalid password";
        }

    } else {
        echo "User not found";
    }
}
?>