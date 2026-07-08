<?php
/**
 * Ortak site stilleri – eski yükleme sırası: sayfa CSS → footer → navbar
 * Kullanım: $pageCss = "videolar.style.css"; include "includes/site-styles.php";
 */
$pageCss = $pageCss ?? "";
?>
<?php if ($pageCss !== ""): ?>
    <link rel="stylesheet" href="../CSS/<?= htmlspecialchars(basename($pageCss), ENT_QUOTES, "UTF-8") ?>" />
<?php endif; ?>
    <link rel="stylesheet" href="../CSS/navbar.css" />
    <link rel="stylesheet" href="../CSS/footer.css" />
