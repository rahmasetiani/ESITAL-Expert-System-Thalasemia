<?php
session_start();
require '../database/koneksi.php';

// Redirect if user is not logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../page/login.php");
    exit();
}

include '../handler/basiskasus/pagination-basiskasus.php'; // Manage pagination and user listing
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Basis Kasus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../asset/css/admin.css">
</head>
<body>

<?php include 'sidebar.php'; ?>
<?php include 'navbar.php'; ?>

<div id="content" style="margin-top: 56px;">
    <h2>Daftar Basis Kasus</h2>
    <a href="z-dashboard.php" style="text-decoration: none; color: #d62268;">Dashboard</a> /
    <a href="d-halbasiskasus.php" style="text-decoration: none; color: #d62268;">Daftar Basus Kasus</a> 

    <!-- Add Basis Kasus Modal Trigger -->
    <div class="d-flex justify-content-between align-items-center mt-4">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addGejalaModal">
        <i class="bi bi-person-plus"></i>Tambah Basis Kasus
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

        <!-- Search Gejala Section on the Right -->
        <div class="d-flex align-items-center">
            <input type="text" class="form-control w-75 me-2" placeholder="Basis Kasus Penyakit" id="searchInput" value="<?php echo htmlspecialchars($searchQuery); ?>" onkeypress="if(event.key === 'Enter') searchBasisKasus()">
            <button type="submit" class="btn btn-primary" onclick="searchBasisKasus()">
            <i class="fas fa-search"></i>
        </div>
    </div>

    <!-- Modal for Adding Basis Kasus -->
    <div class="modal fade" id="addGejalaModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="../handler/basiskasus/admin-tambahbasiskasus.php">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Basis Kasus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="kodepenyakit" class="form-label">Nama Penyakit</label>
                            <select name="kodepenyakit" class="form-select" required>
                                <?php 
                                $penyakitResult = mysqli_query($conn, "SELECT * FROM penyakit");
                                while ($penyakit = mysqli_fetch_assoc($penyakitResult)): ?>
                                    <option value="<?php echo htmlspecialchars($penyakit['kodepenyakit']); ?>">
                                        <?php echo htmlspecialchars($penyakit['namapenyakit']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="kodegejala" class="form-label">Pilih Gejala</label>
                            <div>
                                <?php 
                                $gejalaResult = mysqli_query($conn, "SELECT * FROM gejala");
                                while ($gejala = mysqli_fetch_assoc($gejalaResult)): ?>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="kodegejala[]" value="<?php echo htmlspecialchars($gejala['kodegejala']); ?>" id="gejala-<?php echo htmlspecialchars($gejala['kodegejala']); ?>">
                                        <label class="form-check-label" for="gejala-<?php echo htmlspecialchars($gejala['kodegejala']); ?>">
                                            <?php echo htmlspecialchars($gejala['namagejala'] . ' - Bobot: ' . $gejala['bobot']); ?>
                                        </label>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="tambah" class="btn btn-primary">Tambah Basis Kasus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<!-- Tabel User -->
<div class="container mt-4">
        <!-- Add table-responsive class here -->
        <div class="table-responsive">
            <br>
            <table class="table table-striped table-hover">
    <thead>
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">Kode Basis Kasus</th>
            <th class="text-center">Nama Penyakit</th>
            <th class="text-center">Gejala</th>
            <th class="text-center">Bobot</th>
            <th class="text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
    <?php if (mysqli_num_rows($basiskasusResult) > 0): ?>

    <?php $counter = $startNumber; while ($row = mysqli_fetch_assoc($basiskasusResult)): ?>

        <tr>
                <td class="text-center"><?php echo $counter++; ?></td>
                <td class="text-center"><?php echo htmlspecialchars($row['kodebasiskasus']); ?></td>
                <td class="text-center"><?php echo htmlspecialchars($row['namapenyakit']); ?></td>
                <td class="text-center">
                    <?php
                    // Fetch all gejala for this basis kasus
                    $gejalaQuery = "
                        SELECT g.namagejala 
                        FROM basiskasus_gejala bg 
                        JOIN gejala g ON bg.kodegejala = g.kodegejala 
                        WHERE bg.kodebasiskasus = '".htmlspecialchars($row['kodebasiskasus'])."'
                    ";
                    $gejalaResult = mysqli_query($conn, $gejalaQuery);
                    $gejalaList = [];
                    while ($gejalaRow = mysqli_fetch_assoc($gejalaResult)) {
                        $gejalaList[] = htmlspecialchars($gejalaRow['namagejala']);
                    }
                    echo implode('<br>', $gejalaList); // Display all gejala
                    ?>
                </td>
                <td class="text-center">
                    <?php
                    // Fetch bobot for the gejala related to this basis kasus
                    $bobotQuery = "
                        SELECT g.bobot 
                        FROM basiskasus_gejala bg 
                        JOIN gejala g ON bg.kodegejala = g.kodegejala 
                        WHERE bg.kodebasiskasus = '".htmlspecialchars($row['kodebasiskasus'])."'
                    ";
                    $bobotResult = mysqli_query($conn, $bobotQuery);
                    $bobotList = [];
                    while ($bobotRow = mysqli_fetch_assoc($bobotResult)) {
                        $bobotList[] = htmlspecialchars($bobotRow['bobot']);
                    }
                    echo implode('<br>', $bobotList); // Display all bobot
                    ?>
                </td>
                <td class="text-center">
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal-<?php echo htmlspecialchars($row['kodebasiskasus']); ?>"> <i class="fas fa-edit"></i> </button>
                    <a href="../handler/basiskasus/admin-hapusbasiskasus.php?kodebasiskasus=<?php echo htmlspecialchars($row['kodebasiskasus']); ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')"><i class="fas fa-trash-alt"></i></a>
                </td>
            </tr>
            <!-- Edit Modal -->
            <div class="modal fade" id="editModal-<?php echo htmlspecialchars($row['kodebasiskasus']); ?>">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" action="../handler/basiskasus/admin-ubahbasiskasus.php">
                            <div class="modal-header">
                                <h5 class="modal-title">Ubah Basis Kasus <?php echo htmlspecialchars($row['kodebasiskasus']); ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="kodebasiskasus" value="<?php echo htmlspecialchars($row['kodebasiskasus']); ?>">
                                <div class="mb-3">
                                    <label for="kodepenyakit" class="form-label">Nama Penyakit</label>
                                    <select name="kodepenyakit" class="form-select" required>
                                        <?php 
                                        $penyakitResult = mysqli_query($conn, "SELECT * FROM penyakit");
                                        while ($penyakit = mysqli_fetch_assoc($penyakitResult)): ?>
                                            <option value="<?php echo htmlspecialchars($penyakit['kodepenyakit']); ?>" <?php echo $row['kodepenyakit'] == $penyakit['kodepenyakit'] ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($penyakit['namapenyakit']); ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="kodegejala" class="form-label">Pilih Gejala</label>
                                    <div>
                                        <?php 
                                        $gejalaResult = mysqli_query($conn, "SELECT * FROM gejala");
                                        while ($gejala = mysqli_fetch_assoc($gejalaResult)): ?>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" name="kodegejala[]" value="<?php echo htmlspecialchars($gejala['kodegejala']); ?>" id="gejala-<?php echo htmlspecialchars($gejala['kodegejala']); ?>"
                                                    <?php 
                                                    // Check if this gejala is already linked to the basis kasus
                                                    $checkedQuery = "SELECT * FROM basiskasus_gejala WHERE kodebasiskasus='" . htmlspecialchars($row['kodebasiskasus']) . "' AND kodegejala='" . htmlspecialchars($gejala['kodegejala']) . "'";
                                                    $checkedResult = mysqli_query($conn, $checkedQuery);
                                                    if (mysqli_num_rows($checkedResult) > 0) echo 'checked'; ?>>
                                                <label class="form-check-label" for="gejala-<?php echo htmlspecialchars($gejala['kodegejala']); ?>">
                                                    <?php echo htmlspecialchars($gejala['namagejala'] . ' - Bobot: ' . $gejala['bobot']); ?>
                                                </label>
                                            </div>
                                        <?php endwhile; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" name="ubah" class="btn btn-primary">Ubah Basis Kasus</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
        <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada basis kasus yang tersedia.</td>
                    </tr>
        <?php endif; ?>
    </tbody>
</table> <br>
</div>
</div>
           <!-- Pagination Controls -->
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
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../asset/js/admin.js"></script>

</body>
</html>
