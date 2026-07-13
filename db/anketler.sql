-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 13 Tem 2026, 15:36:42
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.0.30

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
-- Tablo için tablo yapısı `anketler`
--

CREATE TABLE `anketler` (
  `id` int(11) NOT NULL,
  `baslik` varchar(255) NOT NULL,
  `aciklama` text DEFAULT NULL,
  `resim_url` varchar(500) DEFAULT NULL,
  `baslangic_tarihi` date DEFAULT NULL,
  `bitis_tarihi` date DEFAULT NULL,
  `katilim_sayisi` int(11) DEFAULT 0,
  `hedef_katilim` int(11) DEFAULT 0,
  `favori` tinyint(1) NOT NULL DEFAULT 0,
  `kategori_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `anketler`
--

INSERT INTO `anketler` (`id`, `baslik`, `aciklama`, `resim_url`, `baslangic_tarihi`, `bitis_tarihi`, `katilim_sayisi`, `hedef_katilim`, `favori`, `kategori_id`) VALUES
(13, 'Personel Memnuniyet Anketi', 'Belediyemiz bünyesindeki genel memnuniyeti, yönetim süreçlerini ve kurumsal aidiyet duygusunu ölçümlemek amacıyla hazırlanmıştır.', 'https://images.unsplash.com/photo-1541746972996-4e0b0f43e02a?q=80&w=600', '2026-07-01', '2026-08-31', 1, 200, 1, 1),
(14, 'Eğitim İhtiyaç Analizi', 'Gelecek dönem düzenleyeceğimiz mesleki ve kişisel gelişim eğitimlerini sizin talep ve ihtiyaçlarınıza göre şekillendiriyoruz.', 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=600', '2026-07-10', '2026-09-15', 1, 150, 0, 1),
(15, 'İş Ortamı Değerlendirme Anketi', 'Çalıştığınız birimdeki fiziksel koşulları, teknik donanım yeterliliğini ve iş sağlığı standartlarını tespit etmeyi amaçlıyoruz.', 'https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=600', '2026-07-12', '2026-08-15', 1, 250, 0, 1);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `anketler`
--
ALTER TABLE `anketler`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_anketler_kategori_id` (`kategori_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `anketler`
--
ALTER TABLE `anketler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `anketler`
--
ALTER TABLE `anketler`
  ADD CONSTRAINT `fk_anketler_kategori` FOREIGN KEY (`kategori_id`) REFERENCES `anketler_kategori` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
