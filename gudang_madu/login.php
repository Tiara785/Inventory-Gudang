<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $result = $koneksi->query("SELECT * FROM user WHERE username='$username' AND password='$password'");
    if ($result->num_rows > 0) {
        $_SESSION['login'] = true;
        header("Location: index.php");
    } else {
        $pesan = "<div class='alert alert-danger'>Login gagal!</div>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Gudang Madu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('https://images.unsplash.com/photo-1609325171555-7373f2e08c03'); 
            background-size: cover;
            background-position: center;
        }
        .login-card {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.85);
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 login-card shadow-lg" style="width: 22rem;">
        <h4 class="text-center mb-4">Login Gudang Madu</h4>
        <?php if (!empty($pesan)) echo $pesan; ?>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-warning w-100">Login</button>
            <div class="text-center mt-3">
                <a href="register.php" class="text-decoration-none"></a>
            </div>
        </form>
    </div>
</body>
</html>