<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/site-settings.php';
require_once __DIR__ . '/db-helpers.php';
require_once __DIR__ . '/view-helpers.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$assetBase = getAssetBase();

require_once __DIR__ . '/auth-helpers.php';

$portalPublicScripts = ['oturum_kapat.php'];
$portalScriptName = basename($_SERVER['SCRIPT_FILENAME'] ?? '');
$portalSessionActive = false;
$portalSessionGuard = false;
$portalOturumKapatUrl = portalPageUrl('oturum_kapat.php');

if (!in_array($portalScriptName, $portalPublicScripts, true)) {
    requirePortalLogin($assetBase);
    $portalSessionActive = true;
    $portalSessionGuard = !empty($_SESSION['personel_id']) && empty($_SESSION['yonetici_id']);
}

$userType = 'personel';
$userName = 'Misafir';
$userTitle = 'Personel';
$userPhoto = faviconUrl($assetBase);
$userId = 0;

try {
    $userProfile = loadCurrentUserProfile(getPDO(), $assetBase);
    $userType = (string) $userProfile['userType'];
    $userName = (string) $userProfile['userName'];
    $userTitle = (string) $userProfile['userTitle'];
    $userPhoto = faviconUrl($assetBase);
    $userId = (int) $userProfile['id'];
} catch (Throwable $e) {
    error_log('Profil yukleme hatasi: ' . $e->getMessage());
}

$profileInitial = mb_strtoupper(mb_substr($userName, 0, 1, 'UTF-8'), 'UTF-8');
