<?php
<<<<<<< HEAD
declare(strict_types=1);

require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/auth-helpers.php';

try {
    logoutCurrentUser(getPDO());
} catch (Throwable $e) {
    error_log('Cikis hatasi: ' . $e->getMessage());
}

header('Location: ' . $assetBase . 'pages/login.php');
exit;
=======
session_start();
include "baglan.php";

$pid = isset($_SESSION["personel_id"]) ? (int) $_SESSION["personel_id"] : null;
authClearRememberToken($db, $pid);

if (isset($_SESSION["oturum_id"])) {
  oturumClose($db, (int) $_SESSION["oturum_id"], "manuel");
}

$_SESSION = [];
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
header("Location: login.php");
exit();
>>>>>>> da0ab1ce9c2e683fa29c9cbbff849780f358e71f
