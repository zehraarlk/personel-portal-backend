<?php
require_once __DIR__ . "/../includes/auth.php";

$id = (int) ($_GET["id"] ?? 0);
$row = $id > 0 ? dbFetchOne($db, "SELECT * FROM etkinlikler WHERE id = ?", [$id]) : null;
if (!$row) {
  adminFlashSet("danger", "Etkinlik bulunamadı.");
  header("Location: index.php");
  exit();
}

$currentPage = "etkinlikler";
$pageTitle = "Etkinlik Düzenle";
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
    $resim = adminUploadImage($_FILES["resim"] ?? [], "etkinlikler", $row["resim"] ?? null);

    if ($resim === null && !empty($_FILES["resim"]["name"])) {
      $hata = "Görsel yüklenemedi.";
    } elseif ($baslik === "" || $tarih === "") {
      $hata = "Başlık ve tarih zorunludur.";
    } else {
      $db
        ->prepare(
          "UPDATE etkinlikler SET baslik=?, aciklama=?, tarih=?, bitis_tarihi=?, durum=?, resim=? WHERE id=?",
        )
        ->execute([$baslik, $aciklama, $tarih, $bitis, $durum, $resim, $id]);
      adminFlashSet("success", "Etkinlik güncellendi.");
      header("Location: index.php");
      exit();
    }
  }
}

include __DIR__ . "/../includes/header.php";
?>

<div class="row justify-content-center"><div class="col-lg-8">
<div class="admin-card">
  <div class="admin-card-header"><h3>Etkinlik Düzenle #<?= $id ?></h3><a href="index.php" class="admin-btn admin-btn-secondary admin-btn-sm"><i class="fas fa-arrow-left"></i> Geri</a></div>
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
      <div class="mb-3"><label class="form-label">Açıklama</label><textarea name="aciklama" class="form-control" rows="4"><?= htmlspecialchars(
        $row["aciklama"] ?? "",
        ENT_QUOTES,
        "UTF-8",
      ) ?></textarea></div>
      <div class="row">
        <div class="col-md-4 mb-3"><label class="form-label">Başlangıç *</label><input type="date" name="tarih" class="form-control" required value="<?= htmlspecialchars(
          $row["tarih"],
          ENT_QUOTES,
          "UTF-8",
        ) ?>" /></div>
        <div class="col-md-4 mb-3"><label class="form-label">Bitiş</label><input type="date" name="bitis_tarihi" class="form-control" value="<?= htmlspecialchars(
          $row["bitis_tarihi"] ?? "",
          ENT_QUOTES,
          "UTF-8",
        ) ?>" /></div>
        <div class="col-md-4 mb-3"><label class="form-label">Durum</label><select name="durum" class="form-select"><?php $mevcutDurum = dbEtkinliklerResolveDurum(
          $row,
        ); ?><option value="aktif" <?= $mevcutDurum === "aktif"
          ? "selected"
          : "" ?>>Aktif</option><option value="pasif" <?= $mevcutDurum === "pasif"
  ? "selected"
  : "" ?>>Pasif</option></select></div>
      </div>
      <?= adminImageFieldHtml($assetBase, $row["resim"] ?? null, [
        "name" => "resim",
        "label" => "Görsel",
        "hint" => "Yeni dosya seçerseniz mevcut görsel değişir.",
      ]) ?>
      <button type="submit" class="admin-btn admin-btn-primary"><i class="fas fa-save"></i> Güncelle</button>
    </form>
  </div>
</div>
</div></div>

<?php include __DIR__ . "/../includes/footer.php"; ?>
