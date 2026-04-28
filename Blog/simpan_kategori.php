<?php
include 'koneksi.php';

$nama_kategori = $_POST['nama_kategori'];
$keterangan = $_POST['keterangan'];

$stmt = $conn->prepare("INSERT INTO kategori_artikel (nama_kategori, keterangan) VALUES (?, ?)");
$stmt->bind_param("ss", $nama_kategori, $keterangan);

if($stmt->execute()){
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>