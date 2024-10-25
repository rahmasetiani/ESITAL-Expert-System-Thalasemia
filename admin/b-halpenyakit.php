<?php
session_start();
require '../database/koneksi.php';

if (!isset($_SESSION['email'])) {
    header("Location: ../page/login.php");
    exit();
}

include '../handler/penyakit/pagination-penyakit.php'; // Manage pagination and user listing
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Penyakit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../asset/css/admin.css">
</head>
<body>

<?php include 'sidebar.php'; ?>
<?php include 'navbar.php'; ?>

<div id="content" style="margin-top: 56px;">
    <h2>Daftar Penyakit</h2>

    <div class="d-flex justify-content-between align-items-center mt-4">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPenyakitModal">
            Tambah Penyakit
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

        <!-- Search Penyakit Section on the Right -->
        <div class="d-flex align-items-center">
            <label for="searchInput" class="me-2">Search</label>
            <input type="text" class="form-control w-75 me-2" placeholder="Cari Penyakit..." id="searchInput" value="<?php echo htmlspecialchars($searchQuery); ?>" onkeypress="if(event.key === 'Enter') searchPenyakit()">
        </div>
    </div>

    <div class="container mt-4">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Kode Penyakit</th>
                    <th class="text-center">Nama Penyakit</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($penyakitResult) > 0): ?>
                    <?php $counter = $offset + 1; ?>
                    <?php while ($penyakit = mysqli_fetch_assoc($penyakitResult)): ?>
                        <tr>
                            <td class="text-center"><?php echo $counter++; ?></td>
                            <td class="text-center"><?php echo htmlspecialchars($penyakit['kodepenyakit']); ?></td>
                            <td class="text-center"><?php echo htmlspecialchars($penyakit['namapenyakit']); ?></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#detailModal-<?php echo $penyakit['kodepenyakit']; ?>">Detail</button>
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateModal-<?php echo $penyakit['kodepenyakit']; ?>">Ubah</button>
                                <a href="../handler/penyakit/admin-hapuspenyakit.php?kodepenyakit=<?php echo $penyakit['kodepenyakit']; ?>&limit=<?php echo $limit; ?>&page=<?php echo $page; ?>&search=<?php echo htmlspecialchars($searchQuery); ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus penyakit ini?');">Hapus</a>
                            </td>
                        </tr>

<!-- Detail Modal -->
<div class="modal fade" id="detailModal-<?php echo $penyakit['kodepenyakit']; ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md"> <!-- Narrower modal width with modal-md -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Penyakit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Display the image centered and with a fixed size -->
                <div class="text-center mb-3">
                    <img src="../asset/image/penyakit/<?php echo htmlspecialchars($penyakit['foto']); ?>" 
                         alt="<?php echo htmlspecialchars($penyakit['namapenyakit']); ?>" 
                         class="img-fluid rounded border" 
                         style="width: 100%; max-width: 150px;"> <!-- Adjusted image size -->
                </div>

                <!-- Display disease code and name -->
                <p><strong>Kode Penyakit:</strong> <?php echo htmlspecialchars($penyakit['kodepenyakit']); ?></p>
                <p><strong>Nama Penyakit:</strong> <?php echo htmlspecialchars($penyakit['namapenyakit']); ?></p>

                <!-- Deskripsi and Solusi Pengobatan sections with limited height and vertical scrolling -->
                <div class="container">
                    <div class="row mb-3">
                        <div class="col-12">
                            <strong>Deskripsi:</strong>
                            <div class="p-2 border rounded" 
                                 style="max-height: 150px; overflow-y: auto; white-space: pre-wrap;">
                                <?php echo nl2br(htmlspecialchars($penyakit['deskripsi'])); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <strong>Solusi Pengobatan:</strong>
                            <div class="p-2 border rounded" 
                                 style="max-height: 150px; overflow-y: auto; white-space: pre-wrap;">
                                <?php echo nl2br(htmlspecialchars($penyakit['solusipengobatan'])); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
                       


                        <!-- Update Modal -->
<div class="modal fade" id="updateModal-<?php echo $penyakit['kodepenyakit']; ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="../handler/penyakit/admin-ubahpenyakit.php" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Penyakit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="namapenyakit" class="form-label">Nama Penyakit</label>
                        <input type="text" class="form-control" name="namapenyakit" value="<?php echo htmlspecialchars($penyakit['namapenyakit']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" rows="3" required><?php echo htmlspecialchars($penyakit['deskripsi']); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="solusi" class="form-label">Solusi Pengobatan</label>
                        <textarea class="form-control" name="solusipengobatan" rows="3" required><?php echo htmlspecialchars($penyakit['solusipengobatan']); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar</label>
                        <input type="file" class="form-control" name="foto">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                    </div>
                    <input type="hidden" name="kodepenyakit" value="<?php echo htmlspecialchars($penyakit['kodepenyakit']); ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada data penyakit yang tersedia.</td>
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

    <!-- Add Penyakit Modal -->
    <div class="modal fade" id="addPenyakitModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="../handler/penyakit/admin-tambahpenyakit.php?limit=<?php echo $limit; ?>&page=<?php echo $page; ?>&search=<?php echo htmlspecialchars($searchQuery); ?>" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Penyakit</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_penyakit" class="form-label">Nama Penyakit</label>
                            <input type="text" class="form-control" name="nama_penyakit" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="solusi" class="form-label">Solusi Pengobatan</label>
                            <textarea class="form-control" name="solusi" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto</label>
                            <input type="file" class="form-control" name="foto" accept="image/*" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="add_penyakit" class="btn btn-primary">Tambah Penyakit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../asset/js/admin.js"></script>
</body>
</html>
