<?php
include "auth.php";
include "koneksi.php";

$page_title = "Profile - DailyJournal";
include "header.php";

$username = $_SESSION['username'];

$stmt = $conn->prepare("SELECT username, foto FROM users WHERE username=? LIMIT 1");
$stmt->bind_param("s", $username);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
  echo "<div class='alert alert-danger'>User tidak ditemukan.</div>";
  include "footer.php";
  exit;
}

$foto = $user['foto'] ?? null;
$fotoPath = ($foto && file_exists("img/".$foto)) ? "img/".htmlspecialchars($foto) : null;
?>

<h3 class="mb-3">Profile</h3>

<?php if (isset($_SESSION['success'])): ?>
  <div class="alert alert-success py-2">
    <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
  </div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
  <div class="alert alert-danger py-2">
    <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
  </div>
<?php endif; ?>

<div class="row">
  <div class="col-lg-7">
    <div class="card shadow-sm border-0">
      <div class="card-body p-4">
        <form action="profile_process.php" method="POST" enctype="multipart/form-data" class="vstack gap-3">

          <div>
            <label class="form-label">Username</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($user['username']); ?>" readonly>
          </div>

          <div>
            <label class="form-label">Ganti Password</label>
            <input type="password" name="password_baru" class="form-control"
                   placeholder="Isi jika ingin mengganti password">
            <div class="form-text">Kosongkan jika tidak ingin mengganti password.</div>
          </div>

          <div>
            <label class="form-label">Ganti Foto Profil</label>
            <input type="file" name="foto" class="form-control" accept="image/*">
            <div class="form-text">Format: jpg/jpeg/png/gif/webp, max 2MB.</div>
          </div>

          <div>
            <button class="btn btn-primary">Simpan</button>
          </div>

        </form>
      </div>
    </div>
  </div>

  <div class="col-lg-5 mt-3 mt-lg-0">
    <div class="card shadow-sm border-0">
      <div class="card-body p-4">
        <h6 class="mb-3">Foto Profil Saat Ini</h6>
        <?php if ($fotoPath): ?>
          <img src="<?= $fotoPath ?>" class="rounded border" style="max-width:200px; height:auto;">
        <?php else: ?>
          <div class="text-muted">Belum ada foto profil.</div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php include "footer.php"; ?>
