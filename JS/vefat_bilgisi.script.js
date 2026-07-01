// Vefat verileri - Toplamda 36 kişi (3 sayfa x 12 kart)
const vefatData = [
  // Sayfa 1 (1-12)
  {
    name: "Sedat TÜRKKAN",
    position: "Destek Hizmetleri Müdürlüğü personeli Ali Türkkan'ın Babası ",
    deathDate: "21 Aralık 2024",
    message:
      "Destek Hizmetleri Müdürlüğü personeli Ali Türkkan'ın babası  Sedat Türkkan Vefat etmiştir.Cenazesi Yarın öğlen namazına müteakip Gebze Kargalı Köyü Camii'nden kaldırılacaktır. İrtibat: Ali Türkkan 05312611643",
  },
  {
    name: "Emine AYDIN GÜL",
    position: "Temizlik İşleri Müdürlüğü personeli Fahrettin Aydın'ın kardeşi",
    deathDate: "21 Aralık 2024",
    message:
      "Temizlik İşleri Müdürlüğü personeli Fahrettin Aydın'ın kardeşi Emine Aydın Gül vefat etmiştir.Cenazesi bugün öğlen namazına müteakip Darıca Fevzi Çakmak Mahallesi Camii'nden kaldırılacaktır. İrtibat:05356598417",
  },
  {
    name: "Cevat ALTINTAŞ Annesi",
    position: "Teftiş Kurulu Müdürü Cevat Altıntaş'ın annesi",
    deathDate: "21 Aralık 2024",
    message:
      "Teftiş Kurulu Müdürü Cevat Altıntaş'ın annesi vefat etmiştir.Cenazesi yarın öğlen namazına müteakip Trabzon,Sürmene Petekli Mahallesi Camii'nden kaldırılacaktır. İrtibat:05337219067",
  },
  {
    name: "Nevzat TAŞKIN",
    position: "Kültür Ve Sosyal İşler Müdürlüğü Personeli Engin Taşkın'ın abisi",
    deathDate: "15 Ocak 2024",
    message:
      "Kültür Ve Sosyal İşler Müdürlüğü Personeli Engin Taşkın'ın abisi Nevzat Taşkın vefat etmiştir. Cenazesi bugün öğlen namazına müteakip memleketi Yalova'dan kaldırılcaktır.İrtibat: Engin Taşkın 05327823276",
  },
  {
    name: "Yavuz HORASAN Babası",
    position: "İşletme ve İştirakler Müdürlüğü Personeli Yavuz Horasın'ın babası ",
    deathDate: "15 Ocak 2024",
    message:
      "İşletme ve İştirakler Müdürlüğü Personeli Yavuz Horasın'ın babası vefat etmiştir. Cenazesi bugün ikindi namazına müteakip Tokat Turhal'dan kaldırılcaktır. İrtibat: Yavuz Horasan 05335423041",
  },
  {
    name: "Mehmet tevfik ŞAHİN",
    position: "Destek Hizmetleri Müdürlüğü personeli Haluk Şahin'in abisi",
    deathDate: "26 Aralık 2023",
    message:
      "Destek Hizmetleri Müdürlüğü personeli Haluk Şahin'in abisi Mehmet Teşvik Şahin vefat etmiştir. Cenazesi öğlen namazına müteakip Eskişehir Günyüzü'nde kaldırılacaktır. İrtibat: Haluk Şahin 05326311898",
  },
  {
    name: "Yusuf BİTMEZ",
    position: "Emekli Belediye Başkan Danışmanımız Şakir Bitmez'in babası",
    deathDate: "25 Aralık 2023",
    message:
      "Emekli Belediye Başkan Danışmanımız Şakir Bitmez'in babası Yusuf Bitmez vefat etmiştir.Cenazesi bugün ikindi namazına müteakip Pendik Yayalar Mahallesi Mehmet Akif Ersoy Camii'nden kaldırılacaktır.",
  },
  {
    name: "Erdoğan POLAT",
    position: "Park Ve Bahçeler Müdürlüğü Personeli  Tarık Polat'ın amcası",
    deathDate: "20 Aralık 2023",
    message:
      "Park Ve Bahçeler Müdürlüğü Personeli Tarık Polat'ın amcası Erdoğan Polat vefat etmiştir.Cenazesi bugün ikindi namazına müteakip Çayırova Bedir Camii'nden kaldırılacaktır. İrtibat: Tarık Polat 05072524854",
  },
  {
    name: "Enver YAZICI'NIN Kayınvalidesi",
    position: "Kültür Müdürlüğü Personeli Enver Yazıcı'nın kayınvalidesi",
    deathDate: "20 Aralık 2023",
    message:
      "Kültür Müdürlüğü Personeli Enver Yazıcı'nın kayınvalidesi vefat etmiştir. Cenazesi bugün Cuma namazına müteakip  Eskihisar Akşemseddin Camii'nden kaldırılacaktır. İrtibat: Enver Yazıcı 05423454169",
  },
  {
    name: "Hafız Bahattin YİĞİT",
    position: "Güvenlik Personellerimiz Adnan Yiğit ve Fuat Yiğit'in babası",
    deathDate: "15 Aralık 2023",
    message:
      "Güvenlik Personellerimiz Adnan Yiğit ve Fuat Yiğit'in babası Hafız Bahattin Yiğit vefat etmiştir. Cenazesi Cumartesi öğlen namazına müteakip Hürriyet Mahallesi  Hz.Osman Camiin'den kaldırılacaktır. İrtibat: Adnan Yiğit 05333502447-Fuat Yiğit 05421867958",
  },
  {
    name: "İsmail BİNGÖL Babası",
    position: "Temizlik İşleri Müdürlüğü Personeli İsmail Bingöl'ün babası",
    deathDate: "12 Aralık 2023",
    message:
      "Temizlik İşleri Müdürlüğü Personeli İsmail Bingöl'ün babası vefat etmiştir. Cenazesi bugün öğlen namazına müteakip kaldırılacaktır. İrtibat: İsmail Bingöl 05354091358",
  },
  {
    name: "Cengiz AĞAÜZÜM",
    position: "Belediyemizin Emekli Personeli Cengiz Ağaüzüm",
    deathDate: "12 Aralık 2023",
    message:
      "Belediyemizin Emekli Personeli Cengiz Ağaüzüm vefat etmiştir. Cenazesi bugün ikindi namazına müteakip Yıldız Camii'nden kaldırılacaktır.İrtibat: Engin Ağaüzüm 05343033746",
  },

  // Sayfa 2 (13-24)
  {
    name: "Nuray Dal",
    position: "Etüt Proje Müdürlüğü Personeli Günay Çatak'ın ablası",
    deathDate: "12 Aralık 2023",
    message:
      "Etüt Proje Müdürlüğü Personeli Günay Çatak'ın ablası Nury Dal vefat etmiştir. Cenazesi yarın öğlen namazına müteakip Aydın İli Çine İlçesinden kaldırılacaktır.",
  },
  {
    name: "Ali Osman İŞÇİ",
    position: "Emlak ve İstimlak Müdürlüğü Personeli Salih Katı'nın Kayınpederi",
    deathDate: "12 Aralık 2023",
    message:
      "Emlak ve İstimlak Müdürlüğü Personeli Salih Katı'nın Kayınpederi Ali Osman İşçi vefat etmiştir. Cenazesi bugün öğle namazına müteakip Darıa Emek Mahallesi Merkez Camii'nden kaldırılacaktır. İrtibat: Salih Katı 05327433232 ",
  },
  {
    name: "Fikar KESKİNOĞLU",
    position: "Basın Yayın Ve Halkla İlişkiler Müdürü Mecit Keskinoğlu'nun Yengesi",
    deathDate: "5 Aralık 2023",
    message:
      "Basın Yayın Ve Halkla İlişkiler Müdürü Mecit Keskinoğlu'nun Yengesi Fikar Keskinoğlu vefat etmiştir. Cenazesi yarın öğlen namazına müteakip Nenehatun Mahallesi Eyüpoğlu Camii'nden kaldırılacaktır. İrtibat: Mecit Keskinoğlu 05359431643",
  },
  {
    name: "Murat ÇOBAN'ın Ablası",
    position: "Belediyemizin emekli personeli Murat Çoban'ın Ablası",
    deathDate: "29 Kasım 2023",
    message:
      "Belediyemizin emekli personeli Murat Çoban'ın ablası vefat etmiştir. Cenazesi bugün öğle namazına müteakip Darıca'dan kaldırılacaktır. İrtibat:",
  },
  {
    name: "Teyfik BAYRAM",
    position: "Zabıta Müdürlüğü Güvenlik Personeli Olcay Bayram'ın Babası",
    deathDate: "24 Kasım 2023",
    message:
      "Zabıta Müdürlüğü Güvenlik Personeli Olcay Bayram'ın babası Teyfik Bayram vefat etmiştir. Cenazesi bugün öğle namazına mütakip memleketi Amasya'dan kaldırılcaktır. İrtibat: Olcay Bayram 0546226207",
  },
  {
    name: "Ahmet KARDEŞ'in Amcası",
    position: "Ruhsat Müdürlüğü Personeli Ahmet Kardeş'in amcası ",
    deathDate: "23 Kasım 2023",
    message:
      "Ruhsat Müdürlüğü Personeli Ahmet Kardeş'in amcası vefat etmiştir. Cenazesi bugün öğle namazına müteakip Yenimahalle Merkez Camii'nden kaldırılacaktır. İrtibat: Ahmet Kardeş 05370308461",
  },
  {
    name: "Ramazan ZOR'un Halası",
    position: "Basın Yayın Halkla İlişkiler Müdürlüğü Personeli Ramazan Zor'un Halası",
    deathDate: "13 Kasım 2023",
    message:
      "Baın Yayın Halkla İlişkiler Müdürlüğü Personeli Ramazan Zor'un halası vefat etmiştir. Cenazesi yarın öğlen namazına müteakip İlyasbey Camii'nden kaldırılacaktır. İrtibat: Ramazan Zor 05333360656",
  },
  {
    name: "Davut Şahin",
    position: "Etüt Proje Müdürlüğü Personeli Ömer Şahin'in Amcası",
    deathDate: "6 Kasım 2023",
    message:
      "Etüt Proje Müdürlüğü Personeli Ömer Şahin'in amcası Davut Şahin vefat etmiştir. Cenazesi bugün öğle namazına müteakip İstanbul Rüzgarlı Bahçe Camii'nden kaldırılacaktır. İrtibat Ömer Şahin 05387303472 ",
  },
  {
    name: "Remzi DURAN",
    position: " Destek Hizmetleri Personeli Tenzile Deniz'in Babası",
    deathDate: "6 Kasım 2023",
    message:
      "Destek Hizmetleri Personeli Tenzile Deniz'in babası Remzi Duran vefat etmiştir. Cenazesi bugün Öğlen namazına müteakip Elbizli Mahallesinde kaldırılacaktır.İrtibat: Tenzile Deniz 05454151007",
  },
  {
    name: "İsmet YILMAZ",
    position: "Destek Hizmetleri Personeli İlker Yılmaz'ın Babası",
    deathDate: "6 Kasım 2023",
    message:
      "Destek Hizmetleri Personeli İlker Yılmaz'ın babası İsmet Yılmaz vefat etmiştir.Cenazesi yarın öğle namazına müteakip Beylikbağı Fatih Camii'nden kaldırılacaktır. İrtibat: İlker YILMAZ 05438092966",
  },
  {
    name: "Erdal GÜNEY'ın Kayınbiraderi",
    position: "Temizlik İşleri Personeli Nazım Ertürk'ün abisi Erdal Güney'ın Kayınbiraderi",
    deathDate: "6 Kasım 2023",
    message:
      "Temizlik İşleri Personeli Nazım Ertürk'ün abisi Erdal Güney'ın kayınbiraderi vefat etmiştir. Cenazesi bugün öğlen namazından sonra Hürriyet Mahallesi Hz.Ali Camii'nden kaldırılacaktır.İrtibat: Nazım Ertürk 05362215339-ErdalGüzey 05343572975",
  },

  // Sayfa 3 (25-36)
  {
    name: "Elmas ARSLAN",
    position: "Veteriner İşleri Müdürlüğü Personeli Barış Arslan'ın annesi",
    deathDate: "6 Kasım 2023",
    message:
      "Belediyemiz Veteriner İşleri Müdürlüğü Personeli Barış Arslan'ın annesi Elmas Arslan vefat etmiştir. Cenazesi memleketi Giresun'dan kaldırılacaktır. İrtibat: Barış Arslan 05333969761",
  },
  {
    name: "Fuat CAN",
    position: "Özel Kalem Müdürlüğü Personeli Filiz Can'ın Eşi",
    deathDate: "26 Kasım 2023",
    message:
      "Belediyemiz Özel KALEM Müdürlüğü personeli Filiz Can'ın eşi Fuat Can vefat etmiştir. Cenazesi yarın öğlen namazına müteakip Nur Osmaniye Camii'nden kaldırılacaktır. İrtibat: Eren Can 05523429125",
  },
  {
    name: "Ayşe VAROL",
    position: " Belediyemizin Emekli Personeli İhsan Varol'un eşi",
    deathDate: "26 Kasım 2023",
    message:
      "Belediyemizin emekli personeli İhsan Varol'un eşi Ayşe Varol vefat etmiştir. Cenazesi ikindi namazına müteakip Yavuz Selim Mahallesi Ulu Camii'nden kaldırılacaktır. İrtibat: İhsan Varol 05453676219",
  },
  {
    name: "Saadettin Gürkan'ın Kayınpederi",
    position: "Kültür Müdürlüğü Personeli Saadettin Gürkan'ın Kayınpederi",
    deathDate: "26 Kasım 2023",
    message:
      "Belediyemizin Kültür Müdürlüğü Personeli Saadettin GÜRKAN'ın kayınpederi vefat etmiştir. Cenazesi memleketi Ordu'da defnedilcektir. İrtibat: Saadettin Gürkan 05427181294",
  },
  {
    name: "Tuncay KUYUCU'nun Babası",
    position: "Emlak İstimlak Müdürlüğü Personeli Tuncay Kuyucu'nun babası",
    deathDate: "16 Kasım 2023",
    message:
      "Belediyemiz Emlak İstimlak Müdürlüğü personelimiz Tuncay Kuyucu'nun babası vefat etmiştir. Cenaze pazar günü öğlen namazına müteakip Mudarlı köyünde defnedilmiştir. İrtibat: Tuncay Kuyucu 05363270149",
  },
  {
    name: "Metin Ve Murat ÇİMEN'in babaannesi",
    position: "Fen işleri Personelimiz Metin ve Murat Çimen'in Babaannesi ",
    deathDate: "16 Kasım 2023",
    message:
      "Emekli Fen İşleri personelimiz İsmail ÇİMEN'in annesi,Fen işleri Personelimiz Metin ve Murat Çimen'in babaannesi vefat etmiştir.Cenazesi bugün ikindi namazına müteakip Barış Mahallesi Merkez Camii'nden kaldırılacaktır. İrtibat: İsmail Çimen 05358250415 Metin Çimen 05378878231",
  },
  {
    name: "Hasan ALTINPARMAK'ın Babası",
    position: "Temizlik İşleri Müdürlüğü Personeli Hasan Altınparmak'ın Babası",
    deathDate: "16 Kasım 2023",
    message:
      "Temizlik İşleri Müdürlüğü Personeli Hasan Altınparmak'ın babası vefat etmiştir.Cenazesi bugün ikindi namazına müteakip Çayırova Mandıra(Mescid-i Aksa)Camii-'nden kaldırılacaktır. İrtibat: Hasan Altınparmak 05310132598",
  },
  {
    name: "Namık Demir'in Babası",
    position: "Bilgi İşlem Müdürlüğü Personeli Namık Demir'in Babası",
    deathDate: "7 Eylül 2023",
    message:
      "Belediyemiz Bilgi İşlem Müdürlüğü Personeli Namık Demir'in babası vefat etmiştir. Cenazesi bugün öğle namazına müteakip memleketi Erzurum'dan kaldırılacaktır. İrtibat: Namık Demir 05063654125",
  },
];

