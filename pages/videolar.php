<?php
/**
 * Dosya sorumluluğu: Video listeleme sayfası.
 *
 * Girdi doğrulama, yetkilendirme ve çıktı kaçışları bu dosyanın
 * mevcut güvenlik akışına uygun biçimde korunmalıdır.
 */
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
