<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/icons.php';

$etkinlikId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$pdo = getPDO();
$etkinlik = fetchEtkinlikById($pdo, $etkinlikId);

if ($etkinlik === null) {
    header('Location: ' . $assetBase . 'pages/ana_sayfa.php');
    exit;
}

$viewResult = dbBumpUniqueView($pdo, 'etkinlikler', $etkinlikId);
$goruntulenme = $viewResult['count'];

$digerEtkinlikler = fetchOtherEtkinlikler($pdo, $etkinlikId);
$digerSayfalari = array_chunk($digerEtkinlikler, 6);

$pageTitle = 'Etkinlik Detayı';
$documentTitle = (string) ($etkinlik['baslik'] ?? $pageTitle);
$useDetailLayout = true;
$showBreadcrumb = true;

require __DIR__ . '/../includes/site-head.php';
require __DIR__ . '/../includes/header-nav.php';
require __DIR__ . '/../includes/breadcrumb.php';

$sidebarTitle = 'Diğer Etkinlikler';
$sidebarIcon = 'calendar';
$itemDetailBase = $assetBase . 'pages/etkinlik_detay.php?id=';
?>

<main class="content-area detail-page">
    <div class="site-container">
        <div class="detail-layout">
            <article class="detail-article">
                <header class="detail-article-header">
                    <h1 class="detail-article-title"><?= e((string) $etkinlik['baslik']) ?></h1>
                    <div class="detail-article-meta">
                        <span class="detail-meta-item">
                            <span class="icon" aria-hidden="true"><?= icon('calendar') ?></span>
                            <?= e(formatDetailDate((string) ($etkinlik['tarih'] ?? ''))) ?>
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
                    <img src="<?= e(imgUrl((string) ($etkinlik['resim'] ?? ''), $assetBase)) ?>"
                         alt="<?= e((string) $etkinlik['baslik']) ?>"
                         class="detail-article-image">
                </div>

                <div class="detail-article-body">
                    <?= nl2br(e((string) ($etkinlik['aciklama'] ?? ''))) ?>
                </div>

                <div class="detail-article-actions">
                    <a href="<?= e($assetBase) ?>pages/etkinlikler.php" class="detail-back-link">
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
