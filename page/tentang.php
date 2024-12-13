<?php 
include 'header.php'; ?>

<section class="py-5 text-center">
        <h2 class="navbar-brand large-text" style="color: #d62268; margin-bottom: 1rem; text-shadow: 1px 1px 3px rgba(0,0,0,0.2); text-align: center; font-size: calc(1.5rem + 2vw);">
        Thalassemia Banyumas
    </h2>

        <!-- Subjudul -->
        <h3 style="color: #757375; margin-bottom: 2rem; text-align: center; font-size: calc(1rem + 1.5vw);">
            Rumah Sakit Umum Daerah Banyumas
        </h3>

        <!-- Paragraf 1 -->
        <p style="text-align: justify; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 1.2rem; line-height: 1.7; color: #555; text-indent: 30px; margin-bottom: 1.5rem;">
            Yayasan Thalassemia Banyumas adalah sebuah organisasi nirlaba yang didirikan untuk memberikan dukungan dan informasi kepada pasien thalassemia serta keluarganya di daerah Banyumas. Yayasan ini berfokus pada peningkatan kesadaran tentang thalassemia, sebuah penyakit genetik yang mempengaruhi produksi hemoglobin, dan menyediakan berbagai layanan, termasuk konsultasi medis, pendidikan tentang manajemen penyakit, serta dukungan psikologis.
        </p>

        <!-- Paragraf 2 -->
        <p style="text-align: justify; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 1.2rem; line-height: 1.7; color: #555; text-indent: 30px;">
            Melalui program-programnya, Yayasan Thalassemia Banyumas berupaya membantu pasien menjalani kehidupan yang lebih baik dan berdaya, serta mendorong upaya pencegahan melalui pemeriksaan dan edukasi di masyarakat.
        </p>

        <!-- Tombol -->
        <a href="diagnosa.php" class="btn custom-btn btn-lg">Detesi Dini Thalassemia</a>

    </div>
</section>


<style>
    /* Background dan Section */
section {
    background-color: #f8f9fa;
    background-image: linear-gradient(135deg, rgba(255, 255, 255, 0.2), rgba(0, 0, 0, 0.05));
    padding: 60px 20px; /* Menambahkan padding lebih banyak untuk memberi ruang */
}



/* Styling Tombol */
.btn.custom-btn {
    padding: 12px 25px;
    font-size: 1.2rem;
    background-color: #d62268;
    border-radius: 5px;
    color: white;
    transition: background-color 0.3s ease, transform 0.3s ease;
    width: 100%;
    max-width: 350px; /* Maximum width untuk tombol */
    display: block;
    margin: 30px auto 0;
    border: none;
    text-align: center;
    font-weight: 600;
}

/* Efek Hover untuk Tombol */
.btn.custom-btn:hover {
    background-color: #a91e56;
    transform: translateY(-5px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
}

/* Responsiveness */
@media (max-width: 768px) {
    .navbar-brand.large-text {
        font-size: calc(1.5rem + 3vw);
    }

    .card-body {
        padding: 1rem;
    }

    .btn.custom-btn {
        font-size: 1rem;
        max-width: 100%;
    }
}

@media (max-width: 480px) {
    .navbar-brand.large-text {
        font-size: 2rem;
    }

    .container {
        padding: 0 10px;
    }

    .card-title {
        font-size: 1.2rem;
    }

    .card-body {
        padding: 0.8rem;
    }
}

</style>


<?php include 'footer.php'; ?>
