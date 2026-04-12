<?php

include "config.php";

$user_id = $_GET['user_id'];

$sql = "SELECT * FROM skills WHERE user_id='$user_id'";
$result = mysqli_query($conn,$sql);
$current = mysqli_fetch_assoc($result);

$myOffer = explode(",",$current['skill_offer']);
$myWant = explode(",",$current['skill_want']);

?>

<!DOCTYPE html>
<html>
<head>

<style>

body{
background:#f4f7fb;
font-family:Arial;
}

.card{

background:white;
padding:20px;
margin:20px auto;
width:500px;
border-radius:10px;
box-shadow:0 0 10px gray;

}

</style>

</head>

<body>

<h2 align=center>Your Matches</h2>

<?php

$sql2 = "
SELECT users.name,skills.skill_offer,skills.skill_want
FROM users
JOIN skills ON users.id=skills.user_id
WHERE users.id!='$user_id'
";

$result2 = mysqli_query($conn,$sql2);

$found=false;

while($row=mysqli_fetch_assoc($result2)){

$offer = explode(",",$row['skill_offer']);
$want = explode(",",$row['skill_want']);

$match=false;

foreach($myWant as $w){

if(in_array(trim($w),$offer)){

$match=true;

}

}

foreach($myOffer as $o){

if(in_array(trim($o),$want)){

$match=true;

}

}

if($match){

$found=true;

echo "

<div class='card'>

<h3>".$row['name']."</h3>

Offers: ".$row['skill_offer']."<br>

Wants: ".$row['skill_want']."<br>

</div>

";

}

}

if(!$found){

echo "<div class='card'>No matches found</div>";

}

?>

</body>
</html>