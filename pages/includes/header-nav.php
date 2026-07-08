<?php
// Eğer bu sayfa dahil edilmeden önce session_start() başlatılmadıysa otomatik başlatıyoruz kanka
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Oturum açmış personelin verileri yoksa varsayılan değerler atıyoruz ki hata fırlatmasın
$session_ad = isset($_SESSION['ad']) ? $_SESSION['ad'] : 'Kullanıcı';
$session_soyad = isset($_SESSION['soyad']) ? $_SESSION['soyad'] : 'Adı';
$session_email = isset($_SESSION['email']) ? $_SESSION['email'] : 'personel@gebze.bel.tr';
$session_foto = !empty($_SESSION['fotograf']) ? $_SESSION['fotograf'] : '../images/login/login.jpg';
$session_oturum_aktif = !empty($_SESSION['personel_id']) && !empty($_SESSION['oturum_id']);

// Aktif oturumun son aktivite zamanını yenile
if ($session_oturum_aktif && isset($db) && $db instanceof PDO) {
    oturumTouch($db, (int)$_SESSION['oturum_id']);
}
?>
<?php if ($session_oturum_aktif): ?>
<script>
(function () {
  if (window.__ppSessionGuard) return;
  window.__ppSessionGuard = true;

  var endpoint = "oturum_kapat.php";
  var NAV_KEY = "pp_internal_nav";
  var sent = false;

  // Önceki sayfadan kalan bayrağı temizle
  try { sessionStorage.removeItem(NAV_KEY); } catch (e0) {}

  function markInternalNav() {
    try { sessionStorage.setItem(NAV_KEY, "1"); } catch (e1) {}
  }

  function isInternalNav() {
    try { return sessionStorage.getItem(NAV_KEY) === "1"; } catch (e2) { return false; }
  }

  function sameOriginHref(href) {
    if (!href || href.charAt(0) === "#" || href.indexOf("javascript:") === 0) return false;
    try {
      var url = new URL(href, window.location.href);
      return url.origin === window.location.origin;
    } catch (e3) {
      return href.indexOf("http") !== 0;
    }
  }

  // mousedown: click'ten önce — profil menü linklerinde de yakalar
  function onPossibleNav(e) {
    var a = e.target && e.target.closest ? e.target.closest("a[href]") : null;
    if (!a) return;
    if (a.target && a.target !== "" && a.target !== "_self") return;
    if (sameOriginHref(a.getAttribute("href") || a.href || "")) {
      markInternalNav();
    }
  }

  document.addEventListener("mousedown", onPossibleNav, true);
  document.addEventListener("touchstart", onPossibleNav, true);
  document.addEventListener("click", onPossibleNav, true);
  document.addEventListener("submit", function () { markInternalNav(); }, true);
  window.addEventListener("keydown", function (e) {
    if (e.key === "F5" || ((e.ctrlKey || e.metaKey) && (e.key === "r" || e.key === "R"))) {
      markInternalNav();
    }
  });

  function closeSession() {
    if (sent || isInternalNav()) return;
    sent = true;
    try {
      if (navigator.sendBeacon) {
        navigator.sendBeacon(endpoint, new Blob(["1"], { type: "text/plain" }));
        return;
      }
    } catch (e4) {}
    try {
      fetch(endpoint, { method: "POST", keepalive: true, credentials: "same-origin", cache: "no-store" });
    } catch (e5) {}
  }

  // Sadece gerçek sekme/tarayıcı kapanışında kapat (site içi gezinmede değil)
  window.addEventListener("pagehide", function (e) {
    if (e.persisted) return;
    closeSession();
  });
})();
</script>
<?php endif; ?>
    <nav class="navbar">
      <div class="nav-container">
        <div class="nav-left">
          <button class="mobile-menu-toggle" aria-label="Menüyü aç">
            <i class="fas fa-bars"></i>
          </button>
          <a href="ana_sayfa.php" class="logo-container">
            <img src="../images/logo(2).png" alt="Gebze Belediyesi Logosu" class="logo-img" />

          </a>
        </div>

        <ul class="nav-links">
          <li class="nav-dropdown">
            <a href="ana_sayfa.php"><i class="fas fa-home"></i> Anasayfa</a>
          </li>
          <li>
            <a href="videolar.php"><i class="fas fa-video"></i> Videolar</a>
          </li>
          <li class="nav-dropdown dd-safe">
            <a href="#" class="nav-dropdown-toggle">
              <i class="fas fa-newspaper"></i>
              Etkinlikler
            </a>
            <div class="nav-dropdown-menu pull-left">
              <div class="dropdown-content">
                <div class="dropdown-grid">
                  <a href="sizden_gelenler.php" class="dropdown-item">
                    <i class="fas fa-comments"></i>
                    <div class="dropdown-text">
                      <div class="dropdown-title">SİZDEN GELENLER</div>
                      <div class="dropdown-description">Öneri ve geri bildirimleriniz</div>
                    </div>
                  </a>
                  <a href="etkinlikler.php" class="dropdown-item">
                    <i class="fas fa-calendar-check"></i>
                    <div class="dropdown-text">
                      <div class="dropdown-title">ETKİNLİKLER</div>
                      <div class="dropdown-description">Güncel kurumsal etkinlik bilgileri</div>
                    </div>
                  </a>
                  <a href="duyuru.php" class="dropdown-item">
                    <i class="fas fa-bullhorn"></i>
                    <div class="dropdown-text">
                      <div class="dropdown-title">DUYURULAR</div>
                      <div class="dropdown-description">Resmi güncel duyuru paylaşımları</div>
                    </div>
                  </a>
                </div>
              </div>
            </div>
          </li>
          <li class="nav-dropdown dd-safe">
            <a href="#" class="nav-dropdown-toggle">
              <i class="fas fa-landmark"></i>
              Kaynaklar
            </a>
            <div class="nav-dropdown-menu pull-left">
              <div class="dropdown-content">
                <div class="dropdown-grid">
                  <a href="protokol.php" class="dropdown-item">
                    <i class="fas fa-file-signature"></i>
                    <div class="dropdown-text">
                      <div class="dropdown-title">PROTOKOLLER</div>
                      <div class="dropdown-description">Resmi protokol kayıtları.</div>
                    </div>
                  </a>
                  <a href="dokumanlar.php" class="dropdown-item">
                    <i class="fas fa-file-alt"></i>
                    <div class="dropdown-text">
                      <div class="dropdown-title">DOKÜMANLAR</div>
                      <div class="dropdown-description">Kurumsal doküman arşivi.</div>
                    </div>
                  </a>
                  <a href="mevzuat.php" class="dropdown-item">
                    <i class="fas fa-balance-scale"></i>
                    <div class="dropdown-text">
                      <div class="dropdown-title">MEVZUATLAR</div>
                      <div class="dropdown-description">Güncel mevzuat bilgileri.</div>
                    </div>
                  </a>
                  <a href="egitim.php" class="dropdown-item">
                    <i class="fas fa-graduation-cap"></i>
                    <div class="dropdown-text">
                      <div class="dropdown-title">EĞİTİMLER</div>
                      <div class="dropdown-description">Personel eğitim içerikleri.</div>
                    </div>
                  </a>
                </div>
              </div>
            </div>
          </li>
          <li class="nav-dropdown dd-safe">
            <a href="#" class="nav-dropdown-toggle">
              <i class="fas fa-file-alt"></i>
              Diğer
            </a>
            <div class="nav-dropdown-menu pull-left">
              <div class="dropdown-content">
                <div class="dropdown-grid">
                  <a href="anketler.php" class="dropdown-item">
                    <i class="fas fa-poll"></i>
                    <div class="dropdown-text">
                      <div class="dropdown-title">ANKETLER</div>
                      <div class="dropdown-description">Katılabileceğiniz güncel anketler</div>
                    </div>
                  </a>
                  <a href="yardimci_linkler.php" class="dropdown-item">
                    <i class="fas fa-link"></i>
                    <div class="dropdown-text">
                      <div class="dropdown-title">YARDIMCI LİNKLER</div>
                      <div class="dropdown-description">İş akışı için önemli bağlantılar</div>
                    </div>
                  </a>
                  <a href="vefat_bilgisi.php" class="dropdown-item">
                    <i class="fas fa-ribbon" style="color: #222"></i>
                    <div class="dropdown-text">
                      <div class="dropdown-title">VEFAT EDEN BİLGİSİ</div>
                      <div class="dropdown-description">Vefat eden değerli çalışanlarımız</div>
                    </div>
                  </a>
                  <a href="dogum.php" class="dropdown-item">
                    <i class="fas fa-birthday-cake"></i>
                    <div class="dropdown-text">
                      <div class="dropdown-title">DOĞUM GÜNÜ BİLGİSİ</div>
                      <div class="dropdown-description">Bugün doğum günü olan personeller</div>
                    </div>
                  </a>
                </div>
              </div>
            </div>
          </li>
        </ul>

        <div class="nav-right">
          <div class="profile-dropdown">
            <button class="profile-btn" id="profileBtn" type="button" aria-expanded="false" aria-haspopup="true">
              <img src="<?php echo $session_foto; ?>" alt="Profil" class="profile-img" />
            </button>
            <div class="profile-menu" id="profileMenu">
              <div class="profile-info">
                <img src="<?php echo $session_foto; ?>" alt="Profil" class="profile-menu-img" />
                <div class="profile-details">
                  <span class="profile-name"><?php echo $session_ad . " " . $session_soyad; ?></span>
                  <span class="profile-role">Personel</span>
                </div>
              </div>
             <ul class="profile-menu-list" style="list-style: none; padding: 0; margin: 0;">
  <li>
    <a href="email_degistir.php" class="profile-menu-item">
      <i class="fas fa-envelope"></i><span>Email Değiştir</span>
    </a>
  </li>
  <li>
    <a href="sifre_degistir.php" class="profile-menu-item">
      <i class="fas fa-key"></i><span>Şifre Değiştir</span>
    </a>
  </li>
  <li>
    <a href="oturum_bilgileri.php" class="profile-menu-item">
      <i class="fas fa-history"></i><span>Oturum Bilgileri</span>
    </a>
  </li>
  <li>
    <a href="cikis.php" class="profile-menu-item logout">
      <i class="fas fa-sign-out-alt"></i><span>Çıkış Yap</span>
    </a>
  </li>
