<?php
include("backend/config.php");

if(!isset($_GET['cert_id'])){
echo "Certificate not found";
exit();
}

$cert_id = $_GET['cert_id'];

/* Get certificate */

$cert = mysqli_fetch_assoc(
mysqli_query($conn,
"SELECT * FROM certificates WHERE id='$cert_id'")
);

if(!$cert){
echo "Invalid Certificate";
exit();
}

/* Get user */

$user = mysqli_fetch_assoc(
mysqli_query($conn,
"SELECT * FROM users WHERE id='".$cert['user_id']."'")
);
?>

<!DOCTYPE html>
<html>
<head>
<title>Skill Swap Certificate</title>

<style>

body{
background:#f4f4f4;
font-family:Georgia;
}

/* Certificate box */

.certificate{
width:800px;
margin:40px auto;
padding:60px;
text-align:center;
border:12px solid #d4af37;
background:white;
box-shadow:0 0 25px rgba(0,0,0,0.2);
position:relative;
}

/* Inner border */

.certificate:before{
content:"";
position:absolute;
top:15px;
left:15px;
right:15px;
bottom:15px;
border:3px solid #d4af37;
}

/* Title */

h1{
font-size:42px;
margin-bottom:10px;
}

/* Name */

.name{
font-size:34px;
font-weight:bold;
margin:25px 0;
color:#222;
}

/* Skill */

.skill{
font-size:26px;
margin:20px 0;
font-weight:bold;
color:#444;
}

/* Footer */

.footer{
margin-top:60px;
font-size:16px;
}

/* Signature */

.signature{
margin-top:50px;
display:flex;
justify-content:space-between;
}

.signature div{
text-align:center;
}

/* Print button */

.print{
display:block;
margin:20px auto;
padding:10px 20px;
background:#007bff;
color:white;
border:none;
border-radius:6px;
cursor:pointer;
}

.print:hover{
background:#0056b3;
}

</style>
</head>

<body>

<div class="certificate">

<h1>🎓 Certificate of Completion</h1>

<p>This certifies that</p>

<div class="name">
<?php echo htmlspecialchars($user['name']); ?>
</div>

<p>has successfully completed the skill</p>

<div class="skill">
<?php echo htmlspecialchars($cert['skill_name']); ?>
</div>

<p>Issued on <b><?php echo $cert['issue_date']; ?></b></p>

<p>Certificate ID: <b>CERT-<?php echo $cert_id; ?></b></p>

<div class="signature">

<div>
_____________________
<br>Mentor Signature
</div>

<div>
_____________________
<br>Skill Swap Platform
</div>

</div>

<div class="footer">
Skill Swap Learning Platform
</div>

</div>

<button class="print" onclick="window.print()">Download / Print Certificate</button>

</body>
</html>