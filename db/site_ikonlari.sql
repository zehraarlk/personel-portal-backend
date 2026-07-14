-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 14 Tem 2026, 11:30:58
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
-- Tablo için tablo yapısı `site_ikonlari`
--

CREATE TABLE `site_ikonlari` (
  `id` int(11) NOT NULL,
  `anahtar` varchar(100) NOT NULL,
  `ad` varchar(150) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `ikon_sinifi` varchar(150) NOT NULL,
  `renk` varchar(30) DEFAULT NULL,
  `sira` int(11) NOT NULL DEFAULT 0,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `olusturma_tarihi` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `site_ikonlari`
--

INSERT INTO `site_ikonlari` (`id`, `anahtar`, `ad`, `kategori`, `ikon_sinifi`, `renk`, `sira`, `aktif`, `olusturma_tarihi`) VALUES
(1, 'menu_ac', 'Mobil Menüyü Aç', 'arayuz', 'fas fa-bars', NULL, 10, 1, '2026-07-14 08:46:13'),
(2, 'anasayfa', 'Anasayfa', 'navigasyon', 'fas fa-home', NULL, 20, 1, '2026-07-14 08:46:13'),
(3, 'videolar', 'Videolar', 'navigasyon', 'fas fa-video', NULL, 30, 1, '2026-07-14 08:46:14'),
(4, 'etkinlikler', 'Etkinlikler', 'navigasyon', 'fas fa-newspaper', NULL, 40, 1, '2026-07-14 08:46:14'),
(5, 'sizden_gelenler', 'Sizden Gelenler', 'navigasyon', 'fas fa-comments', NULL, 50, 1, '2026-07-14 08:46:14'),
(6, 'etkinlik_takvimi', 'Etkinlik Takvimi', 'navigasyon', 'fas fa-calendar-check', NULL, 60, 1, '2026-07-14 08:46:14'),
(7, 'duyurular', 'Duyurular', 'navigasyon', 'fas fa-bullhorn', NULL, 70, 1, '2026-07-14 08:46:14'),
(8, 'kaynaklar', 'Kaynaklar', 'navigasyon', 'fas fa-landmark', NULL, 80, 1, '2026-07-14 08:46:14'),
(9, 'protokoller', 'Protokoller', 'navigasyon', 'fas fa-file-signature', NULL, 90, 1, '2026-07-14 08:46:14'),
(10, 'dokumanlar', 'Dokümanlar', 'navigasyon', 'fas fa-file-alt', NULL, 100, 1, '2026-07-14 08:46:14'),
(11, 'mevzuatlar', 'Mevzuatlar', 'navigasyon', 'fas fa-balance-scale', NULL, 110, 1, '2026-07-14 08:46:14'),
(12, 'egitimler', 'Eğitimler', 'navigasyon', 'fas fa-graduation-cap', NULL, 120, 1, '2026-07-14 08:46:14'),
(13, 'diger', 'Diğer', 'navigasyon', 'fas fa-file-alt', NULL, 130, 1, '2026-07-14 08:46:14'),
(14, 'anketler', 'Anketler', 'navigasyon', 'fas fa-poll', NULL, 140, 1, '2026-07-14 08:46:14'),
(15, 'yardimci_linkler', 'Yardımcı Linkler', 'navigasyon', 'fas fa-link', NULL, 150, 1, '2026-07-14 08:46:14'),
(16, 'vefat_bilgisi', 'Vefat Eden Bilgisi', 'navigasyon', 'fas fa-ribbon', '#222222', 160, 1, '2026-07-14 08:46:14'),
(17, 'dogum_gunu', 'Doğum Günü Bilgisi', 'navigasyon', 'fas fa-birthday-cake', NULL, 170, 1, '2026-07-14 08:46:14'),
(18, 'yonetim_paneli', 'Yönetim Paneli', 'profil', 'fas fa-cog', NULL, 180, 1, '2026-07-14 08:46:14'),
(19, 'oturum_bilgileri', 'Oturum Bilgileri', 'profil', 'fas fa-history', NULL, 190, 1, '2026-07-14 08:46:14'),
(20, 'email_degistir', 'E-posta Değiştir', 'profil', 'fas fa-envelope', NULL, 200, 1, '2026-07-14 08:46:14'),
(21, 'sifre_degistir', 'Şifre Değiştir', 'profil', 'fas fa-key', NULL, 210, 1, '2026-07-14 08:46:14'),
(22, 'cikis_yap', 'Çıkış Yap', 'profil', 'fas fa-sign-out-alt', NULL, 220, 1, '2026-07-14 08:46:14'),
(23, 'telefon', 'Telefon', 'iletisim', 'fas fa-phone', NULL, 230, 1, '2026-07-14 08:46:14'),
(24, 'eposta', 'E-posta', 'iletisim', 'fas fa-envelope', NULL, 240, 1, '2026-07-14 08:46:14'),
(25, 'facebook', 'Facebook', 'sosyal', 'fab fa-facebook-f', NULL, 250, 1, '2026-07-14 08:46:14'),
(26, 'twitter', 'Twitter / X', 'sosyal', 'fab fa-twitter', NULL, 260, 1, '2026-07-14 08:46:14'),
(27, 'instagram', 'Instagram', 'sosyal', 'fab fa-instagram', NULL, 270, 1, '2026-07-14 08:46:14'),
(28, 'youtube', 'YouTube', 'sosyal', 'fab fa-youtube', NULL, 280, 1, '2026-07-14 08:46:14'),
(29, 'linkedin', 'LinkedIn', 'sosyal', 'fab fa-linkedin-in', NULL, 290, 1, '2026-07-14 08:46:14'),
(30, 'arama', 'Arama', 'arayuz', 'fas fa-search', NULL, 300, 1, '2026-07-14 08:56:15'),
(31, 'tarih', 'Tarih', 'bilgi', 'fas fa-calendar-alt', NULL, 310, 1, '2026-07-14 08:56:15'),
(32, 'goruntulenme', 'Görüntülenme', 'bilgi', 'fas fa-eye', NULL, 320, 1, '2026-07-14 08:56:15'),
(33, 'kullanici', 'Kullanıcı / Yazar', 'bilgi', 'fas fa-user', NULL, 330, 1, '2026-07-14 08:56:15'),
(34, 'geri_don', 'Geri Dön', 'arayuz', 'fas fa-arrow-left', NULL, 340, 1, '2026-07-14 08:56:15'),
(35, 'onceki', 'Önceki', 'arayuz', 'fas fa-chevron-left', NULL, 350, 1, '2026-07-14 08:56:15'),
(36, 'sonraki', 'Sonraki', 'arayuz', 'fas fa-chevron-right', NULL, 360, 1, '2026-07-14 08:56:15'),
(37, 'pdf_dosyasi', 'PDF Dosyası', 'dosya', 'fas fa-file-pdf', NULL, 370, 1, '2026-07-14 08:56:15'),
(38, 'kaydet', 'Kaydet', 'form', 'fas fa-save', NULL, 380, 1, '2026-07-14 08:56:16'),
(39, 'video_oynat', 'Videoyu Oynat', 'video', 'fas fa-play', NULL, 390, 1, '2026-07-14 08:56:16'),
(40, 'harici_baglanti', 'Harici Bağlantı', 'baglanti', 'fas fa-external-link-alt', NULL, 400, 1, '2026-07-14 08:56:16'),
(41, 'etkinlik_sayfa', 'Etkinlik Sayfası', 'sayfa', 'fa-solid fa-calendar-days', NULL, 410, 1, '2026-07-14 08:56:16'),
(42, 'oturum_saati', 'Oturum Saati', 'oturum', 'far fa-clock', NULL, 420, 1, '2026-07-14 08:56:16'),
(43, 'yonetim_guvenlik_bi', 'Yönetim Güvenliği', 'giris', 'bi bi-shield-lock-fill', NULL, 430, 1, '2026-07-14 08:56:16'),
(44, 'sifre_goster_bi', 'Şifreyi Göster', 'giris', 'bi bi-eye', NULL, 440, 1, '2026-07-14 08:56:16'),
(45, 'sifre_gizle_bi', 'Şifreyi Gizle', 'giris', 'bi bi-eye-slash', NULL, 450, 1, '2026-07-14 08:56:16'),
(46, 'giris_yap_bi', 'Giriş Yap', 'giris', 'bi bi-box-arrow-in-right', NULL, 460, 1, '2026-07-14 08:56:16'),
(47, 'geri_don_bi', 'Geri Dön', 'giris', 'bi bi-arrow-left', NULL, 470, 1, '2026-07-14 08:56:16'),
(48, 'islem_yukleniyor_bi', 'İşlem Yapılıyor', 'arayuz', 'bi bi-arrow-clockwise', NULL, 480, 1, '2026-07-14 08:56:16'),
(49, 'personel_kayit_bi', 'Personel Kaydı', 'giris', 'bi bi-person-plus-fill', NULL, 490, 1, '2026-07-14 08:56:16'),
(50, 'islem_basarili_bi', 'İşlem Başarılı', 'durum', 'bi bi-check-circle', NULL, 500, 1, '2026-07-14 08:56:16'),
(51, 'anasayfa_haberler', 'Ana Sayfa Haberler Başlığı', 'anasayfa', 'fas fa-bullhorn', NULL, 510, 1, '2026-07-14 09:11:28'),
(52, 'duyuru_zili', 'Duyuru Zili', 'duyuru', 'fas fa-bell', NULL, 520, 1, '2026-07-14 09:11:28'),
(53, 'dogum_sayfa', 'Doğum Günü Sayfa İkonu', 'dogum', 'fa-solid fa-cake-candles', NULL, 530, 1, '2026-07-14 09:11:28'),
(54, 'otomasyon_sistem', 'Otomasyon Sistemi', 'anasayfa', 'fas fa-desktop', NULL, 540, 1, '2026-07-14 09:11:28'),
(55, 'anket_kilit_acik', 'Anket Cevapları Açık', 'anket', 'fas fa-lock-open', NULL, 550, 1, '2026-07-14 09:11:28'),
(56, 'anket_gonder', 'Anketi Gönder', 'anket', 'fas fa-paper-plane', NULL, 560, 1, '2026-07-14 09:11:28'),
(57, 'anket_durum_aktif', 'Aktif Anket', 'anket', 'fas fa-play-circle', NULL, 570, 1, '2026-07-14 09:11:28'),
(58, 'anket_durum_beklemede', 'Bekleyen Anket', 'anket', 'fas fa-clock', NULL, 580, 1, '2026-07-14 09:11:28'),
(59, 'anket_durum_tamamlandi', 'Tamamlanan Anket', 'anket', 'fas fa-check-circle', NULL, 590, 1, '2026-07-14 09:11:28'),
(60, 'anket_durum_suresi_doldu', 'Süresi Dolan Anket', 'anket', 'fas fa-times-circle', NULL, 600, 1, '2026-07-14 09:11:29'),
(61, 'anket_tarih', 'Anket Tarihi', 'anket', 'fas fa-calendar', NULL, 610, 1, '2026-07-14 09:11:29'),
(62, 'anket_giris', 'Ankete Giriş', 'anket', 'fas fa-sign-in-alt', NULL, 620, 1, '2026-07-14 09:11:29'),
(63, 'anket_duzenle', 'Ankete Katıl / Düzenle', 'anket', 'fas fa-edit', NULL, 630, 1, '2026-07-14 09:11:29'),
(64, 'anket_favori_dolu', 'Favorideki Anket', 'anket', 'fas fa-star', NULL, 640, 1, '2026-07-14 09:11:29'),
(65, 'anket_favori_bos', 'Favoride Olmayan Anket', 'anket', 'far fa-star', NULL, 650, 1, '2026-07-14 09:11:29'),
(66, 'anket_liste', 'Anket Listesi', 'anket', 'fas fa-list', NULL, 660, 1, '2026-07-14 09:11:29'),
(67, 'indir', 'Dosya İndir', 'dosya', 'fas fa-download', NULL, 670, 1, '2026-07-14 09:11:29'),
(68, 'dosya_word', 'Word Dosyası', 'dosya', 'fas fa-file-word', NULL, 680, 1, '2026-07-14 09:11:29'),
(69, 'dosya_excel', 'Excel Dosyası', 'dosya', 'fas fa-file-excel', NULL, 690, 1, '2026-07-14 09:11:29'),
(70, 'dosya_belge', 'Belge Dosyası', 'dosya', 'fas fa-file-alt', NULL, 700, 1, '2026-07-14 09:11:29'),
(71, 'dosya_genel', 'Genel Dosya', 'dosya', 'fas fa-file', NULL, 710, 1, '2026-07-14 09:11:29'),
(72, 'egitim_video', 'Eğitim Videosu', 'egitim', 'fas fa-video', NULL, 720, 1, '2026-07-14 09:11:29');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `site_ikonlari`
--
ALTER TABLE `site_ikonlari`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `anahtar` (`anahtar`) USING BTREE;

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `site_ikonlari`
--
ALTER TABLE `site_ikonlari`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
