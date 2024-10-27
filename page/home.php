<?php
session_start();
include 'header.php'; // Memanggil header
?>

<!-- Hero Section -->
<section class="hero bg-dark text-white text-center d-flex align-items-center justify-content-center">
    <div class="container">
        <h6 class="navbar-brand welcome-text">WELCOME TO 
            <a class="navbar-brand large-text">EXSI<span style="color: #d62268;">THAL</span></a>
        </h6>
        <h1 class="display-1">Expert System Penyakit Thalassemia</h1>
        <p class="lead">Powered by Yayasan Thalassemia Kabupaten Banyumas</p>
        <a href="#about-us" class="btn custom-btn btn-lg">Jelajahi</a>
    </div>
</section>

<!-- About Us Section -->
<section class="about-us py-5" id="about-us">
    <div class="container" style="color: #757375;">
        <div class="row align-items-center">
            <div class="col-md-6">
                <img src="../asset/image/tentang.jpg" alt="About Us" class="img-fluid rounded">
            </div>
            <div class="col-md-6">
                <a class="navbar-brand large-text" style="color: #757375;">EXSI<span style="color: #d62268;">THAL</span></a>
                <p class="lead">(Expert System Penyakit Thalassemia)</p>
                <p class="text-justify" style="text-align: justify;">
                    EXSITHAL adalah sistem pakar yang didedikasikan untuk membantu deteksi dini penyakit thalassemia. 
                    Dengan teknologi terbaru, kami bertujuan untuk memberikan informasi yang akurat dan bermanfaat 
                    bagi masyarakat. Kami bekerja sama dengan berbagai pihak untuk meningkatkan kesadaran dan 
                    pemahaman tentang thalassemia.
                </p>
                <p class="text-justify" style="text-align: justify;">
                    Kami berkomitmen untuk menyediakan sumber daya dan dukungan yang dibutuhkan untuk individu dan keluarga yang terpengaruh oleh penyakit ini. 
                    Bersama-sama, kita dapat meningkatkan kualitas hidup mereka yang menderita thalassemia.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Apa Itu Thalassemia Section -->
<section class="py-5 text-center">
    <div class="container">
        <h2 style="color: #757375;">Apa itu <span style="color: #d62268;">Thalassemia</span>?</h2>
        <p class="lead" style="color: #757375;">
            Thalassemia adalah gangguan darah yang diturunkan yang ditandai dengan produksi hemoglobin yang tidak normal. 
            Penyakit ini dapat menyebabkan anemia, kelelahan, dan masalah kesehatan lainnya. 
            Deteksi dini dan pengelolaan yang tepat dapat membantu meningkatkan kualitas hidup penderita.
        </p>
    </div>
</section>

<!-- Tujuan Website Ini Section -->
<section class="about-us py-5">
    <div class="container" style="color: #757375;">
        <div class="row align-items-center">
            <div class="col-md-6">
                <img src="../asset/image/anak.jpg" alt="About Us" class="img-fluid rounded">
            </div>
            <div class="col-md-6">
                <a class="navbar-brand large-text" style="color: #757375;">Tujuan <span style="color: #d62268;">Website Ini</span>:</a>
                <p class="text-justify" style="text-align: justify;">
                    Website ini bertujuan untuk memberikan informasi yang akurat dan mendidik tentang thalassemia, 
                    termasuk gejala, penyebab, dan pengelolaannya. Kami berkomitmen untuk meningkatkan kesadaran 
                    tentang penyakit ini dan memberikan dukungan yang dibutuhkan oleh individu dan keluarga yang 
                    terpengaruh.
                </p>
                <p class="text-justify" style="text-align: justify;">
                    Selain itu, website ini juga berfungsi sebagai platform untuk berbagi pengalaman, pengetahuan, 
                    dan sumber daya. Kami berharap dapat menciptakan komunitas yang saling mendukung, 
                    sehingga bersama-sama kita dapat meningkatkan kualitas hidup penderita thalassemia.
                </p>
                <a href="diagnosa.php" class="btn custom-btn btn-lg">Deteksi Dini Thalassemia</a>
            </div>
        </div>
    </div>
</section>

<?php
include 'footer.php'; // Memanggil footer
?>
