<?php
session_start();
include("baglan.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tc_no']) && isset($_POST['telefon'])) {
    $tc_no = trim($_POST['tc_no']);
    $telefon = preg_replace('/\D/', '', trim($_POST['telefon'])); // sadece rakamlar

    if (empty($tc_no) || strlen($tc_no) !== 11 || !ctype_digit($tc_no)) {
        echo json_encode(["status" => "error", "message" => "Geçerli bir T.C. Kimlik Numarası giriniz."]);
        exit;
    }

    if (empty($telefon) || strlen($telefon) !== 11 || substr($telefon, 0, 2) !== "05") {
        echo json_encode(["status" => "error", "message" => "Geçerli bir cep telefonu numarası giriniz. Örn: 05XX XXX XX XX"]);
        exit;
    }

    // Personel tablosunda T.C. kimlik no ve telefon eşleşmesi kontrolü
    $sorgu = $db->prepare("SELECT * FROM personeller WHERE tc_no = ? AND telefon = ?");
    $sorgu->execute([$tc_no, $telefon]);
    $personel = $sorgu->fetch(PDO::FETCH_ASSOC);

    if ($personel) {
        // Yeni geçici şifre oluşturup e-posta/sms ile gönderme akışı burada işlenir
        $yeni_sifre = strtoupper(substr(bin2hex(random_bytes(4)), 0, 8));
        $sifre_hash = md5($yeni_sifre);

        $guncelle = $db->prepare("UPDATE personeller SET sifre = ? WHERE id = ?");
        $guncelle->execute([$sifre_hash, $personel['id']]);

        // TODO: $yeni_sifre değerini SMS/e-posta ile personele iletiniz
        echo json_encode(["status" => "success", "message" => "Şifreniz sıfırlandı. Yeni şifreniz kayıtlı iletişim bilgilerinize gönderildi."]);
        exit;
    } else {
        echo json_encode(["status" => "error", "message" => "Girdiğiniz bilgilerle eşleşen bir personel kaydı bulunamadı."]);
        exit;
    }
}
?>
<!doctype html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Personel Portalı - Şifremi Unuttum</title>
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
        max-width: 460px;
        width: 100%;
        text-align: center;
      }

      .logo-wrap {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 18px;
        margin-bottom: 25px;
      }

      .logo-wrap img {
        max-height: 70px;
        width: auto;
      }

      .page-title {
        font-size: 1.6rem;
        font-weight: 700;
        color: #222;
        margin-bottom: 12px;
      }

      .page-subtitle {
        font-size: 0.95rem;
        color: #b9bcc7;
        margin-bottom: 28px;
      }

      .form-label {
        font-weight: 600;
        color: #222;
        text-align: left;
        display: block;
        margin-bottom: 6px;
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
        border-color: #023d65;
        box-shadow: 0 0 0 0.2rem rgba(88, 196, 192, 0.2);
      }

      .format-hint {
        font-size: 0.8rem;
        color: #9a9da8;
        text-align: left;
        margin-top: 6px;
        margin-bottom: 0;
      }

      .format-hint code {
        background-color: rgba(180, 185, 185, 0.12);
        color: #023d65;
        padding: 2px 8px;
        border-radius: 6px;
        font-weight: 600;
      }

      .btn-row {
        display: flex;
        gap: 12px;
        margin-top: 28px;
      }

      .btn-reset {
        flex: 1;
        background: linear-gradient(135deg, #023d65, #022842);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        padding: 13px;
        transition: all 0.3s ease;
      }

      .btn-reset:hover {
        background: linear-gradient(135deg, #023d65, #022842);
        transform: translateY(-1px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
      }

      .btn-cancel {
        flex: 1;
        background-color: rgba(180, 185, 185, 0.12);
        color: #023d65;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        padding: 13px;
        transition: all 0.2s ease;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .btn-cancel:hover {
        background-color: rgba(149, 185, 184, 0.2);
        color: #022842;
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
        .btn-row {
          flex-direction: column;
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

        <div class="page-title">Şifremi Unuttum ?</div>
        <div class="page-subtitle">Şifrenizi sıfırlamak için sizden istenilen bilgileri giriniz.</div>

        <div id="phpError" class="alert alert-danger d-none text-start small py-2 mb-3"></div>
        <div id="phpSuccess" class="alert alert-success d-none text-start small py-2 mb-3"></div>

        <form id="resetForm" novalidate>
          <div class="mb-3 text-start">
            <label for="tcNo" class="form-label">T.C Kimlik Numarası</label>
            <input type="text" class="form-control" id="tcNo" name="tc_no" placeholder="Kimlik Numaranız..." inputmode="numeric" maxlength="11" autocomplete="off" />
            <div class="invalid-feedback">Geçerli bir T.C. Kimlik Numarası giriniz.</div>
          </div>

          <div class="mb-1 text-start">
            <label for="telefon" class="form-label">Cep Telefonu</label>
            <input type="text" class="form-control" id="telefon" name="telefon" placeholder="0*************" inputmode="numeric" maxlength="11" autocomplete="off" />
            <div class="invalid-feedback">Geçerli bir cep telefonu numarası giriniz.</div>
          </div>
          <p class="format-hint">Cep Telefonu Yazım Formatı: <code>(05**) ***_****</code></p>

          <div class="btn-row">
            <button type="submit" class="btn-reset">Şifre Sıfırla</button>
            <a href="login.php" class="btn-cancel">Vazgeç</a>
          </div>
        </form>
      </div>
    </div>

    <script>
      const tcInput = document.getElementById("tcNo");
      const telInput = document.getElementById("telefon");

      // sadece rakam girişine izin ver
      [tcInput, telInput].forEach((el) => {
        el.addEventListener("input", function () {
          this.value = this.value.replace(/\D/g, "");
        });
      });

      document.getElementById("resetForm").addEventListener("submit", function (e) {
        e.preventDefault();
        const errorDiv = document.getElementById("phpError");
        const successDiv = document.getElementById("phpSuccess");
        errorDiv.classList.add("d-none");
        successDiv.classList.add("d-none");

        let isValid = true;

        if (tcInput.value.trim().length !== 11) {
          tcInput.classList.add("is-invalid");
          isValid = false;
        } else {
          tcInput.classList.remove("is-invalid");
        }

        if (telInput.value.trim().length !== 11 || !telInput.value.startsWith("05")) {
          telInput.classList.add("is-invalid");
          isValid = false;
        } else {
          telInput.classList.remove("is-invalid");
        }

        if (isValid) {
          const submitBtn = document.querySelector(".btn-reset");
          const originalText = submitBtn.innerHTML;
          submitBtn.innerHTML = '<i class="bi bi-arrow-clockwise me-2"></i>İŞLENİYOR...';
          submitBtn.disabled = true;

          let formData = new FormData();
          formData.append("tc_no", tcInput.value.trim());
          formData.append("telefon", telInput.value.trim());

          fetch("sifre.php", { method: "POST", body: formData })
            .then((res) => res.json())
            .then((data) => {
              submitBtn.innerHTML = originalText;
              submitBtn.disabled = false;
              if (data.status === "success") {
                successDiv.innerText = data.message;
                successDiv.classList.remove("d-none");
                document.getElementById("resetForm").reset();
              } else {
                errorDiv.innerText = data.message;
                errorDiv.classList.remove("d-none");
              }
            })
            .catch(() => {
              submitBtn.innerHTML = originalText;
              submitBtn.disabled = false;
              errorDiv.innerText = "Sunucu bağlantı hatası oluştu.";
              errorDiv.classList.remove("d-none");
            });
        }
      });
    </script>
  </body>
</html>