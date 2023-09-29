<?php 

$host = "localhost";
$user = "root";
$password = "";
$db_name = "user_system";


$conn = mysqli_connect($host, $user, $password, $db_name);

if (!mysqli_errno($conn)){
    
}else{
    echo "not connected";
}


?>