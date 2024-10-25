<?php
require '../../database/koneksi.php';

$kodePenyakit = $_GET['kodepenyakit'];

// Prepare the delete query
$query = "DELETE FROM penyakit WHERE kodepenyakit = '$kodePenyakit'";

if (mysqli_query($conn, $query)) {
    header("Location: ../../admin/b-halpenyakit.php");
    exit();
} else {
    die("Error: " . mysqli_error($conn));
}
?>