// Sayfa başına gösterilecek kart sayısı
const CARDS_PER_PAGE = 12;
let currentPage = 1;
const totalPages = Math.ceil(vefatData.length / CARDS_PER_PAGE);

document.addEventListener("DOMContentLoaded", function () {
  // Sayfa yüklendiğinde saygı duruşu efekti
  initRespectMoment();

  // İlk sayfayı yükle
  loadPage(1);

  // Sayfalama butonları
  initPagination();

  // Kart hover efektleri
  initCardEffects();

  // Lazy loading fotoğraflar için
  initLazyLoading();
});

// Belirli bir sayfadaki verileri yükle
function loadPage(pageNumber) {
  const startIndex = (pageNumber - 1) * CARDS_PER_PAGE;
  const endIndex = startIndex + CARDS_PER_PAGE;
  const pageData = vefatData.slice(startIndex, endIndex);

  currentPage = pageNumber;
  renderVefatCards(pageData);
  updatePagination();

  // Sayfa değiştiğinde yukarı kaydır
  window.scrollTo({
    top: 0,
    behavior: "smooth",
  });
}

// Vefat kartlarını render et
function renderVefatCards(data) {
  const vefatGrid = document.getElementById("vefatGrid");

  // Loading efekti göster
  vefatGrid.style.opacity = "0.3";
  vefatGrid.style.transition = "opacity 0.3s ease";

  setTimeout(() => {
    vefatGrid.innerHTML = "";

    data.forEach((person, index) => {
      const card = createVefatCard(person, index);
      vefatGrid.appendChild(card);
    });

    // Loading efektini kaldır
    vefatGrid.style.opacity = "1";

    // Kartlara fade-in animasyonu ekle
    setTimeout(() => {
      const cards = vefatGrid.querySelectorAll(".vefat-card");
      cards.forEach((card, index) => {
        setTimeout(() => {
          card.style.opacity = "0";
          card.style.transform = "translateY(20px)";
          card.style.transition = "all 0.5s ease-out";

          setTimeout(() => {
            card.style.opacity = "1";
            card.style.transform = "translateY(0)";
          }, 50);
        }, index * 100);
      });
    }, 100);
  }, 300);
}

