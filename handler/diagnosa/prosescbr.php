<?php
// prosescbr.php
session_start();
require '../../database/koneksi.php'; // Sesuaikan path koneksi

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];  // ID user yang login

// Cek apakah sudah ada ID hasil di session
if (isset($_SESSION['last_idhasil'])) {
    $last_idhasil = $_SESSION['last_idhasil'];
} else {
    // Ambil idhasil terakhir berdasarkan user_id jika belum ada
    $query = "SELECT idhasil FROM hasil WHERE iduser = ? ORDER BY created_at DESC LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);  // Menggunakan binding integer
    $stmt->execute();
    $result = $stmt->get_result();

    // Cek apakah ada hasil
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['last_idhasil'] = $row['idhasil'];  // Simpan idhasil dalam session
        $last_idhasil = $row['idhasil'];  // Set ID hasil
    } else {
        $last_idhasil = null;  // Jika tidak ada hasil, set null
    }
}

// Ambil gejala yang dipilih untuk pasien dari tabel pasien_gejala
$gejalaQuery = "SELECT gejala_terpilih FROM pasien_gejala ORDER BY id DESC LIMIT 1";
$gejalaResult = $conn->query($gejalaQuery);

// Check if there is a result
if ($gejalaResult && $gejalaResult->num_rows > 0) {
    $gejalaRow = $gejalaResult->fetch_assoc();
    $selectedGejala = explode(",", $gejalaRow['gejala_terpilih']);
} else {
    $selectedGejala = [];
}

// Ambil nama dan bobot gejala yang dipilih dari tabel gejala
$gejalaNames = [];
$gejalaWeights = [];
foreach ($selectedGejala as $kode) {
    // Fetch the symptom name
    $gejalaNameQuery = "SELECT namagejala, bobot FROM gejala WHERE kodegejala = ?";
    $gejalaNameStmt = $conn->prepare($gejalaNameQuery);
    $gejalaNameStmt->bind_param("s", $kode);
    $gejalaNameStmt->execute();
    $gejalaNameResult = $gejalaNameStmt->get_result();
    $gejalaNameRow = $gejalaNameResult->fetch_assoc();

    if ($gejalaNameRow) {
        $gejalaNames[] = $gejalaNameRow['namagejala'];  // Store the name of the symptom
        $gejalaWeights[$kode] = $gejalaNameRow['bobot'];  // Store the weight
    }
}

// Retrieve/Ambil nilai ambang batas kesamaan dari tabel ambang_batas
$thresholdQuery = "SELECT nilai FROM ambang_batas WHERE id = 1 LIMIT 1";
$thresholdStmt = $conn->query($thresholdQuery);
$thresholdRow = $thresholdStmt->fetch_assoc();
$threshold = $thresholdRow ? $thresholdRow['nilai'] : 0.0;

// Retrieve/Ambil detail pasien berdasarkan ID pengguna
$patientQuery = "SELECT u.namalengkap AS nama_pasien, u.tanggal_lahir AS tanggallahir_pasien, u.alamat AS alamat_pasien, u.jenis_kelamin AS jk_pasien
                 FROM user u 
                 JOIN pasien_gejala p ON u.id = p.iduser
                 WHERE p.iduser = ? LIMIT 1";
$patientStmt = $conn->prepare($patientQuery);
$patientStmt->bind_param("i", $_SESSION['user_id']);
$patientStmt->execute();
$patientResult = $patientStmt->get_result();
$row = $patientResult->fetch_assoc();

// Retrieve/Ambil kasus dari tabel basiskasus dan hitung kesamaan
$caseQuery = "SELECT bk.kodebasiskasus, bk.kodepenyakit, p.namapenyakit, p.deskripsi, p.solusipengobatan, 
              GROUP_CONCAT(g.kodegejala) AS gejala, SUM(g.bobot) AS total_bobot 
              FROM basiskasus bk 
              JOIN penyakit p ON bk.kodepenyakit = p.kodepenyakit 
              JOIN basiskasus_gejala bg ON bk.kodebasiskasus = bg.kodebasiskasus 
              JOIN gejala g ON bg.kodegejala = g.kodegejala 
              GROUP BY bk.kodebasiskasus";
