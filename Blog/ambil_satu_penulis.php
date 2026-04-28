<?php
// ambil_satu_penulis.php
header('Content-Type: application/json');
include 'koneksi.php';

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT id, nama_depan, nama_belakang, user_name, foto FROM penulis WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(["status" => "error", "message" => "Data tidak ditemukan."]);
}

$stmt->close();
$conn->close();
?>