<?php
session_start();
include "koneksi.php";

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$res = $stmt->get_result();

if ($res && $res->num_rows === 1) {
  $user = $res->fetch_assoc();
  if (password_verify($password, $user['password'])) {
    $_SESSION['username'] = $user['username'];
    // kolom nama sudah kamu hapus, jadi jangan set session nama
    header("Location: admin.php");
    exit;
  }
}

$_SESSION['error'] = "Username atau password salah!";
header("Location: login.php");
exit;
?>
