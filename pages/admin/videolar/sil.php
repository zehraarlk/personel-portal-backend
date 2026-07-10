<?php
require_once __DIR__ . "/../includes/auth.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  header("Location: index.php");
  exit();
}

if (!adminVerifyCsrf($_POST["csrf"] ?? null)) {
  adminFlashSet("danger", "Geçersiz istek.");
  header("Location: index.php");
  exit();
}

$id = isset($_POST["id"]) ? (int) $_POST["id"] : 0;

if ($id <= 0 || !dbDeleteVideo($db, $id)) {
  adminFlashSet("danger", "Video silinemedi veya bulunamadı.");
} else {
  adminFlashSet("success", "Video silindi.");
}

header("Location: index.php");
exit();
