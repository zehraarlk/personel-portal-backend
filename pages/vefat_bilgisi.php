<?php
/**
 * Dosya sorumluluğu: Vefat bilgisi sayfası.
 *
 * Girdi doğrulama, yetkilendirme ve çıktı kaçışları bu dosyanın
 * mevcut güvenlik akışına uygun biçimde korunmalıdır.
 */
declare(strict_types=1);

require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/icons.php';

$pageTitle = 'Vefat Bilgisi';
$pageCss = 'vefat_bilgisi.css';
$showBreadcrumb = true;

$kayitlar = [];
$toplamKayit = 0;
$dbError = '';

try {
    $data = loadVefatBilgileriData();
    $kayitlar = $data['kayitlar'];
    $toplamKayit = $data['toplam'];
} catch (Throwable $e) {
    $dbError = $e->getMessage();
    error_log('Vefat bilgisi veritabani hatasi: ' . $dbError);
}

require __DIR__ . '/../includes/site-head.php';
require __DIR__ . '/../includes/header-nav.php';
require __DIR__ . '/../includes/breadcrumb.php';
?>

<main class="content-area vefat-page">
    <div class="site-container">
        <?php if ($dbError !== ''): ?>
        <p class="home-db-error">Veritabanı bağlantısı kurulamadı. phpMyAdmin'de <strong>personel_db</strong> veritabanının <code>db/personel_db.sql</code> dosyasından import edildiğinden emin olun.</p>
        <?php endif; ?>

        <header class="vf-page-header">
            <span class="vf-header-icon icon" aria-hidden="true"><?= icon('ribbon') ?></span>
            <h1 id="vf-hero-title">Vefat Eden Bilgisi</h1>
        </header>

        <section class="vf-toolbar" aria-label="Arama">
            <div class="vf-search-box">
                <span class="vf-search-leading icon" aria-hidden="true"><?= icon('search') ?></span>
                <label class="visually-hidden" for="searchInput">Ad veya ilişki ara</label>
                <input type="search"
                       id="searchInput"
                       class="vf-search-input"
                       placeholder="Ad, yakınlık veya mesaj içeriği ara..."
                       autocomplete="off">
                <button type="button" class="vf-search-btn" id="searchBtn">
                    Ara
                </button>
            </div>
            <p class="vf-results-count" id="resultsCount">
                <strong><?= (int) $toplamKayit ?></strong> kayıt listeleniyor
            </p>
        </section>

        <section class="vf-results" aria-label="Sonuçlar">
            <div id="vefatGrid" class="vf-grid" aria-live="polite"></div>

            <div id="emptyState" class="vf-empty" hidden>
                <span class="vf-empty-icon icon" aria-hidden="true"><?= icon('ribbon') ?></span>
                <h2>Kayıt Bulunamadı</h2>
                <p>Aradığınız kriterlere uygun kayıt bulunamadı.</p>
            </div>

            <nav id="pagination" class="vf-pagination" aria-label="Sayfa navigasyonu" hidden></nav>
        </section>
    </div>
</main>

<?php require __DIR__ . '/../includes/footer.php'; ?>

<script>
    window.vefatData = <?= jsonData($kayitlar) ?>;
    window.vefatIcons = {
        ribbon: <?= json_encode(icon('vefat_bilgisi'), JSON_UNESCAPED_UNICODE) ?>,
        calendar: <?= json_encode(icon('tarih'), JSON_UNESCAPED_UNICODE) ?>
    };
</script>
<script src="<?= e($assetBase) ?>assets/js/vefat_bilgisi.js" defer></script>
<script src="<?= e($assetBase) ?>assets/js/navbar.js" defer></script>
</body>
</html>
