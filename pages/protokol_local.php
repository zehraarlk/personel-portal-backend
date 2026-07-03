<?php
include("baglan.php");
$kayitlar = dbFetchAll($db, "SELECT * FROM dokumanlar WHERE sayfa_tipi = ? ORDER BY id", ["protokol"]);
?>
<!doctype html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Protokoller - Gebze Belediyesi Personel Portalı</title>
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
<?php $pageCss = "protokol.style.css"; include "includes/site-styles.php"; ?>
  </head>
  <body>
    <?php include "includes/header-nav.php"; ?>
    <?php $pageTitle = "Protokoller"; include "includes/breadcrumb.php"; ?>
<div class="main-container">
      <!-- Sayfa Başlığı -->
      <header class="page-header">
        <div class="content">
          <h1>Protokoller</h1>
          <p>
            İlgili birimlerle yapılan tüm protokolleri görüntüleyebilir, detaylarına
            ulaşabilirsiniz.
          </p>
        </div>
      </header>

      <!-- Kontroller -->
      <div class="controls-section">
        <div class="search-box">
          <i class="fas fa-search search-icon"></i>
          <input type="text" class="search-input" placeholder="Protokol ara..." id="searchInput" />
        </div>

        <div class="filter-buttons">
          <button class="filter-btn active" data-filter="protocol">Protokoller</button>
          <button class="filter-btn" data-filter="document">Dökümanlar</button>
          <button class="filter-btn" data-filter="regulation">Mevzuatlar</button>
          <button class="filter-btn" data-filter="training">Eğitimler</button>
        </div>
      </div>

      <!-- Dökümanlar Grid -->
      <div class="documents-grid" id="documentsGrid">
<?php foreach ($kayitlar as $k): ?>
        <div class="document-card" data-type="<?= htmlspecialchars($k['alt_tip'] ?? '') ?>" data-category="<?= htmlspecialchars($k['alt_tip'] ?? '') ?>">
          <div class="document-header">
<?php $thumb = documentThumbUrl($k); ?>
<?php if ($thumb): ?>
            <img src="<?= htmlspecialchars($thumb) ?>" alt="" class="document-thumb" />
<?php else: ?>
            <div class="document-icon-fallback" aria-hidden="true"><i class="fas <?= documentIconClass($k) ?>"></i></div>
<?php endif; ?>
            <div class="document-info">
              <h3 class="document-title"><?= htmlspecialchars($k['baslik']) ?></h3>
              <span class="document-category"><?= htmlspecialchars($k['kategori_adi'] ?? '') ?></span>
            </div>
          </div>
          <p class="document-description"><?= htmlspecialchars($k['aciklama'] ?? '') ?></p>
          <?php if (!empty($k['tarih'])): ?>
          <div class="document-meta">
            <div class="document-date"><i class="fas fa-calendar-alt"></i> <?= date('d.m.Y', strtotime($k['tarih'])) ?></div>
          </div>
          <?php endif; ?>
          <div class="download-section">
            <?php if (!empty($k['video_url'])): ?>
            <a class="preview-btn" href="<?= htmlspecialchars($k['video_url']) ?>" target="_blank">Videoyu İzle</a>
            <?php elseif (!empty($k['hedef_url'])): ?>
            <a class="preview-btn" href="<?= htmlspecialchars($k['hedef_url']) ?>" target="_blank">Detaylı Bilgi İçin</a>
            <?php else: ?>
            <button class="preview-btn">Detaylı Bilgi İçin</button>
            <?php endif; ?>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php include "includes/footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../JS/protokol.script.js"></script>
      <script src="../JS/navbar.js"></script>
  </body>
</html>
