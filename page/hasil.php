<?php
include 'header.php';
require '../database/koneksi.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
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

// Fetch the names of the selected symptoms from the gejala table
$gejalaNames = [];
foreach ($selectedGejala as $kode) {
    $gejalaNameQuery = "SELECT namagejala FROM gejala WHERE kodegejala = ?";
    $gejalaNameStmt = $conn->prepare($gejalaNameQuery);
    $gejalaNameStmt->bind_param("s", $kode);
    $gejalaNameStmt->execute();
    $gejalaNameResult = $gejalaNameStmt->get_result();
    $gejalaNameRow = $gejalaNameResult->fetch_assoc();
    
    if ($gejalaNameRow) {
        $gejalaNames[] = $gejalaNameRow['namagejala'];  // Store the name of the symptom
    }
}

// Fetch symptom weights from the gejala table
$gejalaWeights = [];
foreach ($selectedGejala as $kode) {
    $gejalaWeightQuery = "SELECT bobot FROM gejala WHERE kodegejala = ?";
    $gejalaWeightStmt = $conn->prepare($gejalaWeightQuery);
    $gejalaWeightStmt->bind_param("s", $kode);
    $gejalaWeightStmt->execute();
    $gejalaWeightResult = $gejalaWeightStmt->get_result();
    $weightRow = $gejalaWeightResult->fetch_assoc();
    if ($weightRow) {
        $gejalaWeights[$kode] = $weightRow['bobot'];
    }
}

// Retrieve the threshold value for similarity from the ambang_batas table
$thresholdQuery = "SELECT nilai FROM ambang_batas WHERE id = 1 LIMIT 1"; // Assuming 1 as the ID for the threshold
$thresholdStmt = $conn->query($thresholdQuery);
$thresholdRow = $thresholdStmt->fetch_assoc();
$threshold = $thresholdRow ? $thresholdRow['nilai'] : 0.0;

// Retrieve patient details based on iduser
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
$caseQuery = "SELECT bk.kodebasiskasus, bk.kodepenyakit, p.namapenyakit, 
              GROUP_CONCAT(g.kodegejala) AS gejala, SUM(g.bobot) AS total_bobot 
              FROM basiskasus bk 
              JOIN penyakit p ON bk.kodepenyakit = p.kodepenyakit 
              JOIN basiskasus_gejala bg ON bk.kodebasiskasus = bg.kodebasiskasus 
              JOIN gejala g ON bg.kodegejala = g.kodegejala 
              GROUP BY bk.kodebasiskasus";
$caseResult = $conn->query($caseQuery);

// Initialize arrays for cases above and below the threshold
$casesAboveThreshold = [];
$casesBelowThreshold = [];

// Process cases and split them into above and below threshold
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

    // Sort cases based on similarity score and split into above and below threshold
    if ($similarityScore >= ($threshold / 100)) {
        $casesAboveThreshold[] = [
            'kodebasiskasus' => $case['kodebasiskasus'],
            'namapenyakit' => $case['namapenyakit'],
            'matching_bobot' => $matchingBobot,
            'total_bobot' => $caseTotalBobot,
            'similarity' => $similarityScore * 100  // Display as percentage
        ];
    } else {
        $casesBelowThreshold[] = [
            'kodebasiskasus' => $case['kodebasiskasus'],
            'namapenyakit' => $case['namapenyakit'],
            'matching_bobot' => $matchingBobot,
            'total_bobot' => $caseTotalBobot,
            'similarity' => $similarityScore * 100
        ];
    }
}

// Sort cases above the threshold by similarity descending
usort($casesAboveThreshold, function($a, $b) {
    return $b['similarity'] <=> $a['similarity'];
});

// Sort cases below the threshold by similarity ascending (or as needed)
usort($casesBelowThreshold, function($a, $b) {
    return $a['similarity'] <=> $b['similarity'];
});

$bestMatch = !empty($casesAboveThreshold) ? $casesAboveThreshold[0] : null;
?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- HTML output -->
<div class="container my-5">
    <section class="diagnosis-section" style="background-color: #f8f9fa; padding: 20px; border-radius: 8px;">
        <h2 class="text-center mb-4" style="color: black;">Hasil Pemeriksaan Pasien</h2> 
        
        <div class="card mb-4">
            <div class="card-body">
                <div class="row justify-content-start">
                    <div class="col-md-12">
                        <?php if ($row): ?>
                            <div class="table-responsive">
                                <table class="table table-striped">
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
        <?php if (!empty($gejalaNames)): ?>
            <ol style="margin: 0; padding-left: 20px;">
                <?php foreach ($gejalaNames as $gejalaName): ?>
                    <li><?php echo htmlspecialchars($gejalaName); ?></li>
                <?php endforeach; ?>
            </ol>
        <?php else: ?>
            Tidak ada gejala yang ditemukan.
        <?php endif; ?>
    </td>
