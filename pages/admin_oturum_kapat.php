<?php
/**
 * Yönetim paneli sekmesi/tarayıcı kapanınca oturum kaydını kapatır ve
 * yönetici oturum bilgilerini temizler; tekrar girişte şifre istenir.
 */
include __DIR__ . "/baglan.php";

header("Content-Type: application/json; charset=utf-8");
header("Cache-Control: no-store");

$oturumId = isset($_SESSION["yonetici_oturum_id"]) ? (int) $_SESSION["yonetici_oturum_id"] : 0;

if ($oturumId > 0) {
  yoneticiOturumClose($db, $oturumId, "sekme");
}

adminSessionClear();

echo json_encode(["ok" => true]);
exit();
