<?php
session_start();
require '../../database/koneksi.php'; // File koneksi database

// Handle Update User
if (isset($_POST['update_user'])) {
    $id = $_POST['id'];
    $namalengkap = $_POST['namalengkap'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Update user in the database
    $updateQuery = "UPDATE user SET namalengkap = '$namalengkap', email = '$email', role = '$role' WHERE id = $id";
    mysqli_query($conn, $updateQuery);
    header("Location: ../../admin/a-halpengguna.php"); // Redirect back to dashboard
    exit();
} else {
    echo "Update action not performed!";
}
?>
