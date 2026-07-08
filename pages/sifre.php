<<<<<<< HEAD
<!DOCTYPE html>
<html class="light" lang="tr">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Şifreyi Sıfırla</title>
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            colors: {
              primary: {
                DEFAULT: "#0078d4",
                container: "#deecf9",
                fixed: "#0078d4",
              },
              surface: {
                DEFAULT: "#ffffff",
                variant: "#f3f2f1",
              },
              on: {
                surface: "#323130",
                "surface-variant": "#605e5c",
                primary: "#ffffff",
              },
              background: "#faf9f8",
              outline: "#8a8886",
            },
            borderRadius: {
              DEFAULT: "0.25rem",
              lg: "0.5rem",
              xl: "0.75rem",
              full: "9999px",
            },
            fontFamily: {
              headline: ["Public Sans", "sans-serif"],
              display: ["Public Sans", "sans-serif"],
              body: ["Public Sans", "sans-serif"],
              label: ["Public Sans", "sans-serif"],
            },
          },
        },
      };
    </script>
    <style>
      body {
        font-family: "Public Sans", sans-serif;
        background-color: #faf9f8;
        color: #323130;
      }
      .material-symbols-outlined {
        font-variation-settings: "FILL" 0, "wght" 400, "GRAD" 0, "opsz" 24;
        display: inline-block;
        vertical-align: middle;
      }
      input:focus {
        outline: none;
        border-color: #0078d4 !important;
        box-shadow: 0 0 0 1px #0078d4 !important;
      }
    </style>
  </head>
  <body class="bg-background min-h-screen flex items-center justify-center p-6 overflow-hidden selection:bg-primary-container selection:text-primary">
    <main class="w-full max-w-[440px]">
      <div class="bg-white rounded-lg shadow-xl shadow-black/5 p-10 border border-[#edebe9]">
        <div class="text-center mb-10">
          <div class="w-16 h-16 bg-primary-container rounded-full flex items-center justify-center mx-auto mb-6">
            <span class="material-symbols-outlined text-primary text-3xl" style="font-variation-settings: 'wght' 300;">lock_reset</span>
          </div>
          <h2 class="text-2xl font-bold tracking-tight text-on-surface mb-2">Şifreyi Sıfırla</h2>
        </div>

        <form class="space-y-6" id="resetForm" onsubmit="event.preventDefault();">
          <div class="space-y-1.5">
            <label class="text-sm font-semibold text-on-surface" for="tc_no">TC Kimlik No</label>
            <div class="relative">
              <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-xl">badge</span>
              <input class="w-full pl-10 pr-4 py-2.5 bg-surface-variant/30 border border-[#d2d0ce] rounded-md text-on-surface placeholder:text-on-surface-variant/60 transition-all duration-200" id="tc_no" maxlength="11" name="tc_no" placeholder="11 haneli TC No" type="text" />
            </div>
          </div>

          <div class="space-y-1.5">
            <label class="text-sm font-semibold text-on-surface" for="phone">Cep Telefonu</label>
            <div class="relative">
              <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-xl">phone_android</span>
              <input class="w-full pl-10 pr-4 py-2.5 bg-surface-variant/30 border border-[#d2d0ce] rounded-md text-on-surface placeholder:text-on-surface-variant/60 transition-all duration-200" id="phone" name="phone" placeholder="0 (5XX) XXX XX XX" type="tel" />
            </div>
          </div>

          <div class="pt-4 space-y-3">
            <button class="w-full bg-primary text-on-primary font-semibold py-3 px-6 rounded-md hover:opacity-90 active:scale-[0.98] transition-all duration-150 flex items-center justify-center gap-2 shadow-md shadow-primary/20" type="submit">
              Şifreyi Sıfırla
            </button>
            <button class="w-full bg-white border border-[#d2d0ce] text-on-surface font-semibold py-3 px-6 rounded-md hover:bg-surface-variant/50 active:scale-[0.98] transition-all duration-150" id="cancelBtn" type="button">
              Vazgeç
