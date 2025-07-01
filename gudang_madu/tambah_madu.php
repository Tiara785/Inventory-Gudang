<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_madu = $_POST['nama_madu'];
    $jenis_madu = $_POST['jenis_madu'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga_per_botol'];

    $query = "INSERT INTO madu (nama_madu, jenis_madu, stok, harga_per_botol) VALUES ('$nama_madu', '$jenis_madu', '$stok', '$harga')";
    $hasil = mysqli_query($koneksi, $query);

    if ($hasil) {
        echo "<script>alert('Data berhasil disimpan'); window.location.href='madu.php';</script>";
    } else {
        echo "Gagal menyimpan data: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Madu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container col-md-6 mt-5">
    <h3 class="text-center mb-4">Tambah Data Madu</h3>
    <form method="POST" action="">
        <div class="mb-3">
            <label>Nama Madu</label>
            <input type="text" name="nama_madu" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Jenis Madu</label>
            <input type="text" name="jenis_madu" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Stok</label>
            <input type="number" name="stok" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>harga_per_botol</label>
            <input type="number" name="harga_per_botol" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-warning w-100">Simpan</button>
    </form>
</div>
</body>
</html>