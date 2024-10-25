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
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../asset/css/admin.css">
    <style>
        /* CSS untuk styling tabel */
        .table {
            margin-top: 20px;
        }
        .table th, .table td {
            text-align: center; /* Center the text */
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

   <!-- Search Users Section on the Right -->
<div class="d-flex align-items-center">
<label for="entriesSelect" class="me-2">Search </label>
    <input type="text" class="form-control w-75 me-2" placeholder="Cari pengguna..." id="searchInput" value="<?php echo htmlspecialchars($searchQuery); ?>" onkeypress="if(event.key === 'Enter') searchUser()">
</div>

</div>
   
    <!-- Tabel User -->
    <div class="container mt-4">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th> <!-- Change ID to No -->
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $counter = $offset + 1; // Initialize counter for sequential numbers ?>
                <?php while ($user = mysqli_fetch_assoc($userResult)): ?>
                    <tr>
                        <td><?php echo $counter++; ?></td> <!-- Display sequential number -->
                        <td><?php echo $user['namalengkap']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td>
                            <?php
                            // Menampilkan role sesuai dengan nilai dari database
                            switch ($user['role']) {
                                case 0:
                                    echo "Pasien";
                                    break;
                                case 1:
                                    echo "Admin";
                                    break;
                                case 2:
                                    echo "Pakar";
                                    break;
                                default:
                                    echo "Unknown";
                            }
                            ?>
                        </td>
                        <td>
                            <!-- Button to trigger update modal -->
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateModal-<?php echo $user['id']; ?>">
                                Ubah
                            </button>
                            <!-- Delete Button -->
                            <a href="../handler/pengguna/admin-hapuspengguna.php?id=<?php echo $user['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">Hapus</a>
                        </td>
                    </tr>

                    <!-- Update Modal -->
                    <div class="modal fade" id="updateModal-<?php echo $user['id']; ?>" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateModalLabel">Ubah Pengguna</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form method="POST" action="../handler/pengguna/admin-ubahpengguna.php">
                                <div class="modal-body">
                                        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                        <div class="mb-3">
                                            <label for="namalengkap" class="form-label">Nama Lengkap</label>
                                            <input type="text" class="form-control" name="namalengkap" value="<?php echo $user['namalengkap']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" name="email" value="<?php echo $user['email']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="role" class="form-label">Role</label>
                                            <select name="role" class="form-select" required>
                                                <option value="0" <?php echo $user['role'] == 0 ? 'selected' : ''; ?>>Pasien</option>
                                                <option value="1" <?php echo $user['role'] == 1 ? 'selected' : ''; ?>>Admin</option>
                                                <option value="2" <?php echo $user['role'] == 2 ? 'selected' : ''; ?>>Pakar</option>
                                            </select>
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
                    <a class="page-link" href="?page=<?php echo $page - 1; ?>&limit=<?php echo $limit; ?>&search=<?php echo htmlspecialchars($searchQuery); ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?php if ($page == $i) echo 'active'; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>&limit=<?php echo $limit; ?>&search=<?php echo htmlspecialchars($searchQuery); ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?php if ($page >= $totalPages) echo 'disabled'; ?>">
                    <a class="page-link" href="?page=<?php echo $page + 1; ?>&limit=<?php echo $limit; ?>&search=<?php echo htmlspecialchars($searchQuery); ?>" aria-label="Next">
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
                            <option value="0">Pasien</option>
                            <option value="1">Admin</option>
                            <option value="2">Pakar</option>
                        </select>
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
</body>
</html>
