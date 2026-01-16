<?php
include "koneksi.php";

$keyword = trim($_POST['keyword'] ?? '');

$sql = "SELECT * FROM gallery
        WHERE deskripsi LIKE ? OR tanggal LIKE ? OR username LIKE ?
        ORDER BY tanggal DESC";

$stmt = $conn->prepare($sql);
$search = "%".$keyword."%";
$stmt->bind_param("sss", $search, $search, $search);
$stmt->execute();
$res = $stmt->get_result();

$no = 1;

if ($res && $res->num_rows > 0) {
  while ($row = $res->fetch_assoc()) {
    $id = (int)$row['id'];
    $deskripsi = htmlspecialchars($row['deskripsi']);
    $tanggal = htmlspecialchars($row['tanggal']);
    $username = htmlspecialchars($row['username']);
    $gambar = htmlspecialchars($row['gambar']);

    $imgTag = "<img src='img/{$gambar}' class='rounded border' style='width:200px; height:auto;' alt='gallery'>";

    echo "<tr>
      <td>{$no}</td>
      <td>{$deskripsi}</td>
      <td>{$imgTag}</td>
      <td>
        <div>pada : {$tanggal}</div>
        <div>oleh : {$username}</div>
      </td>
      <td>
        <div class='d-flex gap-1'>
          <a class='btn btn-warning btn-sm' href='gallery_edit.php?id={$id}'>Edit</a>
          <a class='btn btn-danger btn-sm' href='gallery_delete.php?id={$id}' onclick=\"return confirm('Hapus data gallery ini?')\">Hapus</a>
        </div>
      </td>
    </tr>";
    $no++;
  }
} else {
  echo "<tr><td colspan='5' class='text-center text-muted py-4'>Data tidak ditemukan.</td></tr>";
}
