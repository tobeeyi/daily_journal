<?php
include "koneksi.php";

$keyword = $_POST['keyword'] ?? '';
$keyword = trim($keyword);

$sql = "SELECT * FROM article 
        WHERE judul LIKE ? OR isi LIKE ? OR tanggal LIKE ? OR username LIKE ?
        ORDER BY tanggal DESC";

$stmt = $conn->prepare($sql);
$search = "%" . $keyword . "%";
$stmt->bind_param("ssss", $search, $search, $search, $search);
$stmt->execute();
$hasil = $stmt->get_result();

$no = 1;

if ($hasil && $hasil->num_rows > 0) {
  while ($row = $hasil->fetch_assoc()) {
    $judul = htmlspecialchars($row['judul']);
    $isi = htmlspecialchars(mb_strimwidth($row['isi'], 0, 100, '...'));
    $tanggal = htmlspecialchars($row['tanggal']);
    $username = htmlspecialchars($row['username']);

    $gambarHtml = '<span class="text-muted">-</span>';
    if (!empty($row['gambar'])) {
      $g = htmlspecialchars($row['gambar']);
      $gambarHtml = "<img src='img/{$g}' alt='gambar' width='80' class='rounded border'>";
    }

    $id = (int)$row['id'];

    echo "<tr>
            <td>{$no}</td>
            <td>{$judul}</td>
            <td>{$isi}</td>
            <td>{$tanggal}</td>
            <td>{$username}</td>
            <td>{$gambarHtml}</td>
            <td>
              <div class='d-flex gap-1'>
                <a class='btn btn-warning btn-sm' href='article_edit.php?id={$id}'>Edit</a>
                <a class='btn btn-danger btn-sm' href='article_delete.php?id={$id}' onclick=\"return confirm('Hapus artikel ini?')\">Hapus</a>
              </div>
            </td>
          </tr>";
    $no++;
  }
} else {
  echo "<tr><td colspan='7' class='text-center text-muted py-4'>Data tidak ditemukan.</td></tr>";
}
?>
