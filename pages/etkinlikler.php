<?php
/**
 * Dosya sorumluluğu: Etkinlik listeleme sayfası.
 *
 * Girdi doğrulama, yetkilendirme ve çıktı kaçışları bu dosyanın
 * mevcut güvenlik akışına uygun biçimde korunmalıdır.
 */
declare(strict_types=1);

require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/icons.php';

$pageTitle = 'Etkinlikler';
$pageCss = 'etkinlikler.css';
$showBreadcrumb = true;

$kayitlar = [];
$toplamKayit = 0;
$dbError = '';

try {
    $data = loadEtkinliklerListData($assetBase);
    $kayitlar = $data['kayitlar'];
    $toplamKayit = $data['toplam'];
} catch (Throwable $e) {
    $dbError = $e->getMessage();
    error_log('Etkinlikler veritabani hatasi: ' . $dbError);
}

require __DIR__ . '/../includes/site-head.php';
require __DIR__ . '/../includes/header-nav.php';
require __DIR__ . '/../includes/breadcrumb.php';
?>

<main class="content-area etkinlikler-page">
    <div class="site-container">
        <?php if ($dbError !== ''): ?>
        <p class="home-db-error">Veritabanı bağlantısı kurulamadı. phpMyAdmin'de <strong>personel_db</strong> veritabanının <code>db/personel_db.sql</code> dosyasından import edildiğinden emin olun.</p>
        <?php endif; ?>

        <section class="et-search-section" aria-label="Arama">
            <div class="et-search-box">
                <label class="visually-hidden" for="searchInput">Etkinlik başlığı veya açıklama ara</label>
                <input type="search"
                       id="searchInput"
                       class="et-search-input"
                       placeholder="Etkinlik başlığı veya açıklama ara..."
                       autocomplete="off">
                <button type="button" class="et-search-btn" id="searchBtn" aria-label="Ara">
                    <span class="icon" aria-hidden="true"><?= icon('search') ?></span>
                </button>
            </div>
        </section>

        <nav class="et-filter-tabs" aria-label="Durum filtreleri" role="tablist">
            <button type="button" class="et-filter-tab is-active" data-status="all" role="tab" aria-selected="true">
                Tümü
            </button>
            <button type="button" class="et-filter-tab" data-status="aktif" role="tab" aria-selected="false">
                Aktif
            </button>
            <button type="button" class="et-filter-tab" data-status="pasif" role="tab" aria-selected="false">
                Pasif
            </button>
        </nav>

        <section class="et-results-section" aria-label="Sonuçlar">
            <div class="et-results-header">
                <p class="et-results-count" id="resultsCount">
                    <strong><?= (int) $toplamKayit ?></strong> sonuç bulundu
                </p>
                <label class="et-sort-label">
                    <span class="visually-hidden">Sıralama</span>
                    <select class="et-sort-select" id="sortSelect">
                        <option value="newest">En Yeni</option>
                        <option value="oldest">En Eski</option>
                        <option value="most-viewed">En Çok Görüntülenen</option>
                        <option value="alphabetical">Alfabetik</option>
                    </select>
                </label>
            </div>

            <div id="newsGrid" class="news-grid" aria-live="polite"></div>

            <div id="noResults" class="et-empty" hidden>
                <span class="icon" aria-hidden="true"><?= icon('search') ?></span>
                <h2>Sonuç Bulunamadı</h2>
                <p>Arama kriterlerinize uygun etkinlik bulunamadı. Lütfen farklı anahtar kelimeler deneyin.</p>
            </div>

            <nav id="pagination" class="et-pagination" aria-label="Sayfa navigasyonu" hidden></nav>
        </section>
    </div>
</main>

<?php require __DIR__ . '/../includes/footer.php'; ?>

<script>
    window.newsData = <?= jsonData($kayitlar) ?>;
    window.etDetailBase = <?= json_encode($assetBase . 'pages/etkinlik_detay.php?id=', JSON_UNESCAPED_UNICODE) ?>;
</script>
<script src="<?= e($assetBase) ?>assets/js/etkinlikler.js" defer></script>
<script src="<?= e($assetBase) ?>assets/js/navbar.js" defer></script>
</body>
</html>
