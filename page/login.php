<?php
session_start();
?>

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

<?php include 'footer.php'; ?>
