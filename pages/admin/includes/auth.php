<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

require_once __DIR__ . "/../../baglan.php";

adminRequireLogin();

$adminUser = [
  "id" => (int) ($_SESSION["yonetici_id"] ?? 0),
  "kullanici" => (string) ($_SESSION["yonetici_kullanici"] ?? ""),
  "ad" => (string) ($_SESSION["yonetici_ad"] ?? ""),
  "soyad" => (string) ($_SESSION["yonetici_soyad"] ?? ""),
  "yetki" => (string) ($_SESSION["yonetici_yetki"] ?? "editor"),
];

$adminInSubfolder = (bool) preg_match("#/admin/[^/]+/#", $_SERVER["PHP_SELF"] ?? "");
$adminBase = $adminInSubfolder ? "../" : "";
$siteBase = $adminInSubfolder ? "../../" : "../";
$assetBase = $adminInSubfolder ? "../../../" : "../../";
