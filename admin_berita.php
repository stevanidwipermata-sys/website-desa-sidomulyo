<?php

include "config.php";

$success = "";
$error = "";

// Handle delete
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    // Hapus gambar lama
    $imgQuery = mysqli_query($koneksi, "SELECT gambar FROM berita WHERE id='$id'");
    $imgData = mysqli_fetch_assoc($imgQuery);
    if($imgData['gambar'] && file_exists('uploads/'.$imgData['gambar'])){
        unlink('uploads/'.$imgData['gambar']);
    }
    mysqli_query($koneksi, "DELETE FROM berita WHERE id='$id'");
    $success = "Berita berhasil dihapus!";
}

// Handle Tambah & Edit form submit
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $isi = mysqli_real_escape_string($koneksi, $_POST['isi']);
    $id_edit = $_POST['id_edit'] ?? '';

    $gambar = '';
    if(isset($_FILES['gambar']) && $_FILES['gambar']['error'] === 0){
        $allowed = ['jpg','jpeg','png'];
        $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
        if(!in_array($ext, $allowed)){
            $error = "Format gambar harus JPG/JPEG/PNG!";
        } else {
            if(!is_dir('uploads')) mkdir('uploads');
            $gambar = time().'_'.$_FILES['gambar']['name'];
            move_uploaded_file($_FILES['gambar']['tmp_name'], 'uploads/'.$gambar);
        }
    }

    if(!$error){
        if($id_edit){ // Edit berita
            // Ambil gambar lama
            $oldQuery = mysqli_query($koneksi, "SELECT gambar FROM berita WHERE id='$id_edit'");
            $old = mysqli_fetch_assoc($oldQuery);
            if($gambar && $old['gambar'] && file_exists('uploads/'.$old['gambar'])){
                unlink('uploads/'.$old['gambar']);
            }
            $img_sql = $gambar ? ", gambar='$gambar'" : "";
            mysqli_query($koneksi, "UPDATE berita SET judul='$judul', kategori='$kategori', isi='$isi' $img_sql WHERE id='$id_edit'");
            $success = "Berita berhasil diupdate!";
        } else { // Tambah berita baru
            mysqli_query($koneksi, "INSERT INTO berita (judul,kategori,isi,gambar,tanggal) VALUES ('$judul','$kategori','$isi','$gambar',NOW())");
            $success = "Berita berhasil ditambahkan!";
        }
    }
}

// Ambil semua berita
$newsQuery = mysqli_query($koneksi, "SELECT * FROM berita ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Berita | Desa Sidomulyo</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<style>
body { font-family:'Poppins',sans-serif; padding-top:80px; background:#e8f5e9; }
.navbar { backdrop-filter:blur(10px); background:rgba(255,255,255,0.2); box-shadow:0 2px 10px rgba(0,0,0,0.1); }
.navbar .nav-link { color:#1B5E20; margin-right:0.5rem; }
.navbar .nav-link.active { color:#66bb6a !important; }
.section-title { color:#1B5E20; font-weight:600; margin-bottom:1rem; }
.card { border-radius:12px; transition: transform 0.3s; }
.card:hover { transform: translateY(-5px); }
.card-img-top { height:180px; object-fit:cover; border-radius:12px 12px 0 0; }
.card-body { padding:15px; }
.btn-sm { font-size:0.8rem; }
</style>
</head>
<body>

<nav class="navbar navbar-expand-lg fixed-top">
<div class="container">
<a class="navbar-brand" href="index.php"><i class="fas fa-seedling"></i> Desa Sidomulyo Admin</a>
<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
  <span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link active" href="#">Berita</a></li>
        <li class="nav-item"><a class="nav-link" href="admin_statistik.php">Statistik</a></li>
        <li class="nav-item"><a class="nav-link" href="admin_profil.php">Profil</a></li>
        <li class="nav-item"><a class="nav-link" href="admin_peta.php">Peta</a></li>
        <li class="nav-item"><a class="nav-link" href="admin_administrasi.php">Administrasi</a></li>
        <li class="nav-item"><a class="nav-link" href="admin_saran.php">Kontak</a></li>
        <li class="nav-item"><a class="nav-link" href="berita.php">Kembali</a></li>
    </ul>
</div>
</div>
</nav>

<div class="container my-5">
<h2 class="section-title">Kelola Berita</h2>

<?php if($success): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>
<?php if($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>

<!-- Button Tambah -->
<button class="btn btn-success mb-4" data-bs-toggle="modal" data-bs-target="#modalTambah"><i class="fas fa-plus"></i> Tambah Berita</button>

<div class="row g-4">
<?php while($news = mysqli_fetch_assoc($newsQuery)): ?>
<div class="col-md-4">
    <div class="card shadow-sm">
        <?php if($news['gambar'] && file_exists('uploads/'.$news['gambar'])): ?>
        <img src="uploads/<?= $news['gambar'] ?>" class="card-img-top" alt="<?= $news['judul'] ?>">
        <?php else: ?>
        <img src="https://via.placeholder.com/400x180?text=No+Image" class="card-img-top" alt="No image">
        <?php endif; ?>
        <div class="card-body">
            <h5 class="card-title"><?= $news['judul'] ?></h5>
            <p class="card-text"><?= substr($news['isi'],0,100) ?>...</p>
            <small class="text-muted"><i class="fas fa-calendar"></i> <?= date("d M Y", strtotime($news['tanggal'])) ?> | <i class="fas fa-tag"></i> <?= $news['kategori'] ?></small>
            <div class="mt-2 d-flex justify-content-between">
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $news['id'] ?>"><i class="fas fa-edit"></i> Edit</button>
                <a href="admin_berita.php?delete=<?= $news['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus berita ini?')"><i class="fas fa-trash"></i> Hapus</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit<?= $news['id'] ?>" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    <form method="POST" enctype="multipart/form-data">
      <div class="modal-header">
        <h5 class="modal-title">Edit Berita</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
          <input type="hidden" name="id_edit" value="<?= $news['id'] ?>">
          <div class="mb-3">
              <label>Judul</label>
              <input type="text" name="judul" class="form-control" value="<?= $news['judul'] ?>" required>
          </div>
          <div class="mb-3">
              <label>Kategori</label>
              <input type="text" name="kategori" class="form-control" value="<?= $news['kategori'] ?>" required>
          </div>
          <div class="mb-3">
              <label>Isi Berita</label>
              <textarea name="isi" class="form-control" rows="5" required><?= $news['isi'] ?></textarea>
          </div>
          <div class="mb-3">
              <label>Gambar (opsional, pilih untuk ganti)</label>
              <input type="file" name="gambar" class="form-control" accept=".jpg,.jpeg,.png">
          </div>
      </div>
      <div class="modal-footer">
          <button type="submit" class="btn btn-success">Simpan Perubahan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
      </div>
    </form>
    </div>
  </div>
</div>
<?php endwhile; ?>
</div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    <form method="POST" enctype="multipart/form-data">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Berita Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
          <div class="mb-3">
              <label>Judul</label>
              <input type="text" name="judul" class="form-control" required>
          </div>
          <div class="mb-3">
              <label>Kategori</label>
              <input type="text" name="kategori" class="form-control" required>
          </div>
          <div class="mb-3">
              <label>Isi Berita</label>
              <textarea name="isi" class="form-control" rows="5" required></textarea>
          </div>
          <div class="mb-3">
              <label>Gambar (opsional)</label>
              <input type="file" name="gambar" class="form-control" accept=".jpg,.jpeg,.png">
          </div>
      </div>
      <div class="modal-footer">
          <button type="submit" class="btn btn-success">Tambah Berita</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
      </div>
    </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
