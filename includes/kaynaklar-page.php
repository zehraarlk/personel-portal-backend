<?php
/**
 * Dosya sorumluluğu: Kaynak listeleme sayfalarının ortak şablonu.
 *
 * Girdi doğrulama, yetkilendirme ve çıktı kaçışları bu dosyanın
 * mevcut güvenlik akışına uygun biçimde korunmalıdır.
 */
declare(strict_types=1);

/**
 * Shared Kaynaklar list page.
 * Expected vars before include: $pageTitle, $kaynakActiveKey, $kaynakSlug,
 * $kaynakSearchPlaceholder, $kaynakEmptyText, $kaynakIntro
 */
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/icons.php';

$pageCss = 'kaynaklar.css';
$showBreadcrumb = true;
$kaynakActiveKey = $kaynakActiveKey ?? 'protocol';
$kaynakSlug = $kaynakSlug ?? 'Protokoller';
$kaynakSearchPlaceholder = $kaynakSearchPlaceholder ?? 'Ara...';
$kaynakEmptyText = $kaynakEmptyText ?? 'Henüz kayıt bulunmuyor.';
$kaynakIntro = $kaynakIntro ?? '';

$kayitlar = [];
$toplamKayit = 0;
$dbError = '';
$kaynakTabs = kaynakNavTabs($assetBase, $kaynakActiveKey);

try {
    $data = loadKaynaklarListData($assetBase, $kaynakSlug, $pageTitle);
    $kayitlar = $data['kayitlar'];
    $toplamKayit = $data['toplam'];
} catch (Throwable $e) {
    $dbError = $e->getMessage();
    error_log($pageTitle . ' veritabani hatasi: ' . $dbError);
}

require __DIR__ . '/../includes/site-head.php';
require __DIR__ . '/../includes/header-nav.php';
require __DIR__ . '/../includes/breadcrumb.php';
?>

<main class="content-area kaynaklar-page">
    <div class="site-container">
        <?php if ($dbError !== ''): ?>
        <p class="home-db-error">Veritabanı bağlantısı kurulamadı. phpMyAdmin'de <strong>personel_db</strong> veritabanının <code>db/personel_db.sql</code> dosyasından import edildiğinden emin olun.</p>
        <?php endif; ?>

        <header class="kr-page-header">
            <h1><?= e($pageTitle) ?></h1>
            <?php if ($kaynakIntro !== ''): ?>
            <p><?= e($kaynakIntro) ?></p>
            <?php endif; ?>
        </header>

        <section class="kr-controls" aria-label="Arama ve kategori">
            <div class="kr-search-box">
                <label class="visually-hidden" for="searchInput"><?= e($kaynakSearchPlaceholder) ?></label>
                <input type="search"
                       id="searchInput"
                       class="kr-search-input"
                       placeholder="<?= e($kaynakSearchPlaceholder) ?>"
                       autocomplete="off">
                <button type="button" class="kr-search-btn" id="searchBtn" aria-label="Ara">
                    <span class="icon" aria-hidden="true"><?= icon('search') ?></span>
                </button>
            </div>

            <nav class="kr-filter-tabs" aria-label="Kaynak kategorileri">
                <?php foreach ($kaynakTabs as $tab): ?>
                <a href="<?= e($tab['href']) ?>"
                   class="kr-filter-tab<?= $tab['active'] ? ' is-active' : '' ?>"
                   <?= $tab['active'] ? 'aria-current="page"' : '' ?>>
                    <?= e($tab['label']) ?>
                </a>
                <?php endforeach; ?>
            </nav>
        </section>

        <section class="kr-results" aria-label="Sonuçlar">
            <p class="kr-results-count" id="resultsCount">
                <strong><?= (int) $toplamKayit ?></strong> sonuç bulundu
            </p>

            <div id="documentsGrid" class="kr-grid" aria-live="polite"></div>

            <div id="noResults" class="kr-empty" hidden>
                <span class="icon" aria-hidden="true"><?= icon('search') ?></span>
                <h2>Sonuç Bulunamadı</h2>
                <p><?= e($kaynakEmptyText) ?></p>
            </div>
        </section>
    </div>
