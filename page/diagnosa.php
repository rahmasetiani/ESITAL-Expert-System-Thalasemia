<?php
include 'header.php';
require '../database/koneksi.php'; // database

// Include the handler for getting symptoms
include '../handler/gejala/get_gejala.php';

// Initialize error message variable
$error_message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if symptoms are selected and at least 3 symptoms are chosen
    if (isset($_POST['gejala']) && count($_POST['gejala']) >= 3) {
        $gejalaSelected = $_POST['gejala']; // Selected symptoms
        
        // Assuming the user ID is set in session
        $iduser = $_SESSION['user_id']; // Make sure this session variable exists and is set correctly

        // Convert the array of selected symptoms to a comma-separated string
        $gejala_str = implode(",", $gejalaSelected);

        // Begin transaction to ensure all inserts are executed as one unit
        $conn->begin_transaction();

        try {
            // Insert selected symptoms into pasien_gejala table
            $query_insert_gejala = "INSERT INTO pasien_gejala (iduser, gejala_terpilih) VALUES (?, ?)";
            $stmt_insert_gejala = $conn->prepare($query_insert_gejala);
            $stmt_insert_gejala->bind_param("is", $iduser, $gejala_str);

            if (!$stmt_insert_gejala->execute()) {
                throw new Exception("Error inserting into pasien_gejala: " . $stmt_insert_gejala->error);
            }

            // Commit the transaction
            $conn->commit();

            // Redirect to the final process page (hasil.php or another page)
            header("Location: ../handler/diagnosa/prosescbr.php"); // Adjust the location if needed
            exit;

        } catch (Exception $e) {
            // Rollback the transaction if an error occurs
            $conn->rollback();
            $error_message = $e->getMessage(); // Capture error message for debugging
            echo $error_message; // Display the error message for debugging
        }
    } else {
        $error_message = "Anda perlu memilih setidaknya 3 gejala."; // Error message if less than 3 symptoms are selected
    }
}
?>

<!-- HTML Code for Form -->

