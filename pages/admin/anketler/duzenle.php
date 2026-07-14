<?php
<<<<<<< HEAD
require_once __DIR__ . "/../includes/auth.php";

$id = (int) ($_GET["id"] ?? 0);
$row = adminFetchAnket($db, $id);
if (!$row) {
  adminFlashSet("danger", "Anket bulunamadı.");
=======

require_once __DIR__ . "/../includes/auth.php";

/*
|--------------------------------------------------------------------------
| Anket kaydını getir
|--------------------------------------------------------------------------
*/

$id = (int) ($_GET["id"] ?? 0);

$row = adminFetchAnket($db, $id);

if (!$row) {
  adminFlashSet("danger", "Anket bulunamadı.");

>>>>>>> da0ab1ce9c2e683fa29c9cbbff849780f358e71f
  header("Location: index.php");
  exit();
}

<<<<<<< HEAD
$currentPage = "anketler";
$pageTitle = "Anket Düzenle";
$durumlar = dbAnketlerKategoriAdiEslemesi();
$hata = "";
$uyari = "";
$sorularKilitli = adminAnketHasCevap($db, $id);
$sorular = adminFetchAnketSorulari($db, $id);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (!adminVerifyCsrf($_POST["csrf"] ?? null)) {
    $hata = "Geçersiz istek.";
  } else {
    $baslik = trim($_POST["baslik"] ?? "");
    $aciklama = trim($_POST["aciklama"] ?? "");
    $kategori = trim($_POST["kategori"] ?? "active");
    $baslangic = trim($_POST["baslangic_tarihi"] ?? "") ?: null;
    $bitis = trim($_POST["bitis_tarihi"] ?? "") ?: null;
    $hedef = (int) ($_POST["hedef_katilim"] ?? 0);
    $favori = isset($_POST["favori"]) ? 1 : 0;
    $resim = trim($_POST["resim_url"] ?? "") ?: null;
    $parsedSorular = adminParseAnketSorularFromPost($_POST);
    $hasCevap = adminAnketHasCevap($db, $id);

    if ($baslik === "") {
      $hata = "Başlık zorunludur.";
    } elseif (!$hasCevap && $parsedSorular === []) {
      $hata =
        "En az bir geçerli soru ekleyin. Çoktan seçmeli sorularda en az 2 seçenek olmalıdır.";
    } else {
      try {
        $db->beginTransaction();

        if (dbColumnExists($db, "anketler", "kategori")) {
          $db
            ->prepare(
              "UPDATE anketler SET baslik=?, aciklama=?, kategori=?, resim_url=?, baslangic_tarihi=?, bitis_tarihi=?, hedef_katilim=?, favori=? WHERE id=?",
            )
            ->execute([
              $baslik,
              $aciklama,
              $kategori,
              $resim,
              $baslangic,
              $bitis,
              $hedef,
              $favori,
              $id,
            ]);
        } else {
          $kategoriId = dbAnketlerKategoriId($db, $kategori);
          $db
            ->prepare(
              "UPDATE anketler SET baslik=?, aciklama=?, kategori_id=?, resim_url=?, baslangic_tarihi=?, bitis_tarihi=?, hedef_katilim=?, favori=? WHERE id=?",
            )
            ->execute([
              $baslik,
              $aciklama,
              $kategoriId,
              $resim,
              $baslangic,
              $bitis,
              $hedef,
              $favori,
              $id,
            ]);
        }

        if (!$hasCevap) {
          adminSaveAnketSorulari($db, $id, $parsedSorular);
        }

        $db->commit();

        if ($hasCevap) {
          adminFlashSet(
            "warning",
            "Anket bilgileri güncellendi. Bu ankete cevap verildiği için sorular değiştirilmedi.",
          );
        } else {
          adminFlashSet("success", "Anket ve sorular güncellendi.");
        }
        header("Location: index.php");
        exit();
      } catch (Throwable $e) {
        if ($db->inTransaction()) {
          $db->rollBack();
        }
        error_log("Anket guncelleme hatasi: " . $e->getMessage());
        $hata = "Anket güncellenirken bir hata oluştu.";
      }
    }

    if ($hata !== "") {
      $row["baslik"] = $baslik;
      $row["aciklama"] = $aciklama;
      $row["kategori"] = $kategori;
      $row["baslangic_tarihi"] = $baslangic;
      $row["bitis_tarihi"] = $bitis;
      $row["hedef_katilim"] = $hedef;
      $row["favori"] = $favori;
      $row["resim_url"] = $resim;
      if (!$hasCevap) {
        $sorular = [];
        foreach ($_POST["sorular"] ?? [] as $item) {
          if (!is_array($item)) {
            continue;
          }
          $secenekler = [];
          foreach ($item["secenekler"] ?? [] as $opt) {
            $secenekler[] = ["secenek_metni" => (string) $opt];
          }
          $sorular[] = [
            "soru_metni" => (string) ($item["metin"] ?? ""),
            "soru_tipi" => (string) ($item["tip"] ?? "coktan_secmeli"),
            "secenekler" => $secenekler,
          ];
        }
      }
    }
  }
}

