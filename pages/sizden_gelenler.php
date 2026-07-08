<?php
include("baglan.php");
$sizdenGelenler = dbFetchAll($db, "SELECT * FROM sizden_gelenler ORDER BY tarih DESC");
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
<?php $pageCss = "sizden_gelenler.style.css"; include "includes/site-styles.php"; ?>
  </head>
  <body>
    <?php include "includes/header-nav.php"; ?>
    <?php $pageTitle = "Sizden Gelenler"; include "includes/breadcrumb.php"; ?>
<!-- Breadcrumb Section - Logo ile aynı hizaya getirildi --><!-- Page Header - Logo ile aynı hizaya getirildi -->
    <div class="page-header">
      <div class="nav-container">
        <h2><i class="fas fa-comments"></i>Sizden Gelenler</h2>
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
    window.newsData = <?php echo jsonData(mapSizdenGelenler($sizdenGelenler)); ?>;
    </script>
    <script src="../JS/sizden_gelenler.script.js"></script>
      <script src="../JS/navbar.js"></script>
  </body>
</html>

