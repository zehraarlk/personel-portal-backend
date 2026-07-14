<?php
require_once __DIR__ . "/../includes/auth.php";

$currentPage = "videolar";
$pageTitle = "Videolar";

$videolar = dbVideolarAttachKategoriSlug(
  $db,
  dbFetchAll($db, dbVideolarListSql($db)),
);

include __DIR__ . "/../includes/header.php";
?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
  <p class="text-muted mb-0">
    Toplam <strong><?= count($videolar) ?></strong> video
  </p>

  <a href="ekle.php" class="admin-btn admin-btn-primary">
    <i class="fas fa-plus"></i>
    Yeni Video Ekle
  </a>
</div>

<div class="admin-card">
  <div class="admin-card-body p-0">

    <?php if (empty($videolar)): ?>

      <p class="text-muted p-4 mb-0">
        Henüz video eklenmemiş. İlk videoyu eklemek için yukarıdaki butonu kullanın.
      </p>

    <?php else: ?>

      <div class="admin-table-wrap">
        <table class="admin-table">

          <thead>
            <tr>
              <th>Önizleme</th>
              <th>Başlık</th>
              <th>Kategori</th>
              <th>Süre</th>
              <th>YouTube ID</th>
              <th>Haftanın Videosu</th>

              <!-- İşlemler başlığı ortalandı -->
              <th class="text-center align-middle">
                İşlemler
              </th>
            </tr>
          </thead>

          <tbody>

            <?php foreach ($videolar as $video): ?>

              <tr<?= !empty($video["vitrin"]) ? ' class="table-warning"' : "" ?>>

                <!-- Önizleme -->
                <td>
                  <img
                    src="https://img.youtube.com/vi/<?= htmlspecialchars(
                      $video["youtube_id"],
                      ENT_QUOTES,
                      "UTF-8"
                    ) ?>/hqdefault.jpg"
                    alt=""
                    class="admin-thumb"
                  />
                </td>

                <!-- Başlık -->
                <td>
                  <strong>
                    <?= htmlspecialchars(
                      $video["baslik"],
                      ENT_QUOTES,
                      "UTF-8"
                    ) ?>
                  </strong>

                  <?php if (!empty($video["vitrin"])): ?>

                    <span class="admin-badge admin-badge-etkinlikler ms-1">
                      <i class="fas fa-star me-1"></i>
                      Haftanın Videosu
                    </span>

                  <?php endif; ?>
                </td>

                <!-- Kategori -->
                <td>

                  <?php
                  $kategoriSlug = (string) ($video["kategori"] ?? "");
                  ?>

                  <span
                    class="admin-badge admin-badge-<?= htmlspecialchars(
                      $kategoriSlug !== "" ? $kategoriSlug : "genel",
                      ENT_QUOTES,
                      "UTF-8"
                    ) ?>"
                  >
                    <?= htmlspecialchars(
                      dbVideolarKategoriAdi(
                        $kategoriSlug !== "" ? $kategoriSlug : null
                      ),
                      ENT_QUOTES,
                      "UTF-8"
                    ) ?>
                  </span>

                </td>

                <!-- Süre -->
                <td>
                  <?= htmlspecialchars(
                    $video["sure"],
                    ENT_QUOTES,
                    "UTF-8"
                  ) ?>
                </td>

                <!-- YouTube ID -->
                <td>
                  <code>
                    <?= htmlspecialchars(
                      $video["youtube_id"],
                      ENT_QUOTES,
                      "UTF-8"
                    ) ?>
                  </code>
                </td>

                <!-- Haftanın Videosu -->
                <td>

                  <?php if (!empty($video["vitrin"])): ?>

                    <span class="text-success fw-semibold">
                      <i class="fas fa-check-circle me-1"></i>
                      Aktif
                    </span>

                  <?php else: ?>

                    <form
                      method="post"
                      action="vitrin.php"
                      class="d-inline"
                      onsubmit="return confirm('Bu videoyu haftanın videosu yapmak istiyor musunuz?');"
                    >

                      <input
                        type="hidden"
                        name="id"
                        value="<?= (int) $video["id"] ?>"
                      />

                      <input
                        type="hidden"
                        name="csrf"
                        value="<?= htmlspecialchars(
                          adminCsrfToken(),
                          ENT_QUOTES,
                          "UTF-8"
                        ) ?>"
                      />

                      <button
                        type="submit"
                        class="admin-btn admin-btn-primary admin-btn-sm"
                        title="Haftanın videosu yap"
                      >
                        <i class="fas fa-star"></i>
                        Seç
                      </button>

                    </form>

                  <?php endif; ?>

                </td>

                <!-- İşlemler -->
                <td class="text-center align-middle">

                  <div class="dropdown d-inline-block position-static">

                    <button
                      type="button"
                      class="admin-btn admin-btn-secondary admin-btn-sm dropdown-toggle"
                      data-bs-toggle="dropdown"
                      data-bs-boundary="viewport"
                      aria-expanded="false"
                    >
                      <i class="fas fa-gear"></i>
                      İşlem Yap
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end shadow-sm text-start">

                      <!-- Düzenle seçeneği -->
                      <li>
                        <a
                          class="dropdown-item d-flex align-items-center gap-2"
                          href="duzenle.php?id=<?= (int) $video["id"] ?>"
                        >
                          <i class="fas fa-pen"></i>
                          Düzenle
                        </a>
                      </li>

                      <li>
                        <hr class="dropdown-divider" />
                      </li>

                      <!-- Sil seçeneği -->
                      <li>

                        <form
                          method="post"
                          action="sil.php"
                          class="m-0"
                          onsubmit="return confirm('Bu videoyu silmek istediğinize emin misiniz?');"
                        >

                          <input
                            type="hidden"
                            name="id"
                            value="<?= (int) $video["id"] ?>"
                          />

                          <input
                            type="hidden"
                            name="csrf"
                            value="<?= htmlspecialchars(
                              adminCsrfToken(),
                              ENT_QUOTES,
                              "UTF-8"
                            ) ?>"
                          />

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