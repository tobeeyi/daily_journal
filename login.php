<?php
session_start();
$page_title = "Login - DailyJournal";
include "header.php";
?>
<div class="row justify-content-center">
  <div class="col-md-5 col-lg-4">
    <div class="card shadow-sm border-0">
      <div class="card-body p-4">
        <h4 class="mb-1">Login Admin</h4>

        <?php if (isset($_SESSION['error'])): ?>
          <div class="alert alert-danger py-2"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <form action="login_process.php" method="POST" class="vstack gap-3">
          <div>
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required autocomplete="username">
          </div>
          <div>
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required autocomplete="current-password">
          </div>
          <button class="btn btn-dark w-100">Login</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include "footer.php"; ?>
