<?php
<<<<<<< HEAD
declare(strict_types=1);

require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/db-helpers.php';
require_once __DIR__ . '/../includes/icons.php';

$pageTitle = 'Ana Sayfa';
$pageCss = 'ana_sayfa.css';
$showBreadcrumb = false;

$haberler = [];
$duyurular = [];
$personeller = [];
$otomasyonLinkleri = [];
$dogumGunu = [];
$ilkHaber = null;
$bugunTarih = getTurkishDateLabel();
$dbError = '';

try {
    $anasayfa = loadAnasayfaData($assetBase);
    $haberler = $anasayfa['haberler'];
    $duyurular = $anasayfa['duyurular'];
    $personeller = $anasayfa['personeller'];
    $otomasyonLinkleri = $anasayfa['otomasyonLinkleri'];
    $dogumGunu = $anasayfa['dogumGunu'];
    $ilkHaber = $anasayfa['ilkHaber'];
    $bugunTarih = $anasayfa['bugunTarih'];
} catch (Throwable $e) {
    $dbError = $e->getMessage();
    error_log('Anasayfa veritabani hatasi: ' . $dbError);
}

$duyuruSayfaBoyutu = 4;
$duyuruToplamSayfa = max(1, (int) ceil(count($duyurular) / $duyuruSayfaBoyutu));
$duyuruIlkSayfa = array_slice($duyurular, 0, $duyuruSayfaBoyutu);

require __DIR__ . '/../includes/site-head.php';
require __DIR__ . '/../includes/header-nav.php';
?>

