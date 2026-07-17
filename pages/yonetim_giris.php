<?php
/**
 * Dosya sorumluluğu: Yönetici giriş sayfası.
 *
 * Girdi doğrulama, yetkilendirme ve çıktı kaçışları bu dosyanın
 * mevcut güvenlik akışına uygun biçimde korunmalıdır.
 */
/**
 * Yönetici giriş ekranı.
 *
 * GET  → HTML form
 * POST → JSON { status, message } (login.js)
 */
declare(strict_types=1);

require_once __DIR__ . '/baglan.php';
require_once __DIR__ . '/../includes/icons.php';

if (adminIsLoggedIn()) {
    header('Location: admin/index.php');
    exit;
}

adminSessionClear();

if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['kullanici_adi'], $_POST['sifre'])
) {
    header('Content-Type: application/json; charset=utf-8');

    try {
        $kullaniciAdi = trim((string) $_POST['kullanici_adi']);
        $sifre = (string) $_POST['sifre'];

        if ($kullaniciAdi === '' || trim($sifre) === '') {
            echo json_encode(['status' => 'error', 'message' => 'Kullanıcı adı ve şifre zorunludur.'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $yonetici = dbFetchOne(
            $db,
            'SELECT * FROM yoneticiler WHERE LOWER(kullanici_adi) = LOWER(?) AND aktif = 1 LIMIT 1',
            [$kullaniciAdi]
        );

        if ($yonetici && adminVerifyPassword((string) $yonetici['sifre'], $sifre)) {
            // Personel oturumu açıksa kapat.
            if (!empty($_SESSION['oturum_id'])) {
                oturumClose($db, (int) $_SESSION['oturum_id'], 'otomatik');
            }

            unset(
                $_SESSION['personel_id'],
                $_SESSION['oturum_id'],
                $_SESSION['ad'],
                $_SESSION['soyad'],
                $_SESSION['email'],
                $_SESSION['sicil_no']
            );

            $_SESSION['yonetici_id'] = (int) $yonetici['id'];
            $_SESSION['yonetici_kullanici'] = (string) $yonetici['kullanici_adi'];
            $_SESSION['yonetici_ad'] = (string) $yonetici['ad'];
            $_SESSION['yonetici_soyad'] = (string) $yonetici['soyad'];
            $_SESSION['yonetici_yetki'] = (string) $yonetici['yetki'];
            $_SESSION['yonetici_oturum_id'] = yoneticiOturumStart($db, (int) $yonetici['id']);

            // Eski MD5 şifreyi bcrypt’e yükselt.
            if (strlen((string) $yonetici['sifre']) === 32 && ctype_xdigit((string) $yonetici['sifre'])) {
                $db->prepare('UPDATE yoneticiler SET sifre = ? WHERE id = ?')
                    ->execute([adminHashPassword($sifre), (int) $yonetici['id']]);
            }

            echo json_encode(['status' => 'success'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        echo json_encode(['status' => 'error', 'message' => 'Kullanıcı adı veya şifre hatalı!'], JSON_UNESCAPED_UNICODE);
        exit;
    } catch (Throwable $e) {
        error_log('Yonetici giris hatasi: ' . $e->getMessage());
        echo json_encode(
            ['status' => 'error', 'message' => 'Giriş işlemi sırasında bir hata oluştu.'],
            JSON_UNESCAPED_UNICODE
        );
        exit;
    }
}

$assetBase = '../';
$pageTitle = 'Yönetim Girişi';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?> — <?= htmlspecialchars(SITE_NAME, ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="icon" href="<?= htmlspecialchars($assetBase, ENT_QUOTES, 'UTF-8') ?>images/favicon.webp" type="image/webp">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="<?= htmlspecialchars($assetBase, ENT_QUOTES, 'UTF-8') ?>assets/css/variables.css">
    <link rel="stylesheet" href="<?= htmlspecialchars($assetBase, ENT_QUOTES, 'UTF-8') ?>assets/css/login.css">
</head>
<body class="login-page login-page--admin" style="<?= htmlspecialchars('--login-logo-url: url(\'' . LOGIN_LOGO_URL . '\')', ENT_QUOTES, 'UTF-8') ?>">
    <main class="login-box" aria-labelledby="admin-login-title">
        <div class="login-logo-wrap">
            <span class="login-logo" role="img" aria-label="Gebze Belediyesi İnsan Kaynakları"></span>
        </div>
        <p class="login-badge">
            <span aria-hidden="true"><?= icon('shield') ?></span>
            YÖNETİM PANELİ
        </p>
        <p id="admin-login-title" class="login-subtitle">YÖNETİCİ GİRİŞ EKRANI</p>
        <p class="login-note">Yönetim paneli girişi personel girişinden ayrıdır.</p>

        <div id="phpError" class="login-alert" role="alert" aria-live="polite"></div>

        <form
            id="loginForm"
            class="login-form"
            novalidate
            data-login-url="yonetim_giris.php"
            data-redirect="admin/index.php"
            data-submit-label="GİRİŞ YAP">
            <div class="login-field">
                <label for="username" class="login-label">
                    Kullanıcı Adı <span class="required" aria-hidden="true">*</span>
                </label>
                <input
                    type="text"
                    class="login-input"
                    id="username"
                    name="kullanici_adi"
                    placeholder="Kullanıcı Adınız..."
                    autocomplete="username"
                    required>
                <p id="usernameError" class="login-field-error">Kullanıcı adı boş bırakılamaz.</p>
            </div>

            <div class="login-field">
                <label for="password" class="login-label">
                    Şifre <span class="required" aria-hidden="true">*</span>
                </label>
                <div class="login-password-wrap">
                    <input
                        type="password"
                        class="login-input"
                        id="password"
                        name="sifre"
                        placeholder="Şifreniz"
                        autocomplete="current-password"
                        required>
                    <button type="button" class="login-password-toggle" id="togglePassword" aria-label="Şifreyi göster">
                        <span id="toggleIcon" aria-hidden="true"><?= icon('eye-off') ?></span>
                    </button>
                </div>
                <p id="passwordError" class="login-field-error">Şifre boş bırakılamaz.</p>
            </div>

            <button type="submit" class="login-submit" id="loginSubmit">GİRİŞ YAP</button>
        </form>

        <a href="login.php" class="login-back-link">
            <span aria-hidden="true"><?= icon('chevron-left') ?></span>
            Personel Girişine Dön
        </a>
    </main>

    <script src="<?= htmlspecialchars($assetBase, ENT_QUOTES, 'UTF-8') ?>assets/js/login.js" defer></script>
</body>
</html>
