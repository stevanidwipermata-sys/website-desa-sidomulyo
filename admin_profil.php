<?php
include "config.php";
$success = "";

/* ===================== SIMPAN (TAMBAH / EDIT) ===================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id          = $_POST['id'] ?? '';
    $kategori    = mysqli_real_escape_string($koneksi, $_POST['kategori'] ?? '');
    $sub         = mysqli_real_escape_string($koneksi, $_POST['sub_kategori'] ?? '');
    $judul       = mysqli_real_escape_string($koneksi, $_POST['judul'] ?? '');
    $konten      = mysqli_real_escape_string($koneksi, $_POST['konten'] ?? '');
    $nama        = mysqli_real_escape_string($koneksi, $_POST['nama'] ?? '');
    $ket         = mysqli_real_escape_string($koneksi, $_POST['keterangan'] ?? '');
    $urutan      = (int)($_POST['urutan'] ?? 0);
    $gambar_lama = $_POST['gambar_lama'] ?? '';

    /* upload gambar */
    $gambar = $gambar_lama;
    if (!empty($_FILES['gambar']['name'])) {
        if (!is_dir("uploads")) mkdir("uploads",0777,true);
        $file = time().'_'.basename($_FILES['gambar']['name']);
        move_uploaded_file($_FILES['gambar']['tmp_name'], "uploads/".$file);
        $gambar = "uploads/".$file;
    }

    if ($id) {
        mysqli_query($koneksi, "UPDATE profil_desa SET
            kategori='$kategori',
            sub_kategori='$sub',
            judul='$judul',
            konten='$konten',
            nama='$nama',
            keterangan='$ket',
            gambar='$gambar',
            urutan='$urutan',
            updated_at=NOW()
            WHERE id='$id'
        ");
        $success = "Data berhasil diperbarui";
    } else {
        mysqli_query($koneksi, "INSERT INTO profil_desa
        (kategori,sub_kategori,judul,konten,nama,keterangan,gambar,urutan,updated_at)
        VALUES
        ('$kategori','$sub','$judul','$konten','$nama','$ket','$gambar','$urutan',NOW())");
        $success = "Data berhasil ditambahkan";
    }
}

/* ===================== HAPUS ===================== */
if (isset($_GET['hapus'])) {
    mysqli_query($koneksi, "DELETE FROM profil_desa WHERE id=".(int)$_GET['hapus']);
    $success = "Data berhasil dihapus";
}

/* ===================== DATA ===================== */
$data = mysqli_query($koneksi, "SELECT * FROM profil_desa ORDER BY urutan ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Profil Desa</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

<style>
body{
    background:#e8f5e9;
    padding-top:80px;
}
.card{
    border-radius:14px;
}
.preview{
    max-width:120px;
    border-radius:8px;
    margin-top:6px;
}
.navbar{
    background:rgba(255,255,255,.9);
    backdrop-filter:blur(10px);
}
.nav-link{
    font-weight:500;
}
.nav-link.active{
    font-weight:600;
}
</style>
</head>
<body>

<!-- ===================== NAVBAR ===================== -->
<nav class="navbar navbar-expand-lg fixed-top shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-semibold" href="admin_profil.php">
        <i class="fa fa-seedling"></i> Admin Desa
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navAdmin">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navAdmin">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link active" href="#">Profil Desa</a></li>
        <li class="nav-item"><a class="nav-link" href="admin_statistik.php">Statistik</a></li>
        <li class="nav-item"><a class="nav-link" href="admin_peta.php">Peta</a></li>
        <li class="nav-item"><a class="nav-link" href="admin_administrasi.php">Administrasi</a></li>
        <li class="nav-item"><a class="nav-link" href="admin_berita.php">Berita</a></li>
        <li class="nav-item"><a class="nav-link" href="admin_saran.php">Kontak</a></li>
        <li class="nav-item"><a class="nav-link" href="profil.php">Kembali</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- ===================== KONTEN ===================== -->
<div class="container">

<h3 class="mb-4">Kelola Profil Desa</h3>

<?php if($success): ?>
<div class="alert alert-success"><?= $success ?></div>
<?php endif; ?>

<div class="card p-4 mb-4 shadow-sm">
<form method="post" enctype="multipart/form-data">
<input type="hidden" name="id" id="id">
<input type="hidden" name="gambar_lama" id="gambar_lama">

<div class="row g-3">

<div class="col-md-3">
<select name="kategori" id="kategori" class="form-select" required onchange="toggleField()">
<option value="">-- Kategori --</option>
<option value="visi">Visi</option>
<option value="misi">Misi</option>
<option value="geo">Geografis</option>
<option value="struktur">Struktur Desa</option>
<option value="sambutan_kades">Sambutan Kades</option>
</select>
</div>

<div class="col-md-3" id="sub_wrap" style="display:none">
<input type="text" name="sub_kategori" id="sub_kategori" class="form-control" placeholder="Sub / Jabatan">
</div>

<div class="col-md-3 normal">
<input type="text" name="judul" id="judul" class="form-control" placeholder="Judul">
</div>

<div class="col-md-3 struktur" style="display:none">
<input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Pejabat">
</div>

<div class="col-md-3 struktur" style="display:none">
<input type="text" name="keterangan" id="keterangan" class="form-control" placeholder="Jabatan">
</div>

<div class="col-md-2">
<input type="number" name="urutan" id="urutan" class="form-control" placeholder="Urut">
</div>

<div class="col-md-12 normal">
<textarea name="konten" id="konten" rows="4" class="form-control" placeholder="Isi Konten"></textarea>
</div>

<div class="col-md-6">
<input type="file" name="gambar" class="form-control">
<div id="preview"></div>
</div>

</div>

<button class="btn btn-success mt-3">
<i class="fa fa-save"></i> Simpan
</button>
</form>
</div>

<div class="card p-4 shadow-sm">
<table class="table table-bordered align-middle">
<thead class="table-success">
<tr>
<th>Kategori</th>
<th>Isi</th>
<th>Gambar</th>
<th>Urut</th>
<th width="120">Aksi</th>
</tr>
</thead>
<tbody>
<?php while($r=mysqli_fetch_assoc($data)): ?>
<tr>
<td><?= $r['kategori'] ?></td>
<td>
<?php if($r['kategori']=='struktur'): ?>
<strong><?= $r['nama'] ?></strong><br>
<small><?= $r['keterangan'] ?></small>
<?php else: ?>
<strong><?= $r['judul'] ?></strong>
<?php endif; ?>
</td>
<td><?= $r['gambar'] ? "<img src='$r[gambar]' width='60'>" : "-" ?></td>
<td><?= $r['urutan'] ?></td>
<td>
<button class="btn btn-success btn-sm" onclick='editData(<?= json_encode($r) ?>)'>
<i class="fa fa-edit"></i>
</button>
<a href="?hapus=<?= $r['id'] ?>" class="btn btn-danger btn-sm"
onclick="return confirm('Hapus data?')">
<i class="fa fa-trash"></i>
</a>
</td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</div>

</div>

<script>
function toggleField(){
    const k = kategori.value;
    document.querySelectorAll('.struktur').forEach(e=>e.style.display='none');
    document.querySelectorAll('.normal').forEach(e=>e.style.display='block');
    sub_wrap.style.display = (k==='struktur'||k==='geo')?'block':'none';

    if(k==='struktur'){
        document.querySelectorAll('.struktur').forEach(e=>e.style.display='block');
        document.querySelectorAll('.normal').forEach(e=>e.style.display='none');
    }
}

function editData(d){
    id.value=d.id;
    kategori.value=d.kategori;
    toggleField();
    sub_kategori.value=d.sub_kategori||'';
    judul.value=d.judul||'';
    konten.value=d.konten||'';
    nama.value=d.nama||'';
    keterangan.value=d.keterangan||'';
    urutan.value=d.urutan||0;
    gambar_lama.value=d.gambar||'';
    preview.innerHTML=d.gambar?`<img src="${d.gambar}" class="preview">`:'';
    scrollTo({top:0,behavior:'smooth'});
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
