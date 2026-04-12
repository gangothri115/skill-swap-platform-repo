<?php
include("config.php");

$user_id = $_GET['user_id'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Incoming Requests</title>

<style>

body{
font-family:'Segoe UI',sans-serif;
background:linear-gradient(135deg,#667eea,#764ba2);
margin:0;
padding:0;
min-height:100vh;
display:flex;
justify-content:center;
align-items:flex-start;
}

.container{
width:650px;
margin-top:60px;
}

h2{
text-align:center;
color:white;
margin-bottom:40px;
letter-spacing:1px;
}

.request-card{
background:white;
padding:25px;
margin-bottom:25px;
border-radius:12px;
box-shadow:0 10px 25px rgba(0,0,0,0.2);
transition:all 0.3s ease;
display:flex;
align-items:center;
justify-content:space-between;
}

.request-card:hover{
transform:translateY(-5px);
box-shadow:0 15px 35px rgba(0,0,0,0.3);
}

.user-info{
display:flex;
align-items:center;
}

.avatar{
width:50px;
height:50px;
border-radius:50%;
background:#4e73df;
color:white;
display:flex;
align-items:center;
justify-content:center;
font-size:20px;
font-weight:bold;
margin-right:15px;
}

.details h3{
margin:0;
color:#333;
}

.details p{
margin:3px 0;
color:#555;
font-size:14px;
}

button{
padding:8px 18px;
border:none;
border-radius:6px;
cursor:pointer;
font-size:14px;
margin-left:8px;
transition:0.2s;
}

.accept{
background:#28a745;
color:white;
}

.reject{
background:#dc3545;
color:white;
}

.accept:hover{
background:#218838;
transform:scale(1.05);
}

.reject:hover{
background:#c82333;
transform:scale(1.05);
}

</style>

</head>

<body>

<div class="container">

<h2>Incoming Skill Requests</h2>

<?php

$sql = "
SELECT sessions.*, users.name, users.email
FROM sessions
JOIN users ON sessions.learner_id = users.id
WHERE sessions.teacher_id='$user_id'
AND sessions.status='pending'
";

$result = mysqli_query($conn,$sql);

if(mysqli_num_rows($result) > 0){

while($row = mysqli_fetch_assoc($result)){

echo "<div class='request-card'>";

echo "<div class='user-info'>";

echo "<div class='avatar'>".strtoupper(substr($row['name'],0,1))."</div>";

echo "<div class='details'>";

echo "<h3>".$row['name']."</h3>";

echo "<p>📧 ".$row['email']."</p>";

echo "<p>📚 Wants to learn: <b>".$row['skill_name']."</b></p>";

echo "</div>";

echo "</div>";

?>

<form action="update_requests.php" method="POST">

<input type="hidden" name="session_id"
value="<?php echo $row['id']; ?>">

<button class="accept" name="action" value="accept">
Accept
</button>

<button class="reject" name="action" value="reject">
Reject
</button>

</form>

<?php

echo "</div>";

}

}else{

echo "<div class='request-card'>";
echo "<p>No incoming requests</p>";
echo "</div>";

}

?>

</div>

</body>
</html>