// Tek bir vefat kartı oluştur
function createVefatCard(person, index) {
  const card = document.createElement("div");
  card.className = "vefat-card";
  card.setAttribute("data-index", index);

  card.innerHTML = `
        <div class="card-header">
            <div class="memorial-icon">
                <i class="fas fa-ribbon header-icon"></i>
            </div>
        </div>
        <div class="card-body">
            <div class="person-photo">
                <!-- Fotoğraf placeholder - gerçek uygulamada person.photo kullanılabilir -->
            </div>
            <h3 class="person-name">${person.name}</h3>
            <p class="person-position">${person.position}</p>
            <div class="person-dates">
                <div class="date-info">
                    <i class="fas fa-calendar-alt"></i>
                    <span> ${person.deathDate}</span>
                </div>
            </div>
            <div class="memorial-message">
                <p>"${person.message}"</p>
            </div>
        </div>
    `;

  return card;
}

// Sayfalama kontrollerini güncelle
function updatePagination() {
  const pagination = document.querySelector(".pagination");
  const prevPageItem = document.getElementById("prevPageItem");
  const nextPageItem = document.getElementById("nextPageItem");

  // Önceki butonu kontrolü
  if (currentPage === 1) {
    prevPageItem.classList.add("disabled");
  } else {
    prevPageItem.classList.remove("disabled");
  }

  // Sonraki butonu kontrolü
  if (currentPage === totalPages) {
    nextPageItem.classList.add("disabled");
  } else {
    nextPageItem.classList.remove("disabled");
  }

  // Sayfa numaralarını güncelle
  const pageNumbers = pagination.querySelectorAll(".page-link[data-page]");
  pageNumbers.forEach((link) => {
    const pageNum = parseInt(link.getAttribute("data-page"));
    const pageItem = link.closest(".page-item");

    if (pageNum === currentPage) {
      pageItem.classList.add("active");
    } else {
      pageItem.classList.remove("active");
    }
  });

  // Sayfa bilgisi göstergesi güncelle (isteğe bağlı)
  updatePageInfo();
}

