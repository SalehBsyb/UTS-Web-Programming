<?php
header('Content-Type: application/json');
include 'koneksi.php';

$id = $_POST['id'] ?? '';
$nama_kategori = $_POST['nama_kategori'] ?? '';
$keterangan = $_POST['keterangan'] ?? '';

$stmt = $pdo->prepare("UPDATE kategori_artikel SET nama_kategori = ?, keterangan = ? WHERE id = ?");

if($stmt->execute([$nama_kategori, $keterangan, $id])){
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "Gagal memperbarui data."]);
}
?>
