<?php
require '../database/koneksi.php'; 
include 'header.php';
// File untuk koneksi database

// Memeriksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Mendapatkan ID pengguna yang sedang login
$iduser = $_SESSION['user_id'];

// Mendapatkan nomor halaman dan menetapkan limit untuk paginasi
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;  // Default adalah 5 baris per halaman
$offset = ($page - 1) * $limit;

// Mendapatkan nilai filter tanggal
$filter_date = isset($_GET['filter_date']) ? $_GET['filter_date'] : '';

// Menyiapkan query untuk mengambil data hasil diagnosa dengan filter tanggal dan paginasi
$sql = "SELECT * FROM hasil WHERE iduser = ?";

// Menambahkan kondisi filter tanggal jika ada
if ($filter_date) {
    $sql .= " AND created_at LIKE ?";
    $date_filter = "%" . $filter_date . "%";
} else {
    $date_filter = null;
}

// Menambahkan paginasi dan mengurutkan berdasarkan tanggal terbaru
$sql .= " ORDER BY created_at DESC LIMIT ? OFFSET ?";

// Menyiapkan query
$stmt = $conn->prepare($sql);

// Mengikat parameter untuk query
if ($date_filter) {
    $stmt->bind_param("ssii", $iduser, $date_filter, $limit, $offset);
} else {
    $stmt->bind_param("iii", $iduser, $limit, $offset);
}

$stmt->execute();
$result = $stmt->get_result();  // Mendapatkan hasil query


// Query untuk menghitung jumlah total data untuk paginasi
$sql_total = "SELECT COUNT(*) AS total FROM hasil WHERE iduser = ?";
if ($date_filter) {
    $sql_total .= " AND created_at LIKE ?";
}

$stmt_total = $conn->prepare($sql_total);

// Mengikat parameter untuk query total
if ($date_filter) {
    $stmt_total->bind_param("ss", $iduser, $date_filter);
} else {
    $stmt_total->bind_param("s", $iduser);
}

$stmt_total->execute();
$total_result = $stmt_total->get_result()->fetch_assoc();
$total_rows = $total_result['total'];

// Menghitung total halaman
$total_pages = ceil($total_rows / $limit);
?>

<!-- <section class="py-5 text-left" style="padding: 0 20px;"> -->
<!-- <section class="py-5"> -->
    <section class="py-5">
    <div class="containerr">

        <h2 class="navbar-brand large-text" style="color: #d62268; margin-bottom: 1rem; text-shadow: 1px 1px 3px rgba(0,0,0,0.2); text-align: center; font-size: calc(1.5rem + 2vw);">
            Riwayat Deteksi Anda
        </h2>
        <h3 style="color: #757375; margin-bottom: 2rem; text-align: center; font-size: calc(1rem + 1.5vw);">
            Berikut Daftar Riwayat Deteksi Anda
        </h3>
       



        <!-- Container for Filter, Table, and Pagination -->
        <div class="card shadow-sm border-0 rounded-lg overflow-hidden">
            <div class="card-body p-4">
                <!-- Filter and Limit -->
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 filter-container">
                    <div class="d-flex align-items-center mb-3 mb-md-0">
                        <label for="entriesSelect" class="me-2" style="color: black;">Lihat</label>
                        <select id="entriesSelect" class="form-select w-auto" onchange="changeLimit(this.value)" style="height: calc(1.5em + .75rem + 2px);">
                            <option value="5" <?php if ($limit == 5) echo 'selected'; ?>>5</option>
                            <option value="10" <?php if ($limit == 10) echo 'selected'; ?>>10</option>
                            <option value="15" <?php if ($limit == 15) echo 'selected'; ?>>15</option>
                        </select>
                        <span class="ms-2 me-2">entries</span>
                    </div>

                    <!-- Filter By Date -->
                    <form method="get" class="d-flex justify-content-end align-items-center mb-3" id="filterForm">
                        <input type="date" name="filter_date" value="<?= htmlspecialchars($filter_date); ?>" class="form-control me-2" style="max-width: 200px;">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>

                <!-- Tabel Riwayat Deteksi -->
                <div class="table-responsive mb-4 table-container">
                    <table class="table table-bordered table-striped table-hover table-blurred">
                        <thead class="thead-light">
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
                            if ($result->num_rows > 0) {
                                $no = $offset + 1;
                                while ($row = $result->fetch_assoc()) {
                                    // Mengonversi gejala menjadi format yang mudah dibaca
                                    $gejala = htmlspecialchars($row['gejala_terpilih']);
                                    $gejala_items = explode(",", $gejala); // Memisahkan berdasarkan koma
                                    $formatted_gejala = implode('<br>', $gejala_items); // Menggabungkan dengan tag <br>

                                    echo '<tr>';
                                    echo '<td>' . $no++ . '</td>';
                                    echo '<td>' . htmlspecialchars($row['nama_pasien']) . '</td>';
                                    echo '<td>' . htmlspecialchars(string: $row['created_at']) . '</td>';
                                    echo '<td>' . $formatted_gejala . '</td>';
                                    echo '<td>' . htmlspecialchars($row['hasil_diagnosa']) . '</td>';
                                    echo '<td>' . (is_null($row['hasil_similarity']) ? '-' : htmlspecialchars($row['hasil_similarity']) . '%') . '</td>';
                                  
                                    // Tautan untuk cetak menggunakan ikon Font Awesome
                                    echo '<td><a href="cetak_hasillangsung.php?idhasil=' . $row['idhasil'] . '" class="btn btn-outline-primary">
                                              <i class="fas fa-print" style="font-size: 20px;"></i> Cetak
                                          </a></td>';

                                    // Tautan untuk hapus menggunakan ikon Font Awesome
                                    echo '<td><a href="../handler/riwayathasil/user-hapusriwayat.php?idhasil=' . $row['idhasil'] . '" class="btn btn-outline-danger" onclick="return confirm(\'Apakah Anda yakin ingin menghapus riwayat ini?\')">
                                              <i class="fas fa-trash-alt" style="font-size: 20px;"></i> Hapus
                                          </a></td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><td colspan="9" class="text-center">Tidak ada riwayat deteksi ditemukan.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Navigasi Paginasi -->
                <nav aria-label="Page navigation" class="pagination-container">
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                            <a class="page-link" href="?page=1&limit=<?= $limit; ?>&filter_date=<?= htmlspecialchars($filter_date); ?>" aria-label="First">
                                <i class="fas fa-angle-double-left"></i> First
                            </a>
                        </li>
                        <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                            <a class="page-link" href="?page=<?= $page - 1; ?>&limit=<?= $limit; ?>&filter_date=<?= htmlspecialchars($filter_date); ?>" aria-label="Previous">
                                <i class="fas fa-chevron-left"></i> Previous
                            </a>
                        </li>
                        <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?>">
                            <a class="page-link" href="?page=<?= $page + 1; ?>&limit=<?= $limit; ?>&filter_date=<?= htmlspecialchars($filter_date); ?>" aria-label="Next">
                                <i class="fas fa-chevron-right"></i> Next
                            </a>
                        </li>
                        <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?>">
                            <a class="page-link" href="?page=<?= $total_pages; ?>&limit=<?= $limit; ?>&filter_date=<?= htmlspecialchars($filter_date); ?>" aria-label="Last">
                                <i class="fas fa-angle-double-right"></i> Last
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
<script>
    // Fungsi untuk mengubah limit per halaman
    function changeLimit(limit) {
        window.location.href = "?page=1&limit=" + limit + "&filter_date=" + document.getElementById("filterForm").filter_date.value;
    }
</script>