</tr>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-center">Tidak ada data pasien yang ditemukan.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Display cases above threshold -->
        <h2 class="text-center mb-4" style="color: black;">Hasil Diagnosa</h2> 
<?php if ($bestMatch): ?>
<?php
// Ambil kodepenyakit dari $bestMatch (asumsi bestMatch sudah ada)
$namapenyakit = $bestMatch['namapenyakit'];

// Query untuk mengambil informasi penyakit
$query = "SELECT * FROM penyakit WHERE namapenyakit = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $namapenyakit);  // Bind kodepenyakit ke query
$stmt->execute();
$result = $stmt->get_result();

// Cek apakah ada data penyakit yang ditemukan
if ($result->num_rows > 0) {
    $penyakit = $result->fetch_assoc(); // Ambil data penyakit
} else {
    $penyakit = null; // Jika tidak ditemukan
}
?>
    <div class="card">
        <div class="card-body">
        <h5 style="color: black;">Hasil diagnosa menunjukkan bahwa berdasarkan gejala yang anda rasakan anda memiliki kemungkinan menggidap penyakit :  </h5>
<br>
        <h5 style="color: black;"><strong><?php echo htmlspecialchars($bestMatch['namapenyakit']); ?></p> </strong></h></h5>
            <h5 style="color: black;">
                <strong>Dengan Akurasi Pakar :</strong> <?php echo round($bestMatch['similarity'], 2); ?>%
                <!-- (<?php echo $bestMatch['matching_bobot']; ?> bobot matching / <?php echo $bestMatch['total_bobot']; ?> total bobot) --></h5>
            <br>
            <!-- Menampilkan detail penyakit jika data ditemukan -->
            <?php if ($penyakit): ?>
                <?php if ($penyakit['foto']): ?>
    <img src="../asset/image/penyakit/<?php echo htmlspecialchars($penyakit['foto']); ?>" alt="Foto Penyakit" class="img-fluid rounded-corner shadow-effect" style="max-width: 300px; height: auto;">
<?php endif; ?>

                <br>
                <br>
                <p style="text-align: justify;"><strong>Deskripsi Penyakit:</strong> <?php echo htmlspecialchars($penyakit['deskripsi']); ?></p>
                <p style="text-align: justify;"><strong>Solusi Pengobatan:</strong> <?php echo htmlspecialchars($penyakit['solusipengobatan']); ?></p>
               
            <?php else: ?>
                <p style="color: black;">Informasi tentang penyakit tidak ditemukan.</p>
            <?php endif; ?>
            <br>
            <h5 style="color: black;">Kemungkinan Penyakit Lain di Atas Ambang Batas Pakar</h5>
            <ul class="list-group">
                <?php foreach ($casesAboveThreshold as $case): ?>
                    <li class="list-group-item">
                        <!-- <strong>Kode Kasus:</strong> <?php echo htmlspecialchars($case['kodebasiskasus']); ?>,  -->
                        <strong>Penyakit:</strong> <?php echo htmlspecialchars($case['namapenyakit']); ?>, 
                        <strong>Akurasi:</strong> <?php echo round($case['similarity'], 2); ?>%
                    </li>
                <?php endforeach; ?>
            </ul> <br>
<?php else: ?>
    <p class="text-center" style="color: black;"><strong>Berdasarkan gejala yang Anda rasakan, Anda tidak terindikasi menderita penyakit Thalassemia.</strong></p>
    <p class="text-center" style="color: black;"><strong> Namun, gejala yang Anda alami akan kami tinjau ulang bersama pakar untuk memastikan hasil diagnosa lebih akurat.</p></strong> <br>
<?php endif; ?>
<!-- Display cases below threshold -->
<h5 style="color: black;">Kemungkinan Penyakit Lain di Bawah Ambang Batas Pakar</h5>
<?php if (!empty($casesBelowThreshold)): ?>
    <ul class="list-group">
        <?php foreach ($casesBelowThreshold as $case): ?>
            <?php if ($case['similarity'] > 0): ?>
                <li class="list-group-item">
                    <!-- <strong>Kode Kasus:</strong> <?php echo htmlspecialchars($case['kodebasiskasus']); ?>,  -->
                    <strong>Penyakit:</strong> <?php echo htmlspecialchars($case['namapenyakit']); ?>, 
                    <strong>Akurasi:</strong> <?php echo round($case['similarity'], 2); ?>%
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>


    </section>
</div>
<style>
    /* Add these styles to your CSS file or inside a <style> tag */
.rounded-corner {
    border-radius: 15px; /* Adjust the value for more/less rounding */
}

.shadow-effect {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Adds a subtle shadow around the image */
}

</style>
<?php include 'footer.php'; ?>

