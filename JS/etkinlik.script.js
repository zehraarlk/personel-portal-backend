// Sample data - Bu veriler gerçek uygulamada API'den gelecek
const newsData = [
  {
    id: 1,
    title: "Stajyer Oryantasyon Eğitimi",
    excerpt:
      "6734 ve 6735 Sayılı Kanun Eğitimi - Biyomedikal Eğitimi - Üniversite Eğitimi - Oryantasyon Eğitimi - Fen Programlama Eğitimi - Mevzuat Eğitimi - Teknoloji Çalışma Eğitimi...",
    date: "06.08.2025",
    endDate: "31.12.2025", // Bitiş tarihi eklendi
    views: 91,
    status: "aktif",
    image: "../images/stajyer-oryantasyon-e-t-m_8697.jpg",
  },
  {
    id: 2,
    title: "Stajyer Dönem Sonu Etkinliği",
    excerpt:
      "Köprülü Geçmis Mahallesi, 503 Sokak'taki çalışmalar...Köprülü Geçmis Mahallesi, 503 Sokak'taki çalışmalar...",
    date: "22.05.2025",
    endDate: "30.06.2025", // Bitiş tarihi eklendi
    views: 145,
    status: "aktif",
    image: "../images/stajyer-donem-sonu-etk-nl_6028.jpg",
  },
  {
    id: 3,
    title: "Personel İftar Programı",
    excerpt:
      "Kül, katkısız ve tüm güzelleştirme organlarından şeye çeşit kurtarıcılar...Kül, katkısız ve tüm güzelleştirme organlarından şeye çeşit kurtarıcılar...",
    date: "15.03.2024",
    endDate: "15.04.2024", // Bitiş tarihi eklendi
    views: 78,
    status: "pasif",
    image: "../images/pesonel-ftar-programi_3732.jpg",
  },
  {
    id: 4,
    title: "8 Mart Dünya Kadınlar Günü Programı",
    excerpt:
      "4 Ekim Dünya Hayvanları Koruma Günü nedeniyle 4 Ekim boyunca...4 Ekim Dünya Hayvanları Koruma Günü nedeniyle 4 Ekim boyunca...",
    date: "08.03.2024",
    endDate: "08.03.2024", // Bitiş tarihi eklendi
    views: 234,
    status: "pasif",
    image: "../images/8-mart-dunya-kadinlar-gunu-programi_8383.jpg",
  },
  {
    id: 5,
    title: "Ön Ödeme Kredi ve Avans Eğitimi",
    excerpt: "Bağışlanmış günlük programı göbildirinde park ve yeşil alanlarımızda...",
    date: "27.02.2025",
    endDate: "31.03.2025", // Bitiş tarihi eklendi
    views: 156,
    status: "pasif",
    image: "../images/on-odeme-kred-ve-avans-e-t-m_2065.jpeg",
  },
  {
    id: 6,
    title: "Marmara Kariyer Yer Fuarı",
    excerpt:
      "Personel gelişimi için düzenlenen eğitim seminerimiz tamamlandı. Katılımcılarımız başarı sertifikalarını aldı...",
    date: "26.02.2024",
    endDate: "28.02.2024", // Bitiş tarihi eklendi
    views: 189,
    status: "pasif",
    image: "../images/marmara-kar-yer-fuari-kocael-2024_9790.jpg",
  },
  {
    id: 7,
    title: "Ofis Programları Eğitimi",
    excerpt:
      "Şehrimizin çeşitli bölgelerinde gerçekleştirilen yol bakım ve onarım çalışmaları devam ediyor...",
    date: "19.02.2025",
    endDate: "31.08.2025", // Bitiş tarihi eklendi - devam eden
    views: 267,
    status: "aktif",
    image: "../images/of-s-programlari-e-t-m_2683.jpeg",
  },
  {
    id: 8,
    title: "İlkyardım Eğitimi",
    excerpt:
      "Doğal yaşam alanlarının korunması için başlatılan temizlik kampanyası büyük ilgi gördü...",
    date: "12.02.2024",
    endDate: "31.12.2025", // Bitiş tarihi eklendi - devam eden
    views: 198,
    status: "aktif",
    image: "../images/lkyardim-e-t-m_1307.jpeg",
  },
  {
    id: 9,
    title: "Stajyer Film-Okuma Programı",
    excerpt:
      "Doğal yaşam alanlarının korunması için başlatılan temizlik kampanyası büyük ilgi gördü...",
    date: "07.02.2024",
    endDate: "15.03.2024", // Bitiş tarihi eklendi
    views: 198,
    status: "pasif",
    image: "../images/lkyardim-e-t-m_1307.jpeg",
  },
  {
    id: 10,
    title: "3 Aralık Dünya Engelliler Günü  Personel Etkinliği",
    excerpt:
      "Personelimize yönelik dijital dönüşüm ve teknoloji kullanımı eğitimi başarıyla tamamlandı...",
    date: "03.12.2023",
    endDate: "03.12.2023", // Bitiş tarihi eklendi
    views: 312,
    status: "pasif",
    image: "../images/3-aralik-dunya-engell-ler-gunu-personel-yeme_9554.jpg",
  },
  {
    id: 11,
    title: "Stajyer Öğrenci Oryantasyonu ",
    excerpt:
      "Şehir merkezindeki altyapı geliştirme ve modernizasyon çalışmaları hızla devam ediyor...",
    date: "29.11.2025",
    endDate: "15.12.2025", // Bitiş tarihi eklendi
    views: 423,
    status: "pasif",
    image: "../images/stajyer-o-renci-oryantasyonu_2177.jpg",
  },
  {
    id: 12,
    title: "24 Kasım Öğretmenler Günü Etkinliği",
    excerpt:
      "Sokak hayvanlarının sağlık kontrolü ve bakım programı kapsamında çalışmalar sürdürülüyor...",
    date: "24.11.2023",
    endDate: "24.11.2023", // Bitiş tarihi eklendi
    views: 186,
    status: "pasif",
    image: "../images/24-kas-m-o-retmenler-gunu_2947.jpg",
  },
  {
    id: 13,
    title: "Müdürlükler Arası Spor Turnuvası",
    excerpt:
      "Kent genelindeki park ve yeşil alanların bakım ve düzenleme çalışmaları tamamlandı...",
    date: "21.08.2023",
    endDate: "30.09.2023", // Bitiş tarihi eklendi
    views: 278,
    status: "pasif",
    image: "../images/futbol-turnuvasi_9646.jpg",
  },
  {
    id: 14,
    title: "Personel Piknik Programı",
    excerpt:
      "Kent genelindeki park ve yeşil alanların bakım ve düzenleme çalışmaları tamamlandı...",
    date: "22.07.2023",
    endDate: "22.07.2023", // Bitiş tarihi eklendi
    views: 278,
    status: "pasif",
    image: "../images/personel-p-kn-k-programi_9118.jpg",
  },
  {
    id: 15,
    title: "Personel Bayramlaşma Programı",
    excerpt:
      "Kent genelindeki park ve yeşil alanların bakım ve düzenleme çalışmaları tamamlandı...",
    date: "23.06.2023",
    endDate: "25.06.2023", // Bitiş tarihi eklendi
    views: 278,
    status: "pasif",
    image: "../images/personel-bayramla-ma-programi_5965.jpg",
  },
  {
    id: 16,
    title: "Personel İftar Programı",
    excerpt:
      "Kent genelindeki park ve yeşil alanların bakım ve düzenleme çalışmaları tamamlandı...",
    date: "10.04.2023",
    endDate: "15.05.2023", // Bitiş tarihi eklendi
    views: 278,
    status: "pasif",
    image: "../images/personel-ftar-program_109.jpg",
  },
];
let filteredData = [...newsData];
let currentPage = 1;
const itemsPerPage = 12; // 4'lü grid için 12 kart gösteriyoruz

