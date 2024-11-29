<?php
include '../handler/ambangbatas/admin-ubahambangbatas.php';  // Include the logic from the PHP file
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nilai Ambang Batas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../asset/css/admin.css">
    <style>
        .threshold-container {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 40px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }
        .threshold-display {
            font-size: 3rem;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 30px;
        }
        .btn-custom {
            font-size: 1.1rem;
        }
        .content-header {
            margin-bottom: 40px;
        }
        .form-container {
            margin-top: 40px;
        }
        .form-container .btn {
            width: 150px;
        }
        .form-box {
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 15px;
        }
    </style>
</head>
<body>

<?php include 'sidebar.php'; ?>
<?php include 'navbar.php'; ?>

<div id="content" class="container mt-5">
    <!-- Display Error if any -->
    <?php if (isset($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>

    <!-- Main content -->
    <div class="threshold-container">
        <!-- Display the current threshold value in large font -->
        <div id="current_threshold" class="text-center">
            <h4>Nilai Ambang Batas saat ini:</h4>
            <p class="threshold-display" style="color : #d62268;"><?php echo $current_threshold; ?>%</p>
        </div>

        <!-- Show the "Ubah" button to enable editing, inside a flex container for centering -->
        <div class="text-center">
        <button id="ubah_button" class="btn btn-custom" style="background-color: #d62268; border-color: #d62268;color : #ffffff" data-bs-toggle="modal" data-bs-target="#ubahModal">Ubah Nilai Ambang Batas</button>
        </div>
    </div>

    <!-- Modal for updating the threshold value -->
    <div class="modal fade" id="ubahModal" tabindex="-1" aria-labelledby="ubahModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ubahModalLabel">Ubah Nilai Ambang Batas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="nilai_ambang_batas" class="form-label">Masukkan Nilai Ambang Batas (%)</label>
                            <input type="number" class="form-control" id="nilai_ambang_batas" name="nilai_ambang_batas" value="<?php echo $current_threshold; ?>" min="0" max="100" step="0.01">
                        </div>
                        <div class="d-flex justify-content-center gap-3">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Kirim Ambang Batas</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
