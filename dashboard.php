<?php
include "backend/config.php";

if(!isset($_GET['user_id'])){
    echo "User not found";
    exit();
}

$user_id = $_GET['user_id'];

$sql = "SELECT * FROM users WHERE id='$user_id'";
$result = mysqli_query($conn,$sql);
$user = mysqli_fetch_assoc($result);

$sql2 = "SELECT * FROM skills WHERE user_id='$user_id'";
$result2 = mysqli_query($conn,$sql2);
$skill = mysqli_fetch_assoc($result2);
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>

<style>

body{
margin:0;
font-family:'Segoe UI',sans-serif;
background:linear-gradient(135deg,#1d2671,#c33764);
min-height:100vh;
display:flex;
justify-content:center;
align-items:center;
}

/* Main Card */

.box{
width:520px;
background:white;
padding:35px;
border-radius:15px;
box-shadow:0 20px 50px rgba(0,0,0,0.4);
transition:0.3s;
}

.box:hover{
transform:translateY(-4px);
}

/* Header */

.header{
display:flex;
align-items:center;
margin-bottom:20px;
}

.avatar{
width:60px;
height:60px;
border-radius:50%;
background:#4e73df;
color:white;
display:flex;
align-items:center;
justify-content:center;
font-size:24px;
font-weight:bold;
margin-right:15px;
}

/* Notifications */

.notification{
background:#fff3cd;
padding:12px;
border-radius:6px;
margin-bottom:10px;
border-left:6px solid orange;
animation:fadeIn 0.5s ease;
}

@keyframes fadeIn{
from{opacity:0; transform:translateY(-10px);}
to{opacity:1; transform:translateY(0);}
}

/* Stats */

.stats{
display:grid;
grid-template-columns:1fr 1fr;
gap:10px;
margin:15px 0;
}

.stat{
background:#f4f7fb;
padding:10px;
border-radius:8px;
font-size:14px;
}

/* Button */

.btn{
display:inline-block;
background:#007bff;
color:white;
padding:10px 22px;
border-radius:6px;
text-decoration:none;
margin-top:15px;
transition:0.2s;
}

.btn:hover{
background:#0056b3;
transform:scale(1.05);
}
.notification button{
color:red;
font-weight:bold;
}

.notification{
display:flex;
justify-content:space-between;
align-items:center;
}
.notification{
transition: all 0.5s ease;
}
</style>
<script>
function deleteNotification(id){

    // fade out animation
    let element = document.getElementById("notif_" + id);
    element.style.transition = "0.5s";
    element.style.opacity = "0";

    setTimeout(() => {
        element.remove();
    }, 500);

    // send request to backend (AJAX)
    fetch("backend/delete_notification.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "notification_id=" + id
    });

}
</script>
</head>

<body>

<div class="box">

<div class="header">

<div class="avatar">
<?php echo strtoupper(substr($user['name'],0,1)); ?>
</div>

<h2>Welcome <?php echo $user['name']; ?></h2>

</div>


<!-- Notifications -->

<h3>🔔 Notifications</h3>

<?php

$sql3 = "SELECT * FROM notifications 
WHERE user_id='$user_id' AND status='unread'";

$result3 = mysqli_query($conn,$sql3);

if(mysqli_num_rows($result3) > 0){

while($row=mysqli_fetch_assoc($result3)){

echo "<div class='notification' id='notif_".$row['id']."'>";

echo "<span>".$row['message']."</span>";

echo "<br><a href='backend/view_requests.php?user_id=$user_id'>View Request</a>";

// ❌ button with JS
echo "<button onclick='deleteNotification(".$row['id'].")' 
style='border:none; background:none; font-size:18px; cursor:pointer; float:right;'>❌</button>";

echo "</div>";

}
}else{

echo "<p>No new notifications</p>";

}

?>


<!-- User Info -->

<div class="stats">

<div class="stat">
📧 Email<br>
<b><?php echo $user['email']; ?></b>
</div>

<div class="stat">
💰 Credits<br>
<b><?php echo $user['credits']; ?></b>
</div>

<div class="stat">
🏅 Badge<br>
<b>
<?php
if($user['credits'] >= 100){
echo "Gold";
}
elseif($user['credits'] >= 50){
echo "Silver";
}
else{
echo "Beginner";
}
?>
</b>
</div>

<div class="stat">
💡 Skill Offer<br>
<b><?php echo $skill['skill_offer']; ?></b>
</div>

<div class="stat">
🎯 Skill Want<br>
<b><?php echo $skill['skill_want']; ?></b>
</div>

</div>


<a class="btn" href="backend/match.php?user_id=<?php echo $user_id; ?>">
Find Match
</a>

</div>

</body>
</html>