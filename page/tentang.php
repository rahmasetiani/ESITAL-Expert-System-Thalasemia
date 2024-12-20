<?php 
include 'header.php'; ?>

<section class="py-5 text-center">
<div class="container">
    <!-- Judul -->
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
</div>

<!-- Maps dan Alamat -->
<div class="container mt-5" style="display: flex; flex-wrap: wrap; gap: 20px;">
    <!-- Maps -->
    <div class="map-container" style="flex: 1; min-width: 300px;">
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31662.99678940113!2d109.2781214!3d-7.5302553!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e65450012229455%3A0x3125689fde55f7ab!2sGedung%20Thalassemia%20RSUD%20Banyumas!5e0!3m2!1sid!2sid!4v1690973300554!5m2!1sid!2sid" 
            width="100%" 
            height="400" 
            style="border:0; border-radius: 10px;" 
            allowfullscreen="" 
            loading="lazy">
        </iframe>
    </div>

    <!-- Alamat -->
    <div class="address-container" style="flex: 1; min-width: 300px; text-align: left;">
        <h4 style="color: #d62268; font-size: 1.5rem; margin-bottom: 1rem;">Alamat Thalassemia Banyumas:</h4>
        <p style="font-size: 1.2rem; color: #555;">
            <i class="fas fa-map-marker-alt" style="margin-right: 8px;"></i>
            Gedung Thalassemia RSUD Banyumas, Jl. Rumah Sakit No.1, Karangpucung, Kejawar, Kec. Banyumas, Kabupaten Banyumas, Jawa Tengah 53192
        </p>
        <p style="font-size: 1.2rem; color: #555;">
            <i class="fas fa-globe" style="margin-right: 8px;"></i>
            <a href="http://rsudbms.banyumaskab.go.id/" target="_blank">rsudbms.banyumaskab.go.id</a>
        </p>
        <p style="font-size: 1.2rem; color: #555;">
            <i class="fas fa-phone" style="margin-right: 8px;"></i> +62 811-2622-009
        </p>
        <!-- Tombol -->
        <a href="diagnosa.php" class="btn custom-btn btn-lg">Deteksi Dini Thalassemia</a>
    </div>
</div>
</section>

<style>
/* Styling Section */
section {
    background-color: #f8f9fa;
    background-image: linear-gradient(135deg, rgba(255, 255, 255, 0.2), rgba(0, 0, 0, 0.05));
    padding: 60px 20px;
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
    max-width: 350px;
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

/* Maps dan Alamat Responsif */
.map-container, .address-container {
    width: 100%;
    margin-bottom: 20px;
}

/* Responsiveness */
@media (max-width: 992px) {
    .map-container iframe {
        height: 300px;
    }
}

@media (max-width: 768px) {
    .address-container {
        text-align: center;
    }

    .btn.custom-btn {
        font-size: 1rem;
        max-width: 100%;
    }
}

@media (max-width: 576px) {
    .map-container iframe {
        height: 200px;
    }
}
</style>

<?php include 'footer.php'; ?>
