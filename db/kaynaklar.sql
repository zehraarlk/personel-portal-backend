-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 03 Tem 2026, 11:19:57
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

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `kaynaklar`
--
ALTER TABLE `kaynaklar`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `kaynaklar`
--
ALTER TABLE `kaynaklar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
