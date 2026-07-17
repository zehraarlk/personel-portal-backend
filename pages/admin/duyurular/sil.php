<?php
/**
 * Dosya sorumluluğu: Duyuru kaydını güvenli biçimde siler.
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
$table = adminDuyuruTable($db);
$stmt = $db->prepare("DELETE FROM `{$table}` WHERE id = ? AND sayfa_tipi = 'duyuru'");
$stmt->execute([$id]);

adminFlashSet(
  $stmt->rowCount() ? "success" : "danger",
  $stmt->rowCount() ? "Duyuru silindi." : "Duyuru silinemedi.",
);
header("Location: index.php");
exit();
