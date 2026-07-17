<?php
/**
 * Dosya sorumluluğu: Duyuru kaydını düzenleme formunu ve güncelleme işlemini yürütür.
 *
 * Girdi doğrulama, yetkilendirme ve çıktı kaçışları bu dosyanın
 * mevcut güvenlik akışına uygun biçimde korunmalıdır.
 */
require_once __DIR__ . "/../includes/auth.php";

$table = adminDuyuruTable($db);
$id = (int) ($_GET["id"] ?? 0);
$row =
  $id > 0
    ? dbFetchOne($db, "SELECT * FROM `{$table}` WHERE id = ? AND sayfa_tipi = 'duyuru'", [$id])
    : null;
if (!$row) {
  adminFlashSet("danger", "Duyuru bulunamadı.");
  header("Location: index.php");
  exit();
}

if (
  !isset($row["alt_tip"]) &&
  dbColumnExists($db, $table, "kategori_id") &&
  !empty($row["kategori_id"])
) {
  $kat = dbFetchOne($db, "SELECT slug, ad FROM duyurular_kategori WHERE id = ?", [
    $row["kategori_id"],
  ]);
  $row["alt_tip"] = $kat["slug"] ?? "";
  $row["kategori_adi"] = $kat["ad"] ?? "";
}

$currentPage = "duyurular";
$pageTitle = "Duyuru Düzenle";
$kategoriler = dbDuyurularKategoriler($db);
$hata = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (!adminVerifyCsrf($_POST["csrf"] ?? null)) {
    $hata = "Geçersiz istek.";
  } else {
    $baslik = trim($_POST["baslik"] ?? "");
    $aciklama = trim($_POST["aciklama"] ?? "");
    $altTip = trim($_POST["alt_tip"] ?? "");
    $kategoriAdi = trim($_POST["kategori_adi"] ?? "");
    $tarih = trim($_POST["tarih"] ?? "");

    $resim = adminUploadImage($_FILES["resim"] ?? [], "duyurular", $row["resim_url"] ?? "");
    if ($resim === null && !empty($_FILES["resim"]["name"])) {
      $hata = "Görsel yüklenemedi.";
    } elseif ($baslik === "" || $aciklama === "") {
      $hata = "Başlık ve açıklama zorunludur.";
    } else {
      $hasAltTip = dbColumnExists($db, $table, "alt_tip");
      $hasKategoriId = dbColumnExists($db, $table, "kategori_id");
      $kategoriId = $hasKategoriId ? dbDuyurularKategoriId($db, $altTip, $kategoriAdi) : null;

      if ($hasAltTip) {
        $db
          ->prepare(
            "UPDATE `{$table}` SET baslik=?, aciklama=?, kategori_adi=?, alt_tip=?, resim_url=?, tarih=? WHERE id=? AND sayfa_tipi='duyuru'",
          )
          ->execute([$baslik, $aciklama, $kategoriAdi, $altTip, $resim, $tarih, $id]);
      } elseif ($hasKategoriId) {
        $db
          ->prepare(
            "UPDATE `{$table}` SET baslik=?, aciklama=?, kategori_id=?, resim_url=?, tarih=? WHERE id=? AND sayfa_tipi='duyuru'",
          )
          ->execute([$baslik, $aciklama, $kategoriId, $resim, $tarih, $id]);
      } else {
        $db
          ->prepare(
            "UPDATE `{$table}` SET baslik=?, aciklama=?, resim_url=?, tarih=? WHERE id=? AND sayfa_tipi='duyuru'",
          )
          ->execute([$baslik, $aciklama, $resim, $tarih, $id]);
      }

      adminFlashSet("success", "Duyuru güncellendi.");
      header("Location: index.php");
      exit();
    }
  }
}

include __DIR__ . "/../includes/header.php";
?>

<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="admin-card">
      <div class="admin-card-header">
        <h3>Duyuru Düzenle #<?= $id ?></h3>
        <a href="index.php" class="admin-btn admin-btn-secondary admin-btn-sm"><i class="fas fa-arrow-left"></i> Geri</a>
      </div>
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
          <div class="mb-3"><label class="form-label">Açıklama *</label><textarea name="aciklama" class="form-control" rows="5" required><?= htmlspecialchars(
            $row["aciklama"] ?? "",
            ENT_QUOTES,
            "UTF-8",
          ) ?></textarea></div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Kategori Slug</label>
              <select name="alt_tip" class="form-select">
                <option value="">Seçin</option>
                <?php foreach ($kategoriler as $kat): ?>
                  <option value="<?= htmlspecialchars(
                    $kat["slug"],
                    ENT_QUOTES,
                    "UTF-8",
                  ) ?>" <?= ($row["alt_tip"] ?? "") === $kat["slug"]
  ? "selected"
  : "" ?>><?= htmlspecialchars($kat["ad"], ENT_QUOTES, "UTF-8") ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Kategori Adı</label>
              <input type="text" name="kategori_adi" class="form-control" value="<?= htmlspecialchars(
                $row["kategori_adi"] ?? "",
                ENT_QUOTES,
                "UTF-8",
              ) ?>" />
            </div>
          </div>
          <div class="mb-3"><label class="form-label">Tarih</label><input type="date" name="tarih" class="form-control" value="<?= htmlspecialchars(
            $row["tarih"] ?? "",
            ENT_QUOTES,
            "UTF-8",
          ) ?>" /></div>
          <?= adminImageFieldHtml($assetBase, $row["resim_url"] ?? null, [
            "name" => "resim",
            "label" => "Görsel",
            "hint" => "Yeni dosya seçerseniz mevcut görsel değişir.",
          ]) ?>
          <button type="submit" class="admin-btn admin-btn-primary"><i class="fas fa-save"></i> Güncelle</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . "/../includes/footer.php"; ?>
