<?php
include "auth.php";
include "koneksi.php";

$id = (int)($_GET['id'] ?? 0);
$sql = "SELECT * FROM article WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if (!$data) {
  header("Location: admin.php");
  exit;
}

$page_title = "Edit Article - DailyJournal";
include "header.php";
?>
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="card shadow-sm border-0">
      <div class="card-body p-4">
        <h4 class="mb-3">Edit Article</h4>

        <form action="article_edit_process.php" method="POST" enctype="multipart/form-data" class="vstack gap-3">
          <input type="hidden" name="id" value="<?= (int)$data['id']; ?>">
          <input type="hidden" name="gambar_lama" value="<?= htmlspecialchars($data['gambar'] ?? ''); ?>">

          <div>
            <label class="form-label">Judul</label>
            <input type="text" name="judul" class="form-control" value="<?= htmlspecialchars($data['judul']); ?>" required>
          </div>

          <div>
            <label class="form-label">Isi</label>
            <textarea name="isi" class="form-control" rows="6" required><?= htmlspecialchars($data['isi']); ?></textarea>
          </div>

          <div>
            <label class="form-label">Gambar (opsional)</label>
            <input type="file" name="gambar" class="form-control" accept="image/*">
            <?php if (!empty($data['gambar'])): ?>
              <div class="mt-2">
                <img src="img/<?= htmlspecialchars($data['gambar']); ?>" width="140" class="rounded border">
              </div>
            <?php endif; ?>
          </div>

          <div class="d-flex gap-2">
            <button class="btn btn-warning">Update</button>
            <a href="admin.php" class="btn btn-outline-secondary">Kembali</a>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>

<?php include "footer.php"; ?>
