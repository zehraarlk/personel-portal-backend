<?php
<<<<<<< HEAD
declare(strict_types=1);

require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/icons.php';

$pageTitle = 'Anketler';
$pageCss = 'anketler.css';
$showBreadcrumb = true;

$kayitlar = [];
$toplamKayit = 0;
$dbError = '';
$katilimBasarili = '';

if (!empty($_SESSION['anket_katilim_ok'])) {
    $katilimBasarili = (string) $_SESSION['anket_katilim_ok'];
    unset($_SESSION['anket_katilim_ok']);
}

try {
    $data = loadAnketlerListData($assetBase);
    $kayitlar = $data['kayitlar'];
    $toplamKayit = $data['toplam'];
} catch (Throwable $e) {
    $dbError = $e->getMessage();
    error_log('Anketler veritabani hatasi: ' . $dbError);
}

require __DIR__ . '/../includes/site-head.php';
require __DIR__ . '/../includes/header-nav.php';
require __DIR__ . '/../includes/breadcrumb.php';
?>

<main class="content-area anketler-page">
    <div class="site-container">
        <?php if ($dbError !== ''): ?>
        <p class="home-db-error">Veritabanı bağlantısı kurulamadı. phpMyAdmin'de <strong>personel_db</strong> veritabanının <code>db/personel_db.sql</code> dosyasından import edildiğinden emin olun.</p>
        <?php endif; ?>

        <?php if ($katilimBasarili !== ''): ?>
        <p class="ak-list-success" role="status">
            “<?= e($katilimBasarili) ?>” anketine katılımınız kaydedildi.
        </p>
        <?php endif; ?>

        <header class="ak-page-header">
            <div class="ak-page-header-text">
                <h1>Anketler</h1>
                <p>Kurumsal anketlere katılabilir, ilerlemeyi takip edebilir ve favorilerinizi yönetebilirsiniz.</p>
            </div>
        </header>

        <section class="ak-controls" aria-label="Arama ve sıralama">
            <div class="ak-search-box">
                <label class="visually-hidden" for="searchInput">Anket ara</label>
                <input type="search"
                       id="searchInput"
                       class="ak-search-input"
                       placeholder="Anket ara..."
                       autocomplete="off">
                <button type="button" class="ak-search-btn" id="searchBtn" aria-label="Ara">
                    <span class="icon" aria-hidden="true"><?= icon('search') ?></span>
                </button>
            </div>

            <label class="ak-sort-label">
                <span class="visually-hidden">Sıralama</span>
                <select class="ak-sort-select" id="sortSelect">
                    <option value="newest">En Yeni</option>
                    <option value="oldest">En Eski</option>
                    <option value="popular">Popülerlik</option>
                </select>
            </label>
        </section>

        <nav class="ak-filter-tabs" aria-label="Anket filtreleri">
            <button type="button" class="ak-filter-tab is-active" data-filter="all">
                <span class="icon" aria-hidden="true"><?= icon('poll') ?></span>
                Tümü
            </button>
            <button type="button" class="ak-filter-tab" data-filter="favorites">
                <span class="icon" aria-hidden="true"><?= icon('star') ?></span>
                Favoriler
            </button>
            <button type="button" class="ak-filter-tab" data-filter="active">
                <span class="icon" aria-hidden="true"><?= icon('play') ?></span>
                Aktif Anketler
            </button>
            <button type="button" class="ak-filter-tab" data-filter="pending">
                <span class="icon" aria-hidden="true"><?= icon('clock') ?></span>
                Beklemede
            </button>
            <button type="button" class="ak-filter-tab" data-filter="completed">
                <span class="icon" aria-hidden="true"><?= icon('check') ?></span>
                Tamamlanan
            </button>
        </nav>

        <section class="ak-results" aria-label="Sonuçlar">
            <p class="ak-results-count" id="resultsCount">
                <strong><?= (int) $toplamKayit ?></strong> sonuç bulundu
            </p>

            <div id="surveyGrid" class="ak-grid" aria-live="polite"></div>

            <div id="emptyState" class="ak-empty" hidden>
                <span class="icon" aria-hidden="true"><?= icon('search') ?></span>
                <h2>Sonuç Bulunamadı</h2>
                <p id="emptyStateText">Aradığınız kriterlere uygun anket bulunamadı.</p>
            </div>
        </section>
    </div>
</main>

<div class="ak-toast-host" id="toastHost" aria-live="polite" aria-atomic="true"></div>