// Sayfa bilgisi göstergesi
function updatePageInfo() {
  const startRecord = (currentPage - 1) * CARDS_PER_PAGE + 1;
  const endRecord = Math.min(currentPage * CARDS_PER_PAGE, vefatData.length);

  // Eğer sayfa bilgisi göstergesi varsa güncelle
  const pageInfo = document.getElementById("pageInfo");
  if (pageInfo) {
    pageInfo.textContent = `${startRecord}-${endRecord} / ${vefatData.length} kayıt gösteriliyor`;
  }
}

// Sayfalama işlevselliği
function initPagination() {
  const pagination = document.querySelector(".pagination");

  pagination.addEventListener("click", function (e) {
    e.preventDefault();
    const link = e.target.closest(".page-link");

    if (!link) return;

    const pageItem = link.closest(".page-item");

    // Disabled link kontrolü
    if (pageItem.classList.contains("disabled")) {
      return;
    }

    // Önceki sayfa
    if (link.id === "prevPage") {
      if (currentPage > 1) {
        loadPage(currentPage - 1);
      }
      return;
    }

    // Sonraki sayfa
    if (link.id === "nextPage") {
      if (currentPage < totalPages) {
        loadPage(currentPage + 1);
      }
      return;
    }

    // Belirli sayfa numarası
    const pageNumber = link.getAttribute("data-page");
    if (pageNumber) {
      loadPage(parseInt(pageNumber));
    }
  });
}

