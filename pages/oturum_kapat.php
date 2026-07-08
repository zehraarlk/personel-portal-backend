<?php
/**
 * Sekme/tarayıcı kapanınca (sendBeacon / fetch keepalive) oturumu kapatır.
 * Session cookie otomatik gönderilir.
 */
include __DIR__ . "/baglan.php";

header("Content-Type: application/json; charset=utf-8");
header("Cache-Control: no-store");

$oturumId = isset($_SESSION["oturum_id"]) ? (int)$_SESSION["oturum_id"] : 0;
$personelId = isset($_SESSION["personel_id"]) ? (int)$_SESSION["personel_id"] : null;

if ($oturumId > 0) {
    oturumClose($db, $oturumId, "sekme");
}

authClearRememberToken($db, $personelId);

$_SESSION = [];
if (ini_get("session.use_cookies")) {
    $p = session_get_cookie_params();
    setcookie(session_name(), "", [
        "expires"  => time() - 42000,
        "path"     => $p["path"],
        "domain"   => $p["domain"],
        "secure"   => $p["secure"],
        "httponly" => $p["httponly"],
        "samesite" => $p["samesite"] ?? "Lax",
    ]);
}
session_destroy();

echo json_encode(["ok" => true]);
exit;
