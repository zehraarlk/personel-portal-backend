<?php
<<<<<<< HEAD
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
=======
include "baglan.php";
$sizdenGelenler = dbFetchAll(
  $db,
  "
    SELECT sg.*, k.slug AS kategori_slug, k.ad AS kategori_adi
    FROM sizden_gelenler sg
    LEFT JOIN sizdengelenler_kategori k ON sg.kategori_id = k.id
    ORDER BY sg.tarih DESC
",
);
$toplamKayit = count($sizdenGelenler);
?>
<!doctype html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sizden Gelenler - Gebze Belediyesi Personel Portalı</title>
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
$pageCss = "sizden_gelenler.style.css";
include "includes/site-styles.php";
?>
  </head>
  <body>
    <?php include "includes/header-nav.php"; ?>
    <?php
    $pageTitle = "Sizden Gelenler";
    include "includes/breadcrumb.php";
    ?>
<!-- Breadcrumb Section - Logo ile aynı hizaya getirildi --><!-- Page Header - Logo ile aynı hizaya getirildi -->
    <div class="page-header">
      <div class="nav-container">
        <h2><i class="<?= portalSiteIconClass($db, "sizden_gelenler", "fas fa-comments") ?>"></i>Sizden Gelenler</h2>
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

        <!-- Results Section - Logo ile aynı hizaya getirildi -->
        <div class="results-section">
          <div class="results-header">
            <div class="results-count" id="resultsCount"><strong><?php echo $toplamKayit; ?></strong> sonuç bulundu</div>            <select class="sort-dropdown" id="sortSelect">
              <option value="newest">En Yeni</option>
              <option value="oldest">En Eski</option>
              <option value="most-viewed">En Çok Görüntülenen</option>
              <option value="alphabetical">Alfabetik</option>
            </select>
          </div>

          <!-- Loading Spinner -->
          <div class="loading-spinner d-none" id="loadingSpinner">
            <div class="spinner-border" role="status">
              <span class="visually-hidden">Yükleniyor...</span>
            </div>
            <p class="mt-3">İçerikler yükleniyor...</p>
          </div>

          <!-- News Grid - Logo ile aynı hizaya getirildi -->
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
    window.newsData = <?php echo jsonData(mapSizdenGelenler($sizdenGelenler)); ?>;
    </script>
    <script src="../JS/sizden_gelenler.script.js"></script>
      <script src="../JS/navbar.js"></script>
  </body>
</html>
>>>>>>> da0ab1ce9c2e683fa29c9cbbff849780f358e71f
