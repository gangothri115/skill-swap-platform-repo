<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $skill_offer = $_POST['skill_offer'];
    $skill_want = $_POST['skill_want'];

    if(empty($name) || empty($email) || empty($_POST['password'])){
        echo "All fields required";
        exit();
    }

    $sql = "INSERT INTO users (name, email, password, skill_offer, skill_want)
            VALUES ('$name', '$email', '$password', '$skill_offer', '$skill_want')";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>