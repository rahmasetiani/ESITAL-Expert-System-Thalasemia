<?php
session_start();
require '../../database/koneksi.php'; // File koneksi database

// Delete Data
if (isset($_GET['kodebasiskasus'])) {
    // Mengambil dan membersihkan input
    $kodebasiskasus = mysqli_real_escape_string($conn, $_GET['kodebasiskasus']);
    
    // Mulai transaksi
    mysqli_begin_transaction($conn);

    try {
        // Hapus dari tabel basiskasus
        $query1 = mysqli_query($conn, "DELETE FROM basiskasus WHERE kodebasiskasus = '$kodebasiskasus'");
        // Hapus dari tabel basiskasus_gejala
        $query2 = mysqli_query($conn, "DELETE FROM basiskasus_gejala WHERE kodebasiskasus = '$kodebasiskasus'"); // Hapus gejala terkait
        
        // Cek apakah query berhasil
        if ($query1 && $query2) {
            // Commit jika semua query berhasil
            mysqli_commit($conn);
        } else {
            // Rollback jika ada kesalahan
            mysqli_rollback($conn);
            throw new Exception("Error in deleting data: " . mysqli_error($conn));
        }

        // Redirect setelah penghapusan
        header("Location: ../../admin/d-halbasiskasus.php");
        exit();
    } catch (Exception $e) {
        // Tangani kesalahan
        echo "Terjadi kesalahan: " . $e->getMessage();
    }
}
?>
