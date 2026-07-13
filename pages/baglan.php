<?php
if (!headers_sent()) {
  header("Content-Type: text/html; charset=utf-8");
}
mb_internal_encoding("UTF-8");

$host = "localhost";
$db_name = "personel_db";
$username = "root";
$password = "";

try {
  $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $username, $password, [
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_general_ci",
  ]);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $pdo->exec(
    "CREATE DATABASE IF NOT EXISTS `$db_name` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci",
  );
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
// Sizden Gelenler kategori tablosu: yoksa oluştur, eski veriyi taşı, FK bağla
dbEnsureSizdenGelenlerKategori($db);
// Videolar kategori tablosu: yoksa oluştur, eski veriyi taşı, FK bağla
dbEnsureVideolarKategori($db);
// Videolar vitrin (haftanın videosu) kolonları
dbEnsureVideolarVitrin($db);
// Kaynaklar (Protokoller/Dökümanlar/Mevzuatlar/Eğitimler) kategori tabloları
dbEnsureKaynaklarKategori($db);
// Duyurular kategori tablosu: yoksa oluştur, eski veriyi taşı, FK bağla
dbEnsureDuyurularKategori($db);
// Anketler kategori (durum) tablosu: yoksa oluştur, eski veriyi taşı, FK bağla
dbEnsureAnketlerKategori($db);
// Yardımcı Linkler kategori tablosu: yoksa oluştur, eski veriyi taşı, FK bağla
dbEnsureYardimciLinklerKategori($db);
// Etkinlikler durum kolonu (aktif/pasif): yoksa ekle
dbEnsureEtkinliklerDurum($db);
// Yönetici tablosu ve varsayılan admin hesabı
dbEnsureYoneticiler($db);

function dbFetchAll(PDO $db, string $sql, array $params = []): array
{
  $stmt = $db->prepare($sql);
  $stmt->execute($params);
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function youtubeExtractVideoId(string $value): ?string
{
  $value = trim($value);
  if ($value === "") {
    return null;
  }
  // Already an ID?
  if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $value)) {
    return $value;
  }
  // Common URL shapes: youtube.com/watch?v=, youtu.be/, embed/
  if (
    preg_match(
      "~(?:youtube\.com/(?:watch\?.*v=|embed/|shorts/)|youtu\.be/)([a-zA-Z0-9_-]{11})~i",
      $value,
      $m,
    )
  ) {
    return $m[1];
  }
  return null;
}

function youtubeFormatDuration(int $seconds): string
{
  $seconds = max(0, $seconds);
  $h = intdiv($seconds, 3600);
  $m = intdiv($seconds % 3600, 60);
  $s = $seconds % 60;
  if ($h > 0) {
    return sprintf("%d:%02d:%02d", $h, $m, $s);
  }
  return sprintf("%02d:%02d", $m, $s);
}

function httpFetchText(string $url, int $timeoutSeconds = 8): ?string
{
  // Prefer cURL if available
  if (function_exists("curl_init")) {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_MAXREDIRS => 3,
      CURLOPT_CONNECTTIMEOUT => $timeoutSeconds,
      CURLOPT_TIMEOUT => $timeoutSeconds,
      CURLOPT_SSL_VERIFYPEER => true,
      CURLOPT_HTTPHEADER => ["User-Agent: Mozilla/5.0", "Accept-Language: tr-TR,tr;q=0.9,en;q=0.8"],
    ]);
    $body = curl_exec($ch);
    $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if (!is_string($body) || $body === "" || $status < 200 || $status >= 300) {
      return null;
    }
    return $body;
  }

  // Fallback: allow_url_fopen
  $ctx = stream_context_create([
    "http" => [
      "method" => "GET",
      "timeout" => $timeoutSeconds,
      "header" => "User-Agent: Mozilla/5.0\r\nAccept-Language: tr-TR,tr;q=0.9,en;q=0.8\r\n",
    ],
  ]);
  $body = @file_get_contents($url, false, $ctx);
  if (!is_string($body) || $body === "") {
    return null;
  }
  return $body;
}

function youtubeFetchWatchPageHtml(string $youtubeId): ?string
{
  $youtubeId = trim($youtubeId);
  if (!preg_match('/^[a-zA-Z0-9_-]{11}$/', $youtubeId)) {
    return null;
  }

  $html = httpFetchText("https://www.youtube.com/watch?v=" . rawurlencode($youtubeId));
  return is_string($html) && $html !== "" ? $html : null;
}

function youtubeParseVideoMetadata(string $html): array
{
  $meta = [
    "title" => null,
    "description" => null,
    "duration_seconds" => null,
  ];

  if (preg_match('/<meta\s+property="og:title"\s+content="([^"]*)"/i', $html, $m)) {
    $meta["title"] = trim(html_entity_decode($m[1], ENT_QUOTES | ENT_HTML5, "UTF-8"));
  } elseif (preg_match('/<meta\s+name="title"\s+content="([^"]*)"/i', $html, $m)) {
    $meta["title"] = trim(html_entity_decode($m[1], ENT_QUOTES | ENT_HTML5, "UTF-8"));
  }

  if (preg_match('/<meta\s+property="og:description"\s+content="([^"]*)"/i', $html, $m)) {
    $meta["description"] = trim(html_entity_decode($m[1], ENT_QUOTES | ENT_HTML5, "UTF-8"));
  } elseif (preg_match('/"shortDescription"\s*:\s*"((?:\\\\.|[^"\\\\])*)"/s', $html, $m)) {
    $decoded = json_decode('"' . addcslashes(stripcslashes($m[1]), '"\\') . '"');
    if (is_string($decoded)) {
      $meta["description"] = trim($decoded);
    }
  }

  if (preg_match('/"approxDurationMs"\s*:\s*"(\d+)"/', $html, $m)) {
    $ms = (int) $m[1];
    if ($ms > 0) {
      $meta["duration_seconds"] = (int) round($ms / 1000);
    }
  } elseif (preg_match('/"lengthSeconds"\s*:\s*"(\d+)"/', $html, $m)) {
    $sec = (int) $m[1];
    if ($sec > 0) {
      $meta["duration_seconds"] = $sec;
    }
  }

  return $meta;
}

function youtubeFetchVideoMetadata(string $youtubeId): array
{
  static $cache = [];

  $youtubeId = trim($youtubeId);
  if (!preg_match('/^[a-zA-Z0-9_-]{11}$/', $youtubeId)) {
    return [];
  }
  if (isset($cache[$youtubeId])) {
    return $cache[$youtubeId];
  }

  $html = youtubeFetchWatchPageHtml($youtubeId);
  if ($html === null) {
    $cache[$youtubeId] = [];
    return [];
  }

  $cache[$youtubeId] = youtubeParseVideoMetadata($html);
  return $cache[$youtubeId];
}

function youtubeFetchDurationSeconds(string $youtubeId): ?int
{
  $meta = youtubeFetchVideoMetadata($youtubeId);
  $seconds = $meta["duration_seconds"] ?? null;
  return is_int($seconds) && $seconds > 0 ? $seconds : null;
}

function youtubeTruncateText(string $text, int $max = 500): string
{
  $text = trim(preg_replace("/\s+/u", " ", $text));
  if ($text === "") {
    return "";
  }
  if (mb_strlen($text, "UTF-8") <= $max) {
    return $text;
  }
  return mb_substr($text, 0, $max - 3, "UTF-8") . "...";
}

function youtubeGuessKategori(string $title, string $description): string
{
  $text = mb_strtolower($title . " " . $description, "UTF-8");
  if (preg_match("/\b(eğitim|egitim|seminer|kurs|kvkk|iş sağlığı|isg|eğitimi)\b/u", $text)) {
    return "egitimler";
  }
  if (
    preg_match("/\b(etkinlik|festival|turnuva|piknik|ziyaret|kampanya|tatbikat|offroad)\b/u", $text)
  ) {
    return "etkinlikler";
  }
  return "duyurular";
}

function dbVideoFieldIsEmpty(?string $value): bool
{
  return trim((string) $value) === "";
}

function dbFillVideoFromYoutube(PDO $db, array $video): array
{
  $youtubeId = youtubeExtractVideoId((string) ($video["youtube_id"] ?? ""));
  if (!$youtubeId) {
    return $video;
  }

  $video["youtube_id"] = $youtubeId;

  $needsBaslik = dbVideoFieldIsEmpty($video["baslik"] ?? null);
  $needsAciklama = dbVideoFieldIsEmpty($video["aciklama"] ?? null);
  $needsSure = dbVideoFieldIsEmpty($video["sure"] ?? null);
  $hasKategoriColumn = dbColumnExists($db, "videolar", "kategori");
  $hasKategoriId = dbColumnExists($db, "videolar", "kategori_id");
  $needsKategori =
    dbVideoFieldIsEmpty($video["kategori"] ?? null) && !($hasKategoriId && !empty($video["kategori_id"]));

  if (!$needsBaslik && !$needsAciklama && !$needsSure && !$needsKategori) {
    return $video;
  }

  $meta = youtubeFetchVideoMetadata($youtubeId);
  $title = trim((string) ($meta["title"] ?? ""));
  $description = youtubeTruncateText((string) ($meta["description"] ?? ""));

  if ($needsBaslik) {
    $video["baslik"] = $title !== "" ? mb_substr($title, 0, 255, "UTF-8") : $youtubeId;
  }
  if ($needsAciklama) {
    $video["aciklama"] =
      $description !== ""
        ? $description
        : youtubeTruncateText((string) ($video["baslik"] ?? $youtubeId), 500);
  }
  if ($needsSure) {
    $seconds = $meta["duration_seconds"] ?? null;
    $video["sure"] = is_int($seconds) && $seconds > 0 ? youtubeFormatDuration($seconds) : "00:00";
  }
  if ($needsKategori) {
    $video["kategori"] = youtubeGuessKategori(
      (string) ($video["baslik"] ?? $title),
      (string) ($video["aciklama"] ?? $description),
    );
  }

  if (dbColumnExists($db, "videolar", "kategori_id") && !empty($video["kategori"])) {
    $kategoriId = dbVideolarKategoriId($db, (string) $video["kategori"]);
    if ($kategoriId) {
      $video["kategori_id"] = $kategoriId;
    }
  }

  return $video;
}

/** Haftanın videosu (vitrin) kaydını getirir. */
function dbFetchVitrinVideo(PDO $db): ?array
{
  if (!dbColumnExists($db, "videolar", "vitrin")) {
    return dbFetchOne($db, "SELECT * FROM videolar ORDER BY id ASC LIMIT 1");
  }

  try {
    $row = dbFetchOne($db, "SELECT * FROM videolar WHERE vitrin = 1 ORDER BY id DESC LIMIT 1");
    if ($row) {
      return $row;
    }
    return dbFetchOne($db, "SELECT * FROM videolar ORDER BY id ASC LIMIT 1");
  } catch (PDOException $e) {
    return null;
  }
}

/** Seçilen videoyu haftanın videosu yapar; diğerlerinin vitrin bayrağını kaldırır. */
function dbSetVitrinVideo(PDO $db, int $id): bool
{
  if ($id <= 0 || !dbColumnExists($db, "videolar", "vitrin")) {
    return false;
  }

  $video = dbFetchOne($db, "SELECT id FROM videolar WHERE id = ?", [$id]);
  if (!$video) {
    return false;
  }

  $db->exec("UPDATE videolar SET vitrin = 0");
  $stmt = $db->prepare("UPDATE videolar SET vitrin = 1 WHERE id = ?");
  $stmt->execute([$id]);
  return $stmt->rowCount() > 0;
}