if ($sorularKilitli) {
  $uyari =
    "Bu ankete en az bir personel cevap verdiği için sorular kilitlidir.";
}

include __DIR__ . "/../includes/header.php";
?>

<div class="row justify-content-center"><div class="col-lg-10">
<div class="admin-card">
  <div class="admin-card-header">
    <h3>Anket Düzenle #<?= $id ?></h3>
    <a href="index.php" class="admin-btn admin-btn-secondary admin-btn-sm"><i class="fas fa-arrow-left"></i> Geri</a>
  </div>
  <div class="admin-card-body">
    <?php if ($hata): ?>
      <div class="admin-alert admin-alert-danger"><?= htmlspecialchars(
        $hata,
        ENT_QUOTES,
        "UTF-8",
      ) ?></div>
    <?php endif; ?>
    <?php if ($uyari): ?>
      <div class="admin-alert admin-alert-warning"><?= htmlspecialchars(
        $uyari,
        ENT_QUOTES,
        "UTF-8",
      ) ?></div>
    <?php endif; ?>
    <form method="post" class="admin-form">
      <input type="hidden" name="csrf" value="<?= htmlspecialchars(
        adminCsrfToken(),
        ENT_QUOTES,
        "UTF-8",
      ) ?>" />
      <div class="mb-3"><label class="form-label">Başlık *</label><input type="text" name="baslik" class="form-control" required value="<?= htmlspecialchars(
        $row["baslik"] ?? "",
        ENT_QUOTES,
        "UTF-8",
      ) ?>" /></div>
      <div class="mb-3"><label class="form-label">Açıklama</label><textarea name="aciklama" class="form-control" rows="3"><?= htmlspecialchars(
        $row["aciklama"] ?? "",
        ENT_QUOTES,
        "UTF-8",
      ) ?></textarea></div>
      <div class="row">
        <div class="col-md-4 mb-3"><label class="form-label">Durum</label><select name="kategori" class="form-select"><?php foreach (
          $durumlar
          as $k => $v
        ): ?><option value="<?= htmlspecialchars($k, ENT_QUOTES, "UTF-8") ?>" <?= ($row[
  "kategori"
] ??
  "") ===
$k
  ? "selected"
  : "" ?>><?= htmlspecialchars(
  $v,
  ENT_QUOTES,
  "UTF-8",
) ?></option><?php endforeach; ?></select></div>
        <div class="col-md-4 mb-3"><label class="form-label">Başlangıç</label><input type="date" name="baslangic_tarihi" class="form-control" value="<?= htmlspecialchars(
          $row["baslangic_tarihi"] ?? "",
          ENT_QUOTES,
          "UTF-8",
        ) ?>" /></div>
        <div class="col-md-4 mb-3"><label class="form-label">Bitiş</label><input type="date" name="bitis_tarihi" class="form-control" value="<?= htmlspecialchars(
          $row["bitis_tarihi"] ?? "",
          ENT_QUOTES,
          "UTF-8",
        ) ?>" /></div>
      </div>
      <div class="row">
        <div class="col-md-6 mb-3"><label class="form-label">Hedef Katılım</label><input type="number" name="hedef_katilim" class="form-control" value="<?= (int) ($row[
          "hedef_katilim"
        ] ??
          0) ?>" /></div>
        <div class="col-md-6 mb-3 d-flex align-items-end"><div class="form-check"><input class="form-check-input" type="checkbox" name="favori" id="favori" value="1" <?= !empty(
          $row["favori"]
        )
          ? "checked"
          : "" ?> /><label class="form-check-label" for="favori">Favori</label></div></div>
      </div>
      <?= adminImageFieldHtml($assetBase, $row["resim_url"] ?? null, [
        "name" => "resim_url",
        "label" => "Görsel URL",
        "mode" => "url",
        "url_value" => (string) ($row["resim_url"] ?? ""),
        "hint" => "Harici görsel adresi (https://...).",
      ]) ?>

      <?php include __DIR__ . "/_sorular_builder.php"; ?>

      <button type="submit" class="admin-btn admin-btn-primary"><i class="fas fa-save"></i> Güncelle</button>
    </form>
  </div>
