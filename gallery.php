<?php
include "auth.php";
$page_title = "Manajemen Gallery";
include "header.php";
?>

<div class="container my-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Gallery</h3>
  </div>

  <div class="row g-2 align-items-center mb-3">
    <div class="col-md-6">
      <a href="gallery_add.php" class="btn btn-primary">+ Tambah Gallery</a>
    </div>
    <div class="col-md-6">
      <div class="input-group">
        <input type="text" id="search" class="form-control" placeholder="Cari Gallery... (min. 3 karakter)">
        <button class="btn btn-outline-secondary" type="button">🔎</button>
      </div>
      <small class="text-muted">Cari berdasarkan deskripsi / tanggal / username.</small>
    </div>
  </div>

  <div class="card shadow-sm border-0">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped table-hover mb-0 align-middle">
          <thead class="table-dark">
            <tr>
              <th style="width:60px;">No</th>
              <th>Deskripsi</th>
              <th style="width:220px;">Gambar</th>
              <th style="width:220px;">Info</th>
              <th style="width:180px;">Aksi</th>
            </tr>
          </thead>
          <tbody id="result"></tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
  function loadGallery(keyword = '') {
    $.ajax({
      url: "gallery_search.php",
      type: "POST",
      data: { keyword: keyword },
      success: function(res) {
        $("#result").html(res);
      },
      error: function() {
        $("#result").html('<tr><td colspan="5" class="text-center text-danger py-4">Gagal memuat data.</td></tr>');
      }
    });
  }

  loadGallery('');

  let tmr;
  $("#search").on("keyup", function() {
    clearTimeout(tmr);
    const keyword = $(this).val();

    tmr = setTimeout(function() {
      if (keyword.length >= 3) loadGallery(keyword);
      else if (keyword.length === 0) loadGallery('');
    }, 350);
  });
</script>

<?php include "footer.php"; ?>
