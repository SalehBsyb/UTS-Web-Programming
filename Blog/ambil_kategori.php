<?php
header('Content-Type: application/json');
include 'koneksi.php';

$sql = "SELECT * FROM kategori_artikel ORDER BY id DESC";
$stmt = $pdo->query($sql);

$data = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $data[] = $row;
}

echo json_encode($data);
?>
