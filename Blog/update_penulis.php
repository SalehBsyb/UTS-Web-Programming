<?php
// update_penulis.php
header('Content-Type: application/json');
include 'koneksi.php';

$id = $_POST['id'];
$nama_depan = htmlspecialchars($_POST['nama_depan']);
$nama_belakang = htmlspecialchars($_POST['nama_belakang']);
$user_name = htmlspecialchars($_POST['user_name']);

// Mulai membuat struktur query update
$query = "UPDATE penulis SET nama_depan = ?, nama_belakang = ?, user_name = ?";
$params = [$nama_depan, $nama_belakang, $user_name];
$types = "sss";

// Jika password diisi, ikut di-update
if (!empty($_POST['password'])) {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $query .= ", password = ?";
    $params[] = $password;
    $types .= "s";
}

// Jika foto baru diupload
if (!empty($_FILES['foto']['name'])) {
    // Ambil path foto lama untuk dihapus
    $stmt_old = $conn->prepare("SELECT foto FROM penulis WHERE id = ?");
    $stmt_old->bind_param("i", $id);
    $stmt_old->execute();
    $res_old = $stmt_old->get_result()->fetch_assoc();
    if (file_exists($res_old['foto'])) {
        unlink($res_old['foto']);
    }
    $stmt_old->close();

    // Upload foto baru
    $foto = $_FILES['foto']['name'];
    $tmp_name = $_FILES['foto']['tmp_name'];
    $path_foto = "uploads_penulis/" . time() . "_" . basename($foto);
    move_uploaded_file($tmp_name, $path_foto);

    $query .= ", foto = ?";
    $params[] = $path_foto;
    $types .= "s";
}

$query .= " WHERE id = ?";
$params[] = $id;
$types .= "i";

$stmt = $conn->prepare($query);
$stmt->bind_param($types, ...$params);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Data penulis berhasil diperbarui."]);
} else {
    echo json_encode(["status" => "error", "message" => "Gagal memperbarui data: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>