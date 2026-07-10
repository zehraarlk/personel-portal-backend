<?php
require_once __DIR__ . "/../includes/auth.php";

$currentPage = "kaynaklar";
$pageTitle = "Kaynaklar";
$kategoriFiltre = trim($_GET["kategori"] ?? "");
$kategoriler = dbKaynaklarKategoriler($db);
$kayitlar = adminFetchKaynaklar($db, $kategoriFiltre !== "" ? $kategoriFiltre : null);

include __DIR__ . "/../includes/header.php";
?>

<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
  <p class="text-muted mb-0">Toplam <strong><?= count($kayitlar) ?></strong> kaynak</p>
  <a href="ekle.php" class="admin-btn admin-btn-primary"><i class="fas fa-plus"></i> Yeni Kaynak</a>
</div>

<div class="mb-4 d-flex flex-wrap gap-2">
  <a href="index.php" class="admin-btn admin-btn-sm <?= $kategoriFiltre === ""
    ? "admin-btn-primary"
    : "admin-btn-secondary" ?>">Tümü</a>
  <?php foreach ($kategoriler as $kat): ?>
    <a href="index.php?kategori=<?= urlencode(
      $kat["slug"],
    ) ?>" class="admin-btn admin-btn-sm <?= $kategoriFiltre === $kat["slug"]
  ? "admin-btn-primary"
  : "admin-btn-secondary" ?>">
      <?= htmlspecialchars($kat["ad"], ENT_QUOTES, "UTF-8") ?>
    </a>
  <?php endforeach; ?>
</div>

<div class="admin-card"><div class="admin-card-body p-0">
<?php if (empty($kayitlar)): ?>
  <p class="text-muted p-4 mb-0">Bu kategoride kayıt bulunmuyor.</p>
<?php else: ?>
<table class="admin-table">
  <thead>
    <tr>
      <th>Başlık</th>
      <th>Kategori</th>
      <th>Alt Kategori</th>
      <th>Boyut</th>
      <th>Tarih</th>
      <th>İşlemler</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($kayitlar as $row): ?>
    <tr>
      <td>
        <strong><?= htmlspecialchars(
          mb_strimwidth($row["baslik"], 0, 45, "..."),
          ENT_QUOTES,
          "UTF-8",
        ) ?></strong>
        <?php if (
          !empty($row["ikon"])
        ): ?><div class="text-muted small"><i class="<?= htmlspecialchars(
  $row["ikon"],
  ENT_QUOTES,
  "UTF-8",
) ?>"></i></div><?php endif; ?>
      </td>
      <td><?= htmlspecialchars($row["kategori_adi"] ?? "-", ENT_QUOTES, "UTF-8") ?></td>
      <td><?= htmlspecialchars($row["alt_kategori_adi"] ?? "-", ENT_QUOTES, "UTF-8") ?></td>
      <td><?= htmlspecialchars($row["boyut"] ?? "-", ENT_QUOTES, "UTF-8") ?></td>
      <td><?= htmlspecialchars(trim($row["tarih"] ?? ""), ENT_QUOTES, "UTF-8") ?></td>
      <td>
        <div class="admin-actions">
          <?php if (!empty($row["dosya_yolu"])): ?>
            <a href="<?= htmlspecialchars(
              adminImgUrl($assetBase, $row["dosya_yolu"]),
              ENT_QUOTES,
              "UTF-8",
            ) ?>" target="_blank" class="admin-btn admin-btn-secondary admin-btn-sm" title="Dosyayı aç"><i class="fas fa-external-link-alt"></i></a>
          <?php endif; ?>
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
<?php endif; ?>
</div></div>

<?php include __DIR__ . "/../includes/footer.php"; ?>