</div>
</div></div>

<?php include __DIR__ . "/../includes/footer.php"; ?>
<script src="<?= htmlspecialchars(
  $assetBase,
  ENT_QUOTES,
  "UTF-8",
) ?>assets/js/admin-anket-sorular.js?v=<?= (int) @filemtime(
  __DIR__ . "/../../../assets/js/admin-anket-sorular.js",
) ?>"></script>
=======
/*
|--------------------------------------------------------------------------
| Sayfa ayarları
|--------------------------------------------------------------------------
*/

$currentPage = "anketler";
$pageTitle = "Anket Düzenle";

$durumlar = dbAnketlerKategoriAdiEslemesi();
$hata = "";

/*
|--------------------------------------------------------------------------
| Form gönderildiğinde
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] === "POST") {

  if (!adminVerifyCsrf($_POST["csrf"] ?? null)) {

    $hata = "Geçersiz istek.";

  } else {

    /*
    |--------------------------------------------------------------------------
    | Form verilerini al
    |--------------------------------------------------------------------------
    */

    $baslik = trim($_POST["baslik"] ?? "");
    $aciklama = trim($_POST["aciklama"] ?? "");
    $kategori = trim($_POST["kategori"] ?? "active");

    $resimUrl = trim($_POST["resim_url"] ?? "");
    $resimUrl = $resimUrl !== "" ? $resimUrl : null;

    $baslangicTarihi = trim($_POST["baslangic_tarihi"] ?? "");
    $baslangicTarihi = $baslangicTarihi !== ""
      ? $baslangicTarihi
      : null;

    $bitisTarihi = trim($_POST["bitis_tarihi"] ?? "");
    $bitisTarihi = $bitisTarihi !== ""
      ? $bitisTarihi
      : null;

    $hedefKatilim = max(
      0,
      (int) ($_POST["hedef_katilim"] ?? 0)
    );

    $favori = isset($_POST["favori"]) ? 1 : 0;

    /*
    |--------------------------------------------------------------------------
    | Form kontrolü
    |--------------------------------------------------------------------------
    */

    if ($baslik === "") {

      $hata = "Başlık alanı zorunludur.";

    } else {

      /*
      |--------------------------------------------------------------------------
      | Kategori sütunu doğrudan tabloda varsa
      |--------------------------------------------------------------------------
      */

      if (dbColumnExists($db, "anketler", "kategori")) {

        $stmt = $db->prepare(
          "UPDATE anketler
           SET
             baslik = ?,
             aciklama = ?,
             kategori = ?,
             resim_url = ?,
             baslangic_tarihi = ?,
             bitis_tarihi = ?,
             hedef_katilim = ?,
             favori = ?
           WHERE id = ?"
        );

        $stmt->execute([
          $baslik,
          $aciklama,
          $kategori,
          $resimUrl,
          $baslangicTarihi,
          $bitisTarihi,
          $hedefKatilim,
          $favori,
          $id
        ]);

      } else {

        /*
        |--------------------------------------------------------------------------
        | Kategori ilişkisi kategori_id ile tutuluyorsa
        |--------------------------------------------------------------------------
        */

        $kategoriId = dbAnketlerKategoriId(
          $db,
          $kategori
        );

        $stmt = $db->prepare(
          "UPDATE anketler
           SET
             baslik = ?,
             aciklama = ?,
             kategori_id = ?,
             resim_url = ?,
             baslangic_tarihi = ?,
             bitis_tarihi = ?,
             hedef_katilim = ?,
             favori = ?
           WHERE id = ?"
        );

        $stmt->execute([
          $baslik,
          $aciklama,
          $kategoriId,
          $resimUrl,
          $baslangicTarihi,
          $bitisTarihi,
          $hedefKatilim,
          $favori,
          $id
        ]);
      }

      adminFlashSet(
        "success",
        "Anket güncellendi."
      );

      header("Location: index.php");
      exit();
    }

    /*
    |--------------------------------------------------------------------------
    | Hata oluşursa girilen değerleri formda koru
    |--------------------------------------------------------------------------
    */

    $row["baslik"] = $baslik;
    $row["aciklama"] = $aciklama;
    $row["kategori"] = $kategori;
    $row["resim_url"] = $resimUrl ?? "";
    $row["baslangic_tarihi"] = $baslangicTarihi ?? "";
    $row["bitis_tarihi"] = $bitisTarihi ?? "";
    $row["hedef_katilim"] = $hedefKatilim;
    $row["favori"] = $favori;
  }
}

