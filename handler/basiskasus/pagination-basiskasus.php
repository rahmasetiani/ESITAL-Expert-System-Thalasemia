<?php
require '../database/koneksi.php';

// Set default values for pagination and search
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

// Calculate the offset for pagination
$offset = ($page - 1) * $limit;

// Calculate the starting number for each page
$startNumber = $offset + 1;

// Query to fetch basis kasus and related penyakit with search functionality
$query = "SELECT b.kodebasiskasus, b.kodepenyakit, p.namapenyakit 
          FROM basiskasus b 
          JOIN penyakit p ON b.kodepenyakit = p.kodepenyakit 
          WHERE p.namapenyakit LIKE '%$searchQuery%'
          ORDER BY b.kodebasiskasus ASC 
          LIMIT $limit OFFSET $offset";

$basiskasusResult = mysqli_query($conn, $query);
if (!$basiskasusResult) {
    echo "Terjadi kesalahan pada query: " . mysqli_error($conn);
    exit();
}

// Count total records for pagination
$totalQuery = "SELECT COUNT(*) as total 
               FROM basiskasus b 
               JOIN penyakit p ON b.kodepenyakit = p.kodepenyakit 
               WHERE p.namapenyakit LIKE '%$searchQuery%'";
$totalResult = mysqli_fetch_assoc(mysqli_query($conn, $totalQuery));
$totalRecords = $totalResult['total'];
$totalPages = ceil($totalRecords / $limit);
?>
