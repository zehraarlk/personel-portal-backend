<?php
require_once __DIR__ . "/../includes/auth.php";

$id = (int) ($_GET["id"] ?? 0);
$row = adminFetchAnket($db, $id);
if (!$row) {
  adminFlashSet("danger", "Anket bulunamadı.");
  header("Location: index.php");
  exit();
}

$currentPage = "anketler";
$pageTitle = "Anket Düzenle";
$durumlar = dbAnketlerKategoriAdiEslemesi();
$hata = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (!adminVerifyCsrf($_POST["csrf"] ?? null)) {
    $hata = "Geçersiz istek.";
  } else {
    $kategori = trim($_POST["kategori"] ?? "active");
    if (dbColumnExists($db, "anketler", "kategori")) {
      $db
        ->prepare(
          "UPDATE anketler SET baslik=?, aciklama=?, kategori=?, resim_url=?, baslangic_tarihi=?, bitis_tarihi=?, hedef_katilim=?, favori=? WHERE id=?",
        )
        ->execute([
          trim($_POST["baslik"] ?? ""),
          trim($_POST["aciklama"] ?? ""),
          $kategori,
          trim($_POST["resim_url"] ?? "") ?: null,
          trim($_POST["baslangic_tarihi"] ?? "") ?: null,
          trim($_POST["bitis_tarihi"] ?? "") ?: null,
          (int) ($_POST["hedef_katilim"] ?? 0),
          isset($_POST["favori"]) ? 1 : 0,
          $id,
        ]);
    } else {
      $kategoriId = dbAnketlerKategoriId($db, $kategori);
      $db
        ->prepare(
          "UPDATE anketler SET baslik=?, aciklama=?, kategori_id=?, resim_url=?, baslangic_tarihi=?, bitis_tarihi=?, hedef_katilim=?, favori=? WHERE id=?",
        )
        ->execute([
          trim($_POST["baslik"] ?? ""),
          trim($_POST["aciklama"] ?? ""),
          $kategoriId,
          trim($_POST["resim_url"] ?? "") ?: null,
          trim($_POST["baslangic_tarihi"] ?? "") ?: null,
          trim($_POST["bitis_tarihi"] ?? "") ?: null,
          (int) ($_POST["hedef_katilim"] ?? 0),
          isset($_POST["favori"]) ? 1 : 0,
          $id,
        ]);
    }
    adminFlashSet("success", "Anket güncellendi.");
    header("Location: index.php");
    exit();
  }
}

include __DIR__ . "/../includes/header.php";
?>

<div class="row justify-content-center"><div class="col-lg-8">
<div class="admin-card">
  <div class="admin-card-header"><h3>Anket Düzenle #<?= $id ?></h3><a href="index.php" class="admin-btn admin-btn-secondary admin-btn-sm"><i class="fas fa-arrow-left"></i> Geri</a></div>
  <div class="admin-card-body">
    <form method="post" class="admin-form">
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
      <div class="mb-3"><label class="form-label">Açıklama</label><textarea name="aciklama" class="form-control" rows="3"><?= htmlspecialchars(
        $row["aciklama"] ?? "",
        ENT_QUOTES,
        "UTF-8",
      ) ?></textarea></div>
      <div class="row">
        <div class="col-md-4 mb-3"><label class="form-label">Durum</label><select name="kategori" class="form-select"><?php foreach (
          $durumlar
          as $k => $v
        ): ?><option value="<?= htmlspecialchars($k, ENT_QUOTES, "UTF-8") ?>" <?= ($row[
  "kategori"
] ??
  "") ===
$k
  ? "selected"
  : "" ?>><?= htmlspecialchars(
  $v,
  ENT_QUOTES,
  "UTF-8",
) ?></option><?php endforeach; ?></select></div>
        <div class="col-md-4 mb-3"><label class="form-label">Başlangıç</label><input type="date" name="baslangic_tarihi" class="form-control" value="<?= htmlspecialchars(
          $row["baslangic_tarihi"] ?? "",
          ENT_QUOTES,
          "UTF-8",
        ) ?>" /></div>
        <div class="col-md-4 mb-3"><label class="form-label">Bitiş</label><input type="date" name="bitis_tarihi" class="form-control" value="<?= htmlspecialchars(
          $row["bitis_tarihi"] ?? "",
          ENT_QUOTES,
          "UTF-8",
        ) ?>" /></div>
      </div>
      <div class="row">
        <div class="col-md-6 mb-3"><label class="form-label">Hedef Katılım</label><input type="number" name="hedef_katilim" class="form-control" value="<?= (int) ($row[
          "hedef_katilim"
        ] ?? 0) ?>" /></div>
        <div class="col-md-6 mb-3 d-flex align-items-end"><div class="form-check"><input class="form-check-input" type="checkbox" name="favori" id="favori" value="1" <?= !empty(
          $row["favori"]
        )
          ? "checked"
          : "" ?> /><label class="form-check-label" for="favori">Favori</label></div></div>
      </div>
      <div class="mb-4"><label class="form-label">Görsel URL</label><input type="url" name="resim_url" class="form-control" value="<?= htmlspecialchars(
        $row["resim_url"] ?? "",
        ENT_QUOTES,
        "UTF-8",
      ) ?>" /></div>
      <button type="submit" class="admin-btn admin-btn-primary"><i class="fas fa-save"></i> Güncelle</button>
    </form>
  </div>
</div>
</div></div>

<?php include __DIR__ . "/../includes/footer.php"; ?>
