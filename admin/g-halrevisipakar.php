<?php
// Pastikan koneksi ke database sudah benar
require '../database/koneksi.php';
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php'); // Redirect ke halaman login jika belum login
    exit;
}

// Filter berdasarkan tanggal dan nama
$filter_date = isset($_GET['filter_date']) ? $_GET['filter_date'] : '';
$filter_name = isset($_GET['filter_name']) ? $_GET['filter_name'] : '';

// Menentukan batasan jumlah data per halaman
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Query untuk mengambil data dengan filter tanggal dan nama
$query = "SELECT * FROM hasil WHERE hasil_similarity IS NULL AND status_revisi = 'pending'";

// Filter berdasarkan tanggal
if ($filter_date) {
    $query .= " AND created_at LIKE ?";
    $filter_date = $filter_date . '%';  // Format untuk filter tanggal (misalnya 2024-12-07%)
}

// Filter berdasarkan nama pasien
if ($filter_name) {
    $query .= " AND nama_pasien = ?"; // Ganti LIKE menjadi = agar pencarian tepat sesuai nama pasien
}

// Tambahkan limit dan offset untuk paginasi
$query .= " LIMIT ? OFFSET ?";


// Eksekusi query
$stmt = $conn->prepare($query);

// Bind parameter
if ($filter_date && $filter_name) {
    $stmt->bind_param("ssii", $filter_date, $filter_name, $limit, $offset);
} elseif ($filter_date) {
    $stmt->bind_param("sii", $filter_date, $limit, $offset);
} elseif ($filter_name) {
    $stmt->bind_param("sii", $filter_name, $limit, $offset);
} else {
    $stmt->bind_param("ii", $limit, $offset);
}

$stmt->execute();
$result = $stmt->get_result();

// Menyimpan semua hasil ke dalam array
$allResults = [];
while ($row = $result->fetch_assoc()) {
    // Menyaring hasil diagnosa dengan similarity tertinggi
    $keseluruhan_diagnosa = json_decode($row['keseluruhan_diagnosa'], true);
    $keseluruhan_similarity = json_decode($row['keseluruhan_similarity'], true);
    
    if (is_array($keseluruhan_similarity) && !empty($keseluruhan_similarity)) {
        // Mengambil nilai similarity tertinggi
        $max_similarity_index = array_keys($keseluruhan_similarity, max($keseluruhan_similarity))[0];
        $highest_similarity = $keseluruhan_similarity[$max_similarity_index];
        $highest_diagnosis = $keseluruhan_diagnosa[$max_similarity_index];
    } else {
        $highest_similarity = 'N/A';  // Jika tidak ada similarity
        $highest_diagnosis = 'N/A';  // Jika tidak ada diagnosa
    }

    // Tambahkan data yang telah diproses ke array
    $row['hasil_diagnosa_tertinggi'] = $highest_diagnosis;
    $row['hasil_similarity_tertinggi'] = $highest_similarity;
    $allResults[] = $row;
}

// Menghitung total hasil untuk paginasi
$countQuery = "SELECT COUNT(*) as total FROM hasil WHERE hasil_similarity IS NULL";
if ($filter_date) {
    $countQuery .= " AND created_at LIKE ?";
}
if ($filter_name) {
    $countQuery .= " AND nama_pasien LIKE ?";
}

$countStmt = $conn->prepare($countQuery);
if ($filter_date && $filter_name) {
    $countStmt->bind_param("ss", $filter_date, $filter_name);
} elseif ($filter_date) {
    $countStmt->bind_param("s", $filter_date);
} elseif ($filter_name) {
    $countStmt->bind_param("s", $filter_name);
}

