<?php
$koneksi = new mysqli("localhost", "root", "", "gudang_madu");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>