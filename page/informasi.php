<?php
require '../database/koneksi.php'; // database
include 'header.php'; // Memanggil header
include '../handler/penyakit/get_penyakit.php'; // Memanggil get_penyakit
?>

<section class="py-5 text-center">
    <h2 class="navbar-brand large-text" style="color: #d62268; margin-bottom: 1rem; text-shadow: 1px 1px 3px rgba(0,0,0,0.2); text-align: center; font-size: calc(1.5rem + 2vw);">
        Kategori & Informasi
    </h2>
    <h3 style="color: #757375; margin-bottom: 2rem; text-align: center; font-size: calc(1rem + 1.5vw);">
        Penyakit Thalassemia dan Deferensial Thalassemia
    </h3>
    <br>
    
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex overflow-auto flex-nowrap">
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <div class="card" style="min-width: 350px; border: 1px solid #ddd; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                            <img src="../asset/image/penyakit/<?php echo $row['foto']; ?>" class="card-img-top" alt="<?php echo $row['namapenyakit']; ?>" style="object-fit: cover; height: 250px;">
                            <div class="card-body" style="padding: 1.5rem;">
                                <h5 class="card-title" style="font-size: 1.5rem; font-weight: bold; color: #d62268;"><?php echo $row['namapenyakit']; ?></h5>
                                <p class="card-text description" data-short-text="<?php echo htmlspecialchars(substr($row['deskripsi'], 0, 100)); ?>" data-full-text="<?php echo htmlspecialchars($row['deskripsi']); ?>" style="font-size: 1.1rem; color: #555;">
                                    <?php 
                                    $shortDescription = substr($row['deskripsi'], 0, 100);
                                    if (strlen($row['deskripsi']) > 100) {
                                        echo $shortDescription . '...<br><a href="#" class="show-more" style="color: #d62268;">Show More</a>';
                                    } else {
                                        echo $shortDescription;
                                    }
                                    ?>
                                </p>
                                <strong style="font-size: 1.1rem; color: #333;">Solusi Pengobatan:</strong>
                                <p class="card-text solution" data-short-text="<?php echo htmlspecialchars(substr($row['solusipengobatan'], 0, 100)); ?>" data-full-text="<?php echo htmlspecialchars($row['solusipengobatan']); ?>" style="font-size: 1.1rem; color: #555;">
                                    <?php 
                                    $shortSolution = substr($row['solusipengobatan'], 0, 100);
                                    if (strlen($row['solusipengobatan']) > 100) {
                                        echo $shortSolution . '...<br><a href="#" class="show-more-solution" style="color: #d62268;">Show More</a>';
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

<style>
    .card {
        height: auto; /* Allow the card to expand based on content */
        min-width: 350px;
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .card-body {
        padding: 1.5rem;
    }

    .card-text {
        font-size: 1.1rem;
        color: #555;
    }

    .show-more, .show-more-solution {
        color: #d62268; /* Pink color for Show More/Show Less */
    }

    .description.expanded, .solution.expanded {
        max-height: none;
        overflow: visible;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const showMoreLinks = document.querySelectorAll('.show-more');
        const showMoreSolutionLinks = document.querySelectorAll('.show-more-solution');

        // Toggle "Show More" and "Show Less" for description
        showMoreLinks.forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                const parent = e.target.closest('.card-body');
                const description = parent.querySelector('.card-text.description');
                const isExpanded = description.classList.contains('expanded');

                if (isExpanded) {
                    description.classList.remove('expanded');
                    e.target.innerText = 'Show More';
                } else {
                    description.classList.add('expanded');
                    e.target.innerText = 'Show Less';
                }
            });
        });

        // Toggle "Show More" and "Show Less" for solution
        showMoreSolutionLinks.forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                const parent = e.target.closest('.card-body');
                const solution = parent.querySelector('.card-text.solution');
                const isExpanded = solution.classList.contains('expanded');

                if (isExpanded) {
                    solution.classList.remove('expanded');
                    e.target.innerText = 'Show More';
                } else {
                    solution.classList.add('expanded');
                    e.target.innerText = 'Show Less';
                }
            });
        });
    });
</script>
