<?php
/**
 * Dosya sorumluluğu: Yönetici kaydı ekleme formunu ve kayıt işlemini yürütür.
 *
 * Girdi doğrulama, yetkilendirme ve çıktı kaçışları bu dosyanın
 * mevcut güvenlik akışına uygun biçimde korunmalıdır.
 */
require_once __DIR__ . "/../includes/auth.php";

$currentPage = "yoneticiler";
$pageTitle = "Yönetici Ekle";
$hata = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (!adminVerifyCsrf($_POST["csrf"] ?? null)) {
    $hata = "Geçersiz istek.";
  } else {
    $kullaniciAdi = trim($_POST["kullanici_adi"] ?? "");
    $ad = trim($_POST["ad"] ?? "");
    $soyad = trim($_POST["soyad"] ?? "");
    $sifre = trim($_POST["sifre"] ?? "");
    $yetki = $_POST["yetki"] ?? "admin";
    $aktif = isset($_POST["aktif"]) ? 1 : 0;

    if (!in_array($yetki, ["admin", "super_admin"], true)) {
      $yetki = "admin";
    }

    if ($kullaniciAdi === "" || $ad === "" || $soyad === "" || $sifre === "") {
      $hata = "Kullanıcı adı, ad, soyad ve şifre zorunludur.";
    } elseif (strlen($sifre) < 6) {
      $hata = "Şifre en az 6 karakter olmalıdır.";
    } else {
      $mevcut = dbFetchOne(
        $db,
        "SELECT id FROM yoneticiler WHERE LOWER(kullanici_adi) = LOWER(?) LIMIT 1",
        [$kullaniciAdi],
      );

      if ($mevcut) {
        $hata = "Bu kullanıcı adı zaten kayıtlı.";
      } else {
        $foto = adminUploadImage($_FILES["foto"] ?? [], "yoneticiler", null);
        if ($foto === null && !empty($_FILES["foto"]["name"])) {
          $hata = "Fotoğraf yüklenemedi.";
        } else {
          $db->prepare(
            "INSERT INTO yoneticiler (kullanici_adi, ad, soyad, sifre, yetki, aktif, foto_url)
             VALUES (?, ?, ?, ?, ?, ?, ?)",
          )->execute([
            $kullaniciAdi,
            $ad,
            $soyad,
            adminHashPassword($sifre),
            $yetki,
            $aktif,
            $foto,
          ]);

          adminFlashSet("success", "Yönetici başarıyla eklendi.");
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
    <h3><i class="fas fa-user-plus me-2"></i>Yönetici Ekle</h3>
    <a href="index.php" class="admin-btn admin-btn-secondary admin-btn-sm"><i class="fas fa-arrow-left"></i> Geri</a>
  </div>
  <div class="admin-card-body">
    <?php if ($hata): ?>
      <div class="admin-alert admin-alert-danger"><?= htmlspecialchars($hata, ENT_QUOTES, "UTF-8") ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" class="admin-form">
      <input type="hidden" name="csrf" value="<?= htmlspecialchars(adminCsrfToken(), ENT_QUOTES, "UTF-8") ?>" />

      <div class="mb-3">
        <label class="form-label">Kullanıcı Adı *</label>
        <input type="text" name="kullanici_adi" class="form-control" required value="<?= htmlspecialchars(
          $_POST["kullanici_adi"] ?? "",
          ENT_QUOTES,
          "UTF-8",
        ) ?>" />
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
        <label class="form-label">Şifre *</label>
        <input type="password" name="sifre" class="form-control" required minlength="6" autocomplete="new-password" />
        <div class="admin-form-hint">Yönetim paneli girişinde kullanıcı adı + bu şifre kullanılır.</div>
      </div>

      <?= adminImageFieldHtml($assetBase, null, [
        "name" => "foto",
        "label" => "Profil Fotoğrafı",
        "hint" => "İsteğe bağlı. Navbar profil alanında görünür.",
      ]) ?>

      <div class="mb-3">
        <label class="form-label">Yetki *</label>
        <select name="yetki" class="form-control">
          <option value="admin" <?= ($_POST["yetki"] ?? "admin") === "admin" ? "selected" : "" ?>>Admin</option>
          <option value="super_admin" <?= ($_POST["yetki"] ?? "") === "super_admin" ? "selected" : "" ?>>Süper Admin</option>
        </select>
      </div>

      <div class="mb-4 form-check">
        <input type="checkbox" name="aktif" id="aktif" class="form-check-input" checked />
        <label class="form-check-label" for="aktif">Aktif (giriş yapabilir)</label>
      </div>

      <button type="submit" class="admin-btn admin-btn-primary"><i class="fas fa-save"></i> Kaydet</button>
    </form>
  </div>
</div>
</div></div>

<?php include __DIR__ . "/../includes/footer.php"; ?>
