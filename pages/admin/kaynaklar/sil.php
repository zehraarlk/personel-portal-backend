<?php
/**
 * Dosya sorumluluğu: Kaynak kaydını güvenli biçimde siler.
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
$stmt = $db->prepare("DELETE FROM kaynaklar WHERE id = ?");
$stmt->execute([$id]);
adminFlashSet(
  $stmt->rowCount() ? "success" : "danger",
  $stmt->rowCount() ? "Kaynak silindi." : "Silinemedi.",
);
header("Location: index.php");
exit();
