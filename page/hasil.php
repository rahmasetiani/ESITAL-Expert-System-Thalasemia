<?php
include 'header.php';
require '../database/koneksi.php';

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

// Fetch selected symptoms for the patient from the pasien_gejala table
$gejalaQuery = "SELECT gejala_terpilih FROM pasien_gejala ORDER BY id DESC LIMIT 1";
$gejalaResult = $conn->query($gejalaQuery);

// Check if there is a result
if ($gejalaResult && $gejalaResult->num_rows > 0) {
    $gejalaRow = $gejalaResult->fetch_assoc();
    $selectedGejala = explode(",", $gejalaRow['gejala_terpilih']);
} else {
    $selectedGejala = [];
}

// Fetch the names and weights of the selected symptoms from the gejala table
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

// Retrieve the threshold value for similarity from the ambang_batas table
$thresholdQuery = "SELECT nilai FROM ambang_batas WHERE id = 1 LIMIT 1";
$thresholdStmt = $conn->query($thresholdQuery);
$thresholdRow = $thresholdStmt->fetch_assoc();
$threshold = $thresholdRow ? $thresholdRow['nilai'] : 0.0;

// Retrieve patient details based on user ID
$patientQuery = "SELECT u.namalengkap AS nama_pasien, u.tanggal_lahir AS tanggallahir_pasien, u.alamat AS alamat_pasien, u.jenis_kelamin AS jk_pasien
                 FROM user u 
                 JOIN pasien_gejala p ON u.id = p.iduser
                 WHERE p.iduser = ? LIMIT 1";
$patientStmt = $conn->prepare($patientQuery);
$patientStmt->bind_param("i", $_SESSION['user_id']);
$patientStmt->execute();
$patientResult = $patientStmt->get_result();
$row = $patientResult->fetch_assoc();

// Retrieve cases from basiskasus and calculate similarity
$caseQuery = "SELECT bk.kodebasiskasus, bk.kodepenyakit, p.namapenyakit, p.deskripsi, p.solusipengobatan, 
              GROUP_CONCAT(g.kodegejala) AS gejala, SUM(g.bobot) AS total_bobot 
              FROM basiskasus bk 
              JOIN penyakit p ON bk.kodepenyakit = p.kodepenyakit 
              JOIN basiskasus_gejala bg ON bk.kodebasiskasus = bg.kodebasiskasus 
              JOIN gejala g ON bg.kodegejala = g.kodegejala 
              GROUP BY bk.kodebasiskasus";
$caseResult = $conn->query($caseQuery);

// Initialize array for storing all diagnoses and similarity
$keseluruhanDiagnosa = [];
$keseluruhanSimilarity = [];
$bestmatchDiagnosa = '';
$bestmatchSimilarity = 0;
$bestmatchDeskripsi = '';
$bestmatchSolusi = '';

// Iterate to find best match and add diagnosis to keseluruhanDiagnosa
while ($case = $caseResult->fetch_assoc()) {
    $caseGejala = explode(",", $case['gejala']);
    $caseTotalBobot = $case['total_bobot'];

    // Calculate the sum of matching symptoms' weights
    $matchingBobot = 0;
    foreach ($selectedGejala as $gejala) {
        if (in_array($gejala, $caseGejala)) {
            $matchingBobot += $gejalaWeights[$gejala] ?? 0;
        }
    }

    // Calculate similarity as matching weight / total weight of the case
    $similarityScore = $caseTotalBobot > 0 ? $matchingBobot / $caseTotalBobot : 0;

    // Check if it's the best match
    if ($similarityScore > $bestmatchSimilarity) {
        $bestmatchDiagnosa = $case['namapenyakit'];
        $bestmatchDeskripsi = $case['deskripsi'];  // Store the description of the disease
        $bestmatchSolusi = $case['solusipengobatan'];  // Store the solution for the disease
        // Store the name of the disease
        $bestmatchSimilarity = $similarityScore;
    }

    // Add diagnosis to keseluruhanDiagnosa and similarity
    $keseluruhanDiagnosa[] = $case['namapenyakit'];  // Store the name of the disease
    $keseluruhanSimilarity[] = round($similarityScore * 100, 2);
}

