-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 02 Tem 2026, 10:29:57
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
-- Tablo için tablo yapısı `duyurular`
--

CREATE TABLE `duyurular` (
  `id` int(11) NOT NULL,
  `baslik` varchar(255) NOT NULL,
  `aciklama` text NOT NULL,
  `resim` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `duyurular`
--

INSERT INTO `duyurular` (`id`, `baslik`, `aciklama`, `resim`) VALUES
(1, 'Stajyer Oryantasyon Eğitimi Tamamlandı', 'Belediyemizde yeni döneme başlayan stajyer öğrencilerimiz için oryantasyon programı düzenlendi.', '../images/stajyer-oryantasyon-e-t-m_8697.jpg'),
(2, 'Geleneksel Bayramlaşma Töreni Gerçekleşti', 'Kurban Bayramı vesilesiyle tüm personelimizin katılımıyla coşkulu bir bayramlaşma programı yapıldı.', '../images/24-kas-m-o-retmenler-gunu_2947.jpg'),
(3, '8 Mart Dünya Kadınlar Günü Kutlandı', 'Belediyemizdeki kadın personelimizin Dünya Kadınlar Günü\'nü özel bir etkinlikle kutladık.', '../images/8-mart-dunya-kadinlar-gunu-programi_8383.jpg'),
(4, 'Personel İftar Programı Büyük İlgi Gördü', 'Ramazan ayının manevi atmosferinde personelimizle birlikte iftar sofrasında buluştuk.', '../images/personel-ftar-program_109.jpg'),
(5, 'Öğretmenler Günü Unutulmadı', 'Gebze\'deki öğretmenlerimizi bu özel günlerinde yalnız bırakmadık ve çeşitli ziyaretler gerçekleştirdik.', '../images/24-kas-m-o-retmenler-gunu_2947.jpg'),
(6, 'Dağ Bisikleti Kupası Gebze\'de Nefes Kesti', 'Türkiye Ulusal Dağ Bisikleti Kupası\'nın bir ayağına ev sahipliği yapmanın gururunu yaşadık.', '../images/ulusal-da-bisikleti-kupas-yar-lar_128.jpg'),
(7, 'Personelimize Ağız ve Diş Sağlığı Taraması', 'Çalışanlarımızın sağlığını önemsiyor, düzenli olarak sağlık taramaları gerçekleştiriyoruz.', '../images/personellerimizin-a-z-ve-di-sa-l-n-onemsiyoruz_7091.jpg'),
(8, 'Yaz Sezonunu Piknikle Açtık', 'Yoğun çalışma temposuna mola vererek tüm birimlerimizin katıldığı bir piknik organizasyonu düzenledik.', '../images/personel-p-kn-k-programi_9118.jpg'),
(9, 'Stajyerlerle Film Okuma Etkinliği', 'Gençlerimizin vizyonunu geliştirmek amacıyla film okuma ve analiz programları düzenliyoruz.', '../images/stajyer-f-lm-okuma-programi_3604.jpg'),
(10, 'İkinci Geleneksel İftar Buluşması', 'Personelimiz ve aileleriyle birlikte Ramazan ayının bereketini paylaştığımız iftar programımız.', '../images/personel-ftar-program_109.jpg'),
(11, 'Stajyer Dönem Sonu Veda Programı', 'Staj dönemini başarıyla tamamlayan öğrencilerimiz için bir veda ve teşekkür etkinliği düzenlendi.', '../images/stajyer-donem-sonu-etk-nl_6028.jpg'),
(12, 'Yeni Stajyerlerimize \"Hoş Geldin\" Dedik', 'Belediye çalışmalarını yakından tanımaları için yeni stajyerlerimize yönelik bir oryantasyon yapıldı.', '../images/stajyer-oryantasyon-e-t-m_8697.jpg'),
(13, 'Kadın Personelimize Özel İkramlar', '8 Mart kapsamında belediyemizdeki tüm kadın çalışanlarımıza küçük bir jest hazırladık.', '../images/8-mart-dunya-kadinlar-gunu-programi_8383.jpg'),
(14, 'Ramazan Bayramı Buluşması', 'Ramazan Bayramı dolayısıyla personelimizle bir araya gelerek bayramlaştık.', '../images/personel-bayramla-ma-programi_5965.jpg'),
(15, 'Birlik ve Beraberlik İftarı', 'İftar programımız, personelimiz arasındaki birlik ve beraberliği pekiştirdi.', '../images/personel-ftar-program_109.jpg');

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

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `duyurular`
--
ALTER TABLE `duyurular`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `haberler`
--
ALTER TABLE `haberler`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `duyurular`
--
ALTER TABLE `duyurular`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Tablo için AUTO_INCREMENT değeri `haberler`
--
ALTER TABLE `haberler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
