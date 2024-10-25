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
                            <a class="nav-link" href="../index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="tentang.php">Tentang</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="informasi.php">Informasi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="diagnosa.php">Diagnosa</a>
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

    <!-- Check if user is logged in -->
    <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
        <!-- Form Section -->
        <section class="py-5 text-center" id="form-section">
    <div class="container" style="max-width: 800px; margin: auto;">
        <h2 class="navbar-brand large-text" style="color: #d62268;">Deteksi Dini Thalassemia</h2><br>
        <h3 style="color: #757375;">Masukan Data Diri Anda</h3><br>
        <form action="your_form_processing_script.php" method="POST">
            <div class="mb-3 row text-start">
                <label for="nama" class="col-sm-4 col-form-label" style="color: #000;">Masukkan Nama</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
            </div>
            <div class="mb-3 row text-start">
                <label for="tanggal_lahir" class="col-sm-4 col-form-label" style="color: #000;">Masukkan Tanggal Lahir</label>
                <div class="col-sm-8">
                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                </div>
            </div>
            <div class="mb-3 row text-start">
                <label for="alamat" class="col-sm-4 col-form-label" style="color: #000;">Alamat</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="alamat" name="alamat" required>
                </div>
            </div>
            <div class="mb-3 row text-start">
                <label for="jenis_kelamin" class="col-sm-4 col-form-label" style="color: #000;">Jenis Kelamin</label>
                <div class="col-sm-8">
                    <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                        <option value="" disabled selected>Pilih Jenis Kelamin</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
            </div>
            <br>
            <h3 style="color: #757375;">Masukan Gejala yang Sedang Anda Alami</h3><br>
            <div class="row">
                <div class="col-sm-4">
                    <?php
                    // Simulated data from the database (replace with actual database fetch)
                    $gejala = ['Gejala 1', 'Gejala 2', 'Gejala 3', 'Gejala 4', 'Gejala 5'];
                    foreach ($gejala as $item) {
                        echo '<div class="form-check">
                                <input class="form-check-input" type="checkbox" name="gejala[]" id="' . $item . '" value="' . $item . '" style="width: 1.5em; height: 1.5em;">
                                <label class="form-check-label" for="' . $item . '" style="color: #000; font-size: 1.1em;">' . $item . '</label>
                              </div>';
                    }
                    ?>
                </div>
                <div class="col-sm-4">
                    <?php
                    // Additional symptoms (for demo, you can add more or fetch from database)
                    $gejala_additional = ['Gejala 6', 'Gejala 7', 'Gejala 8', 'Gejala 9', 'Gejala 10'];
                    foreach ($gejala_additional as $item) {
                        echo '<div class="form-check">
                                <input class="form-check-input" type="checkbox" name="gejala[]" id="' . $item . '" value="' . $item . '" style="width: 1.5em; height: 1.5em;">
                                <label class="form-check-label" for="' . $item . '" style="color: #000; font-size: 1.1em;">' . $item . '</label>
                              </div>';
                    }
                    ?>
                </div>
                <div class="col-sm-4">
                    <?php
                    // More symptoms to fill the third column
                    $gejala_third = ['Gejala 11', 'Gejala 12', 'Gejala 13', 'Gejala 14', 'Gejala 15'];
                    foreach ($gejala_third as $item) {
                        echo '<div class="form-check">
                                <input class="form-check-input" type="checkbox" name="gejala[]" id="' . $item . '" value="' . $item . '" style="width: 1.5em; height: 1.5em;">
                                <label class="form-check-label" for="' . $item . '" style="color: #000; font-size: 1.1em;">' . $item . '</label>
                              </div>';
                    }
                    ?>
                </div>
            </div>
            <button type="submit" class="btn custom-btn btn-lg">Mulai Deteksi</button>
        </form>
    </div>
</section>

    <?php else: ?>
        <!-- Login Prompt Section -->
        <section class="py-5 text-center" id="belum-login">
            <div class="container">
                <br><br><br><br><br><br><br><br><br>
                <h2 class="navbar-brand" style="color: #d62268;">Mohon Maaf ... </h2>
                <h2 style="color: #757375;">Anda Perlu Login Terlebih Dahulu !</h2>
                <p class="lead" style="color: #757375;">
                    Sebelum melanjutkan, silakan lakukan login untuk mengakses informasi dan layanan lebih lanjut. 
                    Dengan login, Anda akan mendapatkan dukungan terbaik dari kami dan akses ke sumber daya yang bermanfaat.
                </p>
                <br><br>
                <a href="login.php" class="btn custom-btn btn-lg">Login/Register</a>

                <br><br><br><br><br><br><br><br><br><br>
            </div>
        </section>
    <?php endif; ?>

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
                    <p><i class="fas fa-map-marker-alt" style="margin-right: 8px;"></i> Jl. Rumah Sakit No.1, Karangpucung, Kejawar, Kec. Banyumas, Kabupaten Banyumas, Jawa Tengah 53192</p>
                    <p><i class="fas fa-globe" style="margin-right: 8px;"></i> <a href="http://rsudbms.banyumaskab.go.id/" class="text-white" target="_blank"> rsudbms.banyumaskab.go.id</a></p>
                    <p><i class="fas fa-phone" style="margin-right: 8px;"></i> +62 811-2622-009</p>
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
