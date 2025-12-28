<?php
include "config.php";

$success = "";
$error = "";

// ===================== PROSES SIMPAN =====================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rt        = mysqli_real_escape_string($koneksi, $_POST['rt']);
    $rw        = mysqli_real_escape_string($koneksi, $_POST['rw']);
    $dusun     = mysqli_real_escape_string($koneksi, $_POST['dusun']);
    $ketua_rt  = mysqli_real_escape_string($koneksi, $_POST['ketua_rt']);
    $ketua_rw  = mysqli_real_escape_string($koneksi, $_POST['ketua_rw']);
    $urutan    = mysqli_real_escape_string($koneksi, $_POST['urutan']);
    $id_edit   = $_POST['id'] ?? '';

    if ($id_edit) {
        $sql = "UPDATE wilayah_desa SET rt='$rt', rw='$rw', dusun='$dusun', ketua_rt='$ketua_rt', ketua_rw='$ketua_rw', urutan='$urutan', updated_at=NOW() WHERE id='$id_edit'";
        $success = mysqli_query($koneksi, $sql) ? "Data berhasil diupdate" : "Gagal update data";
    } else {
        $sql = "INSERT INTO wilayah_desa (rt,rw,dusun,ketua_rt,ketua_rw,urutan,updated_at)
                VALUES ('$rt','$rw','$dusun','$ketua_rt','$ketua_rw','$urutan',NOW())";
        $success = mysqli_query($koneksi, $sql) ? "Data berhasil ditambahkan" : "Gagal menambah data";
    }
}

// ===================== PROSES HAPUS =====================
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM wilayah_desa WHERE id='$id'");
}

$data = mysqli_query($koneksi, "SELECT * FROM wilayah_desa ORDER BY urutan ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Peta Wilayah | Desa Sidomulyo</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<style>
body{font-family:'Poppins',sans-serif;background:#f1f8f4;padding-top:90px}
.navbar{background:rgba(255,255,255,.85);backdrop-filter:blur(8px);box-shadow:0 2px 10px rgba(0,0,0,.08)}
.navbar-brand{font-weight:600;color:#1b5e20}
.nav-link{color:#1b5e20}
.nav-link.active{font-weight:600;color:#2e7d32!important}
.page-title{font-weight:600;color:#1b5e20}
.card{border:0;border-radius:16px}
.card-header{background:#2e7d32;color:#fff;border-radius:16px 16px 0 0}
.btn-success{background:#2e7d32;border:0}
.btn-success:hover{background:#1b5e20}
.table thead{background:#c8e6c9}
.table th{white-space:nowrap}
</style>
</head>
<body>

<nav class="navbar navbar-expand-lg fixed-top">
  <div class="container">
    <a class="navbar-brand" href="index.php"><i class="fas fa-map"></i> Admin Desa</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link active" href="#">Wilayah</a></li>
        <li class="nav-item"><a class="nav-link" href="admin_statistik.php">Statistik</a></li>
        <li class="nav-item"><a class="nav-link" href="admin_profil.php">Profil</a></li>
        <li class="nav-item"><a class="nav-link" href="admin_administrasi.php">Administrasi</a></li>
        <li class="nav-item"><a class="nav-link" href="admin_berita.php">Berita</a></li>
        <li class="nav-item"><a class="nav-link" href="admin_saran.php">Kontak</a></li>
        <li class="nav-item"><a class="nav-link" href="peta.php">Kembali</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container">
  <h3 class="page-title mb-4"><i class="fas fa-location-dot"></i> Kelola Peta Wilayah Desa</h3>

  <?php if($success): ?>
    <div class="alert alert-success"><?= $success ?></div>
  <?php endif; ?>

  <div class="card shadow-sm mb-4">
    <div class="card-header"><i class="fas fa-plus"></i> Form Wilayah</div>
    <div class="card-body">
      <form method="POST">
        <input type="hidden" name="id" id="form_id">
        <div class="row g-3">
          <div class="col-md-2"><input type="text" name="rt" id="form_rt" class="form-control" placeholder="RT" required></div>
          <div class="col-md-2"><input type="text" name="rw" id="form_rw" class="form-control" placeholder="RW" required></div>
          <div class="col-md-3"><input type="text" name="dusun" id="form_dusun" class="form-control" placeholder="Dusun" required></div>
          <div class="col-md-2"><input type="text" name="ketua_rt" id="form_ketua_rt" class="form-control" placeholder="Ketua RT"></div>
          <div class="col-md-2"><input type="text" name="ketua_rw" id="form_ketua_rw" class="form-control" placeholder="Ketua RW"></div>
          <div class="col-md-1"><input type="number" name="urutan" id="form_urutan" class="form-control" placeholder="#" required></div>
        </div>
        <div class="mt-3">
          <button class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
          <button type="reset" onclick="resetForm()" class="btn btn-secondary"><i class="fas fa-rotate"></i> Reset</button>
        </div>
      </form>
    </div>
  </div>

  <div class="card shadow-sm">
    <div class="card-header"><i class="fas fa-table"></i> Data Wilayah</div>
    <div class="card-body table-responsive">
      <table class="table table-bordered align-middle">
        <thead>
          <tr>
            <th>RT</th><th>RW</th><th>Dusun</th><th>Ketua RT</th><th>Ketua RW</th><th>Urut</th><th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php while($r=mysqli_fetch_assoc($data)): ?>
          <tr>
            <td><?= $r['rt'] ?></td>
            <td><?= $r['rw'] ?></td>
            <td><?= $r['dusun'] ?></td>
            <td><?= $r['ketua_rt'] ?></td>
            <td><?= $r['ketua_rw'] ?></td>
            <td><?= $r['urutan'] ?></td>
            <td class="text-center">
              <button class="btn btn-success btn-sm" onclick='editData(<?= json_encode($r) ?>)'><i class="fas fa-edit"></i></button>
              <a href="?hapus=<?= $r['id'] ?>" onclick="return confirm('Hapus data ini?')" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
function editData(d){
  form_id.value=d.id;
  form_rt.value=d.rt;
  form_rw.value=d.rw;
  form_dusun.value=d.dusun;
  form_ketua_rt.value=d.ketua_rt;
  form_ketua_rw.value=d.ketua_rw;
  form_urutan.value=d.urutan;
}
function resetForm(){form_id.value='';}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