<main class="content-area home-page">
    <div class="site-container">
        <?php if ($dbError !== ''): ?>
        <p class="home-empty home-db-error">Veritabanı bağlantısı kurulamadı. phpMyAdmin'de <strong>personel_db</strong> veritabanının <code>db/personel_db.sql</code> dosyasından import edildiğinden emin olun.</p>
        <?php endif; ?>

        <div class="home-layout">
            <section class="home-card" aria-labelledby="haberler-title">
                <header class="home-card-header">
                    <span class="icon" aria-hidden="true"><?= icon('megaphone') ?></span>
                    <h2 id="haberler-title" class="home-card-title">Haberler &amp; Etkinlikler</h2>
                </header>

                <div class="ana-haber-container">
                    <img
                        id="main-haber-gorsel"
                        src="<?= e($ilkHaber['resim'] ?? logoUrl($assetBase)) ?>"
                        alt="<?= e($ilkHaber['baslik'] ?? 'Haber görseli') ?>"
                    >
                    <div class="ana-haber-baslik-container">
                        <a href="<?= e($assetBase) ?>pages/etkinlik_detay.php?id=<?= (int) ($ilkHaber['id'] ?? 0) ?>"
                           id="ana-haber-link"
                           class="ana-haber-baslik-link">
                            <h3 id="ana-haber-baslik" class="ana-haber-baslik">
                                <?= e($ilkHaber['baslik'] ?? 'Haberler & Etkinlikler') ?>
                            </h3>
                        </a>
                    </div>
                </div>

                <div id="gallery-container" class="gallery-container">
                    <div class="gallery-viewport">
                        <button type="button" id="gallery-prev-btn" class="gallery-nav prev" aria-label="Önceki">
                            <?= icon('chevron-left') ?>
                        </button>
                        <div class="gallery-wrapper">
                            <div id="gallery-track" class="gallery-track">
                                <?php foreach ($haberler as $index => $haber): ?>
                                <button type="button"
                                        class="gallery-thumb<?= $index === 0 ? ' is-active' : '' ?>"
                                        data-index="<?= (int) $index ?>"
                                        aria-label="<?= e($haber['baslik']) ?>">
                                    <img src="<?= e($haber['resim']) ?>" alt="">
                                </button>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <button type="button" id="gallery-next-btn" class="gallery-nav next" aria-label="Sonraki">
                            <?= icon('chevron-right') ?>
                        </button>
                    </div>
                    <div id="gallery-dots" class="gallery-dots"></div>
                </div>
            </section>

            <aside class="home-card duyurular-card" aria-labelledby="duyurular-title">
                <header class="home-card-header">
                    <span class="icon" aria-hidden="true"><?= icon('bell') ?></span>
                    <h2 id="duyurular-title" class="home-card-title">Duyurular</h2>
                </header>
                <hr class="duyurular-divider">
                <div id="duyurular-listesi" class="duyurular-list">
                    <?php if ($duyuruIlkSayfa === []): ?>
                    <p class="home-empty">Henüz duyuru bulunmamaktadır.</p>
                    <?php else: ?>
                        <?php foreach ($duyuruIlkSayfa as $duyuru): ?>
                        <a href="<?= e($assetBase) ?>pages/duyuru_detay.php?tip=anasayfa&id=<?= (int) $duyuru['id'] ?>" class="duyuru-item">
                            <img src="<?= e($duyuru['resim']) ?>" alt="" class="duyuru-thumb" width="64" height="64">
                            <div class="duyuru-content">
                                <h4><?= e($duyuru['baslik']) ?></h4>
                                <p><?= e($duyuru['aciklama']) ?></p>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div id="pagination-controls" class="pagination-controls">
                    <button type="button" id="prev-page" class="pagination-arrow" aria-label="Önceki sayfa" disabled>
                        <?= icon('chevron-left') ?>
                    </button>
                    <span id="sayfa-bilgisi" class="sayfa-bilgisi">Sayfa 1 / <?= $duyuruToplamSayfa ?></span>
                    <button type="button" id="next-page" class="pagination-arrow" aria-label="Sonraki sayfa"<?= $duyuruToplamSayfa <= 1 ? ' disabled' : '' ?>>
                        <?= icon('chevron-right') ?>
                    </button>
                </div>
            </aside>
        </div>

        <section class="home-section home-card" aria-labelledby="birthday-title">
            <header class="birthday-header">
                <span class="birthday-header-icon" aria-hidden="true"><?= icon('cake') ?></span>
                <div>
                    <h2 id="birthday-title">Mutlu Yıllar!</h2>
                    <p><?= e($bugunTarih) ?></p>
                </div>
            </header>

            <?php if ($dogumGunu !== []): ?>
            <div class="birthday-grid">
                <?php foreach ($dogumGunu as $personel): ?>
                <article class="birthday-card">
                    <img src="<?= e($personel['fotoUrl']) ?>"
                         alt="<?= e($personel['ad'] . ' ' . $personel['soyad']) ?>"
                         width="80" height="80">
                    <h3><?= e($personel['ad'] . ' ' . $personel['soyad']) ?></h3>
                </article>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <p class="home-empty">Bugün doğum günü olan personel bulunmamaktadır.</p>
            <?php endif; ?>
        </section>

        <section class="home-section home-card" aria-labelledby="otomasyon-title">
            <header class="otomasyon-header">
                <div class="otomasyon-header-inner">
                    <h2 id="otomasyon-title">Kurum İçi Otomasyon Sistemleri</h2>
                </div>
            </header>

            <div class="otomasyon-grid">
                <?php foreach ($otomasyonLinkleri as $link): ?>
                <?php $logo = otomasyonLogoUrl((string) $link['baslik'], (string) ($link['logo_url'] ?? ''), $assetBase); ?>
                <article class="otomasyon-item">
                    <div class="otomasyon-logo">
                        <?php if ($logo !== ''): ?>
                        <img src="<?= e($logo) ?>" alt="<?= e((string) $link['baslik']) ?>" width="72" height="72">
                        <?php else: ?>
                        <span class="otomasyon-icon-fallback" aria-hidden="true"><?= icon('desktop') ?></span>
                        <?php endif; ?>
                    </div>
                    <h3 class="otomasyon-isim"><?= e((string) $link['baslik']) ?></h3>
                    <a href="<?= e((string) ($link['hedef_url'] ?? '#')) ?>"
                       class="otomasyon-btn"
                       target="_blank"
                       rel="noopener noreferrer">
                        <?= icon('external-link') ?>
                        Sisteme Git
                    </a>
                </article>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
</main>

<?php require __DIR__ . '/../includes/footer.php'; ?>

<script>
    window.assetBase = <?= json_encode($assetBase, JSON_UNESCAPED_UNICODE) ?>;
    window.veritabanindanGelenHaberler = <?= jsonData($haberler) ?>;
    window.veritabanindanGelenDuyurular = <?= jsonData($duyurular) ?>;
