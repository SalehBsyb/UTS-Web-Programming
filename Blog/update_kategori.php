<?php
include 'koneksi.php';

$id = $_POST['id'];
$nama_kategori = $_POST['nama_kategori'];
$keterangan = $_POST['keterangan'];

$stmt = $conn->prepare("UPDATE kategori_artikel SET nama_kategori = ?, keterangan = ? WHERE id = ?");
$stmt->bind_param("ssi", $nama_kategori, $keterangan, $id);

if($stmt->execute()){
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>