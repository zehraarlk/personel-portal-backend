<?php
declare(strict_types=1);

require_once __DIR__ . '/baglan.php';

if (!empty($_SESSION['personel_id'])) {
    header('Location: ana_sayfa.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tc_no'], $_POST['telefon'])) {
    header('Content-Type: application/json; charset=utf-8');

    $tcNo = trim((string) $_POST['tc_no']);
    $telefon = preg_replace('/\D/', '', trim((string) $_POST['telefon'])) ?? '';

    if ($tcNo === '' || strlen($tcNo) !== 11 || !ctype_digit($tcNo)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Geçerli bir T.C. Kimlik Numarası giriniz.',
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if ($telefon === '' || strlen($telefon) !== 11 || substr($telefon, 0, 2) !== '05') {
        echo json_encode([
            'status' => 'error',
            'message' => 'Geçerli bir cep telefonu numarası giriniz. Örn: 05XX XXX XX XX',
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $personel = dbFetchOne(
        $db,
        'SELECT id FROM personeller WHERE tc_no = ? AND telefon = ? LIMIT 1',
        [$tcNo, $telefon]
    );

    if (!$personel) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Girdiğiniz bilgilerle eşleşen bir personel kaydı bulunamadı.',
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $yeniSifre = strtoupper(substr(bin2hex(random_bytes(4)), 0, 8));
    $sifreHash = md5($yeniSifre);

    $guncelle = $db->prepare('UPDATE personeller SET sifre = ? WHERE id = ?');
    $guncelle->execute([$sifreHash, (int) $personel['id']]);

    // TODO: $yeniSifre değerini SMS/e-posta ile personele iletiniz

    echo json_encode([
        'status' => 'success',
        'message' => 'Şifreniz sıfırlandı. Yeni şifreniz kayıtlı iletişim bilgilerinize gönderildi.',
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$assetBase = '../';
$pageTitle = 'Şifremi Unuttum';
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
<body class="login-page login-page--reset" style="<?= htmlspecialchars('--login-logo-url: url(\'' . LOGIN_LOGO_URL . '\')', ENT_QUOTES, 'UTF-8') ?>">
    <main class="login-box" aria-labelledby="reset-title">
        <div class="login-logo-wrap">
            <span class="login-logo" role="img" aria-label="Gebze Belediyesi İnsan Kaynakları"></span>
        </div>

        <h1 id="reset-title" class="login-title">Şifremi Unuttum ?</h1>
        <p class="login-intro">Şifrenizi sıfırlamak için sizden istenilen bilgileri giriniz.</p>

        <div id="phpError" class="login-alert" role="alert" aria-live="polite"></div>
        <div id="phpSuccess" class="login-alert login-alert--success" role="status" aria-live="polite"></div>

        <form
            id="resetForm"
            class="login-form"
            novalidate
            data-reset-url="sifre_unuttum.php">
            <div class="login-field">
                <label for="tcNo" class="login-label">
                    T.C Kimlik Numarası <span class="required" aria-hidden="true">*</span>
                </label>
                <input
                    type="text"
                    class="login-input"
                    id="tcNo"
                    name="tc_no"
                    placeholder="Kimlik Numaranız..."
                    inputmode="numeric"
                    maxlength="11"
                    autocomplete="off"
                    required>
                <p id="tcNoError" class="login-field-error">Geçerli bir T.C. Kimlik Numarası giriniz.</p>
            </div>

            <div class="login-field">
                <label for="telefon" class="login-label">
                    Cep Telefonu <span class="required" aria-hidden="true">*</span>
                </label>
                <input
                    type="text"
                    class="login-input"
                    id="telefon"
                    name="telefon"
                    placeholder="0**********"
                    inputmode="numeric"
                    maxlength="11"
                    autocomplete="off"
                    required>
                <p id="telefonError" class="login-field-error">Geçerli bir cep telefonu numarası giriniz.</p>
                <p class="login-format-hint">
                    Cep Telefonu Yazım Formatı: <code>05** *** ** **</code>
                </p>
            </div>

            <div class="login-btn-row">
                <button type="submit" class="login-submit login-submit--inline" id="resetSubmit">Şifre Sıfırla</button>
                <a href="login.php" class="login-cancel-btn">Vazgeç</a>
            </div>
        </form>
    </main>

    <script src="<?= htmlspecialchars($assetBase, ENT_QUOTES, 'UTF-8') ?>assets/js/sifre_unuttum.js" defer></script>
</body>
</html>
