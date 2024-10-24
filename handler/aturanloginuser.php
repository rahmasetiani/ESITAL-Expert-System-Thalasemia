<?php
session_start();
require_once '../database/koneksi.php'; // Include your database connection file

// Initialize an empty error variable
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if email and password are provided
    if (empty($email) || empty($password)) {
        echo "<script>alert('Please enter both email and password.'); window.location.href='../page/login.php';</script>";
    } else {
        // Query to check user in the database
        $query = "SELECT * FROM user WHERE email = ? LIMIT 1";
        if ($stmt = $conn->prepare($query)) {
            // Bind the email to the query
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            // Check if email exists in the database
            if ($result->num_rows == 1) {
                $user = $result->fetch_assoc();
                // Verify password
                if (password_verify($password, $user['password'])) {
                    // Store session data
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['logged_in'] = true;

                    // Redirect based on user role
                    if ($user['role'] == 0) {
                        header("Location: ../page/diagnosa.php"); // Regular user
                    } elseif ($user['role'] == 1) {
                        header("Location: ../admin/dashboard.php"); // Admin
                    } elseif ($user['role'] == 2) {
                        header("Location: ../admin/pakar/dashboard.php"); // Expert, if you have an expert dashboard
                    }
                    exit();
                } else {
                    // Incorrect password
                    echo "<script>alert('Invalid password. Please try again.'); window.location.href='../page/login.php';</script>";
                }
            } else {
                // Email not found in database
                echo "<script>alert('No account found with that email. Please check your email and try again.'); window.location.href='../page/login.php';</script>";
            }
        } else {
            // Error during database query
            echo "<script>alert('Database query error. Please try again later.'); window.location.href='../page/login.php';</script>";
        }
    }
}
?>
