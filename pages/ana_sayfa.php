<?php
/**
 * Dosya sorumluluğu: Portal ana sayfası.
 *
 * Girdi doğrulama, yetkilendirme ve çıktı kaçışları bu dosyanın
 * mevcut güvenlik akışına uygun biçimde korunmalıdır.
 */
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
