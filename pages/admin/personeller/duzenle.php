<?php
require_once __DIR__ . "/../includes/auth.php";

$id = (int) ($_GET["id"] ?? 0);
$row = $id > 0 ? dbFetchOne($db, "SELECT * FROM personeller WHERE id = ?", [$id]) : null;
if (!$row) {
  adminFlashSet("danger", "Personel bulunamadı.");
  header("Location: index.php");
  exit();
}

$currentPage = "personeller";
$pageTitle = "Personel Düzenle";
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

    if ($sicilNo === "" || $ad === "" || $soyad === "" || $email === "" || $dogumTarihi === "") {
      $hata = "Sicil no, ad, soyad, e-posta ve doğum tarihi zorunludur.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $hata = "Geçerli bir e-posta adresi girin.";
    } else {
      $mevcutSicil = dbFetchOne(
        $db,
        "SELECT id FROM personeller WHERE sicil_no = ? AND id != ? LIMIT 1",
        [$sicilNo, $id],
      );
      $mevcutEmail = dbFetchOne(
        $db,
        "SELECT id FROM personeller WHERE email = ? AND id != ? LIMIT 1",
        [$email, $id],
      );

      if ($mevcutSicil) {
        $hata = "Bu sicil numarası başka bir personele ait.";
      } elseif ($mevcutEmail) {
        $hata = "Bu e-posta adresi başka bir personele ait.";
      } else {
        $foto = adminUploadImage($_FILES["foto"] ?? [], "personeller", $row["foto_url"] ?? null);
        if ($foto === null && !empty($_FILES["foto"]["name"])) {
          $hata = "Fotoğraf yüklenemedi.";
        } else {
          if ($foto === null || $foto === "") {
            $foto = $row["foto_url"] ?: adminPersonelDefaultFoto();
          }

          if ($sifre !== "") {
            $db->prepare(
              "UPDATE personeller SET sicil_no=?, ad=?, soyad=?, email=?, sifre=?, dogum_tarihi=?, foto_url=? WHERE id=?",
            )->execute([
              $sicilNo,
              $ad,
              $soyad,
              $email,
              adminPersonelHashPassword($sifre),
              $dogumTarihi,
              $foto,
              $id,
            ]);
          } else {
            $db->prepare(
              "UPDATE personeller SET sicil_no=?, ad=?, soyad=?, email=?, dogum_tarihi=?, foto_url=? WHERE id=?",
            )->execute([$sicilNo, $ad, $soyad, $email, $dogumTarihi, $foto, $id]);
          }

          adminFlashSet("success", "Personel güncellendi.");
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
    <h3>Personel Düzenle #<?= $id ?></h3>
    <a href="index.php" class="admin-btn admin-btn-secondary admin-btn-sm"><i class="fas fa-arrow-left"></i> Geri</a>
  </div>
  <div class="admin-card-body">
    <?php if ($hata): ?>
      <div class="admin-alert admin-alert-danger"><?= htmlspecialchars($hata, ENT_QUOTES, "UTF-8") ?></div>
    <?php endif; ?>

    <?php if (!empty($row["foto_url"])): ?>
      <div class="mb-3 text-center">
        <img
          src="<?= htmlspecialchars(adminImgUrl($assetBase, $row["foto_url"]), ENT_QUOTES, "UTF-8") ?>"
          class="rounded-circle"
          style="width:96px;height:96px;object-fit:cover"
          alt=""
        />
      </div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" class="admin-form">
      <input type="hidden" name="csrf" value="<?= htmlspecialchars(adminCsrfToken(), ENT_QUOTES, "UTF-8") ?>" />

      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Sicil No *</label>
          <input type="text" name="sicil_no" class="form-control" required value="<?= htmlspecialchars(
            $row["sicil_no"],
            ENT_QUOTES,
            "UTF-8",
          ) ?>" />
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Doğum Tarihi *</label>
          <input type="date" name="dogum_tarihi" class="form-control" required value="<?= htmlspecialchars(
            $row["dogum_tarihi"],
            ENT_QUOTES,
            "UTF-8",
          ) ?>" />
        </div>
      </div>

      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Ad *</label>
          <input type="text" name="ad" class="form-control" required value="<?= htmlspecialchars(
            $row["ad"],
            ENT_QUOTES,
            "UTF-8",
          ) ?>" />
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Soyad *</label>
          <input type="text" name="soyad" class="form-control" required value="<?= htmlspecialchars(
            $row["soyad"],
            ENT_QUOTES,
            "UTF-8",
          ) ?>" />
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">E-posta *</label>
        <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars(
          $row["email"],
          ENT_QUOTES,
          "UTF-8",
        ) ?>" />
      </div>

      <div class="mb-3">
        <label class="form-label">Yeni Şifre</label>
        <input type="password" name="sifre" class="form-control" minlength="4" autocomplete="new-password" />
        <div class="admin-form-hint">Boş bırakılırsa mevcut şifre korunur.</div>
      </div>

      <div class="mb-4">
        <label class="form-label">Yeni Fotoğraf</label>
        <input type="file" name="foto" class="form-control" accept="image/*" />
      </div>

      <button type="submit" class="admin-btn admin-btn-primary"><i class="fas fa-save"></i> Güncelle</button>
    </form>
  </div>
</div>
</div></div>

<?php include __DIR__ . "/../includes/footer.php"; ?>
