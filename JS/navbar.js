document.addEventListener("DOMContentLoaded", () => {
  if (window.__portalNavbarInit) return;
  window.__portalNavbarInit = true;

  let profileBtn = document.getElementById("profileBtn");
  const profileMenu = document.getElementById("profileMenu");
  const profileDropdown = document.querySelector(".profile-dropdown");
  const menuToggleBtn = document.querySelector(".mobile-menu-toggle");
  const sideMenu = document.getElementById("sideMenu");
  const closeMenuBtn = document.querySelector(".close-menu-btn");
  const menuBackdrop = document.getElementById("menuBackdrop");
  const navDropdowns = document.querySelectorAll(".nav-dropdown");

  const closeNavMenus = () => {
    navDropdowns.forEach((d) => d.classList.remove("active"));
    if (profileMenu) {
      profileMenu.classList.remove("show");
    }
    if (profileBtn) {
      profileBtn.classList.remove("active");
      profileBtn.setAttribute("aria-expanded", "false");
    }
  };

  const closeMobileMenu = () => {
    if (sideMenu) sideMenu.classList.remove("active");
    if (menuBackdrop) menuBackdrop.classList.remove("active");
  };

  if (menuToggleBtn && sideMenu && menuBackdrop) {
    menuToggleBtn.addEventListener("click", (e) => {
      e.preventDefault();
      e.stopPropagation();
      closeNavMenus();
      sideMenu.classList.add("active");
      menuBackdrop.classList.add("active");
    });
  }

  if (closeMenuBtn) {
    closeMenuBtn.addEventListener("click", (e) => {
      e.preventDefault();
      closeMobileMenu();
    });
  }

  if (menuBackdrop) {
    menuBackdrop.addEventListener("click", closeMobileMenu);
  }

  if (profileBtn && profileMenu) {
    const freshProfileBtn = profileBtn.cloneNode(true);
    profileBtn.parentNode.replaceChild(freshProfileBtn, profileBtn);
    profileBtn = freshProfileBtn;

    profileBtn.addEventListener("click", (e) => {
      e.preventDefault();
      e.stopPropagation();
      navDropdowns.forEach((d) => d.classList.remove("active"));
      const isOpen = !profileMenu.classList.contains("show");
      profileMenu.classList.toggle("show", isOpen);
      profileBtn.classList.toggle("active", isOpen);
      profileBtn.setAttribute("aria-expanded", isOpen ? "true" : "false");
    });

    profileMenu.addEventListener("click", (e) => {
      e.stopPropagation();
    });

    const logoutBtn = profileMenu.querySelector(".logout");
    if (logoutBtn) {
      logoutBtn.addEventListener("click", (e) => {
        e.preventDefault();
        if (confirm("Çıkış yapmak istediğinizden emin misiniz?")) {
          window.location.href = "login.php";
        }
      });
    }

    profileMenu.querySelectorAll(".profile-menu-item:not(.logout)").forEach((item) => {
      item.addEventListener("click", (e) => {
        e.preventDefault();
        closeNavMenus();
      });
    });
  }

  navDropdowns.forEach((dropdown) => {
    const toggle = dropdown.querySelector(".nav-dropdown-toggle");
    if (!toggle) return;

    toggle.addEventListener("click", (e) => {
      e.preventDefault();
      e.stopPropagation();
      if (profileMenu) profileMenu.classList.remove("show");
      if (profileBtn) profileBtn.classList.remove("active");

      const wasActive = dropdown.classList.contains("active");
      navDropdowns.forEach((d) => d.classList.remove("active"));
      if (!wasActive) dropdown.classList.add("active");
    });
  });

  document.addEventListener("click", (e) => {
    if (profileDropdown && profileDropdown.contains(e.target)) return;
    navDropdowns.forEach((dropdown) => {
      if (dropdown.contains(e.target)) return;
      dropdown.classList.remove("active");
    });
    if (profileMenu) profileMenu.classList.remove("show");
    if (profileBtn) {
      profileBtn.classList.remove("active");
      profileBtn.setAttribute("aria-expanded", "false");
    }
  });

  document.addEventListener("keydown", (e) => {
    if (e.key !== "Escape") return;
    closeMobileMenu();
    closeNavMenus();
  });
});
