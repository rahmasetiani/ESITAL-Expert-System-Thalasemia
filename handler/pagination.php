<?php
require '../database/koneksi.php';

// Set pagination defaults
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Search query
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';

// Get total number of users for pagination
$totalUsersQuery = "SELECT COUNT(*) as total FROM user WHERE namalengkap LIKE '%$searchQuery%'";
$totalResult = mysqli_query($conn, $totalUsersQuery);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalUsers = $totalRow['total'];
$totalPages = ceil($totalUsers / $limit);

// Query for user list
$userQuery = "SELECT id, namalengkap, email, role FROM user WHERE namalengkap LIKE '%$searchQuery%' LIMIT $limit OFFSET $offset";
$userResult = mysqli_query($conn, $userQuery);
?>