// Saygı duruşu efekti
function initRespectMoment() {
  const pageHeader = document.querySelector(".page-header");
  if (pageHeader) {
    pageHeader.classList.add("respect-moment");
  }
}

// Kart hover efektleri
function initCardEffects() {
  document.addEventListener(
    "mouseenter",
    function (e) {
      if (e.target.closest(".vefat-card")) {
        const card = e.target.closest(".vefat-card");
        const icon = card.querySelector(".memorial-icon i");
        if (icon) {
          icon.style.transform = "rotate(10deg) scale(1.1)";
          icon.style.transition = "transform 0.3s ease";
        }
      }
    },
    true
  );

  document.addEventListener(
    "mouseleave",
    function (e) {
      if (e.target.closest(".vefat-card")) {
        const card = e.target.closest(".vefat-card");
        const icon = card.querySelector(".memorial-icon i");
        if (icon) {
          icon.style.transform = "none";
        }
      }
    },
    true
  );

  // Kart tıklama efekti (detay modal açılabilir)
  document.addEventListener("click", function (e) {
    const card = e.target.closest(".vefat-card");
    if (card) {
      const index = parseInt(card.getAttribute("data-index"));
      const pageStartIndex = (currentPage - 1) * CARDS_PER_PAGE;
      const dataIndex = pageStartIndex + index;
      const person = vefatData[dataIndex];

      if (person) {
        console.log(`${person.name} için detay açılıyor...`);
        // showPersonDetail(person); // Modal açma fonksiyonu
      }
    }
  });
}

