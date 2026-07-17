<?php
/**
 * Dosya sorumluluğu: Profil fotoğrafı güncelleme sayfası.
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

$flash = profilFlashGet();
$currentPath = getProfilFotoPath(getPDO());
$currentPhoto = profilePhotoMeta($currentPath, $assetBase);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['foto_guncelle'])) {
    if (!csrfVerify($_POST['csrf_token'] ?? null)) {
        profilFlashSet('error', 'Oturum doğrulaması başarısız. Sayfayı yenileyip tekrar deneyin.');
        header('Location: foto.php');
        exit;
    }

    $result = updateProfilFoto(getPDO(), $_FILES['foto'] ?? []);
    profilFlashSet($result['ok'] ? 'success' : 'error', $result['message']);
    header('Location: foto.php');
    exit;
}

$pageTitle = 'Profil Fotoğrafı';
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

            <section class="profil-card" aria-labelledby="foto-card-title">
                <header class="profil-card__header">
                    <h1 id="foto-card-title" class="profil-card__title">
                        <span class="icon" aria-hidden="true"><?= icon('image') ?></span>
                        Profil Fotoğrafı
                    </h1>
                </header>

                <div class="profil-card__body">
                    <p class="profil-intro">Navbar ve doğum günü listelerinde görünen fotoğrafınızı buradan güncelleyebilirsiniz.</p>

                    <div class="profil-foto-preview">
                        <img
                            src="<?= e($currentPhoto['url']) ?>"
                            alt="Mevcut profil fotoğrafı"
                            class="profil-foto-preview__img<?= $currentPhoto['isBrand'] ? ' profil-foto-preview__img--brand' : '' ?>"
                            width="120"
                            height="120"
                        >
                    </div>

                    <form class="profil-form" action="foto.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">

                        <div class="profil-field">
                            <label for="foto" class="profil-label">Yeni fotoğraf</label>
                            <input
                                type="file"
                                class="profil-input"
                                id="foto"
                                name="foto"
                                accept="image/jpeg,image/png,image/webp,image/gif"
                                required
                            >
                            <p class="profil-form-hint">JPG, PNG, WEBP veya GIF. En fazla 5 MB önerilir.</p>
                        </div>

                        <button type="submit" name="foto_guncelle" value="1" class="profil-submit">
                            <span class="icon" aria-hidden="true"><?= icon('image') ?></span>
                            Fotoğrafı Kaydet
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
