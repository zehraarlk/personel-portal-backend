<?php
include "baglan.php";

// Zaten aktif oturum varsa panele yönlendir
if (adminIsLoggedIn()) {
  header("Location: admin/index.php");
  exit();
}

// Eski / kapanmış oturum kalıntılarını temizle
adminSessionClear();

if (
  $_SERVER["REQUEST_METHOD"] == "POST" &&
  isset($_POST["kullanici_adi"]) &&
  isset($_POST["sifre"])
) {
  header("Content-Type: application/json; charset=utf-8");

  $kullanici_adi = trim($_POST["kullanici_adi"]);
  $sifre = (string) $_POST["sifre"];

  if (!empty($kullanici_adi) && $sifre !== "") {
    $sorgu = $db->prepare(
      "SELECT * FROM yoneticiler WHERE LOWER(kullanici_adi) = LOWER(?) AND aktif = 1 LIMIT 1",
    );
    $sorgu->execute([$kullanici_adi]);
    $yonetici = $sorgu->fetch(PDO::FETCH_ASSOC);

    if ($yonetici && adminVerifyPassword((string) $yonetici["sifre"], $sifre)) {
      // Personel oturumu varsa temizle
      if (isset($_SESSION["oturum_id"])) {
        oturumClose($db, (int) $_SESSION["oturum_id"], "otomatik");
      }
      unset(
        $_SESSION["personel_id"],
        $_SESSION["oturum_id"],
        $_SESSION["ad"],
        $_SESSION["soyad"],
        $_SESSION["email"],
        $_SESSION["fotograf"],
        $_SESSION["sicil_no"],
      );

      $_SESSION["yonetici_id"] = $yonetici["id"];
      $_SESSION["yonetici_kullanici"] = $yonetici["kullanici_adi"];
      $_SESSION["yonetici_ad"] = $yonetici["ad"];
      $_SESSION["yonetici_soyad"] = $yonetici["soyad"];
      $_SESSION["yonetici_yetki"] = $yonetici["yetki"];
      $_SESSION["yonetici_oturum_id"] = yoneticiOturumStart($db, (int) $yonetici["id"]);

      // Eski MD5 şifreyi bcrypt'e yükselt
      if (strlen((string) $yonetici["sifre"]) === 32 && ctype_xdigit((string) $yonetici["sifre"])) {
        $db
          ->prepare("UPDATE yoneticiler SET sifre = ? WHERE id = ?")
          ->execute([adminHashPassword($sifre), $yonetici["id"]]);
      }

      echo json_encode(["status" => "success"]);
      exit();
    } else {
      echo json_encode(["status" => "error", "message" => "Kullanıcı adı veya şifre hatalı!"]);
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
    <title>Personel Portalı - Yönetim Paneli Girişi</title>
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

      .badge-panel {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background-color: rgba(99, 104, 163, 0.12);
        color: #46498a;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        padding: 5px 14px;
        border-radius: 20px;
        margin-bottom: 14px;
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
        border-color: #6368a3;
        box-shadow: 0 0 0 0.2rem rgba(99, 104, 163, 0.2);
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

      .btn-login {
        background: linear-gradient(135deg, #6368a3, #363958);
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
        background: linear-gradient(135deg, #565a91, #2c2e48);
        transform: translateY(-1px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
      }

      .back-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        color: #6368a3;
        text-decoration: none;
        margin-top: 22px;
      }

      .back-link:hover {
        color: #363958;
        text-decoration: underline;
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
        <div class="badge-panel"><i class="<?= portalSiteIconClass($db, "yonetim_guvenlik_bi", "bi bi-shield-lock-fill") ?>"></i> YÖNETİM PANELİ</div>
        <div class="login-subtitle">YÖNETİCİ GİRİŞ EKRANI</div>
        <p class="text-muted small mb-3">Yönetim paneli girişi personel girişinden ayrıdır.</p>

        <div id="phpError" class="alert alert-danger d-none text-start small py-2 mb-3"></div>

        <form id="loginForm" novalidate>
          <div class="mb-3 text-start">
            <label for="username" class="form-label">Kullanıcı Adı <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="username" name="kullanici_adi" placeholder="Kullanıcı Adınız..." autocomplete="username" />
            <div class="invalid-feedback">Kullanıcı adı boş bırakılamaz.</div>
          </div>

          <div class="mb-2 text-start">
            <label for="password" class="form-label">Şifre <span class="text-danger">*</span></label>
            <div class="password-container">
              <input type="password" class="form-control" id="password" name="sifre" placeholder="Şifreniz" autocomplete="current-password" />
              <button type="button" class="password-toggle" id="togglePassword" aria-label="Şifreyi göster/gizle">
                <i class="<?= portalSiteIconClass($db, "sifre_goster_bi", "bi bi-eye") ?>" id="toggleIcon"></i>
              </button>
            </div>
            <div class="invalid-feedback">Şifre boş bırakılamaz.</div>
          </div>

          <button type="submit" class="btn btn-login mt-3 mb-2">
            <i class="<?= portalSiteIconClass($db, "giris_yap_bi", "bi bi-box-arrow-in-right") ?> me-2"></i>GİRİŞ YAP
          </button>

          <a href="login.php" class="back-link"><i class="<?= portalSiteIconClass($db, "geri_don_bi", "bi bi-arrow-left") ?>"></i> Personel Girişine Dön</a>
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
          formData.append("kullanici_adi", username.value.trim());
          formData.append("sifre", password.value);

          fetch("yonetim_giris.php", { method: "POST", body: formData })
            .then((res) => res.json())
            .then((data) => {
              if (data.status === "success") {
                window.location.href = "admin/index.php";
              } else {
                errorDiv.innerText = data.message;
                errorDiv.classList.remove("d-none");
                submitBtn.innerHTML = '<i class="<?= portalSiteIconClass($db, "giris_yap_bi", "bi bi-box-arrow-in-right") ?> me-2"></i>GİRİŞ YAP';
                submitBtn.disabled = false;
              }
            })
            .catch(() => {
              errorDiv.innerText = "Sunucu bağlantı hatası oluştu.";
              errorDiv.classList.remove("d-none");
              submitBtn.innerHTML = '<i class="<?= portalSiteIconClass($db, "giris_yap_bi", "bi bi-box-arrow-in-right") ?> me-2"></i>GİRİŞ YAP';
              submitBtn.disabled = false;
            });
        }
      });
    </script>
  </body>
</html>