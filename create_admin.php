<?php

include('db_connection.php'); 

// run this file if you want to create admins (localhost/voting system/create_admin.php)
$name = 'Admin';  // Set admin name
$email = 'admin@gmail.com';  // Set admin email
$password = 'admin123';  // Set admin password

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

mysqli_close($conn);
?>


