document.addEventListener("DOMContentLoaded", function () {
  // --- BÜTÜN MENÜLER İÇİN GEREKLİ ELEMENTLER ---
  const profileBtn = document.getElementById("profileBtn");
  const profileMenu = document.getElementById("profileMenu");
  const menuToggleBtn = document.querySelector(".mobile-menu-toggle");
  const sideMenu = document.getElementById("sideMenu");
  const closeMenuBtn = document.querySelector(".close-menu-btn");
  const menuBackdrop = document.getElementById("menuBackdrop");
  const navDropdowns = document.querySelectorAll(".nav-dropdown");

  // --- MOBİL YAN MENÜ SİSTEMİ (NİHAİ DÜZELTME) ---
  // (Yinelenen değişken tanımları kaldırıldı)

  // Bu elementlerin hepsi var mı diye kontrol edelim (hatayı engellemek için)
  if (menuToggleBtn && sideMenu && closeMenuBtn && menuBackdrop) {
    // Menüyü AÇAN olay: Hamburger ikonuna tıklama
    menuToggleBtn.addEventListener("click", function (e) {
      e.stopPropagation(); // Diğer tıklama olaylarıyla çakışmasını engelle
      sideMenu.classList.add("active");
      menuBackdrop.classList.add("active");
    });
    // Menüyü KAPATAN olay 1: 'X' butonuna tıklama
    closeMenuBtn.addEventListener("click", function () {
      sideMenu.classList.remove("active");
      menuBackdrop.classList.remove("active");
    });
    // Menüyü KAPATAN olay 2: Arka plandaki gölgeye tıklama
    menuBackdrop.addEventListener("click", function () {
      sideMenu.classList.remove("active");
      menuBackdrop.classList.remove("active");
    });
  } else {
    // Eğer elementlerden biri bulunamazsa konsola hata yazdır (hata ayıklama için)
    console.error("Mobil menü elementlerinden biri veya birkaçı HTML içinde bulunamadı!");
  }

  // --- PROFİL AÇILIR MENÜ SİSTEMİ ---
  if (profileBtn && profileMenu) {
    profileBtn.addEventListener("click", function (e) {
      e.stopPropagation();
      navDropdowns.forEach((d) => d.classList.remove("active"));
      profileMenu.classList.toggle("show");
      profileBtn.classList.toggle("active");
    });
  }

  // --- MASAÜSTÜ NAVBAR AÇILIR MENÜ SİSTEMİ ---
  navDropdowns.forEach((navDropdown) => {
    const dropdownToggle = navDropdown.querySelector(".nav-dropdown-toggle");
    if (dropdownToggle) {
      dropdownToggle.addEventListener("click", function (e) {
        e.preventDefault();
        e.stopPropagation();

        if (profileMenu) profileMenu.classList.remove("show");
        if (profileBtn) profileBtn.classList.remove("active");
        navDropdowns.forEach((d) => {
          if (d !== navDropdown) d.classList.remove("active");
        });
        navDropdown.classList.toggle("active");
      });
    }
  });
  // --- Sayfada Boş Bir Yere veya ESC Tuşuna Basınca Bütün Menüleri Kapat ---
  function closeAllMenus() {
    if (profileMenu) profileMenu.classList.remove("show");
    if (profileBtn) profileBtn.classList.remove("active");
    navDropdowns.forEach((d) => d.classList.remove("active"));
    if (sideMenu) sideMenu.classList.remove("active");
    if (menuBackdrop) menuBackdrop.classList.remove("active");
  }

  document.addEventListener("click", function (e) {
    let clickedInsideMenu = false;
    const menuElements = [profileBtn, profileMenu, menuToggleBtn, sideMenu, ...navDropdowns];
    for (const el of menuElements) {
      if (el && el.contains(e.target)) {
        clickedInsideMenu = true;
        break;
      }
    }
    if (!clickedInsideMenu) closeAllMenus();
  });
  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") closeAllMenus();
  });

  // --- GALERİ SİSTEMİ ---
  const detayGorseller = [
    {
      resim: "../images/8-mart-dunya-kadinlar-gunu-programi_8383.jpg",
      baslik: "8 Mart Dünya Kadınlar Günü Programı",
      aciklama: "Kadın personelimizin özel günü kutlandı",
    },
    {
      resim: "../images/24-kas-m-o-retmenler-gunu_2947.jpg",
      baslik: "24 Kasım Öğretmenler Günü Ziyareti",
      aciklama: "Öğretmenlerimizi unutmadık",
    },
    {
      resim: "../images/personel-bayramla-ma-programi_5965.jpg",
      baslik: "Personel Bayramlaşma Programı",
      aciklama: "Geleneksel bayram buluşması",
    },
    {
      resim: "../images/personel-ftar-program_109.jpg",
      baslik: "Personel İftar Programı",
      aciklama: "Ramazan birlikteliği",
    },
    {
      resim: "../images/personel-p-kn-k-programi_9118.jpg",
      baslik: "Personel Piknik Programı",
      aciklama: "Doğayla baş başa keyifli anlar",
    },
    {
      resim: "../images/personellerimizin-a-z-ve-di-sa-l-n-onemsiyoruz_7091.jpg",
      baslik: "Ağız ve Diş Sağlığı Taraması",
      aciklama: "Sağlık önceliğimiz",
    },
    {
      resim: "../images/pesonel-ftar-programi_3732.jpg",
      baslik: "İkinci İftar Buluşması",
      aciklama: "Bereketin paylaşıldığı anlar",
    },
    {
      resim: "../images/stajyer-donem-sonu-etk-nl_6028.jpg",
      baslik: "Stajyer Dönem Sonu Etkinliği",
      aciklama: "Başarılı staj dönemi sona erdi",
    },
    {
      resim: "../images/stajyer-f-lm-okuma-programi_3604.jpg",
      baslik: "Stajyer Film Okuma Programı",
      aciklama: "Kültürel gelişim etkinlikleri",
    },
    {
      resim: "../images/stajyer-o-renci-oryantasyonu_2177.jpg",
      baslik: "Stajyer Öğrenci Oryantasyonu",
      aciklama: "Yeni dönem hazırlıkları",
    },
    {
      resim: "../images/stajyer-oryantasyon-e-t-m_8697.jpg",
      baslik: "Stajyer Oryantasyon Eğitimi",
      aciklama: "Kapsamlı eğitim programı",
    },
    {
      resim: "../images/ulusal-da-bisikleti-kupas-yar-lar_128.jpg",
      baslik: "Ulusal Dağ Bisikleti Kupası",
      aciklama: "Heyecan dolu yarışlar",
    },
  ];
  const mainImage = document.getElementById("main-haber-gorsel");
  const mainTitle = document.getElementById("ana-haber-baslik");
  const galleryTrack = document.getElementById("gallery-track");
  const galleryDotsContainer = document.getElementById("gallery-dots");
  const galleryWrapper = document.querySelector(".gallery-wrapper");
  const galleryPrevBtn = document.getElementById("gallery-prev-btn");
  const galleryNextBtn = document.getElementById("gallery-next-btn");

  if (mainImage && mainTitle && galleryTrack && detayGorseller.length > 0) {
    let selectedImageIndex = 0;
    let autoSlideInterval; // Zamanlayıcı değişkenini burada tanımla

    detayGorseller.forEach((gorsel, index) => {
      const thumbnail = document.createElement("div");
      thumbnail.className = "gallery-thumbnail";
      thumbnail.innerHTML = `<img src="${gorsel.resim}" alt="${gorsel.baslik}" class="gallery-thumbnail-image">`;
      thumbnail.dataset.index = index;
      galleryTrack.appendChild(thumbnail);
    });

    const thumbnails = galleryTrack.querySelectorAll(".gallery-thumbnail");

    function updateGallery(newIndex) {
      selectedImageIndex = newIndex;
      const selectedItem = detayGorseller[selectedImageIndex];
      mainImage.style.opacity = "0";
      mainTitle.style.opacity = "0";
      setTimeout(() => {
        mainImage.src = selectedItem.resim;
        mainTitle.textContent = selectedItem.baslik;
        mainImage.style.opacity = "1";
        mainTitle.style.opacity = "1";
      }, 250);

      thumbnails.forEach((thumb) => {
        thumb.classList.toggle("active", parseInt(thumb.dataset.index) === selectedImageIndex);
      });

      updateGalleryButtons();

      // YENİ EKLENEN KOD BAŞLANGICI
      const activeThumbnail = galleryTrack.querySelector(".gallery-thumbnail.active");
      if (activeThumbnail && galleryWrapper) {
        const scrollAmount =
          activeThumbnail.offsetLeft +
          activeThumbnail.offsetWidth / 2 -
          galleryWrapper.offsetWidth / 2;
        galleryWrapper.scrollTo({
          left: scrollAmount,
          behavior: "smooth",
        });
      }

      // YENİ EKLENEN KOD BİTİŞİ
    }
    // Aktif olan küçük resmi bul
    const activeThumbnail = galleryTrack.querySelector(".gallery-thumbnail.active");

    // Eğer aktif küçük resim varsa ve wrapper'ımız da mevcutsa...
    if (activeThumbnail && galleryWrapper) {
      // Aktif resmin ortalanması için gereken kaydırma miktarını hesapla
      const scrollAmount =
        activeThumbnail.offsetLeft +
        activeThumbnail.offsetWidth / 2 -
        galleryWrapper.offsetWidth / 2;

      // Wrapper'ı (yani o kayan şeridi) yumuşak bir animasyonla yeni pozisyonuna kaydır
      galleryWrapper.scrollTo({
        left: scrollAmount,
        behavior: "smooth",
      });
    }
    updateGalleryButtons();
    function updateGalleryButtons() {
      if (galleryPrevBtn && galleryNextBtn) {
        galleryPrevBtn.disabled = selectedImageIndex === 0;
        galleryNextBtn.disabled = selectedImageIndex === detayGorseller.length - 1;
      }
    }
    galleryTrack.addEventListener("click", (e) => {
      const thumbnail = e.target.closest(".gallery-thumbnail");
      if (thumbnail) {
        clearInterval(autoSlideInterval); // Mevcut sayacı temizle
        updateGallery(parseInt(thumbnail.dataset.index));
        startAutoSlide(); // Sayacı yeniden başlat
      }
    });
    if (galleryPrevBtn && galleryNextBtn) {
      galleryPrevBtn.addEventListener("click", (e) => {
        e.preventDefault();
        if (selectedImageIndex > 0) {
          clearInterval(autoSlideInterval);
          updateGallery(selectedImageIndex - 1);
          startAutoSlide();
        }
      });

      galleryNextBtn.addEventListener("click", (e) => {
        e.preventDefault();
        if (selectedImageIndex < detayGorseller.length - 1) {
          clearInterval(autoSlideInterval);
          updateGallery(selectedImageIndex + 1);
          startAutoSlide();
        }
      });
    }

    function startAutoSlide() {
      autoSlideInterval = setInterval(() => {
        // Mevcut index'i bir artır ve galeri dizisinin sonuna gelince başa dön
        selectedImageIndex = (selectedImageIndex + 1) % detayGorseller.length;
        updateGallery(selectedImageIndex);
      }, 4000); // 4 saniyede bir değiştir
    }

    updateGallery(0); // Sayfa yüklendiğinde ilk resmi göster
    startAutoSlide(); // Otomatik geçişi başlat
  }

  // --- DUYURULAR VE SAYFALANDIRMA SİSTEMİ ---
  const tumDuyurular = [
    {
      resim: "../images/stajyer-oryantasyon-e-t-m_8697.jpg",
      baslik: "Stajyer Oryantasyon Eğitimi Tamamlandı",
      aciklama:
        "Belediyemizde yeni döneme başlayan stajyer öğrencilerimiz için oryantasyon programı düzenlendi.",
    },
    {
      resim: "../images/24-kas-m-o-retmenler-gunu_2947.jpg",
      baslik: "Geleneksel Bayramlaşma Töreni Gerçekleşti",
      aciklama:
        "Kurban Bayramı vesilesiyle tüm personelimizin katılımıyla coşkulu bir bayramlaşma programı yapıldı.",
    },
    {
      resim: "../images/8-mart-dunya-kadinlar-gunu-programi_8383.jpg",
      baslik: "8 Mart Dünya Kadınlar Günü Kutlandı",
      aciklama:
        "Belediyemizdeki kadın personelimizin Dünya Kadınlar Günü'nü özel bir etkinlikle kutladık.",
    },
    {
      resim: "../images/personel-ftar-program_109.jpg",
      baslik: "Personel İftar Programı Büyük İlgi Gördü",
      aciklama:
        "Ramazan ayının manevi atmosferinde personelimizle birlikte iftar sofrasında buluştuk.",
    },
    {
      resim: "../images/24-kas-m-o-retmenler-gunu_2947.jpg",
      baslik: "Öğretmenler Günü Unutulmadı",
      aciklama:
        "Gebze'deki öğretmenlerimizi bu özel günlerinde yalnız bırakmadık ve çeşitli ziyaretler gerçekleştirdik.",
    },
    {
      resim: "../images/ulusal-da-bisikleti-kupas-yar-lar_128.jpg",
      baslik: "Dağ Bisikleti Kupası Gebze'de Nefes Kesti",
      aciklama:
        "Türkiye Ulusal Dağ Bisikleti Kupası'nın bir ayağına ev sahipliği yapmanın gururunu yaşadık.",
    },
    {
      resim: "../images/personellerimizin-a-z-ve-di-sa-l-n-onemsiyoruz_7091.jpg",
      baslik: "Personelimize Ağız ve Diş Sağlığı Taraması",
      aciklama:
        "Çalışanlarımızın sağlığını önemsiyor, düzenli olarak sağlık taramaları gerçekleştiriyoruz.",
    },
    {
      resim: "../images/personel-p-kn-k-programi_9118.jpg",
      baslik: "Yaz Sezonunu Piknikle Açtık",
      aciklama:
        "Yoğun çalışma temposuna mola vererek tüm birimlerimizin katıldığı bir piknik organizasyonu düzenledik.",
    },
    {
      resim: "../images/stajyer-f-lm-okuma-programi_3604.jpg",
      baslik: "Stajyerlerle Film Okuma Etkinliği",
      aciklama:
        "Gençlerimizin vizyonunu geliştirmek amacıyla film okuma ve analiz programları düzenliyoruz.",
    },
    {
      resim: "../images/personel-ftar-program_109.jpg",
      baslik: "İkinci Geleneksel İftar Buluşması",
      aciklama:
        "Personelimiz ve aileleriyle birlikte Ramazan ayının bereketini paylaştığımız iftar programımız.",
    },
    {
      resim: "../images/stajyer-donem-sonu-etk-nl_6028.jpg",
      baslik: "Stajyer Dönem Sonu Veda Programı",
      aciklama:
        "Staj dönemini başarıyla tamamlayan öğrencilerimiz için bir veda ve teşekkür etkinliği düzenlendi.",
    },
    {
      resim: "../images/stajyer-oryantasyon-e-t-m_8697.jpg",
      baslik: 'Yeni Stajyerlerimize "Hoş Geldin" Dedik',
      aciklama:
        "Belediye çalışmalarını yakından tanımaları için yeni stajyerlerimize yönelik bir oryantasyon yapıldı.",
    },
    {
      resim: "../images/8-mart-dunya-kadinlar-gunu-programi_8383.jpg",
      baslik: "Kadın Personelimize Özel İkramlar",
      aciklama:
        "8 Mart kapsamında belediyemizdeki tüm kadın çalışanlarımıza küçük bir jest hazırladık.",
    },
    {
      resim: "../images/personel-bayramla-ma-programi_5965.jpg",
      baslik: "Ramazan Bayramı Buluşması",
      aciklama: "Ramazan Bayramı dolayısıyla personelimizle bir araya gelerek bayramlaştık.",
    },
    {
      resim: "../images/personel-ftar-program_109.jpg",
      baslik: "Birlik ve Beraberlik İftarı",
      aciklama: "İftar programımız, personelimiz arasındaki birlik ve beraberliği pekiştirdi.",
    },
  ];
  const duyurularListesi = document.getElementById("duyurular-listesi");
  const prevButton = document.getElementById("prev-page");
  const nextButton = document.getElementById("next-page");
  const sayfaBilgisi = document.getElementById("sayfa-bilgisi");

  if (duyurularListesi && prevButton && nextButton && sayfaBilgisi) {
    let gecerliSayfa = 1;
    const duyuruSayisiSayfaBasi = 5;
    const toplamSayfa = Math.ceil(tumDuyurular.length / duyuruSayisiSayfaBasi);
    function renderDuyurular() {
      duyurularListesi.innerHTML = "";
      const baslangic = (gecerliSayfa - 1) * duyuruSayisiSayfaBasi;
      const bitis = baslangic + duyuruSayisiSayfaBasi;
      const gosterilecekDuyurular = tumDuyurular.slice(baslangic, bitis);
      gosterilecekDuyurular.forEach((duyuru) => {
        const duyuruElementi = `<a href="#" class="duyuru-item"><img src="${duyuru.resim}" alt="${duyuru.baslik}" class="duyuru-resim"><div class="duyuru-icerik"><h3 class="duyuru-baslik">${duyuru.baslik}</h3><p class="duyuru-aciklama">${duyuru.aciklama}</p></div></a>`;
        duyurularListesi.innerHTML += duyuruElementi;
      });
      updatePaginationControls();
    }
    function updatePaginationControls() {
      sayfaBilgisi.textContent = `Sayfa ${gecerliSayfa} / ${toplamSayfa}`;
      prevButton.disabled = gecerliSayfa === 1;
      nextButton.disabled = gecerliSayfa === toplamSayfa;
    }
    prevButton.addEventListener("click", () => {
      if (gecerliSayfa > 1) {
        gecerliSayfa--;
        renderDuyurular();
      }
    });
    nextButton.addEventListener("click", () => {
      if (gecerliSayfa < toplamSayfa) {
        gecerliSayfa++;
        renderDuyurular();
      }
    });
    if (toplamSayfa > 0) renderDuyurular();
  }

  // --- DOĞUM GÜNÜ SİSTEMİ ---
  const personeller = [
    {
      id: 1,
      ad: "Tümay",
      soyad: "AKSAN",
      dogumTarihi: "1995-08-25",
      fotoUrl: "../images/dogum_gunu/37604190820-tumay-aksan_3957.jpg",
    },
    {
      id: 2,
      ad: "Yavuz",
      soyad: "AĞAÇ",
      dogumTarihi: "1992-08-25",
      fotoUrl: "../images/dogum_gunu/32980582726-yavuz-a-ac_5843.jpg",
    },
    {
      id: 3,
      ad: "Zeynep",
      soyad: "YILMAZ",
      dogumTarihi: "1995-08-25",
      fotoUrl: "../images/dogum_gunu/manzara.jpg",
    },
    {
      id: 4,
      ad: "Fatih",
      soyad: "SULTAN MEHMET",
      dogumTarihi: "1990-08-25",
      fotoUrl: "../images/dogum_gunu/Fatih.jpg",
    },
  ];
  const bugun = new Date();
  const bugunAy = String(bugun.getMonth() + 1).padStart(2, "0");
  const bugunGun = String(bugun.getDate()).padStart(2, "0");
  const bugunDoganlar = personeller.filter((p) => {
    const [, ay, gun] = p.dogumTarihi.split("-");
    return ay === bugunAy && gun === bugunGun;
  });
  const listeElementi = document.getElementById("personelListesi");
  const bosMesajElementi = document.getElementById("bosMesaj");

  if (listeElementi && bugunDoganlar.length > 0) {
    bugunDoganlar.forEach((personel) => {
      const cardHtml = `<div class="col"><div class="birthday-card"><img src="${personel.fotoUrl}" class="card-img-top" alt="${personel.ad} ${personel.soyad}"><div class="card-body"><div><h5 class="card-title">${personel.ad} ${personel.soyad}</h5></div></div></div></div>`;
      listeElementi.innerHTML += cardHtml;
    });
  } else if (bosMesajElementi) {
    bosMesajElementi.classList.remove("d-none");
  }
});
document.addEventListener("DOMContentLoaded", () => {
  const dropdowns = document.querySelectorAll(".nav-dropdown");

  const alignMenuToCenter = (menuItem) => {
    const menu = menuItem.querySelector(".nav-dropdown-menu");
    const toggle = menuItem.querySelector(".nav-dropdown-toggle");
    if (!menu || !toggle) return;

    // Ekranın ve başlığın merkezini hesapla
    const screenCenter = window.innerWidth / 2;
    const toggleRect = toggle.getBoundingClientRect();
    const toggleCenter = toggleRect.left + toggleRect.width / 2;

    // Başlık ekranın solunda mı sağında mı diye kontrol et
    if (toggleCenter < screenCenter) {
      // SOLDA: Menüyü sağa doğru aç
      menu.classList.add("pull-right");
      menu.classList.remove("pull-left");
    } else {
      // SAĞDA: Menüyü sola doğru aç
      menu.classList.add("pull-left");
      menu.classList.remove("pull-right");
    }
  };

  // Her menünün üzerine gelince hizalama fonksiyonunu çalıştır
  dropdowns.forEach((item) => {
    item.addEventListener("mouseenter", () => alignMenuToCenter(item));
  });
});
