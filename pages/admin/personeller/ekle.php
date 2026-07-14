<?php
require_once __DIR__ . "/../includes/auth.php";

$currentPage = "personeller";
$pageTitle = "Personel Ekle";
$hata = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (!adminVerifyCsrf($_POST["csrf"] ?? null)) {
    $hata = "Geçersiz istek.";
  } else {
    $sicilNo = trim($_POST["sicil_no"] ?? "");
    $ad = trim($_POST["ad"] ?? "");
    $soyad = trim($_POST["soyad"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $sifre = trim($_POST["sifre"] ?? "");
    $dogumTarihi = trim($_POST["dogum_tarihi"] ?? "");

    if ($sicilNo === "" || $ad === "" || $soyad === "" || $email === "" || $sifre === "" || $dogumTarihi === "") {
      $hata = "Sicil no, ad, soyad, e-posta, şifre ve doğum tarihi zorunludur.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $hata = "Geçerli bir e-posta adresi girin.";
    } else {
      $mevcutSicil = dbFetchOne($db, "SELECT id FROM personeller WHERE sicil_no = ? LIMIT 1", [$sicilNo]);
      $mevcutEmail = dbFetchOne($db, "SELECT id FROM personeller WHERE email = ? LIMIT 1", [$email]);

      if ($mevcutSicil) {
        $hata = "Bu sicil numarası zaten kayıtlı.";
      } elseif ($mevcutEmail) {
        $hata = "Bu e-posta adresi zaten kayıtlı.";
      } else {
        $foto = adminUploadImage($_FILES["foto"] ?? [], "personeller");
        if ($foto === null && !empty($_FILES["foto"]["name"])) {
          $hata = "Fotoğraf yüklenemedi.";
        } else {
          if ($foto === null) {
            $foto = adminPersonelDefaultFoto();
          }

          $db->prepare(
            "INSERT INTO personeller (sicil_no, ad, soyad, email, sifre, dogum_tarihi, foto_url)
             VALUES (?, ?, ?, ?, ?, ?, ?)",
          )->execute([
            $sicilNo,
            $ad,
            $soyad,
            $email,
            adminPersonelHashPassword($sifre),
            $dogumTarihi,
            $foto,
          ]);

          adminFlashSet("success", "Personel başarıyla eklendi.");
          header("Location: index.php");
          exit();
        }
      }
    }
  }
}

include __DIR__ . "/../includes/header.php";
?>

<div class="row justify-content-center"><div class="col-lg-8">
<div class="admin-card">
  <div class="admin-card-header">
    <h3><i class="fas fa-user-plus me-2"></i>Personel Ekle</h3>
    <a href="index.php" class="admin-btn admin-btn-secondary admin-btn-sm"><i class="fas fa-arrow-left"></i> Geri</a>
  </div>
  <div class="admin-card-body">
    <?php if ($hata): ?>
      <div class="admin-alert admin-alert-danger"><?= htmlspecialchars($hata, ENT_QUOTES, "UTF-8") ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" class="admin-form">
      <input type="hidden" name="csrf" value="<?= htmlspecialchars(adminCsrfToken(), ENT_QUOTES, "UTF-8") ?>" />

      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Sicil No *</label>
          <input type="text" name="sicil_no" class="form-control" required value="<?= htmlspecialchars(
            $_POST["sicil_no"] ?? "",
            ENT_QUOTES,
            "UTF-8",
          ) ?>" />
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Doğum Tarihi *</label>
          <input type="date" name="dogum_tarihi" class="form-control" required value="<?= htmlspecialchars(
            $_POST["dogum_tarihi"] ?? "",
            ENT_QUOTES,
            "UTF-8",
          ) ?>" />
        </div>
      </div>

      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Ad *</label>
          <input type="text" name="ad" class="form-control" required value="<?= htmlspecialchars(
            $_POST["ad"] ?? "",
            ENT_QUOTES,
            "UTF-8",
          ) ?>" />
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Soyad *</label>
          <input type="text" name="soyad" class="form-control" required value="<?= htmlspecialchars(
            $_POST["soyad"] ?? "",
            ENT_QUOTES,
            "UTF-8",
          ) ?>" />
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">E-posta *</label>
        <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars(
          $_POST["email"] ?? "",
          ENT_QUOTES,
          "UTF-8",
        ) ?>" />
      </div>

      <div class="mb-3">
        <label class="form-label">Şifre *</label>
        <input type="password" name="sifre" class="form-control" required minlength="4" autocomplete="new-password" />
        <div class="admin-form-hint">Personel girişinde sicil no + bu şifre kullanılır.</div>
      </div>

      <div class="mb-4">
        <?= adminImageFieldHtml($assetBase, null, [
          "name" => "foto",
          "label" => "Fotoğraf",
          "hint" => "Boş bırakılırsa varsayılan profil fotoğrafı atanır.",
        ]) ?>
      </div>

      <button type="submit" class="admin-btn admin-btn-primary"><i class="fas fa-save"></i> Kaydet</button>
    </form>
  </div>
</div>
</div></div>

<?php include __DIR__ . "/../includes/footer.php"; ?>
