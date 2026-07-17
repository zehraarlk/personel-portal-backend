<?php
/**
 * Dosya sorumluluğu: Kaynak kaydı ekleme formunu ve kayıt işlemini yürütür.
 *
 * Girdi doğrulama, yetkilendirme ve çıktı kaçışları bu dosyanın
 * mevcut güvenlik akışına uygun biçimde korunmalıdır.
 */
require_once __DIR__ . "/../includes/auth.php";

$currentPage = "kaynaklar";
$pageTitle = "Yeni Kaynak";
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
$dokumanId = null;
foreach ($kategoriler as $k) {
  if ($k["slug"] === "Dökümanlar") {
    $dokumanId = (int) $k["id"];
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
    $onizleme = trim($_POST["onizleme"] ?? "") ?: null;
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

      $dosyaYolu = $dosyaUrl;
      if (!empty($_FILES["dosya"]["name"])) {
        $uploaded = adminUploadDocument($_FILES["dosya"], $subdir);
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
            $boyut = "-";
          }
          $db
            ->prepare(
              "INSERT INTO kaynaklar (baslik, aciklama, kategori_id, alt_kategori_id, ikon, dosya_yolu, resmi_sayfa, onizleme, boyut, tarih)
                         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
            )
            ->execute([
              $baslik,
              $aciklama,
              $kategoriId,
              $altKategoriId,
              $ikon,
              $dosyaYolu,
              $resmiSayfa,
              $onizleme,
              $boyut,
              $tarih,
            ]);

          adminFlashSet("success", "Kaynak eklendi.");
          header("Location: index.php");
          exit();
        }
      }
    }
  }
}

include __DIR__ . "/../includes/header.php";
?>

<div class="row justify-content-center"><div class="col-lg-9">
<div class="admin-card">
  <div class="admin-card-header"><h3>Yeni Kaynak</h3><a href="index.php" class="admin-btn admin-btn-secondary admin-btn-sm"><i class="fas fa-arrow-left"></i> Geri</a></div>
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
        $_POST["baslik"] ?? "",
        ENT_QUOTES,
        "UTF-8",
      ) ?>" /></div>
      <div class="mb-3"><label class="form-label">Açıklama *</label><textarea name="aciklama" class="form-control" rows="4" required><?= htmlspecialchars(
        $_POST["aciklama"] ?? "",
        ENT_QUOTES,
        "UTF-8",
      ) ?></textarea></div>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Kategori *</label>
          <select name="kategori_id" id="kategori_id" class="form-select" required>
            <option value="">Seçin</option>
            <?php foreach ($kategoriler as $kat): ?>
              <option value="<?= (int) $kat["id"] ?>" data-slug="<?= htmlspecialchars(
  $kat["slug"],
  ENT_QUOTES,
  "UTF-8",
) ?>" <?= (int) ($_POST["kategori_id"] ?? 0) === (int) $kat["id"]
  ? "selected"
  : "" ?>><?= htmlspecialchars($kat["ad"], ENT_QUOTES, "UTF-8") ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-6 mb-3" id="altKategoriWrap" style="<?= (int) ($_POST["kategori_id"] ??
          0) === $mevzuatId
          ? ""
          : "display:none" ?>">
          <label class="form-label">Alt Kategori (Mevzuat)</label>
          <select name="alt_kategori_id" class="form-select">
            <option value="">Seçin</option>
            <?php foreach ($altKategoriler as $alt): ?>
              <option value="<?= (int) $alt["id"] ?>" <?= (int) ($_POST["alt_kategori_id"] ?? 0) ===
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
              <option value="<?= htmlspecialchars(
                $cls,
                ENT_QUOTES,
                "UTF-8",
              ) ?>"><?= htmlspecialchars($label, ENT_QUOTES, "UTF-8") ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
      <div class="mb-3"><label class="form-label">Dosya URL</label><input type="url" name="dosya_url" class="form-control" placeholder="https://... veya YouTube linki (Eğitimler)" value="<?= htmlspecialchars(
        $_POST["dosya_url"] ?? "",
        ENT_QUOTES,
        "UTF-8",
      ) ?>" /><div class="admin-form-hint">Dosya yüklemezseniz URL kullanılır.</div></div>
      <div class="mb-3"><label class="form-label">Dosya Yükle</label><input type="file" name="dosya" class="form-control" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.zip" /></div>
      <div class="mb-3"><label class="form-label">Resmi Sayfa URL (Mevzuat)</label><input type="url" name="resmi_sayfa" class="form-control" placeholder="https://www.mevzuat.gov.tr/..." value="<?= htmlspecialchars(
        $_POST["resmi_sayfa"] ?? "",
        ENT_QUOTES,
        "UTF-8",
      ) ?>" /></div>
      <div class="mb-3" id="onizlemeWrap" style="<?= (int) ($_POST["kategori_id"] ??
        0) === $dokumanId
        ? ""
        : "display:none" ?>">
        <label class="form-label">Önizleme Linki (Dökümanlar)</label>
        <input type="url" name="onizleme" class="form-control" placeholder="https://docs.google.com/viewer?url=... veya alternatif önizleme linki" value="<?= htmlspecialchars(
          $_POST["onizleme"] ?? "",
          ENT_QUOTES,
          "UTF-8",
        ) ?>" />
        <div class="admin-form-hint">Boş bırakılırsa, sitede önizleme için doğrudan dosya kullanılır.</div>
      </div>
      <div class="row">
        <div class="col-md-6 mb-3"><label class="form-label">Boyut</label><input type="text" name="boyut" class="form-control" placeholder="örn: 2.3 MB (boşsa otomatik)" value="<?= htmlspecialchars(
          $_POST["boyut"] ?? "",
          ENT_QUOTES,
          "UTF-8",
        ) ?>" /></div>
        <div class="col-md-6 mb-3"><label class="form-label">Tarih</label><input type="text" name="tarih" class="form-control" value="<?= htmlspecialchars(
          $_POST["tarih"] ?? date("d.m.Y"),
          ENT_QUOTES,
          "UTF-8",
        ) ?>" /></div>
      </div>
      <button type="submit" class="admin-btn admin-btn-primary"><i class="fas fa-save"></i> Kaydet</button>
    </form>
  </div>
</div>
</div></div>

<script>
document.getElementById("kategori_id")?.addEventListener("change", function () {
  const opt = this.options[this.selectedIndex];
  const wrap = document.getElementById("altKategoriWrap");
  if (wrap) wrap.style.display = opt?.dataset?.slug === "Mevzuatlar" ? "" : "none";
  const onizlemeWrap = document.getElementById("onizlemeWrap");
  if (onizlemeWrap) onizlemeWrap.style.display = opt?.dataset?.slug === "Dökümanlar" ? "" : "none";
});
</script>

<?php include __DIR__ . "/../includes/footer.php"; ?>