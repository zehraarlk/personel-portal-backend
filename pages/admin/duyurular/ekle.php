<?php
require_once __DIR__ . "/../includes/auth.php";

$currentPage = "duyurular";
$pageTitle = "Yeni Duyuru";
$table = adminDuyuruTable($db);
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
    $tarih = trim($_POST["tarih"] ?? "") ?: date("Y-m-d");

    if ($baslik === "" || $aciklama === "") {
      $hata = "Başlık ve açıklama zorunludur.";
    } else {
      $resim = adminUploadImage($_FILES["resim"] ?? [], "duyurular");
      if ($resim === null && !empty($_FILES["resim"]["name"])) {
        $hata = "Görsel yüklenemedi.";
      } else {
        $resim = $resim ?? "";
        $hasAltTip = dbColumnExists($db, $table, "alt_tip");
        $hasKategoriId = dbColumnExists($db, $table, "kategori_id");
        $kategoriId = $hasKategoriId ? dbDuyurularKategoriId($db, $altTip, $kategoriAdi) : null;

        if ($hasAltTip) {
          $stmt = $db->prepare(
            "INSERT INTO `{$table}` (sayfa_tipi, baslik, aciklama, kategori_adi, alt_tip, resim_url, tarih)
                         VALUES ('duyuru', ?, ?, ?, ?, ?, ?)",
          );
          $stmt->execute([$baslik, $aciklama, $kategoriAdi, $altTip, $resim, $tarih]);
        } elseif ($hasKategoriId) {
          $stmt = $db->prepare(
            "INSERT INTO `{$table}` (sayfa_tipi, baslik, aciklama, kategori_id, resim_url, tarih)
                         VALUES ('duyuru', ?, ?, ?, ?, ?)",
          );
          $stmt->execute([$baslik, $aciklama, $kategoriId, $resim, $tarih]);
        } else {
          $stmt = $db->prepare(
            "INSERT INTO `{$table}` (sayfa_tipi, baslik, aciklama, resim_url, tarih)
                         VALUES ('duyuru', ?, ?, ?, ?)",
          );
          $stmt->execute([$baslik, $aciklama, $resim, $tarih]);
        }

        adminFlashSet("success", "Duyuru eklendi.");
        header("Location: index.php");
        exit();
      }
    }
  }
}

include __DIR__ . "/../includes/header.php";
?>

<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="admin-card">
      <div class="admin-card-header">
        <h3>Yeni Duyuru</h3>
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
          <div class="mb-3">
            <label class="form-label">Başlık *</label>
            <input type="text" name="baslik" class="form-control" required value="<?= htmlspecialchars(
              $_POST["baslik"] ?? "",
              ENT_QUOTES,
              "UTF-8",
            ) ?>" />
          </div>
          <div class="mb-3">
            <label class="form-label">Açıklama *</label>
            <textarea name="aciklama" class="form-control" rows="5" required><?= htmlspecialchars(
              $_POST["aciklama"] ?? "",
              ENT_QUOTES,
              "UTF-8",
            ) ?></textarea>
          </div>
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
                  ) ?>" <?= ($_POST["alt_tip"] ?? "") === $kat["slug"]
  ? "selected"
  : "" ?>><?= htmlspecialchars($kat["ad"], ENT_QUOTES, "UTF-8") ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Kategori Adı</label>
              <input type="text" name="kategori_adi" class="form-control" value="<?= htmlspecialchars(
                $_POST["kategori_adi"] ?? "",
                ENT_QUOTES,
                "UTF-8",
              ) ?>" />
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Tarih</label>
            <input type="date" name="tarih" class="form-control" value="<?= htmlspecialchars(
              $_POST["tarih"] ?? date("Y-m-d"),
              ENT_QUOTES,
              "UTF-8",
            ) ?>" />
          </div>
          <div class="mb-4">
            <label class="form-label">Görsel</label>
            <input type="file" name="resim" class="form-control" accept="image/*" />
          </div>
          <button type="submit" class="admin-btn admin-btn-primary"><i class="fas fa-save"></i> Kaydet</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . "/../includes/footer.php"; ?>
