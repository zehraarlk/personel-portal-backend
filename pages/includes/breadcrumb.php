<?php
/** @var string $pageTitle Sayfa başlığı – boşsa breadcrumb gösterilmez */
if (empty($pageTitle)) {
    return;
}
?>
    <div class="breadcrumb-section">
      <div class="nav-container">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="ana_sayfa.php"><i class="fas fa-home"></i> Anasayfa</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
              <?= htmlspecialchars($pageTitle, ENT_QUOTES, "UTF-8") ?>
            </li>
          </ol>
        </nav>
      </div>
    </div>
