<?php 
session_start();

require '../database/koneksi.php'; // database

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EXSITHAL</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../asset/css/index.css">
    <link rel="stylesheet" href="../asset/css/footer.css">
    <link rel="stylesheet" href="../asset/css/info.css">
    <link rel="stylesheet" href="../asset/css/login.css">
    <link rel="stylesheet" href="../asset/css/diagnosa.css">  

</head>
<body>
    <!-- Navbar -->
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">EXSI<span style="color: #d62268;">THAL</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="tentang.php">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="informasi.php">Informasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="diagnosa.php">Deteksi Dini</a>
                    </li>
                    <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                        <li class="nav-item">
                            <a class="nav-link active" href="riwayat.php">Riwayat Deteksi</a>
                        </li>
                    <?php endif; ?>
                </ul>
                <ul class="navbar-nav">
                    <!-- Check if user is logged in -->
                    <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
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
                        <li><a class="dropdown-item" href="../page/pengaturan.php">Pengaturan</a></li>
                        <li><a class="dropdown-item" href="../page/logout.php">Keluar</a></li>
                    </ul>
                </li>

                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Masuk / Daftar</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>
