<?php
include("config.php");

$user_id = $_GET['user_id'];

$sql = "
SELECT * FROM sessions
WHERE (teacher_id='$user_id' OR learner_id='$user_id')
AND status='accepted'
";

$result = mysqli_query($conn,$sql);

echo "<h2>Your Active Sessions</h2>";

while($row = mysqli_fetch_assoc($result)){

echo "<div>";

echo "Skill: ".$row['skill_name']."<br>";

?>

<form action="confirm_session.php" method="POST">

<input type="hidden" name="session_id"
value="<?php echo $row['id']; ?>">

<input type="hidden" name="user_id"
value="<?php echo $user_id; ?>">

<button>Confirm Learning Complete</button>

</form>

<?php

echo "</div>";

}
?>