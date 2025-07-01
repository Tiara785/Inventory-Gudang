<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "gudang_madu";

$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}

if (isset($_POST['submit'])) {
    $nama_pelanggan = trim($_POST['nama_pelanggan']);
    $id_madu = $_POST['id_madu'];
    $jumlah = $_POST['jumlah'];
    $keterangan = $mysqli->real_escape_string($_POST['keterangan']);

    // Cek apakah pelanggan sudah ada
    $cekPelanggan = $mysqli->query("SELECT id_pelanggan FROM pelanggan WHERE nama_pelanggan = '$nama_pelanggan'");
    if ($cekPelanggan->num_rows > 0) {
        $id_pelanggan = $cekPelanggan->fetch_assoc()['id_pelanggan'];
    } else {
        $mysqli->query("INSERT INTO pelanggan (nama_pelanggan) VALUES ('$nama_pelanggan')");
        $id_pelanggan = $mysqli->insert_id;
    }

    // Ambil data madu
    $getHarga = $mysqli->query("SELECT harga_per_botol, stok FROM madu WHERE id_madu = $id_madu");
    $maduData = $getHarga->fetch_assoc();
    $harga = $maduData['harga_per_botol'];
    $stokSekarang = $maduData['stok'];

    if ($stokSekarang < $jumlah) {
        echo "<script>alert('Stok madu tidak mencukupi!'); window.location='" . $_SERVER['PHP_SELF'] . "';</script>";
        exit();
    }

    $total_harga = $harga * $jumlah;

    // Simpan transaksi
    $mysqli->query("INSERT INTO transaksi (tanggal, id_pelanggan, id_madu, jumlah, total, keterangan) 
                    VALUES (NOW(), '$id_pelanggan', '$id_madu', '$jumlah', '$total_harga', '$keterangan')");

    // Kurangi stok madu
    $mysqli->query("UPDATE madu SET stok = stok - $jumlah WHERE id_madu = $id_madu");

    // Catat stok keluar
    $mysqli->query("INSERT INTO stok_keluar (id_madu, jumlah, tanggal, keterangan) 
                    VALUES ('$id_madu', '$jumlah', NOW(), '$keterangan')");

    echo "<script>alert('Transaksi berhasil ditambahkan'); window.location='" . $_SERVER['PHP_SELF'] . "';</script>";
}

// Ambil data madu
$madu = $mysqli->query("SELECT * FROM madu");

// Ambil data transaksi
$data_transaksi = $mysqli->query("
    SELECT t.id_transaksi, t.tanggal, p.nama_pelanggan, m.nama_madu, t.jumlah, t.total, t.keterangan
    FROM transaksi t
    JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan
    JOIN madu m ON t.id_madu = m.id_madu
    ORDER BY t.id_transaksi DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff9db;
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
            color: black;
        }
        h2, h3 {
            text-align: center;
            margin-top: 20px;
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
        input, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            padding: 10px 20px;
            background-color: #27ae60;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 14px;
        }
        button:hover {
            background-color: #219150;
        }
    </style>
</head>
<body>
    <div style="text-align: center; margin-top: 10px;">
        <a href="index.php">
            <button style="background-color: #3498db; color: white; border: none; padding: 10px 20px; border-radius: 5px;">
                Dashboard
            </button>
        </a>
    </div>

    <h2>Riwayat Transaksi Penjualan Madu</h2>

    <form method="POST">
        <h3>Tambah Transaksi</h3>

        <label>Nama Pelanggan</label>
        <input type="text" name="nama_pelanggan" required>

        <label>Nama Madu</label>
        <select name="id_madu" required>
            <option value="">-- Pilih Madu --</option>
            <?php while ($m = $madu->fetch_assoc()) { ?>
                <option value="<?= $m['id_madu'] ?>"><?= $m['nama_madu'] ?></option>
            <?php } ?>
        </select>

        <label>Jumlah</label>
        <input type="number" name="jumlah" required>

        <label>Keterangan</label>
        <input type="text" name="keterangan" required>

        <button type="submit" name="submit">Tambah Transaksi</button>
    </form>

    <table>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Nama Pelanggan</th>
            <th>Nama Madu</th>
            <th>Jumlah</th>
            <th>Total</th>
            <th>Keterangan</th>
        </tr>
        <?php
        $no = 1;
        while ($row = $data_transaksi->fetch_assoc()) { ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['tanggal'] ?></td>
                <td><?= $row['nama_pelanggan'] ?></td>
                <td><?= $row['nama_madu'] ?></td>
                <td><?= $row['jumlah'] ?></td>
                <td>Rp<?= number_format($row['total'], 0, ',', '.') ?></td>
                <td><?= $row['keterangan'] ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>