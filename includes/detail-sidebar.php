<?php
/**
 * Dosya sorumluluğu: Detay sayfası yan panel bileşeni.
 *
 * Girdi doğrulama, yetkilendirme ve çıktı kaçışları bu dosyanın
 * mevcut güvenlik akışına uygun biçimde korunmalıdır.
 */
declare(strict_types=1);

/**
 * @var array<int, array<string, mixed>> $digerSayfalari
 * @var string $sidebarTitle
 * @var string $sidebarIcon
 * @var string $itemDetailBase
 * @var bool $sidebarShowCategory
 */
$sidebarShowCategory = $sidebarShowCategory ?? false;
?>
<aside class="detail-sidebar">
    <div class="detail-sidebar-card">
        <header class="detail-sidebar-header">
            <span class="icon" aria-hidden="true"><?= icon($sidebarIcon) ?></span>
            <h2><?= e($sidebarTitle) ?></h2>
        </header>

        <div class="detail-sidebar-slider" data-detail-slider>
            <div class="detail-sidebar-track" id="detailSidebarTrack">
                <?php if ($digerSayfalari === []): ?>
                <div class="detail-sidebar-page">
                    <p class="detail-sidebar-empty">Gösterilecek başka kayıt bulunmuyor.</p>
                </div>
                <?php else: ?>
                    <?php foreach ($digerSayfalari as $sayfa): ?>
                    <div class="detail-sidebar-page">
                        <?php foreach ($sayfa as $item): ?>
                        <a href="<?= e($itemDetailBase . (int) ($item['id'] ?? 0)) ?>" class="detail-sidebar-item">
                            <img src="<?= e(sidebarItemImage($item, $assetBase)) ?>"
                                 alt="<?= e((string) ($item['baslik'] ?? '')) ?>"
                                 class="detail-sidebar-thumb"
                                 loading="lazy">
                            <div class="detail-sidebar-item-body">
                                <?php if ($sidebarShowCategory && !empty($item['kategori_adi'])): ?>
                                <span class="detail-sidebar-category"><?= e((string) $item['kategori_adi']) ?></span>
                                <?php endif; ?>
                                <h3><?= e((string) ($item['baslik'] ?? '')) ?></h3>
                                <p><?= e(sidebarItemExcerpt($item)) ?></p>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <?php if (count($digerSayfalari) > 1): ?>
        <footer class="detail-sidebar-pagination">
            <button type="button" class="detail-sidebar-nav" id="detailSidebarPrev" aria-label="Önceki sayfa" disabled>
                <span class="icon" aria-hidden="true"><?= icon('chevron-left') ?></span>
            </button>
            <span class="detail-sidebar-page-info" id="detailSidebarPageInfo">Sayfa 1 / <?= count($digerSayfalari) ?></span>
            <button type="button" class="detail-sidebar-nav" id="detailSidebarNext" aria-label="Sonraki sayfa">
                <span class="icon" aria-hidden="true"><?= icon('chevron-right') ?></span>
            </button>
        </footer>
        <?php else: ?>
        <footer class="detail-sidebar-footer" aria-hidden="true"></footer>
        <?php endif; ?>
    </div>
</aside>
