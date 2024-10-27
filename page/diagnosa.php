<?php
session_start();
require '../database/koneksi.php'; // Make sure to include your database connection

// Fetch symptoms from the database
include '../handler/gejala/get_gejala.php';
include '../handler/proses_cbr/prosesawal.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EXSITHAL</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../asset/css/index.css">
    <link rel="stylesheet" href="../asset/css/footer.css">
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
                        <li class="nav-item"><a class="nav-link" href="../index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="tentang.php">Tentang</a></li>
                        <li class="nav-item"><a class="nav-link" href="informasi.php">Informasi</a></li>
                        <li class="nav-item"><a class="nav-link active" href="diagnosa.php">Diagnosa</a></li>
                    </ul>
                    <ul class="navbar-nav">
                        <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                            <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                        <?php else: ?>
                            <li class="nav-item"><a class="nav-link" href="login.php">Login / Register</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
        <!-- Form Section -->
        <section class="py-5 text-center" id="form-section">
            <div class="container" style="max-width: 800px; margin: auto;">
                <?php if ($_SESSION['form_step'] == 1): ?>
                    <h2 class="navbar-brand large-text" style="color: #d62268;">Deteksi Dini Thalassemia</h2><br>
                    <h3 style="color: #757375;">Masukan Data Diri Anda</h3><br>
                    <form method="POST">
                        <div class="mb-3 row text-start">
                            <label for="nama" class="col-sm-4 col-form-label" style="color: #000;">Masukkan Nama</label>
                            <div class="col-sm-8"><input type="text" class="form-control" id="nama" name="nama" required></div>
                        </div>
                        <div class="mb-3 row text-start">
                            <label for="tanggal_lahir" class="col-sm-4 col-form-label" style="color: #000;">Masukkan Tanggal Lahir</label>
                            <div class="col-sm-8"><input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required></div>
                        </div>
                        <div class="mb-3 row text-start">
                            <label for="alamat" class="col-sm-4 col-form-label" style="color: #000;">Alamat</label>
                            <div class="col-sm-8"><input type="text" class="form-control" id="alamat" name="alamat" required></div>
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
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-secondary">Next</button>
                        </div>
                    </form>
                <?php elseif ($_SESSION['form_step'] == 2): ?>
                    <h2 class="navbar-brand large-text" style="color: #d62268;">Deteksi Dini Thalassemia</h2><br>
                    <h3 style="color: #757375;">Masukan Gejala yang Sedang Anda Alami</h3><br>
                    <form method="POST">
                        <table class="symptom-table">
                            <tr>
                                <?php
                                $index = 0;
                                foreach ($symptoms as $row) {
                                    if ($index % 2 == 0 && $index != 0) echo '</tr><tr>'; // Start a new row every 2 cells

                                    echo '<td class="symptom-cell">
                                            <div class="symptom-checkbox">
                                                <input class="form-check-input" type="checkbox" name="gejala[]" id="' . $row['kodegejala'] . '" value="' . $row['kodegejala'] . '" style="width: 1.2em; height: 1.2em;">
                                                <label for="' . $row['kodegejala'] . '">(' . $row['kodegejala'] . ') ' . $row['namagejala'] . '</label>
                                            </div>
                                          </td>';

                                    $index++;
                                }
                                if ($index % 2 != 0) echo '<td class="symptom-cell"></td>'; // Fill last row if it's uneven
                                ?>
                            </tr>
                        </table>
                        <br>
                        <?php if (!empty($error_message)): ?>
        <script>
            alert("<?php echo $error_message; ?>"); // Show error message in a popup
        </script>
    <?php endif; ?>
                        <div class="d-flex justify-content-start mt-4">
    <button type="submit" name="back" class="btn btn-secondary me-2">Kembali</button>

</div>

                        
                        <!-- Back Button and Next Button -->
<div class="d-flex justify-content-center mt-4">
    <button type="submit" class="btn custom-btn btn-lg">Mulai Deteksi</button>
</div>

                    </form>
                <?php endif; ?>
            </div>
        </section>
    <?php else: ?>
        <section class="py-5 text-center" id="belum-login">
            <div class="container">
                <br><br><br><br><br><br>
                <h2 class="navbar-brand" style="color: #d62268;">Mohon Maaf ... </h2>
                <h2 style="color: #757375;">Anda Perlu Login Terlebih Dahulu !</h2>
                <p class="lead" style="color: #757375;">
                    Sebelum melanjutkan, silakan lakukan login untuk mengakses informasi dan layanan lebih lanjut.
                    Dengan login, Anda akan mendapatkan dukungan terbaik dari kami dan akses ke sumber daya yang bermanfaat.
                </p>
                <a href="login.php" class="btn custom-btn btn-lg">Login/Register</a>
                <br><br><br><br><br><br>
            </div>
        </section>
    <?php endif; ?>
    
    <!-- Footer -->
  
    
    <!-- Footer -->
    <footer class="bg-dark text-white text-center text-md-start py-4">
        <div class="container">
            <div class="row">
                <!-- Office Info -->
                <div class="col-md-4">
                    <h5 style="color: #d62268;">Our Office</h5>
                    <p><i class="fas fa-map-marker-alt" style="margin-right: 8px;"></i> Banyumas, Jawa Tengah</p>
                    <p><i class="fas fa-globe" style="margin-right: 8px;"></i> <a href="#" class="text-white" target="_blank">rsudbms.banyumaskab.go.id</a></p>
                    <p><i class="fas fa-phone" style="margin-right: 8px;"></i> +62 811-2622-009</p>
                </div>
                <!-- Links -->
                <div class="col-md-4">
                    <h5 style="color: #d62268;">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="../index.php" class="text-white"><i class="fas fa-chevron-right" style="color: #d62268;"></i> Home</a></li>
                        <li><a href="tentang.php" class="text-white"><i class="fas fa-chevron-right" style="color: #d62268;"></i> Tentang</a></li>
                        <li><a href="informasi.php" class="text-white"><i class="fas fa-chevron-right" style="color: #d62268;"></i> Informasi</a></li>
                        <li><a href="diagnosa.php" class="text-white"><i class="fas fa-chevron-right" style="color: #d62268;"></i> Diagnosa</a></li>
                    </ul>
                </div>
                <!-- Follow Us -->
                <div class="col-md-4">
                    <h5 style="color: #d62268;">Follow Us</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white"><i class="fab fa-facebook-f"></i> Facebook</a></li>
                        <li><a href="#" class="text-white"><i class="fab fa-twitter"></i> Twitter</a></li>
                        <li><a href="#" class="text-white"><i class="fab fa-instagram"></i> Instagram</a></li>
                        <li><a href="#" class="text-white"><i class="fab fa-linkedin-in"></i> LinkedIn</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"></script>
</body>
</html>
