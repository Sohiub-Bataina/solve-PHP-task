<?php

$server="localhost";
$username="root";
$password="";
$dbname="first_table";

$dsn="mysql:host=$server;dbname=$dbname";
try{
$dbconnection=new PDO ($dsn,$username,$password);

// echo "connect";

}catch (PDOException $error){
echo $error;
}


?>
