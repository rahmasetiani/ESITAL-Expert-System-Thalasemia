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
    exit();
}

// Define pagination variables
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10; // Default limit
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Search query (optional)
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';

// Build the query based on the search query
$searchCondition = !empty($searchQuery) ? "WHERE namagejala LIKE '%" . mysqli_real_escape_string($conn, $searchQuery) . "%'" : '';
$query = "SELECT * FROM gejala $searchCondition LIMIT $limit OFFSET $offset";

// Execute the query and check for errors
$gejalaResult = mysqli_query($conn, $query);
if (!$gejalaResult) {
    die("Query failed: " . mysqli_error($conn));
}

// Fetch total rows for pagination
$totalQuery = "SELECT COUNT(*) AS total FROM gejala $searchCondition";
$totalResult = mysqli_query($conn, $totalQuery);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalPages = ceil($totalRow['total'] / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Gejala</title>
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
    <h2>Daftar Gejala</h2>
    <a href="z-dashboard.php" style="text-decoration: none; color: #d62268;">Dashboard</a> /
    <a href="c-halgejala.php" style="text-decoration: none; color: #d62268;">Daftar Gejala</a> 

    <!-- Search and Limit section -->
    <div class="d-flex justify-content-between align-items-center mt-4">
        <div class="d-flex align-items-center">
            <label for="entriesSelect" class="me-2">Lihat</label>
            <select id="entriesSelect" class="form-select w-auto" onchange="changeLimit(this.value)">
                <option value="10" <?php if ($limit == 10) echo 'selected'; ?>>10</option>
                <option value="15" <?php if ($limit == 15) echo 'selected'; ?>>15</option>
                <option value="20" <?php if ($limit == 20) echo 'selected'; ?>>20</option>
            </select>
            <span class="ms-2 me-2">Baris</span>
        </div>

        <!-- Search Gejala Section on the Right -->
        <div class="d-flex align-items-center">
            <input type="text" class="form-control w-75 me-2" placeholder="Nama Gejala" id="searchInput" 
                value="<?php echo htmlspecialchars($searchQuery); ?>" 
                onkeypress="if(event.key === 'Enter') searchGejala()">
            <button type="button" class="btn btn-primary" onclick="searchGejala()">
                <i class="fas fa-search"></i>
            </button>
        </div>

    </div>

    <!-- Tabel Gejala -->
    <div class="container mt-4">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
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
                                <td class="text-center"><?php echo htmlspecialchars($gejala['kodegejala']); ?></td>
                                <td class="text-center"><?php echo htmlspecialchars($gejala['namagejala']); ?></td>
                                <td class="text-center"><?php echo htmlspecialchars($gejala['bobot']); ?></td>
                                <td class="text-center">
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateModal-<?php echo $gejala['kodegejala']; ?>"><i class="fas fa-edit"></i> </button>
                                <a href="../handler/gejala/admin-hapusgejala.php?kodegejala=<?php echo $gejala['kodegejala']; ?>&limit=<?php echo $limit; ?>&page=<?php echo $page; ?>&search=<?php echo htmlspecialchars($searchQuery); ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus gejala ini?');"><i class="fas fa-trash-alt"></i></a>
                            </td>
                            </tr>
                            <!-- Update Modal -->
                        <div class="modal fade" id="updateModal-<?php echo $gejala['kodegejala']; ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="../handler/gejala/admin-ubahgejala.php" enctype="multipart/form-data">
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
    </div>

    <!-- Pagination Controls -->
    <div class="pagination-container">
        <nav aria-label="Page navigation">
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../asset/js/admin.js"></script>
</body>
</html>

<script>
function searchGejala() {
    const searchQuery = document.getElementById('searchInput').value;
    const currentUrl = window.location.href;
    const url = new URL(currentUrl);
    url.searchParams.set('search', searchQuery);
    window.location.href = url.toString();
}

function changeLimit(limit) {
    const currentUrl = window.location.href;
    const url = new URL(currentUrl);
    url.searchParams.set('limit', limit);
    window.location.href = url.toString();
}

</script>
