<?php
session_start();
require '../database/koneksi.php'; // File koneksi database

// Pastikan pengguna sudah login
if (!isset($_SESSION['email'])) {
    header("Location: ../page/login.php"); // Redirect ke login jika belum login
    exit();
}

// Ambil data nama lengkap dan role berdasarkan email dari session
$email = $_SESSION['email'];
$query = "SELECT namalengkap, role FROM user WHERE email = '$email'";
$result = mysqli_query($conn, $query);

if ($row = mysqli_fetch_assoc($result)) {
    $_SESSION['namalengkap'] = $row['namalengkap'];
    $_SESSION['role'] = $row['role']; // Store user role in session
} else {
    echo "User not found!";
}

// Count the number of rows in each table
$count_user_query = "SELECT COUNT(*) AS user_count FROM user";
$count_penyakit_query = "SELECT COUNT(*) AS penyakit_count FROM penyakit";
$count_gejala_query = "SELECT COUNT(*) AS gejala_count FROM gejala";
$count_basiskasus_query = "SELECT COUNT(*) AS basiskasus_count FROM basiskasus";
$count_basiskasus_gejala_query = "SELECT COUNT(*) AS basiskasus_gejala_count FROM basiskasus_gejala";

$count_user = mysqli_fetch_assoc(mysqli_query($conn, $count_user_query))['user_count'];
$count_penyakit = mysqli_fetch_assoc(mysqli_query($conn, $count_penyakit_query))['penyakit_count'];
$count_gejala = mysqli_fetch_assoc(mysqli_query($conn, $count_gejala_query))['gejala_count'];
$count_basiskasus = mysqli_fetch_assoc(mysqli_query($conn, $count_basiskasus_query))['basiskasus_count'];
$count_basiskasus_gejala = mysqli_fetch_assoc(mysqli_query($conn, $count_basiskasus_gejala_query))['basiskasus_gejala_count'];

// Ambil nilai ambang batas dari tabel ambang_batas
$ambang_batas_query = "SELECT nilai FROM ambang_batas WHERE id = 1"; // Ambil data ambang batas pertama
$ambang_batas_result = mysqli_query($conn, $ambang_batas_query);
$nilai_ambang_batas = 0; // Default value jika tidak ada data

if ($ambang_batas_row = mysqli_fetch_assoc($ambang_batas_result)) {
    $nilai_ambang_batas = $ambang_batas_row['nilai'];
}


?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../asset/css/admin.css">
    <style>
        /* Custom styles to enhance card design */
        .card {
            border-radius: 10px; /* Round corners */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Soft shadow */
            transition: transform 0.3s ease, box-shadow 0.3s ease; /* Smooth transition for hover effect */
        }

        .card:hover {
            transform: translateY(-5px); /* Hover effect: lifts the card */
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); /* Enhanced shadow on hover */
        }

        .card-body {
            background-color: #f8f9fa; /* Light background for the card body */
            padding: 20px; /* Add padding */
        }

        .card-title {
            font-size: 2rem;
            font-weight: bold;
            color: #343a40; /* Dark color for title */
        }

        .card-text {
            color: #6c757d; /* Lighter color for text */
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            padding: 8px 16px;
            font-size: 1rem;
            border-radius: 5px; /* Rounded button */
            transition: background-color 0.3s ease; /* Smooth button color transition */
        }

        .btn-primary:hover {
            background-color: #0056b3; /* Darker blue on hover */
            border-color: #004085; /* Darker border on hover */
        }

        .row > .col-md-4 {
            margin-bottom: 20px; /* Add space between cards */
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<?php include 'sidebar.php'; ?>

<!-- Navbar -->
<?php include 'navbar.php'; ?>

<!-- Page Content -->
<div id="content" style="margin-top: 56px;">
    <h2>Dashboard</h2>
    <div class="container mt-4">
        <div class="row">
            <!-- Card Data Pengguna -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $count_user; ?></h5>
                        <p class="card-text">Data Pengguna</p>
                        <!-- <a href="#" class="btn btn-primary">Lihat Detail</a> -->
                    </div>
                </div>
            </div>
            <!-- Card Data Penyakit -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $count_penyakit; ?></h5>
                        <p class="card-text">Data Penyakit</p>
                    </div>
                </div>
            </div>
            <!-- Card Data Gejala -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $count_gejala; ?></h5>
                        <p class="card-text">Data Gejala</p>
                    </div>
                </div>
            </div>
            <!-- Card Basis Kasus -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $count_basiskasus; ?></h5>
                        <p class="card-text">Basis Kasus</p>
                    </div>
                </div>
            </div>
            <!-- Card Basis Kasus Gejala -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $count_basiskasus_gejala; ?></h5>
                        <p class="card-text">Basis Kasus Gejala</p>
                    </div>
                </div>
            </div>
            <!-- Card Ambang Batas -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $nilai_ambang_batas; ?>%</h5>
                        <p class="card-text">Ambang Batas</p>
                    </div>
                </div>
            </div>
            <!-- Card Riwayat Deteksi -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $nilai_ambang_batas; ?>%</h5>
                        <p class="card-text">Riwayat Deteksi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS and Icons -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../asset/js/admin.js"></script>
</body>
</html>
