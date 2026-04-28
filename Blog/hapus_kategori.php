<?php
header('Content-Type: application/json');
include 'koneksi.php';

if (!isset($_GET['id'])) {
    echo json_encode(["status" => "error", "message" => "ID tidak ditemukan."]);
    exit;
}

$id = $_GET['id'];

try {
    $stmt = $pdo->prepare("DELETE FROM kategori_artikel WHERE id = ?");
    if($stmt->execute([$id])){
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Gagal menghapus data."]);
    }
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Tidak dapat menghapus kategori: " . $e->getMessage()]);
}
?>
