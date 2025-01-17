<?php
session_start();
require '../database/koneksi.php';

// Redirect if user is not logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../page/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../asset/css/admin.css">
</head>
<body>

<?php include 'sidebar.php'; ?>
<?php include 'navbar.php'; ?>

<div id="content" style="margin-top: 56px;">
    <h2>Pengaturan Profile</h2>
    <a href="z-dashboard.php" style="text-decoration: none; color: #d62268;">Dashboard</a> /
    <a href="pengaturan.php" style="text-decoration: none; color: #d62268;">Pengaturan Profile</a> 
    <br>
<?php
// Inisialisasi variabel
$namalengkap = '';
$email = '';
$password = '';
$tanggal_lahir = '';
$jenis_kelamin = '';
$alamat = '';
$role = '';

// Memastikan pengguna sudah login
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    // Ambil user ID dari session
    $userId = $_SESSION['user_id'];

    // Query untuk mendapatkan data pengguna
    $sql = "SELECT namalengkap, email, password, tanggal_lahir, jenis_kelamin, alamat, role FROM user WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->bind_result($namalengkap, $email, $password, $tanggal_lahir, $jenis_kelamin, $alamat, $role);
        $stmt->fetch();
        $stmt->close();
    }
}

// Proses update data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $namalengkap = $_POST['namalengkap'];
    $email = $_POST['email'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $new_password = $_POST['password'];

    if (!empty($new_password) && strlen($new_password) < 5) {
        echo "<script>alert('Password harus minimal 5 karakter!'); window.location.href='pengaturan.php';</script>";
        exit;
    }

    // Hash password jika diisi
    $password_hashed = empty($new_password) ? $password : password_hash($new_password, PASSWORD_DEFAULT);

    // Update ke database
    $sql = "UPDATE user SET namalengkap = ?, email = ?, password = ?, tanggal_lahir = ?, jenis_kelamin = ?, alamat = ? WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param(
            "ssssssi",
            $namalengkap,
            $email,
            $password_hashed,
            $tanggal_lahir,
            $jenis_kelamin,
            $alamat,
            $userId
        );
        $stmt->execute();
        $stmt->close();

        echo "<script>alert('Profil berhasil diperbarui!'); window.location.href='pengaturan.php';</script>";
        exit;
    } else {
        die("Error: " . $conn->error);
    }
}
?>

<br>
    <!-- Form Profil -->
<div class="container ms-5" style="max-width: 1000px; background-color: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
        <form method="POST" action="">
        <div class="row g-4 justify-content-center">
        <!-- Kolom Kiri -->
                <div class="col-md-6">
                    <div class="mb-3 text-start">
                        <label for="namalengkap" class="form-label fw-bold" style="color: #000000;">
                            <i class="bi bi-person"></i> Nama Lengkap
                        </label>
                        <input type="text" class="form-control" id="namalengkap" name="namalengkap" value="<?php echo htmlspecialchars($namalengkap); ?>" required>
                    </div>

                    <div class="mb-3 text-start">
                        <label for="tanggal_lahir" class="form-label fw-bold" style="color: #000000;">
                            <i class="bi bi-calendar-date"></i> Tanggal Lahir
                        </label>
                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?php echo htmlspecialchars($tanggal_lahir); ?>" required>
                    </div>
                    <div class="mb-3 text-start">
                        <label for="alamat" class="form-label fw-bold" style="color: #000000;">
                            <i class="bi bi-house-door"></i> Alamat
                        </label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?php echo htmlspecialchars($alamat); ?></textarea>
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="col-md-6">
                    <div class="mb-3 text-start">
                        <label for="email" class="form-label fw-bold" style="color: #000000;">
                            <i class="bi bi-envelope"></i> Email
                        </label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                    </div>
                    <div class="mb-3 text-start">
                        <label for="jenis_kelamin" class="form-label fw-bold" style="color: #000000;">
                            <i class="bi bi-gender-ambiguous"></i> Jenis Kelamin
                        </label>
                        <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="Laki-Laki" <?php echo $jenis_kelamin === 'Laki-Laki' ? 'selected' : ''; ?>>Laki-Laki</option>
                            <option value="Perempuan" <?php echo $jenis_kelamin === 'Perempuan' ? 'selected' : ''; ?>>Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3 text-start">
                        <label for="password" class="form-label fw-bold" style="color: #000000;">
                            <i class="bi bi-key"></i> Password Baru
                        </label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password">
                            <button type="button" class="btn btn-outline-secondary toggle-password">
                                <i class="bi bi-eye-slash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Submit -->
            <div class="text-end mt-4">
                <button type="submit" class="btn" style="background-color: #d62268; color: white; border: none; padding: 10px 20px;">Simpan Perubahan</button>
            </div>

        </form>
    </div>
</section>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../asset/js/admin.js"></script>
</body>
</html>

<script>
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function () {
            const input = this.previousElementSibling; // Ambil input sebelum tombol
            const icon = this.querySelector('i'); // Ambil ikon dalam tombol
            
            if (input.type === 'password') {
                input.type = 'text'; // Ubah tipe input menjadi text
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye'); // Ubah ikon menjadi mata terbuka
            } else {
                input.type = 'password'; // Kembalikan ke tipe password
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash'); // Ubah ikon menjadi mata tertutup
            }
        });
    });
</script>

