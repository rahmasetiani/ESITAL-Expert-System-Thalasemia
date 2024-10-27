<?php
require '../database/koneksi.php'; // Ensure you include your database connection

// Check if form step is set in session, if not, initialize to step 1
if (!isset($_SESSION['form_step'])) {
    $_SESSION['form_step'] = 1; 
}

// Initialize error message variable
$error_message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['back'])) {
        // Set the form step back to Step 1 and clear any existing data in session for Step 2
        $_SESSION['form_step'] = 1;
        unset($_SESSION['gejala']); // Reset selected symptoms if necessary
    } elseif ($_SESSION['form_step'] == 1) {
        // Handle form submission for step 1
        $_SESSION['personal_data'] = [
            'nama' => $_POST['nama'],
            'tanggal_lahir' => $_POST['tanggal_lahir'],
            'alamat' => $_POST['alamat'],
            'jenis_kelamin' => $_POST['jenis_kelamin']
        ];
        $_SESSION['form_step'] = 2; // Move to step 2
    } elseif ($_SESSION['form_step'] == 2) {
        // Handle form submission for step 2
        if (isset($_POST['gejala']) && count($_POST['gejala']) >= 3) {
            // Process the symptoms and initiate detection logic
            // Example: Save to database or perform detection
            
            // Clear session to reset the form
            session_destroy();
            echo "<script>alert('Deteksi berhasil dilakukan!');</script>"; // Show success notification
            exit;
        } else {
            $error_message = "Silakan pilih minimal 3 gejala."; // Set error message if not enough symptoms are selected
        }
    }
}
?>