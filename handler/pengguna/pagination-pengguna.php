<?php
require '../database/koneksi.php';

// Pagination setup
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10; // Default to 10 entries per page
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

// Query to fetch user data with search filter and pagination
// Query untuk mendapatkan data pengguna dengan pengurutan terbaru (ID terbesar)
$userQuery = "SELECT * FROM user WHERE namalengkap LIKE '%$searchQuery%' OR email LIKE '%$searchQuery%' OR role LIKE '%$searchQuery%' ORDER BY id DESC LIMIT $limit OFFSET $offset";
$userResult = mysqli_query($conn, $userQuery);


// Get logged-in user details
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
