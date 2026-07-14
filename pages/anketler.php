<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/icons.php';

$pageTitle = 'Anketler';
$pageCss = 'anketler.css';
$showBreadcrumb = true;

$kayitlar = [];
$toplamKayit = 0;
$dbError = '';
$katilimBasarili = '';

if (!empty($_SESSION['anket_katilim_ok'])) {
    $katilimBasarili = (string) $_SESSION['anket_katilim_ok'];
    unset($_SESSION['anket_katilim_ok']);
}

try {
    $data = loadAnketlerListData($assetBase);
    $kayitlar = $data['kayitlar'];
    $toplamKayit = $data['toplam'];
} catch (Throwable $e) {
    $dbError = $e->getMessage();
    error_log('Anketler veritabani hatasi: ' . $dbError);
}

require __DIR__ . '/../includes/site-head.php';
require __DIR__ . '/../includes/header-nav.php';
require __DIR__ . '/../includes/breadcrumb.php';
?>

<main class="content-area anketler-page">
    <div class="site-container">
        <?php if ($dbError !== ''): ?>
        <p class="home-db-error">Veritabanı bağlantısı kurulamadı. phpMyAdmin'de <strong>personel_db</strong> veritabanının <code>db/personel_db.sql</code> dosyasından import edildiğinden emin olun.</p>
        <?php endif; ?>

        <?php if ($katilimBasarili !== ''): ?>
        <p class="ak-list-success" role="status">
            “<?= e($katilimBasarili) ?>” anketine katılımınız kaydedildi.
        </p>
        <?php endif; ?>

        <header class="ak-page-header">
            <div class="ak-page-header-text">
                <h1>Anketler</h1>
                <p>Kurumsal anketlere katılabilir, ilerlemeyi takip edebilir ve favorilerinizi yönetebilirsiniz.</p>
            </div>
        </header>

        <section class="ak-controls" aria-label="Arama ve sıralama">
            <div class="ak-search-box">
                <label class="visually-hidden" for="searchInput">Anket ara</label>
                <input type="search"
                       id="searchInput"
                       class="ak-search-input"
                       placeholder="Anket ara..."
                       autocomplete="off">
                <button type="button" class="ak-search-btn" id="searchBtn" aria-label="Ara">
                    <span class="icon" aria-hidden="true"><?= icon('search') ?></span>
                </button>
            </div>

            <label class="ak-sort-label">
                <span class="visually-hidden">Sıralama</span>
                <select class="ak-sort-select" id="sortSelect">
                    <option value="newest">En Yeni</option>
                    <option value="oldest">En Eski</option>
                    <option value="popular">Popülerlik</option>
                </select>
            </label>
        </section>

        <nav class="ak-filter-tabs" aria-label="Anket filtreleri">
            <button type="button" class="ak-filter-tab is-active" data-filter="all">
                <span class="icon" aria-hidden="true"><?= icon('poll') ?></span>
                Tümü
            </button>
            <button type="button" class="ak-filter-tab" data-filter="favorites">
                <span class="icon" aria-hidden="true"><?= icon('star') ?></span>
                Favoriler
            </button>
            <button type="button" class="ak-filter-tab" data-filter="active">
                <span class="icon" aria-hidden="true"><?= icon('play') ?></span>
                Aktif Anketler
            </button>
            <button type="button" class="ak-filter-tab" data-filter="pending">
                <span class="icon" aria-hidden="true"><?= icon('clock') ?></span>
                Beklemede
            </button>
            <button type="button" class="ak-filter-tab" data-filter="completed">
                <span class="icon" aria-hidden="true"><?= icon('check') ?></span>
                Tamamlanan
            </button>
        </nav>

        <section class="ak-results" aria-label="Sonuçlar">
            <p class="ak-results-count" id="resultsCount">
                <strong><?= (int) $toplamKayit ?></strong> sonuç bulundu
            </p>

            <div id="surveyGrid" class="ak-grid" aria-live="polite"></div>

            <div id="emptyState" class="ak-empty" hidden>
                <span class="icon" aria-hidden="true"><?= icon('search') ?></span>
                <h2>Sonuç Bulunamadı</h2>
                <p id="emptyStateText">Aradığınız kriterlere uygun anket bulunamadı.</p>
            </div>
        </section>
    </div>
</main>

<div class="ak-toast-host" id="toastHost" aria-live="polite" aria-atomic="true"></div>

<?php require __DIR__ . '/../includes/footer.php'; ?>

<script>
    window.anketData = <?= jsonData($kayitlar) ?>;
    window.anketConfig = <?= json_encode([
        'favoriUrl' => $assetBase . 'pages/anket_favori.php',
        'csrfToken' => csrfToken(),
    ], JSON_UNESCAPED_UNICODE) ?>;
</script>
<script src="<?= e($assetBase) ?>assets/js/anketler.js" defer></script>
<script src="<?= e($assetBase) ?>assets/js/navbar.js" defer></script>
</body>
</html>
