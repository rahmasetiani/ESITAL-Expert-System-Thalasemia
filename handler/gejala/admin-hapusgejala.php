<?php
session_start();
require '../../database/koneksi.php'; // File koneksi database

// Handle Delete Gejala
if (isset($_GET['kodegejala'])) {
    $kodeGejala = $_GET['kodegejala'];
    $kodeGejala = mysqli_real_escape_string($conn, $kodeGejala);
    $deleteQuery = "DELETE FROM gejala WHERE kodegejala = '$kodeGejala'"; // Hapus berdasarkan kodegejala
    if (mysqli_query($conn, $deleteQuery)) {
        header("Location: ../../admin/c-halgejala.php"); // Redirect kembali ke halaman daftar gejala
        exit();
    } else {
        die("Error deleting record: " . mysqli_error($conn)); // Tampilkan pesan error jika query gagal
    }
} else {
    echo "No kode gejala provided!";
}
?>