<?php
include "config.php"; // koneksi database

// Ambil data wilayah desa dari DB
$data = mysqli_query($koneksi, "SELECT * FROM wilayah_desa ORDER BY urutan ASC");
$wilayah = [];
while($row = mysqli_fetch_assoc($data)) {
    $wilayah[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Peta Desa | Desa Sidomulyo</title>

<!-- Bootstrap & Font Awesome -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<style>
body {
    font-family: 'Poppins', sans-serif;
    background-color: rgba(251, 252, 250, 1);
    margin:0;
    padding-top:80px;
}
/* Navbar glass blur */
.navbar {
    backdrop-filter: blur(10px);
    background-color: rgba(255, 255, 255, 0.2);
    box-shadow:0 2px 10px rgba(0,0,0,0.1);
}
.navbar .nav-link { color:#1B5E20; }
.navbar .nav-link:hover, .navbar .nav-link.active { color:#66bb6a !important; transition:0.3s; }
.navbar-brand { color:#1B5E20; font-weight:600; }
.navbar-brand:hover { color:#2e7d32 !important; transition:0.3s; }

/* Hero Section */
.hero-section {
    max-width:1200px;
    margin:0 auto;
    background-color:#ffffffcc; 
    border-radius:15px;
    overflow:hidden;
    box-shadow:0 8px 20px rgba(0,0,0,0.2);
    height:50vh;
    display:flex;
    align-items:center;
    justify-content:center;
    text-align:center;
    position:relative;
}
.hero-section::before {
    content:"";
    background-image:url('balai-desa.jpeg');
    background-size:cover;
    background-position:center;
    position:absolute; top:0; left:0; width:100%; height:100%;
    filter:brightness(0.65); z-index:1;
}
.hero-section .hero-text { position:relative; z-index:2; color:white; text-shadow:0 2px 8px rgba(0,0,0,0.6); }
.hero-section h1 { font-weight:600; }
.hero-section p { font-weight:400; }

/* Card wilayah */
.area-card { background:#fff; border-radius:12px; padding:20px; box-shadow:0 4px 15px rgba(0,0,0,0.1); margin-bottom:20px; }
.area-header { background:#66bb6a; color:#fff; padding:8px 12px; border-radius:8px; margin-bottom:10px; }
.area-info p { margin:0 0 5px; }

/* Footer */
footer { background:#1B5E20; color:#fff; padding:30px 0; text-align:center; }
footer img { height:50px; margin-bottom:10px; }
</style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="index.php">
        <img src="logo-desa.png" alt="Logo Desa Sidomulyo" style="height:40px; margin-right:10px;">
        <span><i class="fas fa-seedling"></i> Desa Sidomulyo</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">Beranda</a></li>
        <li class="nav-item"><a class="nav-link" href="profil.php">Profil Desa</a></li>
        <li class="nav-item"><a class="nav-link active" href="peta.php">Peta Desa</a></li>
        <li class="nav-item"><a class="nav-link" href="administrasi.php">Administrasi</a></li>
        <li class="nav-item"><a class="nav-link" href="berita.php">Berita</a></li>
        <li class="nav-item"><a class="nav-link" href="kontak.php">Kontak</a></li>
        <a href="login.php?page=admin_peta" class="btn btn-admin">Admin</a>
      </ul>
    </div>
  </div>
</nav>

<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-text">
        <h1>Peta Desa Sidomulyo</h1>
        <p>Menampilkan wilayah dan ketua RT/RW Desa Sidomulyo</p>
    </div>
</section>

<!-- Main Content -->
<main class="main-content">
    <div class="container py-5">
        <!-- Header -->
        <div class="page-header text-center mb-5">
            <h1 class="section-title text-center mb-4">Peta Desa Sidomulyo</h1>
            <p class="page-description text-muted">Lihat wilayah desa dan fasilitas umum secara interaktif</p>
        </div>

        <!-- Interactive Map -->
        <section class="map-section mb-5">
            <div class="map-container shadow-sm rounded">
                <iframe 
                    src="https://www.google.com/maps?q=Balai+Desa+Sidomulyo+Krian+Sidoarjo&output=embed"
                    width="100%" 
                    height="500" 
                    style="border:0; border-radius: 12px;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </section>

        <!-- Map Legend -->
        <section class="legend-section mb-5">
            <h2 class="section-title text-center mb-4">Fasilitas Desa</h2>
            <div class="legend-grid row g-4 justify-content-center">
                <div class="legend-item col-12 col-sm-6 col-md-4 col-lg-3 d-flex align-items-start">
                    <div class="legend-icon me-3 text-primary fs-2">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="legend-info">
                        <h5 class="mb-1">Kantor Pemerintahan</h5>
                        <p class="mb-0 text-muted">Balai Desa</p>
                    </div>
                </div>
                
                <div class="legend-item col-12 col-sm-6 col-md-4 col-lg-3 d-flex align-items-start">
                    <div class="legend-icon me-3 text-success fs-2">
                        <i class="fas fa-school"></i>
                    </div>
                    <div class="legend-info">
                        <h5 class="mb-1">Fasilitas Pendidikan</h5>
                        <p class="mb-0 text-muted">SD, SMP, TK, PAUD</p>
                    </div>
                </div>
                
                <div class="legend-item col-12 col-sm-6 col-md-4 col-lg-3 d-flex align-items-start">
                    <div class="legend-icon me-3 text-danger fs-2">
                        <i class="fas fa-hospital"></i>
                    </div>
                    <div class="legend-info">
                        <h5 class="mb-1">Fasilitas Kesehatan</h5>
                        <p class="mb-0 text-muted">Polindes, Posyandu, Klinik</p>
                    </div>
                </div>
                
                <div class="legend-item col-12 col-sm-6 col-md-4 col-lg-3 d-flex align-items-start">
                    <div class="legend-icon me-3 text-warning fs-2">
                        <i class="fas fa-mosque"></i>
                    </div>
                    <div class="legend-info">
                        <h5 class="mb-1">Tempat Ibadah</h5>
                        <p class="mb-0 text-muted">Masjid, Musholla</p>
                    </div>
                </div>

                <div class="legend-item col-12 col-sm-6 col-md-4 col-lg-3 d-flex align-items-start">
                    <div class="legend-icon me-3 text-info fs-2">
                        <i class="fas fa-gavel"></i>
                    </div>
                    <div class="legend-info">
                        <h5 class="mb-1">Posbakum</h5>
                        <p class="mb-0 text-muted">Pos Bantuan Hukum</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

<!-- CSS tambahan untuk legenda -->
<style>
.legend-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem;
}

.legend-item {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 1rem;
    transition: transform 0.3s, box-shadow 0.3s;
}
.legend-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}
.legend-icon i {
    display: inline-block;
}
.section-title {
    font-weight: 600;
    color: #1B5E20;
}
</style>


<!-- Wilayah desa -->
 <h2 class="section-title text-center mb-4">Wilayah Desa</h2>
<div class="container my-5">
    <div class="row g-4">
        <?php foreach($wilayah as $w): ?>
        <div class="col-md-6 col-lg-4">
            <div class="area-card">
                <div class="area-header">
                    <h4>RT <?= $w['rt'] ?> / RW <?= $w['rw'] ?></h4>
                </div>
                <div class="area-info">
                    <p><strong>Ketua RT:</strong> <?= htmlspecialchars($w['ketua_rt']) ?></p>
                    <p><strong>Ketua RW:</strong> <?= htmlspecialchars($w['ketua_rw']) ?></p>
                    <p><strong>Dusun:</strong> <?= htmlspecialchars($w['dusun']) ?></p>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Footer -->
<footer>
    <img src="logo-desa.png" alt="Logo Desa Sidomulyo">
    <p>Pemerintah Desa Sidomulyo<br>
       Jln. Soenandar Prijo Soedarmo No.1, Desa Sidomulyo, Krian, Sidoarjo</p>
    <p>© 2025 Powered by PT Digital Desa Indonesia</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
