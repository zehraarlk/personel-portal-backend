<?php
declare(strict_types=1);

if (empty($showBreadcrumb) || empty($pageTitle)) {
    return;
}
?>
<nav class="breadcrumb-section" aria-label="Sayfa konumu">
    <div class="site-container breadcrumb-container">
        <ol class="breadcrumb-list">
            <li class="breadcrumb-item">
                <a href="<?= e($assetBase) ?>pages/ana_sayfa.php">
                    <span class="icon" aria-hidden="true"><?= icon('home') ?></span>
                    Ana Sayfa
                </a>
            </li>
            <li class="breadcrumb-item is-active" aria-current="page">
                <?= e($pageTitle) ?>
            </li>
        </ol>
    </div>
</nav>
