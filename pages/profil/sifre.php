<?php
declare(strict_types=1);

require_once __DIR__ . '/../../includes/init.php';
require_once __DIR__ . '/../../includes/auth-helpers.php';
require_once __DIR__ . '/../../includes/profil-helpers.php';
require_once __DIR__ . '/../../includes/icons.php';

requirePersonelProfil($assetBase);

$personelId = (int) $_SESSION['personel_id'];
$flash = profilFlashGet();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sifre_guncelle'])) {
    if (!csrfVerify($_POST['csrf_token'] ?? null)) {
        profilFlashSet('error', 'Oturum doğrulaması başarısız. Sayfayı yenileyip tekrar deneyin.');
        header('Location: sifre.php');
        exit;
    }

    $result = updatePersonelPassword(
        getPDO(),
        $personelId,
        (string) ($_POST['eski_sifre'] ?? ''),
        (string) ($_POST['yeni_sifre'] ?? '')
    );
    profilFlashSet($result['ok'] ? 'success' : 'error', $result['message']);
    header('Location: sifre.php');
    exit;
}

$pageTitle = 'Şifre Değiştir';
$pageCss = 'profil.css';
$showBreadcrumb = true;

require __DIR__ . '/../../includes/site-head.php';
require __DIR__ . '/../../includes/header-nav.php';
require __DIR__ . '/../../includes/breadcrumb.php';
?>

<main class="content-area profil-page">
    <div class="site-container">
        <div class="profil-layout">
            <?php if ($flash !== null): ?>
            <p class="profil-alert profil-alert--<?= e($flash['type']) ?>" role="alert"><?= e($flash['message']) ?></p>
            <?php endif; ?>

            <section class="profil-card" aria-labelledby="password-card-title">
                <header class="profil-card__header">
                    <h1 id="password-card-title" class="profil-card__title">
                        <span class="icon" aria-hidden="true"><?= icon('key') ?></span>
                        Şifre Değiştir
                    </h1>
                </header>

                <div class="profil-card__body">
                    <form class="profil-form" action="sifre.php" method="post" novalidate>
                        <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">

                        <div class="profil-field">
                            <label for="eskiSifre" class="profil-label">Mevcut Şifre</label>
                            <div class="profil-password-wrap">
                                <input
                                    type="password"
                                    class="profil-input"
                                    id="eskiSifre"
                                    name="eski_sifre"
                                    placeholder="Mevcut şifreniz"
                                    autocomplete="current-password"
                                    required>
                                <button
                                    type="button"
                                    class="profil-password-toggle"
                                    data-password-toggle
                                    aria-controls="eskiSifre"
                                    aria-label="Şifreyi göster">
                                    <span data-toggle-icon aria-hidden="true"><?= icon('eye-off') ?></span>
                                </button>
                            </div>
                        </div>

                        <div class="profil-field">
                            <label for="yeniSifre" class="profil-label">Yeni Şifre</label>
                            <div class="profil-password-wrap">
                                <input
                                    type="password"
                                    class="profil-input"
                                    id="yeniSifre"
                                    name="yeni_sifre"
                                    placeholder="Yeni şifreniz"
                                    autocomplete="new-password"
                                    required>
                                <button
                                    type="button"
                                    class="profil-password-toggle"
                                    data-password-toggle
                                    aria-controls="yeniSifre"
                                    aria-label="Şifreyi göster">
                                    <span data-toggle-icon aria-hidden="true"><?= icon('eye-off') ?></span>
                                </button>
                            </div>
                        </div>

                        <button type="submit" name="sifre_guncelle" value="1" class="profil-submit">
                            <span class="icon" aria-hidden="true"><?= icon('key') ?></span>
                            Şifreyi Güncelle
                        </button>
                    </form>
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
