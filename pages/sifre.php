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
            </button>
          </div>
        </form>

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
  </body>
</html>
