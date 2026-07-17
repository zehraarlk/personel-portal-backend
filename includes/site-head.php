<?php
/**
 * Dosya sorumluluğu: Ortak HTML head ve body başlangıcı.
 *
 * Girdi doğrulama, yetkilendirme ve çıktı kaçışları bu dosyanın
 * mevcut güvenlik akışına uygun biçimde korunmalıdır.
 */
/**
 * Ortak HTML <head> ve <body> açılışı.
 *
 * Beklenen değişkenler (init / sayfa tarafından set edilir):
 * - $assetBase, $pageTitle, $pageCss (opsiyonel)
 * - $showBreadcrumb, $useDetailLayout, $documentTitle (opsiyonel)
 * - $portalSessionGuard, $portalOturumKapatUrl (personel oturum koruması)
 */
declare(strict_types=1);

$pageTitle = $pageTitle ?? 'Ana Sayfa';
$pageCss = $pageCss ?? '';
$showBreadcrumb = $showBreadcrumb ?? false;
?>
<!DOCTYPE html>
<html lang="tr" data-photo-fit="<?= e(getContentPhotoFit()) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e(($documentTitle ?? $pageTitle) !== '' ? ($documentTitle ?? $pageTitle) . ' — ' : '') ?><?= e(SITE_NAME) ?></title>
    <link rel="icon" href="<?= e(faviconUrl($assetBase)) ?>" type="image/webp">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="<?= e($assetBase) ?>assets/css/variables.css">
    <?php if ($pageCss !== ''): ?>
    <link rel="stylesheet" href="<?= e($assetBase) ?>assets/css/<?= e($pageCss) ?>">
    <?php endif; ?>
    <?php if (!empty($useDetailLayout)): ?>
    <link rel="stylesheet" href="<?= e($assetBase) ?>assets/css/detay_shared.css">
    <?php endif; ?>
    <link rel="stylesheet" href="<?= e($assetBase) ?>assets/css/navbar.css">
    <?php if (!empty($showBreadcrumb)): ?>
    <link rel="stylesheet" href="<?= e($assetBase) ?>assets/css/breadcrumb.css">
    <?php endif; ?>
    <link rel="stylesheet" href="<?= e($assetBase) ?>assets/css/footer.css">
    <link rel="stylesheet" href="<?= e($assetBase) ?>assets/css/responsive.css">
</head>
<body<?= !empty($useDetailLayout) ? ' class="detail-page"' : '' ?><?= !empty($portalSessionGuard) ? ' data-portal-session="1" data-oturum-kapat="' . e($portalOturumKapatUrl) . '"' : '' ?>>
<?php if (!empty($portalSessionGuard)): ?>
<script src="<?= e($assetBase) ?>assets/js/session-guard.js"></script>
<?php endif; ?>
