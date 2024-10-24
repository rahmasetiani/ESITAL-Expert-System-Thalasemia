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
    
    <section class="login-section d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card p-4 shadow">
                    <h2 class="text-center" style="color: #d62268;">Selamat Datang</h2>
                    <p class="text-center">Silahkan masukan email & password</p>
                    <br>
                    <?php if (isset($error)) { echo "<p class='text-danger'>$error</p>"; } ?>
                    <form method="POST" action="../handler/aturanloginuser.php">
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" name="password" placeholder="Enter your password" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100" style="background-color: #d62268;">Login</button>
                    </form>
                     <!-- Display error message if set -->
                     <?php if (!empty($error)): ?>
                            <div class="alert alert-danger mt-3">
                                <?php echo $error; ?>
                            </div>
                        <?php endif; ?>

                    <div class="text-center mt-3">
                        <a href="register.php" class="text-decoration-none" style="color: #d62268;">Don't have an account? Register here</a><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<style>
    .login-section {
        background-color: #f8f9fa;
        padding: 60px 0;
    }
    .card {
        border-radius: 8px;
        border: none;
    }
    .input-group-text {
        background-color: #d62268;
        color: white;
    }
</style>


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