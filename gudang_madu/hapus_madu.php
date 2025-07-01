<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM madu WHERE id_madu = $id";
    if ($koneksi->query($query)) {
        echo "<script>alert('Data berhasil dihapus'); window.location.href='madu.php';</script>";
    } else {
        echo "Gagal menghapus data: " . $koneksi->error;
    }
} else {
    echo "ID tidak ditemukan.";
}
?>