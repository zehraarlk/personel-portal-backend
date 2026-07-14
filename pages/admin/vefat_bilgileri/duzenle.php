<?php
require_once __DIR__ . "/../includes/auth.php";

$id = (int) ($_GET["id"] ?? 0);
$row = $id > 0 ? dbFetchOne($db, "SELECT * FROM vefat_bilgileri WHERE id = ?", [$id]) : null;
if (!$row) {
  adminFlashSet("danger", "Kayıt bulunamadı.");
  header("Location: index.php");
  exit();
}

$currentPage = "vefat";
$pageTitle = "Vefat Kaydı Düzenle";
$hata = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (!adminVerifyCsrf($_POST["csrf"] ?? null)) {
    $hata = "Geçersiz istek.";
  } else {
    $db
      ->prepare(
        "UPDATE vefat_bilgileri SET vefat_eden_adi=?, iliski_pozisyon=?, vefat_tarihi=?, vefat_tarihi_metin=?, cenaze_mesaji=? WHERE id=?",
      )
      ->execute([
        trim($_POST["vefat_eden_adi"] ?? ""),
        trim($_POST["iliski_pozisyon"] ?? ""),
        trim($_POST["vefat_tarihi"] ?? ""),
        trim($_POST["vefat_tarihi_metin"] ?? ""),
        trim($_POST["cenaze_mesaji"] ?? ""),
        $id,
      ]);
    adminFlashSet("success", "Kayıt güncellendi.");
    header("Location: index.php");
    exit();
  }
}

include __DIR__ . "/../includes/header.php";
?>

<div class="row justify-content-center"><div class="col-lg-8">
<div class="admin-card">
  <div class="admin-card-header"><h3>Vefat Kaydı Düzenle #<?= $id ?></h3><a href="index.php" class="admin-btn admin-btn-secondary admin-btn-sm"><i class="fas fa-arrow-left"></i> Geri</a></div>
  <div class="admin-card-body">
    <form method="post" class="admin-form">
      <input type="hidden" name="csrf" value="<?= htmlspecialchars(
        adminCsrfToken(),
        ENT_QUOTES,
        "UTF-8",
      ) ?>" />
      <div class="mb-3"><label class="form-label">Vefat Eden Adı *</label><input type="text" name="vefat_eden_adi" class="form-control" required value="<?= htmlspecialchars(
        $row["vefat_eden_adi"],
        ENT_QUOTES,
        "UTF-8",
      ) ?>" /></div>
      <div class="mb-3"><label class="form-label">İlişki / Pozisyon</label><input type="text" name="iliski_pozisyon" class="form-control" value="<?= htmlspecialchars(
        $row["iliski_pozisyon"],
        ENT_QUOTES,
        "UTF-8",
      ) ?>" /></div>
      <div class="row">
        <div class="col-md-6 mb-3"><label class="form-label">Vefat Tarihi *</label><input type="date" name="vefat_tarihi" class="form-control" required value="<?= htmlspecialchars(
          $row["vefat_tarihi"],
          ENT_QUOTES,
          "UTF-8",
        ) ?>" /></div>
        <div class="col-md-6 mb-3"><label class="form-label">Tarih Metni</label><input type="text" name="vefat_tarihi_metin" class="form-control" value="<?= htmlspecialchars(
          $row["vefat_tarihi_metin"],
          ENT_QUOTES,
          "UTF-8",
        ) ?>" /></div>
      </div>
      <div class="mb-4"><label class="form-label">Cenaze Mesajı *</label><textarea name="cenaze_mesaji" class="form-control" rows="5" required><?= htmlspecialchars(
        $row["cenaze_mesaji"],
        ENT_QUOTES,
        "UTF-8",
      ) ?></textarea></div>
      <button type="submit" class="admin-btn admin-btn-primary"><i class="fas fa-save"></i> Güncelle</button>
    </form>
  </div>
</div>
</div></div>

<?php include __DIR__ . "/../includes/footer.php"; ?>
