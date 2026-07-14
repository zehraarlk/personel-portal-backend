<?php
require_once __DIR__ . "/../includes/auth.php";

$id = (int) ($_GET["id"] ?? 0);
$row = dbFetchOneYardimciLink($db, $id);
if (!$row) {
  adminFlashSet("danger", "Link bulunamadı.");
  header("Location: index.php");
  exit();
}

$currentPage = "linkler";
$pageTitle = "Link Düzenle";
$kategoriler = ["kurum-ici", "website", "bilgi", "faydalı"];
$katMap = dbYardimciLinklerKategoriAdiEslemesi();
$hata = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (!adminVerifyCsrf($_POST["csrf"] ?? null)) {
    $hata = "Geçersiz istek.";
  } else {
    $logo = adminUploadImage($_FILES["logo"] ?? [], "yardimci_linkler", $row["logo_url"] ?? null);
    if ($logo === null && !empty($_FILES["logo"]["name"])) {
      $hata = "Logo yüklenemedi.";
    } else {
      dbYardimciLinkUpdate(
        $db,
        $id,
        trim($_POST["baslik"] ?? ""),
        trim($_POST["kategori"] ?? ""),
        $logo,
        trim($_POST["hedef_url"] ?? ""),
      );
      adminFlashSet("success", "Link güncellendi.");
      header("Location: index.php");
      exit();
    }
  }
}

include __DIR__ . "/../includes/header.php";
?>

<div class="row justify-content-center"><div class="col-lg-8">
<div class="admin-card">
  <div class="admin-card-header"><h3>Link Düzenle #<?= $id ?></h3><a href="index.php" class="admin-btn admin-btn-secondary admin-btn-sm"><i class="fas fa-arrow-left"></i> Geri</a></div>
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
      <div class="mb-3"><label class="form-label">Kategori</label><select name="kategori" class="form-select"><?php foreach (
        $kategoriler
        as $k
      ): ?><option value="<?= htmlspecialchars($k, ENT_QUOTES, "UTF-8") ?>" <?= $row["kategori"] ===
$k
  ? "selected"
  : "" ?>><?= htmlspecialchars(
  $katMap[$k] ?? $k,
  ENT_QUOTES,
  "UTF-8",
) ?></option><?php endforeach; ?></select></div>
      <div class="mb-3"><label class="form-label">Hedef URL *</label><input type="url" name="hedef_url" class="form-control" required value="<?= htmlspecialchars(
        $row["hedef_url"],
        ENT_QUOTES,
        "UTF-8",
      ) ?>" /></div>
      <?= adminImageFieldHtml($assetBase, $row["logo_url"] ?? null, [
        "name" => "logo",
        "label" => "Logo",
        "hint" => "Yeni dosya seçerseniz mevcut logo değişir.",
      ]) ?>
      <button type="submit" class="admin-btn admin-btn-primary"><i class="fas fa-save"></i> Güncelle</button>
    </form>
  </div>
</div>
</div></div>

<?php include __DIR__ . "/../includes/footer.php"; ?>
