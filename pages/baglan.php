<?php
if (!headers_sent()) {
    header("Content-Type: text/html; charset=utf-8");
}
mb_internal_encoding("UTF-8");

$host     = "localhost";
$db_name  = "personel_db";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $username, $password, [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_general_ci",
    ]);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db_name` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
    $db = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8mb4", $username, $password, [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_general_ci",
    ]);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec("SET NAMES utf8mb4 COLLATE utf8mb4_general_ci");
    $db->exec("SET CHARACTER SET utf8mb4");
    // dbEnsureSchema($db); // GEÇİCİ OLARAK KAPATILDI: her sayfa yüklemesinde
    // db/personel_db.sql'i tekrar import edip etkinlikler/sizden_gelenler
    // tablolarındaki güncel verileri eski demo veriyle eziyordu.
} catch (PDOException $e) {
    die("Veritabanı bağlantı hatası: " . $e->getMessage());
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Anasayfa linkleri tablosu: yoksa oluştur + ilk kurulumda doldur
dbEnsureAnasayfaLinkler($db);
// Kalıcı oturum (remember-me) alanları: yoksa ekle
dbEnsurePersonellerRememberMe($db);
// Oturum kayıtları tablosu: yoksa oluştur
dbEnsureOturumKayitlari($db);
// İçerik izlenme takibi (hesap/ziyaretçi başına 1)
dbEnsureIcerikIzlemeleri($db);
// İlişkisel yapı + unique/index/fk sağlamlaştırma
dbEnsureRelationalConstraints($db);

function dbFetchAll(PDO $db, string $sql, array $params = []): array
{
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function imgUrl(?string $path, string $fallback = "../images/logo(2).png"): string
{
    $path = trim((string)$path);
    if ($path !== "" && imageFileExists($path)) {
        return normalizeImagePath($path);
    }
    if ($fallback !== "" && imageFileExists($fallback)) {
        return normalizeImagePath($fallback);
    }
    return "../images/logo(2).png";
}

function documentThumbUrl(array $row): ?string
{
    $url = trim((string)($row["resim_url"] ?? ""));
    if ($url !== "" && imageFileExists($url)) {
        return normalizeImagePath($url);
    }
    return null;
}

function documentIconClass(array $row): string
{
    $map = [
        "protocol"   => "fa-handshake",
        "document"   => "fa-file-alt",
        "regulation" => "fa-gavel",
        "training"   => "fa-graduation-cap",
    ];
    return $map[$row["alt_tip"] ?? ""] ?? "fa-file";
}

function yardimciLinkLogoDefaults(): array
{
    return [
        "OMIS"                              => "../images/otomasyon/omis_7572.png",
        "Ulakbel"                           => "../images/otomasyon/ulakbel_5496.png",
        "İmar Yönetim Sistemi"              => "../images/otomasyon/imar-yonetim-sistemi_8038.png",
        "Dijital Arşiv"                     => "../images/otomasyon/dijital-arsiv_415.png",
        "Outlook"                           => "../images/otomasyon/outlook_4005.png",
        "Sosyal Yardım"                     => "../images/otomasyon/sosyal-yardim_3767.png",
        "Netcad"                            => "../images/otomasyon/netcad_3888.png",
        "E-Belediye Sistemi"                => "../images/otomasyon/ebys_8493.png",
        "E-Belediye Evlendrme Modülü"       => "../images/otomasyon/e-belediye-evlendirme-modulu_3993.png",
        "E-Belediye Sosyal Yardım Modülü"   => "../images/otomasyon/e-belediye-sosyal-yard-m-modulu_4432.png",
        "Gebze Belediyesi"                  => "../images/yardimci_linkler/web_siteleri/gebze-belediyesi.png",
        "Kocaeli Büyükşehir Belediyesi"     => "../images/yardimci_linkler/web_siteleri/kocaeli-buyuksehir-belediyesi.png",
        "Kocaeli Valiliği"                  => "../images/yardimci_linkler/web_siteleri/kocaeli-vali.jpg",
        "Gebze Kaymakamlığı"                => "../images/yardimci_linkler/web_siteleri/gebze-kaymakam.png",
        "Türkiye Belediyeler Birliği"       => "../images/yardimci_linkler/bilgi_portallari/turkiye-belediyeler-birligi_2430.png",
        "Cumhurbaşkanlığı Uzaktan Eğitim Kapısı" => "../images/yardimci_linkler/bilgi_portallari/cumhur.jpg",
        "BTK Akademi Eğitim Portalı"        => "../images/yardimci_linkler/bilgi_portallari/btk-akademi.jpg",
        "Memurlar.Net"                      => "../images/yardimci_linkler/faydali_linkler/memurlar.png",
        "İlan"                              => "../images/yardimci_linkler/faydali_linkler/ilan.png",
        "Resmi Gazete"                      => "../images/yardimci_linkler/faydali_linkler/resmi.png",
    ];
}

function yardimciLinkLogo(array $row): ?string
{
    $url = trim((string)($row["logo_url"] ?? ""));
    if ($url !== "" && imageFileExists($url)) {
        return normalizeImagePath($url);
    }

    $baslik = trim((string)($row["baslik"] ?? ""));
    $defaults = yardimciLinkLogoDefaults();
    if ($baslik !== "" && isset($defaults[$baslik]) && imageFileExists($defaults[$baslik])) {
        return $defaults[$baslik];
    }

    return otomasyonLogoUrl($baslik, $url);
}

function otomasyonLogoUrl(string $baslik, ?string $logoUrl = ""): ?string
{
    $logoUrl = trim((string)$logoUrl);
    if ($logoUrl !== "" && imageFileExists($logoUrl)) {
        return normalizeImagePath($logoUrl);
    }

    $defaults = yardimciLinkLogoDefaults();
    if (isset($defaults[$baslik]) && imageFileExists($defaults[$baslik])) {
        return $defaults[$baslik];
    }

    return null;
}

function normalizeImagePath(string $path): string
{
    if (preg_match("#^https?://#i", $path)) {
        return $path;
    }
    if (str_starts_with($path, "../")) {
        return $path;
    }
    if (str_starts_with($path, "images/")) {
        return "../" . $path;
    }
    return "../images/" . ltrim($path, "/");
}

function imageFileExists(string $webPath): bool
{
    if ($webPath === "" || preg_match("#^https?://#i", $webPath)) {
        return true;
    }
    static $root = null;
    if ($root === null) {
        $root = realpath(__DIR__ . "/..") ?: "";
    }
    $rel = preg_replace("#^\.\./#", "", normalizeImagePath($webPath));
    return $root !== "" && is_file($root . "/" . str_replace("\\", "/", $rel));
}

function dbEnsureYardimciLinkLogos(PDO $db): void
{
    static $done = false;
    if ($done) {
        return;
    }
    $done = true;

    try {
        $db->query("SELECT 1 FROM yardimci_linkler LIMIT 1");
    } catch (PDOException $e) {
        return;
    }

    dbEnsureColumn($db, "yardimci_linkler", "logo_url", "VARCHAR(255) DEFAULT NULL");

    $stmt = $db->prepare(
        "UPDATE yardimci_linkler SET logo_url = ? WHERE baslik = ? AND (logo_url IS NULL OR logo_url = '')"
    );

    foreach (yardimciLinkLogoDefaults() as $baslik => $logo) {
        if (!imageFileExists($logo)) {
            continue;
        }
        $stmt->execute([$logo, $baslik]);
    }
}

function dbEnsureAnasayfaLinkler(PDO $db): void
{
    static $done = false;
    if ($done) {
        return;
    }
    $done = true;

    try {
        $db->exec(
            "CREATE TABLE IF NOT EXISTS `anasayfa_linkler` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `baslik` varchar(255) NOT NULL,
                `logo_url` varchar(255) DEFAULT NULL,
                `hedef_url` varchar(500) NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci"
        );

        // Tablo boşsa, eski yapıdan (yardimci_linkler/kurum-ici) otomatik taşı
        $countRow = dbFetchOne($db, "SELECT COUNT(*) AS c FROM anasayfa_linkler");
        $count = (int)($countRow["c"] ?? 0);
        if ($count === 0) {
            try {
                $rows = dbFetchAll(
                    $db,
                    "SELECT baslik, logo_url, hedef_url FROM yardimci_linkler WHERE kategori = ? ORDER BY id",
                    ["kurum-ici"]
                );
                if (!empty($rows)) {
                    $stmt = $db->prepare("INSERT INTO anasayfa_linkler (baslik, logo_url, hedef_url) VALUES (?, ?, ?)");
                    foreach ($rows as $r) {
                        $stmt->execute([
                            $r["baslik"] ?? "",
                            $r["logo_url"] ?? null,
                            $r["hedef_url"] ?? "",
                        ]);
                    }
                }
            } catch (PDOException $e) {
                // Sessizce geç: eski tablo yoksa seed atlama
            }
        }
    } catch (PDOException $e) {
        // Sessizce geç: yetki/engine farkları olabilir
    }
}

function dbEnsurePersonellerRememberMe(PDO $db): void
{
    static $done = false;
    if ($done) {
        return;
    }
    $done = true;

    // Auth kolonları bazı eski dump'larda olmayabiliyor
    dbEnsureColumn($db, "personeller", "sicil_no", "VARCHAR(50) DEFAULT NULL");
    dbEnsureColumn($db, "personeller", "email", "VARCHAR(255) DEFAULT NULL");
    dbEnsureColumn($db, "personeller", "sifre", "VARCHAR(255) DEFAULT NULL");

    dbEnsureColumn($db, "personeller", "remember_token_hash", "VARCHAR(64) DEFAULT NULL");
    dbEnsureColumn($db, "personeller", "remember_token_expires", "DATETIME DEFAULT NULL");
}

function dbEnsureRelationalConstraints(PDO $db): void
{
    static $done = false;
    if ($done) {
        return;
    }
    $done = true;

    // personeller: unique sicil_no/email/remember token
    dbEnsureUniqueIndex($db, "personeller", "uq_personeller_sicil_no", ["sicil_no"]);
    dbEnsureUniqueIndex($db, "personeller", "uq_personeller_email", ["email"]);
    dbEnsureUniqueIndex($db, "personeller", "uq_personeller_remember_token_hash", ["remember_token_hash"]);
    dbEnsureIndex($db, "personeller", "idx_personeller_dogum_tarihi", ["dogum_tarihi"]);

    // yardimci_linkler / anasayfa_linkler: tekrarları engelle
    dbEnsureUniqueIndex($db, "yardimci_linkler", "uq_yardimci_linkler_kat_baslik_url", ["kategori", "baslik", "hedef_url"]);
    dbEnsureUniqueIndex($db, "anasayfa_linkler", "uq_anasayfa_linkler_baslik_url", ["baslik", "hedef_url"]);

    // videolar: youtube_id tekil olmalı
    dbEnsureUniqueIndex($db, "videolar", "uq_videolar_youtube_id", ["youtube_id"]);
    dbEnsureIndex($db, "videolar", "idx_videolar_kategori", ["kategori"]);
    dbEnsureIndex($db, "videolar", "idx_videolar_vitrin", ["vitrin"]);

    // oturum_kayitlari -> personeller FK
    try {
        $db->query("SELECT 1 FROM oturum_kayitlari LIMIT 1");
        $db->query("SELECT 1 FROM personeller LIMIT 1");
        dbEnsureIndex($db, "oturum_kayitlari", "idx_oturum_personel_id", ["personel_id"]);
        dbEnsureForeignKey(
            $db,
            "oturum_kayitlari",
            "fk_oturum_personel",
            ["personel_id"],
            "personeller",
            ["id"],
            "CASCADE",
            "CASCADE"
        );
    } catch (PDOException $e) {
        // tablolar yoksa atla
    }

    // haber_galeri -> haberler FK
    try {
        $db->query("SELECT 1 FROM haber_galeri LIMIT 1");
        $db->query("SELECT 1 FROM haberler LIMIT 1");
        dbEnsureIndex($db, "haber_galeri", "idx_haber_galeri_haber_id", ["haber_id"]);
        dbEnsureForeignKey(
            $db,
            "haber_galeri",
            "fk_haber_galeri_haber",
            ["haber_id"],
            "haberler",
            ["id"],
            "CASCADE",
            "CASCADE"
        );
    } catch (PDOException $e) {
        // tablolar yoksa atla
    }
}

function dbEnsureOturumKayitlari(PDO $db): void
{
    static $done = false;
    if ($done) {
        return;
    }
    $done = true;

    try {
        $db->exec(
            "CREATE TABLE IF NOT EXISTS `oturum_kayitlari` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `personel_id` int(11) NOT NULL,
                `giris_zamani` datetime NOT NULL,
                `cikis_zamani` datetime DEFAULT NULL,
                `ip_adresi` varchar(45) DEFAULT NULL,
                `user_agent` varchar(255) DEFAULT NULL,
                `kapanis_tipi` varchar(20) DEFAULT NULL,
                `son_aktivite` datetime DEFAULT NULL,
                PRIMARY KEY (`id`),
                KEY `idx_oturum_personel_id` (`personel_id`),
                KEY `idx_oturum_acik` (`personel_id`, `cikis_zamani`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci"
        );
    } catch (PDOException $e) {
        // Sessizce geç
    }

    dbEnsureColumn($db, "oturum_kayitlari", "ip_adresi", "VARCHAR(45) DEFAULT NULL");
    dbEnsureColumn($db, "oturum_kayitlari", "user_agent", "VARCHAR(255) DEFAULT NULL");
    dbEnsureColumn($db, "oturum_kayitlari", "kapanis_tipi", "VARCHAR(20) DEFAULT NULL");
    dbEnsureColumn($db, "oturum_kayitlari", "son_aktivite", "DATETIME DEFAULT NULL");
    try {
        dbEnsureIndex($db, "oturum_kayitlari", "idx_oturum_acik", ["personel_id", "cikis_zamani"]);
    } catch (Throwable $e) {
        // Sessizce geç
    }
}

/**
 * Açık oturumu kapatır. tip: manuel | sekme | otomatik | eski
 */
function oturumClose(PDO $db, int $oturumId, string $tip = "manuel"): bool
{
    if ($oturumId <= 0) {
        return false;
    }
    $tip = in_array($tip, ["manuel", "sekme", "otomatik", "eski"], true) ? $tip : "manuel";
    try {
        $stmt = $db->prepare(
            "UPDATE oturum_kayitlari
             SET cikis_zamani = COALESCE(cikis_zamani, NOW()),
                 kapanis_tipi = COALESCE(kapanis_tipi, ?),
                 son_aktivite = COALESCE(son_aktivite, NOW())
             WHERE id = ? AND cikis_zamani IS NULL"
        );
        $stmt->execute([$tip, $oturumId]);
        return $stmt->rowCount() > 0;
    } catch (Throwable $e) {
        return false;
    }
}

/** Personelin diğer açık oturumlarını kapatır (yeni giriş öncesi). */
function oturumCloseOtherOpen(PDO $db, int $personelId, ?int $exceptOturumId = null, string $tip = "otomatik"): void
{
    if ($personelId <= 0) {
        return;
    }
    try {
        if ($exceptOturumId) {
            $stmt = $db->prepare(
                "UPDATE oturum_kayitlari
                 SET cikis_zamani = NOW(), kapanis_tipi = COALESCE(kapanis_tipi, ?)
                 WHERE personel_id = ? AND cikis_zamani IS NULL AND id != ?"
            );
            $stmt->execute([$tip, $personelId, $exceptOturumId]);
        } else {
            $stmt = $db->prepare(
                "UPDATE oturum_kayitlari
                 SET cikis_zamani = NOW(), kapanis_tipi = COALESCE(kapanis_tipi, ?)
                 WHERE personel_id = ? AND cikis_zamani IS NULL"
            );
            $stmt->execute([$tip, $personelId]);
        }
    } catch (Throwable $e) {
        // Sessizce geç
    }
}

/** Yeni oturum satırı oluşturur. */
function oturumStart(PDO $db, int $personelId): int
{
    oturumCloseOtherOpen($db, $personelId, null, "otomatik");
    $ip = substr((string)($_SERVER["REMOTE_ADDR"] ?? ""), 0, 45);
    $ua = substr((string)($_SERVER["HTTP_USER_AGENT"] ?? ""), 0, 255);
    $stmt = $db->prepare(
        "INSERT INTO oturum_kayitlari (personel_id, giris_zamani, ip_adresi, user_agent, son_aktivite)
         VALUES (?, NOW(), ?, ?, NOW())"
    );
    $stmt->execute([$personelId, $ip !== "" ? $ip : null, $ua !== "" ? $ua : null]);
    return (int)$db->lastInsertId();
}

/** Aktif oturumun son aktivite zamanını günceller. */
function oturumTouch(PDO $db, ?int $oturumId): void
{
    if (!$oturumId) {
        return;
    }
    try {
        $db->prepare(
            "UPDATE oturum_kayitlari SET son_aktivite = NOW() WHERE id = ? AND cikis_zamani IS NULL"
        )->execute([$oturumId]);
    } catch (Throwable $e) {
        // Sessizce geç
    }
}

function dbEnsureIcerikIzlemeleri(PDO $db): void
{
    static $done = false;
    if ($done) {
        return;
    }
    $done = true;

    try {
        $db->exec(
            "CREATE TABLE IF NOT EXISTS `icerik_izlemeleri` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `tablo` varchar(64) NOT NULL,
                `kayit_id` int(11) NOT NULL,
                `izleyici` varchar(96) NOT NULL,
                `olusturma_tarihi` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                UNIQUE KEY `uq_icerik_izleme` (`tablo`, `kayit_id`, `izleyici`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci"
        );
    } catch (PDOException $e) {
        // Sessizce geç
    }
}

/**
 * İzleyici kimliği: girişli hesap veya kalıcı misafir çerezi.
 */
function viewViewerKey(): string
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!empty($_SESSION["personel_id"])) {
        return "personel:" . (int)$_SESSION["personel_id"];
    }

    $cookieName = "pp_viewer";
    $token = $_COOKIE[$cookieName] ?? "";
    if (!is_string($token) || !preg_match('/^[a-f0-9]{32}$/', $token)) {
        $token = bin2hex(random_bytes(16));
        setcookie($cookieName, $token, [
            "expires"  => time() + 60 * 60 * 24 * 365,
            "path"     => "/",
            "httponly" => true,
            "samesite" => "Lax",
        ]);
        $_COOKIE[$cookieName] = $token;
    }

    return "guest:" . $token;
}

/**
 * Aynı hesap/ziyaretçi için içeriği yalnızca 1 kez sayar.
 * @return array{count:int,increased:bool}
 */
function dbBumpUniqueView(PDO $db, string $table, int $id, string $column = "view"): array
{
    $allowed = [
        "etkinlikler"          => "view",
        "anasayfa_duyurular"   => "view",
        "duyurular"            => "view",
        "sizden_gelenler"      => "goruntulenme",
        "haberler"             => "view",
    ];

    if (!isset($allowed[$table]) || $id <= 0) {
        return ["count" => 0, "increased" => false];
    }

    $column = $allowed[$table];
    dbEnsureColumn($db, $table, $column, "INT(11) NOT NULL DEFAULT 0");
    dbEnsureIcerikIzlemeleri($db);

    $viewer = viewViewerKey();
    $increased = false;

    try {
        $ins = $db->prepare(
            "INSERT IGNORE INTO icerik_izlemeleri (tablo, kayit_id, izleyici) VALUES (?, ?, ?)"
        );
        $ins->execute([$table, $id, $viewer]);
        if ($ins->rowCount() > 0) {
            $db->prepare(
                "UPDATE `{$table}` SET `{$column}` = COALESCE(`{$column}`, 0) + 1 WHERE id = ?"
            )->execute([$id]);
            $increased = true;
        }
    } catch (Throwable $e) {
        // Fallback: session (tablo yoksa / geçici hata)
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION["content_views"]) || !is_array($_SESSION["content_views"])) {
            $_SESSION["content_views"] = [];
        }
        $key = $table . ":" . $id . ":" . $viewer;
        if (empty($_SESSION["content_views"][$key])) {
            try {
                $db->prepare(
                    "UPDATE `{$table}` SET `{$column}` = COALESCE(`{$column}`, 0) + 1 WHERE id = ?"
                )->execute([$id]);
                $_SESSION["content_views"][$key] = 1;
                $increased = true;
            } catch (Throwable $e2) {
                // geç
            }
        }
    }

    $row = dbFetchOne($db, "SELECT `{$column}` AS c FROM `{$table}` WHERE id = ?", [$id]);
    return [
        "count"     => (int)($row["c"] ?? 0),
        "increased" => $increased,
    ];
}

function dbEnsureIndex(PDO $db, string $table, string $indexName, array $columns): void
{
    try {
        $cols = implode("`, `", $columns);
        $db->exec("ALTER TABLE `{$table}` ADD INDEX `{$indexName}` (`{$cols}`)");
    } catch (PDOException $e) {
        // Sessizce geç (zaten vardır / uyumsuz tablo)
    }
}

function dbEnsureUniqueIndex(PDO $db, string $table, string $indexName, array $columns): void
{
    try {
        $cols = implode("`, `", $columns);
        $db->exec("ALTER TABLE `{$table}` ADD UNIQUE KEY `{$indexName}` (`{$cols}`)");
    } catch (PDOException $e) {
        // Sessizce geç (duplicate data / zaten vardır / uyumsuz tablo)
    }
}

function dbEnsureForeignKey(
    PDO $db,
    string $table,
    string $fkName,
    array $columns,
    string $refTable,
    array $refColumns,
    string $onDelete = "RESTRICT",
    string $onUpdate = "RESTRICT"
): void {
    try {
        $cols = implode("`, `", $columns);
        $refCols = implode("`, `", $refColumns);
        $db->exec(
            "ALTER TABLE `{$table}`
             ADD CONSTRAINT `{$fkName}`
             FOREIGN KEY (`{$cols}`) REFERENCES `{$refTable}` (`{$refCols}`)
             ON DELETE {$onDelete} ON UPDATE {$onUpdate}"
        );
    } catch (PDOException $e) {
        // Sessizce geç (zaten vardır / engine uygun değil / veri uyumsuz)
    }
}

function authRememberCookieName(): string
{
    return "pp_remember";
}

function authIssueRememberToken(PDO $db, int $personelId, int $days = 30): void
{
    try {
        $token = bin2hex(random_bytes(32)); // 64 hex
        $hash = hash("sha256", $token);
        $expiresAt = (new DateTimeImmutable("now"))->modify("+{$days} days")->format("Y-m-d H:i:s");

        $stmt = $db->prepare("UPDATE personeller SET remember_token_hash = ?, remember_token_expires = ? WHERE id = ?");
        $stmt->execute([$hash, $expiresAt, $personelId]);

        $cookieValue = $personelId . ":" . $token;
        setcookie(authRememberCookieName(), $cookieValue, [
            "expires"  => time() + ($days * 86400),
            "path"     => "/",
            "secure"   => false, // XAMPP genelde http
            "httponly" => true,
            "samesite" => "Lax",
        ]);
    } catch (Throwable $e) {
        // Sessizce geç
    }
}

function authClearRememberToken(PDO $db, ?int $personelId = null): void
{
    try {
        if ($personelId !== null) {
            $stmt = $db->prepare("UPDATE personeller SET remember_token_hash = NULL, remember_token_expires = NULL WHERE id = ?");
            $stmt->execute([$personelId]);
        }
    } catch (Throwable $e) {
        // Sessizce geç
    }

    setcookie(authRememberCookieName(), "", [
        "expires"  => time() - 3600,
        "path"     => "/",
        "secure"   => false,
        "httponly" => true,
        "samesite" => "Lax",
    ]);
}

function authTryAutoLogin(PDO $db): bool
{
    if (!empty($_SESSION["personel_id"])) {
        return true;
    }

    $raw = $_COOKIE[authRememberCookieName()] ?? "";
    if (!is_string($raw) || $raw === "" || !str_contains($raw, ":")) {
        return false;
    }

    [$idStr, $token] = explode(":", $raw, 2);
    $personelId = (int)$idStr;
    $token = trim($token);
    if ($personelId <= 0 || $token === "") {
        return false;
    }

    try {
        $hash = hash("sha256", $token);
        $stmt = $db->prepare(
            "SELECT * FROM personeller
             WHERE id = ?
               AND remember_token_hash = ?
               AND (remember_token_expires IS NULL OR remember_token_expires > NOW())
             LIMIT 1"
        );
        $stmt->execute([$personelId, $hash]);
        $personel = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$personel) {
            return false;
        }

        // Session bilgilerini doldur
        $_SESSION['personel_id'] = $personel['id'];
        $_SESSION['sicil_no']     = $personel['sicil_no'];
        $_SESSION['email']        = $personel['email'];
        $_SESSION['fotograf']     = !empty($personel['foto_url']) ? $personel['foto_url'] : '../images/login/login.jpg';
        $_SESSION['ad']           = $personel['ad'];
        $_SESSION['soyad']        = $personel['soyad'];
        if (empty($_SESSION['oturum_id'])) {
            $_SESSION['oturum_id'] = oturumStart($db, (int)$personel['id']);
        }

        return true;
    } catch (Throwable $e) {
        return false;
    }
}

function jsonData(mixed $data): string
{
    return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP);
}

function dbFetchOne(PDO $db, string $sql, array $params = []): ?array
{
    $rows = dbFetchAll($db, $sql, $params);
    return $rows[0] ?? null;
}

function mapEtkinlikler(array $rows): array
{
    return array_map(fn($r) => [
        "id"      => (int)$r["id"],
        "title"   => $r["baslik"],
        "excerpt" => $r["aciklama"] ?? "",
        "date"    => !empty($r["tarih"]) ? date("d.m.Y", strtotime($r["tarih"])) : "",
        "endDate" => !empty($r["bitis_tarihi"] ?? $r["tarih"]) ? date("d.m.Y", strtotime($r["bitis_tarihi"] ?? $r["tarih"])) : "",
        "views"   => (int)($r["view"] ?? 0),
        "status"  => $r["durum"] ?? "aktif",
        "image"   => imgUrl($r["resim"] ?? ""),
    ], $rows);
}

function mapSizdenGelenler(array $rows): array
{
    return array_map(fn($r) => [
        "id"           => (int)$r["id"],
        "title"        => $r["baslik"],
        "excerpt"      => $r["ozet"] ?? "",
        "category"     => $r["kategori_slug"] ?? "",
        "categoryName" => $r["kategori_adi"] ?? "",
        "date"         => !empty($r["tarih"]) ? date("d.m.Y", strtotime($r["tarih"])) : "",
        "views"        => (int)($r["goruntulenme"] ?? 0),
        "image"        => imgUrl($r["gorsel_yolu"] ?? ""),
    ], $rows);
}

function mapPersonelJs(array $rows): array
{
    return array_map(fn($r) => [
        "id"          => (int)$r["id"],
        "ad"          => $r["ad"],
        "soyad"       => $r["soyad"],
        "dogumTarihi" => $r["dogum_tarihi"],
        "fotoUrl"     => imgUrl($r["foto_url"] ?? "", "../images/login/login.jpg"),
    ], $rows);
}

function mapVefat(array $rows): array
{
    return array_map(fn($r) => [
        "name"      => $r["vefat_eden_adi"],
        "position"  => $r["iliski_pozisyon"] ?? "",
        "deathDate" => $r["vefat_tarihi_metin"] ?? "",
        "message"   => $r["cenaze_mesaji"] ?? "",
    ], $rows);
}

function dbTableList(PDO $db): array
{
    static $tables = null;
    if ($tables === null) {
        $tables = $db->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    }
    return $tables;
}

function dbHasAnyTable(PDO $db, array $names): bool
{
    $tables = dbTableList($db);
    foreach ($names as $name) {
        if (in_array($name, $tables, true)) {
            return true;
        }
    }
    return false;
}

function dbAnasayfaDuyurularTable(PDO $db): string
{
    return dbHasAnyTable($db, ["anasayfa_duyurular"]) ? "anasayfa_duyurular" : "duyurular";
}

function normalizeLookupTitle(string $title): string
{
    $title = mb_strtolower(trim($title), "UTF-8");
    $map = [
        "ı" => "i", "İ" => "i", "ş" => "s", "Ş" => "s", "ğ" => "g", "Ğ" => "g",
        "ü" => "u", "Ü" => "u", "ö" => "o", "Ö" => "o", "ç" => "c", "Ç" => "c",
    ];
    $title = strtr($title, $map);
    // Sadece dekoratif / haber üslubu kelimelerini sil; konu kelimelerini koru
    $title = preg_replace(
        '/\b(tamamlandi|kutlandi|gerceklesti|buyuk|ilgi|gordu|unutulmadi|dedik|actik|bizimle|ile|icin|ve|nefes|kesti)\b/u',
        " ",
        $title
    ) ?? $title;
    $title = preg_replace('/[^a-z0-9\s]+/u', " ", $title) ?? $title;
    $title = preg_replace('/\s+/u', " ", trim($title)) ?? trim($title);
    return $title;
}

/**
 * Yalnızca aynı / çok benzer etkinlik varsa eşleştirir.
 * Zayıf benzerlikte null döner → duyuru kendi sayfasında açılır.
 */
function dbResolveAnasayfaDuyuruEtkinlikId(PDO $db, array $duyuru): ?int
{
    static $cache = [];
    $duyuruId = (int)($duyuru["id"] ?? 0);
    if ($duyuruId > 0 && array_key_exists($duyuruId, $cache)) {
        return $cache[$duyuruId];
    }

    $needle = normalizeLookupTitle((string)($duyuru["baslik"] ?? ""));
    if ($needle === "") {
        return $cache[$duyuruId] = null;
    }

    $needleTokens = array_values(array_filter(
        explode(" ", $needle),
        static fn($t) => mb_strlen($t, "UTF-8") >= 3
    ));
    if (count($needleTokens) < 2) {
        return $cache[$duyuruId] = null;
    }

    $etkinlikler = dbFetchAll($db, "SELECT id, baslik FROM etkinlikler");
    $bestId = null;
    $bestScore = 0.0;

    foreach ($etkinlikler as $e) {
        $hay = normalizeLookupTitle((string)($e["baslik"] ?? ""));
        if ($hay === "") {
            continue;
        }

        $hayTokens = array_values(array_filter(
            explode(" ", $hay),
            static fn($t) => mb_strlen($t, "UTF-8") >= 3
        ));
        if (count($hayTokens) < 2) {
            continue;
        }

        if ($needle === $hay) {
            $score = 1.0;
        } elseif (str_contains($hay, $needle) || str_contains($needle, $hay)) {
            // Tam kapsama: kısa başlık diğerinin içinde
            $score = 0.95;
        } else {
            $common = count(array_intersect($needleTokens, $hayTokens));
            // En az 2 ortak anlamlı kelime zorunlu
            if ($common < 2) {
                continue;
            }
            $union = count(array_unique(array_merge($needleTokens, $hayTokens)));
            $score = $union > 0 ? ($common / $union) : 0.0;
            // Ortak kelimelerin needle'ın çoğunluğunu kapsaması
            $coverage = $common / count($needleTokens);
            $score = min($score, $coverage);
        }

        if ($score > $bestScore) {
            $bestScore = $score;
            $bestId = (int)$e["id"];
        }
    }

    // Sadece gerçekten benzer / aynı haberleri kabul et
    if ($bestScore < 0.72) {
        $bestId = null;
    }

    return $cache[$duyuruId] = $bestId;
}

function mapAnasayfaDuyurular(PDO $db, array $rows): array
{
    return array_map(function ($r) use ($db) {
        $etkinlikId = dbResolveAnasayfaDuyuruEtkinlikId($db, $r);
        $r["etkinlik_id"] = $etkinlikId;
        $r["detail_url"] = $etkinlikId
            ? ("etkinlikd.php?id=" . $etkinlikId)
            : ("duyurud.php?id=" . (int)($r["id"] ?? 0));
        return $r;
    }, $rows);
}

function dbEtkinliklerDuyurularTable(PDO $db): string
{
    return dbHasAnyTable($db, ["etkinlikler_duyurular"]) ? "etkinlikler_duyurular" : "dokumanlar";
}

function dbFetchAnasayfaDuyurular(PDO $db): array
{
    $table = dbAnasayfaDuyurularTable($db);
    return dbFetchAll($db, "SELECT * FROM `{$table}` ORDER BY id DESC");
}

function dbFetchEtkinliklerDuyurular(PDO $db): array
{
    if (dbEtkinliklerDuyurularTable($db) === "etkinlikler_duyurular") {
        return dbFetchAll($db, "SELECT * FROM etkinlikler_duyurular ORDER BY id");
    }
    return dbFetchAll($db, "SELECT * FROM dokumanlar WHERE sayfa_tipi = ? ORDER BY id", ["duyuru"]);
}

function dbEnsureSchema(PDO $db): void
{
    static $checked = false;
    if ($checked) {
        return;
    }
    $checked = true;

    $required = [
        "haberler", "etkinlikler", "videolar",
        "sizden_gelenler", "personeller", "vefat_bilgileri",
        "yardimci_linkler", "anketler", "haber_galeri",
    ];

    try {
        $tables = $db->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    } catch (PDOException $e) {
        return;
    }

    foreach ($required as $table) {
        if (!in_array($table, $tables, true)) {
            importPersonelDb();
            return;
        }
    }

    if (!dbHasAnyTable($db, ["anasayfa_duyurular", "duyurular"])) {
        importPersonelDb();
        return;
    }

    if (!dbHasAnyTable($db, ["etkinlikler_duyurular", "dokumanlar"])) {
        importPersonelDb();
        return;
    }

    if (!dbHasAnyTable($db, ["kaynaklar", "dokumanlar"])) {
        importPersonelDb();
        return;
    }

    dbEnsureColumn($db, "anketler", "favori", "TINYINT(1) NOT NULL DEFAULT 0");
    dbEnsureVideoOrder($db);
    dbEnsureYardimciLinkLogos($db);
}

function dbCanonicalVideoYoutubeIds(): array
{
    return [
        "qLqYPQgUPEc",
        "aUQ3uIAfL-k",
        "RhVDYrAb0xQ",
        "c0vbYSFwMzU",
        "-0Wxna6PjqQ",
        "e65zC48s8Wc",
        "YXat3fIWc7w",
        "QRizu8RhGnU",
        "Z2dH2UIXb8Y",
        "G2KNC3OAnjE",
        "RhD1ArYsuKo",
        "IEc5W0JyADU",
        "3ePuzpC2S0Q",
        "qdPXmtKXXc4",
        "uUFZvM9kqf4",
        "BiY2WK24UHY",
        "xot-DBvkkq4",
        "ABIqjRnV5dU",
        "psmlNSPRDsM",
        "pAHStsCd9jo",
        "eUBQYWMZyH8",
        "GWfDmGr6tlg",
        "D1b-CZYtCTg",
    ];
}

function dbReorderVideolarRows(PDO $db, array $rows): void
{
    $db->beginTransaction();
    try {
        $db->exec("DELETE FROM videolar");
        $db->exec("ALTER TABLE videolar AUTO_INCREMENT = 1");

        $stmt = $db->prepare(
            "INSERT INTO videolar (youtube_id, baslik, aciklama, kategori, sure) VALUES (?, ?, ?, ?, ?)"
        );
        foreach ($rows as $row) {
            $stmt->execute([
                $row["youtube_id"],
                $row["baslik"],
                $row["aciklama"],
                $row["kategori"],
                $row["sure"],
            ]);
        }

        $db->commit();
    } catch (Throwable $e) {
        if ($db->inTransaction()) {
            $db->rollBack();
        }
        throw $e;
    }
}

function dbResequenceVideolar(PDO $db): void
{
    $rows = dbFetchAll($db, "SELECT * FROM videolar ORDER BY id ASC");
    if (empty($rows)) {
        $db->exec("ALTER TABLE videolar AUTO_INCREMENT = 1");
        return;
    }

    dbReorderVideolarRows($db, $rows);
}

function dbResequenceVideolarIfNeeded(PDO $db): void
{
    $stats = dbFetchOne(
        $db,
        "SELECT COUNT(*) AS total, COALESCE(MAX(id), 0) AS max_id FROM videolar"
    );
    if (!$stats) {
        return;
    }

    $total = (int)$stats["total"];
    $maxId = (int)$stats["max_id"];

    if ($total > 0 && $total !== $maxId) {
        dbResequenceVideolar($db);
    } elseif ($total === 0) {
        $db->exec("ALTER TABLE videolar AUTO_INCREMENT = 1");
    } else {
        $db->exec("ALTER TABLE videolar AUTO_INCREMENT = " . ($maxId + 1));
    }
}

function dbEnsureVideoOrder(PDO $db): void
{
    static $done = false;
    if ($done) {
        return;
    }
    $done = true;

    try {
        $db->query("SELECT 1 FROM videolar LIMIT 1");
    } catch (PDOException $e) {
        return;
    }

    dbResequenceVideolarIfNeeded($db);

    $rows = dbFetchAll($db, "SELECT * FROM videolar ORDER BY id ASC");
    if (empty($rows)) {
        return;
    }

    $canonical = dbCanonicalVideoYoutubeIds();
    $byYoutube = [];
    foreach ($rows as $row) {
        $byYoutube[$row["youtube_id"]] = $row;
    }

    $extras = [];
    foreach ($rows as $row) {
        if (!in_array($row["youtube_id"], $canonical, true)) {
            $extras[] = $row;
        }
    }

    $expectedIds = array_map(fn($row) => $row["youtube_id"], $extras);
    foreach ($canonical as $youtubeId) {
        if (isset($byYoutube[$youtubeId])) {
            $expectedIds[] = $youtubeId;
        }
    }

    $actualIds = array_map(fn($row) => $row["youtube_id"], $rows);
    if ($actualIds === $expectedIds) {
        return;
    }

    $ordered = [];
    foreach ($extras as $row) {
        $ordered[] = $row;
    }
    foreach ($canonical as $youtubeId) {
        if (isset($byYoutube[$youtubeId])) {
            $ordered[] = $byYoutube[$youtubeId];
        }
    }

    if (empty($ordered)) {
        return;
    }

    try {
        dbReorderVideolarRows($db, $ordered);
    } catch (Throwable $e) {
        // Sessizce geç
    }
}

function dbInsertVideo(PDO $db, array $video): int
{
    $rows = dbFetchAll($db, "SELECT * FROM videolar ORDER BY id ASC");
    array_unshift($rows, [
        "youtube_id" => $video["youtube_id"],
        "baslik"     => $video["baslik"],
        "aciklama"   => $video["aciklama"],
        "kategori"   => $video["kategori"],
        "sure"       => $video["sure"],
    ]);

    dbReorderVideolarRows($db, $rows);
    return 1;
}

function dbDeleteVideo(PDO $db, int $id): bool
{
    $stmt = $db->prepare("DELETE FROM videolar WHERE id = ?");
    $stmt->execute([$id]);
    if ($stmt->rowCount() === 0) {
        return false;
    }

    dbResequenceVideolar($db);
    return true;
}

function dbEnsureColumn(PDO $db, string $table, string $column, string $definition): void
{
    try {
        // MySQL'de LIKE '?' sakıncalı olabilir; INFORMATION_SCHEMA kullan
        $stmt = $db->prepare(
            "SELECT COUNT(*) AS c
             FROM information_schema.COLUMNS
             WHERE TABLE_SCHEMA = DATABASE()
               AND TABLE_NAME = ?
               AND COLUMN_NAME = ?"
        );
        $stmt->execute([$table, $column]);
        $exists = (int)($stmt->fetch(PDO::FETCH_ASSOC)["c"] ?? 0) > 0;
        if (!$exists) {
            $db->exec("ALTER TABLE `{$table}` ADD COLUMN `{$column}` {$definition}");
        }
    } catch (PDOException $e) {
        // Sessizce geç – tablo henüz oluşmamış olabilir
    }
}

function importPersonelDb(): void
{
    $sqlFile = realpath(__DIR__ . "/../db/personel_db.sql");
    $mysql   = "C:/xampp/mysql/bin/mysql.exe";
    if ($sqlFile && file_exists($mysql)) {
        $path = str_replace("\\", "/", $sqlFile);
        shell_exec('"' . $mysql . '" -u root --default-character-set=utf8mb4 -e "SOURCE ' . $path . '" 2>nul');
    }
}
?>