<?php
<<<<<<< HEAD
require_once __DIR__ . "/../includes/auth.php";

$id = (int) ($_GET["id"] ?? 0);
$row = dbFetchOneYardimciLink($db, $id);
if (!$row) {
  adminFlashSet("danger", "Link bulunamadı.");
=======

require_once __DIR__ . "/../includes/auth.php";

/*
|--------------------------------------------------------------------------
| Link kaydını getir
|--------------------------------------------------------------------------
*/

$id = (int) ($_GET["id"] ?? 0);

$row = dbFetchOneYardimciLink($db, $id);

if (!$row) {
  adminFlashSet("danger", "Link bulunamadı.");

>>>>>>> da0ab1ce9c2e683fa29c9cbbff849780f358e71f
  header("Location: index.php");
  exit();
}

<<<<<<< HEAD
$currentPage = "linkler";
$pageTitle = "Link Düzenle";
$kategoriler = ["kurum-ici", "website", "bilgi", "faydalı"];
$katMap = dbYardimciLinklerKategoriAdiEslemesi();
$hata = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (!adminVerifyCsrf($_POST["csrf"] ?? null)) {
    $hata = "Geçersiz istek.";
  } else {
    $logo = adminUploadImage($_FILES["logo"] ?? [], "yardimci_linkler", $row["logo_url"] ?? null);
    if ($logo === null && !empty($_FILES["logo"]["name"])) {
      $hata = "Logo yüklenemedi.";
    } else {
      dbYardimciLinkUpdate(
        $db,
        $id,
        trim($_POST["baslik"] ?? ""),
        trim($_POST["kategori"] ?? ""),
        $logo,
        trim($_POST["hedef_url"] ?? ""),
      );
      adminFlashSet("success", "Link güncellendi.");
=======
/*
|--------------------------------------------------------------------------
| Sayfa ayarları
|--------------------------------------------------------------------------
*/

$currentPage = "linkler";
$pageTitle = "Link Düzenle";

$kategoriler = [
  "kurum-ici",
  "website",
  "bilgi",
  "faydalı"
];

$katMap = dbYardimciLinklerKategoriAdiEslemesi();

$hata = "";

/*
|--------------------------------------------------------------------------
| Form gönderildiğinde
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] === "POST") {

  /*
  |--------------------------------------------------------------------------
  | Form verilerini al
  |--------------------------------------------------------------------------
  */

  $baslik = trim($_POST["baslik"] ?? "");
  $kategori = trim($_POST["kategori"] ?? "");
  $hedefUrl = trim($_POST["hedef_url"] ?? "");

  /*
  |--------------------------------------------------------------------------
  | Hata oluşursa formdaki değerleri koru
  |--------------------------------------------------------------------------
  */

  $row["baslik"] = $baslik;
  $row["kategori"] = $kategori;
  $row["hedef_url"] = $hedefUrl;

  /*
  |--------------------------------------------------------------------------
  | CSRF kontrolü
  |--------------------------------------------------------------------------
  */

  if (!adminVerifyCsrf($_POST["csrf"] ?? null)) {

    $hata = "Geçersiz istek.";

  } elseif ($baslik === "" || $hedefUrl === "") {

    $hata = "Başlık ve hedef URL alanları zorunludur.";

  } else {

    /*
    |--------------------------------------------------------------------------
    | Logo yükleme
    |--------------------------------------------------------------------------
    |
    | Yeni logo seçilmediyse mevcut logo korunur.
    |
    */

    $logo = adminUploadImage(
      $_FILES["logo"] ?? [],
      "yardimci_linkler",
      $row["logo_url"] ?? null
    );

    /*
    |--------------------------------------------------------------------------
    | Logo yükleme kontrolü
    |--------------------------------------------------------------------------
    */

    if (
      $logo === null &&
      !empty($_FILES["logo"]["name"])
    ) {

      $hata = "Logo yüklenemedi.";

    } else {

      /*
      |--------------------------------------------------------------------------
      | Veritabanını güncelle
      |--------------------------------------------------------------------------
      */

      dbYardimciLinkUpdate(
        $db,
        $id,
        $baslik,
        $kategori,
        $logo,
        $hedefUrl
      );

      adminFlashSet(
        "success",
        "Link güncellendi."
      );

>>>>>>> da0ab1ce9c2e683fa29c9cbbff849780f358e71f
      header("Location: index.php");
      exit();
    }
  }
}

<<<<<<< HEAD
include __DIR__ . "/../includes/header.php";
?>

<div class="row justify-content-center"><div class="col-lg-8">
<div class="admin-card">
  <div class="admin-card-header"><h3>Link Düzenle #<?= $id ?></h3><a href="index.php" class="admin-btn admin-btn-secondary admin-btn-sm"><i class="fas fa-arrow-left"></i> Geri</a></div>
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
      <div class="mb-3"><label class="form-label">Kategori</label><select name="kategori" class="form-select"><?php foreach (
        $kategoriler
        as $k
      ): ?><option value="<?= htmlspecialchars($k, ENT_QUOTES, "UTF-8") ?>" <?= $row["kategori"] ===
$k
  ? "selected"
  : "" ?>><?= htmlspecialchars(
  $katMap[$k] ?? $k,
  ENT_QUOTES,
  "UTF-8",
) ?></option><?php endforeach; ?></select></div>
      <div class="mb-3"><label class="form-label">Hedef URL *</label><input type="url" name="hedef_url" class="form-control" required value="<?= htmlspecialchars(
        $row["hedef_url"],
        ENT_QUOTES,
        "UTF-8",
      ) ?>" /></div>
      <?= adminImageFieldHtml($assetBase, $row["logo_url"] ?? null, [
        "name" => "logo",
        "label" => "Logo",
        "hint" => "Yeni dosya seçerseniz mevcut logo değişir.",
      ]) ?>
      <button type="submit" class="admin-btn admin-btn-primary"><i class="fas fa-save"></i> Güncelle</button>
    </form>
  </div>
</div>
</div></div>

<?php include __DIR__ . "/../includes/footer.php"; ?>
=======
/*
|--------------------------------------------------------------------------
| Header
|--------------------------------------------------------------------------
*/

include __DIR__ . "/../includes/header.php";

?>

<div class="row justify-content-center">

  <div class="col-lg-8">

    <div class="admin-card">

      <!-- Kart başlığı -->
      <div class="admin-card-header">

        <h3>
          Link Düzenle #<?= $id ?>
        </h3>

        <a
          href="index.php"
          class="admin-btn admin-btn-secondary admin-btn-sm"
        >
          <i class="fas fa-arrow-left"></i>
          Geri
        </a>

      </div>

      <!-- Kart içeriği -->
      <div class="admin-card-body">

        <!-- Hata mesajı -->
        <?php if ($hata): ?>

          <div class="admin-alert admin-alert-danger">

            <?= htmlspecialchars(
              $hata,
              ENT_QUOTES,
              "UTF-8"
            ) ?>

          </div>

        <?php endif; ?>


        <!-- Mevcut logo -->
        <?php if (!empty($row["logo_url"])): ?>

          <div class="mb-4 text-center">

            <div class="text-muted small mb-2">
              Mevcut Logo
            </div>

            <img
              src="<?= htmlspecialchars(
                adminImgUrl(
                  $assetBase,
                  $row["logo_url"]
                ),
                ENT_QUOTES,
                "UTF-8"
              ) ?>"
              class="rounded img-fluid"
              style="
                max-height: 180px;
                max-width: 100%;
                object-fit: contain;
              "
              alt="<?= htmlspecialchars(
                $row["baslik"] ?? "Yardımcı link logosu",
                ENT_QUOTES,
                "UTF-8"
              ) ?>"
            >

          </div>

        <?php endif; ?>


        <!-- Düzenleme formu -->
        <form
          method="post"
          enctype="multipart/form-data"
          class="admin-form"
        >

          <!-- CSRF -->
          <input
            type="hidden"
            name="csrf"
            value="<?= htmlspecialchars(
              adminCsrfToken(),
              ENT_QUOTES,
              "UTF-8"
            ) ?>"
          >


          <!-- Başlık -->
          <div class="mb-3">

            <label class="form-label">
              Başlık *
            </label>

            <input
              type="text"
              name="baslik"
              class="form-control"
              required
              value="<?= htmlspecialchars(
                $row["baslik"] ?? "",
                ENT_QUOTES,
                "UTF-8"
              ) ?>"
            >

          </div>


          <!-- Kategori -->
          <div class="mb-3">

            <label class="form-label">
              Kategori
            </label>

            <select
              name="kategori"
              class="form-select"
            >

              <?php foreach ($kategoriler as $k): ?>

                <option
                  value="<?= htmlspecialchars(
                    $k,
                    ENT_QUOTES,
                    "UTF-8"
                  ) ?>"
                  <?= ($row["kategori"] ?? "") === $k
                    ? "selected"
                    : "" ?>
                >

                  <?= htmlspecialchars(
                    $katMap[$k] ?? $k,
                    ENT_QUOTES,
                    "UTF-8"
                  ) ?>

                </option>

              <?php endforeach; ?>

            </select>

          </div>


          <!-- Hedef URL -->
          <div class="mb-3">

            <label class="form-label">
              Hedef URL *
            </label>

            <input
              type="url"
              name="hedef_url"
              class="form-control"
              required
              placeholder="https://ornek.com"
              value="<?= htmlspecialchars(
                $row["hedef_url"] ?? "",
                ENT_QUOTES,
                "UTF-8"
              ) ?>"
            >

          </div>


          <!-- Yeni logo -->
          <div class="mb-4">

            <label class="form-label">
              Yeni Logo
            </label>

            <input
              type="file"
              name="logo"
              class="form-control"
              accept="image/*"
            >

            <div class="form-text">
              Yeni bir logo seçmezseniz mevcut logo korunur.
            </div>

          </div>


          <!-- Güncelle butonu -->
          <button
            type="submit"
            class="admin-btn admin-btn-primary"
          >

            <i class="fas fa-save"></i>
            Güncelle

          </button>

        </form>

      </div>

    </div>

  </div>

</div>

<?php

include __DIR__ . "/../includes/footer.php";

?>
>>>>>>> da0ab1ce9c2e683fa29c9cbbff849780f358e71f
