<?php
session_start();
require '../../database/koneksi.php';

// Check if form is submitted
if (isset($_POST['update_user'])) {
    $id = $_POST['id'];
    $namalengkap = $_POST['namalengkap'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];

    // If password is provided, hash it, otherwise keep the current password
    if (!empty($_POST['password'])) {
        // Hash new password
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    } else {
        // If no password is entered, do not change the current password
        $query = mysqli_query($conn, "SELECT password FROM user WHERE id = '$id'");
        $user = mysqli_fetch_assoc($query);
        $password = $user['password']; // Use existing password
    }

    // Update user details
    $updateQuery = "UPDATE user SET
                    namalengkap = '$namalengkap',
                    email = '$email',
                    password = '$password',
                    role = '$role',
                    tanggal_lahir = '$tanggal_lahir',
                    jenis_kelamin = '$jenis_kelamin',
                    alamat = '$alamat'
                    WHERE id = '$id'";

    if (mysqli_query($conn, $updateQuery)) {
        $_SESSION['message'] = "Pengguna berhasil diubah!";
        header("Location: ../../admin/a-halpengguna.php"); // Redirect back to the dashboard
    } else {
        $_SESSION['error'] = "Gagal mengubah pengguna!";
        header("Location: ../../admin/a-halpengguna.php");
    }
}
?>