// Lazy loading fotoğraflar için
function initLazyLoading() {
  if ("IntersectionObserver" in window) {
    const imageObserver = new IntersectionObserver((entries, observer) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          const photoDiv = entry.target;
          photoDiv.style.opacity = "0";
          photoDiv.style.transition = "opacity 0.5s ease";

          setTimeout(() => {
            photoDiv.style.opacity = "1";
          }, 100);

          imageObserver.unobserve(photoDiv);
        }
      });
    });

    // Observer'ı yeni yüklenen kartlara uygula
    const observer = new MutationObserver(() => {
      const photos = document.querySelectorAll(".person-photo");
      photos.forEach((photo) => {
        if (!photo.hasAttribute("data-observed")) {
          imageObserver.observe(photo);
          photo.setAttribute("data-observed", "true");
        }
      });
    });

    observer.observe(document.getElementById("vefatGrid"), {
      childList: true,
      subtree: true,
    });
  }
}

// Detay modal fonksiyonu (isteğe bağlı)
function showPersonDetail(person) {
  // Modal HTML'i oluştur ve göster
  const modal = document.createElement("div");
  modal.innerHTML = `
        <div class="modal fade" id="personDetailModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">${person.name} - Detaylı Bilgi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <div class="person-photo mb-3">
                                    <!-- Fotoğraf placeholder -->
                                    <div style="width: 150px; height: 150px; background: #f8f9fa; border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-user" style="font-size: 60px; color: #dee2e6;"></i>
                                    </div>
                                </div>
                                <h4>${person.name}</h4>
                                <p class="text-muted">${person.position}</p>
                            </div>
                            <div class="col-md-8">
                                <h6>Yaşam Bilgileri</h6>
                                <p><strong>Doğum Tarihi:</strong> ${person.birthDate}</p>
                                <p><strong>Vefat Tarihi:</strong> ${person.deathDate}</p>
                                <p><strong>Görev:</strong> ${person.position}</p>
                                
                                <h6 class="mt-4">Anısına</h6>
                                <p class="fst-italic">"${person.message}"</p>
                                
                                <div class="mt-4 p-3 bg-light rounded">
                                    <small class="text-muted">
                                        Değerli çalışanımız ${person.name}, Gebze Belediyesi ailesinin vazgeçilmez bir üyesiydi. 
                                        Gösterdiği özveri ve fedakarlık örnek alınacak niteliktedir. 
                                        Ruhu şad, mekanı cennet olsun.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    </div>
                </div>
            </div>
        </div>
    `;

  document.body.appendChild(modal);

  // Bootstrap modal'ı başlat
  const bsModal = new bootstrap.Modal(document.getElementById("personDetailModal"));
  bsModal.show();

  // Modal kapandığında DOM'dan kaldır
  document.getElementById("personDetailModal").addEventListener("hidden.bs.modal", function () {
    document.body.removeChild(modal);
  });
}

