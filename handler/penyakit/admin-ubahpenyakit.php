<?php
session_start();
require '../../database/koneksi.php';

if (!isset($_SESSION['email'])) {
    header("Location: ../page/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input data
    $kodepenyakit = mysqli_real_escape_string($conn, $_POST['kodepenyakit']);
    $namapenyakit = mysqli_real_escape_string($conn, $_POST['namapenyakit']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $solusipengobatan = mysqli_real_escape_string($conn, $_POST['solusipengobatan']);
    
    // Handle file upload
    $targetDir = "../../asset/image/penyakit/";
    $fileName = basename($_FILES["foto"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Initialize image upload variable
    $imageUploadSuccess = true;
    $newFileUploaded = !empty($fileName); // Check if a new file was uploaded

    // If a new file is uploaded, check for valid file type
    if ($newFileUploaded) {
        $allowedTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array(strtolower($fileType), $allowedTypes)) {
            // Upload file
            if (!move_uploaded_file($_FILES["foto"]["tmp_name"], $targetFilePath)) {
                $imageUploadSuccess = false;
                echo "Error uploading the file.";
            }
        } else {
            $imageUploadSuccess = false;
            echo "Invalid file type. Only JPG, JPEG, PNG & GIF files are allowed.";
        }
    }

    // Fetch the current image from the database
    $currentQuery = "SELECT foto FROM penyakit WHERE kodepenyakit = '$kodepenyakit'";
    $currentResult = mysqli_query($conn, $currentQuery);
    $currentRow = mysqli_fetch_assoc($currentResult);
    $currentPhoto = $currentRow['foto']; // Save the current photo

    // Update the database
    if ($imageUploadSuccess) {
        $updateQuery = "UPDATE penyakit SET 
            namapenyakit = '$namapenyakit', 
            deskripsi = '$deskripsi', 
            solusipengobatan = '$solusipengobatan'" . 
            ($newFileUploaded ? ", foto = '$fileName'" : ", foto = '$currentPhoto'") . 
            " WHERE kodepenyakit = '$kodepenyakit'";

        if (mysqli_query($conn, $updateQuery)) {
            header("Location: ../../admin/b-halpenyakit.php?limit=5&page=1&search=");
            exit();
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }
}
?>
