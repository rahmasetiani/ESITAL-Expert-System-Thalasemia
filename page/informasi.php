<?php
session_start();
require '../database/koneksi.php';

// Fetch data from the penyakit table
include '../handler/penyakit/get_penyakit.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EXSITHAL - Informasi Penyakit</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="../asset/css/index.css">
    <link rel="stylesheet" href="../asset/css/footer.css">
    <link rel="stylesheet" href="../asset/css/info.css">
    
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
                            <a class="nav-link" href="../index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="tentang.php">Tentang</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="informasi.php">Informasi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="diagnosa.php">Diagnosa</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php">Logout</a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="login.php">Login / Register</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <section class="py-5 text-center">
    <h1 style="color: #757375;">Kategori & Informasi</h1>
    <h2 style="color: #d62268;"> Penyakit Thalassemia dan Deferensial Thalassemia </span>?</h2>
    <br>


        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex overflow-auto flex-nowrap">
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <div class="card h-100 me-2" style="min-width: 300px;">
                                <img src="../asset/image/penyakit/<?php echo $row['foto']; ?>" class="card-img-top" alt="<?php echo $row['namapenyakit']; ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $row['namapenyakit']; ?></h5>
                                    <p class="card-text" data-short-text="<?php echo htmlspecialchars(substr($row['deskripsi'], 0, 80)); ?>" data-full-text="<?php echo htmlspecialchars($row['deskripsi']); ?>">
                                        <?php 
                                        $shortDescription = substr($row['deskripsi'], 0, 80);
                                        if (strlen($row['deskripsi']) > 80) {
                                            echo $shortDescription . '...<br><a href="#" class="show-more">Show More</a>';
                                        } else {
                                            echo $shortDescription;
                                        }
                                        ?>
                                    </p>
                                    <strong>Solusi Pengobatan:</strong>
                                    <p class="card-text" data-short-text="<?php echo htmlspecialchars(substr($row['solusipengobatan'], 0, 80)); ?>" data-full-text="<?php echo htmlspecialchars($row['solusipengobatan']); ?>">
                                        <?php 
                                        $shortSolution = substr($row['solusipengobatan'], 0, 80);
                                        if (strlen($row['solusipengobatan']) > 80) {
                                            echo $shortSolution . '...<br><a href="#" class="show-more-solution">Show More</a>';
                                        } else {
                                            echo $shortSolution;
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center text-md-start py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5 style="color: #d62268;"> Our Office</h5>
                    <p><i class="fas fa-map-marker-alt" style="margin-right: 8px;"></i> Jl. Rumah Sakit No.1, Karangpucung, Kejawar, Kec. Banyumas, Kabupaten Banyumas, Jawa Tengah 53192</p>
                    <p><i class="fas fa-globe" style="margin-right: 8px;"></i> <a href="http://rsudbms.banyumaskab.go.id/" class="text-white" target="_blank"> rsudbms.banyumaskab.go.id</a></p>
                    <p><i class="fas fa-phone" style="margin-right: 8px;"></i> +62 811-2622-009</p>
                </div>
                <div class="col-md-4">
                    <h5 style="color: #d62268;">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="../index.php" class="text-white"><i class="fas fa-chevron-right" style="color: #d62268;"></i> Home</a></li>
                        <li><a href="tentang.php" class="text-white"><i class="fas fa-chevron-right" style="color: #d62268;"></i> Tentang Kami</a></li>
                        <li><a href="informasi.php" class="text-white"><i class="fas fa-chevron-right" style="color: #d62268;"></i> Informasi</a></li>
                        <li><a href="diagnosa.php" class="text-white"><i class="fas fa-chevron-right" style="color: #d62268;"></i> Diagnosa</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5 style="color: #d62268;">Business Hours</h5>
                    <p>Monday - Thursday: 6:30 AM - 11:00 AM</p>
                    <p>Friday - Saturday: 6:30 AM - 10:00 AM</p>
                    <p>Sunday: Closed</p>
                </div>
            </div>
            <div class="social-media mt-4">
                <a href="#" class="text-white me-2"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="text-white me-2"><i class="fab fa-twitter"></i></a>
                <a href="#" class="text-white me-2"><i class="fab fa-instagram"></i></a>
                <a href="#" class="text-white"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../asset/js/info.js"></script>

</body>
</html>
