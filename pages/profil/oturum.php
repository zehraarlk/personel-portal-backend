<?php
/**
 * Dosya sorumluluğu: Oturum.
 *
 * Girdi doğrulama, yetkilendirme ve çıktı kaçışları bu dosyanın
 * mevcut güvenlik akışına uygun biçimde korunmalıdır.
 */
declare(strict_types=1);

require_once __DIR__ . '/../../includes/init.php';
require_once __DIR__ . '/../../includes/auth-helpers.php';
require_once __DIR__ . '/../../includes/profil-helpers.php';
require_once __DIR__ . '/../../includes/icons.php';

requireProfilOturum($assetBase);

$oturumData = loadOturumBilgileri(getPDO());
$yoneticiModu = (bool) $oturumData['yoneticiModu'];
$oturumlar = $oturumData['oturumlar'];
$aktifOturumId = (int) $oturumData['aktifOturumId'];
$cikisUrl = '../' . ltrim((string) $oturumData['cikisUrl'], '/');

$pageTitle = 'Oturum Bilgileri';
$pageCss = 'profil.css';
$showBreadcrumb = true;

require __DIR__ . '/../../includes/site-head.php';
require __DIR__ . '/../../includes/header-nav.php';
require __DIR__ . '/../../includes/breadcrumb.php';
?>

<main class="content-area profil-page">
    <div class="site-container">
        <div class="profil-layout">
            <section class="profil-card" aria-labelledby="session-card-title">
                <header class="profil-card__header">
                    <h1 id="session-card-title" class="profil-card__title">
                        <span class="icon" aria-hidden="true"><?= icon('info') ?></span>
                        Oturum Bilgileri<?= $yoneticiModu ? ' (Yönetici)' : '' ?>
                    </h1>
                    <a href="<?= e($cikisUrl) ?>" class="profil-logout-btn" data-logout-confirm>
                        <span class="icon" aria-hidden="true"><?= icon('logout') ?></span>
                        Çıkış Yap
                    </a>
                </header>

                <div class="profil-card__body">
                    <p class="profil-intro"><?= e((string) $oturumData['aciklama']) ?></p>

                    <div class="profil-table-wrap">
                        <table class="profil-table">
                            <thead>
                                <tr>
                                    <th scope="col">Giriş</th>
                                    <th scope="col">Çıkış</th>
                                    <th scope="col">Kapanış</th>
                                    <?php if ($yoneticiModu): ?>
                                    <th scope="col">IP</th>
                                    <?php endif; ?>
                                    <th scope="col">Durum</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($oturumlar === []): ?>
                                <tr>
                                    <td colspan="<?= $yoneticiModu ? 5 : 4 ?>" class="profil-empty">
                                        Kayıtlı oturum geçmişi bulunamadı.
                                    </td>
                                </tr>
                                <?php else: ?>
                                    <?php foreach ($oturumlar as $oturum): ?>
                                        <?php
                                        $meta = portalOturumStatusMeta(
                                            isset($oturum['cikis_zamani']) ? (string) $oturum['cikis_zamani'] : null,
                                            isset($oturum['kapanis_tipi']) ? (string) $oturum['kapanis_tipi'] : null,
                                            (int) $oturum['id'],
                                            $aktifOturumId
                                        );
                                        $hasExit = !empty($oturum['cikis_zamani']);
                                        ?>
                                <tr>
                                    <td>
                                        <span class="profil-datetime profil-datetime--in">
                                            <span class="icon" aria-hidden="true"><?= icon('clock') ?></span>
                                            <?= e(formatProfilDateTime((string) ($oturum['giris_zamani'] ?? ''))) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($hasExit): ?>
                                        <span class="profil-datetime profil-datetime--out">
                                            <span class="icon" aria-hidden="true"><?= icon('clock') ?></span>
                                            <?= e(formatProfilDateTime((string) $oturum['cikis_zamani'])) ?>
                                        </span>
                                        <?php else: ?>
                                        <span class="<?= e($meta['badgeClass']) ?>"><?= e($meta['closeLabel']) ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= e($meta['closeLabel']) ?></td>
                                    <?php if ($yoneticiModu): ?>
                                    <td><?= e((string) ($oturum['ip_adresi'] ?? '—')) ?></td>
                                    <?php endif; ?>
                                    <td>
                                        <span class="<?= e($meta['badgeClass']) ?>"><?= e($meta['statusLabel']) ?></span>
                                    </td>
                                </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
</main>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
<script src="<?= e($assetBase) ?>assets/js/profil.js" defer></script>
<script src="<?= e($assetBase) ?>assets/js/navbar.js" defer></script>
</body>
</html>
