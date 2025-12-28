<?php
$host = "localhost";
$user = "root"; // default Laragon
$pass = "";     // default Laragon
$db   = "db_kontak";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
