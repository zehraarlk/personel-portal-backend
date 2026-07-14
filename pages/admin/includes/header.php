<?php
$pageTitle = $pageTitle ?? "Yönetim Paneli";
$flash = adminFlashGet();
?>
<!doctype html>
<<<<<<< HEAD
<html
  lang="tr"
  data-photo-fit="<?= htmlspecialchars(getContentPhotoFit(), ENT_QUOTES, "UTF-8") ?>"
  data-photo-fit-save="<?= htmlspecialchars($adminBase . "photo_fit_kaydet.php", ENT_QUOTES, "UTF-8") ?>"
  data-photo-fit-csrf="<?= htmlspecialchars(adminCsrfToken(), ENT_QUOTES, "UTF-8") ?>"
>
=======
<html lang="tr">
>>>>>>> da0ab1ce9c2e683fa29c9cbbff849780f358e71f
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, "UTF-8") ?> - Yönetim Paneli</title>
    <link rel="icon" type="image/png" href="<?= htmlspecialchars(
      $assetBase,
      ENT_QUOTES,
      "UTF-8",
<<<<<<< HEAD
    ) ?>images/favicon.webp" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
=======
    ) ?>images/favicon.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
>>>>>>> da0ab1ce9c2e683fa29c9cbbff849780f358e71f
    <link rel="stylesheet" href="<?= htmlspecialchars(
      $assetBase,
      ENT_QUOTES,
      "UTF-8",
<<<<<<< HEAD
    ) ?>assets/css/admin.css?v=<?= (int) @filemtime(
      __DIR__ . "/../../../assets/css/admin.css",
=======
    ) ?>CSS/admin.css?v=<?= (int) @filemtime(
      __DIR__ . "/../../../CSS/admin.css",
>>>>>>> da0ab1ce9c2e683fa29c9cbbff849780f358e71f
    ) ?>" />
  </head>
  <body class="admin-body">
    <div class="admin-layout">
      <?php include __DIR__ . "/sidebar.php"; ?>
      <div class="admin-sidebar-backdrop" id="adminSidebarBackdrop" aria-hidden="true"></div>
      <div class="admin-main">
        <header class="admin-topbar">
          <div class="d-flex align-items-center gap-3">
            <button
              type="button"
              class="admin-menu-toggle"
              id="adminMenuToggle"
              aria-label="Menü"
              aria-expanded="false"
              aria-controls="adminSidebar"
            >
              <i class="fas fa-bars"></i>
            </button>
            <h2><?= htmlspecialchars($pageTitle, ENT_QUOTES, "UTF-8") ?></h2>
          </div>
<<<<<<< HEAD
          <div class="admin-topbar-end">
            <div class="admin-photo-fit" role="group" aria-label="Fotoğraf görünümü">
              <button type="button" class="admin-photo-fit-btn" data-photo-fit-set="contain" aria-pressed="false">Tam ekran</button>
              <button type="button" class="admin-photo-fit-btn" data-photo-fit-set="cover" aria-pressed="false">Doldur</button>
            </div>
            <div class="admin-user">
              <span><?= htmlspecialchars(
                $adminUser["gorunen_ad"] !== "" ? $adminUser["gorunen_ad"] : "Yönetici",
                ENT_QUOTES,
                "UTF-8",
              ) ?></span>
              <span class="admin-user-badge"><?= htmlspecialchars(
                $adminUser["rol_etiket"],
                ENT_QUOTES,
                "UTF-8",
              ) ?></span>
            </div>
=======
          <div class="admin-user">
            <span><?= htmlspecialchars(
              $adminUser["gorunen_ad"] !== "" ? $adminUser["gorunen_ad"] : "Yönetici",
              ENT_QUOTES,
              "UTF-8",
            ) ?></span>
            <span class="admin-user-badge"><?= htmlspecialchars(
              $adminUser["rol_etiket"],
              ENT_QUOTES,
              "UTF-8",
            ) ?></span>
>>>>>>> da0ab1ce9c2e683fa29c9cbbff849780f358e71f
          </div>
        </header>
        <main class="admin-content">
          <?php if ($flash): ?>
            <div class="admin-alert admin-alert-<?= htmlspecialchars(
              $flash["type"],
              ENT_QUOTES,
              "UTF-8",
            ) ?>">
              <?= htmlspecialchars($flash["message"], ENT_QUOTES, "UTF-8") ?>
            </div>
          <?php endif; ?>
