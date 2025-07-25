<?php
session_start();
require '../database/koneksi.php'; // File koneksi database

// Pastikan pengguna sudah login
if (!isset($_SESSION['email'])) {
    header("Location: ../page/login.php"); // Redirect ke login jika belum login
    exit();
}

// Ambil data nama lengkap dan role berdasarkan email dari session
$email = $_SESSION['email'];
$query = "SELECT namalengkap, role FROM user WHERE email = '$email'";
$result = mysqli_query($conn, $query);

if ($row = mysqli_fetch_assoc($result)) {
    $_SESSION['namalengkap'] = $row['namalengkap'];
    $_SESSION['role'] = $row['role']; // Store user role in session
} else {
    echo "User not found!";
}

// Count the number of rows in each table
$count_user_query = "SELECT COUNT(*) AS user_count FROM user";
$count_penyakit_query = "SELECT COUNT(*) AS penyakit_count FROM penyakit";
$count_gejala_query = "SELECT COUNT(*) AS gejala_count FROM gejala";
$count_basiskasus_query = "SELECT COUNT(*) AS basiskasus_count FROM basiskasus";
$count_basiskasus_gejala_query = "SELECT COUNT(*) AS basiskasus_gejala_count FROM basiskasus_gejala";

$count_user = mysqli_fetch_assoc(mysqli_query($conn, $count_user_query))['user_count'];
$count_penyakit = mysqli_fetch_assoc(mysqli_query($conn, $count_penyakit_query))['penyakit_count'];
$count_gejala = mysqli_fetch_assoc(mysqli_query($conn, $count_gejala_query))['gejala_count'];
$count_basiskasus = mysqli_fetch_assoc(mysqli_query($conn, $count_basiskasus_query))['basiskasus_count'];
$count_basiskasus_gejala = mysqli_fetch_assoc(mysqli_query($conn, $count_basiskasus_gejala_query))['basiskasus_gejala_count'];


// Query untuk menghitung jumlah Data Riwayat Deteksi (hasil_similarity tidak NULL)
$count_riwayat_deteksi_query = "SELECT COUNT(*) AS riwayat_deteksi_count FROM hasil WHERE hasil_similarity IS NOT NULL";
$count_riwayat_deteksi = mysqli_fetch_assoc(mysqli_query($conn, $count_riwayat_deteksi_query))['riwayat_deteksi_count'];

// Query untuk menghitung jumlah Data Butuh Revisi Pakar (hasil_similarity NULL)
$count_revisi_pakar_query = "SELECT COUNT(*) AS revisi_pakar_count FROM hasil WHERE hasil_similarity IS NULL AND status_revisi = 'pending'";
$count_revisi_pakar = mysqli_fetch_assoc(mysqli_query($conn, $count_revisi_pakar_query))['revisi_pakar_count'];


// Query untuk menghitung jumlah Data Rekomendasi Kasus Baru Pakar (hasil_similarity NULL)
$count_kasus_baru_query = "SELECT COUNT(*) AS kasus_baru_count FROM hasil WHERE hasil_similarity IS NULL AND status_revisi = 'rejected'";
$count_kasus_baru = mysqli_fetch_assoc(mysqli_query($conn, $count_kasus_baru_query))['kasus_baru_count'];

// Ambil nilai ambang batas dari tabel ambang_batas
$ambang_batas_query = "SELECT nilai FROM ambang_batas WHERE id = 1"; // Ambil data ambang batas pertama
$ambang_batas_result = mysqli_query($conn, $ambang_batas_query);
$nilai_ambang_batas = 0; // Default value jika tidak ada data

if ($ambang_batas_row = mysqli_fetch_assoc($ambang_batas_result)) {
    $nilai_ambang_batas = $ambang_batas_row['nilai'];
}

// Query untuk menghitung total pasien per penyakit
$count_penyakit_pasien_query = "
    SELECT p.namapenyakit, 
           h.jk_pasien, 
           COUNT(h.idhasil) AS jumlah_pasien
    FROM penyakit p
    LEFT JOIN hasil h ON h.hasil_diagnosa LIKE CONCAT('%', p.namapenyakit, '%')
    GROUP BY p.namapenyakit, h.jk_pasien
";
$penyakit_pasien_result = $conn->query($count_penyakit_pasien_query);

// Inisialisasi data
$penyakit_data = [];
$jumlah_pasien_laki_laki = [];
$jumlah_pasien_perempuan = [];
$jumlah_pasien_total = [];

