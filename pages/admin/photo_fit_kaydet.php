<?php
/**
 * Dosya sorumluluğu:  yönetim işlemlerini yürütür.
 *
 * Girdi doğrulama, yetkilendirme ve çıktı kaçışları bu dosyanın
 * mevcut güvenlik akışına uygun biçimde korunmalıdır.
 */
declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'message' => 'Geçersiz istek.'], JSON_UNESCAPED_UNICODE);
    exit;
}

$csrf = $_POST['csrf'] ?? null;
if ($csrf === null) {
    $raw = file_get_contents('php://input');
    $json = is_string($raw) ? json_decode($raw, true) : null;
    if (is_array($json)) {
        $csrf = $json['csrf'] ?? null;
        $_POST['mode'] = $json['mode'] ?? ($_POST['mode'] ?? null);
    }
}

if (!adminVerifyCsrf(is_string($csrf) ? $csrf : null)) {
    http_response_code(403);
    echo json_encode(['ok' => false, 'message' => 'Geçersiz güvenlik anahtarı.'], JSON_UNESCAPED_UNICODE);
    exit;
}

$mode = normalizeContentPhotoFit($_POST['mode'] ?? 'cover');

if (!setContentPhotoFit($mode)) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'message' => 'Ayar kaydedilemedi.'], JSON_UNESCAPED_UNICODE);
    exit;
}

echo json_encode([
    'ok' => true,
    'mode' => $mode,
    'message' => 'Fotoğraf görünümü kaydedildi.',
], JSON_UNESCAPED_UNICODE);
