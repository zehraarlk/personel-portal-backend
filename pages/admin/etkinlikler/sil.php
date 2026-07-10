<?php
require_once __DIR__ . "/../includes/auth.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST" || !adminVerifyCsrf($_POST["csrf"] ?? null)) {
  adminFlashSet("danger", "Geçersiz istek.");
  header("Location: index.php");
  exit();
}

$id = (int) ($_POST["id"] ?? 0);
$stmt = $db->prepare("DELETE FROM etkinlikler WHERE id = ?");
$stmt->execute([$id]);
adminFlashSet(
  $stmt->rowCount() ? "success" : "danger",
  $stmt->rowCount() ? "Etkinlik silindi." : "Silinemedi.",
);
header("Location: index.php");
exit();
