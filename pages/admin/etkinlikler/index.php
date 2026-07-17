<?php
/**
 * Dosya sorumluluğu: Etkinlik kayıtlarını listeler ve yönetim işlemlerini sunar.
 *
 * Girdi doğrulama, yetkilendirme ve çıktı kaçışları bu dosyanın
 * mevcut güvenlik akışına uygun biçimde korunmalıdır.
 */
require_once __DIR__ . "/../includes/auth.php";

$currentPage = "etkinlikler";
$pageTitle = "Etkinlikler";

$kayitlar = dbFetchAll(
  $db,
  "SELECT * FROM etkinlikler ORDER BY tarih DESC"
);

include __DIR__ . "/../includes/header.php";
?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">

  <p class="text-muted mb-0">
    Toplam <strong><?= count($kayitlar) ?></strong> etkinlik
  </p>

  <a href="ekle.php" class="admin-btn admin-btn-primary">
    <i class="fas fa-plus"></i>
    Yeni Etkinlik
  </a>

</div>

<div class="admin-card">

  <div class="admin-card-body p-0">

    <?php if (empty($kayitlar)): ?>

      <p class="text-muted p-4 mb-0">
        Henüz etkinlik eklenmemiş.
      </p>

    <?php else: ?>

      <div class="admin-table-wrap">

        <table class="admin-table">

          <thead>
            <tr>
              <th>Görsel</th>
              <th>Başlık</th>
              <th>Tarih</th>
              <th>Durum</th>
              <th>Görüntülenme</th>

              <!-- İşlemler başlığı ortalandı -->
              <th class="text-center align-middle">
                İşlemler
              </th>
            </tr>
          </thead>

          <tbody>

            <?php foreach ($kayitlar as $row): ?>

              <tr>

                <!-- Görsel -->
                <td>

                  <?php if (!empty($row["resim"])): ?>

                    <img
                      src="<?= htmlspecialchars(
                        adminImgUrl($assetBase, $row["resim"]),
                        ENT_QUOTES,
                        "UTF-8"
                      ) ?>"
                      class="admin-thumb"
                      alt=""
                    />

                  <?php else: ?>

                    <span class="text-muted small">—</span>

                  <?php endif; ?>

                </td>

                <!-- Başlık -->
                <td>

                  <strong>
                    <?= htmlspecialchars(
                      mb_strimwidth(
                        $row["baslik"],
                        0,
                        45,
                        "..."
                      ),
                      ENT_QUOTES,
                      "UTF-8"
                    ) ?>
                  </strong>

                </td>

                <!-- Tarih -->
                <td>

                  <?= !empty($row["tarih"])
                    ? date("d.m.Y", strtotime($row["tarih"]))
                    : "—" ?>

                </td>

                <!-- Durum -->
                <?php $durum = dbEtkinliklerResolveDurum($row); ?>

                <td>

                  <span
                    class="admin-badge admin-badge-<?= $durum === "aktif"
                      ? "etkinlikler"
                      : "duyurular" ?>"
                  >
                    <?= htmlspecialchars(
                      dbEtkinliklerDurumLabel($durum),
                      ENT_QUOTES,
                      "UTF-8"
                    ) ?>
                  </span>

                </td>

                <!-- Görüntülenme -->
                <td>
                  <?= (int) ($row["view"] ?? 0) ?>
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

                      <!-- Düzenle -->
                      <li>

                        <a
                          class="dropdown-item d-flex align-items-center gap-2"
                          href="duzenle.php?id=<?= (int) $row["id"] ?>"
                        >
                          <i class="fas fa-pen"></i>
                          Düzenle
                        </a>

                      </li>

                      <li>
                        <hr class="dropdown-divider">
                      </li>

                      <!-- Sil -->
                      <li>

                        <form
                          method="post"
                          action="sil.php"
                          class="m-0"
                          onsubmit="return confirm('Bu etkinliği silmek istediğinize emin misiniz?');"
                        >

                          <input
                            type="hidden"
                            name="id"
                            value="<?= (int) $row["id"] ?>"
                          >

                          <input
                            type="hidden"
                            name="csrf"
                            value="<?= htmlspecialchars(
                              adminCsrfToken(),
                              ENT_QUOTES,
                              "UTF-8"
                            ) ?>"
                          >

                          <button
                            type="submit"
                            class="dropdown-item text-danger d-flex align-items-center gap-2"
                          >
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