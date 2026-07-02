// Sample data - Bu veriler gerçek uygulamada API'den gelecek
let filteredData = [...newsData];
let currentPage = 1;
const itemsPerPage = 8; // 4'lü grid için 8 kart gösteriyoruz

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

// Initialize
document.addEventListener("DOMContentLoaded", function () {
  updateTotalCount();
  renderNews();
  setupEventListeners(); // Bütün olayları başlatan ana fonksiyon
});

// ===== BÜTÜN OLAY DİNLEYİCİLERİNİ (EVENT LISTENERS) YÖNETEN ANA FONKSİYON =====
function setupEventListeners() {
  // --- Gerekli Bütün HTML Elementlerini Seçme ---
  const profileBtn = document.getElementById("profileBtn");
  const profileMenu = document.getElementById("profileMenu");
  const menuToggleBtn = document.querySelector(".mobile-menu-toggle");
  const sideMenu = document.getElementById("sideMenu");
  const closeMenuBtn = document.querySelector(".close-menu-btn");
  const menuBackdrop = document.getElementById("menuBackdrop");
  const navDropdowns = document.querySelectorAll(".nav-dropdown");

  // --- MOBİL YAN MENÜ SİSTEMİ (HAMBURGER) ---
  if (menuToggleBtn && sideMenu && closeMenuBtn && menuBackdrop) {
    // Menüyü aç
    menuToggleBtn.addEventListener("click", function (e) {
      e.stopPropagation();
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
      e.stopPropagation(); // Tıklamanın sayfaya yayılmasını engelle
      // Diğer açık olabilecek tüm menüleri kapat
      navDropdowns.forEach((otherDropdown) => {
        otherDropdown.classList.remove("active");
      });
      // Profil menüsünü aç/kapat
      profileMenu.classList.toggle("show");
      profileBtn.classList.toggle("active");
    });
  }

  // --- MASAÜSTÜ NAVBAR AÇILIR MENÜLERİ ---
  navDropdowns.forEach((dropdown) => {
    const toggle = dropdown.querySelector(".nav-dropdown-toggle");
    if (toggle) {
      toggle.addEventListener("click", function (e) {
        e.preventDefault();
        e.stopPropagation();
        // Diğer açık menüleri kapat
        if (profileMenu) profileMenu.classList.remove("show");
        navDropdowns.forEach((otherDropdown) => {
          if (otherDropdown !== dropdown) {
            otherDropdown.classList.remove("active");
          }
        });
        // Bu menüyü aç/kapat
        dropdown.classList.toggle("active");
      });
    }
  });

  // --- Sayfada Boş Bir Yere Tıklayınca VEYA ESC Tuşuna Basınca Tüm Menüleri Kapat ---
  document.addEventListener("click", function (e) {
    // Profil menüsünü kapat
    if (profileMenu && !profileMenu.contains(e.target) && !profileBtn.contains(e.target)) {
      profileMenu.classList.remove("show");
      profileBtn.classList.remove("active");
    }
    // Navbar menülerini kapat
    navDropdowns.forEach((dropdown) => {
      if (!dropdown.contains(e.target)) {
        dropdown.classList.remove("active");
      }
    });
  });

  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") {
      // Mobil menüyü kapat
      if (sideMenu && menuBackdrop) {
        sideMenu.classList.remove("active");
        menuBackdrop.classList.remove("active");
      }
      // Profil menüsünü kapat
      if (profileMenu) {
        profileMenu.classList.remove("show");
        profileBtn.classList.remove("active");
      }
      // Navbar menülerini kapat
      navDropdowns.forEach((dropdown) => {
        dropdown.classList.remove("active");
      });
    }
  });

  // --- ARAMA, FİLTRELEME VE SIRALAMA FONKSİYONLARI ---

  // Search functionality
  if (searchInput && searchBtn) {
    searchInput.addEventListener("input", debounce(handleSearch, 300));
    searchBtn.addEventListener("click", handleSearch);
    searchInput.addEventListener("keypress", function (e) {
      if (e.key === "Enter") {
        handleSearch();
      }
    });
  }

  // Filter buttons
  filterBtns.forEach((btn) => {
    btn.addEventListener("click", function () {
      filterBtns.forEach((b) => b.classList.remove("active"));
      this.classList.add("active");
      handleFilter(this.dataset.category);
    });
  });

  // Sort functionality
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
        item.title.toLowerCase().includes(query) ||
        item.excerpt.toLowerCase().includes(query) ||
        item.categoryName.toLowerCase().includes(query)
    );
  }
  currentPage = 1;
  renderNews();
}

// Filter function
function handleFilter(category) {
  if (category === "all") {
    filteredData = [...newsData];
  } else {
    filteredData = newsData.filter((item) => item.category === category);
  }
  currentPage = 1;
  renderNews();
}

// Sort function
function handleSort() {
  const sortType = sortSelect.value;
  switch (sortType) {
    case "newest":
      filteredData.sort(
        (a, b) =>
          new Date(b.date.split(".").reverse().join("-")) -
          new Date(a.date.split(".").reverse().join("-"))
      );
      break;
    case "oldest":
      filteredData.sort(
        (a, b) =>
          new Date(a.date.split(".").reverse().join("-")) -
          new Date(b.date.split(".").reverse().join("-"))
      );
      break;
    case "most-viewed":
      filteredData.sort((a, b) => b.views - a.views);
      break;
    case "alphabetical":
      filteredData.sort((a, b) => a.title.localeCompare(b.title, "tr"));
      break;
  }
  renderNews();
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

// Show news grid
function showNewsGrid(items) {
  if (newsGrid) {
    newsGrid.classList.remove("d-none");
    if (noResults) noResults.classList.add("d-none");

    newsGrid.innerHTML = items
      .map(
        (item) => `
    <div class="news-card" onclick="openNewsDetail(${item.id})">
        <img src="${item.image}" alt="${item.title}" class="news-image" loading="lazy">
        <div class="news-content">
            <h4 class="news-department-name">${item.categoryName}</h4>
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
        `
      )
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
      paginationHTML += `
                <li class="page-item active">
                    <span class="page-link">${i}</span>
                </li>
            `;
    } else if (i === 1 || i === totalPages || (i >= currentPage - 2 && i <= currentPage + 2)) {
      paginationHTML += `
                <li class="page-item">
                    <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
                </li>
            `;
    } else if (i === currentPage - 3 || i === currentPage + 3) {
      paginationHTML += `
                <li class="page-item disabled">
                    <span class="page-link">...</span>
                </li>
            `;
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
  // Bu fonksiyon gerçek uygulamada detay sayfasına yönlendirme yapacak
  console.log("Haber detayı açılıyor:", id);
  window.location.href = `sizden.html?${id}`;
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

// ===== MENÜ GÖRSEL İYİLEŞTİRMELERİ (OK ve HİZALAMA) =====

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
