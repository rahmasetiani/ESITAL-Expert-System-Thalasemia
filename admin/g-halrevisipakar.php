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
    // Mendecode JSON menjadi array
    $keseluruhan_diagnosa = json_decode($row['keseluruhan_diagnosa'], true);
    $keseluruhan_similarity = json_decode($row['keseluruhan_similarity'], true);

    // Mengecek apakah keduanya adalah array
    if (is_array($keseluruhan_similarity) && is_array($keseluruhan_diagnosa)) {
        // Ambil nilai maksimal dan indeksnya
        $max_similarity = max($keseluruhan_similarity);
        $max_diagnosa = max($keseluruhan_diagnosa);
        
        $index_similarity_max = array_search($max_similarity, $keseluruhan_similarity);
        $index_diagnosa_max = array_search($max_diagnosa, $keseluruhan_diagnosa);

        // Assign nilai maksimal berdasarkan indeks
        $row['hasil_diagnosa_terpilih'] = $keseluruhan_diagnosa[$index_diagnosa_max];
        $row['hasil_similarity_terpilih'] = $keseluruhan_similarity[$index_similarity_max];
    } else {
        // Jika tidak berupa array, set nilai default
        $row['hasil_diagnosa_terpilih'] = 'N/A';
        $row['hasil_similarity_terpilih'] = 'N/A';
    }

    // Menyimpan hasil keseluruhan dalam row
    $row['keseluruhan_diagnosa'] = $keseluruhan_diagnosa;
    $row['keseluruhan_similarity'] = $keseluruhan_similarity;

    // Menambahkan row ke array hasil
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
    <a href="g-halrevisipakar.php" style="text-decoration: none; color: #d62268;">Daftar Revisi Pakar</a> 

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
                        <th>Hasil Diagnosa Terpilih</th>
                        <th>Similarity</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (mysqli_num_rows(result: $result) > 0): ?>

                    <?php 
    $no = 1;
    foreach ($allResults as $result) {
        echo "<tr data-idhasil='" . htmlspecialchars($result['idhasil']) . "'>
                <td>" . $no++ . "</td>
                <td>" . htmlspecialchars($result['nama_pasien']) . "</td>
                <td>" . htmlspecialchars($result['created_at']) . "</td>
                <td>";
        $gejalaArray = explode(',', $result['gejala_terpilih']);
        echo implode('<br>', array_map('trim', $gejalaArray));
        echo "</td>
                <td class='hasil-diagnosa-terpilih'>" . htmlspecialchars($result['hasil_diagnosa_terpilih']) . "</td>
                <td class='hasil-similarity-terpilih'>" . htmlspecialchars($result['hasil_similarity_terpilih']) . "%</td>
                <td>
                        <button type='button' class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#editModal' onclick='loadEditData(" . json_encode($result) . ")'>
                            <i class='fas fa-pencil-alt'></i> Revisi
                        </button>             

                    <form action='../handler/riwayathasil/admin-tolakrevisipakar.php' method='get' style='display:inline;' onsubmit='return confirm(\"Apakah Anda yakin ingin menolak hasil ini?\")'>
                        <input type='hidden' name='idhasil' value='". $result['idhasil'] ."'>
                        <button type='submit' class='btn btn-danger'>
                            <i class='fas fa-times-circle'></i> Tolak
                        </button>
                    </form>
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
</table> 
        </div>
        </div>

        <!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Hasil Diagnosa Terpilih</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="idhasil" id="editIdHasil">
                    <div class="mb-3">
                        <label for="editDiagnosa" class="form-label">Hasil Diagnosa</label>
                        <select class="form-select" id="editDiagnosa" name="edit_diagnosa"></select>
                    </div>
                    <div class="mb-3">
                        <label for="editSimilarity" class="form-label">Similarity</label>
                        <input type="number" class="form-control" id="editSimilarity" name="edit_similarity" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success" onclick="saveEdit()"><i class='fas fa-check-circle'></i> Terima</button>
                    </div>
            </form>
        </div>
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

<script>
    function loadEditData(resultData) {
    const diagnosaSelect = document.getElementById('editDiagnosa');
    const similarityInput = document.getElementById('editSimilarity');
    const idhasilInput = document.getElementById('editIdHasil');

    diagnosaSelect.innerHTML = '';

    // Gabungkan diagnosa dan similarity ke dalam array objek
    let combinedData = resultData.keseluruhan_diagnosa.map((diagnosa, index) => ({
        diagnosa: diagnosa,
        similarity: resultData.keseluruhan_similarity[index],
    }));

    // Filter untuk mengecualikan similarity 0%
    combinedData = combinedData.filter(item => item.similarity > 0);

    // Ambil nama penyakit unik dengan similarity tertinggi
    const uniqueDiagnoses = {};
    combinedData.forEach(item => {
        if (!uniqueDiagnoses[item.diagnosa] || uniqueDiagnoses[item.diagnosa].similarity < item.similarity) {
            uniqueDiagnoses[item.diagnosa] = item; // Simpan item jika similarity lebih tinggi
        }
    });

    // Konversi kembali menjadi array dan urutkan berdasarkan similarity tertinggi
    combinedData = Object.values(uniqueDiagnoses).sort((a, b) => b.similarity - a.similarity);

    // Tambahkan opsi ke dropdown
    combinedData.forEach((item, index) => {
        const option = document.createElement('option');
        option.value = index; // Simpan indeks urutannya
        option.text = `${item.diagnosa} (Similarity: ${item.similarity.toFixed(2)}%)`;
        diagnosaSelect.appendChild(option);
    });

    // Set nilai similarity default berdasarkan pilihan pertama
    if (combinedData.length > 0) {
        similarityInput.value = combinedData[0].similarity.toFixed(2);
    }

    // Isi ID hasil pada modal
    idhasilInput.value = resultData.idhasil;

    // Tambahkan event listener untuk mengubah similarity saat diagnosa dipilih
    diagnosaSelect.addEventListener('change', function () {
        const selectedIndex = this.value;
        similarityInput.value = combinedData[selectedIndex].similarity.toFixed(2);
    });
}


function saveEdit() {
    const idhasil = document.getElementById('editIdHasil').value;
    const diagnosaSelect = document.getElementById('editDiagnosa');
    const selectedDiagnosa = diagnosaSelect.options[diagnosaSelect.selectedIndex].text;
    const similarity = document.getElementById('editSimilarity').value;

    // Update data di tabel
    const row = document.querySelector(`tr[data-idhasil="${idhasil}"]`);
    if (row) {
        row.querySelector('.hasil-diagnosa-terpilih').innerText = selectedDiagnosa.split(" (")[0];
        row.querySelector('.hasil-similarity-terpilih').innerText = `${similarity}%`;
    }

    // Kirim data ke server menggunakan Ajax
    fetch('../handler/riwayathasil/admin-updaterevisipakar.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            idhasil: idhasil,
            hasil_diagnosa: selectedDiagnosa.split(" (")[0],
            hasil_similarity: similarity
        }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Data berhasil diperbarui!');
            window.location.href = 'g-halrevisipakar.php';
        } else {
            alert('Gagal memperbarui data: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat memperbarui data.');
    });

    // Tutup modal
    const editModal = bootstrap.Modal.getInstance(document.getElementById('editModal'));
    editModal.hide();

    // Hapus backdrop untuk memastikan layar kembali cerah
    const backdrops = document.querySelectorAll('.modal-backdrop');
    backdrops.forEach((backdrop) => backdrop.remove());

    // Pastikan body tidak memiliki kelas tambahan yang mengaburkan layar
    document.body.classList.remove('modal-open');
    document.body.style.paddingRight = ''; // Reset padding body jika ditambahkan oleh Bootstrap
}


</script>


