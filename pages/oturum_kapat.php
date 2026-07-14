<?php
<<<<<<< HEAD
declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth-helpers.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

handlePersonelOturumKapatPost();
=======
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
>>>>>>> da0ab1ce9c2e683fa29c9cbbff849780f358e71f
