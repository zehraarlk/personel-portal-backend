<?php
/**
 * Dosya sorumluluğu: Site ikonu kaydı ekleme formunu ve kayıt işlemini yürütür.
 *
 * Girdi doğrulama, yetkilendirme ve çıktı kaçışları bu dosyanın
 * mevcut güvenlik akışına uygun biçimde korunmalıdır.
 */
require_once __DIR__ . "/../includes/auth.php";

$currentPage = "ikonlar";
$pageTitle = "Yeni İkon";
$hata = "";

$kategoriOneriler = dbFetchAll(
  $db,
  "SELECT DISTINCT kategori FROM site_ikonlari ORDER BY kategori ASC",
);
$kategoriOneriler = array_map(
  static fn(array $r): string => (string) ($r["kategori"] ?? ""),
  $kategoriOneriler,
);

$maxSira = adminSiraNext($db, "site_ikonlari");

$form = [
  "anahtar" => "",
  "ad" => "",
  "kategori" => "",
  "ikon_sinifi" => "",
  "renk" => "",
  "sira" => $maxSira,
  "aktif" => 1,
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (!adminVerifyCsrf($_POST["csrf"] ?? null)) {
    $hata = "Geçersiz istek.";
  } else {
    $form["anahtar"] = trim((string) ($_POST["anahtar"] ?? ""));
    $form["ad"] = trim((string) ($_POST["ad"] ?? ""));
    $form["kategori"] = trim((string) ($_POST["kategori"] ?? ""));
    $form["ikon_sinifi"] = trim((string) ($_POST["ikon_sinifi"] ?? ""));
    $form["renk"] = trim((string) ($_POST["renk"] ?? "")) ?: null;
    $form["sira"] = max(1, (int) ($_POST["sira"] ?? $maxSira));
    $form["aktif"] = isset($_POST["aktif"]) ? 1 : 0;

    if (
      $form["anahtar"] === "" ||
      $form["ad"] === "" ||
      $form["kategori"] === "" ||
      $form["ikon_sinifi"] === ""
    ) {
      $hata = "Anahtar, ad, kategori ve ikon sınıfı zorunludur.";
    } elseif (!preg_match('/^[a-z0-9_]+$/', $form["anahtar"])) {
      $hata =
        "Anahtar yalnızca küçük harf, rakam ve alt çizgi içerebilir.";
    } else {
      $exists = dbFetchOne(
        $db,
        "SELECT id FROM site_ikonlari WHERE anahtar = ? LIMIT 1",
        [$form["anahtar"]],
      );
      if ($exists) {
        $hata = "Bu anahtar zaten kullanılıyor.";
      } else {
        $db
          ->prepare(
            "INSERT INTO site_ikonlari (anahtar, ad, kategori, ikon_sinifi, renk, sira, aktif)
             VALUES (?, ?, ?, ?, ?, ?, ?)",
          )
          ->execute([
            $form["anahtar"],
            $form["ad"],
            $form["kategori"],
            $form["ikon_sinifi"],
            $form["renk"],
            0,
            $form["aktif"],
          ]);
        $newId = (int) $db->lastInsertId();
        adminSiraPlace($db, "site_ikonlari", $newId, $form["sira"]);
        adminFlashSet("success", "İkon eklendi.");
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
        <h3>Yeni İkon</h3>
        <a href="index.php" class="admin-btn admin-btn-secondary admin-btn-sm">
          <i class="fas fa-arrow-left"></i> Geri
        </a>
      </div>
      <div class="admin-card-body">
        <?php if ($hata): ?>
          <div class="admin-alert admin-alert-danger">
            <?= htmlspecialchars($hata, ENT_QUOTES, "UTF-8") ?>
          </div>
        <?php endif; ?>

        <form method="post" class="admin-form">
          <input
            type="hidden"
            name="csrf"
            value="<?= htmlspecialchars(adminCsrfToken(), ENT_QUOTES, "UTF-8") ?>"
          />

          <div class="mb-3">
            <label class="form-label" for="anahtar">Anahtar *</label>
            <input
              type="text"
              id="anahtar"
              name="anahtar"
              class="form-control"
              required
              pattern="[a-z0-9_]+"
              value="<?= htmlspecialchars($form["anahtar"], ENT_QUOTES, "UTF-8") ?>"
              placeholder="ornek_anahtar"
            />
            <p class="admin-form-hint">icon('anahtar') ile kullanılır.</p>
          </div>

          <div class="mb-3">
            <label class="form-label" for="ad">Ad *</label>
            <input
              type="text"
              id="ad"
              name="ad"
              class="form-control"
              required
              value="<?= htmlspecialchars((string) $form["ad"], ENT_QUOTES, "UTF-8") ?>"
            />
          </div>

          <div class="mb-3">
            <label class="form-label" for="kategori">Kategori *</label>
            <input
              type="text"
              id="kategori"
              name="kategori"
              class="form-control"
              required
              list="kategoriList"
              value="<?= htmlspecialchars(
                (string) $form["kategori"],
                ENT_QUOTES,
                "UTF-8",
              ) ?>"
            />
            <datalist id="kategoriList">
              <?php foreach ($kategoriOneriler as $kat): ?>
                <option value="<?= htmlspecialchars($kat, ENT_QUOTES, "UTF-8") ?>"></option>
              <?php endforeach; ?>
            </datalist>
          </div>

          <div class="mb-3">
            <label class="form-label" for="ikon_sinifi">İkon sınıfı (Font Awesome) *</label>
            <div class="admin-icon-live-preview mb-2">
              <span class="admin-icon-preview admin-icon-preview-lg" id="ikonCanliOnizleme" aria-hidden="true">
                <i class="<?= htmlspecialchars(
                  (string) $form["ikon_sinifi"],
                  ENT_QUOTES,
                  "UTF-8",
                ) ?>"></i>
              </span>
              <span class="text-muted small">Canlı önizleme</span>
            </div>
            <input
              type="text"
              id="ikon_sinifi"
              name="ikon_sinifi"
              class="form-control"
              required
              value="<?= htmlspecialchars(
                (string) $form["ikon_sinifi"],
                ENT_QUOTES,
                "UTF-8",
              ) ?>"
              placeholder="fas fa-home"
              autocomplete="off"
            />
            <p class="admin-form-hint">Örn: fas fa-home, far fa-star, fab fa-youtube (Bootstrap Icons `bi bi-*` kullanmayın)</p>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label" for="renk">Renk</label>
              <input
                type="text"
                id="renk"
                name="renk"
                class="form-control"
                value="<?= htmlspecialchars(
                  (string) ($form["renk"] ?? ""),
                  ENT_QUOTES,
                  "UTF-8",
                ) ?>"
                placeholder="#1a3a6b veya boş"
              />
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label" for="sira">Sıra</label>
              <input
                type="number"
                id="sira"
                name="sira"
                class="form-control"
                step="1"
                min="1"
                value="<?= (int) $form["sira"] ?>"
              />
              <p class="admin-form-hint">1’den başlayan index. Örn. 5. sıraya eklerseniz sonraki kayıtlar bir kayar.</p>
            </div>
          </div>

          <div class="mb-4 form-check">
            <input
              type="checkbox"
              class="form-check-input"
              id="aktif"
              name="aktif"
              value="1"
              <?= (int) $form["aktif"] === 1 ? "checked" : "" ?>
            />
            <label class="form-check-label" for="aktif">Aktif</label>
          </div>

          <button type="submit" class="admin-btn admin-btn-primary">
            <i class="fas fa-save"></i> Kaydet
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . "/../includes/footer.php"; ?>
