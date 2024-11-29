<?php
session_start();
require '../database/koneksi.php'; // File koneksi database

// Pastikan pengguna sudah login
if (!isset($_SESSION['email'])) {
    header("Location: ../page/login.php"); // Redirect ke login jika belum login
    exit();
}

include '../handler/pengguna/pagination-pengguna.php'; // Manage pagination and user listing
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengguna</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../asset/css/admin.css">
    <style>
        .table {
            margin-top: 20px;
        }
        .table th, .table td {
            text-align: center;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<?php include 'sidebar.php'; ?>

<!-- Navbar -->
<?php include 'navbar.php'; ?>

<!-- Page Content -->
<div id="content" style="margin-top: 56px;">
    <h2>Daftar Pengguna</h2>
    
    <!-- Add User and Search Section -->
    <div class="d-flex justify-content-between align-items-center mt-4">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addUserModal">
            Tambah Pengguna
        </button>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-4">
        <!-- Show Entries Section on the Left -->
        <div class="d-flex align-items-center">
            <label for="entriesSelect" class="me-2">Show</label>
            <select id="entriesSelect" class="form-select w-auto" onchange="changeLimit(this.value)">
                <option value="5" <?php if ($limit == 5) echo 'selected'; ?>>5</option>
                <option value="10" <?php if ($limit == 10) echo 'selected'; ?>>10</option>
                <option value="15" <?php if ($limit == 15) echo 'selected'; ?>>15</option>
            </select>
            <span class="ms-2 me-2">entries</span>
        </div>

        <!-- Search Pengguna Section on the Right -->
        <div class="d-flex align-items-center">
            <label for="searchInput" class="me-2">Cari</label>
            <input type="text" class="form-control w-75 me-2" placeholder="Cari Pengguna..." id="searchInput" value="<?php echo htmlspecialchars($searchQuery); ?>" onkeypress="if(event.key === 'Enter') searchPengguna()">
            </div>
    </div>
    
    <!-- Tabel User -->
    <div class="container mt-4">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Tanggal Lahir</th>
                    <th>Jenis Kelamin</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php
                // Mengambil data pengguna dari database
                $query = "SELECT * FROM user LIMIT $offset, $limit";
                $result = mysqli_query($conn, $query);
                $counter = $offset + 1;

                while ($user = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $counter++; ?></td>
                        <td><?= htmlspecialchars($user['namalengkap']); ?></td>
                        <td><?= htmlspecialchars($user['email']); ?></td>
                        <td>
                        <?php
                            switch ($user['role']) {
                                case 0: echo "Pasien"; break;
                                case 1: echo "Admin"; break;
                                case 2: echo "Pakar"; break;
                                default: echo "Unknown";
                            }
                            ?>
                        </td>
                        <td><?= htmlspecialchars(date('Y-m-d', strtotime($user['tanggal_lahir']))); ?></td>
                        <td><?= htmlspecialchars($user['jenis_kelamin']); ?></td>
                        <td><?= htmlspecialchars($user['alamat']); ?></td>
                        <td>
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateModal-<?= $user['id']; ?>">Ubah</button>
                            <a href="../handler/pengguna/admin-hapuspengguna.php?id=<?= $user['id']; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus pengguna ini?');">Hapus</a>
                        </td>
                    </tr>

              <!-- Update Modal -->
                    <!-- Update Modal -->
                    <div class="modal fade" id="updateModal-<?= $user['id']; ?>" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Ubah Pengguna</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form method="POST" action="../handler/pengguna/admin-ubahpengguna.php">
                                    <div class="modal-body">
                                        <input type="hidden" name="id" value="<?= $user['id']; ?>">
                                        <div class="mb-3">
                                            <label for="namalengkap" class="form-label">Nama Lengkap</label>
                                            <input type="text" class="form-control" name="namalengkap" value="<?= htmlspecialchars($user['namalengkap']); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($user['email']); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control" name="password">
                                        </div>
                                        <div class="mb-3">
                                            <label for="role" class="form-label">Role</label>
                                            <select name="role" class="form-select" required>
                                            <option value="0" <?= $user['role'] == 0 ? 'selected' : ''; ?>>Pasien</option>
                                                <option value="1" <?= $user['role'] == 1 ? 'selected' : ''; ?>>Admin</option>
                                                <option value="2" <?= $user['role'] == 2 ? 'selected' : ''; ?>>Pakar</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                            <input type="date" class="form-control" name="tanggal_lahir" value="<?= htmlspecialchars($user['tanggal_lahir']); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                            <select name="jenis_kelamin" class="form-select" required>
                                                <option value="Laki-laki" <?= $user['jenis_kelamin'] == "Laki-laki" ? 'selected' : ''; ?>>Laki-laki</option>
                                                <option value="Perempuan" <?= $user['jenis_kelamin'] == "Perempuan" ? 'selected' : ''; ?>>Perempuan</option>
                                            </select>
                                            </div>
                                        <div class="mb-3">
                                            <label for="alamat" class="form-label">Alamat</label>
                                            <textarea class="form-control" name="alamat" rows="3" required><?= htmlspecialchars($user['alamat']); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" name="update_user" class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </tbody>
        </table> 

        <!-- Pagination Controls -->
<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
            <a class="page-link" href="?page=<?php echo max($page - 1, 1); ?>&limit=<?php echo $limit; ?>&search=<?php echo htmlspecialchars($searchQuery); ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                <a class="page-link" href="?page=<?php echo $i; ?>&limit=<?php echo $limit; ?>&search=<?php echo htmlspecialchars($searchQuery); ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>
        <li class="page-item <?php if ($page >= $totalPages) echo 'disabled'; ?>">
            <a class="page-link" href="?page=<?php echo min($page + 1, $totalPages); ?>&limit=<?php echo $limit; ?>&search=<?php echo htmlspecialchars($searchQuery); ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
</nav>      
    </div>
</div>


<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Tambah Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="../handler/pengguna/admin-tambahpengguna.php">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="namalengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="namalengkap" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select name="role" class="form-select" required>
                            <option value="" disabled selected>Pilih Role</option>
                            <option value="0">Pasien</option>
                            <option value="1">Admin</option>
                            <option value="2">Pakar</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tanggal_lahir" required>
                    </div>
                    <div class="mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select" required>
                        <option value="" disabled selected>Pilih Jenis Kelamin</option>

                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" name="alamat" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="add_user" class="btn btn-primary">Tambah Pengguna</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../asset/js/admin.js"></script>
<script>
    // Search function
    function searchPengguna() {
        const searchQuery = document.getElementById('searchInput').value;
        window.location.href = `?page=1&limit=${document.getElementById('entriesSelect').value}&search=${searchQuery}`;
    }
    
    // Change pagination limit
    function changeLimit(limit) {
        const searchQuery = document.getElementById('searchInput').value;
        window.location.href = `?page=1&limit=${limit}&search=${searchQuery}`;
    }
</script>
</body>
</html>
</body>
</html>
