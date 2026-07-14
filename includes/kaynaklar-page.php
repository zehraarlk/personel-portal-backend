<?php
declare(strict_types=1);

/**
 * Shared Kaynaklar list page.
 * Expected vars before include: $pageTitle, $kaynakActiveKey, $kaynakSlug,
 * $kaynakSearchPlaceholder, $kaynakEmptyText, $kaynakIntro
 */
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/icons.php';

$pageCss = 'kaynaklar.css';
$showBreadcrumb = true;
$kaynakActiveKey = $kaynakActiveKey ?? 'protocol';
$kaynakSlug = $kaynakSlug ?? 'Protokoller';
$kaynakSearchPlaceholder = $kaynakSearchPlaceholder ?? 'Ara...';
$kaynakEmptyText = $kaynakEmptyText ?? 'Henüz kayıt bulunmuyor.';
$kaynakIntro = $kaynakIntro ?? '';

$kayitlar = [];
$toplamKayit = 0;
$dbError = '';
$kaynakTabs = kaynakNavTabs($assetBase, $kaynakActiveKey);

try {
    $data = loadKaynaklarListData($assetBase, $kaynakSlug, $pageTitle);
    $kayitlar = $data['kayitlar'];
    $toplamKayit = $data['toplam'];
} catch (Throwable $e) {
    $dbError = $e->getMessage();
    error_log($pageTitle . ' veritabani hatasi: ' . $dbError);
}

require __DIR__ . '/../includes/site-head.php';
require __DIR__ . '/../includes/header-nav.php';
require __DIR__ . '/../includes/breadcrumb.php';
?>

<main class="content-area kaynaklar-page">
    <div class="site-container">
        <?php if ($dbError !== ''): ?>
        <p class="home-db-error">Veritabanı bağlantısı kurulamadı. phpMyAdmin'de <strong>personel_db</strong> veritabanının <code>db/personel_db.sql</code> dosyasından import edildiğinden emin olun.</p>
        <?php endif; ?>

        <header class="kr-page-header">
            <h1><?= e($pageTitle) ?></h1>
            <?php if ($kaynakIntro !== ''): ?>
            <p><?= e($kaynakIntro) ?></p>
            <?php endif; ?>
        </header>

        <section class="kr-controls" aria-label="Arama ve kategori">
            <div class="kr-search-box">
                <label class="visually-hidden" for="searchInput"><?= e($kaynakSearchPlaceholder) ?></label>
                <input type="search"
                       id="searchInput"
                       class="kr-search-input"
                       placeholder="<?= e($kaynakSearchPlaceholder) ?>"
                       autocomplete="off">
                <button type="button" class="kr-search-btn" id="searchBtn" aria-label="Ara">
                    <span class="icon" aria-hidden="true"><?= icon('search') ?></span>
                </button>
            </div>

            <nav class="kr-filter-tabs" aria-label="Kaynak kategorileri">
                <?php foreach ($kaynakTabs as $tab): ?>
                <a href="<?= e($tab['href']) ?>"
                   class="kr-filter-tab<?= $tab['active'] ? ' is-active' : '' ?>"
                   <?= $tab['active'] ? 'aria-current="page"' : '' ?>>
                    <?= e($tab['label']) ?>
                </a>
                <?php endforeach; ?>
            </nav>
        </section>

        <section class="kr-results" aria-label="Sonuçlar">
            <p class="kr-results-count" id="resultsCount">
                <strong><?= (int) $toplamKayit ?></strong> sonuç bulundu
            </p>

            <div id="documentsGrid" class="kr-grid" aria-live="polite"></div>

            <div id="noResults" class="kr-empty" hidden>
                <span class="icon" aria-hidden="true"><?= icon('search') ?></span>
                <h2>Sonuç Bulunamadı</h2>
                <p><?= e($kaynakEmptyText) ?></p>
            </div>
        </section>
    </div>
</main>

<?php require __DIR__ . '/../includes/footer.php'; ?>

<script>
    window.kaynakData = <?= jsonData($kayitlar) ?>;
    window.kaynakEmptyText = <?= json_encode($kaynakEmptyText, JSON_UNESCAPED_UNICODE) ?>;
</script>
<script src="<?= e($assetBase) ?>assets/js/kaynaklar.js" defer></script>
<script src="<?= e($assetBase) ?>assets/js/navbar.js" defer></script>
</body>
</html>
