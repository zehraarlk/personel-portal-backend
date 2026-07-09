-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 08 Tem 2026, 16:17:29
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `personel_db`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `anasayfa_duyurular`
--

CREATE TABLE `anasayfa_duyurular` (
  `id` int(11) NOT NULL,
  `baslik` varchar(255) NOT NULL,
  `aciklama` text NOT NULL,
  `resim` varchar(255) NOT NULL,
  `view` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `anasayfa_duyurular`
--

INSERT INTO `anasayfa_duyurular` (`id`, `baslik`, `aciklama`, `resim`, `view`) VALUES
(1, 'Stajyer Oryantasyon Eğitimi Tamamlandı', 'Belediyemizde yeni döneme başlayan stajyer öğrencilerimiz için oryantasyon programı düzenlendi.', '../images/stajyer-oryantasyon-e-t-m_8697.jpg', 1),
(2, 'Geleneksel Bayramlaşma Töreni Gerçekleşti', 'Kurban Bayramı vesilesiyle tüm personelimizin katılımıyla coşkulu bir bayramlaşma programı yapıldı.', '../images/24-kas-m-o-retmenler-gunu_2947.jpg', 1),
(3, '8 Mart Dünya Kadınlar Günü Kutlandı', 'Belediyemizdeki kadın personelimizin Dünya Kadınlar Günü\'nü özel bir etkinlikle kutladık.', '../images/8-mart-dunya-kadinlar-gunu-programi_8383.jpg', 0),
(4, 'Personel İftar Programı Büyük İlgi Gördü', 'Ramazan ayının manevi atmosferinde personelimizle birlikte iftar sofrasında buluştuk.', '../images/personel-ftar-program_109.jpg', 1),
(5, 'Öğretmenler Günü Unutulmadı', 'Gebze\'deki öğretmenlerimizi bu özel günlerinde yalnız bırakmadık ve çeşitli ziyaretler gerçekleştirdik.', '../images/24-kas-m-o-retmenler-gunu_2947.jpg', 0),
(6, 'Dağ Bisikleti Kupası Gebze\'de Nefes Kesti', 'Türkiye Ulusal Dağ Bisikleti Kupası\'nın bir ayağına ev sahipliği yapmanın gururunu yaşadık.', '../images/ulusal-da-bisikleti-kupas-yar-lar_128.jpg', 0),
(7, 'Personelimize Ağız ve Diş Sağlığı Taraması', 'Çalışanlarımızın sağlığını önemsiyor, düzenli olarak sağlık taramaları gerçekleştiriyoruz.', '../images/personellerimizin-a-z-ve-di-sa-l-n-onemsiyoruz_7091.jpg', 0),
(8, 'Yaz Sezonunu Piknikle Açtık', 'Yoğun çalışma temposuna mola vererek tüm birimlerimizin katıldığı bir piknik organizasyonu düzenledik.', '../images/personel-p-kn-k-programi_9118.jpg', 3),
(9, 'Stajyerlerle Film Okuma Etkinliği', 'Gençlerimizin vizyonunu geliştirmek amacıyla film okuma ve analiz programları düzenliyoruz.', '../images/stajyer-f-lm-okuma-programi_3604.jpg', 1),
(10, 'İkinci Geleneksel İftar Buluşması', 'Personelimiz ve aileleriyle birlikte Ramazan ayının bereketini paylaştığımız iftar programımız.', '../images/personel-ftar-program_109.jpg', 1),
(11, 'Stajyer Dönem Sonu Veda Programı', 'Staj dönemini başarıyla tamamlayan öğrencilerimiz için bir veda ve teşekkür etkinliği düzenlendi.', '../images/stajyer-donem-sonu-etk-nl_6028.jpg', 1),
(12, 'Yeni Stajyerlerimize \"Hoş Geldin\" Dedik', 'Belediye çalışmalarını yakından tanımaları için yeni stajyerlerimize yönelik bir oryantasyon yapıldı.', '../images/stajyer-oryantasyon-e-t-m_8697.jpg', 1),
(13, 'Kadın Personelimize Özel İkramlar', '8 Mart kapsamında belediyemizdeki tüm kadın çalışanlarımıza küçük bir jest hazırladık.', '../images/8-mart-dunya-kadinlar-gunu-programi_8383.jpg', 1),
(14, 'Ramazan Bayramı Buluşması', 'Ramazan Bayramı dolayısıyla personelimizle bir araya gelerek bayramlaştık.', '../images/personel-bayramla-ma-programi_5965.jpg', 1),
(15, 'Birlik ve Beraberlik İftarı', 'İftar programımız, personelimiz arasındaki birlik ve beraberliği pekiştirdi.', '../images/personel-ftar-program_109.jpg', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `anasayfa_linkler`
--

CREATE TABLE `anasayfa_linkler` (
  `id` int(11) NOT NULL,
  `baslik` varchar(255) NOT NULL,
  `logo_url` varchar(255) DEFAULT NULL,
  `hedef_url` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `anasayfa_linkler`
--

INSERT INTO `anasayfa_linkler` (`id`, `baslik`, `logo_url`, `hedef_url`) VALUES
(1, 'OMIS', '../images/otomasyon/omis_7572.png', 'https://ebelediye.gebze.bel.tr/eBelediye/'),
(2, 'Ulakbel', '../images/otomasyon/ulakbel_5496.png', 'https://ulakbel.gebze.bel.tr/ulakbel#/'),
(3, 'İmar Yönetim Sistemi', '../images/otomasyon/imar-yonetim-sistemi_8038.png', 'https://www.gebze.bel.tr/ebelediye/'),
(4, 'Dijital Arşiv', '../images/otomasyon/dijital-arsiv_415.png', 'https://www.gebze.bel.tr/'),
(5, 'Outlook', '../images/otomasyon/outlook_4005.png', 'https://outlook.live.com/'),
(6, 'Sosyal Yardım', '../images/otomasyon/sosyal-yardim_3767.png', 'https://www.turkiye.gov.tr/ashb-sosyal-yardim-bilgileri-sorgulama'),
(7, 'Netcad', '../images/otomasyon/netcad_3888.png', 'https://www.netcad.com/'),
(8, 'E-Belediye Sistemi', '../images/otomasyon/ebys_8493.png', 'https://www.belediye.gov.tr/'),
(9, 'E-Belediye Evlendrme Modülü', '../images/otomasyon/e-belediye-evlendirme-modulu_3993.png', 'https://www.belediye.gov.tr/evlendirme-modulu'),
(10, 'E-Belediye Sosyal Yardım Modülü', '../images/otomasyon/e-belediye-sosyal-yard-m-modulu_4432.png', 'https://www.belediye.gov.tr/sosyal-yardim-takip-sistemi-syts-modulu');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `anketler`
--

CREATE TABLE `anketler` (
  `id` int(11) NOT NULL,
  `baslik` varchar(255) NOT NULL,
  `aciklama` text DEFAULT NULL,
  `kategori` varchar(50) NOT NULL,
  `resim_url` varchar(500) DEFAULT NULL,
  `baslangic_tarihi` date DEFAULT NULL,
  `bitis_tarihi` date DEFAULT NULL,
  `katilim_sayisi` int(11) DEFAULT 0,
  `hedef_katilim` int(11) DEFAULT 0,
  `favori` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `anketler`
--

INSERT INTO `anketler` (`id`, `baslik`, `aciklama`, `kategori`, `resim_url`, `baslangic_tarihi`, `bitis_tarihi`, `katilim_sayisi`, `hedef_katilim`, `favori`) VALUES
(1, 'Personel Memnuniyet Anketi 2024', 'Görev yapan personele yönelik genel değerlendirme formu. İş memnuniyeti ve çalışma koşulları değerlendirmesi.', 'active', 'https://img.freepik.com/free-photo/business-graphs-charts-tablet_23-2147819730.jpg', '2024-10-09', '2024-11-15', 45, 120, 1),
(2, 'Eğitim İhtiyaç Analizi', 'Personel gelişimi için gerekli eğitim alanlarının belirlenmesi amacıyla hazırlanan değerlendirme anketi.', 'completed', 'https://img.freepik.com/free-photo/education-concept-with-graduation-cap-books_23-2147819868.jpg', '2024-09-01', '2024-09-30', 98, 120, 0),
(3, 'İş Ortamı Değerlendirme', 'Çalışma ortamı, ekipman yeterliliği ve fiziksel koşulların değerlendirilmesi anketi.', 'expired', 'https://img.freepik.com/free-photo/workplace-productivity-concept_23-2147819745.jpg', '2024-08-15', '2024-09-15', 67, 120, 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `duyurular`
--

CREATE TABLE `duyurular` (
  `id` int(11) NOT NULL,
  `baslik` varchar(255) NOT NULL,
  `aciklama` text NOT NULL,
  `resim` varchar(255) NOT NULL,
  `view` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `duyurular`
--

INSERT INTO `duyurular` (`id`, `baslik`, `aciklama`, `resim`, `view`) VALUES
(1, 'Stajyer Oryantasyon Eğitimi Tamamlandı', 'Belediyemizde yeni döneme başlayan stajyer öğrencilerimiz için oryantasyon programı düzenlendi.', '../images/stajyer-oryantasyon-e-t-m_8697.jpg', 0),
(2, 'Geleneksel Bayramlaşma Töreni Gerçekleşti', 'Kurban Bayramı vesilesiyle tüm personelimizin katılımıyla coşkulu bir bayramlaşma programı yapıldı.', '../images/24-kas-m-o-retmenler-gunu_2947.jpg', 0),
(3, '8 Mart Dünya Kadınlar Günü Kutlandı', 'Belediyemizdeki kadın personelimizin Dünya Kadınlar Günü\'nü özel bir etkinlikle kutladık.', '../images/8-mart-dunya-kadinlar-gunu-programi_8383.jpg', 0),
(4, 'Personel İftar Programı Büyük İlgi Gördü', 'Ramazan ayının manevi atmosferinde personelimizle birlikte iftar sofrasında buluştuk.', '../images/personel-ftar-program_109.jpg', 0),
(5, 'Öğretmenler Günü Unutulmadı', 'Gebze\'deki öğretmenlerimizi bu özel günlerinde yalnız bırakmadık ve çeşitli ziyaretler gerçekleştirdik.', '../images/24-kas-m-o-retmenler-gunu_2947.jpg', 0),
(6, 'Dağ Bisikleti Kupası Gebze\'de Nefes Kesti', 'Türkiye Ulusal Dağ Bisikleti Kupası\'nın bir ayağına ev sahipliği yapmanın gururunu yaşadık.', '../images/ulusal-da-bisikleti-kupas-yar-lar_128.jpg', 0),
(7, 'Personelimize Ağız ve Diş Sağlığı Taraması', 'Çalışanlarımızın sağlığını önemsiyor, düzenli olarak sağlık taramaları gerçekleştiriyoruz.', '../images/personellerimizin-a-z-ve-di-sa-l-n-onemsiyoruz_7091.jpg', 0),
(8, 'Yaz Sezonunu Piknikle Açtık', 'Yoğun çalışma temposuna mola vererek tüm birimlerimizin katıldığı bir piknik organizasyonu düzenledik.', '../images/personel-p-kn-k-programi_9118.jpg', 0),
(9, 'Stajyerlerle Film Okuma Etkinliği', 'Gençlerimizin vizyonunu geliştirmek amacıyla film okuma ve analiz programları düzenliyoruz.', '../images/stajyer-f-lm-okuma-programi_3604.jpg', 0),
(10, 'İkinci Geleneksel İftar Buluşması', 'Personelimiz ve aileleriyle birlikte Ramazan ayının bereketini paylaştığımız iftar programımız.', '../images/personel-ftar-program_109.jpg', 0),
(11, 'Stajyer Dönem Sonu Veda Programı', 'Staj dönemini başarıyla tamamlayan öğrencilerimiz için bir veda ve teşekkür etkinliği düzenlendi.', '../images/stajyer-donem-sonu-etk-nl_6028.jpg', 0),
(12, 'Yeni Stajyerlerimize \"Hoş Geldin\" Dedik', 'Belediye çalışmalarını yakından tanımaları için yeni stajyerlerimize yönelik bir oryantasyon yapıldı.', '../images/stajyer-oryantasyon-e-t-m_8697.jpg', 0),
(13, 'Kadın Personelimize Özel İkramlar', '8 Mart kapsamında belediyemizdeki tüm kadın çalışanlarımıza küçük bir jest hazırladık.', '../images/8-mart-dunya-kadinlar-gunu-programi_8383.jpg', 0),
(14, 'Ramazan Bayramı Buluşması', 'Ramazan Bayramı dolayısıyla personelimizle bir araya gelerek bayramlaştık.', '../images/personel-bayramla-ma-programi_5965.jpg', 0),
(15, 'Birlik ve Beraberlik İftarı', 'İftar programımız, personelimiz arasındaki birlik ve beraberliği pekiştirdi.', '../images/personel-ftar-program_109.jpg', 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `etkinlikler`
--

CREATE TABLE `etkinlikler` (
  `id` int(11) NOT NULL,
  `baslik` varchar(255) NOT NULL,
  `aciklama` text DEFAULT NULL,
  `tarih` date NOT NULL,
  `bitis_tarihi` date DEFAULT NULL,
  `view` int(11) DEFAULT 0,
  `durum` varchar(20) DEFAULT 'aktif',
  `resim` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `etkinlikler`
--

INSERT INTO `etkinlikler` (`id`, `baslik`, `aciklama`, `tarih`, `bitis_tarihi`, `view`, `durum`, `resim`) VALUES
(1, 'Stajyer Oryantasyon Eğitimi', '6734 ve 6735 Sayılı Kanun Eğitimi - Biyomedikal Eğitimi - Üniversite Eğitimi - Oryantasyon Eğitimi - Fen Programlama Eğitimi - Mevzuat Eğitimi - Teknoloji Çalışma Eğitimi...', '2025-08-06', '2025-12-31', 95, 'aktif', '../images/stajyer-oryantasyon-e-t-m_8697.jpg'),
(2, 'Stajyer Dönem Sonu Etkinliği', 'Köprülü Geçmis Mahallesi, 503 Sokak\'taki çalışmalar...Köprülü Geçmis Mahallesi, 503 Sokak\'taki çalışmalar...', '2025-05-22', '2025-06-30', 153, 'aktif', '../images/stajyer-donem-sonu-etk-nl_6028.jpg'),
(3, 'Personel İftar Programı', 'Kül, katkısız ve tüm güzelleştirme organlarından şeye çeşit kurtarıcılar...Kül, katkısız ve tüm güzelleştirme organlarından şeye çeşit kurtarıcılar...', '2024-03-15', '2024-04-15', 80, 'pasif', '../images/pesonel-ftar-programi_3732.jpg'),
(4, '8 Mart Dünya Kadınlar Günü Programı', '4 Ekim Dünya Hayvanları Koruma Günü nedeniyle 4 Ekim boyunca...4 Ekim Dünya Hayvanları Koruma Günü nedeniyle 4 Ekim boyunca...', '2024-03-08', '2024-03-08', 236, 'pasif', '../images/8-mart-dunya-kadinlar-gunu-programi_8383.jpg'),
(5, 'Ön Ödeme Kredi ve Avans Eğitimi', 'Bağışlanmış günlük programı göbildirinde park ve yeşil alanlarımızda...', '2025-02-27', '2025-03-31', 159, 'pasif', '../images/on-odeme-kred-ve-avans-e-t-m_2065.jpeg'),
(6, 'Marmara Kariyer Yer Fuarı', 'Personel gelişimi için düzenlenen eğitim seminerimiz tamamlandı. Katılımcılarımız başarı sertifikalarını aldı...', '2024-02-26', '2024-02-28', 198, 'pasif', '../images/marmara-kar-yer-fuari-kocael-2024_9790.jpg'),
(7, 'Ofis Programları Eğitimi', 'Şehrimizin çeşitli bölgelerinde gerçekleştirilen yol bakım ve onarım çalışmaları devam ediyor...', '2025-02-19', '2025-08-31', 271, 'aktif', '../images/of-s-programlari-e-t-m_2683.jpeg'),
(8, 'İlkyardım Eğitimi', 'Doğal yaşam alanlarının korunması için başlatılan temizlik kampanyası büyük ilgi gördü...', '2024-02-12', '2025-12-31', 200, 'aktif', '../images/lkyardim-e-t-m_1307.jpeg'),
(9, 'Stajyer Film-Okuma Programı', 'Doğal yaşam alanlarının korunması için başlatılan temizlik kampanyası büyük ilgi gördü...', '2024-02-07', '2024-03-15', 201, 'pasif', '../images/lkyardim-e-t-m_1307.jpeg'),
(10, '3 Aralık Dünya Engelliler Günü Personel Etkinliği', 'Personelimize yönelik dijital dönüşüm ve teknoloji kullanımı eğitimi başarıyla tamamlandı...', '2023-12-03', '2023-12-03', 314, 'pasif', '../images/3-aralik-dunya-engell-ler-gunu-personel-yeme_9554.jpg'),
(11, 'Stajyer Öğrenci Oryantasyonu ', 'Şehir merkezindeki altyapı geliştirme ve modernizasyon çalışmaları hızla devam ediyor...', '2025-11-29', '2025-12-15', 433, 'pasif', '../images/stajyer-o-renci-oryantasyonu_2177.jpg'),
(12, '24 Kasım Öğretmenler Günü Etkinliği', 'Sokak hayvanlarının sağlık kontrolü ve bakım programı kapsamında çalışmalar sürdürülüyor...', '2023-11-24', '2023-11-24', 186, 'pasif', '../images/24-kas-m-o-retmenler-gunu_2947.jpg'),
(13, 'Müdürlükler Arası Spor Turnuvası', 'Kent genelindeki park ve yeşil alanların bakım ve düzenleme çalışmaları tamamlandı...', '2023-08-21', '2023-09-30', 279, 'pasif', '../images/futbol-turnuvasi_9646.jpg'),
(14, 'Personel Piknik Programı', 'Kent genelindeki park ve yeşil alanların bakım ve düzenleme çalışmaları tamamlandı...', '2023-07-22', '2023-07-22', 279, 'pasif', '../images/personel-p-kn-k-programi_9118.jpg'),
(15, 'Personel Bayramlaşma Programı', 'Kent genelindeki park ve yeşil alanların bakım ve düzenleme çalışmaları tamamlandı...', '2023-06-23', '2023-06-25', 280, 'pasif', '../images/personel-bayramla-ma-programi_5965.jpg'),
(16, 'Personel İftar Programı', 'Kent genelindeki park ve yeşil alanların bakım ve düzenleme çalışmaları tamamlandı...', '2023-04-10', '2023-05-15', 280, 'pasif', '../images/personel-ftar-program_109.jpg');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `etkinlikler_duyurular`
--

CREATE TABLE `etkinlikler_duyurular` (
  `id` int(11) NOT NULL,
  `sayfa_tipi` varchar(50) NOT NULL,
  `baslik` varchar(255) NOT NULL,
  `aciklama` text DEFAULT NULL,
  `kategori_adi` varchar(150) DEFAULT NULL,
  `alt_tip` varchar(50) DEFAULT NULL,
  `resim_url` varchar(255) DEFAULT NULL,
  `dosya_url` varchar(500) DEFAULT NULL,
  `video_url` varchar(500) DEFAULT NULL,
  `tarih` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `etkinlikler_duyurular`
--

INSERT INTO `etkinlikler_duyurular` (`id`, `sayfa_tipi`, `baslik`, `aciklama`, `kategori_adi`, `alt_tip`, `resim_url`, `dosya_url`, `video_url`, `tarih`) VALUES
(1, 'duyuru', 'DİL EĞİTİM MODELLERİNDE GEÇERLİ %50 İNDİRİM!', 'KURUMUMUZ PERSONELİ VE 1. DERECE YAKINLARINA ÖZEL AMERICAN VIP DİL OKULLARINDA GEÇERLİ %50 İNİDİRİM ANLAŞMASI İMZALANDI.', 'İnsan Kaynakları', 'insan', '../images/d-l-e-t-m-modeller-nde-gecerl-50-nd-r-m_4469.jpg', NULL, NULL, '2023-10-04'),
(2, 'duyuru', 'Gebze\'de Zabıta Haftası Kutlandı', 'Gebze Belediye Başkanı Zinnur Büyükgöz, her yıl 1-7 Eylül tarihleri arasında kutlanan Zabıta Haftası münasebetiyle zabıta personelleriyle bir araya geldi.', 'İnsan Kaynakları', 'insan', '../images/gebze-de-zab-ta-haftas-kutland_5157 (1).jpg', NULL, NULL, '2023-10-04'),
(3, 'duyuru', 'GEBZE\'DE EK ZAM PROTOKOLÜ İMZALANDI', 'Gebze Belediyesi, bünyesinde görev yapan tüm işçilerin maaşlarına %20 zam müjdesini verdi. Ek zam protokolü Gebze Belediye Başkanı Zinnur BÜYÜKGÖZ ve Hizmet-İş ve Özgüven-Sen Sendikası yetkilileri arasında imzalandı.', 'İnsan Kaynakları', 'insan', '../images/gebze-de-ek-zam-protokolu-mzalandi_4681.jpg', NULL, NULL, '2023-10-04'),
(4, 'duyuru', 'Gebze\'nin Filosu Büyüyor;', 'Gebze\'nin mahallelerine daha kaliteli hizmet verebilmek adına makine ve araç filosuna yeni takviyeler yapılmasını sağlayan Gebze Belediye Başkanı Zinnur Büyükgöz, belediyenin öz kaynaklarıyla satın alınan 100 yeni aracı filoya kazandırdı.', 'İnsan Kaynakları', 'insan', '../images/gebze-nin-filosu-buyuyor_2355.jpg', NULL, NULL, '2023-10-04'),
(5, 'duyuru', 'Daha Sağlıklı Personel İçin', 'Gebze Belediyesi bünyesinde görev yapan tüm personellerimiz ve 1. derece yakınları (anne, baba, eş ve çocuk ) anlaşmalı sağlık kurumlarında indirimli fiyatlardan faydalanabilme olanağına sahip olacaklardır.', 'İnsan Kaynakları', 'insan', '../images/daha-saazlikli-ba-r-personel-a-a-a-n_7523.jpg', NULL, NULL, '2023-10-04'),
(6, 'duyuru', 'Parola Güvenlik Politika Geçişi', 'T.C. Cumhurbaşkanlığı Dijital Dönüşüm Ofisi Başkanlığı koordinasyonunda başlatılan \"Bilgi ve İletişim Güvenliği Rehberi\" uyum süreci doğrultusunda gerçekleştireceğimiz \"Güvenli Parola Politikası\" geçişi kapsamında, bilgisayar oturumu açma parolaları değişecektir.', 'Bilgi İşlem', 'bilgi', '../images/parola-guvenlik-politikasi-duyurusu_2090.jpg', NULL, NULL, '2023-10-04');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `haberler`
--

CREATE TABLE `haberler` (
  `id` int(11) NOT NULL,
  `baslik` varchar(255) NOT NULL,
  `aciklama` text NOT NULL,
  `resim` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `haberler`
--

INSERT INTO `haberler` (`id`, `baslik`, `aciklama`, `resim`) VALUES
(1, '8 Mart Dünya Kadınlar Günü Programı', 'Kadın personelimizin özel günü kutlandı.', '../images/8-mart-dunya-kadinlar-gunu-programi_8383.jpg'),
(2, '24 Kasım Öğretmenler Günü Ziyareti', 'Öğretmenlerimizi bu özel günlerinde yalnız bırakmadık.', '../images/24-kas-m-o-retmenler-gunu_2947.jpg'),
(3, 'Personel Bayramlaşma Programı', 'Personelle bayramlaştık.', '../images/personel-bayramla-ma-programi_5965.jpg'),
(4, 'Personel İftar Programı', '', '../images/personel-ftar-program_109.jpg'),
(5, 'Personel Piknik Programı', '', '../images/personel-p-kn-k-programi_9118.jpg'),
(6, 'Ağız ve Diş Sağlığı Taraması', '', '../images/personellerimizin-a-z-ve-di-sa-l-n-onemsiyoruz_7091.jpg'),
(7, 'İkinci İftar Buluşması', '', '../images/pesonel-ftar-programi_3732.jpg'),
(8, 'Stajyer Dönem Sonu Etkinliği', '', '../images/stajyer-donem-sonu-etk-nl_6028.jpg'),
(9, 'Stajyer Film Okuma Programı', '', '../images/stajyer-f-lm-okuma-programi_3604.jpg'),
(10, 'Stajyer Öğrenci Oryantasyonu', '', '../images/stajyer-o-renci-oryantasyonu_2177.jpg'),
(11, 'Stajyer Oryantasyon Eğitimi', '', '../images/stajyer-oryantasyon-e-t-m_8697.jpg'),
(12, 'Ulusal Dağ Bisikleti Kupası', '', '../images/ulusal-da-bisikleti-kupas-yar-lar_128.jpg');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `haber_galeri`
--

CREATE TABLE `haber_galeri` (
  `id` int(11) NOT NULL,
  `haber_id` int(11) NOT NULL DEFAULT 1,
  `resim_url` varchar(255) NOT NULL,
  `sira` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `haber_galeri`
--

INSERT INTO `haber_galeri` (`id`, `haber_id`, `resim_url`, `sira`) VALUES
(1, 1, '../images/off-road-foto/gebze-de-off-road-heyecan_120.jpg', 1),
(2, 1, '../images/off-road-foto/gebze-de-off-road-heyecan_2075.jpg', 2),
(3, 1, '../images/off-road-foto/gebze-de-off-road-heyecan_2143.jpg', 3),
(4, 1, '../images/off-road-foto/gebze-de-off-road-heyecan_3569.jpg', 4),
(5, 1, '../images/off-road-foto/gebze-de-off-road-heyecan_3911.jpg', 5),
(6, 1, '../images/off-road-foto/gebze-de-off-road-heyecan_4046.jpg', 6),
(7, 1, '../images/off-road-foto/gebze-de-off-road-heyecan_4564.jpg', 7),
(8, 1, '../images/off-road-foto/gebze-de-off-road-heyecan_4975.jpg', 8),
(9, 1, '../images/off-road-foto/gebze-de-off-road-heyecan_5429.jpg', 9);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `icerik_izlemeleri`
--

CREATE TABLE `icerik_izlemeleri` (
  `id` int(11) NOT NULL,
  `tablo` varchar(64) NOT NULL,
  `kayit_id` int(11) NOT NULL,
  `izleyici` varchar(96) NOT NULL,
  `olusturma_tarihi` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `icerik_izlemeleri`
--

INSERT INTO `icerik_izlemeleri` (`id`, `tablo`, `kayit_id`, `izleyici`, `olusturma_tarihi`) VALUES
(1, 'etkinlikler', 1, 'personel:1', '2026-07-08 15:18:38'),
(3, 'sizden_gelenler', 1, 'personel:1', '2026-07-08 15:19:20'),
(8, 'sizden_gelenler', 2, 'personel:1', '2026-07-08 15:19:38'),
(19, 'sizden_gelenler', 3, 'personel:1', '2026-07-08 15:20:14'),
(31, 'etkinlikler', 2, 'personel:1', '2026-07-08 15:20:40'),
(32, 'etkinlikler', 8, 'personel:1', '2026-07-08 15:20:44'),
(35, 'sizden_gelenler', 6, 'personel:1', '2026-07-08 15:20:52'),
(40, 'sizden_gelenler', 7, 'personel:1', '2026-07-08 15:52:57'),
(43, 'sizden_gelenler', 8, 'personel:1', '2026-07-08 15:53:07'),
(45, 'sizden_gelenler', 5, 'personel:1', '2026-07-08 15:53:15'),
(46, 'anasayfa_duyurular', 11, 'personel:1', '2026-07-08 15:55:22'),
(49, 'etkinlikler', 11, 'personel:1', '2026-07-08 15:56:57'),
(51, 'anasayfa_duyurular', 15, 'personel:1', '2026-07-08 15:58:43'),
(52, 'etkinlikler', 4, 'personel:1', '2026-07-08 15:58:54'),
(53, 'etkinlikler', 16, 'personel:1', '2026-07-08 16:01:04'),
(54, 'etkinlikler', 15, 'personel:1', '2026-07-08 16:01:08'),
(57, 'etkinlikler', 9, 'personel:1', '2026-07-08 16:01:28'),
(60, 'anasayfa_duyurular', 10, 'personel:1', '2026-07-08 16:05:28'),
(70, 'etkinlikler', 14, 'personel:1', '2026-07-08 16:36:13'),
(75, 'etkinlikler', 3, 'personel:1', '2026-07-08 16:36:34'),
(94, 'etkinlikler', 7, 'personel:1', '2026-07-08 16:39:26'),
(96, 'etkinlikler', 6, 'personel:1', '2026-07-08 16:39:41'),
(103, 'anasayfa_duyurular', 13, 'personel:1', '2026-07-08 16:40:07'),
(104, 'anasayfa_duyurular', 14, 'personel:1', '2026-07-08 16:40:16'),
(130, 'etkinlikler', 5, 'personel:1', '2026-07-08 16:55:53'),
(137, 'sizden_gelenler', 4, 'personel:1', '2026-07-08 16:56:30'),
(139, 'etkinlikler', 10, 'personel:1', '2026-07-08 16:57:46'),
(150, 'anasayfa_duyurular', 2, 'personel:1', '2026-07-08 17:08:18'),
(153, 'sizden_gelenler', 8, 'guest:81103e765626c0a68d547c30e1fe6b33', '2026-07-08 17:08:40'),
(154, 'sizden_gelenler', 11, 'guest:81103e765626c0a68d547c30e1fe6b33', '2026-07-08 17:08:45'),
(156, 'sizden_gelenler', 12, 'guest:81103e765626c0a68d547c30e1fe6b33', '2026-07-08 17:08:58'),
(157, 'anasayfa_duyurular', 12, 'guest:81103e765626c0a68d547c30e1fe6b33', '2026-07-08 17:12:31'),
(158, 'etkinlikler', 6, 'guest:81103e765626c0a68d547c30e1fe6b33', '2026-07-08 17:12:55');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kaynaklar`
--

CREATE TABLE `kaynaklar` (
  `id` int(11) NOT NULL,
  `baslik` varchar(255) NOT NULL,
  `aciklama` text NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `alt_kategori` varchar(50) DEFAULT NULL,
  `ikon` varchar(50) DEFAULT 'fa-file-signature',
  `dosya_yolu` varchar(255) NOT NULL,
  `resmi_sayfa` varchar(500) DEFAULT NULL,
  `boyut` varchar(50) NOT NULL,
  `tarih` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `kaynaklar`
--

INSERT INTO `kaynaklar` (`id`, `baslik`, `aciklama`, `kategori`, `alt_kategori`, `ikon`, `dosya_yolu`, `resmi_sayfa`, `boyut`, `tarih`) VALUES
(1, 'Aile Bildirim Formu', 'Personelin medeni durumu, eş, çocuk ve bakmakla yükümlü olduğu aile bireylerine ilişkin bilgileri bildirmek veya güncellemek amacıyla kullanılan resmi form.', 'Dökümanlar', NULL, 'fas fa-user-friends', '../images/dokumanlar/a-le-durum-b-ld-r-r-formu_7664 (1).xlsx', NULL, '2.3 MB', '04.10.2023'),
(2, 'Mal Bildirim Formu', 'Kamu görevlilerinin kendileri, eşleri ve velayetleri altındaki çocuklarına ait taşınır ve taşınmaz mallar ile diğer mal varlığı unsurlarını 3628 sayılı Kanun gereğince beyan etmek amacıyla kullanılan form.', 'Dökümanlar', NULL, 'fas fa-briefcase', '../images/dokumanlar/mal-b-ld-r-m-formu_501.doc', NULL, '845 KB', '08.01.2025'),
(3, 'Personel İlişki Kesme Formu', 'Kurumdan ayrılan personelin zimmetli eşyalarının teslimi ve ilgili birimlerle ilişiğinin resmi olarak kesilmesi amacıyla kullanılan form.', 'Dökümanlar', NULL, 'fas fa-sign-out-alt', '../images/dokumanlar/personel-l-k-kesme-formu_9657.docx', NULL, '1.7 MB', '20.12.2024'),
(4, 'Gebze Merkez Prime Hastanesi', 'Gebze Merkez Prime Hastanesi İle Gebze Belediyesi Personelleri Ve Birinci Derece Yakınlarına Yönelik % 20 Oranında İndirim Anlaşması İmzalanmıştır.', 'Protokoller', NULL, 'fas fa-hospital', 'https://personel.gebze.bel.tr/upload/antlasma/gebze-merkez-pr-me-hastanes/gebze-merkez-pr-me-hastanes_2019.pdf', NULL, '2.3 MB', '04.10.2023'),
(5, 'Gebze MedicalPark Hastanesi', 'Gebze Medıcalpark Hastanesi İle Gebze Belediyesi Personelleri Ve Birinci Derece\r\nYakınlarına Yönelik % 20 Oranında İndirim Anlaşması İmzalanmıştır.', 'Protokoller', NULL, 'fas fa-hospital', 'https://personel.gebze.bel.tr/upload/antlasma/gebze-medicalpark-hastanes/gebze-medicalpark-hastanes_3836.pdf', NULL, '845 KB', '04.10.2023'),
(6, 'Gebze Özel Yüzyıl Hastanesi', 'Gebze Özel Yüzyıl Hastanesi İle Gebze Belediyesi Personelleri Ve Birinci Derece\r\nYakınlarına Yönelik % 20 Oranında İndirim Anlaşması İmzalanmıştır.', 'Protokoller', NULL, 'fas fa-hospital', 'https://personel.gebze.bel.tr/upload/antlasma/gebze-ozel-yuzyil-hastanes/gebze-ozel-yuzyil-hastanes_6572.pdf', NULL, '1.7 MB', ' 04.10.2023'),
(7, 'Darıca Hospitalpark Hastanesi', ' Darıca Hospıtalpark Hastanesi İle Gebze Belediyesi Personelleri Ve Birinci Derece\r\nYakınlarına Yönelik % 30 Oranında İndirim Anlaşması İmzalanmıştır.', 'Protokoller', NULL, 'fas fa-hospital', 'https://personel.gebze.bel.tr/upload/antlasma/darica-hospitalpark-hastanes/darica-hospitalpark-hastanes_1530.pdf', NULL, '1.7 MB', '04.10.2023'),
(8, 'Özel Ülker Ağız ve Diş Sağlığı Polikliniği', ' Personellerimizin ve 1. derece yakınlarının (anne, baba, eş ve çocuklar) diş sağlığına katkıda bulunmak adına çevre Polikliniklerimizle muayene, tetkik ve tedavilerde indirim anlaşmaları imzalanmıştır.', 'Protokoller', NULL, 'fas fa-tooth', 'https://personel.gebze.bel.tr/upload/antlasma/ozel-ulker-a-iz-ve-d-sa-li-i-pol-kl-n/ozel-ulker-a-iz-ve-d-sa-li-i-pol-kl-n_3454.pdf', NULL, '1.7 MB', ' 04.10.2023'),
(9, 'Özel Dentriva Ağız ve Diş Sağlığı Polikliniği', 'Personellerimizin ve 1. derece yakınlarının (anne, baba, eş ve çocuklar) diş sağlığına katkıda bulunmak adına çevre Polikliniklerimizle muayene, tetkik ve tedavilerde indirim anlaşmaları imzalanmıştır.', 'Protokoller', NULL, 'fas fa-tooth', 'https://personel.gebze.bel.tr/upload/antlasma/ozel-dentr-va-a-iz-ve-d-sa-li-i-pol-kl-n/ozel-dentr-va-a-iz-ve-d-sa-li-i-pol-kl-n_5515.pdf', NULL, '1.7 MB', '04.10.2023'),
(10, 'Özel Arapçeşme Ağız ve Diş Sağlığı Polikliniği', 'Personellerimizin ve 1. derece yakınlarının (anne, baba, eş ve çocuklar) diş sağlığına katkıda bulunmak adına çevre Polikliniklerimizle muayene, tetkik ve tedavilerde indirim anlaşmaları imzalanmıştır.', 'Protokoller', NULL, 'fas fa-tooth', 'https://personel.gebze.bel.tr/upload/antlasma/ozel-arapce-me-a-iz-ve-d-sa-li-i-pol-kl-n/ozel-arapce-me-a-iz-ve-d-sa-li-i-pol-kl-n_7964.pdf', NULL, '1.7 MB', '04.10.2023'),
(11, 'Şimşekdent Ağız ve Diş Sağlığı Polikliniği', 'Personellerimizin ve 1. derece yakınlarının (anne, baba, eş ve çocuklar) diş sağlığına katkıda bulunmak adına çevre Polikliniklerimizle muayene, tetkik ve tedavilerde indirim anlaşmaları imzalanmıştır.', 'Protokoller', NULL, 'fas fa-tooth', 'https://personel.gebze.bel.tr/upload/antlasma/m-ekdent-a-iz-ve-d-sa-li-i-pol-kl-n/m-ekdent-a-iz-ve-d-sa-li-i-pol-kl-n_2554.pdf', NULL, '2.3 MB', '20.12.2024'),
(12, 'Resmi Yazışma Kuralları', 'Kamu kurum ve kuruluşlarında kullanılması esas ve her kamu görevlisi tarafından bilinmesi gereken resmi yazışmalar hakkında mevzuat hükümleri.', 'Mevzuatlar', 'genel', 'fas fa-folder-open', 'https://personel.gebze.bel.tr/upload/regulation/resm-yazi-ma-kurallari/resm-yazi-ma-kurallari_1373.pdf', 'https://www.mevzuat.gov.tr/mevzuatmetin/21.5.2646.pdf', '2.3 MB', '04.10.2023'),
(13, 'Belediye Kanunu', 'Kanun Numarası : 5393 Kabul Tarihi : 3/7/2005 Yayımlandığı Resmî Gazete : Tarih :13/7/2005 Sayı : 25874 Yayımlandığı Düstur : Tertip : 5 Cilt : 44', 'Mevzuatlar', 'genel', 'fas fa-folder-open', 'https://personel.gebze.bel.tr/upload/regulation/5393-sayili-beled-ye-kanunu/5393-sayili-beled-ye-kanunu_8722.pdf', 'https://www.mevzuat.gov.tr/mevzuatmetin/1.5.5393.pdf', '845 KB', '04.10.2023'),
(14, 'Kamu İhale Kanunu', 'Kanunun Numarası : 4734 Kabul Tarihi : 4/1/2002 Yayımlandığı Resmî Gazete : Tarih :22/1/2002 Sayı : 24648 Yayımlandığı Düstur : Tertip : 5 Cilt : 42', 'Mevzuatlar', 'genel', 'fas fa-folder-open', 'https://personel.gebze.bel.tr/upload/regulation/kamu-hale-kanunu/kamu-hale-kanunu_4328.pdf', 'https://www.mevzuat.gov.tr/MevzuatMetin/1.5.4734.pdf', '1.7 MB', '04.10.2023'),
(15, 'Kamu İhale Sözleşmeleri Kanunu', ' Kanun Numarası : 4735 Kabul Tarihi : 5/1/2002 Yayımlandığı Resmî Gazete : Tarih :22/1/2002 Sayı : 24648 Yayımlandığı Düstur : Tertip : 5 Cilt : 42', 'Mevzuatlar', 'genel', 'fas fa-folder-open', 'https://personel.gebze.bel.tr/upload/regulation/kamu-hale-sozle-meler-kanunu/kamu-hale-sozle-meler-kanunu_8417.pdf', 'https://www.mevzuat.gov.tr/MevzuatMetin/1.5.4735.pdf', '2.3 MB', '04.10.2023'),
(16, 'İmar Kanunu', ' Kanun Numarası : 3194 Kabul Tarihi : 3/5/1985 Yayımlandığı R. Gazete : Tarih :9/5/1985 Sayı: 18749 Yayımlandığı Düstur : Tertip : 5 Cilt : 24 Sayfa : 378', 'Mevzuatlar', 'genel', 'fas fa-folder-open', 'https://personel.gebze.bel.tr/upload/regulation/3194-sayili-mar-kanunu/3194-sayili-mar-kanunu_9104.pdf', 'https://www.mevzuat.gov.tr/mevzuat?MevzuatNo=20122665&MevzuatTur=21&MevzuatTertip=5', '1.7 MB', '04.10.2023'),
(17, 'Kişisel Verilerin Korunması Kanunu', ' Kanun Numarası : 6698 Kabul Tarihi : 24/3/2016 Yayımlandığı Resmî Gazete : Tarih :7/4/2016 Sayı : 29677 Yayımlandığı Düstur : Tertip : 5 Cilt : 57', 'Mevzuatlar', 'genel', 'fa-file-signature', 'https://personel.gebze.bel.tr/upload/regulation/k-sel-ver-ler-n-korunmasi-kanunu/k-sel-ver-ler-n-korunmasi-kanunu_7116.pdf', 'https://www.mevzuat.gov.tr/mevzuat?MevzuatNo=6698&MevzuatTur=1&MevzuatTertip=5', '2.3 MB', '04.10.2023'),
(18, 'Devlet Memurları Kanunu', 'Kanun Numarası : 657 Kabul Tarihi : 14/7/1965 Yayımlandığı Resmî Gazete : Tarih :23/7/1965 Sayı : 12056 Yayımlandığı Düstur : Tertip : 5 Cilt : 4 Sayfa : 3044', 'Mevzuatlar', 'memur', 'fas fa-folder-open', 'https://personel.gebze.bel.tr/upload/regulation/657-sayili-devlet-memurlari-kanunu/657-sayili-devlet-memurlari-kanunu_1477.pdf', 'https://www.mevzuat.gov.tr/MevzuatMetin/1.5.657.pdf', '1.7 MB', '04.10.2023'),
(19, ' Devlet Memurlarına Verilecek Hastalık Raporları ile Hastalık ve Refakat İznine İlişkin Usul ve Esaslar Hakkında Yönetmenlik', 'Bakanlar Kurulu Kararının Tarihi : 22/8/2011 No : 2011/2226 Dayandığı Kanunun Tarihi :14/7/1965 No : 657 Yayımlandığı R.Gazetenin Tarihi : 29/10/2011 No : 28099 Yayımlandığı\r\nDüsturun Tertibi : 5 Cilt : 51', 'Mevzuatlar', 'memur', 'fas fa-folder-open', 'https://www.mevzuat.gov.tr/MevzuatMetin/3.5.20112226.pdf', 'https://personel.gebze.bel.tr/upload/regulation/devlet-memurlarina-ver-lecek-hastalik-raporlari-le-hastalik-ve-refakat-zn-ne-l-k-n-usul-ve-esaslar-hakkinda-yonetmel-k/devlet-memurlarina-ver-lecek-hastalik-raporlari-le-hastalik-ve-refakat-zn-ne-l-k-n-usul-ve-esaslar-hakkinda-yonetmel-k_3060.pdf', '1.7 MB', '04.10.2023'),
(20, 'Memurlar ve Diğer Kamu Görevlilerinin Yargılanması Hakkında Kanun', ' Kanun Numarası : 4483 Kabul Tarihi : 2/12/1999 Yayımlandığı Resmî Gazete : Tarih :4/12/1999 Sayı : 23896 Yayımlandığı Düstur : Tertip : 5 Cilt : 39', 'Mevzuatlar', 'memur', 'fas fa-folder-open', 'https://www.mevzuat.gov.tr/mevzuat?MevzuatNo=4483&MevzuatTur=1&MevzuatTertip=5', 'https://personel.gebze.bel.tr/upload/regulation/memurlar-ve-d-er-kamu-gorevl-ler-n-n-yargilanmasi-hakkinda-kanun/memurlar-ve-d-er-kamu-gorevl-ler-n-n-yargilanmasi-hakkinda-kanun_4777.pdf', '1.7 MB', '04.10.2023'),
(21, 'Mahalli İdareler Disiplin Amirleri Yönetmenliği', 'MAHALLİ İDARELER DİSİPLİN AMİRLERİ YÖNETMELİĞİ', 'Mevzuatlar', 'memur', 'fas fa-folder-open', 'https://personel.gebze.bel.tr/upload/regulation/mahall-dareler-d-s-pl-n-am-rler-yonetmel/mahall-dareler-d-s-pl-n-am-rler-yonetmel_5784.pdf', 'https://www.mevzuat.gov.tr/MevzuatMetin/yonetmelik/7.5.39416.pdf', '1.7 MB', '04.10.2023'),
(22, 'Sözleşmeli Personel Çalıştırılmasına İlişkin Esaslar', 'Bakanlar Kurulu Kararının; Tarihi ve No\'su : 6/6/1978-7/15754 Dayandığı Kanun :28/2/1978-2143 Yayımlandığı Resmi Gazete : 28/6/1978-16330 9/5/2020 tarihli ve 31122 sayılı Resmî Gazete\'de yayımlanan 8/5/2020 tarihli ve 2506 sayılı Cumhurbaşkanı Kararı uyarınca bu Yönetmelik Cumhurbaşkanlığı Yönetmeliği bölümüne eklenmiştir.', 'Mevzuatlar', 'sozlesmeli', 'fas fa-folder-open', 'https://personel.gebze.bel.tr/upload/regulation/sozle-mel-personel-cali-tirilmasina-l-k-n-esaslar/sozle-mel-personel-cali-tirilmasina-l-k-n-esaslar_7813.pdf', 'https://www.mevzuat.gov.tr/anasayfa/MevzuatFihristDetayIframe?MevzuatTur=21&MevzuatNo=715754&MevzuatTertip=5', '1.7 MB', '04.10.2023'),
(23, 'Sözleşmeli Personele Ek Ödeme Yapılmasına Dair Karar', 'Bakanlar Kurulu Kararının Tarihi: 3/1/2012 Sayısı: 2012/2665 Yayımlandığı Resmi Gazete Tarihi:10/1/2012 Sayısı: 28169', 'Mevzuatlar', 'sozlesmeli', 'fas fa-folder-open', 'https://personel.gebze.bel.tr/upload/regulation/sozle-mel-personele-ek-odeme-yapilmasina-da-r-karar/sozle-mel-personele-ek-odeme-yapilmasina-da-r-karar_7257.pdf', 'https://www.mevzuat.gov.tr/mevzuat?MevzuatNo=20122665&MevzuatTur=21&MevzuatTertip=5', '1.7 MB', '04.10.2023'),
(24, 'İş Kanunu', 'Kanun Numarası : 4857 Kabul Tarihi : 22/5/2003 Yayımlandığı Resmî Gazete : Tarih: 10/6/2003 Sayı : 25134 Yayımlandığı Düstur : Tertip : 5 Cilt : 42', 'Mevzuatlar', 'isci', 'fas fa-folder-open', 'https://personel.gebze.bel.tr/upload/regulation/4857-sayili-kanunu/4857-sayili-kanunu_8535.pdf', 'https://www.mevzuat.gov.tr/mevzuatmetin/1.5.4857.pdf', '1.7 MB', '04.10.2023'),
(25, 'Yaşam Enerjisini Yükseltme Yolları', 'Yaşam Enerjisini Yükseltme Yolları', 'Eğitimler', NULL, '', 'https://www.youtube.com/watch?v=NkLIwJsycKw', NULL, '2.3 MB', '04.10.2023'),
(26, 'Satın Alma Yöntem ve Süreçleri', 'Satın Alma Yöntem ve Süreçleri', 'Eğitimler', NULL, '', 'https://www.youtube.com/watch?v=HlSLDMRZOAE', NULL, '845 KB', '08.01.2025'),
(27, 'Disiplin Uygulamaları', 'Disiplin Uygulamaları', 'Eğitimler', '', '', 'https://www.youtube.com/watch?v=oQaAM3yFu5k', NULL, '2.3 MB', '20.12.2024'),
(28, 'Belediye Şirketleri', 'Belediye Şirketleri', 'Eğitimler', NULL, '', 'https://www.youtube.com/watch?v=Bpl95iZ8Gkc', NULL, '845 KB', '08.01.2025'),
(29, 'Belediyelerin Sosyal Yardım ve Hizmetleri', 'Belediyelerin Sosyal Yardım ve Hizmetleri', 'Eğitimler', NULL, '', 'https://www.youtube.com/watch?v=v_43pkCuwdg', NULL, '845 KB', '04.10.2023'),
(30, 'Bilgi Edinme Hakkı', 'Bilgi Edinme Hakkı', 'Eğitimler', NULL, '', 'https://www.youtube.com/watch?v=nTbrb8pqY9U', NULL, '2.3 MB', ' 04.10.2023'),
(31, 'Kırsal Mahalle ve Kırsal Yerleşik Alan Yönetmeliği', 'Kırsal Mahalle ve Kırsal Yerleşik Alan Yönetmeliği', 'Eğitimler', NULL, '', 'https://www.youtube.com/watch?v=HULXxszRxVk', NULL, '2.3 MB', '20.12.2024'),
(32, 'Kamulaştırma', 'Kamulaştırma', 'Eğitimler', NULL, '', 'https://www.youtube.com/watch?v=F5pE70bPaWM', NULL, '2.3 MB', ' 04.10.2023'),
(33, 'Yeni Zabıta Yönetmeliği', 'Yeni Zabıta Yönetmeliği', 'Eğitimler', NULL, '', 'https://www.youtube.com/watch?v=9QWJRD0G_Iw', NULL, '1.7 MB', '20.12.2024');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `oturum_kayitlari`
--

CREATE TABLE `oturum_kayitlari` (
  `id` int(11) NOT NULL,
  `personel_id` int(11) NOT NULL,
  `giris_zamani` datetime NOT NULL,
  `cikis_zamani` datetime DEFAULT NULL,
  `ip_adresi` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `kapanis_tipi` varchar(20) DEFAULT NULL,
  `son_aktivite` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `oturum_kayitlari`
--

INSERT INTO `oturum_kayitlari` (`id`, `personel_id`, `giris_zamani`, `cikis_zamani`, `ip_adresi`, `user_agent`, `kapanis_tipi`, `son_aktivite`) VALUES
(1, 1, '2026-07-06 14:39:17', '2026-07-06 14:39:17', NULL, NULL, 'eski', NULL),
(2, 1, '2026-07-06 14:40:20', '2026-07-06 14:40:20', NULL, NULL, 'eski', NULL),
(3, 1, '2026-07-06 14:47:54', '2026-07-06 14:47:54', NULL, NULL, 'eski', NULL),
(4, 1, '2026-07-06 14:48:21', '2026-07-06 14:48:21', NULL, NULL, 'eski', NULL),
(5, 1, '2026-07-06 14:55:05', '2026-07-06 14:55:05', NULL, NULL, 'eski', NULL),
(6, 1, '2026-07-06 14:56:53', '2026-07-06 14:56:53', NULL, NULL, 'eski', NULL),
(7, 1, '2026-07-06 15:02:01', '2026-07-06 15:02:01', NULL, NULL, 'eski', NULL),
(8, 1, '2026-07-06 15:24:53', '2026-07-06 15:29:04', NULL, NULL, NULL, NULL),
(9, 1, '2026-07-06 15:29:26', '2026-07-06 15:29:26', NULL, NULL, 'eski', NULL),
(10, 1, '2026-07-06 15:48:53', '2026-07-06 15:48:53', NULL, NULL, 'eski', NULL),
(11, 1, '2026-07-07 08:48:16', '2026-07-07 08:48:16', NULL, NULL, 'eski', NULL),
(12, 1, '2026-07-07 09:00:50', '2026-07-07 09:07:06', NULL, NULL, NULL, NULL),
(13, 1, '2026-07-07 09:07:54', '2026-07-07 09:08:23', NULL, NULL, NULL, NULL),
(14, 1, '2026-07-07 09:08:58', '2026-07-07 09:09:07', NULL, NULL, NULL, NULL),
(15, 1, '2026-07-07 09:15:32', '2026-07-07 09:18:04', NULL, NULL, NULL, NULL),
(16, 1, '2026-07-07 09:18:20', '2026-07-07 09:19:42', NULL, NULL, NULL, NULL),
(17, 1, '2026-07-07 09:19:52', '2026-07-07 09:35:43', NULL, NULL, NULL, NULL),
(18, 1, '2026-07-07 09:35:56', '2026-07-07 11:49:26', NULL, NULL, NULL, NULL),
(19, 1, '2026-07-07 11:49:39', '2026-07-07 12:17:40', NULL, NULL, NULL, NULL),
(20, 1, '2026-07-07 15:01:28', '2026-07-07 15:03:15', NULL, NULL, NULL, NULL),
(21, 1, '2026-07-07 15:03:22', '2026-07-07 15:03:22', NULL, NULL, 'eski', NULL),
(22, 1, '2026-07-08 13:30:07', '2026-07-08 13:34:04', NULL, NULL, NULL, NULL),
(23, 1, '2026-07-08 13:34:41', '2026-07-08 13:34:56', NULL, NULL, NULL, NULL),
(24, 1, '2026-07-08 13:35:22', '2026-07-08 13:39:23', NULL, NULL, NULL, NULL),
(25, 1, '2026-07-08 14:22:03', '2026-07-08 14:45:04', NULL, NULL, NULL, NULL),
(26, 1, '2026-07-08 14:45:08', '2026-07-08 15:01:24', NULL, NULL, NULL, NULL),
(27, 1, '2026-07-08 15:01:29', '2026-07-08 15:01:29', NULL, NULL, 'eski', NULL),
(28, 1, '2026-07-08 15:13:11', '2026-07-08 15:13:11', NULL, NULL, 'eski', NULL),
(29, 1, '2026-07-08 16:10:00', '2026-07-08 16:10:00', NULL, NULL, 'eski', NULL),
(30, 1, '2026-07-08 16:10:56', '2026-07-08 16:10:56', NULL, NULL, 'eski', NULL),
(31, 1, '2026-07-08 17:01:48', '2026-07-08 17:07:02', NULL, NULL, 'sekme', '2026-07-08 17:06:50'),
(32, 1, '2026-07-08 17:07:09', '2026-07-08 17:08:29', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'sekme', '2026-07-08 17:08:29'),
(33, 1, '2026-07-08 17:10:15', '2026-07-08 17:10:34', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'sekme', '2026-07-08 17:10:34'),
(34, 1, '2026-07-08 17:13:24', '2026-07-08 17:14:08', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'sekme', '2026-07-08 17:14:06'),
(35, 1, '2026-07-08 17:14:15', '2026-07-08 17:14:17', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'sekme', '2026-07-08 17:14:15'),
(36, 1, '2026-07-08 17:14:39', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', NULL, '2026-07-08 17:15:53');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `personeller`
--

CREATE TABLE `personeller` (
  `id` int(11) NOT NULL,
  `sicil_no` varchar(50) NOT NULL,
  `ad` varchar(50) NOT NULL,
  `soyad` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `sifre` varchar(255) NOT NULL,
  `dogum_tarihi` date NOT NULL,
  `foto_url` varchar(255) NOT NULL,
  `remember_token_hash` varchar(64) DEFAULT NULL,
  `remember_token_expires` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `personeller`
--

INSERT INTO `personeller` (`id`, `sicil_no`, `ad`, `soyad`, `email`, `sifre`, `dogum_tarihi`, `foto_url`, `remember_token_hash`, `remember_token_expires`) VALUES
(1, '12345', 'Zehra', 'Aralık', 'test3@gebze.bel.tr', '81dc9bdb52d04dc20036dbd8313ed055', '2006-07-07', '../images/gebze_logo.jpg', NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sizden_gelenler`
--

CREATE TABLE `sizden_gelenler` (
  `id` int(11) NOT NULL,
  `baslik` varchar(255) NOT NULL,
  `ozet` text NOT NULL,
  `kategori_slug` varchar(100) NOT NULL,
  `kategori_adi` varchar(150) NOT NULL,
  `tarih` date NOT NULL,
  `goruntulenme` int(11) DEFAULT 0,
  `gorsel_yolu` varchar(255) DEFAULT NULL,
  `olusturma_tarihi` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `sizden_gelenler`
--

INSERT INTO `sizden_gelenler` (`id`, `baslik`, `ozet`, `kategori_slug`, `kategori_adi`, `tarih`, `goruntulenme`, `gorsel_yolu`, `olusturma_tarihi`) VALUES
(1, 'İnsan Kaynakları ve Eğitim Müdürlüğü', '6734 ve 6735 Sayılı Kanun Eğitimi - Biyomedikal Eğitimi - Üniversite Eğitimi - Oryantasyon Eğitimi - Fen Programlama Eğitimi - Mevzuat Eğitimi - Teknoloji Çalışma Eğitimi...', 'insan-kaynaklari', 'İnsan Kaynakları ve Eğitim Müdürlüğü', '2023-11-06', 106, '../images/sizden_gelenler/insan_kaynaklari/nsan-kaynaklar-ve-e-itim-mudurlu-u_1547.jpg', '2026-07-02 12:20:03'),
(2, 'Fen İşleri Müdürlüğü', 'Köprülü Geçmis Mahallesi, 503 Sokak\'taki çalışmalar...Köprülü Geçmis Mahallesi, 503 Sokak\'taki çalışmalar...', 'fen-isleri', 'Fen İşleri Müdürlüğü', '2023-10-19', 147, '../images/sizden_gelenler/fen_isleri/fen-leri-mudurlu-u_3604.jpg', '2026-07-02 12:20:03'),
(3, 'Temizlik İşleri Müdürlüğü', 'Kül, katkısız ve tüm güzelleştirme organlarından şeye çeşit kurtarıcılar...Kül, katkısız ve tüm güzelleştirme organlarından şeye çeşit kurtarıcılar...', 'temizlik', 'Temizlik İşleri Müdürlüğü', '2023-10-19', 79, '../images/sizden_gelenler/temizlik_isleri/temizlik-leri-mudurlu-u_2142.jpg', '2026-07-02 12:20:03'),
(4, 'Veteriner İşleri Müdürlüğü', '4 Ekim Dünya Hayvanları Koruma Günü nedeniyle 4 Ekim boyunca...4 Ekim Dünya Hayvanları Koruma Günü nedeniyle 4 Ekim boyunca...', 'veteriner', 'Veteriner İşleri Müdürlüğü', '2023-10-17', 235, '../images/sizden_gelenler/veteriner_isleri/veteriner-leri-mudurlu-u_547.jpg', '2026-07-02 12:20:03'),
(5, 'Park ve Bahçeler Müdürlüğü', 'Bağışlanmış günlük programı göbildirinde park ve yeşil alanlarımızda...', 'park-bahce', 'Park ve Bahçeler Müdürlüğü', '2023-10-17', 157, '../images/sizden_gelenler/park_bahce/park-ve-bahceler-mudurlu-u_357.jpg', '2026-07-02 12:20:03'),
(6, 'İnsan Kaynakları Eğitim Semineri', 'Personel gelişimi için düzenlenen eğitim seminerimiz tamamlandı. Katılımcılarımız başarı sertifikalarını aldı...', 'insan-kaynaklari', 'İnsan Kaynakları ve Eğitim Müdürlüğü', '2023-10-15', 190, '../images/sizden_gelenler/insan_kaynaklari/nsan-kaynaklar-ve-e-itim-mudurlu-u_4846.jpg', '2026-07-02 12:20:03'),
(7, 'Yol Bakım ve Onarım Çalışmaları', 'Şehrimizin çeşitli bölgelerinde gerçekleştirilen yol bakım ve onarım çalışmaları devam ediyor...', 'fen-isleri', 'Fen İşleri Müdürlüğü', '2023-10-12', 268, '../images/sizden_gelenler/fen_isleri/fen-leri-mudurlu-u_8989.jpg', '2026-07-02 12:20:03'),
(8, 'Çevre Temizlik Kampanyası', 'Doğal yaşam alanlarının korunması için başlatılan temizlik kampanyası büyük ilgi gördü...', 'temizlik', 'Temizlik İşleri Müdürlüğü', '2023-10-10', 200, '../images/sizden_gelenler/temizlik_isleri/temizlik-leri-mudurlu-u_6633.jpg', '2026-07-02 12:20:03'),
(9, 'Dijital Dönüşüm Eğitimi', 'Personelimize yönelik dijital dönüşüm ve teknoloji kullanımı eğitimi başarıyla tamamlandı...', 'zabita', 'Zabıta Müdürlüğü', '2023-10-08', 312, '../images/sizden_gelenler/zabıta/zab-ta-mudurlu-u_6319.jpg', '2026-07-02 12:20:03'),
(10, 'Altyapı Geliştirme Projesi', 'Şehir merkezindeki altyapı geliştirme ve modernizasyon çalışmaları hızla devam ediyor...', 'fen-isleri', 'Fen İşleri Müdürlüğü', '2023-10-05', 423, '../images/sizden_gelenler/fen_isleri/fen-leri-mudurlu-u_8989.jpg', '2026-07-02 12:20:03'),
(11, 'Sokak Hayvanları Bakım Programı', 'Sokak hayvanlarının sağlık kontrolü ve bakım programı kapsamında çalışmalar sürdürülüyor...', 'veteriner', 'Veteriner İşleri Müdürlüğü', '2023-10-03', 187, '../images/sizden_gelenler/veteriner_isleri/veteriner-leri-mudurlu-u_547.jpg', '2026-07-02 12:20:03'),
(12, 'Yeşil Alan Düzenleme Çalışması', 'Kent genelindeki park ve yeşil alanların bakım ve düzenleme çalışmaları tamamlandı...', 'park-bahce', 'Park ve Bahçeler Müdürlüğü', '2023-10-01', 279, '../images/sizden_gelenler/park_bahce/park-ve-bahceler-mudurlu-u_4188.jpg', '2026-07-02 12:20:03');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `vefat_bilgileri`
--

CREATE TABLE `vefat_bilgileri` (
  `id` int(11) NOT NULL,
  `vefat_eden_adi` varchar(255) NOT NULL,
  `iliski_pozisyon` text NOT NULL,
  `vefat_tarihi` date NOT NULL,
  `vefat_tarihi_metin` varchar(50) NOT NULL,
  `cenaze_mesaji` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `vefat_bilgileri`
--

INSERT INTO `vefat_bilgileri` (`id`, `vefat_eden_adi`, `iliski_pozisyon`, `vefat_tarihi`, `vefat_tarihi_metin`, `cenaze_mesaji`) VALUES
(1, 'Sedat TÜRKKAN', 'Destek Hizmetleri Müdürlüğü personeli Ali Türkkan\'ın Babası ', '2024-12-21', '21 Aralık 2024', 'Destek Hizmetleri Müdürlüğü personeli Ali Türkkan\'ın babası Sedat Türkkan Vefat etmiştir.Cenazesi Yarın öğlen namazına müteakip Gebze Kargalı Köyü Camii\'nden kaldırılacaktır. İrtibat: Ali Türkkan 05312611643'),
(2, 'Emine AYDIN GÜL', 'Temizlik İşleri Müdürlüğü personeli Fahrettin Aydın\'ın kardeşi', '2024-12-21', '21 Aralık 2024', 'Temizlik İşleri Müdürlüğü personeli Fahrettin Aydın\'ın kardeşi Emine Aydın Gül vefat etmiştir.Cenazesi bugün öğlen namazına müteakip Darıca Fevzi Çakmak Mahallesi Camii\'nden kaldırılacaktır. İrtibat:05356598417'),
(3, 'Cevat ALTINTAŞ Annesi', 'Teftiş Kurulu Müdürü Cevat Altıntaş\'ın annesi', '2024-12-21', '21 Aralık 2024', 'Teftiş Kurulu Müdürü Cevat Altıntaş\'ın annesi vefat etmiştir.Cenazesi yarın öğlen namazına müteakip Trabzon,Sürmene Petekli Mahallesi Camii\'nden kaldırılacaktır. İrtibat:05337219067'),
(4, 'Nevzat TAŞKIN', 'Kültür Ve Sosyal İşler Müdürlüğü Personeli Engin Taşkın\'ın abisi', '2024-01-15', '15 Ocak 2024', 'Kültür Ve Sosyal İşler Müdürlüğü Personeli Engin Taşkın\'ın abisi Nevzat Taşkın vefat etmiştir. Cenazesi bugün öğlen namazına müteakip memleketi Yalova\'dan kaldırılcaktır.İrtibat: Engin Taşkın 05327823276'),
(5, 'Yavuz HORASAN Babası', 'İşletme ve İştirakler Müdürlüğü Personeli Yavuz Horasın\'ın babası ', '2024-01-15', '15 Ocak 2024', 'İşletme ve İştirakler Müdürlüğü Personeli Yavuz Horasın\'ın babası vefat etmiştir. Cenazesi bugün ikindi namazına müteakip Tokat Turhal\'dan kaldırılcaktır. İrtibat: Yavuz Horasan 05335423041'),
(6, 'Mehmet tevfik ŞAHİN', 'Destek Hizmetleri Müdürlüğü personeli Haluk Şahin\'in abisi', '2023-12-26', '26 Aralık 2023', 'Destek Hizmetleri Müdürlüğü personeli Haluk Şahin\'in abisi Mehmet Teşvik Şahin vefat etmiştir. Cenazesi öğlen namazına müteakip Eskişehir Günyüzü\'nde kaldırılacaktır. İrtibat: Haluk Şahin 05326311898'),
(7, 'Yusuf BİTMEZ', 'Emekli Belediye Başkan Danışmanımız Şakir Bitmez\'in babası', '2023-12-25', '25 Aralık 2023', 'Emekli Belediye Başkan Danışmanımız Şakir Bitmez\'in babası Yusuf Bitmez vefat etmiştir.Cenazesi bugün ikindi namazına müteakip Pendik Yayalar Mahallesi Mehmet Akif Ersoy Camii\'nden kaldırılacaktır.'),
(8, 'Erdoğan POLAT', 'Park Ve Bahçeler Müdürlüğü Personeli Tarık Polat\'ın amcası', '2023-12-20', '20 Aralık 2023', 'Park Ve Bahçeler Müdürlüğü Personeli Tarık Polat\'ın amcası Erdoğan Polat vefat etmiştir.Cenazesi bugün ikindi namazına müteakip Çayırova Bedir Camii\'nden kaldırılacaktır. İrtibat: Tarık Polat 05072524854'),
(9, 'Enver YAZICI\'NIN Kayınvalidesi', 'Kültür Müdürlüğü Personeli Enver Yazıcı\'nın kayınvalidesi', '2023-12-20', '20 Aralık 2023', 'Kültür Müdürlüğü Personeli Enver Yazıcı\'nın kayınvalidesi vefat etmiştir. Cenazesi bugün Cuma namazına müteakip Eskihisar Akşemseddin Camii\'nden kaldırılacaktır. İrtibat: Enver Yazıcı 05423454169'),
(10, 'Hafız Bahattin YİĞİT', 'Güvenlik Personellerimiz Adnan Yiğit ve Fuat Yiğit\'in babası', '2023-12-15', '15 Aralık 2023', 'Güvenlik Personellerimiz Adnan Yiğit ve Fuat Yiğit\'in babası Hafız Bahattin Yiğit vefat etmiştir. Cenazesi Cumartesi öğlen namazına müteakip Hürriyet Mahallesi Hz.Osman Camiin\'den kaldırılacaktır. İrtibat: Adnan Yiğit 05333502447-Fuat Yiğit 05421867958'),
(11, 'İsmail BİNGÖL Babası', 'Temizlik İşleri Müdürlüğü Personeli İsmail Bingöl\'ün babası', '2023-12-12', '12 Aralık 2023', 'Temizlik İşleri Müdürlüğü Personeli İsmail Bingöl\'ün babası vefat etmiştir. Cenazesi bugün öğlen namazına müteakip kaldırılacaktır. İrtibat: İsmail Bingöl 05354091358'),
(12, 'Cengiz AĞAÜZÜM', 'Belediyemizin Emekli Personeli Cengiz Ağaüzüm', '2023-12-12', '12 Aralık 2023', 'Belediyemizin Emekli Personeli Cengiz Ağaüzüm vefat etmiştir. Cenazesi bugün ikindi namazına müteakip Yıldız Camii\'nden kaldırılacaktır.İrtibat: Engin Ağaüzüm 05343033746'),
(13, 'Nuray Dal', 'Etüt Proje Müdürlüğü Personeli Günay Çatak\'ın ablası', '2023-12-12', '12 Aralık 2023', 'Etüt Proje Müdürlüğü Personeli Günay Çatak\'ın ablası Nury Dal vefat etmiştir. Cenazesi yarın öğlen namazına müteakip Aydın İli Çine İlçesinden kaldırılacaktır.'),
(14, 'Ali Osman İŞÇİ', 'Emlak ve İstimlak Müdürlüğü Personeli Salih Katı\'nın Kayınpederi', '2023-12-12', '12 Aralık 2023', 'Emlak ve İstimlak Müdürlüğü Personeli Salih Katı\'nın Kayınpederi Ali Osman İşçi vefat etmiştir. Cenazesi bugün öğle namazına müteakip Darıa Emek Mahallesi Merkez Camii\'nden kaldırılacaktır. İrtibat: Salih Katı 05327433232 '),
(15, 'Fikar KESKİNOĞLU', 'Basın Yayın Ve Halkla İlişkiler Müdürü Mecit Keskinoğlu\'nun Yengesi', '2023-12-05', '5 Aralık 2023', 'Basın Yayın Ve Halkla İlişkiler Müdürü Mecit Keskinoğlu\'nun Yengesi Fikar Keskinoğlu vefat etmiştir. Cenazesi yarın öğlen namazına müteakip Nenehatun Mahallesi Eyüpoğlu Camii\'nden kaldırılacaktır. İrtibat: Mecit Keskinoğlu 05359431643'),
(16, 'Murat ÇOBAN\'ın Ablası', 'Belediyemizin emekli personeli Murat Çoban\'ın Ablası', '2023-11-29', '29 Kasım 2023', 'Belediyemizin emekli personeli Murat Çoban\'ın ablası vefat etmiştir. Cenazesi bugün öğle namazına müteakip Darıca\'dan kaldırılacaktır. İrtibat:'),
(17, 'Teyfik BAYRAM', 'Zabıta Müdürlüğü Güvenlik Personeli Olcay Bayram\'ın Babası', '2023-11-24', '24 Kasım 2023', 'Zabıta Müdürlüğü Güvenlik Personeli Olcay Bayram\'ın babası Teyfik Bayram vefat etmiştir. Cenazesi bugün öğle namazına mütakip memleketi Amasya\'dan kaldırılcaktır. İrtibat: Olcay Bayram 0546226207'),
(18, 'Ahmet KARDEŞ\'in Amcası', 'Ruhsat Müdürlüğü Personeli Ahmet Kardeş\'in amcası ', '2023-11-23', '23 Kasım 2023', 'Ruhsat Müdürlüğü Personeli Ahmet Kardeş\'in amcası vefat etmiştir. Cenazesi bugün öğle namazına müteakip Yenimahalle Merkez Camii\'nden kaldırılacaktır. İrtibat: Ahmet Kardeş 05370308461'),
(19, 'Ramazan ZOR\'un Halası', 'Basın Yayın Halkla İlişkiler Müdürlüğü Personeli Ramazan Zor\'un Halası', '2023-11-13', '13 Kasım 2023', 'Baın Yayın Halkla İlişkiler Müdürlüğü Personeli Ramazan Zor\'un halası vefat etmiştir. Cenazesi yarın öğlen namazına müteakip İlyasbey Camii\'nden kaldırılacaktır. İrtibat: Ramazan Zor 05333360656'),
(20, 'Davut Şahin', 'Etüt Proje Müdürlüğü Personeli Ömer Şahin\'in Amcası', '2023-11-06', '6 Kasım 2023', 'Etüt Proje Müdürlüğü Personeli Ömer Şahin\'in amcası Davut Şahin vefat etmiştir. Cenazesi bugün öğle namazına müteakip İstanbul Rüzgarlı Bahçe Camii\'nden kaldırılacaktır. İrtibat Ömer Şahin 05387303472 '),
(21, 'Remzi DURAN', ' Destek Hizmetleri Personeli Tenzile Deniz\'in Babası', '2023-11-06', '6 Kasım 2023', 'Destek Hizmetleri Personeli Tenzile Deniz\'in babası Remzi Duran vefat etmiştir. Cenazesi bugün Öğlen namazına müteakip Elbizli Mahallesinde kaldırılacaktır.İrtibat: Tenzile Deniz 05454151007'),
(22, 'İsmet YILMAZ', 'Destek Hizmetleri Personeli İlker Yılmaz\'ın Babası', '2023-11-06', '6 Kasım 2023', 'Destek Hizmetleri Personeli İlker Yılmaz\'ın babası İsmet Yılmaz vefat etmiştir.Cenazesi yarın öğle namazına müteakip Beylikbağı Fatih Camii\'nden kaldırılacaktır. İrtibat: İlker YILMAZ 05438092966'),
(23, 'Erdal GÜNEY\'ın Kayınbiraderi', 'Temizlik İşleri Personeli Nazım Ertürk\'ün abisi Erdal Güney\'ın Kayınbiraderi', '2023-11-06', '6 Kasım 2023', 'Temizlik İşleri Personeli Nazım Ertürk\'ün abisi Erdal Güney\'ın kayınbiraderi vefat etmiştir. Cenazesi bugün öğlen namazından sonra Hürriyet Mahallesi Hz.Ali Camii\'nden kaldırılacaktır.İrtibat: Nazım Ertürk 05362215339-ErdalGüzey 05343572975'),
(24, 'Elmas ARSLAN', 'Veteriner İşleri Müdürlüğü Personeli Barış Arslan\'ın annesi', '2023-11-06', '6 Kasım 2023', 'Belediyemiz Veteriner İşleri Müdürlüğü Personeli Barış Arslan\'ın annesi Elmas Arslan vefat etmiştir. Cenazesi memleketi Giresun\'dan kaldırılacaktır. İrtibat: Barış Arslan 05333969761'),
(25, 'Fuat CAN', 'Özel Kalem Müdürlüğü Personeli Filiz Can\'ın Eşi', '2023-11-26', '26 Kasım 2023', 'Belediyemiz Özel KALEM Müdürlüğü personeli Filiz Can\'ın eşi Fuat Can vefat etmiştir. Cenazesi yarın öğlen namazına müteakip Nur Osmaniye Camii\'nden kaldırılacaktır. İrtibat: Eren Can 05523429125'),
(26, 'Ayşe VAROL', ' Belediyemizin Emekli Personeli İhsan Varol\'un eşi', '2023-11-26', '26 Kasım 2023', 'Belediyemizin emekli personeli İhsan Varol\'un eşi Ayşe Varol vefat etmiştir. Cenazesi ikindi namazına müteakip Yavuz Selim Mahallesi Ulu Camii\'nden kaldırılacaktır. İrtibat: İhsan Varol 05453676219'),
(27, 'Saadettin Gürkan\'ın Kayınpederi', 'Kültür Müdürlüğü Personeli Saadettin Gürkan\'ın Kayınpederi', '2023-11-26', '26 Kasım 2023', 'Belediyemizin Kültür Müdürlüğü Personeli Saadettin GÜRKAN\'ın kayınpederi vefat etmiştir. Cenazesi memleketi Ordu\'da defnedilcektir. İrtibat: Saadettin Gürkan 05427181294'),
(28, 'Tuncay KUYUCU\'nun Babası', 'Emlak İstimlak Müdürlüğü Personeli Tuncay Kuyucu\'nun babası', '2023-11-16', '16 Kasım 2023', 'Belediyemiz Emlak İstimlak Müdürlüğü personelimiz Tuncay Kuyucu\'nun babası vefat etmiştir. Cenaze pazar günü öğlen namazına müteakip Mudarlı köyünde defnedilmiştir. İrtibat: Tuncay Kuyucu 05363270149'),
(29, 'Metin Ve Murat ÇİMEN\'in babaannesi', 'Fen işleri Personelimiz Metin ve Murat Çimen\'in Babaannesi ', '2023-11-16', '16 Kasım 2023', 'Emekli Fen İşleri personelimiz İsmail ÇİMEN\'in annesi,Fen işleri Personelimiz Metin ve Murat Çimen\'in babaannesi vefat etmiştir.Cenazesi bugün ikindi namazına müteakip Barış Mahallesi Merkez Camii\'nden kaldırılacaktır. İrtibat: İsmail Çimen 05358250415 Metin Çimen 05378878231'),
(30, 'Hasan ALTINPARMAK\'ın Babası', 'Temizlik İşleri Müdürlüğü Personeli Hasan Altınparmak\'ın Babası', '2023-11-16', '16 Kasım 2023', 'Temizlik İşleri Müdürlüğü Personeli Hasan Altınparmak\'ın babası vefat etmiştir.Cenazesi bugün ikindi namazına müteakip Çayırova Mandıra(Mescid-i Aksa)Camii-\'nden kaldırılacaktır. İrtibat: Hasan Altınparmak 05310132598'),
(31, 'Namık Demir\'in Babası', 'Bilgi İşlem Müdürlüğü Personeli Namık Demir\'in Babası', '2023-09-07', '7 Eylül 2023', 'Belediyemiz Bilgi İşlem Müdürlüğü Personeli Namık Demir\'in babası vefat etmiştir. Cenazesi bugün öğle namazına müteakip memleketi Erzurum\'dan kaldırılacaktır. İrtibat: Namık Demir 05063654125');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `videolar`
--

CREATE TABLE `videolar` (
  `id` int(11) NOT NULL,
  `youtube_id` varchar(50) NOT NULL,
  `baslik` varchar(255) NOT NULL,
  `aciklama` text NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `sure` varchar(20) NOT NULL,
  `vitrin_baslik` varchar(255) DEFAULT NULL,
  `vitrin_aciklama` text DEFAULT NULL,
  `vitrin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `videolar`
--

INSERT INTO `videolar` (`id`, `youtube_id`, `baslik`, `aciklama`, `kategori`, `sure`, `vitrin_baslik`, `vitrin_aciklama`, `vitrin`) VALUES
(1, 'qLqYPQgUPEc', 'Gebze Offroad Heyecanı', 'Nefes kesen anlar ve çamurlu yollar... Offroad tutkunları bu etkinlikte buluştu.', 'etkinlikler', '15:22', NULL, NULL, 0),
(2, 'aUQ3uIAfL-k', 'Geleneksel Aşure Günü', 'Aşure gününde personelimizle bir araya geldik.', 'etkinlikler', '04:20', NULL, NULL, 0),
(3, 'RhVDYrAb0xQ', 'Yangın Tatbikatı Eğitimi', 'Acil durumlara hazırlık kapsamında düzenlenen eğitim videosu.', 'egitimler', '18:55', NULL, NULL, 0),
(4, 'c0vbYSFwMzU', 'İş Elbiseleri Dağıtımı', 'Yeni dönem iş elbiselerinin dağıtımıyla ilgili duyuru.', 'duyurular', '01:45', NULL, NULL, 0),
(5, '-0Wxna6PjqQ', 'Sokak Hayvanları Besleme Etkinliği', 'Patili dostlarımızı unutmadık, onlarla bir gün geçirdik.', 'etkinlikler', '06:33', NULL, NULL, 1),
(6, 'e65zC48s8Wc', 'Stresle Başa Çıkma Yöntemleri', 'İş hayatında stresi yönetmek için pratik bilgiler.', 'egitimler', '41:12', NULL, NULL, 0),
(7, 'YXat3fIWc7w', 'Kantin Fiyat Düzenlemesi', 'Yemekhane ve kantin fiyatları hakkındaki yeni düzenleme.', 'duyurular', '01:10', NULL, NULL, 0),
(8, 'QRizu8RhGnU', 'Fidan Dikme Etkinliği', 'Daha yeşil bir Gebze için personelimizle birlikte fidan diktik.', 'etkinlikler', '09:45', NULL, NULL, 0),
(9, 'Z2dH2UIXb8Y', 'Kişisel Verilerin Korunması (KVKK)', 'KVKK kanunu kapsamında personelimiz için zorunlu eğitim.', 'egitimler', '38:00', NULL, NULL, 0),
(10, 'G2KNC3OAnjE', 'Yıllık İzin Kullanımı Hakkında', 'İnsan kaynaklarından izin kullanımı ile ilgili önemli duyuru.', 'duyurular', '02:55', NULL, NULL, 0),
(11, 'RhD1ArYsuKo', 'Huzurevi Ziyareti', 'Sosyal sorumluluk projemiz kapsamında gerçekleştirdiğimiz ziyaret.', 'etkinlikler', '07:25', NULL, NULL, 0),
(12, 'IEc5W0JyADU', 'Zaman Yönetimi ve Verimlilik', 'Daha verimli çalışmanın ipuçları bu eğitimde.', 'egitimler', '28:30', NULL, NULL, 0),
(13, '3ePuzpC2S0Q', 'Yeni Servis Güzergahları Hk.', 'Personel servis güzergahlarındaki değişiklikler hakkında duyuru.', 'duyurular', '04:18', NULL, NULL, 0),
(14, 'qdPXmtKXXc4', 'Spor Turnuvası Kura Çekimi', 'Birimler arası spor turnuvası için kura çekimi heyecanı.', 'etkinlikler', '12:50', NULL, NULL, 0),
(15, 'uUFZvM9kqf4', 'Temel Ofis Programları Eğitimi', 'Word, Excel ve PowerPoint kullanımı üzerine temel eğitim serisi.', 'egitimler', '55:20', NULL, NULL, 0),
(16, 'BiY2WK24UHY', 'Maaş Avansı Kullanım Bilgilendirmesi', 'İnsan kaynaklarından personelimize duyuru.', 'duyurular', '03:05', NULL, NULL, 0),
(17, 'xot-DBvkkq4', 'Gebze Kitap Fuarı Başladı', 'Belediyemizin düzenlediği kitap fuarından ilk görüntüler.', 'etkinlikler', '08:12', NULL, NULL, 0),
(18, 'ABIqjRnV5dU', 'Etkili İletişim Teknikleri Semineri', 'Kurum içi iletişimimizi güçlendirmek için düzenlenen eğitim.', 'egitimler', '33:40', NULL, NULL, 0),
(19, 'psmlNSPRDsM', 'Önemli Sistem Güncellemesi', 'Bilgi İşlem Daire Başkanlığından önemli duyuru.', 'duyurular', '02.15', NULL, NULL, 0),
(20, 'pAHStsCd9jo', 'Belediye Pikniği 2025', 'Geçtiğimiz hafta sonu düzenlediğimiz personel pikniğinden renkli anlar.', 'etkinlikler', '05:48', NULL, NULL, 0),
(21, 'eUBQYWMZyH8', 'Bayramlaşma Töreni Duyurusu ', 'Geleneksel bayramlaşma törenimiz hakkında bilgilendirme. Tüm personelimiz davetlidir. ', 'duyurular', '01.30', NULL, NULL, 0),
(22, 'GWfDmGr6tlg', 'Yeni Personel İçin İSG Eğitimi', 'İş sağlığı ve güvenliği temelleri, tüm yeni personelimiz için önemli bir başlangıç.', 'egitimler', '45:10', NULL, NULL, 0),
(23, 'D1b-CZYtCTg', 'Portal Kullanım Kılavuzu', 'Personel portalının nasıl daha etkin kullanılacağına dair video.', 'duyurular', '11:30', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yardimci_linkler`
--

CREATE TABLE `yardimci_linkler` (
  `id` int(11) NOT NULL,
  `baslik` varchar(255) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `logo_url` varchar(255) DEFAULT NULL,
  `hedef_url` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `yardimci_linkler`
--

INSERT INTO `yardimci_linkler` (`id`, `baslik`, `kategori`, `logo_url`, `hedef_url`) VALUES
(1, 'OMIS', 'kurum-ici', '../images/otomasyon/omis_7572.png', 'https://ebelediye.gebze.bel.tr/eBelediye/'),
(2, 'Ulakbel', 'kurum-ici', '../images/otomasyon/ulakbel_5496.png', 'https://ulakbel.gebze.bel.tr/ulakbel#/'),
(3, 'İmar Yönetim Sistemi', 'kurum-ici', '../images/otomasyon/imar-yonetim-sistemi_8038.png', 'https://www.gebze.bel.tr/ebelediye/'),
(4, 'Dijital Arşiv', 'kurum-ici', '../images/otomasyon/dijital-arsiv_415.png', 'https://www.gebze.bel.tr/'),
(5, 'Outlook', 'kurum-ici', '../images/otomasyon/outlook_4005.png', 'https://outlook.live.com/'),
(6, 'Sosyal Yardım', 'kurum-ici', '../images/otomasyon/sosyal-yardim_3767.png', 'https://www.turkiye.gov.tr/ashb-sosyal-yardim-bilgileri-sorgulama'),
(7, 'Netcad', 'kurum-ici', '../images/otomasyon/netcad_3888.png', 'https://www.netcad.com/'),
(8, 'E-Belediye Sistemi', 'kurum-ici', '../images/otomasyon/ebys_8493.png', 'https://www.belediye.gov.tr/'),
(9, 'E-Belediye Evlendrme Modülü', 'kurum-ici', '../images/otomasyon/e-belediye-evlendirme-modulu_3993.png', 'https://www.belediye.gov.tr/evlendirme-modulu'),
(10, 'E-Belediye Sosyal Yardım Modülü', 'kurum-ici', '../images/otomasyon/e-belediye-sosyal-yard-m-modulu_4432.png', 'https://www.belediye.gov.tr/sosyal-yardim-takip-sistemi-syts-modulu'),
(11, 'Gebze Belediyesi', 'website', '../images/yardimci_linkler/web_siteleri/gebze-belediyesi.png', 'https://www.gebze.bel.tr/'),
(12, 'Kocaeli Büyükşehir Belediyesi', 'website', '../images/yardimci_linkler/web_siteleri/kocaeli-buyuksehir-belediyesi.png', 'https://www.kocaeli.bel.tr/'),
(13, 'Kocaeli Valiliği', 'website', '../images/yardimci_linkler/web_siteleri/kocaeli-vali.jpg', 'http://www.kocaeli.gov.tr/'),
(14, 'Gebze Kaymakamlığı', 'website', '../images/yardimci_linkler/web_siteleri/gebze-kaymakam.png', 'http://www.gebze.gov.tr/'),
(15, 'Türkiye Belediyeler Birliği', 'bilgi', '../images/yardimci_linkler/bilgi_portallari/turkiye-belediyeler-birligi_2430.png', 'https://www.tbb.gov.tr/tr'),
(16, 'Cumhurbaşkanlığı Uzaktan Eğitim Kapısı', 'bilgi', '../images/yardimci_linkler/bilgi_portallari/cumhur.jpg', 'https://uzaktanegitimkapisi.cbiko.gov.tr/Giris'),
(17, 'BTK Akademi Eğitim Portalı', 'bilgi', '../images/yardimci_linkler/bilgi_portallari/btk-akademi.jpg', 'https://www.btkakademi.gov.tr/'),
(18, 'Memurlar.Net', 'faydalı', '../images/yardimci_linkler/faydali_linkler/memurlar.png', 'https://www.memurlar.net/'),
(19, 'İlan', 'faydalı', '../images/yardimci_linkler/faydali_linkler/ilan.png', 'https://www.ilan.gov.tr/'),
(20, 'Resmi Gazete', 'faydalı', '../images/yardimci_linkler/faydali_linkler/resmi.png', 'https://www.resmigazete.gov.tr/');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `anasayfa_duyurular`
--
ALTER TABLE `anasayfa_duyurular`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `anasayfa_linkler`
--
ALTER TABLE `anasayfa_linkler`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_anasayfa_linkler_baslik_url` (`baslik`,`hedef_url`);

--
-- Tablo için indeksler `anketler`
--
ALTER TABLE `anketler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `duyurular`
--
ALTER TABLE `duyurular`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `etkinlikler`
--
ALTER TABLE `etkinlikler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `etkinlikler_duyurular`
--
ALTER TABLE `etkinlikler_duyurular`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `haberler`
--
ALTER TABLE `haberler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `haber_galeri`
--
ALTER TABLE `haber_galeri`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_haber_galeri_haber_id` (`haber_id`);

--
-- Tablo için indeksler `icerik_izlemeleri`
--
ALTER TABLE `icerik_izlemeleri`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_icerik_izleme` (`tablo`,`kayit_id`,`izleyici`);

--
-- Tablo için indeksler `kaynaklar`
--
ALTER TABLE `kaynaklar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `oturum_kayitlari`
--
ALTER TABLE `oturum_kayitlari`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_oturum_personel_id` (`personel_id`),
  ADD KEY `idx_oturum_acik` (`personel_id`,`cikis_zamani`);

--
-- Tablo için indeksler `personeller`
--
ALTER TABLE `personeller`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_personeller_sicil_no` (`sicil_no`),
  ADD UNIQUE KEY `uq_personeller_email` (`email`),
  ADD UNIQUE KEY `uq_personeller_remember_token_hash` (`remember_token_hash`),
  ADD KEY `idx_personeller_dogum_tarihi` (`dogum_tarihi`);

--
-- Tablo için indeksler `sizden_gelenler`
--
ALTER TABLE `sizden_gelenler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `vefat_bilgileri`
--
ALTER TABLE `vefat_bilgileri`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `videolar`
--
ALTER TABLE `videolar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_videolar_youtube_id` (`youtube_id`),
  ADD KEY `idx_videolar_kategori` (`kategori`),
  ADD KEY `idx_videolar_vitrin` (`vitrin`);

--
-- Tablo için indeksler `yardimci_linkler`
--
ALTER TABLE `yardimci_linkler`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_yardimci_linkler_kat_baslik_url` (`kategori`,`baslik`,`hedef_url`) USING HASH;

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `anasayfa_duyurular`
--
ALTER TABLE `anasayfa_duyurular`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Tablo için AUTO_INCREMENT değeri `anasayfa_linkler`
--
ALTER TABLE `anasayfa_linkler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Tablo için AUTO_INCREMENT değeri `anketler`
--
ALTER TABLE `anketler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `duyurular`
--
ALTER TABLE `duyurular`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Tablo için AUTO_INCREMENT değeri `etkinlikler`
--
ALTER TABLE `etkinlikler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Tablo için AUTO_INCREMENT değeri `etkinlikler_duyurular`
--
ALTER TABLE `etkinlikler_duyurular`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Tablo için AUTO_INCREMENT değeri `haberler`
--
ALTER TABLE `haberler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Tablo için AUTO_INCREMENT değeri `haber_galeri`
--
ALTER TABLE `haber_galeri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Tablo için AUTO_INCREMENT değeri `icerik_izlemeleri`
--
ALTER TABLE `icerik_izlemeleri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- Tablo için AUTO_INCREMENT değeri `kaynaklar`
--
ALTER TABLE `kaynaklar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Tablo için AUTO_INCREMENT değeri `oturum_kayitlari`
--
ALTER TABLE `oturum_kayitlari`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Tablo için AUTO_INCREMENT değeri `personeller`
--
ALTER TABLE `personeller`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `sizden_gelenler`
--
ALTER TABLE `sizden_gelenler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Tablo için AUTO_INCREMENT değeri `vefat_bilgileri`
--
ALTER TABLE `vefat_bilgileri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Tablo için AUTO_INCREMENT değeri `videolar`
--
ALTER TABLE `videolar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Tablo için AUTO_INCREMENT değeri `yardimci_linkler`
--
ALTER TABLE `yardimci_linkler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `haber_galeri`
--
ALTER TABLE `haber_galeri`
  ADD CONSTRAINT `fk_haber_galeri_haber` FOREIGN KEY (`haber_id`) REFERENCES `haberler` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `oturum_kayitlari`
--
ALTER TABLE `oturum_kayitlari`
  ADD CONSTRAINT `fk_oturum_personel` FOREIGN KEY (`personel_id`) REFERENCES `personeller` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