function dbVideolarListSql(PDO $db): string
{
  $hasVitrin = dbColumnExists($db, "videolar", "vitrin");
  $order = $hasVitrin ? "vitrin DESC, id ASC" : "id ASC";
  $orderAliased = $hasVitrin ? "v.vitrin DESC, v.id ASC" : "v.id ASC";

  if (dbColumnExists($db, "videolar", "kategori")) {
    return "SELECT * FROM videolar ORDER BY {$order}";
  }

  return "SELECT v.*, k.slug AS kategori
          FROM videolar v
          LEFT JOIN videolar_kategori k ON k.id = v.kategori_id
          ORDER BY {$orderAliased}";
}

function dbFetchOneVideo(PDO $db, int $id): ?array
{
  if ($id <= 0) {
    return null;
  }

  if (dbColumnExists($db, "videolar", "kategori")) {
    return dbFetchOne($db, "SELECT * FROM videolar WHERE id = ?", [$id]);
  }

  return dbFetchOne(
    $db,
    "SELECT v.*, k.slug AS kategori
         FROM videolar v
         LEFT JOIN videolar_kategori k ON k.id = v.kategori_id
         WHERE v.id = ?",
    [$id],
  );
}

function dbVideolarResolveKategoriSlug(PDO $db, array $row): string
{
  $slug = trim((string) ($row["kategori"] ?? ""));
  if ($slug !== "") {
    return $slug;
  }

  $kategoriId = (int) ($row["kategori_id"] ?? 0);
  if ($kategoriId > 0) {
    $kat = dbFetchOne($db, "SELECT slug FROM videolar_kategori WHERE id = ?", [$kategoriId]);
    if ($kat) {
      return (string) $kat["slug"];
    }
  }

  return "duyurular";
}

function dbEnsureVideoMetadata(PDO $db, array &$videos): void
{
  $hasKategoriId = dbColumnExists($db, "videolar", "kategori_id");
  $hasKategoriColumn = dbColumnExists($db, "videolar", "kategori");
  $syncFields = ["baslik", "aciklama", "sure"];
  if ($hasKategoriColumn) {
    $syncFields[] = "kategori";
  }

  foreach ($videos as $i => $row) {
    $filled = dbFillVideoFromYoutube($db, $row);
    $changed = false;

    $setParts = [];
    $params = [];

    foreach ($syncFields as $field) {
      $oldValue = trim((string) ($row[$field] ?? ""));
      $newValue = trim((string) ($filled[$field] ?? ""));
      if ($oldValue === "" && $newValue !== "" && $newValue !== ($row[$field] ?? "")) {
        $setParts[] = "{$field} = ?";
        $params[] = $filled[$field];
        $videos[$i][$field] = $filled[$field];
        $changed = true;
      }
    }

    if ($hasKategoriId && !empty($filled["kategori_id"]) && empty($row["kategori_id"])) {
      $setParts[] = "kategori_id = ?";
      $params[] = (int) $filled["kategori_id"];
      $videos[$i]["kategori_id"] = (int) $filled["kategori_id"];
      $changed = true;
    }

    if (!$changed || empty($setParts)) {
      continue;
    }

    $params[] = (int) $row["id"];
    $sql = "UPDATE videolar SET " . implode(", ", $setParts) . " WHERE id = ?";
    try {
      $stmt = $db->prepare($sql);
      $stmt->execute($params);
    } catch (Throwable $e) {
      // Sessizce geç
    }
  }
}

function imgUrl(?string $path, string $fallback = "../images/logo(2).png"): string
{
  $path = trim((string) $path);
  if ($path !== "" && imageFileExists($path)) {
    return normalizeImagePath($path);
  }
  if ($fallback !== "" && imageFileExists($fallback)) {
    return normalizeImagePath($fallback);
  }
  return "../images/logo(2).png";
}

/** Admin paneli alt klasörlerinden görsellerin doğru yüklenmesi için URL üretir. */
function adminImgUrl(
  string $assetBase,
  ?string $path,
  string $fallback = "images/logo(2).png",
): string {
  $path = trim((string) $path);
  $resolved =
    $path !== ""
      ? imgUrl($path, "../" . ltrim($fallback, "/"))
      : imgUrl("../" . ltrim($fallback, "/"));

  if (preg_match("#^https?://#i", $resolved)) {
    return $resolved;
  }

  $relative = preg_replace("#^(\.\./)+#", "", $resolved);
  return rtrim($assetBase, "/") . "/" . ltrim($relative, "/");
}

function adminFormatFileSize(int $bytes): string
{
  if ($bytes >= 1048576) {
    return round($bytes / 1048576, 1) . " MB";
  }
  if ($bytes >= 1024) {
    return round($bytes / 1024) . " KB";
  }
  return max(0, $bytes) . " B";
}

function adminUploadDocument(array $file, string $subdir, ?string $currentPath = null): ?string
{
  if (!isset($file["error"]) || $file["error"] === UPLOAD_ERR_NO_FILE) {
    return $currentPath;
  }
  if ($file["error"] !== UPLOAD_ERR_OK) {
    return null;
  }

  $ext = strtolower(pathinfo((string) $file["name"], PATHINFO_EXTENSION));
  $allowed = ["pdf", "doc", "docx", "xls", "xlsx", "ppt", "pptx", "txt", "zip"];
  if (!in_array($ext, $allowed, true)) {
    return null;
  }

  $baseDir = realpath(__DIR__ . "/../images");
  if ($baseDir === false) {
    return null;
  }

  $targetDir = $baseDir . "/" . trim($subdir, "/");
  if (!is_dir($targetDir) && !mkdir($targetDir, 0755, true)) {
    return null;
  }

  $name = pathinfo((string) $file["name"], PATHINFO_FILENAME);
  $name = preg_replace("/[^a-z0-9_-]+/i", "-", $name);
  $name = strtolower(trim((string) $name, "-"));
  if ($name === "") {
    $name = "dosya";
  }

  $filename = $name . "_" . bin2hex(random_bytes(4)) . "." . $ext;
  $fullPath = $targetDir . "/" . $filename;
  if (!move_uploaded_file($file["tmp_name"], $fullPath)) {
    return null;
  }

  return "../images/" . trim($subdir, "/") . "/" . $filename;
}

function adminFetchKaynaklar(PDO $db, ?string $kategoriSlug = null): array
{
  $params = [];
  $sql = "SELECT r.*, k.slug AS kategori_slug, k.ad AS kategori_adi,
                   ak.slug AS alt_kategori_slug, ak.ad AS alt_kategori_adi
            FROM kaynaklar r
            LEFT JOIN kaynaklar_kategori k ON r.kategori_id = k.id
            LEFT JOIN kaynaklar_alt_kategori ak ON r.alt_kategori_id = ak.id";

  if ($kategoriSlug !== null && $kategoriSlug !== "") {
    $sql .= " WHERE k.slug = ?";
    $params[] = $kategoriSlug;
  }

  $sql .= " ORDER BY r.id DESC";
  return dbFetchAll($db, $sql, $params);
}

function documentThumbUrl(array $row): ?string
{
  $url = trim((string) ($row["resim_url"] ?? ""));
  if ($url !== "" && imageFileExists($url)) {
    return normalizeImagePath($url);
  }
  return null;
}

function documentIconClass(array $row): string
{
  $map = [
    "protocol" => "fa-handshake",
    "document" => "fa-file-alt",
    "regulation" => "fa-gavel",
    "training" => "fa-graduation-cap",
  ];
  return $map[$row["alt_tip"] ?? ""] ?? "fa-file";
}

function yardimciLinkLogoDefaults(): array
{
  return [
    "OMIS" => "../images/otomasyon/omis_7572.png",
    "Ulakbel" => "../images/otomasyon/ulakbel_5496.png",
    "İmar Yönetim Sistemi" => "../images/otomasyon/imar-yonetim-sistemi_8038.png",
    "Dijital Arşiv" => "../images/otomasyon/dijital-arsiv_415.png",
    "Outlook" => "../images/otomasyon/outlook_4005.png",
    "Sosyal Yardım" => "../images/otomasyon/sosyal-yardim_3767.png",
    "Netcad" => "../images/otomasyon/netcad_3888.png",
    "E-Belediye Sistemi" => "../images/otomasyon/ebys_8493.png",
    "E-Belediye Evlendrme Modülü" => "../images/otomasyon/e-belediye-evlendirme-modulu_3993.png",
    "E-Belediye Sosyal Yardım Modülü" =>
      "../images/otomasyon/e-belediye-sosyal-yard-m-modulu_4432.png",
    "Gebze Belediyesi" => "../images/yardimci_linkler/web_siteleri/gebze-belediyesi.png",
    "Kocaeli Büyükşehir Belediyesi" =>
      "../images/yardimci_linkler/web_siteleri/kocaeli-buyuksehir-belediyesi.png",
    "Kocaeli Valiliği" => "../images/yardimci_linkler/web_siteleri/kocaeli-vali.jpg",
    "Gebze Kaymakamlığı" => "../images/yardimci_linkler/web_siteleri/gebze-kaymakam.png",
    "Türkiye Belediyeler Birliği" =>
      "../images/yardimci_linkler/bilgi_portallari/turkiye-belediyeler-birligi_2430.png",
    "Cumhurbaşkanlığı Uzaktan Eğitim Kapısı" =>
      "../images/yardimci_linkler/bilgi_portallari/cumhur.jpg",
    "BTK Akademi Eğitim Portalı" => "../images/yardimci_linkler/bilgi_portallari/btk-akademi.jpg",
    "Memurlar.Net" => "../images/yardimci_linkler/faydali_linkler/memurlar.png",
    "İlan" => "../images/yardimci_linkler/faydali_linkler/ilan.png",
    "Resmi Gazete" => "../images/yardimci_linkler/faydali_linkler/resmi.png",
  ];
}

function yardimciLinkLogo(array $row): ?string
{
  $url = trim((string) ($row["logo_url"] ?? ""));
  if ($url !== "" && imageFileExists($url)) {
    return normalizeImagePath($url);
  }

  $baslik = trim((string) ($row["baslik"] ?? ""));
  $defaults = yardimciLinkLogoDefaults();
  if ($baslik !== "" && isset($defaults[$baslik]) && imageFileExists($defaults[$baslik])) {
    return $defaults[$baslik];
  }

  return otomasyonLogoUrl($baslik, $url);
}

