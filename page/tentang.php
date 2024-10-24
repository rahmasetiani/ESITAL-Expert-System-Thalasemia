<?php
session_start();
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
    <link rel="stylesheet" href="../asset/css/index.css">
    <link rel="stylesheet" href="../asset/css/footer.css">
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
                            <a class="nav-link active" href="../index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="tentang.php">Tentang</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="informasi.php">Informasi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="diagnosa.php">Diagnosa</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <!-- Check if user is logged in -->
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

<!-- Apa Itu Thalassemia Section -->
<section class="py-5 text-center">
    <div class="container">
        <h2 style="color: #757375;">Apa itu <span style="color: #d62268;">Yayasan Thalassemia</span>?</h2>
        <p class="lead" style="color: #757375;">
        Yayasan Thalassemia adalah organisasi yang dibentuk untuk mendukung pasien thalassemia, sebuah penyakit genetik yang mempengaruhi kemampuan tubuh untuk memproduksi hemoglobin dengan normal. Yayasan ini bertujuan untuk memberikan edukasi, informasi, dan layanan dukungan kepada pasien dan keluarga mereka, serta meningkatkan kesadaran masyarakat tentang thalassemia.
        </p>
    </div>

</section>

<!-- About Us Section -->
<section class="about-us py-5">
    <div class="container" style="color: #757375;">
        <div class="row align-items-center">
            <div class="col-md-6">
                <img src="../asset/image/thalassemia.jpg" alt="About Us" class="img-fluid rounded">
            </div>
            <div class="col-md-6">
            <a class="navbar-brand large-text" style="color: #757375;">Yayasan</a>
            <a class="navbar-brand large-text" style="color: #d62268;">Thalassemia Banyumas</a>
            <p class="text-justify" style="text-align: justify;">
            Yayasan Thalassemia Banyumas adalah sebuah organisasi nirlaba yang didirikan untuk memberikan dukungan dan informasi kepada pasien thalassemia serta keluarganya di daerah Banyumas. Yayasan ini berfokus pada peningkatan kesadaran tentang thalassemia, sebuah penyakit genetik yang mempengaruhi produksi hemoglobin, dan menyediakan berbagai layanan, termasuk konsultasi medis, pendidikan tentang manajemen penyakit, serta dukungan psikologis
</p>
<p class="text-justify" style="text-align: justify;">Melalui program-programnya, Yayasan Thalassemia Banyumas berupaya membantu pasien menjalani kehidupan yang lebih baik dan berdaya, serta mendorong upaya pencegahan melalui pemeriksaan dan edukasi di masyarakat.
</p>
<a href="diagnosa.php" class="btn custom-btn btn-lg">Detesi Dini Thalassemia</a>

</div>
        </div>
    </div>
</section>

<style>
    section {
        background-color: #f8f9fa; /* Warna latar belakang yang lembut */
        background-image: linear-gradient(135deg, rgba(255, 255, 255, 0.2), rgba(0, 0, 0, 0.05)); /* Tekstur warna */
    }
</style>
        <!-- Footer -->
<footer class="bg-dark text-white text-center text-md-start py-4">
    <div class="container">
        <div class="row">
            <!-- Our Office Column -->
            <div class="col-md-4">
                <h5 style="color: #d62268;"> Our Office</h5>
                <p><i class="fas fa-map-marker-alt" style="margin-right: 8px;"></i></i> Jl. Rumah Sakit No.1, Karangpucung, Kejawar, Kec. Banyumas, Kabupaten Banyumas, Jawa Tengah 53192</p>
                <p><i class="fas fa-globe" style="margin-right: 8px;"></i></i> <a href="http://rsudbms.banyumaskab.go.id/" class="text-white" target="_blank"> rsudbms.banyumaskab.go.id</a></p>
                <p><i class="fas fa-phone" style="margin-right: 8px;"></i></i> +62 811-2622-009</p>
            </div>
            
            <!-- Quick Links Column -->
            <div class="col-md-4">
                <h5 style="color: #d62268;">Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="../index.php" class="text-white"><i class="fas fa-chevron-right" style="color: #d62268;"></i> Home</a></li>
                    <li><a href="tentang.php" class="text-white"><i class="fas fa-chevron-right" style="color: #d62268;"></i> Tentang Kami</a></li>
                    <li><a href="informasi.php" class="text-white"><i class="fas fa-chevron-right" style="color: #d62268;"></i> Informasi</a></li>
                    <li><a href="diagnosa.php" class="text-white"><i class="fas fa-chevron-right" style="color: #d62268;"></i> Diagnosa</a></li>
                </ul>
            </div>

            <!-- Business Hours Column -->
            <div class="col-md-4">
                <h5 style="color: #d62268;">Business Hours</h5>
                <p>Monday - Thursday: 6:30 AM - 11:00 AM</p>
                <p>Friday - Saturday: 6:30 AM - 10:00 AM</p>
                <p>Sunday: Closed</p>
            </div>
        </div>
        
        <!-- Social Media Links -->
        <div class="social-media mt-4">
            <a href="https://facebook.com" class="btn btn-circle" style="background-color: #d62268;">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="https://instagram.com" class="btn btn-circle" style="background-color: #d62268;">
                <i class="fab fa-instagram"></i>
            </a>
            <a href="https://whatsapp.com" class="btn btn-circle" style="background-color: #d62268;">
                <i class="fab fa-whatsapp"></i>
            </a>
        </div>
    </div>
    
    <!-- Scroll to Top Button -->
    <a href="#" class="scroll-to-top" style="display: none;">
        <i class="fas fa-arrow-up"></i>
    </a>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../asset/js/index.js"></script>


</body>
</html>