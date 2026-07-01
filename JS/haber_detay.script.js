// Galeri fotoğrafları array'i - Başlık ve açıklamalarla
const detayGorseller = [
  {
    resim: "../images/off-road-foto/gebze-de-off-road-heyecan_120.jpg",
  },
  {
    resim: "../images/off-road-foto/gebze-de-off-road-heyecan_2075.jpg",
  },
  {
    resim: "../images/off-road-foto/gebze-de-off-road-heyecan_2143.jpg",
  },
  {
    resim: "../images/off-road-foto/gebze-de-off-road-heyecan_3569.jpg",
  },
  {
    resim: "../images/off-road-foto/gebze-de-off-road-heyecan_3911.jpg",
  },
  {
    resim: "../images/off-road-foto/gebze-de-off-road-heyecan_4046.jpg",
  },
  {
    resim: "../images/off-road-foto/gebze-de-off-road-heyecan_4564.jpg",
  },
  {
    resim: "../images/off-road-foto/gebze-de-off-road-heyecan_4975.jpg",
  },
  {
    resim: "../images/off-road-foto/gebze-de-off-road-heyecan_5429.jpg",
  },
];
// --- GALERİ SİSTEMİ ---
const mainImage = document.getElementById("main-haber-gorsel");
const mainTitle = document.getElementById("ana-haber-baslik");
const galleryTrack = document.getElementById("gallery-track");
const galleryDotsContainer = document.getElementById("gallery-dots");

