<?php
require_once __DIR__ . "/../includes/auth.php";

$currentPage = "vefat";
$pageTitle = "Vefat Bilgileri";
$kayitlar = dbFetchAll($db, "SELECT * FROM vefat_bilgileri ORDER BY vefat_tarihi DESC");

include __DIR__ . "/../includes/header.php";
?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
  <p class="text-muted mb-0">Toplam <strong><?= count($kayitlar) ?></strong> kayıt</p>
  <a href="ekle.php" class="admin-btn admin-btn-primary"><i class="fas fa-plus"></i> Yeni Kayıt</a>
</div>

<div class="admin-card"><div class="admin-card-body p-0">
<table class="admin-table"><thead><tr><th>Vefat Eden</th><th>İlişki</th><th>Tarih</th><th>İşlemler</th></tr></thead><tbody>
<?php foreach ($kayitlar as $row): ?>
<tr>
  <td><strong><?= htmlspecialchars($row["vefat_eden_adi"], ENT_QUOTES, "UTF-8") ?></strong></td>
  <td><?= htmlspecialchars(
    mb_strimwidth($row["iliski_pozisyon"], 0, 50, "..."),
    ENT_QUOTES,
    "UTF-8",
  ) ?></td>
  <td><?= htmlspecialchars(
    $row["vefat_tarihi_metin"] ?? date("d.m.Y", strtotime($row["vefat_tarihi"])),
    ENT_QUOTES,
    "UTF-8",
  ) ?></td>
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
