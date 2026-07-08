<?php
include("baglan.php");

$duyuruTable = dbAnasayfaDuyurularTable($db);
$duyuruId = isset($_GET["id"]) ? (int)$_GET["id"] : 0;
$duyuru = $duyuruId > 0
    ? dbFetchOne($db, "SELECT * FROM `{$duyuruTable}` WHERE id = ?", [$duyuruId])
    : null;

if (!$duyuru) {
    header("Location: duyuru.php");
    exit;
}

$digerDuyurular = dbFetchAll(
    $db,
    "SELECT * FROM `{$duyuruTable}` WHERE id != ? ORDER BY id DESC LIMIT 18",
    [$duyuruId]
);
$digerDuyuruSayfalari = array_chunk($digerDuyurular, 6);
?>
<!doctype html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo htmlspecialchars($duyuru['baslik']); ?> - Gebze Belediyesi Personel Portalı</title>
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
<?php $pageCss = "etkinlik_detay.style.css"; include "includes/site-styles.php"; ?>
  </head>
  <body>
    <?php include "includes/header-nav.php"; ?>
    <?php $pageTitle = "Duyuru Detayı"; include "includes/breadcrumb.php"; ?>
<div class="content-area">
      <div class="container">
        <div class="row">
          <div class="col-lg-8">
            <article class="news-detail-card">
              <div class="article-header">
                <h1 class="article-title" id="articleTitle"><?php echo htmlspecialchars($duyuru['baslik']); ?></h1>
                <div class="article-meta">
                  <div class="meta-item">
                    <i class="fas fa-bell"></i>
                    <span>Duyuru</span>
                  </div>
                  <div class="meta-item">
                    <i class="fas fa-user"></i>
                    <span>Gebze Belediyesi</span>
                  </div>
                </div>
              </div>

              <div class="article-image-section">
                <div class="article-image-container">
                  <img
                    src="<?php echo htmlspecialchars(imgUrl($duyuru['resim'] ?? '')); ?>"
                    alt="<?php echo htmlspecialchars($duyuru['baslik']); ?>"
                    class="article-image"
                    id="mainArticleImage"
                  />
                </div>
              </div>

              <div class="article-content">
                <div class="article-body" id="articleBody">
                  <?php echo nl2br(htmlspecialchars($duyuru['aciklama'] ?? '')); ?>
                </div>
              </div>

              <div class="article-actions">
                <div class="back-button">
                  <a href="ana_sayfa.php" class="btn-back">
                    <i class="fas fa-arrow-left"></i>
                    Geri Dön
                  </a>
                </div>
              </div>
            </article>
          </div>

          <div class="col-lg-4">
            <div class="other-departments-card">
              <div class="departments-header">
                <h3 class="departments-title">
                  <i class="fas fa-bell"></i>
                  Diğer Duyurular
                </h3>
              </div>

              <div class="departments-slider">
                <div class="departments-track" id="deptTrack">
                  <?php if (empty($digerDuyuruSayfalari)): ?>
                  <div class="department-item">
                    <p class="text-muted px-2 mb-0">Gösterilecek başka duyuru bulunmuyor.</p>
                  </div>
                  <?php else: ?>
                    <?php foreach ($digerDuyuruSayfalari as $sayfa): ?>
                  <div class="department-item">
                      <?php foreach ($sayfa as $item): ?>
                    <a href="duyurud.php?id=<?php echo (int)$item['id']; ?>" class="other-news-item">
                      <img
                        src="<?php echo htmlspecialchars(imgUrl($item['resim'] ?? '')); ?>"
                        class="other-news-img"
                        alt="<?php echo htmlspecialchars($item['baslik']); ?>"
                      />
                      <div class="other-news-content">
                        <h5 class="other-news-title"><?php echo htmlspecialchars($item['baslik']); ?></h5>
                        <p class="other-news-description">
                          <?php echo htmlspecialchars(mb_strimwidth(strip_tags($item['aciklama'] ?? ''), 0, 90, '...')); ?>
                        </p>
                      </div>
                    </a>
                      <?php endforeach; ?>
                  </div>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </div>
              </div>

              <div class="departments-pagination">
                <button class="pagination-btn prev-btn" id="prevDeptBtn" title="Önceki duyurular">
                  <i class="fas fa-chevron-left"></i>
                </button>
                <div class="pagination-dots" id="paginationDots"></div>
                <button class="pagination-btn next-btn" id="nextDeptBtn" title="Sonraki duyurular">
                  <i class="fas fa-chevron-right"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include "includes/footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../JS/etkinlik_detay.script.js"></script>
    <script src="../JS/navbar.js"></script>
  </body>
</html>
