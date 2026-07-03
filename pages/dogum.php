<?php
include("baglan.php");
$personelKayitlari = mapPersonelJs(dbFetchAll($db, "SELECT * FROM personeller ORDER BY ad"));
?>
<!doctype html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Doğum Günü Bilgisi - Gebze Belediyesi Personel Portalı</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
<?php $pageCss = "dogum.style.css"; include "includes/site-styles.php"; ?>
  </head>
  <body>
    <?php include "includes/header-nav.php"; ?>
    <?php $pageTitle = "Doğum Günü"; include "includes/breadcrumb.php"; ?>
    <div class="content-area">
      <div class="container-fluid px-4 py-4">
        <div class="page-header-container">
          <div class="header-icon-wrapper">
            <i class="fa-solid fa-cake-candles"></i>
          </div>
          <div class="header-text-wrapper">
            <h2 class="header-title-main">Bugün Doğum Günü Olan Personeller</h2>
            <p class="header-subtitle">19 Ağustos 2025</p>
          </div>
        </div>
        <div id="personelListesi" class="row g-4"></div>

        <div id="bosMesaj" class="alert alert-secondary text-center mt-4 d-none">
          Bugün doğum günü olan personel bulunmamaktadır.
        </div>
      </div>
    </div>
    <?php include "includes/footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    const personellerFromDb = <?php echo json_encode($personelKayitlari, JSON_UNESCAPED_UNICODE); ?>;
  </script>
    <script src="../JS/dogum.script.js"></script>
      <script src="../JS/navbar.js"></script>
  </body>
</html>
