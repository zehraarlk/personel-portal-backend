<?php
/**
 * Dosya sorumluluğu: Anket katılım kaydını siler.
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

$anketId = (int) ($_POST["anket_id"] ?? 0);
$personelId = (int) ($_POST["personel_id"] ?? 0);

if ($anketId <= 0 || $personelId <= 0) {
  adminFlashSet("danger", "Geçersiz katılım.");
  header("Location: index.php");
  exit();
}

$ok = adminAnketKatilimSil($db, $anketId, $personelId);

adminFlashSet(
  $ok ? "success" : "danger",
  $ok
    ? "Katılım silindi. Personel ankete yeniden katılabilir."
    : "Katılım silinemedi veya bulunamadı.",
);

header("Location: katilimlar.php?id=" . $anketId);
exit();
