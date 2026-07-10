<?php
require_once __DIR__ . "/../includes/auth.php";

$currentPage = "sizden";
$pageTitle = "Yeni Kayıt";
$kategoriler = dbSizdenGelenlerKategoriler($db);
$hata = "";
$hasKategoriId = dbColumnExists($db, "sizden_gelenler", "kategori_id");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (!adminVerifyCsrf($_POST["csrf"] ?? null)) {
    $hata = "Geçersiz istek.";
  } else {
    $baslik = trim($_POST["baslik"] ?? "");
    $ozet = trim($_POST["ozet"] ?? "");
    $tarih = trim($_POST["tarih"] ?? "") ?: date("Y-m-d");
    $slug = trim($_POST["kategori_slug"] ?? "");
    $kategoriAdi = trim($_POST["kategori_adi"] ?? "");

    if ($baslik === "" || $ozet === "") {
      $hata = "Başlık ve özet zorunludur.";
    } else {
      $gorsel = adminUploadImage($_FILES["gorsel"] ?? [], "sizden_gelenler/genel");
      if ($gorsel === null && !empty($_FILES["gorsel"]["name"])) {
        $hata = "Görsel yüklenemedi.";
      } else {
        if ($hasKategoriId) {
          $kategoriId = dbSizdenGelenlerKategoriId($db, $slug, $kategoriAdi);
          $db
            ->prepare(
              "INSERT INTO sizden_gelenler (baslik, ozet, kategori_id, tarih, gorsel_yolu, goruntulenme) VALUES (?, ?, ?, ?, ?, 0)",
            )
            ->execute([$baslik, $ozet, $kategoriId, $tarih, $gorsel]);
        } else {
          $db
            ->prepare(
              "INSERT INTO sizden_gelenler (baslik, ozet, kategori_slug, kategori_adi, tarih, gorsel_yolu, goruntulenme) VALUES (?, ?, ?, ?, ?, ?, 0)",
            )
            ->execute([$baslik, $ozet, $slug, $kategoriAdi, $tarih, $gorsel]);
        }
        adminFlashSet("success", "Kayıt eklendi.");
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
  <div class="admin-card-header"><h3>Yeni Kayıt</h3><a href="index.php" class="admin-btn admin-btn-secondary admin-btn-sm"><i class="fas fa-arrow-left"></i> Geri</a></div>
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
      <div class="mb-3"><label class="form-label">Özet *</label><textarea name="ozet" class="form-control" rows="4" required></textarea></div>
      <div class="row">
        <div class="col-md-6 mb-3"><label class="form-label">Kategori</label>
          <select name="kategori_slug" class="form-select"><option value="">Seçin</option>
          <?php foreach ($kategoriler as $kat): ?><option value="<?= htmlspecialchars(
  $kat["slug"],
  ENT_QUOTES,
  "UTF-8",
) ?>"><?= htmlspecialchars($kat["ad"], ENT_QUOTES, "UTF-8") ?></option><?php endforeach; ?>
          </select></div>
        <div class="col-md-6 mb-3"><label class="form-label">Kategori Adı</label><input type="text" name="kategori_adi" class="form-control" /></div>
      </div>
      <div class="mb-3"><label class="form-label">Tarih</label><input type="date" name="tarih" class="form-control" value="<?= date(
        "Y-m-d",
      ) ?>" /></div>
      <div class="mb-4"><label class="form-label">Görsel</label><input type="file" name="gorsel" class="form-control" accept="image/*" /></div>
      <button type="submit" class="admin-btn admin-btn-primary"><i class="fas fa-save"></i> Kaydet</button>
    </form>
  </div>
</div>
</div></div>

<?php include __DIR__ . "/../includes/footer.php"; ?>
