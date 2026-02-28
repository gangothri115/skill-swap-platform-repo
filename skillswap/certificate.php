<?php
include("config.php");

$cert_id = $_GET['cert_id'];

$cert = mysqli_fetch_assoc(
mysqli_query($conn,
"SELECT * FROM certificates WHERE id='$cert_id'")
);

$user = mysqli_fetch_assoc(
mysqli_query($conn,
"SELECT * FROM users WHERE id='".$cert['user_id']."'")
);
?>

<!DOCTYPE html>
<html>
<head>
<title>Certificate</title>
<style>
body{
    background:#f4f4f4;
    font-family:Georgia;
}
.certificate{
    width:800px;
    margin:40px auto;
    padding:50px;
    text-align:center;
    border:15px solid #bfa046;
    background:white;
}
h1{
    font-size:40px;
}
.name{
    font-size:30px;
    font-weight:bold;
    margin:20px 0;
}
.skill{
    font-size:24px;
    margin:15px 0;
}
.footer{
    margin-top:50px;
}
.print{
    margin-top:20px;
}
</style>
</head>
<body>

<div class="certificate">
<h1>Certificate of Completion</h1>

<p>This certifies that</p>

<div class="name"><?php echo $user['name']; ?></div>

<p>has successfully completed</p>

<div class="skill"><?php echo $cert['skill_name']; ?></div>

<p>Issued on <?php echo $cert['issue_date']; ?></p>

<p>Certificate ID: CERT-<?php echo $cert_id; ?></p>

<div class="footer">
Skill Swap Platform
</div>

</div>

<button class="print" onclick="window.print()">Download / Print</button>

</body>
</html>