<?php
include("baglan.php");
$etkinlikId = isset($_GET["id"]) ? (int)$_GET["id"] : 1;
$etkinlik = dbFetchOne($db, "SELECT * FROM etkinlikler WHERE id = ?", [$etkinlikId]);
if (!$etkinlik) {
    header("Location: etkinlikler.php");
    exit;
}

// Görüntülenme sayısını 1 artır ve güncel değeri ekranda göstermek için diziyi de güncelle
$db->prepare("UPDATE etkinlikler SET view = view + 1 WHERE id = ?")
   ->execute([$etkinlikId]);
$etkinlik['view'] = (int)$etkinlik['view'] + 1;

$digerEtkinlikler = dbFetchAll(
    $db,
    "SELECT * FROM etkinlikler WHERE id != ? ORDER BY tarih DESC LIMIT 18",
    [$etkinlikId]
);
$digerEtkinlikSayfalari = array_chunk($digerEtkinlikler, 6);
?>
<!doctype html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo htmlspecialchars($etkinlik['baslik']); ?> - Gebze Belediyesi Personel Portalı</title>
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
    <?php $pageTitle = "Etkinlik Detayı"; include "includes/breadcrumb.php"; ?>
<div class="content-area">
      <div class="container">
        <div class="row">
          <div class="col-lg-8">
            <article class="news-detail-card">
              <div class="article-header">
                <h1 class="article-title" id="articleTitle"><?php echo htmlspecialchars($etkinlik['baslik']); ?></h1>
                <div class="article-meta">
                  <div class="meta-item">
                    <i class="fas fa-calendar-alt"></i>
                    <span id="articleDate"><?php echo date("d.m.Y", strtotime($etkinlik['tarih'])); ?></span>
                  </div>
                  <div class="meta-item">
                    <i class="fas fa-eye"></i>
                    <span id="articleViews"><?php echo (int)$etkinlik['view']; ?></span> görüntülenme
                  </div>
                  <div class="meta-item">
                    <i class="fas fa-user"></i>
                    <span>Gebze Belediyesi</span>
                  </div>
                </div>
              </div>

              <!-- Ana resim ve küçük resimler slider'ı -->
              <div class="article-image-section">
                <div class="article-image-container">
                  <img
                    src="<?php echo htmlspecialchars($etkinlik['resim']); ?>"
                    alt="<?php echo htmlspecialchars($etkinlik['baslik']); ?>"
                    class="article-image"
                    id="mainArticleImage"
                  />
                </div>
              </div>

              <div class="article-content">
                <div class="article-body" id="articleBody">
                  <?php echo nl2br(htmlspecialchars($etkinlik['aciklama'])); ?>
                </div>
              </div>

              <div class="article-actions">
                <div class="back-button">
                  <a href="etkinlikler.php" class="btn-back">
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
                  <i class="fas fa-building"></i>
                  Diğer Müdürlükler
                </h3>
              </div>

              <!-- SLIDER: 6 haber için güncellenmiş yapı -->
              <div class="departments-slider">
                <div class="departments-track" id="deptTrack">
                  <?php if (empty($digerEtkinlikSayfalari)): ?>
                  <div class="department-item">
                    <p class="text-muted px-2 mb-0">Gösterilecek başka etkinlik bulunmuyor.</p>
                  </div>
                  <?php else: ?>
                    <?php foreach ($digerEtkinlikSayfalari as $sayfa): ?>
                  <div class="department-item">
                      <?php foreach ($sayfa as $item): ?>
                    <a href="etkinlikd.php?id=<?php echo (int)$item['id']; ?>" class="other-news-item">
                      <img
                        src="<?php echo htmlspecialchars(imgUrl($item['resim'] ?? '')); ?>"
                        class="other-news-img"
                        alt="<?php echo htmlspecialchars($item['baslik']); ?>"
                      />
                      <div class="other-news-content">
                        <h5 class="other-news-title"><?php echo htmlspecialchars($item['baslik']); ?></h5>
                        <p class="other-news-description">
                          <?php echo htmlspecialchars(mb_strimwidth(strip_tags($item['aciklama']), 0, 90, '...')); ?>
                        </p>
                      </div>
                    </a>
                      <?php endforeach; ?>
                  </div>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </div>
              </div>

              <!-- Nokta göstergeleri ile güncellenen sayfalandırma -->
              <div class="departments-pagination">
                <button class="pagination-btn prev-btn" id="prevDeptBtn" title="Önceki müdürlük">
                  <i class="fas fa-chevron-left"></i>
                </button>

                <!-- Nokta göstergeleri -->
                <div class="pagination-dots" id="paginationDots">
                  <!-- JavaScript ile dinamik olarak oluşturulacak -->
                </div>

                <button class="pagination-btn next-btn" id="nextDeptBtn" title="Sonraki müdürlük">
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