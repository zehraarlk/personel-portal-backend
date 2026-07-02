-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 02 Tem 2026, 14:25:30
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
-- Tablo için tablo yapısı `videolar`
--

CREATE TABLE `videolar` (
  `id` int(11) NOT NULL,
  `youtube_id` varchar(50) NOT NULL,
  `baslik` varchar(255) NOT NULL,
  `aciklama` text NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `sure` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `videolar`
--

INSERT INTO `videolar` (`id`, `youtube_id`, `baslik`, `aciklama`, `kategori`, `sure`) VALUES
(1, 'D1b-CZYtCTg', 'Portal Kullanım Kılavuzu', 'Personel portalının nasıl daha etkin kullanılacağına dair video.', 'duyurular', '11:30'),
(2, 'GWfDmGr6tlg', 'Yeni Personel İçin İSG Eğitimi', 'İş sağlığı ve güvenliği temelleri, tüm yeni personelimiz için önemli bir başlangıç.', 'egitimler', '45:10'),
(3, 'eUBQYWMZyH8', 'Bayramlaşma Töreni Duyurusu\r\n', 'Geleneksel bayramlaşma törenimiz hakkında bilgilendirme. Tüm personelimiz davetlidir.\r\n', 'duyurular', '01.30'),
(4, 'pAHStsCd9jo', 'Belediye Pikniği 2025', 'Geçtiğimiz hafta sonu düzenlediğimiz personel pikniğinden renkli anlar.', 'etkinlikler', '05:48'),
(5, 'psmlNSPRDsM', 'Önemli Sistem Güncellemesi', 'Bilgi İşlem Daire Başkanlığından önemli duyuru.', 'duyurular', '02.15'),
(6, 'ABIqjRnV5dU', 'Etkili İletişim Teknikleri Semineri', 'Kurum içi iletişimimizi güçlendirmek için düzenlenen eğitim.', 'egitimler', '33:40'),
(7, 'xot-DBvkkq4', 'Gebze Kitap Fuarı Başladı', 'Belediyemizin düzenlediği kitap fuarından ilk görüntüler.', 'etkinlikler', '08:12'),
(8, 'BiY2WK24UHY', 'Maaş Avansı Kullanım Bilgilendirmesi', 'İnsan kaynaklarından personelimize duyuru.', 'duyurular', '03:05'),
(9, 'uUFZvM9kqf4', 'Temel Ofis Programları Eğitimi', 'Word, Excel ve PowerPoint kullanımı üzerine temel eğitim serisi.', 'egitimler', '55:20'),
(10, 'qdPXmtKXXc4', 'Spor Turnuvası Kura Çekimi', 'Birimler arası spor turnuvası için kura çekimi heyecanı.', 'etkinlikler', '12:50'),
(11, '3ePuzpC2S0Q', 'Yeni Servis Güzergahları Hk.', 'Personel servis güzergahlarındaki değişiklikler hakkında duyuru.', 'duyurular', '04:18'),
(12, 'IEc5W0JyADU', 'Zaman Yönetimi ve Verimlilik', 'Daha verimli çalışmanın ipuçları bu eğitimde.', 'egitimler', '28:30'),
(13, 'RhD1ArYsuKo', 'Huzurevi Ziyareti', 'Sosyal sorumluluk projemiz kapsamında gerçekleştirdiğimiz ziyaret.', 'etkinlikler', '07:25'),
(14, 'G2KNC3OAnjE', 'Yıllık İzin Kullanımı Hakkında', 'İnsan kaynaklarından izin kullanımı ile ilgili önemli duyuru.', 'duyurular', '02:55'),
(15, 'Z2dH2UIXb8Y', 'Kişisel Verilerin Korunması (KVKK)', 'KVKK kanunu kapsamında personelimiz için zorunlu eğitim.', 'egitimler', '38:00'),
(16, 'QRizu8RhGnU', 'Fidan Dikme Etkinliği', 'Daha yeşil bir Gebze için personelimizle birlikte fidan diktik.', 'etkinlikler', '09:45'),
(17, 'YXat3fIWc7w', 'Kantin Fiyat Düzenlemesi', 'Yemekhane ve kantin fiyatları hakkındaki yeni düzenleme.', 'duyurular', '01:10'),
(18, 'e65zC48s8Wc', 'Stresle Başa Çıkma Yöntemleri', 'İş hayatında stresi yönetmek için pratik bilgiler.', 'egitimler', '41:12'),
(19, '-0Wxna6PjqQ', 'Sokak Hayvanları Besleme Etkinliği', 'Patili dostlarımızı unutmadık, onlarla bir gün geçirdik.', 'etkinlikler', '06:33'),
(20, 'c0vbYSFwMzU', 'İş Elbiseleri Dağıtımı', 'Yeni dönem iş elbiselerinin dağıtımıyla ilgili duyuru.', 'duyurular', '01:45'),
(21, 'RhVDYrAb0xQ', 'Yangın Tatbikatı Eğitimi', 'Acil durumlara hazırlık kapsamında düzenlenen eğitim videosu.', 'egitimler', '18:55'),
(22, 'aUQ3uIAfL-k', 'Geleneksel Aşure Günü', 'Aşure gününde personelimizle bir araya geldik.', 'etkinlikler', '04:20'),
(23, 'qLqYPQgUPEc', 'Gebze Offroad Heyecanı', 'Nefes kesen anlar ve çamurlu yollar... Offroad tutkunları bu etkinlikte buluştu.', 'etkinlikler', '15:22');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `videolar`
--
ALTER TABLE `videolar`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `videolar`
--
ALTER TABLE `videolar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
