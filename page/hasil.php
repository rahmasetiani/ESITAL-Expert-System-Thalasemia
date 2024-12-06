<?php 
include 'header.php';
require '../database/koneksi.php'; // Pastikan koneksi ke database sudah benar

// Cek apakah pengguna sudah login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php'); // Redirect ke halaman login jika belum login
    exit;
}

// Ambil ID pengguna yang sedang login
$userId = $_SESSION['user_id'];

// Query untuk mengambil data hasil terakhir dari tabel 'hasil' berdasarkan iduser
$query = "SELECT * FROM hasil WHERE iduser = ? ORDER BY created_at DESC LIMIT 1";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$lastResult = $result->fetch_assoc(); // Ambil baris pertama yang merupakan data terakhir

if (!$lastResult) {
    // Jika tidak ada hasil diagnosa, tampilkan pesan
    $lastResultMessage = "Tidak ada data diagnosa terakhir.";
} else {
    $lastResultMessage = $lastResult; // Data diagnosa terakhir
}

// Ambil semua diagnosa yang terkait
$queryAllDiagnoses = "SELECT * FROM hasil WHERE iduser = ? ORDER BY created_at DESC";
$stmtAll = $conn->prepare($queryAllDiagnoses);
$stmtAll->bind_param("i", $userId);
$stmtAll->execute();
$allDiagnosesResult = $stmtAll->get_result();
$allDiagnoses = [];
while ($row = $allDiagnosesResult->fetch_assoc()) {
    $allDiagnoses[] = $row;
}
// Ambil nama penyakit dari hasil diagnosa
$namaPenyakit = $lastResultMessage['hasil_diagnosa'];

// Query untuk mengambil deskripsi dan solusipengobatan dari tabel penyakit
$queryPenyakit = "SELECT deskripsi, solusipengobatan FROM penyakit WHERE namapenyakit = ?";
$stmtPenyakit = $conn->prepare($queryPenyakit);
$stmtPenyakit->bind_param("s", $namaPenyakit);
$stmtPenyakit->execute();
$penyakitResult = $stmtPenyakit->get_result();
$penyakitData = $penyakitResult->fetch_assoc();

