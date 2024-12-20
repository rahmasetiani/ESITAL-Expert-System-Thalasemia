<?php
// Pastikan koneksi ke database sudah benar
require '../../database/koneksi.php';
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php'); // Redirect ke halaman login jika belum login
    exit;
}

// Pastikan data dikirim melalui POST untuk keamanan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data yang dikirim melalui POST
    $idhasil = isset($_POST['idhasil']) ? trim($_POST['idhasil']) : null;
    $diagnosa = isset($_POST['hasil_diagnosa_terpilih']) ? trim($_POST['hasil_diagnosa_terpilih']) : null;
    $similarity = isset($_POST['hasil_similarity_terpilih']) ? trim($_POST['hasil_similarity_terpilih']) : null;

    // Validasi data yang diterima
    if (empty($idhasil) || empty($diagnosa) || empty($similarity)) {
        echo "Data tidak lengkap. Pastikan semua data terisi.";
        exit;
    }

    // Query untuk memperbarui status revisi menjadi 'accepted' dan menyimpan diagnosa serta similarity
    $query = "UPDATE hasil SET hasil_diagnosa = ?, hasil_similarity = ?, status_revisi = 'accepted' WHERE idhasil = ?";
    $stmt = $conn->prepare($query);

    // Pastikan similarity dikonversi ke float untuk keamanan tipe data
    $similarity = floatval($similarity);

    // Bind parameter ke query
    $stmt->bind_param("sdi", $diagnosa, $similarity, $idhasil);

    // Eksekusi query
    if ($stmt->execute()) {
        // Jika berhasil, redirect kembali ke halaman revisi pakar
        header('Location: ../../admin/g-halrevisipakar.php?update=success');
        exit;
    } else {
        // Jika terjadi kesalahan
        echo "Gagal memperbarui data. Silakan coba lagi.";
    }
} else {
    // Jika tidak menggunakan metode POST
    echo "Metode permintaan tidak valid.";
}
?>
