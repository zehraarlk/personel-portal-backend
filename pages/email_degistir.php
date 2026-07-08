<?php
session_start();
include("baglan.php");

if (!isset($_SESSION['personel_id'])) {
    header("Location: login.php");
    exit;
}

$personel_id = $_SESSION['personel_id'];
$mesaj = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email_guncelle'])) {
    $yeni_email = trim($_POST['email']);
    if (!empty($yeni_email)) {
        $guncelle = $db->prepare("UPDATE personeller SET email = ? WHERE id = ?");
        if ($guncelle->execute([$yeni_email, $personel_id])) {
            $_SESSION['email'] = $yeni_email;
            $_SESSION['profil_mesaj'] = "<div class='alert alert-success mb-4'>E-posta adresiniz başarıyla güncellendi!</div>";
            header("Location: email_degistir.php");
            exit;
        } else {
            $mesaj = "<div class='alert alert-danger mb-4'>Güncelleme sırasında bir hata oluştu.</div>";
        }
    } else {
        $mesaj = "<div class='alert alert-danger mb-4'>Lütfen geçerli bir e-posta adresi girin.</div>";
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
    <title>Email Değiştir - Gebze Belediyesi Personel Portalı</title>
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
      }
      .profil-card .card-header i { color: #ffa500; margin-right: 8px; }
      .btn-navy {
        background-color: #022842;
        color: #fff;
        font-weight: 600;
        border: none;
      }
      .btn-navy:hover { background-color: #033a5e; color: #fff; }
    </style>
  </head>
  <body>
    <?php include "includes/header-nav.php"; ?>
    <?php $pageTitle = "Email Değiştir"; include "includes/breadcrumb.php"; ?>

    <div class="content-area">
      <div class="container py-4" style="max-width: 650px;">
        <?php echo $mesaj; ?>

        <div class="card profil-card">
          <div class="card-header">
            <i class="fas fa-envelope"></i>Email Değiştir
          </div>
          <div class="card-body p-4">
            <form action="email_degistir.php" method="POST">
              <div class="mb-3">
                <label class="form-label text-muted small">E-posta Adresiniz</label>
                <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($_SESSION['email'] ?? ''); ?>" required>
              </div>
              <button type="submit" name="email_guncelle" class="btn btn-navy w-100">
                <i class="fas fa-save me-1"></i> Email Kaydet
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