<!-- navbar.php -->
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top" style="z-index: 10;">
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
                        <li><a class="dropdown-item" href="pengaturan.php">Pengaturan</a></li>
                        <li><a class="dropdown-item" href="../page/logout.php">Keluar</a></li>
                    </ul>
                </li>
                <!-- Displaying Sidebar Menu Items Only on Small Screens
                <li class="nav-item d-lg-none">
                    <a href="z-dashboard.php" class="nav-link">
                    <i class="bi bi-house-door me-3"></i>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item d-lg-none">
                    <a href="a-halpengguna.php" class="nav-link">
                        <i class="bi bi-person-circle me-3"></i>
                        Data Pengguna
                    </a>
                </li>
                <li class="nav-item d-lg-none">
                    <a href="b-halpenyakit.php" class="nav-link">
                        <i class="bi bi-heart me-3"></i>
                        Data Penyakit
                    </a>
                </li>
                <li class="nav-item d-lg-none">
                    <a href="c-halgejala.php" class="nav-link">
                        <i class="bi bi-symmetry-horizontal me-3"></i>
                        Data Gejala
                    </a>
                </li>
                <li class="nav-item d-lg-none">
                    <a href="d-halbasiskasus.php" class="nav-link">
                        <i class="bi bi-file-earmark me-3"></i>
                        Basis Kasus
                    </a>
                </li>
                <li class="nav-item d-lg-none">
                    <a href="e-halambangbatas.php" class="nav-link">
                        <i class="bi bi-arrow-up-right-circle me-3"></i>
                        Ambang Batas
                    </a>
                </li>
                <li class="nav-item d-lg-none">
                    <a href="f-halriwayatpasien.php" class="nav-link">
                     <i class="bi bi-clock-history me-3"></i>
                        Data Riwayat Deteksi
                    </a>
                </li>
                <li class="nav-item d-lg-none">
                    <a href="f-halriwayatpasien.php" class="nav-link">
                        <i class="bi bi-pencil-square me-3"></i>
                        Data Butuh Revisi Pakar
                    </a>
                </li> -->
            </ul>
        </div>
    </div>
</nav>

<!-- Optional CSS for better control on small screens -->
<style>
    @media (max-width: 768px) {
        /* Sidebar menu items in navbar will only be visible on small screens */
        .navbar-nav .nav-item.d-lg-none {
            display: block; /* Display on small screens */
        }

        /* The navbar will behave as expected, with collapsible items on small screens */
        .navbar-nav {
            text-align: left;
        }
    }
    @media (min-width: 768px) {
        /* Hide the navbar menu items on larger screens */
        .navbar-nav .nav-item.d-lg-none {
            display: none;
        }
    }
</style>
