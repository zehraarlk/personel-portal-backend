<?php
session_start();
include("baglan.php");
$hataMesaji = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['sicil_no']) && isset($_POST['sifre'])) {
    $sicil_no = trim($_POST['sicil_no']);
    $sifre = md5(trim($_POST['sifre'])); // Şifreyi MD5'leyerek kontrol ediyoruz

    if (!empty($sicil_no) && !empty($sifre)) {
        // Personeller tablosundan sicil no ve şifre eşleşmesi kontrolü
        $sorgu = $db->prepare("SELECT * FROM personeller WHERE sicil_no = ? AND sifre = ?");
        $sorgu->execute([$sicil_no, $sifre]);
        $personel = $sorgu->fetch(PDO::FETCH_ASSOC);

        if ($personel) {
            // Oturum (Session) bilgilerini eksiksiz dolduruyoruz kanka
            $_SESSION['personel_id'] = $personel['id'];
            $_SESSION['sicil_no']     = $personel['sicil_no'];
            $_SESSION['email']        = $personel['email'];
            $_SESSION['fotograf']     = !empty($personel['foto_url']) ? $personel['foto_url'] : '../images/login/login.jpg';
            $_SESSION['ad']           = $personel['ad'];
            $_SESSION['soyad']        = $personel['soyad']; // Soyadı da ekledik!

            // 🕒 Giriş Zamanını Veritabanına Kaydediyoruz
            $giris_ekle = $db->prepare("INSERT INTO oturum_kayitlari (personel_id, giris_zamani) VALUES (?, NOW())");
            $giris_ekle->execute([$personel['id']]);
            
            $_SESSION['oturum_id'] = $db->lastInsertId();

            echo json_encode(["status" => "success"]);
            exit;
        } else {
            echo json_encode(["status" => "error", "message" => "Sicil numarası veya şifre hatalı!"]);
            exit;
        }
    }
    exit;
}
?>
<!doctype html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login - Responsive İyileştirilmiş</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
      body, html { height: 100%; margin: 0; font-family: "Segoe UI", sans-serif; position: relative; overflow-x: hidden; }
      body::before { content: ""; position: fixed; inset: 0; background-image: url("../images/login/login\(2\).jpg"); background-size: cover; background-position: center; background-attachment: fixed; filter: blur(8px) brightness(0.7); z-index: -1; }
      .login-container { min-height: 100vh; display: flex; align-items: center; justify-content: center; position: relative; z-index: 1; padding: 20px; }
      .login-box { background-color: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); padding: 40px 30px; border-radius: 20px; box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3); max-width: 420px; width: 100%; color: black; text-align: center; margin: auto; }
      .form-control { background-color: rgba(0, 0, 0, 0.05); border: 1px solid rgba(0, 0, 0, 0.1); color: black; font-size: 16px; }
      .form-control:focus { background-color: rgba(255, 255, 255, 0.9); border-color: #363958; box-shadow: 0 0 0 0.2rem rgba(30, 88, 2, 0.25); }
      .btn-login { background: linear-gradient(135deg, #6368a3, #363958); color: white; border: none; font-weight: 600; padding: 12px; transition: all 0.3s ease; }
      .btn-login:hover { background: linear-gradient(135deg, #0773b3, #0961a3); transform: translateY(-1px); box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2); }
      a { color: #363958; text-decoration: none; font-weight: 500; }
      a:hover { color: #0773b3; text-decoration: underline; }
      .password-toggle { position: absolute; top: 50%; right: 15px; transform: translateY(-50%); background: none; border: none; color: #666; cursor: pointer; z-index: 10; padding: 5px; }
      .password-container { position: relative; }
      .login-title { font-size: 1.5rem; font-weight: 600; color: #363958; margin-bottom: 25px; }
      @media (max-width: 576px) { .login-box { padding: 30px 25px; border-radius: 15px; } .login-title { font-size: 1.3rem; } }
    </style>
    <link rel="stylesheet" href="../CSS/footer.css" />
  </head>
  <body>
    <div class="login-container">
      <div class="login-box">
        <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #6368a3, #363958); border-radius: 50%; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; border: 3px solid white;">
          <i class="bi bi-person-fill text-white" style="font-size: 2rem"></i>
        </div>
        <h2 class="login-title">Personel Portalı Giriş</h2>
        
        <div id="phpError" class="alert alert-danger d-none text-start small py-2 mb-3"></div>

        <form id="loginForm" novalidate>
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="username" name="sicil_no" placeholder="Username" autocomplete="username" />
            <label for="username">Sicil Numarası</label>
            <div class="invalid-feedback text-start">Sicil numarası boş bırakılamaz.</div>
          </div>
          <div class="form-floating mb-3 password-container">
            <input type="password" class="form-control" id="password" name="sifre" placeholder="Password" autocomplete="current-password" />
            <label for="password">Şifre</label>
            <button type="button" class="password-toggle" id="togglePassword" aria-label="Şifreyi göster/gizle">
              <i class="bi bi-eye" id="toggleIcon"></i>
            </button>
            <div class="invalid-feedback text-start">Şifre boş bırakılamaz.</div>
          </div>
          <button type="submit" class="btn btn-login w-100 mb-3">
            <i class="bi bi-box-arrow-in-right me-2"></i>OTURUM AÇ
          </button>
          <div class="d-flex justify-content-center mb-3">
            <a href="sifre.php"> <i class="bi bi-key me-1"></i>Şifremi Unuttum </a>
          </div>
        </form>
      </div>
    </div>

    <script>
      // Şifre gizle/göster fonksiyonu
      document.getElementById("togglePassword").addEventListener("click", function () {
        const passwordField = document.getElementById("password");
        const toggleIcon = document.getElementById("toggleIcon");
        if (passwordField.type === "password") {
          passwordField.type = "text";
          toggleIcon.className = "bi bi-eye-slash";
        } else {
          passwordField.type = "password";
          toggleIcon.className = "bi bi-eye";
        }
      });

      // Form validation ve AJAX ile Giriş Kontrolü
      document.getElementById("loginForm").addEventListener("submit", function (e) {
        e.preventDefault();
        const username = document.getElementById("username");
        const password = document.getElementById("password");
        const errorDiv = document.getElementById("phpError");
        errorDiv.classList.add("d-none");

        let isValid = true;
        if (username.value.trim() === "") { username.classList.add("is-invalid"); isValid = false; } 
        else { username.classList.remove("is-invalid"); }

        if (password.value.trim() === "") { password.classList.add("is-invalid"); isValid = false; } 
        else { password.classList.remove("is-invalid"); }

        if (isValid) {
          const submitBtn = document.querySelector(".btn-login");
          submitBtn.innerHTML = '<i class="bi bi-arrow-clockwise me-2"></i>GİRİŞ YAPILIYOR...';
          submitBtn.disabled = true;

          // FormData ile arka plana istek atıyoruz
          let formData = new FormData();
          formData.append('sicil_no', username.value.trim());
          formData.append('sifre', password.value.trim());

          fetch('login.php', { method: 'POST', body: formData })
          .then(res => res.json())
          .then(data => {
              if(data.status === "success") {
                  window.location.href = "ana_sayfa.php";
              } else {
                  errorDiv.innerText = data.message;
                  errorDiv.classList.remove("d-none");
                  submitBtn.innerHTML = '<i class="bi bi-box-arrow-in-right me-2"></i>OTURUM AÇ';
                  submitBtn.disabled = false;
              }
          }).catch(() => {
              errorDiv.innerText = "Sunucu bağlantı hatası oluştu.";
              errorDiv.classList.remove("d-none");
              submitBtn.innerHTML = '<i class="bi bi-box-arrow-in-right me-2"></i>OTURUM AÇ';
              submitBtn.disabled = false;
          });
        }
      });
    </script>
    <?php include "includes/footer.php"; ?>
  </body>
</html>