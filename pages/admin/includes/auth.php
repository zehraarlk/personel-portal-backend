<?php
/**
 * Dosya sorumluluğu: Admin erişim kontrolü ve kullanıcı bağlamı.
 *
 * Girdi doğrulama, yetkilendirme ve çıktı kaçışları bu dosyanın
 * mevcut güvenlik akışına uygun biçimde korunmalıdır.
 */
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

require_once __DIR__ . "/../../baglan.php";
require_once __DIR__ . "/../../../includes/site-settings.php";

adminRequireLogin();
dbEnsureColumn($db, "yoneticiler", "foto_url", "varchar(255) DEFAULT NULL");

$adminUser = [
  "id" => (int) ($_SESSION["yonetici_id"] ?? 0),
  "kullanici" => (string) ($_SESSION["yonetici_kullanici"] ?? ""),
  "ad" => (string) ($_SESSION["yonetici_ad"] ?? ""),
  "soyad" => (string) ($_SESSION["yonetici_soyad"] ?? ""),
  "yetki" => (string) ($_SESSION["yonetici_yetki"] ?? "editor"),
  "gorunen_ad" => trim((string) ($_SESSION["yonetici_kullanici"] ?? "")) !== ""
    ? trim((string) $_SESSION["yonetici_kullanici"])
    : trim(
      trim((string) ($_SESSION["yonetici_ad"] ?? "")) .
        " " .
        trim((string) ($_SESSION["yonetici_soyad"] ?? "")),
    ),
  "rol_etiket" => adminYetkiLabel((string) ($_SESSION["yonetici_yetki"] ?? "editor")),
];

$adminInSubfolder = (bool) preg_match("#/admin/[^/]+/#", $_SERVER["PHP_SELF"] ?? "");
$adminBase = $adminInSubfolder ? "../" : "";
$siteBase = $adminInSubfolder ? "../../" : "../";
$assetBase = $adminInSubfolder ? "../../../" : "../../";
$adminOturumKapatUrl = $siteBase . "admin_oturum_kapat.php";
