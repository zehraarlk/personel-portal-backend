-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 02 Tem 2026, 14:25:58
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
(1, 'İnsan Kaynakları ve Eğitim Müdürlüğü', '6734 ve 6735 Sayılı Kanun Eğitimi - Biyomedikal Eğitimi - Üniversite Eğitimi - Oryantasyon Eğitimi - Fen Programlama Eğitimi - Mevzuat Eğitimi - Teknoloji Çalışma Eğitimi...', 'insan-kaynaklari', 'İnsan Kaynakları ve Eğitim Müdürlüğü', '2023-11-06', 91, '../images/sizden_gelenler/insan_kaynaklari/nsan-kaynaklar-ve-e-itim-mudurlu-u_1547.jpg', '2026-07-02 12:20:03'),
(2, 'Fen İşleri Müdürlüğü', 'Köprülü Geçmis Mahallesi, 503 Sokak\'taki çalışmalar...Köprülü Geçmis Mahallesi, 503 Sokak\'taki çalışmalar...', 'fen-isleri', 'Fen İşleri Müdürlüğü', '2023-10-19', 145, '../images/sizden_gelenler/fen_isleri/fen-leri-mudurlu-u_3604.jpg', '2026-07-02 12:20:03'),
(3, 'Temizlik İşleri Müdürlüğü', 'Kül, katkısız ve tüm güzelleştirme organlarından şeye çeşit kurtarıcılar...Kül, katkısız ve tüm güzelleştirme organlarından şeye çeşit kurtarıcılar...', 'temizlik', 'Temizlik İşleri Müdürlüğü', '2023-10-19', 78, '../images/sizden_gelenler/temizlik_isleri/temizlik-leri-mudurlu-u_2142.jpg', '2026-07-02 12:20:03'),
(4, 'Veteriner İşleri Müdürlüğü', '4 Ekim Dünya Hayvanları Koruma Günü nedeniyle 4 Ekim boyunca...4 Ekim Dünya Hayvanları Koruma Günü nedeniyle 4 Ekim boyunca...', 'veteriner', 'Veteriner İşleri Müdürlüğü', '2023-10-17', 234, '../images/sizden_gelenler/veteriner_isleri/veteriner-leri-mudurlu-u_547.jpg', '2026-07-02 12:20:03'),
(5, 'Park ve Bahçeler Müdürlüğü', 'Bağışlanmış günlük programı göbildirinde park ve yeşil alanlarımızda...', 'park-bahce', 'Park ve Bahçeler Müdürlüğü', '2023-10-17', 156, '../images/sizden_gelenler/park_bahce/park-ve-bahceler-mudurlu-u_357.jpg', '2026-07-02 12:20:03'),
(6, 'İnsan Kaynakları Eğitim Semineri', 'Personel gelişimi için düzenlenen eğitim seminerimiz tamamlandı. Katılımcılarımız başarı sertifikalarını aldı...', 'insan-kaynaklari', 'İnsan Kaynakları ve Eğitim Müdürlüğü', '2023-10-15', 189, '../images/sizden_gelenler/insan_kaynaklari/nsan-kaynaklar-ve-e-itim-mudurlu-u_4846.jpg', '2026-07-02 12:20:03'),
(7, 'Yol Bakım ve Onarım Çalışmaları', 'Şehrimizin çeşitli bölgelerinde gerçekleştirilen yol bakım ve onarım çalışmaları devam ediyor...', 'fen-isleri', 'Fen İşleri Müdürlüğü', '2023-10-12', 267, '../images/sizden_gelenler/fen_isleri/fen-leri-mudurlu-u_8989.jpg', '2026-07-02 12:20:03'),
(8, 'Çevre Temizlik Kampanyası', 'Doğal yaşam alanlarının korunması için başlatılan temizlik kampanyası büyük ilgi gördü...', 'temizlik', 'Temizlik İşleri Müdürlüğü', '2023-10-10', 198, '../images/sizden_gelenler/temizlik_isleri/temizlik-leri-mudurlu-u_6633.jpg', '2026-07-02 12:20:03'),
(9, 'Dijital Dönüşüm Eğitimi', 'Personelimize yönelik dijital dönüşüm ve teknoloji kullanımı eğitimi başarıyla tamamlandı...', 'zabita', 'Zabıta Müdürlüğü', '2023-10-08', 312, '../images/sizden_gelenler/zabıta/zab-ta-mudurlu-u_6319.jpg', '2026-07-02 12:20:03'),
(10, 'Altyapı Geliştirme Projesi', 'Şehir merkezindeki altyapı geliştirme ve modernizasyon çalışmaları hızla devam ediyor...', 'fen-isleri', 'Fen İşleri Müdürlüğü', '2023-10-05', 423, '../images/sizden_gelenler/fen_isleri/fen-leri-mudurlu-u_8989.jpg', '2026-07-02 12:20:03'),
(11, 'Sokak Hayvanları Bakım Programı', 'Sokak hayvanlarının sağlık kontrolü ve bakım programı kapsamında çalışmalar sürdürülüyor...', 'veteriner', 'Veteriner İşleri Müdürlüğü', '2023-10-03', 186, '../images/sizden_gelenler/veteriner_isleri/veteriner-leri-mudurlu-u_547.jpg', '2026-07-02 12:20:03'),
(12, 'Yeşil Alan Düzenleme Çalışması', 'Kent genelindeki park ve yeşil alanların bakım ve düzenleme çalışmaları tamamlandı...', 'park-bahce', 'Park ve Bahçeler Müdürlüğü', '2023-10-01', 278, '../images/sizden_gelenler/park_bahce/park-ve-bahceler-mudurlu-u_4188.jpg', '2026-07-02 12:20:03');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `sizden_gelenler`
--
ALTER TABLE `sizden_gelenler`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `sizden_gelenler`
--
ALTER TABLE `sizden_gelenler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
