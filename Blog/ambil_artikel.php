<?php
include 'koneksi.php';

// Relasi tabel artikel ke kategori dan penulis
$query = "SELECT artikel.*, penulis.nama_depan, penulis.nama_belakang, kategori_artikel.nama_kategori 
          FROM artikel 
          JOIN penulis ON artikel.id_penulis = penulis.id 
          JOIN kategori_artikel ON artikel.id_kategori = kategori_artikel.id 
          ORDER BY artikel.id DESC";
          
$stmt = $pdo->query($query);
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
?>