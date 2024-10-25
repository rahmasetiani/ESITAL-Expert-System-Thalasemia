<?php
session_start();
require '../../database/koneksi.php';

if (!isset($_SESSION['email'])) {
    header("Location: ../page/login.php");
    exit();
}

// Generate kodepenyakit
$maxKodeQuery = "SELECT MAX(kodepenyakit) AS maxKode FROM penyakit";
$result = mysqli_query($conn, $maxKodeQuery);
$row = mysqli_fetch_assoc($result);
$maxKode = $row['maxKode'];

// Generate the next kodepenyakit
$nextKode = (int) substr($maxKode, 1) + 1; // Remove 'P' and increment
$newKodePenyakit = 'P' . str_pad($nextKode, 3, '0', STR_PAD_LEFT); // Format to 'P001', 'P002', etc.

// Collect other data from the POST request
$namapenyakit = mysqli_real_escape_string($conn, $_POST['nama_penyakit']);
$deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
$solusi = mysqli_real_escape_string($conn, $_POST['solusi']);

// Cek apakah nama penyakit sudah ada
$checkQuery = "SELECT * FROM penyakit WHERE namapenyakit = '$namapenyakit'";
$resultCheck = mysqli_query($conn, $checkQuery);

if (mysqli_num_rows($resultCheck) > 0) {
    // Nama penyakit sudah ada
    echo "<script>alert('Nama penyakit sudah ada!'); window.location.href = '../../admin/b-halpenyakit.php';</script>";
    exit();
}

// Handle file upload for the image
$foto = $_FILES['foto']['name'];
$targetDir = '../../asset/image/penyakit/'; // Make sure this directory exists
$targetFile = $targetDir . basename($foto);

// Check if the file was uploaded successfully
if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetFile)) {
    // Prepare the insert query
    $insertQuery = "INSERT INTO penyakit (kodepenyakit, namapenyakit, deskripsi, solusipengobatan, foto) 
                    VALUES ('$newKodePenyakit', '$namapenyakit', '$deskripsi', '$solusi', '$foto')";

    // Execute the insert query and check for success
    if (mysqli_query($conn, $insertQuery)) {
        // Redirect back to the list page with success message
        header("Location: ../../admin/b-halpenyakit.php?message=success");
        exit(); // Always exit after a redirect
    } else {
        // Error inserting data
        die("Error inserting data: " . mysqli_error($conn));
    }
} else {
    // Error uploading file
    die("Error uploading file: " . $_FILES['foto']['error']);
}
?>