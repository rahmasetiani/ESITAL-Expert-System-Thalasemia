<?php
session_start();
require '../database/koneksi.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Retrieve the last patient record
$query = "SELECT * FROM personaldata_pasien WHERE iduser = ? ORDER BY idpersonal_pasien DESC LIMIT 1";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Fetch selected symptoms for the last patient record, including names
$gejalaQuery = "SELECT g.kodegejala, g.namagejala 
                FROM pasien_gejala pg 
                JOIN gejala g ON pg.kodegejala_terpilih = g.kodegejala 
                WHERE pg.idpersonal_pasien = ?";
$gejalaStmt = $conn->prepare($gejalaQuery);
$gejalaStmt->bind_param("i", $row['idpersonal_pasien']);
$gejalaStmt->execute();
$gejalaResult = $gejalaStmt->get_result();

$selectedGejala = [];
while ($gejalaRow = $gejalaResult->fetch_assoc()) {
    $selectedGejala[] = [
        'kode' => $gejalaRow['kodegejala'],
        'nama' => $gejalaRow['namagejala']
    ];
}

// Retrieve cases from basiskasus and calculate similarity
$caseQuery = "SELECT bk.kodebasiskasus, bk.kodepenyakit, p.namapenyakit, 
              GROUP_CONCAT(g.kodegejala) AS gejala 
              FROM basiskasus bk 
              JOIN penyakit p ON bk.kodepenyakit = p.kodepenyakit 
              JOIN basiskasus_gejala bg ON bk.kodebasiskasus = bg.kodebasiskasus 
              JOIN gejala g ON bg.kodegejala = g.kodegejala 
              GROUP BY bk.kodebasiskasus";
$caseResult = $conn->query($caseQuery);

$casesSimilarity = [];
while ($case = $caseResult->fetch_assoc()) {
    $caseGejala = explode(",", $case['gejala']);
    $matchingSymptoms = array_intersect(array_column($selectedGejala, 'kode'), $caseGejala);
    $similarityScore = count($matchingSymptoms) / count($caseGejala);
    $casesSimilarity[] = [
        'kodebasiskasus' => $case['kodebasiskasus'],
        'namapenyakit' => $case['namapenyakit'],
        'similarity' => $similarityScore
    ];
}

// Sort cases by similarity descending
usort($casesSimilarity, function($a, $b) {
    return $b['similarity'] <=> $a['similarity'];
});

$bestMatch = $casesSimilarity[0];
?>
<!-- Header (use include for separating header) -->
<?php include 'header.php'; ?>   
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- HTML output -->
<div class="container my-5"> <!-- Adjusted margin for better spacing -->
    <section class="diagnosis-section" style="background-color: #f8f9fa; padding: 20px; border-radius: 8px;"> <!-- Light gray background -->
        <h2 class="text-center mb-4" style="color: black;">Hasil Pemeriksaan Pasien</h2> 
        
        <div class="card mb-4">
            <div class="card-body">
                <div class="row justify-content-start">
                    <div class="col-md-12"> <!-- Changed to full width for better spacing -->
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
                                            <td><strong>Tanggal Pemeriksaan</strong></td>
                                            <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Gejala yang Dipilih</strong></td>
                                            <td>
                                                <?php if (!empty($selectedGejala)): ?>
                                                    <ol style="margin: 0; padding-left: 20px;">
                                                        <?php foreach ($selectedGejala as $gejala): ?>
                                                            <li><?php echo htmlspecialchars($gejala['kode']); ?> - <?php echo htmlspecialchars($gejala['nama']); ?></li>
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

        <h2 class="text-center mb-4" style="color: black;">Hasil Diagnosa</h2>
        <div class="card">
            <div class="card-body">
                <h3 style="color: black;">Hasil dengan Similarity Tertinggi</h3>
                <p style="color: black;"><strong>Nama Penyakit:</strong> <?php echo htmlspecialchars($bestMatch['namapenyakit']); ?></p>
                <p style="color: black;"><strong>Similarity:</strong> <?php echo round($bestMatch['similarity'] * 100, 2); ?>%</p>

                <h3 style="color: black;">Similarity Setiap Kasus</h3>
                <ul class="list-group">
                    <?php foreach ($casesSimilarity as $case): ?>
                        <li class="list-group-item">
                            <strong>Kode Kasus:</strong> <?php echo htmlspecialchars($case['kodebasiskasus']); ?>, 
                            <strong>Penyakit:</strong> <?php echo htmlspecialchars($case['namapenyakit']); ?>, 
                            <strong>Similarity:</strong> <?php echo round($case['similarity'] * 100, 2); ?>%
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </section>
</div>



<?php
include 'footer.php'; // Memanggil footer
?>

