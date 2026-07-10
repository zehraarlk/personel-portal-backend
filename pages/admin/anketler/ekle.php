<?php
require_once __DIR__ . "/../includes/auth.php";

$currentPage = "anketler";
$pageTitle = "Yeni Anket";
$durumlar = dbAnketlerKategoriAdiEslemesi();
$hata = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (!adminVerifyCsrf($_POST["csrf"] ?? null)) {
    $hata = "Geçersiz istek.";
  } else {
    $baslik = trim($_POST["baslik"] ?? "");
    $aciklama = trim($_POST["aciklama"] ?? "");
    $kategori = trim($_POST["kategori"] ?? "active");
    $baslangic = trim($_POST["baslangic_tarihi"] ?? "") ?: null;
    $bitis = trim($_POST["bitis_tarihi"] ?? "") ?: null;
    $hedef = (int) ($_POST["hedef_katilim"] ?? 0);
    $favori = isset($_POST["favori"]) ? 1 : 0;
    $resim = trim($_POST["resim_url"] ?? "") ?: null;

    if ($baslik === "") {
      $hata = "Başlık zorunludur.";
    } else {
      if (dbColumnExists($db, "anketler", "kategori")) {
        $db
          ->prepare(
            "INSERT INTO anketler (baslik, aciklama, kategori, resim_url, baslangic_tarihi, bitis_tarihi, katilim_sayisi, hedef_katilim, favori)
                     VALUES (?, ?, ?, ?, ?, ?, 0, ?, ?)",
          )
          ->execute([$baslik, $aciklama, $kategori, $resim, $baslangic, $bitis, $hedef, $favori]);
      } else {
        $kategoriId = dbAnketlerKategoriId($db, $kategori);
        $db
          ->prepare(
            "INSERT INTO anketler (baslik, aciklama, kategori_id, resim_url, baslangic_tarihi, bitis_tarihi, katilim_sayisi, hedef_katilim, favori)
                     VALUES (?, ?, ?, ?, ?, ?, 0, ?, ?)",
          )
          ->execute([$baslik, $aciklama, $kategoriId, $resim, $baslangic, $bitis, $hedef, $favori]);
      }
      adminFlashSet("success", "Anket eklendi.");
      header("Location: index.php");
      exit();
    }
  }
}

include __DIR__ . "/../includes/header.php";
?>

<div class="row justify-content-center"><div class="col-lg-8">
<div class="admin-card">
  <div class="admin-card-header"><h3>Yeni Anket</h3><a href="index.php" class="admin-btn admin-btn-secondary admin-btn-sm"><i class="fas fa-arrow-left"></i> Geri</a></div>
  <div class="admin-card-body">
    <?php if ($hata): ?><div class="admin-alert admin-alert-danger"><?= htmlspecialchars(
  $hata,
  ENT_QUOTES,
  "UTF-8",
) ?></div><?php endif; ?>
    <form method="post" class="admin-form">
      <input type="hidden" name="csrf" value="<?= htmlspecialchars(
        adminCsrfToken(),
        ENT_QUOTES,
        "UTF-8",
      ) ?>" />
      <div class="mb-3"><label class="form-label">Başlık *</label><input type="text" name="baslik" class="form-control" required /></div>
      <div class="mb-3"><label class="form-label">Açıklama</label><textarea name="aciklama" class="form-control" rows="3"></textarea></div>
      <div class="row">
        <div class="col-md-4 mb-3"><label class="form-label">Durum</label><select name="kategori" class="form-select"><?php foreach (
          $durumlar
          as $k => $v
        ): ?><option value="<?= htmlspecialchars($k, ENT_QUOTES, "UTF-8") ?>"><?= htmlspecialchars(
  $v,
  ENT_QUOTES,
  "UTF-8",
) ?></option><?php endforeach; ?></select></div>
        <div class="col-md-4 mb-3"><label class="form-label">Başlangıç</label><input type="date" name="baslangic_tarihi" class="form-control" /></div>
        <div class="col-md-4 mb-3"><label class="form-label">Bitiş</label><input type="date" name="bitis_tarihi" class="form-control" /></div>
      </div>
      <div class="row">
        <div class="col-md-6 mb-3"><label class="form-label">Hedef Katılım</label><input type="number" name="hedef_katilim" class="form-control" value="100" min="0" /></div>
        <div class="col-md-6 mb-3 d-flex align-items-end"><div class="form-check"><input class="form-check-input" type="checkbox" name="favori" id="favori" value="1" /><label class="form-check-label" for="favori">Favori anket</label></div></div>
      </div>
      <div class="mb-4"><label class="form-label">Görsel URL</label><input type="url" name="resim_url" class="form-control" placeholder="https://..." /></div>
      <button type="submit" class="admin-btn admin-btn-primary"><i class="fas fa-save"></i> Kaydet</button>
    </form>
  </div>
</div>
</div></div>

<?php include __DIR__ . "/../includes/footer.php"; ?>
