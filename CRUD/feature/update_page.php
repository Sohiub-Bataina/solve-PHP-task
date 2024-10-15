<?php

include('../layout/header.php');
require('../conn.php');
?>

<?php
if(isset($_GET['id'])){
    $id=$_GET['id'];;

    $query="SELECT * FROM `crud` WHERE `user_id`=:id";

    $statment=$dbconnection->prepare($query);
    $statment->bindParam(':id',$id,PDO::PARAM_INT);
    $statment->execute();

    $user=$statment->fetch(PDO::FETCH_ASSOC);
    // print_r($user);

}

?>

<?php
if(isset($_POST['update_user'])){
    $fname=$_POST['fname'];
    $email=$_POST['email'];
    $mobile=$_POST['mobile'];
    $password=$_POST['password'];
    $id=$_POST['id'];

    $query="UPDATE `crud` SET `user_name`=:user_name,`user_email`=:user_email,`user_mobile`=:user_mobile,`user_password`=:user_password WHERE `user_id`=:user_id";
    $statment=$dbconnection->prepare($query);
    $statment->bindParam(':user_name',$fname);
    $statment->bindParam(':user_email',$email);
    $statment->bindParam(':user_mobile',$mobile);
    $statment->bindParam(':user_password',$password);
    $statment->bindParam(':user_id',$id);

    // $statment->execute();
if($statment->execute()){
    echo "update successfully";
}else{
echo "failed of update data";
}





}

?>


<div class="container mt-5">
    <form action="update_page.php" method="post">
    <input type="hidden" class="form-control" name="id" id="id" aria-describedby="id"
    value=<?php echo $user['user_id']??'';?>>
        <div class="form-group">
            <label for="fname">User Name</label>
            <input type="text" class="form-control" name="fname" id="fname" aria-describedby="fname"
                value=<?php echo $user['user_name']??'';?>>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" placeholder="email" name="email"
                value=<?php echo $user['user_email']??'';?>>
        </div>
        <div class="form-group">
            <label for="mobile">User Mobile</label>
            <input type="text" class="form-control" id="mobile" aria-describedby="mobile" placeholder="mobile" name="mobile"
                value=<?php echo $user['user_mobile']??'';?>>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="text" class="form-control" id="password" name="password" placeholder="password" value=<?php echo $user['user_password']??'';?>>
        </div>
        
        <input type="submit" class="btn btn-success" name="update_user" value="UPDATE">
    </form>
</div>

<?php

include('../layout/footer.php');
?>