<?php
session_start();
require '../../database/koneksi.php'; // File koneksi database

// Add Data
if (isset($_POST['tambah'])) {
    $kodepenyakit = mysqli_real_escape_string($conn, $_POST['kodepenyakit']);
    $kodegejalaList = $_POST['kodegejala']; // Get selected gejala as an array

    // Check if any gejala is selected
    if (empty($kodegejalaList)) {
        echo "<script>alert('Pilih setidaknya satu gejala!'); window.history.back();</script>";
        exit();
    }

    // Generate new kode for basis kasus
    $lastKode = mysqli_fetch_assoc(mysqli_query($conn, "SELECT kodebasiskasus FROM basiskasus ORDER BY kodebasiskasus DESC LIMIT 1"))['kodebasiskasus'];
    $newKode = 'BK' . str_pad((int)substr($lastKode, 2) + 1, 3, '0', STR_PAD_LEFT);
    
    // Insert into basiskasus
    mysqli_query($conn, "INSERT INTO basiskasus (kodebasiskasus, kodepenyakit) VALUES ('$newKode', '$kodepenyakit')");
    
    // Insert into basiskasus_gejala for each selected gejala
    foreach ($kodegejalaList as $kodegejala) {
        $insertQuery = "INSERT INTO basiskasus_gejala (kodebasiskasus, kodegejala) VALUES ('$newKode', '$kodegejala')";
        mysqli_query($conn, $insertQuery);
    }
    header("Location: ../../admin/d-halbasiskasus.php");
    exit();
}
?>