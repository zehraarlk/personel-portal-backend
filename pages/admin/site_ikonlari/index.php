<?php
require_once __DIR__ . "/../includes/auth.php";

$currentPage = "ikonlar";
$pageTitle = "Site İkonları";

$kategoriFiltre = trim($_GET["kategori"] ?? "");
$arama = trim($_GET["q"] ?? "");

$sql = "SELECT * FROM site_ikonlari WHERE 1=1";
$params = [];

if ($kategoriFiltre !== "") {
  $sql .= " AND kategori = ?";
  $params[] = $kategoriFiltre;
}

if ($arama !== "") {
  $sql .= " AND (anahtar LIKE ? OR ad LIKE ? OR ikon_sinifi LIKE ?)";
  $like = "%" . $arama . "%";
  $params[] = $like;
  $params[] = $like;
  $params[] = $like;
}

$sql .= " ORDER BY sira ASC, id ASC";
$kayitlar = dbFetchAll($db, $sql, $params);

$kategoriler = dbFetchAll(
  $db,
  "SELECT kategori, COUNT(*) AS adet FROM site_ikonlari GROUP BY kategori ORDER BY kategori ASC",
);

include __DIR__ . "/../includes/header.php";
?>

<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
  <p class="text-muted mb-0">
    Toplam <strong><?= count($kayitlar) ?></strong> ikon
  </p>
  <a href="ekle.php" class="admin-btn admin-btn-primary">
    <i class="fas fa-plus"></i>
    Yeni İkon
  </a>
</div>

<form method="get" class="admin-form mb-3 d-flex flex-wrap gap-2 align-items-end">
  <div>
    <label class="form-label" for="ikonArama">Ara</label>
    <input
      type="search"
      id="ikonArama"
      name="q"
      class="form-control form-control-sm"
      value="<?= htmlspecialchars($arama, ENT_QUOTES, "UTF-8") ?>"
      placeholder="Anahtar, ad, sınıf..."
    />
  </div>
  <div>
    <label class="form-label" for="ikonKategori">Kategori</label>
    <select
      id="ikonKategori"
      name="kategori"
      class="form-select form-select-sm admin-filter-select"
      onchange="this.form.submit()"
    >
      <option value="">Tümü</option>
      <?php foreach ($kategoriler as $kat): ?>
        <?php $slug = (string) ($kat["kategori"] ?? ""); ?>
        <option
          value="<?= htmlspecialchars($slug, ENT_QUOTES, "UTF-8") ?>"
          <?= $kategoriFiltre === $slug ? "selected" : "" ?>
        >
          <?= htmlspecialchars($slug, ENT_QUOTES, "UTF-8") ?>
          (<?= (int) ($kat["adet"] ?? 0) ?>)
        </option>
      <?php endforeach; ?>
    </select>
  </div>
  <button type="submit" class="admin-btn admin-btn-secondary admin-btn-sm">
    <i class="fas fa-search"></i> Filtrele
  </button>
  <?php if ($arama !== "" || $kategoriFiltre !== ""): ?>
    <a href="index.php" class="admin-btn admin-btn-secondary admin-btn-sm">Temizle</a>
  <?php endif; ?>
</form>

<div class="admin-card">
  <div class="admin-card-body p-0">
    <?php if (empty($kayitlar)): ?>
      <p class="text-muted p-4 mb-0">Kayıt bulunamadı.</p>
    <?php else: ?>
      <div class="admin-table-wrap">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Önizleme</th>
              <th>Anahtar</th>
              <th>Ad</th>
              <th>Kategori</th>
              <th>Sınıf</th>
              <th>Sıra</th>
              <th>Durum</th>
              <th class="text-center align-middle">İşlemler</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($kayitlar as $row): ?>
              <?php
              $ikonSinifi = trim((string) ($row["ikon_sinifi"] ?? ""));
              $aktif = (int) ($row["aktif"] ?? 0) === 1;
              ?>
              <tr>
                <td>
                  <span class="admin-icon-preview" title="<?= htmlspecialchars(
                    $ikonSinifi,
                    ENT_QUOTES,
                    "UTF-8",
                  ) ?>">
                    <?php if ($ikonSinifi !== ""): ?>
                      <i class="<?= htmlspecialchars(
                        $ikonSinifi,
                        ENT_QUOTES,
                        "UTF-8",
                      ) ?>"></i>
                    <?php else: ?>
                      —
                    <?php endif; ?>
                  </span>
                </td>
                <td>
                  <code><?= htmlspecialchars(
                    (string) ($row["anahtar"] ?? ""),
                    ENT_QUOTES,
                    "UTF-8",
                  ) ?></code>
                </td>
                <td>
                  <strong><?= htmlspecialchars(
                    (string) ($row["ad"] ?? ""),
                    ENT_QUOTES,
                    "UTF-8",
                  ) ?></strong>
                </td>
                <td><?= htmlspecialchars(
                  (string) ($row["kategori"] ?? ""),
                  ENT_QUOTES,
                  "UTF-8",
                ) ?></td>
                <td>
                  <small><?= htmlspecialchars(
                    $ikonSinifi,
                    ENT_QUOTES,
                    "UTF-8",
                  ) ?></small>
                </td>
                <td><?= (int) ($row["sira"] ?? 0) ?></td>
                <td>
                  <span class="admin-badge <?= $aktif
                    ? "admin-badge-egitimler"
                    : "" ?>">
                    <?= $aktif ? "Aktif" : "Pasif" ?>
                  </span>
                </td>
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
                        <a
                          class="dropdown-item d-flex align-items-center gap-2"
                          href="duzenle.php?id=<?= (int) $row["id"] ?>"
                        >
                          <i class="fas fa-pen"></i>
                          Düzenle
                        </a>
                      </li>
                      <li><hr class="dropdown-divider" /></li>
                      <li>
                        <form
                          method="post"
                          action="sil.php"
                          class="m-0"
                          onsubmit="return confirm('Bu ikonu silmek istediğinize emin misiniz?');"
                        >
                          <input type="hidden" name="id" value="<?= (int) $row[
                            "id"
                          ] ?>" />
                          <input
                            type="hidden"
                            name="csrf"
                            value="<?= htmlspecialchars(
                              adminCsrfToken(),
                              ENT_QUOTES,
                              "UTF-8",
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