// Jika tidak ditemukan data penyakit, tampilkan pesan
if ($penyakitData) {
    $deskripsi = $penyakitData['deskripsi'];
    $solusiPengobatan = $penyakitData['solusipengobatan'];
} else {
    $deskripsi = "Deskripsi tidak ditemukan.";
    $solusiPengobatan = "Solusi pengobatan tidak ditemukan.";
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Diagnosa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../asset/css/index.css"> <!-- Sesuaikan dengan stylesheet Anda -->
</head>
<body>
<section class="py-5 text-left" style="padding: 0 20px;">

<h2 class="navbar-brand large-text" style="color: #d62268; margin-bottom: 1rem; text-shadow: 1px 1px 3px rgba(0,0,0,0.2); text-align: center; font-size: calc(1.5rem + 2vw);">
        Hasil Deteksi Anda
    </h2>
        
        <div class="container my-5">
        <button class="btn custom-btn btn-lg" id="printBtn" onclick="redirectToPrintPage()">
            <i class="fas fa-print"></i> Cetak Hasil
        </button>
        <br><br>
        <div class="card-body">
            <table class="table">
                <tbody>
                    <tr>
                        <td><strong>Nama Pasien</strong></td>
                        <td><?php echo htmlspecialchars($lastResultMessage['nama_pasien']); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Lahir</strong></td>
                        <td><?php echo htmlspecialchars($lastResultMessage['tanggallahir_pasien']); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Alamat</strong></td>
                        <td><?php echo htmlspecialchars($lastResultMessage['alamat_pasien']); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Jenis Kelamin</strong></td>
                        <td><?php echo htmlspecialchars($lastResultMessage['jk_pasien']); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Gejala yang Dipilih</strong></td>
                        <td>
                            <?php 
                            // Memisahkan gejala berdasarkan koma
                            $gejalaTerpilih = explode(',', $lastResultMessage['gejala_terpilih']);
                            
                            // Menampilkan setiap gejala di baris baru
                            if (is_array($gejalaTerpilih)) {
                                foreach ($gejalaTerpilih as $gejala) {
                                    echo htmlspecialchars($gejala) . "<br>"; // Menampilkan gejala dengan baris baru
                                }
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                <td><strong>Hasil Diagnosa</strong></td>
                <td>
                    <?php 
                    echo htmlspecialchars($lastResultMessage['hasil_diagnosa']);
                    
                    // Cek jika hasil diagnosa adalah "Tidak Teridentifikasi Penyakit Thalassemia dan Penyakit Serupa"
                    if ($lastResultMessage['hasil_diagnosa'] == "Tidak Teridentifikasi Penyakit Thalassemia dan Penyakit Serupa") {
                        echo "<br>Namun, gejala yang Anda alami akan kami tinjau ulang bersama pakar untuk memastikan hasil diagnosa lebih akurat.";
                    }
                    ?>
                </td>
            </tr>

                    <?php if ($penyakitData): ?>
                    <tr>
                        <td><strong>Deskripsi Penyakit</strong></td>
                        <td><?php echo htmlspecialchars($deskripsi); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Solusi Pengobatan</strong></td>
                        <td><?php echo htmlspecialchars($solusiPengobatan); ?></td>
                    </tr>
                    <?php endif; ?>

                    <?php if ($lastResultMessage['hasil_similarity'] !== NULL): ?>
                    <tr>
                        <td><strong>Similarity</strong></td>
                        <td><?php echo htmlspecialchars($lastResultMessage['hasil_similarity']) . '%'; ?></td>
                    </tr>
                    <?php endif; ?>

                </tbody>
            </table>
        </div>
        </

            <!-- Menggunakan Font Awesome untuk ikon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="card-body d-flex justify-content-between">       
    <!-- Tombol Tampilkan Semua Diagnosa -->
    <button class="btn custom-btn btn-lg" id="toggleDiagnosesBtn" onclick="toggleDiagnosesTable()">
        <i class="fas fa-search-plus" id="diagnosesIcon"></i> Tampilkan Semua Diagnosa
    </button>
</div>
</div>

    <style>
    .btn.custom-btn {
        padding: 10px 20px;
        font-size: 16px;
        width: auto; /* Tombol mengikuti panjang teks */
        max-width: none; /* Tidak ada batasan lebar maksimum */
        white-space: nowrap; /* Menghindari teks tombol terpotong jika terlalu panjang */
        display: inline-block; /* Pastikan tombol diatur sebaris */
    }
</style>
<div id="diagnosesTable" style="display:none;">
    <div class="table-responsive" style="max-width: 800px; margin: 0 auto;">
        <table class="table">
            <thead>
                <tr>
                    <th>Diagnosa Penyakit</th>
                    <th>Presentase (%)</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                // Memisahkan hasil diagnosa dan similarity berdasarkan koma
                $diagnosaArray = explode(',', $lastResultMessage['keseluruhan_diagnosa']);
                $similarityArray = explode(',', $lastResultMessage['keseluruhan_similarity']);

                // Gabungkan hasil diagnosa dan similarity ke dalam array asosiatif
                $diagnosaSimilarity = [];
                for ($i = 0; $i < count($diagnosaArray); $i++) {
                    // Trim nilai dan hapus tanda kutip atau karakter yang tidak diinginkan
                    $diagnosa = trim($diagnosaArray[$i], ' "[]');
                    $similarityValue = trim($similarityArray[$i], ' "[]');
                    
                    // Masukkan ke dalam array jika similarity > 0
                    if ($similarityValue > 0) {
                        $diagnosaSimilarity[] = [
                            'diagnosa' => $diagnosa,
                            'similarity' => (float)$similarityValue
                        ];
                    }
                }

                // Urutkan array berdasarkan similarity dari terbesar ke terkecil
                usort($diagnosaSimilarity, function ($a, $b) {
                    return $b['similarity'] - $a['similarity']; // Membandingkan berdasarkan similarity
                });

                // Tampilkan data yang telah diurutkan
                foreach ($diagnosaSimilarity as $item) {
                    echo "<tr>
                            <td>" . htmlspecialchars($item['diagnosa']) . "</td>
                            <td>" . htmlspecialchars($item['similarity']) . "%</td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</div>
</section>
<?php include 'footer.php'; ?>


    <script>
        // Fungsi untuk mengalihkan ke halaman cetak
        function redirectToPrintPage() {
    // Ambil idhasil terakhir dari session PHP dan tambahkan 1
    var idhasil = <?php echo isset($_SESSION['last_idhasil']) ? $_SESSION['last_idhasil'] : 'null'; ?>;

    if (idhasil !== null) {
        // Arahkan ke halaman cetak_hasillangsung.php dengan parameter idhasil
        window.location.href = "cetak_hasillangsung.php?idhasil=" + idhasil;

        // Redirect ke riwayat.php setelah 1 detik (biarkan waktu untuk memuat halaman cetak)
        setTimeout(function() {
            window.location.href = "riwayat.php";
        }, 1000); // 1000ms = 1 detik
    } else {
        alert("ID Hasil tidak ditemukan.");
    }
}

        // Fungsi untuk toggle tampilan tabel diagnosa lainnya
        function toggleDiagnosesTable() {
        var table = document.getElementById("diagnosesTable");
        var button = document.getElementById("toggleDiagnosesBtn");
        var icon = document.getElementById("diagnosesIcon");

        if (table.style.display === "none") {
            table.style.display = "block";
            button.innerHTML = '<i class="fas fa-search-minus" id="diagnosesIcon"></i> Sembunyikan Semua Diagnosa'; // Ganti ikon dan teks
        } else {
            table.style.display = "none";
            button.innerHTML = '<i class="fas fa-search-plus" id="diagnosesIcon"></i> Tampilkan Semua Diagnosa'; // Kembalikan ikon dan teks
        }
    }
    </script>

</body>
</html>

<style>
    /* Style untuk kontainer utama */
.container {
    max-width: 900px;
    margin: 0 auto;
}

/* Tampilan untuk tombol kustom */
.btn.custom-btn {
    padding: 12px 24px;
    font-size: 18px;
    background-color: #d62268;
    color: white;
    border: none;
    border-radius: 8px;
    transition: background-color 0.3s ease;
    width: auto;
}

.btn.custom-btn:hover {
    background-color: #b51e5a;
}

.btn.custom-btn i {
    margin-right: 8px;
}

/* Header utama */
h2.navbar-brand {
    color: #d62268;
    margin-bottom: 1rem;
    text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
    text-align: center;
    font-size: calc(1.5rem + 2vw);
}

/* Tabel Hasil Diagnosa */
.table {
    width: 100%;
    margin-top: 20px;
    border-collapse: collapse;
}

.table th, .table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.table th {
    background-color: #f8f9fa;
    color: #555;
}

.table td {
    background-color: #fff;
    color: #333;
}

/* Tampilan responsif untuk tabel */
@media (max-width: 768px) {
    .table th, .table td {
        padding: 8px;
        font-size: 14px;
    }

    .container {
        padding-left: 15px;
        padding-right: 15px;
    }
}

/* Gaya untuk tombol toggle diagnosa */
#toggleDiagnosesBtn {
    background-color: #f8f9fa;
    border: 1px solid #ddd;
    color: #d62268;
    font-weight: bold;
    padding: 10px 20px;
    border-radius: 8px;
    transition: background-color 0.3s ease;
}

#toggleDiagnosesBtn:hover {
    background-color: #f1f1f1;
}

#diagnosesTable {
    margin-top: 20px;
}

#diagnosesTable .table {
    border-top: 2px solid #ddd;
    margin-top: 15px;
}

#diagnosesTable .table td, #diagnosesTable .table th {
    padding: 10px;
}

/* Tabel Diagnosa lainnya */
#diagnosesTable .table thead {
    background-color: #f8f9fa;
}

#diagnosesTable .table tr:nth-child(even) {
    background-color: #f9f9f9;
}

/* Tampilkan hasil diagnosa jika ada kesalahan */
.alert {
    padding: 15px;
    margin-top: 20px;
    border-radius: 5px;
    background-color: #f8d7da;
    color: #721c24;
}

.alert.success {
    background-color: #d4edda;
    color: #155724;
}

/* Footer */
footer {
    background-color: #f1f1f1;
    padding: 20px;
    text-align: center;
}

</style>
