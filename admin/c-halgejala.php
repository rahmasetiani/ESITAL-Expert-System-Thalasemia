<?php
session_start();
require '../database/koneksi.php';

if (!isset($_SESSION['email'])) {
    header("Location: ../page/login.php");
    exit();
}
include '../handler/gejala/pagination-gejala.php'; // Manage pagination and user listing
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

        <!-- Search Gejala Section on the Right -->
        <div class="d-flex align-items-center">
            <label for="searchInput" class="me-2">Search</label>
            <input type="text" class="form-control w-75 me-2" placeholder="Cari gejala..." id="searchInput" value="<?php echo htmlspecialchars($searchQuery); ?>" onkeypress="if(event.key === 'Enter') searchGejala()">
        </div>
    </div>

    <div class="container mt-4">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Kode Gejala</th>
                    <th class="text-center">Nama Gejala</th>
                    <th class="text-center">Bobot</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($gejalaResult) > 0): ?>
                    <?php $counter = $offset + 1; ?>
                    <?php while ($gejala = mysqli_fetch_assoc($gejalaResult)): ?>
                        <tr>
                            <td class="text-center"><?php echo $counter++; ?></td>
                            <td class="text-center"><?php echo $gejala['kodegejala']; ?></td>
                            <td class="text-center"><?php echo $gejala['namagejala']; ?></td>
                            <td class="text-center"><?php echo $gejala['bobot']; ?></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateModal-<?php echo $gejala['kodegejala']; ?>">Ubah</button>
                                <a href="../handler/gejala/admin-hapusgejala.php?kodegejala=<?php echo $gejala['kodegejala']; ?>&limit=<?php echo $limit; ?>&page=<?php echo $page; ?>&search=<?php echo htmlspecialchars($searchQuery); ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus gejala ini?');">Hapus</a>
                            </td>
                        </tr>

                        <!-- Update Modal -->
                        <div class="modal fade" id="updateModal-<?php echo $gejala['kodegejala']; ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="../handler/gejala/admin-ubahgejala.php?limit=<?php echo $limit; ?>&page=<?php echo $page; ?>&search=<?php echo htmlspecialchars($searchQuery); ?>">
                                        <div class="modal-body">
                                            <input type="hidden" name="kodegejala" value="<?php echo $gejala['kodegejala']; ?>">
                                            <div class="mb-3">
                                                <label for="nama_gejala" class="form-label">Nama Gejala</label>
                                                <input type="text" class="form-control" name="nama_gejala" value="<?php echo $gejala['namagejala']; ?>" required>
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

    <!-- Add Gejala Modal -->
    <div class="modal fade" id="addGejalaModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="../handler/gejala/admin-tambahgejala.php?limit=<?php echo $limit; ?>&page=<?php echo $page; ?>&search=<?php echo htmlspecialchars($searchQuery); ?>">
                    <div class="modal-body">
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

</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../asset/js/admin.js"></script>

</body>
</html>
