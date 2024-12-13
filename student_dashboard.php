<?php
session_start();
include('db_connection.php');

// Check if the student is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: login_student.php"); // Redirect to login if not logged in
    exit();
}

$student_id = $_SESSION['student_id'];

// Fetch student details
$query = "SELECT * FROM students WHERE student_id = '$student_id'"; 
$result = mysqli_query($conn, $query);
$student = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Welcome, <?php echo $student['name']; ?>!</h2>
        <p>Student ID: <?php echo $student['student_id']; ?></p>
        
        <h3>Voting Status</h3>
        <?php
        // Check if the student has voted
        $vote_query = "SELECT * FROM votes WHERE student_id = '$student_id'"; 
        $vote_result = mysqli_query($conn, $vote_query);
        
        if (mysqli_num_rows($vote_result) > 0) {
            echo "<p>You have already voted.</p>";
        } else {
            echo "<p>You have not voted yet. <a href='vote.php'>Click here to vote</a></p>";
        }
        ?>
        
        <a href="student_logout.php" class="btn btn-danger">Logout</a>
    </div>
</body>
</html>