</ul>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <div class="menu-backdrop" id="menuBackdrop"></div>
    
    <div class="side-menu" id="sideMenu">
      <div class="side-menu-header">
        <div class="side-menu-profile">
          <img src="<?php echo $session_foto; ?>" alt="Profil" class="side-menu-profile-img" />
          <div class="side-menu-profile-details">
            <span class="side-menu-profile-name"><?php echo $session_ad . " " . $session_soyad; ?></span>
            <span class="side-menu-profile-email"><?php echo $session_email; ?></span>
          </div>
        </div>
        <button class="close-menu-btn" type="button" aria-label="Menüyü kapat">&times;</button>
      </div>
      <ul class="side-menu-links">
        <li><a href="ana_sayfa.php"><i class="fas fa-home"></i> Anasayfa</a></li>
        <li><a href="sizden_gelenler.php"><i class="fas fa-comments"></i> Sizden Gelenler</a></li>
        <li><a href="etkinlikler.php"><i class="fas fa-calendar-check"></i> Etkinlikler</a></li>
        <li><a href="duyuru.php"><i class="fas fa-bullhorn"></i> Duyurular</a></li>
        <li><a href="protokol.php"><i class="fas fa-file-signature"></i> Protokoller</a></li>
        <li><a href="dokumanlar.php"><i class="fas fa-file-alt"></i> Dokümanlar</a></li>
        <li><a href="mevzuat.php"><i class="fas fa-balance-scale"></i> Mevzuatlar</a></li>
        <li><a href="egitim.php"><i class="fas fa-graduation-cap"></i> Eğitimler</a></li>
        <li><a href="videolar.php"><i class="fas fa-video"></i> Videolar</a></li>
        <li><a href="anketler.php"><i class="fas fa-poll"></i> Anketler</a></li>
        <li><a href="yardimci_linkler.php"><i class="fas fa-link"></i> Yardımcı Linkler</a></li>
        <li><a href="vefat_bilgisi.php"><i class="fas fa-ribbon"></i> Vefat Eden Bilgisi</a></li>
        <li><a href="dogum.php"><i class="fas fa-birthday-cake"></i> Doğum Günü Bilgisi</a></li>
        <hr class="my-2 bg-secondary opacity-25">
       <li><a href="email_degistir.php"><i class="fas fa-envelope"></i> Email Değiştir</a></li>
<li><a href="sifre_degistir.php"><i class="fas fa-key"></i> Şifre Değiştir</a></li>
<li><a href="oturum_bilgileri.php"><i class="fas fa-history"></i> Oturum Bilgileri</a></li>
        <li><a href="cikis.php" class="text-danger" onclick="try{sessionStorage.setItem('pp_internal_nav','1')}catch(e){}"><i class="fas fa-sign-out-alt"></i> Çıkış Yap</a></li>
      </ul>
    </div>