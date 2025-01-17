<?php
include 'header.php'; // Memanggil header
require '../database/koneksi.php'; // Koneksi ke database

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

    // Validasi password minimal 5 karakter
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

<!-- Halaman Pengaturan Profil -->
<section class="py-5 text-center" style="background-color: #f8f9fa;">
    <!-- Logo dan Judul Halaman -->
    <div class="mb-5">
        <h2 class="navbar-brand large-text mt-3" style="color: #d62268; text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2); font-weight: bold;">
            Pengaturan Profil
        </h2>
    </div>

    <!-- Form Profil -->
    <div class="container" style="max-width: 1000px; background-color: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
        <form method="POST" action="">
            <div class="row g-4">
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

<?php
include 'footer.php'; // Memanggil footer
?>

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
