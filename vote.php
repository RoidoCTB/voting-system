<?php
include('db_connection.php'); 
include('auth.php'); 

// Fetch candidates from the database for each category
$query_president = "SELECT * FROM candidates WHERE category = 'President' AND status = 'active'";
$query_vice_president = "SELECT * FROM candidates WHERE category = 'Vice President' AND status = 'active'";
$query_councilors = "SELECT * FROM candidates WHERE category = 'Councilor' AND status = 'active'";

// Execute queries
$result_president = mysqli_query($conn, $query_president);
$result_vice_president = mysqli_query($conn, $query_vice_president);
$result_councilors = mysqli_query($conn, $query_councilors);

// Check if the queries executed successfully
if (!$result_president || !$result_vice_president || !$result_councilors) {
    die('Error in query: ' . mysqli_error($conn)); // Debugging: Check for query errors
}

// If the form is submitted, process the votes
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_SESSION['student_id']; // Get the student ID from session
    $vote_date = date('Y-m-d H:i:s'); // Capture the current date and time for vote

    // Insert vote for President if selected
    if (isset($_POST['president_id'])) {
        $president_id = $_POST['president_id'];
        $query_president_vote = "INSERT INTO votes (student_id, vote_date, candidate_id) VALUES ('$student_id', '$vote_date', '$president_id')";
        mysqli_query($conn, $query_president_vote);
    }

    // Insert vote for Vice President if selected
    if (isset($_POST['vice_president_id'])) {
        $vice_president_id = $_POST['vice_president_id'];
        $query_vice_president_vote = "INSERT INTO votes (student_id, vote_date, candidate_id) VALUES ('$student_id', '$vote_date', '$vice_president_id')";
        mysqli_query($conn, $query_vice_president_vote);
    }

    // Insert votes for Councilors if selected
    if (isset($_POST['councilors'])) {
        foreach ($_POST['councilors'] as $councilor_id) {
            $query_councilor_vote = "INSERT INTO votes (student_id, vote_date, candidate_id) VALUES ('$student_id', '$vote_date', '$councilor_id')";
            mysqli_query($conn, $query_councilor_vote);
        }
    }

    // Redirect with JS alert on successful voting
    echo "<script>
            alert('Thanks for voting!');
            window.location.href = 'student_dashboard.php'; // Redirect back to student dashboard
          </script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vote</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Vote for a Candidate</h2>
        <form method="POST">
            <!-- President Vote -->
            <div class="form-group">
                <label>Select President</label>
                <div class="d-flex flex-wrap">
                    <?php while ($row = mysqli_fetch_assoc($result_president)) { ?>
                        <div class="m-2 text-center">
                            <?php 
                                $imagePath = $row['image']; // Directly use the image path stored in the database
                                if (!empty($imagePath) && file_exists($imagePath)) {
                                    echo '<img src="' . $imagePath . '" alt="' . $row['name'] . '" class="img-thumbnail" style="width: 100px; height: 100px;">';
                                } else {
                                    echo '<img src="images/placeholder.jpg" alt="No Image" class="img-thumbnail" style="width: 100px; height: 100px;">';
                                }
                            ?>
                            <div>
                                <input type="radio" name="president_id" value="<?php echo $row['id']; ?>" required>
                                <label><?php echo $row['name']; ?></label>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <!-- Vice President Vote -->
            <div class="form-group">
                <label>Select Vice President</label>
                <div class="d-flex flex-wrap">
                    <?php while ($row = mysqli_fetch_assoc($result_vice_president)) { ?>
                        <div class="m-2 text-center">
                            <?php 
                                $imagePath = $row['image']; 
                                if (!empty($imagePath) && file_exists($imagePath)) {
                                    echo '<img src="' . $imagePath . '" alt="' . $row['name'] . '" class="img-thumbnail" style="width: 100px; height: 100px;">';
                                } else {
                                    echo '<img src="images/placeholder.jpg" alt="No Image" class="img-thumbnail" style="width: 100px; height: 100px;">';
                                }
                            ?>
                            <div>
                                <input type="radio" name="vice_president_id" value="<?php echo $row['id']; ?>" required>
                                <label><?php echo $row['name']; ?></label>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <!-- Councilor Vote -->
            <div class="form-group">
                <label>Select Councilors (up to 7)</label>
                <div class="d-flex flex-wrap">
                    <?php while ($row = mysqli_fetch_assoc($result_councilors)) { ?>
                        <div class="m-2 text-center">
                            <?php 
                                $imagePath = $row['image']; 
                                if (!empty($imagePath) && file_exists($imagePath)) {
                                    echo '<img src="' . $imagePath . '" alt="' . $row['name'] . '" class="img-thumbnail" style="width: 100px; height: 100px;">';
                                } else {
                                    echo '<img src="images/placeholder.jpg" alt="No Image" class="img-thumbnail" style="width: 100px; height: 100px;">';
                                }
                            ?>
                            <div>
                                <input type="checkbox" name="councilors[]" value="<?php echo $row['id']; ?>" 
                                       max="7"> 
                                <label><?php echo $row['name']; ?></label>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Submit Vote</button>
        </form>
    </div>
</body>
</html>




















