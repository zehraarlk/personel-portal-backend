<?php
/**
 * Dosya sorumluluğu: Duyuru listeleme sayfası.
 *
 * Girdi doğrulama, yetkilendirme ve çıktı kaçışları bu dosyanın
 * mevcut güvenlik akışına uygun biçimde korunmalıdır.
 */
declare(strict_types=1);

require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/icons.php';

$pageTitle = 'Duyurular';
$pageCss = 'duyurular.css';
$showBreadcrumb = true;

$kayitlar = [];
$toplamKayit = 0;
$dbError = '';

try {
    $data = loadDuyurularListData($assetBase);
    $kayitlar = $data['kayitlar'];
    $toplamKayit = $data['toplam'];
} catch (Throwable $e) {
    $dbError = $e->getMessage();
    error_log('Duyurular veritabani hatasi: ' . $dbError);
}

require __DIR__ . '/../includes/site-head.php';
require __DIR__ . '/../includes/header-nav.php';
require __DIR__ . '/../includes/breadcrumb.php';
?>

<main class="content-area duyurular-page">
    <div class="site-container">
        <?php if ($dbError !== ''): ?>
        <p class="home-db-error">Veritabanı bağlantısı kurulamadı. phpMyAdmin'de <strong>personel_db</strong> veritabanının <code>db/personel_db.sql</code> dosyasından import edildiğinden emin olun.</p>
        <?php endif; ?>

        <header class="du-page-header">
            <h1>Duyurular</h1>
            <p>Belediye personellerimize özel tüm duyurulara ulaşabilirsiniz.</p>
        </header>

        <section class="du-search-section" aria-label="Arama ve filtre">
            <div class="du-search-box">
                <label class="visually-hidden" for="searchInput">Duyuru ara</label>
                <input type="search"
                       id="searchInput"
                       class="du-search-input"
                       placeholder="Duyuru ara..."
                       autocomplete="off">
                <button type="button" class="du-search-btn" id="searchBtn" aria-label="Ara">
                    <span class="icon" aria-hidden="true"><?= icon('search') ?></span>
                </button>
            </div>
        </section>

        <section class="du-results-section" aria-label="Sonuçlar">
            <div class="du-results-header">
                <p class="du-results-count" id="resultsCount">
                    <strong><?= (int) $toplamKayit ?></strong> sonuç bulundu
                </p>
                <label class="du-sort-label">
                    <span class="visually-hidden">Kategori filtresi</span>
                    <select class="du-sort-select" id="categorySelect">
                        <option value="all">Tüm Duyurular</option>
                        <option value="insan">İnsan Kaynakları Duyuruları</option>
                        <option value="bilgi">Bilgi İşlem Duyuruları</option>
                    </select>
                </label>
            </div>

            <div id="newsGrid" class="news-grid" aria-live="polite"></div>

            <div id="noResults" class="du-empty" hidden>
                <span class="icon" aria-hidden="true"><?= icon('search') ?></span>
                <h2>Sonuç Bulunamadı</h2>
                <p>Arama veya filtre kriterlerinize uygun duyuru bulunamadı.</p>
            </div>

            <nav id="pagination" class="du-pagination" aria-label="Sayfa navigasyonu" hidden></nav>
        </section>
    </div>
</main>

<?php require __DIR__ . '/../includes/footer.php'; ?>

<script>
    window.newsData = <?= jsonData($kayitlar) ?>;
    window.duDetailBase = <?= json_encode($assetBase . 'pages/duyuru_detay.php?id=', JSON_UNESCAPED_UNICODE) ?>;
</script>
<script src="<?= e($assetBase) ?>assets/js/duyurular.js" defer></script>
<script src="<?= e($assetBase) ?>assets/js/navbar.js" defer></script>
</body>
</html>
