<?php include 'header.php'; ?>

    
    <section class="login-section d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card p-4 shadow">
                    <h2 class="text-center" style="color: #d62268;">Selamat Datang</h2>
                    <p class="text-center">Silahkan masukan email & password</p>
                    <br>
                    <?php if (isset($error)) { echo "<p class='text-danger'>$error</p>"; } ?>
                    <form method="POST" action="../handler/pengguna/role-pengguna.php">
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control" name="email" placeholder="Masukan email" required>
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

                        <button type="submit" class="btn btn-primary w-100" style="background-color: #d62268;">Masuk</button>
                    </form>
                     <!-- Display error message if set -->
                     <?php if (!empty($error)): ?>
                            <div class="alert alert-danger mt-3">
                                <?php echo $error; ?>
                            </div>
                        <?php endif; ?>

                    <div class="text-center mt-3">
                        <a href="register.php" class="text-decoration-none" style="color: #d62268;">Apakah kamu belum punya akun? Daftar Disini</a><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

<script>
    // Toggle visibility of password
    document.querySelectorAll('.toggle-password').forEach(item => {
        item.addEventListener('click', function () {
            const passwordInput = this.previousElementSibling;
            const icon = this.querySelector('i');

            // Toggle between password and text input
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
