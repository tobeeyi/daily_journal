<?php
include "auth.php";
include "koneksi.php";

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
  header("Location: gallery.php");
  exit;
}

$stmt = $conn->prepare("SELECT * FROM gallery WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if (!$data) {
  header("Location: gallery.php");
  exit;
}

$page_title = "Edit Gallery";
include "header.php";
?>

<div class="container my-4">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card shadow-sm border-0">
        <div class="card-body p-4">
          <h4 class="mb-3">Edit Gallery</h4>

          <form action="gallery_edit_process.php" method="POST" enctype="multipart/form-data" class="vstack gap-3">
            <input type="hidden" name="id" value="<?= (int)$data['id']; ?>">
            <input type="hidden" name="old_gambar" value="<?= htmlspecialchars($data['gambar']); ?>">

            <div>
              <label class="form-label">Deskripsi</label>
              <input type="text" name="deskripsi" class="form-control" value="<?= htmlspecialchars($data['deskripsi']); ?>" required>
            </div>

            <div>
              <label class="form-label d-block">Gambar Saat Ini</label>
              <img src="img/<?= htmlspecialchars($data['gambar']); ?>" class="rounded border" style="max-width:280px;">
            </div>

            <div>
              <label class="form-label">Ganti Gambar (opsional)</label>
              <input type="file" name="gambar" class="form-control" accept="image/*">
            </div>

            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
              <a href="gallery.php" class="btn btn-outline-secondary">Kembali</a>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>

<?php include "footer.php"; ?>
