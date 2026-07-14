<?php
/**
 * Ortak site stilleri – eski yükleme sırası: sayfa CSS → footer → navbar
 * Kullanım: $pageCss = "videolar.style.css"; include "includes/site-styles.php";
 * Detay sayfaları: $useDetailLayout = true; (layout çakışmalarını ortak dosya çözer)
 */
$pageCss = $pageCss ?? "";
$useDetailLayout = !empty($useDetailLayout);
?>
    <link rel="icon" type="image/png" href="../images/favicon.webp" />
    <link rel="shortcut icon" type="image/png" href="../images/favicon.webp" />
    <link rel="apple-touch-icon" href="../images/favicon.webp" />
<?php if ($pageCss !== ""): ?>
    <link rel="stylesheet" href="../CSS/<?= htmlspecialchars(
      basename($pageCss),
      ENT_QUOTES,
      "UTF-8",
    ) ?>" />
<?php endif; ?>
    <link rel="stylesheet" href="../CSS/navbar.css" />
    <link rel="stylesheet" href="../CSS/footer.css" />
<?php if ($useDetailLayout): ?>
    <link rel="stylesheet" href="../CSS/detail_shared.css" />
<?php endif; ?>