// DOM Elements
const searchInput = document.getElementById("searchInput");
const searchBtn = document.getElementById("searchBtn");
const filterBtns = document.querySelectorAll(".filter-btn");
const sortSelect = document.getElementById("sortSelect");
const newsGrid = document.getElementById("newsGrid");
const resultsCount = document.getElementById("resultsCount");
const totalNews = document.getElementById("totalNews");
const loadingSpinner = document.getElementById("loadingSpinner");
const noResults = document.getElementById("noResults");
const pagination = document.getElementById("pagination");

// Etkinlik durumunu kontrol eden fonksiyon
function getEventStatus(endDate) {
  const today = new Date();
  const eventEndDate = new Date(endDate.split(".").reverse().join("-"));

  if (eventEndDate >= today) {
    return { status: "active", text: "Aktif", class: "aktif" };
  } else {
    return { status: "expired", text: "Süresi Doldu", class: "pasif" };
  }
}

// Initialize
document.addEventListener("DOMContentLoaded", function () {
  updateTotalCount();
  renderNews();
  setupEventListeners();
});

// Event Listeners
function setupEventListeners() {
  // ---- Mobil Menü ----
  const menuToggleBtn = document.querySelector(".mobile-menu-toggle");
  const sideMenu = document.getElementById("sideMenu");
  const closeMenuBtn = document.querySelector(".close-menu-btn");
  const menuBackdrop = document.getElementById("menuBackdrop");

  if (menuToggleBtn && sideMenu && closeMenuBtn && menuBackdrop) {
    menuToggleBtn.addEventListener("click", function () {
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
  }

  // ---- Masaüstü Dropdown Menüler ----
  const navDropdowns = document.querySelectorAll(".nav-dropdown");
  navDropdowns.forEach((navDropdown) => {
    const dropdownToggle = navDropdown.querySelector(".nav-dropdown-toggle");
    if (dropdownToggle) {
      dropdownToggle.addEventListener("click", function (e) {
        e.preventDefault();
        e.stopPropagation();
        // Diğer açık menüleri kapat
        document
          .querySelectorAll(".nav-dropdown.active, .profile-menu.show")
          .forEach((openMenu) => {
            if (openMenu !== navDropdown) {
              openMenu.classList.remove("active", "show");
            }
          });
        navDropdown.classList.toggle("active");
      });
    }
  });

  // ---- Profil Dropdown Menüsü ----
  const profileBtn = document.getElementById("profileBtn");
  const profileMenu = document.getElementById("profileMenu");
  if (profileBtn && profileMenu) {
    profileBtn.addEventListener("click", function (e) {
      e.stopPropagation();
      // Diğer açık menüleri kapat
      document.querySelectorAll(".nav-dropdown.active").forEach((openMenu) => {
        openMenu.classList.remove("active");
      });
      profileMenu.classList.toggle("show");
      profileBtn.classList.toggle("active");
    });
  }

  // ---- Sayfaya Tıklayınca veya ESC basınca menüleri kapatma ----
  document.addEventListener("click", function (e) {
    if (!e.target.closest(".nav-dropdown")) {
      document
        .querySelectorAll(".nav-dropdown.active")
        .forEach((dd) => dd.classList.remove("active"));
    }
    if (!e.target.closest(".profile-dropdown")) {
      if (profileMenu) profileMenu.classList.remove("show");
      if (profileBtn) profileBtn.classList.remove("active");
    }
  });

  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") {
      document
        .querySelectorAll(".nav-dropdown.active, .side-menu.active, .profile-menu.show")
        .forEach((el) => {
          el.classList.remove("active", "show");
        });
      if (profileBtn) profileBtn.classList.remove("active");
      if (menuBackdrop) menuBackdrop.classList.remove("active");
    }
  });

  // ---- Arama Fonksiyonları ----
  if (searchInput && searchBtn) {
    searchInput.addEventListener("input", debounce(handleSearch, 300));
    searchBtn.addEventListener("click", handleSearch);
    searchInput.addEventListener("keypress", function (e) {
      if (e.key === "Enter") {
        handleSearch();
      }
    });
  }

  // ---- Filtreleme ve Sıralama ----
  if (sortSelect) {
    sortSelect.addEventListener("change", handleSort);
  }
}

