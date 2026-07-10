<?php
include "baglan.php";
$kayitlar = dbFetchEtkinliklerDuyurular($db);
?>
<!doctype html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Duyurular - Gebze Belediyesi Personel Portalı</title>
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
$pageCss = "duyuru.style.css";
include "includes/site-styles.php";
?>
  </head>
  <body>
    <?php include "includes/header-nav.php"; ?>
    <?php
    $pageTitle = "Duyurular";
    include "includes/breadcrumb.php";
    ?>
    <div class="main-container container py-5">
      <!-- Sayfa Başlığı -->
      <header class="page-header">
        <div class="content">
          <h1>Duyurular</h1>
          <p>Belediye personellerimize özel tüm duyurulara ulaşabilirsiniz.</p>
        </div>
      </header>

      <!-- Kontroller -->
      <div class="controls-section">
        <div class="search-box">
          <i class="fas fa-search search-icon"></i>
          <input type="text" class="search-input" placeholder="Duyuru ara..." id="searchInput" />
        </div>

        <select class="sort-dropdown" id="sortSelect">
          <option value="all">Tüm Duyurular</option>
          <option value="insan">İnsan Kaynakları Duyuruları</option>
          <option value="bilgi">Bilgi İşlem Duyuruları</option>
        </select>
      </div>

      <!-- Duyurular Grid -->
      <div class="documents-grid news-grid" id="documentsGrid">
<?php foreach ($kayitlar as $k):

  $tarihFmt = !empty($k["tarih"]) ? date("d.m.Y", strtotime($k["tarih"])) : "";
  $resimUrl = imgUrl($k["resim_url"] ?? "");
  ?>
        <div
          class="document-card news-card"
          data-type="<?= htmlspecialchars($k["alt_tip"] ?? "", ENT_QUOTES) ?>"
          data-category="<?= htmlspecialchars($k["alt_tip"] ?? "", ENT_QUOTES) ?>"
          data-baslik="<?= htmlspecialchars($k["baslik"], ENT_QUOTES) ?>"
          data-aciklama="<?= htmlspecialchars($k["aciklama"] ?? "", ENT_QUOTES) ?>"
          data-kategori="<?= htmlspecialchars($k["kategori_adi"] ?? "", ENT_QUOTES) ?>"
          data-tarih="<?= htmlspecialchars($tarihFmt, ENT_QUOTES) ?>"
          data-resim="<?= htmlspecialchars($resimUrl, ENT_QUOTES) ?>"
          data-dosya="<?= htmlspecialchars($k["dosya_url"] ?? "", ENT_QUOTES) ?>"
          data-video="<?= htmlspecialchars($k["video_url"] ?? "", ENT_QUOTES) ?>"
        >
          <img
            src="<?= htmlspecialchars($resimUrl) ?>"
            alt="<?= htmlspecialchars($k["baslik"]) ?>"
            class="news-image"
            loading="lazy"
          />
          <div class="news-content">
            <?php if (!empty($k["kategori_adi"])): ?>
            <span class="document-category news-department-name"><?= htmlspecialchars(
              $k["kategori_adi"],
            ) ?></span>
            <?php endif; ?>
            <h3 class="document-title news-title"><?= htmlspecialchars($k["baslik"]) ?></h3>
            <p class="document-description news-excerpt"><?= htmlspecialchars(
              $k["aciklama"] ?? "",
            ) ?></p>
            <?php if (!empty($k["tarih"])): ?>
            <div class="document-meta news-meta">
              <span class="document-date news-date">
                <i class="fas fa-calendar-alt"></i>
                <?= date("d.m.Y", strtotime($k["tarih"])) ?>
              </span>
            </div>
            <?php endif; ?>
            <div class="download-section">
              <?php if (!empty($k["video_url"])): ?>
              <a class="preview-btn preview-btn-secondary" href="<?= htmlspecialchars(
                $k["video_url"],
              ) ?>" target="_blank" rel="noopener">Videoyu İzle</a>
              <?php endif; ?>
              <button
                class="preview-btn btn-duyuru-detail"
                type="button"
                data-bs-toggle="modal"
                data-bs-target="#duyuruDetailModal"
              >
                Detaylı Bilgi İçin
              </button>
            </div>
          </div>
        </div>
        <?php
endforeach; ?>
      </div>
    </div>

    <div
      class="modal fade"
      id="duyuruDetailModal"
      tabindex="-1"
      aria-labelledby="duyuruDetailModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content duyuru-detail-modal">
          <div class="modal-header">
            <h5 class="modal-title" id="duyuruDetailModalLabel">Duyuru Detayı</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
          </div>
          <div class="modal-body">
            <img id="duyuruModalImage" src="" alt="" class="duyuru-modal-image" />
            <span id="duyuruModalCategory" class="document-category news-department-name d-none"></span>
            <h4 id="duyuruModalTitle" class="duyuru-modal-title"></h4>
            <p id="duyuruModalDate" class="duyuru-modal-date d-none">
              <i class="fas fa-calendar-alt"></i>
              <span></span>
            </p>
            <p id="duyuruModalDescription" class="duyuru-modal-description"></p>
            <div id="duyuruModalActions" class="duyuru-modal-actions d-none"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
          </div>
        </div>
      </div>
    </div>

    <?php include "includes/footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../JS/duyuru.script.js"></script>
      <script src="../JS/navbar.js"></script>
  </body>
</html>
