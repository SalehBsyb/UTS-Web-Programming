<?php
// ambil_satu_penulis.php
header('Content-Type: application/json');
include 'koneksi.php';

if (!isset($_GET['id'])) {
    echo json_encode(["status" => "error", "message" => "ID tidak ditemukan."]);
    exit;
}

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT id, nama_depan, nama_belakang, user_name, foto FROM penulis WHERE id = ?");
$stmt->execute([$id]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    echo json_encode($result);
} else {
    echo json_encode(["status" => "error", "message" => "Data tidak ditemukan."]);
}
?>
