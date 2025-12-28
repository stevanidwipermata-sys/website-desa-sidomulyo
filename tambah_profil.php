<?php
include "config.php";

if (isset($_POST['submit'])) {
    $kategori      = mysqli_real_escape_string($koneksi, $_POST['kategori'] ?? '');
    $sub_kategori  = mysqli_real_escape_string($koneksi, $_POST['sub_kategori'] ?? '');
    $judul         = mysqli_real_escape_string($koneksi, $_POST['judul'] ?? '');
    $konten        = mysqli_real_escape_string($koneksi, $_POST['konten'] ?? '');
    $urutan        = (int)($_POST['urutan'] ?? 0);

    // Upload gambar
    $gambar = '';
    if (!empty($_FILES['gambar']['name'])) {
        $folder = "uploads/";
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        $nama_file = time() . "_" . basename($_FILES['gambar']['name']);
        $path = $folder . $nama_file;

        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $path)) {
            $gambar = $path;
        }
    }

    $query = "INSERT INTO profil_desa 
        (kategori, sub_kategori, judul, konten, gambar, urutan) 
        VALUES 
        ('$kategori','$sub_kategori','$judul','$konten','$gambar','$urutan')";

    mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));

    header("Location: admin_profil.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Profil Desa</title>
</head>
<body>

<h2>Tambah Profil Desa</h2>

<form method="post" enctype="multipart/form-data">
    <label>Kategori</label><br>
    <input type="text" name="kategori" required><br><br>

    <label>Sub Kategori</label><br>
    <input type="text" name="sub_kategori"><br><br>

    <label>Judul</label><br>
    <input type="text" name="judul" required><br><br>

    <label>Konten</label><br>
    <textarea name="konten" rows="6"></textarea><br><br>

    <label>Gambar</label><br>
    <input type="file" name="gambar"><br><br>

    <label>Urutan</label><br>
    <input type="number" name="urutan" value="0"><br><br>

    <button type="submit" name="submit">Simpan</button>
    <a href="admin_profil.php">Batal</a>
</form>

</body>
</html>
