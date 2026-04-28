<?php
include 'koneksi.php';

$judul = $_POST['judul'];
$id_kategori = $_POST['id_kategori'];
$id_penulis = $_POST['id_penulis'];
$isi = $_POST['isi'];
$hari_tanggal = $_POST['hari_tanggal'];
$gambar = $_FILES['gambar']['name'];

// Proses mengunggah gambar wajib ke folder uploads_artikel/
$tmp = $_FILES['gambar']['tmp_name'];
$path = "uploads_artikel/" . $gambar;

if(move_uploaded_file($tmp, $path)){
    $sql = "INSERT INTO artikel (id_penulis, id_kategori, judul, isi, gambar, hari_tanggal) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    if($stmt->execute([$id_penulis, $id_kategori, $judul, $isi, $gambar, $hari_tanggal])){
        echo "Artikel berhasil disimpan!";
    } else {
        echo "Gagal menyimpan ke database.";
    }
} else {
    echo "Gagal mengunggah gambar, pastikan folder tersedia.";
}
?>