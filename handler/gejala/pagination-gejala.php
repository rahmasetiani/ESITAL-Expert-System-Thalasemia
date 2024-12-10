<?php
require '../database/koneksi.php';

$email = $_SESSION['email'];
$query = "SELECT namalengkap, role FROM user WHERE email = '$email'";
$result = mysqli_query($conn, $query);

if ($row = mysqli_fetch_assoc($result)) {
    $_SESSION['namalengkap'] = $row['namalengkap'];
    $_SESSION['role'] = $row['role'];
} else {
    echo "User not found!";
    exit();
}

// Pagination and listing logic
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10; // Default limit
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
$offset = ($page - 1) * $limit;
$searchQuery = isset($_GET['search']) ? $_GET['search'] : ''; // Current search query

// Count total records for pagination
$countQuery = "SELECT COUNT(*) as total FROM gejala WHERE namagejala LIKE '%$searchQuery%'";
$countResult = mysqli_query($conn, $countQuery);
$totalRecords = mysqli_fetch_assoc($countResult)['total'];
$totalPages = ceil($totalRecords / $limit); // Calculate total pages

// Query untuk mengambil data gejala
$queryGejala = "SELECT * FROM gejala WHERE namagejala LIKE '%$searchQuery%' LIMIT $limit OFFSET $offset";
$gejalaResult = mysqli_query($conn, $queryGejala);

// Cek apakah query berhasil
if (!$gejalaResult) {
    die("Error executing query: " . mysqli_error($conn));
}

// Ambil kode gejala terakhir
$queryLastKode = "SELECT kodegejala FROM gejala ORDER BY kodegejala DESC LIMIT 1";
$resultLastKode = mysqli_query($conn, $queryLastKode);

if ($row = mysqli_fetch_assoc($resultLastKode)) {
    $lastKode = (int) substr($row['kodegejala'], 1); // Mengambil angka setelah 'G'
    $nextKodeGejala = $lastKode + 1;
} else {
    $nextKodeGejala = 1; // Jika belum ada data, mulai dari 1
}
?>