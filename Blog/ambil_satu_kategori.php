<?php
include 'koneksi.php';

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM kategori_artikel WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

echo json_encode($result->fetch_assoc());

$stmt->close();
$conn->close();
?>