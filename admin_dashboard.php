<?php
session_start();
include('db_connection.php'); // Include your database connection

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch data for the dashboard (total voters and total candidates)
$query_voters = "SELECT COUNT(*) AS total_voters FROM students"; // Change to 'students' table
$query_candidates = "SELECT COUNT(*) AS total_candidates FROM candidates"; // Modify table name if needed

$result_voters = mysqli_query($conn, $query_voters);
$result_candidates = mysqli_query($conn, $query_candidates);

// Check if the queries were successful
if ($result_voters && $result_candidates) {
    $total_voters = mysqli_fetch_assoc($result_voters)['total_voters'];
    $total_candidates = mysqli_fetch_assoc($result_candidates)['total_candidates'];
} else {
    // Handle errors if queries fail
    $total_voters = 0;
    $total_candidates = 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap 4.5 CSS link -->
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
    
    <div class="content">
        <h2>Admin Dashboard</h2>
        <div class="row">
            <div class="col-md-6">
                <div class="card text-white bg-info mb-3">
                    <div class="card-header">Total Voters</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $total_voters; ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-white bg-info mb-3">
                    <div class="card-header">Total Candidates</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $total_candidates; ?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>







