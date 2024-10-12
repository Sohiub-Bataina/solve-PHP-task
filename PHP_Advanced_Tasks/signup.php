<?php
session_start();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $mobile = trim($_POST['mobile']);
    $fname = trim($_POST['fname']);
    $mname = trim($_POST['mname']);
    $lname = trim($_POST['lname']);
    $family_name = trim($_POST['family_name']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $dob_day = $_POST['dob_day'];
    $dob_month = $_POST['dob_month'];
    $dob_year = $_POST['dob_year'];

    // Regex patterns
    $email_pattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
    $mobile_pattern = "/^\d{14}$/";
    $name_pattern = "/^[a-zA-Z]+$/";
    $password_pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&.]{6,}$/";

    // Validate inputs
    if (!preg_match($email_pattern, $email)) {
        $errors[] = "Invalid email format.";
    }
    if (!preg_match($mobile_pattern, $mobile)) {
        $errors[] = "Mobile number must be 10 digits.";
    }
    if (!preg_match($name_pattern, $fname) || !preg_match($name_pattern, $mname) ||
        !preg_match($name_pattern, $lname) || !preg_match($name_pattern, $family_name)) {
        $errors[] = "Names must only contain letters.";
    }
    if (!preg_match($password_pattern, $password)) {
        $errors[] = "Password must be at least 6 characters long and contain upper case, lower case, numbers, and special characters.";
    }
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    // Check age
    $dob = DateTime::createFromFormat('Y-m-d', "$dob_year-$dob_month-$dob_day");
    $age = (new DateTime())->diff($dob)->y;
    if ($age < 16) {
        $errors[] = "You must be at least 16 years old to register.";
    }

    // If no errors, store data
    if (empty($errors)) {
        $_SESSION['user'] = [
            'email' => $email,
            'mobile' => $mobile,
            'full_name' => "$fname $mname $lname $family_name",
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'dob' => $dob->format('Y-m-d'),
        ];
        header('Location: login.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Sign Up</h2>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error): ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <form method="POST" novalidate>
        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email" required>
        </div>
        <div class="mb-3">
            <input type="text" name="mobile" class="form-control" placeholder="Mobile (10 digits)" required>
        </div>
        <div class="mb-3">
            <input type="text" name="fname" class="form-control" placeholder="First Name" required>
        </div>
        <div class="mb-3">
            <input type="text" name="mname" class="form-control" placeholder="Middle Name" required>
        </div>
        <div class="mb-3">
            <input type="text" name="lname" class="form-control" placeholder="Last Name" required>
        </div>
        <div class="mb-3">
            <input type="text" name="family_name" class="form-control" placeholder="Family Name" required>
        </div>
        <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <div class="mb-3">
            <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
        </div>
        <div class="mb-3">
            <input type="number" name="dob_day" class="form-control" placeholder="Day (DD)" required>
            <input type="number" name="dob_month" class="form-control" placeholder="Month (MM)" required>
            <input type="number" name="dob_year" class="form-control" placeholder="Year (YYYY)" required>
        </div>
        <button type="submit" class="btn btn-primary">Sign Up</button>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a></p>
</div>
</body>
</html>
