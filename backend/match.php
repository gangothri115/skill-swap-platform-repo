<?php
include "config.php";

$user_id = $_GET['user_id'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Skill Matches</title>

<style>

body{
font-family:'Segoe UI',sans-serif;
background:linear-gradient(135deg,#1d2671,#c33764);
margin:0;
padding:40px;
}

.container{
width:700px;
margin:auto;
}

h2{
text-align:center;
color:white;
margin-bottom:40px;
letter-spacing:1px;
}

.card{
display:flex;
align-items:center;
background:white;
padding:20px;
border-radius:12px;
box-shadow:0 10px 25px rgba(0,0,0,0.3);
margin-bottom:20px;
transition:0.3s;
}

.card:hover{
transform:translateY(-5px);
box-shadow:0 15px 35px rgba(0,0,0,0.4);
}

.avatar{
width:55px;
height:55px;
border-radius:50%;
background:#4e73df;
color:white;
display:flex;
align-items:center;
justify-content:center;
font-size:20px;
font-weight:bold;
margin-right:20px;
}

.info{
flex:1;
}

.info h3{
margin:0;
color:#333;
}

.info p{
margin:4px 0;
color:#444;
}

.btn{
background:#007bff;
color:white;
padding:8px 15px;
border:none;
border-radius:6px;
cursor:pointer;
margin-top:8px;
}

.btn:hover{
background:#0056b3;
}

</style>

</head>

<body>

<div class="container">

<h2>🎯 Your Skill Matches</h2>

<?php

// get current user skills
$sql = "SELECT skill_offer, skill_want FROM skills WHERE user_id='$user_id'";
$result = mysqli_query($conn,$sql);
$current = mysqli_fetch_assoc($result);

$my_offer = explode(",", strtolower($current['skill_offer']));
$my_want  = explode(",", strtolower($current['skill_want']));


// get all other users
$sql2 = "
SELECT users.id, users.name, users.email,
skills.skill_offer, skills.skill_want
FROM users
JOIN skills ON users.id = skills.user_id
WHERE users.id != '$user_id'
";

$result2 = mysqli_query($conn,$sql2);

$found = false;

while($row = mysqli_fetch_assoc($result2))
{

$offer = explode(",", strtolower($row['skill_offer']));
$want  = explode(",", strtolower($row['skill_want']));

$match = false;

// match logic
foreach($my_offer as $o)
{
    if(in_array(trim($o), $want))
    {
        $match = true;
    }
}

foreach($my_want as $w)
{
    if(in_array(trim($w), $offer))
    {
        $match = true;
    }
}


if($match)
{
$found = true;

echo "<div class='card'>";

echo "<div class='avatar'>".strtoupper(substr($row['name'],0,1))."</div>";

echo "<div class='info'>";

echo "<h3>".$row['name']."</h3>";

echo "<p>📧 ".$row['email']."</p>";

echo "<p>💡 Offers: <b>".$row['skill_offer']."</b></p>";

echo "<p>🎯 Wants: <b>".$row['skill_want']."</b></p>";

?>

<form action="request_session.php" method="POST">

<input type="hidden" name="teacher_id" value="<?php echo $row['id']; ?>">

<input type="hidden" name="learner_id" value="<?php echo $user_id; ?>">

<input type="hidden" name="skill_name" value="<?php echo $row['skill_offer']; ?>">

<button class="btn">Request Skill Swap</button>

</form>

<?php

echo "</div>";

echo "</div>";

}

}

if(!$found)
{
echo "<div class='card'>";
echo "<p>No skill matches found 😔</p>";
echo "</div>";
}

?>

</div>

</body>
</html>