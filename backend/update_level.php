<?php
function updateLevel($user_id, $conn){

    $result = mysqli_fetch_assoc(
        mysqli_query($conn,"SELECT credits FROM users WHERE id='$user_id'")
    );

    $credits = $result['credits'];

    if($credits >= 20){
        $level = "Expert";
    }
    elseif($credits >= 10){
        $level = "Contributor";
    }
    elseif($credits >= 5){
        $level = "Active Learner";
    }
    else{
        $level = "Beginner";
    }

    mysqli_query($conn,
        "UPDATE users SET level='$level' WHERE id='$user_id'");
}
?>