<?php
declare(strict_types=1);

require_once __DIR__ . '/icons.php';

$footerYear = (int) date('Y');

$socialLinks = [
    ['href' => SOCIAL_FACEBOOK, 'icon' => 'facebook', 'label' => 'Facebook'],
    ['href' => SOCIAL_TWITTER, 'icon' => 'twitter', 'label' => 'X (Twitter)'],
    ['href' => SOCIAL_INSTAGRAM, 'icon' => 'instagram', 'label' => 'Instagram'],
    ['href' => SOCIAL_YOUTUBE, 'icon' => 'youtube', 'label' => 'YouTube'],
    ['href' => SOCIAL_LINKEDIN, 'icon' => 'linkedin', 'label' => 'LinkedIn'],
];
?>
<footer class="site-footer" role="contentinfo">
    <div class="site-container footer-main">
        <a href="<?= e($assetBase) ?>pages/ana_sayfa.php" class="footer-brand" aria-label="Gebze Belediyesi — Ana Sayfa">
            <img src="<?= e(logoUrl($assetBase)) ?>" alt="Gebze Belediyesi Logosu" width="240" height="52">
        </a>

        <address class="footer-contact">
            <button type="button"
                    class="footer-contact-item"
                    data-copy="<?= e(FOOTER_PHONE) ?>"
                    data-copy-success="Telefon numarası kopyalandı"
                    aria-label="Telefon numarasını kopyala: <?= e(FOOTER_PHONE) ?>">
                <span class="icon" aria-hidden="true"><?= icon('telefon') ?></span>
                <?= e(FOOTER_PHONE) ?>
            </button>
            <button type="button"
                    class="footer-contact-item"
                    data-copy="<?= e(FOOTER_EMAIL) ?>"
                    data-copy-success="E-posta adresi kopyalandı"
                    aria-label="E-posta adresini kopyala: <?= e(FOOTER_EMAIL) ?>">
                <span class="icon" aria-hidden="true"><?= icon('eposta') ?></span>
                <?= e(FOOTER_EMAIL) ?>
            </button>
        </address>

        <nav class="footer-social" aria-label="Sosyal medya hesapları">
            <?php foreach ($socialLinks as $social): ?>
            <a href="<?= e($social['href']) ?>"
               class="footer-social-link"
               target="_blank"
               rel="noopener noreferrer"
               aria-label="<?= e($social['label']) ?>">
                <?= icon($social['icon']) ?>
            </a>
            <?php endforeach; ?>
        </nav>
    </div>

    <div class="footer-bottom">
        <div class="site-container">
            <p>&copy; <?= $footerYear ?> Gebze Belediyesi - Bilgi İşlem Müdürlüğü | Tüm Hakları Saklıdır</p>
        </div>
    </div>
</footer>
