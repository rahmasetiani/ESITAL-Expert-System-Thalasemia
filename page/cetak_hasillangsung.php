<?php
require '../database/koneksi.php';
require '../vendor/autoload.php';  // Load DomPDF
session_start();
use Dompdf\Dompdf;
use Dompdf\Options;

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Ambil idhasil dari URL (asumsi idhasil diteruskan sebagai query parameter)
$idhasil = isset($_GET['idhasil']) ? $_GET['idhasil'] : null;

if (!$idhasil) {
    die("ID Hasil tidak valid.");
}

// Query untuk mengambil hasil diagnosis berdasarkan idhasil
$query = "SELECT * FROM hasil WHERE idhasil = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $idhasil); // Menggunakan binding integer
$stmt->execute();
$result = $stmt->get_result();

// Cek apakah data hasil ditemukan
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    die("Data hasil tidak ditemukan.");
}

// Query untuk mengambil detail penyakit berdasarkan nama penyakit
$penyakitQuery = "SELECT p.namapenyakit, p.foto, p.deskripsi, p.solusipengobatan
                  FROM penyakit p
                  WHERE p.namapenyakit = ?";
$penyakitStmt = $conn->prepare($penyakitQuery);
$penyakitStmt->bind_param("s", $row['hasil_diagnosa']); // Link dengan hasil_diagnosa
$penyakitStmt->execute();
$penyakitResult = $penyakitStmt->get_result();

// Cek apakah detail penyakit ditemukan
$penyakit = null;
if ($penyakitResult->num_rows > 0) {
    $penyakit = $penyakitResult->fetch_assoc();
}

// Parse keseluruhan diagnosa dan similarity
$keseluruhan_diagnosa = json_decode($row['keseluruhan_diagnosa']);
$keseluruhan_similarity = json_decode($row['keseluruhan_similarity']);

// Mulai output buffering
ob_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pemeriksaan Pasien</title>
    <style>
    body {
        font-family: 'Times New Roman', Times, serif;
        margin: 0;
        padding: 0;
        line-height: 1.5;
        font-size: 12pt;
    }
    .kop-surat {
        text-align: center;
        margin-bottom: 20px;
    }
    .kop-surat img {
        max-height: 100px;
    }
    .kop-surat h3, .kop-surat h4 {
        margin: 0;
    }
    .kop-surat h3 {
        font-size: 18pt;
    }
    .kop-surat h4 {
        font-size: 14pt;
    }
    hr {
        border: 0;
        border-top: 2px solid #000;
        margin: 10px 0;
    }
    .signature {
        text-align: right;
        margin-top: 50px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }
    table td {
        padding: 2px;
        vertical-align: top;
    }
    table th {
        padding: 10px;
        text-align: left;
        vertical-align: top;
        background-color: #f0f0f0;
    }

    /* Menyempitkan kolom kiri dan memberi lebar maksimum */
    .content-table td:nth-child(1), .content-table th:nth-child(1) {
        width: 25%; /* Lebar kolom kiri lebih kecil */
    }

    .content-table td:nth-child(2), .content-table th:nth-child(2) {
        width: 75%; /* Kolom kanan lebih lebar */
    }

    /* Kolom tabel keseluruhan diagnosa */
    .content-table td, .content-table th {
        font-size: 12pt;
    }

    .content-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    .content-table tr:nth-child(odd) {
        background-color: #f0f0f0;
    }
    .content-table td strong {
        width: 20%;
    }
    .content-table td {
        width: 70%;
    }

    /* Styling untuk tabel keseluruhan diagnosa */
    .diagnosa-table td, .diagnosa-table th {
        padding: 3px;
    }

    .diagnosa-table th {
        background-color: #f0f0f0;
    }

    
    </style>
