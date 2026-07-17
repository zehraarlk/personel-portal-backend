<?php
/**
 * Dosya sorumluluğu: Yönetici kayıtlarını listeler ve yönetim işlemlerini sunar.
 *
 * Girdi doğrulama, yetkilendirme ve çıktı kaçışları bu dosyanın
 * mevcut güvenlik akışına uygun biçimde korunmalıdır.
 */
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
              <div class="dropdown d-inline-block position-static">
                <button
                  type="button"
                  class="admin-btn admin-btn-secondary admin-btn-sm dropdown-toggle text-nowrap"
                  data-bs-toggle="dropdown"
                  data-bs-boundary="viewport"
                  aria-expanded="false"
                >
                  <i class="fas fa-gear"></i>
                  İşlem Yap
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm text-start">
                  <li>
                    <a class="dropdown-item d-flex align-items-center gap-2" href="duzenle.php?id=<?= (int) $row["id"] ?>">
                      <i class="fas fa-pen"></i>
                      Düzenle
                    </a>
                  </li>
                  <?php if ((int) $row["id"] !== (int) ($_SESSION["yonetici_id"] ?? 0)): ?>
                  <li><hr class="dropdown-divider"></li>
                  <li>
                    <form method="post" action="sil.php" class="m-0" onsubmit="return confirm('Bu yöneticiyi silmek istediğinize emin misiniz?');">
                      <input type="hidden" name="id" value="<?= (int) $row["id"] ?>" />
                      <input type="hidden" name="csrf" value="<?= htmlspecialchars(adminCsrfToken(), ENT_QUOTES, "UTF-8") ?>" />
                      <button type="submit" class="dropdown-item text-danger d-flex align-items-center gap-2">
                        <i class="fas fa-trash"></i>
                        Sil
                      </button>
                    </form>
                  </li>
                  <?php endif; ?>
                </ul>
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
