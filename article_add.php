<?php
include "auth.php";
$page_title = "Tambah Article - DailyJournal";
include "header.php";
?>
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="card shadow-sm border-0">
      <div class="card-body p-4">
        <h4 class="mb-3">Tambah Article</h4>
        <form action="article_add_process.php" method="POST" enctype="multipart/form-data" class="vstack gap-3">
          <div>
            <label class="form-label">Judul</label>
            <input type="text" name="judul" class="form-control" required>
          </div>
          <div>
            <label class="form-label">Isi</label>
            <textarea name="isi" class="form-control" rows="6" required></textarea>
          </div>
          <div>
            <label class="form-label">Gambar (opsional)</label>
            <input type="file" name="gambar" class="form-control" accept="image/*">
            <div class="form-text">Upload gambar kecil (free hosting storage terbatas).</div>
          </div>
          <div class="d-flex gap-2">
            <button class="btn btn-primary">Simpan</button>
            <a href="admin.php" class="btn btn-outline-secondary">Kembali</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include "footer.php"; ?>
