<?php
include "koneksi.php";
$gal = $conn->query("SELECT * FROM gallery ORDER BY tanggal DESC");
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>DailyJournal</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
  <style>
    :root{ --pink:#ff4da6; }
    .navbar-pink{ background: var(--pink) !important; }
  </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-pink">
  <div class="container">
    <a class="navbar-brand fw-semibold text-white" href="index.php">DailyJournal</a>
    <a class="btn btn-outline-light btn-sm" href="login.php">Login</a>
  </div>
</nav>

<div class="container py-4">
  <h3 class="mb-3">Gallery</h3>

  <?php if ($gal && $gal->num_rows > 0): ?>
    <div id="galleryCarousel" class="carousel slide" data-bs-ride="carousel">

      <div class="carousel-indicators">
        <?php $i=0; foreach ($gal as $row): ?>
          <button type="button" data-bs-target="#galleryCarousel" data-bs-slide-to="<?= $i ?>"
            class="<?= $i===0?'active':'' ?>" aria-current="<?= $i===0?'true':'false' ?>"
            aria-label="Slide <?= $i+1 ?>"></button>
        <?php $i++; endforeach; ?>
      </div>

      <div class="carousel-inner rounded shadow-sm">
        <?php
          $gal->data_seek(0);
          $i=0;
          while($row = $gal->fetch_assoc()):
            $img = htmlspecialchars($row['gambar']);
            $desk = htmlspecialchars($row['deskripsi']);
        ?>
          <div class="carousel-item <?= $i===0?'active':'' ?>">
            <img src="img/<?= $img ?>" class="d-block w-100" style="max-height:450px; object-fit:cover;" alt="<?= $desk ?>">
            <div class="carousel-caption d-none d-md-block">
              <h5><?= $desk ?></h5>
            </div>
          </div>
        <?php $i++; endwhile; ?>
      </div>

      <button class="carousel-control-prev" type="button" data-bs-target="#galleryCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#galleryCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
        <span class="visually-hidden">Next</span>
      </button>

    </div>
  <?php else: ?>
    <div class="alert alert-info">Belum ada data gallery.</div>
  <?php endif; ?>
</div>

</body>
</html>
