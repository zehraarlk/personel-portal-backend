<?php
<<<<<<< HEAD
declare(strict_types=1);

require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/icons.php';

$pageTitle = 'Vefat Bilgisi';
$pageCss = 'vefat_bilgisi.css';
$showBreadcrumb = true;

$kayitlar = [];
$toplamKayit = 0;
$dbError = '';

try {
    $data = loadVefatBilgileriData();
    $kayitlar = $data['kayitlar'];
    $toplamKayit = $data['toplam'];
} catch (Throwable $e) {
    $dbError = $e->getMessage();
    error_log('Vefat bilgisi veritabani hatasi: ' . $dbError);
}

require __DIR__ . '/../includes/site-head.php';
require __DIR__ . '/../includes/header-nav.php';
require __DIR__ . '/../includes/breadcrumb.php';
?>

<main class="content-area vefat-page">
    <div class="site-container">
        <?php if ($dbError !== ''): ?>
        <p class="home-db-error">Veritabanı bağlantısı kurulamadı. phpMyAdmin'de <strong>personel_db</strong> veritabanının <code>db/personel_db.sql</code> dosyasından import edildiğinden emin olun.</p>
        <?php endif; ?>

        <header class="vf-page-header">
            <span class="vf-header-icon icon" aria-hidden="true"><?= icon('ribbon') ?></span>
            <h1 id="vf-hero-title">Vefat Eden Bilgisi</h1>
        </header>

        <section class="vf-toolbar" aria-label="Arama">
            <div class="vf-search-box">
                <span class="vf-search-leading icon" aria-hidden="true"><?= icon('search') ?></span>
                <label class="visually-hidden" for="searchInput">Ad veya ilişki ara</label>
                <input type="search"
                       id="searchInput"
                       class="vf-search-input"
                       placeholder="Ad, yakınlık veya mesaj içeriği ara..."
                       autocomplete="off">
                <button type="button" class="vf-search-btn" id="searchBtn">
                    Ara
                </button>
            </div>
            <p class="vf-results-count" id="resultsCount">
                <strong><?= (int) $toplamKayit ?></strong> kayıt listeleniyor
            </p>
        </section>

        <section class="vf-results" aria-label="Sonuçlar">
            <div id="vefatGrid" class="vf-grid" aria-live="polite"></div>

            <div id="emptyState" class="vf-empty" hidden>
                <span class="vf-empty-icon icon" aria-hidden="true"><?= icon('ribbon') ?></span>
                <h2>Kayıt Bulunamadı</h2>
                <p>Aradığınız kriterlere uygun kayıt bulunamadı.</p>
            </div>

            <nav id="pagination" class="vf-pagination" aria-label="Sayfa navigasyonu" hidden></nav>
        </section>
    </div>
</main>

<?php require __DIR__ . '/../includes/footer.php'; ?>

<script>
    window.vefatData = <?= jsonData($kayitlar) ?>;
    window.vefatIcons = {
        ribbon: <?= json_encode(icon('vefat_bilgisi'), JSON_UNESCAPED_UNICODE) ?>,
        calendar: <?= json_encode(icon('tarih'), JSON_UNESCAPED_UNICODE) ?>
    };
</script>
<script src="<?= e($assetBase) ?>assets/js/vefat_bilgisi.js" defer></script>
<script src="<?= e($assetBase) ?>assets/js/navbar.js" defer></script>
</body>
=======
include "baglan.php";
$vefatKayitlari = dbFetchAll($db, "SELECT * FROM vefat_bilgileri ORDER BY vefat_tarihi DESC");
?>
<!doctype html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Vefat Eden Bilgisi - Gebze Belediyesi Personel Portalı</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
<?php
$pageCss = "vefat_bilgisi.style.css";
include "includes/site-styles.php";
?>
  </head>
  <body>
    <?php include "includes/header-nav.php"; ?>
    <?php
    $pageTitle = "Vefat Bilgisi";
    include "includes/breadcrumb.php";
    ?>
    <div class="main-content container">
      <div class="container">
        <div class="page-header">
          <div class="header-content">
            <i class="<?= portalSiteIconClass($db, "vefat_bilgisi", "fas fa-ribbon") ?> header-icon"></i>
            <h1>VEFAT EDEN BİLGİSİ</h1>
          </div>
        </div>

        <div class="vefat-grid" id="vefatGrid"></div>

        <div class="pagination-container">
          <nav aria-label="Vefat bilgileri sayfalama">
            <ul class="pagination">
              <li class="page-item disabled" id="prevPageItem">
                <a class="page-link" href="#" aria-label="Önceki" id="prevPage">
                  <i class="<?= portalSiteIconClass($db, "onceki", "fas fa-chevron-left") ?>"></i>
                  Önceki
                </a>
              </li>
              <li class="page-item active">
                <a class="page-link" href="#" data-page="1">1</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="#" data-page="2">2</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="#" data-page="3">3</a>
              </li>
              <li class="page-item" id="nextPageItem">
                <a class="page-link" href="#" aria-label="Sonraki" id="nextPage">
                  Sonraki
                  <i class="<?= portalSiteIconClass($db, "sonraki", "fas fa-chevron-right") ?>"></i>
                </a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
    <?php include "includes/footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    window.vefatData = <?php echo jsonData(mapVefat($vefatKayitlari)); ?>;
  </script>
    <script src="../JS/vefat_bilgisi.script.js"></script>
      <script src="../JS/navbar.js"></script>
  </body>
>>>>>>> da0ab1ce9c2e683fa29c9cbbff849780f358e71f
</html>
