<?php
include("baglan.php");
$haberler = array_map(function ($h) {
    $h["resim"] = imgUrl($h["resim"] ?? "");
    return $h;
}, dbFetchAll($db, "SELECT * FROM haberler ORDER BY id DESC"));
$duyurular = array_map(function ($d) {
    $d["resim"] = imgUrl($d["resim"] ?? "");
    return $d;
}, dbFetchAnasayfaDuyurular($db));
$personeller = mapPersonelJs(dbFetchAll($db, "SELECT * FROM personeller ORDER BY ad"));
$otomasyonLinkleri = dbFetchAll($db, "SELECT * FROM yardimci_linkler WHERE kategori = ? ORDER BY id", ["kurum-ici"]);
$ilkHaber = $haberler[0] ?? null;
?>
<!doctype html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ana Sayfa - Gebze Belediyesi Personel Portalı</title>
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
<?php $pageCss = "ana_sayfa.style.css"; include "includes/site-styles.php"; ?>
  </head>
  <body>
    <?php include "includes/header-nav.php"; ?>
    <div class="content-area">
      <div class="container bg-light py-4 py-sm-5">
        <div class="container-fluid">
          <div class="row g-4 g-lg-5 justify-content-center">
            <div class="col-12 col-lg-8">
              <div class="card shadow-lg border-0 rounded-4 p-3 p-sm-4">
                <!-- Haberler Başlığı -->
                <div class="d-flex align-items-center mb-3" style="width: 100%; max-width: 1600px">
                  <div class="title-v1">
                    <h2 class="title-v2"><i class="fas fa-bullhorn"></i> Haberler & Etkinlikler</h2>
                  </div>
                </div>
                <!-- Ana Haber Resmi ve Başlığı -->
                <div class="ana-haber-container mb-4">
                  <img
                    id="main-haber-gorsel"
                    src="<?= htmlspecialchars($ilkHaber["resim"] ?? "../images/logo(2).png") ?>"
                    alt="Haber görseli"
                    class="img-fluid rounded-3 shadow-sm w-100 object-fit-cover"
                    style="max-height: 500px"
                  />
                  <div class="ana-haber-baslik-container">
                    <a href="" id="ana-haber-link" class="ana-haber-baslik-link">
                      <h3 id="ana-haber-baslik" class="ana-haber-baslik">
                        8 Mart Dünya Kadınlar Günü Programı
                      </h3>
                    </a>
                  </div>
                </div>

                <!-- Galeri Container -->
                <div id="gallery-container" class="mb-4">
                  <button id="gallery-prev-btn" class="gallery-nav-arrow prev" title="Önceki">
                    <i class="fas fa-chevron-left"></i>
                  </button>
                  <button id="gallery-next-btn" class="gallery-nav-arrow next" title="Sonraki">
                    <i class="fas fa-chevron-right"></i>
                  </button>
                  <div class="gallery-wrapper">
                    <div id="gallery-track" class="d-flex gap-2"></div>
                  </div>
                  <div id="gallery-dots" class="d-flex justify-content-center gap-2 mt-3"></div>
                </div>
              </div>
            </div>

            <div class="col-12 col-lg-4">
              <div class="card shadow-lg border-0 rounded-4 p-3 p-sm-4 h-100 d-flex flex-column">
                <div class="duyurular-header">
                  <h2 class="duyurular-baslik"><i class="fas fa-bell me-2"></i>Duyurular</h2>
                </div>
                <hr />
                <div id="duyurular-listesi" class="duyurular-govde"></div>

                <div id="pagination-controls" class="pagination-controls mt-auto pt-3">
                  <button id="prev-page" class="pagination-arrow" title="Önceki Sayfa">
                    <i class="fas fa-chevron-left"></i>
                  </button>
                  <span id="sayfa-bilgisi" class="sayfa-bilgisi">Sayfa 1 / 5</span>
                  <button id="next-page" class="pagination-arrow" title="Sonraki Sayfa">
                    <i class="fas fa-chevron-right"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div class="row g-4 justify-content-center mt-4">
            <div class="col-12">
              <div class="card shadow-lg border-0 rounded-4 p-4">
                <div class="content-area">
                  <div class="container-fluid px-4 py-4">
                    <div class="page-header-container">
                      <div class="header-icon-wrapper">
                        <i class="fa-solid fa-cake-candles"></i>
                      </div>
                      <div class="header-text-wrapper">
                        <h2 class="header-title-main">Mutlu Yıllar !</h2>
                        <p class="header-subtitle">25 Ağustos 2025</p>
                      </div>
                    </div>
                    <div
                      id="personelListesi"
                      class="row row-cols-1 row-cols-md-3 row-cols-lg-6 g-4"
                    ></div>

                    <div id="bosMesaj" class="alert alert-secondary text-center mt-4 d-none">
                      Bugün doğum günü olan personel bulunmamaktadır.
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Otomasyon Sistemleri Bölümü -->
          <div class="row g-4 justify-content-center mt-4">
            <div class="col-12">
              <div class="card shadow-lg border-0 rounded-4 p-4">
                <div class="otomasyon-header mb-4">
                  <div
                    class="d-flex align-items-center mb-3"
                    style="
                      background-color: #fff;
                      padding: 1rem;
                      border-left: 5px solid #344e75;
                      border-radius: 10px;
                      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
                    "
                  >
                    <h2 class="otomasyon-baslik mb-0 fw-bold">Kurum İçi Otomasyon Sistemleri</h2>
                  </div>
                </div>
                <div class="otomasyon-grid">
<?php foreach ($otomasyonLinkleri as $link):
    $logo = otomasyonLogoUrl($link["baslik"], $link["logo_url"] ?? "");
?>
                  <div class="otomasyon-item">
                    <div class="otomasyon-logo">
                      <?php if ($logo): ?>
                      <img src="<?= htmlspecialchars($logo) ?>" alt="<?= htmlspecialchars($link["baslik"]) ?>" class="otomasyon-icon" />
                      <?php else: ?>
                      <div class="otomasyon-icon-fallback" aria-hidden="true"><i class="fas fa-desktop"></i></div>
                      <?php endif; ?>
                    </div>
                    <h3 class="otomasyon-isim"><?= htmlspecialchars($link["baslik"]) ?></h3>
                    <a href="<?= htmlspecialchars($link["hedef_url"] ?? "#") ?>" target="_blank" rel="noopener" class="otomasyon-btn">
                      <i class="fas fa-external-link-alt me-2"></i>Sisteme Git
                    </a>
                  </div>
<?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include "includes/footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const veritabanindanGelenHaberler = <?php echo jsonData($haberler); ?>;
        const veritabanindanGelenDuyurular = <?php echo jsonData($duyurular); ?>;
        const veritabanindanGelenPersonel = <?php echo jsonData($personeller); ?>;
    </script>
    <script src="../JS/ana_sayfa.script.js"></script>
      <script src="../JS/navbar.js"></script>
  </body>
</html>