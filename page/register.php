<?php
session_start();
?>

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
                                <input type="text" class="form-control" id="namalengkap" name="namalengkap" placeholder="Enter your name" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100" style="background-color: #d62268;">Buat Akun</button>
                    </form>
                    <div class="text-center mt-3">
                        <a href="login.php" class="text-decoration-none" style="color: #d62268;">Do you have an account? Login here</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
