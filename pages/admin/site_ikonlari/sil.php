<?php
/**
 * Dosya sorumluluğu: Site ikonu kaydını güvenli biçimde siler.
 *
 * Girdi doğrulama, yetkilendirme ve çıktı kaçışları bu dosyanın
 * mevcut güvenlik akışına uygun biçimde korunmalıdır.
 */
require_once __DIR__ . "/../includes/auth.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST" || !adminVerifyCsrf($_POST["csrf"] ?? null)) {
  adminFlashSet("danger", "Geçersiz istek.");
  header("Location: index.php");
  exit();
}

$id = (int) ($_POST["id"] ?? 0);
$stmt = $db->prepare("DELETE FROM site_ikonlari WHERE id = ?");
$stmt->execute([$id]);

if ($stmt->rowCount()) {
  adminSiraNormalize($db, "site_ikonlari");
  adminFlashSet("success", "İkon silindi.");
} else {
  adminFlashSet("danger", "Silinemedi.");
}
header("Location: index.php");
exit();
