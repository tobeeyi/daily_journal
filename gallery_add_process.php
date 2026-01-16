<?php
include "auth.php";
include "koneksi.php";

$deskripsi = trim($_POST['deskripsi'] ?? '');

if ($deskripsi === '' || empty($_FILES['gambar']['name'])) {
  header("Location: gallery_add.php");
  exit;
}

if (!is_dir("img")) {
  mkdir("img", 0777, true);
}

$username = $_SESSION['username'] ?? 'admin';
$tanggal = date("Y-m-d H:i:s");

$ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
$allowed = ['jpg','jpeg','png','gif','webp'];

if (!in_array($ext, $allowed)) {
  die("Format file tidak didukung. Gunakan jpg/jpeg/png/gif/webp.");
}

$namaFile = time() . "_" . bin2hex(random_bytes(4)) . "." . $ext;
$target = "img/" . $namaFile;

if (!move_uploaded_file($_FILES['gambar']['tmp_name'], $target)) {
  die("Upload gagal.");
}

$sql = "INSERT INTO gallery (deskripsi, gambar, tanggal, username) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $deskripsi, $namaFile, $tanggal, $username);
$stmt->execute();

header("Location: gallery.php");
exit;
