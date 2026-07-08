-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 07 Tem 2026, 14:14:14
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
-- Tablo için tablo yapısı `oturum_kayitlari`
--

CREATE TABLE `oturum_kayitlari` (
  `id` int(11) NOT NULL,
  `personel_id` int(11) NOT NULL,
  `giris_zamani` datetime NOT NULL,
  `cikis_zamani` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `oturum_kayitlari`
--

INSERT INTO `oturum_kayitlari` (`id`, `personel_id`, `giris_zamani`, `cikis_zamani`) VALUES
(1, 1, '2026-07-06 14:39:17', NULL),
(2, 1, '2026-07-06 14:40:20', NULL),
(3, 1, '2026-07-06 14:47:54', NULL),
(4, 1, '2026-07-06 14:48:21', NULL),
(5, 1, '2026-07-06 14:55:05', NULL),
(6, 1, '2026-07-06 14:56:53', NULL),
(7, 1, '2026-07-06 15:02:01', NULL),
(8, 1, '2026-07-06 15:24:53', '2026-07-06 15:29:04'),
(9, 1, '2026-07-06 15:29:26', NULL),
(10, 1, '2026-07-06 15:48:53', NULL),
(11, 1, '2026-07-07 08:48:16', NULL),
(12, 1, '2026-07-07 09:00:50', '2026-07-07 09:07:06'),
(13, 1, '2026-07-07 09:07:54', '2026-07-07 09:08:23'),
(14, 1, '2026-07-07 09:08:58', '2026-07-07 09:09:07'),
(15, 1, '2026-07-07 09:15:32', '2026-07-07 09:18:04'),
(16, 1, '2026-07-07 09:18:20', '2026-07-07 09:19:42'),
(17, 1, '2026-07-07 09:19:52', '2026-07-07 09:35:43'),
(18, 1, '2026-07-07 09:35:56', '2026-07-07 11:49:26'),
(19, 1, '2026-07-07 11:49:39', '2026-07-07 12:17:40'),
(20, 1, '2026-07-07 15:01:28', '2026-07-07 15:03:15'),
(21, 1, '2026-07-07 15:03:22', NULL);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `oturum_kayitlari`
--
ALTER TABLE `oturum_kayitlari`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `oturum_kayitlari`
--
ALTER TABLE `oturum_kayitlari`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
