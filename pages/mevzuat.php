<?php
include "baglan.php";
$mevzuatlar = dbFetchAll(
  $db,
  "SELECT r.id, r.baslik, r.aciklama, k.slug AS kategori, ak.slug AS alt_kategori,
            r.ikon, r.dosya_yolu, r.resmi_sayfa, r.boyut, r.tarih
     FROM kaynaklar r
     JOIN kaynaklar_kategori k ON r.kategori_id = k.id
     LEFT JOIN kaynaklar_alt_kategori ak ON r.alt_kategori_id = ak.id
     WHERE k.slug = ?
     ORDER BY r.tarih DESC",
  ["Mevzuatlar"],
);
$altKategoriMap = [
  "genel" => "Genel Mevzuatlar",
  "memur" => "Memur Mevzuatları",
  "sozlesmeli" => "Sözleşmeli Memur Mevzuatları",
  "isci" => "İşçi Mevzuatları",
];
?>
<!doctype html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mevzuatlar - Gebze Belediyesi Personel Portalı</title>
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
$pageCss = "mevzuat.style.css";
include "includes/site-styles.php";
?>
  </head>
  <body>
    <?php include "includes/header-nav.php"; ?>
    <?php
    $pageTitle = "Mevzuatlar";
    include "includes/breadcrumb.php";
    ?>
    <div class="main-container">
      <header class="page-header">
        <div class="content">
          <h1>Mevzuatlar</h1>
          <p>Kurumsal işleyişi düzenleyen tüm mevzuatları bu sayfada görüntüleyebilirsiniz</p>
        </div>
      </header>

      <div class="controls-section">
        <div class="search-box">
          <i class="fas fa-search search-icon"></i>
          <input type="text" class="search-input" placeholder="Mevzuat ara..." id="searchInput" />
        </div>
        <div class="filter-buttons">
          <button class="filter-btn" data-filter="protocol">Protokoller</button>
          <button class="filter-btn" data-filter="document">Dökümanlar</button>
          <button class="filter-btn active" data-filter="regulation">Mevzuatlar</button>
          <button class="filter-btn" data-filter="training">Eğitimler</button>
        </div>
      </div>
      <div class="results-header">
        <select class="sort-dropdown" id="sortSelect">
          <option value="all">Tüm Mevzuatlar</option>
          <option value="genel">Genel Mevzuatlar</option>
          <option value="memur">Memur Mevzuatları</option>
          <option value="sozlesmeli">Sözleşmeli Memur Mevzuatları</option>
          <option value="isci">İşçi Mevzuatları</option>
        </select>
      </div>

      <div class="documents-grid" id="documentsGrid">
<?php if (count($mevzuatlar) > 0): ?>
<?php foreach ($mevzuatlar as $row):

  $altKod = !empty($row["alt_kategori"]) ? $row["alt_kategori"] : "genel";
  $altAd = $altKategoriMap[$altKod] ?? "Genel Mevzuatlar";
  $ikon = !empty($row["ikon"]) ? $row["ikon"] : "fa-folder-open";
  $tarihFormat = !empty($row["tarih"]) ? date("d.m.Y", strtotime($row["tarih"])) : "";
  ?>
        <div class="document-card" data-category="regulation" data-type="<?= htmlspecialchars(
          $altKod,
        ) ?>">
          <div class="document-header">
            <div class="document-icon">
              <i class="fas <?= htmlspecialchars($ikon) ?>"></i>
            </div>
            <div class="document-info">
              <h3 class="document-title"><?= htmlspecialchars($row["baslik"]) ?></h3>
              <span class="document-category"><?= htmlspecialchars($altAd) ?></span>
            </div>
          </div>
          <p class="document-description"><?= nl2br(htmlspecialchars($row["aciklama"])) ?></p>
          <a href="#" class="read-more-btn">Devamını Oku</a>
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
<?php if (!empty($row["resmi_sayfa"])): ?>
            <button
              class="preview-btn"
              onclick="previewDocument('<?= htmlspecialchars($row["resmi_sayfa"], ENT_QUOTES) ?>')"
            >
              Resmi Sayfa
            </button>
<?php endif; ?>
<?php if (!empty($row["dosya_yolu"])): ?>
            <button
              class="preview-btn2"
              onclick="previewDocument('<?= htmlspecialchars($row["dosya_yolu"], ENT_QUOTES) ?>')"
            >
              Döküman
            </button>
<?php endif; ?>
          </div>
        </div>
<?php
endforeach; ?>
<?php else: ?>
        <p>Henüz eklenmiş mevzuat bulunmuyor.</p>
<?php endif; ?>
      </div>
    </div>
    <?php include "includes/footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../JS/mevzuat.script.js"></script>
    <script src="../JS/navbar.js"></script>
  </body>
</html>