<?php

include('../layout/header.php');
require('../conn.php');


if (isset($_GET['id'])){
    $user_id=$_GET['id'];

    $query="DELETE FROM `crud` WHERE `user_id`=:user_id";
    $statment=$dbconnection->prepare($query);
    $statment->bindParam(':user_id',$user_id,PDO::PARAM_INT);
    $statment->execute();
}
?>



<?php

include('../layout/footer.php');
?>