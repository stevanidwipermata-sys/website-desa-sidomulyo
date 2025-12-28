<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
    header("Location: login.php?page=tambah_berita.php");
    exit;
}

include "config.php";

$success = "";
$error = "";

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $judul     = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $kategori  = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $isi       = mysqli_real_escape_string($koneksi, $_POST['isi']);
    $tanggal   = date("Y-m-d");

    // Upload gambar
    $gambar = "";
    if(isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0){
        $allowed = ['jpg','jpeg','png'];
        $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
        if(!in_array($ext,$allowed)){
            $error = "Format gambar harus JPG, JPEG, PNG.";
        } else {
            if(!is_dir('uploads')) mkdir('uploads');
            $gambar = time().'_'.$_FILES['gambar']['name'];
            move_uploaded_file($_FILES['gambar']['tmp_name'],'uploads/'.$gambar);
        }
    }

    if(!$error){
        $sql = "INSERT INTO berita (judul,kategori,isi,tanggal,gambar) VALUES ('$judul','$kategori','$isi','$tanggal','$gambar')";
        if(mysqli_query($koneksi,$sql)){
            $success = "Berita berhasil ditambahkan!";
            $_POST = [];
        } else {
            $error = "Terjadi kesalahan: ".mysqli_error($koneksi);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tambah Berita | Admin Desa Sidomulyo</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
<h2>Tambah Berita</h2>
<?php if($success): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>
<?php if($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label class="form-label">Judul</label>
        <input type="text" name="judul" class="form-control" required value="<?= $_POST['judul'] ?? '' ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Kategori</label>
        <input type="text" name="kategori" class="form-control" required value="<?= $_POST['kategori'] ?? '' ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Isi</label>
        <textarea name="isi" class="form-control" rows="6" required><?= $_POST['isi'] ?? '' ?></textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Gambar (opsional)</label>
        <input type="file" name="gambar" class="form-control" accept=".jpg,.jpeg,.png">
    </div>
    <button type="submit" class="btn btn-success">Tambah Berita</button>
    <a href="admin_berita.php" class="btn btn-secondary">Kembali</a>
</form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
