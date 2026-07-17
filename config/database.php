<?php
/**
 * Dosya sorumluluğu: PDO veritabanı bağlantısı.
 *
 * Girdi doğrulama, yetkilendirme ve çıktı kaçışları bu dosyanın
 * mevcut güvenlik akışına uygun biçimde korunmalıdır.
 */
/**
 * PDO veritabanı bağlantısı.
 *
 * getPDO() tek bir bağlantı örneği (singleton) döner; tekrar çağrılınca
 * yeni bağlantı açılmaz. Tüm sorgular prepared statement ile yapılmalıdır.
 */
declare(strict_types=1);

require_once __DIR__ . '/config.php';

/**
 * Paylaşılan PDO örneğini döndürür.
 *
 * @throws PDOException Bağlantı kurulamazsa
 */
function getPDO(): PDO
{
    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;

    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);

    return $pdo;
}
