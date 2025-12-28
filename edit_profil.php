<?php
include "config.php";
$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM profil_desa WHERE id='$id'"));

if(isset($_POST['submit'])){
    $kategori = $_POST['kategori'];
    $sub_kategori = $_POST['sub_kategori'];
    $judul = $_POST['judul'];
    $konten = $_POST['konten'];
    $urutan = $_POST['urutan'];

    $gambar = $data['gambar'];
    if(isset($_FILES['gambar']) && $_FILES['gambar']['name'] != ""){
        $target_dir = "uploads/";
        if(!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        $gambar = $target_dir . basename($_FILES["gambar"]["name"]);
        move_uploaded_file($_FILES["gambar"]["tmp_name"], $gambar);
    }

    mysqli_query($koneksi,"UPDATE profil_desa SET kategori='$kategori', sub_kategori='$sub_kategori', judul='$judul', konten='$konten', gambar='$gambar', urutan='$urutan' WHERE id='$id'") or die(mysqli_error($koneksi));
    header("Location: admin_profil.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Konten Profil</title>
</head>
<body>
<h2>Edit Konten Profil Desa</h2>
<form method="post" enctype="multipart/form-data">
<label>Kategori:</label><br>
<input type="text" name="kategori" value="<?= $data['kategori'] ?>" required><br>
<label>Sub Kategori:</label><br>
<input type="text" name="sub_kategori" value="<?= $data['sub_kategori'] ?>"><br>
<label>Judul:</label><br>
<input type="text" name="judul" value="<?= $data['judul'] ?>" required><br>
<label>Konten:</label><br>
<textarea name="konten" rows="6"><?= $data['konten'] ?></textarea><br>
<label>Gambar:</label><br>
<input type="file" name="gambar"><br>
<?php if($data['gambar']) echo "<img src='".$data['gambar']."' width='80'>"; ?><br>
<label>Urutan:</label><br>
<input type="number" name="urutan" value="<?= $data['urutan'] ?>"><br><br>
<input type="submit" name="submit" value="Update">
</form>
</body>
</html>