// Search function
function handleSearch() {
  const query = searchInput.value.toLowerCase().trim();
  if (query === "") {
    filteredData = [...newsData];
  } else {
    filteredData = newsData.filter(
      (item) =>
        item.title.toLowerCase().includes(query) || item.excerpt.toLowerCase().includes(query)
    );
  }
  currentPage = 1;
  renderNews();
}

// Filter function - Sort dropdown'a göre filtreleme
function handleFilter() {
  const sortType = sortSelect.value;
  if (sortType === "active") {
    filteredData = newsData.filter((item) => getEventStatus(item.endDate).status === "active");
  } else if (sortType === "completed") {
    filteredData = newsData.filter((item) => getEventStatus(item.endDate).status === "expired");
  } else {
    filteredData = [...newsData];
  }
  currentPage = 1;
  renderNews();
}

// Sort function
function handleSort() {
  handleFilter(); // Sort dropdown değiştiğinde filtrelemeyi yeniden yap
}

// Render news function
function renderNews() {
  showLoading();
  setTimeout(() => {
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const currentItems = filteredData.slice(startIndex, endIndex);

    if (currentItems.length === 0) {
      showNoResults();
    } else {
      showNewsGrid(currentItems);
    }

    updateResultsCount();
    renderPagination();
    hideLoading();
  }, 500);
}

// Show loading
function showLoading() {
  if (loadingSpinner) loadingSpinner.classList.remove("d-none");
  if (newsGrid) newsGrid.classList.add("d-none");
  if (noResults) noResults.classList.add("d-none");
}

