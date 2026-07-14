<?php
<<<<<<< HEAD
require_once __DIR__ . "/../includes/auth.php";

$id = (int) ($_GET["id"] ?? 0);
$row = $id > 0 ? dbFetchOne($db, "SELECT * FROM sizden_gelenler WHERE id = ?", [$id]) : null;
if (!$row) {
  adminFlashSet("danger", "Kayıt bulunamadı.");
=======

require_once __DIR__ . "/../includes/auth.php";

/*
|--------------------------------------------------------------------------
| Kayıt bilgilerini getir
|--------------------------------------------------------------------------
*/

$id = (int) ($_GET["id"] ?? 0);

$row = $id > 0
  ? dbFetchOne(
      $db,
      "SELECT * FROM sizden_gelenler WHERE id = ?",
      [$id]
    )
  : null;

/*
|--------------------------------------------------------------------------
| Kayıt bulunamadıysa listeye dön
|--------------------------------------------------------------------------
*/

if (!$row) {
  adminFlashSet("danger", "Kayıt bulunamadı.");

>>>>>>> da0ab1ce9c2e683fa29c9cbbff849780f358e71f
  header("Location: index.php");
  exit();
}

<<<<<<< HEAD
if (dbColumnExists($db, "sizden_gelenler", "kategori_id") && !empty($row["kategori_id"])) {
  $kat = dbFetchOne($db, "SELECT slug, ad FROM sizdengelenler_kategori WHERE id = ?", [
    $row["kategori_id"],
  ]);
=======
/*
|--------------------------------------------------------------------------
| Kategori bilgilerini getir
|--------------------------------------------------------------------------
*/

if (
  dbColumnExists($db, "sizden_gelenler", "kategori_id") &&
  !empty($row["kategori_id"])
) {
  $kat = dbFetchOne(
    $db,
    "SELECT slug, ad
     FROM sizdengelenler_kategori
     WHERE id = ?",
    [$row["kategori_id"]]
  );

>>>>>>> da0ab1ce9c2e683fa29c9cbbff849780f358e71f
  $row["kategori_slug"] = $kat["slug"] ?? "";
  $row["kategori_adi"] = $kat["ad"] ?? "";
}

<<<<<<< HEAD
$currentPage = "sizden";
$pageTitle = "Kayıt Düzenle";
$kategoriler = dbSizdenGelenlerKategoriler($db);
$hata = "";
$hasKategoriId = dbColumnExists($db, "sizden_gelenler", "kategori_id");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (!adminVerifyCsrf($_POST["csrf"] ?? null)) {
    $hata = "Geçersiz istek.";
  } else {
=======
/*
|--------------------------------------------------------------------------
| Sayfa ayarları
|--------------------------------------------------------------------------
*/

$currentPage = "sizden";
$pageTitle = "Kayıt Düzenle";

$kategoriler = dbSizdenGelenlerKategoriler($db);
$hata = "";

$hasKategoriId = dbColumnExists(
  $db,
  "sizden_gelenler",
  "kategori_id"
);

/*
|--------------------------------------------------------------------------
| Form gönderildiğinde
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] === "POST") {

  /*
  |--------------------------------------------------------------------------
  | CSRF kontrolü
  |--------------------------------------------------------------------------
  */

  if (!adminVerifyCsrf($_POST["csrf"] ?? null)) {

    $hata = "Geçersiz istek.";

  } else {

    /*
    |--------------------------------------------------------------------------
    | Form verilerini al
    |--------------------------------------------------------------------------
    */

>>>>>>> da0ab1ce9c2e683fa29c9cbbff849780f358e71f
    $baslik = trim($_POST["baslik"] ?? "");
    $ozet = trim($_POST["ozet"] ?? "");
    $tarih = trim($_POST["tarih"] ?? "");
    $slug = trim($_POST["kategori_slug"] ?? "");
    $kategoriAdi = trim($_POST["kategori_adi"] ?? "");
<<<<<<< HEAD
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
=======

    /*
    |--------------------------------------------------------------------------
    | Görseli yükle
    |
    | Yeni görsel seçilmediyse mevcut görsel korunur.
    |--------------------------------------------------------------------------
    */

    $gorsel = adminUploadImage(
      $_FILES["gorsel"] ?? [],
      "sizden_gelenler/genel",
      $row["gorsel_yolu"] ?? null
    );

    /*
    |--------------------------------------------------------------------------
    | Doğrulamalar
    |--------------------------------------------------------------------------
    */

    if (
      $gorsel === null &&
      !empty($_FILES["gorsel"]["name"])
    ) {

      $hata = "Görsel yüklenemedi.";

    } elseif ($baslik === "" || $ozet === "") {

      $hata = "Başlık ve özet zorunludur.";

    } else {

      /*
      |--------------------------------------------------------------------------
      | Kategori ID alanı varsa
      |--------------------------------------------------------------------------
      */

      if ($hasKategoriId) {

        $kategoriId = dbSizdenGelenlerKategoriId(
          $db,
          $slug,
          $kategoriAdi
        );

        $stmt = $db->prepare(
          "UPDATE sizden_gelenler
           SET
             baslik = ?,
             ozet = ?,
             kategori_id = ?,
             tarih = ?,
             gorsel_yolu = ?
           WHERE id = ?"
        );

        $stmt->execute([
          $baslik,
          $ozet,
          $kategoriId,
          $tarih,
          $gorsel,
          $id
        ]);

      } else {

        /*
        |--------------------------------------------------------------------------
        | Kategori bilgileri doğrudan tabloda tutuluyorsa
        |--------------------------------------------------------------------------
        */

        $stmt = $db->prepare(
          "UPDATE sizden_gelenler
           SET
             baslik = ?,
             ozet = ?,
             kategori_slug = ?,
             kategori_adi = ?,
             tarih = ?,
             gorsel_yolu = ?
           WHERE id = ?"
        );

        $stmt->execute([
          $baslik,
          $ozet,
          $slug,
          $kategoriAdi,
          $tarih,
          $gorsel,
          $id
        ]);
      }

      adminFlashSet("success", "Kayıt güncellendi.");

      header("Location: index.php");
      exit();
    }

    /*
    |--------------------------------------------------------------------------
    | Hata oluşursa kullanıcının girdiği değerleri formda koru
    |--------------------------------------------------------------------------
    */

    $row["baslik"] = $baslik;
    $row["ozet"] = $ozet;
    $row["tarih"] = $tarih;
    $row["kategori_slug"] = $slug;
    $row["kategori_adi"] = $kategoriAdi;
  }
}

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
          Kayıt Düzenle #<?= $id ?>
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


        <!-- Mevcut görsel -->
        <?php if (!empty($row["gorsel_yolu"])): ?>

          <div class="mb-4 text-center">

            <div class="text-muted small mb-2">
              Mevcut Görsel
            </div>

            <img
              src="<?= htmlspecialchars(
                adminImgUrl(
                  $assetBase,
                  $row["gorsel_yolu"]
                ),
                ENT_QUOTES,
                "UTF-8"
              ) ?>"
              class="rounded img-fluid"
              style="
                max-height: 200px;
                max-width: 100%;
                object-fit: contain;
              "
              alt="<?= htmlspecialchars(
                $row["baslik"] ?? "Kayıt görseli",
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


          <!-- Özet -->
          <div class="mb-3">

            <label class="form-label">
              Özet *
            </label>

            <textarea
              name="ozet"
              class="form-control"
              rows="4"
              required
            ><?= htmlspecialchars(
              $row["ozet"] ?? "",
              ENT_QUOTES,
              "UTF-8"
            ) ?></textarea>

          </div>


          <!-- Kategori alanları -->
          <div class="row">

            <!-- Kategori seçimi -->
            <div class="col-md-6 mb-3">

              <label class="form-label">
                Kategori
              </label>

              <select
                name="kategori_slug"
                class="form-select"
              >

                <option value="">
                  Seçin
                </option>

                <?php foreach ($kategoriler as $kat): ?>

                  <option
                    value="<?= htmlspecialchars(
                      $kat["slug"],
                      ENT_QUOTES,
                      "UTF-8"
                    ) ?>"
                    <?= ($row["kategori_slug"] ?? "") === $kat["slug"]
                      ? "selected"
                      : "" ?>
                  >

                    <?= htmlspecialchars(
                      $kat["ad"],
                      ENT_QUOTES,
                      "UTF-8"
                    ) ?>

                  </option>

                <?php endforeach; ?>

              </select>

            </div>


            <!-- Kategori adı -->
            <div class="col-md-6 mb-3">

              <label class="form-label">
                Kategori Adı
              </label>

              <input
                type="text"
                name="kategori_adi"
                class="form-control"
                value="<?= htmlspecialchars(
                  $row["kategori_adi"] ?? "",
                  ENT_QUOTES,
                  "UTF-8"
                ) ?>"
              >

            </div>

          </div>


          <!-- Tarih -->
          <div class="mb-3">

            <label class="form-label">
              Tarih
            </label>

            <input
              type="date"
              name="tarih"
              class="form-control"
              value="<?= htmlspecialchars(
                $row["tarih"] ?? "",
                ENT_QUOTES,
                "UTF-8"
              ) ?>"
            >

          </div>


          <!-- Yeni görsel -->
          <div class="mb-4">

            <label class="form-label">
              Yeni Görsel
            </label>

            <input
              type="file"
              name="gorsel"
              class="form-control"
              accept="image/*"
            >

            <div class="form-text">
              Yeni bir görsel seçmezseniz mevcut görsel korunur.
            </div>

          </div>


          <!-- Güncelleme butonu -->
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
