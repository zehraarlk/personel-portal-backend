<?php
require_once __DIR__ . "/../includes/auth.php";

$currentPage = "personeller";
$pageTitle = "Personeller";

$kayitlar = dbFetchAll(
  $db,
  "SELECT * FROM personeller ORDER BY ad ASC, soyad ASC"
);

include __DIR__ . "/../includes/header.php";
?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">

  <p class="text-muted mb-0">
    Toplam <strong><?= count($kayitlar) ?></strong> personel
  </p>

  <a href="ekle.php" class="admin-btn admin-btn-primary">
    <i class="fas fa-user-plus"></i>
    Personel Ekle
  </a>

</div>

<div class="admin-card">

  <div class="admin-card-body p-0">

    <?php if (empty($kayitlar)): ?>

      <p class="text-muted p-4 mb-0">
        Henüz personel eklenmemiş.
      </p>

    <?php else: ?>

      <div class="admin-table-wrap">

        <table class="admin-table">

          <thead>
            <tr>
              <th>Foto</th>
              <th>Sicil No</th>
              <th>Ad Soyad</th>
              <th>E-posta</th>
              <th>Doğum Tarihi</th>

              <th class="text-center align-middle">
                İşlemler
              </th>
            </tr>
          </thead>

          <tbody>

            <?php foreach ($kayitlar as $row): ?>

              <tr>

                <!-- Fotoğraf -->
                <td>

                  <?php if (!empty($row["foto_url"])): ?>

                    <img
                      src="<?= htmlspecialchars(
                        adminImgUrl($assetBase, $row["foto_url"]),
                        ENT_QUOTES,
                        "UTF-8"
                      ) ?>"
                      class="admin-thumb"
                      style="
                        width: 40px;
                        height: 40px;
                        object-fit: cover;
                        border-radius: 50%;
                      "
                      alt=""
                    />

                  <?php else: ?>

                    <span class="text-muted small">—</span>

                  <?php endif; ?>

                </td>

                <!-- Sicil numarası -->
                <td>

                  <code>
                    <?= htmlspecialchars(
                      $row["sicil_no"] ?? "",
                      ENT_QUOTES,
                      "UTF-8"
                    ) ?>
                  </code>

                </td>

                <!-- Ad soyad -->
                <td>

                  <strong>
                    <?= htmlspecialchars(
                      trim(
                        ($row["ad"] ?? "") .
                        " " .
                        ($row["soyad"] ?? "")
                      ),
                      ENT_QUOTES,
                      "UTF-8"
                    ) ?>
                  </strong>

                </td>

                <!-- E-posta -->
                <td>

                  <?= htmlspecialchars(
                    $row["email"] ?? "",
                    ENT_QUOTES,
                    "UTF-8"
                  ) ?>

                </td>

                <!-- Doğum tarihi -->
                <td>

                  <?php
                  $dogumTarihi = "—";

                  if (!empty($row["dogum_tarihi"])) {
                    $timestamp = strtotime($row["dogum_tarihi"]);

                    if ($timestamp !== false) {
                      $dogumTarihi = date("d.m.Y", $timestamp);
                    }
                  }
                  ?>

                  <?= htmlspecialchars(
                    $dogumTarihi,
                    ENT_QUOTES,
                    "UTF-8"
                  ) ?>

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
                          onsubmit="return confirm('Bu personeli silmek istediğinize emin misiniz?');"
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