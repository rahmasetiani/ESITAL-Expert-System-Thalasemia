<?php
require '../../database/koneksi.php';
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php'); // Redirect ke halaman login jika belum login
    exit;
}

// Ambil ID dari query string
if (isset($_GET['idhasil'])) {
    $idhasil = $_GET['idhasil'];

    // Query untuk memperbarui status_revisi menjadi 'rejected'
    $updateQuery = "UPDATE hasil SET status_revisi = 'rejected' WHERE idhasil = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("i", $idhasil);

    if ($stmt->execute()) {
        // Redirect ke halaman daftar revisi pakar
        header('Location: ../../admin/g-halrevisipakar.php');
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    echo "ID tidak valid.";
}
?>