</main>

<?php require __DIR__ . '/../includes/footer.php'; ?>

<script>
    window.kaynakData = <?= jsonData($kayitlar) ?>;
    window.kaynakEmptyText = <?= json_encode($kaynakEmptyText, JSON_UNESCAPED_UNICODE) ?>;
    window.kaynakActiveKey = <?= json_encode($kaynakActiveKey, JSON_UNESCAPED_UNICODE) ?>;
    window.kaynakPreviewBase = <?= json_encode($assetBase . 'pages/kaynak_onizleme.php?id=', JSON_UNESCAPED_UNICODE) ?>;
    window.kaynakDownloadBase = <?= json_encode($assetBase . 'pages/kaynak_dosya.php?id=', JSON_UNESCAPED_UNICODE) ?>;
    window.kaynakIcons = <?= jsonData([
        'protokoller' => '<span class="icon" aria-hidden="true">' . icon('protokoller') . '</span>',
        'dokumanlar' => '<span class="icon" aria-hidden="true">' . icon('dokumanlar') . '</span>',
        'mevzuatlar' => '<span class="icon" aria-hidden="true">' . icon('mevzuatlar') . '</span>',
        'egitimler' => '<span class="icon" aria-hidden="true">' . icon('egitimler') . '</span>',
        'videolar' => '<span class="icon" aria-hidden="true">' . icon('videolar') . '</span>',
        'tarih' => '<span class="icon" aria-hidden="true">' . icon('tarih') . '</span>',
        'search' => '<span class="icon" aria-hidden="true">' . icon('search') . '</span>',
        'eye' => '<span class="icon" aria-hidden="true">' . icon('eye') . '</span>',
        'protocol' => '<span class="icon" aria-hidden="true">' . icon('protokoller') . '</span>',
        'document' => '<span class="icon" aria-hidden="true">' . icon('dokumanlar') . '</span>',
        'law' => '<span class="icon" aria-hidden="true">' . icon('mevzuatlar') . '</span>',
        'education' => '<span class="icon" aria-hidden="true">' . icon('egitimler') . '</span>',
        'video' => '<span class="icon" aria-hidden="true">' . icon('videolar') . '</span>',
        'calendar' => '<span class="icon" aria-hidden="true">' . icon('tarih') . '</span>',
        'documentMeta' => '<span class="icon" aria-hidden="true">' . icon('dokumanlar') . '</span>',
        'preview' => '<span class="icon" aria-hidden="true">' . icon('eye') . '</span>',
        'download' => '<span class="icon" aria-hidden="true"><i class="fas fa-download" aria-hidden="true"></i></span>',
    ]) ?>;
</script>
<script src="<?= e($assetBase) ?>assets/js/kaynaklar.js" defer></script>
<script src="<?= e($assetBase) ?>assets/js/navbar.js" defer></script>

