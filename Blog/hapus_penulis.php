<?php
// hapus_penulis.php
header('Content-Type: application/json');
include 'koneksi.php';

if (!isset($_GET['id'])) {
    echo json_encode(["status" => "error", "message" => "ID tidak ditemukan."]);
    exit;
}

$id = $_GET['id'];

// Cari file foto di database dan hapus filenya dari server
$stmt_select = $pdo->prepare("SELECT foto FROM penulis WHERE id = ?");
$stmt_select->execute([$id]);
$row = $stmt_select->fetch(PDO::FETCH_ASSOC);

if ($row) {
    $file_foto = $row['foto'];
    if (file_exists($file_foto)) {
        unlink($file_foto); // Hapus foto fisik dari folder
    }
}

// Hapus data dari tabel
try {
    $stmt_delete = $pdo->prepare("DELETE FROM penulis WHERE id = ?");
    if ($stmt_delete->execute([$id])) {
        echo json_encode(["status" => "success", "message" => "Data berhasil dihapus."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Gagal menghapus data."]);
    }
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Tidak dapat menghapus penulis: " . $e->getMessage()]);
}
?>
