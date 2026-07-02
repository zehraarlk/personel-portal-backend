document.addEventListener("DOMContentLoaded", function () {
  // --- BÜTÜN MENÜLER İÇİN GEREKLİ ELEMENTLER ---
  const profileBtn = document.getElementById("profileBtn");
  const profileMenu = document.getElementById("profileMenu");
  const menuToggleBtn = document.querySelector(".mobile-menu-toggle");
  const sideMenu = document.getElementById("sideMenu");
  const closeMenuBtn = document.querySelector(".close-menu-btn");
  const menuBackdrop = document.getElementById("menuBackdrop");
  const navDropdowns = document.querySelectorAll(".nav-dropdown");

  // --- MOBİL YAN MENÜ SİSTEMİ ---
  if (menuToggleBtn && sideMenu && closeMenuBtn && menuBackdrop) {
    menuToggleBtn.addEventListener("click", function (e) {
      e.stopPropagation();
      sideMenu.classList.add("active");
      menuBackdrop.classList.add("active");
    });
    closeMenuBtn.addEventListener("click", function () {
      sideMenu.classList.remove("active");
      menuBackdrop.classList.remove("active");
    });
    menuBackdrop.addEventListener("click", function () {
      sideMenu.classList.remove("active");
      menuBackdrop.classList.remove("active");
    });
  } else {
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

  // --- GALERİ SİSTEMİ (DİNAMİK VERİ) ---
  const detayGorseller = (typeof veritabanindanGelenHaberler !== 'undefined') ? veritabanindanGelenHaberler.map(haber => ({
      resim: haber.resim,
      baslik: haber.baslik,
      aciklama: haber.aciklama
  })) : [];

  const mainImage = document.getElementById("main-haber-gorsel");
  const mainTitle = document.getElementById("ana-haber-baslik");
  const galleryTrack = document.getElementById("gallery-track");
  const galleryWrapper = document.querySelector(".gallery-wrapper");
  const galleryPrevBtn = document.getElementById("gallery-prev-btn");
  const galleryNextBtn = document.getElementById("gallery-next-btn");

  if (mainImage && mainTitle && galleryTrack && detayGorseller.length > 0) {
    let selectedImageIndex = 0;
    let autoSlideInterval;

    // Küçük resimleri DOM'a sadece BİR kere ekliyoruz
    galleryTrack.innerHTML = ""; 
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

      if (galleryPrevBtn && galleryNextBtn) {
        galleryPrevBtn.disabled = selectedImageIndex === 0;
        galleryNextBtn.disabled = selectedImageIndex === detayGorseller.length - 1;
      }

      const activeThumbnail = galleryTrack.querySelector(".gallery-thumbnail.active");
      if (activeThumbnail && galleryWrapper) {
        const scrollAmount = activeThumbnail.offsetLeft + activeThumbnail.offsetWidth / 2 - galleryWrapper.offsetWidth / 2;
        galleryWrapper.scrollTo({ left: scrollAmount, behavior: "smooth" });
      }
    }

    galleryTrack.addEventListener("click", (e) => {
      const thumbnail = e.target.closest(".gallery-thumbnail");
      if (thumbnail) {
        clearInterval(autoSlideInterval);
        updateGallery(parseInt(thumbnail.dataset.index));
        startAutoSlide();
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
        selectedImageIndex = (selectedImageIndex + 1) % detayGorseller.length;
        updateGallery(selectedImageIndex);
      }, 4000);
    }

    updateGallery(0);
    startAutoSlide();
  }

// Eski el yazısı diziyi sildik, yerine veritabanından gelen duyuruları bağlıyoruz:
  const tumDuyurular = (typeof veritabanindanGelenDuyurular !== 'undefined') ? veritabanindanGelenDuyurular.map(duyuru => ({
      resim: duyuru.resim,
      baslik: duyuru.baslik,
      aciklama: duyuru.aciklama
  })) : [];
  
  const duyurularListesi = document.getElementById("duyurular-listesi");
  const prevButton = document.getElementById("prev-page");
  const nextButton = document.getElementById("next-page");
  const sayfaBilgisi = document.getElementById("sayfa-bilgisi");

  if (duyurularListesi && prevButton && nextButton && sayfaBilgisi) {
    let gecerliSayfa = 1;
    const duyuruSayisiSayfaBasi = 4;
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
      sayfaBilgisi.textContent = `Sayfa ${gecerliSayfa} / ${toplamSayfa}`;
      prevButton.disabled = gecerliSayfa === 1;
      nextButton.disabled = gecerliSayfa === toplamSayfa;
    }

    prevButton.addEventListener("click", () => { if (gecerliSayfa > 1) { gecerliSayfa--; renderDuyurular(); } });
    nextButton.addEventListener("click", () => { if (gecerliSayfa < toplamSayfa) { gecerliSayfa++; renderDuyurular(); } });
    if (toplamSayfa > 0) renderDuyurular();
  }

  // --- DOĞUM GÜNÜ SİSTEMİ ---
  const personeller = [
    { id: 1, ad: "Tümay", soyad: "AKSAN", dogumTarihi: "1995-08-25", fotoUrl: "../images/dogum_gunu/37604190820-tumay-aksan_3957.jpg" },
    { id: 2, ad: "Yavuz", soyad: "AĞAÇ", dogumTarihi: "1992-08-25", fotoUrl: "../images/dogum_gunu/32980582726-yavuz-a-ac_5843.jpg" },
    { id: 3, ad: "Zeynep", soyad: "YILMAZ", dogumTarihi: "1995-08-25", fotoUrl: "../images/dogum_gunu/manzara.jpg" },
    { id: 4, ad: "Fatih", soyad: "SULTAN MEHMET", dogumTarihi: "1990-08-25", fotoUrl: "../images/dogum_gunu/Fatih.jpg" },
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
    listeElementi.innerHTML = "";
    bugunDoganlar.forEach((personel) => {
      const cardHtml = `<div class="col"><div class="birthday-card"><img src="${personel.fotoUrl}" class="card-img-top" alt="${personel.ad} ${personel.soyad}"><div class="card-body"><div><h5 class="card-title">${personel.ad} ${personel.soyad}</h5></div></div></div></div>`;
      listeElementi.innerHTML += cardHtml;
    });
  } else if (bosMesajElementi) {
    bosMesajElementi.classList.remove("d-none");
  }
});

// --- MENÜ HİZALAMA SİSTEMİ ---
document.addEventListener("DOMContentLoaded", () => {
  const dropdowns = document.querySelectorAll(".nav-dropdown");
  const alignMenuToCenter = (menuItem) => {
    const menu = menuItem.querySelector(".nav-dropdown-menu");
    const toggle = menuItem.querySelector(".nav-dropdown-toggle");
    if (!menu || !toggle) return;

    const screenCenter = window.innerWidth / 2;
    const toggleRect = toggle.getBoundingClientRect();
    const toggleCenter = toggleRect.left + toggleRect.width / 2;

    if (toggleCenter < screenCenter) {
      menu.classList.add("pull-right");
      menu.classList.remove("pull-left");
    } else {
      menu.classList.add("pull-left");
      menu.classList.remove("pull-right");
    }
  };
  dropdowns.forEach((item) => {
    item.addEventListener("mouseenter", () => alignMenuToCenter(item));
  });
});