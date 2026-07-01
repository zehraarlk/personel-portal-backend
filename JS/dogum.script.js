document.addEventListener('DOMContentLoaded', function() {

    // --- Gerekli Bütün HTML Elementlerini Seçme ---
    const profileBtn = document.getElementById('profileBtn');
    const profileMenu = document.getElementById('profileMenu');
    const menuToggleBtn = document.querySelector('.mobile-menu-toggle');
    const sideMenu = document.getElementById('sideMenu');
    const closeMenuBtn = document.querySelector('.close-menu-btn');
    const menuBackdrop = document.getElementById('menuBackdrop');
    const navDropdown = document.querySelector('.nav-dropdown');
    const dropdownToggle = document.querySelector('.nav-dropdown-toggle');

    // --- MOBİL YAN MENÜ SİSTEMİ ---
    if (menuToggleBtn && sideMenu && closeMenuBtn && menuBackdrop) {
        // Menüyü aç
        menuToggleBtn.addEventListener('click', function() {
            sideMenu.classList.add('active');
            menuBackdrop.classList.add('active');
        });

        // Menüyü kapat (X butonu ile)
        closeMenuBtn.addEventListener('click', function() {
            sideMenu.classList.remove('active');
            menuBackdrop.classList.remove('active');
        });

        // Menüyü kapat (arka plana tıklayarak)
        menuBackdrop.addEventListener('click', function() {
            sideMenu.classList.remove('active');
            menuBackdrop.classList.remove('active');
        });
    }

    // --- PROFİL AÇILIR MENÜ SİSTEMİ ---
    if (profileBtn && profileMenu) {
        profileBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            if (navDropdown) navDropdown.classList.remove('active'); // Diğer menüyü kapat
            profileMenu.classList.toggle('show');
            profileBtn.classList.toggle('active');
        });
    }

    // --- MASAÜSTÜ NAVBAR AÇILIR MENÜ SİSTEMİ ---
    if (navDropdown && dropdownToggle) {
        dropdownToggle.addEventListener('click', function(e) {
            e.preventDefault(); // Sayfanın en üstüne gitmesini engelle
            e.stopPropagation();
            if (profileMenu) profileMenu.classList.remove('show'); // Diğer menüyü kapat
            navDropdown.classList.toggle('active');
        });
    }

    // --- Sayfada Boş Bir Yere veya ESC Tuşuna Basınca Menüleri Kapat ---
    document.addEventListener('click', function(e) {
        if (profileMenu && !profileBtn.contains(e.target) && !profileMenu.contains(e.target)) {
            profileMenu.classList.remove('show');
            profileBtn.classList.remove('active');
        }
        if (navDropdown && !navDropdown.contains(e.target)) {
            navDropdown.classList.remove('active');
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            if (profileMenu) {
                profileMenu.classList.remove('show');
                profileBtn.classList.remove('active');
            }
            if (navDropdown) navDropdown.classList.remove('active');
            if (sideMenu) {
                sideMenu.classList.remove('active');
                menuBackdrop.classList.remove('active');
            }
        }
    });

    // ========================================================
    // GÜNCELLENMİŞ DOĞUM GÜNÜ LİSTELEME VE ETKİLEŞİM KODLARI
    // ========================================================

    // Örnek personel verisi (Departman bilgisi eklendi)
    const personeller = [
        { id: 1, 
          ad: "Tümay", 
          soyad: "AKSAN", 
          dogumTarihi: "1995-08-21", 
          fotoUrl: "images/dogum_gunu/37604190820-tumay-aksan_3957.jpg" },

        { id: 2, 
          ad: "Yavuz", 
          soyad: "AĞAÇ", 
          dogumTarihi: "1992-08-21", 
          fotoUrl: "images/dogum_gunu/32980582726-yavuz-a-ac_5843.jpg" },

        { id: 3, 
          ad: "Zeynep", 
          soyad: "YILMAZ", 
          dogumTarihi: "1995-08-21",  
          fotoUrl: "images/dogum_gunu/manzara.jpg" },

        { id: 4, 
          ad: "Fatih", 
          soyad: "SULTAN MEHMET", 
          dogumTarihi: "1990-08-21", 
          fotoUrl: "images/dogum_gunu/Fatih.jpg" },

          { id: 4, 
          ad: "Fatih", 
          soyad: "SULTAN MEHMET", 
          dogumTarihi: "1990-08-21", 
          fotoUrl: "images/dogum_gunu/Fatih.jpg" },

          { id: 4, 
          ad: "Fatih", 
          soyad: "SULTAN MEHMET", 
          dogumTarihi: "1990-08-21",  
          fotoUrl: "images/dogum_gunu/Fatih.jpg" },

          { id: 4, 
          ad: "Fatih", 
          soyad: "SULTAN MEHMET", 
          dogumTarihi: "1990-08-21", 
          fotoUrl: "images/dogum_gunu/Fatih.jpg" },

          { id: 4, 
          ad: "Fatih", 
          soyad: "SULTAN MEHMET", 
          dogumTarihi: "1990-08-21", 
          fotoUrl: "images/dogum_gunu/Fatih.jpg" },
    ];

    const bugun = new Date();
    const bugunAy = String(bugun.getMonth() + 1).padStart(2, "0");
    const bugunGun = String(bugun.getDate()).padStart(2, "0");

    const bugunDoganlar = personeller.filter(p => {
        const [, ay, gun] = p.dogumTarihi.split("-");
        return ay === bugunAy && gun === bugunGun;
    });

    const listeElementi = document.getElementById("personelListesi");
    const bosMesajElementi = document.getElementById("bosMesaj");

    if (bugunDoganlar.length > 0) {
        bugunDoganlar.forEach(personel => {
            // Yeni kart yapısına uygun HTML oluşturuluyor
            const cardHtml = `
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="birthday-card">
                        <img src="${personel.fotoUrl}" class="card-img-top" alt="${personel.ad} ${personel.soyad}">
                        <div class="card-body">
                            <div>
                                <h5 class="card-title">${personel.ad} ${personel.soyad}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            listeElementi.innerHTML += cardHtml;
        });
    } else {
        bosMesajElementi.classList.remove("d-none");
    }
});
document.addEventListener('DOMContentLoaded', () => {
  const dropdowns = document.querySelectorAll('.nav-dropdown');

  const setArrow = (li) => {
    const toggle = li.querySelector('.nav-dropdown-toggle');
    const menu   = li.querySelector('.nav-dropdown-menu');
    if (!toggle || !menu) return;

    // Menü görünmüyorsa ölçüm için anlık görünür yap
    const cs = getComputedStyle(menu);
    const hidden = cs.display === 'none' || cs.visibility === 'hidden' || cs.opacity === '0';
    if (hidden) { menu.style.visibility = 'hidden'; menu.style.display = 'block'; }

    const t = toggle.getBoundingClientRect();
    const m = menu.getBoundingClientRect();
    const center = (t.left + t.width / 2) - m.left;   // toggle merkezi → menüye göre
    menu.style.setProperty('--arrow-left', `${center}px`);

    if (hidden) { menu.style.display = ''; menu.style.visibility = ''; }
  };

  dropdowns.forEach(li => {
    li.addEventListener('mouseenter', () => setArrow(li));
    li.addEventListener('focusin',    () => setArrow(li));
  });

  // pencere boyutu değişirse yeniden hizala
  window.addEventListener('resize', () => {
    document.querySelectorAll('.nav-dropdown:hover, .nav-dropdown:focus-within')
            .forEach(li => setArrow(li));
  });
});
document.addEventListener('DOMContentLoaded', () => {
    const dropdowns = document.querySelectorAll('.nav-dropdown');

    const alignMenuToCenter = (menuItem) => {
        const menu = menuItem.querySelector('.nav-dropdown-menu');
        const toggle = menuItem.querySelector('.nav-dropdown-toggle');
        if (!menu || !toggle) return;

        // Ekranın ve başlığın merkezini hesapla
        const screenCenter = window.innerWidth / 2;
        const toggleRect = toggle.getBoundingClientRect();
        const toggleCenter = toggleRect.left + toggleRect.width / 2;

        // Başlık ekranın solunda mı sağında mı diye kontrol et
        if (toggleCenter < screenCenter) {
            // SOLDA: Menüyü sağa doğru aç
            menu.classList.add('pull-right');
            menu.classList.remove('pull-left');
        } else {
            // SAĞDA: Menüyü sola doğru aç
            menu.classList.add('pull-left');
            menu.classList.remove('pull-right');
        }
    };

    // Her menünün üzerine gelince hizalama fonksiyonunu çalıştır
    dropdowns.forEach(item => {
        item.addEventListener('mouseenter', () => alignMenuToCenter(item));
    });
});