if (mainImage && mainTitle && galleryTrack && detayGorseller.length > 1) {
  const itemsPerView = 7;
  const totalGroups = Math.ceil(detayGorseller.length / itemsPerView);
  let currentGroupIndex = 0;
  let selectedImageIndex = 0;
  let autoSlideInterval;
  let isAutoPlaying = true;

  // Ok butonlarını oluştur
  const mainImageContainer = mainImage.parentElement;
  mainImageContainer.classList.add("main-image-container");

  const prevArrow = document.createElement("button");
  prevArrow.className = "gallery-arrow prev";
  prevArrow.innerHTML = '<i class="fas fa-chevron-left"></i>';

  const nextArrow = document.createElement("button");
  nextArrow.className = "gallery-arrow next";
  nextArrow.innerHTML = '<i class="fas fa-chevron-right"></i>';

  mainImageContainer.appendChild(prevArrow);
  mainImageContainer.appendChild(nextArrow);

  // Sonsuz döngü için görselleri çoğalt
  const galleryItems = [...detayGorseller, ...detayGorseller, ...detayGorseller];

  // Galeriyi ve noktaları oluştur
  galleryItems.forEach((gorsel, index) => {
    const originalIndex = index % detayGorseller.length;
    const thumbnail = document.createElement("div");
    thumbnail.className = "gallery-thumbnail";
    thumbnail.innerHTML = `
                <img src="${gorsel.resim}" alt="${gorsel.baslik}" class="gallery-thumbnail-image">
            `;
    thumbnail.dataset.index = originalIndex;
    galleryTrack.appendChild(thumbnail);
  });

  for (let i = 0; i < totalGroups; i++) {
    const dot = document.createElement("div");
    dot.className = "gallery-dot";
    dot.dataset.groupIndex = i;
    galleryDotsContainer.appendChild(dot);
  }

  const thumbnails = galleryTrack.querySelectorAll(".gallery-thumbnail");
  const dots = galleryDotsContainer.querySelectorAll(".gallery-dot");

  // Ana görsel ve başlık güncelleme fonksiyonu
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

    // Aktif thumbnail görünür alanda mı kontrol et
    ensureThumbnailVisible(selectedImageIndex);
  }

  // Dot'ları güncelle
  function updateDots() {
    dots.forEach((dot) => {
      dot.classList.toggle("active", parseInt(dot.dataset.groupIndex) === currentGroupIndex);
    });
  }

  // Grup değiştirme
  function setGroup(groupIndex) {
    currentGroupIndex = groupIndex;
    const itemWidth = thumbnails[0].offsetWidth + 8;
    const groupWidth = itemWidth * itemsPerView;
    galleryTrack.style.transform = `translateX(-${currentGroupIndex * groupWidth}px)`;
    updateDots();
  }

  // Aktif thumbnail'ın görünür olmasını sağla
  function ensureThumbnailVisible(imageIndex) {
    const groupIndex = Math.floor(imageIndex / itemsPerView);
    if (groupIndex !== currentGroupIndex) {
      setGroup(groupIndex);
    }
  }

  // Otomatik slider başlat
  function startAutoSlide() {
    if (autoSlideInterval) clearInterval(autoSlideInterval);

    autoSlideInterval = setInterval(() => {
      if (isAutoPlaying) {
        const nextIndex = (selectedImageIndex + 1) % detayGorseller.length;
        updateGallery(nextIndex);
      }
    }, 4000); // 4 saniyede bir değiş
  }

  // Otomatik slider durdur
  function stopAutoSlide() {
    isAutoPlaying = false;
    if (autoSlideInterval) {
      clearInterval(autoSlideInterval);
    }
  }

  // Otomatik slider yeniden başlat
  function resumeAutoSlide() {
    isAutoPlaying = true;
    startAutoSlide();
  }

  // Önceki fotoğraf
  function showPrevImage() {
    const prevIndex = selectedImageIndex === 0 ? detayGorseller.length - 1 : selectedImageIndex - 1;
    updateGallery(prevIndex);
  }

  // Sonraki fotoğraf
  function showNextImage() {
    const nextIndex = (selectedImageIndex + 1) % detayGorseller.length;
    updateGallery(nextIndex);
  }

  // Event listener'lar
  prevArrow.addEventListener("click", (e) => {
    e.stopPropagation();
    stopAutoSlide();
    showPrevImage();
    setTimeout(resumeAutoSlide, 10000);
  });

  nextArrow.addEventListener("click", (e) => {
    e.stopPropagation();
    stopAutoSlide();
    showNextImage();
    setTimeout(resumeAutoSlide, 10000);
  });

  // Thumbnail tıklama
  galleryTrack.addEventListener("click", (e) => {
    const thumbnail = e.target.closest(".gallery-thumbnail");
    if (thumbnail) {
      stopAutoSlide();
      updateGallery(parseInt(thumbnail.dataset.index));
      setTimeout(resumeAutoSlide, 10000);
    }
  });

  // Dot tıklama
  galleryDotsContainer.addEventListener("click", (e) => {
    const dot = e.target.closest(".gallery-dot");
    if (dot) {
      setGroup(parseInt(dot.dataset.groupIndex));
    }
  });

  // Klavye kontrolleri
  document.addEventListener("keydown", (e) => {
    if (e.key === "ArrowLeft") {
      e.preventDefault();
      stopAutoSlide();
      showPrevImage();
      setTimeout(resumeAutoSlide, 10000);
    } else if (e.key === "ArrowRight") {
      e.preventDefault();
      stopAutoSlide();
      showNextImage();
      setTimeout(resumeAutoSlide, 10000);
    }
  });

  // Ana görsel hover olayları
  mainImageContainer.addEventListener("mouseenter", () => {
    stopAutoSlide();
  });

  mainImageContainer.addEventListener("mouseleave", () => {
    resumeAutoSlide();
  });

  // Başlangıç durumu
  updateGallery(0);
  updateDots();
  startAutoSlide();
}

// DOM Elements
const profileBtn = document.getElementById("profileBtn");
const profileMenu = document.getElementById("profileMenu");
const navDropdown = document.querySelector(".nav-dropdown");
const dropdownToggle = document.querySelector(".nav-dropdown-toggle");
const dropdownMenu = document.querySelector(".nav-dropdown-menu");

// Initialize Event Listeners
document.addEventListener("DOMContentLoaded", function () {
  setupEventListeners();
});

