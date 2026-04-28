<?php
include 'koneksi.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM artikel WHERE id = ?");
$stmt->execute([$id]);
echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
?>