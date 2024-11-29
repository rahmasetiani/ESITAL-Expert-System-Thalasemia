<?php
session_start();

require '../../database/koneksi.php'; // Import database connection

// Initialize error message variable
$error_message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if symptoms are selected and at least 3 symptoms are chosen
    if (isset($_POST['gejala']) && count($_POST['gejala']) >= 3) {
        $gejalaSelected = $_POST['gejala']; // Selected symptoms
        
        // Assuming the user ID is set in session
        $iduser = $_SESSION['user_id']; // Make sure this session variable exists and is set correctly
        
        // Generate unique id_test (You can use auto-increment or another unique method)
        $id_test = uniqid('test_', true);  // Generate unique ID for the diagnosis session
        
        // Begin transaction to ensure all inserts are executed as one unit
        $conn->begin_transaction();

        try {
            // Insert selected symptoms into pasien_gejala table
            foreach ($gejalaSelected as $kodegejala) {
                // Insert selected symptom with iduser and generated id_test
                $query_insert_gejala = "INSERT INTO pasien_gejala (id_test, iduser, kodegejala_terpilih) VALUES (?, ?, ?)";
                $stmt_insert_gejala = $conn->prepare($query_insert_gejala);
                $stmt_insert_gejala->bind_param("sis", $id_test, $iduser, $kodegejala);
                
                if (!$stmt_insert_gejala->execute()) {
                    throw new Exception("Error inserting into pasien_gejala: " . $stmt_insert_gejala->error);
                }
            }

            // Commit the transaction
            $conn->commit();

            // Redirect to the next page (hasil.php or another page)
            header("Location: ../../page/hasil.php"); // Adjust the location if needed
            exit;

        } catch (Exception $e) {
            // Rollback the transaction if an error occurs
            $conn->rollback();
            $error_message = $e->getMessage(); // Capture error message for debugging
            echo $error_message; // Display the error message for debugging
        }
    } else {
        $error_message = "Please select at least 3 symptoms."; // Error message if less than 3 symptoms are selected
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proses Awal</title>
</head>
<body>
    <h2>Proses Diagnosa</h2>
    <form action="prosesawal.php" method="POST">
        <p>Select at least 3 symptoms:</p>
        
        <!-- Display symptoms checkboxes -->
        <?php
        // Query to fetch available symptoms (assuming there's a table `gejala` with symptoms)
        $query = "SELECT kodegejala, nama_gejala FROM gejala";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<input type="checkbox" name="gejala[]" value="' . $row['kodegejala'] . '">' . $row['nama_gejala'] . '<br>';
            }
        } else {
            echo "No symptoms available.";
        }
        ?>

        <br>
        <button type="submit">Submit</button>
    </form>

    <?php if ($error_message) : ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>
</body>
</html>
