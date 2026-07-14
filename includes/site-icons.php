<?php
declare(strict_types=1);

/**
 * site_ikonlari satırlarını anahtar => satır olarak yükler.
 *
 * @return array<string, array{anahtar:string,ad:string,ikon_sinifi:string,renk:?string}>
 */
function loadSiteIkonlariMap(): array
{
    static $cache = null;

    if (is_array($cache)) {
        return $cache;
    }

    $cache = [];

    try {
        if (!function_exists('getPDO') || !function_exists('dbTableExists')) {
            return $cache;
        }

        $pdo = getPDO();

        if (!dbTableExists($pdo, 'site_ikonlari')) {
            return $cache;
        }

        $rows = dbFetchAll(
            $pdo,
            'SELECT anahtar, ad, ikon_sinifi, renk
             FROM site_ikonlari
             WHERE aktif = 1
             ORDER BY sira ASC, id ASC'
        );

        foreach ($rows as $row) {
            $key = trim((string) ($row['anahtar'] ?? ''));
            $class = trim((string) ($row['ikon_sinifi'] ?? ''));

            if ($key === '' || $class === '') {
                continue;
            }

            $cache[$key] = [
                'anahtar' => $key,
                'ad' => (string) ($row['ad'] ?? $key),
                'ikon_sinifi' => $class,
                'renk' => isset($row['renk']) && $row['renk'] !== '' ? (string) $row['renk'] : null,
            ];
        }
    } catch (Throwable $e) {
        error_log('site_ikonlari yukleme hatasi: ' . $e->getMessage());
        $cache = [];
    }

    return $cache;
}

function siteIconAnahtarAlias(string $name): string
{
    static $aliases = [
        'home' => 'anasayfa',
        'video' => 'videolar',
        'calendar' => 'etkinlik_sayfa',
        'inbox' => 'sizden_gelenler',
        'megaphone' => 'duyurular',
        'bell' => 'duyuru_zili',
        'protocol' => 'protokoller',
        'document' => 'dokumanlar',
        'law' => 'mevzuatlar',
        'education' => 'egitimler',
        'poll' => 'anketler',
        'link' => 'yardimci_linkler',
        'ribbon' => 'vefat_bilgisi',
        'cake' => 'dogum_gunu',
        'settings' => 'yonetim_paneli',
        'info' => 'oturum_bilgileri',
        'mail' => 'email_degistir',
        'key' => 'sifre_degistir',
        'logout' => 'cikis_yap',
        'menu' => 'menu_ac',
        'search' => 'arama',
        'phone' => 'telefon',
        'eye' => 'goruntulenme',
        'user' => 'kullanici',
        'play' => 'video_oynat',
        'external-link' => 'harici_baglanti',
        'desktop' => 'otomasyon_sistem',
        'star' => 'anket_favori_dolu',
        'star-outline' => 'anket_favori_bos',
        'clock' => 'oturum_saati',
        'check' => 'islem_basarili_bi',
        'chevron-left' => 'onceki',
        'chevron-right' => 'sonraki',
        'shield' => 'yonetim_guvenlik_bi',
        'eye-off' => 'sifre_gizle_bi',
        'loader' => 'islem_yukleniyor_bi',
        'tag' => 'dokumanlar',
    ];

    return $aliases[$name] ?? $name;
}

function siteIconRow(string $name): ?array
{
    $map = loadSiteIkonlariMap();
    $key = trim($name);

    if ($key !== '' && isset($map[$key])) {
        return $map[$key];
    }

    $alias = siteIconAnahtarAlias($key);

    return $map[$alias] ?? null;
}

function siteIconClass(string $name): string
{
    $row = siteIconRow($name);

    return $row['ikon_sinifi'] ?? '';
}