// Hide loading
function hideLoading() {
  if (loadingSpinner) loadingSpinner.classList.add("d-none");
}

// Show news grid - Güncellenmiş durum badge'i ile
function showNewsGrid(items) {
  if (newsGrid) {
    newsGrid.classList.remove("d-none");
    if (noResults) noResults.classList.add("d-none");

    newsGrid.innerHTML = items
      .map((item) => {
        const eventStatus = getEventStatus(item.endDate);
        return `
                <div class="news-card" onclick="openNewsDetail(${item.id})">
                    <img src="${item.image}" alt="${item.title}" class="news-image" loading="lazy">
                    <div class="news-content">
                        <div class="event-status">
                            <span class="badge ${eventStatus.class}">${eventStatus.text}</span>
                        </div>
                        <h3 class="news-title">${item.title}</h3>
                        <p class="news-excerpt">${item.excerpt}</p>
                        <div class="news-meta">
                            <span class="news-date">
                                <i class="fas fa-calendar-alt"></i>
                                ${item.date}
                            </span>
                            <span class="news-views">
                                <i class="fas fa-eye"></i>
                                ${item.views}
                            </span>
                        </div>
                    </div>
                </div>
            `;
      })
      .join("");
  }
}

// Show no results
function showNoResults() {
  if (newsGrid) newsGrid.classList.add("d-none");
  if (noResults) noResults.classList.remove("d-none");
}

// Update results count
function updateResultsCount() {
  if (resultsCount) {
    resultsCount.innerHTML = `<strong>${filteredData.length}</strong> sonuç bulundu`;
  }
}

// Update total count
function updateTotalCount() {
  if (totalNews) {
    totalNews.textContent = newsData.length;
  }
}

// Render pagination
function renderPagination() {
  if (!pagination) return;

  const totalPages = Math.ceil(filteredData.length / itemsPerPage);
  if (totalPages <= 1) {
    pagination.innerHTML = "";
    return;
  }

  let paginationHTML = "";
  // Previous button
  if (currentPage > 1) {
    paginationHTML += `
            <li class="page-item">
                <a class="page-link" href="#" onclick="changePage(${currentPage - 1})">
                    <i class="fas fa-chevron-left"></i>
                </a>
            </li>
        `;
  }

  // Page numbers
  for (let i = 1; i <= totalPages; i++) {
    if (i === currentPage) {
      paginationHTML += `<li class="page-item active"><span class="page-link">${i}</span></li>`;
    } else if (i === 1 || i === totalPages || (i >= currentPage - 2 && i <= currentPage + 2)) {
      paginationHTML += `<li class="page-item"><a class="page-link" href="#" onclick="changePage(${i})">${i}</a></li>`;
    } else if (i === currentPage - 3 || i === currentPage + 3) {
      paginationHTML += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
    }
  }

  // Next button
  if (currentPage < totalPages) {
    paginationHTML += `
            <li class="page-item">
                <a class="page-link" href="#" onclick="changePage(${currentPage + 1})">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </li>
        `;
  }

  pagination.innerHTML = paginationHTML;
}

// Change page
function changePage(page) {
  currentPage = page;
  renderNews();
  window.scrollTo({ top: 0, behavior: "smooth" });
}

// Open news detail (placeholder)
function openNewsDetail(id) {
  console.log("Haber detayı açılıyor:", id);
  window.location.href = `etkinlikd.html?id=${id}`;
}

// Debounce function
function debounce(func, wait) {
  let timeout;
  return function executedFunction(...args) {
    const later = () => {
      clearTimeout(timeout);
      func(...args);
    };
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
  };
}

// Dropdown arrow alignment logic
document.addEventListener("DOMContentLoaded", () => {
  const dropdowns = document.querySelectorAll(".nav-dropdown");

  const setArrow = (li) => {
    const toggle = li.querySelector(".nav-dropdown-toggle");
    const menu = li.querySelector(".nav-dropdown-menu");
    if (!toggle || !menu) return;

    const cs = getComputedStyle(menu);
    const hidden = cs.display === "none" || cs.visibility === "hidden" || cs.opacity === "0";
    if (hidden) {
      menu.style.visibility = "hidden";
      menu.style.display = "block";
    }

    const t = toggle.getBoundingClientRect();
    const m = menu.getBoundingClientRect();
    const center = t.left + t.width / 2 - m.left;
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

  window.addEventListener("resize", () => {
    document
      .querySelectorAll(".nav-dropdown:hover, .nav-dropdown:focus-within")
      .forEach((li) => setArrow(li));
  });
});

// Dropdown menu alignment logic
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
