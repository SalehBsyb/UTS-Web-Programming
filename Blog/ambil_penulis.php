<?php
// ambil_penulis.php
header('Content-Type: application/json');
include 'koneksi.php';

$query = "SELECT id, nama_depan, nama_belakang, user_name, foto FROM penulis ORDER BY id DESC";
$result = $conn->query($query);

$data = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data);
$conn->close();
?>