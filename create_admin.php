<?php
// Include the database connection
include('db_connection.php'); 

// Admin details
$name = 'Lloyd';  // Set admin name
$email = 'lloyd@gmail.com';  // Set admin email
$password = 'headzhacke12';  // Set admin password

// Hash the password for security
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// SQL query to insert the admin user into the database
$sql = "INSERT INTO admins (name, email, password) VALUES ('$name', '$email', '$hashed_password')";

// Execute the query
if (mysqli_query($conn, $sql)) {
    echo "Admin user created successfully!";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>


