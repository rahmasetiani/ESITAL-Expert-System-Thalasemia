<?php
require '../database/koneksi.php';

// Set pagination defaults
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Search query
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';

// Get total number of users for pagination
$totalUsersQuery = "SELECT COUNT(*) as total FROM user WHERE namalengkap LIKE '%$searchQuery%' OR email LIKE '%$searchQuery%' OR role LIKE '%$searchQuery%'";
$totalResult = mysqli_query($conn, $totalUsersQuery);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalUsers = $totalRow['total'];
$totalPages = ceil($totalUsers / $limit);

// Query for user list
$userQuery = "SELECT * FROM user WHERE namalengkap LIKE '%$searchQuery%' OR email LIKE '%$searchQuery%' OR role LIKE '%$searchQuery%' LIMIT $limit OFFSET $offset";
$userResult = mysqli_query($conn, $userQuery);

// Ambil data nama lengkap dan role berdasarkan email dari session
$email = $_SESSION['email'];
$query = "SELECT namalengkap, role, tanggal_lahir, jenis_kelamin, alamat FROM user WHERE email = '$email'";
$result = mysqli_query($conn, $query);

if ($row = mysqli_fetch_assoc($result)) {
    $_SESSION['namalengkap'] = $row['namalengkap'];
    $_SESSION['role'] = $row['role']; // Store user role in session
} else {
    echo "User not found!";
}
?>
