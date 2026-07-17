<?php
/**
 * Dosya sorumluluğu: Kamu portalı başlangıç ve oturum yükleyicisi.
 *
 * Girdi doğrulama, yetkilendirme ve çıktı kaçışları bu dosyanın
 * mevcut güvenlik akışına uygun biçimde korunmalıdır.
 */
/**
 * Kamu portal sayfalarının ortak başlangıç dosyası.
 *
 * Sıra:
 * 1) Config + yardımcılar yüklenir
 * 2) Oturum başlar
 * 3) Giriş zorunluluğu kontrol edilir (requirePortalLogin)
 * 4) Navbar için kullanıcı profili doldurulur
 *
 * Ana sayfa, duyurular, etkinlikler vb. bu dosyayı include eder.
 */
declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/site-settings.php';
require_once __DIR__ . '/db-helpers.php';
require_once __DIR__ . '/view-helpers.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/** CSS/JS/görsel yolları için göreli kök (ör. ../ veya ../../). */
$assetBase = getAssetBase();

require_once __DIR__ . '/auth-helpers.php';

/** Oturum kapatma uçları giriş kontrolünden muaf tutulur. */
$portalPublicScripts = ['oturum_kapat.php'];
$portalScriptName = basename($_SERVER['SCRIPT_FILENAME'] ?? '');
$portalSessionActive = false;
$portalSessionGuard = false;
$portalOturumKapatUrl = portalPageUrl('oturum_kapat.php');

if (!in_array($portalScriptName, $portalPublicScripts, true)) {
    // Personel veya yönetici oturumu yoksa login’e yönlendirir.
    requirePortalLogin($assetBase);
    $portalSessionActive = true;
    // Sekme kapanınca personel oturumunu kapatan JS yalnızca personelde aktif.
    $portalSessionGuard = !empty($_SESSION['personel_id']) && empty($_SESSION['yonetici_id']);
}

$userType = 'personel';
$userName = 'Misafir';
$userTitle = 'Personel';
$userPhoto = faviconUrl($assetBase);
$userPhotoIsBrand = true;
$userId = 0;

try {
    $userProfile = loadCurrentUserProfile(getPDO(), $assetBase);
    $userType = (string) $userProfile['userType'];
    $userName = (string) $userProfile['userName'];
    $userTitle = (string) $userProfile['userTitle'];
    $userPhoto = (string) ($userProfile['userPhoto'] ?: faviconUrl($assetBase));
    $userPhotoIsBrand = !empty($userProfile['userPhotoIsBrand']);
    $userId = (int) $userProfile['id'];
} catch (Throwable $e) {
    error_log('Profil yukleme hatasi: ' . $e->getMessage());
}

$profileInitial = mb_strtoupper(mb_substr($userName, 0, 1, 'UTF-8'), 'UTF-8');
