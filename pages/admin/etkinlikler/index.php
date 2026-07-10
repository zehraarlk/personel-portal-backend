<?php
require_once __DIR__ . "/../includes/auth.php";

$currentPage = "etkinlikler";
$pageTitle = "Etkinlikler";
$kayitlar = dbFetchAll($db, "SELECT * FROM etkinlikler ORDER BY tarih DESC");

include __DIR__ . "/../includes/header.php";
?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
  <p class="text-muted mb-0">Toplam <strong><?= count($kayitlar) ?></strong> etkinlik</p>
  <a href="ekle.php" class="admin-btn admin-btn-primary"><i class="fas fa-plus"></i> Yeni Etkinlik</a>
</div>

<div class="admin-card">
  <div class="admin-card-body p-0">
    <?php if (empty($kayitlar)): ?>
      <p class="text-muted p-4 mb-0">Henüz etkinlik eklenmemiş.</p>
    <?php else: ?>
    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead>
          <tr><th>Görsel</th><th>Başlık</th><th>Tarih</th><th>Durum</th><th>Görüntülenme</th><th>İşlemler</th></tr>
        </thead>
        <tbody>
          <?php foreach ($kayitlar as $row): ?>
          <tr>
            <td><?php if (!empty($row["resim"])): ?><img src="<?= htmlspecialchars(
  adminImgUrl($assetBase, $row["resim"]),
  ENT_QUOTES,
  "UTF-8",
) ?>" class="admin-thumb" alt="" /><?php endif; ?></td>
            <td><strong><?= htmlspecialchars(
              mb_strimwidth($row["baslik"], 0, 45, "..."),
              ENT_QUOTES,
              "UTF-8",
            ) ?></strong></td>
            <td><?= date("d.m.Y", strtotime($row["tarih"])) ?></td>
            <?php $durum = dbEtkinliklerResolveDurum($row); ?>
            <td><span class="admin-badge admin-badge-<?= $durum === "aktif"
              ? "etkinlikler"
              : "duyurular" ?>"><?= htmlspecialchars(
  dbEtkinliklerDurumLabel($durum),
  ENT_QUOTES,
  "UTF-8",
) ?></span></td>
            <td><?= (int) ($row["view"] ?? 0) ?></td>
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
