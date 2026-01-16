<?php
include "auth.php";
include "koneksi.php";

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
  header("Location: admin.php");
  exit;
}

$sql = "SELECT gambar FROM article WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if ($data && !empty($data['gambar']) && file_exists("img/" . $data['gambar'])) {
  unlink("img/" . $data['gambar']);
}

$sqlDel = "DELETE FROM article WHERE id = ?";
$stmtDel = $conn->prepare($sqlDel);
$stmtDel->bind_param("i", $id);
$stmtDel->execute();

header("Location: admin.php");
exit;
?>
