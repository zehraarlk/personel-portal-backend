document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("searchInput");
  const filterButtons = document.querySelectorAll(".filter-btn");
  const documentCards = document.querySelectorAll(".document-card");

  // 🔍 ARAMA
  searchInput.addEventListener("input", function () {
    const searchTerm = searchInput.value.toLowerCase();
    documentCards.forEach((card) => {
      const title = card.querySelector(".document-title").textContent.toLowerCase();
      const description = card.querySelector(".document-description").textContent.toLowerCase();
      if (title.includes(searchTerm) || description.includes(searchTerm)) {
        card.style.display = "block";
      } else {
        card.style.display = "none";
      }
    });
  });

  // 📂 FİLTRELEME
  filterButtons.forEach((button) => {
    button.addEventListener("click", function () {
      filterButtons.forEach((btn) => btn.classList.remove("active"));
      this.classList.add("active");

      const filterValue = this.getAttribute("data-filter");
      const searchTerm = searchInput.value.toLowerCase();

      documentCards.forEach((card) => {
        const category = card.getAttribute("data-category");
        const title = card.querySelector(".document-title").textContent.toLowerCase();
        const description = card.querySelector(".document-description").textContent.toLowerCase();

        const matchesFilter = filterValue === "all" || category === filterValue;
        const matchesSearch = title.includes(searchTerm) || description.includes(searchTerm);

        if (matchesFilter && matchesSearch) {
          card.style.display = "block";
        } else {
          card.style.display = "none";
        }
      });
    });
  });
});

// 📥 İNDİRME BUTONU ANİMASYONU
function downloadDocument(fileName, buttonElement) {
  alert(`${fileName} dosyası indiriliyor...`);

  const originalText = buttonElement.innerHTML;

  buttonElement.innerHTML = `
        <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: currentColor;">
            <path d="M12,4V2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z"/>
        </svg>
        İndiriliyor...
    `;

  setTimeout(() => {
    buttonElement.innerHTML = `
            <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; fill: currentColor;">
                <path d="M21,7L9,19L3.5,13.5L4.91,12.09L9,16.17L19.59,5.59L21,7Z"/>
            </svg>
            Tamamlandı
        `;

    setTimeout(() => {
      buttonElement.innerHTML = originalText;
    }, 2000);
  }, 1500);
}

// 👁 ÖNİZLEME BUTONU (PDF, Word, Excel)
function previewDocument(fullUrl) {
  const ext = fullUrl.split(".").pop().toLowerCase();
  let viewerUrl = "";

  if (ext === "pdf") {
    viewerUrl = fullUrl;
  } else if (["doc", "docx", "xls", "xlsx"].includes(ext)) {
    viewerUrl = `https://docs.google.com/viewer?url=${encodeURIComponent(fullUrl)}&embedded=true`;
  } else {
    alert("Bu dosya türü önizlenemiyor.");
    return;
  }

  window.open(viewerUrl, "_blank");
}
// Sayfa yüklendiğinde 'Dökümanlar' filtresini uygula
document.addEventListener("DOMContentLoaded", function () {
  const defaultFilter = "regulation";
  const searchTerm = ""; // Arama kutusu boş

  document.querySelectorAll(".document-card").forEach((card) => {
    const category = card.getAttribute("data-category");
    const title = card.querySelector(".document-title").textContent.toLowerCase();
    const description = card.querySelector(".document-description").textContent.toLowerCase();

    const matchesFilter = category === defaultFilter;
    const matchesSearch = title.includes(searchTerm) || description.includes(searchTerm);

    if (matchesFilter && matchesSearch) {
      card.style.display = "block";
    } else {
      card.style.display = "none";
    }
  });
});
document.addEventListener("DOMContentLoaded", function () {
  const filterButtons = document.querySelectorAll(".filter-btn");

  filterButtons.forEach((button) => {
    button.addEventListener("click", () => {
      const target = button.dataset.filter;

      // Yönlendirme için sayfa isimlerini burada belirt
      if (target === "protocol") {
        window.location.href = "protokol.html";
      } else if (target === "document") {
        window.location.href = "dokumanlar.html";
      } else if (target === "regulation") {
        window.location.href = "mevzuat.html";
      } else if (target === "training") {
        window.location.href = "egitim.html";
      }
    });
  });
});

const SortSelect = document.getElementById("sortSelect");
document.addEventListener("DOMContentLoaded", function () {
  updateTotalCount();
  renderNews();
  setupEventListeners();
});
function setupEventListeners() {
  // Navbar dropdown functionality from your existing code
  const navDropdown = document.querySelector(".nav-dropdown");
  const dropdownToggle = document.querySelector(".nav-dropdown-toggle");
  const dropdownMenu = document.querySelector(".nav-dropdown-menu");

  if (navDropdown && dropdownToggle && dropdownMenu) {
    dropdownToggle.addEventListener("click", function (e) {
      e.preventDefault();
      e.stopPropagation();

      const profileMenu = document.getElementById("profileMenu");
      const profileBtn = document.getElementById("profileBtn");
      if (profileMenu && profileBtn) {
        profileMenu.classList.remove("show");
        profileBtn.classList.remove("active");
      }

      navDropdown.classList.toggle("active");
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
  const profileBtn = document.getElementById("profileBtn");
  const profileMenu = document.getElementById("profileMenu");

  if (profileBtn && profileMenu) {
    profileBtn.addEventListener("click", function (e) {
      e.stopPropagation();

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
function updateResultsCount() {
  if (resultsCount) {
    resultsCount.innerHTML = `<strong>${filteredData.length}</strong> sonuç bulundu`;
  }
}
const sortSelect = document.getElementById("sortSelect");
const allCards = document.querySelectorAll(".document-card");

sortSelect.addEventListener("change", function () {
  const selectedType = this.value;

  allCards.forEach((card) => {
    const cardType = card.dataset.type;
    const cardCategory = card.dataset.category;

    // Sadece regulation (mevzuat) içindekilere uygula
    if (cardCategory === "regulation") {
      if (selectedType === "all" || cardType === selectedType) {
        card.style.display = "block";
      } else {
        card.style.display = "none";
      }
    } else {
      // Mevzuat dışı kartlar gizlenmeden gösterilmeye devam eder
      card.style.display = "block";
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
document.addEventListener("DOMContentLoaded", function () {
  const readMoreButtons = document.querySelectorAll(".read-more-btn");

  readMoreButtons.forEach((button) => {
    button.addEventListener("click", function (event) {
      event.preventDefault();

      const card = this.closest(".document-card");
      const title = card.querySelector(".document-title");
      const description = card.querySelector(".document-description");

      title.classList.toggle("expanded");
      description.classList.toggle("expanded");

      if (description.classList.contains("expanded")) {
        this.textContent = "Daha Az Göster";
      } else {
        this.textContent = "Devamını Oku";
      }
    });
  });
});
