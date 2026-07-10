<?php
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
        <h2><i class="fa-solid fa-calendar-days"></i> Etkinlikler & Aktiviteler</h2>
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
              <i class="fas fa-search"></i>
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
            <i class="fas fa-search"></i>
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
    <script src="../JS/etkinlik.script.js"></script>
      <script src="../JS/navbar.js"></script>
  </body>
</html>