<?php
$name        = $_POST['name'] ?? "";
$email       = $_POST['email'] ?? "";
$skill_offer = $_POST['skill_offer'] ?? "";
$skill_want  = $_POST['skill_want'] ?? "";

// FIX: If no data, redirect back to registration
if ($name == "" && $email == "") {
    header("Location: Registration.html");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Skill Swap Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>

<div class="navbar">
    <!-- FIX: $name now correctly comes from POST (works for both register & login) -->
    <h2>Welcome, <?php echo htmlspecialchars($name); ?> 👋</h2>
</div>

<div class="container">

    <div class="card">
        <h3>Your Details</h3>
        <!-- FIX: Use PHP variables directly instead of localStorage (more reliable) -->
        <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
        <p><strong>Skill You Offer:</strong> <?php echo htmlspecialchars($skill_offer); ?></p>
        <p><strong>Skill You Want:</strong> <?php echo htmlspecialchars($skill_want); ?></p>
    </div>

    <div class="card">
        <h3>Find Skill Matches</h3>
        <form action="matches.php" method="POST">
            <!-- FIX: Pass all user data so matches.php has full context -->
            <input type="hidden" name="skill_offer" value="<?php echo htmlspecialchars($skill_offer); ?>">
            <input type="hidden" name="skill_want"  value="<?php echo htmlspecialchars($skill_want); ?>">
            <input type="hidden" name="name"         value="<?php echo htmlspecialchars($name); ?>">
            <input type="hidden" name="email"        value="<?php echo htmlspecialchars($email); ?>">
            <button type="submit">View Matches</button>
        </form>
    </div>

</div>

</body>
</html>