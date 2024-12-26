<?php
require '../../database/koneksi.php';  // This file contains your mysqli connection

// Check if the user is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../../page/login.php');
    exit;
}

// Check if 'idhasil' is passed in the URL
if (isset($_GET['idhasil'])) {
    $idhasil = $_GET['idhasil'];

    // Start a transaction to ensure consistency
    $conn->begin_transaction();

    try {
        // Delete from 'hasil' table
        $sql_hasil = "DELETE FROM hasil WHERE idhasil = ?";
        $stmt_hasil = $conn->prepare($sql_hasil);
        $stmt_hasil->bind_param("i", $idhasil);
        $stmt_hasil->execute();

        // Commit the transaction
        $conn->commit();

        // Redirect back to riwayat.php after successful deletion
        header('Location: ../../admin/h-halkasusbaru.php');
        exit;
    } catch (Exception $e) {
        // Rollback the transaction in case of error
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
} else {
    // If no 'idhasil' is provided, redirect back to riwayat.php
    header('Location: ../../admin/h-halkasusbaru.php');
    exit;
}
?>
