<?php
/**
 * Dosya sorumluluğu: Kaynak dosyası indirme ve görüntüleme uç noktası.
 *
 * Girdi doğrulama, yetkilendirme ve çıktı kaçışları bu dosyanın
 * mevcut güvenlik akışına uygun biçimde korunmalıdır.
 */
declare(strict_types=1);

require_once __DIR__ . '/../includes/init.php';

$id = (int) ($_GET['id'] ?? 0);
$inline = isset($_GET['inline']) && (string) $_GET['inline'] === '1';
$row = fetchKaynakById(getPDO(), $id);

if ($row === null) {
    http_response_code(404);
    header('Content-Type: text/plain; charset=utf-8');
    echo 'Dosya bulunamadı.';
    exit;
}

$dbPath = trim((string) ($row['onizleme'] ?? ''));
if ($dbPath === '') {
    $dbPath = trim((string) ($row['dosya_yolu'] ?? ''));
}

if (preg_match('#^https?://#i', $dbPath)) {
    header('Location: ' . $dbPath, true, 302);
    exit;
}

$info = kaynakLocalFileInfo($dbPath);
if ($info === null) {
    http_response_code(404);
    header('Content-Type: text/plain; charset=utf-8');
    echo 'Dosya bulunamadı.';
    exit;
}

$disposition = $inline ? 'inline' : 'attachment';
$safeName = str_replace(['"', "\r", "\n"], '', $info['name']);

header('Content-Type: ' . $info['mime']);
header('Content-Length: ' . (string) filesize($info['path']));
header('Content-Disposition: ' . $disposition . '; filename="' . $safeName . '"');
header('X-Content-Type-Options: nosniff');
header('Cache-Control: private, max-age=0, must-revalidate');

readfile($info['path']);
exit;
