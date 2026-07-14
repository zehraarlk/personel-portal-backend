<?php
declare(strict_types=1);

require_once __DIR__ . '/db-helpers.php';

function csrfToken(): string
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (empty($_SESSION['csrf_token']) || !is_string($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function csrfVerify(?string $token): bool
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    return is_string($token)
        && isset($_SESSION['csrf_token'])
        && is_string($_SESSION['csrf_token'])
        && hash_equals($_SESSION['csrf_token'], $token);
}

function clearPersonelSession(): void
{
    unset(
        $_SESSION['personel_id'],
        $_SESSION['oturum_id'],
        $_SESSION['sicil_no'],
        $_SESSION['email'],
        $_SESSION['ad'],
        $_SESSION['soyad']
    );
}

function clearYoneticiSession(): void
{
    unset(
        $_SESSION['yonetici_id'],
        $_SESSION['yonetici_oturum_id'],
        $_SESSION['yonetici_kullanici'],
        $_SESSION['yonetici_ad'],
        $_SESSION['yonetici_soyad'],
        $_SESSION['yonetici_yetki']
    );
}

function clearStalePortalSession(?PDO $pdo = null): void
{
    if ($pdo instanceof PDO) {
        if (!empty($_SESSION['oturum_id']) && !empty($_SESSION['personel_id'])) {
            oturumClose($pdo, (int) $_SESSION['oturum_id'], (int) $_SESSION['personel_id'], 'otomatik');
        }

        if (!empty($_SESSION['yonetici_oturum_id']) && !empty($_SESSION['yonetici_id'])) {
            yoneticiOturumClose($pdo, (int) $_SESSION['yonetici_oturum_id'], (int) $_SESSION['yonetici_id'], 'otomatik');
        }
    }

    clearPersonelSession();
    clearYoneticiSession();
}

function personelOturumIsActive(PDO $pdo): bool
{
    $personelId = (int) ($_SESSION['personel_id'] ?? 0);
    $oturumId = (int) ($_SESSION['oturum_id'] ?? 0);

    if ($personelId <= 0 || $oturumId <= 0) {
        return false;
    }

    return dbFetchOne(
        $pdo,
        'SELECT id FROM oturum_kayitlari
         WHERE id = ? AND personel_id = ? AND cikis_zamani IS NULL
         LIMIT 1',
        [$oturumId, $personelId]
    ) !== null;
}

function yoneticiOturumIsActive(PDO $pdo): bool
{
    $yoneticiId = (int) ($_SESSION['yonetici_id'] ?? 0);
    $oturumId = (int) ($_SESSION['yonetici_oturum_id'] ?? 0);

    if ($yoneticiId <= 0 || $oturumId <= 0) {
        return false;
    }

    return dbFetchOne(
        $pdo,
        'SELECT id FROM yonetici_oturum_kayitlari
         WHERE id = ? AND yonetici_id = ? AND cikis_zamani IS NULL
         LIMIT 1',
        [$oturumId, $yoneticiId]
    ) !== null;
}

function portalSessionIsActive(PDO $pdo): bool
{
    if (!empty($_SESSION['yonetici_id'])) {
        return yoneticiOturumIsActive($pdo);
    }

    if (!empty($_SESSION['personel_id'])) {
        return personelOturumIsActive($pdo);
    }

    return false;
}

function portalTouchActiveSession(PDO $pdo): void
{
    if (personelOturumIsActive($pdo)) {
        oturumTouch($pdo, (int) $_SESSION['oturum_id']);
        return;
    }

    if (yoneticiOturumIsActive($pdo)) {
        yoneticiOturumTouch($pdo, (int) $_SESSION['yonetici_oturum_id']);
    }
}

function oturumTouch(PDO $pdo, int $oturumId): void
{
    if ($oturumId <= 0) {
        return;
    }

    try {
        $stmt = $pdo->prepare(
            'UPDATE oturum_kayitlari
             SET son_aktivite = NOW()
             WHERE id = ? AND cikis_zamani IS NULL'
        );
        $stmt->execute([$oturumId]);
    } catch (Throwable) {
        // Sessizce geç
    }
}

function yoneticiOturumTouch(PDO $pdo, int $oturumId): void
{
    if ($oturumId <= 0) {
        return;
    }

    try {
        $stmt = $pdo->prepare(
            'UPDATE yonetici_oturum_kayitlari
             SET son_aktivite = NOW()
             WHERE id = ? AND cikis_zamani IS NULL'
        );
        $stmt->execute([$oturumId]);
    } catch (Throwable) {
        // Sessizce geç
    }
}

function isLoggedIn(): bool
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    try {
        return portalSessionIsActive(getPDO());
    } catch (Throwable) {
        return false;
    }
}

