<?php
include("baglan.php");

if (!isset($_SESSION['personel_id'])) {
    header("Location: login.php");
    exit;
}

$personel_id = $_SESSION['personel_id'];
$mesaj = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['sifre_guncelle'])) {
    $eski_sifre = md5(trim($_POST['eski_sifre']));
    $yeni_sifre_ham = trim($_POST['yeni_sifre']);
    $yeni_sifre = md5($yeni_sifre_ham);

    $kontrol = $db->prepare("SELECT id FROM personeller WHERE id = ? AND sifre = ?");
    $kontrol->execute([$personel_id, $eski_sifre]);

    if (empty($yeni_sifre_ham)) {
        $mesaj = "<div class='alert alert-danger mb-4'>Yeni şifre boş bırakılamaz.</div>";
    } elseif ($kontrol->rowCount() > 0) {
        $guncelle = $db->prepare("UPDATE personeller SET sifre = ? WHERE id = ?");
        if ($guncelle->execute([$yeni_sifre, $personel_id])) {
            $_SESSION['profil_mesaj'] = "<div class='alert alert-success mb-4'>Şifreniz başarıyla değiştirildi!</div>";
            header("Location: sifre_degistir.php");
            exit;
        } else {
            $mesaj = "<div class='alert alert-danger mb-4'>Güncelleme sırasında bir hata oluştu.</div>";
        }
    } else {
        $mesaj = "<div class='alert alert-danger mb-4'>Mevcut şifreniz hatalı!</div>";
    }
}

if (isset($_SESSION['profil_mesaj'])) {
    $mesaj = $_SESSION['profil_mesaj'];
    unset($_SESSION['profil_mesaj']);
}
?>
<!doctype html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Şifre Değiştir - Gebze Belediyesi Personel Portalı</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<?php $pageCss = "profil.style.css"; include "includes/site-styles.php"; ?>
  </head>
  <body>
    <?php include "includes/header-nav.php"; ?>
    <?php $pageTitle = "Şifre Değiştir"; include "includes/breadcrumb.php"; ?>

    <div class="content-area">
      <div class="container profil-form-narrow">
        <?php echo $mesaj; ?>

        <div class="card profil-card">
          <div class="card-header">
            <i class="fas fa-key"></i>Şifre Değiştir
          </div>
          <div class="card-body p-4">
            <form action="sifre_degistir.php" method="POST">
              <div class="mb-3">
                <label class="form-label text-muted small">Mevcut Şifre</label>
                <input type="password" name="eski_sifre" class="form-control" placeholder="Mevcut Şifre" required>
              </div>
              <div class="mb-4">
                <label class="form-label text-muted small">Yeni Şifre</label>
                <input type="password" name="yeni_sifre" class="form-control" placeholder="Yeni Şifre" required>
              </div>
              <button type="submit" name="sifre_guncelle" class="btn btn-navy w-100">
                <i class="fas fa-save me-1"></i> Şifreyi Güncelle
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <?php include "includes/footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../JS/navbar.js"></script>
  </body>
</html>