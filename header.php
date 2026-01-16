<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= isset($page_title) ? htmlspecialchars($page_title) : "DailyJournal"; ?></title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>

  <style>
    :root{
      --pink:#ff4da6;
      --pink-hover:#ff2f98;
    }

    .navbar-pink{ background-color: var(--pink) !important; }

    .btn-primary{
      background-color: var(--pink) !important;
      border-color: var(--pink) !important;
    }
    .btn-primary:hover{
      background-color: var(--pink-hover) !important;
      border-color: var(--pink-hover) !important;
    }

    .table-dark{ background-color: var(--pink) !important; }

    .navbar-toggler{ border-color: rgba(255,255,255,0.65) !important; }
    .navbar-toggler-icon{ filter: brightness(0) invert(1); }

    .nav-link.active{
      font-weight: 600;
      text-decoration: underline;
      text-underline-offset: 6px;
    }
  </style>
</head>

<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-pink">
  <div class="container">
    <a class="navbar-brand fw-semibold text-white" href="dashboard.php">DailyJournal</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu"
      aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navMenu">
      <?php if (isset($_SESSION['username'])): ?>
        <?php $current = basename($_SERVER['PHP_SELF']); ?>

        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link text-white <?= ($current === 'dashboard.php') ? 'active' : ''; ?>" href="dashboard.php">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white <?= ($current === 'admin.php') ? 'active' : ''; ?>" href="admin.php">Article</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white <?= ($current === 'gallery.php') ? 'active' : ''; ?>" href="gallery.php">Gallery</a>
          </li>
        </ul>

        <div class="d-flex gap-2 align-items-center">
          <span class="navbar-text text-white">
            Hi, <?= htmlspecialchars($_SESSION['username']); ?>
          </span>
          <a class="btn btn-outline-light btn-sm" href="profile.php">Profile</a>
          <a class="btn btn-outline-light btn-sm" href="logout.php">Logout</a>
        </div>
      <?php else: ?>
        <div class="ms-auto">
          <a class="btn btn-outline-light btn-sm" href="login.php">Login</a>
        </div>
      <?php endif; ?>
    </div>
  </div>
</nav>

<div class="container py-4">
