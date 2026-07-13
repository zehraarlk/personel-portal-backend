<?php
require_once __DIR__ . "/../includes/auth.php";

$currentPage = "personeller";
$pageTitle = "Personeller";
$kayitlar = dbFetchAll($db, "SELECT * FROM personeller ORDER BY ad ASC, soyad ASC");

include __DIR__ . "/../includes/header.php";
?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
  <p class="text-muted mb-0">Toplam <strong><?= count($kayitlar) ?></strong> personel</p>
  <a href="ekle.php" class="admin-btn admin-btn-primary"><i class="fas fa-user-plus"></i> Personel Ekle</a>
</div>

<div class="admin-card">
  <div class="admin-card-body p-0">
    <?php if (empty($kayitlar)): ?>
      <p class="text-muted p-4 mb-0">Henüz personel eklenmemiş.</p>
    <?php else: ?>
    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Foto</th>
            <th>Sicil No</th>
            <th>Ad Soyad</th>
            <th>E-posta</th>
            <th>Doğum Tarihi</th>
            <th>İşlemler</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($kayitlar as $row): ?>
          <tr>
            <td>
              <?php if (!empty($row["foto_url"])): ?>
                <img
                  src="<?= htmlspecialchars(adminImgUrl($assetBase, $row["foto_url"]), ENT_QUOTES, "UTF-8") ?>"
                  class="admin-thumb"
                  style="width:40px;height:40px;object-fit:cover;border-radius:50%"
                  alt=""
                />
              <?php endif; ?>
            </td>
            <td><code><?= htmlspecialchars($row["sicil_no"], ENT_QUOTES, "UTF-8") ?></code></td>
            <td><strong><?= htmlspecialchars(
              trim($row["ad"] . " " . $row["soyad"]),
              ENT_QUOTES,
              "UTF-8",
            ) ?></strong></td>
            <td><?= htmlspecialchars($row["email"], ENT_QUOTES, "UTF-8") ?></td>
            <td><?= !empty($row["dogum_tarihi"])
              ? htmlspecialchars(date("d.m.Y", strtotime($row["dogum_tarihi"])), ENT_QUOTES, "UTF-8")
              : "-" ?></td>
            <td>
              <div class="admin-actions">
                <a href="duzenle.php?id=<?= (int) $row["id"] ?>" class="admin-btn admin-btn-secondary admin-btn-sm">
                  <i class="fas fa-pen"></i>
                </a>
                <form method="post" action="sil.php" class="d-inline" onsubmit="return confirm('Bu personeli silmek istediğinize emin misiniz?');">
                  <input type="hidden" name="id" value="<?= (int) $row["id"] ?>" />
                  <input type="hidden" name="csrf" value="<?= htmlspecialchars(
                    adminCsrfToken(),
                    ENT_QUOTES,
                    "UTF-8",
                  ) ?>" />
                  <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">
                    <i class="fas fa-trash"></i>
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
