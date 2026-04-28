<?php
// hapus_penulis.php
header('Content-Type: application/json');
include 'koneksi.php';

// Ambil input JSON dari Fetch API
$data = json_decode(file_get_contents("php://input"));
$id = $data->id;

// Cari file foto di database dan hapus filenya dari server
$stmt_select = $conn->prepare("SELECT foto FROM penulis WHERE id = ?");
$stmt_select->bind_param("i", $id);
$stmt_select->execute();
$result = $stmt_select->get_result();

if ($row = $result->fetch_assoc()) {
    $file_foto = $row['foto'];
    if (file_exists($file_foto)) {
        unlink($file_foto); // Hapus foto fisik dari folder
    }
}
$stmt_select->close();

// Hapus data dari tabel
$stmt_delete = $conn->prepare("DELETE FROM penulis WHERE id = ?");
$stmt_delete->bind_param("i", $id);

if ($stmt_delete->execute()) {
    echo json_encode(["status" => "success", "message" => "Data berhasil dihapus."]);
} else {
    echo json_encode(["status" => "error", "message" => "Gagal menghapus data: " . $stmt_delete->error]);
}

$stmt_delete->close();
$conn->close();
?>