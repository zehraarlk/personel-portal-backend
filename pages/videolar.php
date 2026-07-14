<?php
<<<<<<< HEAD
declare(strict_types=1);

require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/icons.php';

$pageTitle = 'Videolar';
$pageCss = 'videolar.css';
$showBreadcrumb = true;

$vitrinBaslik = "Gebze'de Offroad Heyecanı";
$vitrinAciklama = 'Belediyemizin yürüttüğü son projeler ve önemli gelişmeler...';
$vitrinYoutubeId = 'qLqYPQgUPEc';
$vitrinThumb = youtubeThumbUrl($vitrinYoutubeId);
$videolar = [];
$dbError = '';

try {
    $videoData = loadVideolarData();
    $vitrinBaslik = $videoData['vitrinBaslik'];
    $vitrinAciklama = $videoData['vitrinAciklama'];
    $vitrinYoutubeId = $videoData['vitrinYoutubeId'];
    $vitrinThumb = $videoData['vitrinThumb'];
    $videolar = $videoData['videolar'];
} catch (Throwable $e) {
    $dbError = $e->getMessage();
    error_log('Videolar veritabani hatasi: ' . $dbError);
}

require __DIR__ . '/../includes/site-head.php';
require __DIR__ . '/../includes/header-nav.php';
require __DIR__ . '/../includes/breadcrumb.php';
?>

<main class="content-area videos-page">
    <div class="site-container">
        <?php if ($dbError !== ''): ?>
        <p class="home-db-error">Veritabanı bağlantısı kurulamadı. phpMyAdmin'de <strong>personel_db</strong> veritabanının <code>db/personel_db.sql</code> dosyasından import edildiğinden emin olun.</p>
        <?php endif; ?>

        <section class="featured-video-section" aria-labelledby="featured-video-title">
            <div class="featured-video">
                <button type="button"
                        class="featured-video-thumb"
                        data-youtube-id="<?= e($vitrinYoutubeId) ?>"
                        aria-label="Haftanın videosunu izle">
                    <img src="<?= e($vitrinThumb) ?>" alt="<?= e($vitrinBaslik) ?>">
                    <span class="play-icon-overlay" aria-hidden="true">
                        <span class="icon"><?= icon('play') ?></span>
                    </span>
                </button>

                <div class="featured-video-content">
                    <h1 id="featured-video-title">Haftanın Videosu: <?= e($vitrinBaslik) ?></h1>
                    <p class="featured-video-desc"><?= e($vitrinAciklama) ?></p>
                    <div class="featured-video-actions">
                        <button type="button"
                                class="btn-primary"
                                data-youtube-id="<?= e($vitrinYoutubeId) ?>">
                            <span class="icon" aria-hidden="true"><?= icon('play') ?></span>
                            Videoyu İzle
                        </button>
                        <button type="button" class="btn-secondary" id="show-all-videos-btn">
                            Tümünü Gör
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <section class="video-list-section" id="video-list-section" aria-label="Tüm videolar">
            <div id="video-grid-baslangic" class="video-toolbar" aria-label="Video filtreleri">
                <div id="video-filters" class="video-filters" role="tablist" aria-label="Kategori filtreleri">
                    <button type="button" class="filter-pill is-active" data-category="all" role="tab" aria-selected="true">Tümü</button>
                    <button type="button" class="filter-pill" data-category="egitimler" role="tab" aria-selected="false">Eğitimler</button>
                    <button type="button" class="filter-pill" data-category="etkinlikler" role="tab" aria-selected="false">Etkinlikler</button>
                    <button type="button" class="filter-pill" data-category="duyurular" role="tab" aria-selected="false">Duyurular</button>
                </div>

                <label class="video-search" for="video-search-input">
                    <span class="visually-hidden">Video ara</span>
                    <input type="search"
                           id="video-search-input"
                           placeholder="Video ara..."
                           autocomplete="off">
                    <span class="video-search-icon" aria-hidden="true"><?= icon('search') ?></span>
                </label>
            </div>

            <section id="video-grid" class="video-grid" aria-live="polite"></section>

            <div id="no-results-message" class="video-empty" hidden>
                <span class="icon" aria-hidden="true"><?= icon('search') ?></span>
                <h3>Aradığınız kritere uygun video bulunamadı.</h3>
            </div>

            <nav id="video-pagination" class="video-pagination" aria-label="Video sayfaları" hidden></nav>
        </section>
    </div>
</main>

<dialog id="video-modal" class="video-modal" aria-label="Video oynatıcı">
    <div class="video-modal-inner">
        <button type="button" id="video-modal-close" class="video-modal-close" aria-label="Videoyu kapat">
            <?= icon('close') ?>
        </button>
        <div class="video-modal-ratio">
            <iframe id="youtube-iframe"
                    src=""
                    title="YouTube video oynatıcı"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
        </div>
    </div>
</dialog>

<?php require __DIR__ . '/../includes/footer.php'; ?>

<script>
    window.videoPlayIcon = <?= json_encode(icon('play'), JSON_UNESCAPED_UNICODE) ?>;
    window.veritabanindanGelenVideolar = <?= jsonData($videolar) ?>;
</script>
<script src="<?= e($assetBase) ?>assets/js/videolar.js" defer></script>
<script src="<?= e($assetBase) ?>assets/js/navbar.js" defer></script>
</body>
</html>
=======
include "baglan.php";
$vitrinVideo = dbFetchVitrinVideo($db);
$tumVideolar = dbVideolarAttachKategoriSlug(
  $db,
  dbFetchAll($db, dbVideolarListSql($db)),
);

