<?php
session_start();
require '../database/koneksi.php';

if (!isset($_SESSION['email'])) {
    header("Location: ../page/login.php");
    exit();
}

include '../handler/penyakit/pagination-penyakit.php'; // Manage pagination and user listing
?>


<?php
 // Define pagination variables
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10; // Default limit
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Search query
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';

// Build the query based on the search query
$searchCondition = !empty($searchQuery) ? "WHERE namapenyakit LIKE '%" . mysqli_real_escape_string($conn, $searchQuery) . "%'" : '';
$query = "SELECT * FROM penyakit $searchCondition LIMIT $limit OFFSET $offset";

// Execute the query and check for errors
$penyakitResult = mysqli_query($conn, $query);
if (!$penyakitResult) {
    die("Query failed: " . mysqli_error($conn));
}

// Fetch total rows for pagination
$totalQuery = "SELECT COUNT(*) AS total FROM penyakit $searchCondition";
$totalResult = mysqli_query($conn, $totalQuery);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalPages = ceil($totalRow['total'] / $limit);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Penyakit</title>
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

<?php include 'sidebar.php'; ?>
<?php include 'navbar.php'; ?>

<div id="content" style="margin-top: 56px;">
    <h2>Daftar Penyakit</h2>

    <div class="d-flex justify-content-between align-items-center mt-4">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPenyakitModal">
        <i class="bi bi-person-plus"></i>Tambah Penyakit
        </button>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-4">
        <!-- Show Entries Section on the Left -->
        <div class="d-flex align-items-center">
            <label for="entriesSelect" class="me-2">Lihat</label>
            <select id="entriesSelect" class="form-select w-auto" onchange="changeLimit(this.value)">
                <option value="10" <?php if ($limit == 10) echo 'selected'; ?>>10</option>
                <option value="15" <?php if ($limit == 15) echo 'selected'; ?>>15</option>
                <option value="20" <?php if ($limit == 20) echo 'selected'; ?>>20</option>
            </select>
            <span class="ms-2 me-2">Baris</span>
        </div>

        <!-- Search Penyakit Section on the Right -->
        <div class="d-flex align-items-center">
            <input type="text" class="form-control w-75 me-2" placeholder="Nama Penyakit" id="searchInput" value="<?php echo htmlspecialchars($searchQuery); ?>" onkeypress="if(event.key === 'Enter') searchPenyakit()">
            <button type="submit" class="btn btn-primary">
            <i class="fas fa-search"></i>
        </button>
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
                                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#detailModal-<?php echo $penyakit['kodepenyakit']; ?>"><i class="fas fa-info-circle"></i> Detail</button>
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateModal-<?php echo $penyakit['kodepenyakit']; ?>"> <i class="fas fa-edit"></i> Ubah</button>
                                <a href="../handler/penyakit/admin-hapuspenyakit.php?kodepenyakit=<?php echo $penyakit['kodepenyakit']; ?>&limit=<?php echo $limit; ?>&page=<?php echo $page; ?>&search=<?php echo htmlspecialchars($searchQuery); ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus penyakit ini?');"><i class="fas fa-trash-alt"></i> Hapus</a>
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
