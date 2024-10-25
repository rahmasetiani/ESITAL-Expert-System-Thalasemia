<?php
require '../../database/koneksi.php';

$namaGejala = $_POST['nama_gejala'];
$bobot = $_POST['bobot'];

// Pastikan nama kolom dalam query sesuai dengan nama yang ada di database
$queryCheck = "SELECT * FROM gejala WHERE namagejala = '$namaGejala'";
$resultCheck = mysqli_query($conn, $queryCheck);

// Cek apakah query berhasil
if (!$resultCheck) {
    die("Query gagal: " . mysqli_error($conn)); // Menampilkan pesan error jika query gagal
}

// Cek apakah gejala sudah ada
if (mysqli_num_rows($resultCheck) > 0) {
    echo "<script>alert('Gejala sudah ada!'); window.location.href = '../../admin/c-halgejala.php';</script>";
} else {
    // Generate kode gejala
    $kodeGejala = 'G' . str_pad((mysqli_num_rows(mysqli_query($conn, "SELECT * FROM gejala")) + 1), 3, '0', STR_PAD_LEFT);
    
    $query = "INSERT INTO gejala (kodegejala, namagejala, bobot) VALUES ('$kodeGejala', '$namaGejala', '$bobot')";
    
    if (mysqli_query($conn, $query)) {
        header("Location: ../../admin/c-halgejala.php");
        exit(); // Penting untuk menghentikan eksekusi script setelah header
    } else {
        die("Error: " . mysqli_error($conn)); // Menampilkan pesan error jika insert gagal
    }
}
?>
