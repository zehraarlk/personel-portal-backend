// ========== DOM HAZIR OLDUĞUNDA ÇALIŞACAK KODLAR ==========
document.addEventListener("DOMContentLoaded", function () {
  let activeFilter = "all";

  function getSurveyItems() {
    return document.querySelectorAll("#surveyContainer .survey-item");
  }

  function updateEmptyState(hasResults, searchTerm = "") {
    const emptyState = document.getElementById("emptyState");
    const emptyStateText = document.getElementById("emptyStateText");
    if (!emptyState) return;
    if (!hasResults) {
      emptyState.classList.remove("d-none");
      if (emptyStateText) {
        if (activeFilter === "favorites") {
          emptyStateText.textContent = "Henüz favori anketiniz bulunmuyor.";
        } else if (searchTerm) {
          emptyStateText.textContent = "Aradığınız kriterlere uygun anket bulunamadı.";
        } else {
          emptyStateText.textContent = "Bu kategoride anket bulunamadı.";
        }
      }
    } else {
      emptyState.classList.add("d-none");
    }
  }

  function itemMatchesFilter(item) {
    const category = item.getAttribute("data-category");
    const isFavorite = item.getAttribute("data-favorite") === "1";

    if (activeFilter === "all") return true;
    if (activeFilter === "favorites") return isFavorite;
    return category === activeFilter;
  }

  function itemMatchesSearch(item, searchTerm) {
    if (!searchTerm) return true;
    const title = item.querySelector(".survey-title");
    const desc = item.querySelector(".survey-desc");
    if (!title || !desc) return false;
    const text = (title.textContent + " " + desc.textContent).toLowerCase();
    return text.includes(searchTerm);
  }

  function applyFilters() {
    const searchTerm = (document.getElementById("searchInput")?.value || "").toLowerCase();
    let hasResults = false;

    getSurveyItems().forEach((item) => {
      const visible = itemMatchesFilter(item) && itemMatchesSearch(item, searchTerm);
      item.style.display = visible ? "" : "none";
      if (visible) hasResults = true;
    });

    updateEmptyState(hasResults, searchTerm);
  }

  function setFavoriteState(item, isFavorite) {
    item.setAttribute("data-favorite", isFavorite ? "1" : "0");
    const btn = item.querySelector(".favorite-toggle-btn");
    if (btn) {
      btn.classList.toggle("active", isFavorite);
      const label = isFavorite ? "Favorilerden Çıkar" : "Favorilere Ekle";
      btn.setAttribute("aria-label", label);
      btn.innerHTML = `<i class="${isFavorite ? "fas" : "far"} fa-star me-2"></i>${label}`;
    }
  }

  function syncFavoriteState(id, isFavorite) {
    document.querySelectorAll(`.survey-item[data-id="${id}"]`).forEach((item) => {
      setFavoriteState(item, isFavorite);
    });
  }

  async function toggleFavorite(btn) {
    const item = btn.closest(".survey-item");
    if (!item) return;

    const id = item.getAttribute("data-id");
    const isFavorite = item.getAttribute("data-favorite") !== "1";
    const newValue = isFavorite ? 1 : 0;

    btn.disabled = true;

    try {
      const formData = new FormData();
      formData.append("id", id);
      formData.append("favori", String(newValue));

      const response = await fetch("anket_favori.php", {
        method: "POST",
        body: formData,
      });
      const data = await response.json();

      if (!response.ok || !data.ok) {
        throw new Error(data.message || "Favori güncellenemedi.");
      }

      syncFavoriteState(id, isFavorite);
      applyFilters();
      showToast(
        isFavorite ? "Anket favorilere eklendi." : "Anket favorilerden çıkarıldı.",
        isFavorite ? "warning" : "secondary"
      );
    } catch (error) {
      showToast(error.message || "Bir hata oluştu.", "danger");
    } finally {
      btn.disabled = false;
    }
  }

  function bindFavoriteButtons(root = document) {
    root.querySelectorAll(".favorite-toggle-btn").forEach((btn) => {
      if (btn.dataset.bound === "1") return;
      btn.dataset.bound = "1";
      btn.addEventListener("click", function (e) {
        e.preventDefault();
        e.stopPropagation();
        toggleFavorite(this);
      });
    });
  }

  bindFavoriteButtons();

  // ========== ARAMA FONKSİYONU ==========
  const searchInput = document.getElementById("searchInput");
  if (searchInput) {
    searchInput.addEventListener("input", function () {
      applyFilters();
    });
  }

  // ========== FİLTRE TAB SİSTEMİ ==========
  const filterTabs = document.querySelectorAll(".filter-tab");
  if (filterTabs.length > 0) {
    filterTabs.forEach((tab) => {
      tab.addEventListener("click", function () {
        filterTabs.forEach((t) => t.classList.remove("active"));
        this.classList.add("active");
        activeFilter = this.getAttribute("data-filter") || "all";
        applyFilters();
      });
    });
  }

  // ========== BİLDİRİM SİSTEMİ ==========
  const notificationBell = document.querySelector(".notification-bell");
  if (notificationBell) {
    console.log("Bildirim bell bulundu");

    notificationBell.addEventListener("click", function () {
      console.log("Bildirim tıklandı");
      alert(
        "3 yeni bildiriminiz var:\n• Yeni anket: Personel Memnuniyet Anketi\n• Anket hatırlatması: Eğitim İhtiyaç Analizi\n• Sonuçlar hazır: İş Ortamı Değerlendirme"
      );
    });
  }

 // ========== ANKET KARTLARI İNTERAKSİYONU ==========
  const surveyBtns = document.querySelectorAll(".survey-btn");
  surveyBtns.forEach((btn) => {
    btn.addEventListener("click", function (e) {
      // Eğer buton gerçek bir linke (anket_katil.php veya sonuclar.php) gidiyorsa engelleme yapma
      if (this.getAttribute("href") !== "#") {
        return; 
      }
      
      e.preventDefault();
      console.log("Anket butonu tıklandı");

      if (this.classList.contains("completed")) {
        alert("Anket sonuçları görüntüleniyor...");
      } else if (this.classList.contains("expired")) {
        alert("Bu anketin süresi dolmuştur.");
      } else {
        alert("Ankete yönlendiriliyor...");
      }
    });
  });

  // ========== SIRALAMA SİSTEMİ ==========
  const sortSelect = document.querySelector(".sort-select");
  if (sortSelect) {
    console.log("Sıralama select bulundu");

    sortSelect.addEventListener("change", function (e) {
      const sortType = e.target.value;
      console.log("Sıralama seçildi:", sortType);

      const surveyContainer = document.getElementById("surveyContainer");
      const surveyItems = Array.from(surveyContainer.querySelectorAll(".survey-item"));

      // Sıralama işlemi
      surveyItems.sort((a, b) => {
        switch (sortType) {
          case "En Yeni":
            return sortByDate(a, b, false); // Yeniden eskiye
          case "En Eski":
            return sortByDate(a, b, true); // Eskiden yeniye
          case "Popülerlik":
            return sortByPopularity(a, b);
          default:
            return sortByDate(a, b, false); // Varsayılan: En yeni
        }
      });

      // Sıralanmış öğeleri DOM'a tekrar ekle
      surveyItems.forEach((item) => {
        surveyContainer.appendChild(item);
      });

      // Smooth scroll efekti
      surveyContainer.style.opacity = "0.7";
      setTimeout(() => {
        surveyContainer.style.opacity = "1";
      }, 150);
    });
  } else {
    console.log("Sıralama select bulunamadı");
  }

  console.log("Tüm JavaScript event listener'ları başarıyla yüklendi");
});

