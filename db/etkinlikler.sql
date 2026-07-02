-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 02 Tem 2026, 14:25:53
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
(1, 'Stajyer Oryantasyon Eğitimi', '6734 ve 6735 Sayılı Kanun Eğitimi - Biyomedikal Eğitimi - Üniversite Eğitimi - Oryantasyon Eğitimi - Fen Programlama Eğitimi - Mevzuat Eğitimi - Teknoloji Çalışma Eğitimi...', '2025-08-06', '2025-12-31', 91, 'aktif', '../images/stajyer-oryantasyon-e-t-m_8697.jpg'),
(2, 'Stajyer Dönem Sonu Etkinliği', 'Köprülü Geçmis Mahallesi, 503 Sokak\'taki çalışmalar...Köprülü Geçmis Mahallesi, 503 Sokak\'taki çalışmalar...', '2025-05-22', '2025-06-30', 145, 'aktif', '../images/stajyer-donem-sonu-etk-nl_6028.jpg'),
(3, 'Personel İftar Programı', 'Kül, katkısız ve tüm güzelleştirme organlarından şeye çeşit kurtarıcılar...Kül, katkısız ve tüm güzelleştirme organlarından şeye çeşit kurtarıcılar...', '2024-03-15', '2024-04-15', 78, 'pasif', '../images/pesonel-ftar-programi_3732.jpg'),
(4, '8 Mart Dünya Kadınlar Günü Programı', '4 Ekim Dünya Hayvanları Koruma Günü nedeniyle 4 Ekim boyunca...4 Ekim Dünya Hayvanları Koruma Günü nedeniyle 4 Ekim boyunca...', '2024-03-08', '2024-03-08', 234, 'pasif', '../images/8-mart-dunya-kadinlar-gunu-programi_8383.jpg'),
(5, 'Ön Ödeme Kredi ve Avans Eğitimi', 'Bağışlanmış günlük programı göbildirinde park ve yeşil alanlarımızda...', '2025-02-27', '2025-03-31', 156, 'pasif', '../images/on-odeme-kred-ve-avans-e-t-m_2065.jpeg'),
(6, 'Marmara Kariyer Yer Fuarı', 'Personel gelişimi için düzenlenen eğitim seminerimiz tamamlandı. Katılımcılarımız başarı sertifikalarını aldı...', '2024-02-26', '2024-02-28', 189, 'pasif', '../images/marmara-kar-yer-fuari-kocael-2024_9790.jpg'),
(7, 'Ofis Programları Eğitimi', 'Şehrimizin çeşitli bölgelerinde gerçekleştirilen yol bakım ve onarım çalışmaları devam ediyor...', '2025-02-19', '2025-08-31', 267, 'aktif', '../images/of-s-programlari-e-t-m_2683.jpeg'),
(8, 'İlkyardım Eğitimi', 'Doğal yaşam alanlarının korunması için başlatılan temizlik kampanyası büyük ilgi gördü...', '2024-02-12', '2025-12-31', 198, 'aktif', '../images/lkyardim-e-t-m_1307.jpeg'),
(9, 'Stajyer Film-Okuma Programı', 'Doğal yaşam alanlarının korunması için başlatılan temizlik kampanyası büyük ilgi gördü...', '2024-02-07', '2024-03-15', 198, 'pasif', '../images/lkyardim-e-t-m_1307.jpeg'),
(10, '3 Aralık Dünya Engelliler Günü  Personel Etkinliği', 'Personelimize yönelik dijital dönüşüm ve teknoloji kullanımı eğitimi başarıyla tamamlandı...', '2023-12-03', '2023-12-03', 312, 'pasif', '../images/3-aralik-dunya-engell-ler-gunu-personel-yeme_9554.jpg'),
(11, 'Stajyer Öğrenci Oryantasyonu ', 'Şehir merkezindeki altyapı geliştirme ve modernizasyon çalışmaları hızla devam ediyor...', '2025-11-29', '2025-12-15', 423, 'pasif', '../images/stajyer-o-renci-oryantasyonu_2177.jpg'),
(12, '24 Kasım Öğretmenler Günü Etkinliği', 'Sokak hayvanlarının sağlık kontrolü ve bakım programı kapsamında çalışmalar sürdürülüyor...', '2023-11-24', '2023-11-24', 186, 'pasif', '../images/24-kas-m-o-retmenler-gunu_2947.jpg'),
(13, 'Müdürlükler Arası Spor Turnuvası', 'Kent genelindeki park ve yeşil alanların bakım ve düzenleme çalışmaları tamamlandı...', '2023-08-21', '2023-09-30', 278, 'pasif', '../images/futbol-turnuvasi_9646.jpg'),
(14, 'Personel Piknik Programı', 'Kent genelindeki park ve yeşil alanların bakım ve düzenleme çalışmaları tamamlandı...', '2023-07-22', '2023-07-22', 278, 'pasif', '../images/personel-p-kn-k-programi_9118.jpg'),
(15, 'Personel Bayramlaşma Programı', 'Kent genelindeki park ve yeşil alanların bakım ve düzenleme çalışmaları tamamlandı...', '2023-06-23', '2023-06-25', 278, 'pasif', '../images/personel-bayramla-ma-programi_5965.jpg'),
(16, 'Personel İftar Programı', 'Kent genelindeki park ve yeşil alanların bakım ve düzenleme çalışmaları tamamlandı...', '2023-04-10', '2023-05-15', 278, 'pasif', '../images/personel-ftar-program_109.jpg');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `etkinlikler`
--
ALTER TABLE `etkinlikler`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `etkinlikler`
--
ALTER TABLE `etkinlikler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
