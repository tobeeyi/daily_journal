<?php
include "auth.php";
include "koneksi.php";

$judul = trim($_POST['judul'] ?? '');
$isi   = trim($_POST['isi'] ?? '');

if ($judul === '' || $isi === '') {
  header("Location: article_add.php");
  exit;
}

$tanggal = date("Y-m-d H:i:s");
$username = $_SESSION['username'];

$namaFile = null;
if (!empty($_FILES['gambar']['name'])) {
  $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
  $namaFile = time() . "_" . bin2hex(random_bytes(4)) . "." . $ext;
  $target = "img/" . $namaFile;
  move_uploaded_file($_FILES['gambar']['tmp_name'], $target);
}

$sql = "INSERT INTO article (judul, isi, tanggal, gambar, username) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $judul, $isi, $tanggal, $namaFile, $username);
$stmt->execute();

header("Location: admin.php");
exit;
?>
