<?php
require_once __DIR__ . "/../includes/auth.php";

$currentPage = "linkler";
$pageTitle = "Yardımcı Linkler";

$kayitlar = dbFetchYardimciLinkler($db);
$katMap = dbYardimciLinklerKategoriAdiEslemesi();

include __DIR__ . "/../includes/header.php";
?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">

  <p class="text-muted mb-0">
    Toplam <strong><?= count($kayitlar) ?></strong> link
  </p>

  <a href="ekle.php" class="admin-btn admin-btn-primary">
    <i class="fas fa-plus"></i>
    Yeni Link
  </a>

</div>

<div class="admin-card">

  <div class="admin-card-body p-0">

    <?php if (empty($kayitlar)): ?>

      <p class="text-muted p-4 mb-0">
        Henüz yardımcı link eklenmemiş.
      </p>

    <?php else: ?>

      <div class="admin-table-wrap">

        <table class="admin-table">

          <thead>
            <tr>
              <th>Logo</th>
              <th>Başlık</th>
              <th>Kategori</th>
              <th>URL</th>

              <th class="text-center align-middle">
                İşlemler
              </th>
            </tr>
          </thead>

          <tbody>

            <?php foreach ($kayitlar as $row): ?>

              <tr>

                <!-- Logo -->
                <td>

                  <?php
                  $logo = yardimciLinkLogo($row);
                  ?>

                  <?php if ($logo): ?>

                    <img
                      src="<?= htmlspecialchars(
                        adminImgUrl($assetBase, $logo),
                        ENT_QUOTES,
                        "UTF-8"
                      ) ?>"
                      class="admin-thumb"
                      style="width: 40px; height: 40px; object-fit: contain;"
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
                      $row["baslik"] ?? "",
                      ENT_QUOTES,
                      "UTF-8"
                    ) ?>
                  </strong>

                </td>

                <!-- Kategori -->
                <td>

                  <?= htmlspecialchars(
                    dbYardimciLinkKategoriLabel($row, $katMap),
                    ENT_QUOTES,
                    "UTF-8"
                  ) ?>

                </td>

                <!-- URL -->
                <td>

                  <small>
                    <?= htmlspecialchars(
                      mb_strimwidth(
                        $row["hedef_url"] ?? "",
                        0,
                        40,
                        "..."
                      ),
                      ENT_QUOTES,
                      "UTF-8"
                    ) ?>
                  </small>

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
                          onsubmit="return confirm('Bu yardımcı linki silmek istediğinize emin misiniz?');"
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