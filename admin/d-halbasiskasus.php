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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../asset/css/admin.css">
</head>
<body>

<?php include 'sidebar.php'; ?>
<?php include 'navbar.php'; ?>

<div id="content" style="margin-top: 56px;">
    <h2>Daftar Basis Kasus</h2>

    <!-- Add Basis Kasus Modal Trigger -->
    <div class="d-flex justify-content-between align-items-center mt-4">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addGejalaModal">
            Tambah Basis Kasus
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
            <input type="text" class="form-control w-75 me-2" placeholder="Cari gejala..." id="searchInput" value="<?php echo htmlspecialchars($searchQuery); ?>" onkeypress="if(event.key === 'Enter') searchBasisKasus()">
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

    <!-- Data Table -->
    <div class="container mt-4">
    <table class="table table-striped">
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
        <?php $counter = 1; while ($row = mysqli_fetch_assoc($basiskasusResult)): ?>
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
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal-<?php echo htmlspecialchars($row['kodebasiskasus']); ?>">Ubah</button>
                    <a href="../handler/basiskasus/admin-hapusbasiskasus.php?kodebasiskasus=<?php echo htmlspecialchars($row['kodebasiskasus']); ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
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

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../asset/js/admin.js"></script>

</body>
</html>