// Arama fonksiyonu (isteğe bağlı)
function searchVefatRecords(searchTerm) {
  if (!searchTerm.trim()) {
    loadPage(1);
    return;
  }

  const filteredData = vefatData.filter(
    (person) =>
      person.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
      person.position.toLowerCase().includes(searchTerm.toLowerCase())
  );

  if (filteredData.length > 0) {
    renderVefatCards(filteredData.slice(0, CARDS_PER_PAGE));
    // Arama sonuçları için sayfalama gizle
    document.querySelector(".pagination-container").style.display = "none";
  } else {
    // Sonuç bulunamadı mesajı
    const vefatGrid = document.getElementById("vefatGrid");
    vefatGrid.innerHTML = `
            <div class="col-12 text-center py-5">
                <i class="fas fa-search" style="font-size: 4rem; color: #dee2e6; margin-bottom: 1rem;"></i>
                <h4 class="text-muted">Aradığınız kriterlere uygun kayıt bulunamadı</h4>
                <p class="text-muted">Lütfen farklı anahtar kelimeler deneyiniz.</p>
                <button class="btn btn-primary" onclick="loadPage(1)">
                    <i class="fas fa-arrow-left"></i> Tüm Kayıtlara Dön
                </button>
            </div>
        `;
    document.querySelector(".pagination-container").style.display = "none";
  }
}

// Arama çubuğu ekleme fonksiyonu (isteğe bağlı)
function addSearchBar() {
  const pageHeader = document.querySelector(".page-header");
  const searchBar = document.createElement("div");
  searchBar.className = "search-container mt-4";
  searchBar.innerHTML = `
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" class="form-control form-control-lg" 
                           placeholder="Ad veya görev pozisyonu ile arama yapın..." 
                           id="searchInput">
                    <button class="btn btn-primary" type="button" id="searchBtn">
                        <i class="fas fa-search"></i> Ara
                    </button>
                    <button class="btn btn-outline-secondary" type="button" id="clearBtn">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    `;

  pageHeader.appendChild(searchBar);

  // Arama işlevselliği
  const searchInput = document.getElementById("searchInput");
  const searchBtn = document.getElementById("searchBtn");
  const clearBtn = document.getElementById("clearBtn");

  searchBtn.addEventListener("click", () => {
    searchVefatRecords(searchInput.value);
  });

  clearBtn.addEventListener("click", () => {
    searchInput.value = "";
    loadPage(1);
    document.querySelector(".pagination-container").style.display = "flex";
  });

  searchInput.addEventListener("keypress", (e) => {
    if (e.key === "Enter") {
      searchVefatRecords(searchInput.value);
    }
  });

  // Gerçek zamanlı arama (isteğe bağlı)
  let searchTimeout;
  searchInput.addEventListener("input", () => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
      if (searchInput.value.length >= 2) {
        searchVefatRecords(searchInput.value);
      } else if (searchInput.value.length === 0) {
        loadPage(1);
        document.querySelector(".pagination-container").style.display = "flex";
      }
    }, 500);
  });
}

