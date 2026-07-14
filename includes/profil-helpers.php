<?php
declare(strict_types=1);

require_once __DIR__ . '/auth-helpers.php';

function profilFlashSet(string $type, string $message): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $_SESSION['profil_flash'] = [
        'type' => $type === 'success' ? 'success' : 'error',
        'message' => $message,
    ];
}

function profilFlashGet(): ?array
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (empty($_SESSION['profil_flash']) || !is_array($_SESSION['profil_flash'])) {
        return null;
    }

    $flash = $_SESSION['profil_flash'];
    unset($_SESSION['profil_flash']);

    $type = ($flash['type'] ?? '') === 'success' ? 'success' : 'error';
    $message = trim((string) ($flash['message'] ?? ''));

    if ($message === '') {
        return null;
    }

    return ['type' => $type, 'message' => $message];
}

function requirePersonelProfil(string $assetBase): void
{
    requireLogin($assetBase);

    if (empty($_SESSION['personel_id'])) {
        header('Location: ' . $assetBase . 'pages/ana_sayfa.php');
        exit;
    }
}

function requireProfilOturum(string $assetBase): void
{
    requireLogin($assetBase);
}

function getPersonelEmail(PDO $pdo, int $personelId): string
{
    $row = dbFetchOne(
        $pdo,
        'SELECT email FROM personeller WHERE id = ? LIMIT 1',
        [$personelId]
    );

    return trim((string) ($row['email'] ?? ''));
}

function updatePersonelEmail(PDO $pdo, int $personelId, string $email): array
{
    $email = trim($email);

    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return ['ok' => false, 'message' => 'Lütfen geçerli bir e-posta adresi girin.'];
    }

    $stmt = $pdo->prepare('UPDATE personeller SET email = ? WHERE id = ?');
    $ok = $stmt->execute([$email, $personelId]);

    if (!$ok) {
        return ['ok' => false, 'message' => 'Güncelleme sırasında bir hata oluştu.'];
    }

    $_SESSION['email'] = $email;

    return ['ok' => true, 'message' => 'E-posta adresiniz başarıyla güncellendi.'];
}

function updatePersonelPassword(PDO $pdo, int $personelId, string $oldPassword, string $newPassword): array
{
    $oldPassword = trim($oldPassword);
    $newPassword = trim($newPassword);

    if ($newPassword === '') {
        return ['ok' => false, 'message' => 'Yeni şifre boş bırakılamaz.'];
    }

    if ($oldPassword === '') {
        return ['ok' => false, 'message' => 'Mevcut şifrenizi giriniz.'];
    }

    $personel = dbFetchOne(
        $pdo,
        'SELECT id FROM personeller WHERE id = ? AND sifre = ? LIMIT 1',
        [$personelId, md5($oldPassword)]
    );

    if ($personel === null) {
        return ['ok' => false, 'message' => 'Mevcut şifreniz hatalı!'];
    }

    $stmt = $pdo->prepare('UPDATE personeller SET sifre = ? WHERE id = ?');
    $ok = $stmt->execute([md5($newPassword), $personelId]);

    if (!$ok) {
        return ['ok' => false, 'message' => 'Güncelleme sırasında bir hata oluştu.'];
    }

    return ['ok' => true, 'message' => 'Şifreniz başarıyla değiştirildi.'];
}

function portalOturumStatusMeta(?string $cikisZamani, ?string $kapanisTipi, int $oturumId, int $aktifOturumId): array
{
    if ($cikisZamani === null || $cikisZamani === '') {
        if ($aktifOturumId > 0 && $oturumId === $aktifOturumId) {
            return [
                'statusLabel' => 'Açık',
                'badgeClass' => 'profil-badge profil-badge--active',
                'closeLabel' => 'Aktif seans',
            ];
        }

        return [
            'statusLabel' => 'Açık (eski)',
            'badgeClass' => 'profil-badge profil-badge--stale',
            'closeLabel' => 'Kapanmamış',
        ];
    }

    $map = [
        'manuel' => 'Manuel çıkış',
        'sekme' => 'Sekme/tarayıcı kapanışı',
        'otomatik' => 'Otomatik kapanış',
        'eski' => 'Eski kayıt temizliği',
        'cikis' => 'Çıkış yapıldı',
    ];

    $closeLabel = $map[$kapanisTipi ?? ''] ?? 'Kapatıldı';

    return [
        'statusLabel' => 'Kapatıldı',
        'badgeClass' => 'profil-badge profil-badge--closed',
        'closeLabel' => $closeLabel,
    ];
}

function loadOturumBilgileri(PDO $pdo): array
{
    $yoneticiModu = !empty($_SESSION['yonetici_id']) && empty($_SESSION['personel_id']);

    if ($yoneticiModu) {
        $oturumId = (int) ($_SESSION['yonetici_oturum_id'] ?? 0);
        portalTouchActiveSession($pdo);

        return [
            'yoneticiModu' => true,
            'aktifOturumId' => $oturumId,
            'cikisUrl' => 'cikis.php',
            'aciklama' => 'Son 15 yönetici oturum kaydı. Site veya sekme kapatıldığında oturum otomatik kapanır.',
            'oturumlar' => dbFetchAll(
                $pdo,
                'SELECT id, giris_zamani, cikis_zamani, kapanis_tipi, ip_adresi, son_aktivite, user_agent
                 FROM yonetici_oturum_kayitlari
                 WHERE yonetici_id = ?
                 ORDER BY id DESC
                 LIMIT 15',
                [(int) $_SESSION['yonetici_id']]
            ),
        ];
    }

    return [
        'yoneticiModu' => false,
        'aktifOturumId' => (int) ($_SESSION['oturum_id'] ?? 0),
        'cikisUrl' => 'cikis.php',
        'aciklama' => 'Son 15 giriş kaydı. Site veya sekme kapatıldığında oturum otomatik kapanır.',
        'oturumlar' => dbFetchAll(
            $pdo,
            'SELECT id, giris_zamani, cikis_zamani, kapanis_tipi, ip_adresi, son_aktivite
             FROM oturum_kayitlari
             WHERE personel_id = ?
             ORDER BY id DESC
             LIMIT 15',
            [(int) $_SESSION['personel_id']]
        ),
    ];
}

function formatProfilDateTime(?string $value): string
{
    if ($value === null || trim($value) === '') {
        return '—';
    }

    $timestamp = strtotime($value);

    if ($timestamp === false) {
        return '—';
    }

    return date('d.m.Y H:i:s', $timestamp);
}
