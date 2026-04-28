<?php
header('Content-Type: application/json');
include 'koneksi.php';

$nama_kategori = $_POST['nama_kategori'] ?? '';
$keterangan = $_POST['keterangan'] ?? '';

$stmt = $pdo->prepare("INSERT INTO kategori_artikel (nama_kategori, keterangan) VALUES (?, ?)");

if($stmt->execute([$nama_kategori, $keterangan])){
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "Gagal menyimpan data."]);
}
?>
