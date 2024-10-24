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
    <link rel="stylesheet" href="asset/css/index.css">
    <link rel="stylesheet" href="asset/css/footer.css">
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
                            <a class="nav-link active" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="page/tentang.php">Tentang</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="page/informasi.php">Informasi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="page/diagnosa.php">Diagnosa</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <!-- Check if user is logged in -->
                        <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="page/logout.php">Logout</a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="page/login.php">Login / Register</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero bg-dark text-white text-center d-flex align-items-center justify-content-center">
        <div class="container">
            <h6 class="navbar-brand welcome-text">WELCOME TO <a class="navbar-brand large-text">EXSI<span style="color: #d62268;">THAL</span></a>
            <h1 class="display-1">Expert System Penyakit Thalassemia</h1>
            <p class="lead">Powered by Yayasan Thalassemia Kabupaten Banyumas</p>
            <a href="#about-us"" class="btn custom-btn btn-lg">Jelajahi</a>
            </div>
    </section>
    <!-- About Us Section -->
<section class="about-us py-5" id="about-us">
    <div class="container" style="color: #757375;">
        <div class="row align-items-center">
            <div class="col-md-6">
                <img src="asset/image/tentang.jpg" alt="About Us" class="img-fluid rounded">
            </div>
            <div class="col-md-6">
    <a class="navbar-brand large-text" style="color: #757375;">EXSI<span style="color: #d62268;">THAL</span></a>
    <p class="lead">(Expert System Penyakit Thalassemia)</p>
    <p class="text-justify" style="text-align: justify;">
        EXSITHAL adalah sistem pakar yang didedikasikan untuk membantu deteksi dini penyakit thalassemia. 
        Dengan teknologi terbaru, kami bertujuan untuk memberikan informasi yang akurat dan bermanfaat 
        bagi masyarakat. Kami bekerja sama dengan berbagai pihak untuk meningkatkan kesadaran dan 
        pemahaman tentang thalassemia.
    </p>
    <p class="text-justify" style="text-align: justify;">
        Kami berkomitmen untuk menyediakan sumber daya dan dukungan yang dibutuhkan untuk individu dan keluarga yang terpengaruh oleh penyakit ini. Bersama-sama, kita dapat meningkatkan kualitas hidup mereka yang menderita thalassemia.
    </p>
</div>
        </div>
    </div>
</section>

<!-- Apa Itu Thalassemia Section -->
<section class="py-5 text-center">
    <div class="container">
        <h2 style="color: #757375;">Apa itu <span style="color: #d62268;">Thalassemia</span>?</h2>
        <p class="lead" style="color: #757375;">
            Thalassemia adalah gangguan darah yang diturunkan yang ditandai dengan produksi hemoglobin yang tidak normal. 
            Penyakit ini dapat menyebabkan anemia, kelelahan, dan masalah kesehatan lainnya. 
            Deteksi dini dan pengelolaan yang tepat dapat membantu meningkatkan kualitas hidup penderita.
        </p>
    </div>

</section>

<!-- About Us Section -->
<section class="about-us py-5">
    <div class="container" style="color: #757375;">
        <div class="row align-items-center">
            <div class="col-md-6">
                <img src="asset/image/anak.jpg" alt="About Us" class="img-fluid rounded">
            </div>
            <div class="col-md-6">
            <a class="navbar-brand large-text" style="color: #757375;">Tujuan <span style="color: #d62268;">Website Ini</span>:</a>
            <p class="text-justify" style="text-align: justify;">
            Website ini bertujuan untuk memberikan informasi yang akurat dan mendidik tentang thalassemia, 
    termasuk gejala, penyebab, dan pengelolaannya. Kami berkomitmen untuk meningkatkan kesadaran 
    tentang penyakit ini dan memberikan dukungan yang dibutuhkan oleh individu dan keluarga yang 
    terpengaruh.
</p>
<p class="text-justify" style="text-align: justify;">
Selain itu, website ini juga berfungsi sebagai platform untuk berbagi pengalaman, pengetahuan, 
    dan sumber daya. Kami berharap dapat menciptakan komunitas yang saling mendukung, 
    sehingga bersama-sama kita dapat meningkatkan kualitas hidup penderita thalassemia.
</p>
<a href="page/diagnosa.php" class="btn custom-btn btn-lg">Detesi Dini Thalassemia</a>

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
                    <li><a href="index.php" class="text-white"><i class="fas fa-chevron-right" style="color: #d62268;"></i> Home</a></li>
                    <li><a href="page/tentang.php" class="text-white"><i class="fas fa-chevron-right" style="color: #d62268;"></i> Tentang Kami</a></li>
                    <li><a href="page/informasi.php" class="text-white"><i class="fas fa-chevron-right" style="color: #d62268;"></i> Informasi</a></li>
                    <li><a href="page/diagnosa.php" class="text-white"><i class="fas fa-chevron-right" style="color: #d62268;"></i> Diagnosa</a></li>
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
<script src="asset/js/index.js"></script>


</body>
</html>