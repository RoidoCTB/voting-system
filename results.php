<?php
session_start();
include('db_connection.php');

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch results data, grouped by category (President, Vice President, and Councilor)
$query_results = "SELECT candidates.category, candidates.name, candidates.image, COUNT(votes.candidate_id) AS total_votes
                  FROM votes
                  INNER JOIN candidates ON votes.candidate_id = candidates.id
                  GROUP BY candidates.category, votes.candidate_id
                  ORDER BY FIELD(candidates.category, 'PRESIDENT', 'VICE PRESIDENT', 'COUNCILOR')"; // Sorting categories

// Execute the query and check if it's successful
$result_results = mysqli_query($conn, $query_results);

if (!$result_results) {
    // If the query failed, display the error message
    echo "Error in query: " . mysqli_error($conn);
    exit();
}

// Fetch total number of votes cast by students
$query_total_votes = "SELECT COUNT(DISTINCT student_id) AS total_student_votes FROM votes";
$result_total_votes = mysqli_query($conn, $query_total_votes);

if (!$result_total_votes) {
    echo "Error in query: " . mysqli_error($conn);
    exit();
}

$row_total_votes = mysqli_fetch_assoc($result_total_votes);
$total_student_votes = $row_total_votes['total_student_votes'];

// Group the results by category
$categories = ['PRESIDENT', 'VICE PRESIDENT', 'COUNCILOR'];
$results_by_category = [];
while ($row = mysqli_fetch_assoc($result_results)) {
    $results_by_category[$row['category']][] = $row;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Election Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<style>
    .total-votes-column {
        width: 150px;
        text-align: center; 
        vertical-align: middle; 
    }
    .candidate-image {
        width: 50px;
        height: 50px;
        border-radius: 50%;
    }
    table {
        margin: auto; 
    }
    td, th {
        vertical-align: middle; 
    }
</style>

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
    <h2>Election Results</h2>

    <?php foreach ($categories as $category): ?>
        <h3><?php echo ucfirst(strtolower($category)); ?> Results</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Candidate</th>
                    <th class="total-votes-column">Total Votes</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($results_by_category[$category])): ?>
                    <?php foreach ($results_by_category[$category] as $row): ?>
                        <tr>
                            <td>
                                <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" class="candidate-image">
                                <?php echo $row['name']; ?>
                            </td>
                            <td class="total-votes-column"><?php echo $row['total_votes']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2">No candidates in this category.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    <?php endforeach; ?>

    <h3>Total Votes Cast by Students: <?php echo $total_student_votes; ?></h3>
</div>
</body>
</html>



