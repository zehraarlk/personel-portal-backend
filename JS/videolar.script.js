
document.addEventListener("DOMContentLoaded", () => {
  // ===================================================================
  // BÖLÜM 1: VİDEO SAYFASI İÇİN GEREKLİ KODLAR
  // ===================================================================

  // Video Veri Tabanı
  // ===================================================================
  // BÖLÜM 1: VİDEO SAYFASI İÇİN GEREKLİ KODLAR
  // ===================================================================

// Veritabanındaki Türkçe sütun isimlerini, JavaScript'in beklediği İngilizce isimlere eşliyoruz:
  const videos = (typeof veritabanindanGelenVideolar !== 'undefined') ? veritabanindanGelenVideolar.map(video => ({
      id: video.youtube_id, // Senin veritabanındaki youtube_id sütun adın
      title: video.baslik,   // Senin veritabanındaki baslik sütun adın
      description: video.aciklama, // Senin veritabanındaki aciklama sütun adın
      category: video.kategori,   // Senin veritabanındaki kategori sütun adın
      duration: video.sure   // Senin veritabanındaki sure sütun adın
  })) : [];

  // Gerekli HTML Elementlerini Seçme (Video Bölümü)
  const videoGrid = document.getElementById("video-grid");
  const searchInput = document.getElementById("video-search-input");
  const filterButtons = document.querySelectorAll(".nav-pills .nav-link");
  const noResultsMessage = document.getElementById("no-results-message");
  const paginationContainer = document.querySelector(".pagination");
  const videoModalEl = document.getElementById("videoModal");
  const youtubeIframe = document.getElementById("youtube-iframe");

  const itemsPerPage = 8;
  let currentPage = 1;

  // Videoları Ekrana Çizen Fonksiyon
  const renderVideos = (items) => {
    if (!videoGrid) return;
    videoGrid.innerHTML = "";
    if (items.length === 0) return;
    items.forEach((video) => {
      const cardHTML = `
                <div class="col video-item" data-category="${video.category}">
                    <div class="card video-card h-100 shadow-sm" data-bs-toggle="modal" data-bs-target="#videoModal" data-youtube-id="${video.id}">
                        <div class="card-thumbnail">
                             <img src="https://img.youtube.com/vi/${video.id}/hqdefault.jpg" class="card-img-top" alt="${video.title}">
                            <div class="play-icon-overlay"><i class="fas fa-play"></i></div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">${video.title}</h5>
                            <p class="card-text small">${video.description}</p>
                        </div>
                         <div class="card-footer">
                            <small class="text-muted"><i class="fas fa-tag me-1"></i> ${video.category}</small>
                            <small class="text-muted"><i class="fas fa-clock me-1"></i> ${video.duration}</small>
                        </div>
                    </div>
                </div>`;
      videoGrid.innerHTML += cardHTML;
    });
  };

  // Sayfayı (Filtre, Arama, Sayfalama) Güncelleyen Ana Fonksiyon
  const updateDisplay = () => {
    if (!searchInput) return; // Sadece video sayfasındaysa çalış
    const selectedCategory = document
      .querySelector(".nav-pills .nav-link.active")
      .getAttribute("data-category");
    const searchTerm = searchInput.value.toLowerCase();
    const filteredItems = videos.filter((video) => {
      const categoryMatch = selectedCategory === "all" || video.category === selectedCategory;
      const searchMatch = video.title.toLowerCase().includes(searchTerm);
      return categoryMatch && searchMatch;
    });
    const paginatedItems = paginate(filteredItems);
    renderVideos(paginatedItems);

    if (noResultsMessage)
      noResultsMessage.style.display = filteredItems.length === 0 ? "block" : "none";
    setupPagination(filteredItems);
  };

  // Sayfalama Yapan Fonksiyon
  const paginate = (items) => {
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    return items.slice(startIndex, endIndex);
  };

  // Sayfalama Butonlarını Oluşturan Fonksiyon
  const setupPagination = (items) => {
    if (!paginationContainer) return;
    const totalPages = Math.ceil(items.length / itemsPerPage);
    paginationContainer.innerHTML = "";
    if (totalPages <= 1) {
      paginationContainer.style.display = "none";
      return;
    }
    paginationContainer.style.display = "flex";
    paginationContainer.innerHTML += `<li class="page-item ${currentPage === 1 ? "disabled" : ""}"><a class="page-link" href="#" aria-label="Önceki" data-page="${currentPage - 1}"><i class="fas fa-chevron-left"></i></a></li>`;
    for (let i = 1; i <= totalPages; i++) {
      paginationContainer.innerHTML += `<li class="page-item ${i === currentPage ? "active" : ""}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
    }
    paginationContainer.innerHTML += `<li class="page-item ${currentPage === totalPages ? "disabled" : ""}"><a class="page-link" href="#" aria-label="Sonraki" data-page="${currentPage + 1}"><i class="fas fa-chevron-right"></i></a></li>`;
  };

  // Video Sayfası Olay Dinleyicileri
  if (filterButtons.length > 0) {
    filterButtons.forEach((button) => {
      button.addEventListener("click", (event) => {
        event.preventDefault();
        filterButtons.forEach((btn) => btn.classList.remove("active"));
        button.classList.add("active");
        currentPage = 1;
        updateDisplay();
      });
    });
  }

  if (searchInput) {
    searchInput.addEventListener("input", () => {
      currentPage = 1;
      updateDisplay();
    });
  }

  if (paginationContainer) {
    paginationContainer.addEventListener("click", (event) => {
      event.preventDefault();
      const target = event.target.closest("a");
      if (target && !target.parentElement.classList.contains("disabled")) {
        currentPage = parseInt(target.getAttribute("data-page"));
        updateDisplay();
      }
    });
  }

  if (videoModalEl) {
    videoModalEl.addEventListener("show.bs.modal", (event) => {
      // Tıklanan elementin kendisini alıyoruz, artık .card aramıyoruz.
      const triggerElement = event.relatedTarget;
      if (triggerElement) {
        // YouTube ID'sini direkt bu elementten alıyoruz.
        const youtubeId = triggerElement.getAttribute("data-youtube-id");
        if (youtubeId && youtubeIframe) {
          youtubeIframe.setAttribute(
            "src",
            `https://www.youtube.com/embed/${youtubeId}?autoplay=1`
          );
        }
      }
    });

    videoModalEl.addEventListener("hidden.bs.modal", () => {
      if (youtubeIframe) youtubeIframe.setAttribute("src", "");
    });
  }

  // Video sayfası için ilk yükleme
  if (window.location.pathname.includes("video")) {
    updateDisplay();
  }

  // ===================================================================
  // BÖLÜM 2: BÜTÜN MENÜLERİN ÇALIŞMASINI SAĞLAYAN KOD
  // ===================================================================

  // Gerekli HTML Elementlerini Seçme (Menü Bölümü)
  const profileBtn = document.getElementById("profileBtn");
  const profileMenu = document.getElementById("profileMenu");
  const menuToggleBtn = document.querySelector(".mobile-menu-toggle");
  const sideMenu = document.getElementById("sideMenu");
  const closeMenuBtn = document.querySelector(".close-menu-btn");
  const menuBackdrop = document.getElementById("menuBackdrop");
  const navDropdowns = document.querySelectorAll(".nav-dropdown");

  // Mobil Yan Menü (Hamburger)
  if (menuToggleBtn && sideMenu && closeMenuBtn && menuBackdrop) {
    menuToggleBtn.addEventListener("click", (e) => {
      e.stopPropagation();
      sideMenu.classList.add("active");
      menuBackdrop.classList.add("active");
    });
    closeMenuBtn.addEventListener("click", () => {
      sideMenu.classList.remove("active");
      menuBackdrop.classList.remove("active");
    });
    menuBackdrop.addEventListener("click", () => {
      sideMenu.classList.remove("active");
      menuBackdrop.classList.remove("active");
    });
  }

  // Profil Açılır Menüsü
  if (profileBtn && profileMenu) {
    profileBtn.addEventListener("click", (e) => {
      e.stopPropagation();
      navDropdowns.forEach((d) => d.classList.remove("active"));
      profileMenu.classList.toggle("show");
    });
  }

  // Masaüstü Açılır Menüler
  navDropdowns.forEach((dropdown) => {
    const toggle = dropdown.querySelector(".nav-dropdown-toggle");
    if (toggle) {
      toggle.addEventListener("click", (e) => {
        e.preventDefault();
        e.stopPropagation();
        if (profileMenu) profileMenu.classList.remove("show");

        let wasActive = dropdown.classList.contains("active");
        navDropdowns.forEach((d) => d.classList.remove("active"));

        if (!wasActive) {
          dropdown.classList.add("active");
        }
      });
    }
  });

  // Boş Yere veya ESC'ye Basınca Menüleri Kapat
  document.addEventListener("click", () => {
    if (profileMenu) profileMenu.classList.remove("show");
    navDropdowns.forEach((d) => d.classList.remove("active"));
  });

  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") {
      if (sideMenu) sideMenu.classList.remove("active");
      if (menuBackdrop) menuBackdrop.classList.remove("active");
      if (profileMenu) profileMenu.classList.remove("show");
      navDropdowns.forEach((d) => d.classList.remove("active"));
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
