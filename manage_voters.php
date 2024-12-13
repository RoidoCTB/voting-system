<?php
session_start();
include('db_connection.php');

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch student information from the students and votes table
$query_voters = "SELECT students.id, students.name, students.email, 
                CASE WHEN COUNT(votes.student_id) > 0 THEN 'Voted' ELSE 'Not Voted' END AS status
                FROM students
                LEFT JOIN votes ON students.student_id = votes.student_id
                GROUP BY students.id"; // Updated query

// Run the query
$result_voters = mysqli_query($conn, $query_voters);

// Check if the query was successful
if (!$result_voters) {
    die('Query failed: ' . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Voters</title>
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
        <h2>Manage Voters</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result_voters)) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>








