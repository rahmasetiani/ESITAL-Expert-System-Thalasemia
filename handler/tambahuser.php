<?php
// Include the database connection
include '../database/koneksi.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and get form data
    $namalengkap = $conn->real_escape_string($_POST['namalengkap']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);
    
    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $check_email = "SELECT * FROM user WHERE email = '$email'";
    $result = $conn->query($check_email);

    if ($result->num_rows > 0) {
        // Email already exists
        echo "<script>alert('Email already registered. Please use another email.'); window.location.href='../page/register.php';</script>";
    } else {
        // Insert user data into the database
        $sql = "INSERT INTO user (namalengkap, email, password) VALUES ('$namalengkap', '$email', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            // Registration successful, redirect to login page
            echo "<script>alert('Registration successful! Please login.'); window.location.href='../page/login.php';</script>";
        } else {
            // Error handling
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Close connection
$conn->close();
?>
