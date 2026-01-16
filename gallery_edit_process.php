<?php
include "auth.php";
include "koneksi.php";

$id = (int)($_POST['id'] ?? 0);
$deskripsi = trim($_POST['deskripsi'] ?? '');
$old = $_POST['old_gambar'] ?? '';

if ($id <= 0 || $deskripsi === '') {
  header("Location: gallery.php");
  exit;
}

$namaFile = $old;

if (!empty($_FILES['gambar']['name'])) {

  if (!is_dir("img")) {
    mkdir("img", 0777, true);
  }

  $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
  $allowed = ['jpg','jpeg','png','gif','webp'];
  if (!in_array($ext, $allowed)) {
    die("Format file tidak didukung. Gunakan jpg/jpeg/png/gif/webp.");
  }

  $namaFile = time() . "_" . bin2hex(random_bytes(4)) . "." . $ext;
  $target = "img/" . $namaFile;

  if (!move_uploaded_file($_FILES['gambar']['tmp_name'], $target)) {
    die("Upload gambar baru gagal.");
  }

  if ($old && file_exists("img/".$old)) {
    @unlink("img/".$old);
  }
}

$stmt = $conn->prepare("UPDATE gallery SET deskripsi=?, gambar=? WHERE id=?");
$stmt->bind_param("ssi", $deskripsi, $namaFile, $id);
$stmt->execute();

header("Location: gallery.php");
exit;
