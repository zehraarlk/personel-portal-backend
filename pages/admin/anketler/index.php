<?php
require_once __DIR__ . "/../includes/auth.php";

$currentPage = "anketler";
$pageTitle = "Anketler";

$kayitlar = adminFetchAnketler($db);
$durumlar = dbAnketlerKategoriAdiEslemesi();

include __DIR__ . "/../includes/header.php";
?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">

  <p class="text-muted mb-0">
    Toplam <strong><?= count($kayitlar) ?></strong> anket
  </p>

  <a href="ekle.php" class="admin-btn admin-btn-primary">
    <i class="fas fa-plus"></i>
    Yeni Anket
  </a>

</div>

<div class="admin-card">

  <div class="admin-card-body p-0">

    <?php if (empty($kayitlar)): ?>

      <p class="text-muted p-4 mb-0">
        Henüz anket yok.
      </p>

    <?php else: ?>

      <div class="admin-table-wrap">

        <table class="admin-table">

          <thead>
            <tr>
              <th>Başlık</th>
              <th>Durum</th>
              <th>Tarih Aralığı</th>
              <th>Katılım</th>

              <th class="text-center align-middle">
                İşlemler
              </th>
            </tr>
          </thead>

          <tbody>

            <?php foreach ($kayitlar as $row): ?>

              <tr>

                <!-- Başlık -->
                <td>
                  <strong>
                    <?= htmlspecialchars(
                      mb_strimwidth(
                        $row["baslik"] ?? "",
                        0,
                        45,
                        "..."
                      ),
                      ENT_QUOTES,
                      "UTF-8"
                    ) ?>
                  </strong>
                </td>

                <!-- Durum -->
                <td>
                  <?= htmlspecialchars(
                    $durumlar[$row["kategori"] ?? ""] ??
                      ($row["kategori_adi"] ?? "-"),
                    ENT_QUOTES,
                    "UTF-8"
                  ) ?>
                </td>

                <!-- Tarih aralığı -->
                <td>
                  <?= htmlspecialchars(
                    ($row["baslangic_tarihi"] ?? "") .
                      " - " .
                      ($row["bitis_tarihi"] ?? ""),
                    ENT_QUOTES,
                    "UTF-8"
                  ) ?>
                </td>

                <!-- Katılım -->
                <td>
                  <?= (int) ($row["katilim_sayisi"] ?? 0) ?>
                  /
                  <?= (int) ($row["hedef_katilim"] ?? 0) ?>
                </td>

                <!-- İşlemler -->
                <td class="text-center align-middle">

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
    <a class="dropdown-item d-flex align-items-center gap-2" href="sorular.php?anket_id=<?= (int)$row["id"] ?>">
      <i class="fas fa-list-check text-primary"></i>
      Soruları Yönet
    </a>
  </li>
  <li>
    <a class="dropdown-item d-flex align-items-center gap-2" href="sonuclar.php?anket_id=<?= (int)$row["id"] ?>">
      <i class="fas fa-chart-pie text-success"></i>
      Anket Sonuçları
    </a>
  </li>
  <li><hr class="dropdown-divider"></li>
  <li>
    <a class="dropdown-item d-flex align-items-center gap-2" href="duzenle.php?id=<?= (int) $row["id"] ?>">
      <i class="fas fa-pen"></i>
      Düzenle
    </a>
  </li>
  <li><hr class="dropdown-divider"></li>
  <li>
    <form method="post" action="sil.php" class="m-0" onsubmit="return confirm('Bu anketi silmek istediğinize emin misiniz?');">
      <input type="hidden" name="id" value="<?= (int) $row["id"] ?>">
      <input type="hidden" name="csrf" value="<?= htmlspecialchars(adminCsrfToken(), ENT_QUOTES, "UTF-8") ?>">
      <button type="submit" class="dropdown-item text-danger d-flex align-items-center gap-2">
        <i class="fas fa-trash"></i>
        Sil
      </button>
    </form>
  </li>
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