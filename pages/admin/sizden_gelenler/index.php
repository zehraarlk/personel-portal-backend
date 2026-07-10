<?php
require_once __DIR__ . "/../includes/auth.php";

$currentPage = "sizden";
$pageTitle = "Sizden Gelenler";
$kayitlar = dbFetchAll(
  $db,
  "SELECT sg.*, k.slug AS kategori_slug, k.ad AS kategori_adi
     FROM sizden_gelenler sg
     LEFT JOIN sizdengelenler_kategori k ON sg.kategori_id = k.id
     ORDER BY sg.tarih DESC",
);

include __DIR__ . "/../includes/header.php";
?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
  <p class="text-muted mb-0">Toplam <strong><?= count($kayitlar) ?></strong> kayıt</p>
  <a href="ekle.php" class="admin-btn admin-btn-primary"><i class="fas fa-plus"></i> Yeni Kayıt</a>
</div>

<div class="admin-card"><div class="admin-card-body p-0">
<?php if (empty($kayitlar)): ?>
  <p class="text-muted p-4 mb-0">Henüz kayıt yok.</p>
<?php else: ?>
<table class="admin-table"><thead><tr><th>Görsel</th><th>Başlık</th><th>Kategori</th><th>Tarih</th><th>Görüntülenme</th><th>İşlemler</th></tr></thead><tbody>
<?php foreach ($kayitlar as $row): ?>
<tr>
  <td><?php if (!empty($row["gorsel_yolu"])): ?><img src="<?= htmlspecialchars(
  adminImgUrl($assetBase, $row["gorsel_yolu"]),
  ENT_QUOTES,
  "UTF-8",
) ?>" class="admin-thumb" alt="" /><?php endif; ?></td>
  <td><strong><?= htmlspecialchars(
    mb_strimwidth($row["baslik"], 0, 40, "..."),
    ENT_QUOTES,
    "UTF-8",
  ) ?></strong></td>
  <td><?= htmlspecialchars($row["kategori_adi"] ?? "-", ENT_QUOTES, "UTF-8") ?></td>
  <td><?= date("d.m.Y", strtotime($row["tarih"])) ?></td>
  <td><?= (int) ($row["goruntulenme"] ?? 0) ?></td>
  <td><div class="admin-actions">
    <a href="duzenle.php?id=<?= (int) $row[
      "id"
    ] ?>" class="admin-btn admin-btn-secondary admin-btn-sm"><i class="fas fa-pen"></i></a>
    <form method="post" action="sil.php" class="d-inline" onsubmit="return confirm('Silmek istediğinize emin misiniz?');">
      <input type="hidden" name="id" value="<?= (int) $row[
        "id"
      ] ?>" /><input type="hidden" name="csrf" value="<?= htmlspecialchars(
  adminCsrfToken(),
  ENT_QUOTES,
  "UTF-8",
) ?>" />
      <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm"><i class="fas fa-trash"></i></button>
    </form>
  </div></td>
</tr>
<?php endforeach; ?>
</tbody></table>
<?php endif; ?>
</div></div>

<?php include __DIR__ . "/../includes/footer.php"; ?>
