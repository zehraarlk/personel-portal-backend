<?php
<<<<<<< HEAD
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
=======
include "baglan.php";
$etkinlikler = dbFetchAll($db, "SELECT * FROM etkinlikler ORDER BY tarih DESC");
$toplamEtkinlik = count($etkinlikler);
?>
<!doctype html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Etkinlikler - Gebze Belediyesi Personel Portalı</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
<?php
$pageCss = "etkinlik.style.css";
include "includes/site-styles.php";
?>
  </head>
  <body>
    <?php include "includes/header-nav.php"; ?>
    <?php
    $pageTitle = "Etkinlikler";
    include "includes/breadcrumb.php";
    ?>
<!-- Breadcrumb Section - Logo ve başlık ile aynı hizada --><!-- Page Header - Logo ve breadcrumb ile aynı hizada -->
    <div class="page-header">
      <div class="nav-container">
        <h2><i class="<?= portalSiteIconClass($db, "etkinlik_sayfa", "fa-solid fa-calendar-days") ?>"></i> Etkinlikler & Aktiviteler</h2>
      </div>
    </div>

    <!-- Main Content -->
    <div class="content-area">
      <div class="nav-container">
        <!-- Search and Filter Section -->
        <div class="search-filter-section">
          <div class="search-box">
            <input
              type="text"
              class="form-control search-input"
              id="searchInput"
              placeholder="Haber başlığı veya açıklama ara..."
            />
            <button class="search-btn" id="searchBtn">
              <i class="<?= portalSiteIconClass($db, "arama", "fas fa-search") ?>"></i>
            </button>
          </div>
        </div>
        <!-- Results Section -->
        <div class="results-section">
          <div class="results-header">
            <div class="results-count" id="resultsCount"><strong><?php echo $toplamEtkinlik; ?></strong> sonuç bulundu</div>            <select class="sort-dropdown" id="sortSelect">
              <option value="all">Tüm Etkinlikler</option>
              <option value="active">Devam Eden Etkinlikler</option>
              <option value="completed">Sonlandırılmış Etkinlikler</option>
            </select>
          </div>
          <div id="categoryContainer" class="category-container">
            <!-- Seçilen kategoriye göre burası dinamik değişecek -->
          </div>

          <!-- Loading Spinner -->
          <div class="loading-spinner d-none" id="loadingSpinner">
            <div class="spinner-border" role="status">
              <span class="visually-hidden">Yükleniyor...</span>
            </div>
            <p class="mt-3">İçerikler yükleniyor...</p>
          </div>

          <!-- News Grid -->
          <div class="news-grid" id="newsGrid">
            <!-- News items will be populated by JavaScript -->
          </div>

          <!-- No Results -->
          <div class="no-results d-none" id="noResults">
            <i class="<?= portalSiteIconClass($db, "arama", "fas fa-search") ?>"></i>
            <h4>Sonuç Bulunamadı</h4>
            <p>
              Arama kriterlerinize uygun içerik bulunamadı. Lütfen farklı anahtar kelimeler deneyin.
            </p>
          </div>

          <!-- Pagination -->
          <nav aria-label="Sayfa navigasyonu">
            <ul class="pagination pagination-custom" id="pagination">
              <!-- Pagination will be populated by JavaScript -->
            </ul>
          </nav>
        </div>
      </div>
    </div>
    <?php include "includes/footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    window.eventData = <?php echo jsonData(mapEtkinlikler($etkinlikler)); ?>;
    </script>
    <script src="../JS/etkinlik.script.js?v=<?php echo (int) @filemtime(
      __DIR__ . "/../JS/etkinlik.script.js",
    ); ?>"></script>
      <script src="../JS/navbar.js"></script>
  </body>
</html>
>>>>>>> da0ab1ce9c2e683fa29c9cbbff849780f358e71f
