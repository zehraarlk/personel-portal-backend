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

// Anasayfa linkleri tablosu: yoksa oluştur + ilk kurulumda doldur
dbEnsureAnasayfaLinkler($db);
// Kalıcı oturum (remember-me) alanları: yoksa ekle
dbEnsurePersonellerRememberMe($db);
// Oturum kayıtları tablosu: yoksa oluştur
dbEnsureOturumKayitlari($db);
// İlişkisel yapı + unique/index/fk sağlamlaştırma
dbEnsureRelationalConstraints($db);
// Sizden Gelenler kategori tablosu: yoksa oluştur, eski veriyi taşı, FK bağla
dbEnsureSizdenGelenlerKategori($db);
// Videolar kategori tablosu: yoksa oluştur, eski veriyi taşı, FK bağla
dbEnsureVideolarKategori($db);
// Kaynaklar (Protokoller/Dökümanlar/Mevzuatlar/Eğitimler) kategori tabloları
dbEnsureKaynaklarKategori($db);
// Duyurular kategori tablosu: yoksa oluştur, eski veriyi taşı, FK bağla
dbEnsureDuyurularKategori($db);

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
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci"
        );
    } catch (PDOException $e) {
        // Sessizce geç
    }
}

function dbColumnExists(PDO $db, string $table, string $column): bool
{
    try {
        $stmt = $db->prepare(
            "SELECT COUNT(*) AS c
             FROM information_schema.COLUMNS
             WHERE TABLE_SCHEMA = DATABASE()
               AND TABLE_NAME = ?
               AND COLUMN_NAME = ?"
        );
        $stmt->execute([$table, $column]);
        return (int)($stmt->fetch(PDO::FETCH_ASSOC)["c"] ?? 0) > 0;
    } catch (PDOException $e) {
        return false;
    }
}

/**
 * "Sizden Gelenler" sayfasının kategorilerini ayrı bir tabloya taşır.
 * Tablo adı bilinçli olarak "sizdengelenler_kategori" (sayfaya özel) seçildi;
 * ileride diğer sayfalar için de aynı desenle (ör. "haberler_kategori",
 * "etkinlikler_kategori") ayrı kategori tabloları açılabilir.
 *
 * - Tablo yoksa oluşturur.
 * - sizden_gelenler tablosunda hâlâ eski kategori_slug/kategori_adi kolonları
 *   varsa, buradaki benzersiz kategorileri yeni tabloya aktarır.
 * - sizden_gelenler tablosuna kategori_id kolonu ekler ve eşleştirir.
 * - Foreign key ekler.
 * - Tüm kayıtlar başarıyla eşleştiyse eski redundant kolonları siler.
 */
