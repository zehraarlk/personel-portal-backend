<?php
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
          <i class="fas fa-search search-icon"></i>
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
              <i class="fas fa-external-link-alt link-fallback-icon" aria-hidden="true"></i>
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