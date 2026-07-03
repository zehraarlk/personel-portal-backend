<?php
include("baglan.php");
$haberId = isset($_GET["id"]) ? (int)$_GET["id"] : 1;
$haber = dbFetchOne($db, "SELECT * FROM haberler WHERE id = ?", [$haberId]);
$galeri = dbFetchAll($db, "SELECT * FROM haber_galeri WHERE haber_id = ? ORDER BY sira", [$haberId]);
if (empty($galeri) && $haber) {
    $galeri = [["resim_url" => $haber["resim"] ?? ""]];
}
$digerHaberler = dbFetchAll($db, "SELECT * FROM haberler WHERE id != ? ORDER BY id DESC LIMIT 12", [$haberId]);
?>
<!doctype html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Haber Detayı - Gebze Belediyesi Personel Portalı</title>
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
<?php $pageCss = "haber_detay.style.css"; include "includes/site-styles.php"; ?>
  </head>
  <body>
    <?php include "includes/header-nav.php"; ?>
    <?php $pageTitle = "Haber Detayı"; include "includes/breadcrumb.php"; ?>
    <div class="content-area">
      <div class="row">
        <div>
          <article class="news-detail-card">
            <div class="article-header" style="padding: 20px 0">
              <!-- Kategori Rozeti -->
              <div style="margin-bottom: 5px">
                <span
                  class="article-category"
                  id="articleCategory"
                  style="
                    background-color: #0a3044;
                    color: white;
                    padding: 5px 15px;
                    border-radius: 20px;
                    font-size: 12px;
                    font-weight: 600;
                    display: inline-block;
                    letter-spacing: 0.5px;
                    margin-left: 3%;
                  "
                >
                  HABERLER & DUYURULAR
                </span>
              </div>

              <!-- Başlık ve Meta Bilgi: Alt alta -->
              <div
                style="
                  border-bottom: 1px solid #e1e1e1;
                  padding-bottom: 10px;
                  margin-left: 3%;
                  margin-right: 3%;
                "
              >
                <!-- Başlık -->
                <h1
                  id="articleTitle"
                  style="font-size: 40px; font-weight: 700; color: #0a3044; margin: 0"
                >
                  Gebze'de Off-Road Heyecanı
                </h1>

                <!-- Meta Bilgiler -->
                <div
                  class="article-meta"
                  style="
                    display: flex;
                    gap: 20px;
                    font-size: 14px;
                    color: #0a3044;
                    align-items: center;
                    flex-wrap: wrap;
                    margin-top: 8px;
                  "
                >
                  <div class="meta-item" style="display: flex; align-items: center; gap: 5px">
                    <i class="fas fa-calendar-alt"></i>
                    <span id="articleDate">Tarih</span>
                  </div>
                  <div class="meta-item" style="display: flex; align-items: center; gap: 5px">
                    <i class="fas fa-eye"></i>
                    <span id="articleViews">0</span> görüntülenme
                  </div>
                  <div class="meta-item" style="display: flex; align-items: center; gap: 5px">
                    <i class="fas fa-user"></i>
                    <span>Gebze Belediyesi</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="article-image-container">
              <img
                id="main-haber-gorsel"
                src="<?= htmlspecialchars(imgUrl($haber["resim"] ?? "")) ?>"
                alt="<?= htmlspecialchars($haber["baslik"] ?? "Haber görseli") ?>"
                class="article-image"
                style="width: 100%; max-width: 1114px; border-radius: 15px"
              />
              <a href="#" id="ana-haber-link" class="anahaber-baslik-link">
                <h3 id="ana-haber-baslik" class="ana-haber-baslik"></h3>
              </a>
            </div>

            <!-- Galeri Container -->
            <div id="gallery-container" class="mb-4">
              <div class="gallery-wrapper">
                <div id="gallery-track" class="d-flex gap-2"></div>
              </div>
              <div id="gallery-dots" class="d-flex justify-content-center gap-2 mt-3"></div>
            </div>

            <div class="article-content">
              <!-- Kısa özet alanını kaldırdım, sadece haber metni görünecek -->
              <div class="article-body" id="articleBody">
                <!-- Haber metni buraya gelecek -->
                <p style="font-size: 20px">
                  Gebze Belediyesi'nin Denizli Mahallesi'nde düzenlediği ve macera severlerin yoğun
                  ilgi gösterdiği Off-Road Festivali 2 gün süren nefes kesen heyecan dolu yarışların
                  ardından sona erdi. Festivalde dereceye giren ekiplere ödüllerini takdim eden
                  Belediye Başkanı Zinnur Büyükgöz, tüm katılımcılara teşekkür etti.
                </p>
              </div>
            </div>
          </article>
        </div>
        <div>
          <aside class="other-news-box" style="border-left: 5px solid #344e75">
            <h4 class="other-news-title"><i class="fas fa-bullhorn"></i> Diğer Haberler</h4>
            <div id="other-news-list" class="other-news-list">
<?php foreach ($digerHaberler as $h): ?>
              <a href="haber_detay.php?id=<?= (int)$h["id"] ?>" class="other-news-item">
                <img src="<?= htmlspecialchars(imgUrl($h["resim"] ?? "")) ?>" alt="<?= htmlspecialchars($h["baslik"]) ?>" />
                <div>
                  <div class="item-title"><?= htmlspecialchars($h["baslik"]) ?></div>
                  <p style="color: rgb(135, 135, 135)"><?= htmlspecialchars($h["aciklama"] ?? "") ?></p>
                </div>
              </a>
              <?php endforeach; ?>
            </div>
          </aside>
        </div>
      </div>
    </div>
    <?php include "includes/footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    const phpGaleriGorseller = <?php
      $galeriKaynak = !empty($galeri) ? $galeri : [["resim_url" => $haber["resim"] ?? ""]];
      echo jsonData(array_map(function ($g) {
        return ["resim" => imgUrl($g["resim_url"] ?? $g["resim"] ?? "")];
      }, $galeriKaynak));
    ?>;
    const phpHaberBaslik = <?= json_encode($haber["baslik"] ?? "", JSON_UNESCAPED_UNICODE) ?>;
  </script>
    <script src="../JS/haber_detay.script.js"></script>
      <script src="../JS/navbar.js"></script>
  </body>
</html>
