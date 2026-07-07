<?php
session_start();
include("baglan.php");

if (!isset($_SESSION['personel_id'])) {
    header("Location: login.php");
    exit;
}

$personel_id = $_SESSION['personel_id'];

$oturumlar = dbFetchAll($db, "SELECT giris_zamani, cikis_zamani FROM oturum_kayitlari WHERE personel_id = ? ORDER BY id DESC LIMIT 10", [$personel_id]);
?>
<!doctype html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Oturum Bilgileri - Gebze Belediyesi Personel Portalı</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <?php include "includes/site-styles.php"; ?>
    <style>
      html, body { overflow-x: hidden; max-width: 100%; }
      .content-area { min-height: 60vh; }
      .profil-card {
        border: none;
        border-radius: 14px;
        box-shadow: 0 4px 18px rgba(2, 40, 66, 0.08);
      }
      .profil-card .card-header {
        background-color: #022842;
        color: #fff;
        border-radius: 14px 14px 0 0 !important;
        padding: 1.1rem 1.5rem;
        font-weight: 600;
        flex-wrap: wrap;
        gap: 0.5rem;
      }
      .profil-card .card-header i { color: #ffa500; margin-right: 8px; }
      .badge-acik { background-color: #fff3cd; color: #997404; font-weight: 600; }
      .btn-cikis {
        background-color: #d93025;
        color: #fff;
        font-weight: 600;
        border: none;
        white-space: nowrap;
      }
      .btn-cikis:hover { background-color: #b8261c; color: #fff; }
      .table-responsive { overflow-x: auto; -webkit-overflow-scrolling: touch; }
      @media (max-width: 576px) {
        .container { padding-left: 1rem; padding-right: 1rem; }
        .profil-card .card-header { padding: 1rem; }
      }
    </style>
  </head>
  <body>
    <?php include "includes/header-nav.php"; ?>
    <?php $pageTitle = "Oturum Bilgileri"; include "includes/breadcrumb.php"; ?>

    <div class="content-area">
      <div class="container py-4" style="max-width: 950px;">
        <div class="card profil-card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-history"></i>Oturum Bilgileri</span>
            <a href="cikis.php" class="btn btn-cikis btn-sm" onclick="return confirm('Çıkış yapmak istediğinizden emin misiniz?');">
              <i class="fas fa-sign-out-alt me-1"></i>Çıkış Yap
            </a>
          </div>
          <div class="card-body p-4">
            <p class="text-muted small">Sisteme yaptığınız son 10 başarılı giriş ve çıkış kaydı:</p>
            <div class="table-responsive">
              <table class="table table-hover align-middle">
                <thead class="table-light">
                  <tr>
                    <th>Giriş Tarihi / Saati</th>
                    <th>Çıkış Tarihi / Saati</th>
                    <th>Durum</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($oturumlar)): ?>
                    <?php foreach ($oturumlar as $oturum): ?>
                      <tr>
                        <td><i class="far fa-clock text-success me-2"></i><?php echo date('d.m.Y H:i:s', strtotime($oturum['giris_zamani'])); ?></td>
                        <td>
                          <?php
                            echo !empty($oturum['cikis_zamani'])
                                ? "<i class='far fa-clock text-danger me-2'></i>" . date('d.m.Y H:i:s', strtotime($oturum['cikis_zamani']))
                                : "<span class='badge badge-acik'>Aktif Seans</span>";
                          ?>
                        </td>
                        <td><?php echo !empty($oturum['cikis_zamani']) ? '🟢 Kapatıldı' : '🔵 Açık'; ?></td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr><td colspan="3" class="text-center text-muted py-3">Kayıtlı oturum geçmişi bulunamadı.</td></tr>
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