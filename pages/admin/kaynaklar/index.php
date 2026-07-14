<?php
require_once __DIR__ . "/../includes/auth.php";

$currentPage = "kaynaklar";
$pageTitle = "Kaynaklar";

$kategoriFiltre = trim($_GET["kategori"] ?? "");
$kategoriler = dbKaynaklarKategoriler($db);

$kayitlar = adminFetchKaynaklar(
  $db,
  $kategoriFiltre !== "" ? $kategoriFiltre : null
);

include __DIR__ . "/../includes/header.php";
?>

<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">

  <p class="text-muted mb-0">
    Toplam <strong><?= count($kayitlar) ?></strong> kaynak
  </p>

  <a href="ekle.php" class="admin-btn admin-btn-primary">
    <i class="fas fa-plus"></i>
    Yeni Kaynak
  </a>

</div>

<<<<<<< HEAD
<form method="get" class="admin-form mb-4 d-flex flex-wrap gap-2 align-items-end">
  <div>
    <label class="form-label" for="kaynakKategori">Kategori</label>
    <select
      id="kaynakKategori"
      name="kategori"
      class="form-select form-select-sm admin-filter-select"
      onchange="this.form.submit()"
    >
      <option value="">Tümü</option>
      <?php foreach ($kategoriler as $kat): ?>
        <option
          value="<?= htmlspecialchars($kat["slug"], ENT_QUOTES, "UTF-8") ?>"
          <?= $kategoriFiltre === $kat["slug"] ? "selected" : "" ?>
        >
          <?= htmlspecialchars($kat["ad"], ENT_QUOTES, "UTF-8") ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
</form>
=======
<!-- Kategori filtreleri -->
<div class="mb-4 d-flex flex-wrap gap-2">

  <a
    href="index.php"
    class="admin-btn admin-btn-sm <?= $kategoriFiltre === ""
      ? "admin-btn-primary"
      : "admin-btn-secondary" ?>"
  >
    Tümü
  </a>

  <?php foreach ($kategoriler as $kat): ?>

    <a
      href="index.php?kategori=<?= urlencode($kat["slug"]) ?>"
      class="admin-btn admin-btn-sm <?= $kategoriFiltre === $kat["slug"]
        ? "admin-btn-primary"
        : "admin-btn-secondary" ?>"
    >
      <?= htmlspecialchars(
        $kat["ad"],
        ENT_QUOTES,
        "UTF-8"
      ) ?>
    </a>

  <?php endforeach; ?>

</div>
>>>>>>> da0ab1ce9c2e683fa29c9cbbff849780f358e71f

<div class="admin-card">

  <div class="admin-card-body p-0">

    <?php if (empty($kayitlar)): ?>

      <p class="text-muted p-4 mb-0">
        Bu kategoride kayıt bulunmuyor.
      </p>

    <?php else: ?>

      <div class="admin-table-wrap">

        <table class="admin-table">

          <thead>
            <tr>
              <th>Başlık</th>
              <th>Kategori</th>
              <th>Alt Kategori</th>
              <th>Boyut</th>
              <th>Tarih</th>

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

                  <?php if (!empty($row["ikon"])): ?>

                    <div class="text-muted small">
                      <i class="<?= htmlspecialchars(
                        $row["ikon"],
                        ENT_QUOTES,
                        "UTF-8"
                      ) ?>"></i>
                    </div>

                  <?php endif; ?>

                </td>

                <!-- Kategori -->
                <td>

                  <?= htmlspecialchars(
                    $row["kategori_adi"] ?? "-",
                    ENT_QUOTES,
                    "UTF-8"
                  ) ?>

                </td>

                <!-- Alt kategori -->
                <td>

                  <?= htmlspecialchars(
                    $row["alt_kategori_adi"] ?? "-",
                    ENT_QUOTES,
                    "UTF-8"
                  ) ?>

                </td>

                <!-- Dosya boyutu -->
                <td>

                  <?= htmlspecialchars(
                    $row["boyut"] ?? "-",
                    ENT_QUOTES,
                    "UTF-8"
                  ) ?>

                </td>

                <!-- Tarih -->
                <td>

                  <?php
                  $tarih = trim((string) ($row["tarih"] ?? ""));
                  ?>

                  <?= htmlspecialchars(
                    $tarih !== "" ? $tarih : "—",
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

                      <!-- Dosyayı aç -->
                      <?php if (!empty($row["dosya_yolu"])): ?>

                        <li>

                          <a
                            class="dropdown-item d-flex align-items-center gap-2"
                            href="<?= htmlspecialchars(
                              adminImgUrl(
                                $assetBase,
                                $row["dosya_yolu"]
                              ),
                              ENT_QUOTES,
                              "UTF-8"
                            ) ?>"
                            target="_blank"
                            rel="noopener noreferrer"
                          >
                            <i class="fas fa-external-link-alt"></i>
                            Dosyayı Aç
                          </a>

                        </li>

                        <li>
                          <hr class="dropdown-divider">
                        </li>

                      <?php endif; ?>

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
                          onsubmit="return confirm('Bu kaynağı silmek istediğinize emin misiniz?');"
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