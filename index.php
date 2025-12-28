<?php
include "config.php";

// Ambil statistik desa
$stat = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT * FROM statistik_desa LIMIT 1")
);

// Ambil 3 berita terbaru
$newsQuery = mysqli_query($koneksi, "SELECT * FROM berita ORDER BY tanggal DESC LIMIT 3");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Beranda | Desa Sidomulyo</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<style>
body{font-family:'Poppins',sans-serif;background:#fcfbfbff;padding-top:80px}
.navbar{backdrop-filter:blur(10px);background:rgba(255,255,255,.2);box-shadow:0 2px 10px rgba(0,0,0,.1)}
.navbar .nav-link{color:#1B5E20}
.navbar .nav-link:hover,.nav-link.active{color:#66bb6a!important}
.hero-section{max-width:1200px;margin:auto;height:50vh;border-radius:15px;overflow:hidden;display:flex;align-items:center;justify-content:center;position:relative}
.hero-section::before{content:"";background:url('balai-desa.jpeg') center/cover;position:absolute;inset:0;filter:brightness(.65)}
.hero-text{position:relative;color:#fff;text-align:center}
.stats-grid{display:flex;gap:20px;justify-content:center;flex-wrap:wrap}
.stat-card{background:#fff;border-radius:12px;padding:30px;width:220px;text-align:center;box-shadow:0 4px 15px rgba(0,0,0,.1)}
.stat-card i{font-size:2rem;color:#4CAF50}
.services-grid,.news-grid{display:flex;gap:20px;justify-content:center;flex-wrap:wrap}
.service-card,.news-card{background:#fff;border-radius:12px;box-shadow:0 4px 15px rgba(0,0,0,.1)}
.news-card{width:300px;overflow:hidden}
.news-card img{width:100%;height:180px;object-fit:cover}
footer{background:#1B5E20;color:#fff;text-align:center;padding:30px}
</style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg fixed-top">
<div class="container">
<a class="navbar-brand d-flex align-items-center" href="index.php">
<img src="logo-desa.png" style="height:40px;margin-right:10px">
Desa Sidomulyo
</a>
<ul class="navbar-nav ms-auto">
<li class="nav-item"><a class="nav-link active" href="index.php">Beranda</a></li>
<li class="nav-item"><a class="nav-link" href="profil.php">Profil Desa</a></li>
<li class="nav-item"><a class="nav-link" href="peta.php">Peta Desa</a></li>
<li class="nav-item"><a class="nav-link" href="administrasi.php">Administrasi</a></li>
<li class="nav-item"><a class="nav-link" href="berita.php">Berita</a></li>
<li class="nav-item"><a class="nav-link" href="kontak.php">Kontak</a></li>
<a href="login.php?page=admin_statistik" class="btn btn-admin">Admin</a>
</ul>
</div>
</nav>

<!-- HERO -->
<section class="hero-section">
<div class="hero-text">
<h1>Selamat Datang di Desa Sidomulyo</h1>
<p>Senyum, Salam dan Sapa Kami Siap Melayani Anda</p>
<a href="profil.php" class="btn btn-success">Profil Desa</a>
</div>
</section>

<!-- STATISTIK -->
<section class="my-5">
<div class="stats-grid">
<div class="stat-card">
<i class="fas fa-users"></i>
<h3><?= number_format($stat['jumlah_penduduk']) ?></h3>
<p>Jumlah Penduduk</p>
</div>

<div class="stat-card">
<i class="fas fa-home"></i>
<h3><?= number_format($stat['kepala_keluarga']) ?></h3>
<p>Kepala Keluarga</p>
</div>

<div class="stat-card">
<i class="fas fa-map"></i>
<h3>173.635 Hektar</h3>
<p>Luas Desa</p>
</div>
</div>
</section>

<!-- LAYANAN -->
<section class="text-center my-5">
<h2>Layanan Desa</h2>
<div class="services-grid">
<div class="service-card p-3" style="width:250px">
<i class="fas fa-file-alt fa-2x text-success"></i>
<h5>Administrasi</h5>
<p>Layanan kependudukan</p>
</div>
<div class="service-card p-3" style="width:250px">
<i class="fas fa-comments fa-2x text-success"></i>
<h5>Pengaduan</h5>
<p>Saran & keluhan warga</p>
</div>
</div>
</section>

<!-- BERITA -->
<section class="my-5">
<h2 class="text-center">Berita Terkini</h2>
<div class="news-grid">
<?php while($n=mysqli_fetch_assoc($newsQuery)): ?>
<div class="news-card">
<?php if($n['gambar']): ?>
<img src="uploads/<?= $n['gambar'] ?>">
<?php endif; ?>
<div class="p-3">
<h5><?= htmlspecialchars($n['judul']) ?></h5>
<p><?= substr(strip_tags($n['isi']),0,80) ?>...</p>
<a href="berita_detail.php?id=<?= $n['id'] ?>">Baca</a>
</div>
</div>
<?php endwhile; ?>
</div>
</section>

<!-- FOOTER -->
<footer>
<p>© 2025 Pemerintah Desa Sidomulyo</p>
</footer>

</body>
</html>
