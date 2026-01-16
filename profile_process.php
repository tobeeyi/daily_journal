<?php
include "auth.php";
include "koneksi.php";

$username = $_SESSION['username'];

$passwordBaru = trim($_POST['password_baru'] ?? '');
$gantiPassword = ($passwordBaru !== '');

$gantiFoto = (!empty($_FILES['foto']['name']) && !empty($_FILES['foto']['tmp_name']));

if (!$gantiPassword && !$gantiFoto) {
  $_SESSION['error'] = "Tidak ada perubahan yang disimpan.";
  header("Location: profile.php");
  exit;
}

$stmt = $conn->prepare("SELECT foto FROM users WHERE username=? LIMIT 1");
$stmt->bind_param("s", $username);
$stmt->execute();
$old = $stmt->get_result()->fetch_assoc();
$oldFoto = $old['foto'] ?? null;

$newHash = null;
$newFoto = null;

if ($gantiPassword) {
  if (mb_strlen($passwordBaru) < 4) {
    $_SESSION['error'] = "Password minimal 4 karakter.";
    header("Location: profile.php");
    exit;
  }
  $newHash = password_hash($passwordBaru, PASSWORD_DEFAULT);
}

if ($gantiFoto) {
  if (!is_dir("img")) {
    mkdir("img", 0777, true);
  }

  $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
  $allowed = ['jpg','jpeg','png','gif','webp'];
  if (!in_array($ext, $allowed)) {
    $_SESSION['error'] = "Format foto tidak didukung. Gunakan jpg/jpeg/png/gif/webp.";
    header("Location: profile.php");
    exit;
  }

  if (!empty($_FILES['foto']['size']) && $_FILES['foto']['size'] > 2 * 1024 * 1024) {
    $_SESSION['error'] = "Ukuran foto terlalu besar (maks 2MB).";
    header("Location: profile.php");
    exit;
  }

  $newFoto = "profile_" . $username . "_" . time() . "_" . bin2hex(random_bytes(4)) . "." . $ext;
  $target = "img/" . $newFoto;

  if (!move_uploaded_file($_FILES['foto']['tmp_name'], $target)) {
    $_SESSION['error'] = "Upload foto gagal.";
    header("Location: profile.php");
    exit;
  }

  if ($oldFoto && file_exists("img/".$oldFoto)) {
    @unlink("img/".$oldFoto);
  }
}

if ($gantiPassword && $gantiFoto) {
  $q = $conn->prepare("UPDATE users SET password=?, foto=? WHERE username=?");
  $q->bind_param("sss", $newHash, $newFoto, $username);
  $q->execute();
} elseif ($gantiPassword) {
  $q = $conn->prepare("UPDATE users SET password=? WHERE username=?");
  $q->bind_param("ss", $newHash, $username);
  $q->execute();
} elseif ($gantiFoto) {
  $q = $conn->prepare("UPDATE users SET foto=? WHERE username=?");
  $q->bind_param("ss", $newFoto, $username);
  $q->execute();
}

$_SESSION['success'] = "Profile berhasil diperbarui.";
header("Location: profile.php");
exit;
