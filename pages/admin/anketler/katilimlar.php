<?php
/**
 * Dosya sorumluluğu: Anket katılım kayıtlarını listeler.
 *
 * Girdi doğrulama, yetkilendirme ve çıktı kaçışları bu dosyanın
 * mevcut güvenlik akışına uygun biçimde korunmalıdır.
 */
require_once __DIR__ . "/../includes/auth.php";

$anketId = (int) ($_GET["id"] ?? 0);
$anket = $anketId > 0 ? adminFetchAnket($db, $anketId) : null;

if (!$anket) {
  adminFlashSet("danger", "Anket bulunamadı.");
  header("Location: index.php");
  exit();
}

$currentPage = "anketler";
$pageTitle = "Anket Katılımları";
$katilimlar = adminFetchAnketKatilimlari($db, $anketId);

include __DIR__ . "/../includes/header.php";
?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
  <div>
    <p class="text-muted mb-1">
      <a href="index.php" class="text-decoration-none">Anketler</a>
      · Katılımlar
    </p>
    <h2 class="h5 mb-0">
      <?= htmlspecialchars((string) ($anket["baslik"] ?? ""), ENT_QUOTES, "UTF-8") ?>
    </h2>
    <p class="text-muted mb-0 small">
      Toplam <strong><?= count($katilimlar) ?></strong> katılımcı
      · Sayaç:
      <strong><?= (int) ($anket["katilim_sayisi"] ?? 0) ?></strong>
      /
      <?= (int) ($anket["hedef_katilim"] ?? 0) ?>
    </p>
  </div>
  <a href="index.php" class="admin-btn admin-btn-secondary admin-btn-sm">
    <i class="fas fa-arrow-left"></i> Geri
  </a>
</div>

<div class="admin-card">
  <div class="admin-card-body p-0">
    <?php if (empty($katilimlar)): ?>
      <p class="text-muted p-4 mb-0">Bu ankete henüz kimse katılmamış.</p>
    <?php else: ?>
      <div class="admin-table-wrap">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Personel</th>
              <th>Sicil No</th>
              <th>Tamamlanma</th>
              <th>Cevap</th>
              <th class="text-center align-middle">İşlem</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($katilimlar as $row): ?>
              <?php
              $adSoyad = trim(
                trim((string) ($row["ad"] ?? "")) .
                  " " .
                  trim((string) ($row["soyad"] ?? "")),
              );
              $personelId = (int) ($row["personel_id"] ?? 0);
              ?>
              <tr>
                <td>
                  <strong>
                    <?= htmlspecialchars(
                      $adSoyad !== "" ? $adSoyad : "Personel #" . $personelId,
                      ENT_QUOTES,
                      "UTF-8",
                    ) ?>
                  </strong>
                </td>
                <td>
                  <?= htmlspecialchars(
                    (string) ($row["sicil_no"] ?? "—"),
                    ENT_QUOTES,
                    "UTF-8",
                  ) ?>
                </td>
                <td>
                  <?= htmlspecialchars(
                    (string) ($row["tamamlanma_tarihi"] ?? "—"),
                    ENT_QUOTES,
                    "UTF-8",
                  ) ?>
                </td>
                <td><?= (int) ($row["cevap_sayisi"] ?? 0) ?></td>
                <td class="text-center align-middle">
                  <form
                    method="post"
                    action="katilim_sil.php"
                    class="m-0 d-inline"
                    onsubmit="return confirm('Bu personelin anket katılımı ve tüm cevapları silinecek. Devam edilsin mi?');"
                  >
                    <input type="hidden" name="anket_id" value="<?= $anketId ?>" />
                    <input type="hidden" name="personel_id" value="<?= $personelId ?>" />
                    <input
                      type="hidden"
                      name="csrf"
                      value="<?= htmlspecialchars(adminCsrfToken(), ENT_QUOTES, "UTF-8") ?>"
                    />
                    <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">
                      <i class="fas fa-user-minus"></i>
                      Katılımı Sil
                    </button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php include __DIR__ . "/../includes/footer.php"; ?>
