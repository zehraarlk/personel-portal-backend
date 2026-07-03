<?php
include("baglan.php");
$kayitId = isset($_GET["id"]) ? (int)$_GET["id"] : 1;
$kayit = dbFetchOne($db, "SELECT * FROM sizden_gelenler WHERE id = ?", [$kayitId]);
?>
<!doctype html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Haber Detayı - Gebze Belediyesi Personel Portalı</title>
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
<?php $pageCss = "sizden_gelen_detay.style.css"; include "includes/site-styles.php"; ?>
  </head>
  <body>
    <?php include "includes/header-nav.php"; ?>
    <?php $pageTitle = "Sizden Gelenler"; include "includes/breadcrumb.php"; ?>
<div class="content-area">
      <div class="container">
        <div class="row">
          <div class="col-lg-8">
            <article class="news-detail-card">
              <div class="article-header">
                <span class="article-category" id="articleCategory"
                  >İnsan Kaynakları Ve Eğitim Müdürlüğü</span
                >
                <h1 class="article-title" id="articleTitle">
                  Eğitim Faaliyetleri Hakkında Bilgilendirme
                </h1>
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
                    src="../images/sizden_gelenler/insan_kaynaklari/nsan-kaynaklar-ve-e-itim-mudurlu-u_5093.jpg"
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
                        data-image="../images/sizden_gelenler/insan_kaynaklari/nsan-kaynaklar-ve-e-itim-mudurlu-u_5093.jpg"
                      >
                        <img
                          src="../images/sizden_gelenler/insan_kaynaklari/nsan-kaynaklar-ve-e-itim-mudurlu-u_5093.jpg"
                          alt="Eğitim 1"
                        />
                      </div>
                      <div
                        class="gallery-item"
                        data-image="../images/sizden_gelenler/fen_isleri/fen-leri-mudurlu-u_3604.jpg"
                      >
                        <img
                          src="../images/sizden_gelenler/fen_isleri/fen-leri-mudurlu-u_3604.jpg"
                          alt="Eğitim 2"
                        />
                      </div>
                      <div
                        class="gallery-item"
                        data-image="../images/sizden_gelenler/park_bahce/park-ve-bahceler-mudurlu-u_1011.jpg"
                      >
                        <img
                          src="../images/sizden_gelenler/park_bahce/park-ve-bahceler-mudurlu-u_1011.jpg"
                          alt="Eğitim 3"
                        />
                      </div>
                      <div
                        class="gallery-item"
                        data-image="../images/sizden_gelenler/temizlik_isleri/temizlik-leri-mudurlu-u_2142.jpg"
                      >
                        <img
                          src="../images/sizden_gelenler/temizlik_isleri/temizlik-leri-mudurlu-u_2142.jpg"
                          alt="Eğitim 4"
                        />
                      </div>
                      <div
                        class="gallery-item"
                        data-image="../images/sizden_gelenler/veteriner_isleri/veteriner-leri-mudurlu-u_1035.jpg"
                      >
                        <img
                          src="../images/sizden_gelenler/veteriner_isleri/veteriner-leri-mudurlu-u_1035.jpg"
                          alt="Eğitim 5"
                        />
                      </div>
                      <div
                        class="gallery-item"
                        data-image="../images/sizden_gelenler/zabita/zab-ta-mudurlu-u_4326.jpg"
                      >
                        <img
                          src="../images/sizden_gelenler/zabita/zab-ta-mudurlu-u_4326.jpg"
                          alt="Eğitim 6"
                        />
                      </div>
                      <div
                        class="gallery-item"
                        data-image="../images/sizden_gelenler/zabita/zab-ta-mudurlu-u_6319.jpg"
                      >
                        <img
                          src="../images/sizden_gelenler/zabita/zab-ta-mudurlu-u_6319.jpg"
                          alt="Eğitim 7"
                        />
                      </div>
                      <div
                        class="gallery-item"
                        data-image="../images/sizden_gelenler/zabita/zab-ta-mudurlu-u_7967.jpg"
                      >
                        <img
                          src="../images/sizden_gelenler/zabita/zab-ta-mudurlu-u_7967.jpg"
                          alt="Eğitim 8"
                        />
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
                  <a href="sizden_gelenler.php" class="btn-back">
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
                        src="../images/sizden_gelenler/fen_isleri/fen-leri-mudurlu-u_3604.jpg"
                        class="other-news-img me-3"
                        alt="Fen İşleri"
                      />
                      <div class="other-news-content">
                        <div class="department-category">Fen İşleri Müdürlüğü</div>
                        <h5 class="other-news-title">Altyapı Çalışmaları Devam Ediyor</h5>
                        <p class="other-news-description">
                          Köşklü Çeşme Mahallesi, 553 Sokak'ın üstyapısını.....
                        </p>
                      </div>
                    </div>

                    <div class="other-news-item d-flex mb-3">
                      <img
                        src="../images/sizden_gelenler/park_bahce/park-ve-bahceler-mudurlu-u_1011.jpg"
                        class="other-news-img me-3"
                        alt="Park ve Bahçeler"
                      />
                      <div class="other-news-content">
                        <div class="department-category">Park ve Bahçeler Müdürlüğü</div>
                        <h5 class="other-news-title">Yeşil Alan Çalışmaları</h5>
                        <p class="other-news-description">
                          park ve bahçelerde bakım çalışmalarına devam ediyor.
                        </p>
                      </div>
                    </div>

                    <div class="other-news-item d-flex mb-3">
                      <img
                        src="../images/sizden_gelenler/temizlik_isleri/temizlik-leri-mudurlu-u_2142.jpg"
                        class="other-news-img me-3"
                        alt="Temizlik İşleri"
                      />
                      <div class="other-news-content">
                        <div class="department-category">Temizlik İşleri Müdürlüğü</div>
                        <h5 class="other-news-title">Temizlik Seferberliği</h5>
                        <p class="other-news-description">
                          Şehir genelinde kapsamlı temizlik çalışmaları başlatıldı.
                        </p>
                      </div>
                    </div>

                    <div class="other-news-item d-flex mb-3">
                      <img
                        src="../images/sizden_gelenler/veteriner_isleri/veteriner-leri-mudurlu-u_1035.jpg"
                        class="other-news-img me-3"
                        alt="Veteriner İşleri"
                      />
                      <div class="other-news-content">
                        <div class="department-category">Veteriner İşleri Müdürlüğü</div>
                        <h5 class="other-news-title">Sokak Hayvanları Projesi</h5>
                        <p class="other-news-description">
                          Sokak hayvanlarının için yeni projeler hayata geçiriliyor.
                        </p>
                      </div>
                    </div>

                    <div class="other-news-item d-flex mb-3">
                      <img
                        src="../images/sizden_gelenler/zabita/zab-ta-mudurlu-u_4326.jpg"
                        class="other-news-img me-3"
                        alt="Zabıta"
                      />
                      <div class="other-news-content">
                        <div class="department-category">Zabıta Müdürlüğü</div>
                        <h5 class="other-news-title">Denetim Çalışmaları</h5>
                        <p class="other-news-description">
                          İşyerleri ve sokak satıcıları düzenli olarak denetleniyor.
                        </p>
                      </div>
                    </div>

                    <div class="other-news-item d-flex mb-3">
                      <img
                        src="../images/sizden_gelenler/fen_isleri/fen-leri-mudurlu-u_5216.jpg"
                        class="other-news-img me-3"
                        alt="Fen İşleri"
                      />
                      <div class="other-news-content">
                        <div class="department-category">Fen İşleri Müdürlüğü</div>
                        <h5 class="other-news-title">Yol Yapım Çalışmaları</h5>
                        <p class="other-news-description">
                          yol yapım ve mevcut yolların onarım çalışmaları
                        </p>
                      </div>
                    </div>
                  </div>

                  <!-- SAYFA 2 - 6 Haber -->
                  <div class="department-item">
                    <div class="other-news-item d-flex mb-3">
                      <img
                        src="../images/sizden_gelenler/insan_kaynaklari/nsan-kaynaklar-ve-e-itim-mudurlu-u_3146.jpeg"
                        class="other-news-img me-3"
                        alt="Bilgi İşlem"
                      />
                      <div class="other-news-content">
                        <div class="department-category">İnsan Kaynakları ve Eğitim Müdürlüğü</div>
                        <h5 class="other-news-title">Oryantasyon Programı</h5>
                        <p class="other-news-description">
                          Stajyerler için oryantasyon programı düzenlendi.
                        </p>
                      </div>
                    </div>

                    <div class="other-news-item d-flex mb-3">
                      <img
                        src="../images/sizden_gelenler/fen_isleri/fen-leri-mudurlu-u_3604.jpg"
                        class="other-news-img me-3"
                        alt="Fen İşleri"
                      />
                      <div class="other-news-content">
                        <div class="department-category">Fen İşleri Müdürlüğü</div>
                        <h5 class="other-news-title">Altyapı Çalışmaları</h5>
                        <p class="other-news-description">
                          Kent genelinde altyapı çalışmaları devam ediyor.
                        </p>
                      </div>
                    </div>

                    <div class="other-news-item d-flex mb-3">
                      <img
                        src="../images/sizden_gelenler/park_bahce/park-ve-bahceler-mudurlu-u_1011.jpg"
                        class="other-news-img me-3"
                        alt="Park Bahçe"
                      />
                      <div class="other-news-content">
                        <div class="department-category">Park ve Bahçeler Müdürlüğü</div>
                        <h5 class="other-news-title">Peyzaj Çalışmaları</h5>
                        <p class="other-news-description">
                          Yeni peyzaj düzenlemeleri tamamlanıyor.
                        </p>
                      </div>
                    </div>

                    <div class="other-news-item d-flex mb-3">
                      <img
                        src="../images/sizden_gelenler/temizlik_isleri/temizlik-leri-mudurlu-u_2142.jpg"
                        class="other-news-img me-3"
                        alt="Temizlik İşleri"
                      />
                      <div class="other-news-content">
                        <div class="department-category">Temizlik İşleri Müdürlüğü</div>
                        <h5 class="other-news-title">Çevre Temizliği</h5>
                        <p class="other-news-description">
                          Çevresel temizlik kampanyaları sürdürülüyor.
                        </p>
                      </div>
                    </div>

                    <div class="other-news-item d-flex mb-3">
                      <img
                        src="../images/sizden_gelenler/veteriner_isleri/veteriner-leri-mudurlu-u_1035.jpg"
                        class="other-news-img me-3"
                        alt="Veteriner"
                      />
                      <div class="other-news-content">
                        <div class="department-category">Veteriner İşleri Müdürlüğü</div>
                        <h5 class="other-news-title">Aşı Kampanyası</h5>
                        <p class="other-news-description">
                          Sokak hayvanları için aşı kampanyası devam ediyor.
                        </p>
                      </div>
                    </div>
                    <div class="other-news-item d-flex mb-3">
                      <img
                        src="../images/sizden_gelenler/veteriner_isleri/veteriner-leri-mudurlu-u_1035.jpg"
                        class="other-news-img me-3"
                        alt="Veteriner"
                      />
                      <div class="other-news-content">
                        <div class="department-category">Veteriner İşleri Müdürlüğü</div>
                        <h5 class="other-news-title">Aşı Kampanyası</h5>
                        <p class="other-news-description">
                          Sokak hayvanları için aşı kampanyası devam ediyor.
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
    <script src="../JS/sizden_gelen_detay.script.js"></script>
      <script src="../JS/navbar.js"></script>
  </body>
</html>
