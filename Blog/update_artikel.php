<?php
header('Content-Type: application/json');
include 'koneksi.php';

$id = $_POST['id'] ?? '';
$judul = $_POST['judul'] ?? '';
$id_kategori = $_POST['id_kategori'] ?? '';
$id_penulis = $_POST['id_penulis'] ?? '';
$isi = $_POST['isi'] ?? '';
$hari_tanggal = $_POST['hari_tanggal'] ?? '';
$gambar = $_FILES['gambar']['name'] ?? '';

// Cek apakah gambar ikut diubah
if($gambar != "") {
    // Hapus gambar lama jika ada
    $stmt_old = $pdo->prepare("SELECT gambar FROM artikel WHERE id = ?");
    $stmt_old->execute([$id]);
    $row_old = $stmt_old->fetch(PDO::FETCH_ASSOC);
    if($row_old && file_exists("uploads_artikel/".$row_old['gambar'])){
        unlink("uploads_artikel/".$row_old['gambar']);
    }

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

echo json_encode(["status" => "success", "message" => "Artikel berhasil diupdate!"]);
?>
