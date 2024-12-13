<?php
session_start();


if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {

} 

elseif (isset($_SESSION['student_id'])) {
 
} 
else {
   
    if (basename($_SERVER['PHP_SELF']) === 'admin_login.php' || basename($_SERVER['PHP_SELF']) === 'admin_dashboard.php') {
        header("Location: admin_login.php");
    } else {
        header("Location: student_login.php"); 
    }
    exit();
}
?>

