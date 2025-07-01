<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "gudang_madu";

$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}

// Proses simpan stok masuk
if (isset($_POST['submit'])) {
    $nama_madu = trim($_POST['nama_madu']);
    $jumlah = $_POST['jumlah'];
    $keterangan = trim($_POST['keterangan']);

    // Cari id_madu berdasarkan nama_madu
    $nama_madu = trim($_POST['nama_madu']);
$result = $mysqli->query("SELECT id_madu FROM madu WHERE LOWER(TRIM(nama_madu)) = LOWER('$nama_madu')");

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id_madu = $row['id_madu'];

        // Tambahkan stok masuk
        $mysqli->query("INSERT INTO stok_masuk (id_madu, jumlah, tanggal, keterangan) VALUES ('$id_madu', '$jumlah', NOW(), '$keterangan')");

        // Tambah ke stok madu
        $mysqli->query("UPDATE madu SET stok = stok + $jumlah WHERE id_madu = $id_madu");

        echo "<script>alert('Stok masuk berhasil ditambahkan'); window.location='" . $_SERVER['PHP_SELF'] . "';</script>";
    } else {
        echo "<script>alert('Nama madu tidak ditemukan! Pastikan nama madu sesuai.');</script>";
    }
}

// Ambil data stok masuk
$query = "SELECT sm.id_masuk, sm.tanggal, m.nama_madu, sm.jumlah, sm.keterangan
          FROM stok_masuk sm
          JOIN madu m ON sm.id_madu = m.id_madu
          ORDER BY sm.id_masuk ASC";
$result = $mysqli->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Stok Masuk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }
        h2, h3 {
            text-align: center;
        }
        form {
            width: 90%;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 8px #ccc;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input, textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            padding: 10px 20px;
            background-color: #27ae60;
            color: white;
            border: none;
            border-radius: 5px;
        }
        button:hover {
            background-color: #219150;
        }
        .top-buttons {
            width: 90%;
            margin: 20px auto;
            text-align: right;
        }
        .top-buttons a {
            background-color: #3498db;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            margin-left: 10px;
        }
        .top-buttons a.tambah {
            background-color: #27ae60;
        }
        table {
            width: 90%;
            margin: 30px auto;
            border-collapse: collapse;
            background-color: white;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #f2c94c;
        }
    </style>
</head>
<body>

<div class="top-buttons">
    <a href="index.php">Dashboard</a>
    <a href="#formTambah" class="tambah">+ Tambah Stok Masuk</a>
</div>

<h2>Riwayat Stok Masuk Madu</h2>

<!-- Form Tambah -->
<form method="POST" id="formTambah">
    <h3>Tambah Stok Masuk</h3>

    <label for="nama_madu">Masukkan Nama Madu:</label>
    <input type="text" name="nama_madu" placeholder="Contoh: Madu Randu" required>

    <label for="jumlah">Jumlah Masuk:</label>
    <input type="number" name="jumlah" required>

    <label for="keterangan">Keterangan:</label>
    <textarea name="keterangan" rows="2" placeholder="Contoh: Tambahan stok dari petani A" required></textarea>

    <button type="submit" name="submit">Tambah</button>
</form>

<!-- Tabel Riwayat -->
<table>
    <tr>
        <th>No</th>
        <th>Tanggal</th>
        <th>Nama Madu</th>
        <th>Jumlah Masuk</th>
        <th>Keterangan</th>
    </tr>
    <?php 
    $no = 1;
    while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $row['tanggal'] ?></td>
            <td><?= $row['nama_madu'] ?></td>
            <td><?= $row['jumlah'] ?></td>
            <td><?= $row['keterangan'] ?></td>
        </tr>
    <?php } ?>
</table>

</body>
</html>