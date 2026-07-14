<?php
require_once __DIR__ . "/../includes/auth.php";

$currentPage = "videolar";
$pageTitle = "Yeni Video Ekle";
$kategoriler = ["duyurular", "egitimler", "etkinlikler"];
$hata = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (!adminVerifyCsrf($_POST["csrf"] ?? null)) {
    $hata = "Geçersiz istek. Lütfen tekrar deneyin.";
  } else {
    $youtubeInput = trim($_POST["youtube_id"] ?? "");
    $youtubeId = youtubeExtractVideoId($youtubeInput);

    if (!$youtubeId) {
      $hata = "Geçerli bir YouTube ID veya URL girin.";
    } else {
      $mevcut = dbFetchOne($db, "SELECT id FROM videolar WHERE youtube_id = ?", [$youtubeId]);
      if ($mevcut) {
        $hata = "Bu YouTube videosu zaten kayıtlı.";
      } else {
        $video = dbFillVideoFromYoutube($db, [
          "youtube_id" => $youtubeId,
          "baslik" => trim($_POST["baslik"] ?? ""),
          "aciklama" => trim($_POST["aciklama"] ?? ""),
          "kategori" => trim($_POST["kategori"] ?? ""),
          "sure" => trim($_POST["sure"] ?? ""),
        ]);

        if (!empty($_POST["kategori"])) {
          $video["kategori"] = trim($_POST["kategori"]);
        }

        dbInsertVideo($db, $video);
        adminFlashSet("success", "Video başarıyla eklendi. YouTube bilgileri otomatik dolduruldu.");
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
        <h3><i class="fas fa-video me-2"></i>Video Ekle</h3>
        <a href="index.php" class="admin-btn admin-btn-secondary admin-btn-sm">
          <i class="fas fa-arrow-left"></i> Listeye Dön
        </a>
      </div>
      <div class="admin-card-body">
        <?php if ($hata !== ""): ?>
          <div class="admin-alert admin-alert-danger"><?= htmlspecialchars(
            $hata,
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

<<<<<<< HEAD
          <div class="admin-img-field mb-4">
            <div class="admin-img-preview">
              <img data-preview-img data-youtube-thumb alt="" hidden />
              <p class="admin-img-preview-empty" data-preview-empty>YouTube ID/URL girince kapak önizlemesi burada görünür.</p>
            </div>
          </div>

=======
>>>>>>> da0ab1ce9c2e683fa29c9cbbff849780f358e71f
          <div class="mb-4">
            <label for="youtube_id" class="form-label">YouTube ID veya URL <span class="text-danger">*</span></label>
            <input
              type="text"
              class="form-control"
              id="youtube_id"
              name="youtube_id"
<<<<<<< HEAD
              data-youtube-input
=======
>>>>>>> da0ab1ce9c2e683fa29c9cbbff849780f358e71f
              placeholder="qLqYPQgUPEc veya https://www.youtube.com/watch?v=..."
              value="<?= htmlspecialchars($_POST["youtube_id"] ?? "", ENT_QUOTES, "UTF-8") ?>"
              required
            />
            <div class="admin-form-hint">
              Sadece YouTube ID girerseniz başlık, açıklama, süre ve kategori otomatik doldurulur.
            </div>
          </div>

          <div class="row">
            <div class="col-md-8 mb-3">
              <label for="baslik" class="form-label">Başlık</label>
              <input type="text" class="form-control" id="baslik" name="baslik" placeholder="Boş bırakılırsa YouTube'dan alınır" value="<?= htmlspecialchars(
                $_POST["baslik"] ?? "",
                ENT_QUOTES,
                "UTF-8",
              ) ?>" />
            </div>
            <div class="col-md-4 mb-3">
              <label for="kategori" class="form-label">Kategori</label>
              <select class="form-select" id="kategori" name="kategori">
                <option value="">Otomatik tahmin</option>
                <?php foreach ($kategoriler as $kat): ?>
                  <option value="<?= htmlspecialchars($kat, ENT_QUOTES, "UTF-8") ?>" <?= ($_POST[
  "kategori"
] ??
  "") ===
$kat
  ? "selected"
  : "" ?>>
                    <?= htmlspecialchars(dbVideolarKategoriAdi($kat), ENT_QUOTES, "UTF-8") ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div class="mb-3">
            <label for="aciklama" class="form-label">Açıklama</label>
            <textarea class="form-control" id="aciklama" name="aciklama" rows="4" placeholder="Boş bırakılırsa YouTube açıklaması kullanılır"><?= htmlspecialchars(
              $_POST["aciklama"] ?? "",
              ENT_QUOTES,
              "UTF-8",
            ) ?></textarea>
          </div>

          <div class="mb-4">
            <label for="sure" class="form-label">Süre</label>
            <input type="text" class="form-control" id="sure" name="sure" placeholder="Boş bırakılırsa YouTube'dan alınır (örn: 04:20)" value="<?= htmlspecialchars(
              $_POST["sure"] ?? "",
              ENT_QUOTES,
              "UTF-8",
            ) ?>" />
          </div>

          <button type="submit" class="admin-btn admin-btn-primary">
            <i class="fas fa-save"></i> Videoyu Kaydet
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . "/../includes/footer.php"; ?>
