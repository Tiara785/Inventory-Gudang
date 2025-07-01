<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $telepon = $_POST['telepon'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    // Cek apakah username atau email sudah digunakan
    $cek = $koneksi->query("SELECT * FROM user WHERE username='$username' OR email='$email'");
    if ($cek->num_rows > 0) {
        $pesan = "<div class='alert alert-warning'>Username atau Email sudah digunakan!</div>";
    } else {
        $koneksi->query("INSERT INTO user (nama, email, telepon, username, password) VALUES ('$nama', '$email', '$telepon', '$username', '$password')");
        $pesan = "<div class='alert alert-success'>Registrasi berhasil. <a href='login.php'>Login</a></div>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register - Gudang Madu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('https://images.unsplash.com/photo-1560807707-8cc77767d783');
            background-size: cover;
            background-position: center;
        }
        .register-card {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.85);
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 register-card shadow-lg" style="width: 25rem;">
        <h4 class="text-center mb-4">Register Akun Baru</h4>
        <?php if (!empty($pesan)) echo $pesan; ?>
        <form method="post">
            <div class="mb-2">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="mb-2">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-2">
                <label class="form-label">Telepon</label>
                <input type="text" name="telepon" class="form-control" required>
            </div>
            <div class="mb-2">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-2">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Daftar</button>
            <div class="text-center mt-3">
                <a href="login.php" class="text-decoration-none">Sudah punya akun?</a>
            </div>
        </form>
    </div>
</body>
</html>