</head>
<body>
    <div class="kop-surat">
        <!-- <img src="http://localhost/Tugas-Akhir/ESITAL-Expert-System-Thalasemia/asset/logo-kop.png" alt="Logo Kop Surat"> -->
        <h3>Sistem Pakar Deteksi Dini Penyakit Thalasemia</h3>
        <h4>Yayasan Thalassemia Indonesia Kabupaten Banyumas</h4>
        <hr>
    </div>

    <div>
        <h2 style="text-align: center; font-size: 16pt; font-weight: bold;">Hasil Pemeriksaan Pasien</h2>

        <table class="content-table">
            <tr>
                <td><strong>Tanggal Periksa</strong></td>
                <td>: <?php echo htmlspecialchars(date("d-m-Y H:i:s", strtotime($row['created_at']))); ?></td>
            </tr>
            <tr>
                <td><strong>Nama Pasien</strong></td>
                <td>: <?php echo htmlspecialchars($row['nama_pasien']); ?></td>
            </tr>
            <tr>
                <td><strong>Tanggal Lahir</strong></td>
                <td>: <?php echo htmlspecialchars($row['tanggallahir_pasien']); ?></td>
            </tr>
            <tr>
                <td><strong>Alamat</strong></td>
                <td>: <?php echo htmlspecialchars($row['alamat_pasien']); ?></td>
            </tr>
            <tr>
                <td><strong>Jenis Kelamin</strong></td>
                <td>: <?php echo htmlspecialchars($row['jk_pasien']); ?></td>
            </tr>
            <tr>
                <td><strong>Gejala yang Dipilih</strong></td>
                <td>: 
                    <?php 
                    $gejalaList = explode(",", $row['gejala_terpilih']);
                    foreach ($gejalaList as $gejala) {
                        echo htmlspecialchars(trim($gejala)) . "<br>";
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td><strong>Hasil Diagnosa</strong></td>
                <td>: <?php echo htmlspecialchars($row['hasil_diagnosa']); ?></td>
            </tr>
            <?php if (!empty($row['hasil_similarity'])): ?>
            <tr>
                <td><strong>Hasil Similarity</strong></td>
                <td>: <?php echo htmlspecialchars($row['hasil_similarity']); ?>%</td>
            </tr>
            <?php endif; ?>
        </table>

        <?php if ($penyakit): ?>
            <table class="content-table">
                <tr>
                    <td><strong>Deskripsi Penyakit</strong></td>
                    <td>: <?php echo htmlspecialchars($penyakit['deskripsi']); ?></td>
                </tr>
                <tr>
                    <td><strong>Solusi Pengobatan</strong></td>
                    <td>: <?php echo htmlspecialchars($penyakit['solusipengobatan']); ?></td>
                </tr>
            </table>
        <?php else: ?>
            <p style="color: #f44336;">Informasi penyakit tidak ditemukan.</p>
        <?php endif; ?>
        <h3">Detail Hasil Akurasi Deteksi</h3>
<table class="diagnosa-table">
    <thead>
        <tr>
            <th style="text-align: left;">Nama Penyakit</th>
            <th style="text-align: left;">Similarity (%)</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        // Gabungkan diagnosa dan similarity menjadi array asosiatif
        $diagnosaWithSimilarity = [];
        foreach ($keseluruhan_diagnosa as $index => $diagnosa) {
            $similarity = isset($keseluruhan_similarity[$index]) ? $keseluruhan_similarity[$index] : 0;
            if ($similarity > 0) {
                $diagnosaWithSimilarity[] = [
                    'diagnosa' => $diagnosa,
                    'similarity' => $similarity
                ];
            }
        }

        // Urutkan berdasarkan similarity terbesar
        usort($diagnosaWithSimilarity, function($a, $b) {
            return $b['similarity'] - $a['similarity']; // Mengurutkan dalam urutan menurun
        });

        // Tampilkan hasil yang sudah diurutkan
        foreach ($diagnosaWithSimilarity as $item) {
            echo "<tr>
                    <td>" . htmlspecialchars($item['diagnosa']) . "</td>
                    <td>" . htmlspecialchars($item['similarity']) . "%</td>
                  </tr>";
        }
        ?>
    </tbody>
</table>


        <div class="signature">
            <p>Ditandatangani oleh Pakar:</p>
            <img src="http://localhost/Tugas-Akhir/ESITAL-Expert-System-Thalasemia/asset/ttd-pakar.png" alt="Tanda Tangan Pakar" style="width: 150px; height: auto;">
            <p><strong>Dr. John Doe</strong></p>
        </div>
    </div>
</body>
</html>

<?php
// Capture the HTML output
$html = ob_get_clean();

// Inisialisasi DomPDF
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);
$dompdf = new Dompdf($options);

// Load HTML ke dalam DomPDF
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');

// Render PDF
$dompdf->render();

// Stream hasil PDF ke browser (Attachment diset ke false agar tampil di browser)
$dompdf->stream("hasil_diagnosa.pdf", ["Attachment" => false]);

// Akhiri script
exit;
?>