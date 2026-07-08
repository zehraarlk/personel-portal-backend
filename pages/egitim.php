<?php
include("baglan.php");
$egitimler = dbFetchAll(
    $db,
    "SELECT id, baslik, aciklama, kategori, dosya_yolu, boyut, tarih FROM kaynaklar WHERE kategori = ? ORDER BY tarih DESC",
    ["Eğitimler"]
);
?>
<!doctype html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Eğitim - Gebze Belediyesi Personel Portalı</title>
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
<?php $pageCss = "egitim.style.css"; include "includes/site-styles.php"; ?>
  </head>
  <body>
    <?php include "includes/header-nav.php"; ?>
    <?php $pageTitle = "Eğitim"; include "includes/breadcrumb.php"; ?>
    <div class="main-container container-py-5">
      <header class="page-header">
        <div class="content">
          <h1>Eğitimler</h1>
          <p>Eğitim videoları, formlar ve ilgili tüm dokümanlara bu bölümden ulaşabilirsiniz.</p>
        </div>
      </header>

      <div class="controls-section">
        <div class="search-box">
          <i class="fas fa-search search-icon"></i>
          <input type="text" class="search-input" placeholder="Eğitim ara..." id="searchInput" />
        </div>
        <div class="filter-buttons">
          <button class="filter-btn" data-filter="protocol">Protokoller</button>
          <button class="filter-btn" data-filter="document">Dökümanlar</button>
          <button class="filter-btn" data-filter="regulation">Mevzuatlar</button>
          <button class="filter-btn active" data-filter="training">Eğitimler</button>
        </div>
      </div>

      <div class="documents-grid" id="documentsGrid">
<?php if (count($egitimler) > 0): ?>
<?php foreach ($egitimler as $row):
    $tarihFormat = !empty($row["tarih"]) ? date("d.m.Y", strtotime($row["tarih"])) : "";
    $video = htmlspecialchars($row["dosya_yolu"], ENT_QUOTES);
?>
        <div class="document-card" data-category="training">
          <div class="document-header">
            <div class="document-info">
              <h3 class="document-title"><?= htmlspecialchars($row["baslik"]) ?></h3>
              <span class="document-category">Eğitimler</span>
            </div>
          </div>
          <p class="document-description"><?= htmlspecialchars($row["aciklama"]) ?></p>
          <div class="document-meta">
            <div class="document-size">
              <i class="fas fa-file-pdf"></i>
              PDF • <?= htmlspecialchars($row["boyut"]) ?>
            </div>
            <div class="document-date">
              <i class="fas fa-calendar-alt"></i>
              <?= $tarihFormat ?>
            </div>
          </div>
          <div class="download-section">
            <button class="preview-btn" onclick="previewYouTubeVideo('<?= $video ?>')">
              <i class="fas fa-video"></i> Video
            </button>
            <button class="preview-btn" onclick="previewYouTubeVideo('<?= $video ?>')">
              <i class="fas fa-file-alt"></i> Belge
            </button>
            <button class="preview-btn" onclick="previewYouTubeVideo('<?= $video ?>')">
              <i class="fas fa-file"></i> Döküman
            </button>
          </div>
        </div>
<?php endforeach; ?>
<?php else: ?>
        <p>Henüz eklenmiş eğitim bulunmuyor.</p>
<?php endif; ?>
      </div>
    </div>
    <?php include "includes/footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../JS/egitim.script.js"></script>
    <script src="../JS/navbar.js"></script>
  </body>
</html>
