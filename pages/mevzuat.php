<?php
require_once "../pages/baglan.php"; // baglan.php dosyanızın gerçek yoluna göre bu satırı düzenleyin

$kategoriAdi = "Mevzuatlar";

$stmt = $db->prepare("SELECT id, baslik, aciklama, kategori, alt_kategori, ikon, dosya_yolu, resmi_sayfa, boyut, tarih FROM kaynaklar WHERE kategori = :kategori ORDER BY tarih DESC");
$stmt->execute(["kategori" => $kategoriAdi]);
$mevzuatlar = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Alt kategori kodunu ekrandaki Türkçe etiketle eşliyoruz
$altKategoriMap = [
    "genel"      => "Genel Mevzuatlar",
    "memur"      => "Memur Mevzuatları",
    "sozlesmeli" => "Sözleşmeli Memur Mevzuatları",
    "isci"       => "İşçi Mevzuatları",
];
?>
<!doctype html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mevzuatlar - Gebze Belediyesi Personel Portalı</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
    <link rel="stylesheet" href="../CSS/mevzuat.style.css" />
    <link rel="stylesheet" href="../CSS/footer.css" />
    <link rel="stylesheet" href="../CSS/navbar.css" />
  </head>
  <body>
    <nav class="navbar">
      <div class="nav-container">
        <div class="nav-left">
          <button class="mobile-menu-toggle" aria-label="Menüyü aç">
            <i class="fas fa-bars"></i>
          </button>
          <a href="ana_sayfa.html" class="logo-container">
            <img src="../images/logo(2).png" alt="Gebze Belediyesi Logosu" class="logo-img" />
          </a>
        </div>

        <ul class="nav-links">
          <li class="nav-dropdown">
            <a href="ana_sayfa.html"> <i class="fas fa-home"></i> Anasayfa </a>
          </li>
          <li>
            <a href="videolar.html"><i class="fas fa-video"></i>Videolar</a>
          </li>

          <li class="nav-dropdown dd-safe">
            <a href="#" class="nav-dropdown-toggle">
              <i class="fas fa-newspaper"></i>
              Etkinlikler
            </a>
            <div class="nav-dropdown-menu pull-left">
              <div class="dropdown-content">
                <div class="dropdown-grid">
                  <a href="sizden_gelenler.html" class="dropdown-item">
                    <i class="fas fa-comments"></i>
                    <div class="dropdown-text">
                      <div class="dropdown-title">SİZDEN GELENLER</div>
                      <div class="dropdown-description">Talep ve öneri merkezi</div>
                    </div>
                  </a>
                  <a href="etkinlikler.html" class="dropdown-item">
                    <i class="fas fa-calendar-check"></i>
                    <div class="dropdown-text">
                      <div class="dropdown-title">ETKİNLİKLER</div>
                      <div class="dropdown-description">Kurumsal etkinlik takvimi</div>
                    </div>
                  </a>
                  <a href="duyuru.html" class="dropdown-item">
                    <i class="fas fa-bullhorn"></i>
                    <div class="dropdown-text">
                      <div class="dropdown-title">DUYURULAR</div>
                      <div class="dropdown-description">Güncel duyuru ve arşivi</div>
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
                    <i class="fas fa-comments"></i>
                    <div class="dropdown-text">
                      <div class="dropdown-title">DOKÜMANLAR</div>
                      <div class="dropdown-description">Kurumsal doküman arşivi.</div>
                    </div>
                  </a>
                  <a href="mevzuat.php" class="dropdown-item">
                    <i class="fas fa-calendar-check"></i>
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
                  <a href="anketler.html" class="dropdown-item">
                    <i class="fas fa-poll"></i>
                    <div class="dropdown-text">
                      <div class="dropdown-title">ANKETLER</div>
                      <div class="dropdown-description">Katılabileceğiniz güncel anketler</div>
                    </div>
                  </a>
                  <a href="yardimci_linkler.html" class="dropdown-item">
                    <i class="fas fa-link"></i>
                    <div class="dropdown-text">
                      <div class="dropdown-title">YARDIMCI LİNKLER</div>
                      <div class="dropdown-description">İş akışı için önemli bağlantılar</div>
                    </div>
                  </a>
                  <a href="vefat_bilgisi.html" class="dropdown-item">
                    <i class="fas fa-ribbon" style="color: #222"></i>
                    <div class="dropdown-text">
                      <div class="dropdown-title">VEFAT EDEN BİLGİSİ</div>
                      <div class="dropdown-description">Vefat eden değerli çalışanlarımız</div>
                    </div>
                  </a>
                  <a href="dogum.html" class="dropdown-item">
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
            <button class="profile-btn" id="profileBtn">
              <img src="../images/login/login.jpg" alt="Profil" class="profile-img" />
            </button>
            <div class="profile-menu" id="profileMenu">
              <div class="profile-info">
                <img src="../images/login/login.jpg" alt="Profil" class="profile-menu-img" />
                <div class="profile-details">
                  <span class="profile-name">Kullanıcı Adı</span>
                  <span class="profile-role">Personel</span>
                </div>
              </div>
              <ul class="profile-menu-list">
                <li>
                  <a href="#" class="profile-menu-item"
                    ><i class="fas fa-user"></i><span>Profilim</span></a
                  >
                </li>
                <li>
                  <a href="#" class="profile-menu-item"
                    ><i class="fas fa-cog"></i><span>Ayarlar</span></a
                  >
                </li>
                <li>
                  <a href="#" class="profile-menu-item logout"
                    ><i class="fas fa-sign-out-alt"></i><span>Çıkış Yap</span></a
                  >
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
          <img src="../images/login/login.jpg" alt="Profil" class="side-menu-profile-img" />
          <div class="side-menu-profile-details">
            <span class="side-menu-profile-name">Kullanıcı Adı</span>
            <span class="side-menu-profile-email">personel@gebze.bel.tr</span>
          </div>
        </div>
        <button class="close-menu-btn" aria-label="Menüyü kapat">&times;</button>
      </div>
      <ul class="side-menu-links">
        <li>
          <a href="ana_sayfa.html"><i class="fas fa-home"></i> Anasayfa</a>
        </li>
        <li>
          <a href="sizden_gelenler.html"><i class="fas fa-comments"></i> Sizden Gelenler</a>
        </li>
        <li>
          <a href="etkinlikler.html"><i class="fas fa-calendar-check"></i> Etkinlikler</a>
        </li>
        <li>
          <a href="duyuru.html"><i class="fas fa-bullhorn"></i> Duyurular</a>
        </li>
        <li>
          <a href="protokol.php"><i class="fas fa-file-signature"></i> Protokoller</a>
        </li>
        <li>
          <a href="dokumanlar.php"><i class="fas fa-comments"></i> Dokümanlar</a>
        </li>
        <li>
          <a href="mevzuat.php"><i class="fas fa-calendar-check"></i> Mevzuatlar</a>
        </li>
        <li>
          <a href="egitim.php"><i class="fas fa-graduation-cap"></i> Eğitimler</a>
        </li>
        <li>
          <a href="videolar.html"><i class="fas fa-video"></i> Videolar</a>
        </li>
        <li>
          <a href="anketler.html"><i class="fas fa-poll"></i> Anketler</a>
        </li>
        <li>
          <a href="yardimci_linkler.html"><i class="fas fa-link"></i> Yardımcı Linkler</a>
        </li>
        <li>
          <a href="vefat_bilgisi.html"><i class="fas fa-ribbon"></i>Vefat Eden Bilgisi</a>
        </li>
        <li>
          <a href="dogum.html"><i class="fas fa-birthday-cake"></i>Doğum Günü Bilgisi</a>
        </li>
      </ul>
    </div>
    <div class="breadcrumb-section">
      <div class="nav-container">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="ana_sayfa.html"><i class="fas fa-home"></i> Anasayfa</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page" id="breadcrumbTitle">
              Mevzuatlar
            </li>
          </ol>
        </nav>
      </div>
    </div>

    <div class="main-container">
      <!-- Sayfa Başlığı -->
      <header class="page-header">
        <div class="content">
          <h1>Mevzuatlar</h1>
          <p>Kurumsal işleyişi düzenleyen tüm mevzuatları bu sayfada görüntüleyebilirsiniz</p>
        </div>
      </header>

      <!-- Kontroller -->
      <div class="controls-section">
        <div class="search-box">
          <i class="fas fa-search search-icon"></i>
          <input type="text" class="search-input" placeholder="Mevzuat ara..." id="searchInput" />
        </div>

        <div class="filter-buttons">
          <button class="filter-btn" data-filter="protocol">Protokoller</button>
          <button class="filter-btn" data-filter="document">Dökümanlar</button>
          <button class="filter-btn active" data-filter="regulation">Mevzuatlar</button>
          <button class="filter-btn" data-filter="training">Eğitimler</button>
        </div>
      </div>
      <div class="results-header">
        <select class="sort-dropdown" id="sortSelect">
          <option value="all">Tüm Mevzuatlar</option>
          <option value="genel">Genel Mevzuatlar</option>
          <option value="memur">Memur Mevzuatları</option>
          <option value="sozlesmeli">Sözleşmeli Memur Mevzuatları</option>
          <option value="isci">İşçi Mevzuatları</option>
        </select>
      </div>

      <!-- Mevzuatlar Grid -->
      <div class="documents-grid" id="documentsGrid">
        <?php if (count($mevzuatlar) > 0): ?>
          <?php foreach ($mevzuatlar as $row):
              $altKod = !empty($row['alt_kategori']) ? $row['alt_kategori'] : "genel";
              $altAd  = $altKategoriMap[$altKod] ?? "Genel Mevzuatlar";
              $ikon   = !empty($row['ikon']) ? $row['ikon'] : "fa-folder-open";
              $tarihFormat = !empty($row['tarih']) ? date("d.m.Y", strtotime($row['tarih'])) : "";
          ?>
          <div class="document-card" data-category="regulation" data-type="<?= htmlspecialchars($altKod) ?>">
            <div class="document-header">
              <div class="document-icon">
                <i class="fas <?= htmlspecialchars($ikon) ?>"></i>
              </div>
              <div class="document-info">
                <h3 class="document-title"><?= htmlspecialchars($row['baslik']) ?></h3>
                <span class="document-category"><?= htmlspecialchars($altAd) ?></span>
              </div>
            </div>
            <p class="document-description">
              <?= nl2br(htmlspecialchars($row['aciklama'])) ?>
            </p>
            <a href="#" class="read-more-btn">Devamını Oku</a>
            <div class="document-meta">
              <div class="document-size">
                <i class="fas fa-file-pdf"></i>
                PDF • <?= htmlspecialchars($row['boyut']) ?>
              </div>
              <div class="document-date">
                <i class="fas fa-calendar-alt"></i>
                <?= $tarihFormat ?>
              </div>
            </div>
            <div class="download-section">
              <?php if (!empty($row['resmi_sayfa'])): ?>
              <button
                class="preview-btn"
                onclick="previewDocument('<?= htmlspecialchars($row['resmi_sayfa'], ENT_QUOTES) ?>')"
              >
                Resmi Sayfa
              </button>
              <?php endif; ?>
              <?php if (!empty($row['dosya_yolu'])): ?>
              <button
                class="preview-btn2"
                onclick="previewDocument('<?= htmlspecialchars($row['dosya_yolu'], ENT_QUOTES) ?>')"
              >
                Döküman
              </button>
              <?php endif; ?>
            </div>
          </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p>Henüz eklenmiş mevzuat bulunmuyor.</p>
        <?php endif; ?>
      </div>
    </div>
    <footer>
      <div class="container">
        <div class="footer-content">
          <img src="../images/logo(2).png" class="footer-logo" alt="Gebze Belediyesi" />
          <p><i class="fas fa-phone"></i> (0262) 123 45 67</p>
          <p><i class="fas fa-envelope"></i> bilgiislem@gebze.bel.tr</p>
          <div class="social-icons mt-3">
            <a href="https://www.facebook.com/gebzebelediye/?locale=tr_TR"
              ><i class="fab fa-facebook-f"></i
            ></a>
            <a
              href="https://x.com/gebze_belediye?ref_src=twsrc%5Egoogle%7Ctwcamp%5Eserp%7Ctwgr%5Eauthor"
              ><i class="fab fa-twitter"></i
            ></a>
            <a href="https://www.instagram.com/gebze_belediyesi/?hl=tr"
              ><i class="fab fa-instagram"></i
            ></a>
            <a href="https://www.youtube.com/@gebzebelediyesi7295"
              ><i class="fab fa-youtube"></i
            ></a>
            <a href="https://www.linkedin.com/company/gebze-belediyesi/posts/?feedView=all"
              ><i class="fab fa-linkedin-in"></i
            ></a>
          </div>
        </div>
        <div class="footer-bottom">
          <p>&copy; 2025 Gebze Belediyesi - Bilgi İşlem Müdürlüğü | Tüm Hakları Saklıdır</p>
        </div>
      </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../JS/mevzuat.script.js"></script>
  </body>
</html>
