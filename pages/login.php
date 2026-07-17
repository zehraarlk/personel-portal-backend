<?php
/**
 * Dosya sorumluluğu: Personel giriş sayfası.
 *
 * Girdi doğrulama, yetkilendirme ve çıktı kaçışları bu dosyanın
 * mevcut güvenlik akışına uygun biçimde korunmalıdır.
 */
/**
 * Personel giriş ekranı.
 *
 * GET  → HTML form (sicil no + şifre)
 * POST → JSON { status, message }  (login.js AJAX ile çağırır)
 *
 * Başarılı girişte personel oturumu açılır; varsa yönetici oturumu kapatılır.
 */
declare(strict_types=1);

require_once __DIR__ . '/baglan.php';
require_once __DIR__ . '/../includes/icons.php';

// Zaten geçerli personel oturumu varsa ana sayfaya yönlendir.
if (!empty($_SESSION['personel_id']) && !empty($_SESSION['oturum_id'])) {
    $aktifOturum = dbFetchOne(
        $db,
        'SELECT id FROM oturum_kayitlari
         WHERE id = ? AND personel_id = ? AND cikis_zamani IS NULL
         LIMIT 1',
        [(int) $_SESSION['oturum_id'], (int) $_SESSION['personel_id']]
    );

    if ($aktifOturum) {
        header('Location: ana_sayfa.php');
        exit;
    }

    // Oturum kaydı kapanmışsa PHP session anahtarlarını temizle.
    unset(
        $_SESSION['personel_id'],
        $_SESSION['oturum_id'],
        $_SESSION['sicil_no'],
        $_SESSION['email'],
        $_SESSION['ad'],
        $_SESSION['soyad']
    );
}

// --- AJAX giriş (JSON) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sicil_no'], $_POST['sifre'])) {
    header('Content-Type: application/json; charset=utf-8');

    try {
        $sicilNo = trim((string) $_POST['sicil_no']);
        $sifreHash = md5(trim((string) $_POST['sifre']));

        if ($sicilNo === '' || $sifreHash === md5('')) {
            echo json_encode(['status' => 'error', 'message' => 'Sicil numarası ve şifre zorunludur.'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $personel = dbFetchOne(
            $db,
            'SELECT * FROM personeller WHERE sicil_no = ? AND sifre = ? LIMIT 1',
            [$sicilNo, $sifreHash]
        );

        if (!$personel) {
            echo json_encode(['status' => 'error', 'message' => 'Sicil numarası veya şifre hatalı!'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        // Aynı tarayıcıda yönetici oturumu varsa kapat (karışmayı önle).
        if (!empty($_SESSION['yonetici_oturum_id'])) {
            try {
                yoneticiOturumClose($db, (int) $_SESSION['yonetici_oturum_id'], 'otomatik');
            } catch (Throwable) {
                // Oturum kapatma başarısız olsa da personel girişine devam et.
            }
        }
        unset(
            $_SESSION['yonetici_id'],
            $_SESSION['yonetici_oturum_id'],
            $_SESSION['yonetici_kullanici'],
            $_SESSION['yonetici_ad'],
            $_SESSION['yonetici_soyad'],
            $_SESSION['yonetici_yetki']
        );

        $_SESSION['personel_id'] = (int) $personel['id'];
        $_SESSION['sicil_no'] = (string) $personel['sicil_no'];
        $_SESSION['email'] = (string) $personel['email'];
        $_SESSION['ad'] = (string) $personel['ad'];
        $_SESSION['soyad'] = (string) $personel['soyad'];
        $_SESSION['oturum_id'] = oturumStart($db, (int) $personel['id']);

        echo json_encode(['status' => 'success'], JSON_UNESCAPED_UNICODE);
        exit;
    } catch (Throwable $e) {
        error_log('Personel giris hatasi: ' . $e->getMessage());
        echo json_encode(
            ['status' => 'error', 'message' => 'Giriş işlemi sırasında bir hata oluştu.'],
            JSON_UNESCAPED_UNICODE
        );
        exit;
    }
}

$assetBase = '../';
$pageTitle = 'Personel Giriş';
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
<body class="login-page" style="<?= htmlspecialchars('--login-logo-url: url(\'' . LOGIN_LOGO_URL . '\')', ENT_QUOTES, 'UTF-8') ?>">
    <main class="login-box" aria-labelledby="login-title">
        <div class="login-logo-wrap">
            <span class="login-logo" role="img" aria-label="Gebze Belediyesi İnsan Kaynakları"></span>
        </div>
        <p id="login-title" class="login-subtitle">PERSONEL GİRİŞ EKRANI</p>

        <div id="phpError" class="login-alert" role="alert" aria-live="polite"></div>

        <form
            id="loginForm"
            class="login-form"
            novalidate
            data-login-url="login.php"
            data-redirect="ana_sayfa.php">
            <div class="login-field">
                <label for="username" class="login-label">
                    Sicil Numarası <span class="required" aria-hidden="true">*</span>
                </label>
                <input
                    type="text"
                    class="login-input"
                    id="username"
                    name="sicil_no"
                    placeholder="Sicil Numaranız..."
                    autocomplete="username"
                    required>
                <p id="usernameError" class="login-field-error">Sicil numarası boş bırakılamaz.</p>
            </div>

            <div class="login-field">
                <div class="login-field-row">
                    <label for="password" class="login-label login-label--inline">
                        Şifre <span class="required" aria-hidden="true">*</span>
                    </label>
                    <a href="sifre_unuttum.php" class="login-forgot-link">Şifremi Unuttum ?</a>
                </div>
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

            <button type="submit" class="login-submit" id="loginSubmit">Giriş Yap</button>

            <div class="login-divider" aria-hidden="true">YA DA</div>

            <a href="sifre_unuttum.php" class="login-secondary-btn">
                Şifrenizi Sıfırlamak için Tıklayınız.
            </a>
            <a href="yonetim_giris.php" class="login-secondary-btn">
                Yönetim Paneli için Tıklayınız.
            </a>
        </form>
    </main>

    <script src="<?= htmlspecialchars($assetBase, ENT_QUOTES, 'UTF-8') ?>assets/js/login.js" defer></script>
</body>
</html>
