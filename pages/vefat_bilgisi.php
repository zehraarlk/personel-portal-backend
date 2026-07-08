<?php
include("baglan.php");
$vefatKayitlari = dbFetchAll($db, "SELECT * FROM vefat_bilgileri ORDER BY vefat_tarihi DESC");
?>
<!doctype html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Vefat Eden Bilgisi - Gebze Belediyesi Personel Portalı</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
<?php $pageCss = "vefat_bilgisi.style.css"; include "includes/site-styles.php"; ?>
  </head>
  <body>
    <?php include "includes/header-nav.php"; ?>
    <?php $pageTitle = "Vefat Bilgisi"; include "includes/breadcrumb.php"; ?>
<!-- Breadcrumb Section - Logo ile aynı hizaya getirildi --><div class="main-content container py-5">
      <div class="container">
        <!-- Sayfa Başlığı -->
        <div class="page-header">
          <div class="header-content">
            <i class="fas fa-ribbon header-icon"></i>
            <h1>VEFAT EDEN BİLGİSİ</h1>
          </div>
        </div>

        <!-- Vefat Kartları Grid -->
        <div class="vefat-grid" id="vefatGrid">
          <!-- Kartlar JavaScript ile doldurulacak -->
        </div>

        <!-- Sayfalama -->
        <div class="pagination-container">
          <nav aria-label="Vefat bilgileri sayfalama">
            <ul class="pagination">
              <li class="page-item disabled" id="prevPageItem">
                <a class="page-link" href="#" aria-label="Önceki" id="prevPage">
                  <i class="fas fa-chevron-left"></i>
                  Önceki
                </a>
              </li>
              <li class="page-item active">
                <a class="page-link" href="#" data-page="1">1</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="#" data-page="2">2</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="#" data-page="3">3</a>
              </li>
              <li class="page-item" id="nextPageItem">
                <a class="page-link" href="#" aria-label="Sonraki" id="nextPage">
                  Sonraki
                  <i class="fas fa-chevron-right"></i>
                </a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
    <?php include "includes/footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    window.vefatData = <?php echo jsonData(mapVefat($vefatKayitlari)); ?>;
  </script>
    <script src="../JS/vefat_bilgisi.script.js"></script>
      <script src="../JS/navbar.js"></script>
  </body>
</html>
