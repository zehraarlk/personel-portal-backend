<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

function dbFetchAll(PDO $pdo, string $sql, array $params = []): array
{
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function dbTableExists(PDO $pdo, string $table): bool
{
    try {
        $pdo->query('SELECT 1 FROM `' . str_replace('`', '``', $table) . '` LIMIT 1');
        return true;
    } catch (Throwable) {
        return false;
    }
}

function normalizeDbImagePath(string $path): string
{
    $path = trim(str_replace('\\', '/', $path));

    if ($path === '' || preg_match('#^https?://#i', $path)) {
        return $path;
    }

    $path = preg_replace('#^(\.\./)+#', '', $path);
    $path = preg_replace('#^/?images/#', '', $path);

    return ltrim($path, '/');
}

function imageAlternateExtensions(): array
{
    return ['webp', 'png', 'jpg', 'jpeg', 'gif', 'svg'];
}

/**
 * Disk üzerinde path yoksa aynı dosya adıyla webp/png/jpg alternatiflerini dener.
 * @return array{0:string,1:string} [relativeUnderImages, fullDiskPath] or ['','']
 */
function resolveImageOnDisk(string $path): array
{
    $relative = normalizeDbImagePath($path);

    if ($relative === '' || preg_match('#^https?://#i', $relative)) {
        return ['', ''];
    }

    $fullPath = IMAGES_DIR . '/' . $relative;

    if (is_file($fullPath)) {
        return [$relative, $fullPath];
    }

    $dir = dirname($relative);
    $base = pathinfo($relative, PATHINFO_FILENAME);

    if ($base === '') {
        return ['', ''];
    }

    foreach (imageAlternateExtensions() as $ext) {
        $candidate = ($dir === '.' || $dir === '')
            ? $base . '.' . $ext
            : $dir . '/' . $base . '.' . $ext;
        $candidateFull = IMAGES_DIR . '/' . $candidate;

        if (is_file($candidateFull)) {
            return [$candidate, $candidateFull];
        }
    }

    return ['', ''];
}

function encodeImageWebPath(string $webPath): string
{
    if ($webPath === '' || preg_match('#^https?://#i', $webPath)) {
        return $webPath;
    }

    $parts = explode('/', $webPath);

    return implode('/', array_map(
        static fn(string $part): string => rawurlencode(rawurldecode($part)),
        $parts
    ));
}

function imageDiskPath(string $dbPath): string
{
    [, $full] = resolveImageOnDisk($dbPath);

    return $full;
}

function logoUrl(string $assetBase = ''): string
{
    return imgUrl(SITE_LOGO, $assetBase);
}

function faviconUrl(string $assetBase = ''): string
{
    return imgUrl(SITE_FAVICON, $assetBase);
}

function loginLogoUrl(string $assetBase = ''): string
{
    return LOGIN_LOGO_URL;
}

function loginLogoStyleAttr(): string
{
    return '--login-logo-url: url(\'' . LOGIN_LOGO_URL . '\')';
}

function imgUrl(string $path, string $assetBase = ''): string
{
    $path = trim(str_replace('\\', '/', $path));

    if ($path === '') {
        return $assetBase . encodeImageWebPath(SITE_LOGO);
    }

    if (preg_match('#^https?://#i', $path)) {
        return $path;
    }

    [$relative] = resolveImageOnDisk($path);

    if ($relative !== '') {
        return $assetBase . encodeImageWebPath('images/' . $relative);
    }

    [$logoRelative] = resolveImageOnDisk(SITE_LOGO);

    if ($logoRelative !== '') {
        return $assetBase . encodeImageWebPath('images/' . $logoRelative);
    }

    return $assetBase . encodeImageWebPath(SITE_LOGO);
}

function otomasyonLogoUrl(string $title, string $logoPath, string $assetBase): string
{
    $url = imgUrl($logoPath, $assetBase);
    $fallback = logoUrl($assetBase);

    return $url !== $fallback ? $url : '';
}

function mapEtkinliklerForJs(array $rows, string $assetBase): array
{
    return array_map(static function (array $row) use ($assetBase): array {
        return [
            'id'      => (int) $row['id'],
            'baslik'  => $row['baslik'] ?? '',
            'aciklama'=> $row['aciklama'] ?? '',
            'tarih'   => $row['tarih'] ?? '',
            'resim'   => imgUrl((string) ($row['resim'] ?? ''), $assetBase),
        ];
    }, $rows);
}

function mapDuyurularForJs(array $rows, string $assetBase): array
{
    return array_map(static function (array $row) use ($assetBase): array {
        return [
            'id'       => (int) $row['id'],
            'baslik'   => $row['baslik'] ?? '',
            'aciklama' => $row['aciklama'] ?? '',
            'resim'    => imgUrl((string) ($row['resim'] ?? ''), $assetBase),
        ];
    }, $rows);
}

function mapPersonelForJs(array $rows, string $assetBase): array
{
    return array_map(static function (array $row) use ($assetBase): array {
        return [
            'id'      => (int) $row['id'],
            'ad'      => $row['ad'] ?? '',
            'soyad'   => $row['soyad'] ?? '',
            'fotoUrl' => imgUrl((string) ($row['foto_url'] ?? ''), $assetBase),
        ];
    }, $rows);
}

function mapYoneticiYetkiLabel(string $yetki): string
{
    return match ($yetki) {
        'super'  => 'Sistem Yöneticisi',
        'editor' => 'İçerik Yöneticisi',
        default  => 'Yönetici',
    };
}

function loadCurrentUserProfile(PDO $pdo, string $assetBase): array
{
    $photo = faviconUrl($assetBase);

    if (!empty($_SESSION['yonetici_id'])) {
        $row = dbFetchOne(
            $pdo,
            'SELECT id, ad, soyad, yetki FROM yoneticiler WHERE id = ? AND aktif = 1 LIMIT 1',
            [(int) $_SESSION['yonetici_id']]
        );

        if ($row !== null) {
            return [
                'userType'  => 'yonetici',
                'userName'  => trim(($row['ad'] ?? '') . ' ' . ($row['soyad'] ?? '')),
                'userTitle' => mapYoneticiYetkiLabel((string) ($row['yetki'] ?? '')),
                'userPhoto' => $photo,
                'id'        => (int) $row['id'],
            ];
        }
    }

    $personelId = !empty($_SESSION['personel_id'])
        ? (int) $_SESSION['personel_id']
        : 0;

    if ($personelId > 0) {
        $row = dbFetchOne(
            $pdo,
            'SELECT id, ad, soyad FROM personeller WHERE id = ? LIMIT 1',
            [$personelId]
        );
    } elseif (!empty($_SESSION['yonetici_id'])) {
        $row = null;
    } else {
        $row = null;
    }

    if ($row !== null) {
        return [
            'userType'  => 'personel',
            'userName'  => trim(($row['ad'] ?? '') . ' ' . ($row['soyad'] ?? '')),
            'userTitle' => 'Personel',
            'userPhoto' => $photo,
            'id'        => (int) $row['id'],
        ];
    }

    return [
        'userType'  => 'personel',
        'userName'  => 'Misafir',
        'userTitle' => 'Personel',
        'userPhoto' => $photo,
        'id'        => 0,
    ];
}

function jsonData(array $data): string
{
    return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
}

function dbFetchOne(PDO $pdo, string $sql, array $params = []): ?array
{
    $rows = dbFetchAll($pdo, $sql, $params);

    return $rows[0] ?? null;
}

function youtubeThumbUrl(string $youtubeId): string
{
    $youtubeId = trim($youtubeId);

    if ($youtubeId === '') {
        return '';
    }

    return 'https://img.youtube.com/vi/' . rawurlencode($youtubeId) . '/hqdefault.jpg';
}

function fetchVitrinVideo(PDO $pdo): ?array
{
    $video = dbFetchOne(
        $pdo,
        'SELECT v.*, k.slug AS kategori_slug, k.ad AS kategori_ad
         FROM videolar v
         LEFT JOIN videolar_kategori k ON k.id = v.kategori_id
         WHERE v.vitrin = 1
         ORDER BY v.id DESC
         LIMIT 1'
    );

    if ($video !== null) {
        return $video;
    }

    return dbFetchOne(
        $pdo,
        'SELECT v.*, k.slug AS kategori_slug, k.ad AS kategori_ad
         FROM videolar v
         LEFT JOIN videolar_kategori k ON k.id = v.kategori_id
         ORDER BY v.id ASC
         LIMIT 1'
    );
}

function fetchVideolarList(PDO $pdo): array
{
    return dbFetchAll(
        $pdo,
        'SELECT v.*, k.slug AS kategori_slug, k.ad AS kategori_ad
         FROM videolar v
         LEFT JOIN videolar_kategori k ON k.id = v.kategori_id
         ORDER BY v.id DESC'
    );
}

function mapVideosForJs(array $rows): array
{
    return array_map(static function (array $row): array {
        $youtubeId = (string) ($row['youtube_id'] ?? '');

        return [
            'id'         => (int) ($row['id'] ?? 0),
            'youtubeId'  => $youtubeId,
            'baslik'     => (string) ($row['baslik'] ?? ''),
            'aciklama'   => (string) ($row['aciklama'] ?? ''),
            'sure'       => (string) ($row['sure'] ?? ''),
            'kategori'   => (string) ($row['kategori_slug'] ?? 'etkinlikler'),
            'kategoriAd' => (string) ($row['kategori_ad'] ?? 'Etkinlikler'),
            'thumb'      => youtubeThumbUrl($youtubeId),
        ];
    }, $rows);
}

function loadVideolarData(): array
{
    $pdo = getPDO();
    $vitrinVideo = fetchVitrinVideo($pdo);
    $tumVideolar = mapVideosForJs(fetchVideolarList($pdo));

    if ($vitrinVideo !== null) {
        $vitrinId = (int) $vitrinVideo['id'];
        $tumVideolar = array_values(array_filter(
            $tumVideolar,
            static fn(array $video): bool => (int) $video['id'] !== $vitrinId
        ));
    }

    $vitrinBaslik = "Gebze'de Offroad Heyecanı";
    $vitrinAciklama = 'Belediyemizin yürüttüğü son projeler ve önemli gelişmeler...';
    $vitrinYoutubeId = 'qLqYPQgUPEc';

    if ($vitrinVideo !== null) {
        $vitrinBaslik = (string) ($vitrinVideo['vitrin_baslik'] ?? $vitrinVideo['baslik'] ?? $vitrinBaslik);
        $vitrinAciklama = (string) ($vitrinVideo['vitrin_aciklama'] ?? $vitrinVideo['aciklama'] ?? $vitrinAciklama);
        $vitrinYoutubeId = (string) ($vitrinVideo['youtube_id'] ?? $vitrinYoutubeId);
    }

    return [
        'vitrinBaslik'    => $vitrinBaslik,
        'vitrinAciklama'  => $vitrinAciklama,
        'vitrinYoutubeId' => $vitrinYoutubeId,
        'vitrinThumb'     => youtubeThumbUrl($vitrinYoutubeId),
        'videolar'        => $tumVideolar,
    ];
}

function getTurkishDateLabel(): string
{
    $aylar = ['', 'Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'];
    $gunler = ['Pazar', 'Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi'];

    return date('d') . ' ' . $aylar[(int) date('m')] . ' ' . date('Y') . ' ' . $gunler[(int) date('w')];
}

function loadAnasayfaData(string $assetBase): array
{
    $pdo = getPDO();

    $haberler = mapEtkinliklerForJs(
        dbFetchAll($pdo, 'SELECT * FROM etkinlikler ORDER BY tarih DESC, id DESC'),
        $assetBase
    );

    $duyurular = mapDuyurularForJs(
        dbFetchAll($pdo, 'SELECT * FROM anasayfa_duyurular ORDER BY id DESC'),
        $assetBase
    );

    $personeller = mapPersonelForJs(
        dbFetchAll($pdo, 'SELECT * FROM personeller ORDER BY ad'),
        $assetBase
    );

    $otomasyonLinkleri = dbTableExists($pdo, 'anasayfa_linkler')
        ? dbFetchAll($pdo, 'SELECT * FROM anasayfa_linkler ORDER BY id')
        : (dbTableExists($pdo, 'yardimci_linkler')
            ? dbFetchAll($pdo, 'SELECT * FROM yardimci_linkler WHERE kategori = ? ORDER BY id', ['kurum-ici'])
            : []);

    $dogumGunu = mapPersonelForJs(
        dbFetchAll(
            $pdo,
            'SELECT * FROM personeller
             WHERE MONTH(dogum_tarihi) = MONTH(NOW()) AND DAY(dogum_tarihi) = DAY(NOW())
             ORDER BY ad'
        ),
        $assetBase
    );

    return [
        'haberler'           => $haberler,
        'duyurular'          => $duyurular,
        'personeller'          => $personeller,
        'otomasyonLinkleri'  => $otomasyonLinkleri,
        'dogumGunu'          => $dogumGunu,
        'ilkHaber'           => $haberler[0] ?? null,
        'bugunTarih'         => getTurkishDateLabel(),
    ];
}

function fetchSizdenGelenlerList(PDO $pdo): array
{
    return dbFetchAll(
        $pdo,
        'SELECT sg.*, k.slug AS kategori_slug, k.ad AS kategori_adi
         FROM sizden_gelenler sg
         LEFT JOIN sizdengelenler_kategori k ON sg.kategori_id = k.id
         ORDER BY sg.tarih DESC'
    );
}

function mapSizdenGelenlerForJs(array $rows, string $assetBase): array
{
    return array_map(static function (array $row) use ($assetBase): array {
        return [
            'id'           => (int) ($row['id'] ?? 0),
            'title'        => (string) ($row['baslik'] ?? ''),
            'excerpt'      => (string) ($row['ozet'] ?? ''),
            'category'     => (string) ($row['kategori_slug'] ?? ''),
            'categoryName' => (string) ($row['kategori_adi'] ?? ''),
            'date'         => !empty($row['tarih']) ? date('d.m.Y', strtotime((string) $row['tarih'])) : '',
            'dateSort'     => (string) ($row['tarih'] ?? ''),
            'views'        => (int) ($row['goruntulenme'] ?? 0),
            'image'        => imgUrl((string) ($row['gorsel_yolu'] ?? ''), $assetBase),
        ];
    }, $rows);
}

function loadSizdenGelenlerData(string $assetBase): array
{
    $pdo = getPDO();
    $rows = fetchSizdenGelenlerList($pdo);

    return [
        'kayitlar' => mapSizdenGelenlerForJs($rows, $assetBase),
        'toplam'   => count($rows),
    ];
}

function mapEtkinliklerListForJs(array $rows, string $assetBase): array
{
    return array_map(static function (array $row) use ($assetBase): array {
        return [
            'id'           => (int) ($row['id'] ?? 0),
            'title'        => (string) ($row['baslik'] ?? ''),
            'excerpt'      => excerptText((string) ($row['aciklama'] ?? ''), 120),
            'categoryName' => '',
            'date'         => formatDetailDate((string) ($row['tarih'] ?? '')),
            'dateSort'     => (string) ($row['tarih'] ?? ''),
            'views'        => (int) ($row['view'] ?? 0),
            'image'        => imgUrl((string) ($row['resim'] ?? ''), $assetBase),
        ];
    }, $rows);
}

function loadEtkinliklerListData(string $assetBase): array
{
    $pdo = getPDO();
    $rows = dbFetchAll($pdo, 'SELECT * FROM etkinlikler ORDER BY tarih DESC, id DESC');

    return [
        'kayitlar' => mapEtkinliklerListForJs($rows, $assetBase),
        'toplam'   => count($rows),
    ];
}

function fetchEtkinliklerDuyurularList(PDO $pdo): array
{
    if (dbTableExists($pdo, 'etkinlikler_duyurular')) {
        try {
            return dbFetchAll(
                $pdo,
                'SELECT t.*, k.slug AS alt_tip, k.ad AS kategori_adi
                 FROM etkinlikler_duyurular t
                 LEFT JOIN duyurular_kategori k ON k.id = t.kategori_id
                 ORDER BY t.tarih DESC, t.id DESC'
            );
        } catch (Throwable) {
            return [];
        }
    }

    if (!dbTableExists($pdo, 'dokumanlar')) {
        return [];
    }

    try {
        return dbFetchAll(
            $pdo,
            'SELECT * FROM dokumanlar WHERE sayfa_tipi = ? ORDER BY id DESC',
            ['duyuru']
        );
    } catch (Throwable) {
        return [];
    }
}

function mapDuyurularListForJs(array $rows, string $assetBase): array
{
    return array_map(static function (array $row) use ($assetBase): array {
        $tarih = (string) ($row['tarih'] ?? '');

        return [
            'id'           => (int) ($row['id'] ?? 0),
            'title'        => (string) ($row['baslik'] ?? ''),
            'excerpt'      => excerptText((string) ($row['aciklama'] ?? ''), 140),
            'description'  => (string) ($row['aciklama'] ?? ''),
            'category'     => (string) ($row['alt_tip'] ?? ''),
            'categoryName' => (string) ($row['kategori_adi'] ?? ''),
            'date'         => formatDetailDate($tarih),
            'dateSort'     => $tarih,
            'image'        => imgUrl((string) ($row['resim_url'] ?? $row['resim'] ?? ''), $assetBase),
            'fileUrl'      => trim((string) ($row['dosya_url'] ?? '')),
            'videoUrl'     => trim((string) ($row['video_url'] ?? '')),
        ];
    }, $rows);
}

function loadDuyurularListData(string $assetBase): array
{
    $rows = fetchEtkinliklerDuyurularList(getPDO());

    return [
        'kayitlar' => mapDuyurularListForJs($rows, $assetBase),
        'toplam'   => count($rows),
    ];
}

function kaynakFileUrl(string $path, string $assetBase = ''): string
{
    $path = trim(str_replace('\\', '/', $path));

    if ($path === '') {
        return '';
    }

    if (preg_match('#^https?://#i', $path) || str_starts_with($path, '//')) {
        return $path;
    }

    $relative = normalizeDbImagePath($path);
    [$resolvedRelative] = resolveImageOnDisk($path);

    if ($resolvedRelative !== '') {
        return $assetBase . encodeImageWebPath('images/' . $resolvedRelative);
    }

    $path = (string) preg_replace('#^(\.\./)+#', '', $path);

    return $assetBase . ltrim($path, '/');
}

function kaynakExtension(string $path): string
{
    if (preg_match('#(?:youtube\.com|youtu\.be)/#i', $path)) {
        return 'youtube';
    }

    $ext = strtolower(pathinfo(parse_url($path, PHP_URL_PATH) ?: $path, PATHINFO_EXTENSION));

    return $ext !== '' ? $ext : 'file';
}

function kaynakDateLabel(string $tarih): string
{
    $tarih = trim($tarih);

    if ($tarih === '') {
        return '';
    }

    if (preg_match('/^\d{2}\.\d{2}\.\d{4}$/', $tarih)) {
        return $tarih;
    }

    $timestamp = strtotime($tarih);

    return $timestamp !== false ? date('d.m.Y', $timestamp) : $tarih;
}

function kaynakIconName(string $kategoriSlug, string $ext = ''): string
{
    return match (true) {
        $ext === 'youtube' || str_contains($ext, 'mp4') => 'video',
        in_array($kategoriSlug, ['Eğitimler', 'egitimler'], true) => 'education',
        in_array($kategoriSlug, ['Mevzuatlar', 'mevzuatlar'], true) => 'law',
        in_array($kategoriSlug, ['Dökümanlar', 'Dokümanlar', 'dokumanlar'], true) => 'document',
        default => 'protocol',
    };
}

function fetchKaynaklarBySlug(PDO $pdo, string $slug): array
{
    if (!dbTableExists($pdo, 'kaynaklar') || !dbTableExists($pdo, 'kaynaklar_kategori')) {
        return [];
    }

    $queries = [
        'SELECT r.id, r.baslik, r.aciklama, r.ikon, r.dosya_yolu, r.resmi_sayfa, r.onizleme, r.boyut, r.tarih,
                k.slug AS kategori_slug, k.ad AS kategori_adi
         FROM kaynaklar r
         JOIN kaynaklar_kategori k ON r.kategori_id = k.id
         WHERE k.slug = ?
         ORDER BY r.tarih DESC, r.id DESC',
        'SELECT r.id, r.baslik, r.aciklama, r.ikon, r.dosya_yolu, r.resmi_sayfa, r.boyut, r.tarih,
                k.slug AS kategori_slug, k.ad AS kategori_adi
         FROM kaynaklar r
         JOIN kaynaklar_kategori k ON r.kategori_id = k.id
         WHERE k.slug = ?
         ORDER BY r.tarih DESC, r.id DESC',
        'SELECT r.id, r.baslik, r.aciklama, r.ikon, r.dosya_yolu, r.boyut, r.tarih,
                k.slug AS kategori_slug, k.ad AS kategori_adi
         FROM kaynaklar r
         JOIN kaynaklar_kategori k ON r.kategori_id = k.id
         WHERE k.slug = ?
         ORDER BY r.tarih DESC, r.id DESC',
    ];

    foreach ($queries as $sql) {
        try {
            return dbFetchAll($pdo, $sql, [$slug]);
        } catch (Throwable) {
            continue;
        }
    }

    return [];
}

function mapKaynaklarListForJs(array $rows, string $assetBase, string $fallbackCategory = ''): array
{
    return array_map(static function (array $row) use ($assetBase, $fallbackCategory): array {
        $filePath = (string) ($row['dosya_yolu'] ?? '');
        $fileUrl = kaynakFileUrl($filePath, $assetBase);
        $ext = kaynakExtension($filePath !== '' ? $filePath : $fileUrl);
        $kategoriSlug = (string) ($row['kategori_slug'] ?? $fallbackCategory);
        $kategoriAdi = (string) ($row['kategori_adi'] ?? $fallbackCategory);
        $resmiSayfa = trim((string) ($row['resmi_sayfa'] ?? ''));
        $onizlemeYolu = trim((string) ($row['onizleme'] ?? ''));

        return [
            'id'          => (int) ($row['id'] ?? 0),
            'title'       => (string) ($row['baslik'] ?? ''),
            'excerpt'     => excerptText((string) ($row['aciklama'] ?? ''), 160),
            'description' => (string) ($row['aciklama'] ?? ''),
            'category'    => $kategoriSlug,
            'categoryName'=> $kategoriAdi !== '' ? $kategoriAdi : $fallbackCategory,
            'size'        => trim((string) ($row['boyut'] ?? '')),
            'date'        => kaynakDateLabel((string) ($row['tarih'] ?? '')),
            'ext'         => strtoupper($ext === 'youtube' ? 'VIDEO' : ($ext !== 'file' ? $ext : 'PDF')),
            'fileUrl'     => $fileUrl,
            'previewUrl'  => $onizlemeYolu !== '' ? kaynakFileUrl($onizlemeYolu, $assetBase) : '',
            'officialUrl' => $resmiSayfa !== '' ? kaynakFileUrl($resmiSayfa, $assetBase) : '',
            'icon'        => kaynakIconName($kategoriSlug, $ext),
        ];
    }, $rows);
}

function loadKaynaklarListData(string $assetBase, string $slug, string $label = ''): array
{
    $rows = fetchKaynaklarBySlug(getPDO(), $slug);

    return [
        'kayitlar' => mapKaynaklarListForJs($rows, $assetBase, $label !== '' ? $label : $slug),
        'toplam'   => count($rows),
    ];
}

function kaynakNavTabs(string $assetBase, string $activeKey): array
{
    return [
        [
            'key'   => 'protocol',
            'label' => 'Protokoller',
            'href'  => $assetBase . 'pages/protokoller.php',
            'active'=> $activeKey === 'protocol',
        ],
        [
            'key'   => 'document',
            'label' => 'Dökümanlar',
            'href'  => $assetBase . 'pages/dokumanlar.php',
            'active'=> $activeKey === 'document',
        ],
        [
            'key'   => 'regulation',
            'label' => 'Mevzuatlar',
            'href'  => $assetBase . 'pages/mevzuatlar.php',
            'active'=> $activeKey === 'regulation',
        ],
        [
            'key'   => 'training',
            'label' => 'Eğitimler',
            'href'  => $assetBase . 'pages/egitimler.php',
            'active'=> $activeKey === 'training',
        ],
    ];
}

function anketStatusMeta(string $slug): array
{
    return match ($slug) {
        'pending' => ['label' => 'Beklemede', 'class' => 'is-pending', 'icon' => 'clock'],
        'completed' => ['label' => 'Tamamlandı', 'class' => 'is-completed', 'icon' => 'check'],
        'expired' => ['label' => 'Süresi Doldu', 'class' => 'is-expired', 'icon' => 'close'],
        default => ['label' => 'Aktif', 'class' => 'is-active', 'icon' => 'play'],
    };
}

function fetchAnketlerList(PDO $pdo): array
{
    if (!dbTableExists($pdo, 'anketler')) {
        return [];
    }

    $queries = [];

    if (dbTableExists($pdo, 'anketler_kategori')) {
        $queries[] = 'SELECT t.*, k.slug AS kategori, k.ad AS kategori_adi
                      FROM anketler t
                      LEFT JOIN anketler_kategori k ON k.id = t.kategori_id
                      ORDER BY t.id DESC';
    }

    $queries[] = 'SELECT * FROM anketler ORDER BY id DESC';

    foreach ($queries as $sql) {
        try {
            return dbFetchAll($pdo, $sql);
        } catch (Throwable) {
            continue;
        }
    }

    return [];
}

function fetchPersonelKatildigiAnketIds(PDO $pdo, int $personelId): array
{
    dbEnsureAnketKatilimlari($pdo);

    if ($personelId <= 0 || !dbTableExists($pdo, 'anket_katilimlari')) {
        return [];
    }

    try {
        $rows = dbFetchAll(
            $pdo,
            'SELECT anket_id FROM anket_katilimlari WHERE personel_id = ?',
            [$personelId]
        );

        return array_values(array_filter(
            array_map(static fn(array $row): int => (int) ($row['anket_id'] ?? 0), $rows),
            static fn(int $id): bool => $id > 0
        ));
    } catch (Throwable) {
        return [];
    }
}

/**
 * Oturumdaki personel kimliği (anket katılımı için).
 */
function currentAnketPersonelId(): int
{
    return (int) ($_SESSION['personel_id'] ?? 0);
}

/**
 * Personel–anket katılım tablosu.
 * Her (anket_id, personel_id) çifti en fazla bir satır; sayaç buradan türetilir.
 */
if (!function_exists('dbEnsureAnketKatilimlari')) {
    function dbEnsureAnketKatilimlari(PDO $pdo): void
    {
        static $done = false;
        if ($done) {
            return;
        }
        $done = true;

        try {
            $pdo->exec(
                "CREATE TABLE IF NOT EXISTS `anket_katilimlari` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `anket_id` int(11) NOT NULL,
                `personel_id` int(11) NOT NULL,
                `tamamlanma_tarihi` datetime NOT NULL DEFAULT current_timestamp(),
                PRIMARY KEY (`id`),
                UNIQUE KEY `uq_anket_personel` (`anket_id`,`personel_id`),
                KEY `idx_anket_katilim_personel` (`personel_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci"
            );

            if (dbTableExists($pdo, 'anket_cevaplari')) {
                $pdo->exec(
                    "INSERT IGNORE INTO `anket_katilimlari` (`anket_id`, `personel_id`, `tamamlanma_tarihi`)
                 SELECT `anket_id`, `personel_id`, MIN(`olusturma_tarihi`)
                 FROM `anket_cevaplari`
                 GROUP BY `anket_id`, `personel_id`"
                );
            }

            anketKatilimSayilariniSenkronizeEt($pdo);
        } catch (Throwable $e) {
            $done = false;
            error_log('anket_katilimlari ensure hatasi: ' . $e->getMessage());
        }
    }
}

function anketKatilimSayilariniSenkronizeEt(PDO $pdo, ?int $anketId = null): void
{
    try {
        if ($anketId !== null && $anketId > 0) {
            $row = dbFetchOne(
                $pdo,
                'SELECT COUNT(*) AS c FROM anket_katilimlari WHERE anket_id = ?',
                [$anketId]
            );
            $pdo->prepare('UPDATE anketler SET katilim_sayisi = ? WHERE id = ?')
                ->execute([(int) ($row['c'] ?? 0), $anketId]);
            return;
        }

        $pdo->exec(
            "UPDATE anketler a
             SET katilim_sayisi = (
                SELECT COUNT(*) FROM anket_katilimlari k WHERE k.anket_id = a.id
             )"
        );
    } catch (Throwable $e) {
        error_log('anket katilim sayi senkron hatasi: ' . $e->getMessage());
    }
}

function personelAnketKatildiMi(PDO $pdo, int $anketId, int $personelId): bool
{
    dbEnsureAnketKatilimlari($pdo);

    if ($anketId <= 0 || $personelId <= 0) {
        return false;
    }

    try {
        return dbFetchOne(
            $pdo,
            'SELECT id FROM anket_katilimlari WHERE anket_id = ? AND personel_id = ? LIMIT 1',
            [$anketId, $personelId]
        ) !== null;
    } catch (Throwable) {
        return false;
    }
}

/**
 * Personelin anket katılımını kaydeder ve anket.katilim_sayisi'ni günceller.
 * Aynı personel için ikinci çağrı sayacı artırmaz (UNIQUE).
 */
function anketKatilimKaydet(PDO $pdo, int $anketId, int $personelId): bool
{
    dbEnsureAnketKatilimlari($pdo);

    if ($anketId <= 0 || $personelId <= 0) {
        return false;
    }

    $stmt = $pdo->prepare(
        'INSERT IGNORE INTO anket_katilimlari (anket_id, personel_id) VALUES (?, ?)'
    );
    $stmt->execute([$anketId, $personelId]);
    $yeni = $stmt->rowCount() > 0;

    anketKatilimSayilariniSenkronizeEt($pdo, $anketId);

    return $yeni;
}

function mapAnketlerListForJs(array $rows, string $assetBase, array $participatedIds = []): array
{
    return array_map(static function (array $row) use ($assetBase, $participatedIds): array {
        $id = (int) ($row['id'] ?? 0);
        $slug = (string) ($row['kategori'] ?? 'active');
        $meta = anketStatusMeta($slug);
        $katilim = (int) ($row['katilim_sayisi'] ?? 0);
        $hedef = max(1, (int) ($row['hedef_katilim'] ?? 1));
        $yuzde = min(100, (int) round(($katilim / $hedef) * 100));
        $start = formatDetailDate((string) ($row['baslangic_tarihi'] ?? ''));
        $end = formatDetailDate((string) ($row['bitis_tarihi'] ?? ''));

        return [
            'id'           => $id,
            'title'        => (string) ($row['baslik'] ?? ''),
            'excerpt'      => excerptText((string) ($row['aciklama'] ?? ''), 140),
            'description'  => (string) ($row['aciklama'] ?? ''),
            'image'        => imgUrl((string) ($row['resim_url'] ?? ''), $assetBase),
            'category'     => $slug !== '' ? $slug : 'active',
            'statusLabel'  => $meta['label'],
            'statusClass'  => $meta['class'],
            'statusIcon'   => $meta['icon'],
            'startDate'    => $start,
            'endDate'      => $end,
            'dateLabel'    => trim($start . ($start !== '' && $end !== '' ? ' - ' : '') . $end),
            'dateSort'     => (string) ($row['baslangic_tarihi'] ?? ''),
            'participants' => $katilim,
            'target'       => $hedef,
            'percent'      => $yuzde,
            'favorite'     => (int) ($row['favori'] ?? 0) === 1,
            'participated' => in_array($id, $participatedIds, true),
            'joinUrl'      => $assetBase . 'pages/anket_katil.php?id=' . $id,
        ];
    }, $rows);
}

function loadAnketlerListData(string $assetBase): array
{
    $pdo = getPDO();
    dbEnsureAnketKatilimlari($pdo);
    $personelId = currentAnketPersonelId();
    $rows = fetchAnketlerList($pdo);
    $participated = fetchPersonelKatildigiAnketIds($pdo, $personelId);

    return [
        'kayitlar' => mapAnketlerListForJs($rows, $assetBase, $participated),
        'toplam'   => count($rows),
    ];
}

function yardimciLinkLogoDefaults(): array
{
    return [
        'OMIS' => 'images/otomasyon/omis_7572.webp',
        'Ulakbel' => 'images/otomasyon/ulakbel_5496.webp',
        'İmar Yönetim Sistemi' => 'images/otomasyon/imar-yonetim-sistemi_8038.webp',
        'Dijital Arşiv' => 'images/otomasyon/dijital-arsiv_415.webp',
        'Outlook' => 'images/otomasyon/outlook_4005.webp',
        'Sosyal Yardım' => 'images/otomasyon/sosyal-yardim_3767.webp',
        'Netcad' => 'images/otomasyon/netcad_3888.webp',
        'E-Belediye Sistemi' => 'images/otomasyon/ebys_8493.webp',
        'E-Belediye Evlendrme Modülü' => 'images/otomasyon/e-belediye-evlendirme-modulu_3993.webp',
        'E-Belediye Sosyal Yardım Modülü' => 'images/otomasyon/e-belediye-sosyal-yard-m-modulu_4432.webp',
        'Gebze Belediyesi' => 'images/yardimci_linkler/web_siteleri/gebze-belediyesi.webp',
        'Kocaeli Büyükşehir Belediyesi' => 'images/yardimci_linkler/web_siteleri/kocaeli-buyuksehir-belediyesi.webp',
        'Kocaeli Valiliği' => 'images/yardimci_linkler/web_siteleri/kocaeli-vali.webp',
        'Gebze Kaymakamlığı' => 'images/yardimci_linkler/web_siteleri/gebze-kaymakam.webp',
        'Türkiye Belediyeler Birliği' => 'images/yardimci_linkler/bilgi_portallari/turkiye-belediyeler-birligi_2430.webp',
        'Cumhurbaşkanlığı Uzaktan Eğitim Kapısı' => 'images/yardimci_linkler/bilgi_portallari/cumhur.webp',
        'BTK Akademi Eğitim Portalı' => 'images/yardimci_linkler/bilgi_portallari/btk-akademi.webp',
        'Memurlar.Net' => 'images/yardimci_linkler/faydali_linkler/memurlar.webp',
        'İlan' => 'images/yardimci_linkler/faydali_linkler/ilan.webp',
        'Resmi Gazete' => 'images/yardimci_linkler/faydali_linkler/resmi.webp',
    ];
}

function yardimciKategoriLabel(string $slug): string
{
    return match ($slug) {
        'kurum-ici' => 'Kurum İçi Linkler',
        'website' => 'Website Linkler',
        'bilgi' => 'Bilgi Portalları',
        'faydalı' => 'Faydalı Linkler',
        default => $slug !== '' ? $slug : 'Diğer',
    };
}

function resolveYardimciLinkLogo(array $row, string $assetBase): string
{
    $candidates = [];
    $logoUrl = trim((string) ($row['logo_url'] ?? ''));

    if ($logoUrl !== '') {
        $candidates[] = $logoUrl;
    }

    $baslik = trim((string) ($row['baslik'] ?? ''));
    $defaults = yardimciLinkLogoDefaults();

    if ($baslik !== '' && isset($defaults[$baslik])) {
        $candidates[] = $defaults[$baslik];
    }

    foreach ($candidates as $path) {
        $path = trim(str_replace('\\', '/', $path));

        if ($path === '') {
            continue;
        }

        if (preg_match('#^https?://#i', $path)) {
            return $path;
        }

        $disk = imageDiskPath($path);

        if ($disk !== '' && is_file($disk)) {
            return imgUrl($path, $assetBase);
        }
    }

    return '';
}

function fetchYardimciLinklerList(PDO $pdo): array
{
    if (!dbTableExists($pdo, 'yardimci_linkler')) {
        return [];
    }

    $queries = [];

    if (dbTableExists($pdo, 'yardimci_linkler_kategori')) {
        $queries[] = 'SELECT t.*, k.slug AS kategori, k.ad AS kategori_adi
                      FROM yardimci_linkler t
                      LEFT JOIN yardimci_linkler_kategori k ON k.id = t.kategori_id
                      ORDER BY t.id ASC';
    }

    $queries[] = 'SELECT * FROM yardimci_linkler ORDER BY id ASC';

    foreach ($queries as $sql) {
        try {
            return dbFetchAll($pdo, $sql);
        } catch (Throwable) {
            continue;
        }
    }

    return [];
}

function mapYardimciLinklerForJs(array $rows, string $assetBase): array
{
    return array_map(static function (array $row) use ($assetBase): array {
        $slug = (string) ($row['kategori'] ?? '');
        $label = trim((string) ($row['kategori_adi'] ?? ''));

        if ($label === '') {
            $label = yardimciKategoriLabel($slug);
        }

        return [
            'id'           => (int) ($row['id'] ?? 0),
            'title'        => (string) ($row['baslik'] ?? ''),
            'url'          => (string) ($row['hedef_url'] ?? '#'),
            'logo'         => resolveYardimciLinkLogo($row, $assetBase),
            'category'     => $slug !== '' ? $slug : 'all',
            'categoryName' => $label,
        ];
    }, $rows);
}

function loadYardimciLinklerData(string $assetBase): array
{
    $rows = fetchYardimciLinklerList(getPDO());

    return [
        'kayitlar' => mapYardimciLinklerForJs($rows, $assetBase),
        'toplam'   => count($rows),
    ];
}

function fetchVefatBilgileriList(PDO $pdo): array
{
    if (!dbTableExists($pdo, 'vefat_bilgileri')) {
        return [];
    }

    try {
        return dbFetchAll(
            $pdo,
            'SELECT * FROM vefat_bilgileri ORDER BY vefat_tarihi DESC, id DESC'
        );
    } catch (Throwable) {
        return [];
    }
}

function mapVefatBilgileriForJs(array $rows): array
{
    return array_map(static function (array $row): array {
        $dateText = trim((string) ($row['vefat_tarihi_metin'] ?? ''));

        if ($dateText === '') {
            $dateText = formatDetailDate((string) ($row['vefat_tarihi'] ?? ''));
        }

        return [
            'id'       => (int) ($row['id'] ?? 0),
            'name'     => (string) ($row['vefat_eden_adi'] ?? ''),
            'position' => (string) ($row['iliski_pozisyon'] ?? ''),
            'deathDate'=> $dateText,
            'dateSort' => (string) ($row['vefat_tarihi'] ?? ''),
            'message'  => (string) ($row['cenaze_mesaji'] ?? ''),
        ];
    }, $rows);
}

function loadVefatBilgileriData(): array
{
    $rows = fetchVefatBilgileriList(getPDO());

    return [
        'kayitlar' => mapVefatBilgileriForJs($rows),
        'toplam'   => count($rows),
    ];
}

function fetchBugunDogumGunuList(PDO $pdo): array
{
    if (!dbTableExists($pdo, 'personeller')) {
        return [];
    }

    try {
        return dbFetchAll(
            $pdo,
            'SELECT * FROM personeller
             WHERE MONTH(dogum_tarihi) = MONTH(NOW()) AND DAY(dogum_tarihi) = DAY(NOW())
             ORDER BY ad ASC, soyad ASC'
        );
    } catch (Throwable) {
        return [];
    }
}

function mapDogumGunuForJs(array $rows, string $assetBase): array
{
    return array_map(static function (array $row) use ($assetBase): array {
        return [
            'id'          => (int) ($row['id'] ?? 0),
            'ad'          => (string) ($row['ad'] ?? ''),
            'soyad'       => (string) ($row['soyad'] ?? ''),
            'sicilNo'     => (string) ($row['sicil_no'] ?? ''),
            'dogumTarihi' => (string) ($row['dogum_tarihi'] ?? ''),
            'fotoUrl'     => imgUrl((string) ($row['foto_url'] ?? ''), $assetBase),
            'fullName'    => trim((string) ($row['ad'] ?? '') . ' ' . (string) ($row['soyad'] ?? '')),
        ];
    }, $rows);
}

function loadDogumGunuData(string $assetBase): array
{
    $rows = fetchBugunDogumGunuList(getPDO());

    return [
        'kayitlar'   => mapDogumGunuForJs($rows, $assetBase),
        'toplam'     => count($rows),
        'bugunTarih' => getTurkishDateLabel(),
    ];
}

function fetchPortalDuyuruById(PDO $pdo, int $id): ?array
{
    if ($id <= 0 || !dbTableExists($pdo, 'etkinlikler_duyurular')) {
        return null;
    }

    try {
        return dbFetchOne(
            $pdo,
            'SELECT t.*, k.slug AS alt_tip, k.ad AS kategori_adi
             FROM etkinlikler_duyurular t
             LEFT JOIN duyurular_kategori k ON k.id = t.kategori_id
             WHERE t.id = ?
             LIMIT 1',
            [$id]
        );
    } catch (Throwable) {
        return null;
    }
}

function fetchOtherPortalDuyurular(PDO $pdo, int $excludeId, int $limit = 18): array
{
    if (!dbTableExists($pdo, 'etkinlikler_duyurular')) {
        return [];
    }

    try {
        return dbFetchAll(
            $pdo,
            'SELECT t.*, k.slug AS alt_tip, k.ad AS kategori_adi
             FROM etkinlikler_duyurular t
             LEFT JOIN duyurular_kategori k ON k.id = t.kategori_id
             WHERE t.id != ?
             ORDER BY t.tarih DESC, t.id DESC
             LIMIT ' . (int) $limit,
            [$excludeId]
        );
    } catch (Throwable) {
        return [];
    }
}

function formatDetailDate(string $date): string
{
    if ($date === '') {
        return '';
    }

    $timestamp = strtotime($date);

    return $timestamp !== false ? date('d.m.Y', $timestamp) : '';
}

function excerptText(string $text, int $max = 90): string
{
    $text = trim(strip_tags($text));

    if ($text === '') {
        return '';
    }

    if (mb_strlen($text, 'UTF-8') <= $max) {
        return $text;
    }

    return mb_strimwidth($text, 0, $max, '...', 'UTF-8');
}

function normalizeLookupTitle(string $title): string
{
    $title = mb_strtolower(trim($title), 'UTF-8');

    return (string) preg_replace('/\s+/u', ' ', $title);
}

function fetchEtkinlikById(PDO $pdo, int $id): ?array
{
    if ($id <= 0) {
        return null;
    }

    return dbFetchOne($pdo, 'SELECT * FROM etkinlikler WHERE id = ?', [$id]);
}

function fetchOtherEtkinlikler(PDO $pdo, int $excludeId, int $limit = 18): array
{
    return dbFetchAll(
        $pdo,
        'SELECT * FROM etkinlikler WHERE id != ? ORDER BY tarih DESC, id DESC LIMIT ' . (int) $limit,
        [$excludeId]
    );
}

function fetchAnasayfaDuyuruById(PDO $pdo, int $id): ?array
{
    if ($id <= 0) {
        return null;
    }

    return dbFetchOne($pdo, 'SELECT * FROM anasayfa_duyurular WHERE id = ?', [$id]);
}

function fetchOtherAnasayfaDuyurular(PDO $pdo, int $excludeId, int $limit = 18): array
{
    return dbFetchAll(
        $pdo,
        'SELECT * FROM anasayfa_duyurular WHERE id != ? ORDER BY id DESC LIMIT ' . (int) $limit,
        [$excludeId]
    );
}

function resolveAnasayfaDuyuruEtkinlikId(PDO $pdo, array $duyuru): ?int
{
    static $cache = [];

    $duyuruId = (int) ($duyuru['id'] ?? 0);

    if ($duyuruId > 0 && array_key_exists($duyuruId, $cache)) {
        return $cache[$duyuruId];
    }

    $needle = normalizeLookupTitle((string) ($duyuru['baslik'] ?? ''));

    if ($needle === '') {
        return $cache[$duyuruId] = null;
    }

    $needleTokens = array_values(array_filter(
        explode(' ', $needle),
        static fn(string $token): bool => mb_strlen($token, 'UTF-8') >= 3
    ));

    if (count($needleTokens) < 2) {
        return $cache[$duyuruId] = null;
    }

    $bestId = null;
    $bestScore = 0.0;

    foreach (dbFetchAll($pdo, 'SELECT id, baslik FROM etkinlikler') as $etkinlik) {
        $haystack = normalizeLookupTitle((string) ($etkinlik['baslik'] ?? ''));

        if ($haystack === '') {
            continue;
        }

        if ($needle === $haystack) {
            $score = 1.0;
        } elseif (str_contains($haystack, $needle) || str_contains($needle, $haystack)) {
            $score = 0.95;
        } else {
            $hayTokens = array_values(array_filter(
                explode(' ', $haystack),
                static fn(string $token): bool => mb_strlen($token, 'UTF-8') >= 3
            ));
            $common = count(array_intersect($needleTokens, $hayTokens));
            $score = $common >= 2 ? $common / max(count($needleTokens), count($hayTokens)) : 0.0;
        }

        if ($score > $bestScore) {
            $bestScore = $score;
            $bestId = (int) $etkinlik['id'];
        }
    }

    return $cache[$duyuruId] = ($bestScore >= 0.5 ? $bestId : null);
}

function fetchSizdenGelenById(PDO $pdo, int $id): ?array
{
    if ($id <= 0) {
        return null;
    }

    return dbFetchOne(
        $pdo,
        'SELECT sg.*, k.slug AS kategori_slug, k.ad AS kategori_adi
         FROM sizden_gelenler sg
         LEFT JOIN sizdengelenler_kategori k ON sg.kategori_id = k.id
         WHERE sg.id = ?',
        [$id]
    );
}

function fetchOtherSizdenGelenler(PDO $pdo, int $excludeId, int $limit = 18): array
{
    return dbFetchAll(
        $pdo,
        'SELECT sg.*, k.slug AS kategori_slug, k.ad AS kategori_adi
         FROM sizden_gelenler sg
         LEFT JOIN sizdengelenler_kategori k ON sg.kategori_id = k.id
         WHERE sg.id != ?
         ORDER BY sg.tarih DESC, sg.id DESC
         LIMIT ' . (int) $limit,
        [$excludeId]
    );
}

function sidebarItemImage(array $item, string $assetBase): string
{
    return imgUrl((string) ($item['resim'] ?? $item['resim_url'] ?? $item['gorsel_yolu'] ?? ''), $assetBase);
}

function sidebarItemExcerpt(array $item, int $max = 90): string
{
    return excerptText((string) ($item['aciklama'] ?? $item['ozet'] ?? ''), $max);
}