$caseResult = $conn->query($caseQuery);

// Inisialisasi array untuk menyimpan semua diagnosis dan kesamaan
$keseluruhanDiagnosa = [];
$keseluruhanSimilarity = [];
$bestmatchDiagnosa = '';
$bestmatchSimilarity = 0;
$bestmatchDeskripsi = '';
$bestmatchSolusi = '';

// Lakukan iterasi untuk mencari kecocokan terbaik dan tambahkan diagnosis ke keseluruhanDiagnosa
while ($case = $caseResult->fetch_assoc()) {
    $caseGejala = explode(",", $case['gejala']);
    $caseTotalBobot = $case['total_bobot'];

    // Hitung jumlah bobot gejala yang cocok
    $matchingBobot = 0;
    foreach ($selectedGejala as $gejala) {
        if (in_array($gejala, $caseGejala)) {
            $matchingBobot += $gejalaWeights[$gejala] ?? 0;
        }
    }

    // Hitung kesamaan sebagai bobot yang cocok / total bobot dari kasus
    $similarityScore = $caseTotalBobot > 0 ? $matchingBobot / $caseTotalBobot : 0;

    // Periksa apakah ini merupakan kecocokan terbaik
    if ($similarityScore > $bestmatchSimilarity) {
        $bestmatchDiagnosa = $case['kodebasiskasus'];
        $bestmatchDiagnosa = $case['namapenyakit'];
        $bestmatchDeskripsi = $case['deskripsi'];  // Store the description of the disease
        $bestmatchSolusi = $case['solusipengobatan'];  // Store the solution for the disease
        // Store the name of the disease
        $bestmatchSimilarity = $similarityScore;
    }

    // "Tambahkan diagnosis ke dalam keseluruhanDiagnosa dan keseluruhanSimilarity."
    $keseluruhanDiagnosa[] = $case['namapenyakit'];  // Store the name of the disease
    $keseluruhanSimilarity[] = round($similarityScore * 100, 2);
}

// "Jika similarity di bawah ambang batas, sesuaikan hasilnya."
if ($bestmatchSimilarity < ($threshold / 100)) {
    $bestmatchDiagnosa = "Tidak Teridentifikasi Penyakit Thalassemia";
} else {
    $akurasi = round($bestmatchSimilarity * 100, 2);
}

// Prepare the data for insertion
$idUser = $_SESSION['user_id'];
$namaPasien = $row['nama_pasien'];
$tanggalLahir = $row['tanggallahir_pasien'];
$alamat = $row['alamat_pasien'];
$jenisKelamin = $row['jk_pasien'];
$gejalaDipilih = implode(", ", $gejalaNames);
$hasilDiagnosa = $bestmatchDiagnosa;  // Store the name of the disease or default message

// JSON encode keseluruhanDiagnosa and keseluruhanSimilarity
$keseluruhanDiagnosaJson = json_encode($keseluruhanDiagnosa);
$keseluruhanSimilarityJson = json_encode($keseluruhanSimilarity);

// Insert into 'hasil' table (store nama penyakit, bukan kode penyakit)
$insertQuery = "INSERT INTO hasil (iduser, nama_pasien, tanggallahir_pasien, alamat_pasien, jk_pasien, gejala_terpilih, hasil_diagnosa, hasil_similarity, created_at, keseluruhan_diagnosa, keseluruhan_similarity)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?)";
$insertStmt = $conn->prepare($insertQuery);
$insertStmt->bind_param(
    "isssssssss", 
    $idUser, 
    $namaPasien, 
    $tanggalLahir, 
    $alamat, 
    $jenisKelamin, 
    $gejalaDipilih, 
    $hasilDiagnosa, 
    $akurasi, 
    $keseluruhanDiagnosaJson, 
    $keseluruhanSimilarityJson
);

// Execute the statement
if ($insertStmt->execute()) {
    // Set session variable for last_idhasil after successful insertion
    $_SESSION['last_idhasil'] = $conn->insert_id;  // Store the last inserted ID
    header("Location: ../../page/hasil.php"); // Redirect to hasil.php
    exit();
} else {
    echo "Error: " . $insertStmt->error;
}
?>
