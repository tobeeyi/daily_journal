<?php
include "auth.php";
include "koneksi.php";

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
  header("Location: gallery.php");
  exit;
}

$stmt = $conn->prepare("SELECT gambar FROM gallery WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

$stmt2 = $conn->prepare("DELETE FROM gallery WHERE id=?");
$stmt2->bind_param("i", $id);
$stmt2->execute();

if ($row && !empty($row['gambar'])) {
  $path = "img/" . $row['gambar'];
  if (file_exists($path)) {
    @unlink($path);
  }
}

header("Location: gallery.php");
exit;
