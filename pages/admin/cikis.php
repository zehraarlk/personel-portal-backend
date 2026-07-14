<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
require_once __DIR__ . "/../baglan.php";

$oturumId = (int) ($_SESSION["yonetici_oturum_id"] ?? 0);
if ($oturumId > 0) {
  yoneticiOturumClose($db, $oturumId, "manuel");
}

adminSessionClear();

if (ini_get("session.use_cookies")) {
  $p = session_get_cookie_params();
  setcookie(session_name(), "", [
    "expires" => time() - 42000,
    "path" => $p["path"],
    "domain" => $p["domain"],
    "secure" => $p["secure"],
    "httponly" => $p["httponly"],
    "samesite" => $p["samesite"] ?? "Lax",
  ]);
}
session_destroy();

header("Location: " . adminLoginUrl());
exit();
