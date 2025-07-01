<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "gudang_madu";

$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}

if (!isset($_GET['id'])) {
    echo "<script>alert('ID madu tidak ditemukan!'); window.location='madu.php';</script>";
    exit();
}

$id = $_GET['id'];
$query = $mysqli->query("SELECT * FROM madu WHERE id_madu = $id");
$data = $query->fetch_assoc();

if (!$data) {
    echo "<script>alert('Data madu tidak ditemukan!'); window.location='madu.php';</script>";
    exit();
}

if (isset($_POST['submit'])) {
    $nama_madu = $_POST['nama_madu'];
    $jenis_madu = $_POST['jenis_madu'];
    $stok = $_POST['stok'];
    $harga_per_botol = $_POST['harga_per_botol'];

    $mysqli->query("UPDATE madu SET nama_madu='$nama_madu', jenis_madu='$jenis_madu', stok='$stok', harga_per_botol='$harga_per_botol' WHERE id_madu = $id");

    echo "<script>alert('Data madu berhasil diperbarui'); window.location='madu.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Madu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff9db;
        }
        .container {
            width: 60%;
            margin: 30px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px #ccc;
        }
        h2 {
            text-align: center;
            color: #f39c12;
        }
        form label {
            display: block;
            margin-top: 15px;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        input[readonly] {
            background-color: #f4f4f4;
        }
        button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #27ae60;
            color: white;
            border: none;
            border-radius: 5px;
        }
        button:hover {
            background-color: #219150;
        }
        a.btn-kembali {
            display: inline-block;
            margin-top: 20px;
            background-color: #3498db;
            padding: 8px 16px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        a.btn-kembali:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Data Madu</h2>
        <form method="POST">
            <label>ID Madu:</label>
            <input type="text" value="<?= $data['id_madu'] ?>" readonly>

            <label>Nama Madu:</label>
            <input type="text" name="nama_madu" value="<?= $data['nama_madu'] ?>" required>

            <label>Jenis Madu:</label>
            <input type="text" name="jenis_madu" value="<?= $data['jenis_madu'] ?>" required>

            <label>Stok (botol):</label>
            <input type="number" name="stok" value="<?= $data['stok'] ?>" required>

            <label>Harga per Botol (Rp):</label>
            <input type="number" name="harga_per_botol" value="<?= $data['harga_per_botol'] ?>" required>

            <button type="submit" name="submit">Simpan Perubahan</button>
        </form>
        <a class="btn-kembali" href="madu.php">← Kembali ke Data Madu</a>
    </div>
</body>
</html>