<?php require __DIR__ . '/../includes/footer.php'; ?>

<script>
    window.anketData = <?= jsonData($kayitlar) ?>;
    window.anketConfig = <?= json_encode([
        'favoriUrl' => $assetBase . 'pages/anket_favori.php',
        'csrfToken' => csrfToken(),
    ], JSON_UNESCAPED_UNICODE) ?>;
</script>
<script src="<?= e($assetBase) ?>assets/js/anketler.js" defer></script>
<script src="<?= e($assetBase) ?>assets/js/navbar.js" defer></script>
</body>
</html>
=======
include "baglan.php";
$kayitlar = dbFetchAnketler($db);

$badgeMap = [
  "active" => ["Aktif", "status-active", "anket_durum_aktif", "fas fa-play-circle"],
  "pending" => ["Beklemede", "status-pending", "anket_durum_beklemede", "fas fa-clock"],
  "completed" => [
    "Tamamlandı",
    "status-completed",
    "anket_durum_tamamlandi",
    "fas fa-check-circle",
  ],
  "expired" => [
    "Süresi Doldu",
    "status-expired",
    "anket_durum_suresi_doldu",
    "fas fa-times-circle",
  ],
];
// Giriş yapmış personelin katılım sağladığı anket ID listesini tek bir query ile çekelim
$katilinanAnketler = [];
if (!empty($_SESSION["personel_id"])) {
    $katilimlar = dbFetchAll($db, "SELECT DISTINCT anket_id FROM anket_cevaplari WHERE personel_id = ?", [(int)$_SESSION["personel_id"]]);
    $katilinanAnketler = array_column($katilimlar, 'anket_id');
}

function renderAnketCard(array $k, array $badgeMap): void
{
  global $db, $katilinanAnketler;

  [$durum, $badgeClass, $badgeIconKey, $badgeIconDefault] =
    $badgeMap[$k["kategori"]] ?? [
      "Aktif",
      "status-active",
      "anket_durum_aktif",
      "fas fa-play-circle",
    ];
  $katilim = (int) ($k["katilim_sayisi"] ?? 0);
  $hedef = max(1, (int) ($k["hedef_katilim"] ?? 1));
  $yuzde = min(100, round(($katilim / $hedef) * 100));
  $favori = (int) ($k["favori"] ?? 0) === 1;
  $id = (int) $k["id"];
  ?>
        <div class="col-md-6 col-lg-4 survey-item" data-id="<?= $id ?>" data-category="<?= htmlspecialchars($k["kategori"]) ?>" data-favorite="<?= $favori ? "1" : "0" ?>">
          <div class="survey-card h-100 d-flex flex-column">
            <span class="status-badge <?= $badgeClass ?>">
              <i class="<?= portalSiteIconClass(
                $db,
                $badgeIconKey,
                $badgeIconDefault,
              ) ?> me-1"></i><?= $durum ?>
            </span>
            <img src="<?= htmlspecialchars(
              imgUrl($k["resim_url"] ?? ""),
            ) ?>" class="survey-img" alt="<?= htmlspecialchars($k["baslik"]) ?>" />
            <div class="p-4 d-flex flex-column justify-content-between flex-grow-1">
              <div>
                <h5 class="survey-title"><?= htmlspecialchars($k["baslik"]) ?></h5>
                <p class="survey-desc"><?= htmlspecialchars($k["aciklama"] ?? "") ?></p>
                <p class="survey-date"><i class="<?= portalSiteIconClass(
                  $db,
                  "anket_tarih",
                  "fas fa-calendar",
                ) ?> me-1"></i><?= date(
                  "d.m.Y",
                  strtotime($k["baslangic_tarihi"]),
                ) ?> - <?= date("d.m.Y", strtotime($k["bitis_tarihi"])) ?></p>
                <div class="progress-container">
                  <div class="d-flex justify-content-between">
                    <span class="participation-rate">Katılım: <?= $katilim ?>/<?= $hedef ?> kişi</span>
                    <span class="participation-rate">%<?= $yuzde ?></span>
                  </div>
                  <div class="progress mt-2" style="height: 6px">
                    <div class="progress-bar bg-success" role="progressbar" style="width: <?= $yuzde ?>%"></div>
                  </div>
                </div>
              </div>
              <div class="mt-3 d-grid gap-2">
  <?php if (empty($_SESSION["personel_id"])): ?>
      <a href="login.php" class="btn btn-secondary w-100"><i class="<?= portalSiteIconClass(
        $db,
        "anket_giris",
        "fas fa-sign-in-alt",
      ) ?> me-2"></i>Katılmak İçin Giriş Yap</a>
  <?php else: 
      if (in_array($id, $katilinanAnketler, true)): ?>
          <!-- Personel katıldıysa yine aynı sayfaya GÖRÜNTÜLEMEK için gönderiyoruz -->
          <a href="anket_katil.php?id=<?= $id ?>" class="btn btn-info text-white w-100"><i class="<?= portalSiteIconClass(
            $db,
            "goruntulenme",
            "fas fa-eye",
          ) ?> me-2"></i>Cevaplarınızı Görüntüleyin</a>
      <?php else: ?>
          <a href="anket_katil.php?id=<?= $id ?>" class="btn survey-btn w-100"><i class="<?= portalSiteIconClass(
            $db,
            "anket_duzenle",
            "fas fa-edit",
          ) ?> me-2"></i>Ankete Katıl</a>
      <?php endif; ?>
  <?php endif; ?>
  
  <button type="button" class="btn favorite-toggle-btn w-100<?= $favori ? " active" : "" ?>" data-id="<?= $id ?>">
    <i class="<?= portalSiteIconClass(
      $db,
      $favori ? "anket_favori_dolu" : "anket_favori_bos",
      $favori ? "fas fa-star" : "far fa-star",
    ) ?> me-2"></i>
    <?= $favori ? "Favorilerden Çıkar" : "Favorilere Ekle" ?>
  </button>
