<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Gudang Madu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom, #ffffff, #f8f9fa);
            font-family: 'Segoe UI', sans-serif;
        }
        .dashboard-box {
            background-color: #4a4a4a;
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            color: white;
            box-shadow: 0px 10px 30px rgba(0,0,0,0.2);
            margin-top: 100px;
        }
        .dashboard-box h2 {
            font-weight: bold;
            margin-bottom: 30px;
        }
        .btn-custom {
            font-weight: bold;
            width: 180px;
            padding: 10px;
            margin: 10px;
            border-radius: 10px;
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center">
    <div class="dashboard-box col-md-8">
        <h2>🧁 Sistem Inventory Gudang Madu</h2>
        <div class="d-flex justify-content-center flex-wrap">
            <a href="madu.php" class="btn btn-warning btn-custom">📦 Manajemen Madu</a>
            <a href="transaksi.php" class="btn btn-success btn-custom">💰 Transaksi</a>
            <a href="stok_masuk.php" class="btn btn-primary btn-custom">📥 Stok Masuk</a> <!-- ✅ Tombol baru -->
            <a href="stok_keluar.php" class="btn btn-danger btn-custom">📤 Stok Keluar</a>
            <a href="logout.php" class="btn btn-secondary btn-custom">🚪 Logout</a>
        </div>
    </div>
</div>

</body>
</html>