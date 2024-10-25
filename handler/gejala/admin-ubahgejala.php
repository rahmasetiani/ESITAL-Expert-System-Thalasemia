<?php
require '../../database/koneksi.php';

// Ambil data dari form
$kodeGejala = $_POST['kodegejala'];
$namaGejala = $_POST['nama_gejala'];
$bobot = $_POST['bobot'];

// Pastikan data valid sebelum melakukan update
if (empty($kodeGejala) || empty($namaGejala) || empty($bobot)) {
    echo "<script>alert('Semua kolom harus diisi!'); window.location.href = '../../admin/c-halgejala.php';</script>";
    exit();
}

// Cek apakah nama gejala yang baru sudah ada di database
$queryCheck = "SELECT * FROM gejala WHERE namagejala = '$namaGejala' AND kodegejala != '$kodeGejala'";
$resultCheck = mysqli_query($conn, $queryCheck);

// Cek apakah query berhasil
if (!$resultCheck) {
    die("Query gagal: " . mysqli_error($conn)); // Menampilkan pesan error jika query gagal
}

// Cek jika gejala sudah ada
if (mysqli_num_rows($resultCheck) > 0) {
    echo "<script>alert('Gejala dengan nama \"$namaGejala\" sudah ada di database!'); window.location.href = '../../admin/c-halgejala.php';</script>";
    exit();
}

// Query untuk memperbarui data gejala
$query = "UPDATE gejala SET namagejala = '$namaGejala', bobot = '$bobot' WHERE kodegejala = '$kodeGejala'";

if (mysqli_query($conn, $query)) {
    // Jika berhasil, arahkan kembali ke halaman daftar gejala
    header("Location: ../../admin/c-halgejala.php");
    exit();
} else {
    // Jika ada error saat melakukan update
    die("Error: " . mysqli_error($conn));
}
?>
