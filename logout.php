<?php 
include "db_connect.php";   
unset($_SESSION['email']);
unset($_SESSION['level_code']);
unset($_SESSION['approve_status']); 
unset($_SESSION["unique_ids"]); 
header('Location:login_page.php');exit;
/*header('Location:index.php');exit;*/
?>