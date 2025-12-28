<?php
include "config.php"; // Database berita

// Pagination
$limit = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Ambil berita terbaru (Featured)
$featuredQuery = mysqli_query($koneksi, "SELECT * FROM berita ORDER BY tanggal DESC LIMIT 1");
$featured = mysqli_fetch_assoc($featuredQuery);

// Ambil berita lainnya
$newsQuery = mysqli_query(
    $koneksi,
    "SELECT * FROM berita 
     WHERE id != '".$featured['id']."' 
     ORDER BY tanggal DESC 
     LIMIT $start, $limit"
);

// Total halaman
$totalNews = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT COUNT(*) as total FROM berita WHERE id != '".$featured['id']."'")
);
$totalPages = ceil($totalNews['total'] / $limit);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Berita Desa | Desa Sidomulyo</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<style>
body{
    font-family:'Poppins',sans-serif;
    background:#fcfbfbff;
    padding-top:80px;
}

/* Navbar */
.navbar{
    backdrop-filter: blur(10px);
    background:rgba(255, 255, 255, 0.2);
    box-shadow:0 2px 10px rgba(0,0,0,0.1);
}
.navbar .nav-link{color:#1B5E20}
.navbar .nav-link.active,
.navbar .nav-link:hover{color:#66bb6a}

/* Hero */
.hero-section{
    max-width:1200px;
    margin:0 auto 50px;
    height:40vh;
    border-radius:15px;
    overflow:hidden;
    position:relative;
}
.hero-section::before{
    content:"";
    position:absolute;
    inset:0;
    background:url('balai-desa.jpeg') center/cover;
    filter:brightness(0.6);
}
.hero-text{
    position:relative;
    z-index:2;
    height:100%;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    color:#fff;
    text-align:center;
}

/* ===== FEATURED CARD ===== */
.featured-card{
    display:grid;
    grid-template-columns:1.2fr 1fr;
    gap:25px;
    background:#fff;
    padding:20px;
    border-radius:15px;
    box-shadow:0 8px 25px rgba(0,0,0,0.12);
}
.featured-card img{
    width:100%;
    height:100%;
    max-height:320px;
    object-fit:cover;
    border-radius:12px;
}
.featured-badge{
    background:#2e7d32;
    color:#fff;
    font-size:.75rem;
    padding:6px 14px;
    border-radius:20px;
    display:inline-block;
    margin-bottom:10px;
}
@media(max-width:768px){
    .featured-card{grid-template-columns:1fr}
}

/* News Grid */
.news-grid .card{
    box-shadow:0 4px 15px rgba(0,0,0,0.1);
    transition:.3s;
}
.news-grid .card:hover{transform:translateY(-5px)}
.card-img-top{height:200px;object-fit:cover}

/* Pagination */
.pagination .page-link{color:#2e7d32}
.pagination .active .page-link{
    background:#2e7d32;
    border-color:#2e7d32;
}

/* Footer */
footer{
    background:#1B5E20;
    color:#fff;
    padding:30px 0;
    text-align:center;
}
</style>
</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top">
<div class="container">
<a class="navbar-brand" href="index.php">
    <img src="logo-desa.png" height="40"> Desa Sidomulyo
</a>
<div class="collapse navbar-collapse">
<ul class="navbar-nav ms-auto">
<li class="nav-item"><a class="nav-link" href="index.php">Beranda</a></li>
        <li class="nav-item"><a class="nav-link" href="profil.php">Profil Desa</a></li>
        <li class="nav-item"><a class="nav-link" href="peta.php">Peta Desa</a></li>
        <li class="nav-item"><a class="nav-link" href="administrasi.php">Administrasi</a></li>
        <li class="nav-item"><a class="nav-link active" href="berita.php">Berita</a></li>
        <li class="nav-item"><a class="nav-link" href="kontak.php">Kontak</a></li>
        <a href="login.php?page=admin_berita" class="btn btn-admin">Admin</a>
</ul>
</div>
</div>
</nav>

<!-- Hero -->
<section class="hero-section">
<div class="hero-text">
<h1>Berita Desa</h1>
<p>Informasi terbaru Desa Sidomulyo</p>
</div>
</section>

<main class="container">

<!-- ===== FEATURED NEWS ===== -->
<?php if($featured): ?>
<section class="mb-5">
<div class="featured-card">

<div>
<?php if($featured['gambar']): ?>
<img src="uploads/<?php echo $featured['gambar']; ?>">
<?php endif; ?>
</div>

<div>
<span class="featured-badge">
<i class="fas fa-star"></i> Berita Utama
</span>

<h2><?php echo $featured['judul']; ?></h2>
<p><?php echo substr($featured['isi'],0,250); ?>...</p>

<small class="text-muted">
<i class="fas fa-calendar"></i>
<?php echo date("d M Y", strtotime($featured['tanggal'])); ?>
 |
<i class="fas fa-tag"></i>
<?php echo $featured['kategori']; ?>
</small>
</div>

</div>
</section>
<?php endif; ?>

<!-- ===== NEWS GRID ===== -->
<section class="row news-grid">
<?php while($news = mysqli_fetch_assoc($newsQuery)): ?>
<div class="col-md-4 mb-4">
<div class="card">
<?php if($news['gambar']): ?>
<img src="uploads/<?php echo $news['gambar']; ?>" class="card-img-top">
<?php endif; ?>
<div class="card-body">
<h5 class="card-title"><?php echo $news['judul']; ?></h5>
<p class="card-text"><?php echo substr($news['isi'],0,100); ?>...</p>
<small class="text-muted">
<i class="fas fa-calendar"></i>
<?php echo date("d M Y", strtotime($news['tanggal'])); ?>
</small>
</div>
</div>
</div>
<?php endwhile; ?>
</section>

<!-- Pagination -->
<nav>
<ul class="pagination justify-content-center">
<?php for($i=1;$i<=$totalPages;$i++): ?>
<li class="page-item <?=($i==$page)?'active':''?>">
<a class="page-link" href="?page=<?=$i?>"><?=$i?></a>
</li>
<?php endfor; ?>
</ul>
</nav>

</main>

<footer>
<p>© 2025 Desa Sidomulyo</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
