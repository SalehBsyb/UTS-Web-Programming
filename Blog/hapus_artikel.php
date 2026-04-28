<?php
include 'koneksi.php';

$id = $_POST['id'];

// Mengambil nama file gambar untuk ikut dihapus dari penyimpanan
$stmt = $pdo->prepare("SELECT gambar FROM artikel WHERE id = ?");
$stmt->execute([$id]);
$row = $stmt->fetch();

if($row && file_exists("uploads_artikel/".$row['gambar'])){
    unlink("uploads_artikel/".$row['gambar']);
}

$sql = "DELETE FROM artikel WHERE id = ?";
$stmt = $pdo->prepare($sql);
if($stmt->execute([$id])) {
    echo "Artikel berhasil dihapus!";
} else {
    echo "Gagal menghapus artikel.";
}
?>