<?php
session_start(); // Pastikan session sudah dimulai

// Cek apakah pengguna sudah login dan ada data role
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    // Ambil role dari session
    $role = $_SESSION['role'];

    // Redirect tergantung pada nilai role
    if ($role == 0) {
        // Jika role 0, arahkan ke home
        header("Location: page/home.php");
    } elseif ($role == 1 || $role == 2) {
        // Jika role 1 atau 2, arahkan ke admin/z-dashboard.php
        header("Location: admin/z-dashboard.php");
    }
    exit();
} else {
    // Jika belum login, arahkan ke halaman login
    header("Location: page/home.php");
    exit();
}
?>
