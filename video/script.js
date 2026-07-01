document.addEventListener('DOMContentLoaded', function() {
    const navDropdown = document.querySelector('.nav-dropdown');
    const dropdownToggle = document.querySelector('.nav-dropdown-toggle');
    const dropdownMenu = document.querySelector('.nav-dropdown-menu');

    if (navDropdown && dropdownToggle && dropdownMenu) {
        dropdownToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            const profileMenu = document.getElementById('profileMenu');
            const profileBtn = document.getElementById('profileBtn');
            if (profileMenu && profileBtn) {
                profileMenu.classList.remove('show');
                profileBtn.classList.remove('active');
            }
            navDropdown.classList.toggle('active');
        });
        const dropdownItems = dropdownMenu.querySelectorAll('.dropdown-item');
        dropdownItems.forEach(item => {
            item.addEventListener('click', function(e) {     
                console.log('Dropdown item clicked:', this.textContent.trim());
                navDropdown.classList.remove('active');
            });
        });
        document.addEventListener('click', function(e) {
            if (!navDropdown.contains(e.target)) {
                navDropdown.classList.remove('active');
            }
        });
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                navDropdown.classList.remove('active');
            }
        });
        dropdownMenu.addEventListener('mouseenter', function() {
      
        });
        dropdownMenu.addEventListener('mouseleave', function() {
            // Mouse menü dışına çıktığında kapat (isteğe bağlı)
            // setTimeout(() => {
            //     navDropdown.classList.remove('active');
            // }, 300);
        });
    }

    // --- PROFİL DROPDOWN SİSTEMİ ---
    const profileBtn = document.getElementById('profileBtn');
    const profileMenu = document.getElementById('profileMenu');

    if (profileBtn && profileMenu) {
        // Profil butonuna tıklama
        profileBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            
            // Navbar dropdown'ını kapat
            if (navDropdown) {
                navDropdown.classList.remove('active');
            }
            
            profileMenu.classList.toggle('show');
            profileBtn.classList.toggle('active');
        });

        document.addEventListener('click', function(e) {
            if (!profileBtn.contains(e.target) && !profileMenu.contains(e.target)) {
                profileMenu.classList.remove('show');
                profileBtn.classList.remove('active');
            }
        });
        const logoutBtn = profileMenu.querySelector('.logout');
        if (logoutBtn) {
            logoutBtn.addEventListener('click', function(e) {
                if (confirm('Çıkış yapmak istediğinizden emin misiniz?')) {
                    console.log('Çıkış yapılıyor...'); 
                  }
            });
        }
            document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                profileMenu.classList.remove('show');
                profileBtn.classList.remove('active');
            }
        });
    }
});
    const tabs = document.querySelectorAll('.tab');
    const contents = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            contents.forEach(c => c.classList.remove('active'));

            tab.classList.add('active');
            document.getElementById(tab.dataset.tab).classList.add('active');
        });
    });
        function escapeHtmlAttribute(str) {
             if (typeof str !== 'string') return '';
             // Tek tırnakları ve çift tırnakları HTML varlıklarına dönüştür
             // Ayrıca özel karakterleri de kaçış karakterleriyle düzenle
             return str.replace(/&/g, '&amp;')
                       .replace(/'/g, '&apos;')
                       .replace(/"/g, '&quot;')
                       .replace(/</g, '&lt;')
                       .replace(/>/g, '&gt;');
         }

         // YouTube video ID'sini URL'den çıkaran fonksiyon
         function getYouTubeVideoId(url) {
             const regex = /(?:youtube\.com\/(?:[^/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[&?]v=)|youtu\.be\/)([^"&?/\s]{11})/i;
             const match = url.match(regex);
             return match ? match[1] : null;
         }

         // Global beğeni ve yorum sayısı depolama
         const videoLikes = {};
         const videoComments = {}; // { videoId: ['Yorum 1', 'Yorum 2'] } şeklinde saklanacak
         let currentLightboxVideoId = null; // Şu anda lightbox'ta açık olan videonun ID'si

         // Slayt Verileri (Sadece video slaytları)
         const slideData = [
             { id: 'video_slide1', type: 'video', url: 'https://www.youtube.com/watch?v=KHVP2TDPozc', title: 'Başladık, Bitirdik! Beylikbağı Mahallesi', desc: 'Beylikbağı Mahallesi, 335 Sokak #İşinÖzüAşklaÇalışmak #Sağlamİşler' },
             { id: 'video_slide2', type: 'video', url: 'https://www.youtube.com/watch?v=uamGfsS2qZo', title: 'Gebze-Darıca Metrosunda İlk Test Sürüşü!', desc: 'Gebze-Darıca Metro Hattında test sürüşü yapıldı. Projenin 2026 yılında hizmete sunulması bekleniyor.' },
             { id: 'v3', url: 'https://www.youtube.com/watch?v=o_8bQ8snkic', title: 'Gebze Kültür Merkezine', desc: 'Gebze Kültür Merkezine sizleri de bekliyoruz.' },
             { id: 'v4', url: 'https://www.youtube.com/watch?v=jOyXFJWZAy0', title: 'Özel Personelimiz Eren', desc: 'Gebze Belediyesinin en özel personeli Eren, enerjisiyle neşe saçıyor.' },
             { id: 'v5', url: 'https://www.youtube.com/watch?v=pAHStsCd9jo', title: 'E-Atık | Kent Madenciliği', desc: 'Atıkların geri dönüşümü hakkında proje tanıtımı.' },
             { id: 'v6', url: 'https://www.youtube.com/watch?v=WkvvDvgJSiE', title: 'Zabıta Parkur', desc: 'Zabıta Parkur Tanıtım Videosu.' }
         ];

         let currentSlide = 0;
         let slideInterval; // Slayt otomatik geçişi için

         // Slaytları render etme fonksiyonu
         function renderSlides() {
             const slidesWrapper = document.getElementById('slidesWrapper');
             const slideDotsContainer = document.getElementById('slideDots');
             slidesWrapper.innerHTML = '';
             slideDotsContainer.innerHTML = '';

             slideData.forEach((data, index) => {
                 // Video beğenilerini ve yorumlarını başlangıçta sıfırla veya mevcut değeri kullan
                 if (!videoLikes[data.id]) {
                    videoLikes[data.id] = 0;
                 }
                 if (!videoComments[data.id]) {
                     videoComments[data.id] = [];
                 }

                 const videoId = getYouTubeVideoId(data.url);
                 const thumbnailUrl = `https://img.youtube.com/vi/${videoId}/maxresdefault.jpg`;
                 const fallbackThumbnailUrl = `https://img.youtube.com/vi/${videoId}/hqdefault.jpg`;

                 const slide = document.createElement('div');
                 slide.classList.add('slide');
                 slide.innerHTML = `
                     <a href="#" onclick="openLightbox(event, '${videoId}', '${escapeHtmlAttribute(data.title)}', '${escapeHtmlAttribute(data.desc)}', '${data.id}')" class="block w-full h-full relative">
                         <img class="w-full h-full object-cover absolute top-0 left-0"
                              src="${thumbnailUrl}"
                              onerror="this.onerror=null; this.src='${fallbackThumbnailUrl}'"
                              alt="${data.title}">
                         <div class="slide-overlay">
                             <h2 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl xl:text-5xl font-extrabold mb-2">${data.title}</h2>
                             <p class="text-sm sm:text-base md:text-lg opacity-90 max-w-3xl mx-auto">${data.desc}</p>
                             <div class="play-button-overlay">
                                 <i class="fas fa-play"></i>
                             </div>
                         </div>
                     </a>
                 `;
                 slidesWrapper.appendChild(slide);

                 const dot = document.createElement('span');
                 dot.classList.add('dot');
                 dot.onclick = () => goToSlide(index);
                 slideDotsContainer.appendChild(dot);
             });

             updateSlideDisplay();
         }

         function updateSlideDisplay() {
             const slidesWrapper = document.getElementById('slidesWrapper');
             const dots = document.querySelectorAll('.dot');

             slidesWrapper.style.transform = `translateX(${-currentSlide * 100}%)`;

             dots.forEach((dot, index) => {
                 if (index === currentSlide) {
                     dot.classList.add('active');
                 } else {
                     dot.classList.remove('active');
                 }
             });
         }

         function changeSlide(direction) {
             currentSlide += direction;
             if (currentSlide < 0) {
                 currentSlide = slideData.length - 1;
             } else if (currentSlide >= slideData.length) {
                 currentSlide = 0;
             }
             updateSlideDisplay();
             resetSlideTimer();
         }

         function goToSlide(index) {
             currentSlide = index;
             updateSlideDisplay();
             resetSlideTimer();
         }

         function startSlideTimer() {
             slideInterval = setInterval(() => {
                 changeSlide(1); // Her 5 saniyede bir sonraki slayta geç
             }, 5000);
         }

         function resetSlideTimer() {
             clearInterval(slideInterval);
             startSlideTimer();
         }

         // Video verileri (ID'ler korunuyor)
         const videos = {
             baskan: [
                 { id: 'v1', url: 'https://www.youtube.com/watch?v=qLqYPQgUPEc', title: 'Gebze\'de OFFROAD Heyecanı', desc: 'Gebze Belediyesi organizasyonuyla Offroad heyecanı.' },
                 { id: 'v2', url: 'https://www.youtube.com/watch?v=GWfDmGr6tlg', title: 'Gebze\'yi Sağlama Aldık', desc: 'Başkanımız, yeni projelerden bahsediyor.' },
                 { id: 'v3', url: 'https://www.youtube.com/watch?v=eUBQYWMZyH8', title: 'Atık Sonu | End of Waste', desc: 'Sıfır Atık projemiz hakkında bilgilendirme.' },
                 { id: 'v4', url: 'https://www.youtube.com/watch?v=sQ_ylQ7hU2M', title: 'Yeni Projeler Tanıtımı', desc: 'Gebze için tasarlanan yeni projeler.' },
                 { id: 'v5', url: 'https://www.youtube.com/watch?v=0JFIfQiGdt8', title: 'Halkla Buluşma Gebze', desc: 'Başkanımız halkla buluşuyor.' },
                 { id: 'v6', url: 'https://www.youtube.com/watch?v=SbWJRen7tmE', title: 'Engelsiz Nakil Aracımız', desc: 'İhtiyaç duyduğunuz her an, Engelsiz Nakil Aracımız ve tüm sosyal olanaklarımız emrinizde.' },
                 { id: 'v7', url: 'https://www.youtube.com/watch?v=kugu3Z-hHVg', title: 'Beylikbağı Güzide Tesisleri', desc: 'Beylikbağı Güzide Tesisleri ve Çevre Düzenleme Projesinde yapım çalışmaları tüm hızıyla sürüyor.' },
                 { id: 'v8', url: 'https://www.youtube.com/watch?v=Z5WBNBxKpUE', title: '5 Yılda Yaptık!', desc: 'Geçmiş 100 yılda yapılandan daha fazlasını 5 yılda yaptık!' }
             ],
             etkinlikler: [
                 { id: 'v9', url: 'https://www.youtube.com/watch?v=pAHStsCd9jo', title: 'E-Atık | Kent Madenciliği', desc: 'Atıkların geri dönüşümü hakkında proje tanıtımı.' },
                 { id: 'v10', url: 'https://www.youtube.com/watch?v=w_Fou1nFtsQ', title: 'Türkiye Panorama II', desc: 'Türkiye’nin dört bir yanından görüntüler.' },
                 { id: 'v11', url: 'https://www.youtube.com/watch?v=Uy8Z1HOkT1U', title: 'Çam Şeşi Bırakma, Ormanlarımızı Hep Yaşat', desc: 'Doğa koruma ve farkındalık kampanyası.' },
                 { id: 'v12', url: 'https://www.youtube.com/watch?v=WkvvDvgJSiE', title: 'Zabıta Parkur', desc: 'Zabıta Parkur Tanıtım Videosu.' },
                 { id: 'v13', url: 'https://www.youtube.com/watch?v=0d-ftOgpOnw', title: 'Yapay Zeka Teknolojisi', desc: 'İlklerin öncüsü Gebze Belediyesinden yapay zeka teknolojisi.' },
                 { id: 'v14', url: 'https://www.youtube.com/watch?v=pkMNDyZjgvY', title: 'Atlı Eğitim Merkezi', desc: 'Gözbebeği evlatlarımız, belediyemize ait atlı eğitim merkezinde hippoterapi ile şifa buluyor.' },
                 { id: 'v15', url: 'https://www.youtube.com/watch?v=o_8bQ8snkic', title: 'Gebze Kültür Merkezine', desc: 'Gebze Kültür Merkezine sizleri de bekliyoruz.' }
             ],
             personel: [
                 { id: 'v16', url: 'https://www.youtube.com/watch?v=jOyXFJWZAy0', title: 'Özel Personelimiz Eren', desc: 'Gebze Belediyesinin en özel personeli Eren, enerjisiyle neşe saçıyor.' },
                 { id: 'v17', url: 'https://www.youtube.com/watch?v=gsoAYR6RxjU', title: 'Gebze Belediyesi Meclisi', desc: 'Gebze Belediyesi Meclisi Gerçekleştirdi.' },
                 { id: 'v18', url: 'https://www.youtube.com/watch?v=T7onTmxN2EM', title: 'Semt Pazarlarımız', desc: 'Semt Pazarlarımız, zabıta ekiplerimizce düzenli olarak denetleniyor.' },
                 { id: 'v19', url: 'https://www.youtube.com/watch?v=Ez_5QWZ6s3I', title: 'Gebze Belediyesi Bağlantı Yolları', desc: 'Gebze Belediyesi Bağlantı Yolları Açılmaya Devam Ediyor.' },
                 { id: 'v20', url: 'https://www.youtube.com/watch?v=utQNWrhWy0M', title: '36 Bin Tapu Teslim Töreni', desc: 'Gebze Belediyesinden 36 bin tapu teslim töreni.' }
             ],
             shorts: [
                 { id: 'v21', url: 'https://www.youtube.com/watch?v=KHVP2TDPozc', title: 'Başladık, Bitirdik!', desc: 'Başladık, Bitirdik! Beylikbağı Mahallesi, 335 Sokak #İşinÖzüAşklaÇalışmak #Sağlamİşler' },
                 { id: 'v22', url: 'https://www.youtube.com/watch?v=METyl0T3bmQ', title: 'Tertemiz Bir Gebze İçin', desc: 'Tertemiz bir Gebze için gece gündüz demeden çalışıyoruz.' },
                 { id: 'v23', url: 'https://www.youtube.com/watch?v=uamGfsS2qZo', title: 'Gebze-Darıca Metrosunda İlk Test Sürüşü!', desc: 'Gebze-Darıca Metro Hattında test sürüşü yapıldı. Projenin 2026 yılında hizmete sunulması bekleniyor.' },
                 { id: 'v24', url: 'https://www.youtube.com/watch?v=YUqUu1ryj5E', title: 'Cumaköy Mesire Alanımız', desc: 'Temelini attığımız WC ve mescit inşasının ardından Cumaköy Mesire Alanımız %100 tamamlanmış olacak.' },
                 { id: 'v25', url: 'https://www.youtube.com/watch?v=FaAufyquOA0', title: 'Her Parkurda Ayrı Bir Heyecan!', desc: 'Her parkurda ayrı bir heyecan!' },
                 { id: 'v26', url: 'https://www.youtube.com/watch?v=rq-KXUVeo9c', title: 'Gebze Millet Bahçesi', desc: 'Gündüzü güzel, gecesi ayrı bi güzel😊📍Gebze Millet Bahçesi' },
                 { id: 'v27', url: 'https://www.youtube.com/watch?v=UjC3cD8wKCg', title: 'Cumaköy Mesire Alanı', desc: 'Doğanın kalbinde bir gün Cumaköy Mesire Alanı.' },
                 { id: 'v28', url: 'https://www.youtube.com/watch?v=zFYQGBIeyVo', title: 'Ahmet Pembegüllü Spor Tesisimizde', desc: 'Ahmet Pembegüllü Spor Tesisimizde, Futbol sahası Tamam.' },
                 { id: 'v29', url: 'https://www.youtube.com/watch?v=ctb3VMqDx3A', title: 'Güzide Kampüs', desc: 'Gebze Teknik Üniversitesi içerisinde bir "Güzide Kampüs" daha yapıyoruz.' }
             ]
         };

         // Sayfalandırma için genel değişkenler
         const videosPerPage = 12; // Sayfa başına gösterilecek video sayısı
         let currentPage = 1;
         let currentFilteredVideos = []; // Şu anki filtrelenmiş/aranmış tüm videolar
         let currentCategoryName = 'Tümü'; // Pagination başlığı için

         // Video kutusunu açma ve kapatma fonksiyonları
         function openLightbox(event, videoId, title, description, originalItemId) {
             event.preventDefault(); // Varsayılan bağlantı davranışını engelle
             const lightbox = document.getElementById('videoLightbox');
             const iframe = document.getElementById('lightboxVideoIframe');
             const lightboxTitle = document.getElementById('lightboxVideoTitle');
             const lightboxDescription = document.getElementById('lightboxVideoDescription');
             const lightboxLikeCount = document.getElementById('lightboxLikeCount');
             const lightboxCommentCount = document.getElementById('lightboxCommentCount');
             const lightboxCommentSection = document.getElementById('lightboxCommentSection');
             
             currentLightboxVideoId = originalItemId; // Lightbox'ta açılan videonun ID'sini sakla

             // Video beğenilerini ve yorumlarını başlangıçta sıfırla veya mevcut değeri kullan
             if (!videoLikes[originalItemId]) {
                 videoLikes[originalItemId] = 0;
             }
             if (!videoComments[originalItemId]) {
                 videoComments[originalItemId] = [];
             }

             iframe.src = `https://www.youtube.com/embed/${videoId}?autoplay=1&modestbranding=1&rel=0`;
             lightboxTitle.textContent = title;
             lightboxDescription.textContent = description;
             lightboxLikeCount.textContent = videoLikes[originalItemId]; // Lightbox'ı açarken mevcut beğeni sayısını göster
             lightboxCommentCount.textContent = videoComments[originalItemId].length; // Mevcut yorum sayısını göster

             // Yorum bölümünü gizle ve yorumları yükle
             lightboxCommentSection.classList.add('hidden');
             renderComments(originalItemId);

             lightbox.classList.add('open');
         }

         function closeLightbox() {
             const lightbox = document.getElementById('videoLightbox');
             const iframe = document.getElementById('lightboxVideoIframe');
             iframe.src = ''; // Videoyu durdurmak için src'yi temizle
             lightbox.classList.remove('open');
             document.getElementById('lightboxVideoTitle').textContent = ''; // Başlığı temizle
             document.getElementById('lightboxVideoDescription').textContent = ''; // Açıklamayı temizle
             document.getElementById('lightboxLikeCount').textContent = '0'; // Beğeni sayacını da temizle
             document.getElementById('lightboxCommentCount').textContent = '0'; // Yorum sayacını da temizle
             document.getElementById('lightboxCommentSection').classList.add('hidden'); // Yorum bölümünü gizle
             currentLightboxVideoId = null; // Lightbox kapandığında ID'yi sıfırla
         }

         // Beğenme fonksiyonu
         function likeVideo(videoId) {
             if (!videoLikes[videoId]) {
                 videoLikes[videoId] = 0;
             }
             videoLikes[videoId]++;

             // Video listesindeki beğenme sayısını güncelle (eğer mevcut sayfada görünüyorsa)
             const cardLikeSpan = document.getElementById(`like_${videoId}`);
             if (cardLikeSpan) {
                 cardLikeSpan.textContent = videoLikes[videoId];
             }

             // Lightbox'taki beğenme sayısını güncelle (eğer açıksa ve bu videoyu gösteriyorsa)
             const lightboxLikeSpan = document.getElementById('lightboxLikeCount');
             if (lightboxLikeSpan && currentLightboxVideoId === videoId) {
                 lightboxLikeSpan.textContent = videoLikes[videoId];
             }
         }

         // Yorum bölümünü açıp kapatma
         function toggleCommentSection() {
             const commentSection = document.getElementById('lightboxCommentSection');
             commentSection.classList.toggle('hidden');
             if (!commentSection.classList.contains('hidden')) {
                 renderComments(currentLightboxVideoId);
             }
         }

         // Yorumları render etme
         function renderComments(videoId) {
             const commentListDiv = document.getElementById('lightboxCommentList');
             commentListDiv.innerHTML = '';
             const comments = videoComments[videoId] || [];
             if (comments.length === 0) {
                 commentListDiv.innerHTML = '<p class="text-center text-gray-500 italic">Henüz yorum yapılmamış.</p>';
             } else {
                 comments.forEach(comment => {
                     const div = document.createElement('div');
                     div.classList.add('comment-item');
                     div.textContent = comment;
                     commentListDiv.appendChild(div);
                 });
             }
         }

         // Yorum gönderme fonksiyonu
         function submitComment() {
             const commentInput = document.getElementById('commentInput');
             const commentText = commentInput.value.trim();

             if (commentText && currentLightboxVideoId) {
                 if (!videoComments[currentLightboxVideoId]) {
                     videoComments[currentLightboxVideoId] = [];
                 }
                 videoComments[currentLightboxVideoId].push(commentText);
                 commentInput.value = ''; // Inputu temizle
                 renderComments(currentLightboxVideoId); // Yorumları yeniden render et

                 // Yorum sayacını güncelle
                 const cardCommentSpan = document.getElementById(`comment_${currentLightboxVideoId}`);
                 if (cardCommentSpan) {
                     cardCommentSpan.textContent = videoComments[currentLightboxVideoId].length;
                 }
                 const lightboxCommentCount = document.getElementById('lightboxCommentCount');
                 if (lightboxCommentCount) {
                     lightboxCommentCount.textContent = videoComments[currentLightboxVideoId].length;
                 }
             }
         }

         // Video öğesi ekleyen fonksiyon
         function addVideo(video) {
             const videoList = document.getElementById("videoList");
             const item = document.createElement("div");
             item.classList.add("video-item");

             // Video beğenilerini ve yorumlarını başlangıçta sıfırla veya mevcut değeri kullan
             if (!videoLikes[video.id]) {
                videoLikes[video.id] = 0;
             }
             if (!videoComments[video.id]) {
                 videoComments[video.id] = [];
             }

             const videoId = getYouTubeVideoId(video.url);
             const thumbnailUrl = `https://img.youtube.com/vi/${videoId}/hqdefault.jpg`;

             item.innerHTML = `
                 <div class="video-player-container" onclick="openLightbox(event, '${videoId}', '${escapeHtmlAttribute(video.title)}', '${escapeHtmlAttribute(video.desc)}', '${video.id}')">
                     <img class="video-thumbnail" src="${thumbnailUrl}" alt="${video.title} - Video Önizleme">
                     <div class="play-button">
                         <i class="fas fa-play"></i>
                     </div>
                 </div>
                 <div class="video-info">
                     <h3>${video.title}</h3>
                     <p>${video.desc}</p>
                     <div class="action-buttons">
                         <button class="like-btn" onclick="event.stopPropagation(); likeVideo('${video.id}')">
                             <i class="fas fa-heart"></i> Beğen <span id="like_${video.id}">${videoLikes[video.id]}</span>
                         </button>
                         <button class="comment-btn" onclick="event.stopPropagation(); openLightbox(event, '${videoId}', '${escapeHtmlAttribute(video.title)}', '${escapeHtmlAttribute(video.desc)}', '${video.id}'); toggleCommentSection();">
                             <i class="fas fa-comment"></i> Yorum <span id="comment_${video.id}">${videoComments[video.id].length}</span>
                         </button>
                     </div>
                 </div>
             `;
             videoList.appendChild(item);
         }

         // Sayfaya videoları render etme fonksiyonu
         function displayVideosForPage(page) {
             const videoList = document.getElementById("videoList");
             videoList.innerHTML = ""; // Mevcut videoları temizle

             const startIndex = (page - 1) * videosPerPage;
             const endIndex = startIndex + videosPerPage;
             const videosToDisplay = currentFilteredVideos.slice(startIndex, endIndex);

             if (videosToDisplay.length > 0) {
                 videosToDisplay.forEach(video => addVideo(video));
             } else {
                 videoList.innerHTML = '<p class="text-center text-gray-600 text-lg py-10">Bu kategoriye/aramaya uygun video bulunamadı.</p>';
             }
             document.getElementById('videoListSectionTitle').textContent = `${currentCategoryName} Videoları`;
         }

         // Sayfalandırma kontrollerini render etme fonksiyonu
         function renderPaginationControls() {
             const paginationControls = document.getElementById('paginationControls');
             paginationControls.innerHTML = ''; // Mevcut kontrolleri temizle

             const totalPages = Math.ceil(currentFilteredVideos.length / videosPerPage);

             if (totalPages <= 1) { // Tek sayfa varsa pagination gösterme
                 return;
             }

             // Önceki Sayfa butonu
             const prevButton = document.createElement('button');
             prevButton.textContent = 'Önceki';
             prevButton.disabled = currentPage === 1;
             prevButton.onclick = () => goToPage(currentPage - 1);
             paginationControls.appendChild(prevButton);

             // Sayfa numarası butonları
             for (let i = 1; i <= totalPages; i++) {
                 const pageButton = document.createElement('button');
                 pageButton.textContent = i;
                 pageButton.classList.add('page-number');
                 if (i === currentPage) {
                     pageButton.classList.add('active');
                 }
                 pageButton.onclick = () => goToPage(i);
                 paginationControls.appendChild(pageButton);
             }

             // Sonraki Sayfa butonu
             const nextButton = document.createElement('button');
             nextButton.textContent = 'Sonraki';
             nextButton.disabled = currentPage === totalPages;
             nextButton.onclick = () => goToPage(currentPage + 1);
             paginationControls.appendChild(nextButton);
         }

         // Belirli bir sayfaya gitme fonksiyonu
         function goToPage(pageNumber) {
             currentPage = pageNumber;
             displayVideosForPage(currentPage);
             renderPaginationControls();
             window.scrollTo({ top: document.getElementById('videoListSectionTitle').offsetTop - 100, behavior: 'smooth' }); // Video listesine kaydır
         }

         // Kategoriye göre videoları gösteren fonksiyon
         function showCategory(category, event) {
             currentFilteredVideos = [];

             // Tüm kategori butonlarındaki 'active' sınıfını kaldır
             document.querySelectorAll(".category-buttons button").forEach(btn => btn.classList.remove("active"));

             // Tıklanan butona 'active' sınıfını ekle
             if (event && event.target) {
                 event.target.classList.add("active");
                 currentCategoryName = event.target.textContent;
             } else if (category === "all") {
                  document.querySelector('.category-buttons button[onclick*="all"]').classList.add('active');
                  currentCategoryName = 'Tümü';
             }

             if (category === "all") {
                 Object.keys(videos).forEach(cat => {
                     currentFilteredVideos = currentFilteredVideos.concat(videos[cat]);
                 });
             } else {
                 if (videos[category]) {
                     currentFilteredVideos = videos[category];
                 }
             }

             currentPage = 1; // Her kategori değişiminde ilk sayfaya dön
             displayVideosForPage(currentPage);
             renderPaginationControls();
         }

         // Videoları arama fonksiyonu
         function searchVideos() {
             let input = document.getElementById("searchInput").value.toLowerCase();
             currentFilteredVideos = [];
             currentCategoryName = `"${input}" Araması`;

             // Arama yapıldığında kategori butonlarındaki 'active' sınıfını kaldır
             document.querySelectorAll(".category-buttons button").forEach(btn => btn.classList.remove("active"));

             // Tüm kategorilerdeki videoları ara
             Object.keys(videos).forEach(cat => {
                 videos[cat].forEach(video => {
                     let title = video.title.toLowerCase();
                     let desc = video.desc.toLowerCase();
                     if (title.includes(input) || desc.includes(input)) {
                         currentFilteredVideos.push(video);
                     }
                 });
             });

             currentPage = 1; // Her aramada ilk sayfaya dön
             displayVideosForPage(currentPage);
             renderPaginationControls();
         }

         // Sayfa yüklendiğinde slaytı ve video listesini başlat
         document.addEventListener('DOMContentLoaded', () => {
             // Tüm videoların initial like ve comment sayısını 0 olarak ayarla
             Object.keys(videos).forEach(cat => {
                 videos[cat].forEach(video => {
                     if (!videoLikes[video.id]) {
                         videoLikes[video.id] = 0;
                     }
                     if (!videoComments[video.id]) {
                         videoComments[video.id] = [];
                     }
                 });
             });
             // Slayt verileri için de beğenileri ve yorumları başlat
             slideData.forEach(slide => {
                 if (!videoLikes[slide.id]) {
                     videoLikes[slide.id] = 0;
                 }
                 if (!videoComments[slide.id]) {
                     videoComments[slide.id] = [];
                 }
             });

             renderSlides(); // Slaytı render et
             startSlideTimer(); // Slaytın otomatik geçişini başlat
             showCategory("all"); // Varsayılan olarak tüm videoları göster ve sayfalandır
         });