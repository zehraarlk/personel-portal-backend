<?php
/**
 * Site ikonlarını site_ikonlari tablosundan okur.
 * Eksik varsayılan ikon kayıtlarını tabloya otomatik ekler.
 */

if (!function_exists("siteIkonVarsayilanlari")) {
  function siteIkonVarsayilanlari(): array
  {
    return [
      ["menu_ac", "Mobil Menüyü Aç", "arayuz", "fas fa-bars", null, 10],

      ["anasayfa", "Anasayfa", "navigasyon", "fas fa-home", null, 20],
      ["videolar", "Videolar", "navigasyon", "fas fa-video", null, 30],
      ["etkinlikler", "Etkinlikler", "navigasyon", "fas fa-newspaper", null, 40],
      ["sizden_gelenler", "Sizden Gelenler", "navigasyon", "fas fa-comments", null, 50],
      ["etkinlik_takvimi", "Etkinlik Takvimi", "navigasyon", "fas fa-calendar-check", null, 60],
      ["duyurular", "Duyurular", "navigasyon", "fas fa-bullhorn", null, 70],

      ["kaynaklar", "Kaynaklar", "navigasyon", "fas fa-landmark", null, 80],
      ["protokoller", "Protokoller", "navigasyon", "fas fa-file-signature", null, 90],
      ["dokumanlar", "Dokümanlar", "navigasyon", "fas fa-file-alt", null, 100],
      ["mevzuatlar", "Mevzuatlar", "navigasyon", "fas fa-balance-scale", null, 110],
      ["egitimler", "Eğitimler", "navigasyon", "fas fa-graduation-cap", null, 120],

      ["diger", "Diğer", "navigasyon", "fas fa-file-alt", null, 130],
      ["anketler", "Anketler", "navigasyon", "fas fa-poll", null, 140],
      ["yardimci_linkler", "Yardımcı Linkler", "navigasyon", "fas fa-link", null, 150],
      ["vefat_bilgisi", "Vefat Eden Bilgisi", "navigasyon", "fas fa-ribbon", "#222222", 160],
      ["dogum_gunu", "Doğum Günü Bilgisi", "navigasyon", "fas fa-birthday-cake", null, 170],

      ["yonetim_paneli", "Yönetim Paneli", "profil", "fas fa-cog", null, 180],
      ["oturum_bilgileri", "Oturum Bilgileri", "profil", "fas fa-history", null, 190],
      ["email_degistir", "E-posta Değiştir", "profil", "fas fa-envelope", null, 200],
      ["sifre_degistir", "Şifre Değiştir", "profil", "fas fa-key", null, 210],
      ["cikis_yap", "Çıkış Yap", "profil", "fas fa-sign-out-alt", null, 220],

      ["telefon", "Telefon", "iletisim", "fas fa-phone", null, 230],
      ["eposta", "E-posta", "iletisim", "fas fa-envelope", null, 240],

      ["facebook", "Facebook", "sosyal", "fab fa-facebook-f", null, 250],
      ["twitter", "Twitter / X", "sosyal", "fab fa-twitter", null, 260],
      ["instagram", "Instagram", "sosyal", "fab fa-instagram", null, 270],
      ["youtube", "YouTube", "sosyal", "fab fa-youtube", null, 280],
      ["linkedin", "LinkedIn", "sosyal", "fab fa-linkedin-in", null, 290],
    ];
  }
}

if (!function_exists("siteIkonVarsayilanlariniEkle")) {
  function siteIkonVarsayilanlariniEkle($db): void
  {
    static $calisti = false;

    if ($calisti || !($db instanceof PDO)) {
      return;
    }
    $calisti = true;

    try {
      $mevcutAnahtarlar = [];
      $stmt = $db->query("SELECT anahtar FROM site_ikonlari");

      while ($satir = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $anahtar = trim((string) ($satir["anahtar"] ?? ""));
        if ($anahtar !== "") {
          $mevcutAnahtarlar[$anahtar] = true;
        }
      }

      $ekle = $db->prepare(
        "INSERT INTO site_ikonlari
          (anahtar, ad, kategori, ikon_sinifi, renk, sira, aktif)
         VALUES (?, ?, ?, ?, ?, ?, 1)",
      );

      foreach (siteIkonVarsayilanlari() as $ikon) {
        [$anahtar, $ad, $kategori, $ikonSinifi, $renk, $sira] = $ikon;

        if (isset($mevcutAnahtarlar[$anahtar])) {
          continue;
        }

        $ekle->execute([$anahtar, $ad, $kategori, $ikonSinifi, $renk, $sira]);
      }
    } catch (Throwable $e) {
      // Tablo yoksa veya yazma yetkisi yoksa site varsayılan ikonlarla çalışır.
    }
  }
}

if (!function_exists("siteIkonKayitlari")) {
  function siteIkonKayitlari($db): array
  {
    static $cache = [];

    if (!($db instanceof PDO)) {
      return [];
    }

    $cacheKey = spl_object_id($db);
    if (array_key_exists($cacheKey, $cache)) {
      return $cache[$cacheKey];
    }

    siteIkonVarsayilanlariniEkle($db);

    $ikonlar = [];

    try {
      $stmt = $db->query(
        "SELECT anahtar, ikon_sinifi, renk
         FROM site_ikonlari
         WHERE aktif = 1
         ORDER BY sira ASC, id ASC",
      );

      while ($satir = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $anahtar = trim((string) ($satir["anahtar"] ?? ""));
        if ($anahtar === "") {
          continue;
        }

        $ikonlar[$anahtar] = [
          "ikon_sinifi" => trim((string) ($satir["ikon_sinifi"] ?? "")),
          "renk" => trim((string) ($satir["renk"] ?? "")),
        ];
      }
    } catch (Throwable $e) {
      $ikonlar = [];
    }

    $cache[$cacheKey] = $ikonlar;
    return $ikonlar;
  }
}

if (!function_exists("siteIkonSinifi")) {
  function siteIkonSinifi($db, string $anahtar, string $varsayilan): string
  {
    $ikonlar = siteIkonKayitlari($db);
    $sinif = trim((string) ($ikonlar[$anahtar]["ikon_sinifi"] ?? ""));

    if ($sinif === "" || !preg_match('/^[a-zA-Z0-9 _-]+$/', $sinif)) {
      $sinif = $varsayilan;
    }

    return htmlspecialchars($sinif, ENT_QUOTES, "UTF-8");
  }
}

if (!function_exists("siteIkonStili")) {
  function siteIkonStili($db, string $anahtar): string
  {
    $ikonlar = siteIkonKayitlari($db);
    $renk = trim((string) ($ikonlar[$anahtar]["renk"] ?? ""));

    if ($renk === "" || !preg_match('/^#[0-9a-fA-F]{3}([0-9a-fA-F]{3})?$/', $renk)) {
      return "";
    }

    return ' style="color: ' . htmlspecialchars($renk, ENT_QUOTES, "UTF-8") . ';"';
  }
}
