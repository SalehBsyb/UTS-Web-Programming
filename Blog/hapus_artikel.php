<?php
header('Content-Type: application/json');
include 'koneksi.php';

if (!isset($_GET['id'])) {
    echo json_encode(["status" => "error", "message" => "ID tidak ditemukan."]);
    exit;
}

$id = $_GET['id'];

// Mengambil nama file gambar untuk ikut dihapus dari penyimpanan
$stmt = $pdo->prepare("SELECT gambar FROM artikel WHERE id = ?");
$stmt->execute([$id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if($row && file_exists("uploads_artikel/".$row['gambar'])){
    unlink("uploads_artikel/".$row['gambar']);
}

$sql = "DELETE FROM artikel WHERE id = ?";
$stmt = $pdo->prepare($sql);
if($stmt->execute([$id])) {
    echo json_encode(["status" => "success", "message" => "Artikel berhasil dihapus!"]);
} else {
    echo json_encode(["status" => "error", "message" => "Gagal menghapus artikel."]);
}
?>
