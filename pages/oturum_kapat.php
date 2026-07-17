<?php
/**
 * Dosya sorumluluğu: Portal oturumunu kapatma uç noktası.
 *
 * Girdi doğrulama, yetkilendirme ve çıktı kaçışları bu dosyanın
 * mevcut güvenlik akışına uygun biçimde korunmalıdır.
 */
declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth-helpers.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

handlePersonelOturumKapatPost();
