<?php
/**
 * Dosya sorumluluğu: Genel amaçlı görünüm ve URL yardımcıları.
 *
 * Girdi doğrulama, yetkilendirme ve çıktı kaçışları bu dosyanın
 * mevcut güvenlik akışına uygun biçimde korunmalıdır.
 */
declare(strict_types=1);

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function getAssetBase(): string
{
    $scriptFile = $_SERVER['SCRIPT_FILENAME'] ?? '';
    $scriptDir = dirname($scriptFile !== '' ? $scriptFile : __FILE__);
    $projectRoot = PROJECT_ROOT;

    $scriptDir = str_replace('\\', '/', realpath($scriptDir) ?: $scriptDir);
    $projectRoot = str_replace('\\', '/', realpath($projectRoot) ?: $projectRoot);

    if (!str_starts_with($scriptDir, $projectRoot)) {
        return '';
    }

    $relative = trim(substr($scriptDir, strlen($projectRoot)), '/');

    if ($relative === '') {
        return '';
    }

    return str_repeat('../', substr_count($relative, '/') + 1);
}

function isHomePage(): bool
{
    $current = strtok($_SERVER['REQUEST_URI'] ?? '', '?') ?: '/';

    return (bool) preg_match('#/ana_sayfa\.php$#', $current)
        || (bool) preg_match('#/index\.php$#', $current)
        || (bool) preg_match('#/personel-portal/?$#', $current);
}

function isNavActive(string $segment): bool
{
    $current = strtok($_SERVER['REQUEST_URI'] ?? '', '?') ?: '/';
    $segment = trim($segment, '/');

    return str_contains($current, '/' . $segment . '/')
        || str_ends_with($current, '/' . $segment)
        || str_contains($current, '/' . $segment . '.php')
        || ($segment === 'etkinlikler' && str_contains($current, '/etkinlik_detay.php'))
        || ($segment === 'sizden_gelenler' && str_contains($current, '/sizden_detay.php'))
        || ($segment === 'duyurular' && (str_contains($current, '/duyurular.php') || str_contains($current, '/duyuru_detay.php')))
        || ($segment === 'protokoller' && str_contains($current, '/protokoller.php'))
        || ($segment === 'dokumanlar' && str_contains($current, '/dokumanlar.php'))
        || ($segment === 'mevzuatlar' && str_contains($current, '/mevzuatlar.php'))
        || ($segment === 'egitimler' && str_contains($current, '/egitimler.php'))
        || ($segment === 'anketler' && (str_contains($current, '/anketler.php') || str_contains($current, '/anket_katil.php') || str_contains($current, '/anket_favori.php')))
        || ($segment === 'yardimci_linkler' && str_contains($current, '/yardimci_linkler.php'))
        || ($segment === 'vefat_bilgisi' && str_contains($current, '/vefat_bilgisi.php'))
        || ($segment === 'dogum_gunu' && str_contains($current, '/dogum_gunu.php'));
}

function portalPageUrl(string $page): string
{
    $page = ltrim(str_replace('\\', '/', $page), '/');
    $assetBase = getAssetBase();
    $depth = substr_count($assetBase, '../');
    $scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
    $scriptDir = trim(dirname($scriptName), '/');
    $parts = $scriptDir !== '' ? explode('/', $scriptDir) : [];

    if ($depth > 0 && count($parts) >= $depth) {
        $parts = array_slice($parts, 0, count($parts) - $depth);
    }

    $prefix = $parts === [] ? '' : '/' . implode('/', $parts);

    return $prefix . '/pages/' . $page;
}
