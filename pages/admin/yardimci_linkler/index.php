<?php
require_once __DIR__ . "/../includes/auth.php";

$currentPage = "linkler";
$pageTitle = "Yardımcı Linkler";
$kayitlar = dbFetchAll($db, "SELECT * FROM yardimci_linkler ORDER BY id ASC");
$katMap = dbYardimciLinklerKategoriAdiEslemesi();

include __DIR__ . "/../includes/header.php";
?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
  <p class="text-muted mb-0">Toplam <strong><?= count($kayitlar) ?></strong> link</p>
  <a href="ekle.php" class="admin-btn admin-btn-primary"><i class="fas fa-plus"></i> Yeni Link</a>
</div>

<div class="admin-card"><div class="admin-card-body p-0">
<table class="admin-table"><thead><tr><th>Logo</th><th>Başlık</th><th>Kategori</th><th>URL</th><th>İşlemler</th></tr></thead><tbody>
<?php foreach ($kayitlar as $row): ?>
<tr>
  <td><?php
  $logo = yardimciLinkLogo($row);
  if ($logo): ?><img src="<?= htmlspecialchars(
  adminImgUrl($assetBase, $logo),
  ENT_QUOTES,
  "UTF-8",
) ?>" class="admin-thumb" style="width:40px;height:40px;object-fit:contain" alt="" /><?php endif;
  ?></td>
  <td><strong><?= htmlspecialchars($row["baslik"], ENT_QUOTES, "UTF-8") ?></strong></td>
  <td><?= htmlspecialchars(
    $katMap[$row["kategori"]] ?? $row["kategori"],
    ENT_QUOTES,
    "UTF-8",
  ) ?></td>
  <td><small><?= htmlspecialchars(
    mb_strimwidth($row["hedef_url"], 0, 40, "..."),
    ENT_QUOTES,
    "UTF-8",
  ) ?></small></td>
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
</div></div>

<?php include __DIR__ . "/../includes/footer.php"; ?>
