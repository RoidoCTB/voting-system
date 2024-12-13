<?php
session_start();
include('db_connection.php'); // Include your database connection

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Check if an ID was passed
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete candidate from the database
    $query = "DELETE FROM candidates WHERE id = '$id'";
    if (mysqli_query($conn, $query)) {
        header("Location: manage_candidates.php"); // Redirect to candidates management page
        exit();
    } else {
        echo "Error deleting candidate: " . mysqli_error($conn);
    }
} else {
    echo "No candidate ID specified!";
}
?>
