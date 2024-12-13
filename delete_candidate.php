<?php
session_start();
include('db_connection.php');

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM candidates WHERE id = '$id'";
    if (mysqli_query($conn, $query)) {
        header("Location: manage_candidates.php"); 
        exit();
    } else {
        echo "Error deleting candidate: " . mysqli_error($conn);
    }
} else {
    echo "No candidate ID specified!";
}
?>
