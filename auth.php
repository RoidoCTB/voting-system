<?php
session_start();

// Check if the admin is logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    // Admin is logged in, no action needed
    // You can add additional admin-specific checks here if needed
} 
// Check if the student is logged in
elseif (isset($_SESSION['student_id'])) {
    // Student is logged in, no action needed
    // You can add additional student-specific checks here if needed
} 
else {
    // If neither is logged in, redirect to the appropriate login page
    if (basename($_SERVER['PHP_SELF']) === 'admin_login.php' || basename($_SERVER['PHP_SELF']) === 'admin_dashboard.php') {
        header("Location: admin_login.php"); // Redirect to admin login
    } else {
        header("Location: student_login.php"); // Redirect to student login
    }
    exit();
}
?>

