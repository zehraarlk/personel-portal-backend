document.addEventListener("DOMContentLoaded", function () {

  // --- GALERİ SİSTEMİ (DİNAMİK VERİ) ---
  const detayGorseller = (typeof veritabanindanGelenHaberler !== 'undefined') ? veritabanindanGelenHaberler.map(haber => ({
      id: haber.id,
      resim: haber.resim,
      baslik: haber.baslik,
      aciklama: haber.aciklama
  })) : [];

  const mainImage = document.getElementById("main-haber-gorsel");
  const mainTitle = document.getElementById("ana-haber-baslik");
  const mainLink = document.getElementById("ana-haber-link");
  const galleryTrack = document.getElementById("gallery-track");
  const galleryWrapper = document.querySelector(".gallery-wrapper");
  const galleryPrevBtn = document.getElementById("gallery-prev-btn");
  const galleryNextBtn = document.getElementById("gallery-next-btn");

  if (mainImage && mainTitle && galleryTrack && detayGorseller.length > 0) {
    let selectedImageIndex = 0;
    let autoSlideInterval;
    let currentDetailUrl = "";

    // Linkin href="" olması sayfayı yenileyebilir; defaultu ezip her zaman detaya git
    if (mainLink) {
      mainLink.href = "#";
      mainLink.addEventListener("click", (e) => {
        e.preventDefault();
        e.stopPropagation();
        if (currentDetailUrl) window.location.href = currentDetailUrl;
      });
    }

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

      // Detay linki: tıklayınca etkinlikd.php?id=...
      const selectedId = selectedItem ? parseInt(selectedItem.id, 10) : 0;
      currentDetailUrl = selectedId > 0 ? `etkinlikd.php?id=${encodeURIComponent(selectedId)}` : "";
      if (mainLink) {
        mainLink.href = currentDetailUrl || "#";
      }

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
        const clickedIndex = parseInt(thumbnail.dataset.index);

        // Aktif olana tekrar tıklanırsa: detay sayfasına git
        if (clickedIndex === selectedImageIndex && currentDetailUrl) {
          window.location.href = currentDetailUrl;
          return;
        }

        clearInterval(autoSlideInterval);
        updateGallery(clickedIndex);
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

    // Ana görsele tıklanınca da detaya git
    if (mainImage) {
      mainImage.style.cursor = "pointer";
      mainImage.addEventListener("click", () => {
        if (currentDetailUrl) {
          window.location.href = currentDetailUrl;
        }
      });
    }

    // Başlığa tıklanınca da detaya git
    if (mainTitle) {
      mainTitle.style.cursor = "pointer";
      mainTitle.addEventListener("click", (e) => {
        // Başlık <a> içinde olduğundan default navigasyonu kes
        e.preventDefault();
        e.stopPropagation();
        if (currentDetailUrl) window.location.href = currentDetailUrl;
      });
    }
  }

// Eski el yazısı diziyi sildik, yerine veritabanından gelen duyuruları bağlıyoruz:
  const tumDuyurular = (typeof veritabanindanGelenDuyurular !== 'undefined') ? veritabanindanGelenDuyurular.map(duyuru => ({
      id: duyuru.id,
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

    function escapeHtml(value) {
      return String(value ?? "")
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#39;");
    }

    function renderDuyurular() {
      duyurularListesi.innerHTML = "";
      const baslangic = (gecerliSayfa - 1) * duyuruSayisiSayfaBasi;
      const bitis = baslangic + duyuruSayisiSayfaBasi;
      const gosterilecekDuyurular = tumDuyurular.slice(baslangic, bitis);
      gosterilecekDuyurular.forEach((duyuru) => {
        const duyuruId = Number(duyuru.id) || 0;
        const detayUrl = duyuruId > 0 ? `duyurud.php?id=${encodeURIComponent(duyuruId)}` : "duyuru.php";
        const duyuruElementi = `<a href="${detayUrl}" class="duyuru-item"><img src="${escapeHtml(duyuru.resim)}" alt="${escapeHtml(duyuru.baslik)}" class="duyuru-resim"><div class="duyuru-icerik"><h3 class="duyuru-baslik">${escapeHtml(duyuru.baslik)}</h3><p class="duyuru-aciklama">${escapeHtml(duyuru.aciklama)}</p></div></a>`;
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