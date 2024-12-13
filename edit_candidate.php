<?php
session_start();
include('db_connection.php'); 

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch the candidate details from the database
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM candidates WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    $candidate = mysqli_fetch_assoc($result);

    if (!$candidate) {
        echo "Candidate not found!";
        exit();
    }
}

// Initialize variables for form inputs
$name = $candidate_id = $category = $imagePath = ''; // Added $imagePath
$error = '';

// Handle form submission for editing candidate details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $candidate_id = mysqli_real_escape_string($conn, $_POST['candidate_id']);
    $category = mysqli_real_escape_string($conn, $_POST['category']); // Changed from 'status' to 'category'

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image'];
        $imageName = time() . '_' . $image['name']; // Generate unique file name
        $imageTmpName = $image['tmp_name'];
        $imagePath = 'images/' . $imageName;

        // Check if the uploaded file is a valid image
        $imageType = mime_content_type($imageTmpName);
        if (strpos($imageType, 'image') !== false) {
            move_uploaded_file($imageTmpName, $imagePath);
        } else {
            $error = "Only image files are allowed!";
        }
    } else {
        // If no image is uploaded, use the current image from the database
        $imagePath = $candidate['image'];
    }

    // Update candidate in the database
    if (!empty($name) && !empty($candidate_id) && !empty($category)) { // Check for 'category' instead of 'status'
        $update_query = "UPDATE candidates SET name = '$name', candidate_id = '$candidate_id', category = '$category', image = '$imagePath' WHERE id = '$id'"; // Added image field
        if (mysqli_query($conn, $update_query)) {
            header("Location: manage_candidates.php"); // Redirect to the candidates management page
            exit();
        } else {
            $error = "Error updating candidate: " . mysqli_error($conn);
        }
    } else {
        $error = "All fields are required!";
    }
} else {
    $name = $candidate['name'];
    $candidate_id = $candidate['candidate_id'];
    $category = $candidate['category']; // Changed from 'status' to 'category'
    $imagePath = $candidate['image']; // Fetch current image
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Candidate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Edit Candidate</h2>

        <?php if ($error): ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form action="edit_candidate.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Candidate Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
            </div>
            <div class="form-group">
                <label for="candidate_id">Candidate ID</label>
                <input type="text" class="form-control" id="candidate_id" name="candidate_id" value="<?php echo htmlspecialchars($candidate_id); ?>" required>
            </div>
            <div class="form-group">
                <label for="category">Category</label> <!-- Changed from 'status' to 'category' -->
                <select class="form-control" id="category" name="category" required>
                    <option value="PRESIDENT" <?php echo ($category == 'PRESIDENT') ? 'selected' : ''; ?>>President</option>
                    <option value="VICE PRESIDENT" <?php echo ($category == 'VICE PRESIDENT') ? 'selected' : ''; ?>>Vice President</option>
                    <option value="COUNCILOR" <?php echo ($category == 'COUNCILOR') ? 'selected' : ''; ?>>Councilor</option> <!-- Added Councilor -->
                </select>
            </div>
            <div class="form-group">
                <label for="image">Candidate Image</label>
                <input type="file" class="form-control-file" id="image" name="image">
                <?php if ($imagePath): ?>
                    <div class="mt-2">
                        <img src="<?php echo $imagePath; ?>" alt="Current Candidate Image" class="img-thumbnail" style="width: 100px; height: 100px;">
                    </div>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Update Candidate</button>
            <a href="manage_candidates.php" class="btn btn-secondary">Back to Candidates</a>
        </form>
    </div>
</body>
</html>



