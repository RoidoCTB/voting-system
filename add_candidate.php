<?php
session_start();
include('db_connection.php'); // Include your database connection

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Initialize variables
$name = $candidate_id = $category = '';
$error = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $candidate_id = mysqli_real_escape_string($conn, $_POST['candidate_id']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $status = 'active'; // Set status as 'active' by default

    // Handle image upload
    if (!empty($_FILES["image"]["name"])) {
        $target_dir = "images/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

        // Validate image file type
        if (!in_array($imageFileType, $allowed_types)) {
            $error = "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
        } else {
            // Attempt to move the uploaded file
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // Insert into the database
                if (!empty($name) && !empty($candidate_id) && !empty($category)) {
                    $query = "INSERT INTO candidates (name, candidate_id, category, image, status) 
                              VALUES ('$name', '$candidate_id', '$category', '$target_file', '$status')";
                    if (mysqli_query($conn, $query)) {
                        header("Location: manage_candidates.php");
                        exit();
                    } else {
                        $error = "Error adding candidate: " . mysqli_error($conn);
                    }
                } else {
                    $error = "All fields are required!";
                }
            } else {
                $error = "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        $error = "Please upload an image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Candidate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #f8f9fa;
            width: 250px;
        }
        .sidebar a {
            color: #333;
            padding: 15px;
            display: block;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #ddd;
        }
        .content {
            margin-left: 260px;
            padding: 20px;
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
        <h2>Add New Candidate</h2>

        <?php if ($error): ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form action="add_candidate.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Candidate Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
            </div>
            <div class="form-group">
                <label for="candidate_id">Candidate ID</label>
                <input type="text" class="form-control" id="candidate_id" name="candidate_id" value="<?php echo htmlspecialchars($candidate_id); ?>" required>
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <select class="form-control" id="category" name="category" required>
                    <option value="PRESIDENT" <?php echo ($category == 'PRESIDENT') ? 'selected' : ''; ?>>President</option>
                    <option value="VICE PRESIDENT" <?php echo ($category == 'VICE PRESIDENT') ? 'selected' : ''; ?>>Vice President</option>
                    <option value="COUNCILOR" <?php echo ($category == 'COUNCILOR') ? 'selected' : ''; ?>>Councilor</option>
                </select>
            </div>
            <div class="form-group">
                <label for="image">Candidate Image</label>
                <input type="file" class="form-control-file" id="image" name="image" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Candidate</button>
            <a href="manage_candidates.php" class="btn btn-secondary">Back to Candidates</a>
        </form>
    </div>
</body>
</html>




