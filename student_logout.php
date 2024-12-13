<?php
session_start(); // Start the session

// Destroy all session variables and the session
session_unset();
session_destroy();

// Redirect the user to the login page
header("Location: login_student.php");
exit();
?>
