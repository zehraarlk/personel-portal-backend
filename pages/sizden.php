<?php
include "baglan.php";
$kayitId = isset($_GET["id"]) ? (int) $_GET["id"] : 1;
$kayit = dbFetchOne(
  $db,
  "SELECT sg.*, k.slug AS kategori_slug, k.ad AS kategori_adi
     FROM sizden_gelenler sg
     LEFT JOIN sizdengelenler_kategori k ON sg.kategori_id = k.id
     WHERE sg.id = ?",
  [$kayitId],
);
if (!$kayit) {
  header("Location: sizden_gelenler.php");
  exit();
}

$viewResult = dbBumpUniqueView($db, "sizden_gelenler", $kayitId, "goruntulenme");
$kayit["goruntulenme"] = $viewResult["count"];

$digerKayitlar = dbFetchAll(
  $db,
  "SELECT sg.*, k.slug AS kategori_slug, k.ad AS kategori_adi
     FROM sizden_gelenler sg
     LEFT JOIN sizdengelenler_kategori k ON sg.kategori_id = k.id
     WHERE sg.id != ?
     ORDER BY sg.tarih DESC
     LIMIT 18",
  [$kayitId],
);
$digerKayitSayfalari = array_chunk($digerKayitlar, 6);
?>
<!doctype html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo htmlspecialchars(
      $kayit["baslik"],
    ); ?> - Gebze Belediyesi Personel Portalı</title>
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
$pageCss = "sizden_gelen_detay.style.css";
$useDetailLayout = true;
include "includes/site-styles.php";
?>
  </head>
  <body class="detail-page">
    <?php include "includes/header-nav.php"; ?>
    <?php
    $pageTitle = "Sizden Gelenler";
    include "includes/breadcrumb.php";
    ?>
<div class="content-area">
      <div class="container">
        <div class="row detail-layout-row gx-3 gx-lg-4 gy-0">
          <div class="col-12 col-lg-8">
            <article class="news-detail-card">
              <div class="article-header">
                <span class="article-category" id="articleCategory"
                  ><?php echo htmlspecialchars($kayit["kategori_adi"] ?? ""); ?></span
                >
                <h1 class="article-title" id="articleTitle">
                  <?php echo htmlspecialchars($kayit["baslik"]); ?>
                </h1>
                <div class="article-meta">
                  <div class="meta-item">
                    <i class="fas fa-calendar-alt"></i>
                    <span id="articleDate"><?php echo date(
                      "d.m.Y",
                      strtotime($kayit["tarih"]),
                    ); ?></span>
                  </div>
                  <div class="meta-item">
                    <i class="fas fa-eye"></i>
                    <span id="articleViews"><?php echo (int) $kayit[
                      "goruntulenme"
                    ]; ?></span> görüntülenme
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
                    src="<?php echo htmlspecialchars(imgUrl($kayit["gorsel_yolu"] ?? "")); ?>"
                    alt="<?php echo htmlspecialchars($kayit["baslik"]); ?>"
                    class="article-image"
                    id="mainArticleImage"
                  />
                </div>
              </div>

              <div class="article-content">
                <div class="article-body" id="articleBody">
                  <?php echo nl2br(htmlspecialchars($kayit["ozet"])); ?>
                </div>
              </div>

              <div class="article-actions">
                <div class="back-button">
                  <a href="sizden_gelenler.php" class="btn-back">
                    <i class="fas fa-arrow-left"></i>
                    Geri Dön
                  </a>
                </div>
              </div>
            </article>
          </div>

          <div class="col-12 col-lg-4">
            <div class="other-departments-card">
              <div class="departments-header">
                <h3 class="departments-title">
                  <i class="fas fa-comments"></i>
                  Diğer Paylaşımlar
                </h3>
              </div>

              <div class="departments-slider">
                <div class="departments-track" id="deptTrack">
                  <?php if (empty($digerKayitSayfalari)): ?>
                  <div class="department-item">
                    <p class="text-muted px-2 mb-0">Gösterilecek başka kayıt bulunmuyor.</p>
                  </div>
                  <?php else: ?>
                    <?php foreach ($digerKayitSayfalari as $sayfa): ?>
                  <div class="department-item">
                      <?php foreach ($sayfa as $item): ?>
                    <a href="sizden.php?id=<?php echo (int) $item[
                      "id"
                    ]; ?>" class="other-news-item">
                      <img
                        src="<?php echo htmlspecialchars(imgUrl($item["gorsel_yolu"] ?? "")); ?>"
                        class="other-news-img"
                        alt="<?php echo htmlspecialchars($item["baslik"]); ?>"
                      />
                      <div class="other-news-content">
                        <div class="department-category"><?php echo htmlspecialchars(
                          $item["kategori_adi"] ?? "",
                        ); ?></div>
                        <h5 class="other-news-title"><?php echo htmlspecialchars(
                          $item["baslik"],
                        ); ?></h5>
                        <p class="other-news-description">
                          <?php echo htmlspecialchars(
                            mb_strimwidth(strip_tags($item["ozet"]), 0, 90, "..."),
                          ); ?>
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
                <button class="pagination-btn prev-btn" id="prevDeptBtn" title="Önceki sayfa" type="button">
                  <i class="fas fa-chevron-left"></i>
                </button>
                <span class="dept-page-info" id="deptPageInfo">Sayfa 1 / 1</span>
                <button class="pagination-btn next-btn" id="nextDeptBtn" title="Sonraki sayfa" type="button">
                  <i class="fas fa-chevron-right"></i>
                </button>
              </div>
              <div class="pagination-dots" id="paginationDots" hidden></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include "includes/footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../JS/sizden_gelen_detay.script.js"></script>
    <script src="../JS/navbar.js"></script>
  </body>
</html>
