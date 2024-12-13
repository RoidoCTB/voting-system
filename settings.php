<?php
session_start();
include('db_connection.php'); // Include your database connection

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch admin details from the database
$query_admin = "SELECT * FROM admins WHERE id = '{$_SESSION['admin_id']}'"; // Modify table name if needed
$result_admin = mysqli_query($conn, $query_admin);
$admin = mysqli_fetch_assoc($result_admin);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="sidebar">
    <h2 class="text-center">Dashboard</h2>
    <a href="admin_dashboard.php">Home</a>
    <a href="manage_voters.php">Manage Voters</a>
    <a href="manage_candidates.php">Manage Candidates</a>
    <a href="results.php">Results</a>
    <a href="settings.php">Settings</a>
    <a href="logout.php">Logout</a>
</div>
    
<div class="container mt-4">
    <h2>Admin Details</h2>
    <table class="table">
        <tr>
            <th>Admin ID</th>
            <td><?php echo $admin['id']; ?></td>
        </tr>
        <tr>
            <th>Admin Name</th>
            <td><?php echo $admin['name']; ?></td>
        </tr>
        <tr>
            <th>Admin Email</th>
            <td><?php echo $admin['email']; ?></td>
        </tr>
    </table>
</div>
</body>
</html>



