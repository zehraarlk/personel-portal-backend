<?php
/**
 * Dosya sorumluluğu: Email.
 *
 * Girdi doğrulama, yetkilendirme ve çıktı kaçışları bu dosyanın
 * mevcut güvenlik akışına uygun biçimde korunmalıdır.
 */
declare(strict_types=1);

require_once __DIR__ . '/../../includes/init.php';
require_once __DIR__ . '/../../includes/auth-helpers.php';
require_once __DIR__ . '/../../includes/profil-helpers.php';
require_once __DIR__ . '/../../includes/icons.php';

requirePersonelProfil($assetBase);

$personelId = (int) $_SESSION['personel_id'];
$flash = profilFlashGet();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email_guncelle'])) {
    if (!csrfVerify($_POST['csrf_token'] ?? null)) {
        profilFlashSet('error', 'Oturum doğrulaması başarısız. Sayfayı yenileyip tekrar deneyin.');
        header('Location: email.php');
        exit;
    }

    $result = updatePersonelEmail(getPDO(), $personelId, (string) ($_POST['email'] ?? ''));
    profilFlashSet($result['ok'] ? 'success' : 'error', $result['message']);
    header('Location: email.php');
    exit;
}

$currentEmail = getPersonelEmail(getPDO(), $personelId);
if ($currentEmail === '' && !empty($_SESSION['email'])) {
    $currentEmail = (string) $_SESSION['email'];
}

$pageTitle = 'E-posta Değiştir';
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

            <section class="profil-card" aria-labelledby="email-card-title">
                <header class="profil-card__header">
                    <h1 id="email-card-title" class="profil-card__title">
                        <span class="icon" aria-hidden="true"><?= icon('mail') ?></span>
                        E-posta Değiştir
                    </h1>
                </header>

                <div class="profil-card__body">
                    <form class="profil-form" action="email.php" method="post" novalidate>
                        <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">

                        <div class="profil-field">
                            <label for="email" class="profil-label">E-posta Adresiniz</label>
                            <input
                                type="email"
                                class="profil-input"
                                id="email"
                                name="email"
                                value="<?= e($currentEmail) ?>"
                                placeholder="ornek@gebze.bel.tr"
                                autocomplete="email"
                                required>
                        </div>

                        <button type="submit" name="email_guncelle" value="1" class="profil-submit">
                            <span class="icon" aria-hidden="true"><?= icon('mail') ?></span>
                            E-postayı Kaydet
                        </button>
                    </form>
                </div>
            </section>
        </div>
    </div>
</main>

<?php require __DIR__ . '/../../includes/footer.php'; ?>
<script src="<?= e($assetBase) ?>assets/js/navbar.js" defer></script>
</body>
</html>
