<?php
/**
 * Dosya sorumluluğu: Etkinlik kaydı ekleme formunu ve kayıt işlemini yürütür.
 *
 * Girdi doğrulama, yetkilendirme ve çıktı kaçışları bu dosyanın
 * mevcut güvenlik akışına uygun biçimde korunmalıdır.
 */
require_once __DIR__ . "/../includes/auth.php";

$currentPage = "etkinlikler";
$pageTitle = "Yeni Etkinlik";
$hata = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (!adminVerifyCsrf($_POST["csrf"] ?? null)) {
    $hata = "Geçersiz istek.";
  } else {
    $baslik = trim($_POST["baslik"] ?? "");
    $aciklama = trim($_POST["aciklama"] ?? "");
    $tarih = trim($_POST["tarih"] ?? "");
    $bitis = trim($_POST["bitis_tarihi"] ?? "") ?: null;
    $durum = in_array($_POST["durum"] ?? "", ["aktif", "pasif"], true) ? $_POST["durum"] : "aktif";

    if ($baslik === "" || $tarih === "") {
      $hata = "Başlık ve başlangıç tarihi zorunludur.";
    } else {
      $resim = adminUploadImage($_FILES["resim"] ?? [], "etkinlikler");
      if ($resim === null && !empty($_FILES["resim"]["name"])) {
        $hata = "Görsel yüklenemedi.";
      } else {
        $db
          ->prepare(
            "INSERT INTO etkinlikler (baslik, aciklama, tarih, bitis_tarihi, durum, resim, view) VALUES (?, ?, ?, ?, ?, ?, 0)",
          )
          ->execute([$baslik, $aciklama, $tarih, $bitis, $durum, $resim]);
        adminFlashSet("success", "Etkinlik eklendi.");
        header("Location: index.php");
        exit();
      }
    }
  }
}

include __DIR__ . "/../includes/header.php";
?>

<div class="row justify-content-center"><div class="col-lg-8">
<div class="admin-card">
  <div class="admin-card-header"><h3>Yeni Etkinlik</h3><a href="index.php" class="admin-btn admin-btn-secondary admin-btn-sm"><i class="fas fa-arrow-left"></i> Geri</a></div>
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
      <div class="mb-3"><label class="form-label">Başlık *</label><input type="text" name="baslik" class="form-control" required /></div>
      <div class="mb-3"><label class="form-label">Açıklama</label><textarea name="aciklama" class="form-control" rows="4"></textarea></div>
      <div class="row">
        <div class="col-md-4 mb-3"><label class="form-label">Başlangıç *</label><input type="date" name="tarih" class="form-control" required /></div>
        <div class="col-md-4 mb-3"><label class="form-label">Bitiş</label><input type="date" name="bitis_tarihi" class="form-control" /></div>
        <div class="col-md-4 mb-3"><label class="form-label">Durum</label><select name="durum" class="form-select"><option value="aktif">Aktif</option><option value="pasif">Pasif</option></select></div>
      </div>
      <div class="mb-4"><?= adminImageFieldHtml($assetBase, null, [
        "name" => "resim",
        "label" => "Görsel",
        "hint" => "JPG, PNG veya WEBP yükleyebilirsiniz.",
      ]) ?></div>
      <button type="submit" class="admin-btn admin-btn-primary"><i class="fas fa-save"></i> Kaydet</button>
    </form>
  </div>
</div>
</div></div>

<?php include __DIR__ . "/../includes/footer.php"; ?>
