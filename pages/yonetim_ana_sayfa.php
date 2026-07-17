<?php
/**
 * Dosya sorumluluğu: Yönetim paneli yönlendirme sayfası.
 *
 * Girdi doğrulama, yetkilendirme ve çıktı kaçışları bu dosyanın
 * mevcut güvenlik akışına uygun biçimde korunmalıdır.
 */
declare(strict_types=1);

header('Location: admin/index.php', true, 302);
exit;
