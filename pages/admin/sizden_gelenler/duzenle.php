<?php
/**
 * Dosya sorumluluğu: Personelden gelen içerik kaydını düzenleme formunu ve güncelleme işlemini yürütür.
 *
 * Girdi doğrulama, yetkilendirme ve çıktı kaçışları bu dosyanın
 * mevcut güvenlik akışına uygun biçimde korunmalıdır.
 */
require_once __DIR__ . "/../includes/auth.php";

$id = (int) ($_GET["id"] ?? 0);
$row = $id > 0 ? dbFetchOne($db, "SELECT * FROM sizden_gelenler WHERE id = ?", [$id]) : null;
if (!$row) {
  adminFlashSet("danger", "Kayıt bulunamadı.");
  header("Location: index.php");
  exit();
}

if (dbColumnExists($db, "sizden_gelenler", "kategori_id") && !empty($row["kategori_id"])) {
  $kat = dbFetchOne($db, "SELECT slug, ad FROM sizdengelenler_kategori WHERE id = ?", [
    $row["kategori_id"],
  ]);
  $row["kategori_slug"] = $kat["slug"] ?? "";
  $row["kategori_adi"] = $kat["ad"] ?? "";
}

$currentPage = "sizden";
$pageTitle = "Kayıt Düzenle";
$kategoriler = dbSizdenGelenlerKategoriler($db);
$hata = "";
$hasKategoriId = dbColumnExists($db, "sizden_gelenler", "kategori_id");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (!adminVerifyCsrf($_POST["csrf"] ?? null)) {
    $hata = "Geçersiz istek.";
  } else {
    $baslik = trim($_POST["baslik"] ?? "");
    $ozet = trim($_POST["ozet"] ?? "");
    $tarih = trim($_POST["tarih"] ?? "");
    $slug = trim($_POST["kategori_slug"] ?? "");
    $kategoriAdi = trim($_POST["kategori_adi"] ?? "");
    $gorsel = adminUploadImage(
      $_FILES["gorsel"] ?? [],
      "sizden_gelenler/genel",
      $row["gorsel_yolu"] ?? null,
    );

    if ($gorsel === null && !empty($_FILES["gorsel"]["name"])) {
      $hata = "Görsel yüklenemedi.";
    } elseif ($baslik === "" || $ozet === "") {
      $hata = "Başlık ve özet zorunludur.";
    } else {
      if ($hasKategoriId) {
        $kategoriId = dbSizdenGelenlerKategoriId($db, $slug, $kategoriAdi);
        $db
          ->prepare(
            "UPDATE sizden_gelenler SET baslik=?, ozet=?, kategori_id=?, tarih=?, gorsel_yolu=? WHERE id=?",
          )
          ->execute([$baslik, $ozet, $kategoriId, $tarih, $gorsel, $id]);
      } else {
        $db
          ->prepare(
            "UPDATE sizden_gelenler SET baslik=?, ozet=?, kategori_slug=?, kategori_adi=?, tarih=?, gorsel_yolu=? WHERE id=?",
          )
          ->execute([$baslik, $ozet, $slug, $kategoriAdi, $tarih, $gorsel, $id]);
      }
      adminFlashSet("success", "Kayıt güncellendi.");
      header("Location: index.php");
      exit();
    }
  }
}

include __DIR__ . "/../includes/header.php";
?>

<div class="row justify-content-center"><div class="col-lg-8">
<div class="admin-card">
  <div class="admin-card-header"><h3>Kayıt Düzenle #<?= $id ?></h3><a href="index.php" class="admin-btn admin-btn-secondary admin-btn-sm"><i class="fas fa-arrow-left"></i> Geri</a></div>
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
      <div class="mb-3"><label class="form-label">Özet *</label><textarea name="ozet" class="form-control" rows="4" required><?= htmlspecialchars(
        $row["ozet"],
        ENT_QUOTES,
        "UTF-8",
      ) ?></textarea></div>
      <div class="row">
        <div class="col-md-6 mb-3"><label class="form-label">Kategori</label><select name="kategori_slug" class="form-select"><option value="">Seçin</option>
          <?php foreach ($kategoriler as $kat): ?><option value="<?= htmlspecialchars(
  $kat["slug"],
  ENT_QUOTES,
  "UTF-8",
) ?>" <?= ($row["kategori_slug"] ?? "") === $kat["slug"] ? "selected" : "" ?>><?= htmlspecialchars(
  $kat["ad"],
  ENT_QUOTES,
  "UTF-8",
) ?></option><?php endforeach; ?>
        </select></div>
        <div class="col-md-6 mb-3"><label class="form-label">Kategori Adı</label><input type="text" name="kategori_adi" class="form-control" value="<?= htmlspecialchars(
          $row["kategori_adi"] ?? "",
          ENT_QUOTES,
          "UTF-8",
        ) ?>" /></div>
      </div>
      <div class="mb-3"><label class="form-label">Tarih</label><input type="date" name="tarih" class="form-control" value="<?= htmlspecialchars(
        $row["tarih"],
        ENT_QUOTES,
        "UTF-8",
      ) ?>" /></div>
      <?= adminImageFieldHtml($assetBase, $row["gorsel_yolu"] ?? null, [
        "name" => "gorsel",
        "label" => "Görsel",
        "hint" => "Yeni dosya seçerseniz mevcut görsel değişir.",
      ]) ?>
      <button type="submit" class="admin-btn admin-btn-primary"><i class="fas fa-save"></i> Güncelle</button>
    </form>
  </div>
</div>
</div></div>

<?php include __DIR__ . "/../includes/footer.php"; ?>
