<?php
session_start();
require '../database/koneksi.php';

if (!isset($_SESSION['email'])) {
    header("Location: ../page/login.php");
    exit();
}

// Initialize $current_threshold with a default value
$current_threshold = 0;

// Check if the row for ambang_batas exists, if not, create it with default value 0
$query = "SELECT * FROM ambang_batas WHERE id = 1";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    // If the row does not exist, create it with default value 0%
    $insert_query = "INSERT INTO ambang_batas (id, nilai) VALUES (1, 0)";
    mysqli_query($conn, $insert_query);
} else {
    // If the row exists, fetch the current value
    $row = mysqli_fetch_assoc($result);
    $current_threshold = $row['nilai'];
}

// Handle form submission to update the threshold value
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_threshold = $_POST['nilai_ambang_batas'];

    // Validate input: check if it's a number between 0 and 100
    if (is_numeric($new_threshold) && $new_threshold >= 0 && $new_threshold <= 100) {
        // Update the threshold value in the database (only update for id=1)
        $update_query = "UPDATE ambang_batas SET nilai = $new_threshold WHERE id = 1";
        mysqli_query($conn, $update_query);
        
        // Reload the page after updating
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    } else {
        $error = "Nilai Ambang Batas harus antara 0 dan 100.";
    }
}
?>
