<?php
// update_penulis.php
header('Content-Type: application/json');
include 'koneksi.php';

$id = $_POST['id'] ?? '';
$nama_depan = htmlspecialchars($_POST['nama_depan'] ?? '');
$nama_belakang = htmlspecialchars($_POST['nama_belakang'] ?? '');
$user_name = htmlspecialchars($_POST['user_name'] ?? '');

// Mulai membuat struktur query update
$query = "UPDATE penulis SET nama_depan = ?, nama_belakang = ?, user_name = ?";
$params = [$nama_depan, $nama_belakang, $user_name];

// Jika password diisi, ikut di-update
if (!empty($_POST['password'])) {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $query .= ", password = ?";
    $params[] = $password;
}

// Jika foto baru diupload
if (!empty($_FILES['foto']['name'])) {
    // Ambil path foto lama untuk dihapus
    $stmt_old = $pdo->prepare("SELECT foto FROM penulis WHERE id = ?");
    $stmt_old->execute([$id]);
    $res_old = $stmt_old->fetch(PDO::FETCH_ASSOC);
    if ($res_old && file_exists($res_old['foto'])) {
        unlink($res_old['foto']);
    }

    // Upload foto baru
    $foto = $_FILES['foto']['name'];
    $tmp_name = $_FILES['foto']['tmp_name'];
    $path_foto = "uploads_penulis/" . time() . "_" . basename($foto);
    move_uploaded_file($tmp_name, $path_foto);

    $query .= ", foto = ?";
    $params[] = $path_foto;
}

$query .= " WHERE id = ?";
$params[] = $id;

$stmt = $pdo->prepare($query);

if ($stmt->execute($params)) {
    echo json_encode(["status" => "success", "message" => "Data penulis berhasil diperbarui."]);
} else {
    echo json_encode(["status" => "error", "message" => "Gagal memperbarui data."]);
}
?>
