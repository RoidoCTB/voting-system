<?php
session_start();
include('db_connection.php'); // Include your database connection

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch all candidates from the database
$query_candidates = "SELECT * FROM candidates"; // Modify table name if needed
$result_candidates = mysqli_query($conn, $query_candidates);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Candidates</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
       .candidate-image {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 50px; 
    display: block;
    margin: 0 auto; 
}

    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2 class="text-center">Dashboard</h2>
        <a href="admin_dashboard.php">Home</a>
        <a href="manage_voters.php">Manage Voters</a>
        <a href="manage_candidates.php">Manage Candidates</a>
        <a href="results.php">Results</a>
        <a href="settings.php">Settings</a>
        <a href="logout.php">Logout</a>
    </div>

    <!-- Main content -->
    <div class="content">
        <h2>Manage Candidates</h2>
        
        <a href="add_candidate.php" class="btn btn-success mb-3">+ Add Candidate</a>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>PICTURE</th>
                    <th>CANDIDATE NAME</th>
                    <th>CANDIDATE ID</th>
                    <th>CANDIDATE CATEGORY</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result_candidates)) { ?>
                    <tr>
                        <td>
                            <?php if (!empty($row['image'])): ?>
                                <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="Candidate Image" class="candidate-image">
                            <?php else: ?>
                                <span>No Image</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['candidate_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['category']); ?></td>
                        <td>
                            <a href="edit_candidate.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete_candidate.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>