// Event Listeners
function setupEventListeners() {
  // Navbar dropdown functionality
  if (navDropdown && dropdownToggle && dropdownMenu) {
    dropdownToggle.addEventListener("click", function (e) {
      e.preventDefault();
      e.stopPropagation();

      // Close profile menu if open
      if (profileMenu && profileBtn) {
        profileMenu.classList.remove("show");
        profileBtn.classList.remove("active");
      }

      navDropdown.classList.toggle("active"); // Toggle 'active' class
    });

    document.addEventListener("click", function (e) {
      if (!navDropdown.contains(e.target)) {
        navDropdown.classList.remove("active");
      }
    });

    document.addEventListener("keydown", function (e) {
      if (e.key === "Escape") {
        navDropdown.classList.remove("active");
      }
    });
  }

  // Profile dropdown functionality
  if (profileBtn && profileMenu) {
    profileBtn.addEventListener("click", function (e) {
      e.stopPropagation();

      // Close navbar dropdown if open
      if (navDropdown) {
        navDropdown.classList.remove("active");
      }

      profileMenu.classList.toggle("show");
      profileBtn.classList.toggle("active");
    });

    document.addEventListener("click", function (e) {
      if (!profileBtn.contains(e.target) && !profileMenu.contains(e.target)) {
        profileMenu.classList.remove("show");
        profileBtn.classList.remove("active");
      }
    });

    const logoutBtn = profileMenu.querySelector(".logout");
    if (logoutBtn) {
      logoutBtn.addEventListener("click", function (e) {
        e.preventDefault();
        if (confirm("Çıkış yapmak istediğinizden emin misiniz?")) {
          console.log("Çıkış yapılıyor...");
          // Burada çıkış yapma işlemleri (örn. oturumu sonlandırma, yönlendirme) eklenebilir.
        }
      });
    }

    document.addEventListener("keydown", function (e) {
      if (e.key === "Escape") {
        profileMenu.classList.remove("show");
        profileBtn.classList.remove("active");
      }
    });
  }
}
document.addEventListener("DOMContentLoaded", function () {
  const newsList = document.getElementById("other-news-list");
  // Burada herhangi bir sayfalama yok, tüm haberler listede
  // Scroll ile kullanıcı aşağı indikçe görebilir
});
document.addEventListener("DOMContentLoaded", function () {
  // --- Gerekli Bütün HTML Elementlerini Seçme ---
  const profileBtn = document.getElementById("profileBtn");
  const profileMenu = document.getElementById("profileMenu");
  const menuToggleBtn = document.querySelector(".mobile-menu-toggle");
  const sideMenu = document.getElementById("sideMenu");
  const closeMenuBtn = document.querySelector(".close-menu-btn");
  const menuBackdrop = document.getElementById("menuBackdrop");
  const navDropdown = document.querySelector(".nav-dropdown");
  const dropdownToggle = document.querySelector(".nav-dropdown-toggle");

  // --- MOBİL YAN MENÜ SİSTEMİ ---
  if (menuToggleBtn && sideMenu && closeMenuBtn && menuBackdrop) {
    // Menüyü aç
    menuToggleBtn.addEventListener("click", function () {
      sideMenu.classList.add("active");
      menuBackdrop.classList.add("active");
    });

    // Menüyü kapat (X butonu ile)
    closeMenuBtn.addEventListener("click", function () {
      sideMenu.classList.remove("active");
      menuBackdrop.classList.remove("active");
    });

    // Menüyü kapat (arka plana tıklayarak)
    menuBackdrop.addEventListener("click", function () {
      sideMenu.classList.remove("active");
      menuBackdrop.classList.remove("active");
    });
  }

  // --- PROFİL AÇILIR MENÜ SİSTEMİ ---
  if (profileBtn && profileMenu) {
    profileBtn.addEventListener("click", function (e) {
      e.stopPropagation();
      if (navDropdown) navDropdown.classList.remove("active"); // Diğer menüyü kapat
      profileMenu.classList.toggle("show");
      profileBtn.classList.toggle("active");
    });
  }

  // --- MASAÜSTÜ NAVBAR AÇILIR MENÜ SİSTEMİ ---
  if (navDropdown && dropdownToggle) {
    dropdownToggle.addEventListener("click", function (e) {
      e.preventDefault(); // Sayfanın en üstüne gitmesini engelle
      e.stopPropagation();
      if (profileMenu) profileMenu.classList.remove("show"); // Diğer menüyü kapat
      navDropdown.classList.toggle("active");
    });
  }

  // --- Sayfada Boş Bir Yere veya ESC Tuşuna Basınca Menüleri Kapat ---
  document.addEventListener("click", function (e) {
    if (profileMenu && !profileBtn.contains(e.target) && !profileMenu.contains(e.target)) {
      profileMenu.classList.remove("show");
      profileBtn.classList.remove("active");
    }
    if (navDropdown && !navDropdown.contains(e.target)) {
      navDropdown.classList.remove("active");
    }
  });

  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") {
      if (profileMenu) {
        profileMenu.classList.remove("show");
        profileBtn.classList.remove("active");
      }
      if (navDropdown) navDropdown.classList.remove("active");
      if (sideMenu) {
        sideMenu.classList.remove("active");
        menuBackdrop.classList.remove("active");
      }
    }
  });
});
document.addEventListener("DOMContentLoaded", function () {
  // --- Gerekli Bütün HTML Elementlerini Seçme ---
  const profileBtn = document.getElementById("profileBtn");
  const profileMenu = document.getElementById("profileMenu");
  const menuToggleBtn = document.querySelector(".mobile-menu-toggle");
  const sideMenu = document.getElementById("sideMenu");
  const closeMenuBtn = document.querySelector(".close-menu-btn");
  const menuBackdrop = document.getElementById("menuBackdrop");
  const navDropdown = document.querySelector(".nav-dropdown");
  const dropdownToggle = document.querySelector(".nav-dropdown-toggle");

  // --- MOBİL YAN MENÜ SİSTEMİ ---
  if (menuToggleBtn && sideMenu && closeMenuBtn && menuBackdrop) {
    // Menüyü aç
    menuToggleBtn.addEventListener("click", function () {
      sideMenu.classList.add("active");
      menuBackdrop.classList.add("active");
    });

    // Menüyü kapat (X butonu ile)
    closeMenuBtn.addEventListener("click", function () {
      sideMenu.classList.remove("active");
      menuBackdrop.classList.remove("active");
    });

    // Menüyü kapat (arka plana tıklayarak)
    menuBackdrop.addEventListener("click", function () {
      sideMenu.classList.remove("active");
      menuBackdrop.classList.remove("active");
    });
  }

  // --- PROFİL AÇILIR MENÜ SİSTEMİ ---
  if (profileBtn && profileMenu) {
    profileBtn.addEventListener("click", function (e) {
      e.stopPropagation();
      if (navDropdown) navDropdown.classList.remove("active"); // Diğer menüyü kapat
      profileMenu.classList.toggle("show");
      profileBtn.classList.toggle("active");
    });
  }

  // --- MASAÜSTÜ NAVBAR AÇILIR MENÜ SİSTEMİ ---
  if (navDropdown && dropdownToggle) {
    dropdownToggle.addEventListener("click", function (e) {
      e.preventDefault(); // Sayfanın en üstüne gitmesini engelle
      e.stopPropagation();
      if (profileMenu) profileMenu.classList.remove("show"); // Diğer menüyü kapat
      navDropdown.classList.toggle("active");
    });
  }

  // --- Sayfada Boş Bir Yere veya ESC Tuşuna Basınca Menüleri Kapat ---
  document.addEventListener("click", function (e) {
    if (profileMenu && !profileBtn.contains(e.target) && !profileMenu.contains(e.target)) {
      profileMenu.classList.remove("show");
      profileBtn.classList.remove("active");
    }
    if (navDropdown && !navDropdown.contains(e.target)) {
      navDropdown.classList.remove("active");
    }
  });

  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") {
      if (profileMenu) {
        profileMenu.classList.remove("show");
        profileBtn.classList.remove("active");
      }
      if (navDropdown) navDropdown.classList.remove("active");
      if (sideMenu) {
        sideMenu.classList.remove("active");
        menuBackdrop.classList.remove("active");
      }
    }
  });
});
document.addEventListener("DOMContentLoaded", () => {
  const dropdowns = document.querySelectorAll(".nav-dropdown");

  const setArrow = (li) => {
    const toggle = li.querySelector(".nav-dropdown-toggle");
    const menu = li.querySelector(".nav-dropdown-menu");
    if (!toggle || !menu) return;

    // Menü görünmüyorsa ölçüm için anlık görünür yap
    const cs = getComputedStyle(menu);
    const hidden = cs.display === "none" || cs.visibility === "hidden" || cs.opacity === "0";
    if (hidden) {
      menu.style.visibility = "hidden";
      menu.style.display = "block";
    }

    const t = toggle.getBoundingClientRect();
    const m = menu.getBoundingClientRect();
    const center = t.left + t.width / 2 - m.left; // toggle merkezi → menüye göre
    menu.style.setProperty("--arrow-left", `${center}px`);

    if (hidden) {
      menu.style.display = "";
      menu.style.visibility = "";
    }
  };

  dropdowns.forEach((li) => {
    li.addEventListener("mouseenter", () => setArrow(li));
    li.addEventListener("focusin", () => setArrow(li));
  });

  // pencere boyutu değişirse yeniden hizala
  window.addEventListener("resize", () => {
    document
      .querySelectorAll(".nav-dropdown:hover, .nav-dropdown:focus-within")
      .forEach((li) => setArrow(li));
  });
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
