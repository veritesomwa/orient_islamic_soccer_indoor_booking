<?php 
require "includes/db.php";
require "includes/server.php";

include "includes/header.php"
;
if (isset($_SESSION['user_id']) & !empty($_SESSION['user_id'])){
    include "includes/dashboard.php";
}else{
    include "includes/login.php";
}

?>