// Memproses hasil query
while ($row = $penyakit_pasien_result->fetch_assoc()) {
    $penyakit = $row['namapenyakit'];
    $jenis_kelamin = $row['jk_pasien'];
    $jumlah_pasien = (int)$row['jumlah_pasien'];

    // Tambahkan nama penyakit jika belum ada
    if (!isset($jumlah_pasien_total[$penyakit])) {
        $penyakit_data[] = $penyakit;
        $jumlah_pasien_laki_laki[$penyakit] = 0;
        $jumlah_pasien_perempuan[$penyakit] = 0;
        $jumlah_pasien_total[$penyakit] = 0;
    }

    // Hitung jumlah pasien berdasarkan jenis kelamin
    if ($jenis_kelamin === 'Laki-laki') {
        $jumlah_pasien_laki_laki[$penyakit] += $jumlah_pasien;
    } elseif ($jenis_kelamin === 'Perempuan') {
        $jumlah_pasien_perempuan[$penyakit] += $jumlah_pasien;
    }

    // Hitung total pasien per penyakit
    $jumlah_pasien_total[$penyakit] += $jumlah_pasien;
}

// Konversi array untuk grafik
$jumlah_pasien_total = array_values($jumlah_pasien_total);
$jumlah_pasien_laki_laki = array_values($jumlah_pasien_laki_laki);
$jumlah_pasien_perempuan = array_values($jumlah_pasien_perempuan);
$penyakit_data = json_encode($penyakit_data);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../asset/css/admin.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* Kartu yang lebih cantik dengan border-radius dan efek hover */
        .card {
            border-radius: 15px; /* Rounded corners */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); /* Soft shadow */
            transition: transform 0.3s ease, box-shadow 0.3s ease; /* Smooth hover effect */
        }

        .card:hover {
            transform: translateY(-10px); /* Hover effect */
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2); /* Enhanced shadow on hover */
        }

        .card-body {
            background-color: #f9f9f9; /* Soft background */
            padding: 20px;
        }

        .card-title {
            font-size: 1.75rem;
            font-weight: 600;
            color: #d62268; /* Bright color for titles */
        }

        .card-text {
            font-size: 1.1rem;
            color: #555; /* Darker text color */
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            font-size: 1rem;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease; /* Smooth transition */
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        /* Styling tabel lebih menarik dengan Bootstrap */
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }

        .table {
            font-size: 1rem; /* Ukuran font yang nyaman dibaca */
            border-radius: 10px; /* Rounded borders for table */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); /* Soft shadow for the table */
        }

        .table-bordered th, .table-bordered td {
            border: 1px solid #dee2e6; /* Custom table border color */
        }

        /* Styling untuk grafik */
        #penyakitChart {
    max-width: 100%;
    height: 500px; /* Sesuaikan dengan ukuran yang lebih besar */
    margin: 20px auto;
}


        /* Kolom-kolom card lebih responsif pada tampilan kecil */
        .row .col-md-4 {
            margin-bottom: 20px;
        }

        /* Mengoptimalkan tampilan untuk mobile */
        @media (max-width: 768px) {
            .col-md-4 {
                max-width: 100%;
            }


            .table {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<?php include 'sidebar.php'; ?>

<!-- Navbar -->
<?php include 'navbar.php'; ?>

<!-- Page Content -->
<div id="content" style="margin-top: 56px;">
<?php if ($_SESSION['role'] == 1): ?>
<h2>Dashboard Admin</h2>
<?php elseif ($_SESSION['role'] == 2): ?>
<h2>Dashboard Pakar</h2>
<?php endif; ?>

    <div class="container mt-4">
        <div class="row">
        <?php if ($_SESSION['role'] == 1): ?>
           <!-- Card Data Pengguna -->
            <div class="col-md-4">
                <a href="a-halpengguna.php" class="text-decoration-none">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title"><i class="bi bi-person-circle me-3"></i>
                            <?php echo $count_user; ?></h5>
                            <p class="card-text">Data Pengguna</p>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Card Data Penyakit -->
            <div class="col-md-4">
            <a href="javascript:void(0);" class="text-decoration-none" onclick="notifyPakarPenyakit()">
            <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title"><i class="bi bi-heart-fill me-2"></i>
                        <?php echo $count_penyakit; ?></h5>
                        <p class="card-text">Data Penyakit</p>
                    </div>
                </div>
                </a>
            </div>

            <!-- Card Data Gejala -->
            <div class="col-md-4">
            <a href="javascript:void(0);" class="text-decoration-none" onclick="notifyPakarGejala()">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title"><i class="bi bi-symmetry-horizontal me-3"></i>
                        <?php echo $count_gejala; ?></h5>
                        <p class="card-text">Data Gejala</p>
                    </div>
                </div>
                </a>
            </div>

            <div class="col-md-4">
            <a href="javascript:void(0);" class="text-decoration-none" onclick="notifyPakarBasisKasus()">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">
                        <i class="bi bi-file-earmark-fill me-2"></i>
                        <?php echo $count_basiskasus; ?></h5>
                        <p class="card-text">Basis Kasus</p>
                    </div>
                </div>
                </a>
            </div>

            <!-- Card Basis Kasus Gejala -->
            <div class="col-md-4">
            <a href="javascript:void(0);" class="text-decoration-none" onclick="notifyPakarBasisKasus()">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">
                        <i class="bi bi-file-earmark-fill me-2"></i>
                        <?php echo $count_basiskasus_gejala; ?></h5>
                        <p class="card-text">Basis Kasus Gejala</p>
                    </div>
                </div>
            </a>
            </div>

            <!-- Card Ambang Batas -->
            <div class="col-md-4">
            <a href="javascript:void(0);" class="text-decoration-none" onclick="notifyPakarAmbangBatas()">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">
                        <i class="bi bi-arrow-up-right-circle me-3"></i>
                        <?php echo $nilai_ambang_batas; ?>%</h5>
                        <p class="card-text">Ambang Batas</p>
                    </div>
                </div>
                </a>
            </div>

            <!-- Card Riwayat Deteksi -->
            <div class="col-md-4">
            <a href="f-halriwayatpasien.php" class="text-decoration-none">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">
                        <i class="bi bi-clock-history me-2"></i>
                        <?php echo $count_riwayat_deteksi; ?></h5>
                        <p class="card-text">Data Riwayat Deteksi</p>
                    </div>
                </div>
                </a>
            </div>

            <!-- Card Butuh  Rekomendasi Kasus Baru Pakar -->
            <div class="col-md-4">
            <a href="javascript:void(0);" class="text-decoration-none" onclick="notifyPakarRevisiPakar()">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">
                            <i class="bi bi-pencil-square me-3"></i>
                            <?php echo $count_revisi_pakar; ?></h5>
                        <p class="card-text">Data Butuh Revisi Pakar</p>
                    </div>
                </div>
                </a>
            </div>

            <div class="col-md-4">
            <a href="javascript:void(0);" class="text-decoration-none" onclick="notifyPakarKasusBaru()">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">
                            <i class="bi bi-pencil-square me-3"></i>
                            <?php echo $count_kasus_baru; ?></h5>
                        <p class="card-text">Data Rekomendasi Kasus Baru</p>
                    </div>
                </div>
                </a>
            </div>

            <!-- Grafik Penyakit Pasien -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Grafik Jumlah Pasien Tiap Penyakit</h5>
                    <canvas id="penyakitChart" width="800" height="500"></canvas>
                    </div>
            </div>
        </div>

            
        <?php elseif ($_SESSION['role'] == 2): ?>

            <div class="col-md-4">
                <a href="javascript:void(0);" class="text-decoration-none" onclick="notifyAdminPengguna()">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title"><i class="bi bi-person-circle me-3"></i>
                            <?php echo $count_user; ?></h5>
                            <p class="card-text">Data Pengguna</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Card Data Penyakit -->
            <div class="col-md-4">
            <a href="b-halpenyakit.php" class="text-decoration-none">

                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title"><i class="bi bi-heart-fill me-2"></i>
                        <?php echo $count_penyakit; ?></h5>
                        <p class="card-text">Data Penyakit</p>
                    </div>
                </div>
                </a>
            </div>

            <!-- Card Data Gejala -->
            <div class="col-md-4">
            <a href="c-halgejala.php" class="text-decoration-none">

                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title"><i class="bi bi-symmetry-horizontal me-3"></i>
                        <?php echo $count_gejala; ?></h5>
                        <p class="card-text">Data Gejala</p>
                    </div>
                </div>
                </a>
            </div>

            <div class="col-md-4">
            <a href="d-halbasiskasus.php" class="text-decoration-none">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">
                        <i class="bi bi-file-earmark-fill me-2"></i>
                        <?php echo $count_basiskasus; ?></h5>
                        <p class="card-text">Basis Kasus</p>
                    </div>
                </div>
                </a>
            </div>

            <!-- Card Basis Kasus Gejala -->
            <div class="col-md-4">
            <a href="d-halbasiskasus.php" class="text-decoration-none">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">
                        <i class="bi bi-file-earmark-fill me-2"></i>
                        <?php echo $count_basiskasus_gejala; ?></h5>
                        <p class="card-text">Basis Kasus Gejala</p>
                    </div>
                </div>
            </a>
            </div>

            <!-- Card Ambang Batas -->
            <div class="col-md-4">
            <a href="e-halambangbatas.php" class="text-decoration-none">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">
                        <i class="bi bi-arrow-up-right-circle me-3"></i>
                        <?php echo $nilai_ambang_batas; ?>%</h5>
                        <p class="card-text">Ambang Batas</p>
                    </div>
                </div>
                </a>
            </div>

            <!-- Card Riwayat Deteksi -->
            <div class="col-md-4">
            <a href="f-halriwayatpasien.php" class="text-decoration-none">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">
                        <i class="bi bi-clock-history me-2"></i>
                        <?php echo $count_riwayat_deteksi; ?></h5>
                        <p class="card-text">Data Riwayat Deteksi</p>
                    </div>
                </div>
                </a>
            </div>

            <!-- Card Butuh Revisi Pakar -->
            <div class="col-md-4">
            <a href="g-halrevisipakar.php" class="text-decoration-none">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">
                            <i class="bi bi-pencil-square me-3"></i>
                            <?php echo $count_revisi_pakar; ?></h5>
                        <p class="card-text">Data Butuh Revisi Pakar</p>
                    </div>
                </div>
                </a>
            </div>

             <!-- Card Rekomendasi Kasus Baru Pakar -->
             <div class="col-md-4">
            <a href="h-halkasusbaru.php" class="text-decoration-none">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">
                        <i class="bi bi-folder-fill me-3"></i>
                        <?php echo $count_kasus_baru; ?></h5>
                        <p class="card-text">Data Rekomendasi Kasus Baru</p>
                    </div>
                </div>
                </a>
            </div>
        </div>

        <!-- Grafik Penyakit Pasien -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Grafik Jumlah Pasien Tiap Penyakit</h5>
                    <canvas id="penyakitChart" width="800" height="500"></canvas>
                    </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>


<script>
    var ctx = document.getElementById('penyakitChart').getContext('2d');
    var penyakitChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo $penyakit_data; ?>, // Nama penyakit
            datasets: [
                {
                    label: 'Total Pasien',
                    data: <?php echo json_encode($jumlah_pasien_total); ?>, // Total jumlah pasien
                    backgroundColor: 'rgba(255, 223, 0, 0.5)', // Kuning
                    borderColor: 'rgba(255, 223, 0, 1)', // Kuning tua
                    borderWidth: 1
                },
                {
                    label: 'Laki-laki',
                    data: <?php echo json_encode($jumlah_pasien_laki_laki); ?>, // Pasien laki-laki
                    backgroundColor: 'rgba(54, 162, 235, 0.5)', // Biru
                    borderColor: 'rgba(54, 162, 235, 1)', // Biru tua
                    borderWidth: 1
                },
                {
                    label: 'Perempuan',
                    data: <?php echo json_encode($jumlah_pasien_perempuan); ?>, // Pasien perempuan
                    backgroundColor: 'rgba(255, 99, 132, 0.5)', // Pink
                    borderColor: 'rgba(255, 99, 132, 1)', // Pink tua
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    enabled: true,
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah Pasien'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Penyakit'
                    }
                }
            }
        }
    });
</script>


<script>
    function notifyAdminPengguna() {
        alert('Hubungi admin untuk pengelolaan Data Pengguna.');
    }

    function notifyPakarPenyakit() {
        alert('Hubungi pakar untuk pengelolaan Data Penyakit.');
    }

    function notifyPakarGejala() {
        alert('Hubungi pakar untuk pengelolaan Data Gejala.');
    }

    function notifyPakarBasisKasus() {
        alert('Hubungi pakar untuk pengelolaan Basis Kasus.');
    }

    function notifyPakarAmbangBatas() {
        alert('Hubungi pakar untuk pengelolaan Nilai Ambang Batas.');
    }

    function notifyPakarRevisiPakar() {
        alert('Hubungi pakar untuk pengelolaan Data Revisi Pakar.');
    }

    function notifyPakarKasusBaru() {
        alert('Hubungi pakar untuk pengelolaan Data Rekomendasi Kasus Baru.');
    }
</script>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script src="../asset/js/admin.js"></script>

</body>
</html>



