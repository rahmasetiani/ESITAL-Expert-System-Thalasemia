<!-- sidebar.php -->
<div id="sidebar" class="bg-dark">
    <div class="sidebar-header d-flex flex-column align-items-center justify-content-center" style="height: 80px;">
        <br>
        <br>
        <br>
        <br>
        <span class="nav-text text-white" style="color: #d62268; font-size: 1.25rem;">Selamat Datang</span>
        <span class="nav-text" style="color: #d62268; font-size: 1.25rem;">
            <?php
            if ($_SESSION['role'] == 1) {
                echo '<strong>ADMIN EXSITHAL</strong>';
            } elseif ($_SESSION['role'] == 2) {
                echo '<strong>PAKAR EXSITHAL</strong>';
            }
            ?>
        </span>
        <br>
        <br>
    </div>
    <br>
    <br>
    <nav class="nav flex-column">
        <?php if ($_SESSION['role'] == 1): ?>
        <!-- Admin Menu -->
        <div class="nav-item">
            <a href="z-dashboard.php" class="nav-link d-flex align-items-center">
                <i class="bi bi-house-door me-3" style="font-size: 1.25rem;"></i>
                <span class="nav-text">Dashboard</span>
            </a>
        </div>
        <div class="nav-item">
            <a href="a-halpengguna.php" class="nav-link d-flex align-items-center">
                <i class="bi bi-person-circle me-3" style="font-size: 1.25rem;"></i>
                <span class="nav-text">Data Pengguna</span>
            </a>
        </div>
        <div class="nav-item">
            <a href="f-halriwayatpasien.php" class="nav-link d-flex align-items-center">
                <i class="bi bi-clock-history me-3" style="font-size: 1.25rem;"></i>
                <span class="nav-text">Data Riwayat Deteksi</span>
            </a>
        </div>
        <?php elseif ($_SESSION['role'] == 2): ?>
        <!-- Pakar Menu -->
        <div class="nav-item">
            <a href="z-dashboard.php" class="nav-link d-flex align-items-center">
                <i class="bi bi-house-door me-3" style="font-size: 1.25rem;"></i>
                <span class="nav-text">Dashboard</span>
            </a>
        </div>
        <div class="nav-item">
            <a href="b-halpenyakit.php" class="nav-link d-flex align-items-center">
                <i class="bi bi-heart me-3" style="font-size: 1.25rem;"></i>
                <span class="nav-text">Data Penyakit</span>
            </a>
        </div>
        <div class="nav-item">
            <a href="c-halgejala.php" class="nav-link d-flex align-items-center">
                <i class="bi bi-symmetry-horizontal me-3" style="font-size: 1.25rem;"></i>
                <span class="nav-text">Data Gejala</span>
            </a>
        </div>
        <div class="nav-item">
            <a href="d-halbasiskasus.php" class="nav-link d-flex align-items-center">
                <i class="bi bi-file-earmark me-3" style="font-size: 1.25rem;"></i>
                <span class="nav-text">Basis Kasus</span>
            </a>
        </div>
        <div class="nav-item">
            <a href="e-halambangbatas.php" class="nav-link d-flex align-items-center">
                <i class="bi bi-arrow-up-right-circle me-3" style="font-size: 1.25rem;"></i>
                <span class="nav-text">Ambang Batas</span>
            </a>
        </div>
        <div class="nav-item">
            <a href="f-halriwayatpasien.php" class="nav-link d-flex align-items-center">
                <i class="bi bi-clock-history me-3" style="font-size: 1.25rem;"></i>
                <span class="nav-text">Riwayat Deteksi</span>
            </a>
        </div>
        <div class="nav-item">
            <a href="g-halrevisipakar.php" class="nav-link d-flex align-items-center">
                <i class="bi bi-pencil-square me-3" style="font-size: 1.25rem;"></i>
                <span class="nav-text">Butuh Revisi Pakar</span>
            </a>
        </div>
        <div class="nav-item">
            <a href="h-halkasusbaru.php" class="nav-link d-flex align-items-center">
            <i class="bi bi-folder-fill me-3" style="font-size: 1.25rem;"></i>
                <span class="nav-text">Rekomendasi Kasus Baru</span>
            </a>
        </div>
        <?php endif; ?>
    </nav>

    <!-- Icon Buttons -->
    <div class="icon-buttons">
        <button id="toggleCollapse" class="btn" title="Collapse Sidebar">
            <i class="bi bi-arrow-left-circle" style="font-size: 30px;"></i>
        </button>
        <button id="toggleExpand" class="btn" title="Expand Sidebar" style="display: none;">
            <i class="bi bi-arrow-right-circle" style="font-size: 30px;"></i>
        </button>
    </div>
</div>
