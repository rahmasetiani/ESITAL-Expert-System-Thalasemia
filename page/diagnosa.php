<?php
session_start();
require '../database/koneksi.php'; // Pastikan koneksi database sudah benar

// Memasukkan file handler untuk mengambil gejala dan proses awal
include '../handler/gejala/get_gejala.php';
include '../handler/diagnosa/prosesawal.php';
?>

<!-- Header (gunakan include untuk memisah header) -->
<?php include 'header.php'; ?>

<?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
    <!-- Form Section -->
    <section class="py-5 text-center" id="form-section">
        <div class="container" style="max-width: 800px;"> <!-- Set max-width to 800px -->
            <?php if ($_SESSION['form_step'] == 1): ?>
                <h2 class="navbar-brand large-text" style="color: #d62268; margin-bottom: 1rem; text-shadow: 1px 1px 3px rgba(0,0,0,0.2);">Deteksi Dini Thalassemia</h2>
                <h3 style="color: #757375; margin-bottom: 2rem;">Masukan Data Diri Anda</h3>
                <form method="POST">
                    <div class="mb-4 row text-start">
                        <label for="nama" class="col-sm-4 col-form-label" style="color: #000;">Masukkan Nama</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="nama" name="nama" required style="box-shadow: 0px 4px 8px rgba(0,0,0,0.1);">
                        </div>
                    </div>
                    <div class="mb-4 row text-start">
                        <label for="tanggal_lahir" class="col-sm-4 col-form-label" style="color: #000;">Masukkan Tanggal Lahir</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required style="box-shadow: 0px 4px 8px rgba(0,0,0,0.1);">
                        </div>
                    </div>
                    <div class="mb-4 row text-start">
                        <label for="alamat" class="col-sm-4 col-form-label" style="color: #000;">Alamat</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="alamat" name="alamat" required style="box-shadow: 0px 4px 8px rgba(0,0,0,0.1);">
                        </div>
                    </div>
                    <div class="mb-4 row text-start">
                        <label for="jenis_kelamin" class="col-sm-4 col-form-label" style="color: #000;">Jenis Kelamin</label>
                        <div class="col-sm-8">
                            <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required style="box-shadow: 0px 4px 8px rgba(0,0,0,0.1);">
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
                <h2 class="navbar-brand large-text" style="color: #d62268; margin-bottom: 1rem; text-shadow: 1px 1px 3px rgba(0,0,0,0.2);">Deteksi Dini Thalassemia</h2>
                <h3 style="color: #757375; margin-bottom: 2rem;">Masukan Gejala yang Sedang Anda Alami</h3>
                <form method="POST">
                    <!-- Table to display gejala -->
                    <div class="table-responsive">
                        <table class="table table-bordered" style="border-collapse: collapse; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                            <thead style="background-color: #d62268; color: white; text-shadow: 1px 1px 5px rgba(0,0,0,0.3);">
                                <tr>
                                    <th style="width: 120px; padding: 8px; text-align: center;">Kode Gejala</th>
                                    <th style="padding: 8px; text-align: center;">Nama Gejala</th>
                                    <th style="width: 100px; padding: 8px; text-align: center;">Checklist</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $index = 0;
                                foreach ($symptoms as $row) {
                                    echo '<tr style="background-color: #f9f9f9; border-bottom: 1px solid #ddd;">
                                            <td style="text-align: center; padding: 8px; font-weight: bold; color: #555;">' . $row['kodegejala'] . '</td>
                                            <td style="padding: 8px; color: #333;">' . $row['namagejala'] . '</td>
                                            <td style="text-align: center; padding: 8px;">
                                                <input class="form-check-input" type="checkbox" name="gejala[]" value="' . $row['kodegejala'] . '" style="width: 1.5em; height: 1.5em;">
                                            </td>
                                          </tr>';
                                    $index++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <?php if (!empty($error_message)): ?>
                        <script>
                            alert("<?php echo $error_message; ?>"); // Tampilkan pesan kesalahan di popup
                        </script>
                    <?php endif; ?>
                    
                    <!-- Back Button -->
                    <div class="d-flex justify-content-start mt-4">
                        <button type="submit" name="back" class="btn btn-secondary me-2" style="margin-right: auto;">Kembali</button>
                    </div>

                    <!-- Next Button -->
                    <div class="d-flex justify-content-center mt-4">
                        <button type="submit" class="btn custom-btn btn-lg">Mulai Deteksi</button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </section>
<?php else: ?>
    <section class="py-5 text-center" id="belum-login">
        <div class="container" style="max-width: 800px;"> <!-- Set max-width to 800px -->
            <br><br><br><br><br><br>
            <h2 class="navbar-brand" style="color: #d62268;">Mohon Maaf ... </h2>
            <h2 style="color: #757375;">Anda Perlu Login Terlebih Dahulu!</h2>
            <p class="lead" style="color: #757375;">
                Sebelum melanjutkan, silakan lakukan login untuk mengakses informasi dan layanan lebih lanjut.
            </p>
            <a href="login.php" class="btn custom-btn btn-lg">Login/Register</a>
            <br><br><br><br><br><br>
        </div>
    </section>
<?php endif; ?>

<!-- Footer (gunakan include untuk memisah footer) -->
<?php include 'footer.php'; ?>
