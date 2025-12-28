<?php include "config.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Registrasi Admin</title>
</head>
<body>
<h2>Form Registrasi</h2>

<form method="POST">
    <input type="text" name="username" placeholder="Username" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit" name="daftar">Daftar</button>
</form>

<?php
if (isset($_POST['daftar'])) {
    $user = $_POST['username'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO admin (username, password) VALUES ('$user', '$pass')";
    if (mysqli_query($koneksi, $sql)) {
        echo "Registrasi berhasil!";
    } else {
        echo "Gagal: " . mysqli_error($koneksi);
    }
}
?>
</body>
</html>