$countStmt->execute();
$countResult = $countStmt->get_result()->fetch_assoc();
$total_records = $countResult['total'];
$total_pages = ceil($total_records / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Butuh Revisi Pakar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../asset/css/admin.css">
</head>
<body>
<?php include 'sidebar.php'; ?>
<?php include 'navbar.php'; ?>

<div id="content" style="margin-top: 56px;">
    <h2>Daftar Butuh Revisi Pakar</h2>
    <a href="z-dashboard.php" style="text-decoration: none; color: #d62268;">Dashboard</a> /
    <a href="g-halrevisipakar.php" style="text-decoration: none; color: #d62268;">Daftar Butuh Revisi Pakar</a> 

    <div class="d-flex justify-content-between align-items-center mt-4">
        <div class="d-flex align-items-center mb-4">
            <label for="entriesSelect" class="me-2">Lihat</label>
            <select id="entriesSelect" class="form-select w-auto" onchange="changeLimit(this.value)">
                <option value="10" <?php if ($limit == 10) echo 'selected'; ?>>10</option>
                <option value="15" <?php if ($limit == 15) echo 'selected'; ?>>15</option>
                <option value="20" <?php if ($limit == 20) echo 'selected'; ?>>20</option>
            </select>
            <span class="ms-2 me-2">Baris</span>
        </div>

        <!-- Filter By Date and Name -->
        <form method="get" class="filter-form d-flex justify-content-end align-items-center mb-4">
            <input type="date" name="filter_date" value="<?= htmlspecialchars($filter_date); ?>" class="form-control me-2">
            <input type="text" name="filter_name" value="<?= htmlspecialchars($filter_name); ?>" class="form-control me-2" placeholder="Nama Pasien">
            <button type="submit" class="btn btn-primary btn-custom">
                <i class="fas fa-search"></i> 
            </button>
        </form>
        </div>

        <!-- Tabel untuk menampilkan semua hasil -->
        <div class="container mt-4">
        <!-- Make the table responsive on smaller screens -->
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pasien</th>
                        <th>Tanggal Pemeriksaan</th>
                        <th>Gejala Terpilih</th>
                        <th>Hasil Diagnosa Tertinggi</th>
                        <th>Similarity</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (mysqli_num_rows(result: $result) > 0): ?>

    <?php 
    $no = 1;
    foreach ($allResults as $result) {
        echo "<tr>
                <td>" . $no++ . "</td>
                <td>" . htmlspecialchars($result['nama_pasien']) . "</td>
                <td>" . htmlspecialchars($result['created_at']) . "</td>
                <td>";
                    // Menampilkan gejala dengan setiap elemen pada baris baru
                    $gejalaArray = explode(',', $result['gejala_terpilih']);
                    echo implode('<br>', array_map('trim', $gejalaArray));
        echo "</td>
                <td>" . htmlspecialchars($result['hasil_diagnosa_tertinggi']) . "</td>
                <td>" . htmlspecialchars($result['hasil_similarity_tertinggi']) . "%</td>
                <td>
                    <a href='../handler/riwayathasil/admin-terimarevisipakar.php?idhasil=". $result['idhasil'] ."' class='btn btn-success'  onclick='return confirm(\"Apakah Anda yakin ingin menerima hasil ini?\")'>
                        <i class='fas fa-check-circle'></i> Terima
                    </a>
                    <a href='../handler/riwayathasil/admin-tolakrevisipakar.php?idhasil=" . $result['idhasil'] ."' class='btn btn-danger' onclick='return confirm(\"Apakah Anda yakin ingin menolak hasil ini?\")'>
                        <i class='fas fa-times-circle'></i> Tolak 
                    </a>
                </td>
              </tr>";
    }
    ?>
    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data butuh revisi pakar yang tersedia.</td>
                        </tr>
                    <?php endif; ?>
</tbody>
</table> <br>
        </div>
        </div>

        <!-- Navigasi Paginasi -->
        <nav aria-label="Page navigation" class="pagination-container">
            <ul class="pagination justify-content-center">
                <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                    <a class="page-link" href="?page=1&limit=<?= $limit; ?>&filter_date=<?= htmlspecialchars($filter_date); ?>&filter_name=<?= htmlspecialchars($filter_name); ?>" aria-label="First">
                        <i class="fas fa-angle-double-left"></i> First
                    </a>
                </li>
                <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                    <a class="page-link" href="?page=<?= $page - 1; ?>&limit=<?= $limit; ?>&filter_date=<?= htmlspecialchars($filter_date); ?>&filter_name=<?= htmlspecialchars($filter_name); ?>" aria-label="Previous">
                        <i class="fas fa-chevron-left"></i> Previous
                    </a>
                </li>
                <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?>">
                    <a class="page-link" href="?page=<?= $page + 1; ?>&limit=<?= $limit; ?>&filter_date=<?= htmlspecialchars($filter_date); ?>&filter_name=<?= htmlspecialchars($filter_name); ?>" aria-label="Next">
                        <i class="fas fa-chevron-right"></i> Next
                    </a>
                </li>
                <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?>">
                    <a class="page-link" href="?page=<?= $total_pages; ?>&limit=<?= $limit; ?>&filter_date=<?= htmlspecialchars($filter_date); ?>&filter_name=<?= htmlspecialchars($filter_name); ?>" aria-label="Last">
                        <i class="fas fa-angle-double-right"></i> Last
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>

<!-- JavaScript untuk mengubah limit per halaman -->
<script>
    function changeLimit(limit) {
        window.location.href = `?limit=${limit}&page=1`;
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../asset/js/admin.js"></script></body>
</html>
