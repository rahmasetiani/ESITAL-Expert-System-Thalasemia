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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../asset/css/admin.css">
    <style>
        .table {
            margin-top: 20px;
        }
        .table th, .table td {
            text-align: center;
        }
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }
        .pagination-container {
            margin-top: 20px;
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
    <a href="z-dashboard.php" style="text-decoration: none; color: #d62268;">Dashboard</a> /
    <a href="a-halpengguna.php" style="text-decoration: none; color: #d62268;">Daftar Pengguna</a>    
    <!-- Add User and Search Section -->
    <div class="d-flex justify-content-between align-items-center mt-4">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="bi bi-person-plus"></i> Tambah Pengguna
        </button>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-4">
        <!-- Show Entries Section on the Left -->
        <div class="d-flex align-items-center">
            <label for="entriesSelect" class="me-2">Lihat</label>
            <select id="entriesSelect" class="form-select w-auto" onchange="changeLimit(this.value)">
                <option value="10" <?php if ($limit == 10) echo 'selected'; ?>>10</option>
                <option value="20" <?php if ($limit == 20) echo 'selected'; ?>>20</option>
                <option value="30" <?php if ($limit == 30) echo 'selected'; ?>>30</option>
            </select>
            <span class="ms-2 me-2">Baris</span>
        </div>
        
        <!-- Search Pengguna Section on the Right -->
        <form method="GET" action="" class="d-flex align-items-center">
            <input type="text" id="searchInput" name="search" value="<?= htmlspecialchars($searchQuery); ?>" class="form-control w-75 me-2" placeholder="Nama Pengguna" onkeypress="if(event.key === 'Enter') searchPengguna()">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
    
    <!-- Tabel User -->
    <div class="container mt-4">
        <!-- Add table-responsive class here -->
        <div class="table-responsive">
            <table class="table table-striped table-hover">
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
                    <?php if (mysqli_num_rows($userResult) > 0): ?>
                        <?php
                        $counter = $offset + 1;
                        while ($user = mysqli_fetch_assoc($userResult)): ?>
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
                                    <!-- Add icons to buttons -->
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateModal-<?= $user['id']; ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <a href="../handler/pengguna/admin-hapuspengguna.php?id=<?= $user['id']; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus pengguna ini?');">
                                        <i class="fas fa-trash-alt"></i> 
                                    </a>
                                </td>
                            </tr>

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
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data pengguna yang tersedia.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        </div> <!-- End of table-responsive -->

        <!-- Pagination -->
        <div class="pagination-container">
            <nav aria-label="Page navigation" class="pagination-container">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?= $page <= 1 ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=1&limit=<?= $limit; ?>&search=<?= htmlspecialchars($searchQuery); ?>" aria-label="First">
                            <i class="fas fa-angle-double-left"></i> First
                        </a>
                    </li>
                    <li class="page-item <?= $page <= 1 ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?= $page - 1; ?>&limit=<?= $limit; ?>&search=<?= htmlspecialchars($searchQuery); ?>" aria-label="Previous">
                            <i class="fas fa-chevron-left"></i> Previous
                        </a>
                    </li>
                    <li class="page-item <?= $page >= $totalPages ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?= $page + 1; ?>&limit=<?= $limit; ?>&search=<?= htmlspecialchars($searchQuery); ?>" aria-label="Next">
                            <i class="fas fa-chevron-right"></i> Next
                        </a>
                    </li>
                    <li class="page-item <?= $page >= $totalPages ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?= $totalPages; ?>&limit=<?= $limit; ?>&search=<?= htmlspecialchars($searchQuery); ?>" aria-label="Last">
                            <i class="fas fa-angle-double-right"></i> Last
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