</script>
<script src="<?= e($assetBase) ?>assets/js/ana_sayfa.js" defer></script>
<script src="<?= e($assetBase) ?>assets/js/navbar.js" defer></script>
</body>
</html>
=======
include "baglan.php";
$haberler = array_map(function ($h) {
  $h["resim"] = imgUrl($h["resim"] ?? "");
  return $h;
}, dbFetchAll($db, "SELECT * FROM etkinlikler ORDER BY tarih DESC, id DESC"));
$duyurular = array_map(function ($d) {
  $d["resim"] = imgUrl($d["resim"] ?? "");
  return $d;
}, mapAnasayfaDuyurular($db, dbFetchAnasayfaDuyurular($db)));
$personeller = mapPersonelJs(dbFetchAll($db, "SELECT * FROM personeller ORDER BY ad"));
// Anasayfa "Kurum İçi Otomasyon Sistemleri" linkleri artık ayrı tabloda tutulur.
// Geriye dönük uyumluluk: tablo yoksa eski kaynaktan okumaya devam et.
$otomasyonLinkleri = dbHasAnyTable($db, ["anasayfa_linkler"])
  ? dbFetchAll($db, "SELECT * FROM anasayfa_linkler ORDER BY id")
  : dbFetchAll($db, "SELECT * FROM yardimci_linkler WHERE kategori = ? ORDER BY id", ["kurum-ici"]);
$ilkHaber = $haberler[0] ?? null;
$sql_dogum =
  "SELECT * FROM personeller WHERE MONTH(dogum_tarihi) = MONTH(NOW()) AND DAY(dogum_tarihi) = DAY(NOW()) ORDER BY ad";
$anasayfaDogumKayitlari = mapPersonelJs(dbFetchAll($db, $sql_dogum));

// 🇹🇷 Ekrandaki tarihi dinamik olarak Türkçe basmak için dizi kurgusu
$aylar = [
  "",
  "Ocak",
  "Şubat",
  "Mart",
  "Nisan",
  "Mayıs",
  "Haziran",
  "Temmuz",
  "Ağustos",
  "Eylül",
  "Ekim",
  "Kasım",
  "Aralık",
];
$gunler = ["Pazar", "Pazartesi", "Salı", "Çarşamba", "Perşembe", "Cuma", "Cumartesi"];

$anasayfaBugunTarih =
  date("d") . " " . $aylar[(int) date("m")] . " " . date("Y") . " " . $gunler[date("w")];
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
<?php
$pageCss = "ana_sayfa.style.css";
include "includes/site-styles.php";
?>
  </head>
  <body>
    <?php include "includes/header-nav.php"; ?>
    <div class="content-area">
      <div class="container bg-light py-4 py-sm-5">
        <div class="container-fluid">
          <div class="row g-4 g-lg-5 justify-content-center align-items-stretch">
            <div class="col-12 col-lg-8">
              <div class="card shadow-lg border-0 rounded-4 p-3 p-sm-4 h-100">
                <!-- Haberler Başlığı -->
                <div class="d-flex align-items-center mb-3" style="width: 100%; max-width: 1600px">
                  <div class="title-v1">
                    <h2 class="title-v2"><i class="<?= portalSiteIconClass($db, "anasayfa_haberler", "fas fa-bullhorn") ?>"></i> Haberler & Etkinlikler</h2>
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
                    <a href="etkinlikd.php?id=<?= (int) ($ilkHaber["id"] ??
                      1) ?>" id="ana-haber-link" class="ana-haber-baslik-link">
                      <h3 id="ana-haber-baslik" class="ana-haber-baslik">
                        <?= htmlspecialchars($ilkHaber["baslik"] ?? "Haberler & Etkinlikler") ?>
                      </h3>
                    </a>
                  </div>
                </div>

                <!-- Galeri Container -->
                <div id="gallery-container" class="mb-4">
                  <button id="gallery-prev-btn" class="gallery-nav-arrow prev" title="Önceki">
                    <i class="<?= portalSiteIconClass($db, "onceki", "fas fa-chevron-left") ?>"></i>
                  </button>
                  <button id="gallery-next-btn" class="gallery-nav-arrow next" title="Sonraki">
                    <i class="<?= portalSiteIconClass($db, "sonraki", "fas fa-chevron-right") ?>"></i>
                  </button>
                  <div class="gallery-wrapper">
                    <div id="gallery-track" class="d-flex gap-2"></div>
                  </div>
                  <div id="gallery-dots" class="d-flex justify-content-center gap-2 mt-3"></div>
                </div>
              </div>
            </div>

            <div class="col-12 col-lg-4 d-flex">
              <div class="card shadow-lg border-0 rounded-4 p-3 p-sm-4 w-100 duyurular-card">
                <div class="duyurular-header">
                  <h2 class="duyurular-baslik"><i class="<?= portalSiteIconClass($db, "duyuru_zili", "fas fa-bell") ?> me-2"></i>Duyurular</h2>
                </div>
                <hr class="duyurular-divider" />
                <div id="duyurular-listesi" class="duyurular-govde"></div>

                <div id="pagination-controls" class="pagination-controls">
                  <button id="prev-page" class="pagination-arrow" title="Önceki Sayfa">
                    <i class="<?= portalSiteIconClass($db, "onceki", "fas fa-chevron-left") ?>"></i>
                  </button>
                  <span id="sayfa-bilgisi" class="sayfa-bilgisi">Sayfa 1 / 1</span>
                  <button id="next-page" class="pagination-arrow" title="Sonraki Sayfa">
                    <i class="<?= portalSiteIconClass($db, "sonraki", "fas fa-chevron-right") ?>"></i>
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
              <i class="<?= portalSiteIconClass($db, "dogum_sayfa", "fa-solid fa-cake-candles") ?>"></i>
            </div>
            <div class="header-text-wrapper">
              <h2 class="header-title-main">Mutlu Yıllar !</h2>
              <!-- Tarih artık veritabanı/sunucu saatiyle dinamik geliyor kanka -->
              <p class="header-subtitle"><?php echo $anasayfaBugunTarih; ?></p>
            </div>
          </div>
          
          <!-- Karışıklık olmasın diye ID'leri anasayfaya özel güncelledik -->
          <div id="personelListesiAnasayfa" class="row row-cols-1 row-cols-md-3 row-cols-lg-6 g-4"></div>

          <div id="bosMesajAnasayfa" class="alert alert-secondary text-center mt-4 d-none">
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
  $logo = otomasyonLogoUrl($link["baslik"], $link["logo_url"] ?? ""); ?>
                  <div class="otomasyon-item">
                    <div class="otomasyon-logo">
                      <?php if ($logo): ?>
                      <img src="<?= htmlspecialchars($logo) ?>" alt="<?= htmlspecialchars(
  $link["baslik"],
) ?>" class="otomasyon-icon" />
                      <?php else: ?>
                      <div class="otomasyon-icon-fallback" aria-hidden="true"><i class="<?= portalSiteIconClass($db, "otomasyon_sistem", "fas fa-desktop") ?>"></i></div>
                      <?php endif; ?>
                    </div>
                    <h3 class="otomasyon-isim"><?= htmlspecialchars($link["baslik"]) ?></h3>
                    <a href="<?= htmlspecialchars(
                      $link["hedef_url"] ?? "#",
                    ) ?>" target="_blank" rel="noopener" class="otomasyon-btn">
                      <i class="<?= portalSiteIconClass($db, "harici_baglanti", "fas fa-external-link-alt") ?> me-2"></i>Sisteme Git
                    </a>
                  </div>
