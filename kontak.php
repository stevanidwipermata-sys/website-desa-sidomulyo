<?php
include "configsaran.php";

$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_lengkap    = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $email           = mysqli_real_escape_string($koneksi, $_POST['email']);
    $nomor_telepon   = mysqli_real_escape_string($koneksi, $_POST['nomor_telepon']);
    $kategori        = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $subjek          = mysqli_real_escape_string($koneksi, $_POST['subjek']);
    $pesan           = mysqli_real_escape_string($koneksi, $_POST['pesan']);

    $lampiran = "";
    if (isset($_FILES['lampiran']) && $_FILES['lampiran']['error'] === 0) {
        $allowed = ['jpg','jpeg','png','pdf','doc','docx'];
        $fileName = $_FILES['lampiran']['name'];
        $fileTmp  = $_FILES['lampiran']['tmp_name'];
        $fileSize = $_FILES['lampiran']['size'];
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            $error = "Format file tidak didukung. Hanya JPG, PNG, PDF, DOC, DOCX.";
        } elseif ($fileSize > 5 * 1024 * 1024) {
            $error = "Ukuran file maksimal 5MB.";
        } else {
            if (!is_dir("uploads")) mkdir("uploads");
            $lampiran = "uploads/" . time() . "_" . $fileName;
            if (!move_uploaded_file($fileTmp, $lampiran)) {
                $error = "Gagal mengunggah file.";
            }
        }
    }

    if (!$error) {
        $sql = "INSERT INTO saran 
                (nama_lengkap,email,nomor_telepon,kategori,subjek,pesan,lampiran)
                VALUES 
                ('$nama_lengkap','$email','$nomor_telepon','$kategori','$subjek','$pesan','$lampiran')";
        if (mysqli_query($koneksi, $sql)) {
            $success = "Pesan berhasil dikirim!";
            $_POST = [];
        } else {
            $error = "Terjadi kesalahan: " . mysqli_error($koneksi);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kontak | Desa Sidomulyo</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<style>
body {
    font-family: 'Poppins', sans-serif;
    background-color: #fffffeff;
    margin: 0;
    padding-top: 80px;
}

/* Navbar */
.navbar {
    backdrop-filter: blur(10px);
    background-color: rgba(255,255,255,0.2);
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}
.navbar .nav-link { color: #1B5E20; }
.navbar .nav-link:hover,
.navbar .nav-link.active { color: #66bb6a !important; transition:0.3s; }
.navbar-brand { color:#1B5E20; font-weight:600; }
.navbar-brand:hover { color:#2e7d32 !important; transition:0.3s; }

/* Hero Section */
.hero-section {
    max-width: 1200px;
    margin: 0 auto 50px auto;
    background-color: #ffffffcc; 
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    height: 40vh;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    position: relative;
}
.hero-section::before {
    content: "";
    background-image: url('balai-desa.jpeg');
    background-size: cover;
    background-position: center;
    position: absolute;
    top: 0; left: 0;
    width: 100%;
    height: 100%;
    filter: brightness(0.65);
    z-index: 1;
}
.hero-section .hero-text {
    position: relative;
    z-index: 2;
    color: white;
    text-shadow: 0 2px 8px rgba(0,0,0,0.6);
}
.hero-section h1 { font-weight: 600; }
.hero-section p { font-weight: 400; }

/* Cards */
.card {
    border-radius:12px;
    padding:20px;
    margin-bottom: 20px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}
.submit-btn { background-color:#4CAF50; color:white; border:none; }
.submit-btn:hover { background-color:#45a049; }
.contact-info i { color:#4CAF50; font-size:1.2rem; }

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
        <img src="logo-desa.png" alt="Logo Sidoarjo" style="height:40px; margin-right:10px;">
        <span><i class="fas fa-seedling"></i> Desa Sidomulyo</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item"><a class="nav-link" href="index.php">Beranda</a></li>
        <li class="nav-item"><a class="nav-link" href="profil.php">Profil Desa</a></li>
        <li class="nav-item"><a class="nav-link" href="peta.php">Peta Desa</a></li>
        <li class="nav-item"><a class="nav-link" href="administrasi.php">Administrasi</a></li>
        <li class="nav-item"><a class="nav-link" href="berita.php">Berita</a></li>
        <li class="nav-item"><a class="nav-link active" href="kontak.php">Kontak</a></li>
        <a href="login.php?page=admin_saran" class="btn btn-admin">Admin</a>
    </div>
  </div>
</nav>

<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-text">
        <h1>Kontak & Masukan</h1>
        <p>Sampaikan saran atau pertanyaan Anda untuk kemajuan Desa Sidomulyo</p>
    </div>
</section>

<!-- Konten Utama -->
<div class="container mb-5">
    <div class="row g-4">
        <!-- Form Kontak -->
        <div class="col-md-7">
            <?php if($success): ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php endif; ?>
            <?php if($error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <div class="card">
                <h2 class="mb-3">Kirim Pesan</h2>
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap *</label>
                        <input type="text" class="form-control" name="nama_lengkap" required value="<?= $_POST['nama_lengkap'] ?? '' ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" class="form-control" name="email" required value="<?= $_POST['email'] ?? '' ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control" name="nomor_telepon" value="<?= $_POST['nomor_telepon'] ?? '' ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori *</label>
                        <select class="form-select" name="kategori" required>
                            <option value="">Pilih Kategori</option>
                            <option value="Pengaduan" <?= ($_POST['kategori'] ?? '')=='Pengaduan'?'selected':'' ?>>Pengaduan</option>
                            <option value="Saran" <?= ($_POST['kategori'] ?? '')=='Saran'?'selected':'' ?>>Saran & Masukan</option>
                            <option value="Informasi" <?= ($_POST['kategori'] ?? '')=='Informasi'?'selected':'' ?>>Permintaan Informasi</option>
                            <option value="Pelayanan" <?= ($_POST['kategori'] ?? '')=='Pelayanan'?'selected':'' ?>>Keluhan Pelayanan</option>
                            <option value="Infrastruktur" <?= ($_POST['kategori'] ?? '')=='Infrastruktur'?'selected':'' ?>>Infrastruktur</option>
                            <option value="Lainnya" <?= ($_POST['kategori'] ?? '')=='Lainnya'?'selected':'' ?>>Lainnya</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Subjek *</label>
                        <input type="text" class="form-control" name="subjek" required value="<?= $_POST['subjek'] ?? '' ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pesan *</label>
                        <textarea class="form-control" name="pesan" rows="5" required><?= $_POST['pesan'] ?? '' ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lampiran (opsional)</label>
                        <input class="form-control" type="file" name="lampiran" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                        <small class="text-muted">Format: JPG, PNG, PDF, DOC, DOCX (Max 5MB)</small>
                    </div>
                    <button type="submit" class="btn submit-btn"><i class="fas fa-paper-plane"></i> Kirim Pesan</button>
                </form>
            </div>
        </div>

        <!-- Info Kontak -->
        <div class="col-md-5">
            <div class="card bg-light">
                <h2 class="mb-3">Informasi Kontak</h2>
                <p><i class="fas fa-map-marker-alt"></i> Jln. Soenandar Prijo Soedarmo No.1, Desa Sidomulyo, Krian, Sidoarjo</p>
                <p><i class="fas fa-phone"></i> 0857-3241-1128 (WhatsApp)</p>
                <p><i class="fas fa-envelope"></i> sidomulyo.krian@sidoarjokab.go.id</p>
                <p><i class="fas fa-clock"></i> Senin - Jumat: 08.00 - 15.00 WIB | Sabtu - Minggu: Tutup</p>
            </div>
        </div>
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
