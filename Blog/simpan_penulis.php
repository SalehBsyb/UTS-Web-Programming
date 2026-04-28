<?php
// simpan_penulis.php
header('Content-Type: application/json');
include 'koneksi.php';

$nama_depan = htmlspecialchars($_POST['nama_depan']);
$nama_belakang = htmlspecialchars($_POST['nama_belakang']);
$user_name = htmlspecialchars($_POST['user_name']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Enkripsi password

// Proses upload foto
$foto = $_FILES['foto']['name'];
$tmp_name = $_FILES['foto']['tmp_name'];
$folder = "uploads_penulis/";
$nama_foto_baru = time() . "_" . basename($foto);
$path_foto = $folder . $nama_foto_baru;

if (move_uploaded_file($tmp_name, $path_foto)) {
    $stmt = $conn->prepare("INSERT INTO penulis (nama_depan, nama_belakang, user_name, password, foto) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nama_depan, $nama_belakang, $user_name, $password, $path_foto);
    
    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Data penulis berhasil disimpan."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Gagal menyimpan data: " . $stmt->error]);
    }
    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Gagal mengunggah foto."]);
}

$conn->close();
?>