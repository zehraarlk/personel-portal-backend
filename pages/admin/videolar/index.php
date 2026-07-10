<?php
require_once __DIR__ . "/../includes/auth.php";

$currentPage = "videolar";
$pageTitle = "Videolar";

$videolar = dbVideolarAttachKategoriSlug(
  $db,
  dbFetchAll($db, dbVideolarListSql($db)),
);

include __DIR__ . "/../includes/header.php";
?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
  <p class="text-muted mb-0">Toplam <strong><?= count($videolar) ?></strong> video</p>
  <a href="ekle.php" class="admin-btn admin-btn-primary">
    <i class="fas fa-plus"></i> Yeni Video Ekle
  </a>
</div>

<div class="admin-card">
  <div class="admin-card-body p-0">
    <?php if (empty($videolar)): ?>
      <p class="text-muted p-4 mb-0">Henüz video eklenmemiş. İlk videoyu eklemek için yukarıdaki butonu kullanın.</p>
    <?php else: ?>
    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Önizleme</th>
            <th>Başlık</th>
            <th>Kategori</th>
            <th>Süre</th>
            <th>YouTube ID</th>
            <th>Haftanın Videosu</th>
            <th>İşlemler</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($videolar as $video): ?>
          <tr<?= !empty($video["vitrin"]) ? ' class="table-warning"' : "" ?>>
            <td>
              <img
                src="https://img.youtube.com/vi/<?= htmlspecialchars(
                  $video["youtube_id"],
                  ENT_QUOTES,
                  "UTF-8",
                ) ?>/hqdefault.jpg"
                alt=""
                class="admin-thumb"
              />
            </td>
            <td>
              <strong><?= htmlspecialchars($video["baslik"], ENT_QUOTES, "UTF-8") ?></strong>
              <?php if (!empty($video["vitrin"])): ?>
                <span class="admin-badge admin-badge-etkinlikler ms-1"><i class="fas fa-star me-1"></i>Haftanın Videosu</span>
              <?php endif; ?>
            </td>
            <td>
              <?php $kategoriSlug = (string) ($video["kategori"] ?? ""); ?>
              <span class="admin-badge admin-badge-<?= htmlspecialchars(
                $kategoriSlug !== "" ? $kategoriSlug : "genel",
                ENT_QUOTES,
                "UTF-8",
              ) ?>">
                <?= htmlspecialchars(
                  dbVideolarKategoriAdi($kategoriSlug !== "" ? $kategoriSlug : null),
                  ENT_QUOTES,
                  "UTF-8",
                ) ?>
              </span>
            </td>
            <td><?= htmlspecialchars($video["sure"], ENT_QUOTES, "UTF-8") ?></td>
            <td><code><?= htmlspecialchars($video["youtube_id"], ENT_QUOTES, "UTF-8") ?></code></td>
            <td>
              <?php if (!empty($video["vitrin"])): ?>
                <span class="text-success fw-semibold"><i class="fas fa-check-circle me-1"></i>Aktif</span>
              <?php else: ?>
                <form method="post" action="vitrin.php" class="d-inline" onsubmit="return confirm('Bu videoyu haftanın videosu yapmak istiyor musunuz?');">
                  <input type="hidden" name="id" value="<?= (int) $video["id"] ?>" />
                  <input type="hidden" name="csrf" value="<?= htmlspecialchars(
                    adminCsrfToken(),
                    ENT_QUOTES,
                    "UTF-8",
                  ) ?>" />
                  <button type="submit" class="admin-btn admin-btn-primary admin-btn-sm" title="Haftanın videosu yap">
                    <i class="fas fa-star"></i> Seç
                  </button>
                </form>
              <?php endif; ?>
            </td>
            <td>
              <div class="admin-actions">
                <a href="duzenle.php?id=<?= (int) $video[
                  "id"
                ] ?>" class="admin-btn admin-btn-secondary admin-btn-sm">
                  <i class="fas fa-pen"></i> Düzenle
                </a>
                <form method="post" action="sil.php" class="d-inline" onsubmit="return confirm('Bu videoyu silmek istediğinize emin misiniz?');">
                  <input type="hidden" name="id" value="<?= (int) $video["id"] ?>" />
                  <input type="hidden" name="csrf" value="<?= htmlspecialchars(
                    adminCsrfToken(),
                    ENT_QUOTES,
                    "UTF-8",
                  ) ?>" />
                  <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">
                    <i class="fas fa-trash"></i> Sil
                  </button>
                </form>
              </div>
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
