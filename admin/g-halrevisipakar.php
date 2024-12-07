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
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Query untuk mengambil data dengan filter tanggal dan nama
$query = "SELECT * FROM hasil WHERE hasil_similarity IS NULL";

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
    <title>Riwayat Pasien</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../asset/css/admin.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }
        .pagination-container {
            margin-top: 20px;
        }
        .form-select, .form-control {
            max-width: 150px;
        }
        .table th, .table td {
            text-align: center;
        }
        .btn-custom {
            padding: 8px 15px;
            font-size: 14px;
        }
        .filter-form input, .filter-form button {
            margin-left: 10px;
        }
        .page-item.disabled .page-link {
            background-color: #f1f1f1;
            border-color: #ddd;
        }
        .card-body {
            overflow-x: auto;
        }
    </style>
</head>
<body>
<?php include 'sidebar.php'; ?>
<?php include 'navbar.php'; ?>

<div id="content" style="margin-top: 56px;">
    <h2>Daftar Riwayat Deteksi</h2>

    <div class="container my-5">
        <div class="d-flex align-items-center mb-4">
            <label for="entriesSelect" class="me-2">Lihat</label>
            <select id="entriesSelect" class="form-select w-auto" onchange="changeLimit(this.value)">
                <option value="5" <?php if ($limit == 5) echo 'selected'; ?>>5</option>
                <option value="10" <?php if ($limit == 10) echo 'selected'; ?>>10</option>
                <option value="15" <?php if ($limit == 15) echo 'selected'; ?>>15</option>
            </select>
            <span class="ms-2 me-2">Baris</span>
        </div>

        <!-- Filter By Date and Name -->
        <form method="get" class="filter-form d-flex justify-content-end align-items-center mb-4">
            <input type="date" name="filter_date" value="<?= htmlspecialchars($filter_date); ?>" class="form-control me-2">
            <input type="text" name="filter_name" value="<?= htmlspecialchars($filter_name); ?>" class="form-control me-2" placeholder="Nama Pasien">
            <button type="submit" class="btn btn-primary btn-custom">
                <i class="fas fa-search"></i> Cari
            </button>
        </form>

        <!-- Tabel untuk menampilkan semua hasil -->
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Pasien</th>
                        <th>Tanggal Pemeriksaan</th>
                        <th>Gejala Terpilih</th>
                        <th>Hasil Diagnosa</th>
                        <th>Similarity</th>
                        <th>Dokumen</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    foreach ($allResults as $result) {
                        echo "<tr>
                                <td>" . $no++ . "</td>
                                <td>" . htmlspecialchars($result['nama_pasien']) . "</td>
                                <td>" . htmlspecialchars($result['created_at']) . "</td>
                                <td>" . htmlspecialchars($result['gejala_terpilih']) . "</td>
                                <td>" . htmlspecialchars($result['hasil_diagnosa']) . "</td>
                                <td>" . htmlspecialchars($result['hasil_similarity']) . "%</td>
                                <td>
                                    <a href='../page/cetak_hasillangsung.php?idhasil=" . $result['idhasil'] . "' class='btn btn-outline-primary'>
                                        <i class='fas fa-print'></i> Cetak
                                    </a>
                                </td>
                                <td>
                                    <a href='?delete_id=" . $result['idhasil'] . "' class='btn btn-outline-danger' onclick='return confirm(\"Apakah Anda yakin ingin menghapus riwayat ini?\")'>
                                        <i class='fas fa-trash-alt'></i> Hapus
                                    </a>
                                </td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
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
