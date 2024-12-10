<?php
require '../../database/koneksi.php';
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: ../../page/login.php');
    exit;
}

// Ambil idhasil dari parameter URL
$idhasil = isset($_GET['idhasil']) ? (int)$_GET['idhasil'] : 0;

// Query untuk mengambil data hasil berdasarkan idhasil
$query = "SELECT * FROM hasil WHERE idhasil = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $idhasil);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

// Jika data tidak ditemukan, redirect ke halaman sebelumnya
if (!$result) {
    header('Location: ../../admin/g-halrevisipakar.php');
    exit;
}

// Mengambil keseluruhan_diagnosa dan keseluruhan_similarity dari JSON
$keseluruhan_diagnosa = json_decode($result['keseluruhan_diagnosa'], true);
$keseluruhan_similarity = json_decode($result['keseluruhan_similarity'], true);

// Jika tidak ada data untuk keseluruhan_diagnosa atau keseluruhan_similarity
if (!is_array($keseluruhan_diagnosa) || !is_array($keseluruhan_similarity) || empty($keseluruhan_similarity)) {
    // Redirect ke halaman jika tidak ada diagnosa atau similarity
    header('Location: ../../admin/g-halrevisipakar.php');
    exit;
}

// Mengambil nilai similarity tertinggi
$max_similarity_index = array_keys($keseluruhan_similarity, max($keseluruhan_similarity))[0];
$highest_similarity = $keseluruhan_similarity[$max_similarity_index];
$highest_diagnosis = $keseluruhan_diagnosa[$max_similarity_index];

// Update hasil_diagnosa dan hasil_similarity
$updateQuery = "UPDATE hasil SET hasil_diagnosa = ?, hasil_similarity = ? WHERE idhasil = ?";
$updateStmt = $conn->prepare($updateQuery);
$updateStmt->bind_param("sdi", $highest_diagnosis, $highest_similarity, $idhasil);
$updateStmt->execute();

// Redirect kembali ke halaman admin setelah sukses
header('Location: ../../admin/g-halrevisipakar.php');
exit;
?>
