<?php
session_start();
require '../../database/koneksi.php'; // File koneksi database

// Edit Data
if (isset($_POST['ubah'])) {
    $kodebasiskasus = mysqli_real_escape_string($conn, $_POST['kodebasiskasus']);
    $kodepenyakit = mysqli_real_escape_string($conn, $_POST['kodepenyakit']);
    $kodegejalaList = $_POST['kodegejala']; // Changed to handle array

    // Check if any gejala is selected
    if (empty($kodegejalaList)) {
        echo "<script>alert('Pilih setidaknya satu gejala!'); window.history.back();</script>";
        exit();
    }

    // Update basis kasus
    $updateQuery = "UPDATE basiskasus SET kodepenyakit='$kodepenyakit' WHERE kodebasiskasus='$kodebasiskasus'";
    mysqli_query($conn, $updateQuery);

    // Clear existing gejala links
    mysqli_query($conn, "DELETE FROM basiskasus_gejala WHERE kodebasiskasus='$kodebasiskasus'");

    // Insert updated gejala
    foreach ($kodegejalaList as $kodegejala) {
        $insertQuery = "INSERT INTO basiskasus_gejala (kodebasiskasus, kodegejala) VALUES ('$kodebasiskasus', '$kodegejala')";
        mysqli_query($conn, $insertQuery);
    }

    header("Location: ../../admin/d-halbasiskasus.php");
    exit();
}
?>