// ========== SIRALAMA YARDIMCI FONKSİYONLARI ==========

// Tarihe göre sıralama
function sortByDate(a, b, ascending = true) {
  const dateA = extractDate(a);
  const dateB = extractDate(b);

  if (!dateA || !dateB) return 0;

  return ascending ? dateA - dateB : dateB - dateA;
}

// Popülerliğe göre sıralama (katılım oranına göre)
function sortByPopularity(a, b) {
  const participationA = extractParticipation(a);
  const participationB = extractParticipation(b);

  return participationB - participationA; // Yüksekten düşüğe
}

// Anket kartından tarihi çıkar
function extractDate(surveyItem) {
  const dateElement = surveyItem.querySelector(".survey-date");
  if (!dateElement) return null;

  const dateText = dateElement.textContent;
  // Tarih formatı: "09.10.2024 - 15.11.2024"
  const dateMatch = dateText.match(/(\d{2})\.(\d{2})\.(\d{4})/);

  if (dateMatch) {
    const [, day, month, year] = dateMatch;
    return new Date(year, month - 1, day); // JavaScript ayları 0-11 arası
  }

  return null;
}

// Katılım oranını çıkar
function extractParticipation(surveyItem) {
  const participationElement = surveyItem.querySelector(".participation-rate");
  if (!participationElement) return 0;

  const participationText = participationElement.textContent;
  // Format: "Katılım: 45/120 kişi" veya "%37"

  // Yüzde değerini ara
  const percentMatch = participationText.match(/(\d+)%/);
  if (percentMatch) {
    return parseInt(percentMatch[1]);
  }

  // Oran değerini ara (45/120)
  const ratioMatch = participationText.match(/(\d+)\/(\d+)/);
  if (ratioMatch) {
    const [, current, total] = ratioMatch;
    return Math.round((parseInt(current) / parseInt(total)) * 100);
  }

  return 0;
}

// ========== YARDIMCI FONKSİYONLAR ==========
// Smooth scroll fonksiyonu
function smoothScrollTo(element) {
  if (element) {
    element.scrollIntoView({
      behavior: "smooth",
      block: "start",
    });
  }
}

// Loading state gösterme
function showLoading(element) {
  if (element) {
    element.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Yükleniyor...';
    element.disabled = true;
  }
}

// Loading state gizleme
function hideLoading(element, originalText) {
  if (element) {
    element.innerHTML = originalText;
    element.disabled = false;
  }
}

// Toast mesaj gösterme (Bootstrap kullanarak)
function showToast(message, type = "info") {
  const toastHTML = `
        <div class="toast align-items-center text-white bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    `;

  // Toast container'ı oluştur (yoksa)
  let toastContainer = document.querySelector(".toast-container");
  if (!toastContainer) {
    toastContainer = document.createElement("div");
    toastContainer.className = "toast-container position-fixed bottom-0 end-0 p-3";
    document.body.appendChild(toastContainer);
  }

  // Toast'ı ekle
  const tempDiv = document.createElement("div");
  tempDiv.innerHTML = toastHTML.trim();
  const toastElement = tempDiv.firstChild;

  toastContainer.appendChild(toastElement);

  // Bootstrap Toast'ı başlat
  const toast = new bootstrap.Toast(toastElement, {
    autohide: true,
    delay: 5000,
  });

  toast.show();

  // Temizleme için event listener
  toastElement.addEventListener("hidden.bs.toast", function () {
    toastElement.remove();
  });
}
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