<?php if ($kaynakActiveKey === 'training'): ?>
<style>
    .kr-training-actions {
        --kr-training-hover-color: #f58220;
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 8px;
        width: 100%;
    }

    .kaynaklar-page .kr-training-actions > a.kr-training-action-button,
    .kaynaklar-page .kr-training-actions > button.kr-training-action-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-width: 0;
        min-height: 44px;
        padding: 10px 8px;
        text-align: center;
        text-decoration: none;
        white-space: nowrap;
        transition: background-color .2s ease, border-color .2s ease, color .2s ease, transform .2s ease;
    }

    .kr-training-action-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 auto;
        width: 19px;
        height: 19px;
        color: inherit;
    }

    .kr-training-action-icon svg {
        width: 19px;
        height: 19px;
        fill: currentColor;
    }

    .kr-training-action-icon i {
        color: inherit;
        font-size: 17px;
        line-height: 1;
    }

    body .kaynaklar-page .kr-training-actions > a.kr-training-action-button:hover,
    body .kaynaklar-page .kr-training-actions > button.kr-training-action-button:hover,
    body .kaynaklar-page .kr-training-actions > a.kr-training-action-button:focus-visible,
    body .kaynaklar-page .kr-training-actions > button.kr-training-action-button:focus-visible,
    body .kaynaklar-page .kr-training-actions > .kr-training-action-button.is-hovered {
        background: var(--kr-training-hover-color) !important;
        background-color: var(--kr-training-hover-color) !important;
        background-image: none !important;
        border-color: var(--kr-training-hover-color) !important;
        color: #fff !important;
        box-shadow: 0 6px 14px rgba(245, 130, 32, .24) !important;
        transform: translateY(-1px);
    }

    body .kaynaklar-page .kr-training-actions > .kr-training-action-button:hover *,
    body .kaynaklar-page .kr-training-actions > .kr-training-action-button:focus-visible *,
    body .kaynaklar-page .kr-training-actions > .kr-training-action-button.is-hovered * {
        color: #fff !important;
        fill: currentColor !important;
    }

    @media (max-width: 420px) {
        .kr-training-actions {
            grid-template-columns: 1fr;
        }
    }
</style>
<script>
(function () {
    'use strict';

    const detailButtonText = 'Detaylı Bilgi İçin Tıklayınız';
    const actionItems = <?= json_encode([
        ['label' => 'Eğitim', 'icon' => icon('education')],
        ['label' => 'Video', 'icon' => icon('video')],
        ['label' => 'Doküman', 'icon' => icon('document')],
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;

    function replaceTrainingButtons(root) {
        root.querySelectorAll('a, button').forEach((originalButton) => {
            if (originalButton.textContent.trim() !== detailButtonText) {
                return;
            }

            const actionGroup = document.createElement('div');
            actionGroup.className = 'kr-training-actions';
            actionGroup.setAttribute('aria-label', 'Eğitim bağlantıları');

            actionItems.forEach((item) => {
                // Orijinal öğeyi klonladığımız için href/onclick/target gibi
                // bağlantı bilgileri üç butonda da korunur.
                const actionButton = originalButton.cloneNode(true);
                const iconElement = document.createElement('span');
                const labelElement = document.createElement('span');

                iconElement.className = 'kr-training-action-icon';
                iconElement.setAttribute('aria-hidden', 'true');
                iconElement.innerHTML = item.icon;

                labelElement.className = 'kr-training-action-label';
                labelElement.textContent = item.label;

                actionButton.replaceChildren(iconElement, labelElement);
                actionButton.classList.add('kr-training-action-button');
                actionButton.dataset.trainingAction = item.label;

                // Mevcut tema CSS'i güçlü seçiciler veya gradient kullansa bile
                // hover renginin kesin uygulanması için sınıf tabanlı destek.
                actionButton.addEventListener('pointerenter', () => {
                    actionButton.classList.add('is-hovered');
                });
                actionButton.addEventListener('pointerleave', () => {
                    actionButton.classList.remove('is-hovered');
                });
                actionButton.addEventListener('focus', () => {
                    actionButton.classList.add('is-hovered');
                });
                actionButton.addEventListener('blur', () => {
                    actionButton.classList.remove('is-hovered');
                });
                actionButton.setAttribute('aria-label', item.label);
                actionGroup.appendChild(actionButton);
            });

            originalButton.replaceWith(actionGroup);
        });
    }

    function initializeTrainingActions() {
        const grid = document.getElementById('documentsGrid');
        if (!grid) {
            return;
        }

        replaceTrainingButtons(grid);

        // Arama sonucunda kartlar yeniden oluşturulursa butonları tekrar uygula.
        const observer = new MutationObserver(() => replaceTrainingButtons(grid));
        observer.observe(grid, { childList: true, subtree: true });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeTrainingActions);
    } else {
        initializeTrainingActions();
    }
})();
</script>
<?php endif; ?>
</body>
</html>