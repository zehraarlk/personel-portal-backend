<?php
/**
 * Dosya sorumluluğu: Index.
 *
 * Girdi doğrulama, yetkilendirme ve çıktı kaçışları bu dosyanın
 * mevcut güvenlik akışına uygun biçimde korunmalıdır.
 */
declare(strict_types=1);

header('Location: pages/login.php', true, 302);
exit;
