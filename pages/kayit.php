<?php
session_start();
include("baglan.php");

// Zaten girişliyse veya cookie ile otomatik giriş olabiliyorsa anasayfaya git
if (!empty($_SESSION["personel_id"]) || authTryAutoLogin($db)) {
    header("Location: ana_sayfa.php");
    exit;
}

$mesaj = "";
$status = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sicil_no     = trim($_POST['sicil_no']);
    $ad           = trim($_POST['ad']);
    $soyad        = trim($_POST['soyad']);
    $email        = trim($_POST['email']);
    $sifre        = trim($_POST['sifre']);
    $dogum_tarihi = trim($_POST['dogum_tarihi']);

    if (!empty($sicil_no) && !empty($ad) && !empty($soyad) && !empty($email) && !empty($sifre) && !empty($dogum_tarihi)) {
        
        // Sicil numarası veya email daha önce alınmış mı kontrolü
        $kontrol = $db->prepare("SELECT id FROM personeller WHERE sicil_no = ? OR email = ?");
        $kontrol->execute([$sicil_no, $email]);
        
        if ($kontrol->rowCount() > 0) {
            $status = "error";
            $mesaj = "Bu sicil numarası veya e-posta adresi sistemde zaten kayıtlı!";
        } else {
            // Şifreyi MD5'liyoruz
            $sifre_md5 = md5($sifre);
            // Varsayılan profil fotoğrafı yolu
            $varsayilan_foto = "../images/login/login.jpg";

            $kaydet = $db->prepare("INSERT INTO personeller (sicil_no, ad, soyad, email, sifre, dogum_tarihi, foto_url) VALUES (?, ?, ?, ?, ?, ?, ?)");
            if ($kaydet->execute([$sicil_no, $ad, $soyad, $email, $sifre_md5, $dogum_tarihi, $varsayilan_foto])) {
                $status = "success";
                $mesaj = "Personel kaydı başarıyla oluşturuldu! Giriş sayfasına yönlendiriliyorsunuz.";
            } else {
                $status = "error";
                $mesaj = "Kayıt sırasında teknik bir hata oluştu.";
            }
        }
    } else {
        $status = "error";
        $mesaj = "Lütfen tüm alanları eksiksiz doldurunuz!";
    }
}
?>
<!doctype html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Personel Kayıt - Gebze Belediyesi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
      body, html { height: 100%; margin: 0; font-family: "Segoe UI", sans-serif; position: relative; overflow-x: hidden; }
      body::before { content: ""; position: fixed; inset: 0; background-image: url("../images/login/login\(2\).jpg"); background-size: cover; background-position: center; background-attachment: fixed; filter: blur(8px) brightness(0.7); z-index: -1; }
      .login-container { min-height: 100vh; display: flex; align-items: center; justify-content: center; position: relative; z-index: 1; padding: 40px 20px; }
      .login-box { background-color: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); padding: 40px 30px; border-radius: 20px; box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3); max-width: 500px; width: 100%; color: black; text-align: center; margin: auto; }
      .form-control { background-color: rgba(0, 0, 0, 0.05); border: 1px solid rgba(0, 0, 0, 0.1); color: black; font-size: 16px; }
      .form-control:focus { background-color: rgba(255, 255, 255, 0.9); border-color: #363958; box-shadow: 0 0 0 0.2rem rgba(30, 88, 2, 0.25); }
      .btn-register { background: linear-gradient(135deg, #363958, #22243a); color: white; border: none; font-weight: 600; padding: 12px; transition: all 0.3s ease; }
      .btn-register:hover { background: linear-gradient(135deg, #0773b3, #0961a3); transform: translateY(-1px); box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2); }
      a { color: #363958; text-decoration: none; font-weight: 500; }
      a:hover { color: #0773b3; text-decoration: underline; }
      .login-title { font-size: 1.5rem; font-weight: 600; color: #363958; margin-bottom: 25px; }
    </style>
  </head>
  <body>
    <div class="login-container">
      <div class="login-box">
        <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #6368a3, #363958); border-radius: 50%; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; border: 3px solid white;">
          <i class="bi bi-person-plus-fill text-white" style="font-size: 2rem"></i>
        </div>
        <h2 class="login-title">Yeni Personel Kaydı</h2>
        
        <?php if(!empty($mesaj)): ?>
            <div class="alert alert-<?php echo $status == 'success' ? 'success' : 'danger'; ?> text-start small py-2 mb-3">
                <?php echo $mesaj; ?>
            </div>
            <?php if($status == 'success'): ?>
                <script>setTimeout(() => { window.location.href = 'login.php'; }, 2500);</script>
            <?php endif; ?>
        <?php endif; ?>

        <form action="kayit.php" method="POST" id="registerForm">
          <div class="row">
            <div class="col-md-12 form-floating mb-3">
              <input type="text" class="form-control" id="sicil_no" name="sicil_no" placeholder="Sicil No" required />
              <label for="sicil_no" class="ms-2">Sicil Numarası</label>
            </div>
            <div class="col-md-6 form-floating mb-3">
              <input type="text" class="form-control" id="ad" name="ad" placeholder="Ad" required />
              <label for="ad" class="ms-2">Adı</label>
            </div>
            <div class="col-md-6 form-floating mb-3">
              <input type="text" class="form-control" id="soyad" name="soyad" placeholder="Soyad" required />
              <label for="soyad" class="ms-2">Soyadı</label>
            </div>
            <div class="col-md-12 form-floating mb-3">
              <input type="email" class="form-control" id="email" name="email" placeholder="E-posta" required />
              <label for="email" class="ms-2">E-posta Adresi</label>
            </div>
            <div class="col-md-12 form-floating mb-3">
              <input type="password" class="form-control" id="sifre" name="sifre" placeholder="Şifre" required />
              <label for="sifre" class="ms-2">Şifre</label>
            </div>
            <div class="col-md-12 form-floating mb-4">
              <input type="date" class="form-control" id="dogum_tarihi" name="dogum_tarihi" required />
              <label for="dogum_tarihi" class="ms-2">Doğum Tarihi</label>
            </div>
          </div>

          <button type="submit" class="btn btn-register w-100 mb-3">
            <i class="bi bi-check-circle me-2"></i>KAYDI TAMAMLA
          </button>
          
          <div class="d-flex justify-content-center">
            <a href="login.php"><i class="bi bi-arrow-left me-1"></i> Giriş Sayfasına Dön</a>
          </div>
        </form>
      </div>
    </div>
  </body>
</html>