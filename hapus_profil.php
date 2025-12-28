<?php
include "config.php";
$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM profil_desa WHERE id='$id'"));

// Hapus gambar jika ada
if($data['gambar'] && file_exists($data['gambar'])){
    unlink($data['gambar']);
}

mysqli_query($koneksi,"DELETE FROM profil_desa WHERE id='$id'");
header("Location: admin_profil.php");
?>
