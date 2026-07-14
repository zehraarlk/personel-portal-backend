<?php
require_once __DIR__ . "/../includes/auth.php";

$id = isset($_GET["id"]) ? (int) $_GET["id"] : 0;
$video = dbFetchOneVideo($db, $id);

if (!$video) {
  adminFlashSet("danger", "Video bulunamadı.");
  header("Location: index.php");
  exit();
}

$currentPage = "videolar";
$pageTitle = "Video Düzenle";
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
      $mevcut = dbFetchOne($db, "SELECT id FROM videolar WHERE youtube_id = ? AND id != ?", [
        $youtubeId,
        $id,
      ]);
      if ($mevcut) {
        $hata = "Bu YouTube videosu başka bir kayıtta kullanılıyor.";
      } else {
        $updated = [
          "youtube_id" => $youtubeId,
          "baslik" => trim($_POST["baslik"] ?? ""),
          "aciklama" => trim($_POST["aciklama"] ?? ""),
          "kategori" => trim($_POST["kategori"] ?? "duyurular"),
          "sure" => trim($_POST["sure"] ?? ""),
          "vitrin_baslik" => trim($_POST["vitrin_baslik"] ?? "") ?: null,
          "vitrin_aciklama" => trim($_POST["vitrin_aciklama"] ?? "") ?: null,
          "vitrin" => isset($_POST["vitrin"]) ? 1 : 0,
        ];

        if ($updated["youtube_id"] !== $video["youtube_id"]) {
          $filled = dbFillVideoFromYoutube(
            $db,
            array_merge($video, [
              "youtube_id" => $youtubeId,
              "baslik" => "",
              "aciklama" => "",
              "sure" => "",
            ]),
          );
          if (trim($_POST["baslik"] ?? "") === "") {
            $updated["baslik"] = $filled["baslik"];
          }
          if (trim($_POST["aciklama"] ?? "") === "") {
            $updated["aciklama"] = $filled["aciklama"];
          }
          if (trim($_POST["sure"] ?? "") === "") {
            $updated["sure"] = $filled["sure"];
          }
        }

        dbUpdateVideo($db, $id, $updated);
        if (!empty($updated["vitrin"])) {
          dbSetVitrinVideo($db, $id);
        }
        adminFlashSet("success", "Video güncellendi.");
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
        <h3><i class="fas fa-pen me-2"></i>Video Düzenle #<?= (int) $video["id"] ?></h3>
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

        <div class="admin-img-field mb-4">
          <div class="admin-img-preview">
            <img
              data-preview-img
              data-youtube-thumb
              src="https://img.youtube.com/vi/<?= htmlspecialchars(
                $video["youtube_id"],
                ENT_QUOTES,
                "UTF-8",
              ) ?>/hqdefault.jpg"
              alt=""
            />
          </div>
        </div>

        <form method="post" class="admin-form">
          <input type="hidden" name="csrf" value="<?= htmlspecialchars(
            adminCsrfToken(),
            ENT_QUOTES,
            "UTF-8",
          ) ?>" />

          <div class="mb-3">
            <label for="youtube_id" class="form-label">YouTube ID veya URL</label>
            <input type="text" class="form-control" id="youtube_id" name="youtube_id" data-youtube-input value="<?= htmlspecialchars(
              $video["youtube_id"],
              ENT_QUOTES,
              "UTF-8",
            ) ?>" required />
            <div class="admin-form-hint">ID değişince üstteki önizleme güncellenir.</div>
          </div>

          <div class="row">
            <div class="col-md-8 mb-3">
              <label for="baslik" class="form-label">Başlık</label>
              <input type="text" class="form-control" id="baslik" name="baslik" value="<?= htmlspecialchars(
                $video["baslik"],
                ENT_QUOTES,
                "UTF-8",
              ) ?>" required />
            </div>
            <div class="col-md-4 mb-3">
              <label for="kategori" class="form-label">Kategori</label>
              <select class="form-select" id="kategori" name="kategori" required>
                <?php foreach ($kategoriler as $kat): ?>
                  <?php $videoKategori = (string) ($video["kategori"] ?? "duyurular"); ?>
                  <option value="<?= htmlspecialchars($kat, ENT_QUOTES, "UTF-8") ?>" <?= $videoKategori === $kat
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
            <textarea class="form-control" id="aciklama" name="aciklama" rows="4" required><?= htmlspecialchars(
              $video["aciklama"],
              ENT_QUOTES,
              "UTF-8",
            ) ?></textarea>
          </div>

          <div class="mb-3">
            <label for="sure" class="form-label">Süre</label>
            <input type="text" class="form-control" id="sure" name="sure" value="<?= htmlspecialchars(
              $video["sure"],
              ENT_QUOTES,
              "UTF-8",
            ) ?>" required />
          </div>

          <div class="border rounded p-3 mb-4 bg-light">
            <div class="form-check mb-3">
              <input class="form-check-input" type="checkbox" id="vitrin" name="vitrin" value="1" <?= !empty(
                $video["vitrin"]
              )
                ? "checked"
                : "" ?> />
              <label class="form-check-label fw-semibold" for="vitrin">Haftanın videosu (vitrin)</label>
              <div class="form-text">İşaretlerseniz bu video sitede en üstte gösterilir. Aynı anda yalnızca bir video seçilebilir.</div>
            </div>
            <div class="mb-3">
              <label for="vitrin_baslik" class="form-label">Vitrin Başlığı</label>
              <input type="text" class="form-control" id="vitrin_baslik" name="vitrin_baslik" value="<?= htmlspecialchars(
                $video["vitrin_baslik"] ?? "",
                ENT_QUOTES,
                "UTF-8",
              ) ?>" />
            </div>
            <div class="mb-0">
              <label for="vitrin_aciklama" class="form-label">Vitrin Açıklaması</label>
              <textarea class="form-control" id="vitrin_aciklama" name="vitrin_aciklama" rows="2"><?= htmlspecialchars(
                $video["vitrin_aciklama"] ?? "",
                ENT_QUOTES,
                "UTF-8",
              ) ?></textarea>
            </div>
          </div>

          <button type="submit" class="admin-btn admin-btn-primary">
            <i class="fas fa-save"></i> Değişiklikleri Kaydet
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . "/../includes/footer.php"; ?>
