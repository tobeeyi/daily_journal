<?php
include "auth.php";
include "koneksi.php";

$page_title = "Dashboard - DailyJournal";
include "header.php";

$username = $_SESSION['username'];

$stmt = $conn->prepare("SELECT foto FROM users WHERE username=? LIMIT 1");
$stmt->bind_param("s", $username);
$stmt->execute();
$u = $stmt->get_result()->fetch_assoc();
$foto = $u['foto'] ?? null;

$fotoPath = null;
if ($foto && file_exists("img/" . $foto)) {
  $fotoPath = "img/" . htmlspecialchars($foto);
}

$articleCount = 0;
$galleryCount = 0;

$r1 = $conn->query("SELECT COUNT(*) AS total FROM article");
if ($r1) $articleCount = (int)($r1->fetch_assoc()['total'] ?? 0);

$r2 = $conn->query("SELECT COUNT(*) AS total FROM gallery");
if ($r2) $galleryCount = (int)($r2->fetch_assoc()['total'] ?? 0);
?>

<h2 class="mb-3" style="text-transform:lowercase;">dashboard</h2>
<hr class="mb-4">

<div class="text-center my-4">
  <div class="mb-2 fs-5 text-muted">Selamat Datang,</div>
  <div class="mb-3" style="font-size:40px; font-weight:700; color:#d63384;">
    <?= htmlspecialchars($username); ?>
  </div>

  <?php if ($fotoPath): ?>
    <img src="<?= $fotoPath ?>" class="rounded-circle shadow"
         style="width:220px; height:220px; object-fit:cover; border:6px solid #111;">
  <?php else: ?>
    <div class="text-muted">Belum ada foto profil.</div>
  <?php endif; ?>
</div>

<div class="row justify-content-center g-3 mt-4">
  <div class="col-md-4">
    <a href="admin.php" class="text-decoration-none">
      <div class="card shadow-sm border-0">
        <div class="card-body d-flex justify-content-between align-items-center p-4">
          <div class="fw-semibold text-dark">📰 Article</div>
          <div class="rounded-circle d-flex align-items-center justify-content-center"
               style="width:56px;height:56px;background:#d63384;color:#fff;font-weight:700;font-size:20px;">
            <?= $articleCount ?>
          </div>
        </div>
      </div>
    </a>
  </div>

  <div class="col-md-4">
    <a href="gallery.php" class="text-decoration-none">
      <div class="card shadow-sm border-0">
        <div class="card-body d-flex justify-content-between align-items-center p-4">
          <div class="fw-semibold text-dark">🖼️ Gallery</div>
          <div class="rounded-circle d-flex align-items-center justify-content-center"
               style="width:56px;height:56px;background:#d63384;color:#fff;font-weight:700;font-size:20px;">
            <?= $galleryCount ?>
          </div>
        </div>
      </div>
    </a>
  </div>
</div>

<?php include "footer.php"; ?>