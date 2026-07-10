<?php
require_once __DIR__ . "/../includes/auth.php";

$currentPage = "duyurular";
$pageTitle = "Duyurular";
$kayitlar = adminFetchDuyurular($db);

include __DIR__ . "/../includes/header.php";
?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
  <p class="text-muted mb-0">Toplam <strong><?= count($kayitlar) ?></strong> duyuru</p>
  <a href="ekle.php" class="admin-btn admin-btn-primary"><i class="fas fa-plus"></i> Yeni Duyuru</a>
</div>

<div class="admin-card">
  <div class="admin-card-body p-0">
    <?php if (empty($kayitlar)): ?>
      <p class="text-muted p-4 mb-0">Henüz duyuru eklenmemiş.</p>
    <?php else: ?>
    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Görsel</th>
            <th>Başlık</th>
            <th>Kategori</th>
            <th>Tarih</th>
            <th>İşlemler</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($kayitlar as $row): ?>
          <tr>
            <td>
              <?php if (!empty($row["resim_url"])): ?>
                <img src="<?= htmlspecialchars(
                  adminImgUrl($assetBase, $row["resim_url"]),
                  ENT_QUOTES,
                  "UTF-8",
                ) ?>" alt="" class="admin-thumb" />
              <?php else: ?>
                <span class="text-muted small">—</span>
              <?php endif; ?>
            </td>
            <td><strong><?= htmlspecialchars(
              mb_strimwidth($row["baslik"], 0, 50, "..."),
              ENT_QUOTES,
              "UTF-8",
            ) ?></strong></td>
            <td><?= htmlspecialchars(
              $row["kategori_adi"] ?? ($row["alt_tip"] ?? "-"),
              ENT_QUOTES,
              "UTF-8",
            ) ?></td>
            <td><?= !empty($row["tarih"]) ? date("d.m.Y", strtotime($row["tarih"])) : "—" ?></td>
            <td>
              <div class="admin-actions">
                <a href="duzenle.php?id=<?= (int) $row[
                  "id"
                ] ?>" class="admin-btn admin-btn-secondary admin-btn-sm"><i class="fas fa-pen"></i></a>
                <form method="post" action="sil.php" class="d-inline" onsubmit="return confirm('Silmek istediğinize emin misiniz?');">
                  <input type="hidden" name="id" value="<?= (int) $row["id"] ?>" />
                  <input type="hidden" name="csrf" value="<?= htmlspecialchars(
                    adminCsrfToken(),
                    ENT_QUOTES,
                    "UTF-8",
                  ) ?>" />
                  <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm"><i class="fas fa-trash"></i></button>
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
