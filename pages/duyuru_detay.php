<?php
/**
 * Dosya sorumluluğu: Duyuru detay sayfası.
 *
 * Girdi doğrulama, yetkilendirme ve çıktı kaçışları bu dosyanın
 * mevcut güvenlik akışına uygun biçimde korunmalıdır.
 */
declare(strict_types=1);

require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/icons.php';

$duyuruId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$tip = strtolower(trim((string) ($_GET['tip'] ?? 'liste')));
$pdo = getPDO();

if ($tip === 'anasayfa') {
    $duyuru = fetchAnasayfaDuyuruById($pdo, $duyuruId);

    if ($duyuru === null) {
        header('Location: ' . $assetBase . 'pages/ana_sayfa.php');
        exit;
    }

    $etkinlikId = resolveAnasayfaDuyuruEtkinlikId($pdo, $duyuru);

    if ($etkinlikId !== null) {
        header('Location: ' . $assetBase . 'pages/etkinlik_detay.php?id=' . $etkinlikId);
        exit;
    }

    $viewResult = dbBumpUniqueView($pdo, 'anasayfa_duyurular', $duyuruId);
    $goruntulenme = $viewResult['count'];
    $kategoriAdi = '';
    $tarihLabel = '';
    $resim = imgUrl((string) ($duyuru['resim'] ?? ''), $assetBase);
    $geriUrl = $assetBase . 'pages/ana_sayfa.php';

    $digerKaynak = fetchOtherEtkinlikler($pdo, 0);
    if (count($digerKaynak) < 2) {
        $digerKaynak = fetchOtherAnasayfaDuyurular($pdo, $duyuruId);
        $sidebarTitle = 'Diğer Duyurular';
        $sidebarIcon = 'bell';
        $itemDetailBase = $assetBase . 'pages/duyuru_detay.php?tip=anasayfa&id=';
        $sidebarShowCategory = false;
    } else {
        $sidebarTitle = 'Diğer Etkinlikler';
        $sidebarIcon = 'calendar';
        $itemDetailBase = $assetBase . 'pages/etkinlik_detay.php?id=';
        $sidebarShowCategory = false;
    }
} else {
    $duyuru = fetchPortalDuyuruById($pdo, $duyuruId);

    if ($duyuru === null) {
        header('Location: ' . $assetBase . 'pages/duyurular.php');
        exit;
    }

    $viewResult = dbBumpUniqueView($pdo, 'etkinlikler_duyurular', $duyuruId);
    $goruntulenme = $viewResult['count'];
    $kategoriAdi = trim((string) ($duyuru['kategori_adi'] ?? ''));
    $tarihLabel = formatDetailDate((string) ($duyuru['tarih'] ?? ''));
    $resim = imgUrl((string) ($duyuru['resim_url'] ?? $duyuru['resim'] ?? ''), $assetBase);
    $geriUrl = $assetBase . 'pages/duyurular.php';

    $digerKaynak = fetchOtherPortalDuyurular($pdo, $duyuruId);
    $sidebarTitle = 'Diğer Duyurular';
    $sidebarIcon = 'megaphone';
    $itemDetailBase = $assetBase . 'pages/duyuru_detay.php?id=';
    $sidebarShowCategory = true;
}

$digerSayfalari = array_chunk($digerKaynak, 6);
$dosyaUrl = trim((string) ($duyuru['dosya_url'] ?? ''));
$videoUrl = trim((string) ($duyuru['video_url'] ?? ''));

$pageTitle = 'Duyuru Detayı';
$documentTitle = (string) ($duyuru['baslik'] ?? $pageTitle);
$useDetailLayout = true;
$showBreadcrumb = true;

require __DIR__ . '/../includes/site-head.php';
require __DIR__ . '/../includes/header-nav.php';
require __DIR__ . '/../includes/breadcrumb.php';
?>

<main class="content-area detail-page">
    <div class="site-container">
        <div class="detail-layout">
            <article class="detail-article">
                <header class="detail-article-header">
                    <h1 class="detail-article-title"><?= e((string) $duyuru['baslik']) ?></h1>
                    <div class="detail-article-meta">
                        <?php if ($tarihLabel !== ''): ?>
                        <span class="detail-meta-item">
                            <span class="icon" aria-hidden="true"><?= icon('calendar') ?></span>
                            <?= e($tarihLabel) ?>
                        </span>
                        <?php endif; ?>
                        <?php if ($kategoriAdi !== ''): ?>
                        <span class="detail-meta-item">
                            <span class="icon" aria-hidden="true"><?= icon('tag') ?></span>
                            <?= e($kategoriAdi) ?>
                        </span>
                        <?php endif; ?>
                        <span class="detail-meta-item">
                            <span class="icon" aria-hidden="true"><?= icon('eye') ?></span>
                            <?= (int) $goruntulenme ?> görüntülenme
                        </span>
                        <span class="detail-meta-item">
                            <span class="icon" aria-hidden="true"><?= icon('user') ?></span>
                            Gebze Belediyesi
                        </span>
                    </div>
                </header>

                <div class="detail-article-image-wrap">
                    <img src="<?= e($resim) ?>"
                         alt="<?= e((string) $duyuru['baslik']) ?>"
                         class="detail-article-image">
                </div>

                <div class="detail-article-body">
                    <?= nl2br(e((string) ($duyuru['aciklama'] ?? ''))) ?>
                </div>

                <?php if ($dosyaUrl !== '' || $videoUrl !== ''): ?>
                <div class="detail-article-actions detail-article-actions--links">
                    <?php if ($dosyaUrl !== ''): ?>
                    <a href="<?= e($dosyaUrl) ?>" class="detail-back-link" target="_blank" rel="noopener noreferrer">
                        <span class="icon" aria-hidden="true"><?= icon('document') ?></span>
                        Ek Dosyayı Görüntüle
                    </a>
                    <?php endif; ?>
                    <?php if ($videoUrl !== ''): ?>
                    <a href="<?= e($videoUrl) ?>" class="detail-back-link" target="_blank" rel="noopener noreferrer">
                        <span class="icon" aria-hidden="true"><?= icon('play') ?></span>
                        Videoyu İzle
                    </a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <div class="detail-article-actions">
                    <a href="<?= e($geriUrl) ?>" class="detail-back-link">
                        <span class="icon" aria-hidden="true"><?= icon('chevron-left') ?></span>
                        Geri Dön
                    </a>
                </div>
            </article>

            <?php require __DIR__ . '/../includes/detail-sidebar.php'; ?>
        </div>
    </div>
</main>

<?php require __DIR__ . '/../includes/footer.php'; ?>

<script src="<?= e($assetBase) ?>assets/js/detay_slider.js" defer></script>
<script src="<?= e($assetBase) ?>assets/js/navbar.js" defer></script>
</body>
</html>
