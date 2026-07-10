<?php
require_once __DIR__ . "/../includes/auth.php";

$currentPage = "anketler";
$pageTitle = "Anketler";
$kayitlar = adminFetchAnketler($db);
$durumlar = dbAnketlerKategoriAdiEslemesi();

include __DIR__ . "/../includes/header.php";
?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
  <p class="text-muted mb-0">Toplam <strong><?= count($kayitlar) ?></strong> anket</p>
  <a href="ekle.php" class="admin-btn admin-btn-primary"><i class="fas fa-plus"></i> Yeni Anket</a>
</div>

<div class="admin-card"><div class="admin-card-body p-0">
<?php if (empty($kayitlar)): ?><p class="text-muted p-4 mb-0">Henüz anket yok.</p>
<?php else: ?>
<table class="admin-table"><thead><tr><th>Başlık</th><th>Durum</th><th>Tarih Aralığı</th><th>Katılım</th><th>İşlemler</th></tr></thead><tbody>
<?php foreach ($kayitlar as $row): ?>
<tr>
  <td><strong><?= htmlspecialchars(
    mb_strimwidth($row["baslik"], 0, 45, "..."),
    ENT_QUOTES,
    "UTF-8",
  ) ?></strong></td>
  <td><?= htmlspecialchars(
    $durumlar[$row["kategori"] ?? ""] ?? ($row["kategori_adi"] ?? "-"),
    ENT_QUOTES,
    "UTF-8",
  ) ?></td>
  <td><?= htmlspecialchars(
    ($row["baslangic_tarihi"] ?? "") . " - " . ($row["bitis_tarihi"] ?? ""),
    ENT_QUOTES,
    "UTF-8",
  ) ?></td>
  <td><?= (int) ($row["katilim_sayisi"] ?? 0) ?> / <?= (int) ($row["hedef_katilim"] ?? 0) ?></td>
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
