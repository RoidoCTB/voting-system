<?php
// Please use this in your database query to manually add students since student id raman pod ang gamit sa pag login niya
// INSERT INTO students (student_id, name, email)
// VALUES ('20210440', 'John Smith', 'johnsmith@example.com');


session_start();
include('db_connection.php'); // Include your database connection

// Check if the student is already logged in
if (isset($_SESSION['student_id'])) {
    header("Location: student_dashboard.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];

    // Check if the student ID exists in the database
    $query = "SELECT * FROM students WHERE student_id = '$student_id'"; // Adjust table name if needed
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        // Student found, log them in
        $_SESSION['student_id'] = $student_id;
        header("Location: student_dashboard.php"); // Redirect to student dashboard
        exit();
    } else {
        $error_message = "Invalid Student ID.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Student Login</h2>
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form method="POST" action="login_student.php">
            <div class="form-group">
                <label for="student_id">Student ID</label>
                <input type="text" class="form-control" id="student_id" name="student_id" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</body>
</html>
