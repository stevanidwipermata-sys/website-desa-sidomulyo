<?php
include "configsaran.php";

/* ===================== HAPUS ===================== */
if(isset($_GET['hapus_id'])){
    $id = (int)$_GET['hapus_id'];

    $cek = mysqli_query($koneksi,"SELECT lampiran FROM saran WHERE id=$id");
    if($f = mysqli_fetch_assoc($cek)){
        if($f['lampiran'] && file_exists($f['lampiran'])){
            unlink($f['lampiran']);
        }
    }
    mysqli_query($koneksi,"DELETE FROM saran WHERE id=$id");
    header("Location: admin_saran.php");
    exit;
}

$data = mysqli_query($koneksi,"SELECT * FROM saran ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Admin Saran | Desa Sidomulyo</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<style>
body{
    font-family:'Poppins',sans-serif;
    background:#e8f5e9;
    padding-top:80px;
}
.navbar{
    backdrop-filter:blur(10px);
    background:rgba(255,255,255,.2);
    box-shadow:0 2px 10px rgba(0,0,0,.1);
}
.section-title{
    color:#1B5E20;
    font-weight:600;
    margin-bottom:1rem;
}
.card{
    border-radius:14px;
    transition:.3s;
}
.card:hover{
    transform:translateY(-5px);
}
.badge{
    font-size:.75rem;
}
</style>
</head>

<body>

<nav class="navbar navbar-expand-lg fixed-top">
<div class="container">
<a class="navbar-brand fw-semibold" href="index.php">
<i class="fas fa-seedling"></i> Desa Sidomulyo Admin
</a>
<button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">
<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="nav">
<ul class="navbar-nav ms-auto">
<li class="nav-item"><a class="nav-link active" href="#">Saran</a></li>
<li class="nav-item"><a class="nav-link" href="kontak.php">Kembali</a></li>
</ul>
</div>
</div>
</nav>

<div class="container my-5">
<h2 class="section-title">Kotak Saran Masyarakat</h2>

<div class="row g-4">
<?php if(mysqli_num_rows($data)>0): ?>
<?php while($r=mysqli_fetch_assoc($data)): ?>
<div class="col-md-6 col-lg-4">
<div class="card shadow-sm h-100">
<div class="card-body">
<h6 class="fw-semibold mb-1"><?= htmlspecialchars($r['nama_lengkap']) ?></h6>
<small class="text-muted"><?= htmlspecialchars($r['email']) ?></small><br>
<small class="text-muted"><?= htmlspecialchars($r['nomor_telepon']) ?></small>

<hr>

<span class="badge bg-success"><?= htmlspecialchars($r['kategori']) ?></span>
<span class="badge bg-secondary"><?= htmlspecialchars($r['subjek']) ?></span>

<p class="mt-3"><?= nl2br(htmlspecialchars($r['pesan'])) ?></p>

<?php if($r['lampiran']): ?>
<a href="<?= $r['lampiran'] ?>" target="_blank" class="btn btn-outline-success btn-sm">
<i class="fa fa-paperclip"></i> Lampiran
</a>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mt-3">
<small class="text-muted">
<i class="fa fa-calendar"></i>
<?= date("d M Y H:i",strtotime($r['created_at'])) ?>
</small>

<a href="?hapus_id=<?= $r['id'] ?>"
onclick="return confirm('Hapus saran ini?')"
class="btn btn-danger btn-sm">
<i class="fa fa-trash"></i>
</a>
</div>

</div>
</div>
</div>
<?php endwhile; ?>
<?php else: ?>
<div class="col-12 text-center text-muted">
Belum ada saran masuk
</div>
<?php endif; ?>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
