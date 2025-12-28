<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
    header("Location: login.php?page=admin_berita.php");
    exit;
}

include "config.php";

$success = "";
$error = "";

$id = $_GET['id'] ?? 0;
$newsQuery = mysqli_query($koneksi,"SELECT * FROM berita WHERE id='$id'");
$news = mysqli_fetch_assoc($newsQuery);
if(!$news){
    die("Berita tidak ditemukan");
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $judul     = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $kategori  = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $isi       = mysqli_real_escape_string($koneksi, $_POST['isi']);

    // Upload gambar baru
    $gambar = $news['gambar'];
    if(isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0){
        $allowed = ['jpg','jpeg','png'];
        $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
        if(!in_array($ext,$allowed)){
            $error = "Format gambar harus JPG, JPEG, PNG.";
        } else {
            if(!is_dir('uploads')) mkdir('uploads');
            $newImg = time().'_'.$_FILES['gambar']['name'];
            move_uploaded_file($_FILES['gambar']['tmp_name'],'uploads/'.$newImg);
            // Hapus gambar lama
            if($news['gambar'] && file_exists('uploads/'.$news['gambar'])){
                unlink('uploads/'.$news['gambar']);
            }
            $gambar = $newImg;
        }
    }

    if(!$error){
        $sql = "UPDATE berita SET judul='$judul', kategori='$kategori', isi='$isi', gambar='$gambar' WHERE id='$id'";
        if(mysqli_query($koneksi,$sql)){
            $success = "Berita berhasil diupdate!";
            // refresh data
            $news = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM berita WHERE id='$id'"));
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
<title>Edit Berita | Admin Desa Sidomulyo</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
<h2>Edit Berita</h2>
<?php if($success): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>
<?php if($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label class="form-label">Judul</label>
        <input type="text" name="judul" class="form-control" required value="<?= $news['judul'] ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Kategori</label>
        <input type="text" name="kategori" class="form-control" required value="<?= $news['kategori'] ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Isi</label>
        <textarea name="isi" class="form-control" rows="6" required><?= $news['isi'] ?></textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Gambar (opsional)</label><br>
        <?php if($news['gambar'] && file_exists('uploads/'.$news['gambar'])): ?>
            <img src="uploads/<?= $news['gambar'] ?>" style="max-width:200px; margin-bottom:10px;"><br>
        <?php endif; ?>
        <input type="file" name="gambar" class="form-control" accept=".jpg,.jpeg,.png">
        <small class="text-muted">Upload untuk mengganti gambar lama</small>
    </div>
    <button type="submit" class="btn btn-primary">Update Berita</button>
    <a href="admin_berita.php" class="btn btn-secondary">Kembali</a>
</form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