// Keyboard shortcuts
document.addEventListener("keydown", function (e) {
  // ESC tuşu ile modal kapat
  if (e.key === "Escape") {
    const openModal = document.querySelector(".modal.show");
    if (openModal) {
      const modal = bootstrap.Modal.getInstance(openModal);
      modal.hide();
    }
  }

  // Arrow keys ile sayfalama
  if (e.key === "ArrowLeft" && !e.target.matches("input, textarea")) {
    e.preventDefault();
    if (currentPage > 1) {
      loadPage(currentPage - 1);
    }
  }

  if (e.key === "ArrowRight" && !e.target.matches("input, textarea")) {
    e.preventDefault();
    if (currentPage < totalPages) {
      loadPage(currentPage + 1);
    }
  }

  // Home tuşu ile ilk sayfa
  if (e.key === "Home" && !e.target.matches("input, textarea")) {
    e.preventDefault();
    loadPage(1);
  }

  // End tuşu ile son sayfa
  if (e.key === "End" && !e.target.matches("input, textarea")) {
    e.preventDefault();
    loadPage(totalPages);
  }
});

// Yazdırma fonksiyonu
function printVefatRecords() {
  const printWindow = window.open("", "_blank");
  const currentPageData = vefatData.slice(
    (currentPage - 1) * CARDS_PER_PAGE,
    currentPage * CARDS_PER_PAGE
  );

  let printContent = `
        <!DOCTYPE html>
        <html>
        <head>
            <title>Vefat Eden Personel Listesi - Sayfa ${currentPage}</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                .header { text-align: center; margin-bottom: 30px; }
                .person { margin-bottom: 20px; padding: 15px; border: 1px solid #ddd; }
                .person-name { font-weight: bold; font-size: 18px; color: #022842; }
                .person-position { color: #666; margin: 5px 0; }
                .person-dates { margin: 10px 0; font-style: italic; }
                .person-message { margin-top: 10px; font-style: italic; }
                @media print { body { margin: 0; } }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>GEBZE BELEDİYESİ</h1>
                <h2>Vefat Eden Personel Listesi</h2>
                <p>Sayfa ${currentPage} / ${totalPages}</p>
                <hr>
            </div>
    `;

  currentPageData.forEach((person) => {
    printContent += `
            <div class="person">
                <div class="person-name">${person.name}</div>
                <div class="person-position">${person.position}</div>
                <div class="person-dates"> ${person.deathDate}</div>
                <div class="person-message">"${person.message}"</div>
            </div>
        `;
  });

  printContent += `
            <div style="margin-top: 40px; text-align: center; font-size: 12px; color: #666;">
                <p>Gebze Belediyesi - ${new Date().toLocaleDateString("tr-TR")}</p>
            </div>
        </body>
        </html>
    `;

  printWindow.document.write(printContent);
  printWindow.document.close();
  printWindow.focus();
  setTimeout(() => {
    printWindow.print();
    printWindow.close();
  }, 250);
}

// Export fonksiyonu (CSV olarak)
function exportToCSV() {
  const csvData = [["Ad Soyad", "Pozisyon", "Doğum Tarihi", "Vefat Tarihi", "Anı Mesajı"]];

  vefatData.forEach((person) => {
    csvData.push([
      person.name,
      person.position,
      person.birthDate,
      person.deathDate,
      person.message,
    ]);
  });

  const csvContent = csvData
    .map((row) => row.map((field) => `"${field.replace(/"/g, '""')}"`).join(","))
    .join("\n");

  const blob = new Blob(["\ufeff" + csvContent], {
    type: "text/csv;charset=utf-8;",
  });
  const link = document.createElement("a");
  const url = URL.createObjectURL(blob);

  link.setAttribute("href", url);
  link.setAttribute("download", `vefat_listesi_${new Date().toISOString().split("T")[0]}.csv`);
  link.style.visibility = "hidden";

  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
}

// Sayfa yüklenme performansı izleme
window.addEventListener("load", function () {
  console.log(`Vefat sayfası ${performance.now().toFixed(2)}ms'de yüklendi`);
  console.log(`Toplam ${vefatData.length} vefat kaydı, ${totalPages} sayfa`);
});

// Responsive kontrolleri
window.addEventListener("resize", function () {
  // Mobil cihazlarda sayfa boyutunu ayarla
  if (window.innerWidth < 768 && CARDS_PER_PAGE === 12) {
    // Mobilde daha az kart göster (opsiyonel)
    console.log("Mobil görünüm aktif");
  }
});

// Sayfa görünürlük kontrolü (tab değiştiğinde)
document.addEventListener("visibilitychange", function () {
  if (document.hidden) {
    console.log("Vefat sayfası gizlendi");
  } else {
    console.log("Vefat sayfası tekrar görünür");
  }
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
