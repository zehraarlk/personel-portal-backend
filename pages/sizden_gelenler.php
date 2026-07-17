<?php
/**
 * Dosya sorumluluğu: Personelden gelen içeriklerin listeleme sayfası.
 *
 * Girdi doğrulama, yetkilendirme ve çıktı kaçışları bu dosyanın
 * mevcut güvenlik akışına uygun biçimde korunmalıdır.
 */
declare(strict_types=1);

require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/icons.php';

$pageTitle = 'Sizden Gelenler';
$pageCss = 'sizden_gelenler.css';
$showBreadcrumb = true;

$kayitlar = [];
$toplamKayit = 0;
$dbError = '';

try {
    $data = loadSizdenGelenlerData($assetBase);
    $kayitlar = $data['kayitlar'];
    $toplamKayit = $data['toplam'];
} catch (Throwable $e) {
    $dbError = $e->getMessage();
    error_log('Sizden gelenler veritabani hatasi: ' . $dbError);
}

require __DIR__ . '/../includes/site-head.php';
require __DIR__ . '/../includes/header-nav.php';
require __DIR__ . '/../includes/breadcrumb.php';
?>

<main class="content-area sizden-gelenler-page">
    <div class="site-container">
        <?php if ($dbError !== ''): ?>
        <p class="home-db-error">Veritabanı bağlantısı kurulamadı. phpMyAdmin'de <strong>personel_db</strong> veritabanının <code>db/personel_db.sql</code> dosyasından import edildiğinden emin olun.</p>
        <?php endif; ?>

        <section class="sg-search-section" aria-label="Arama">
            <div class="sg-search-box">
                <label class="visually-hidden" for="searchInput">Haber başlığı veya açıklama ara</label>
                <input type="search"
                       id="searchInput"
                       class="sg-search-input"
                       placeholder="Haber başlığı veya açıklama ara..."
                       autocomplete="off">
                <button type="button" class="sg-search-btn" id="searchBtn" aria-label="Ara">
                    <span class="icon" aria-hidden="true"><?= icon('search') ?></span>
                </button>
            </div>
        </section>

        <section class="sg-results-section" aria-label="Sonuçlar">
            <div class="sg-results-header">
                <p class="sg-results-count" id="resultsCount">
                    <strong><?= (int) $toplamKayit ?></strong> sonuç bulundu
                </p>
                <label class="sg-sort-label">
                    <span class="visually-hidden">Sıralama</span>
                    <select class="sg-sort-select" id="sortSelect">
                        <option value="newest">En Yeni</option>
                        <option value="oldest">En Eski</option>
                        <option value="most-viewed">En Çok Görüntülenen</option>
                        <option value="alphabetical">Alfabetik</option>
                    </select>
                </label>
            </div>

            <div id="newsGrid" class="news-grid" aria-live="polite"></div>

            <div id="noResults" class="sg-empty" hidden>
                <span class="icon" aria-hidden="true"><?= icon('search') ?></span>
                <h2>Sonuç Bulunamadı</h2>
                <p>Arama kriterlerinize uygun içerik bulunamadı. Lütfen farklı anahtar kelimeler deneyin.</p>
            </div>

            <nav id="pagination" class="sg-pagination" aria-label="Sayfa navigasyonu" hidden></nav>
        </section>
    </div>
</main>

<?php require __DIR__ . '/../includes/footer.php'; ?>

<script>
    window.newsData = <?= jsonData($kayitlar) ?>;
    window.sgDetailBase = <?= json_encode($assetBase . 'pages/sizden_detay.php?id=', JSON_UNESCAPED_UNICODE) ?>;
</script>
<script src="<?= e($assetBase) ?>assets/js/sizden_gelenler.js" defer></script>
<script src="<?= e($assetBase) ?>assets/js/navbar.js" defer></script>
</body>
</html>
