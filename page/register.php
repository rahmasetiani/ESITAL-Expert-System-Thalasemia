<?php include 'header.php'; ?>

<section class="login-section d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <!-- Card to create a box around the form -->
                <div class="card p-4 shadow">
                    <h2 class="text-center" style="color: #d62268;">Buat Akun</h2>
                    <p class="text-center">Silahkan masukan data pribadi untuk membuat akun</p>
                    <br>
                    <form action="../handler/pengguna/user-tambahpengguna.php" method="POST">
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control" id="namalengkap" name="namalengkap" placeholder="Masukan nama" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Masukan email" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Masukan password" required>
                                <span class="input-group-text toggle-password" style="cursor: pointer;">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Konfirmasi password" required>
                                <span class="input-group-text toggle-password" style="cursor: pointer;">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                            </div>
                        </div>

                        <!-- New Fields -->
                        <div class="mb-3">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                    <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-home"></i></span>
                                <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukan alamat" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100" style="background-color: #d62268;">Buat Akun</button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="login.php" class="text-decoration-none" style="color: #d62268;">Apakah kamu sudah punya akun? Masuk disini</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Toggle visibility of password fields
    document.querySelectorAll('.toggle-password').forEach(item => {
        item.addEventListener('click', function () {
            const passwordInput = this.previousElementSibling;
            const icon = this.querySelector('i');

            // Toggle password visibility
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        });
    });


</script>


<?php include 'footer.php'; ?>
