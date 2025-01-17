<?php
// Include the database connection
include '../../database/koneksi.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and get form data
    $namalengkap = $conn->real_escape_string($_POST['namalengkap']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);
    $confirm_password = $conn->real_escape_string($_POST['confirm_password']); // Ambil field konfirmasi password
    $tanggal_lahir = $conn->real_escape_string($_POST['tanggal_lahir']);
    $jenis_kelamin = $conn->real_escape_string($_POST['jenis_kelamin']);
    $alamat = $conn->real_escape_string($_POST['alamat']);
    
    // Default role for new users
    $role = 0; // 0 for regular users

    // Validasi panjang password
    if (strlen($password) < 5) {
        echo "<script>alert('Password harus memiliki minimal 5 karakter.'); window.location.href='../../page/register.php';</script>";
        exit(); // Hentikan eksekusi jika password tidak memenuhi syarat
    }

    // Validasi konfirmasi password
    if ($password !== $confirm_password) {
        echo "<script>alert('Password dan Konfirmasi Password tidak sesuai. Silakan coba lagi.'); window.location.href='../../page/register.php';</script>";
        exit(); // Hentikan eksekusi jika password tidak sesuai
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $check_email = "SELECT * FROM user WHERE email = '$email'";
    $result = $conn->query($check_email);

    if ($result->num_rows > 0) {
        // Email already exists
        echo "<script>alert('Email sudah terdaftar. Silakan gunakan email lain.'); window.location.href='../../page/register.php';</script>";
    } else {
        // Insert user data into the database, including role, tanggal_lahir, jenis_kelamin, and alamat
        $sql = "INSERT INTO user (namalengkap, email, password, role, tanggal_lahir, jenis_kelamin, alamat) 
                VALUES ('$namalengkap', '$email', '$hashed_password', '$role', '$tanggal_lahir', '$jenis_kelamin', '$alamat')";

        if ($conn->query($sql) === TRUE) {
            // Registration successful, redirect to the login page
            echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location.href='../../page/login.php';</script>";
        } else {
            // Error handling
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Close connection
$conn->close();
?>
