<?php
include "baglan.php";
$dokumanlar = dbFetchAll(
  $db,
  "SELECT r.id, r.baslik, r.aciklama, k.slug AS kategori, r.ikon, r.dosya_yolu, r.boyut, r.tarih
     FROM kaynaklar r
     JOIN kaynaklar_kategori k ON r.kategori_id = k.id
     WHERE k.slug = ?
     ORDER BY r.tarih DESC",
  ["Dökümanlar"],
);
?>
<!doctype html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dokümanlar - Gebze Belediyesi Personel Portalı</title>
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
$pageCss = "dokumanlar.style.css";
include "includes/site-styles.php";
?>
  </head>
  <body>
    <?php include "includes/header-nav.php"; ?>
    <?php
    $pageTitle = "Dokümanlar";
    include "includes/breadcrumb.php";
    ?>
    <div class="main-container">
      <header class="page-header">
        <div class="content">
          <h1>Dökümanlar</h1>
          <p>Personel için önemli belgeler, formlar ve yönergeler</p>
        </div>
      </header>

      <div class="controls-section">
        <div class="search-box">
          <i class="fas fa-search search-icon"></i>
          <input type="text" class="search-input" placeholder="Döküman ara..." id="searchInput" />
        </div>
        <div class="filter-buttons">
          <button class="filter-btn" data-filter="protocol">Protokoller</button>
          <button class="filter-btn active" data-filter="document">Dökümanlar</button>
          <button class="filter-btn" data-filter="regulation">Mevzuatlar</button>
          <button class="filter-btn" data-filter="training">Eğitimler</button>
        </div>
      </div>

      <div class="documents-grid" id="documentsGrid">
<?php if (count($dokumanlar) > 0): ?>
<?php foreach ($dokumanlar as $row):

  $uzanti = strtolower(pathinfo($row["dosya_yolu"], PATHINFO_EXTENSION));
  $extIcon = "fa-file-alt";
  if ($uzanti === "pdf") {
    $extIcon = "fa-file-pdf";
  } elseif (in_array($uzanti, ["doc", "docx"], true)) {
    $extIcon = "fa-file-word";
  } elseif (in_array($uzanti, ["xls", "xlsx"], true)) {
    $extIcon = "fa-file-excel";
  }
  $icon = !empty($row["ikon"]) ? $row["ikon"] : $extIcon;
  $tarihFormat = !empty($row["tarih"]) ? date("d.m.Y", strtotime($row["tarih"])) : "";
  ?>
        <div class="document-card" data-category="document">
          <div class="document-header">
            <div class="document-icon">
              <i class="fas <?= htmlspecialchars($icon) ?>"></i>
            </div>
            <div class="document-info">
              <h3 class="document-title"><?= htmlspecialchars($row["baslik"]) ?></h3>
              <span class="document-category">Dökümanlar</span>
            </div>
          </div>
          <p class="document-description"><?= nl2br(htmlspecialchars($row["aciklama"])) ?></p>
          <div class="document-meta">
            <div class="document-size">
              <i class="fas <?= $extIcon ?>"></i>
              <?= strtoupper($uzanti) ?> • <?= htmlspecialchars($row["boyut"]) ?>
            </div>
            <div class="document-date">
              <i class="fas fa-calendar-alt"></i>
              <?= $tarihFormat ?>
            </div>
          </div>
          <div class="download-section">
            <a href="<?= htmlspecialchars($row["dosya_yolu"]) ?>" download class="download-btn">
              <i class="fas fa-download"></i> İndir
            </a>
            <button
              class="preview-btn"
              onclick="previewDocument('<?= htmlspecialchars($row["dosya_yolu"], ENT_QUOTES) ?>')"
            >
              <i class="fas fa-eye"></i>
            </button>
          </div>
        </div>
<?php
endforeach; ?>
<?php else: ?>
        <p>Henüz eklenmiş döküman bulunmuyor.</p>
<?php endif; ?>
      </div>
    </div>
    <?php include "includes/footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../JS/dokumanlar.script.js"></script>
    <script src="../JS/navbar.js"></script>
  </body>
</html>