<?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
    <section class="py-5 text-center">
        <h2 class="navbar-brand large-text" style="color: #d62268; margin-bottom: 1rem; text-shadow: 1px 1px 3px rgba(0,0,0,0.2); text-align: center; font-size: calc(1.5rem + 2vw);">
            Deteksi Dini Thalassemia
        </h2>
        <h3 style="color: #757375; margin-bottom: 2rem; text-align: center; font-size: calc(1rem + 1.5vw);">
            Masukan Gejala Yang Anda Alami
        </h3>

        <form method="POST">
            <!-- Table to display gejala -->
            <div class="table-responsive" style="max-width: 1000px; margin: 0 auto;" >
                <table class="table table-bordered" style="max-width: 1000px; margin: 0 auto; border-collapse: collapse; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    <thead style="background-color: #d62268; color: white; text-shadow: 1px 1px 5px rgba(0,0,0,0.3);">
                        <tr>
                            <th style="width: 10%; text-align: center; padding: 8px;">Kode Gejala</th>
                            <th style="width: 50%; text-align: center; padding: 8px;">Nama Gejala</th>
                            <th style="width: 20%; text-align: center; padding: 8px;">Checklist</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($symptoms)) {
                            foreach ($symptoms as $row) {
                                echo '<tr style="background-color: #f9f9f9; border-bottom: 1px solid #ddd;">
                                    <td style="text-align: center; padding: 8px; font-weight: bold; color: #555;">' . htmlspecialchars($row['kodegejala']) . '</td>
                                    <td style="padding: 8px; color: #333;">' . htmlspecialchars($row['namagejala']) . '</td>
                                    <td style="text-align: center; padding: 8px;">
                                        <input class="form-check-input" type="checkbox" name="gejala[]" value="' . htmlspecialchars($row['kodegejala']) . '" style="width: 1.5em; height: 1.5em;">
                                    </td>
                                </tr>';
                            }
                        } else {
                            echo '<tr><td colspan="3" style="text-align: center; color: #757375;">Tidak ada data gejala tersedia.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <br>

            <!-- Display error message as a Bootstrap toast -->
            <?php if (!empty($error_message)): ?>
                <div class="toast-container position-fixed top-0 end-0 p-3">
                    <div class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                                <?php echo htmlspecialchars($error_message); ?>
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Next Button -->
            <div class="d-flex justify-content-center mt-4">
                <button type="submit" class="btn custom-btn btn-lg">Mulai Deteksi</button>
            </div>
        </form>
    </div>
<?php else: ?>
    <!-- Section for users not logged in -->
    <section class="py-5 text-center" id="belum-login">
        <div class="container" style="max-width: 800px;">
            <br><br><br><br><br><br>
            <h2 class="navbar-brand" style="color: #d62268;">Mohon Maaf ... </h2>
            <h2 style="color: #757375;">Anda Perlu Login Terlebih Dahulu!</h2>
            <p class="lead" style="color: #757375;">
                Sebelum melanjutkan, silakan lakukan login untuk mengakses informasi dan layanan lebih lanjut.
            </p>
            <a href="login.php" class="btn custom-btn btn-lg">Login/Register</a>
            <br><br><br><br><br><br>
        </div>
    </section>
<?php endif; ?>

</section>

<!-- Footer (gunakan include untuk memisah footer) -->
<?php include 'footer.php'; ?>

<script>
    // Automatically show the toast if there is an error message
    var myToast = document.querySelector('.toast');
    if (myToast) {
        var toast = new bootstrap.Toast(myToast);
        toast.show();
    }
</script>

<style>
    /* Section Styling */
section.py-5 {
    padding: 50px 20px;
}

/* Table Styling */
table {
    border-radius: 12px;
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.6);  /* Adding stronger shadow for depth */
    border-collapse: collapse;
    margin: 0px auto;
    font-size: 16px;
    width: 100%;
    background-color: #ffffff; /* Ganti latar belakang tabel menjadi putih */
}

thead {
    background: linear-gradient(45deg, #d62268, #9e005d);
    color: white;
    text-shadow: 1px 1px 3px rgba(0,0,0,0.2);
}

tbody tr:hover {
    background-color: #f4f4f4;
    transform: scale(1.02);
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}



td, th {
    padding: 1px 1px; /* Perbesar kotak agar lebih jelas dan cukup besar */
    text-align: center;
    border: 1px solid #ddd;
    font-size: 15px;
    color: #ffffff;
    border-radius: 6px;
}

th {
    font-weight: bold;
}

/* Form Section */
form {
    margin-top: 0px;
    margin-bottom: 0px;
}

/* Checkbox */
input[type="checkbox"] {
    width: 22px;
    height: 22px;
    margin: 2px;
}

/* Button Styling */
.btn.custom-btn {
    background: #d62268;
    color: white;
    border: none;
    border-radius: 8px;
    padding: 12px 25px; /* Perbesar ukuran tombol */
    font-size: 18px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.btn.custom-btn:hover {
    background: #9e005d;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
}

.btn.custom-btn:focus {
    outline: none;
    box-shadow: 0 0 5px 2px #d62268;
}

/* Toast Message Styling */
.toast-container {
    position: fixed;
    top: 0;
    right: 0;
    z-index: 1050;
}

.toast {
    max-width: 300px;
    font-size: 14px;
    padding: 15px;
    margin-top: 10px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.toast-body {
    font-size: 16px;
}

.toast.text-bg-danger {
    background-color: #e74c3c;
    color: white;
}

.toast .btn-close {
    margin-left: auto;
}

/* Page Heading */


/* Responsive Design */
@media (max-width: 768px) {
    .container {
        padding: 15px;
    }

    table {
        font-size: 14px;
    }

    .btn.custom-btn {
        font-size: 16px;
        padding: 10px 20px;
    }
}


</style>