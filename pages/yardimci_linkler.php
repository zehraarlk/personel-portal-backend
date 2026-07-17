<?php
/**
 * Dosya sorumluluğu: Yardımcı bağlantılar sayfası.
 *
 * Girdi doğrulama, yetkilendirme ve çıktı kaçışları bu dosyanın
 * mevcut güvenlik akışına uygun biçimde korunmalıdır.
 */
declare(strict_types=1);

require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/icons.php';

$pageTitle = 'Yardımcı Linkler';
$pageCss = 'yardimci_linkler.css';
$showBreadcrumb = true;

$kayitlar = [];
$toplamKayit = 0;
$dbError = '';

try {
    $data = loadYardimciLinklerData($assetBase);
    $kayitlar = $data['kayitlar'];
    $toplamKayit = $data['toplam'];
} catch (Throwable $e) {
    $dbError = $e->getMessage();
    error_log('Yardimci linkler veritabani hatasi: ' . $dbError);
}

require __DIR__ . '/../includes/site-head.php';
require __DIR__ . '/../includes/header-nav.php';
require __DIR__ . '/../includes/breadcrumb.php';
?>

<main class="content-area yardimci-linkler-page">
    <div class="site-container">
        <?php if ($dbError !== ''): ?>
        <p class="home-db-error">Veritabanı bağlantısı kurulamadı. phpMyAdmin'de <strong>personel_db</strong> veritabanının <code>db/personel_db.sql</code> dosyasından import edildiğinden emin olun.</p>
        <?php endif; ?>

        <header class="yl-page-header">
            <h1>Yardımcı Linkler</h1>
            <p>Kurum içi sistemler, web siteleri ve faydalı dış bağlantılara buradan ulaşabilirsiniz.</p>
        </header>

        <section class="yl-controls" aria-label="Arama ve kategori">
            <div class="yl-search-box">
                <label class="visually-hidden" for="searchInput">Yardımcı link ara</label>
                <input type="search"
                       id="searchInput"
                       class="yl-search-input"
                       placeholder="Yardımcı link ara..."
                       autocomplete="off">
                <button type="button" class="yl-search-btn" id="searchBtn" aria-label="Ara">
                    <span class="icon" aria-hidden="true"><?= icon('search') ?></span>
                </button>
            </div>

            <label class="yl-sort-label">
                <span class="visually-hidden">Kategori</span>
                <select class="yl-sort-select" id="sortSelect">
                    <option value="all">Tüm Yardımcı Linkler</option>
                    <option value="kurum-ici">Kurum İçi Linkler</option>
                    <option value="website">Website Linkler</option>
                    <option value="bilgi">Bilgi Portalları</option>
                    <option value="faydalı">Faydalı Linkler</option>
                </select>
            </label>
        </section>

        <section class="yl-results" aria-label="Sonuçlar">
            <p class="yl-results-count" id="resultsCount">
                <strong><?= (int) $toplamKayit ?></strong> sonuç bulundu
            </p>

            <div id="linksGrid" class="yl-grid" aria-live="polite"></div>

            <div id="emptyState" class="yl-empty" hidden>
                <span class="icon" aria-hidden="true"><?= icon('search') ?></span>
                <h2>Sonuç Bulunamadı</h2>
                <p id="emptyStateText">Aradığınız kriterlere uygun yardımcı link bulunamadı.</p>
            </div>
        </section>
    </div>
</main>

<?php require __DIR__ . '/../includes/footer.php'; ?>

<script>
    window.yardimciLinkData = <?= jsonData($kayitlar) ?>;
</script>
<script src="<?= e($assetBase) ?>assets/js/yardimci_linkler.js" defer></script>
<script src="<?= e($assetBase) ?>assets/js/navbar.js" defer></script>
</body>
</html>
