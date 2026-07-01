document.addEventListener('DOMContentLoaded', () => {

    // ===================================================================
    // BÖLÜM 1: VİDEO SAYFASI İÇİN GEREKLİ KODLAR
    // ===================================================================

    // Video Veri Tabanı
 // ===================================================================
// BÖLÜM 1: VİDEO SAYFASI İÇİN GEREKLİ KODLAR
// ===================================================================

// Video Veri Tabanı
const videos = [
    { id: 'qLqYPQgUPEc', title: 'Gebze Offroad Heyecanı', description: 'Nefes kesen anlar ve çamurlu yollar... Offroad tutkunları bu etkinlikte buluştu.', category: 'etkinlikler', duration: '15:22' },
    { id: 'GWfDmGr6tlg', title: 'Yeni Personel İçin İSG Eğitimi', description: 'İş sağlığı ve güvenliği temelleri, tüm yeni personelimiz için önemli bir başlangıç.', category: 'egitimler', duration: '45:10' },
    { id: 'eUBQYWMZyH8', title: 'Bayramlaşma Töreni Duyurusu', description: 'Geleneksel bayramlaşma törenimiz hakkında bilgilendirme. Tüm personelimiz davetlidir.', category: 'duyurular', duration: '01:30' },
    { id: 'pAHStsCd9jo', title: 'Belediye Pikniği 2025', description: 'Geçtiğimiz hafta sonu düzenlediğimiz personel pikniğinden renkli anlar.', category: 'etkinlikler', duration: '05:48' },
    { id: 'psmlNSPRDsM', title: 'Önemli Sistem Güncellemesi', description: 'Bilgi İşlem Daire Başkanlığından önemli duyuru.', category: 'duyurular', duration: '02:15' },
    { id: 'ABIqjRnV5dU', title: 'Etkili İletişim Teknikleri Semineri', description: 'Kurum içi iletişimimizi güçlendirmek için düzenlenen eğitim.', category: 'egitimler', duration: '33:40' },
    { id: 'xot-DBvkkq4', title: 'Gebze Kitap Fuarı Başladı', description: 'Belediyemizin düzenlediği kitap fuarından ilk görüntüler.', category: 'etkinlikler', duration: '08:12' },
    { id: 'BiY2WK24UHY', title: 'Maaş Avansı Kullanım Bilgilendirmesi', description: 'İnsan kaynaklarından personelimize duyuru.', category: 'duyurular', duration: '03:05' },
    { id: 'uUFZvM9kqf4', title: 'Temel Ofis Programları Eğitimi', description: 'Word, Excel ve PowerPoint kullanımı üzerine temel eğitim serisi.', category: 'egitimler', duration: '55:20' },
    { id: 'qdPXmtKXXc4', title: 'Spor Turnuvası Kura Çekimi', description: 'Birimler arası spor turnuvası için kura çekimi heyecanı.', category: 'etkinlikler', duration: '12:50' },
    { id: '3ePuzpC2S0Q', title: 'Yeni Servis Güzergahları Hk.', description: 'Personel servis güzergahlarındaki değişiklikler hakkında duyuru.', category: 'duyurular', duration: '04:18' },
    { id: 'IEc5W0JyADU', title: 'Zaman Yönetimi ve Verimlilik', description: 'Daha verimli çalışmanın ipuçları bu eğitimde.', category: 'egitimler', duration: '28:30' },
    { id: 'RhD1ArYsuKo', title: 'Huzurevi Ziyareti', description: 'Sosyal sorumluluk projemiz kapsamında gerçekleştirdiğimiz ziyaret.', category: 'etkinlikler', duration: '07:25' },
    { id: 'G2KNC3OAnjE', title: 'Yıllık İzin Kullanımı Hakkında', description: 'İnsan kaynaklarından izin kullanımı ile ilgili önemli duyuru.', category: 'duyurular', duration: '02:55' },
    { id: 'Z2dH2UIXb8Y', title: 'Kişisel Verilerin Korunması (KVKK)', description: 'KVKK kanunu kapsamında personelimiz için zorunlu eğitim.', category: 'egitimler', duration: '38:00' },
    { id: 'QRizu8RhGnU', title: 'Fidan Dikme Etkinliği', description: 'Daha yeşil bir Gebze için personelimizle birlikte fidan diktik.', category: 'etkinlikler', duration: '09:45' },
    { id: 'YXat3fIWc7w', title: 'Kantin Fiyat Düzenlemesi', description: 'Yemekhane ve kantin fiyatları hakkındaki yeni düzenleme.', category: 'duyurular', duration: '01:10' },
    { id: 'e65zC48s8Wc', title: 'Stresle Başa Çıkma Yöntemleri', description: 'İş hayatında stresi yönetmek için pratik bilgiler.', category: 'egitimler', duration: '41:12' },
    { id: '-0Wxna6PjqQ', title: 'Sokak Hayvanları Besleme Etkinliği', description: 'Patili dostlarımızı unutmadık, onlarla bir gün geçirdik.', category: 'etkinlikler', duration: '06:33' },
    { id: 'c0vbYSFwMzU', title: 'İş Elbiseleri Dağıtımı', description: 'Yeni dönem iş elbiselerinin dağıtımıyla ilgili duyuru.', category: 'duyurular', duration: '01:45' },
    { id: 'RhVDYrAb0xQ', title: 'Yangın Tatbikatı Eğitimi', description: 'Acil durumlara hazırlık kapsamında düzenlenen eğitim videosu.', category: 'egitimler', duration: '18:55' },
    { id: 'aUQ3uIAfL-k', title: 'Geleneksel Aşure Günü', description: 'Aşure gününde personelimizle bir araya geldik.', category: 'etkinlikler', duration: '04:20' },
    { id: 'D1b-CZYtCTg', title: 'Portal Kullanım Kılavuzu', description: 'Personel portalının nasıl daha etkin kullanılacağına dair video.', category: 'duyurular', duration: '11:30' }
];

    // Gerekli HTML Elementlerini Seçme (Video Bölümü)
    const videoGrid = document.getElementById('video-grid');
    const searchInput = document.getElementById('video-search-input');
    const filterButtons = document.querySelectorAll('.nav-pills .nav-link');
    const noResultsMessage = document.getElementById('no-results-message');
    const paginationContainer = document.querySelector('.pagination');
    const videoModalEl = document.getElementById('videoModal');
    const youtubeIframe = document.getElementById('youtube-iframe');

    const itemsPerPage = 8;
    let currentPage = 1;

    // Videoları Ekrana Çizen Fonksiyon
    const renderVideos = (items) => {
        if (!videoGrid) return;
        videoGrid.innerHTML = '';
        if (items.length === 0) return;
        items.forEach(video => {
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
        const selectedCategory = document.querySelector('.nav-pills .nav-link.active').getAttribute('data-category');
        const searchTerm = searchInput.value.toLowerCase();
        const filteredItems = videos.filter(video => {
            const categoryMatch = (selectedCategory === 'all' || video.category === selectedCategory);
            const searchMatch = video.title.toLowerCase().includes(searchTerm);
            return categoryMatch && searchMatch;
        });
        const paginatedItems = paginate(filteredItems);
        renderVideos(paginatedItems);
        
        if (noResultsMessage) noResultsMessage.style.display = filteredItems.length === 0 ? 'block' : 'none';
        setupPagination(filteredItems);
    };

    // Sayfalama Yapan Fonksiyon
    const paginate = (items) => {
        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        return items.slice(startIndex, endIndex);
    }

    // Sayfalama Butonlarını Oluşturan Fonksiyon
    const setupPagination = (items) => {
        if (!paginationContainer) return;
        const totalPages = Math.ceil(items.length / itemsPerPage);
        paginationContainer.innerHTML = '';
        if (totalPages <= 1) {
            paginationContainer.style.display = 'none';
            return;
        }
        paginationContainer.style.display = 'flex';
        paginationContainer.innerHTML += `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}"><a class="page-link" href="#" aria-label="Önceki" data-page="${currentPage - 1}"><i class="fas fa-chevron-left"></i></a></li>`;
        for (let i = 1; i <= totalPages; i++) {
            paginationContainer.innerHTML += `<li class="page-item ${i === currentPage ? 'active' : ''}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
        }
        paginationContainer.innerHTML += `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}"><a class="page-link" href="#" aria-label="Sonraki" data-page="${currentPage + 1}"><i class="fas fa-chevron-right"></i></a></li>`;
    };

    // Video Sayfası Olay Dinleyicileri
    if (filterButtons.length > 0) {
        filterButtons.forEach(button => {
            button.addEventListener('click', (event) => {
                event.preventDefault();
                filterButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
                currentPage = 1;
                updateDisplay();
            });
        });
    }

    if (searchInput) {
        searchInput.addEventListener('input', () => {
            currentPage = 1;
            updateDisplay();
        });
    }

    if (paginationContainer) {
        paginationContainer.addEventListener('click', (event) => {
            event.preventDefault();
            const target = event.target.closest('a');
            if (target && !target.parentElement.classList.contains('disabled')) {
                currentPage = parseInt(target.getAttribute('data-page'));
                updateDisplay();
            }
        });
    }
    
   if (videoModalEl) {
    videoModalEl.addEventListener('show.bs.modal', (event) => {
        // Tıklanan elementin kendisini alıyoruz, artık .card aramıyoruz.
        const triggerElement = event.relatedTarget; 
        if (triggerElement) {
            // YouTube ID'sini direkt bu elementten alıyoruz.
            const youtubeId = triggerElement.getAttribute('data-youtube-id'); 
            if (youtubeId && youtubeIframe) {
                youtubeIframe.setAttribute('src', `https://www.youtube.com/embed/${youtubeId}?autoplay=1`);
            }
        }
    });

        videoModalEl.addEventListener('hidden.bs.modal', () => {
            if (youtubeIframe) youtubeIframe.setAttribute('src', '');
        });
    }

    // Video sayfası için ilk yükleme
    if (window.location.pathname.includes('video')) {
         updateDisplay();
    }


    // ===================================================================
    // BÖLÜM 2: BÜTÜN MENÜLERİN ÇALIŞMASINI SAĞLAYAN KOD
    // ===================================================================

    // Gerekli HTML Elementlerini Seçme (Menü Bölümü)
    const profileBtn = document.getElementById('profileBtn');
    const profileMenu = document.getElementById('profileMenu');
    const menuToggleBtn = document.querySelector('.mobile-menu-toggle');
    const sideMenu = document.getElementById('sideMenu');
    const closeMenuBtn = document.querySelector('.close-menu-btn');
    const menuBackdrop = document.getElementById('menuBackdrop');
    const navDropdowns = document.querySelectorAll('.nav-dropdown');

    // Mobil Yan Menü (Hamburger)
    if (menuToggleBtn && sideMenu && closeMenuBtn && menuBackdrop) {
        menuToggleBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            sideMenu.classList.add('active');
            menuBackdrop.classList.add('active');
        });
        closeMenuBtn.addEventListener('click', () => {
            sideMenu.classList.remove('active');
            menuBackdrop.classList.remove('active');
        });
        menuBackdrop.addEventListener('click', () => {
            sideMenu.classList.remove('active');
            menuBackdrop.classList.remove('active');
        });
    }

    // Profil Açılır Menüsü
    if (profileBtn && profileMenu) {
        profileBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            navDropdowns.forEach(d => d.classList.remove('active'));
            profileMenu.classList.toggle('show');
        });
    }
    
    // Masaüstü Açılır Menüler
    navDropdowns.forEach(dropdown => {
        const toggle = dropdown.querySelector('.nav-dropdown-toggle');
        if(toggle){
            toggle.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                if (profileMenu) profileMenu.classList.remove('show');
                
                let wasActive = dropdown.classList.contains('active');
                navDropdowns.forEach(d => d.classList.remove('active'));
                
                if (!wasActive) {
                    dropdown.classList.add('active');
                }
            });
        }
    });

    // Boş Yere veya ESC'ye Basınca Menüleri Kapat
    document.addEventListener('click', () => {
        if(profileMenu) profileMenu.classList.remove('show');
        navDropdowns.forEach(d => d.classList.remove('active'));
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            if(sideMenu) sideMenu.classList.remove('active');
            if(menuBackdrop) menuBackdrop.classList.remove('active');
            if(profileMenu) profileMenu.classList.remove('show');
            navDropdowns.forEach(d => d.classList.remove('active'));
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