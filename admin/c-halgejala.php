<?php
session_start();
require '../database/koneksi.php';

if (!isset($_SESSION['email'])) {
    header("Location: ../page/login.php");
    exit();
}

$email = $_SESSION['email'];
$query = "SELECT namalengkap, role FROM user WHERE email = '$email'";
$result = mysqli_query($conn, $query);

if ($row = mysqli_fetch_assoc($result)) {
    $_SESSION['namalengkap'] = $row['namalengkap'];
    $_SESSION['role'] = $row['role'];
} else {
    echo "User not found!";
}

include '../handler/pagination.php'; // Pagination and listing logic
// Query untuk mengambil data gejala
$queryGejala = "SELECT kodegejala, namagejala, bobot FROM gejala LIMIT $limit OFFSET $offset";
$gejalaResult = mysqli_query($conn, $queryGejala);

// Cek apakah query berhasil
if (!$gejalaResult) {
    die("Error executing query: " . mysqli_error($conn));
}

// Ambil kode gejala terakhir
$queryLastKode = "SELECT kodegejala FROM gejala ORDER BY kodegejala DESC LIMIT 1";
$resultLastKode = mysqli_query($conn, $queryLastKode);

if ($row = mysqli_fetch_assoc($resultLastKode)) {
    $lastKode = (int) substr($row['kodegejala'], 1); // Mengambil angka setelah 'G'
    $nextKodeGejala = $lastKode + 1;
} else {
    $nextKodeGejala = 1; // Jika belum ada data, mulai dari 1
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Gejala</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../asset/css/admin.css">
</head>
<body>

<?php include 'sidebar.php'; ?>
<?php include 'navbar.php'; ?>

<div id="content" style="margin-top: 56px;">
    <h2>Daftar Gejala</h2>

    <div class="d-flex justify-content-between align-items-center mt-4">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addGejalaModal">
            Tambah Gejala
        </button>
    </div>

    <div class="container mt-4">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Gejala</th>
                    <th>Nama Gejala</th>
                    <th>Bobot</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($gejalaResult) > 1): ?>
                    <?php $counter = $offset + 1; ?>
                    <?php while ($gejala = mysqli_fetch_assoc($gejalaResult)): ?>
                        <tr>
                            <td><?php echo $counter++; ?></td>
                            <td><?php echo $gejala['kodegejala']; ?></td>
                            <td><?php echo $gejala['nama_gejala']; ?></td>
                            <td><?php echo $gejala['bobot']; ?></td>
                            <td>
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateModal-<?php echo $gejala['id']; ?>">Ubah</button>
                                <a href="../handler/gejala/admin-hapusgejala.php?id=<?php echo $gejala['id']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus gejala ini?');">Hapus</a>
                            </td>
                        </tr>

                        <!-- Update Modal -->
                        <div class="modal fade" id="updateModal-<?php echo $gejala['id']; ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="../handler/gejala/admin-ubahgejala.php">
                                        <div class="modal-body">
                                            <input type="hidden" name="id" value="<?php echo $gejala['id']; ?>">
                                            <div class="mb-3">
                                                <label for="kodegejala" class="form-label">Kode Gejala</label>
                                                <input type="text" class="form-control" name="kodegejala" value="<?php echo $gejala['kodegejala']; ?>" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label for="nama_gejala" class="form-label">Nama Gejala</label>
                                                <input type="text" class="form-control" name="nama_gejala" value="<?php echo $gejala['nama_gejala']; ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="bobot" class="form-label">Bobot</label>
                                                <input type="number" class="form-control" name="bobot" value="<?php echo $gejala['bobot']; ?>" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" name="update_gejala" class="btn btn-primary">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data gejala yang tersedia.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="addGejalaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="../handler/gejala/admin-tambahgejala.php">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="kodegejala" class="form-label">Kode Gejala</label>
                        <input type="text" class="form-control" name="kodegejala" value="G<?php echo sprintf('%03d', $nextKodeGejala); ?>" readonly>
                        </div>
                    <div class="mb-3">
                        <label for="nama_gejala" class="form-label">Nama Gejala</label>
                        <input type="text" class="form-control" name="nama_gejala" required>
                    </div>
                    <div class="mb-3">
                        <label for="bobot" class="form-label">Bobot</label>
                        <input type="number" class="form-control" name="bobot" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="add_gejala" class="btn btn-primary">Tambah Gejala</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../asset/js/admin.js"></script>
</body>
</html>
