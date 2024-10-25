<?php
session_start();
require '../../database/koneksi.php'; // File koneksi database

// Check if the form is submitted
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
        echo "<script>alert('Email already registered. Please use another email.'); window.location.href='../../admin/a-halpengguna.php';</script>";
    } else {
        // Insert user data into the database, including role
        $sql = "INSERT INTO user (namalengkap, email, password, role) VALUES ('$namalengkap', '$email', '$hashed_password', '$role')";

        if ($conn->query($sql) === TRUE) {
            // Registration successful, redirect to the login page
            echo "<script>alert('Registration successful! Please login.'); window.location.href='../../admin/a-halpengguna.php';</script>";
        } else {
            // Error handling
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Close connection
$conn->close();
?>
