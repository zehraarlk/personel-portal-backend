-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 09 Tem 2026, 12:53:34
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
  `sure` varchar(20) NOT NULL,
  `kategori_id` int(11) DEFAULT NULL,
  `vitrin_baslik` varchar(255) DEFAULT NULL,
  `vitrin_aciklama` text DEFAULT NULL,
  `vitrin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `videolar`
--

INSERT INTO `videolar` (`id`, `youtube_id`, `baslik`, `aciklama`, `kategori`, `sure`, `kategori_id`, `vitrin_baslik`, `vitrin_aciklama`, `vitrin`) VALUES
(1, 'qLqYPQgUPEc', 'Gebze Offroad Heyecanı', 'Nefes kesen anlar ve çamurlu yollar... Offroad tutkunları bu etkinlikte buluştu.', 'etkinlikler', '00:30', 3, NULL, NULL, 0),
(2, 'aUQ3uIAfL-k', 'Türkiye\'nin Sıfır Atık Kenti Bilgilendiriyor', 'Sıfır Atık Projesi Kapsamında atıkları kaynağından ayrıştıran Mobil Atık Getirme Merkezlerini Gebze\'mizde yaygınlaştırıyoruz.\r\n', 'etkinlikler', '00:33', 3, NULL, NULL, 0),
(3, 'RhVDYrAb0xQ', 'Gebze #shorts', 'Gebzemiz', 'etkinlikler', '00:07', 3, NULL, NULL, 0),
(4, 'c0vbYSFwMzU', 'Gebze Belediyesi MBB Altın Karınca Yarışması Dijital Kapı Projesi', 'Altın Karınca Yarışması', 'duyurular', '02:46', 1, NULL, NULL, 0),
(5, '-0Wxna6PjqQ', 'Vatandaşlarımızın Hayatını Kolaylaştırıyoruz...', 'İnteraktif Belediyecilik Vatandaşlarımızın Hayatını Kolaylaştırıyoruz.\r\n', 'etkinlikler', '00:56', 3, NULL, NULL, 1),
(6, 'e65zC48s8Wc', 'Çocuklarımızı Da Elbette Unutmadık', 'Çocuklarımızı da elbette unutmadık.', 'etkinlikler', '00:46', 3, NULL, NULL, 0),
(7, 'YXat3fIWc7w', 'İnteraktif Belediyecilikle Gebze\'de artık her şey çok kolay...', 'İnteraktif Belediyecilikle Gebze\'de artık her şey çok kolay.', 'duyurular', '00:59', 1, NULL, NULL, 0),
(8, 'QRizu8RhGnU', 'Dijital Belediye İnteraktif Yaklaşım', 'Dijital Belediye İnteraktif Yaklaşım', 'duyurular', '05:12', 1, NULL, NULL, 0),
(9, 'Z2dH2UIXb8Y', 'Zeki Bey\'in \'interaktif\' macerası başlıyor...', 'Zeki Bey\'in \'interaktif\' macerası başlıyor.', 'duyurular', '00:55', 1, NULL, NULL, 0),
(10, 'G2KNC3OAnjE', 'Türkiye Aşkına', 'Türkiye Aşkına', 'etkinlikler', '00:42', 3, NULL, NULL, 0),
(11, 'RhD1ArYsuKo', 'Türkiye\'nin 7/24 hizmet veren ilk ve tek bebek & çocuk bakımevini Gebze\'mizde hizmete açtık\r\n', 'Türkiye\'nin 7/24 hizmet veren ilk ve tek bebek & çocuk bakımevini Gebze\'mizde hizmete açtık\r\n', 'etkinlikler', '00:48', 1, NULL, NULL, 0),
(12, 'IEc5W0JyADU', 'Gesmek Sergimiz ', '#shorts', 'etkinlikler', '00:07', 3, NULL, NULL, 0),
(13, '3ePuzpC2S0Q', 'Eskihisarda Müzik Rüzgarı', 'Eskihisar\'da müzik rüzgarı', 'etkinlikler', '00:26', 3, NULL, NULL, 0),
(14, 'qdPXmtKXXc4', 'Yapım işini tamamladığımız İlyasbey Sağlıklı Yaşam Merkezi \'miz', 'İlyasbey Sağlıklı Yaşam Merkezi', 'duyurular', '00:34', 1, NULL, NULL, 0),
(15, 'uUFZvM9kqf4', 'Marmara\'nın İncisi Eskihisar\'da,30 bin metrekare yakın hayalet ağ çıkaracağız\r\n', 'Marmara\'nın İncisi Eskihisar', 'duyurular', '00:42', 1, NULL, NULL, 0),
(16, 'BiY2WK24UHY', 'Şehirler Arası Otobüs Terminalimizin işlevselliğini artırıyoruz\r\n', 'Şehirler Arası Otobüs Terminalimizin işlevselliğini artırıyoruz', 'duyurular', '00:41', 1, NULL, NULL, 0),
(17, 'xot-DBvkkq4', 'Matematik, Edebiyat Sınıfları ve modern derslikler gençliğin Güzide Merkezinde...\r\n', 'Matematik, Edebiyat Sınıfları ve modern derslikler gençliğin Güzide Merkezinde...\r\n\r\n', 'etkinlikler', '00:26', 3, NULL, NULL, 0),
(18, 'ABIqjRnV5dU', 'Cam Şişe Bırakma, Ormanlarımız Hep Yaşasın!', 'Cam Şişe Bırakma, Ormanlarımız Hep Yaşasın!', 'etkinlikler', '00:21', 3, NULL, NULL, 0),
(19, 'psmlNSPRDsM', 'Türkiye Panorama II', 'Türkiye Panorama II', 'etkinlikler', '03:22', 3, NULL, NULL, 0),
(20, 'pAHStsCd9jo', 'E Atık | Kent Madenciliği', 'Geçtiğimiz hafta sonu düzenlediğimiz personel pikniğinden renkli anlar.', 'etkinlikler', '05:14', 3, NULL, NULL, 0),
(21, 'eUBQYWMZyH8', 'Atık Sonu | End of Waste', 'Atık Sonu | End of Waste', 'etkinlikler', '03:51', 3, NULL, NULL, 0),
(22, 'GWfDmGr6tlg', 'Gebze\'yi Sağlama Aldık', '\"Gebze\'yi Sağlama Aldık\" mottosuyla düzenlediğimiz 2019-2023 dönemi hizmet ve eserlerimizin sunumu il ve ilçe protokolünün katılımıyla gerçekleştirdik.', 'etkinlikler', '03:20', 3, NULL, NULL, 0),
(23, 'D1b-CZYtCTg', 'Gebzeli CEZA', 'Gebzeli CEZA', 'etkinlikler', '00:40', 3, NULL, NULL, 0);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `videolar`
--
ALTER TABLE `videolar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_videolar_youtube_id` (`youtube_id`),
  ADD KEY `idx_videolar_kategori` (`kategori`),
  ADD KEY `idx_videolar_kategori_id` (`kategori_id`),
  ADD KEY `idx_videolar_vitrin` (`vitrin`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `videolar`
--
ALTER TABLE `videolar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `videolar`
--
ALTER TABLE `videolar`
  ADD CONSTRAINT `fk_videolar_kategori` FOREIGN KEY (`kategori_id`) REFERENCES `videolar_kategori` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
