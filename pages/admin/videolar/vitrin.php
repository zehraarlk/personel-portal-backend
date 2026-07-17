<?php
/**
 * Dosya sorumluluğu: Video vitrin durumunu günceller.
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
if (dbSetVitrinVideo($db, $id)) {
  adminFlashSet("success", "Haftanın videosu güncellendi.");
} else {
  adminFlashSet("danger", "Video bulunamadı veya güncellenemedi.");
}

header("Location: index.php");
exit();