function dbEnsureSizdenGelenlerKategori(PDO $db): void
{
    static $done = false;
    if ($done) {
        return;
    }
    $done = true;

    try {
        $db->query("SELECT 1 FROM sizden_gelenler LIMIT 1");
    } catch (PDOException $e) {
        return; // sizden_gelenler tablosu henüz yoksa atla
    }

    // 1) Kategori tablosunu oluştur
    try {
        $db->exec(
            "CREATE TABLE IF NOT EXISTS `sizdengelenler_kategori` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `slug` varchar(100) NOT NULL,
                `ad` varchar(150) NOT NULL,
                PRIMARY KEY (`id`),
                UNIQUE KEY `uq_sizdengelenler_kategori_slug` (`slug`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci"
        );
    } catch (PDOException $e) {
        return; // oluşturulamadıysa devam etmenin anlamı yok
    }

    $hasOldSlugColumn = dbColumnExists($db, "sizden_gelenler", "kategori_slug");
    $hasOldAdColumn   = dbColumnExists($db, "sizden_gelenler", "kategori_adi");

    // 2) Eski yapıdaki (serbest metin) kategorileri yeni tabloya aktar
    if ($hasOldSlugColumn && $hasOldAdColumn) {
        try {
            $eskiKategoriler = dbFetchAll(
                $db,
                "SELECT DISTINCT kategori_slug, kategori_adi
                 FROM sizden_gelenler
                 WHERE kategori_slug IS NOT NULL AND kategori_slug <> ''"
            );
            if (!empty($eskiKategoriler)) {
                $stmt = $db->prepare(
                    "INSERT INTO sizdengelenler_kategori (slug, ad) VALUES (?, ?)
                     ON DUPLICATE KEY UPDATE ad = VALUES(ad)"
                );
                foreach ($eskiKategoriler as $k) {
                    $stmt->execute([$k["kategori_slug"], $k["kategori_adi"]]);
                }
            }
        } catch (PDOException $e) {
            // Sessizce geç
        }
    }

    // 3) sizden_gelenler tablosuna kategori_id kolonu ekle
    dbEnsureColumn($db, "sizden_gelenler", "kategori_id", "INT(11) DEFAULT NULL");

    // 4) Eski slug verisinden kategori_id'yi doldur (henüz boş olan satırlar için)
    if ($hasOldSlugColumn) {
        try {
            $db->exec(
                "UPDATE sizden_gelenler sg
                 JOIN sizdengelenler_kategori k ON k.slug = sg.kategori_slug
                 SET sg.kategori_id = k.id
                 WHERE sg.kategori_id IS NULL"
            );
        } catch (PDOException $e) {
            // Sessizce geç
        }
    }

    // 5) Index + Foreign Key
    dbEnsureIndex($db, "sizden_gelenler", "idx_sizden_gelenler_kategori_id", ["kategori_id"]);
    dbEnsureForeignKey(
        $db,
        "sizden_gelenler",
        "fk_sizden_gelenler_kategori",
        ["kategori_id"],
        "sizdengelenler_kategori",
        ["id"],
        "RESTRICT",
        "CASCADE"
    );

    // 6) Tüm satırlar başarıyla eşleştiyse eski redundant kolonları kaldır
    if ($hasOldSlugColumn && $hasOldAdColumn) {
        try {
            $eksik = dbFetchOne($db, "SELECT COUNT(*) AS c FROM sizden_gelenler WHERE kategori_id IS NULL");
            if ((int)($eksik["c"] ?? 1) === 0) {
                $db->exec("ALTER TABLE sizden_gelenler DROP COLUMN kategori_slug, DROP COLUMN kategori_adi");
            }
        } catch (PDOException $e) {
            // Sessizce geç
        }
    }
}

/**
 * Admin panelinde dropdown doldurmak için kategori listesi.
 */
function dbSizdenGelenlerKategoriler(PDO $db): array
{
    try {
        return dbFetchAll($db, "SELECT * FROM sizdengelenler_kategori ORDER BY ad ASC");
    } catch (PDOException $e) {
        return [];
    }
}

/**
 * Bilinen kategori slug'ları için Türkçe görünen ad eşlemesi.
 * Eşlemede olmayan slug'lar için ilk harfi büyütülerek kullanılır.
 */
function dbVideolarKategoriAdiEslemesi(): array
{
    return [
        "etkinlikler" => "Etkinlikler",
        "egitimler"   => "Eğitimler",
        "duyurular"   => "Duyurular",
    ];
}

function dbVideolarKategoriAdi(string $slug): string
{
    $slug = trim($slug);
    $eslesme = dbVideolarKategoriAdiEslemesi();
    if (isset($eslesme[$slug])) {
        return $eslesme[$slug];
    }
    return $slug !== "" ? mb_convert_case($slug, MB_CASE_TITLE, "UTF-8") : $slug;
}

/**
 * "Videolar" sayfasının kategorilerini ayrı bir tabloya taşır (videolar_kategori).
 *
 * NOT: sizden_gelenler'den farklı olarak buradaki eski "kategori" metin kolonu
 * KALDIRILMIYOR; çünkü dbReorderVideolarRows/dbInsertVideo gibi fonksiyonlar bu
 * kolonu doğrudan kullanıyor (video ekleme/silme/sıralama admin tarafında hâlâ
 * "kategori" metnini gönderiyor). Bu yüzden "kategori" metin kolonu ile yeni
 * "kategori_id" foreign key kolonu birlikte, senkron şekilde tutulur.
 */
function dbEnsureVideolarKategori(PDO $db): void
{
    static $done = false;
    if ($done) {
        return;
    }
    $done = true;

    try {
        $db->query("SELECT 1 FROM videolar LIMIT 1");
    } catch (PDOException $e) {
        return; // videolar tablosu henüz yoksa atla
    }

    // 1) Kategori tablosunu oluştur
    try {
        $db->exec(
            "CREATE TABLE IF NOT EXISTS `videolar_kategori` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `slug` varchar(100) NOT NULL,
                `ad` varchar(150) NOT NULL,
                PRIMARY KEY (`id`),
                UNIQUE KEY `uq_videolar_kategori_slug` (`slug`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci"
        );
    } catch (PDOException $e) {
        return;
    }

    // 2) Mevcut "kategori" metin değerlerini yeni tabloya aktar
    if (dbColumnExists($db, "videolar", "kategori")) {
        try {
            $mevcutKategoriler = dbFetchAll(
                $db,
                "SELECT DISTINCT kategori FROM videolar WHERE kategori IS NOT NULL AND kategori <> ''"
            );
            if (!empty($mevcutKategoriler)) {
                $stmt = $db->prepare(
                    "INSERT INTO videolar_kategori (slug, ad) VALUES (?, ?)
                     ON DUPLICATE KEY UPDATE ad = VALUES(ad)"
                );
                foreach ($mevcutKategoriler as $k) {
                    $slug = $k["kategori"];
                    $stmt->execute([$slug, dbVideolarKategoriAdi($slug)]);
                }
            }
        } catch (PDOException $e) {
            // Sessizce geç
        }
    }

    // 3) videolar tablosuna kategori_id kolonu ekle
    dbEnsureColumn($db, "videolar", "kategori_id", "INT(11) DEFAULT NULL");

    // 4) Mevcut kategori metnine göre kategori_id'yi doldur
    try {
        $db->exec(
            "UPDATE videolar v
             JOIN videolar_kategori k ON k.slug = v.kategori
             SET v.kategori_id = k.id
             WHERE v.kategori_id IS NULL"
        );
    } catch (PDOException $e) {
        // Sessizce geç
    }

    // 5) Index + Foreign Key
    dbEnsureIndex($db, "videolar", "idx_videolar_kategori_id", ["kategori_id"]);
    dbEnsureForeignKey(
        $db,
        "videolar",
        "fk_videolar_kategori",
        ["kategori_id"],
        "videolar_kategori",
        ["id"],
        "RESTRICT",
        "CASCADE"
    );

    // Not: "kategori" metin kolonu bilinçli olarak silinmiyor (yukarıdaki not).
}

/**
 * Verilen kategori metnine (slug) karşılık gelen id'yi döndürür.
 * Tabloda yoksa otomatik olarak oluşturur (admin panelinden yeni bir
 * kategori adıyla video eklendiğinde koleksiyonun kopmaması için).
 */
function dbVideolarKategoriId(PDO $db, string $slug): ?int
{
    $slug = trim($slug);
    if ($slug === "") {
        return null;
    }

    try {
        $row = dbFetchOne($db, "SELECT id FROM videolar_kategori WHERE slug = ?", [$slug]);
        if ($row) {
            return (int)$row["id"];
        }

        $stmt = $db->prepare(
            "INSERT INTO videolar_kategori (slug, ad) VALUES (?, ?)
             ON DUPLICATE KEY UPDATE ad = VALUES(ad)"
        );
        $stmt->execute([$slug, dbVideolarKategoriAdi($slug)]);

        $row = dbFetchOne($db, "SELECT id FROM videolar_kategori WHERE slug = ?", [$slug]);
        return $row ? (int)$row["id"] : null;
    } catch (PDOException $e) {
        return null;
    }
}

/**
 * Admin panelinde dropdown doldurmak için kategori listesi.
 */
function dbVideolarKategoriler(PDO $db): array
{
    try {
        return dbFetchAll($db, "SELECT * FROM videolar_kategori ORDER BY ad ASC");
    } catch (PDOException $e) {
        return [];
    }
}

/**
 * Mevzuatlar sayfasındaki alt kategori slug -> görünen ad eşlemesi.
 * (Daha önce mevzuat.php içindeki $altKategoriMap dizisiyle aynı.)
 */
function dbKaynaklarAltKategoriAdiEslemesi(): array
{
    return [
        "genel"      => "Genel Mevzuatlar",
        "memur"      => "Memur Mevzuatları",
        "sozlesmeli" => "Sözleşmeli Memur Mevzuatları",
        "isci"       => "İşçi Mevzuatları",
    ];
}

/**
 * "kaynaklar" tablosu Protokoller/Dökümanlar/Mevzuatlar/Eğitimler sayfalarının
 * hepsi tarafından ortak kullanılıyor (kategori = 'Dökümanlar' gibi filtrelerle).
 * Bu fonksiyon:
 *  - kaynaklar_kategori tablosunu oluşturur (4 bilinen ana kategori her zaman
 *    hazır bulunur: Protokoller, Dökümanlar, Mevzuatlar, Eğitimler)
 *  - kaynaklar.kategori_id kolonunu ekler, mevcut "kategori" metnine göre doldurur, FK bağlar
 *  - Mevzuatlar'a özel alt kategoriler için kaynaklar_alt_kategori tablosunu oluşturur
 *    (genel/memur/sozlesmeli/isci, kaynaklar_kategori.id üzerinden Mevzuatlar'a bağlı)
 *  - kaynaklar.alt_kategori_id kolonunu ekler, mevcut "alt_kategori" metnine göre doldurur, FK bağlar
 *  - Tüm satırlar başarıyla eşleştiyse eski "kategori"/"alt_kategori" metin kolonlarını kaldırır
 */
function dbEnsureKaynaklarKategori(PDO $db): void
{
    static $done = false;
    if ($done) {
        return;
    }
    $done = true;

    try {
        $db->query("SELECT 1 FROM kaynaklar LIMIT 1");
    } catch (PDOException $e) {
        return; // kaynaklar tablosu henüz yoksa atla
    }

    // 1) Ana kategori tablosu
    try {
        $db->exec(
            "CREATE TABLE IF NOT EXISTS `kaynaklar_kategori` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `slug` varchar(100) NOT NULL,
                `ad` varchar(150) NOT NULL,
                PRIMARY KEY (`id`),
                UNIQUE KEY `uq_kaynaklar_kategori_slug` (`slug`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci"
        );
    } catch (PDOException $e) {
        return;
    }

    // Bilinen 4 ana kategori her zaman bulunsun (veri henüz olmasa bile dropdown dolu olsun)
    try {
        $stmt = $db->prepare(
            "INSERT INTO kaynaklar_kategori (slug, ad) VALUES (?, ?)
             ON DUPLICATE KEY UPDATE ad = VALUES(ad)"
        );
        foreach (["Protokoller", "Dökümanlar", "Mevzuatlar", "Eğitimler"] as $ad) {
            $stmt->execute([$ad, $ad]);
        }
    } catch (PDOException $e) {
        // Sessizce geç
    }

    $hasKategoriColumn = dbColumnExists($db, "kaynaklar", "kategori");

    // Veride varsa bilinmeyen/ekstra kategorileri de taşı
    if ($hasKategoriColumn) {
        try {
            $mevcut = dbFetchAll(
                $db,
                "SELECT DISTINCT kategori FROM kaynaklar WHERE kategori IS NOT NULL AND kategori <> ''"
            );
            if (!empty($mevcut)) {
                $stmt = $db->prepare(
                    "INSERT INTO kaynaklar_kategori (slug, ad) VALUES (?, ?)
                     ON DUPLICATE KEY UPDATE ad = VALUES(ad)"
                );
                foreach ($mevcut as $k) {
                    $stmt->execute([$k["kategori"], $k["kategori"]]);
                }
            }
        } catch (PDOException $e) {
            // Sessizce geç
        }
    }

    // 2) kaynaklar.kategori_id kolonu
    dbEnsureColumn($db, "kaynaklar", "kategori_id", "INT(11) DEFAULT NULL");

    if ($hasKategoriColumn) {
        try {
            $db->exec(
                "UPDATE kaynaklar r
                 JOIN kaynaklar_kategori k ON k.slug = r.kategori
                 SET r.kategori_id = k.id
                 WHERE r.kategori_id IS NULL"
            );
        } catch (PDOException $e) {
            // Sessizce geç
        }
    }

    dbEnsureIndex($db, "kaynaklar", "idx_kaynaklar_kategori_id", ["kategori_id"]);
    dbEnsureForeignKey(
        $db,
        "kaynaklar",
        "fk_kaynaklar_kategori",
        ["kategori_id"],
        "kaynaklar_kategori",
        ["id"],
        "RESTRICT",
        "CASCADE"
    );

    // 3) Mevzuatlar'a özel alt kategori tablosu
    try {
        $db->exec(
            "CREATE TABLE IF NOT EXISTS `kaynaklar_alt_kategori` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `kaynak_kategori_id` int(11) NOT NULL,
                `slug` varchar(100) NOT NULL,
                `ad` varchar(150) NOT NULL,
                PRIMARY KEY (`id`),
                UNIQUE KEY `uq_kaynaklar_alt_kategori` (`kaynak_kategori_id`, `slug`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci"
        );
        dbEnsureForeignKey(
            $db,
            "kaynaklar_alt_kategori",
            "fk_kaynaklar_alt_kategori_ust",
            ["kaynak_kategori_id"],
            "kaynaklar_kategori",
            ["id"],
            "CASCADE",
            "CASCADE"
        );
    } catch (PDOException $e) {
        return;
    }

    $mevzuatlarRow = dbFetchOne($db, "SELECT id FROM kaynaklar_kategori WHERE slug = ?", ["Mevzuatlar"]);
    $mevzuatlarId = $mevzuatlarRow ? (int)$mevzuatlarRow["id"] : null;

    if ($mevzuatlarId !== null) {
        // Bilinen 4 alt kategori her zaman bulunsun
        try {
            $stmt = $db->prepare(
                "INSERT INTO kaynaklar_alt_kategori (kaynak_kategori_id, slug, ad) VALUES (?, ?, ?)
                 ON DUPLICATE KEY UPDATE ad = VALUES(ad)"
            );
            foreach (dbKaynaklarAltKategoriAdiEslemesi() as $slug => $ad) {
                $stmt->execute([$mevzuatlarId, $slug, $ad]);
            }
        } catch (PDOException $e) {
            // Sessizce geç
        }

        $hasAltKategoriColumn = dbColumnExists($db, "kaynaklar", "alt_kategori");

        if ($hasAltKategoriColumn) {
            try {
                $mevcutAlt = dbFetchAll(
                    $db,
                    "SELECT DISTINCT alt_kategori FROM kaynaklar
                     WHERE alt_kategori IS NOT NULL AND alt_kategori <> ''"
                );
                if (!empty($mevcutAlt)) {
                    $eslesme = dbKaynaklarAltKategoriAdiEslemesi();
                    $stmt = $db->prepare(
                        "INSERT INTO kaynaklar_alt_kategori (kaynak_kategori_id, slug, ad) VALUES (?, ?, ?)
                         ON DUPLICATE KEY UPDATE ad = VALUES(ad)"
                    );
                    foreach ($mevcutAlt as $a) {
                        $slug = $a["alt_kategori"];
                        $ad = $eslesme[$slug] ?? mb_convert_case($slug, MB_CASE_TITLE, "UTF-8");
                        $stmt->execute([$mevzuatlarId, $slug, $ad]);
                    }
                }
            } catch (PDOException $e) {
                // Sessizce geç
            }
        }

        // 4) kaynaklar.alt_kategori_id kolonu
        dbEnsureColumn($db, "kaynaklar", "alt_kategori_id", "INT(11) DEFAULT NULL");

        if ($hasAltKategoriColumn) {
            try {
                $stmt = $db->prepare(
                    "UPDATE kaynaklar r
                     JOIN kaynaklar_alt_kategori ak
                       ON ak.slug = r.alt_kategori AND ak.kaynak_kategori_id = ?
                     SET r.alt_kategori_id = ak.id
                     WHERE r.alt_kategori_id IS NULL AND r.kategori_id = ?"
                );
                $stmt->execute([$mevzuatlarId, $mevzuatlarId]);
            } catch (PDOException $e) {
                // Sessizce geç
            }
        }

        dbEnsureIndex($db, "kaynaklar", "idx_kaynaklar_alt_kategori_id", ["alt_kategori_id"]);
        dbEnsureForeignKey(
            $db,
            "kaynaklar",
            "fk_kaynaklar_alt_kategori",
            ["alt_kategori_id"],
            "kaynaklar_alt_kategori",
            ["id"],
            "RESTRICT",
            "CASCADE"
        );
    }

    // 5) Tüm satırlar başarıyla eşleştiyse eski redundant kolonları kaldır
    if ($hasKategoriColumn) {
        try {
            $eksikKategoriRow = dbFetchOne($db, "SELECT COUNT(*) AS c FROM kaynaklar WHERE kategori_id IS NULL");
            $eksikKategori = (int)($eksikKategoriRow["c"] ?? 1);

            $eksikAlt = 0;
            $hasAltKategoriColumn = dbColumnExists($db, "kaynaklar", "alt_kategori");
            if ($hasAltKategoriColumn) {
                $eksikAltRow = dbFetchOne(
                    $db,
                    "SELECT COUNT(*) AS c FROM kaynaklar
                     WHERE alt_kategori IS NOT NULL AND alt_kategori <> '' AND alt_kategori_id IS NULL"
                );
                $eksikAlt = (int)($eksikAltRow["c"] ?? 1);
            }

            if ($eksikKategori === 0 && $eksikAlt === 0) {
                if ($hasAltKategoriColumn) {
                    $db->exec("ALTER TABLE kaynaklar DROP COLUMN kategori, DROP COLUMN alt_kategori");
                } else {
                    $db->exec("ALTER TABLE kaynaklar DROP COLUMN kategori");
                }
            }
        } catch (PDOException $e) {
            // Sessizce geç
        }
    }
}

/**
 * Admin panelinde ana kategori dropdown'ı için liste.
 */
function dbKaynaklarKategoriler(PDO $db): array
{
    try {
        return dbFetchAll($db, "SELECT * FROM kaynaklar_kategori ORDER BY ad ASC");
    } catch (PDOException $e) {
        return [];
    }
}

/**
 * Admin panelinde alt kategori dropdown'ı için liste (ör. Mevzuatlar seçilince).
 */
function dbKaynaklarAltKategoriler(PDO $db, int $kategoriId): array
{
    try {
        return dbFetchAll(
            $db,
            "SELECT * FROM kaynaklar_alt_kategori WHERE kaynak_kategori_id = ? ORDER BY ad ASC",
            [$kategoriId]
        );
    } catch (PDOException $e) {
        return [];
    }
}

/**
 * Duyurular sayfasının (etkinlikler_duyurular / eski dokumanlar tablosu)
 * kategorilerini ayrı bir tabloya taşır: "duyurular_kategori".
 *
 * Diğer sayfalardan (Sizden Gelenler) farkı: kaynak tablo "dokumanlar" ise
 * birden fazla sayfa tipi (duyuru, protokol, döküman, mevzuat, eğitim) aynı
 * tabloyu paylaşıyor olabilir. Bu yüzden:
 *  - Eski "alt_tip" (insan/bilgi gibi filtre değeri) ve "kategori_adi" (görünen ad)
 *    metin kolonları KALDIRILMIYOR; sadece yeni "kategori_id" foreign key kolonu
 *    eklenip senkron tutuluyor (Videolar sayfasındaki yaklaşımın aynısı).
 *  - Taşıma/eşleştirme sorguları, tablo "dokumanlar" ise sadece
 *    sayfa_tipi = 'duyuru' olan satırlarla sınırlandırılıyor; böylece diğer
 *    sayfa tiplerinin verisi etkilenmiyor.
 */
function dbEnsureDuyurularKategori(PDO $db): void
{
    static $done = false;
    if ($done) {
        return;
    }
    $done = true;

    $table = dbEtkinliklerDuyurularTable($db);

    try {
        $db->query("SELECT 1 FROM `{$table}` LIMIT 1");
    } catch (PDOException $e) {
        return; // tablo henüz yoksa atla
    }

    $hasAltTip      = dbColumnExists($db, $table, "alt_tip");
    $hasKategoriAdi = dbColumnExists($db, $table, "kategori_adi");
    if (!$hasAltTip || !$hasKategoriAdi) {
        return; // beklenen kolonlar yoksa taşınacak bir şey yok
    }

    $isDokumanlar = ($table === "dokumanlar");
    $hasSayfaTipi = $isDokumanlar && dbColumnExists($db, $table, "sayfa_tipi");

    // 1) Kategori tablosunu oluştur
    try {
        $db->exec(
            "CREATE TABLE IF NOT EXISTS `duyurular_kategori` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `slug` varchar(100) NOT NULL,
                `ad` varchar(150) NOT NULL,
                PRIMARY KEY (`id`),
                UNIQUE KEY `uq_duyurular_kategori_slug` (`slug`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci"
        );
    } catch (PDOException $e) {
        return;
    }

    // 2) Mevcut alt_tip/kategori_adi değerlerini yeni tabloya aktar
    try {
        $sql = "SELECT DISTINCT alt_tip, kategori_adi FROM `{$table}`
                WHERE alt_tip IS NOT NULL AND alt_tip <> ''";
        $params = [];
        if ($hasSayfaTipi) {
            $sql .= " AND sayfa_tipi = ?";
            $params[] = "duyuru";
        }
        $mevcutKategoriler = dbFetchAll($db, $sql, $params);
        if (!empty($mevcutKategoriler)) {
            $stmt = $db->prepare(
                "INSERT INTO duyurular_kategori (slug, ad) VALUES (?, ?)
                 ON DUPLICATE KEY UPDATE ad = VALUES(ad)"
            );
            foreach ($mevcutKategoriler as $k) {
                $slug = $k["alt_tip"];
                $ad   = ($k["kategori_adi"] ?? "") !== ""
                    ? $k["kategori_adi"]
                    : mb_convert_case($slug, MB_CASE_TITLE, "UTF-8");
                $stmt->execute([$slug, $ad]);
            }
        }
    } catch (PDOException $e) {
        // Sessizce geç
    }

    // 3) Tabloya kategori_id kolonu ekle
    dbEnsureColumn($db, $table, "kategori_id", "INT(11) DEFAULT NULL");

    // 4) Mevcut alt_tip değerine göre kategori_id'yi doldur
    try {
        $sql = "UPDATE `{$table}` t
                JOIN duyurular_kategori k ON k.slug = t.alt_tip
                SET t.kategori_id = k.id
                WHERE t.kategori_id IS NULL";
        if ($hasSayfaTipi) {
            $sql .= " AND t.sayfa_tipi = 'duyuru'";
        }
        $db->exec($sql);
    } catch (PDOException $e) {
        // Sessizce geç
    }

    // 5) Index + Foreign Key
    dbEnsureIndex($db, $table, "idx_{$table}_kategori_id", ["kategori_id"]);
    dbEnsureForeignKey(
        $db,
        $table,
        "fk_{$table}_duyurular_kategori",
        ["kategori_id"],
        "duyurular_kategori",
        ["id"],
        "RESTRICT",
        "CASCADE"
    );

    // 6) Sadece "etkinlikler_duyurular" tablosunda: bu tablo yalnızca duyurulara
    //    özel olduğu için (dokumanlar gibi başka sayfa tipleriyle paylaşılmıyor),
    //    tüm satırlar başarıyla eşleştiyse eski redundant kolonları kaldır.
    //    "dokumanlar" tablosuna bilinçli olarak dokunulmuyor; o tablo Protokoller/
    //    Dökümanlar/Mevzuatlar/Eğitimler sayfalarıyla da paylaşımlı olabilir.
    if ($table === "etkinlikler_duyurular") {
        try {
            $eksik = dbFetchOne($db, "SELECT COUNT(*) AS c FROM `{$table}` WHERE kategori_id IS NULL");
            if ((int)($eksik["c"] ?? 1) === 0) {
                $db->exec("ALTER TABLE `{$table}` DROP COLUMN alt_tip, DROP COLUMN kategori_adi");
            }
        } catch (PDOException $e) {
            // Sessizce geç
        }
    }
}

/**
 * Verilen slug'a (alt_tip) karşılık gelen kategori id'sini döndürür.
 * Tabloda yoksa otomatik oluşturur (admin panelinden yeni bir kategoriyle
 * duyuru eklendiğinde koleksiyonun kopmaması için).
 */
function dbDuyurularKategoriId(PDO $db, string $slug, ?string $ad = null): ?int
{
    $slug = trim($slug);
    if ($slug === "") {
        return null;
    }

    try {
        $row = dbFetchOne($db, "SELECT id FROM duyurular_kategori WHERE slug = ?", [$slug]);
        if ($row) {
            return (int)$row["id"];
        }

        $adDeger = $ad !== null && $ad !== "" ? $ad : mb_convert_case($slug, MB_CASE_TITLE, "UTF-8");
        $stmt = $db->prepare(
            "INSERT INTO duyurular_kategori (slug, ad) VALUES (?, ?)
             ON DUPLICATE KEY UPDATE ad = VALUES(ad)"
        );
        $stmt->execute([$slug, $adDeger]);

        $row = dbFetchOne($db, "SELECT id FROM duyurular_kategori WHERE slug = ?", [$slug]);
        return $row ? (int)$row["id"] : null;
    } catch (PDOException $e) {
        return null;
    }
}

/**
 * Admin panelinde dropdown doldurmak için kategori listesi.
 */
function dbDuyurularKategoriler(PDO $db): array
{
    try {
        return dbFetchAll($db, "SELECT * FROM duyurular_kategori ORDER BY ad ASC");
    } catch (PDOException $e) {
        return [];
    }
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
        // dbEnsureDuyurularKategori() eski satırlar tamamen eşleştiyse
        // "alt_tip"/"kategori_adi" kolonlarını silmiş olabilir. Bu durumda
        // kategori_id üzerinden JOIN ile aynı isimlerle geri kazandırıyoruz,
        // böylece duyuru.php gibi tüketici sayfalar değişiklik yapmadan çalışır.
        if (dbColumnExists($db, "etkinlikler_duyurular", "alt_tip")) {
            return dbFetchAll($db, "SELECT * FROM etkinlikler_duyurular ORDER BY id");
        }
        return dbFetchAll(
            $db,
            "SELECT t.*, k.slug AS alt_tip, k.ad AS kategori_adi
             FROM etkinlikler_duyurular t
             LEFT JOIN duyurular_kategori k ON k.id = t.kategori_id
             ORDER BY t.id"
        );
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

        $hasKategoriId = dbColumnExists($db, "videolar", "kategori_id");

        $stmt = $hasKategoriId
            ? $db->prepare(
                "INSERT INTO videolar (youtube_id, baslik, aciklama, kategori, kategori_id, sure) VALUES (?, ?, ?, ?, ?, ?)"
              )
            : $db->prepare(
                "INSERT INTO videolar (youtube_id, baslik, aciklama, kategori, sure) VALUES (?, ?, ?, ?, ?)"
              );

        foreach ($rows as $row) {
            $params = [
                $row["youtube_id"],
                $row["baslik"],
                $row["aciklama"],
                $row["kategori"],
            ];
            if ($hasKategoriId) {
                $params[] = dbVideolarKategoriId($db, $row["kategori"] ?? "");
            }
            $params[] = $row["sure"];
            $stmt->execute($params);
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