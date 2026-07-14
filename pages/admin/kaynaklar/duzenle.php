<?php
require_once __DIR__ . "/../includes/auth.php";

$id = (int) ($_GET["id"] ?? 0);
$row = $id > 0 ? dbFetchOne($db, "SELECT * FROM kaynaklar WHERE id = ?", [$id]) : null;
if (!$row) {
  adminFlashSet("danger", "Kaynak bulunamadı.");
  header("Location: index.php");
  exit();
}

$currentPage = "kaynaklar";
$pageTitle = "Kaynak Düzenle";
$kategoriler = dbKaynaklarKategoriler($db);
$ikonlar = [
  "fas fa-file-pdf" => "PDF",
  "fas fa-file-alt" => "Döküman",
  "fas fa-gavel" => "Mevzuat",
  "fas fa-graduation-cap" => "Eğitim",
  "fas fa-handshake" => "Protokol",
  "fas fa-hospital" => "Hastane",
  "fas fa-tooth" => "Diş",
  "fa-file-signature" => "İmza",
  "fas fa-file" => "Genel",
];
$hata = "";

$mevzuatId = null;
$slugMap = [
  "Protokoller" => "protokoller",
  "Dökümanlar" => "dokumanlar",
  "Mevzuatlar" => "mevzuatlar",
  "Eğitimler" => "egitimler",
];
foreach ($kategoriler as $k) {
  if ($k["slug"] === "Mevzuatlar") {
    $mevzuatId = (int) $k["id"];
    break;
  }
}
$altKategoriler = $mevzuatId ? dbKaynaklarAltKategoriler($db, $mevzuatId) : [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (!adminVerifyCsrf($_POST["csrf"] ?? null)) {
    $hata = "Geçersiz istek.";
  } else {
    $baslik = trim($_POST["baslik"] ?? "");
    $aciklama = trim($_POST["aciklama"] ?? "");
    $kategoriId = (int) ($_POST["kategori_id"] ?? 0);
    $altKategoriId = (int) ($_POST["alt_kategori_id"] ?? 0) ?: null;
    $ikon = trim($_POST["ikon"] ?? "fas fa-file");
    $dosyaUrl = trim($_POST["dosya_url"] ?? "");
    $resmiSayfa = trim($_POST["resmi_sayfa"] ?? "") ?: null;
    $boyut = trim($_POST["boyut"] ?? "");
    $tarih = trim($_POST["tarih"] ?? "") ?: date("d.m.Y");

    if ($baslik === "" || $aciklama === "" || $kategoriId <= 0) {
      $hata = "Başlık, açıklama ve kategori zorunludur.";
    } else {
      $kategoriSlug = "";
      foreach ($kategoriler as $kat) {
        if ((int) $kat["id"] === $kategoriId) {
          $kategoriSlug = $kat["slug"];
          break;
        }
      }
      $subdir = $slugMap[$kategoriSlug] ?? "dokumanlar";

      $dosyaYolu = $row["dosya_yolu"];
      if ($dosyaUrl !== "") {
        $dosyaYolu = $dosyaUrl;
      }
      if (!empty($_FILES["dosya"]["name"])) {
        $uploaded = adminUploadDocument($_FILES["dosya"], $subdir, $row["dosya_yolu"] ?? null);
        if ($uploaded === null) {
          $hata = "Dosya yüklenemedi. PDF, Word veya Excel dosyası seçin.";
        } else {
          $dosyaYolu = $uploaded;
          $relative = preg_replace("#^(\.\./)+#", "", $uploaded);
          $fullPath = realpath(__DIR__ . "/../../../" . $relative);
          if ($boyut === "" && $fullPath && is_file($fullPath)) {
            $boyut = adminFormatFileSize((int) filesize($fullPath));
          }
        }
      }

      if ($hata === "") {
        if ($dosyaYolu === "") {
          $hata = "Dosya URL'si girin veya dosya yükleyin.";
        } else {
          if ($boyut === "") {
            $boyut = $row["boyut"] ?? "-";
          }
          $db
            ->prepare(
              "UPDATE kaynaklar SET baslik=?, aciklama=?, kategori_id=?, alt_kategori_id=?, ikon=?, dosya_yolu=?, resmi_sayfa=?, boyut=?, tarih=? WHERE id=?",
            )
            ->execute([
              $baslik,
              $aciklama,
              $kategoriId,
              $altKategoriId,
              $ikon,
              $dosyaYolu,
              $resmiSayfa,
              $boyut,
              $tarih,
              $id,
            ]);

          adminFlashSet("success", "Kaynak güncellendi.");
          header("Location: index.php");
          exit();
        }
      }
    }
  }
}

$dosyaGoruntule = adminImgUrl($assetBase, $row["dosya_yolu"] ?? "");

include __DIR__ . "/../includes/header.php";
?>