</div>
            </div>
          </div>
        </div>
<?php
}
?>
<!doctype html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Anketler - Gebze Belediyesi</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
      rel="stylesheet"
    />
<?php
$pageCss = "anketler.style.css";
include "includes/site-styles.php";
?>
  </head>
  <body>
    <?php include "includes/header-nav.php"; ?>
    <?php
    $pageTitle = "Anketler";
    include "includes/breadcrumb.php";
    ?>
    <main class="main-container container py-5">
      <div class="surveys-header">
        <h1 class="surveys-title">Anketler</h1>
        <div class="surveys-controls">
          <div class="search-box">
            <input type="text" placeholder="Anket ara..." id="searchInput" />
            <i class="<?= portalSiteIconClass($db, "arama", "fas fa-search") ?>"></i>
          </div>
          <select class="sort-select">
            <option value="Tarihe Göre Sırala">Tarihe Göre Sırala</option>
            <option value="En Yeni">En Yeni</option>
            <option value="En Eski">En Eski</option>
            <option value="Popülerlik">Popülerlik</option>
          </select>
        </div>
      </div>

      <div class="filter-tabs">
        <button class="filter-tab active" data-filter="all">
          <i class="<?= portalSiteIconClass($db, "anket_liste", "fas fa-list") ?> me-1"></i>Tümü
        </button>
        <button class="filter-tab" data-filter="favorites">
          <i class="<?= portalSiteIconClass($db, "anket_favori_dolu", "fas fa-star") ?> me-1"></i>Favoriler
        </button>
        <button class="filter-tab" data-filter="active">
          <i class="<?= portalSiteIconClass($db, "anket_durum_aktif", "fas fa-play-circle") ?> me-1"></i>Aktif Anketler
        </button>
        <button class="filter-tab" data-filter="pending">
          <i class="<?= portalSiteIconClass($db, "anket_durum_beklemede", "fas fa-clock") ?> me-1"></i>Beklemede
        </button>
        <button class="filter-tab" data-filter="completed">
          <i class="<?= portalSiteIconClass($db, "anket_durum_tamamlandi", "fas fa-check-circle") ?> me-1"></i>Tamamlanan
        </button>
      </div>

      <div class="row g-4" id="surveyContainer">
<?php foreach ($kayitlar as $k):
  renderAnketCard($k, $badgeMap);
endforeach; ?>
      </div>

      <div id="emptyState" class="empty-state d-none">
        <i class="<?= portalSiteIconClass($db, "arama", "fas fa-search") ?>"></i>
        <p id="emptyStateText">Aradığınız kriterlere uygun anket bulunamadı.</p>
      </div>
    </main>
    <?php include "includes/footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../JS/anketler.script.js"></script>
      <script src="../JS/navbar.js"></script>
  </body>
</html>
>>>>>>> da0ab1ce9c2e683fa29c9cbbff849780f358e71f
