<?php
include("config.php");

$session_id = $_POST['session_id'];
$action = $_POST['action'];

// ✅ Get session details
$result = mysqli_query($conn,
"SELECT * FROM sessions WHERE id='$session_id'");

$row = mysqli_fetch_assoc($result);

$learner_id = $row['learner_id'];
$teacher_id = $row['teacher_id'];


// ================= ACCEPT =================
if($action == "accept"){

    // ✅ Update session
    mysqli_query($conn,
    "UPDATE sessions 
     SET status='accepted' 
     WHERE id='$session_id'");

    // 🔥 DELETE notification (handles BOTH cases)
    mysqli_query($conn,
    "DELETE FROM notifications 
     WHERE session_id='$session_id' 
     OR (user_id='$teacher_id' 
     AND message LIKE '%skill swap request%')");

    // ✅ Create new notification for learner
    $message = "Your learning session has started. Click to open chat.";

    mysqli_query($conn,
    "INSERT INTO notifications(user_id, message, session_id, status)
     VALUES('$learner_id', '$message', '$session_id', 'unread')");

    // ✅ Redirect
    echo "<script>
    alert('Request Accepted ✔');
    window.location='../chat.php?session_id=$session_id';
    </script>";
}


// ================= REJECT =================
else{

    // ✅ Update session
    mysqli_query($conn,
    "UPDATE sessions 
     SET status='rejected' 
     WHERE id='$session_id'");

    // 🔥 DELETE notification (handles BOTH cases)
    mysqli_query($conn,
    "DELETE FROM notifications 
     WHERE session_id='$session_id' 
     OR (user_id='$teacher_id' 
     AND message LIKE '%skill swap request%')");

    // ✅ Redirect
    echo "<script>
    alert('Request Rejected ❌');
    window.location='../dashboard.php?user_id=$teacher_id';
    </script>";
}
?>