<div class="row justify-content-center"><div class="col-lg-9">
<div class="admin-card">
  <div class="admin-card-header"><h3>Kaynak Düzenle #<?= $id ?></h3><a href="index.php" class="admin-btn admin-btn-secondary admin-btn-sm"><i class="fas fa-arrow-left"></i> Geri</a></div>
  <div class="admin-card-body">
    <?php if ($hata): ?><div class="admin-alert admin-alert-danger"><?= htmlspecialchars(
  $hata,
  ENT_QUOTES,
  "UTF-8",
) ?></div><?php endif; ?>
    <form method="post" enctype="multipart/form-data" class="admin-form">
      <input type="hidden" name="csrf" value="<?= htmlspecialchars(
        adminCsrfToken(),
        ENT_QUOTES,
        "UTF-8",
      ) ?>" />
      <div class="mb-3"><label class="form-label">Başlık *</label><input type="text" name="baslik" class="form-control" required value="<?= htmlspecialchars(
        $row["baslik"],
        ENT_QUOTES,
        "UTF-8",
      ) ?>" /></div>
      <div class="mb-3"><label class="form-label">Açıklama *</label><textarea name="aciklama" class="form-control" rows="4" required><?= htmlspecialchars(
        $row["aciklama"],
        ENT_QUOTES,
        "UTF-8",
      ) ?></textarea></div>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Kategori *</label>
          <select name="kategori_id" id="kategori_id" class="form-select" required>
            <?php foreach ($kategoriler as $kat): ?>
              <option value="<?= (int) $kat["id"] ?>" data-slug="<?= htmlspecialchars(
  $kat["slug"],
  ENT_QUOTES,
  "UTF-8",
) ?>" <?= (int) $row["kategori_id"] === (int) $kat["id"] ? "selected" : "" ?>><?= htmlspecialchars(
  $kat["ad"],
  ENT_QUOTES,
  "UTF-8",
) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-6 mb-3" id="altKategoriWrap" style="<?= (int) $row["kategori_id"] ===
        $mevzuatId
          ? ""
          : "display:none" ?>">
          <label class="form-label">Alt Kategori (Mevzuat)</label>
          <select name="alt_kategori_id" class="form-select">
            <option value="">Seçin</option>
            <?php foreach ($altKategoriler as $alt): ?>
              <option value="<?= (int) $alt["id"] ?>" <?= (int) ($row["alt_kategori_id"] ?? 0) ===
(int) $alt["id"]
  ? "selected"
  : "" ?>><?= htmlspecialchars($alt["ad"], ENT_QUOTES, "UTF-8") ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">İkon</label>
          <select name="ikon" class="form-select">
            <?php foreach ($ikonlar as $cls => $label): ?>
              <option value="<?= htmlspecialchars($cls, ENT_QUOTES, "UTF-8") ?>" <?= ($row[
  "ikon"
] ??
  "") ===
$cls
  ? "selected"
  : "" ?>><?= htmlspecialchars($label, ENT_QUOTES, "UTF-8") ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
      <?php if (!empty($row["dosya_yolu"])): ?>
        <div class="mb-3">
          <label class="form-label">Mevcut Dosya</label>
          <div><a href="<?= htmlspecialchars(
            $dosyaGoruntule,
            ENT_QUOTES,
            "UTF-8",
          ) ?>" target="_blank" class="admin-btn admin-btn-secondary admin-btn-sm"><i class="fas fa-external-link-alt"></i> Dosyayı aç</a></div>
        </div>
      <?php endif; ?>
      <div class="mb-3"><label class="form-label">Dosya URL</label><input type="url" name="dosya_url" class="form-control" placeholder="https://..." value="<?= htmlspecialchars(
        preg_match("#^https?://#i", $row["dosya_yolu"] ?? "") ? $row["dosya_yolu"] : "",
        ENT_QUOTES,
        "UTF-8",
      ) ?>" /><div class="admin-form-hint">Yeni URL girerseniz mevcut dosya yolu değişir.</div></div>
      <div class="mb-3"><label class="form-label">Yeni Dosya Yükle</label><input type="file" name="dosya" class="form-control" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.zip" /></div>
      <div class="mb-3"><label class="form-label">Resmi Sayfa URL (Mevzuat)</label><input type="url" name="resmi_sayfa" class="form-control" value="<?= htmlspecialchars(
        $row["resmi_sayfa"] ?? "",
        ENT_QUOTES,
        "UTF-8",
      ) ?>" /></div>
      <div class="row">
        <div class="col-md-6 mb-3"><label class="form-label">Boyut</label><input type="text" name="boyut" class="form-control" value="<?= htmlspecialchars(
          $row["boyut"] ?? "",
          ENT_QUOTES,
          "UTF-8",
        ) ?>" /></div>
        <div class="col-md-6 mb-3"><label class="form-label">Tarih</label><input type="text" name="tarih" class="form-control" value="<?= htmlspecialchars(
          $row["tarih"] ?? "",
          ENT_QUOTES,
          "UTF-8",
        ) ?>" /></div>
      </div>
      <button type="submit" class="admin-btn admin-btn-primary"><i class="fas fa-save"></i> Güncelle</button>
    </form>
  </div>
</div>
</div></div>

<script>
document.getElementById("kategori_id")?.addEventListener("change", function () {
  const opt = this.options[this.selectedIndex];
  const wrap = document.getElementById("altKategoriWrap");
  if (!wrap) return;
  wrap.style.display = opt?.dataset?.slug === "Mevzuatlar" ? "" : "none";
});
</script>

<?php include __DIR__ . "/../includes/footer.php"; ?>
