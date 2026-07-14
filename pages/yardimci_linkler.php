<?php
<<<<<<< HEAD
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
=======
include "baglan.php";
$kayitlar = dbFetchYardimciLinkler($db);
?>
<!doctype html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Yardımcı Linkler - Gebze Belediyesi Personel Portalı</title>
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
$pageCss = "yardimci_link.style.css";
include "includes/site-styles.php";
?>
  </head>
  <body>
    <?php include "includes/header-nav.php"; ?>
    <?php
    $pageTitle = "Yardımcı Linkler";
    include "includes/breadcrumb.php";
    ?>
<!-- Breadcrumb --><div class="main-container">
      <!-- Sayfa Başlığı -->
      <header class="page-header">
        <div class="content">
          <h1>Yardımcı Linkler</h1>
        </div>
      </header>

      <!-- Kontroller -->
      <div class="controls-section">
        <div class="search-box">
          <i class="<?= portalSiteIconClass($db, "arama", "fas fa-search") ?> search-icon"></i>
          <input
            type="text"
            class="search-input"
            placeholder="Yardımcı link ara..."
            id="searchInput"
          />
        </div>
        <div class="results-header">
          <select class="sort-dropdown" id="sortSelect">
            <option value="all">Tüm Yardımcı Linkler</option>
            <option value="kurum-ici">Kurum İçi Linkler</option>
            <option value="website">Website Linkler</option>
            <option value="bilgi">Bilgi Portalları</option>
            <option value="faydalı">Faydalı Linkler</option>
          </select>
        </div>
        <div class="links-grid" id="linksGrid">
<?php foreach ($kayitlar as $k):
  $logo = yardimciLinkLogo($k); ?>
          <div class="link-card" data-category="<?= htmlspecialchars($k["kategori"]) ?>">
            <div class="card-image">
<?php if ($logo): ?>
              <img src="<?= htmlspecialchars($logo) ?>" alt="<?= htmlspecialchars(
  $k["baslik"],
) ?>" class="system-logo" />
<?php else: ?>
              <i class="<?= portalSiteIconClass($db, "harici_baglanti", "fas fa-external-link-alt") ?> link-fallback-icon" aria-hidden="true"></i>
<?php endif; ?>
            </div>
            <h3 class="link-title"><?= htmlspecialchars($k["baslik"]) ?></h3>
            <a class="site-btn" href="<?= htmlspecialchars(
              $k["hedef_url"],
            ) ?>" target="_blank"> Siteye Git </a>
          </div>
          <?php
endforeach; ?>
        </div>
      </div>
    </div>
    <?php include "includes/footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../JS/yardimci_link.script.js"></script>
      <script src="../JS/navbar.js"></script>
  </body>
</html>
>>>>>>> da0ab1ce9c2e683fa29c9cbbff849780f358e71f
