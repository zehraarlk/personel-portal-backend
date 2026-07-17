<?php
/**
 * Dosya sorumluluğu: Vefat bilgisi kaydı ekleme formunu ve kayıt işlemini yürütür.
 *
 * Girdi doğrulama, yetkilendirme ve çıktı kaçışları bu dosyanın
 * mevcut güvenlik akışına uygun biçimde korunmalıdır.
 */
require_once __DIR__ . "/../includes/auth.php";

$currentPage = "vefat";
$pageTitle = "Yeni Vefat Kaydı";
$hata = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (!adminVerifyCsrf($_POST["csrf"] ?? null)) {
    $hata = "Geçersiz istek.";
  } else {
    $adi = trim($_POST["vefat_eden_adi"] ?? "");
    $iliski = trim($_POST["iliski_pozisyon"] ?? "");
    $tarih = trim($_POST["vefat_tarihi"] ?? "");
    $tarihMetin = trim($_POST["vefat_tarihi_metin"] ?? "");
    $mesaj = trim($_POST["cenaze_mesaji"] ?? "");

    if ($adi === "" || $tarih === "" || $mesaj === "") {
      $hata = "Vefat eden adı, tarih ve cenaze mesajı zorunludur.";
    } else {
      if ($tarihMetin === "") {
        $tarihMetin = date("j F Y", strtotime($tarih));
      }
      $db
        ->prepare(
          "INSERT INTO vefat_bilgileri (vefat_eden_adi, iliski_pozisyon, vefat_tarihi, vefat_tarihi_metin, cenaze_mesaji) VALUES (?, ?, ?, ?, ?)",
        )
        ->execute([$adi, $iliski, $tarih, $tarihMetin, $mesaj]);
      adminFlashSet("success", "Vefat kaydı eklendi.");
      header("Location: index.php");
      exit();
    }
  }
}

include __DIR__ . "/../includes/header.php";
?>

<div class="row justify-content-center"><div class="col-lg-8">
<div class="admin-card">
  <div class="admin-card-header"><h3>Yeni Vefat Kaydı</h3><a href="index.php" class="admin-btn admin-btn-secondary admin-btn-sm"><i class="fas fa-arrow-left"></i> Geri</a></div>
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
      <div class="mb-3"><label class="form-label">Vefat Eden Adı *</label><input type="text" name="vefat_eden_adi" class="form-control" required /></div>
      <div class="mb-3"><label class="form-label">İlişki / Pozisyon</label><input type="text" name="iliski_pozisyon" class="form-control" /></div>
      <div class="row">
        <div class="col-md-6 mb-3"><label class="form-label">Vefat Tarihi *</label><input type="date" name="vefat_tarihi" class="form-control" required /></div>
        <div class="col-md-6 mb-3"><label class="form-label">Tarih Metni</label><input type="text" name="vefat_tarihi_metin" class="form-control" placeholder="örn: 21 Aralık 2024" /></div>
      </div>
      <div class="mb-4"><label class="form-label">Cenaze Mesajı *</label><textarea name="cenaze_mesaji" class="form-control" rows="5" required></textarea></div>
      <button type="submit" class="admin-btn admin-btn-primary"><i class="fas fa-save"></i> Kaydet</button>
    </form>
  </div>
</div>
</div></div>

<?php include __DIR__ . "/../includes/footer.php"; ?>
