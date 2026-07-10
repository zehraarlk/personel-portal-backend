<?php
$pageTitle = $pageTitle ?? "Yönetim Paneli";
$flash = adminFlashGet();
?>
<!doctype html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, "UTF-8") ?> - Yönetim Paneli</title>
    <link rel="icon" type="image/png" href="<?= htmlspecialchars(
      $assetBase,
      ENT_QUOTES,
      "UTF-8",
    ) ?>images/favicon.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="<?= htmlspecialchars(
      $assetBase,
      ENT_QUOTES,
      "UTF-8",
    ) ?>CSS/admin.css" />
  </head>
  <body class="admin-body">
    <div class="admin-layout">
      <?php include __DIR__ . "/sidebar.php"; ?>
      <div class="admin-main">
        <header class="admin-topbar">
          <div class="d-flex align-items-center gap-3">
            <button type="button" class="admin-menu-toggle" id="adminMenuToggle" aria-label="Menü">
              <i class="fas fa-bars"></i>
            </button>
            <h2><?= htmlspecialchars($pageTitle, ENT_QUOTES, "UTF-8") ?></h2>
          </div>
          <div class="admin-user">
            <span><?= htmlspecialchars(
              $adminUser["ad"] . " " . $adminUser["soyad"],
              ENT_QUOTES,
              "UTF-8",
            ) ?></span>
            <span class="admin-user-badge"><?= htmlspecialchars(
              $adminUser["yetki"],
              ENT_QUOTES,
              "UTF-8",
            ) ?></span>
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
