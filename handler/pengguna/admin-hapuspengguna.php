<?php
session_start();
require '../../database/koneksi.php'; // File koneksi database

// Handle Delete User
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $deleteQuery = "DELETE FROM user WHERE id = $id";
    mysqli_query($conn, $deleteQuery);
    header("Location: ../../admin/a-halpengguna.php"); // Redirect back to dashboard
    exit();
} else {
    echo "No user ID provided!";
}
?>
