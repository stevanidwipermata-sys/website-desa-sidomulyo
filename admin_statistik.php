<?php
session_start();
include "config.php";

// Proteksi login
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit;
}

$success = "";

// Ambil data statistik
$data = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT * FROM statistik_desa LIMIT 1")
);

// Simpan perubahan
if(isset($_POST['simpan'])){
    $jp = intval($_POST['jumlah_penduduk']);
    $kk = intval($_POST['kepala_keluarga']);

    mysqli_query($koneksi, "
        UPDATE statistik_desa 
        SET jumlah_penduduk='$jp', kepala_keluarga='$kk'
        WHERE id='{$data['id']}'
    ");

    $success = "Statistik berhasil diperbarui!";
    $data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM statistik_desa LIMIT 1"));
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Statistik | Desa Sidomulyo</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<style>
body{
    font-family:'Poppins',sans-serif;
    padding-top:80px;
    background:#e8f5e9;
}
.navbar{
    backdrop-filter:blur(10px);
    background:rgba(255,255,255,0.2);
    box-shadow:0 2px 10px rgba(0,0,0,0.1);
}
.navbar .nav-link{color:#1B5E20}
.navbar .nav-link.active{color:#66bb6a!important}
.section-title{
    color:#1B5E20;
    font-weight:600;
    margin-bottom:1rem;
}
.card{
    border-radius:14px;
    box-shadow:0 4px 15px rgba(0,0,0,0.1);
}
.stat-icon{
    font-size:3rem;
    color:#4CAF50;
}
</style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg fixed-top">
<div class="container">
<a class="navbar-brand" href="index.php">
<i class="fas fa-seedling"></i> Desa Sidomulyo Admin
</a>
<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarNav">
<ul class="navbar-nav ms-auto">
<li class="nav-item"><a class="nav-link active" href="#">Statistik</a></li>
<li class="nav-item"><a class="nav-link" href="admin_profil.php">Profil</a></li>
<li class="nav-item"><a class="nav-link" href="admin_peta.php">Peta</a></li>
<li class="nav-item"><a class="nav-link" href="admin_administrasi.php">Administrasi</a></li>
<li class="nav-item"><a class="nav-link" href="admin_berita.php">Berita</a></li>
<li class="nav-item"><a class="nav-link" href="index.php">Kembali</a></li>
</ul>
</div>
</div>
</nav>

<!-- CONTENT -->
<div class="container my-5">
<h2 class="section-title">Kelola Statistik Desa</h2>

<?php if($success): ?>
<div class="alert alert-success"><?= $success ?></div>
<?php endif; ?>

<div class="row justify-content-center">
<div class="col-md-8">

<div class="card p-4">
<div class="row text-center mb-4">
<div class="col-md-6">
<i class="fas fa-users stat-icon"></i>
<h5 class="mt-2">Jumlah Penduduk</h5>
</div>
<div class="col-md-6">
<i class="fas fa-home stat-icon"></i>
<h5 class="mt-2">Kepala Keluarga</h5>
</div>
</div>

<form method="post">
<div class="row">
<div class="col-md-6 mb-3">
<label class="form-label">Jumlah Penduduk</label>
<input type="number" name="jumlah_penduduk" class="form-control form-control-lg"
value="<?= $data['jumlah_penduduk'] ?>" required>
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Kepala Keluarga</label>
<input type="number" name="kepala_keluarga" class="form-control form-control-lg"
value="<?= $data['kepala_keluarga'] ?>" required>
</div>
</div>

<div class="text-end mt-3">
<button type="submit" name="simpan" class="btn btn-success px-4">
<i class="fas fa-save"></i> Simpan Perubahan
</button>
</div>
</form>

</div>
</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
