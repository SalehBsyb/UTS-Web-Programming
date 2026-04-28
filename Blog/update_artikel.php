<?php
include 'koneksi.php';

$id = $_POST['id'];
$judul = $_POST['judul'];
$id_kategori = $_POST['id_kategori'];
$id_penulis = $_POST['id_penulis'];
$isi = $_POST['isi'];
$hari_tanggal = $_POST['hari_tanggal'];
$gambar = $_FILES['gambar']['name'];

// Cek apakah gambar ikut diubah
if($gambar != "") {
    $tmp = $_FILES['gambar']['tmp_name'];
    $path = "uploads_artikel/" . $gambar;
    move_uploaded_file($tmp, $path);

    $sql = "UPDATE artikel SET id_penulis=?, id_kategori=?, judul=?, isi=?, gambar=?, hari_tanggal=? WHERE id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_penulis, $id_kategori, $judul, $isi, $gambar, $hari_tanggal, $id]);
} else {
    $sql = "UPDATE artikel SET id_penulis=?, id_kategori=?, judul=?, isi=?, hari_tanggal=? WHERE id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_penulis, $id_kategori, $judul, $isi, $hari_tanggal, $id]);
}

echo "Artikel berhasil diupdate!";
?>