// If similarity is below the threshold, adjust the result
if ($bestmatchSimilarity < ($threshold / 100)) {
    $bestmatchDiagnosa = "Menunggu Revisi Pakar";
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
    echo "Data berhasil disimpan dengan ID hasil: " . $_SESSION['last_idhasil'];
} else {
    echo "Error: " . $insertStmt->error;
}

?>
<script>
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

</script>



<section class="py-5 text-left" style="padding: 0 20px;">
<h2 class="navbar-brand large-text" style="color: #d62268; margin-bottom: 1rem; text-shadow: 1px 1px 3px rgba(0,0,0,0.2); text-align: center; font-size: calc(1.5rem + 2vw);">
        Hasil Deteksi Anda
    </h2>
    <button class="btn custom-btn btn-lg" id="printBtn" onclick="redirectToPrintPage()">
        <i class="fas fa-print"></i> Cetak Hasil
    </button>
    <div class="container my-5">
        <div class="card-body">
            <table class="table">
                <tbody>
                    <tr>
                        <td><strong>Nama Pasien</strong></td>
                        <td><?php echo htmlspecialchars($row['nama_pasien']); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Lahir</strong></td>
                        <td><?php echo htmlspecialchars($row['tanggallahir_pasien']); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Alamat</strong></td>
                        <td><?php echo htmlspecialchars($row['alamat_pasien']); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Jenis Kelamin</strong></td>
                        <td><?php echo htmlspecialchars($row['jk_pasien']); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Gejala yang Dipilih</strong></td>
                        <td>
                            <?php 
                            // Display each selected symptom on a new line
                            foreach ($gejalaNames as $gejala) {
                                echo htmlspecialchars($gejala) . "<br>";  // Add line break after each symptom
                            }
                            ?>
                        </td>
                    </tr>

                    <tr>
    <td><strong>Hasil Diagnosa</strong></td>
    <td>
        <?php 
            echo htmlspecialchars($bestmatchDiagnosa);
            if ($bestmatchSimilarity < ($threshold / 100)) {
                echo "<br>Berdasarkan gejala yang anda pilih, anda tidak terdeteksi penyakit thalassemia atau serupa.";
                echo "<br>Namun, gejala yang anda alami akan kami tinjau ulang bersama pakar untuk memastikan hasil diagnosa lebih akurat.";}
        ?>
    </td>
</tr>

                    <?php if ($bestmatchSimilarity >= ($threshold / 100)): ?>
                    <tr>
                        <td><strong>Deskripsi Penyakit</strong></td>
                        <td><?php echo htmlspecialchars($bestmatchDeskripsi); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Solusi Penyakit</strong></td>
                        <td><?php echo htmlspecialchars($bestmatchSolusi); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Akurasi Diagnosa (%)</strong></td>
                        <td><?php echo number_format($akurasi, 2) . "%"; ?></td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

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

<!-- Tabel Diagnosa -->
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
                // Combine diagnoses and similarities into an associative array
                $diagnosisData = [];
                foreach ($keseluruhanDiagnosa as $index => $diagnosis) {
                    $similarityPercentage = $keseluruhanSimilarity[$index];
                    if ($similarityPercentage > 0) {
                        $diagnosisData[] = [
                            'diagnosis' => $diagnosis,
                            'similarity' => $similarityPercentage
                        ];
                    }
                }

                // Sort the array by similarity in descending order
                usort($diagnosisData, function($a, $b) {
                    return $b['similarity'] - $a['similarity'];
                });

                // Loop through the sorted data and display the results
                foreach ($diagnosisData as $data) {
                    echo "<tr>
                            <td>" . htmlspecialchars($data['diagnosis']) . "</td>
                            <td>" . number_format($data['similarity'], 2) . "%</td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
</div>
</section>

<script>
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


<?php 
include 'footer.php';?>
