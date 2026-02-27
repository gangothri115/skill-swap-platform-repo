<?php
$skill_offer = $_POST['skill_offer'] ?? "";
$skill_want  = $_POST['skill_want'] ?? "";
$name        = $_POST['name'] ?? "";
$email       = $_POST['email'] ?? "";

if ($skill_offer == "") {
    header("Location: Registration.html");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Skill Matches</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>

<div class="navbar">
    <h2>Matched Users for <?php echo htmlspecialchars($name); ?></h2>
    <!-- FIX: Back button re-posts to dashboard so skills aren't lost -->
    <form action="dashboard.php" method="POST" style="display:inline;">
        <input type="hidden" name="name"        value="<?php echo htmlspecialchars($name); ?>">
        <input type="hidden" name="email"       value="<?php echo htmlspecialchars($email); ?>">
        <input type="hidden" name="skill_offer" value="<?php echo htmlspecialchars($skill_offer); ?>">
        <input type="hidden" name="skill_want"  value="<?php echo htmlspecialchars($skill_want); ?>">
        <button type="submit">⬅ Back to Dashboard</button>
    </form>
</div>

<div class="container">

<?php
// FIX: Uncommented the users array — this was the main crash cause!
// Replace this with database queries later when backend team sets up DB.
$users = [
    ["name" => "Rahul",  "skill_offer" => "Web Design", "skill_want" => "Python"],
    ["name" => "Sneha",  "skill_offer" => "Python",     "skill_want" => "Web Design"],
    ["name" => "Arjun",  "skill_offer" => "Java",       "skill_want" => "C++"],
    ["name" => "Priya",  "skill_offer" => "C++",        "skill_want" => "Java"],
    ["name" => "Vikram", "skill_offer" => "Data Science","skill_want" => "Web Design"],
    ["name" => "Ananya", "skill_offer" => "Web Design", "skill_want" => "Data Science"],
];

$matchFound = false;

// Case-insensitive matching so "python" matches "Python"
foreach ($users as $user) {
    if (
        strtolower($user['skill_offer']) === strtolower($skill_want) &&
        strtolower($user['skill_want'])  === strtolower($skill_offer)
    ) {
        $matchFound = true;
        echo "
        <div class='card'>
            <h4>👤 {$user['name']}</h4>
            <p><strong>Offers:</strong> {$user['skill_offer']}</p>
            <p><strong>Wants:</strong> {$user['skill_want']}</p>
            <p><em>✅ Perfect match with you!</em></p>
        </div>
        ";
    }
}

if (!$matchFound) {
    echo "<div class='card'><p>😕 No matches found yet. Check back later as more users join!</p></div>";
}
?>

</div>

</body>
</html>