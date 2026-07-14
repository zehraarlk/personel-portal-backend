<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/icons.php';

$kayitId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$pdo = getPDO();
$kayit = fetchSizdenGelenById($pdo, $kayitId);

if ($kayit === null) {
    header('Location: ' . $assetBase . 'pages/sizden_gelenler.php');
    exit;
}

$viewResult = dbBumpUniqueView($pdo, 'sizden_gelenler', $kayitId);
$goruntulenme = $viewResult['count'];

$digerKayitlar = fetchOtherSizdenGelenler($pdo, $kayitId);
$digerSayfalari = array_chunk($digerKayitlar, 6);

$pageTitle = 'Sizden Gelenler';
$documentTitle = (string) ($kayit['baslik'] ?? $pageTitle);
$useDetailLayout = true;
$showBreadcrumb = true;

require __DIR__ . '/../includes/site-head.php';
require __DIR__ . '/../includes/header-nav.php';
require __DIR__ . '/../includes/breadcrumb.php';

$sidebarTitle = 'Diğer Paylaşımlar';
$sidebarIcon = 'inbox';
$itemDetailBase = $assetBase . 'pages/sizden_detay.php?id=';
$sidebarShowCategory = true;
?>

<main class="content-area detail-page">
    <div class="site-container">
        <div class="detail-layout">
            <article class="detail-article">
                <header class="detail-article-header">
                    <?php if (!empty($kayit['kategori_adi'])): ?>
                    <span class="detail-article-category"><?= e((string) $kayit['kategori_adi']) ?></span>
                    <?php endif; ?>
                    <h1 class="detail-article-title"><?= e((string) $kayit['baslik']) ?></h1>
                    <div class="detail-article-meta">
                        <span class="detail-meta-item">
                            <span class="icon" aria-hidden="true"><?= icon('calendar') ?></span>
                            <?= e(formatDetailDate((string) ($kayit['tarih'] ?? ''))) ?>
                        </span>
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
                    <img src="<?= e(imgUrl((string) ($kayit['gorsel_yolu'] ?? ''), $assetBase)) ?>"
                         alt="<?= e((string) $kayit['baslik']) ?>"
                         class="detail-article-image">
                </div>

                <div class="detail-article-body">
                    <?= nl2br(e((string) ($kayit['ozet'] ?? ''))) ?>
                </div>

                <div class="detail-article-actions">
                    <a href="<?= e($assetBase) ?>pages/sizden_gelenler.php" class="detail-back-link">
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
