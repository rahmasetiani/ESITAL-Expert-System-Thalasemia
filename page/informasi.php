<?php
session_start();

require '../database/koneksi.php'; // database
include 'header.php'; // Memanggil header
include '../handler/penyakit/get_penyakit.php'; // Memanggil get_penyakit
?>

<section class="py-5 text-center">
    <h1 style="color: #757375;">Kategori & Informasi</h1>
    <h2 style="color: #d62268;">Penyakit Thalassemia dan Deferensial Thalassemia</h2>
    <br>
    
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex overflow-auto flex-nowrap">
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <div class="card h-100 me-2" style="min-width: 300px;">
                            <img src="../asset/image/penyakit/<?php echo $row['foto']; ?>" class="card-img-top" alt="<?php echo $row['namapenyakit']; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['namapenyakit']; ?></h5>
                                <p class="card-text" data-short-text="<?php echo htmlspecialchars(substr($row['deskripsi'], 0, 80)); ?>" data-full-text="<?php echo htmlspecialchars($row['deskripsi']); ?>">
                                    <?php 
                                    $shortDescription = substr($row['deskripsi'], 0, 80);
                                    if (strlen($row['deskripsi']) > 80) {
                                        echo $shortDescription . '...<br><a href="#" class="show-more">Show More</a>';
                                    } else {
                                        echo $shortDescription;
                                    }
                                    ?>
                                </p>
                                <strong>Solusi Pengobatan:</strong>
                                <p class="card-text" data-short-text="<?php echo htmlspecialchars(substr($row['solusipengobatan'], 0, 80)); ?>" data-full-text="<?php echo htmlspecialchars($row['solusipengobatan']); ?>">
                                    <?php 
                                    $shortSolution = substr($row['solusipengobatan'], 0, 80);
                                    if (strlen($row['solusipengobatan']) > 80) {
                                        echo $shortSolution . '...<br><a href="#" class="show-more-solution">Show More</a>';
                                    } else {
                                        echo $shortSolution;
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include 'footer.php'; // Memanggil footer
?>
