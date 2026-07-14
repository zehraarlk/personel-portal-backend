<?php
require_once __DIR__ . "/../includes/auth.php";

$currentPage = "yoneticiler";
$pageTitle = "Yöneticiler";
$kayitlar = dbFetchAll($db, "SELECT * FROM yoneticiler ORDER BY ad ASC, soyad ASC");

include __DIR__ . "/../includes/header.php";
?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
  <p class="text-muted mb-0">Toplam <strong><?= count($kayitlar) ?></strong> yönetici</p>
  <a href="ekle.php" class="admin-btn admin-btn-primary"><i class="fas fa-user-plus"></i> Yönetici Ekle</a>
</div>

<div class="admin-card">
  <div class="admin-card-body p-0">
    <?php if (empty($kayitlar)): ?>
      <p class="text-muted p-4 mb-0">Henüz yönetici eklenmemiş.</p>
    <?php else: ?>
    <div class="admin-table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Kullanıcı Adı</th>
            <th>Ad Soyad</th>
            <th>Yetki</th>
            <th>Durum</th>
            <th>İşlemler</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($kayitlar as $row): ?>
          <tr>
            <td><code><?= htmlspecialchars($row["kullanici_adi"], ENT_QUOTES, "UTF-8") ?></code></td>
            <td>
              <strong><?= htmlspecialchars(trim($row["ad"] . " " . $row["soyad"]), ENT_QUOTES, "UTF-8") ?></strong>
              <?php if ((int) $row["id"] === (int) ($_SESSION["yonetici_id"] ?? 0)): ?>
                <span class="badge bg-secondary ms-1">Siz</span>
              <?php endif; ?>
            </td>
            <td>
              <?php if ($row["yetki"] === "super_admin"): ?>
                <span class="badge bg-purple">Süper Admin</span>
              <?php else: ?>
                <span class="badge bg-info text-dark">Admin</span>
              <?php endif; ?>
            </td>
            <td>
              <?php if ((int) $row["aktif"] === 1): ?>
                <span class="badge bg-success">Aktif</span>
              <?php else: ?>
                <span class="badge bg-secondary">Pasif</span>
              <?php endif; ?>
            </td>
            <td>
              <div class="admin-actions">
                <a href="duzenle.php?id=<?= (int) $row["id"] ?>" class="admin-btn admin-btn-secondary admin-btn-sm">
                  <i class="fas fa-pen"></i>
                </a>
                <?php if ((int) $row["id"] !== (int) ($_SESSION["yonetici_id"] ?? 0)): ?>
                <form method="post" action="sil.php" class="d-inline" onsubmit="return confirm('Bu yöneticiyi silmek istediğinize emin misiniz?');">
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
                <?php endif; ?>
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
