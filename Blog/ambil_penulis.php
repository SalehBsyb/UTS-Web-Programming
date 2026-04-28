<?php
// ambil_penulis.php
header('Content-Type: application/json');
include 'koneksi.php';

$query = "SELECT id, nama_depan, nama_belakang, user_name, foto FROM penulis ORDER BY id DESC";
$stmt = $pdo->query($query);

$data = [];
if ($stmt) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
}

echo json_encode($data);
?>
