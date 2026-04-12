<?php
include "backend/config.php";

$session_id = $_GET['session_id'];
$user_id = 1; // temporary demo

/* Get session details */

$session = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT * FROM sessions WHERE id='$session_id'"
));

$teacher_id = $session['teacher_id'];
$learner_id = $session['learner_id'];
$skill_name = $session['skill_name'];

?>

<!DOCTYPE html>
<html>
<head>

<title>Skill Swap Live Learning Chat</title>

<!--<meta http-equiv="refresh" content="2">-->

<style>

body{
font-family:'Segoe UI',sans-serif;
background:linear-gradient(135deg,#4facfe,#00f2fe);
margin:0;
height:100vh;
display:flex;
justify-content:center;
align-items:center;
}

/* Chat container */

.chat-container{
width:450px;
height:550px;
background:white;
border-radius:12px;
box-shadow:0 15px 40px rgba(0,0,0,0.3);
display:flex;
flex-direction:column;
overflow:hidden;
}

/* Header */

.chat-header{
background:#075e54;
color:white;
padding:15px;
text-align:center;
font-weight:bold;
}

.chat-header small{
display:block;
font-size:12px;
color:#cfcfcf;
}

/* Call buttons */

.call-buttons{
margin-top:6px;
}

.call-buttons button{
background:#128C7E;
border:none;
color:white;
padding:5px 10px;
margin:2px;
border-radius:4px;
cursor:pointer;
}

.call-buttons button:hover{
background:#0f6f63;
}

/* Chat box */

.chat-box{
flex:1;
padding:15px;
overflow-y:auto;
background:#e5ddd5;
}

/* Messages */

.message{
max-width:70%;
padding:10px 12px;
margin:8px 0;
border-radius:10px;
font-size:14px;
}

.sent{
background:#dcf8c6;
margin-left:auto;
}

.received{
background:white;
}

/* Sender */

.sender{
font-size:11px;
color:#555;
margin-bottom:3px;
font-weight:bold;
}

/* Time */

.time{
font-size:10px;
color:gray;
margin-top:4px;
text-align:right;
}

/* Input */

.chat-input{
display:flex;
border-top:1px solid #ddd;
}

.chat-input input{
flex:1;
border:none;
padding:12px;
font-size:14px;
outline:none;
}

.chat-input button{
background:#25d366;
color:white;
border:none;
padding:12px 18px;
cursor:pointer;
font-weight:bold;
}

.chat-input button:hover{
background:#1ebc59;
}

/* Empty */

.empty{
text-align:center;
color:gray;
margin-top:120px;
}

/* Complete session button */

.complete-btn{
text-align:center;
padding:10px;
background:#f4f4f4;
}

.complete-btn button{
background:#ff9800;
color:white;
padding:10px 20px;
border:none;
border-radius:6px;
cursor:pointer;
font-weight:bold;
}

.complete-btn button:hover{
background:#e68900;
}

</style>

<script>

/* Voice call */

function startVoice(){

let meeting = "https://meet.jit.si/skillswap_session_<?php echo $session_id; ?>#config.startWithVideoMuted=true";

window.open(meeting,"_blank");

}

/* Video call */

function startVideo(){

let meeting = "https://meet.jit.si/skillswap_session_<?php echo $session_id; ?>";

window.open(meeting,"_blank");

}

</script>

</head>

<body>

<div class="chat-container">

<div class="chat-header">

💬 Skill Swap Live Learning Chat

<small>🟢 Learning Session Active</small>

<div class="call-buttons">
<button onclick="startVoice()">📞 Voice</button>
<button onclick="startVideo()">🎥 Video</button>
</div>

</div>

<div class="chat-box">

<?php

$sql = "SELECT * FROM messages 
        WHERE session_id='$session_id'
        ORDER BY id ASC";

$result = mysqli_query($conn,$sql);

if(mysqli_num_rows($result)==0){

echo "<div class='empty'>Start the conversation 👋</div>";

}

while($row = mysqli_fetch_assoc($result)){

$class = ($row['sender_id']==$user_id) ? "sent" : "received";

echo "<div class='message $class'>";

echo "<div class='sender'>User ".$row['sender_id']."</div>";

echo htmlspecialchars($row['message']);

echo "<div class='time'>".$row['sent_at']."</div>";

echo "</div>";

}

?>

</div>

<form class="chat-input" method="POST" action="backend/send_message.php">

<input type="hidden" name="session_id" value="<?php echo $session_id ?>">

<input type="hidden" name="sender_id" value="<?php echo $user_id ?>">

<input type="text" name="message" placeholder="Type message..." required>

<button type="submit">Send</button>

</form>

<div class="complete-btn">

<form action="backend/complete_session.php" method="POST">

<input type="hidden" name="teacher_id" value="<?php echo $teacher_id; ?>">
<input type="hidden" name="learner_id" value="<?php echo $learner_id; ?>">
<input type="hidden" name="skill_name" value="<?php echo $skill_name; ?>">

<button>🎓 Complete Session</button>

</form>

</div>

</div>

<script>

/* auto scroll */

var chatBox = document.querySelector(".chat-box");
chatBox.scrollTop = chatBox.scrollHeight;

</script>

</body>
</html>