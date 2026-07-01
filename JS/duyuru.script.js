// script.js — TEMİZ, GÜNCEL SÜRÜM

document.addEventListener('DOMContentLoaded', () => {
  /* ========= NAVBAR DROPDOWN ========= */
  const navDropdown   = document.querySelector('.nav-dropdown');
  const dropdownToggle= document.querySelector('.nav-dropdown-toggle');
  const dropdownMenu  = document.querySelector('.nav-dropdown-menu');

  if (navDropdown && dropdownToggle && dropdownMenu) {
    dropdownToggle.addEventListener('click', (e) => {
      e.preventDefault();
      e.stopPropagation();
      // profil menüyü kapat
      const profileMenu = document.getElementById('profileMenu');
      const profileBtn  = document.getElementById('profileBtn');
      profileMenu?.classList.remove('show');
      profileBtn?.classList.remove('active');

      navDropdown.classList.toggle('active');
    });

    document.addEventListener('click', (e) => {
      if (!navDropdown.contains(e.target)) navDropdown.classList.remove('active');
    });
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') navDropdown.classList.remove('active');
    });
  }


  /* ========= DUYURU KARTLARI: ANİMASYON + FİLTRE/ARAMA ========= */
  const searchInput = document.getElementById('searchInput'); // "Duyuru ara..."
  const sortSelect  = document.getElementById('sortSelect');  // all / insan / bilgi
  const cards       = Array.from(document.querySelectorAll('.document-card'));

  // açılış animasyonu
  cards.forEach((card, i) => {
    card.style.opacity = '0';
    card.style.transform = 'translateY(30px)';
    setTimeout(() => {
      card.style.transition = 'all 0.6s ease';
      card.style.opacity = '1';
      card.style.transform = 'translateY(0)';
    }, i * 120);
  });

  function applyFilters() {
    const q    = (searchInput?.value || '').trim().toLowerCase();
    const type = (sortSelect?.value || 'all').toLowerCase(); // all | insan | bilgi

    cards.forEach(card => {
      const cardType = (card.dataset.type || '').toLowerCase(); // "insan" / "bilgi"
      const title = card.querySelector('.document-title')?.textContent.toLowerCase() || '';
      const desc  = card.querySelector('.document-description')?.textContent.toLowerCase() || '';

      const matchesType   = (type === 'all') || (cardType === type);
      const matchesSearch = !q || title.includes(q) || desc.includes(q);

      card.style.display = (matchesType && matchesSearch) ? '' : 'none';
    });
  }

  // ilk yüklemede hepsi görünsün
  applyFilters();

  // olay bağla
  sortSelect?.addEventListener('change', applyFilters);
  searchInput?.addEventListener('input', applyFilters);
});

/* ========= (İSTEĞE BAĞLI) DOSYA ÖNİZLEME / İNDİRME =========
   Preview/Download butonları kullanacaksan, aşağıdaki yardımcıları
   butonların onclick'ine bağlayabilirsin.
*/
function previewDocument(fullUrl) {
  const ext = (fullUrl.split('.').pop() || '').toLowerCase();
  let viewerUrl = '';
  if (ext === 'pdf') {
    viewerUrl = fullUrl;
  } else if (['doc', 'docx', 'xls', 'xlsx'].includes(ext)) {
    viewerUrl = `https://docs.google.com/viewer?url=${encodeURIComponent(fullUrl)}&embedded=true`;
  } else {
    alert('Bu dosya türü önizlenemiyor.');
    return;
  }
  window.open(viewerUrl, '_blank');
}

function downloadDocument(fileName, buttonElement) {
  alert(`${fileName} dosyası indiriliyor...`);
  const original = buttonElement.innerHTML;
  buttonElement.innerHTML = `
    <svg viewBox="0 0 24 24" style="width:18px;height:18px;fill:currentColor">
      <path d="M12,4V2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z"></path>
    </svg> İndiriliyor...`;
  setTimeout(() => {
    buttonElement.innerHTML = `
      <svg viewBox="0 0 24 24" style="width:18px;height:18px;fill:currentColor">
        <path d="M21,7L9,19L3.5,13.5L4.91,12.09L9,16.17L19.59,5.59L21,7Z"></path>
      </svg> Tamamlandı`;
    setTimeout(() => (buttonElement.innerHTML = original), 2000);
  }, 1500);
}

document.addEventListener('DOMContentLoaded', function(){
  const navToggle = document.getElementById('navToggle');
  const mainNav   = document.getElementById('mainNav');

  if(navToggle && mainNav){
    navToggle.addEventListener('click', () => {
      const open = mainNav.classList.toggle('is-open');
      navToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
  }

  // Mobilde dropdown'ları tıklamayla aç/kapat
  const mq = window.matchMedia('(max-width: 992px)');
  function wireMobileDropdowns(){
    document.querySelectorAll('.nav-dropdown').forEach(dd => {
      const toggle = dd.querySelector('.nav-dropdown-toggle');
      if(!toggle) return;

      // Eski dinleyicileri temizlemek için clone
      const clone = toggle.cloneNode(true);
      toggle.parentNode.replaceChild(clone, toggle);

      if(mq.matches){
        clone.addEventListener('click', (e) => {
          e.preventDefault();
          dd.classList.toggle('open');
        });
      }else{
        dd.classList.remove('open'); // desktop'ta hover ile açılacak
      }
    });
  }
  wireMobileDropdowns();
  mq.addEventListener('change', wireMobileDropdowns);

  // Dışarı tıklanınca mobil menüyü kapat (isteğe bağlı)
  document.addEventListener('click', (e) => {
    if(!mainNav.contains(e.target) && !navToggle.contains(e.target)){
      mainNav.classList.remove('is-open');
      navToggle.setAttribute('aria-expanded','false');
    }
  });
});

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
