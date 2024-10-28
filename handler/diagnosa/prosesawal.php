<?php
require '../database/koneksi.php'; // Import database connection

// Check if form step is set in session, if not, initialize to step 1
if (!isset($_SESSION['form_step'])) {
    $_SESSION['form_step'] = 1; 
}

// Initialize error message variable
$error_message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['back'])) {
        // Set form step back to Step 1
        $_SESSION['form_step'] = 1;
    } elseif ($_SESSION['form_step'] == 1) {
        // Handle form submission for Step 1
        $_SESSION['personal_data'] = [
            'nama' => $_POST['nama'],
            'tanggal_lahir' => $_POST['tanggal_lahir'],
            'alamat' => $_POST['alamat'],
            'jenis_kelamin' => $_POST['jenis_kelamin']
        ];
        $_SESSION['form_step'] = 2; // Move to Step 2
    } elseif ($_SESSION['form_step'] == 2) {
        // Handle form submission for Step 2
        if (isset($_POST['gejala']) && count($_POST['gejala']) >= 3) {
            // Save personal data to personaldata_pasien table
            $nama = $_SESSION['personal_data']['nama'];
            $tanggal_lahir = $_SESSION['personal_data']['tanggal_lahir'];
            $alamat = $_SESSION['personal_data']['alamat'];
            $iduser = $_SESSION['user_id']; // Get user ID from session
            $jenis_kelamin = ($_SESSION['personal_data']['jenis_kelamin'] === 'Laki-laki') ? 'L' : 'P';

            // Query to save patient data
            $query = "INSERT INTO personaldata_pasien (iduser, nama_pasien, tanggallahir_pasien, alamat_pasien, jk_pasien) 
                      VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sssss", $iduser, $nama, $tanggal_lahir, $alamat, $jenis_kelamin);

            if ($stmt->execute()) {
                $idpersonal_pasien = $stmt->insert_id; // Get the last inserted ID
                $_SESSION['idpersonal_pasien'] = $idpersonal_pasien; // Store in session

                // ** Begin Inserting Symptoms into pasien_gejala table **
                $gejalaSelected = $_POST['gejala']; // Selected symptoms
                
                foreach ($gejalaSelected as $kodegejala) {
                    // Query to insert selected symptoms
                    $query_insert_gejala = "INSERT INTO pasien_gejala (idpersonal_pasien, kodegejala_terpilih) VALUES (?, ?)";
                    $stmt_insert_gejala = $conn->prepare($query_insert_gejala);
                    $stmt_insert_gejala->bind_param("is", $idpersonal_pasien, $kodegejala);
                    
                    if (!$stmt_insert_gejala->execute()) {
                        die("Error inserting into pasien_gejala: " . $stmt_insert_gejala->error);
                    }
                }
                // ** End Inserting Symptoms into pasien_gejala table **

                header("Location: ../page/hasil.php"); // Redirect to final process
                exit;
            } else {
                $error_message = "Failed to save patient data: " . $stmt->error;
                echo $error_message; // Display error message for debugging
            }
        } else {
            $error_message = "Please select at least 3 symptoms.";
        }
    }
}
?>