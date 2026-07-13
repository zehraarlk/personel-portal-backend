<?php
require_once __DIR__ . "/../includes/auth.php";

$id = (int) ($_GET["id"] ?? 0);
$row = $id > 0 ? dbFetchOne($db, "SELECT * FROM yoneticiler WHERE id = ?", [$id]) : null;
if (!$row) {
  adminFlashSet("danger", "Yönetici bulunamadı.");
  header("Location: index.php");
  exit();
}

$benKimim = (int) ($_SESSION["yonetici_id"] ?? 0);
$kendiKaydim = $benKimim === (int) $row["id"];

$currentPage = "yoneticiler";
$pageTitle = "Yönetici Düzenle";
$hata = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (!adminVerifyCsrf($_POST["csrf"] ?? null)) {
    $hata = "Geçersiz istek.";
  } else {
    $kullaniciAdi = trim($_POST["kullanici_adi"] ?? "");
    $ad = trim($_POST["ad"] ?? "");
    $soyad = trim($_POST["soyad"] ?? "");
    $sifre = trim($_POST["sifre"] ?? "");
    $yetki = $_POST["yetki"] ?? $row["yetki"];
    // Kendi kaydını pasife düşüremesin, kendini kilitlemesin
    $aktif = $kendiKaydim ? 1 : (isset($_POST["aktif"]) ? 1 : 0);

    if (!in_array($yetki, ["admin", "super_admin"], true)) {
      $yetki = $row["yetki"];
    }

    if ($kullaniciAdi === "" || $ad === "" || $soyad === "") {
      $hata = "Kullanıcı adı, ad ve soyad zorunludur.";
    } elseif ($sifre !== "" && strlen($sifre) < 6) {
      $hata = "Şifre en az 6 karakter olmalıdır.";
    } else {
      $mevcut = dbFetchOne(
        $db,
        "SELECT id FROM yoneticiler WHERE LOWER(kullanici_adi) = LOWER(?) AND id != ? LIMIT 1",
        [$kullaniciAdi, $id],
      );

      if ($mevcut) {
        $hata = "Bu kullanıcı adı başka bir yöneticiye ait.";
      } else {
        if ($sifre !== "") {
          $db->prepare(
            "UPDATE yoneticiler SET kullanici_adi=?, ad=?, soyad=?, sifre=?, yetki=?, aktif=? WHERE id=?",
          )->execute([$kullaniciAdi, $ad, $soyad, adminHashPassword($sifre), $yetki, $aktif, $id]);
        } else {
          $db->prepare(
            "UPDATE yoneticiler SET kullanici_adi=?, ad=?, soyad=?, yetki=?, aktif=? WHERE id=?",
          )->execute([$kullaniciAdi, $ad, $soyad, $yetki, $aktif, $id]);
        }

        adminFlashSet("success", "Yönetici güncellendi.");
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
  <div class="admin-card-header">
    <h3>Yönetici Düzenle #<?= $id ?></h3>
    <a href="index.php" class="admin-btn admin-btn-secondary admin-btn-sm"><i class="fas fa-arrow-left"></i> Geri</a>
  </div>
  <div class="admin-card-body">
    <?php if ($hata): ?>
      <div class="admin-alert admin-alert-danger"><?= htmlspecialchars($hata, ENT_QUOTES, "UTF-8") ?></div>
    <?php endif; ?>

    <form method="post" class="admin-form">
      <input type="hidden" name="csrf" value="<?= htmlspecialchars(adminCsrfToken(), ENT_QUOTES, "UTF-8") ?>" />

      <div class="mb-3">
        <label class="form-label">Kullanıcı Adı *</label>
        <input type="text" name="kullanici_adi" class="form-control" required value="<?= htmlspecialchars(
          $row["kullanici_adi"],
          ENT_QUOTES,
          "UTF-8",
        ) ?>" />
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
        <label class="form-label">Yeni Şifre</label>
        <input type="password" name="sifre" class="form-control" minlength="6" autocomplete="new-password" />
        <div class="admin-form-hint">Boş bırakılırsa mevcut şifre korunur.</div>
      </div>

      <div class="mb-3">
        <label class="form-label">Yetki *</label>
        <select name="yetki" class="form-control" <?= $kendiKaydim ? "disabled" : "" ?>>
          <option value="admin" <?= $row["yetki"] === "admin" ? "selected" : "" ?>>Admin</option>
          <option value="super_admin" <?= $row["yetki"] === "super_admin" ? "selected" : "" ?>>Süper Admin</option>
        </select>
        <?php if ($kendiKaydim): ?>
          <div class="admin-form-hint">Kendi yetkinizi değiştiremezsiniz.</div>
          <input type="hidden" name="yetki" value="<?= htmlspecialchars($row["yetki"], ENT_QUOTES, "UTF-8") ?>" />
        <?php endif; ?>
      </div>

      <div class="mb-4 form-check">
        <input type="checkbox" name="aktif" id="aktif" class="form-check-input" <?= (int) $row[
          "aktif"
        ] === 1
          ? "checked"
          : "" ?> <?= $kendiKaydim ? "disabled" : "" ?> />
        <label class="form-check-label" for="aktif">Aktif (giriş yapabilir)</label>
        <?php if ($kendiKaydim): ?>
          <div class="admin-form-hint">Kendi hesabınızı pasife alamazsınız.</div>
        <?php endif; ?>
      </div>

      <button type="submit" class="admin-btn admin-btn-primary"><i class="fas fa-save"></i> Güncelle</button>
    </form>
  </div>
</div>
</div></div>

<?php include __DIR__ . "/../includes/footer.php"; ?>
