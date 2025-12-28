<?php
include "config.php";

/* ===================== AMBIL DATA PROFIL ===================== */
$data = mysqli_query($koneksi, "
    SELECT * FROM profil_desa 
    ORDER BY 
        CASE 
            WHEN kategori = 'sambutan' THEN 0
            WHEN kategori = 'struktur' THEN 99
            ELSE 1
        END,
        urutan ASC,
        id ASC
");

$profil   = [];
$struktur = [];

while($row = mysqli_fetch_assoc($data)) {
    $kategori = strtolower(trim($row['kategori']));
    $sub      = strtolower(trim($row['sub_kategori'] ?? 'default'));

    if($kategori === 'struktur') {
        $struktur[] = $row;
    } else {
        if(!isset($profil[$kategori])) {
            $profil[$kategori] = [];
        }
        $profil[$kategori][$sub] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Profil Desa | Desa Sidomulyo</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<style>
body{
    font-family:'Poppins',sans-serif;
    background:#fcfbfbff;
    padding-top:80px;
}
.navbar{
    backdrop-filter:blur(10px);
    background:rgba(255,255,255,0.2);
}
.navbar .nav-link{color:#1B5E20}
.navbar .nav-link:hover,
.navbar .nav-link.active{color:#66bb6a!important}
.navbar-brand{color:#1B5E20;font-weight:600}

.hero-section{
    max-width:1200px;
    margin:0 auto 50px;
    height:50vh;
    position:relative;
    display:flex;
    align-items:center;
    justify-content:center;
    text-align:center;
    border-radius:15px;
    overflow:hidden;
    box-shadow:0 8px 20px rgba(0,0,0,0.2);
}
.hero-section::before{
    content:"";
    position:absolute;
    inset:0;
    background:url('balai-desa.jpeg') center/cover no-repeat;
    filter:brightness(0.6);
}
.hero-text{position:relative;z-index:2;color:#fff}

.profil-section{
    background:#fff;
    border-radius:12px;
    padding:30px;
    margin-bottom:30px;
    box-shadow:0 4px 15px rgba(0,0,0,0.1);
}
.profil-section h2{
    color:#1B5E20;
    font-weight:600;
}
.profil-gambar img{
    max-width:100%;
    border-radius:10px;
    margin-top:15px;
}

/* STRUKTUR */
.struktur-card{
    background:#fff;
    border-radius:12px;
    padding:20px;
    text-align:center;
    box-shadow:0 4px 10px rgba(0,0,0,0.1);
    transition:.3s;
}
.struktur-card:hover{transform:translateY(-5px)}
.struktur-card img{
    width:120px;
    height:120px;
    object-fit:cover;
    border-radius:50%;
}
.struktur-jabatan{
    font-weight:600;
    color:#1B5E20;
}
footer{
    background:#1B5E20;
    color:#fff;
    padding:30px 0;
    text-align:center;
}
</style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg fixed-top">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="index.php">
        <img src="logo-desa.png" style="height:40px;margin-right:10px;">
        Desa Sidomulyo
    </a>

    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">Beranda</a></li>
        <li class="nav-item"><a class="nav-link active" href="profil.php">Profil Desa</a></li>
        <li class="nav-item"><a class="nav-link" href="peta.php">Peta Desa</a></li>
        <li class="nav-item"><a class="nav-link" href="administrasi.php">Administrasi</a></li>
        <li class="nav-item"><a class="nav-link" href="berita.php">Berita</a></li>
        <li class="nav-item"><a class="nav-link" href="kontak.php">Kontak</a></li>
        <li class="nav-item"><a class="nav-link" href="login.php">Admin</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- HERO -->
<section class="hero-section">
    <div class="hero-text">
        <h1>Profil Desa Sidomulyo</h1>
        <p>Mengenal sejarah, visi, misi, dan pemerintahan desa</p>
    </div>
</section>

<div class="container">

<!-- PROFIL (SAMBUTAN KADES PALING ATAS) -->
<?php foreach($profil as $kat): ?>
    <?php foreach($kat as $row): ?>
        <section class="profil-section">
            <h2><?= htmlspecialchars($row['judul']) ?></h2>
            <?= $row['isi'] ?? $row['konten'] ?>
            <?php if(!empty($row['gambar'])): ?>
                <div class="profil-gambar">
                    <img src="<?= $row['gambar'] ?>">
                </div>
            <?php endif; ?>
        </section>
    <?php endforeach; ?>
<?php endforeach; ?>

<!-- STRUKTUR -->
<?php if($struktur): ?>
<section class="mb-5">
    <h2 class="text-success mb-4">Struktur Pemerintahan Desa</h2>
    <div class="row g-4">
        <?php foreach($struktur as $s): ?>
        <div class="col-md-3 col-sm-6">
            <div class="struktur-card">
                <img src="<?= $s['gambar'] ?: 'default-avatar.png' ?>">
                <div class="struktur-jabatan"><?= $s['sub_kategori'] ?></div>
                <div><?= $s['nama'] ?></div>
                <small><?= $s['keterangan'] ?></small>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

</div>

<footer>
    <img src="logo-desa.png" style="height:50px">
    <p>Pemerintah Desa Sidomulyo<br>Krian, Sidoarjo</p>
    <p>© 2025</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
