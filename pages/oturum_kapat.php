<?php
/**
 * Sekme/tarayıcı kapanınca (sendBeacon / fetch keepalive) oturum kaydını kapatır.
 * PHP oturumu tamamen silinmez; hızlı yenilemede yanlışlıkla çıkış yapılmasını önler.
 */
include __DIR__ . "/baglan.php";

header("Content-Type: application/json; charset=utf-8");
header("Cache-Control: no-store");

$oturumId = isset($_SESSION["oturum_id"]) ? (int) $_SESSION["oturum_id"] : 0;

if ($oturumId > 0) {
  oturumClose($db, $oturumId, "sekme");
}

unset($_SESSION["oturum_id"]);

echo json_encode(["ok" => true]);
exit();
