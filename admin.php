<?php
include "auth.php";
$page_title = "Manajemen Article - DailyJournal";
include "header.php";
?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <h3 class="mb-0">Manajemen Article</h3>
  </div>
</div>

<div class="row mb-2 g-2 align-items-center">
  <div class="col-md-6">
    <a href="article_add.php" class="btn btn-primary">+ Tambah Article</a>
  </div>
  <div class="col-md-6">
    <div class="input-group">
      <input type="text" id="search" class="form-control" placeholder="Cari Artikel... (min. 3 karakter)">
      <span class="input-group-text">🔍</span>
    </div>
  </div>
</div>

<div class="card shadow-sm border-0">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-striped table-hover mb-0 align-middle">
        <thead class="table-dark">
          <tr>
            <th style="width:60px;">No</th>
            <th>Judul</th>
            <th>Isi</th>
            <th style="width:160px;">Tanggal</th>
            <th style="width:120px;">Username</th>
            <th style="width:120px;">Gambar</th>
            <th style="width:170px;">Aksi</th>
          </tr>
        </thead>
        <tbody id="result"></tbody>
      </table>
    </div>
  </div>
</div>

<script>
  function loadData(keyword = '') {
    $.ajax({
      url: "article_search.php",
      type: "POST",
      data: { keyword: keyword },
      success: function(data) {
        $("#result").html(data);
      },
      error: function() {
        $("#result").html('<tr><td colspan="7" class="text-center text-danger">Gagal memuat data.</td></tr>');
      }
    });
  }

  loadData('');

  let typingTimer;
  const typingInterval = 400;

  $("#search").on("keyup", function() {
    clearTimeout(typingTimer);
    const keyword = $(this).val();

    typingTimer = setTimeout(() => {
      if (keyword.length >= 3) {
        loadData(keyword);
      } else if (keyword.length === 0) {
        loadData('');
      }
    }, typingInterval);
  });
</script>

<?php include "footer.php"; ?>