function requirePortalLogin(string $assetBase): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    try {
        $pdo = getPDO();

        if (!portalSessionIsActive($pdo)) {
            clearStalePortalSession($pdo);
            header('Location: ' . $assetBase . 'pages/login.php');
            exit;
        }

        portalTouchActiveSession($pdo);
    } catch (Throwable $e) {
        error_log('Portal oturum dogrulama hatasi: ' . $e->getMessage());
        clearStalePortalSession();
        header('Location: ' . $assetBase . 'pages/login.php');
        exit;
    }
}

function requireLogin(string $assetBase): void
{
    requirePortalLogin($assetBase);
}

function handlePersonelOturumKapatPost(): never
{
    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: no-store');

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $oturumId = (int) ($_SESSION['oturum_id'] ?? 0);
    $personelId = (int) ($_SESSION['personel_id'] ?? 0);

    try {
        $pdo = getPDO();

        if ($oturumId > 0 && $personelId > 0) {
            oturumClose($pdo, $oturumId, $personelId, 'sekme');
        }
    } catch (Throwable $e) {
        error_log('Oturum kapatma hatasi: ' . $e->getMessage());
    }

    clearPersonelSession();

    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            (bool) $params['secure'],
            (bool) $params['httponly']
        );
    }

    session_destroy();

    echo json_encode(['ok' => true], JSON_UNESCAPED_UNICODE);
    exit;
}

function loginJsonResponse(array $payload, int $status = 200): never
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($payload, JSON_UNESCAPED_UNICODE);
    exit;
}

function oturumStart(PDO $pdo, int $personelId): int
{
    $closeStmt = $pdo->prepare(
        'UPDATE oturum_kayitlari
         SET cikis_zamani = NOW(), kapanis_tipi = ?
         WHERE personel_id = ? AND cikis_zamani IS NULL'
    );
    $closeStmt->execute(['eski', $personelId]);

    $ip = $_SERVER['REMOTE_ADDR'] ?? null;
    $userAgent = substr((string) ($_SERVER['HTTP_USER_AGENT'] ?? ''), 0, 255);

    $insertStmt = $pdo->prepare(
        'INSERT INTO oturum_kayitlari (personel_id, giris_zamani, ip_adresi, user_agent, son_aktivite)
         VALUES (?, NOW(), ?, ?, NOW())'
    );
    $insertStmt->execute([$personelId, $ip, $userAgent]);

    return (int) $pdo->lastInsertId();
}

function loginPersonel(PDO $pdo, string $sicilNo, string $plainPassword): ?array
{
    $sicilNo = trim($sicilNo);
    $passwordHash = md5(trim($plainPassword));

    if ($sicilNo === '' || $plainPassword === '') {
        return null;
    }

    return dbFetchOne(
        $pdo,
        'SELECT id, sicil_no, ad, soyad, email FROM personeller WHERE sicil_no = ? AND sifre = ? LIMIT 1',
        [$sicilNo, $passwordHash]
    );
}