/*
|--------------------------------------------------------------------------
| Mevcut görsel adresini hazırla
|--------------------------------------------------------------------------
|
| resim_url tam bir internet adresiyse doğrudan kullanılır.
| Veritabanında proje içi bir yol tutuluyorsa adminImgUrl kullanılır.
|
*/

$resimDegeri = trim(
  (string) ($row["resim_url"] ?? "")
);

$resimSrc = "";

if ($resimDegeri !== "") {

  if (filter_var($resimDegeri, FILTER_VALIDATE_URL)) {

    $resimSrc = $resimDegeri;

  } else {

    $resimSrc = adminImgUrl(
      $assetBase,
      $resimDegeri
    );
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
          Anket Düzenle #<?= $id ?>
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
        <?php if ($resimSrc !== ""): ?>

          <div class="mb-4 text-center">

            <div class="text-muted small mb-2">
              Mevcut Görsel
            </div>

            <img
              src="<?= htmlspecialchars(
                $resimSrc,
                ENT_QUOTES,
                "UTF-8"
              ) ?>"
              class="rounded img-fluid"
              style="
                max-height: 220px;
                max-width: 100%;
                object-fit: contain;
              "
              alt="<?= htmlspecialchars(
                $row["baslik"] ?? "Anket görseli",
                ENT_QUOTES,
                "UTF-8"
              ) ?>"
            >

          </div>

        <?php endif; ?>


        <!-- Düzenleme formu -->
        <form
          method="post"
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


          <!-- Açıklama -->
          <div class="mb-3">

            <label class="form-label">
              Açıklama
            </label>

            <textarea
              name="aciklama"
              class="form-control"
              rows="3"
            ><?= htmlspecialchars(
              $row["aciklama"] ?? "",
              ENT_QUOTES,
              "UTF-8"
            ) ?></textarea>

          </div>


          <!-- Durum ve tarihler -->
          <div class="row">

            <!-- Durum -->
            <div class="col-md-4 mb-3">

              <label class="form-label">
                Durum
              </label>

              <select
                name="kategori"
                class="form-select"
              >

                <?php foreach ($durumlar as $k => $v): ?>

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
                      $v,
                      ENT_QUOTES,
                      "UTF-8"
                    ) ?>

                  </option>

                <?php endforeach; ?>

              </select>

            </div>


            <!-- Başlangıç tarihi -->
            <div class="col-md-4 mb-3">

              <label class="form-label">
                Başlangıç
              </label>

              <input
                type="date"
                name="baslangic_tarihi"
                class="form-control"
                value="<?= htmlspecialchars(
                  $row["baslangic_tarihi"] ?? "",
                  ENT_QUOTES,
                  "UTF-8"
                ) ?>"
              >

            </div>


            <!-- Bitiş tarihi -->
            <div class="col-md-4 mb-3">

              <label class="form-label">
                Bitiş
              </label>

              <input
                type="date"
                name="bitis_tarihi"
                class="form-control"
                value="<?= htmlspecialchars(
                  $row["bitis_tarihi"] ?? "",
                  ENT_QUOTES,
                  "UTF-8"
                ) ?>"
              >

            </div>

          </div>


          <!-- Hedef katılım ve favori -->
          <div class="row">

            <!-- Hedef katılım -->
            <div class="col-md-6 mb-3">

              <label class="form-label">
                Hedef Katılım
              </label>

              <input
                type="number"
                name="hedef_katilim"
                class="form-control"
                min="0"
                value="<?= (int) (
                  $row["hedef_katilim"] ?? 0
                ) ?>"
              >

            </div>


            <!-- Favori -->
            <div class="col-md-6 mb-3 d-flex align-items-end">

              <div class="form-check mb-2">

                <input
                  class="form-check-input"
                  type="checkbox"
                  name="favori"
                  id="favori"
                  value="1"
                  <?= !empty($row["favori"])
                    ? "checked"
                    : "" ?>
                >

                <label
                  class="form-check-label"
                  for="favori"
                >
                  Favori
                </label>

              </div>

            </div>

          </div>


          <!-- Görsel URL -->
          <div class="mb-4">

            <label class="form-label">
              Görsel URL
            </label>

            <input
              type="text"
              name="resim_url"
              class="form-control"
              placeholder="https://ornek.com/gorsel.jpg"
              value="<?= htmlspecialchars(
                $row["resim_url"] ?? "",
                ENT_QUOTES,
                "UTF-8"
              ) ?>"
            >

            <div class="form-text">
              Görseli değiştirmek istemiyorsanız mevcut adresi değiştirmeyin.
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
