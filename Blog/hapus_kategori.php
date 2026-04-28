<?php
include 'koneksi.php';

$id = $_POST['id'];

$stmt = $conn->prepare("DELETE FROM kategori_artikel WHERE id = ?");
$stmt->bind_param("i", $id);

if($stmt->execute()){
    echo json_encode(["status" => "success"]);
} else {
    // Memberikan pesan error spesifik, contohnya jika ada relasi tabel Foreign Key
    echo json_encode(["status" => "error", "message" => $stmt->error]); 
}

$stmt->close();
$conn->close();
?>