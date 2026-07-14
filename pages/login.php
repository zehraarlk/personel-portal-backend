<?php
session_start();
include "baglan.php";
$hataMesaji = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["sicil_no"]) && isset($_POST["sifre"])) {
  $sicil_no = trim($_POST["sicil_no"]);
  $sifre = md5(trim($_POST["sifre"])); // Şifreyi MD5'leyerek kontrol ediyoruz

  if (!empty($sicil_no) && !empty($sifre)) {
    // Personeller tablosundan sicil no ve şifre eşleşmesi kontrolü
    $sorgu = $db->prepare("SELECT * FROM personeller WHERE sicil_no = ? AND sifre = ?");
    $sorgu->execute([$sicil_no, $sifre]);
    $personel = $sorgu->fetch(PDO::FETCH_ASSOC);

    if ($personel) {
      $_SESSION["personel_id"] = $personel["id"];
      $_SESSION["sicil_no"] = $personel["sicil_no"];
      $_SESSION["email"] = $personel["email"];
      $_SESSION["fotograf"] = !empty($personel["foto_url"])
        ? $personel["foto_url"]
        : "../images/login/login.jpg";
      $_SESSION["ad"] = $personel["ad"];
      $_SESSION["soyad"] = $personel["soyad"];

      // 🕒 Giriş: eski açık oturumları kapat, yenisini aç
      $_SESSION["oturum_id"] = oturumStart($db, (int) $personel["id"]);

      echo json_encode(["status" => "success"]);
      exit();
    } else {
      echo json_encode(["status" => "error", "message" => "Sicil numarası veya şifre hatalı!"]);
      exit();
    }
  }
  exit();
}
?>
<!doctype html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Personel Portalı - Giriş</title>
    <link rel="icon" type="image/png" href="../images/favicon.png" />
    <link rel="shortcut icon" type="image/png" href="../images/favicon.png" />
    <link rel="apple-touch-icon" href="../images/favicon.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
      body, html {
        height: 100%;
        margin: 0;
        font-family: "Segoe UI", sans-serif;
        background: linear-gradient(135deg, #f4f6fb 0%, #e9ecf5 100%);
      }

      .login-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
      }

      .login-box {
        background-color: #ffffff;
        padding: 40px 35px;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
        max-width: 440px;
        width: 100%;
        text-align: center;
      }

      .logo-wrap {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 18px;
        margin-bottom: 15px;
      }

      .logo-wrap img {
        max-height: 70px;
        width: auto;
      }

      .login-subtitle {
        font-size: 1rem;
        font-weight: 700;
        letter-spacing: 1px;
        color: #b9bcc7;
        margin-bottom: 30px;
      }

      .form-label {
        font-weight: 600;
        color: #222;
        text-align: left;
        display: block;
        margin-bottom: 6px;
      }

      .form-label .text-danger {
        margin-left: 2px;
      }

      .form-control {
        background-color: #f1f2f6;
        border: 1px solid #f1f2f6;
        border-radius: 10px;
        color: #333;
        font-size: 15px;
        padding: 12px 15px;
      }

      .form-control:focus {
        background-color: #ffffff;
        border-color: #022842;
        box-shadow: 0 0 0 0.2rem rgba(180, 185, 185, 0.12);
      }

      .password-container {
        position: relative;
      }

      .password-toggle {
        position: absolute;
        top: 50%;
        right: 12px;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #888;
        cursor: pointer;
        padding: 5px;
      }

      .field-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 6px;
      }

      .forgot-link {
        font-size: 0.85rem;
        font-weight: 600;
        color: #023d65;
        text-decoration: none;
      }

      .forgot-link:hover {
        color: #022842;
        text-decoration: underline;
      }

      .btn-login {
        background: linear-gradient(135deg, #023d65, #022842);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        letter-spacing: 0.5px;
        padding: 13px;
        transition: all 0.3s ease;
        width: 100%;
      }

      .btn-login:hover {
        background: linear-gradient(135deg, #e4e4e4, #cbcbcb);
        transform: translateY(-1px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
      }

      .divider {
        display: flex;
        align-items: center;
        text-align: center;
        color: #b9bcc7;
        font-size: 0.8rem;
        font-weight: 700;
        letter-spacing: 1px;
        margin: 22px 0;
      }

      .divider::before,
      .divider::after {
        content: "";
        flex: 1;
        border-bottom: 1px solid #eee;
      }

      .divider:not(:empty)::before {
        margin-right: 0.75em;
      }

      .divider:not(:empty)::after {
        margin-left: 0.75em;
      }

      .btn-secondary-action {
        display: block;
        width: 100%;
        background-color: #f1f2f6;
        border: none;
        border-radius: 10px;
        color: #555;
        font-weight: 600;
        font-size: 0.9rem;
        padding: 13px;
        margin-bottom: 12px;
        text-decoration: none;
        transition: background-color 0.2s ease;
      }

      .btn-secondary-action:hover {
        background-color: #e6e7ec;
        color: #333;
      }

      .invalid-feedback {
        text-align: left;
      }

      @media (max-width: 576px) {
        .login-box {
          padding: 30px 22px;
          border-radius: 15px;
        }
        .logo-wrap img {
          max-height: 55px;
        }
      }
    </style>
  </head>
  <body>
    <div class="login-container">
      <div class="login-box">
        <div class="logo-wrap">
          <img src="https://personel.gebze.bel.tr/public/img/logo/logo1.png" alt="Gebze Belediyesi İnsan Kaynakları" />
        </div>
        <div class="login-subtitle">PERSONEL GİRİŞ EKRANI</div>

        <div id="phpError" class="alert alert-danger d-none text-start small py-2 mb-3"></div>

        <form id="loginForm" novalidate>
          <div class="mb-3 text-start">
            <label for="username" class="form-label">Sicil Numarası <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="username" name="sicil_no" placeholder="Sicil Numaranız..." autocomplete="username" />
            <div class="invalid-feedback">Sicil numarası boş bırakılamaz.</div>
          </div>

          <div class="mb-2 text-start">
            <div class="field-row">
              <label for="password" class="form-label mb-0">Şifre <span class="text-danger">*</span></label>
              <a href="sifre.php" class="forgot-link">Şifremi Unuttum ?</a>
            </div>
            <div class="password-container">
              <input type="password" class="form-control" id="password" name="sifre" placeholder="Şifreniz" autocomplete="current-password" />
              <button type="button" class="password-toggle" id="togglePassword" aria-label="Şifreyi göster/gizle">
                <i class="<?= portalSiteIconClass($db, "sifre_goster_bi", "bi bi-eye") ?>" id="toggleIcon"></i>
              </button>
            </div>
            <div class="invalid-feedback">Şifre boş bırakılamaz.</div>
          </div>

          <button type="submit" class="btn btn-login mt-3 mb-3">Giriş Yap</button>

          <div class="divider">YA DA</div>

          <a href="sifre.php" class="btn-secondary-action">Şifrenizi Sıfırlamak için Tıklayınız.</a>
          <a href="yonetim_giris.php" class="btn-secondary-action mb-0">Yönetim Paneli için Tıklayınız.</a>
        </form>
      </div>
    </div>

    <script>
      document.getElementById("togglePassword").addEventListener("click", function () {
        const passwordField = document.getElementById("password");
        const toggleIcon = document.getElementById("toggleIcon");
        if (passwordField.type === "password") {
          passwordField.type = "text";
          toggleIcon.className = <?= json_encode(portalSiteIconClass($db, "sifre_gizle_bi", "bi bi-eye-slash")) ?>;
        } else {
          passwordField.type = "password";
          toggleIcon.className = <?= json_encode(portalSiteIconClass($db, "sifre_goster_bi", "bi bi-eye")) ?>;
        }
      });

      document.getElementById("loginForm").addEventListener("submit", function (e) {
        e.preventDefault();
        const username = document.getElementById("username");
        const password = document.getElementById("password");
        const errorDiv = document.getElementById("phpError");
        errorDiv.classList.add("d-none");

        let isValid = true;
        if (username.value.trim() === "") {
          username.classList.add("is-invalid");
          isValid = false;
        } else {
          username.classList.remove("is-invalid");
        }

        if (password.value.trim() === "") {
          password.classList.add("is-invalid");
          isValid = false;
        } else {
          password.classList.remove("is-invalid");
        }

        if (isValid) {
          const submitBtn = document.querySelector(".btn-login");
          submitBtn.innerHTML = '<i class="<?= portalSiteIconClass($db, "islem_yukleniyor_bi", "bi bi-arrow-clockwise") ?> me-2"></i>GİRİŞ YAPILIYOR...';
          submitBtn.disabled = true;

          let formData = new FormData();
          formData.append("sicil_no", username.value.trim());
          formData.append("sifre", password.value.trim());

          fetch("login.php", { method: "POST", body: formData })
            .then((res) => res.json())
            .then((data) => {
              if (data.status === "success") {
                window.location.href = "ana_sayfa.php";
              } else {
                errorDiv.innerText = data.message;
                errorDiv.classList.remove("d-none");
                submitBtn.innerHTML = "Giriş Yap";
                submitBtn.disabled = false;
              }
            })
            .catch(() => {
              errorDiv.innerText = "Sunucu bağlantı hatası oluştu.";
              errorDiv.classList.remove("d-none");
              submitBtn.innerHTML = "Giriş Yap";
              submitBtn.disabled = false;
            });
        }
      });
    </script>
  </body>
</html>