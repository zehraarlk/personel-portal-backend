<?php
$currentPage = $currentPage ?? "";
$menuItems = [
  [
    "id" => "dashboard",
    "label" => "Dashboard",
    "icon" => "fa-gauge-high",
    "href" => $adminBase . "index.php",
  ],
  [
    "id" => "personeller",
    "label" => "Personeller",
    "icon" => "fa-users",
    "href" => $adminBase . "personeller/index.php",
  ],
  [
    "id" => "yoneticiler",
    "label" => "Yöneticiler",
    "icon" => "fa-user-shield",
    "href" => $adminBase . "yoneticiler/index.php",
  ],
  [
    "id" => "videolar",
    "label" => "Videolar",
    "icon" => "fa-video",
    "href" => $adminBase . "videolar/index.php",
  ],
  [
    "id" => "duyurular",
    "label" => "Duyurular",
    "icon" => "fa-bullhorn",
    "href" => $adminBase . "duyurular/index.php",
  ],
  [
    "id" => "etkinlikler",
    "label" => "Etkinlikler",
    "icon" => "fa-calendar-days",
    "href" => $adminBase . "etkinlikler/index.php",
  ],
  [
    "id" => "sizden",
    "label" => "Sizden Gelenler",
    "icon" => "fa-comments",
    "href" => $adminBase . "sizden_gelenler/index.php",
  ],
  [
    "id" => "anketler",
    "label" => "Anketler",
    "icon" => "fa-poll",
    "href" => $adminBase . "anketler/index.php",
  ],
  [
    "id" => "linkler",
    "label" => "Yardımcı Linkler",
    "icon" => "fa-link",
    "href" => $adminBase . "yardimci_linkler/index.php",
  ],
  [
    "id" => "vefat",
    "label" => "Vefat Bilgileri",
    "icon" => "fa-ribbon",
    "href" => $adminBase . "vefat_bilgileri/index.php",
  ],
  [
    "id" => "kaynaklar",
    "label" => "Kaynaklar",
    "icon" => "fa-folder-open",
    "href" => $adminBase . "kaynaklar/index.php",
  ],
];
?>
<aside class="admin-sidebar" id="adminSidebar">
  <button type="button" class="admin-sidebar-close" id="adminSidebarClose" aria-label="Menüyü kapat">
    <i class="fas fa-times"></i>
  </button>
  <a href="<?= htmlspecialchars($adminBase . "index.php", ENT_QUOTES, "UTF-8") ?>" class="admin-brand-link">
  <div class="admin-brand">
    <img src="<?= htmlspecialchars(
      adminImgUrl($assetBase, "images/logo(2).png"),
      ENT_QUOTES,
      "UTF-8",
    ) ?>" alt="Gebze Belediyesi" />
    <h1>Gebze Belediyesi</h1>
    <p>Personel Portalı · Yönetim Paneli</p>
  </div>
  </a>

  <nav class="admin-nav">
    <div class="admin-nav-section">Yönetim</div>
    <?php foreach (array_slice($menuItems, 0, 3) as $item): ?>
      <a
        href="<?= htmlspecialchars($item["href"], ENT_QUOTES, "UTF-8") ?>"
        class="<?= htmlspecialchars(
          ($currentPage === $item["id"] ? "active" : "") .
            (!empty($item["disabled"]) ? " disabled" : ""),
          ENT_QUOTES,
          "UTF-8"
        ) ?>"
      >
        <i class="fas <?= htmlspecialchars($item["icon"], ENT_QUOTES, "UTF-8") ?>"></i>
        <?= htmlspecialchars($item["label"], ENT_QUOTES, "UTF-8") ?>
      </a>
    <?php endforeach; ?>
    <div class="admin-nav-section">İçerik Yönetimi</div>
    <?php foreach (array_slice($menuItems, 3) as $item): ?>
      <a
        href="<?= htmlspecialchars($item["href"], ENT_QUOTES, "UTF-8") ?>"
        class="<?= htmlspecialchars(
          ($currentPage === $item["id"] ? "active" : "") .
            (!empty($item["disabled"]) ? " disabled" : ""),
          ENT_QUOTES,
          "UTF-8"
        ) ?>"
      >
        <i class="fas <?= htmlspecialchars($item["icon"], ENT_QUOTES, "UTF-8") ?>"></i>
        <?= htmlspecialchars($item["label"], ENT_QUOTES, "UTF-8") ?>
      </a>
    <?php endforeach; ?>
  </nav>

  <div class="admin-sidebar-footer">
    <a href="<?= htmlspecialchars(
      $siteBase,
      ENT_QUOTES,
      "UTF-8",
    ) ?>ana_sayfa.php" target="_blank"><i class="fas fa-external-link-alt"></i> Siteyi Görüntüle</a>
    <a href="<?= htmlspecialchars(
      $adminBase,
      ENT_QUOTES,
      "UTF-8",
    ) ?>cikis.php"><i class="fas fa-sign-out-alt"></i> Çıkış Yap</a>
  </div>
</aside>
