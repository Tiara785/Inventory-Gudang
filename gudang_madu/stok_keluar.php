<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "gudang_madu";

$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}

// Ambil data madu untuk dropdown
$madu = $mysqli->query("SELECT * FROM madu");

// Menyimpan data stok keluar manual
if (isset($_POST['submit'])) {
    $id_madu = $_POST['id_madu'];
    $jumlah = $_POST['jumlah'];
    $keterangan = $_POST['keterangan'];

    // Kurangi stok madu
    $mysqli->query("UPDATE madu SET stok = stok - $jumlah WHERE id_madu = $id_madu");

    // Simpan ke stok_keluar
    $mysqli->query("INSERT INTO stok_keluar (id_madu, jumlah, tanggal, keterangan) VALUES ('$id_madu', '$jumlah', NOW(), '$keterangan')");

    echo "<script>alert('Stok keluar berhasil ditambahkan!'); window.location='" . $_SERVER['PHP_SELF'] . "';</script>";
}

// Ambil riwayat stok keluar
$stok_keluar = $mysqli->query("SELECT sk.*, m.nama_madu 
                               FROM stok_keluar sk
                               JOIN madu m ON sk.id_madu = m.id_madu
                               ORDER BY sk.id_keluar DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Stok Keluar</title>
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
        input, select, textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            padding: 10px 20px;
            background-color: #e67e22;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 14px;
        }
        button:hover {
            background-color: #d35400;
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

    <h2>Data Stok Keluar Madu</h2>

    <form method="POST">
        <h3>Tambah Stok Keluar Manual</h3>

        <label for="id_madu">Pilih Madu:</label>
        <select name="id_madu" required>
            <option value="">-- Pilih Madu --</option>
            <?php while ($row = $madu->fetch_assoc()) { ?>
                <option value="<?= $row['id_madu'] ?>"><?= $row['nama_madu'] ?></option>
            <?php } ?>
        </select>

        <label for="jumlah">Jumlah:</label>
        <input type="number" name="jumlah" min="1" required>

        <label for="keterangan">Keterangan:</label>
        <textarea name="keterangan" rows="3" placeholder="Contoh: Barang rusak, kadaluarsa, dll." required></textarea>

        <button type="submit" name="submit">Simpan</button>
    </form>

    <table>
        <tr>
            <th>No</th>
            <th>Nama Madu</th>
            <th>Jumlah</th>
            <th>Tanggal</th>
            <th>Keterangan</th>
        </tr>
        <?php $no = 1; while ($row = $stok_keluar->fetch_assoc()) { ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $row['nama_madu'] ?></td>
            <td><?= $row['jumlah'] ?></td>
            <td><?= $row['tanggal'] ?></td>
            <td><?= $row['keterangan'] ?></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>