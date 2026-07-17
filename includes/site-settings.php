<?php
/**
 * Dosya sorumluluğu: Site görünüm ayarları.
 *
 * Girdi doğrulama, yetkilendirme ve çıktı kaçışları bu dosyanın
 * mevcut güvenlik akışına uygun biçimde korunmalıdır.
 */
declare(strict_types=1);

function siteSettingsPath(): string
{
    return PROJECT_ROOT . '/config/site-settings.json';
}

function normalizeContentPhotoFit(mixed $mode): string
{
    return $mode === 'contain' ? 'contain' : 'cover';
}

function getContentPhotoFit(): string
{
    $path = siteSettingsPath();
    if (!is_file($path)) {
        return 'cover';
    }

    $raw = @file_get_contents($path);
    if ($raw === false || $raw === '') {
        return 'cover';
    }

    $data = json_decode($raw, true);
    if (!is_array($data)) {
        return 'cover';
    }

    return normalizeContentPhotoFit($data['content_photo_fit'] ?? 'cover');
}

function setContentPhotoFit(string $mode): bool
{
    $mode = normalizeContentPhotoFit($mode);
    $path = siteSettingsPath();
    $payload = json_encode(
        ['content_photo_fit' => $mode],
        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
    );

    if ($payload === false) {
        return false;
    }

    return @file_put_contents($path, $payload . PHP_EOL, LOCK_EX) !== false;
}
