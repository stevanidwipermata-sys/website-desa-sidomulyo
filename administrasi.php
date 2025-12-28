<?php
include "config.php";

// Ambil data kependudukan terbaru
$data = mysqli_query($koneksi, "SELECT * FROM kependudukan ORDER BY id DESC LIMIT 1");
$row = mysqli_fetch_assoc($data);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Administrasi Penduduk | Desa Sidomulyo</title>

<!-- Bootstrap & Font Awesome -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<style>
body {
    font-family: 'Poppins', sans-serif;
    background-color: #fcfbfbff;
    margin:0;
    padding-top:80px;
}
/* Navbar glass blur */
.navbar {
    backdrop-filter: blur(10px);
    background-color: rgba(255, 255, 255, 0.2);
    box-shadow:0 2px 10px rgba(0,0,0,0.1);
}
.navbar .nav-link { color:#1B5E20; margin-right:0.5rem; }
.navbar .nav-link.active, .navbar .nav-link:hover { color:#66bb6a !important; transition:0.3s; }
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
    height:40vh;
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

/* Stat & Occupation Cards */
.stat-card, .occ-card {
    background:#fff; border-radius:12px; padding:20px; box-shadow:0 4px 15px rgba(0,0,0,0.1); text-align:center; margin-bottom:20px;
    transition: transform 0.3s, box-shadow 0.3s;
}
.stat-card:hover, .occ-card:hover { transform: translateY(-5px); box-shadow:0 10px 20px rgba(0,0,0,0.15); }
.stat-icon, .occ-icon { font-size:2rem; color:#66bb6a; margin-bottom:10px; }

/* Layanan Administrasi */
.services-section { padding:50px 0; }
.services-section .section-title { text-align:center; color:#1B5E20; font-weight:600; margin-bottom:2rem; }
.admin-services-grid { display:flex; flex-wrap:wrap; gap:1.5rem; justify-content:center; }
.admin-service-card { background:#fff; border-radius:12px; padding:20px; flex:1 1 280px; box-shadow:0 4px 15px rgba(0,0,0,0.1); transition: transform 0.3s; }
.admin-service-card:hover { transform: translateY(-5px); }
.service-icon { font-size:2rem; color:#66bb6a; margin-bottom:10px; text-align:center; }
.service-details ul { padding-left:1.2rem; }

/* Jam Pelayanan */
.hours-section { background:#f1f8e9; padding:50px 0; }
.hours-section .section-title { text-align:center; color:#1B5E20; font-weight:600; margin-bottom:2rem; }
.hours-card { max-width:800px; margin:0 auto; background:#fff; border-radius:12px; padding:20px; box-shadow:0 4px 15px rgba(0,0,0,0.1); }
.hours-item { display:flex; justify-content:space-between; margin-bottom:10px; }
.hours-note { margin-top:10px; font-size:0.9rem; color:#555; }

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
        <li class="nav-item"><a class="nav-link" href="peta.php">Peta Desa</a></li>
        <li class="nav-item"><a class="nav-link active" href="administrasi.php">Administrasi</a></li>
        <li class="nav-item"><a class="nav-link" href="berita.php">Berita</a></li>
        <li class="nav-item"><a class="nav-link" href="kontak.php">Kontak</a></li>
        <a href="login.php?page=admin_administrasi" class="btn btn-admin">Admin</a>
      </ul>
    </div>
  </div>
</nav>

<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-text">
        <h1>Administrasi Kependudukan</h1>
        <p>Data kependudukan dan layanan administrasi Desa Sidomulyo</p>
    </div>
</section>

<!-- Main Content -->
<main class="main-content">
    <div class="container py-5">

        <!-- Statistik Penduduk -->
        <h2 class="text-center mb-5">Data Kependudukan</h2>
        <div class="row">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-users"></i></div>
                    <h3><?= $row['total_penduduk'] ?></h3>
                    <p>Total Penduduk</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-male"></i></div>
                    <h3><?= $row['laki_laki'] ?></h3>
                    <p>Laki-laki</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-female"></i></div>
                    <h3><?= $row['perempuan'] ?></h3>
                    <p>Perempuan</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-home"></i></div>
                    <h3><?= $row['kepala_keluarga'] ?></h3>
                    <p>Kepala Keluarga</p>
                </div>
            </div>
        </div>

        <!-- Mata Pencaharian -->
        <h2 class="text-center my-5">Mata Pencaharian</h2>
        <div class="row justify-content-center">
            <?php
            $jobs = ['petani','pedagang','pegawai_swasta','pns','buruh','ibu_rumah_tangga'];
            $icons = ['fas fa-seedling','fas fa-store','fas fa-briefcase','fas fa-user-tie','fas fa-hammer','fas fa-home'];
            $labels = ['Petani','Pedagang','Pegawai Swasta','PNS','Buruh','Ibu Rumah Tangga'];
            for($i=0;$i<count($jobs);$i++): ?>
            <div class="col-md-4 col-lg-2">
                <div class="occ-card">
                    <div class="occ-icon"><i class="<?= $icons[$i] ?>"></i></div>
                    <h5><?= $labels[$i] ?></h5>
                    <p><?= $row[$jobs[$i]] ?> orang</p>
                </div>
            </div>
            <?php endfor; ?>
        </div>

        <!-- Layanan Administrasi -->
        <section class="services-section mt-5">
            <h2 class="section-title">Layanan Administrasi</h2>
            <div class="admin-services-grid">
                <div class="admin-service-card">
                    <div class="service-icon text-center"><i class="fas fa-users"></i></div>
                    <h4 class="text-center mt-2">Kartu Keluarga (KK)</h4>
                    <p class="text-center">Pembuatan KK baru dan perubahan data</p>
                    <ul>
                        <li>Surat nikah/cerai</li>
                        <li>KTP suami & istri</li>
                        <li>Surat pengantar RT/RW</li>
                    </ul>
                </div>
                <div class="admin-service-card">
                    <div class="service-icon text-center"><i class="fas fa-baby"></i></div>
                    <h4 class="text-center mt-2">Akta Kelahiran</h4>
                    <p class="text-center">Pembuatan akta kelahiran anak</p>
                    <ul>
                        <li>Surat keterangan lahir dari bidan/dokter</li>
                        <li>KTP orang tua</li>
                        <li>Surat nikah orang tua</li>
                    </ul>
                </div>
                <div class="admin-service-card">
                    <div class="service-icon text-center"><i class="fas fa-file-alt"></i></div>
                    <h4 class="text-center mt-2">Surat Keterangan</h4>
                    <p class="text-center">Berbagai surat keterangan dari desa</p>
                    <ul>
                        <li>Surat Keterangan Domisili</li>
                        <li>Surat Keterangan Usaha</li>
                        <li>Surat Keterangan Tidak Mampu</li>
                        <li>Surat Keterangan Belum Menikah</li>
                        <li>Surat Keterangan Lainnya</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Jam Pelayanan -->
        <section class="hours-section mt-5">
            <h2 class="section-title">Jam Pelayanan</h2>
            <div class="hours-card">
                <div class="hours-item"><h5>Senin - Jumat</h5><span>08.00 - 15.00 WIB</span></div>
                <div class="hours-item"><h5>Sabtu - Minggu</h5><span>Tutup</span></div>
                <p class="hours-note"><strong>Catatan:</strong> Untuk pelayanan darurat dapat menghubungi nomor telepon desa di luar jam kerja.</p>
            </div>
        </section>

    </div>
</main>

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