function establishPersonelSession(PDO $pdo, array $personel): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!empty($_SESSION['yonetici_oturum_id']) && !empty($_SESSION['yonetici_id'])) {
        try {
            yoneticiOturumClose(
                $pdo,
                (int) $_SESSION['yonetici_oturum_id'],
                (int) $_SESSION['yonetici_id'],
                'otomatik'
            );
        } catch (Throwable) {
            // devam
        }
    }

    clearYoneticiSession();

    $_SESSION['personel_id'] = (int) $personel['id'];
    $_SESSION['sicil_no'] = (string) $personel['sicil_no'];
    $_SESSION['email'] = (string) $personel['email'];
    $_SESSION['ad'] = (string) $personel['ad'];
    $_SESSION['soyad'] = (string) $personel['soyad'];
    $_SESSION['oturum_id'] = oturumStart($pdo, (int) $personel['id']);
}

function handlePersonelLoginPost(): never
{
    if (!csrfVerify($_POST['csrf_token'] ?? null)) {
        loginJsonResponse(['status' => 'error', 'message' => 'Oturum doğrulaması başarısız. Sayfayı yenileyip tekrar deneyin.'], 403);
    }

    $sicilNo = trim((string) ($_POST['sicil_no'] ?? ''));
    $password = (string) ($_POST['sifre'] ?? '');

    if ($sicilNo === '' || trim($password) === '') {
        loginJsonResponse(['status' => 'error', 'message' => 'Sicil numarası ve şifre zorunludur.']);
    }

    try {
        $pdo = getPDO();
        $personel = loginPersonel($pdo, $sicilNo, $password);

        if ($personel === null) {
            loginJsonResponse(['status' => 'error', 'message' => 'Sicil numarası veya şifre hatalı!']);
        }

        establishPersonelSession($pdo, $personel);
        loginJsonResponse(['status' => 'success']);
    } catch (Throwable $e) {
        error_log('Personel giris hatasi: ' . $e->getMessage());
        loginJsonResponse(['status' => 'error', 'message' => 'Giriş işlemi sırasında bir hata oluştu.'], 500);
    }
}

function logoutCurrentUser(PDO $pdo): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!empty($_SESSION['oturum_id']) && !empty($_SESSION['personel_id'])) {
        oturumClose($pdo, (int) $_SESSION['oturum_id'], (int) $_SESSION['personel_id'], 'cikis');
    }

    if (!empty($_SESSION['yonetici_oturum_id']) && !empty($_SESSION['yonetici_id'])) {
        yoneticiOturumClose($pdo, (int) $_SESSION['yonetici_oturum_id'], (int) $_SESSION['yonetici_id'], 'cikis');
    }

    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], (bool) $params['secure'], (bool) $params['httponly']);
    }

    session_destroy();
}

function oturumClose(PDO $pdo, int $oturumId, int $personelId, string $kapanisTipi = 'cikis'): void
{
    $stmt = $pdo->prepare(
        'UPDATE oturum_kayitlari
         SET cikis_zamani = NOW(), kapanis_tipi = ?
         WHERE id = ? AND personel_id = ? AND cikis_zamani IS NULL'
    );
    $stmt->execute([$kapanisTipi, $oturumId, $personelId]);
}

function yoneticiOturumStart(PDO $pdo, int $yoneticiId): int
{
    $closeStmt = $pdo->prepare(
        'UPDATE yonetici_oturum_kayitlari
         SET cikis_zamani = NOW(), kapanis_tipi = ?
         WHERE yonetici_id = ? AND cikis_zamani IS NULL'
    );
    $closeStmt->execute(['eski', $yoneticiId]);

    $ip = $_SERVER['REMOTE_ADDR'] ?? null;
    $userAgent = substr((string) ($_SERVER['HTTP_USER_AGENT'] ?? ''), 0, 255);

    $insertStmt = $pdo->prepare(
        'INSERT INTO yonetici_oturum_kayitlari (yonetici_id, giris_zamani, ip_adresi, user_agent, son_aktivite)
         VALUES (?, NOW(), ?, ?, NOW())'
    );
    $insertStmt->execute([$yoneticiId, $ip, $userAgent]);

    return (int) $pdo->lastInsertId();
}

