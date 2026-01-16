<?php
include "auth.php";
$page_title = "Tambah Gallery";
include "header.php";
?>

<div class="container my-4">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card shadow-sm border-0">
        <div class="card-body p-4">
          <h4 class="mb-3">Tambah Gallery</h4>

          <form action="gallery_add_process.php" method="POST" enctype="multipart/form-data" class="vstack gap-3">
            <div>
              <label class="form-label">Deskripsi</label>
              <input type="text" name="deskripsi" class="form-control" required>
            </div>

            <div>
              <label class="form-label">Gambar</label>
              <input type="file" name="gambar" class="form-control" accept="image/*" required>
              <small class="text-muted">Disimpan ke folder <b>img/</b></small>
            </div>

            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-primary">Simpan</button>
              <a href="gallery.php" class="btn btn-outline-secondary">Kembali</a>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>

<?php include "footer.php"; ?>
