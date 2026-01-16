<?php
include "auth.php";
include "koneksi.php";

$id = (int)($_POST['id'] ?? 0);
$judul = trim($_POST['judul'] ?? '');
$isi = trim($_POST['isi'] ?? '');
$gambarLama = $_POST['gambar_lama'] ?? '';

if ($id <= 0 || $judul === '' || $isi === '') {
  header("Location: admin.php");
  exit;
}

$namaFile = $gambarLama;

if (!empty($_FILES['gambar']['name'])) {
  $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
  $namaFile = time() . "_" . bin2hex(random_bytes(4)) . "." . $ext;
  $target = "img/" . $namaFile;
  move_uploaded_file($_FILES['gambar']['tmp_name'], $target);

  if (!empty($gambarLama) && file_exists("img/" . $gambarLama)) {
    unlink("img/" . $gambarLama);
  }
}

$sql = "UPDATE article SET judul = ?, isi = ?, gambar = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssi", $judul, $isi, $namaFile, $id);
$stmt->execute();

header("Location: admin.php");
exit;
?>
