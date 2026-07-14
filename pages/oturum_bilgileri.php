<?php
include "baglan.php";

$yoneticiModu = adminIsLoggedIn();
$personelModu = !$yoneticiModu && !empty($_SESSION["personel_id"]);

if (!$yoneticiModu && !$personelModu) {
  header("Location: login.php");
  exit();
}

if ($yoneticiModu) {
  yoneticiOturumTouch($db, (int) ($_SESSION["yonetici_oturum_id"] ?? 0));
  $aktifOturumId = (int) ($_SESSION["yonetici_oturum_id"] ?? 0);
  $oturumlar = dbFetchAll(
    $db,
    "SELECT id, giris_zamani, cikis_zamani, kapanis_tipi, ip_adresi, son_aktivite, user_agent
       FROM yonetici_oturum_kayitlari
       WHERE yonetici_id = ?
       ORDER BY id DESC
       LIMIT 15",
    [(int) $_SESSION["yonetici_id"]],
  );
  $cikisUrl = "admin/cikis.php";
  $aciklama = "Son 15 yönetici oturum kaydı. Site/sekme kapatıldığında oturum otomatik kapanır.";
} else {
  $aktifOturumId = isset($_SESSION["oturum_id"]) ? (int) $_SESSION["oturum_id"] : 0;
  $oturumlar = dbFetchAll(
    $db,
    "SELECT id, giris_zamani, cikis_zamani, kapanis_tipi, ip_adresi, son_aktivite
       FROM oturum_kayitlari
       WHERE personel_id = ?
       ORDER BY id DESC
       LIMIT 15",
    [(int) $_SESSION["personel_id"]],
  );
  $cikisUrl = "cikis.php";
  $aciklama = "Son 15 giriş kaydı. Site/sekme kapatıldığında oturum otomatik kapanır.";
}
?>
<!doctype html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Oturum Bilgileri - Gebze Belediyesi Personel Portalı</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<?php
$pageCss = "profil.style.css";
include "includes/site-styles.php";
?>
  </head>
  <body>
    <?php include "includes/header-nav.php"; ?>
    <?php
    $pageTitle = "Oturum Bilgileri";
    include "includes/breadcrumb.php";
    ?>

    <div class="content-area">
      <div class="container profil-form-wide">
        <div class="card profil-card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="<?= portalSiteIconClass($db, "oturum_bilgileri", "fas fa-history") ?>"></i>Oturum Bilgileri<?= $yoneticiModu
              ? " (Yönetici)"
              : "" ?></span>
            <a href="<?= htmlspecialchars($cikisUrl, ENT_QUOTES, "UTF-8") ?>" class="btn btn-cikis btn-sm" onclick="return confirm('Çıkış yapmak istediğinizden emin misiniz?');">
              <i class="<?= portalSiteIconClass($db, "cikis_yap", "fas fa-sign-out-alt") ?> me-1"></i>Çıkış Yap
            </a>
          </div>
          <div class="card-body p-4">
            <p class="text-muted small mb-3"><?= htmlspecialchars($aciklama, ENT_QUOTES, "UTF-8") ?></p>
            <div class="table-responsive">
              <table class="table table-hover align-middle">
                <thead class="table-light">
                  <tr>
                    <th>Giriş</th>
                    <th>Çıkış</th>
                    <th>Kapanış</th>
                    <?php if ($yoneticiModu): ?><th>IP</th><?php endif; ?>
                    <th>Durum</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($oturumlar)): ?>
                    <?php foreach ($oturumlar as $oturum):
                      [$durum, $badgeClass, $tipText] = portalOturumDurumEtiket(
                        $oturum["cikis_zamani"] ?? null,
                        $oturum["kapanis_tipi"] ?? null,
                        (int) $oturum["id"],
                        $aktifOturumId,
                      ); ?>
                      <tr>
                        <td>
                          <i class="<?= portalSiteIconClass($db, "oturum_saati", "far fa-clock") ?> text-success me-2"></i>
                          <?= htmlspecialchars(
                            date("d.m.Y H:i:s", strtotime($oturum["giris_zamani"])),
                            ENT_QUOTES,
                            "UTF-8",
                          ) ?>
                        </td>
                        <td>
                          <?php if (!empty($oturum["cikis_zamani"])): ?>
                            <i class="<?= portalSiteIconClass($db, "oturum_saati", "far fa-clock") ?> text-danger me-2"></i>
                            <?= htmlspecialchars(
                              date("d.m.Y H:i:s", strtotime($oturum["cikis_zamani"])),
                              ENT_QUOTES,
                              "UTF-8",
                            ) ?>
                          <?php else: ?>
                            <span class="badge <?= htmlspecialchars(
                              $badgeClass,
                              ENT_QUOTES,
                              "UTF-8",
                            ) ?>"><?= htmlspecialchars($tipText, ENT_QUOTES, "UTF-8") ?></span>
                          <?php endif; ?>
                        </td>
                        <td class="small text-muted"><?= htmlspecialchars(
                          $tipText,
                          ENT_QUOTES,
                          "UTF-8",
                        ) ?></td>
                        <?php if ($yoneticiModu): ?>
                          <td class="small text-muted"><?= htmlspecialchars(
                            $oturum["ip_adresi"] ?? "-",
                            ENT_QUOTES,
                            "UTF-8",
                          ) ?></td>
                        <?php endif; ?>
                        <td><?= htmlspecialchars($durum, ENT_QUOTES, "UTF-8") ?></td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="<?= $yoneticiModu ? 5 : 4 ?>" class="text-center text-muted py-3">
                        Kayıtlı oturum geçmişi bulunamadı.
                      </td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php include "includes/footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../JS/navbar.js"></script>
  </body>
</html>