<?php
endforeach; ?>
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
      <script>
  // PHP'deki veriyi JavaScript'e aktarıyoruz
  const anasayfaPersonelleri = <?php echo json_encode(
    $anasayfaDogumKayitlari,
    JSON_UNESCAPED_UNICODE,
  ); ?>;
  
  document.addEventListener("DOMContentLoaded", function () {
    const listeElementi = document.getElementById("personelListesiAnasayfa");
    const bosMesajElementi = document.getElementById("bosMesajAnasayfa");

    if (listeElementi && anasayfaPersonelleri.length > 0) {
      anasayfaPersonelleri.forEach((personel) => {
        // İstediğin row-cols-lg-6 grid yapısına tam oturan doğum günü kart tasarımı
       const cardHtml = `
  <div class="col">
    <div class="birthday-card text-center border-0 shadow-sm p-3 rounded-4 h-100 bg-white d-flex flex-column align-items-center justify-content-center" style="transition: transform 0.2s; min-height: 160px;">
      <div class="mb-2 d-flex justify-content-center align-items-center" style="width: 80px; height: 80px;">
        <img src="${personel.fotoUrl}" class="rounded-circle img-fluid" alt="${personel.ad} ${personel.soyad}" style="width: 80px; height: 80px; object-fit: cover; border: 3px solid #6368a3;">
      </div>
      <h6 class="card-title mb-0 fw-bold text-dark text-center w-100 mt-1" style="font-size: 0.9rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
        ${personel.ad} ${personel.soyad}
      </h6>
    </div>
  </div>
`;
        listeElementi.innerHTML += cardHtml;
      });
    } else if (bosMesajElementi) {
      bosMesajElementi.classList.remove("d-none");
    }
  });
</script>
  </body>
</html>
>>>>>>> da0ab1ce9c2e683fa29c9cbbff849780f358e71f
