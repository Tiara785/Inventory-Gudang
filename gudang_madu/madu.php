<?php
// Koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "gudang_madu";

$mysqli = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($mysqli->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}

// Ambil data dari tabel madu
$query = "SELECT * FROM madu";
$result = $mysqli->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Madu</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #fefee0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            margin-top: 30px;
            color: #333;
        }

        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background: #fffdf7;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }

        th, td {
            border: 1px solid #aaa;
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #f2c94c;
        }

        a.button {
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 5px;
            font-weight: bold;
            color: white;
            margin-right: 5px;
        }

        .tambah, .dashboard {
            background-color: #27ae60;
            margin: 10px auto;
            display: inline-block;
        }

        .edit {
            background-color: #3498db;
        }

        .hapus {
            background-color: #e74c3c;
        }

        .edit:hover {
            background-color: #2c80b4;
        }

        .hapus:hover {
            background-color: #c0392b;
        }

        .tambah:hover, .dashboard:hover {
            background-color: #219150;
        }

        .button-group {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <h2>Data Madu di Gudang</h2>
    
    <div class="button-group">
        <a class="button dashboard" href="index.php">🏠 Dashboard</a>
        <a class="button tambah" href="tambah_madu.php">+ Tambah Madu</a>
    </div>

    <table>
        <tr>
            <th>ID</th>
            <th>Nama Madu</th>
            <th>Jenis Madu</th>
            <th>Harga per Botol</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['id_madu'] ?></td>
                <td><?= $row['nama_madu'] ?></td>
                <td><?= $row['jenis_madu'] ?></td>
                <td>Rp<?= number_format($row['harga_per_botol'], 0, ',', '.') ?></td>
                <td><?= $row['stok'] ?></td>
                <td>
                    <a class="button edit" href="edit_madu.php?id=<?= $row['id_madu'] ?>">Edit</a>
                    <a class="button hapus" href="hapus_madu.php?id=<?= $row['id_madu'] ?>" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                </td>
            </tr>
        <?php } ?>
    </table>

</body>
</html>