if ($vitrinVideo) {
  $vitrinId = (int) $vitrinVideo["id"];
  $tumVideolar = array_values(
    array_filter(
      $tumVideolar,
      static fn(array $video): bool => (int) $video["id"] !== $vitrinId,
    ),
  );
}

$vitrinBaslik = "Gebze'de Offroad Heyecanı";
$vitrinAciklama = "Belediyemizin yürüttüğü son projeler ve önemli gelişmeler...";
$vitrinYoutubeId = "qLqYPQgUPEc";
if ($vitrinVideo) {
  $vitrinBaslik = $vitrinVideo["baslik"] ?? $vitrinBaslik;
  $vitrinAciklama = $vitrinVideo["aciklama"] ?? $vitrinAciklama;
  $vitrinYoutubeId = $vitrinVideo["youtube_id"] ?? $vitrinYoutubeId;
}
?>
<!doctype html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Videolar Sayfası - Gebze Belediyesi</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
<?php
$pageCss = "videolar.style.css";
include "includes/site-styles.php";
?>
  </head>
  <body>
    <?php include "includes/header-nav.php"; ?>
    <?php
    $pageTitle = "Videolar";
    include "includes/breadcrumb.php";
    ?>
<main class="container py-5">
      <section class="row align-items-center mb-5 gx-5 featured-video-section">
  <div class="col-lg-7 mb-4 mb-lg-0">
    <div
      class="featured-video-placeholder rounded-3 shadow-lg card-thumbnail"
      data-bs-toggle="modal"
      data-bs-target="#videoModal"
      data-youtube-id="<?php echo htmlspecialchars($vitrinYoutubeId, ENT_QUOTES, "UTF-8"); ?>"
    >
      <img
        src="https://img.youtube.com/vi/<?php echo htmlspecialchars(
          $vitrinYoutubeId,
          ENT_QUOTES,
          "UTF-8",
        ); ?>/maxresdefault.jpg"
        alt="Haftanın Videosu"
        class="img-fluid rounded-3 w-100 h-100"
        style="object-fit: cover"
      />
      <div class="play-icon-overlay"><i class="<?= portalSiteIconClass($db, "video_oynat", "fas fa-play") ?>"></i></div>
    </div>
  </div>
  
  <div class="col-lg-5">
    <h1 class="display-5 fw-bold text-body-emphasis lh-1 mb-3">
      Haftanın Videosu: <?php echo htmlspecialchars($vitrinBaslik, ENT_QUOTES, "UTF-8"); ?>
    </h1>
    <p class="lead">
      <?php echo htmlspecialchars($vitrinAciklama, ENT_QUOTES, "UTF-8"); ?>
    </p>
    
    <div class="d-grid gap-2 d-md-flex justify-content-md-start">
      <button
        type="button"
        class="btn btn-primary btn-lg px-4 me-md-2 fw-bold"
        data-bs-toggle="modal"
        data-bs-target="#videoModal"
        data-youtube-id="<?php echo htmlspecialchars($vitrinYoutubeId, ENT_QUOTES, "UTF-8"); ?>"
      >
        Videoyu İzle
      </button>
    <a href="#video-grid-baslangic" class="btn btn-outline-secondary btn-lg px-4">Tümünü Gör</a>
    </div>
  </div>
</section>
      <hr class="my-5" />

      <section id="video-grid-baslangic" class="d-flex flex-column flex-md-row align-items-center mb-5">
        <ul class="nav nav-pills mb-3 mb-md-0">
          <li class="nav-item">
            <a href="#" class="nav-link active" data-category="all">Tümü</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link" data-category="egitimler">Eğitimler</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link" data-category="etkinlikler">Etkinlikler</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link" data-category="duyurular">Duyurular</a>
          </li>
        </ul>
        <div class="ms-md-auto col-12 col-md-4 col-lg-3">
          <div class="input-group">
            <input
              type="text"
              class="form-control"
              id="video-search-input"
              placeholder="Video ara..."
              aria-label="Video ara"
            />
            <span class="input-group-text"><i class="<?= portalSiteIconClass($db, "arama", "fas fa-search") ?>"></i></span>
          </div>
        </div>
      </section>

      <section id="video-grid" class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-4"></section>

      <div id="no-results-message" class="text-center py-5" style="display: none">
        <i class="<?= portalSiteIconClass($db, "arama", "fas fa-search") ?> fa-3x text-muted mb-3"></i>
        <h3 class="text-muted">Aradığınız kritere uygun video bulunamadı.</h3>
      </div>

      <nav aria-label="Video Sayfaları" class="d-flex justify-content-center mt-5">
        <ul class="pagination custom-pagination"></ul>
      </nav>
    </main>

    <div
      class="modal fade"
      id="videoModal"
      tabindex="-1"
      aria-labelledby="videoModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
          <div class="modal-body p-0">
            <div class="ratio ratio-16x9">
              <iframe
                id="youtube-iframe"
                src=""
                title="YouTube video player"
                frameborder="0"
                allow="
                  accelerometer;
                  autoplay;
                  clipboard-write;
                  encrypted-media;
                  gyroscope;
                  picture-in-picture;
                "
                allowfullscreen
              ></iframe>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include "includes/footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const veritabanindanGelenVideolar = <?php echo json_encode(
          $tumVideolar,
          JSON_UNESCAPED_UNICODE,
        ); ?>;
    </script>
    <script src="../JS/videolar.script.js"></script>
    <script src="../JS/navbar.js"></script>
  </body>
</html>
>>>>>>> da0ab1ce9c2e683fa29c9cbbff849780f358e71f
