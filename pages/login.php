<?php
session_start();
include("baglan.php");
$hataMesaji = "";

if (!empty($_SESSION["personel_id"]) || authTryAutoLogin($db)) {
    header("Location: ana_sayfa.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['sicil_no']) && isset($_POST['sifre'])) {
    $sicil_no = trim($_POST['sicil_no']);
    $sifre = md5(trim($_POST['sifre'])); // Şifreyi MD5'leyerek kontrol ediyoruz

    if (!empty($sicil_no) && !empty($sifre)) {
        // Personeller tablosundan sicil no ve şifre eşleşmesi kontrolü
        $sorgu = $db->prepare("SELECT * FROM personeller WHERE sicil_no = ? AND sifre = ?");
        $sorgu->execute([$sicil_no, $sifre]);
        $personel = $sorgu->fetch(PDO::FETCH_ASSOC);

        if ($personel) {
            // Oturum (Session) bilgileri
            $_SESSION['personel_id'] = $personel['id'];
            $_SESSION['sicil_no']     = $personel['sicil_no'];
            $_SESSION['email']        = $personel['email'];
            $_SESSION['fotograf']     = !empty($personel['foto_url']) ? $personel['foto_url'] : '../images/login/login.jpg';
            $_SESSION['ad']           = $personel['ad'];
            $_SESSION['soyad']        = $personel['soyad'];

            // Kalıcı oturum
            authIssueRememberToken($db, (int)$personel["id"]);

            // Giriş Zamanını Veritabanına Kaydediyoruz
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
<!DOCTYPE html>
<html class="light" lang="tr">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Giriş Yap - Personel Portalı</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            colors: {
              primary: "#005A9E",
              "on-primary": "#FFFFFF",
              "primary-container": "#DEECF9",
              "on-primary-container": "#002050",
              surface: "#FAF9F8",
              "on-surface": "#323130",
              "on-surface-variant": "#605E5C",
              outline: "#C8C6C4",
              background: "#FFFFFF",
              error: "#A4262C",
            },
            borderRadius: {
              DEFAULT: "2px",
              lg: "4px",
              xl: "8px",
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
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
      }
      .material-symbols-outlined {
        font-variation-settings: "FILL" 0, "wght" 400, "GRAD" 0, "opsz" 24;
      }
      .azure-input:focus {
        outline: none;
        border-color: #005a9e;
        box-shadow: 0 0 0 1px #005a9e;
      }
    </style>
    <link rel="stylesheet" href="../CSS/footer.css" />
  </head>
  <body class="bg-surface text-on-surface min-h-screen flex items-center justify-center overflow-hidden">
    <main class="relative z-10 w-full max-w-md px-6">
      <div class="bg-background shadow-sm border border-outline/30 rounded-lg p-8 md:p-10">
        <div class="text-center mb-10">
          <h1 class="text-3xl font-extrabold text-primary tracking-tight mb-2">Giriş Yap</h1>
          <p class="text-on-surface-variant text-sm">Devam etmek için bilgilerinizi girin.</p>
        </div>

        <div id="phpError" class="hidden rounded-md border border-error/30 bg-error/10 text-error text-sm px-3 py-2 mb-5 text-left"></div>

        <form id="loginForm" class="space-y-6" onsubmit="return false;">
          <div class="space-y-1.5">
            <label class="block text-xs font-semibold text-on-surface-variant uppercase tracking-wider" for="sicil_no">Sicil No</label>
            <div class="relative group">
              <input
                class="azure-input block w-full pr-3 py-2.5 border border-outline rounded-md bg-white text-on-surface text-sm placeholder:text-outline transition-all px-3"
                id="sicil_no"
                name="sicil_no"
                placeholder="000000"
                type="text"
                autocomplete="username"
              />
            </div>
            <p id="sicilErr" class="hidden text-xs text-error">Sicil numarası boş bırakılamaz.</p>
          </div>

          <div class="space-y-1.5">
            <label class="block text-xs font-semibold text-on-surface-variant uppercase tracking-wider" for="password">Şifre</label>
            <div class="relative group">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-on-surface-variant group-focus-within:text-primary transition-colors">
                <span class="material-symbols-outlined text-[20px]">lock</span>
              </div>
              <input
                class="azure-input block w-full pl-10 pr-10 py-2.5 border border-outline rounded-md bg-white text-on-surface text-sm placeholder:text-outline transition-all"
                id="password"
                name="sifre"
                placeholder="••••••••"
                type="password"
                autocomplete="current-password"
              />
              <button id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-on-surface-variant hover:text-primary transition-colors" type="button" aria-label="Şifreyi göster/gizle">
                <span id="toggleIcon" class="material-symbols-outlined text-[20px]">visibility</span>
              </button>
            </div>
            <p id="passErr" class="hidden text-xs text-error">Şifre boş bırakılamaz.</p>
          </div>

          <div class="pt-2">
            <button id="submitBtn" class="w-full bg-primary text-on-primary font-semibold py-3 px-4 rounded-md shadow-md hover:bg-primary/90 active:scale-[0.98] transition-all duration-150 flex items-center justify-center gap-2" type="submit">
              <span id="submitText">Giriş</span>
              <span class="material-symbols-outlined text-[18px]">login</span>
            </button>
          </div>

          <div class="text-center pt-1">
            <a class="text-sm font-medium text-primary hover:underline transition-all" href="sifre.php">Şifremi Unuttum</a>
          </div>
        </form>
      </div>
    </main>

    <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-primary-container/20 blur-[120px] -z-10"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] rounded-full bg-primary/5 blur-[120px] -z-10"></div>

    <script>
      const toggleBtn = document.getElementById("togglePassword");
      const passwordInput = document.getElementById("password");
      const icon = document.getElementById("toggleIcon");
      toggleBtn?.addEventListener("click", () => {
        if (passwordInput.type === "password") {
          passwordInput.type = "text";
          icon.innerText = "visibility_off";
        } else {
          passwordInput.type = "password";
          icon.innerText = "visibility";
        }
      });

      document.addEventListener("DOMContentLoaded", () => {
        const card = document.querySelector("main");
        card.style.opacity = "0";
        card.style.transform = "translateY(20px)";
        card.style.transition = "all 0.6s cubic-bezier(0.16, 1, 0.3, 1)";
        setTimeout(() => {
          card.style.opacity = "1";
          card.style.transform = "translateY(0)";
        }, 100);
      });

      document.getElementById("loginForm").addEventListener("submit", function () {
        const sicil = document.getElementById("sicil_no");
        const pass = document.getElementById("password");
        const errorDiv = document.getElementById("phpError");
        const sicilErr = document.getElementById("sicilErr");
        const passErr = document.getElementById("passErr");
        const submitBtn = document.getElementById("submitBtn");
        const submitText = document.getElementById("submitText");

        errorDiv.classList.add("hidden");
        sicilErr.classList.add("hidden");
        passErr.classList.add("hidden");

        let ok = true;
        if (sicil.value.trim() === "") {
          ok = false;
          sicilErr.classList.remove("hidden");
        }
        if (pass.value.trim() === "") {
          ok = false;
          passErr.classList.remove("hidden");
        }
        if (!ok) return;

        submitBtn.disabled = true;
        submitText.textContent = "Giriş yapılıyor...";

        const formData = new FormData();
        formData.append("sicil_no", sicil.value.trim());
        formData.append("sifre", pass.value.trim());

        fetch("login.php", { method: "POST", body: formData })
          .then((res) => res.json())
          .then((data) => {
            if (data.status === "success") {
              window.location.href = "ana_sayfa.php";
              return;
            }
            errorDiv.textContent = data.message || "Giriş başarısız.";
            errorDiv.classList.remove("hidden");
            submitBtn.disabled = false;
            submitText.textContent = "Giriş";
          })
          .catch(() => {
            errorDiv.textContent = "Sunucu bağlantı hatası oluştu.";
            errorDiv.classList.remove("hidden");
            submitBtn.disabled = false;
            submitText.textContent = "Giriş";
          });
      });
    </script>
  </body>
</html>