function otomasyonLogoUrl(string $baslik, ?string $logoUrl = ""): ?string
{
  $logoUrl = trim((string) $logoUrl);
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
    "UPDATE yardimci_linkler SET logo_url = ? WHERE baslik = ? AND (logo_url IS NULL OR logo_url = '')",
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
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci",
    );

    // Tablo boşsa, eski yapıdan (yardimci_linkler/kurum-ici) otomatik taşı
    $countRow = dbFetchOne($db, "SELECT COUNT(*) AS c FROM anasayfa_linkler");
    $count = (int) ($countRow["c"] ?? 0);
    if ($count === 0) {
      try {
        $rows = dbFetchAll(
          $db,
          "SELECT baslik, logo_url, hedef_url FROM yardimci_linkler WHERE kategori = ? ORDER BY id",
          ["kurum-ici"],
        );
        if (!empty($rows)) {
          $stmt = $db->prepare(
            "INSERT INTO anasayfa_linkler (baslik, logo_url, hedef_url) VALUES (?, ?, ?)",
          );
          foreach ($rows as $r) {
            $stmt->execute([$r["baslik"] ?? "", $r["logo_url"] ?? null, $r["hedef_url"] ?? ""]);
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
  dbEnsureUniqueIndex($db, "personeller", "uq_personeller_remember_token_hash", [
    "remember_token_hash",
  ]);
  dbEnsureIndex($db, "personeller", "idx_personeller_dogum_tarihi", ["dogum_tarihi"]);

  // yardimci_linkler / anasayfa_linkler: tekrarları engelle
  dbEnsureUniqueIndex($db, "yardimci_linkler", "uq_yardimci_linkler_kat_baslik_url", [
    "kategori",
    "baslik",
    "hedef_url",
  ]);
  dbEnsureUniqueIndex($db, "anasayfa_linkler", "uq_anasayfa_linkler_baslik_url", [
    "baslik",
    "hedef_url",
  ]);

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
      "CASCADE",
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
      "CASCADE",
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
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci",
    );
    dbEnsureColumn($db, "oturum_kayitlari", "ip_adresi", "varchar(45) DEFAULT NULL");
    dbEnsureColumn($db, "oturum_kayitlari", "user_agent", "varchar(255) DEFAULT NULL");
    dbEnsureColumn($db, "oturum_kayitlari", "kapanis_tipi", "varchar(20) DEFAULT NULL");
    dbEnsureColumn($db, "oturum_kayitlari", "son_aktivite", "datetime DEFAULT NULL");
  } catch (PDOException $e) {
    // Sessizce geç
  }
}

function dbEnsureYoneticiler(PDO $db): void
{
  static $done = false;
  if ($done) {
    return;
  }
  $done = true;

  try {
    $db->exec(
      "CREATE TABLE IF NOT EXISTS `yoneticiler` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `kullanici_adi` varchar(50) NOT NULL,
                `sifre` varchar(255) NOT NULL,
                `ad` varchar(100) NOT NULL,
                `soyad` varchar(100) NOT NULL,
                `yetki` enum('super','editor') NOT NULL DEFAULT 'editor',
                `aktif` tinyint(1) NOT NULL DEFAULT 1,
                `olusturma_tarihi` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                UNIQUE KEY `uq_yoneticiler_kullanici_adi` (`kullanici_adi`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci",
    );

    $db->exec(
      "CREATE TABLE IF NOT EXISTS `yonetici_oturum_kayitlari` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `yonetici_id` int(11) NOT NULL,
                `giris_zamani` datetime NOT NULL,
                `cikis_zamani` datetime DEFAULT NULL,
                `ip_adresi` varchar(45) DEFAULT NULL,
                `user_agent` varchar(255) DEFAULT NULL,
                `kapanis_tipi` varchar(20) DEFAULT NULL,
                `son_aktivite` datetime DEFAULT NULL,
                PRIMARY KEY (`id`),
                KEY `idx_yonetici_oturum_yonetici_id` (`yonetici_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci",
    );

    dbEnsureColumn($db, "yonetici_oturum_kayitlari", "ip_adresi", "varchar(45) DEFAULT NULL");
    dbEnsureColumn($db, "yonetici_oturum_kayitlari", "user_agent", "varchar(255) DEFAULT NULL");
    dbEnsureColumn($db, "yonetici_oturum_kayitlari", "kapanis_tipi", "varchar(20) DEFAULT NULL");
    dbEnsureColumn($db, "yonetici_oturum_kayitlari", "son_aktivite", "datetime DEFAULT NULL");

    $count = (int) (dbFetchOne($db, "SELECT COUNT(*) AS c FROM yoneticiler")["c"] ?? 0);
    if ($count === 0) {
      $stmt = $db->prepare(
        "INSERT INTO yoneticiler (kullanici_adi, sifre, ad, soyad, yetki, aktif)
                 VALUES (?, ?, ?, ?, ?, 1)",
      );
      $stmt->execute(["admin", adminHashPassword("admin123"), "Sistem", "Yöneticisi", "super"]);
    }
  } catch (PDOException $e) {
    // Sessizce geç
  }
}

function adminHashPassword(string $plain): string
{
  return password_hash($plain, PASSWORD_DEFAULT);
}

function adminVerifyPassword(string $storedHash, string $plain): bool
{
  $plain = trim($plain);
  if ($plain === "" || $storedHash === "") {
    return false;
  }
  if (password_verify($plain, $storedHash)) {
    return true;
  }
  // Eski MD5 kayıtları için geçiş desteği
  if (strlen($storedHash) === 32 && ctype_xdigit($storedHash)) {
    return hash_equals($storedHash, md5($plain));
  }
  return false;
}

function adminSessionClear(): void
{
  unset(
    $_SESSION["yonetici_id"],
    $_SESSION["yonetici_kullanici"],
    $_SESSION["yonetici_ad"],
    $_SESSION["yonetici_soyad"],
    $_SESSION["yonetici_yetki"],
    $_SESSION["yonetici_oturum_id"],
    $_SESSION["admin_csrf"],
  );
}

function adminLoginUrl(): string
{
  $self = $_SERVER["PHP_SELF"] ?? "";
  if (preg_match("#/admin/[^/]+/#", $self)) {
    return "../../yonetim_giris.php";
  }
  return "../yonetim_giris.php";
}

function yoneticiOturumClose(PDO $db, int $oturumId, string $tip = "manuel"): bool
{
  if ($oturumId <= 0) {
    return false;
  }
  $tip = in_array($tip, ["manuel", "sekme", "otomatik", "eski"], true) ? $tip : "manuel";
  try {
    $stmt = $db->prepare(
      "UPDATE yonetici_oturum_kayitlari
             SET cikis_zamani = COALESCE(cikis_zamani, NOW()),
                 kapanis_tipi = COALESCE(kapanis_tipi, ?),
                 son_aktivite = COALESCE(son_aktivite, NOW())
             WHERE id = ? AND cikis_zamani IS NULL",
    );
    $stmt->execute([$tip, $oturumId]);
    return $stmt->rowCount() > 0;
  } catch (Throwable $e) {
    return false;
  }
}

function yoneticiOturumCloseOtherOpen(
  PDO $db,
  int $yoneticiId,
  ?int $exceptOturumId = null,
  string $tip = "otomatik",
): void {
  if ($yoneticiId <= 0) {
    return;
  }
  try {
    if ($exceptOturumId) {
      $stmt = $db->prepare(
        "UPDATE yonetici_oturum_kayitlari
                 SET cikis_zamani = NOW(), kapanis_tipi = COALESCE(kapanis_tipi, ?)
                 WHERE yonetici_id = ? AND cikis_zamani IS NULL AND id != ?",
      );
      $stmt->execute([$tip, $yoneticiId, $exceptOturumId]);
    } else {
      $stmt = $db->prepare(
        "UPDATE yonetici_oturum_kayitlari
                 SET cikis_zamani = NOW(), kapanis_tipi = COALESCE(kapanis_tipi, ?)
                 WHERE yonetici_id = ? AND cikis_zamani IS NULL",
      );
      $stmt->execute([$tip, $yoneticiId]);
    }
  } catch (Throwable $e) {
    // Sessizce geç
  }
}

function yoneticiOturumStart(PDO $db, int $yoneticiId): int
{
  yoneticiOturumCloseOtherOpen($db, $yoneticiId, null, "otomatik");
  $ip = substr((string) ($_SERVER["REMOTE_ADDR"] ?? ""), 0, 45);
  $ua = substr((string) ($_SERVER["HTTP_USER_AGENT"] ?? ""), 0, 255);
  $stmt = $db->prepare(
    "INSERT INTO yonetici_oturum_kayitlari (yonetici_id, giris_zamani, ip_adresi, user_agent, son_aktivite)
         VALUES (?, NOW(), ?, ?, NOW())",
  );
  $stmt->execute([$yoneticiId, $ip !== "" ? $ip : null, $ua !== "" ? $ua : null]);
  return (int) $db->lastInsertId();
}

function yoneticiOturumTouch(PDO $db, ?int $oturumId): void
{
  if (!$oturumId) {
    return;
  }
  try {
    $db
      ->prepare(
        "UPDATE yonetici_oturum_kayitlari SET son_aktivite = NOW() WHERE id = ? AND cikis_zamani IS NULL",
      )
      ->execute([$oturumId]);
  } catch (Throwable $e) {
    // Sessizce geç
  }
}

function yoneticiOturumIsActive(PDO $db, int $oturumId, int $yoneticiId): bool
{
  if ($oturumId <= 0 || $yoneticiId <= 0) {
    return false;
  }
  try {
    $row = dbFetchOne(
      $db,
      "SELECT id FROM yonetici_oturum_kayitlari
             WHERE id = ? AND yonetici_id = ? AND cikis_zamani IS NULL
             LIMIT 1",
      [$oturumId, $yoneticiId],
    );
    return (bool) $row;
  } catch (Throwable $e) {
    return false;
  }
}

function adminIsLoggedIn(): bool
{
  global $db;

  $yoneticiId = (int) ($_SESSION["yonetici_id"] ?? 0);
  $oturumId = (int) ($_SESSION["yonetici_oturum_id"] ?? 0);
  if ($yoneticiId <= 0 || $oturumId <= 0) {
    return false;
  }
  if (!isset($db) || !$db instanceof PDO) {
    return false;
  }

  return yoneticiOturumIsActive($db, $oturumId, $yoneticiId);
}

function adminRequireLogin(): void
{
  global $db;

  if (!adminIsLoggedIn()) {
    adminSessionClear();
    header("Location: " . adminLoginUrl());
    exit();
  }

  if (isset($db) && $db instanceof PDO) {
    yoneticiOturumTouch($db, (int) ($_SESSION["yonetici_oturum_id"] ?? 0));
  }
}

function adminRequireRole(string $role = "editor"): void
{
  adminRequireLogin();
  if ($role === "super" && ($_SESSION["yonetici_yetki"] ?? "") !== "super") {
    header("Location: index.php?hata=yetkisiz");
    exit();
  }
}

/** Yönetici yetki kodunu Türkçe ünvana çevirir. */
function adminYetkiLabel(string $yetki): string
{
  return match ($yetki) {
    "super" => "Yönetici",
    "editor" => "Editör",
    default => "Yönetici",
  };
}

/** Navbar profil küçük resmi — kurumsal Gebze logosu. */
function portalProfileFotoUrl(): string
{
  $path = "../images/gebze-logo.png";
  $root = realpath(__DIR__ . "/..") ?: "";
  $file = $root . "/images/gebze-logo.png";
  if ($root !== "" && is_file($file)) {
    return $path . "?v=" . filemtime($file);
  }
  return $path;
}

/**
 * Üst menü / profil alanı için oturum tipine göre görünen ad, rol ve çıkış bilgisi.
 * Öncelik: yönetici oturumu > personel oturumu > misafir.
 */
function portalResolveProfile(): array
{
  if (adminIsLoggedIn()) {
    $kullanici = trim((string) ($_SESSION["yonetici_kullanici"] ?? ""));
    $adSoyad = trim(
      trim((string) ($_SESSION["yonetici_ad"] ?? "")) .
        " " .
        trim((string) ($_SESSION["yonetici_soyad"] ?? "")),
    );
    return [
      "tip" => "yonetici",
      "ad" => $kullanici !== "" ? $kullanici : ($adSoyad !== "" ? $adSoyad : "Yönetici"),
      "rol" => adminYetkiLabel((string) ($_SESSION["yonetici_yetki"] ?? "super")),
      "email" => $kullanici !== "" ? $kullanici : "yonetici",
      "foto" => portalProfileFotoUrl(),
      "cikis_url" => "admin/cikis.php",
      "oturum_aktif" => true,
    ];
  }

  $personelAktif = !empty($_SESSION["personel_id"]) && !empty($_SESSION["oturum_id"]);
  if ($personelAktif) {
    return [
      "tip" => "personel",
      "ad" => trim(
        trim((string) ($_SESSION["ad"] ?? "Kullanıcı")) .
          " " .
          trim((string) ($_SESSION["soyad"] ?? "")),
      ),
      "rol" => "Personel",
      "email" => (string) ($_SESSION["email"] ?? "personel@gebze.bel.tr"),
      "foto" => portalProfileFotoUrl(),
      "cikis_url" => "cikis.php",
      "oturum_aktif" => true,
    ];
  }

  return [
    "tip" => "misafir",
    "ad" => "Kullanıcı",
    "rol" => "Misafir",
    "email" => "personel@gebze.bel.tr",
    "foto" => portalProfileFotoUrl(),
    "cikis_url" => "login.php",
    "oturum_aktif" => false,
  ];
}

function adminCsrfToken(): string
{
  if (empty($_SESSION["admin_csrf"])) {
    $_SESSION["admin_csrf"] = bin2hex(random_bytes(32));
  }
  return $_SESSION["admin_csrf"];
}

function adminVerifyCsrf(?string $token): bool
{
  return is_string($token) &&
    $token !== "" &&
    !empty($_SESSION["admin_csrf"]) &&
    hash_equals($_SESSION["admin_csrf"], $token);
}

function adminCountTable(PDO $db, string $table): int
{
  try {
    $row = dbFetchOne($db, "SELECT COUNT(*) AS c FROM `{$table}`");
    return (int) ($row["c"] ?? 0);
  } catch (Throwable $e) {
    return 0;
  }
}

function adminFlashSet(string $type, string $message): void
{
  $_SESSION["admin_flash"] = ["type" => $type, "message" => $message];
}

function adminFlashGet(): ?array
{
  if (empty($_SESSION["admin_flash"])) {
    return null;
  }
  $flash = $_SESSION["admin_flash"];
  unset($_SESSION["admin_flash"]);
  return $flash;
}

function adminUploadImage(array $file, string $subdir, ?string $currentPath = null): ?string
{
  if (!isset($file["error"]) || $file["error"] === UPLOAD_ERR_NO_FILE) {
    return $currentPath;
  }
  if ($file["error"] !== UPLOAD_ERR_OK) {
    return null;
  }

  $allowed = ["image/jpeg", "image/png", "image/webp", "image/gif"];
  $mime = mime_content_type($file["tmp_name"]);
  if (!in_array($mime, $allowed, true)) {
    return null;
  }

  $ext = match ($mime) {
    "image/png" => "png",
    "image/webp" => "webp",
    "image/gif" => "gif",
    default => "jpg",
  };

  $baseDir = realpath(__DIR__ . "/../images");
  if ($baseDir === false) {
    return null;
  }

  $targetDir = $baseDir . "/" . trim($subdir, "/");
  if (!is_dir($targetDir) && !mkdir($targetDir, 0755, true)) {
    return null;
  }

  $name = pathinfo((string) $file["name"], PATHINFO_FILENAME);
  $name = preg_replace("/[^a-z0-9_-]+/i", "-", $name);
  $name = strtolower(trim((string) $name, "-"));
  if ($name === "") {
    $name = "gorsel";
  }

  $filename = $name . "_" . bin2hex(random_bytes(4)) . "." . $ext;
  $fullPath = $targetDir . "/" . $filename;
  if (!move_uploaded_file($file["tmp_name"], $fullPath)) {
    return null;
  }

  return "../images/" . trim($subdir, "/") . "/" . $filename;
}

function dbSizdenGelenlerKategoriId(PDO $db, string $slug, ?string $ad = null): ?int
{
  $slug = trim($slug);
  if ($slug === "") {
    return null;
  }

  try {
    $row = dbFetchOne($db, "SELECT id FROM sizdengelenler_kategori WHERE slug = ?", [$slug]);
    if ($row) {
      return (int) $row["id"];
    }

    $adDeger = $ad !== null && $ad !== "" ? $ad : mb_convert_case($slug, MB_CASE_TITLE, "UTF-8");
    $db
      ->prepare(
        "INSERT INTO sizdengelenler_kategori (slug, ad) VALUES (?, ?)
             ON DUPLICATE KEY UPDATE ad = VALUES(ad)",
      )
      ->execute([$slug, $adDeger]);

    $row = dbFetchOne($db, "SELECT id FROM sizdengelenler_kategori WHERE slug = ?", [$slug]);
    return $row ? (int) $row["id"] : null;
  } catch (PDOException $e) {
    return null;
  }
}

function adminDuyuruTable(PDO $db): string
{
  return dbEtkinliklerDuyurularTable($db);
}

function adminFetchDuyurular(PDO $db): array
{
  $table = adminDuyuruTable($db);
  if (dbColumnExists($db, $table, "alt_tip")) {
    return dbFetchAll($db, "SELECT * FROM `{$table}` WHERE sayfa_tipi = 'duyuru' ORDER BY id DESC");
  }
  return dbFetchAll(
    $db,
    "SELECT t.*, k.slug AS alt_tip, k.ad AS kategori_adi
         FROM `{$table}` t
         LEFT JOIN duyurular_kategori k ON k.id = t.kategori_id
         WHERE t.sayfa_tipi = 'duyuru'
         ORDER BY t.id DESC",
  );
}

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
             WHERE id = ? AND cikis_zamani IS NULL",
    );
    $stmt->execute([$tip, $oturumId]);
    return $stmt->rowCount() > 0;
  } catch (Throwable $e) {
    return false;
  }
}

/** Personelin diğer açık oturumlarını kapatır (yeni giriş öncesi). */
function oturumCloseOtherOpen(
  PDO $db,
  int $personelId,
  ?int $exceptOturumId = null,
  string $tip = "otomatik",
): void {
  if ($personelId <= 0) {
    return;
  }
  try {
    if ($exceptOturumId) {
      $stmt = $db->prepare(
        "UPDATE oturum_kayitlari
                 SET cikis_zamani = NOW(), kapanis_tipi = COALESCE(kapanis_tipi, ?)
                 WHERE personel_id = ? AND cikis_zamani IS NULL AND id != ?",
      );
      $stmt->execute([$tip, $personelId, $exceptOturumId]);
    } else {
      $stmt = $db->prepare(
        "UPDATE oturum_kayitlari
                 SET cikis_zamani = NOW(), kapanis_tipi = COALESCE(kapanis_tipi, ?)
                 WHERE personel_id = ? AND cikis_zamani IS NULL",
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
  $ip = substr((string) ($_SERVER["REMOTE_ADDR"] ?? ""), 0, 45);
  $ua = substr((string) ($_SERVER["HTTP_USER_AGENT"] ?? ""), 0, 255);
  $stmt = $db->prepare(
    "INSERT INTO oturum_kayitlari (personel_id, giris_zamani, ip_adresi, user_agent, son_aktivite)
         VALUES (?, NOW(), ?, ?, NOW())",
  );
  $stmt->execute([$personelId, $ip !== "" ? $ip : null, $ua !== "" ? $ua : null]);
  return (int) $db->lastInsertId();
}

/** Aktif oturumun son aktivite zamanını günceller. */
function oturumTouch(PDO $db, ?int $oturumId): void
{
  if (!$oturumId) {
    return;
  }
  try {
    $db
      ->prepare(
        "UPDATE oturum_kayitlari SET son_aktivite = NOW() WHERE id = ? AND cikis_zamani IS NULL",
      )
      ->execute([$oturumId]);
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
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci",
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
    return "personel:" . (int) $_SESSION["personel_id"];
  }

  $cookieName = "pp_viewer";
  $token = $_COOKIE[$cookieName] ?? "";
  if (!is_string($token) || !preg_match('/^[a-f0-9]{32}$/', $token)) {
    $token = bin2hex(random_bytes(16));
    setcookie($cookieName, $token, [
      "expires" => time() + 60 * 60 * 24 * 365,
      "path" => "/",
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
    "etkinlikler" => "view",
    "anasayfa_duyurular" => "view",
    "duyurular" => "view",
    "sizden_gelenler" => "goruntulenme",
    "haberler" => "view",
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
      "INSERT IGNORE INTO icerik_izlemeleri (tablo, kayit_id, izleyici) VALUES (?, ?, ?)",
    );
    $ins->execute([$table, $id, $viewer]);
    if ($ins->rowCount() > 0) {
      $db
        ->prepare("UPDATE `{$table}` SET `{$column}` = COALESCE(`{$column}`, 0) + 1 WHERE id = ?")
        ->execute([$id]);
      $increased = true;
    }
  } catch (Throwable $e) {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    if (!isset($_SESSION["content_views"]) || !is_array($_SESSION["content_views"])) {
      $_SESSION["content_views"] = [];
    }
    $key = $table . ":" . $id . ":" . $viewer;
    if (empty($_SESSION["content_views"][$key])) {
      try {
        $db
          ->prepare("UPDATE `{$table}` SET `{$column}` = COALESCE(`{$column}`, 0) + 1 WHERE id = ?")
          ->execute([$id]);
        $_SESSION["content_views"][$key] = 1;
        $increased = true;
      } catch (Throwable $e2) {
        // geç
      }
    }
  }

  $row = dbFetchOne($db, "SELECT `{$column}` AS c FROM `{$table}` WHERE id = ?", [$id]);
  return [
    "count" => (int) ($row["c"] ?? 0),
    "increased" => $increased,
  ];
}

function dbColumnExists(PDO $db, string $table, string $column): bool
{
  try {
    $stmt = $db->prepare(
      "SELECT COUNT(*) AS c
             FROM information_schema.COLUMNS
             WHERE TABLE_SCHEMA = DATABASE()
               AND TABLE_NAME = ?
               AND COLUMN_NAME = ?",
    );
    $stmt->execute([$table, $column]);
    return (int) ($stmt->fetch(PDO::FETCH_ASSOC)["c"] ?? 0) > 0;
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
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci",
    );
  } catch (PDOException $e) {
    return; // oluşturulamadıysa devam etmenin anlamı yok
  }

  $hasOldSlugColumn = dbColumnExists($db, "sizden_gelenler", "kategori_slug");
  $hasOldAdColumn = dbColumnExists($db, "sizden_gelenler", "kategori_adi");

  // 2) Eski yapıdaki (serbest metin) kategorileri yeni tabloya aktar
  if ($hasOldSlugColumn && $hasOldAdColumn) {
    try {
      $eskiKategoriler = dbFetchAll(
        $db,
        "SELECT DISTINCT kategori_slug, kategori_adi
                 FROM sizden_gelenler
                 WHERE kategori_slug IS NOT NULL AND kategori_slug <> ''",
      );
      if (!empty($eskiKategoriler)) {
        $stmt = $db->prepare(
          "INSERT INTO sizdengelenler_kategori (slug, ad) VALUES (?, ?)
                     ON DUPLICATE KEY UPDATE ad = VALUES(ad)",
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
                 WHERE sg.kategori_id IS NULL",
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
    "CASCADE",
  );

  // 6) Tüm satırlar başarıyla eşleştiyse eski redundant kolonları kaldır
  if ($hasOldSlugColumn && $hasOldAdColumn) {
    try {
      $eksik = dbFetchOne(
        $db,
        "SELECT COUNT(*) AS c FROM sizden_gelenler WHERE kategori_id IS NULL",
      );
      if ((int) ($eksik["c"] ?? 1) === 0) {
        $db->exec(
          "ALTER TABLE sizden_gelenler DROP COLUMN kategori_slug, DROP COLUMN kategori_adi",
        );
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
    "egitimler" => "Eğitimler",
    "duyurular" => "Duyurular",
  ];
}

function dbVideolarKategoriAdi(?string $slug): string
{
  $slug = trim((string) $slug);
  $eslesme = dbVideolarKategoriAdiEslemesi();
  if (isset($eslesme[$slug])) {
    return $eslesme[$slug];
  }
  return $slug !== "" ? mb_convert_case($slug, MB_CASE_TITLE, "UTF-8") : "-";
}

/** videolar satırlarına kategori_id üzerinden slug ekler (kategori kolonu yoksa). */
function dbVideolarAttachKategoriSlug(PDO $db, array $videos): array
{
  $slugById = [];
  foreach (dbVideolarKategoriler($db) as $kat) {
    $slugById[(int) $kat["id"]] = (string) $kat["slug"];
  }

  foreach ($videos as $i => $video) {
    if (trim((string) ($video["kategori"] ?? "")) === "" && !empty($video["kategori_id"])) {
      $videos[$i]["kategori"] = $slugById[(int) $video["kategori_id"]] ?? "";
    }
  }

  return $videos;
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
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci",
    );
  } catch (PDOException $e) {
    return;
  }

  // 2) Mevcut "kategori" metin değerlerini yeni tabloya aktar
  if (dbColumnExists($db, "videolar", "kategori")) {
    try {
      $mevcutKategoriler = dbFetchAll(
        $db,
        "SELECT DISTINCT kategori FROM videolar WHERE kategori IS NOT NULL AND kategori <> ''",
      );
      if (!empty($mevcutKategoriler)) {
        $stmt = $db->prepare(
          "INSERT INTO videolar_kategori (slug, ad) VALUES (?, ?)
                     ON DUPLICATE KEY UPDATE ad = VALUES(ad)",
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
             WHERE v.kategori_id IS NULL",
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
    "CASCADE",
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
      return (int) $row["id"];
    }

    $stmt = $db->prepare(
      "INSERT INTO videolar_kategori (slug, ad) VALUES (?, ?)
             ON DUPLICATE KEY UPDATE ad = VALUES(ad)",
    );
    $stmt->execute([$slug, dbVideolarKategoriAdi($slug)]);

    $row = dbFetchOne($db, "SELECT id FROM videolar_kategori WHERE slug = ?", [$slug]);
    return $row ? (int) $row["id"] : null;
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

/** Videolar tablosuna haftanın videosu (vitrin) kolonlarını ekler. */
function dbEnsureVideolarVitrin(PDO $db): void
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

  dbEnsureColumn($db, "videolar", "vitrin_baslik", "VARCHAR(255) DEFAULT NULL");
  dbEnsureColumn($db, "videolar", "vitrin_aciklama", "TEXT DEFAULT NULL");
  dbEnsureColumn($db, "videolar", "vitrin", "TINYINT(1) NOT NULL DEFAULT 0");
}

/**
 * Mevzuatlar sayfasındaki alt kategori slug -> görünen ad eşlemesi.
 * (Daha önce mevzuat.php içindeki $altKategoriMap dizisiyle aynı.)
 */
function dbKaynaklarAltKategoriAdiEslemesi(): array
{
  return [
    "genel" => "Genel Mevzuatlar",
    "memur" => "Memur Mevzuatları",
    "sozlesmeli" => "Sözleşmeli Memur Mevzuatları",
    "isci" => "İşçi Mevzuatları",
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
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci",
    );
  } catch (PDOException $e) {
    return;
  }

  // Bilinen 4 ana kategori her zaman bulunsun (veri henüz olmasa bile dropdown dolu olsun)
  try {
    $stmt = $db->prepare(
      "INSERT INTO kaynaklar_kategori (slug, ad) VALUES (?, ?)
             ON DUPLICATE KEY UPDATE ad = VALUES(ad)",
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
        "SELECT DISTINCT kategori FROM kaynaklar WHERE kategori IS NOT NULL AND kategori <> ''",
      );
      if (!empty($mevcut)) {
        $stmt = $db->prepare(
          "INSERT INTO kaynaklar_kategori (slug, ad) VALUES (?, ?)
                     ON DUPLICATE KEY UPDATE ad = VALUES(ad)",
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
                 WHERE r.kategori_id IS NULL",
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
    "CASCADE",
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
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci",
    );
    dbEnsureForeignKey(
      $db,
      "kaynaklar_alt_kategori",
      "fk_kaynaklar_alt_kategori_ust",
      ["kaynak_kategori_id"],
      "kaynaklar_kategori",
      ["id"],
      "CASCADE",
      "CASCADE",
    );
  } catch (PDOException $e) {
    return;
  }

  $mevzuatlarRow = dbFetchOne($db, "SELECT id FROM kaynaklar_kategori WHERE slug = ?", [
    "Mevzuatlar",
  ]);
  $mevzuatlarId = $mevzuatlarRow ? (int) $mevzuatlarRow["id"] : null;

  if ($mevzuatlarId !== null) {
    // Bilinen 4 alt kategori her zaman bulunsun
    try {
      $stmt = $db->prepare(
        "INSERT INTO kaynaklar_alt_kategori (kaynak_kategori_id, slug, ad) VALUES (?, ?, ?)
                 ON DUPLICATE KEY UPDATE ad = VALUES(ad)",
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
                     WHERE alt_kategori IS NOT NULL AND alt_kategori <> ''",
        );
        if (!empty($mevcutAlt)) {
          $eslesme = dbKaynaklarAltKategoriAdiEslemesi();
          $stmt = $db->prepare(
            "INSERT INTO kaynaklar_alt_kategori (kaynak_kategori_id, slug, ad) VALUES (?, ?, ?)
                         ON DUPLICATE KEY UPDATE ad = VALUES(ad)",
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
                     WHERE r.alt_kategori_id IS NULL AND r.kategori_id = ?",
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
      "CASCADE",
    );
  }

  // 5) Tüm satırlar başarıyla eşleştiyse eski redundant kolonları kaldır
  if ($hasKategoriColumn) {
    try {
      $eksikKategoriRow = dbFetchOne(
        $db,
        "SELECT COUNT(*) AS c FROM kaynaklar WHERE kategori_id IS NULL",
      );
      $eksikKategori = (int) ($eksikKategoriRow["c"] ?? 1);

      $eksikAlt = 0;
      $hasAltKategoriColumn = dbColumnExists($db, "kaynaklar", "alt_kategori");
      if ($hasAltKategoriColumn) {
        $eksikAltRow = dbFetchOne(
          $db,
          "SELECT COUNT(*) AS c FROM kaynaklar
                     WHERE alt_kategori IS NOT NULL AND alt_kategori <> '' AND alt_kategori_id IS NULL",
        );
        $eksikAlt = (int) ($eksikAltRow["c"] ?? 1);
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
      [$kategoriId],
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

  $hasAltTip = dbColumnExists($db, $table, "alt_tip");
  $hasKategoriAdi = dbColumnExists($db, $table, "kategori_adi");
  if (!$hasAltTip || !$hasKategoriAdi) {
    return; // beklenen kolonlar yoksa taşınacak bir şey yok
  }

  $isDokumanlar = $table === "dokumanlar";
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
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci",
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
                 ON DUPLICATE KEY UPDATE ad = VALUES(ad)",
      );
      foreach ($mevcutKategoriler as $k) {
        $slug = $k["alt_tip"];
        $ad =
          ($k["kategori_adi"] ?? "") !== ""
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
    "CASCADE",
  );

  // 6) Sadece "etkinlikler_duyurular" tablosunda: bu tablo yalnızca duyurulara
  //    özel olduğu için (dokumanlar gibi başka sayfa tipleriyle paylaşılmıyor),
  //    tüm satırlar başarıyla eşleştiyse eski redundant kolonları kaldır.
  //    "dokumanlar" tablosuna bilinçli olarak dokunulmuyor; o tablo Protokoller/
  //    Dökümanlar/Mevzuatlar/Eğitimler sayfalarıyla da paylaşımlı olabilir.
  if ($table === "etkinlikler_duyurular") {
    try {
      $eksik = dbFetchOne($db, "SELECT COUNT(*) AS c FROM `{$table}` WHERE kategori_id IS NULL");
      if ((int) ($eksik["c"] ?? 1) === 0) {
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
      return (int) $row["id"];
    }

    $adDeger = $ad !== null && $ad !== "" ? $ad : mb_convert_case($slug, MB_CASE_TITLE, "UTF-8");
    $stmt = $db->prepare(
      "INSERT INTO duyurular_kategori (slug, ad) VALUES (?, ?)
             ON DUPLICATE KEY UPDATE ad = VALUES(ad)",
    );
    $stmt->execute([$slug, $adDeger]);

    $row = dbFetchOne($db, "SELECT id FROM duyurular_kategori WHERE slug = ?", [$slug]);
    return $row ? (int) $row["id"] : null;
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

/**
 * Bilinen anket "kategori" (aslında durum) değerleri için Türkçe görünen ad
 * ve rozet eşlemesi. anketler.php içindeki $badgeMap ile aynı sırayı takip eder.
 */
function dbAnketlerKategoriAdiEslemesi(): array
{
  return [
    "active" => "Aktif",
    "pending" => "Beklemede",
    "completed" => "Tamamlandı",
    "expired" => "Süresi Doldu",
  ];
}

/**
 * "Anketler" sayfasının kategorilerini (durum: active/pending/completed/expired)
 * ayrı bir tabloya taşır: "anketler_kategori".
 *
 * "anketler" tablosu başka hiçbir sayfayla paylaşılmadığı için (Sizden Gelenler
 * ile aynı durum), tüm satırlar başarıyla eşleştiyse eski "kategori" metin
 * kolonu silinir.
 */
function dbEnsureAnketlerKategori(PDO $db): void
{
  static $done = false;
  if ($done) {
    return;
  }
  $done = true;

  $table = "anketler";

  try {
    $db->query("SELECT 1 FROM `{$table}` LIMIT 1");
  } catch (PDOException $e) {
    return; // anketler tablosu henüz yoksa atla
  }

  if (!dbColumnExists($db, $table, "kategori")) {
    return; // beklenen kolon yoksa taşınacak bir şey yok
  }

  // 1) Kategori tablosunu oluştur
  try {
    $db->exec(
      "CREATE TABLE IF NOT EXISTS `anketler_kategori` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `slug` varchar(100) NOT NULL,
                `ad` varchar(150) NOT NULL,
                PRIMARY KEY (`id`),
                UNIQUE KEY `uq_anketler_kategori_slug` (`slug`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci",
    );
  } catch (PDOException $e) {
    return;
  }

  // Bilinen 4 durum her zaman bulunsun (veri henüz olmasa bile dropdown dolu olsun)
  try {
    $stmt = $db->prepare(
      "INSERT INTO anketler_kategori (slug, ad) VALUES (?, ?)
             ON DUPLICATE KEY UPDATE ad = VALUES(ad)",
    );
    foreach (dbAnketlerKategoriAdiEslemesi() as $slug => $ad) {
      $stmt->execute([$slug, $ad]);
    }
  } catch (PDOException $e) {
    // Sessizce geç
  }

  // 2) Veride varsa bilinmeyen/ekstra durumları da taşı
  try {
    $mevcut = dbFetchAll(
      $db,
      "SELECT DISTINCT kategori FROM `{$table}` WHERE kategori IS NOT NULL AND kategori <> ''",
    );
    if (!empty($mevcut)) {
      $eslesme = dbAnketlerKategoriAdiEslemesi();
      $stmt = $db->prepare(
        "INSERT INTO anketler_kategori (slug, ad) VALUES (?, ?)
                 ON DUPLICATE KEY UPDATE ad = VALUES(ad)",
      );
      foreach ($mevcut as $k) {
        $slug = $k["kategori"];
        $ad = $eslesme[$slug] ?? mb_convert_case($slug, MB_CASE_TITLE, "UTF-8");
        $stmt->execute([$slug, $ad]);
      }
    }
  } catch (PDOException $e) {
    // Sessizce geç
  }

  // 3) Tabloya kategori_id kolonu ekle
  dbEnsureColumn($db, $table, "kategori_id", "INT(11) DEFAULT NULL");

  // 4) Mevcut kategori metnine göre kategori_id'yi doldur
  try {
    $db->exec(
      "UPDATE `{$table}` t
             JOIN anketler_kategori k ON k.slug = t.kategori
             SET t.kategori_id = k.id
             WHERE t.kategori_id IS NULL",
    );
  } catch (PDOException $e) {
    // Sessizce geç
  }

  // 5) Index + Foreign Key
  dbEnsureIndex($db, $table, "idx_anketler_kategori_id", ["kategori_id"]);
  dbEnsureForeignKey(
    $db,
    $table,
    "fk_anketler_kategori",
    ["kategori_id"],
    "anketler_kategori",
    ["id"],
    "RESTRICT",
    "CASCADE",
  );

  // 6) Tüm satırlar başarıyla eşleştiyse eski redundant kolonu kaldır
  try {
    $eksik = dbFetchOne($db, "SELECT COUNT(*) AS c FROM `{$table}` WHERE kategori_id IS NULL");
    if ((int) ($eksik["c"] ?? 1) === 0) {
      $db->exec("ALTER TABLE `{$table}` DROP COLUMN kategori");
    }
  } catch (PDOException $e) {
    // Sessizce geç
  }
}

/**
 * Verilen slug'a (durum) karşılık gelen kategori id'sini döndürür.
 * Tabloda yoksa otomatik oluşturur.
 */
function dbAnketlerKategoriId(PDO $db, string $slug, ?string $ad = null): ?int
{
  $slug = trim($slug);
  if ($slug === "") {
    return null;
  }

  try {
    $row = dbFetchOne($db, "SELECT id FROM anketler_kategori WHERE slug = ?", [$slug]);
    if ($row) {
      return (int) $row["id"];
    }

    $eslesme = dbAnketlerKategoriAdiEslemesi();
    $adDeger =
      $ad !== null && $ad !== ""
        ? $ad
        : $eslesme[$slug] ?? mb_convert_case($slug, MB_CASE_TITLE, "UTF-8");
    $stmt = $db->prepare(
      "INSERT INTO anketler_kategori (slug, ad) VALUES (?, ?)
             ON DUPLICATE KEY UPDATE ad = VALUES(ad)",
    );
    $stmt->execute([$slug, $adDeger]);

    $row = dbFetchOne($db, "SELECT id FROM anketler_kategori WHERE slug = ?", [$slug]);
    return $row ? (int) $row["id"] : null;
  } catch (PDOException $e) {
    return null;
  }
}

/**
 * Admin panelinde dropdown doldurmak için kategori (durum) listesi.
 */
function dbAnketlerKategoriler(PDO $db): array
{
  try {
    return dbFetchAll($db, "SELECT * FROM anketler_kategori ORDER BY ad ASC");
  } catch (PDOException $e) {
    return [];
  }
}

/**
 * anketler.php'nin ihtiyaç duyduğu satırları getirir. "kategori" kolonu
 * dbEnsureAnketlerKategori() tarafından silinmiş olsa bile, kategori_id
 * üzerinden JOIN ile aynı isimle ("kategori") geri kazandırılır; böylece
 * anketler.php'deki $badgeMap[$k["kategori"]] araması değişmeden çalışır.
 */
function dbFetchAnketler(PDO $db): array
{
  if (dbColumnExists($db, "anketler", "kategori")) {
    return dbFetchAll($db, "SELECT * FROM anketler ORDER BY id");
  }
  return dbFetchAll(
    $db,
    "SELECT t.*, k.slug AS kategori
         FROM anketler t
         LEFT JOIN anketler_kategori k ON k.id = t.kategori_id
         ORDER BY t.id",
  );
}

/** Admin paneli anket listesi (kategori slug JOIN ile, yeniden eskiye). */
function adminFetchAnketler(PDO $db): array
{
  if (dbColumnExists($db, "anketler", "kategori")) {
    return dbFetchAll($db, "SELECT * FROM anketler ORDER BY id DESC");
  }
  return dbFetchAll(
    $db,
    "SELECT t.*, k.slug AS kategori, k.ad AS kategori_adi
         FROM anketler t
         LEFT JOIN anketler_kategori k ON k.id = t.kategori_id
         ORDER BY t.id DESC",
  );
}

/** Admin paneli tek anket kaydı (kategori slug JOIN ile). */
function adminFetchAnket(PDO $db, int $id): ?array
{
  if ($id <= 0) {
    return null;
  }
  if (dbColumnExists($db, "anketler", "kategori")) {
    return dbFetchOne($db, "SELECT * FROM anketler WHERE id = ?", [$id]);
  }
  return dbFetchOne(
    $db,
    "SELECT t.*, k.slug AS kategori, k.ad AS kategori_adi
         FROM anketler t
         LEFT JOIN anketler_kategori k ON k.id = t.kategori_id
         WHERE t.id = ?",
    [$id],
  );
}

/**
 * Bilinen yardımcı link kategori slug'ları için Türkçe görünen ad eşlemesi.
 * (yardimci_linkler.php içindeki sortSelect dropdown'ıyla aynı sırayı takip eder.)
 */
function dbYardimciLinklerKategoriAdiEslemesi(): array
{
  return [
    "kurum-ici" => "Kurum İçi Linkler",
    "website" => "Website Linkler",
    "bilgi" => "Bilgi Portalları",
    "faydalı" => "Faydalı Linkler",
  ];
}

/**
 * "Yardımcı Linkler" sayfasının kategorilerini ayrı bir tabloya taşır:
 * "yardimci_linkler_kategori".
 *
 * "yardimci_linkler" tablosu başka hiçbir sayfayla paylaşılmadığı için
 * (Sizden Gelenler/Anketler'deki gibi), tüm satırlar başarıyla eşleştiyse
 * eski "kategori" metin kolonu silinir.
 *
 * NOT: dbEnsureAnasayfaLinkler() bu fonksiyondan ÖNCE çalışır ve ilk kurulumda
 * "yardimci_linkler" tablosundaki kategori = 'kurum-ici' satırlarını
 * "anasayfa_linkler" tablosuna bir kerelik taşır; bu yüzden kategori kolonu
 * o adım tamamlanmadan silinmez.
 */
function dbEnsureYardimciLinklerKategori(PDO $db): void
{
  static $done = false;
  if ($done) {
    return;
  }
  $done = true;

  $table = "yardimci_linkler";

  try {
    $db->query("SELECT 1 FROM `{$table}` LIMIT 1");
  } catch (PDOException $e) {
    return; // tablo henüz yoksa atla
  }

  if (!dbColumnExists($db, $table, "kategori")) {
    return; // beklenen kolon yoksa taşınacak bir şey yok
  }

  // 1) Kategori tablosunu oluştur
  try {
    $db->exec(
      "CREATE TABLE IF NOT EXISTS `yardimci_linkler_kategori` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `slug` varchar(100) NOT NULL,
                `ad` varchar(150) NOT NULL,
                PRIMARY KEY (`id`),
                UNIQUE KEY `uq_yardimci_linkler_kategori_slug` (`slug`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci",
    );
  } catch (PDOException $e) {
    return;
  }

  // Bilinen 4 kategori her zaman bulunsun (veri henüz olmasa bile dropdown dolu olsun)
  try {
    $stmt = $db->prepare(
      "INSERT INTO yardimci_linkler_kategori (slug, ad) VALUES (?, ?)
             ON DUPLICATE KEY UPDATE ad = VALUES(ad)",
    );
    foreach (dbYardimciLinklerKategoriAdiEslemesi() as $slug => $ad) {
      $stmt->execute([$slug, $ad]);
    }
  } catch (PDOException $e) {
    // Sessizce geç
  }

  // 2) Veride varsa bilinmeyen/ekstra kategorileri de taşı
  try {
    $mevcut = dbFetchAll(
      $db,
      "SELECT DISTINCT kategori FROM `{$table}` WHERE kategori IS NOT NULL AND kategori <> ''",
    );
    if (!empty($mevcut)) {
      $eslesme = dbYardimciLinklerKategoriAdiEslemesi();
      $stmt = $db->prepare(
        "INSERT INTO yardimci_linkler_kategori (slug, ad) VALUES (?, ?)
                 ON DUPLICATE KEY UPDATE ad = VALUES(ad)",
      );
      foreach ($mevcut as $k) {
        $slug = $k["kategori"];
        $ad = $eslesme[$slug] ?? mb_convert_case($slug, MB_CASE_TITLE, "UTF-8");
        $stmt->execute([$slug, $ad]);
      }
    }
  } catch (PDOException $e) {
    // Sessizce geç
  }

  // 3) Tabloya kategori_id kolonu ekle
  dbEnsureColumn($db, $table, "kategori_id", "INT(11) DEFAULT NULL");

  // 4) Mevcut kategori metnine göre kategori_id'yi doldur
  try {
    $db->exec(
      "UPDATE `{$table}` t
             JOIN yardimci_linkler_kategori k ON k.slug = t.kategori
             SET t.kategori_id = k.id
             WHERE t.kategori_id IS NULL",
    );
  } catch (PDOException $e) {
    // Sessizce geç
  }

  // 5) Index + Foreign Key
  dbEnsureIndex($db, $table, "idx_yardimci_linkler_kategori_id", ["kategori_id"]);
  dbEnsureForeignKey(
    $db,
    $table,
    "fk_yardimci_linkler_kategori",
    ["kategori_id"],
    "yardimci_linkler_kategori",
    ["id"],
    "RESTRICT",
    "CASCADE",
  );

  // 6) Tüm satırlar başarıyla eşleştiyse eski redundant kolonu kaldır
  try {
    $eksik = dbFetchOne($db, "SELECT COUNT(*) AS c FROM `{$table}` WHERE kategori_id IS NULL");
    if ((int) ($eksik["c"] ?? 1) === 0) {
      $db->exec("ALTER TABLE `{$table}` DROP COLUMN kategori");
    }
  } catch (PDOException $e) {
    // Sessizce geç
  }
}

/**
 * Verilen slug'a karşılık gelen kategori id'sini döndürür.
 * Tabloda yoksa otomatik oluşturur.
 */
function dbYardimciLinklerKategoriId(PDO $db, string $slug, ?string $ad = null): ?int
{
  $slug = trim($slug);
  if ($slug === "") {
    return null;
  }

  try {
    $row = dbFetchOne($db, "SELECT id FROM yardimci_linkler_kategori WHERE slug = ?", [$slug]);
    if ($row) {
      return (int) $row["id"];
    }

    $eslesme = dbYardimciLinklerKategoriAdiEslemesi();
    $adDeger =
      $ad !== null && $ad !== ""
        ? $ad
        : $eslesme[$slug] ?? mb_convert_case($slug, MB_CASE_TITLE, "UTF-8");
    $stmt = $db->prepare(
      "INSERT INTO yardimci_linkler_kategori (slug, ad) VALUES (?, ?)
             ON DUPLICATE KEY UPDATE ad = VALUES(ad)",
    );
    $stmt->execute([$slug, $adDeger]);

    $row = dbFetchOne($db, "SELECT id FROM yardimci_linkler_kategori WHERE slug = ?", [$slug]);
    return $row ? (int) $row["id"] : null;
  } catch (PDOException $e) {
    return null;
  }
}

/**
 * Admin panelinde dropdown doldurmak için kategori listesi.
 */
function dbYardimciLinklerKategoriler(PDO $db): array
{
  try {
    return dbFetchAll($db, "SELECT * FROM yardimci_linkler_kategori ORDER BY ad ASC");
  } catch (PDOException $e) {
    return [];
  }
}

/**
 * yardimci_linkler.php'nin ihtiyaç duyduğu satırları getirir. "kategori" kolonu
 * dbEnsureYardimciLinklerKategori() tarafından silinmiş olsa bile, kategori_id
 * üzerinden JOIN ile aynı isimle ("kategori") geri kazandırılır; böylece
 * data-category="<?= $k['kategori'] ?>" ve sortSelect filtresi değişmeden çalışır.
 */
function dbFetchYardimciLinkler(PDO $db): array
{
  if (dbColumnExists($db, "yardimci_linkler", "kategori")) {
    return dbFetchAll($db, "SELECT * FROM yardimci_linkler ORDER BY id");
  }
  return dbFetchAll(
    $db,
    "SELECT t.*, k.slug AS kategori
         FROM yardimci_linkler t
         LEFT JOIN yardimci_linkler_kategori k ON k.id = t.kategori_id
         ORDER BY t.id",
  );
}

function dbFetchOneYardimciLink(PDO $db, int $id): ?array
{
  if ($id <= 0) {
    return null;
  }
  if (dbColumnExists($db, "yardimci_linkler", "kategori")) {
    return dbFetchOne($db, "SELECT * FROM yardimci_linkler WHERE id = ?", [$id]);
  }
  return dbFetchOne(
    $db,
    "SELECT t.*, k.slug AS kategori
         FROM yardimci_linkler t
         LEFT JOIN yardimci_linkler_kategori k ON k.id = t.kategori_id
         WHERE t.id = ?",
    [$id],
  );
}

function dbYardimciLinkKategoriLabel(array $row, array $katMap): string
{
  $slug = (string) ($row["kategori"] ?? "");
  return $katMap[$slug] ?? $slug;
}

function dbYardimciLinkInsert(
  PDO $db,
  string $baslik,
  string $kategoriSlug,
  ?string $logo,
  string $hedef,
): void {
  if (dbColumnExists($db, "yardimci_linkler", "kategori")) {
    $db->prepare(
      "INSERT INTO yardimci_linkler (baslik, kategori, logo_url, hedef_url) VALUES (?, ?, ?, ?)",
    )->execute([$baslik, $kategoriSlug, $logo, $hedef]);
    return;
  }
  $kategoriId = dbYardimciLinklerKategoriId($db, $kategoriSlug);
  $db->prepare(
    "INSERT INTO yardimci_linkler (baslik, kategori_id, logo_url, hedef_url) VALUES (?, ?, ?, ?)",
  )->execute([$baslik, $kategoriId, $logo, $hedef]);
}

function dbYardimciLinkUpdate(
  PDO $db,
  int $id,
  string $baslik,
  string $kategoriSlug,
  ?string $logo,
  string $hedef,
): void {
  if (dbColumnExists($db, "yardimci_linkler", "kategori")) {
    $db->prepare(
      "UPDATE yardimci_linkler SET baslik=?, kategori=?, logo_url=?, hedef_url=? WHERE id=?",
    )->execute([$baslik, $kategoriSlug, $logo, $hedef, $id]);
    return;
  }
  $kategoriId = dbYardimciLinklerKategoriId($db, $kategoriSlug);
  $db->prepare(
    "UPDATE yardimci_linkler SET baslik=?, kategori_id=?, logo_url=?, hedef_url=? WHERE id=?",
  )->execute([$baslik, $kategoriId, $logo, $hedef, $id]);
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
  string $onUpdate = "RESTRICT",
): void {
  try {
    $cols = implode("`, `", $columns);
    $refCols = implode("`, `", $refColumns);
    $db->exec(
      "ALTER TABLE `{$table}`
             ADD CONSTRAINT `{$fkName}`
             FOREIGN KEY (`{$cols}`) REFERENCES `{$refTable}` (`{$refCols}`)
             ON DELETE {$onDelete} ON UPDATE {$onUpdate}",
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
    $now = new DateTimeImmutable("now");
    $expiresAt = $now->modify("+{$days} days")->format("Y-m-d H:i:s");

    $stmt = $db->prepare(
      "UPDATE personeller SET remember_token_hash = ?, remember_token_expires = ? WHERE id = ?",
    );
    $stmt->execute([$hash, $expiresAt, $personelId]);

    $cookieValue = $personelId . ":" . $token;
    setcookie(authRememberCookieName(), $cookieValue, [
      "expires" => time() + $days * 86400,
      "path" => "/",
      "secure" => false, // XAMPP genelde http
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
      $stmt = $db->prepare(
        "UPDATE personeller SET remember_token_hash = NULL, remember_token_expires = NULL WHERE id = ?",
      );
      $stmt->execute([$personelId]);
    }
  } catch (Throwable $e) {
    // Sessizce geç
  }

  setcookie(authRememberCookieName(), "", [
    "expires" => time() - 3600,
    "path" => "/",
    "secure" => false,
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
  $personelId = (int) $idStr;
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
             LIMIT 1",
    );
    $stmt->execute([$personelId, $hash]);
    $personel = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$personel) {
      return false;
    }

    // Session bilgilerini doldur
    $_SESSION["personel_id"] = $personel["id"];
    $_SESSION["sicil_no"] = $personel["sicil_no"];
    $_SESSION["email"] = $personel["email"];
    $_SESSION["fotograf"] = !empty($personel["foto_url"])
      ? $personel["foto_url"]
      : "../images/login/login.jpg";
    $_SESSION["ad"] = $personel["ad"];
    $_SESSION["soyad"] = $personel["soyad"];
    if (empty($_SESSION["oturum_id"])) {
      $_SESSION["oturum_id"] = oturumStart($db, (int) $personel["id"]);
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
  return array_map(
    fn($r) => [
      "id" => (int) $r["id"],
      "title" => $r["baslik"],
      "excerpt" => $r["aciklama"] ?? "",
      "date" => !empty($r["tarih"]) ? date("d.m.Y", strtotime($r["tarih"])) : "",
      "endDate" => !empty($r["bitis_tarihi"] ?? $r["tarih"])
        ? date("d.m.Y", strtotime($r["bitis_tarihi"] ?? $r["tarih"]))
        : "",
      "views" => (int) ($r["view"] ?? 0),
      "status" => dbEtkinliklerResolveDurum($r),
      "statusLabel" => dbEtkinliklerPublicDurumLabel(dbEtkinliklerResolveDurum($r)),
      "image" => imgUrl($r["resim"] ?? ""),
    ],
    $rows,
  );
}

function dbEtkinliklerHasDurumColumn(PDO $db): bool
{
  return dbColumnExists($db, "etkinlikler", "durum");
}

/**
 * etkinlikler.durum kolonu yoksa ekler; boş/geçersiz kayıtları bitiş tarihine göre doldurur.
 */
function dbEnsureEtkinliklerDurum(PDO $db): void
{
  if (!dbHasAnyTable($db, ["etkinlikler"])) {
    return;
  }

  dbEnsureColumn($db, "etkinlikler", "durum", "VARCHAR(20) NOT NULL DEFAULT 'aktif'");

  $rows = dbFetchAll($db, "SELECT id, tarih, bitis_tarihi, durum FROM etkinlikler");
  foreach ($rows as $row) {
    $durum = trim((string) ($row["durum"] ?? ""));
    if (in_array($durum, ["aktif", "pasif"], true)) {
      continue;
    }
    $db->prepare("UPDATE etkinlikler SET durum = ? WHERE id = ?")->execute([
      dbEtkinliklerResolveDurumFromDates($row),
      (int) $row["id"],
    ]);
  }
}

/** Yalnızca tarih alanlarına bakarak aktif/pasif türetir (durum kolonu yedek). */
function dbEtkinliklerResolveDurumFromDates(array $row): string
{
  $bitis = $row["bitis_tarihi"] ?? $row["tarih"] ?? null;
  if (empty($bitis)) {
    return "aktif";
  }

  $ts = strtotime((string) $bitis);
  if ($ts === false) {
    return "aktif";
  }

  return $ts >= strtotime("today") ? "aktif" : "pasif";
}

/** durum kolonu yoksa bitiş tarihine göre aktif/pasif döndürür. */
function dbEtkinliklerResolveDurum(array $row): string
{
  $durum = trim((string) ($row["durum"] ?? ""));
  if ($durum !== "" && in_array($durum, ["aktif", "pasif"], true)) {
    return $durum;
  }

  return dbEtkinliklerResolveDurumFromDates($row);
}

function dbEtkinliklerDurumLabel(string $durum): string
{
  return $durum === "aktif" ? "Aktif" : "Pasif";
}

function dbEtkinliklerPublicDurumLabel(string $durum): string
{
  return $durum === "aktif" ? "Aktif" : "SÜRESİ DOLDU";
}

function mapSizdenGelenler(array $rows): array
{
  return array_map(
    fn($r) => [
      "id" => (int) $r["id"],
      "title" => $r["baslik"],
      "excerpt" => $r["ozet"] ?? "",
      "category" => $r["kategori_slug"] ?? "",
      "categoryName" => $r["kategori_adi"] ?? "",
      "date" => !empty($r["tarih"]) ? date("d.m.Y", strtotime($r["tarih"])) : "",
      "views" => (int) ($r["goruntulenme"] ?? 0),
      "image" => imgUrl($r["gorsel_yolu"] ?? ""),
    ],
    $rows,
  );
}

function mapPersonelJs(array $rows): array
{
  return array_map(
    fn($r) => [
      "id" => (int) $r["id"],
      "ad" => $r["ad"],
      "soyad" => $r["soyad"],
      "dogumTarihi" => $r["dogum_tarihi"],
      "fotoUrl" => imgUrl($r["foto_url"] ?? "", "../images/login/login.jpg"),
    ],
    $rows,
  );
}

function mapVefat(array $rows): array
{
  return array_map(
    fn($r) => [
      "name" => $r["vefat_eden_adi"],
      "position" => $r["iliski_pozisyon"] ?? "",
      "deathDate" => $r["vefat_tarihi_metin"] ?? "",
      "message" => $r["cenaze_mesaji"] ?? "",
    ],
    $rows,
  );
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
    "ı" => "i",
    "İ" => "i",
    "ş" => "s",
    "Ş" => "s",
    "ğ" => "g",
    "Ğ" => "g",
    "ü" => "u",
    "Ü" => "u",
    "ö" => "o",
    "Ö" => "o",
    "ç" => "c",
    "Ç" => "c",
  ];
  $title = strtr($title, $map);
  $title =
    preg_replace(
      "/\b(tamamlandi|kutlandi|gerceklesti|buyuk|ilgi|gordu|unutulmadi|dedik|actik|bizimle|ile|icin|ve|nefes|kesti)\b/u",
      " ",
      $title,
    ) ?? $title;
  $title = preg_replace("/[^a-z0-9\s]+/u", " ", $title) ?? $title;
  $title = preg_replace("/\s+/u", " ", trim($title)) ?? trim($title);
  return $title;
}

/**
 * Yalnızca aynı / çok benzer etkinlik varsa eşleştirir.
 * Zayıf benzerlikte null döner → duyuru kendi sayfasında açılır.
 */
function dbResolveAnasayfaDuyuruEtkinlikId(PDO $db, array $duyuru): ?int
{
  static $cache = [];
  $duyuruId = (int) ($duyuru["id"] ?? 0);
  if ($duyuruId > 0 && array_key_exists($duyuruId, $cache)) {
    return $cache[$duyuruId];
  }

  $needle = normalizeLookupTitle((string) ($duyuru["baslik"] ?? ""));
  if ($needle === "") {
    return $cache[$duyuruId] = null;
  }

  $needleTokens = array_values(
    array_filter(explode(" ", $needle), static fn($t) => mb_strlen($t, "UTF-8") >= 3),
  );
  if (count($needleTokens) < 2) {
    return $cache[$duyuruId] = null;
  }

  $etkinlikler = dbFetchAll($db, "SELECT id, baslik FROM etkinlikler");
  $bestId = null;
  $bestScore = 0.0;

  foreach ($etkinlikler as $e) {
    $hay = normalizeLookupTitle((string) ($e["baslik"] ?? ""));
    if ($hay === "") {
      continue;
    }

    $hayTokens = array_values(
      array_filter(explode(" ", $hay), static fn($t) => mb_strlen($t, "UTF-8") >= 3),
    );
    if (count($hayTokens) < 2) {
      continue;
    }

    if ($needle === $hay) {
      $score = 1.0;
    } elseif (str_contains($hay, $needle) || str_contains($needle, $hay)) {
      $score = 0.95;
    } else {
      $common = count(array_intersect($needleTokens, $hayTokens));
      if ($common < 2) {
        continue;
      }
      $union = count(array_unique(array_merge($needleTokens, $hayTokens)));
      $score = $union > 0 ? $common / $union : 0.0;
      $coverage = $common / count($needleTokens);
      $score = min($score, $coverage);
    }

    if ($score > $bestScore) {
      $bestScore = $score;
      $bestId = (int) $e["id"];
    }
  }

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
    if ($etkinlikId) {
      $etkinlik = dbFetchOne($db, "SELECT `view` FROM etkinlikler WHERE id = ?", [$etkinlikId]);
      if ($etkinlik) {
        $r["view"] = (int) ($etkinlik["view"] ?? 0);
      }
    }
    $r["detail_url"] = $etkinlikId
      ? "etkinlikd.php?id=" . $etkinlikId
      : "duyurud.php?id=" . (int) ($r["id"] ?? 0);
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
             ORDER BY t.id",
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
    "haberler",
    "etkinlikler",
    "videolar",
    "sizden_gelenler",
    "personeller",
    "vefat_bilgileri",
    "yardimci_linkler",
    "anketler",
    "haber_galeri",
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

    $hasKategoriColumn = dbColumnExists($db, "videolar", "kategori");
    $hasKategoriId = dbColumnExists($db, "videolar", "kategori_id");

    if ($hasKategoriId && $hasKategoriColumn) {
      $stmt = $db->prepare(
        "INSERT INTO videolar (youtube_id, baslik, aciklama, kategori, kategori_id, sure) VALUES (?, ?, ?, ?, ?, ?)",
      );
    } elseif ($hasKategoriId) {
      $stmt = $db->prepare(
        "INSERT INTO videolar (youtube_id, baslik, aciklama, kategori_id, sure) VALUES (?, ?, ?, ?, ?)",
      );
    } elseif ($hasKategoriColumn) {
      $stmt = $db->prepare(
        "INSERT INTO videolar (youtube_id, baslik, aciklama, kategori, sure) VALUES (?, ?, ?, ?, ?)",
      );
    } else {
      $stmt = $db->prepare(
        "INSERT INTO videolar (youtube_id, baslik, aciklama, sure) VALUES (?, ?, ?, ?)",
      );
    }

    foreach ($rows as $row) {
      $kategoriSlug = dbVideolarResolveKategoriSlug($db, $row);
      $params = [$row["youtube_id"], $row["baslik"], $row["aciklama"]];
      if ($hasKategoriColumn) {
        $params[] = $kategoriSlug;
      }
      if ($hasKategoriId) {
        $params[] = dbVideolarKategoriId($db, $kategoriSlug);
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
    "SELECT COUNT(*) AS total, COALESCE(MAX(id), 0) AS max_id FROM videolar",
  );
  if (!$stats) {
    return;
  }

  $total = (int) $stats["total"];
  $maxId = (int) $stats["max_id"];

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
  $video = dbFillVideoFromYoutube($db, $video);

  $rows = dbFetchAll($db, "SELECT * FROM videolar ORDER BY id ASC");
  array_unshift($rows, [
    "youtube_id" => $video["youtube_id"],
    "baslik" => $video["baslik"] ?? "",
    "aciklama" => $video["aciklama"] ?? "",
    "kategori" => $video["kategori"] ?? "duyurular",
    "sure" => $video["sure"] ?? "00:00",
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

function dbUpdateVideo(PDO $db, int $id, array $video): bool
{
  $existing = dbFetchOne($db, "SELECT * FROM videolar WHERE id = ?", [$id]);
  if (!$existing) {
    return false;
  }

  $merged = array_merge($existing, $video);
  $merged = dbFillVideoFromYoutube($db, $merged);

  $hasVitrin = dbColumnExists($db, "videolar", "vitrin");
  if ($hasVitrin && !empty($merged["vitrin"])) {
    $clear = $db->prepare("UPDATE videolar SET vitrin = 0 WHERE id != ?");
    $clear->execute([$id]);
  }

  $hasKategoriColumn = dbColumnExists($db, "videolar", "kategori");
  $hasKategoriId = dbColumnExists($db, "videolar", "kategori_id");
  $kategoriSlug = dbVideolarResolveKategoriSlug($db, $merged);
  if (!empty($video["kategori"])) {
    $kategoriSlug = trim((string) $video["kategori"]);
  }
  $kategoriId = $hasKategoriId ? dbVideolarKategoriId($db, $kategoriSlug) : null;

  if ($hasKategoriId) {
    if ($hasVitrin) {
      if ($hasKategoriColumn) {
        $stmt = $db->prepare(
          "UPDATE videolar
                 SET youtube_id = ?, baslik = ?, aciklama = ?, kategori = ?, kategori_id = ?, sure = ?,
                     vitrin_baslik = ?, vitrin_aciklama = ?, vitrin = ?
                 WHERE id = ?",
        );
        $stmt->execute([
          $merged["youtube_id"],
          $merged["baslik"] ?? "",
          $merged["aciklama"] ?? "",
          $kategoriSlug,
          $kategoriId,
          $merged["sure"] ?? "00:00",
          $merged["vitrin_baslik"] ?? null,
          $merged["vitrin_aciklama"] ?? null,
          !empty($merged["vitrin"]) ? 1 : 0,
          $id,
        ]);
      } else {
        $stmt = $db->prepare(
          "UPDATE videolar
                 SET youtube_id = ?, baslik = ?, aciklama = ?, kategori_id = ?, sure = ?,
                     vitrin_baslik = ?, vitrin_aciklama = ?, vitrin = ?
                 WHERE id = ?",
        );
        $stmt->execute([
          $merged["youtube_id"],
          $merged["baslik"] ?? "",
          $merged["aciklama"] ?? "",
          $kategoriId,
          $merged["sure"] ?? "00:00",
          $merged["vitrin_baslik"] ?? null,
          $merged["vitrin_aciklama"] ?? null,
          !empty($merged["vitrin"]) ? 1 : 0,
          $id,
        ]);
      }
    } elseif ($hasKategoriColumn) {
      $stmt = $db->prepare(
        "UPDATE videolar
                 SET youtube_id = ?, baslik = ?, aciklama = ?, kategori = ?, kategori_id = ?, sure = ?
                 WHERE id = ?",
      );
      $stmt->execute([
        $merged["youtube_id"],
        $merged["baslik"] ?? "",
        $merged["aciklama"] ?? "",
        $kategoriSlug,
        $kategoriId,
        $merged["sure"] ?? "00:00",
        $id,
      ]);
    } else {
      $stmt = $db->prepare(
        "UPDATE videolar
                 SET youtube_id = ?, baslik = ?, aciklama = ?, kategori_id = ?, sure = ?
                 WHERE id = ?",
      );
      $stmt->execute([
        $merged["youtube_id"],
        $merged["baslik"] ?? "",
        $merged["aciklama"] ?? "",
        $kategoriId,
        $merged["sure"] ?? "00:00",
        $id,
      ]);
    }
  } else {
    if ($hasVitrin) {
      $stmt = $db->prepare(
        "UPDATE videolar
                 SET youtube_id = ?, baslik = ?, aciklama = ?, kategori = ?, sure = ?,
                     vitrin_baslik = ?, vitrin_aciklama = ?, vitrin = ?
                 WHERE id = ?",
      );
      $stmt->execute([
        $merged["youtube_id"],
        $merged["baslik"] ?? "",
        $merged["aciklama"] ?? "",
        $kategoriSlug,
        $merged["sure"] ?? "00:00",
        $merged["vitrin_baslik"] ?? null,
        $merged["vitrin_aciklama"] ?? null,
        !empty($merged["vitrin"]) ? 1 : 0,
        $id,
      ]);
    } else {
      $stmt = $db->prepare(
        "UPDATE videolar
                 SET youtube_id = ?, baslik = ?, aciklama = ?, kategori = ?, sure = ?
                 WHERE id = ?",
      );
      $stmt->execute([
        $merged["youtube_id"],
        $merged["baslik"] ?? "",
        $merged["aciklama"] ?? "",
        $kategoriSlug,
        $merged["sure"] ?? "00:00",
        $id,
      ]);
    }
  }

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
               AND COLUMN_NAME = ?",
    );
    $stmt->execute([$table, $column]);
    $exists = (int) ($stmt->fetch(PDO::FETCH_ASSOC)["c"] ?? 0) > 0;
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
  $mysql = "C:/xampp/mysql/bin/mysql.exe";
  if ($sqlFile && file_exists($mysql)) {
    $path = str_replace("\\", "/", $sqlFile);
    shell_exec(
      '"' . $mysql . '" -u root --default-character-set=utf8mb4 -e "SOURCE ' . $path . '" 2>nul',
    );
  }
}
?>
