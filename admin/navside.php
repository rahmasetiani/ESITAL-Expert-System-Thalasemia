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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Sidebar</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../asset/css/admin.css">
</head>
<body>

<!-- Sidebar -->
<div id="sidebar" class="bg-dark">
    <div class="sidebar-header d-flex flex-column align-items-center justify-content-center" style="height: 80px;">
        <br>
        <br>
        <br>
        <br>
        <span class="nav-text text-white" style="color: #d62268; font-size: 1.25rem;">Selamat Datang</span>
       <span class="nav-text" style="color: #d62268; font-size: 1.25rem;">
        <?php
        // Check the role and display it
        if ($_SESSION['role'] == 1) { // Assuming 1 is for Admin
            echo '<strong>ADMIN EXSITHAL</strong>'; // Bold text for Admin
        } elseif ($_SESSION['role'] == 2) { // Assuming 2 is for Expert
            echo '<strong>PAKAR EXSITHAL</strong>'; // Bold text for Expert
        }
        ?>
    </span>
        <br>
        <br>
    </div>
    <br>
    <br>
    <nav class="nav flex-column">
        <div class="nav-item">
            <a href="#" class="nav-link">
                <i class="bi bi-person-fill me-2"></i>
                <span class="nav-text">Data Pengguna</span>
            </a>
        </div>
        <div class="nav-item">
            <a href="#" class="nav-link">
                <i class="bi bi-heart-fill me-2"></i>
                <span class="nav-text">Data Penyakit</span>
            </a>
        </div>
        <div class="nav-item">
            <a href="#" class="nav-link">
                <i class="bi bi-emoji-smile-fill me-2"></i>
                <span class="nav-text">Data Gejala</span>
            </a>
        </div>
        <div class="nav-item">
            <a href="#" class="nav-link">
                <i class="bi bi-file-earmark-text-fill me-2"></i>
                <span class="nav-text">Basis Kasus</span>
            </a>
        </div>
    </nav>
    <!-- Icon Buttons -->
    <div class="icon-buttons">
        <button id="toggleCollapse" class="btn" title="Collapse Sidebar">
            <i class="bi bi-arrow-left-circle" style="font-size: 30px;"></i> <!-- Collapse icon -->
        </button>
        <button id="toggleExpand" class="btn" title="Expand Sidebar" style="display: none;"> <!-- Hide by default -->
            <i class="bi bi-arrow-right-circle" style="font-size: 30px;"></i> <!-- Expand icon -->
        </button>
    </div>
</div>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top" style="margin-left: 250px; width: calc(100% - 250px); z-index: 10;">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle me-2"></i>
                        <?php echo $_SESSION['namalengkap']; ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li class="dropdown-item">
                            <strong><?php echo $_SESSION['namalengkap']; ?></strong>
                            <br>
                            <small><?php echo $_SESSION['email']; ?></small>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="../page/logout.php">Log Out</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Page Content -->
<div id="content" style="margin-top: 56px;">
    <?php include 'dashboard.php'; // Include the content file ?>
</div>

<!-- Bootstrap JS and Icons -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../asset/js/admin.js"></script>
</body>
</html>
