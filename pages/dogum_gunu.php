<?php
/**
 * Dosya sorumluluğu: Doğum günü bilgi sayfası.
 *
 * Girdi doğrulama, yetkilendirme ve çıktı kaçışları bu dosyanın
 * mevcut güvenlik akışına uygun biçimde korunmalıdır.
 */
declare(strict_types=1);

require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/icons.php';

$pageTitle = 'Doğum Günü';
$pageCss = 'dogum_gunu.css';
$showBreadcrumb = true;

$kayitlar = [];
$toplamKayit = 0;
$bugunTarih = getTurkishDateLabel();
$dbError = '';

try {
    $data = loadDogumGunuData($assetBase);
    $kayitlar = $data['kayitlar'];
    $toplamKayit = $data['toplam'];
    $bugunTarih = $data['bugunTarih'];
} catch (Throwable $e) {
    $dbError = $e->getMessage();
    error_log('Dogum gunu veritabani hatasi: ' . $dbError);
}

require __DIR__ . '/../includes/site-head.php';
require __DIR__ . '/../includes/header-nav.php';
require __DIR__ . '/../includes/breadcrumb.php';
?>

<main class="content-area dogum-gunu-page">
    <div class="site-container">
        <?php if ($dbError !== ''): ?>
        <p class="home-db-error">Veritabanı bağlantısı kurulamadı. phpMyAdmin'de <strong>personel_db</strong> veritabanının <code>db/personel_db.sql</code> dosyasından import edildiğinden emin olun.</p>
        <?php endif; ?>

        <header class="dg-page-header">
            <span class="dg-header-icon icon" aria-hidden="true"><?= icon('cake') ?></span>
            <div>
                <h1>Bugün Doğum Günü Olan Personeller</h1>
                <p><?= e($bugunTarih) ?></p>
            </div>
        </header>

        <section class="dg-results" aria-label="Doğum günü listesi">
            <p class="dg-results-count">
                <strong><?= (int) $toplamKayit ?></strong> kişi
            </p>

            <?php if ($kayitlar !== []): ?>
            <div class="dg-grid">
                <?php foreach ($kayitlar as $personel): ?>
                <article class="dg-card">
                    <img src="<?= e((string) $personel['fotoUrl']) ?>"
                         alt="<?= e((string) $personel['fullName']) ?>"
                         width="120"
                         height="120"
                         loading="lazy">
                    <h2><?= e((string) $personel['fullName']) ?></h2>
                </article>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="dg-empty">
                <span class="icon" aria-hidden="true"><?= icon('cake') ?></span>
                <h2>Kayıt Yok</h2>
                <p>Bugün doğum günü olan personel bulunmamaktadır.</p>
            </div>
            <?php endif; ?>
        </section>
    </div>
</main>

<?php require __DIR__ . '/../includes/footer.php'; ?>
<script src="<?= e($assetBase) ?>assets/js/navbar.js" defer></script>
</body>
</html>
