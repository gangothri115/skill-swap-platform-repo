<?php
include("config.php");

$current_user_id = $_GET['user_id'];

/* Get current user skills */
$current = mysqli_fetch_assoc(
    mysqli_query($conn,
    "SELECT * FROM skills WHERE user_id='$current_user_id'")
);

$myOffer = strtolower($current['skill_offer']);
$myWant  = strtolower($current['skill_want']);

/* Find matches */
$matches = mysqli_query($conn,
"SELECT users.id, users.name, skills.skill_offer, skills.skill_want
 FROM skills
 JOIN users ON users.id = skills.user_id
 WHERE LOWER(skills.skill_offer) = '$myWant'
 AND LOWER(skills.skill_want) = '$myOffer'
 AND skills.user_id != '$current_user_id'
");

echo "<h2>Your Matches</h2>";

if(mysqli_num_rows($matches) > 0){

    while($row = mysqli_fetch_assoc($matches)){
        echo "<hr>";
        echo "Name: ".$row['name']."<br>";
        echo "Offers: ".$row['skill_offer']."<br>";
        echo "Wants: ".$row['skill_want']."<br>";
    }

}else{
    echo "No Matches Found";
}
?>