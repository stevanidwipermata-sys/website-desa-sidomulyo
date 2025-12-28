 <?php

include "config.php";

$success = "";
$error = "";

$data = mysqli_query($koneksi, "SELECT * FROM kependudukan ORDER BY id DESC LIMIT 1");
$row = mysqli_fetch_assoc($data);
$id = $row['id'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $total_penduduk    = $_POST['total_penduduk'];
    $laki_laki         = $_POST['laki_laki'];
    $perempuan         = $_POST['perempuan'];
    $kepala_keluarga   = $_POST['kepala_keluarga'];
    $petani            = $_POST['petani'];
    $pedagang          = $_POST['pedagang'];
    $pegawai_swasta    = $_POST['pegawai_swasta'];
    $pns               = $_POST['pns'];
    $buruh             = $_POST['buruh'];
    $ibu_rumah_tangga  = $_POST['ibu_rumah_tangga'];

    if($id){
        $sql = "UPDATE kependudukan SET 
                total_penduduk='$total_penduduk', laki_laki='$laki_laki', perempuan='$perempuan', kepala_keluarga='$kepala_keluarga',
                petani='$petani', pedagang='$pedagang', pegawai_swasta='$pegawai_swasta', pns='$pns', buruh='$buruh', ibu_rumah_tangga='$ibu_rumah_tangga',
                updated_at=NOW() WHERE id='$id'";
    } else {
        $sql = "INSERT INTO kependudukan
                (total_penduduk, laki_laki, perempuan, kepala_keluarga, petani, pedagang, pegawai_swasta, pns, buruh, ibu_rumah_tangga, updated_at)
                VALUES ('$total_penduduk', '$laki_laki', '$perempuan', '$kepala_keluarga', '$petani', '$pedagang', '$pegawai_swasta', '$pns', '$buruh', '$ibu_rumah_tangga', NOW())";
    }

    if(mysqli_query($koneksi, $sql)){
        $success = "Data berhasil disimpan!";
        header("Location: admin_administrasi.php"); exit;
    } else {
        $error = "Error: ".mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Administrasi | Desa Sidomulyo</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<style>
body { font-family:'Poppins',sans-serif; padding-top:80px; background:#e8f5e9; }
.navbar { backdrop-filter:blur(10px); background:rgba(255,255,255,0.2); box-shadow:0 2px 10px rgba(0,0,0,0.1); }
.navbar .nav-link { color:#1B5E20; margin-right:0.5rem; }
.navbar .nav-link.active { color:#66bb6a !important; }
.card { border-radius:12px; }
.form-label small { color:#555; font-weight:400; }
.section-title { color:#1B5E20; font-weight:600; margin-bottom:1rem; }
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
        <li class="nav-item"><a class="nav-link active" href="#">Administrasi</a></li>
        <li class="nav-item"><a class="nav-link" href="admin_statistik.php">Statistik</a></li>
        <li class="nav-item"><a class="nav-link" href="admin_profil.php">Profil</a></li>
        <li class="nav-item"><a class="nav-link" href="admin_peta.php">Peta</a></li>
        <li class="nav-item"><a class="nav-link" href="admin_berita.php">Berita</a></li>
        <li class="nav-item"><a class="nav-link" href="admin_saran.php">Kontak</a></li>
        <li class="nav-item"><a class="nav-link" href="administrasi.php">Kembali</a></li>
    </ul>
</div>
</div>
</nav>

<div class="container my-5">
<h2 class="section-title">Kelola Data Kependudukan</h2>

<?php if($success): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>
<?php if($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>

<div class="card p-4 shadow-sm">
<form method="POST">
    <div class="row g-3">
        <div class="col-md-3">
            <label class="form-label">Total Penduduk <small>(Jumlah keseluruhan penduduk)</small></label>
            <input type="number" name="total_penduduk" class="form-control" required value="<?= $row['total_penduduk'] ?? 0 ?>">
        </div>
        <div class="col-md-3">
            <label class="form-label">Laki-laki <small>(Jumlah penduduk laki-laki)</small></label>
            <input type="number" name="laki_laki" class="form-control" required value="<?= $row['laki_laki'] ?? 0 ?>">
        </div>
        <div class="col-md-3">
            <label class="form-label">Perempuan <small>(Jumlah penduduk perempuan)</small></label>
            <input type="number" name="perempuan" class="form-control" required value="<?= $row['perempuan'] ?? 0 ?>">
        </div>
        <div class="col-md-3">
            <label class="form-label">Kepala Keluarga <small>(Jumlah kepala keluarga)</small></label>
            <input type="number" name="kepala_keluarga" class="form-control" required value="<?= $row['kepala_keluarga'] ?? 0 ?>">
        </div>

        <div class="col-md-2">
            <label class="form-label">Petani <small>(Penduduk bekerja sebagai petani)</small></label>
            <input type="number" name="petani" class="form-control" value="<?= $row['petani'] ?? 0 ?>">
        </div>
        <div class="col-md-2">
            <label class="form-label">Pedagang <small>(Penduduk bekerja sebagai pedagang)</small></label>
            <input type="number" name="pedagang" class="form-control" value="<?= $row['pedagang'] ?? 0 ?>">
        </div>
        <div class="col-md-2">
            <label class="form-label">Pegawai Swasta <small>(Penduduk bekerja di perusahaan swasta)</small></label>
            <input type="number" name="pegawai_swasta" class="form-control" value="<?= $row['pegawai_swasta'] ?? 0 ?>">
        </div>
        <div class="col-md-2">
            <label class="form-label">PNS <small>(Penduduk bekerja sebagai PNS)</small></label>
            <input type="number" name="pns" class="form-control" value="<?= $row['pns'] ?? 0 ?>">
        </div>
        <div class="col-md-2">
            <label class="form-label">Buruh <small>(Penduduk bekerja sebagai buruh)</small></label>
            <input type="number" name="buruh" class="form-control" value="<?= $row['buruh'] ?? 0 ?>">
        </div>
        <div class="col-md-2">
            <label class="form-label">Ibu Rumah Tangga <small>(Penduduk yang mengurus rumah tangga)</small></label>
            <input type="number" name="ibu_rumah_tangga" class="form-control" value="<?= $row['ibu_rumah_tangga'] ?? 0 ?>">
        </div>
    </div>
    <button type="submit" class="btn btn-success mt-3"><i class="fas fa-save"></i> Simpan Perubahan</button>
</form>
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
