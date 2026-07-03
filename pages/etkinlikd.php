<?php
include("baglan.php");
$etkinlikId = isset($_GET["id"]) ? (int)$_GET["id"] : 1;
$etkinlik = dbFetchOne($db, "SELECT * FROM etkinlikler WHERE id = ?", [$etkinlikId]);
?>
<!doctype html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Etkinlik Detayı - Gebze Belediyesi Personel Portalı</title>
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
<?php $pageCss = "etkinlik_detay.style.css"; include "includes/site-styles.php"; ?>
  </head>
  <body>
    <?php include "includes/header-nav.php"; ?>
    <?php $pageTitle = "Etkinlik Detayı"; include "includes/breadcrumb.php"; ?>
<div class="content-area">
      <div class="container">
        <div class="row">
          <div class="col-lg-8">
            <article class="news-detail-card">
              <div class="article-header">
                <h1 class="article-title" id="articleTitle">Stajyer Oryantasyon Eğitimi</h1>
                <div class="article-meta">
                  <div class="meta-item">
                    <i class="fas fa-calendar-alt"></i>
                    <span id="articleDate">Tarih</span>
                  </div>
                  <div class="meta-item">
                    <i class="fas fa-eye"></i>
                    <span id="articleViews">0</span> görüntülenme
                  </div>
                  <div class="meta-item">
                    <i class="fas fa-user"></i>
                    <span>Gebze Belediyesi</span>
                  </div>
                </div>
              </div>

              <!-- Ana resim ve küçük resimler slider'ı -->
              <div class="article-image-section">
                <div class="article-image-container">
                  <img
                    src="../images/stajyer-o-renci-oryantasyonu_2177.jpg"
                    alt=""
                    class="article-image"
                    id="mainArticleImage"
                  />
                </div>

                <!-- Küçük resimler slider'ı -->
                <div class="article-gallery-slider">
                  <div class="gallery-container">
                    <div class="gallery-track" id="galleryTrack">
                      <div
                        class="gallery-item active"
                        data-image="../images/stajyer-donem-sonu-etk-nl_6028.jpg"
                      >
                        <img src="../images/stajyer-donem-sonu-etk-nl_6028.jpg" alt="Eğitim 1" />
                      </div>
                      <div
                        class="gallery-item"
                        data-image="../images/personel-ftar-program_109.jpg"
                      >
                        <img src="../images/personel-ftar-program_109.jpg" alt="Eğitim 2" />
                      </div>
                      <div
                        class="gallery-item"
                        data-image="../images/8-mart-dunya-kadinlar-gunu-programi_8383.jpg"
                      >
                        <img
                          src="../images/8-mart-dunya-kadinlar-gunu-programi_8383.jpg"
                          alt="Eğitim 3"
                        />
                      </div>
                      <div
                        class="gallery-item"
                        data-image="../images/on-odeme-kred-ve-avans-e-t-m_2065.jpeg"
                      >
                        <img
                          src="../images/on-odeme-kred-ve-avans-e-t-m_2065.jpeg"
                          alt="Eğitim 4"
                        />
                      </div>
                      <div
                        class="gallery-item"
                        data-image="../images/marmara-kar-yer-fuari-kocael-2024_9790.jpg"
                      >
                        <img
                          src="../images/marmara-kar-yer-fuari-kocael-2024_9790.jpg"
                          alt="Eğitim 5"
                        />
                      </div>
                      <div
                        class="gallery-item"
                        data-image="../images/of-s-programlari-e-t-m_2683.jpeg"
                      >
                        <img src="../images/of-s-programlari-e-t-m_2683.jpeg" alt="Eğitim 6" />
                      </div>
                      <div class="gallery-item" data-image="../images/lkyardim-e-t-m_1307.jpeg">
                        <img src="../images/lkyardim-e-t-m_1307.jpeg" alt="Eğitim 6" />
                      </div>
                      <div
                        class="gallery-item"
                        data-image="../images/stajyer-f-lm-okuma-programi_3604.jpg"
                      >
                        <img src="../images/stajyer-f-lm-okuma-programi_3604.jpg" alt="Eğitim 6" />
                      </div>
                      <div
                        class="gallery-item"
                        data-image="../images/3-aralik-dunya-engell-ler-gunu-personel-yeme_9554.jpg"
                      >
                        <img
                          src="../images/3-aralik-dunya-engell-ler-gunu-personel-yeme_9554.jpg"
                          alt="Eğitim 6"
                        />
                      </div>
                      <div
                        class="gallery-item"
                        data-image="../images/stajyer-o-renci-oryantasyonu_2177.jpg"
                      >
                        <img src="../images/stajyer-o-renci-oryantasyonu_2177.jpg" alt="Eğitim 6" />
                      </div>
                      <div
                        class="gallery-item"
                        data-image="../images/24-kas-m-o-retmenler-gunu_2947.jpg"
                      >
                        <img src="../images/24-kas-m-o-retmenler-gunu_2947.jpg" alt="Eğitim 6" />
                      </div>
                      <div class="gallery-item" data-image="../images/futbol-turnuvasi_9646.jpg">
                        <img src="../images/futbol-turnuvasi_9646.jpg" alt="Eğitim 6" />
                      </div>
                      <div
                        class="gallery-item"
                        data-image="../images/personel-p-kn-k-programi_9118.jpg"
                      >
                        <img src="../images/personel-p-kn-k-programi_9118.jpg" alt="Eğitim 6" />
                      </div>
                      <div
                        class="gallery-item"
                        data-image="../images/personel-bayramla-ma-programi_5965.jpg"
                      >
                        <img
                          src="../images/personel-bayramla-ma-programi_5965.jpg"
                          alt="Eğitim 6"
                        />
                      </div>
                      <div
                        class="gallery-item"
                        data-image="../images/personel-ftar-program_109.jpg"
                      >
                        <img src="../images/personel-ftar-program_109.jpg" alt="Eğitim 6" />
                      </div>
                    </div>
                  </div>
                  <div class="gallery-controls">
                    <button class="gallery-btn prev" id="galleryPrevBtn">
                      <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="gallery-btn next" id="galleryNextBtn">
                      <i class="fas fa-chevron-right"></i>
                    </button>
                  </div>
                </div>
              </div>

              <div class="article-content">
                <div class="article-body" id="articleBody">
                  Müdürlüğümüz koordinatörlüğünde yürütülen çalışmalar kapsamında, kurumumuzun
                  çeşitli birimlerinde görev yapan personellerin ihtiyaç duyduğu eğitimler
                  titizlikle planlanarak başarıyla tamamlanmıştır. Bu süreçte, personelimizin
                  mesleki gelişimlerine katkı sağlamak ve hizmet kalitesini artırmak amacıyla
                  gerekli içerikler doğrultusunda eğitim programları etkili bir şekilde
                  uygulanmıştır.
                </div>
              </div>

              <div class="article-actions">
                <div class="back-button">
                  <a href="etkinlikler.php" class="btn-back">
                    <i class="fas fa-arrow-left"></i>
                    Geri Dön
                  </a>
                </div>
              </div>
            </article>
          </div>

          <div class="col-lg-4">
            <div class="other-departments-card">
              <div class="departments-header">
                <h3 class="departments-title">
                  <i class="fas fa-building"></i>
                  Diğer Müdürlükler
                </h3>
              </div>

              <!-- SLIDER: 6 haber için güncellenmiş yapı -->
              <div class="departments-slider">
                <div class="departments-track" id="deptTrack">
                  <!-- SAYFA 1 - 6 Haber -->
                  <div class="department-item">
                    <div class="other-news-item d-flex mb-3">
                      <img
                        src="../images/stajyer-donem-sonu-etk-nl_6028.jpg"
                        class="other-news-img me-3"
                        alt="Fen İşleri"
                      />
                      <div class="other-news-content">
                        <h5 class="other-news-title">Stajyer Dönem Sonu Etkinliği</h5>
                        <p class="other-news-description">
                          Köşklü Çeşme Mahallesi, 553 Sokak'ın üstyapısını.....
                        </p>
                      </div>
                    </div>

                    <div class="other-news-item d-flex mb-3">
                      <img
                        src="../images/pesonel-ftar-programi_3732.jpg"
                        class="other-news-img me-3"
                        alt="Park ve Bahçeler"
                      />
                      <div class="other-news-content">
                        <h5 class="other-news-title">Personel İftar Programı</h5>
                        <p class="other-news-description">
                          park ve bahçelerde bakım çalışmalarına devam ediyor.
                        </p>
                      </div>
                    </div>
                    <div class="other-news-item d-flex mb-3">
                      <img
                        src="../images/8-mart-dunya-kadinlar-gunu-programi_8383.jpg"
                        class="other-news-img me-3"
                        alt="Temizlik İşleri"
                      />
                      <div class="other-news-content">
                        <h5 class="other-news-title">8 Mart Dünya Kadınlar Günü Programı</h5>
                        <p class="other-news-description">
                          Şehir genelinde kapsamlı temizlik çalışmaları başlatıldı.
                        </p>
                      </div>
                    </div>

                    <div class="other-news-item d-flex mb-3">
                      <img
                        src="../images/stajyer-oryantasyon-e-t-m_8697.jpg"
                        class="other-news-img me-3"
                        alt="Veteriner İşleri"
                      />
                      <div class="other-news-content">
                        <h5 class="other-news-title">Stajyer Oryantasyon Eğitimi</h5>
                        <p class="other-news-description">
                          Sokak hayvanlarının için yeni projeler hayata geçiriliyor.
                        </p>
                      </div>
                    </div>

                    <div class="other-news-item d-flex mb-3">
                      <img
                        src="../images/on-odeme-kred-ve-avans-e-t-m_2065.jpeg"
                        class="other-news-img me-3"
                        alt="Veteriner İşleri"
                      />
                      <div class="other-news-content">
                        <h5 class="other-news-title">Ön ödeme-Kredi Avans Eğitim Programı</h5>
                        <p class="other-news-description">
                          Sokak hayvanlarının için yeni projeler hayata geçiriliyor.
                        </p>
                      </div>
                    </div>

                    <div class="other-news-item d-flex mb-3">
                      <img
                        src="../images/marmara-kar-yer-fuari-kocael-2024_9790.jpg"
                        class="other-news-img me-3"
                        alt="Zabıta"
                      />
                      <div class="other-news-content">
                        <h5 class="other-news-title">Marmara Karıyer Fuarı Kocaeli 2024</h5>
                        <p class="other-news-description">
                          İşyerleri ve sokak satıcıları düzenli olarak denetleniyor.
                        </p>
                      </div>
                    </div>
                  </div>

                  <!-- SAYFA 2 - 6 Haber -->
                  <div class="department-item">
                    <div class="other-news-item d-flex mb-3">
                      <img
                        src="../images/of-s-programlari-e-t-m_2683.jpeg"
                        class="other-news-img me-3"
                        alt="Bilgi İşlem"
                      />
                      <div class="other-news-content">
                        <h5 class="other-news-title">Ofis Programları Eğitim Programı</h5>
                        <p class="other-news-description">
                          Stajyerler için oryantasyon programı düzenlendi.
                        </p>
                      </div>
                    </div>

                    <div class="other-news-item d-flex mb-3">
                      <img
                        src="../images/lkyardim-e-t-m_1307.jpeg"
                        class="other-news-img me-3"
                        alt="Fen İşleri"
                      />
                      <div class="other-news-content">
                        <h5 class="other-news-title">İlkyardım Eğitim Programı</h5>
                        <p class="other-news-description">
                          Kent genelinde altyapı çalışmaları devam ediyor.
                        </p>
                      </div>
                    </div>
                    <div class="other-news-item d-flex mb-3">
                      <img
                        src="../images/stajyer-f-lm-okuma-programi_3604.jpg"
                        class="other-news-img me-3"
                        alt="Park Bahçe"
                      />
                      <div class="other-news-content">
                        <h5 class="other-news-title">Stajyer Film-okuma Programı</h5>
                        <p class="other-news-description">
                          Yeni peyzaj düzenlemeleri tamamlanıyor.
                        </p>
                      </div>
                    </div>

                    <div class="other-news-item d-flex mb-3">
                      <img
                        src="../images/3-aralik-dunya-engell-ler-gunu-personel-yeme_9554.jpg"
                        class="other-news-img me-3"
                        alt="Temizlik İşleri"
                      />
                      <div class="other-news-content">
                        <h5 class="other-news-title">
                          3 Aralık Dünya Engelliler Günü Personel Yemeği
                        </h5>
                        <p class="other-news-description">
                          Çevresel temizlik kampanyaları sürdürülüyor.
                        </p>
                      </div>
                    </div>

                    <div class="other-news-item d-flex mb-3">
                      <img
                        src="../images/stajyer-o-renci-oryantasyonu_2177.jpg"
                        class="other-news-img me-3"
                        alt="Veteriner"
                      />
                      <div class="other-news-content">
                        <h5 class="other-news-title">Stajyer Öğrenci Oryantasyonu</h5>
                        <p class="other-news-description">
                          Sokak hayvanları için aşı kampanyası devam ediyor.
                        </p>
                      </div>
                    </div>

                    <div class="other-news-item d-flex mb-3">
                      <img
                        src="../images/24-kas-m-o-retmenler-gunu_2947.jpg"
                        class="other-news-img me-3"
                        alt="Piknik"
                      />
                      <div class="other-news-content">
                        <h5 class="other-news-title">24 Kasım Öğretmenler Günü Programı</h5>
                        <p class="other-news-description">
                          Doğal ortamda personelimiz için düzenlenen keyifli..
                        </p>
                      </div>
                    </div>
                  </div>
                  <!-- SAYFA 3 - 6 Haber -->
                  <div class="department-item">
                    <div class="other-news-item d-flex mb-3">
                      <img
                        src="../images/futbol-turnuvasi_9646.jpg"
                        class="other-news-img me-3"
                        alt="Bayramlaşma"
                      />
                      <div class="other-news-content">
                        <h5 class="other-news-title">Müdürlükler Arası Futbol Turnuvası</h5>
                        <p class="other-news-description">
                          Bayram coşkusunu birlikte yaşadığımız..
                        </p>
                      </div>
                    </div>
                    <div class="other-news-item d-flex mb-3">
                      <img
                        src="../images/personel-p-kn-k-programi_9118.jpg"
                        class="other-news-img me-3"
                        alt="Oryantasyon"
                      />
                      <div class="other-news-content">
                        <h5 class="other-news-title">Personel Piknik Programı</h5>
                        <p class="other-news-description">
                          Yeni dönem stajyer öğrenciler için kapsamlı..
                        </p>
                      </div>
                    </div>

                    <div class="other-news-item d-flex mb-3">
                      <img
                        src="../images/personel-bayramla-ma-programi_5965.jpg"
                        class="other-news-img me-3"
                        alt="Sağlık"
                      />
                      <div class="other-news-content">
                        <h5 class="other-news-title">Personel Bayramlaşma Programı</h5>
                        <p class="other-news-description">
                          İş sağlığı ve güvenliği konularında bilgilendirici eğitim..
                        </p>
                      </div>
                    </div>
                    <div class="other-news-item d-flex mb-3">
                      <img
                        src="../images/personel-ftar-program_109.jpg"
                        class="other-news-img me-3"
                        alt="Teknoloji"
                      />
                      <div class="other-news-content">
                        <h5 class="other-news-title">Personel İftar Programı</h5>
                        <p class="other-news-description">
                          Teknolojik gelişmelere uyum için dijital beceri..
                        </p>
                      </div>
                    </div>
                    <div class="other-news-item d-flex mb-3">
                      <img
                        src="../images/personel-ftar-program_109.jpg"
                        class="other-news-img me-3"
                        alt="Teknoloji"
                      />
                      <div class="other-news-content">
                        <h5 class="other-news-title">Personel İftar Programı</h5>
                        <p class="other-news-description">
                          Teknolojik gelişmelere uyum için dijital beceri..
                        </p>
                      </div>
                    </div>
                    <div class="other-news-item d-flex mb-3">
                      <img
                        src="../images/personel-ftar-program_109.jpg"
                        class="other-news-img me-3"
                        alt="Teknoloji"
                      />
                      <div class="other-news-content">
                        <h5 class="other-news-title">Personel İftar Programı</h5>
                        <p class="other-news-description">
                          Teknolojik gelişmelere uyum için dijital beceri..
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Nokta göstergeleri ile güncellenen sayfalandırma -->
              <div class="departments-pagination">
                <button class="pagination-btn prev-btn" id="prevDeptBtn" title="Önceki müdürlük">
                  <i class="fas fa-chevron-left"></i>
                </button>

                <!-- Nokta göstergeleri -->
                <div class="pagination-dots" id="paginationDots">
                  <!-- JavaScript ile dinamik olarak oluşturulacak -->
                </div>

                <button class="pagination-btn next-btn" id="nextDeptBtn" title="Sonraki müdürlük">
                  <i class="fas fa-chevron-right"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include "includes/footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../JS/etkinlik_detay.script.js"></script>
      <script src="../JS/navbar.js"></script>
  </body>
</html>
