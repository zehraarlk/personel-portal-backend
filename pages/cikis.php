<?php
/**
 * Dosya sorumluluğu: Oturum kapatma işlemi.
 *
 * Girdi doğrulama, yetkilendirme ve çıktı kaçışları bu dosyanın
 * mevcut güvenlik akışına uygun biçimde korunmalıdır.
 */
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
