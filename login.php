<?php 
include "config.php"; 
session_start(); 

// Ambil halaman tujuan tanpa query GET
$redirect = isset($_GET['page']) ? basename($_GET['page']) : 'admin_profil.php';

// Pastikan redirect selalu berupa filename valid
if (!str_ends_with($redirect, ".php")) {
    $redirect .= ".php";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to bottom, #a8e6a3, #4caf50);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
        }
        .card {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }
        .btn-green {
            background-color: #4caf50;
            color: white;
        }
        .btn-green:hover {
            background-color: #45a049;
        }
        h2 {
            color: #2e7d32;
            margin-bottom: 25px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="card col-md-4">
    <h2>Login Admin</h2>

    <form method="POST">
        <div class="mb-3">
            <input type="text" name="username" class="form-control" placeholder="Username" required>
        </div>

        <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>

        <!-- Kirim ulang halaman tujuan -->
        <input type="hidden" name="redirect" value="<?= $redirect ?>">

        <div class="d-grid">
            <button type="submit" name="login" class="btn btn-green">Login</button>
        </div>
    </form>

    <?php
    if (isset($_POST['login'])) {
        $user = $_POST['username'];
        $pass = $_POST['password'];
        $to = basename($_POST['redirect']); // menjaga agar path tetap benar

        $query = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$user'");
        $data = mysqli_fetch_assoc($query);

        if ($data && password_verify($pass, $data['password'])) {
            $_SESSION['admin'] = $data['username'];

            // Redirect langsung ke file tujuan tanpa query
            header("Location: $to");
            exit;
        } else {
            echo '<div class="alert alert-danger mt-3 text-center">Username atau password salah!</div>';
        }
    }
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
