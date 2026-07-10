// Etkinlik listesi — veritabanından (window.eventData)
const newsData = Array.isArray(window.eventData) ? window.eventData : [];
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
  // ---- Mobil MenÃ¼ ----
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

  // ---- MasaÃ¼stÃ¼ Dropdown MenÃ¼ler ----
  const navDropdowns = document.querySelectorAll(".nav-dropdown");
  navDropdowns.forEach((navDropdown) => {
    const dropdownToggle = navDropdown.querySelector(".nav-dropdown-toggle");
    if (dropdownToggle) {
      dropdownToggle.addEventListener("click", function (e) {
        e.preventDefault();
        e.stopPropagation();
        // DiÄŸer aÃ§Ä±k menÃ¼leri kapat
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

  // ---- Profil Dropdown MenÃ¼sÃ¼ ----
  const profileBtn = document.getElementById("profileBtn");
  const profileMenu = document.getElementById("profileMenu");
  if (profileBtn && profileMenu) {
    profileBtn.addEventListener("click", function (e) {
      e.stopPropagation();
      // DiÄŸer aÃ§Ä±k menÃ¼leri kapat
      document.querySelectorAll(".nav-dropdown.active").forEach((openMenu) => {
        openMenu.classList.remove("active");
      });
      profileMenu.classList.toggle("show");
      profileBtn.classList.toggle("active");
    });
  }

  // ---- Sayfaya TÄ±klayÄ±nca veya ESC basÄ±nca menÃ¼leri kapatma ----
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

  // ---- Arama FonksiyonlarÄ± ----
  if (searchInput && searchBtn) {
    searchInput.addEventListener("input", debounce(handleSearch, 300));
    searchBtn.addEventListener("click", handleSearch);
    searchInput.addEventListener("keypress", function (e) {
      if (e.key === "Enter") {
        handleSearch();
      }
    });
  }

  // ---- Filtreleme ve SÄ±ralama ----
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

// Filter function - Sort dropdown'a gÃ¶re filtreleme
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
  handleFilter(); // Sort dropdown deÄŸiÅŸtiÄŸinde filtrelemeyi yeniden yap
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

// Show news grid - GÃ¼ncellenmiÅŸ durum badge'i ile
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
    resultsCount.innerHTML = `<strong>${filteredData.length}</strong> sonuÃ§ bulundu`;
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
  console.log("Haber detayÄ± aÃ§Ä±lÄ±yor:", id);
  window.location.href = `etkinlikd.php?id=${id}`;
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
