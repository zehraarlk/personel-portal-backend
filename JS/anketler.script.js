// ========== DOM HAZIR OLDUĞUNDA ÇALIŞACAK KODLAR ==========
document.addEventListener("DOMContentLoaded", function () {
  console.log("Sayfa yüklendi, JavaScript başlatılıyor...");

  // Cihaz hover destekliyor mu? (Masaüstü) -> hover, Aksi (Mobil/Touch) -> click
  const isHoverable = window.matchMedia("(hover:hover) and (pointer:fine)").matches;

  const dropdowns = document.querySelectorAll(".nav-dropdown");

  dropdowns.forEach((dd) => {
    const toggle = dd.querySelector(".nav-dropdown-toggle");
    const menu = dd.querySelector(".nav-dropdown-menu");
    if (!toggle || !menu) return;

    if (isHoverable) {
      // Masaüstü: hover ile açılacak. Tıklama yeni sayfa açmasın.
      toggle.addEventListener("click", (e) => e.preventDefault());
      // (Hover işi CSS ile; burada ekstra JS şart değil ama tutarlılık için aktif sınıfı yönetebiliriz)
      dd.addEventListener("mouseenter", () => dd.classList.add("active"));
      dd.addEventListener("mouseleave", () => dd.classList.remove("active"));
    } else {
      // Mobil/Touch: tıklama ile aç/kapat
      toggle.addEventListener("click", function (e) {
        e.preventDefault();
        e.stopPropagation();
        // Diğer açık menüleri kapat
        dropdowns.forEach((other) => {
          if (other !== dd) other.classList.remove("active");
        });
        // Bu menüyü aç/kapat
        dd.classList.toggle("active");
      });
    }
  });

  // Dışarı tıklamada kapat
  document.addEventListener("click", function (e) {
    dropdowns.forEach((dd) => {
      if (!dd.contains(e.target)) dd.classList.remove("active");
    });
  });

  // ESC ile kapat
  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") dropdowns.forEach((dd) => dd.classList.remove("active"));
  });

  /* --- Profil menüsü, arama, filtre vb. mevcut kodların aynen kalabilir --- */

  // ========== PROFİL DROPDOWN SİSTEMİ ==========
  const profileBtn = document.getElementById("profileBtn");
  const profileMenu = document.getElementById("profileMenu");

  if (profileBtn && profileMenu) {
    console.log("Profil buton ve menü bulundu");

    // Profil butonuna tıklama
    profileBtn.addEventListener("click", function (e) {
      console.log("Profil butonuna tıklandı");
      e.preventDefault();
      e.stopPropagation();

      // Navbar dropdown'ını kapat
      if (navDropdown) {
        navDropdown.classList.remove("active");
      }

      // Profil menüsünü aç/kapat
      profileMenu.classList.toggle("show");
      profileBtn.classList.toggle("active");

      console.log("Profil menü durumu:", profileMenu.classList.contains("show"));
    });

    // Sayfa herhangi bir yerine tıklandığında menüyü kapat
    document.addEventListener("click", function (e) {
      if (!profileBtn.contains(e.target) && !profileMenu.contains(e.target)) {
        profileMenu.classList.remove("show");
        profileBtn.classList.remove("active");
      }
    });

    // Profil menü item'larına tıklama
    const profileMenuItems = profileMenu.querySelectorAll(".profile-menu-item");
    profileMenuItems.forEach((item) => {
      item.addEventListener("click", function (e) {
        e.preventDefault();
        console.log("Profil menü item tıklandı:", this.textContent.trim());

        // Çıkış yap butonuna özel işlem
        if (this.classList.contains("logout")) {
          if (confirm("Çıkış yapmak istediğinizden emin misiniz?")) {
            console.log("Çıkış yapılıyor...");
            // window.location.href = '/logout'; // Gerçek uygulamada kullanılır
            alert("Çıkış işlemi simülasyonu - Gerçek uygulamada yönlendirme yapılacak");
          }
        } else {
          // Diğer menü itemları için işlem
          alert("Bu özellik henüz aktif değil: " + this.textContent.trim());
        }

        // Menüyü kapat
        profileMenu.classList.remove("show");
        profileBtn.classList.remove("active");
      });
    });

    // ESC tuşu ile menüyü kapat
    document.addEventListener("keydown", function (e) {
      if (e.key === "Escape") {
        profileMenu.classList.remove("show");
        profileBtn.classList.remove("active");
      }
    });
  } else {
    console.log("Profil buton veya menü bulunamadı");
    console.log("profileBtn:", profileBtn);
    console.log("profileMenu:", profileMenu);
  }

  // ========== ARAMA FONKSİYONU ==========
  const searchInput = document.getElementById("searchInput");
  if (searchInput) {
    console.log("Arama input bulundu");

    searchInput.addEventListener("input", function (e) {
      const searchTerm = e.target.value.toLowerCase();
      const surveyItems = document.querySelectorAll(".survey-item");
      let hasResults = false;

      console.log("Arama yapılıyor:", searchTerm);

      surveyItems.forEach((item) => {
        const title = item.querySelector(".survey-title");
        const desc = item.querySelector(".survey-desc");

        if (title && desc) {
          const titleText = title.textContent.toLowerCase();
          const descText = desc.textContent.toLowerCase();

          if (titleText.includes(searchTerm) || descText.includes(searchTerm)) {
            item.style.display = "block";
            hasResults = true;
          } else {
            item.style.display = "none";
          }
        }
      });

      // Boş durum mesajını göster/gizle
      const emptyState = document.getElementById("emptyState");
      if (emptyState) {
        if (!hasResults && searchTerm !== "") {
          emptyState.classList.remove("d-none");
        } else {
          emptyState.classList.add("d-none");
        }
      }
    });
  } else {
    console.log("Arama input bulunamadı");
  }

  // ========== YENİ FİLTRE TAB SİSTEMİ ==========
  const filterTabs = document.querySelectorAll(".filter-tab");
  if (filterTabs.length > 0) {
    console.log("Filtre tabları bulundu:", filterTabs.length);

    filterTabs.forEach((tab) => {
      tab.addEventListener("click", function () {
        console.log("Filtre tab tıklandı:", this.getAttribute("data-filter"));

        // Aktif filtre tabını güncelle
        filterTabs.forEach((t) => t.classList.remove("active"));
        this.classList.add("active");

        const filter = this.getAttribute("data-filter");
        const surveyItems = document.querySelectorAll(".survey-item");
        let hasResults = false;

        surveyItems.forEach((item) => {
          const category = item.getAttribute("data-category");
          if (filter === "all" || category === filter) {
            item.style.display = "block";
            hasResults = true;
          } else {
            item.style.display = "none";
          }
        });

        // Boş durum mesajını göster/gizle
        const emptyState = document.getElementById("emptyState");
        if (emptyState) {
          if (!hasResults) {
            emptyState.classList.remove("d-none");
          } else {
            emptyState.classList.add("d-none");
          }
        }
      });
    });
  } else {
    console.log("Filtre tabları bulunamadı");
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

// ========== FAVORİ TOGGLE FONKSİYONU (GLOBAL) ==========
function toggleFavorite(btn) {
  console.log("Favori toggle çağrıldı");

  const icon = btn.querySelector("i");
  const textNodes = Array.from(btn.childNodes).filter((node) => node.nodeType === Node.TEXT_NODE);

  if (icon) {
    if (icon.classList.contains("far")) {
      // Favoriye ekle
      icon.classList.remove("far");
      icon.classList.add("fas");
      btn.classList.remove("btn-outline-warning");
      btn.classList.add("btn-warning");

      // Text node'u güncelle
      textNodes.forEach((node) => {
        if (node.textContent.trim().includes("Favoriye Ekle")) {
          node.textContent = " Favorilerden Çıkar";
        }
      });

      console.log("Favoriye eklendi");
    } else {
      // Favorilerden çıkar
      icon.classList.remove("fas");
      icon.classList.add("far");
      btn.classList.remove("btn-warning");
      btn.classList.add("btn-outline-warning");

      // Text node'u güncelle
      textNodes.forEach((node) => {
        if (node.textContent.trim().includes("Favorilerden Çıkar")) {
          node.textContent = " Favoriye Ekle";
        }
      });

      console.log("Favorilerden çıkarıldı");
    }
  }
}

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
