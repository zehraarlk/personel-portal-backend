<?php
if (!isset($db) || !($db instanceof PDO)) {
  require_once __DIR__ . "/../baglan.php";
}
?>
    <footer>
      <div class="container">
        <div class="footer-content">
          <img src="../images/logo(2).webp" class="footer-logo" alt="Gebze Belediyesi" />

          <div class="footer-contact">
            <p><i class="<?= portalSiteIconClass($db, "telefon", "fas fa-phone") ?>"></i> (0262) 123 45 67</p>
            <p><i class="<?= portalSiteIconClass($db, "eposta", "fas fa-envelope") ?>"></i> bilgiislem@gebze.bel.tr</p>
          </div>
          <div class="social-icons">
            <a href="https://www.facebook.com/gebzebelediye/?locale=tr_TR" aria-label="Facebook"><i class="<?= portalSiteIconClass($db, "facebook", "fab fa-facebook-f") ?>"></i></a>
            <a href="https://x.com/gebze_belediye" aria-label="Twitter"><i class="<?= portalSiteIconClass($db, "twitter", "fab fa-twitter") ?>"></i></a>
            <a href="https://www.instagram.com/gebze_belediyesi/?hl=tr" aria-label="Instagram"><i class="<?= portalSiteIconClass($db, "instagram", "fab fa-instagram") ?>"></i></a>
            <a href="https://www.youtube.com/@gebzebelediyesi7295" aria-label="YouTube"><i class="<?= portalSiteIconClass($db, "youtube", "fab fa-youtube") ?>"></i></a>
            <a href="https://www.linkedin.com/company/gebze-belediyesi/posts/?feedView=all" aria-label="LinkedIn"><i class="<?= portalSiteIconClass($db, "linkedin", "fab fa-linkedin-in") ?>"></i></a>
          </div>
        </div>
        <div class="footer-bottom">
          <p>&copy; 2025 Gebze Belediyesi - Bilgi İşlem Müdürlüğü | Tüm Hakları Saklıdır</p>
        </div>
      </div>
    </footer>
