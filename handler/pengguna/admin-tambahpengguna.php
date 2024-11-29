<?php
session_start();
require '../../database/koneksi.php'; // File koneksi database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $namalengkap = trim($_POST['namalengkap']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $tanggal_lahir = trim($_POST['tanggal_lahir']);
    $jenis_kelamin = trim($_POST['jenis_kelamin']);
    $alamat = trim($_POST['alamat']);
    $role = isset($_POST['role']) ? intval($_POST['role']) : 0; // Default role: Pasien

    // Validasi input
    if (empty($namalengkap) || empty($email) || empty($password) || empty($tanggal_lahir) || empty($jenis_kelamin) || empty($alamat)) {
        echo "<script>alert('Semua field harus diisi!'); window.location.href='../../admin/a-halpengguna.php';</script>";
        exit();
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists using prepared statement
    $check_email_stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $check_email_stmt->bind_param("s", $email);
    $check_email_stmt->execute();
    $result = $check_email_stmt->get_result();

    if ($result->num_rows > 0) {
        // Email already exists
        echo "<script>alert('Email sudah terdaftar. Silakan gunakan email lain.'); window.location.href='../../admin/a-halpengguna.php';</script>";
    } else {
        // Insert user data using prepared statement
        $insert_stmt = $conn->prepare("INSERT INTO user (namalengkap, email, password, role, tanggal_lahir, jenis_kelamin, alamat) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $insert_stmt->bind_param("sssisss", $namalengkap, $email, $hashed_password, $role, $tanggal_lahir, $jenis_kelamin, $alamat);

        if ($insert_stmt->execute()) {
            // Success
            echo "<script>alert('Pendaftaran berhasil!'); window.location.href='../../admin/a-halpengguna.php';</script>";
        } else {
            // Error handling
            echo "<script>alert('Terjadi kesalahan saat menyimpan data.'); window.location.href='../../admin/a-halpengguna.php';</script>";
        }

        $insert_stmt->close();
    }

    $check_email_stmt->close();
}

// Close connection
$conn->close();
?>
