<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Welcome, <?php echo $_SESSION['user']['full_name']; ?></h2>
    <p>Your email: <?php echo $_SESSION['user']['email']; ?></p>
    <a href="index.php" class="btn btn-primary">Go to Landing Page</a>
</div>
</body>
</html>
