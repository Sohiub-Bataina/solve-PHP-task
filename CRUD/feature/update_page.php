<?php

include('../layout/header.php');
require('../conn.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT * FROM `crud` WHERE `user_id` = :id";
    $statement = $dbconnection->prepare($query);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        echo "User not found.";
        exit;
    }
}

if (isset($_POST['update_user'])) {
    $fname = $_POST['fname'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];

   
    $updateQuery = "UPDATE `crud` SET `user_name` = :fname, `user_email` = :email, `user_mobile` = :mobile, `user_password` = :password WHERE `user_id` = :id";
    $updateStatement = $dbconnection->prepare($updateQuery);
    
    $updateStatement->bindParam(':fname', $fname, PDO::PARAM_STR);
    $updateStatement->bindParam(':email', $email, PDO::PARAM_STR);
    $updateStatement->bindParam(':mobile', $mobile, PDO::PARAM_STR);
    $updateStatement->bindParam(':password', $password, PDO::PARAM_STR);
    $updateStatement->bindParam(':id', $id, PDO::PARAM_INT);
    
    
    if ($updateStatement->execute()) {
        echo "<div class='alert alert-success'>User updated successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error updating user.</div>";
    }
}

?>

<div class="container mt-5">
    <form action="update_page.php?id=<?php echo $id; ?>" method="post">
        <div class="form-group">
            <label for="fname">User Name</label>
            <input type="text" class="form-control" name="fname" id="fname" aria-describedby="fname" value="<?php echo htmlspecialchars($user['user_name']); ?>">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" placeholder="email" name="email" value="<?php echo htmlspecialchars($user['user_email']); ?>">
        </div>
        <div class="form-group">
            <label for="mobile">User Mobile</label>
            <input type="text" class="form-control" id="mobile" aria-describedby="mobile" placeholder="mobile" name="mobile" value="<?php echo htmlspecialchars($user['user_mobile']); ?>">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="password" value="<?php echo htmlspecialchars($user['user_password']); ?>">
        </div>
        
        <input type="submit" class="btn btn-success" name="update_user" value="UPDATE">
    </form>
</div>

<?php

include('../layout/footer.php');
?>
