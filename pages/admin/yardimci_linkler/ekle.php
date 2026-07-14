<?php
require_once __DIR__ . "/../includes/auth.php";

$currentPage = "linkler";
$pageTitle = "Yeni Link";
$kategoriler = ["kurum-ici", "website", "bilgi", "faydalı"];
$katMap = dbYardimciLinklerKategoriAdiEslemesi();
$hata = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (!adminVerifyCsrf($_POST["csrf"] ?? null)) {
    $hata = "Geçersiz istek.";
  } else {
    $baslik = trim($_POST["baslik"] ?? "");
    $kategori = trim($_POST["kategori"] ?? "");
    $hedef = trim($_POST["hedef_url"] ?? "");
    if ($baslik === "" || $hedef === "") {
      $hata = "Başlık ve URL zorunludur.";
    } else {
      $logo = adminUploadImage($_FILES["logo"] ?? [], "yardimci_linkler");
      if ($logo === null && !empty($_FILES["logo"]["name"])) {
        $hata = "Logo yüklenemedi.";
      } else {
        dbYardimciLinkInsert($db, $baslik, $kategori, $logo, $hedef);
        adminFlashSet("success", "Link eklendi.");
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
  <div class="admin-card-header"><h3>Yeni Link</h3><a href="index.php" class="admin-btn admin-btn-secondary admin-btn-sm"><i class="fas fa-arrow-left"></i> Geri</a></div>
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
      <div class="mb-3"><label class="form-label">Kategori</label><select name="kategori" class="form-select"><?php foreach (
        $kategoriler
        as $k
      ): ?><option value="<?= htmlspecialchars($k, ENT_QUOTES, "UTF-8") ?>"><?= htmlspecialchars(
  $katMap[$k] ?? $k,
  ENT_QUOTES,
  "UTF-8",
) ?></option><?php endforeach; ?></select></div>
      <div class="mb-3"><label class="form-label">Hedef URL *</label><input type="url" name="hedef_url" class="form-control" required placeholder="https://..." /></div>
      <div class="mb-4"><?= adminImageFieldHtml($assetBase, null, [
        "name" => "logo",
        "label" => "Logo",
      ]) ?></div>
      <button type="submit" class="admin-btn admin-btn-primary"><i class="fas fa-save"></i> Kaydet</button>
    </form>
  </div>
</div>
</div></div>

<?php include __DIR__ . "/../includes/footer.php"; ?>