function yoneticiOturumClose(PDO $pdo, int $oturumId, int $yoneticiId, string $kapanisTipi = 'cikis'): void
{
    $stmt = $pdo->prepare(
        'UPDATE yonetici_oturum_kayitlari
         SET cikis_zamani = NOW(), kapanis_tipi = ?
         WHERE id = ? AND yonetici_id = ? AND cikis_zamani IS NULL'
    );
    $stmt->execute([$kapanisTipi, $oturumId, $yoneticiId]);
}

function isYoneticiLoggedIn(): bool
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    try {
        return yoneticiOturumIsActive(getPDO());
    } catch (Throwable) {
        return false;
    }
}

function adminVerifyPassword(string $storedHash, string $plainPassword): bool
{
    if ($storedHash === '') {
        return false;
    }

    if (str_starts_with($storedHash, '$2y$') || str_starts_with($storedHash, '$2a$')) {
        return password_verify($plainPassword, $storedHash);
    }

    if (strlen($storedHash) === 32 && ctype_xdigit($storedHash)) {
        return hash_equals($storedHash, md5($plainPassword));
    }

    return hash_equals($storedHash, $plainPassword);
}

function adminHashPassword(string $plainPassword): string
{
    return password_hash($plainPassword, PASSWORD_DEFAULT);
}

function loginYonetici(PDO $pdo, string $kullaniciAdi, string $plainPassword): ?array
{
    $kullaniciAdi = trim($kullaniciAdi);

    if ($kullaniciAdi === '' || $plainPassword === '') {
        return null;
    }

    $yonetici = dbFetchOne(
        $pdo,
        'SELECT id, kullanici_adi, ad, soyad, yetki, sifre FROM yoneticiler WHERE LOWER(kullanici_adi) = LOWER(?) AND aktif = 1 LIMIT 1',
        [$kullaniciAdi]
    );

    if ($yonetici === null || !adminVerifyPassword((string) $yonetici['sifre'], $plainPassword)) {
        return null;
    }

    return $yonetici;
}

function establishYoneticiSession(PDO $pdo, array $yonetici, string $plainPassword): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!empty($_SESSION['oturum_id']) && !empty($_SESSION['personel_id'])) {
        oturumClose($pdo, (int) $_SESSION['oturum_id'], (int) $_SESSION['personel_id'], 'otomatik');
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
    $_SESSION['yonetici_oturum_id'] = yoneticiOturumStart($pdo, (int) $yonetici['id']);

    $storedHash = (string) $yonetici['sifre'];
    if (strlen($storedHash) === 32 && ctype_xdigit($storedHash)) {
        $upgrade = $pdo->prepare('UPDATE yoneticiler SET sifre = ? WHERE id = ?');
        $upgrade->execute([adminHashPassword($plainPassword), (int) $yonetici['id']]);
    }
}

function handleYoneticiLoginPost(): never
{
    if (!csrfVerify($_POST['csrf_token'] ?? null)) {
        loginJsonResponse(['status' => 'error', 'message' => 'Oturum doğrulaması başarısız. Sayfayı yenileyip tekrar deneyin.'], 403);
    }

    $kullaniciAdi = trim((string) ($_POST['kullanici_adi'] ?? ''));
    $password = (string) ($_POST['sifre'] ?? '');

    if ($kullaniciAdi === '' || trim($password) === '') {
        loginJsonResponse(['status' => 'error', 'message' => 'Kullanıcı adı ve şifre zorunludur.']);
    }

    try {
        $pdo = getPDO();
        $yonetici = loginYonetici($pdo, $kullaniciAdi, $password);

        if ($yonetici === null) {
            loginJsonResponse(['status' => 'error', 'message' => 'Kullanıcı adı veya şifre hatalı!']);
        }

        establishYoneticiSession($pdo, $yonetici, $password);
        loginJsonResponse(['status' => 'success']);
    } catch (Throwable $e) {
        error_log('Yonetici giris hatasi: ' . $e->getMessage());
        loginJsonResponse(['status' => 'error', 'message' => 'Giriş işlemi sırasında bir hata oluştu.'], 500);
    }
}