=======
<!doctype html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Şifre Sıfırla</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css"
      rel="stylesheet"
    />
    <style>
      body,
      html {
        height: 100%;
        margin: 0;
        font-family: "Segoe UI", sans-serif;
        position: relative;
        overflow-x: hidden;
      }

      body::before {
        content: "";
        position: fixed;
        inset: 0;
        background-image: url("");
        background-size: cover;
        background-image: url("../images/login/login\(2\).jpg");

        background-position: center;
        background-attachment: fixed;
        filter: blur(8px) brightness(0.7);
        z-index: -1;
      }

      .login-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        z-index: 1;
        padding: 20px;
      }

      .login-box {
        background-color: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        padding: 40px 30px;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        max-width: 420px;
        width: 100%;
        color: black;
        text-align: center;
        margin: auto;
      }

      .profile-img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 20px;
        border: 3px solid #363958;
        background: linear-gradient(135deg, #6368a3, #363958);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: auto;
        margin-right: auto;
      }

      .page-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #363958;
        margin-bottom: 25px;
      }

      .form-control {
        background-color: rgba(255, 255, 255, 0.8);
        border: 1px solid rgba(0, 0, 0, 0.1);
        color: black;
        font-size: 16px;
        transition: all 0.3s ease;
      }

      .form-control:focus {
        background-color: rgba(255, 255, 255, 0.9);
        border-color: #363958;
        box-shadow: 0 0 0 0.2rem rgba(30, 88, 2, 0.25);
      }

      .form-control.is-invalid {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
      }

      .form-control::placeholder {
        color: #999;
      }

      .btn-primary {
        background: linear-gradient(135deg, #6368a3, #363958);
        border: none;
        color: white;
        font-weight: 600;
        padding: 12px;
        transition: all 0.3s ease;
      }

      .btn-primary:hover {
        background: linear-gradient(135deg, #0773b3, #0961a3);
        transform: translateY(-1px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
      }

      .btn-secondary {
        background-color: #6c757d;
        border: none;
        color: white;
        font-weight: 500;
        padding: 12px;
        transition: all 0.3s ease;
      }

      .btn-secondary:hover {
        background-color: #5a6268;
        transform: translateY(-1px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
      }

      .btn-group-vertical .btn {
        margin-bottom: 10px;
      }

      .btn-group-vertical .btn:last-child {
        margin-bottom: 0;
      }

      .invalid-feedback {
        display: block;
        text-align: left;
        margin-top: 5px;
      }

      .back-link {
        color: #363958;
        text-decoration: none;
        font-weight: 500;
        margin-top: 20px;
        display: inline-block;
      }

      .back-link:hover {
        color: #0773b3;
        text-decoration: underline;
      }

      /* Responsive iyileştirmeler */
      @media (max-width: 576px) {
        .login-container {
          padding: 15px;
          min-height: 100vh;
        }

        .login-box {
          padding: 30px 25px;
          border-radius: 15px;
          max-width: 100%;
        }

        .profile-img {
          width: 80px;
          height: 80px;
        }

        .page-title {
          font-size: 1.3rem;
        }

        .form-control {
          font-size: 16px; /* iOS zoom engellemek için */
        }

        .btn-primary,
        .btn-secondary {
          padding: 14px;
          font-size: 1rem;
        }
      }

      @media (max-width: 400px) {
        .login-box {
          padding: 25px 20px;
        }

        .profile-img {
          width: 70px;
          height: 70px;
        }

        .page-title {
          font-size: 1.2rem;
        }

        .page-subtitle {
          font-size: 0.85rem;
        }
      }

      /* Landscape tablet/phone */
      @media (max-height: 600px) and (orientation: landscape) {
        .login-container {
          align-items: flex-start;
          padding-top: 20px;
        }

        .login-box {
          padding: 25px 30px;
        }

        .profile-img {
          width: 70px;
          height: 70px;
          margin-bottom: 15px;
        }

        .page-title {
          font-size: 1.2rem;
          margin-bottom: 5px;
        }

        .page-subtitle {
          margin-bottom: 15px;
        }
      }

      /* Loading animasyonu */
      .btn.loading {
        position: relative;
        color: transparent !important;
      }

      .btn.loading::after {
        content: "";
        position: absolute;
        width: 20px;
        height: 20px;
        top: 50%;
        left: 50%;
        margin-left: -10px;
        margin-top: -10px;
        border: 2px solid transparent;
        border-top-color: #ffffff;
        border-radius: 50%;
        animation: spin 1s linear infinite;
      }

      @keyframes spin {
        0% {
          transform: rotate(0deg);
        }
        100% {
          transform: rotate(360deg);
        }
      }
    </style>
    <link rel="stylesheet" href="../CSS/footer.css" />
  </head>
  <body>
    <div class="login-container">
      <div class="login-box">
        <!-- Icon -->
        <div class="profile-img">
          <i class="bi bi-key-fill text-white" style="font-size: 2.5rem"></i>
        </div>

        <h2 class="page-title">Şifre Sıfırla</h2>

        <form id="resetForm" novalidate>
          <div class="form-floating mb-3">
            <input
              type="text"
              class="form-control"
              id="tcno"
              placeholder="TC Kimlik Numarası"
              maxlength="11"
              pattern="[0-9]{11}"
            />
            <label for="tcno">TC Kimlik Numarası</label>
          </div>

          <div class="form-floating mb-4">
            <input
              type="tel"
              class="form-control"
              id="phone"
              placeholder="Cep Telefonu Numarası"
              maxlength="10"
              pattern="[0-9]{10}"
            />
            <label for="phone">Cep Telefonu Numarası</label>
          </div>

          <div class="btn-group-vertical w-100">
            <button type="submit" class="btn btn-primary" id="resetBtn">
              <i class="bi bi-arrow-clockwise me-2"></i>Şifreyi Sıfırla
            </button>
            <button type="button" class="btn btn-secondary" id="cancelBtn">
              <i class="bi bi-x-circle me-2"></i>Vazgeç
>>>>>>> 112b37f5f7eedd448db79abf5191316023500533
            </button>
          </div>
        </form>

<<<<<<< HEAD
        <div class="mt-8 pt-8 border-t border-[#edebe9] text-center">
          <a class="group inline-flex items-center gap-1 text-primary text-sm font-medium transition-colors leading-none" href="login.php">
            <span class="material-symbols-outlined text-lg">arrow_back</span>
            <span class="underline-offset-4 decoration-primary/60 group-hover:underline group-hover:decoration-primary">
              Giriş Sayfasına Dön
            </span>
          </a>
        </div>
      </div>
    </main>

    <div class="fixed top-0 right-0 p-12 -z-10 opacity-20 pointer-events-none">
      <span class="material-symbols-outlined text-[300px] text-primary/10 select-none">verified_user</span>
    </div>

    <script>
      // TC only digits
      document.getElementById("tc_no").addEventListener("input", function () {
        this.value = this.value.replace(/[^0-9]/g, "");
      });

      // Phone basic mask
      document.getElementById("phone").addEventListener("input", function () {
        let x = this.value.replace(/\D/g, "").match(/(\d{0,3})(\d{0,3})(\d{0,2})(\d{0,2})/);
        this.value = !x[2] ? x[1] : "(" + x[1] + ") " + x[2] + (x[3] ? "-" + x[3] : "") + (x[4] ? "-" + x[4] : "");
        if (this.value.length > 14) this.value = this.value.slice(0, 15);
      });

      document.getElementById("resetForm").addEventListener("submit", function () {
        alert("Şifre sıfırlama bağlantısı cep telefonunuza SMS ile gönderildi!");
        window.location.href = "login.php";
      });

      document.getElementById("cancelBtn").addEventListener("click", function () {
        window.location.href = "login.php";
      });
    </script>
=======
        <a href="login.php" class="back-link">
          <i class="bi bi-arrow-left me-1"></i>Giriş sayfasına dön
        </a>
      </div>
    </div>

    <script>
      // TC Kimlik numarası sadece rakam kabul etme
      document.getElementById("tcno").addEventListener("input", function (e) {
        this.value = this.value.replace(/[^0-9]/g, "").slice(0, 11);
      });

      // Telefon numarası sadece rakam kabul etme
      document.getElementById("phone").addEventListener("input", function (e) {
        this.value = this.value.replace(/[^0-9]/g, "").slice(0, 10);
      });

      // Form validation
      document.getElementById("resetForm").addEventListener("submit", function (e) {
        e.preventDefault();

        const tcno = document.getElementById("tcno");
        const phone = document.getElementById("phone");
        const resetBtn = document.getElementById("resetBtn");

        let isValid = true;

        // TC Kimlik numarası kontrolü
        if (tcno.value.length !== 11) {
          tcno.classList.add("is-invalid");
          isValid = false;
        } else {
          tcno.classList.remove("is-invalid");
        }

        // Telefon numarası kontrolü
        if (phone.value.length !== 10) {
          phone.classList.add("is-invalid");
          isValid = false;
        } else {
          phone.classList.remove("is-invalid");
        }

        if (isValid) {
          // Loading durumu
          resetBtn.classList.add("loading");
          resetBtn.disabled = true;

          // Simüle edilmiş API çağrısı
          setTimeout(() => {
            alert("Şifre sıfırlama bağlantısı cep telefonunuza SMS ile gönderildi!");

            // Başarılı işlem sonrası login sayfasına yönlendir
            window.location.href = "login.php";
          }, 2000);
        }
      });

      // Vazgeç butonu
      document.getElementById("cancelBtn").addEventListener("click", function () {
        window.location.href = "login.php";
      });

      // Input focus animasyonları
      document.querySelectorAll(".form-control").forEach((input) => {
        input.addEventListener("focus", function () {
          this.parentElement.style.transform = "scale(1.02)";
          this.parentElement.style.transition = "transform 0.2s ease";
        });

        input.addEventListener("blur", function () {
          this.parentElement.style.transform = "scale(1)";
        });
      });
    </script>
    <?php include "includes/footer.php"; ?>
>>>>>>> 112b37f5f7eedd448db79abf5191316023500533
  </body>
</html>
