-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: personel_db
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `anasayfa_duyurular`
--

DROP TABLE IF EXISTS `anasayfa_duyurular`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `anasayfa_duyurular` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `baslik` varchar(255) NOT NULL,
  `aciklama` text NOT NULL,
  `resim` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `anasayfa_duyurular`
--

LOCK TABLES `anasayfa_duyurular` WRITE;
/*!40000 ALTER TABLE `anasayfa_duyurular` DISABLE KEYS */;
INSERT INTO `anasayfa_duyurular` VALUES (1,'Stajyer Oryantasyon E─şitimi Tamamland─▒','Belediyemizde yeni d├Âneme ba┼şlayan stajyer ├Â─şrencilerimiz i├ğin oryantasyon program─▒ d├╝zenlendi.','../images/stajyer-oryantasyon-e-t-m_8697.jpg'),(2,'Geleneksel Bayramla┼şma T├Âreni Ger├ğekle┼şti','Kurban Bayram─▒ vesilesiyle t├╝m personelimizin kat─▒l─▒m─▒yla co┼şkulu bir bayramla┼şma program─▒ yap─▒ld─▒.','../images/24-kas-m-o-retmenler-gunu_2947.jpg'),(3,'8 Mart D├╝nya Kad─▒nlar G├╝n├╝ Kutland─▒','Belediyemizdeki kad─▒n personelimizin D├╝nya Kad─▒nlar G├╝n├╝\'n├╝ ├Âzel bir etkinlikle kutlad─▒k.','../images/8-mart-dunya-kadinlar-gunu-programi_8383.jpg'),(4,'Personel ─░ftar Program─▒ B├╝y├╝k ─░lgi G├Ârd├╝','Ramazan ay─▒n─▒n manevi atmosferinde personelimizle birlikte iftar sofras─▒nda bulu┼ştuk.','../images/personel-ftar-program_109.jpg'),(5,'├û─şretmenler G├╝n├╝ Unutulmad─▒','Gebze\'deki ├Â─şretmenlerimizi bu ├Âzel g├╝nlerinde yaln─▒z b─▒rakmad─▒k ve ├ğe┼şitli ziyaretler ger├ğekle┼ştirdik.','../images/24-kas-m-o-retmenler-gunu_2947.jpg'),(6,'Da─ş Bisikleti Kupas─▒ Gebze\'de Nefes Kesti','T├╝rkiye Ulusal Da─ş Bisikleti Kupas─▒\'n─▒n bir aya─ş─▒na ev sahipli─şi yapman─▒n gururunu ya┼şad─▒k.','../images/ulusal-da-bisikleti-kupas-yar-lar_128.jpg'),(7,'Personelimize A─ş─▒z ve Di┼ş Sa─şl─▒─ş─▒ Taramas─▒','├çal─▒┼şanlar─▒m─▒z─▒n sa─şl─▒─ş─▒n─▒ ├Ânemsiyor, d├╝zenli olarak sa─şl─▒k taramalar─▒ ger├ğekle┼ştiriyoruz.','../images/personellerimizin-a-z-ve-di-sa-l-n-onemsiyoruz_7091.jpg'),(8,'Yaz Sezonunu Piknikle A├ğt─▒k','Yo─şun ├ğal─▒┼şma temposuna mola vererek t├╝m birimlerimizin kat─▒ld─▒─ş─▒ bir piknik organizasyonu d├╝zenledik.','../images/personel-p-kn-k-programi_9118.jpg'),(9,'Stajyerlerle Film Okuma Etkinli─şi','Gen├ğlerimizin vizyonunu geli┼ştirmek amac─▒yla film okuma ve analiz programlar─▒ d├╝zenliyoruz.','../images/stajyer-f-lm-okuma-programi_3604.jpg'),(10,'─░kinci Geleneksel ─░ftar Bulu┼şmas─▒','Personelimiz ve aileleriyle birlikte Ramazan ay─▒n─▒n bereketini payla┼şt─▒─ş─▒m─▒z iftar program─▒m─▒z.','../images/personel-ftar-program_109.jpg'),(11,'Stajyer D├Ânem Sonu Veda Program─▒','Staj d├Ânemini ba┼şar─▒yla tamamlayan ├Â─şrencilerimiz i├ğin bir veda ve te┼şekk├╝r etkinli─şi d├╝zenlendi.','../images/stajyer-donem-sonu-etk-nl_6028.jpg'),(12,'Yeni Stajyerlerimize \"Ho┼ş Geldin\" Dedik','Belediye ├ğal─▒┼şmalar─▒n─▒ yak─▒ndan tan─▒malar─▒ i├ğin yeni stajyerlerimize y├Ânelik bir oryantasyon yap─▒ld─▒.','../images/stajyer-oryantasyon-e-t-m_8697.jpg'),(13,'Kad─▒n Personelimize ├ûzel ─░kramlar','8 Mart kapsam─▒nda belediyemizdeki t├╝m kad─▒n ├ğal─▒┼şanlar─▒m─▒za k├╝├ğ├╝k bir jest haz─▒rlad─▒k.','../images/8-mart-dunya-kadinlar-gunu-programi_8383.jpg'),(14,'Ramazan Bayram─▒ Bulu┼şmas─▒','Ramazan Bayram─▒ dolay─▒s─▒yla personelimizle bir araya gelerek bayramla┼şt─▒k.','../images/personel-bayramla-ma-programi_5965.jpg'),(15,'Birlik ve Beraberlik ─░ftar─▒','─░ftar program─▒m─▒z, personelimiz aras─▒ndaki birlik ve beraberli─şi peki┼ştirdi.','../images/personel-ftar-program_109.jpg');
/*!40000 ALTER TABLE `anasayfa_duyurular` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `anasayfa_linkler`
--

DROP TABLE IF EXISTS `anasayfa_linkler`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `anasayfa_linkler` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `baslik` varchar(255) NOT NULL,
  `logo_url` varchar(255) DEFAULT NULL,
  `hedef_url` varchar(500) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_anasayfa_linkler_baslik_url` (`baslik`,`hedef_url`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `anasayfa_linkler`
--

LOCK TABLES `anasayfa_linkler` WRITE;
/*!40000 ALTER TABLE `anasayfa_linkler` DISABLE KEYS */;
INSERT INTO `anasayfa_linkler` VALUES (1,'OMIS','../images/otomasyon/omis_7572.png','https://ebelediye.gebze.bel.tr/eBelediye/'),(2,'Ulakbel','../images/otomasyon/ulakbel_5496.png','https://ulakbel.gebze.bel.tr/ulakbel#/'),(3,'─░mar Y├Ânetim Sistemi','../images/otomasyon/imar-yonetim-sistemi_8038.png','https://www.gebze.bel.tr/ebelediye/'),(4,'Dijital Ar┼şiv','../images/otomasyon/dijital-arsiv_415.png','https://www.gebze.bel.tr/'),(5,'Outlook','../images/otomasyon/outlook_4005.png','https://outlook.live.com/'),(6,'Sosyal Yard─▒m','../images/otomasyon/sosyal-yardim_3767.png','https://www.turkiye.gov.tr/ashb-sosyal-yardim-bilgileri-sorgulama'),(7,'Netcad','../images/otomasyon/netcad_3888.png','https://www.netcad.com/'),(8,'E-Belediye Sistemi','../images/otomasyon/ebys_8493.png','https://www.belediye.gov.tr/'),(9,'E-Belediye Evlendrme Mod├╝l├╝','../images/otomasyon/e-belediye-evlendirme-modulu_3993.png','https://www.belediye.gov.tr/evlendirme-modulu'),(10,'E-Belediye Sosyal Yard─▒m Mod├╝l├╝','../images/otomasyon/e-belediye-sosyal-yard-m-modulu_4432.png','https://www.belediye.gov.tr/sosyal-yardim-takip-sistemi-syts-modulu');
/*!40000 ALTER TABLE `anasayfa_linkler` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `anketler`
--

DROP TABLE IF EXISTS `anketler`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `anketler` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `baslik` varchar(255) NOT NULL,
  `aciklama` text DEFAULT NULL,
  `kategori` varchar(50) NOT NULL,
  `resim_url` varchar(500) DEFAULT NULL,
  `baslangic_tarihi` date DEFAULT NULL,
  `bitis_tarihi` date DEFAULT NULL,
  `katilim_sayisi` int(11) DEFAULT 0,
  `hedef_katilim` int(11) DEFAULT 0,
  `favori` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `anketler`
--

LOCK TABLES `anketler` WRITE;
/*!40000 ALTER TABLE `anketler` DISABLE KEYS */;
INSERT INTO `anketler` VALUES (1,'Personel Memnuniyet Anketi 2024','G├Ârev yapan personele y├Ânelik genel de─şerlendirme formu. ─░┼ş memnuniyeti ve ├ğal─▒┼şma ko┼şullar─▒ de─şerlendirmesi.','active','https://img.freepik.com/free-photo/business-graphs-charts-tablet_23-2147819730.jpg','2024-10-09','2024-11-15',45,120,1),(2,'E─şitim ─░htiya├ğ Analizi','Personel geli┼şimi i├ğin gerekli e─şitim alanlar─▒n─▒n belirlenmesi amac─▒yla haz─▒rlanan de─şerlendirme anketi.','completed','https://img.freepik.com/free-photo/education-concept-with-graduation-cap-books_23-2147819868.jpg','2024-09-01','2024-09-30',98,120,0),(3,'─░┼ş Ortam─▒ De─şerlendirme','├çal─▒┼şma ortam─▒, ekipman yeterlili─şi ve fiziksel ko┼şullar─▒n de─şerlendirilmesi anketi.','expired','https://img.freepik.com/free-photo/workplace-productivity-concept_23-2147819745.jpg','2024-08-15','2024-09-15',67,120,1);
/*!40000 ALTER TABLE `anketler` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `duyurular`
--

DROP TABLE IF EXISTS `duyurular`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `duyurular` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `baslik` varchar(255) NOT NULL,
  `aciklama` text NOT NULL,
  `resim` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `duyurular`
--

LOCK TABLES `duyurular` WRITE;
/*!40000 ALTER TABLE `duyurular` DISABLE KEYS */;
INSERT INTO `duyurular` VALUES (1,'Stajyer Oryantasyon E─şitimi Tamamland─▒','Belediyemizde yeni d├Âneme ba┼şlayan stajyer ├Â─şrencilerimiz i├ğin oryantasyon program─▒ d├╝zenlendi.','../images/stajyer-oryantasyon-e-t-m_8697.jpg'),(2,'Geleneksel Bayramla┼şma T├Âreni Ger├ğekle┼şti','Kurban Bayram─▒ vesilesiyle t├╝m personelimizin kat─▒l─▒m─▒yla co┼şkulu bir bayramla┼şma program─▒ yap─▒ld─▒.','../images/24-kas-m-o-retmenler-gunu_2947.jpg'),(3,'8 Mart D├╝nya Kad─▒nlar G├╝n├╝ Kutland─▒','Belediyemizdeki kad─▒n personelimizin D├╝nya Kad─▒nlar G├╝n├╝\'n├╝ ├Âzel bir etkinlikle kutlad─▒k.','../images/8-mart-dunya-kadinlar-gunu-programi_8383.jpg'),(4,'Personel ─░ftar Program─▒ B├╝y├╝k ─░lgi G├Ârd├╝','Ramazan ay─▒n─▒n manevi atmosferinde personelimizle birlikte iftar sofras─▒nda bulu┼ştuk.','../images/personel-ftar-program_109.jpg'),(5,'├û─şretmenler G├╝n├╝ Unutulmad─▒','Gebze\'deki ├Â─şretmenlerimizi bu ├Âzel g├╝nlerinde yaln─▒z b─▒rakmad─▒k ve ├ğe┼şitli ziyaretler ger├ğekle┼ştirdik.','../images/24-kas-m-o-retmenler-gunu_2947.jpg'),(6,'Da─ş Bisikleti Kupas─▒ Gebze\'de Nefes Kesti','T├╝rkiye Ulusal Da─ş Bisikleti Kupas─▒\'n─▒n bir aya─ş─▒na ev sahipli─şi yapman─▒n gururunu ya┼şad─▒k.','../images/ulusal-da-bisikleti-kupas-yar-lar_128.jpg'),(7,'Personelimize A─ş─▒z ve Di┼ş Sa─şl─▒─ş─▒ Taramas─▒','├çal─▒┼şanlar─▒m─▒z─▒n sa─şl─▒─ş─▒n─▒ ├Ânemsiyor, d├╝zenli olarak sa─şl─▒k taramalar─▒ ger├ğekle┼ştiriyoruz.','../images/personellerimizin-a-z-ve-di-sa-l-n-onemsiyoruz_7091.jpg'),(8,'Yaz Sezonunu Piknikle A├ğt─▒k','Yo─şun ├ğal─▒┼şma temposuna mola vererek t├╝m birimlerimizin kat─▒ld─▒─ş─▒ bir piknik organizasyonu d├╝zenledik.','../images/personel-p-kn-k-programi_9118.jpg'),(9,'Stajyerlerle Film Okuma Etkinli─şi','Gen├ğlerimizin vizyonunu geli┼ştirmek amac─▒yla film okuma ve analiz programlar─▒ d├╝zenliyoruz.','../images/stajyer-f-lm-okuma-programi_3604.jpg'),(10,'─░kinci Geleneksel ─░ftar Bulu┼şmas─▒','Personelimiz ve aileleriyle birlikte Ramazan ay─▒n─▒n bereketini payla┼şt─▒─ş─▒m─▒z iftar program─▒m─▒z.','../images/personel-ftar-program_109.jpg'),(11,'Stajyer D├Ânem Sonu Veda Program─▒','Staj d├Ânemini ba┼şar─▒yla tamamlayan ├Â─şrencilerimiz i├ğin bir veda ve te┼şekk├╝r etkinli─şi d├╝zenlendi.','../images/stajyer-donem-sonu-etk-nl_6028.jpg'),(12,'Yeni Stajyerlerimize \"Ho┼ş Geldin\" Dedik','Belediye ├ğal─▒┼şmalar─▒n─▒ yak─▒ndan tan─▒malar─▒ i├ğin yeni stajyerlerimize y├Ânelik bir oryantasyon yap─▒ld─▒.','../images/stajyer-oryantasyon-e-t-m_8697.jpg'),(13,'Kad─▒n Personelimize ├ûzel ─░kramlar','8 Mart kapsam─▒nda belediyemizdeki t├╝m kad─▒n ├ğal─▒┼şanlar─▒m─▒za k├╝├ğ├╝k bir jest haz─▒rlad─▒k.','../images/8-mart-dunya-kadinlar-gunu-programi_8383.jpg'),(14,'Ramazan Bayram─▒ Bulu┼şmas─▒','Ramazan Bayram─▒ dolay─▒s─▒yla personelimizle bir araya gelerek bayramla┼şt─▒k.','../images/personel-bayramla-ma-programi_5965.jpg'),(15,'Birlik ve Beraberlik ─░ftar─▒','─░ftar program─▒m─▒z, personelimiz aras─▒ndaki birlik ve beraberli─şi peki┼ştirdi.','../images/personel-ftar-program_109.jpg');
/*!40000 ALTER TABLE `duyurular` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `etkinlikler`
--

DROP TABLE IF EXISTS `etkinlikler`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `etkinlikler` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `baslik` varchar(255) NOT NULL,
  `aciklama` text DEFAULT NULL,
  `tarih` date NOT NULL,
  `bitis_tarihi` date DEFAULT NULL,
  `view` int(11) DEFAULT 0,
  `durum` varchar(20) DEFAULT 'aktif',
  `resim` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `etkinlikler`
--

LOCK TABLES `etkinlikler` WRITE;
/*!40000 ALTER TABLE `etkinlikler` DISABLE KEYS */;
INSERT INTO `etkinlikler` VALUES (1,'Stajyer Oryantasyon E─şitimi','6734 ve 6735 Say─▒l─▒ Kanun E─şitimi - Biyomedikal E─şitimi - ├£niversite E─şitimi - Oryantasyon E─şitimi - Fen Programlama E─şitimi - Mevzuat E─şitimi - Teknoloji ├çal─▒┼şma E─şitimi...','2025-08-06','2025-12-31',92,'aktif','../images/stajyer-oryantasyon-e-t-m_8697.jpg'),(2,'Stajyer D├Ânem Sonu Etkinli─şi','K├Âpr├╝l├╝ Ge├ğmis Mahallesi, 503 Sokak\'taki ├ğal─▒┼şmalar...K├Âpr├╝l├╝ Ge├ğmis Mahallesi, 503 Sokak\'taki ├ğal─▒┼şmalar...','2025-05-22','2025-06-30',147,'aktif','../images/stajyer-donem-sonu-etk-nl_6028.jpg'),(3,'Personel ─░ftar Program─▒','K├╝l, katk─▒s─▒z ve t├╝m g├╝zelle┼ştirme organlar─▒ndan ┼şeye ├ğe┼şit kurtar─▒c─▒lar...K├╝l, katk─▒s─▒z ve t├╝m g├╝zelle┼ştirme organlar─▒ndan ┼şeye ├ğe┼şit kurtar─▒c─▒lar...','2024-03-15','2024-04-15',79,'pasif','../images/pesonel-ftar-programi_3732.jpg'),(4,'8 Mart D├╝nya Kad─▒nlar G├╝n├╝ Program─▒','4 Ekim D├╝nya Hayvanlar─▒ Koruma G├╝n├╝ nedeniyle 4 Ekim boyunca...4 Ekim D├╝nya Hayvanlar─▒ Koruma G├╝n├╝ nedeniyle 4 Ekim boyunca...','2024-03-08','2024-03-08',235,'pasif','../images/8-mart-dunya-kadinlar-gunu-programi_8383.jpg'),(5,'├ûn ├ûdeme Kredi ve Avans E─şitimi','Ba─ş─▒┼şlanm─▒┼ş g├╝nl├╝k program─▒ g├Âbildirinde park ve ye┼şil alanlar─▒m─▒zda...','2025-02-27','2025-03-31',157,'pasif','../images/on-odeme-kred-ve-avans-e-t-m_2065.jpeg'),(6,'Marmara Kariyer Yer Fuar─▒','Personel geli┼şimi i├ğin d├╝zenlenen e─şitim seminerimiz tamamland─▒. Kat─▒l─▒mc─▒lar─▒m─▒z ba┼şar─▒ sertifikalar─▒n─▒ ald─▒...','2024-02-26','2024-02-28',190,'pasif','../images/marmara-kar-yer-fuari-kocael-2024_9790.jpg'),(7,'Ofis Programlar─▒ E─şitimi','┼Şehrimizin ├ğe┼şitli b├Âlgelerinde ger├ğekle┼ştirilen yol bak─▒m ve onar─▒m ├ğal─▒┼şmalar─▒ devam ediyor...','2025-02-19','2025-08-31',270,'aktif','../images/of-s-programlari-e-t-m_2683.jpeg'),(8,'─░lkyard─▒m E─şitimi','Do─şal ya┼şam alanlar─▒n─▒n korunmas─▒ i├ğin ba┼şlat─▒lan temizlik kampanyas─▒ b├╝y├╝k ilgi g├Ârd├╝...','2024-02-12','2025-12-31',199,'aktif','../images/lkyardim-e-t-m_1307.jpeg'),(9,'Stajyer Film-Okuma Program─▒','Do─şal ya┼şam alanlar─▒n─▒n korunmas─▒ i├ğin ba┼şlat─▒lan temizlik kampanyas─▒ b├╝y├╝k ilgi g├Ârd├╝...','2024-02-07','2024-03-15',200,'pasif','../images/lkyardim-e-t-m_1307.jpeg'),(10,'3 Aral─▒k D├╝nya Engelliler G├╝n├╝ Personel Etkinli─şi','Personelimize y├Ânelik dijital d├Ân├╝┼ş├╝m ve teknoloji kullan─▒m─▒ e─şitimi ba┼şar─▒yla tamamland─▒...','2023-12-03','2023-12-03',312,'pasif','../images/3-aralik-dunya-engell-ler-gunu-personel-yeme_9554.jpg'),(11,'Stajyer ├û─şrenci Oryantasyonu ','┼Şehir merkezindeki altyap─▒ geli┼ştirme ve modernizasyon ├ğal─▒┼şmalar─▒ h─▒zla devam ediyor...','2025-11-29','2025-12-15',430,'pasif','../images/stajyer-o-renci-oryantasyonu_2177.jpg'),(12,'24 Kas─▒m ├û─şretmenler G├╝n├╝ Etkinli─şi','Sokak hayvanlar─▒n─▒n sa─şl─▒k kontrol├╝ ve bak─▒m program─▒ kapsam─▒nda ├ğal─▒┼şmalar s├╝rd├╝r├╝l├╝yor...','2023-11-24','2023-11-24',186,'pasif','../images/24-kas-m-o-retmenler-gunu_2947.jpg'),(13,'M├╝d├╝rl├╝kler Aras─▒ Spor Turnuvas─▒','Kent genelindeki park ve ye┼şil alanlar─▒n bak─▒m ve d├╝zenleme ├ğal─▒┼şmalar─▒ tamamland─▒...','2023-08-21','2023-09-30',279,'pasif','../images/futbol-turnuvasi_9646.jpg'),(14,'Personel Piknik Program─▒','Kent genelindeki park ve ye┼şil alanlar─▒n bak─▒m ve d├╝zenleme ├ğal─▒┼şmalar─▒ tamamland─▒...','2023-07-22','2023-07-22',278,'pasif','../images/personel-p-kn-k-programi_9118.jpg'),(15,'Personel Bayramla┼şma Program─▒','Kent genelindeki park ve ye┼şil alanlar─▒n bak─▒m ve d├╝zenleme ├ğal─▒┼şmalar─▒ tamamland─▒...','2023-06-23','2023-06-25',279,'pasif','../images/personel-bayramla-ma-programi_5965.jpg'),(16,'Personel ─░ftar Program─▒','Kent genelindeki park ve ye┼şil alanlar─▒n bak─▒m ve d├╝zenleme ├ğal─▒┼şmalar─▒ tamamland─▒...','2023-04-10','2023-05-15',279,'pasif','../images/personel-ftar-program_109.jpg');
/*!40000 ALTER TABLE `etkinlikler` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `etkinlikler_duyurular`
--

DROP TABLE IF EXISTS `etkinlikler_duyurular`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `etkinlikler_duyurular` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sayfa_tipi` varchar(50) NOT NULL,
  `baslik` varchar(255) NOT NULL,
  `aciklama` text DEFAULT NULL,
  `kategori_adi` varchar(150) DEFAULT NULL,
  `alt_tip` varchar(50) DEFAULT NULL,
  `resim_url` varchar(255) DEFAULT NULL,
  `dosya_url` varchar(500) DEFAULT NULL,
  `video_url` varchar(500) DEFAULT NULL,
  `tarih` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `etkinlikler_duyurular`
--

LOCK TABLES `etkinlikler_duyurular` WRITE;
/*!40000 ALTER TABLE `etkinlikler_duyurular` DISABLE KEYS */;
INSERT INTO `etkinlikler_duyurular` VALUES (1,'duyuru','D─░L E─Ş─░T─░M MODELLER─░NDE GE├çERL─░ %50 ─░ND─░R─░M!','KURUMUMUZ PERSONEL─░ VE 1. DERECE YAKINLARINA ├ûZEL AMERICAN VIP D─░L OKULLARINDA GE├çERL─░ %50 ─░N─░D─░R─░M ANLA┼ŞMASI ─░MZALANDI.','─░nsan Kaynaklar─▒','insan','../images/d-l-e-t-m-modeller-nde-gecerl-50-nd-r-m_4469.jpg',NULL,NULL,'2023-10-04'),(2,'duyuru','Gebze\'de Zab─▒ta Haftas─▒ Kutland─▒','Gebze Belediye Ba┼şkan─▒ Zinnur B├╝y├╝kg├Âz, her y─▒l 1-7 Eyl├╝l tarihleri aras─▒nda kutlanan Zab─▒ta Haftas─▒ m├╝nasebetiyle zab─▒ta personelleriyle bir araya geldi.','─░nsan Kaynaklar─▒','insan','../images/gebze-de-zab-ta-haftas-kutland_5157 (1).jpg',NULL,NULL,'2023-10-04'),(3,'duyuru','GEBZE\'DE EK ZAM PROTOKOL├£ ─░MZALANDI','Gebze Belediyesi, b├╝nyesinde g├Ârev yapan t├╝m i┼ş├ğilerin maa┼şlar─▒na %20 zam m├╝jdesini verdi. Ek zam protokol├╝ Gebze Belediye Ba┼şkan─▒ Zinnur B├£Y├£KG├ûZ ve Hizmet-─░┼ş ve ├ûzg├╝ven-Sen Sendikas─▒ yetkilileri aras─▒nda imzaland─▒.','─░nsan Kaynaklar─▒','insan','../images/gebze-de-ek-zam-protokolu-mzalandi_4681.jpg',NULL,NULL,'2023-10-04'),(4,'duyuru','Gebze\'nin Filosu B├╝y├╝yor;','Gebze\'nin mahallelerine daha kaliteli hizmet verebilmek ad─▒na makine ve ara├ğ filosuna yeni takviyeler yap─▒lmas─▒n─▒ sa─şlayan Gebze Belediye Ba┼şkan─▒ Zinnur B├╝y├╝kg├Âz, belediyenin ├Âz kaynaklar─▒yla sat─▒n al─▒nan 100 yeni arac─▒ filoya kazand─▒rd─▒.','─░nsan Kaynaklar─▒','insan','../images/gebze-nin-filosu-buyuyor_2355.jpg',NULL,NULL,'2023-10-04'),(5,'duyuru','Daha Sa─şl─▒kl─▒ Personel ─░├ğin','Gebze Belediyesi b├╝nyesinde g├Ârev yapan t├╝m personellerimiz ve 1. derece yak─▒nlar─▒ (anne, baba, e┼ş ve ├ğocuk ) anla┼şmal─▒ sa─şl─▒k kurumlar─▒nda indirimli fiyatlardan faydalanabilme olana─ş─▒na sahip olacaklard─▒r.','─░nsan Kaynaklar─▒','insan','../images/daha-saazlikli-ba-r-personel-a-a-a-n_7523.jpg',NULL,NULL,'2023-10-04'),(6,'duyuru','Parola G├╝venlik Politika Ge├ği┼şi','T.C. Cumhurba┼şkanl─▒─ş─▒ Dijital D├Ân├╝┼ş├╝m Ofisi Ba┼şkanl─▒─ş─▒ koordinasyonunda ba┼şlat─▒lan \"Bilgi ve ─░leti┼şim G├╝venli─şi Rehberi\" uyum s├╝reci do─şrultusunda ger├ğekle┼ştirece─şimiz \"G├╝venli Parola Politikas─▒\" ge├ği┼şi kapsam─▒nda, bilgisayar oturumu a├ğma parolalar─▒ de─şi┼şecektir.','Bilgi ─░┼şlem','bilgi','../images/parola-guvenlik-politikasi-duyurusu_2090.jpg',NULL,NULL,'2023-10-04');
/*!40000 ALTER TABLE `etkinlikler_duyurular` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `haber_galeri`
--

DROP TABLE IF EXISTS `haber_galeri`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `haber_galeri` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `haber_id` int(11) NOT NULL DEFAULT 1,
  `resim_url` varchar(255) NOT NULL,
  `sira` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `idx_haber_galeri_haber_id` (`haber_id`),
  CONSTRAINT `fk_haber_galeri_haber` FOREIGN KEY (`haber_id`) REFERENCES `haberler` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `haber_galeri`
--

LOCK TABLES `haber_galeri` WRITE;
/*!40000 ALTER TABLE `haber_galeri` DISABLE KEYS */;
INSERT INTO `haber_galeri` VALUES (1,1,'../images/off-road-foto/gebze-de-off-road-heyecan_120.jpg',1),(2,1,'../images/off-road-foto/gebze-de-off-road-heyecan_2075.jpg',2),(3,1,'../images/off-road-foto/gebze-de-off-road-heyecan_2143.jpg',3),(4,1,'../images/off-road-foto/gebze-de-off-road-heyecan_3569.jpg',4),(5,1,'../images/off-road-foto/gebze-de-off-road-heyecan_3911.jpg',5),(6,1,'../images/off-road-foto/gebze-de-off-road-heyecan_4046.jpg',6),(7,1,'../images/off-road-foto/gebze-de-off-road-heyecan_4564.jpg',7),(8,1,'../images/off-road-foto/gebze-de-off-road-heyecan_4975.jpg',8),(9,1,'../images/off-road-foto/gebze-de-off-road-heyecan_5429.jpg',9);
/*!40000 ALTER TABLE `haber_galeri` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `haberler`
--

DROP TABLE IF EXISTS `haberler`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `haberler` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `baslik` varchar(255) NOT NULL,
  `aciklama` text NOT NULL,
  `resim` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `haberler`
--

LOCK TABLES `haberler` WRITE;
/*!40000 ALTER TABLE `haberler` DISABLE KEYS */;
INSERT INTO `haberler` VALUES (1,'8 Mart D├╝nya Kad─▒nlar G├╝n├╝ Program─▒','Kad─▒n personelimizin ├Âzel g├╝n├╝ kutland─▒.','../images/8-mart-dunya-kadinlar-gunu-programi_8383.jpg'),(2,'24 Kas─▒m ├û─şretmenler G├╝n├╝ Ziyareti','├û─şretmenlerimizi bu ├Âzel g├╝nlerinde yaln─▒z b─▒rakmad─▒k.','../images/24-kas-m-o-retmenler-gunu_2947.jpg'),(3,'Personel Bayramla┼şma Program─▒','Personelle bayramla┼şt─▒k.','../images/personel-bayramla-ma-programi_5965.jpg'),(4,'Personel ─░ftar Program─▒','','../images/personel-ftar-program_109.jpg'),(5,'Personel Piknik Program─▒','','../images/personel-p-kn-k-programi_9118.jpg'),(6,'A─ş─▒z ve Di┼ş Sa─şl─▒─ş─▒ Taramas─▒','','../images/personellerimizin-a-z-ve-di-sa-l-n-onemsiyoruz_7091.jpg'),(7,'─░kinci ─░ftar Bulu┼şmas─▒','','../images/pesonel-ftar-programi_3732.jpg'),(8,'Stajyer D├Ânem Sonu Etkinli─şi','','../images/stajyer-donem-sonu-etk-nl_6028.jpg'),(9,'Stajyer Film Okuma Program─▒','','../images/stajyer-f-lm-okuma-programi_3604.jpg'),(10,'Stajyer ├û─şrenci Oryantasyonu','','../images/stajyer-o-renci-oryantasyonu_2177.jpg'),(11,'Stajyer Oryantasyon E─şitimi','','../images/stajyer-oryantasyon-e-t-m_8697.jpg'),(12,'Ulusal Da─ş Bisikleti Kupas─▒','','../images/ulusal-da-bisikleti-kupas-yar-lar_128.jpg');
/*!40000 ALTER TABLE `haberler` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kaynaklar`
--

DROP TABLE IF EXISTS `kaynaklar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kaynaklar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `baslik` varchar(255) NOT NULL,
  `aciklama` text NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `alt_kategori` varchar(50) DEFAULT NULL,
  `ikon` varchar(50) DEFAULT 'fa-file-signature',
  `dosya_yolu` varchar(255) NOT NULL,
  `resmi_sayfa` varchar(500) DEFAULT NULL,
  `boyut` varchar(50) NOT NULL,
  `tarih` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kaynaklar`
--

LOCK TABLES `kaynaklar` WRITE;
/*!40000 ALTER TABLE `kaynaklar` DISABLE KEYS */;
INSERT INTO `kaynaklar` VALUES (1,'Aile Bildirim Formu','Personelin medeni durumu, e┼ş, ├ğocuk ve bakmakla y├╝k├╝ml├╝ oldu─şu aile bireylerine ili┼şkin bilgileri bildirmek veya g├╝ncellemek amac─▒yla kullan─▒lan resmi form.','D├Âk├╝manlar',NULL,'fas fa-user-friends','../images/dokumanlar/a-le-durum-b-ld-r-r-formu_7664 (1).xlsx',NULL,'2.3 MB','04.10.2023'),(2,'Mal Bildirim Formu','Kamu g├Ârevlilerinin kendileri, e┼şleri ve velayetleri alt─▒ndaki ├ğocuklar─▒na ait ta┼ş─▒n─▒r ve ta┼ş─▒nmaz mallar ile di─şer mal varl─▒─ş─▒ unsurlar─▒n─▒ 3628 say─▒l─▒ Kanun gere─şince beyan etmek amac─▒yla kullan─▒lan form.','D├Âk├╝manlar',NULL,'fas fa-briefcase','../images/dokumanlar/mal-b-ld-r-m-formu_501.doc',NULL,'845 KB','08.01.2025'),(3,'Personel ─░li┼şki Kesme Formu','Kurumdan ayr─▒lan personelin zimmetli e┼şyalar─▒n─▒n teslimi ve ilgili birimlerle ili┼şi─şinin resmi olarak kesilmesi amac─▒yla kullan─▒lan form.','D├Âk├╝manlar',NULL,'fas fa-sign-out-alt','../images/dokumanlar/personel-l-k-kesme-formu_9657.docx',NULL,'1.7 MB','20.12.2024'),(4,'Gebze Merkez Prime Hastanesi','Gebze Merkez Prime Hastanesi ─░le Gebze Belediyesi Personelleri Ve Birinci Derece Yak─▒nlar─▒na Y├Ânelik % 20 Oran─▒nda ─░ndirim Anla┼şmas─▒ ─░mzalanm─▒┼şt─▒r.','Protokoller',NULL,'fas fa-hospital','https://personel.gebze.bel.tr/upload/antlasma/gebze-merkez-pr-me-hastanes/gebze-merkez-pr-me-hastanes_2019.pdf',NULL,'2.3 MB','04.10.2023'),(5,'Gebze MedicalPark Hastanesi','Gebze Med─▒calpark Hastanesi ─░le Gebze Belediyesi Personelleri Ve Birinci Derece\r\nYak─▒nlar─▒na Y├Ânelik % 20 Oran─▒nda ─░ndirim Anla┼şmas─▒ ─░mzalanm─▒┼şt─▒r.','Protokoller',NULL,'fas fa-hospital','https://personel.gebze.bel.tr/upload/antlasma/gebze-medicalpark-hastanes/gebze-medicalpark-hastanes_3836.pdf',NULL,'845 KB','04.10.2023'),(6,'Gebze ├ûzel Y├╝zy─▒l Hastanesi','Gebze ├ûzel Y├╝zy─▒l Hastanesi ─░le Gebze Belediyesi Personelleri Ve Birinci Derece\r\nYak─▒nlar─▒na Y├Ânelik % 20 Oran─▒nda ─░ndirim Anla┼şmas─▒ ─░mzalanm─▒┼şt─▒r.','Protokoller',NULL,'fas fa-hospital','https://personel.gebze.bel.tr/upload/antlasma/gebze-ozel-yuzyil-hastanes/gebze-ozel-yuzyil-hastanes_6572.pdf',NULL,'1.7 MB',' 04.10.2023'),(7,'Dar─▒ca Hospitalpark Hastanesi',' Dar─▒ca Hosp─▒talpark Hastanesi ─░le Gebze Belediyesi Personelleri Ve Birinci Derece\r\nYak─▒nlar─▒na Y├Ânelik % 30 Oran─▒nda ─░ndirim Anla┼şmas─▒ ─░mzalanm─▒┼şt─▒r.','Protokoller',NULL,'fas fa-hospital','https://personel.gebze.bel.tr/upload/antlasma/darica-hospitalpark-hastanes/darica-hospitalpark-hastanes_1530.pdf',NULL,'1.7 MB','04.10.2023'),(8,'├ûzel ├£lker A─ş─▒z ve Di┼ş Sa─şl─▒─ş─▒ Poliklini─şi',' Personellerimizin ve 1. derece yak─▒nlar─▒n─▒n (anne, baba, e┼ş ve ├ğocuklar) di┼ş sa─şl─▒─ş─▒na katk─▒da bulunmak ad─▒na ├ğevre Polikliniklerimizle muayene, tetkik ve tedavilerde indirim anla┼şmalar─▒ imzalanm─▒┼şt─▒r.','Protokoller',NULL,'fas fa-tooth','https://personel.gebze.bel.tr/upload/antlasma/ozel-ulker-a-iz-ve-d-sa-li-i-pol-kl-n/ozel-ulker-a-iz-ve-d-sa-li-i-pol-kl-n_3454.pdf',NULL,'1.7 MB',' 04.10.2023'),(9,'├ûzel Dentriva A─ş─▒z ve Di┼ş Sa─şl─▒─ş─▒ Poliklini─şi','Personellerimizin ve 1. derece yak─▒nlar─▒n─▒n (anne, baba, e┼ş ve ├ğocuklar) di┼ş sa─şl─▒─ş─▒na katk─▒da bulunmak ad─▒na ├ğevre Polikliniklerimizle muayene, tetkik ve tedavilerde indirim anla┼şmalar─▒ imzalanm─▒┼şt─▒r.','Protokoller',NULL,'fas fa-tooth','https://personel.gebze.bel.tr/upload/antlasma/ozel-dentr-va-a-iz-ve-d-sa-li-i-pol-kl-n/ozel-dentr-va-a-iz-ve-d-sa-li-i-pol-kl-n_5515.pdf',NULL,'1.7 MB','04.10.2023'),(10,'├ûzel Arap├ğe┼şme A─ş─▒z ve Di┼ş Sa─şl─▒─ş─▒ Poliklini─şi','Personellerimizin ve 1. derece yak─▒nlar─▒n─▒n (anne, baba, e┼ş ve ├ğocuklar) di┼ş sa─şl─▒─ş─▒na katk─▒da bulunmak ad─▒na ├ğevre Polikliniklerimizle muayene, tetkik ve tedavilerde indirim anla┼şmalar─▒ imzalanm─▒┼şt─▒r.','Protokoller',NULL,'fas fa-tooth','https://personel.gebze.bel.tr/upload/antlasma/ozel-arapce-me-a-iz-ve-d-sa-li-i-pol-kl-n/ozel-arapce-me-a-iz-ve-d-sa-li-i-pol-kl-n_7964.pdf',NULL,'1.7 MB','04.10.2023'),(11,'┼Şim┼şekdent A─ş─▒z ve Di┼ş Sa─şl─▒─ş─▒ Poliklini─şi','Personellerimizin ve 1. derece yak─▒nlar─▒n─▒n (anne, baba, e┼ş ve ├ğocuklar) di┼ş sa─şl─▒─ş─▒na katk─▒da bulunmak ad─▒na ├ğevre Polikliniklerimizle muayene, tetkik ve tedavilerde indirim anla┼şmalar─▒ imzalanm─▒┼şt─▒r.','Protokoller',NULL,'fas fa-tooth','https://personel.gebze.bel.tr/upload/antlasma/m-ekdent-a-iz-ve-d-sa-li-i-pol-kl-n/m-ekdent-a-iz-ve-d-sa-li-i-pol-kl-n_2554.pdf',NULL,'2.3 MB','20.12.2024'),(12,'Resmi Yaz─▒┼şma Kurallar─▒','Kamu kurum ve kurulu┼şlar─▒nda kullan─▒lmas─▒ esas ve her kamu g├Ârevlisi taraf─▒ndan bilinmesi gereken resmi yaz─▒┼şmalar hakk─▒nda mevzuat h├╝k├╝mleri.','Mevzuatlar','genel','fas fa-folder-open','https://personel.gebze.bel.tr/upload/regulation/resm-yazi-ma-kurallari/resm-yazi-ma-kurallari_1373.pdf','https://www.mevzuat.gov.tr/mevzuatmetin/21.5.2646.pdf','2.3 MB','04.10.2023'),(13,'Belediye Kanunu','Kanun Numaras─▒ : 5393 Kabul Tarihi : 3/7/2005 Yay─▒mland─▒─ş─▒ Resm├« Gazete : Tarih :13/7/2005 Say─▒ : 25874 Yay─▒mland─▒─ş─▒ D├╝stur : Tertip : 5 Cilt : 44','Mevzuatlar','genel','fas fa-folder-open','https://personel.gebze.bel.tr/upload/regulation/5393-sayili-beled-ye-kanunu/5393-sayili-beled-ye-kanunu_8722.pdf','https://www.mevzuat.gov.tr/mevzuatmetin/1.5.5393.pdf','845 KB','04.10.2023'),(14,'Kamu ─░hale Kanunu','Kanunun Numaras─▒ : 4734 Kabul Tarihi : 4/1/2002 Yay─▒mland─▒─ş─▒ Resm├« Gazete : Tarih :22/1/2002 Say─▒ : 24648 Yay─▒mland─▒─ş─▒ D├╝stur : Tertip : 5 Cilt : 42','Mevzuatlar','genel','fas fa-folder-open','https://personel.gebze.bel.tr/upload/regulation/kamu-hale-kanunu/kamu-hale-kanunu_4328.pdf','https://www.mevzuat.gov.tr/MevzuatMetin/1.5.4734.pdf','1.7 MB','04.10.2023'),(15,'Kamu ─░hale S├Âzle┼şmeleri Kanunu',' Kanun Numaras─▒ : 4735 Kabul Tarihi : 5/1/2002 Yay─▒mland─▒─ş─▒ Resm├« Gazete : Tarih :22/1/2002 Say─▒ : 24648 Yay─▒mland─▒─ş─▒ D├╝stur : Tertip : 5 Cilt : 42','Mevzuatlar','genel','fas fa-folder-open','https://personel.gebze.bel.tr/upload/regulation/kamu-hale-sozle-meler-kanunu/kamu-hale-sozle-meler-kanunu_8417.pdf','https://www.mevzuat.gov.tr/MevzuatMetin/1.5.4735.pdf','2.3 MB','04.10.2023'),(16,'─░mar Kanunu',' Kanun Numaras─▒ : 3194 Kabul Tarihi : 3/5/1985 Yay─▒mland─▒─ş─▒ R. Gazete : Tarih :9/5/1985 Say─▒: 18749 Yay─▒mland─▒─ş─▒ D├╝stur : Tertip : 5 Cilt : 24 Sayfa : 378','Mevzuatlar','genel','fas fa-folder-open','https://personel.gebze.bel.tr/upload/regulation/3194-sayili-mar-kanunu/3194-sayili-mar-kanunu_9104.pdf','https://www.mevzuat.gov.tr/mevzuat?MevzuatNo=20122665&MevzuatTur=21&MevzuatTertip=5','1.7 MB','04.10.2023'),(17,'Ki┼şisel Verilerin Korunmas─▒ Kanunu',' Kanun Numaras─▒ : 6698 Kabul Tarihi : 24/3/2016 Yay─▒mland─▒─ş─▒ Resm├« Gazete : Tarih :7/4/2016 Say─▒ : 29677 Yay─▒mland─▒─ş─▒ D├╝stur : Tertip : 5 Cilt : 57','Mevzuatlar','genel','fa-file-signature','https://personel.gebze.bel.tr/upload/regulation/k-sel-ver-ler-n-korunmasi-kanunu/k-sel-ver-ler-n-korunmasi-kanunu_7116.pdf','https://www.mevzuat.gov.tr/mevzuat?MevzuatNo=6698&MevzuatTur=1&MevzuatTertip=5','2.3 MB','04.10.2023'),(18,'Devlet Memurlar─▒ Kanunu','Kanun Numaras─▒ : 657 Kabul Tarihi : 14/7/1965 Yay─▒mland─▒─ş─▒ Resm├« Gazete : Tarih :23/7/1965 Say─▒ : 12056 Yay─▒mland─▒─ş─▒ D├╝stur : Tertip : 5 Cilt : 4 Sayfa : 3044','Mevzuatlar','memur','fas fa-folder-open','https://personel.gebze.bel.tr/upload/regulation/657-sayili-devlet-memurlari-kanunu/657-sayili-devlet-memurlari-kanunu_1477.pdf','https://www.mevzuat.gov.tr/MevzuatMetin/1.5.657.pdf','1.7 MB','04.10.2023'),(19,' Devlet Memurlar─▒na Verilecek Hastal─▒k Raporlar─▒ ile Hastal─▒k ve Refakat ─░znine ─░li┼şkin Usul ve Esaslar Hakk─▒nda Y├Ânetmenlik','Bakanlar Kurulu Karar─▒n─▒n Tarihi : 22/8/2011 No : 2011/2226 Dayand─▒─ş─▒ Kanunun Tarihi :14/7/1965 No : 657 Yay─▒mland─▒─ş─▒ R.Gazetenin Tarihi : 29/10/2011 No : 28099 Yay─▒mland─▒─ş─▒\r\nD├╝sturun Tertibi : 5 Cilt : 51','Mevzuatlar','memur','fas fa-folder-open','https://www.mevzuat.gov.tr/MevzuatMetin/3.5.20112226.pdf','https://personel.gebze.bel.tr/upload/regulation/devlet-memurlarina-ver-lecek-hastalik-raporlari-le-hastalik-ve-refakat-zn-ne-l-k-n-usul-ve-esaslar-hakkinda-yonetmel-k/devlet-memurlarina-ver-lecek-hastalik-raporlari-le-hastalik-ve-refakat-zn-ne-l-k-n-usul-ve-esaslar-hakkinda-yonetmel-k_3060.pdf','1.7 MB','04.10.2023'),(20,'Memurlar ve Di─şer Kamu G├Ârevlilerinin Yarg─▒lanmas─▒ Hakk─▒nda Kanun',' Kanun Numaras─▒ : 4483 Kabul Tarihi : 2/12/1999 Yay─▒mland─▒─ş─▒ Resm├« Gazete : Tarih :4/12/1999 Say─▒ : 23896 Yay─▒mland─▒─ş─▒ D├╝stur : Tertip : 5 Cilt : 39','Mevzuatlar','memur','fas fa-folder-open','https://www.mevzuat.gov.tr/mevzuat?MevzuatNo=4483&MevzuatTur=1&MevzuatTertip=5','https://personel.gebze.bel.tr/upload/regulation/memurlar-ve-d-er-kamu-gorevl-ler-n-n-yargilanmasi-hakkinda-kanun/memurlar-ve-d-er-kamu-gorevl-ler-n-n-yargilanmasi-hakkinda-kanun_4777.pdf','1.7 MB','04.10.2023'),(21,'Mahalli ─░dareler Disiplin Amirleri Y├Ânetmenli─şi','MAHALL─░ ─░DARELER D─░S─░PL─░N AM─░RLER─░ Y├ûNETMEL─░─Ş─░','Mevzuatlar','memur','fas fa-folder-open','https://personel.gebze.bel.tr/upload/regulation/mahall-dareler-d-s-pl-n-am-rler-yonetmel/mahall-dareler-d-s-pl-n-am-rler-yonetmel_5784.pdf','https://www.mevzuat.gov.tr/MevzuatMetin/yonetmelik/7.5.39416.pdf','1.7 MB','04.10.2023'),(22,'S├Âzle┼şmeli Personel ├çal─▒┼şt─▒r─▒lmas─▒na ─░li┼şkin Esaslar','Bakanlar Kurulu Karar─▒n─▒n; Tarihi ve No\'su : 6/6/1978-7/15754 Dayand─▒─ş─▒ Kanun :28/2/1978-2143 Yay─▒mland─▒─ş─▒ Resmi Gazete : 28/6/1978-16330 9/5/2020 tarihli ve 31122 say─▒l─▒ Resm├« Gazete\'de yay─▒mlanan 8/5/2020 tarihli ve 2506 say─▒l─▒ Cumhurba┼şkan─▒ Karar─▒ uyar─▒nca bu Y├Ânetmelik Cumhurba┼şkanl─▒─ş─▒ Y├Ânetmeli─şi b├Âl├╝m├╝ne eklenmi┼ştir.','Mevzuatlar','sozlesmeli','fas fa-folder-open','https://personel.gebze.bel.tr/upload/regulation/sozle-mel-personel-cali-tirilmasina-l-k-n-esaslar/sozle-mel-personel-cali-tirilmasina-l-k-n-esaslar_7813.pdf','https://www.mevzuat.gov.tr/anasayfa/MevzuatFihristDetayIframe?MevzuatTur=21&MevzuatNo=715754&MevzuatTertip=5','1.7 MB','04.10.2023'),(23,'S├Âzle┼şmeli Personele Ek ├ûdeme Yap─▒lmas─▒na Dair Karar','Bakanlar Kurulu Karar─▒n─▒n Tarihi: 3/1/2012 Say─▒s─▒: 2012/2665 Yay─▒mland─▒─ş─▒ Resmi Gazete Tarihi:10/1/2012 Say─▒s─▒: 28169','Mevzuatlar','sozlesmeli','fas fa-folder-open','https://personel.gebze.bel.tr/upload/regulation/sozle-mel-personele-ek-odeme-yapilmasina-da-r-karar/sozle-mel-personele-ek-odeme-yapilmasina-da-r-karar_7257.pdf','https://www.mevzuat.gov.tr/mevzuat?MevzuatNo=20122665&MevzuatTur=21&MevzuatTertip=5','1.7 MB','04.10.2023'),(24,'─░┼ş Kanunu','Kanun Numaras─▒ : 4857 Kabul Tarihi : 22/5/2003 Yay─▒mland─▒─ş─▒ Resm├« Gazete : Tarih: 10/6/2003 Say─▒ : 25134 Yay─▒mland─▒─ş─▒ D├╝stur : Tertip : 5 Cilt : 42','Mevzuatlar','isci','fas fa-folder-open','https://personel.gebze.bel.tr/upload/regulation/4857-sayili-kanunu/4857-sayili-kanunu_8535.pdf','https://www.mevzuat.gov.tr/mevzuatmetin/1.5.4857.pdf','1.7 MB','04.10.2023'),(25,'Ya┼şam Enerjisini Y├╝kseltme Yollar─▒','Ya┼şam Enerjisini Y├╝kseltme Yollar─▒','E─şitimler',NULL,'','https://www.youtube.com/watch?v=NkLIwJsycKw',NULL,'2.3 MB','04.10.2023'),(26,'Sat─▒n Alma Y├Ântem ve S├╝re├ğleri','Sat─▒n Alma Y├Ântem ve S├╝re├ğleri','E─şitimler',NULL,'','https://www.youtube.com/watch?v=HlSLDMRZOAE',NULL,'845 KB','08.01.2025'),(27,'Disiplin Uygulamalar─▒','Disiplin Uygulamalar─▒','E─şitimler','','','https://www.youtube.com/watch?v=oQaAM3yFu5k',NULL,'2.3 MB','20.12.2024'),(28,'Belediye ┼Şirketleri','Belediye ┼Şirketleri','E─şitimler',NULL,'','https://www.youtube.com/watch?v=Bpl95iZ8Gkc',NULL,'845 KB','08.01.2025'),(29,'Belediyelerin Sosyal Yard─▒m ve Hizmetleri','Belediyelerin Sosyal Yard─▒m ve Hizmetleri','E─şitimler',NULL,'','https://www.youtube.com/watch?v=v_43pkCuwdg',NULL,'845 KB','04.10.2023'),(30,'Bilgi Edinme Hakk─▒','Bilgi Edinme Hakk─▒','E─şitimler',NULL,'','https://www.youtube.com/watch?v=nTbrb8pqY9U',NULL,'2.3 MB',' 04.10.2023'),(31,'K─▒rsal Mahalle ve K─▒rsal Yerle┼şik Alan Y├Ânetmeli─şi','K─▒rsal Mahalle ve K─▒rsal Yerle┼şik Alan Y├Ânetmeli─şi','E─şitimler',NULL,'','https://www.youtube.com/watch?v=HULXxszRxVk',NULL,'2.3 MB','20.12.2024'),(32,'Kamula┼şt─▒rma','Kamula┼şt─▒rma','E─şitimler',NULL,'','https://www.youtube.com/watch?v=F5pE70bPaWM',NULL,'2.3 MB',' 04.10.2023'),(33,'Yeni Zab─▒ta Y├Ânetmeli─şi','Yeni Zab─▒ta Y├Ânetmeli─şi','E─şitimler',NULL,'','https://www.youtube.com/watch?v=9QWJRD0G_Iw',NULL,'1.7 MB','20.12.2024');
/*!40000 ALTER TABLE `kaynaklar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oturum_kayitlari`
--

DROP TABLE IF EXISTS `oturum_kayitlari`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oturum_kayitlari` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `personel_id` int(11) NOT NULL,
  `giris_zamani` datetime NOT NULL,
  `cikis_zamani` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_oturum_personel_id` (`personel_id`),
  CONSTRAINT `fk_oturum_personel` FOREIGN KEY (`personel_id`) REFERENCES `personeller` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oturum_kayitlari`
--

LOCK TABLES `oturum_kayitlari` WRITE;
/*!40000 ALTER TABLE `oturum_kayitlari` DISABLE KEYS */;
INSERT INTO `oturum_kayitlari` VALUES (1,1,'2026-07-06 14:39:17',NULL),(2,1,'2026-07-06 14:40:20',NULL),(3,1,'2026-07-06 14:47:54',NULL),(4,1,'2026-07-06 14:48:21',NULL),(5,1,'2026-07-06 14:55:05',NULL),(6,1,'2026-07-06 14:56:53',NULL),(7,1,'2026-07-06 15:02:01',NULL),(8,1,'2026-07-06 15:24:53','2026-07-06 15:29:04'),(9,1,'2026-07-06 15:29:26',NULL),(10,1,'2026-07-06 15:48:53',NULL),(11,1,'2026-07-07 08:48:16',NULL),(12,1,'2026-07-07 09:00:50','2026-07-07 09:07:06'),(13,1,'2026-07-07 09:07:54','2026-07-07 09:08:23'),(14,1,'2026-07-07 09:08:58','2026-07-07 09:09:07'),(15,1,'2026-07-07 09:15:32','2026-07-07 09:18:04'),(16,1,'2026-07-07 09:18:20','2026-07-07 09:19:42'),(17,1,'2026-07-07 09:19:52','2026-07-07 09:35:43'),(18,1,'2026-07-07 09:35:56','2026-07-07 11:49:26'),(19,1,'2026-07-07 11:49:39','2026-07-07 12:17:40'),(20,1,'2026-07-07 15:01:28','2026-07-07 15:03:15'),(21,1,'2026-07-07 15:03:22',NULL),(22,1,'2026-07-08 13:30:07','2026-07-08 13:34:04'),(23,1,'2026-07-08 13:34:41','2026-07-08 13:34:56'),(24,1,'2026-07-08 13:35:22','2026-07-08 13:39:23');
/*!40000 ALTER TABLE `oturum_kayitlari` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personeller`
--

DROP TABLE IF EXISTS `personeller`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personeller` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sicil_no` varchar(50) NOT NULL,
  `ad` varchar(50) NOT NULL,
  `soyad` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `sifre` varchar(255) NOT NULL,
  `dogum_tarihi` date NOT NULL,
  `foto_url` varchar(255) NOT NULL,
  `remember_token_hash` varchar(64) DEFAULT NULL,
  `remember_token_expires` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_personeller_sicil_no` (`sicil_no`),
  UNIQUE KEY `uq_personeller_email` (`email`),
  UNIQUE KEY `uq_personeller_remember_token_hash` (`remember_token_hash`),
  KEY `idx_personeller_dogum_tarihi` (`dogum_tarihi`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personeller`
--

LOCK TABLES `personeller` WRITE;
/*!40000 ALTER TABLE `personeller` DISABLE KEYS */;
INSERT INTO `personeller` VALUES (1,'12345','zehra','aral?k','test3@gebze.bel.tr','81dc9bdb52d04dc20036dbd8313ed055','2006-07-07','../images/gebze_logo.jpg',NULL,NULL);
/*!40000 ALTER TABLE `personeller` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sizden_gelenler`
--

DROP TABLE IF EXISTS `sizden_gelenler`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sizden_gelenler` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `baslik` varchar(255) NOT NULL,
  `ozet` text NOT NULL,
  `kategori_slug` varchar(100) NOT NULL,
  `kategori_adi` varchar(150) NOT NULL,
  `tarih` date NOT NULL,
  `goruntulenme` int(11) DEFAULT 0,
  `gorsel_yolu` varchar(255) DEFAULT NULL,
  `olusturma_tarihi` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sizden_gelenler`
--

LOCK TABLES `sizden_gelenler` WRITE;
/*!40000 ALTER TABLE `sizden_gelenler` DISABLE KEYS */;
INSERT INTO `sizden_gelenler` VALUES (1,'─░nsan Kaynaklar─▒ ve E─şitim M├╝d├╝rl├╝─ş├╝','6734 ve 6735 Say─▒l─▒ Kanun E─şitimi - Biyomedikal E─şitimi - ├£niversite E─şitimi - Oryantasyon E─şitimi - Fen Programlama E─şitimi - Mevzuat E─şitimi - Teknoloji ├çal─▒┼şma E─şitimi...','insan-kaynaklari','─░nsan Kaynaklar─▒ ve E─şitim M├╝d├╝rl├╝─ş├╝','2023-11-06',93,'../images/sizden_gelenler/insan_kaynaklari/nsan-kaynaklar-ve-e-itim-mudurlu-u_1547.jpg','2026-07-02 12:20:03'),(2,'Fen ─░┼şleri M├╝d├╝rl├╝─ş├╝','K├Âpr├╝l├╝ Ge├ğmis Mahallesi, 503 Sokak\'taki ├ğal─▒┼şmalar...K├Âpr├╝l├╝ Ge├ğmis Mahallesi, 503 Sokak\'taki ├ğal─▒┼şmalar...','fen-isleri','Fen ─░┼şleri M├╝d├╝rl├╝─ş├╝','2023-10-19',146,'../images/sizden_gelenler/fen_isleri/fen-leri-mudurlu-u_3604.jpg','2026-07-02 12:20:03'),(3,'Temizlik ─░┼şleri M├╝d├╝rl├╝─ş├╝','K├╝l, katk─▒s─▒z ve t├╝m g├╝zelle┼ştirme organlar─▒ndan ┼şeye ├ğe┼şit kurtar─▒c─▒lar...K├╝l, katk─▒s─▒z ve t├╝m g├╝zelle┼ştirme organlar─▒ndan ┼şeye ├ğe┼şit kurtar─▒c─▒lar...','temizlik','Temizlik ─░┼şleri M├╝d├╝rl├╝─ş├╝','2023-10-19',78,'../images/sizden_gelenler/temizlik_isleri/temizlik-leri-mudurlu-u_2142.jpg','2026-07-02 12:20:03'),(4,'Veteriner ─░┼şleri M├╝d├╝rl├╝─ş├╝','4 Ekim D├╝nya Hayvanlar─▒ Koruma G├╝n├╝ nedeniyle 4 Ekim boyunca...4 Ekim D├╝nya Hayvanlar─▒ Koruma G├╝n├╝ nedeniyle 4 Ekim boyunca...','veteriner','Veteriner ─░┼şleri M├╝d├╝rl├╝─ş├╝','2023-10-17',234,'../images/sizden_gelenler/veteriner_isleri/veteriner-leri-mudurlu-u_547.jpg','2026-07-02 12:20:03'),(5,'Park ve Bah├ğeler M├╝d├╝rl├╝─ş├╝','Ba─ş─▒┼şlanm─▒┼ş g├╝nl├╝k program─▒ g├Âbildirinde park ve ye┼şil alanlar─▒m─▒zda...','park-bahce','Park ve Bah├ğeler M├╝d├╝rl├╝─ş├╝','2023-10-17',156,'../images/sizden_gelenler/park_bahce/park-ve-bahceler-mudurlu-u_357.jpg','2026-07-02 12:20:03'),(6,'─░nsan Kaynaklar─▒ E─şitim Semineri','Personel geli┼şimi i├ğin d├╝zenlenen e─şitim seminerimiz tamamland─▒. Kat─▒l─▒mc─▒lar─▒m─▒z ba┼şar─▒ sertifikalar─▒n─▒ ald─▒...','insan-kaynaklari','─░nsan Kaynaklar─▒ ve E─şitim M├╝d├╝rl├╝─ş├╝','2023-10-15',189,'../images/sizden_gelenler/insan_kaynaklari/nsan-kaynaklar-ve-e-itim-mudurlu-u_4846.jpg','2026-07-02 12:20:03'),(7,'Yol Bak─▒m ve Onar─▒m ├çal─▒┼şmalar─▒','┼Şehrimizin ├ğe┼şitli b├Âlgelerinde ger├ğekle┼ştirilen yol bak─▒m ve onar─▒m ├ğal─▒┼şmalar─▒ devam ediyor...','fen-isleri','Fen ─░┼şleri M├╝d├╝rl├╝─ş├╝','2023-10-12',267,'../images/sizden_gelenler/fen_isleri/fen-leri-mudurlu-u_8989.jpg','2026-07-02 12:20:03'),(8,'├çevre Temizlik Kampanyas─▒','Do─şal ya┼şam alanlar─▒n─▒n korunmas─▒ i├ğin ba┼şlat─▒lan temizlik kampanyas─▒ b├╝y├╝k ilgi g├Ârd├╝...','temizlik','Temizlik ─░┼şleri M├╝d├╝rl├╝─ş├╝','2023-10-10',198,'../images/sizden_gelenler/temizlik_isleri/temizlik-leri-mudurlu-u_6633.jpg','2026-07-02 12:20:03'),(9,'Dijital D├Ân├╝┼ş├╝m E─şitimi','Personelimize y├Ânelik dijital d├Ân├╝┼ş├╝m ve teknoloji kullan─▒m─▒ e─şitimi ba┼şar─▒yla tamamland─▒...','zabita','Zab─▒ta M├╝d├╝rl├╝─ş├╝','2023-10-08',312,'../images/sizden_gelenler/zab─▒ta/zab-ta-mudurlu-u_6319.jpg','2026-07-02 12:20:03'),(10,'Altyap─▒ Geli┼ştirme Projesi','┼Şehir merkezindeki altyap─▒ geli┼ştirme ve modernizasyon ├ğal─▒┼şmalar─▒ h─▒zla devam ediyor...','fen-isleri','Fen ─░┼şleri M├╝d├╝rl├╝─ş├╝','2023-10-05',423,'../images/sizden_gelenler/fen_isleri/fen-leri-mudurlu-u_8989.jpg','2026-07-02 12:20:03'),(11,'Sokak Hayvanlar─▒ Bak─▒m Program─▒','Sokak hayvanlar─▒n─▒n sa─şl─▒k kontrol├╝ ve bak─▒m program─▒ kapsam─▒nda ├ğal─▒┼şmalar s├╝rd├╝r├╝l├╝yor...','veteriner','Veteriner ─░┼şleri M├╝d├╝rl├╝─ş├╝','2023-10-03',186,'../images/sizden_gelenler/veteriner_isleri/veteriner-leri-mudurlu-u_547.jpg','2026-07-02 12:20:03'),(12,'Ye┼şil Alan D├╝zenleme ├çal─▒┼şmas─▒','Kent genelindeki park ve ye┼şil alanlar─▒n bak─▒m ve d├╝zenleme ├ğal─▒┼şmalar─▒ tamamland─▒...','park-bahce','Park ve Bah├ğeler M├╝d├╝rl├╝─ş├╝','2023-10-01',278,'../images/sizden_gelenler/park_bahce/park-ve-bahceler-mudurlu-u_4188.jpg','2026-07-02 12:20:03');
/*!40000 ALTER TABLE `sizden_gelenler` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vefat_bilgileri`
--

DROP TABLE IF EXISTS `vefat_bilgileri`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vefat_bilgileri` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vefat_eden_adi` varchar(255) NOT NULL,
  `iliski_pozisyon` text NOT NULL,
  `vefat_tarihi` date NOT NULL,
  `vefat_tarihi_metin` varchar(50) NOT NULL,
  `cenaze_mesaji` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vefat_bilgileri`
--

LOCK TABLES `vefat_bilgileri` WRITE;
/*!40000 ALTER TABLE `vefat_bilgileri` DISABLE KEYS */;
INSERT INTO `vefat_bilgileri` VALUES (1,'Sedat T├£RKKAN','Destek Hizmetleri M├╝d├╝rl├╝─ş├╝ personeli Ali T├╝rkkan\'─▒n Babas─▒ ','2024-12-21','21 Aral─▒k 2024','Destek Hizmetleri M├╝d├╝rl├╝─ş├╝ personeli Ali T├╝rkkan\'─▒n babas─▒ Sedat T├╝rkkan Vefat etmi┼ştir.Cenazesi Yar─▒n ├Â─şlen namaz─▒na m├╝teakip Gebze Kargal─▒ K├Ây├╝ Camii\'nden kald─▒r─▒lacakt─▒r. ─░rtibat: Ali T├╝rkkan 05312611643'),(2,'Emine AYDIN G├£L','Temizlik ─░┼şleri M├╝d├╝rl├╝─ş├╝ personeli Fahrettin Ayd─▒n\'─▒n karde┼şi','2024-12-21','21 Aral─▒k 2024','Temizlik ─░┼şleri M├╝d├╝rl├╝─ş├╝ personeli Fahrettin Ayd─▒n\'─▒n karde┼şi Emine Ayd─▒n G├╝l vefat etmi┼ştir.Cenazesi bug├╝n ├Â─şlen namaz─▒na m├╝teakip Dar─▒ca Fevzi ├çakmak Mahallesi Camii\'nden kald─▒r─▒lacakt─▒r. ─░rtibat:05356598417'),(3,'Cevat ALTINTA┼Ş Annesi','Tefti┼ş Kurulu M├╝d├╝r├╝ Cevat Alt─▒nta┼ş\'─▒n annesi','2024-12-21','21 Aral─▒k 2024','Tefti┼ş Kurulu M├╝d├╝r├╝ Cevat Alt─▒nta┼ş\'─▒n annesi vefat etmi┼ştir.Cenazesi yar─▒n ├Â─şlen namaz─▒na m├╝teakip Trabzon,S├╝rmene Petekli Mahallesi Camii\'nden kald─▒r─▒lacakt─▒r. ─░rtibat:05337219067'),(4,'Nevzat TA┼ŞKIN','K├╝lt├╝r Ve Sosyal ─░┼şler M├╝d├╝rl├╝─ş├╝ Personeli Engin Ta┼şk─▒n\'─▒n abisi','2024-01-15','15 Ocak 2024','K├╝lt├╝r Ve Sosyal ─░┼şler M├╝d├╝rl├╝─ş├╝ Personeli Engin Ta┼şk─▒n\'─▒n abisi Nevzat Ta┼şk─▒n vefat etmi┼ştir. Cenazesi bug├╝n ├Â─şlen namaz─▒na m├╝teakip memleketi Yalova\'dan kald─▒r─▒lcakt─▒r.─░rtibat: Engin Ta┼şk─▒n 05327823276'),(5,'Yavuz HORASAN Babas─▒','─░┼şletme ve ─░┼ştirakler M├╝d├╝rl├╝─ş├╝ Personeli Yavuz Horas─▒n\'─▒n babas─▒ ','2024-01-15','15 Ocak 2024','─░┼şletme ve ─░┼ştirakler M├╝d├╝rl├╝─ş├╝ Personeli Yavuz Horas─▒n\'─▒n babas─▒ vefat etmi┼ştir. Cenazesi bug├╝n ikindi namaz─▒na m├╝teakip Tokat Turhal\'dan kald─▒r─▒lcakt─▒r. ─░rtibat: Yavuz Horasan 05335423041'),(6,'Mehmet tevfik ┼ŞAH─░N','Destek Hizmetleri M├╝d├╝rl├╝─ş├╝ personeli Haluk ┼Şahin\'in abisi','2023-12-26','26 Aral─▒k 2023','Destek Hizmetleri M├╝d├╝rl├╝─ş├╝ personeli Haluk ┼Şahin\'in abisi Mehmet Te┼şvik ┼Şahin vefat etmi┼ştir. Cenazesi ├Â─şlen namaz─▒na m├╝teakip Eski┼şehir G├╝ny├╝z├╝\'nde kald─▒r─▒lacakt─▒r. ─░rtibat: Haluk ┼Şahin 05326311898'),(7,'Yusuf B─░TMEZ','Emekli Belediye Ba┼şkan Dan─▒┼şman─▒m─▒z ┼Şakir Bitmez\'in babas─▒','2023-12-25','25 Aral─▒k 2023','Emekli Belediye Ba┼şkan Dan─▒┼şman─▒m─▒z ┼Şakir Bitmez\'in babas─▒ Yusuf Bitmez vefat etmi┼ştir.Cenazesi bug├╝n ikindi namaz─▒na m├╝teakip Pendik Yayalar Mahallesi Mehmet Akif Ersoy Camii\'nden kald─▒r─▒lacakt─▒r.'),(8,'Erdo─şan POLAT','Park Ve Bah├ğeler M├╝d├╝rl├╝─ş├╝ Personeli Tar─▒k Polat\'─▒n amcas─▒','2023-12-20','20 Aral─▒k 2023','Park Ve Bah├ğeler M├╝d├╝rl├╝─ş├╝ Personeli Tar─▒k Polat\'─▒n amcas─▒ Erdo─şan Polat vefat etmi┼ştir.Cenazesi bug├╝n ikindi namaz─▒na m├╝teakip ├çay─▒rova Bedir Camii\'nden kald─▒r─▒lacakt─▒r. ─░rtibat: Tar─▒k Polat 05072524854'),(9,'Enver YAZICI\'NIN Kay─▒nvalidesi','K├╝lt├╝r M├╝d├╝rl├╝─ş├╝ Personeli Enver Yaz─▒c─▒\'n─▒n kay─▒nvalidesi','2023-12-20','20 Aral─▒k 2023','K├╝lt├╝r M├╝d├╝rl├╝─ş├╝ Personeli Enver Yaz─▒c─▒\'n─▒n kay─▒nvalidesi vefat etmi┼ştir. Cenazesi bug├╝n Cuma namaz─▒na m├╝teakip Eskihisar Ak┼şemseddin Camii\'nden kald─▒r─▒lacakt─▒r. ─░rtibat: Enver Yaz─▒c─▒ 05423454169'),(10,'Haf─▒z Bahattin Y─░─Ş─░T','G├╝venlik Personellerimiz Adnan Yi─şit ve Fuat Yi─şit\'in babas─▒','2023-12-15','15 Aral─▒k 2023','G├╝venlik Personellerimiz Adnan Yi─şit ve Fuat Yi─şit\'in babas─▒ Haf─▒z Bahattin Yi─şit vefat etmi┼ştir. Cenazesi Cumartesi ├Â─şlen namaz─▒na m├╝teakip H├╝rriyet Mahallesi Hz.Osman Camiin\'den kald─▒r─▒lacakt─▒r. ─░rtibat: Adnan Yi─şit 05333502447-Fuat Yi─şit 05421867958'),(11,'─░smail B─░NG├ûL Babas─▒','Temizlik ─░┼şleri M├╝d├╝rl├╝─ş├╝ Personeli ─░smail Bing├Âl\'├╝n babas─▒','2023-12-12','12 Aral─▒k 2023','Temizlik ─░┼şleri M├╝d├╝rl├╝─ş├╝ Personeli ─░smail Bing├Âl\'├╝n babas─▒ vefat etmi┼ştir. Cenazesi bug├╝n ├Â─şlen namaz─▒na m├╝teakip kald─▒r─▒lacakt─▒r. ─░rtibat: ─░smail Bing├Âl 05354091358'),(12,'Cengiz A─ŞA├£Z├£M','Belediyemizin Emekli Personeli Cengiz A─şa├╝z├╝m','2023-12-12','12 Aral─▒k 2023','Belediyemizin Emekli Personeli Cengiz A─şa├╝z├╝m vefat etmi┼ştir. Cenazesi bug├╝n ikindi namaz─▒na m├╝teakip Y─▒ld─▒z Camii\'nden kald─▒r─▒lacakt─▒r.─░rtibat: Engin A─şa├╝z├╝m 05343033746'),(13,'Nuray Dal','Et├╝t Proje M├╝d├╝rl├╝─ş├╝ Personeli G├╝nay ├çatak\'─▒n ablas─▒','2023-12-12','12 Aral─▒k 2023','Et├╝t Proje M├╝d├╝rl├╝─ş├╝ Personeli G├╝nay ├çatak\'─▒n ablas─▒ Nury Dal vefat etmi┼ştir. Cenazesi yar─▒n ├Â─şlen namaz─▒na m├╝teakip Ayd─▒n ─░li ├çine ─░l├ğesinden kald─▒r─▒lacakt─▒r.'),(14,'Ali Osman ─░┼Ş├ç─░','Emlak ve ─░stimlak M├╝d├╝rl├╝─ş├╝ Personeli Salih Kat─▒\'n─▒n Kay─▒npederi','2023-12-12','12 Aral─▒k 2023','Emlak ve ─░stimlak M├╝d├╝rl├╝─ş├╝ Personeli Salih Kat─▒\'n─▒n Kay─▒npederi Ali Osman ─░┼ş├ği vefat etmi┼ştir. Cenazesi bug├╝n ├Â─şle namaz─▒na m├╝teakip Dar─▒a Emek Mahallesi Merkez Camii\'nden kald─▒r─▒lacakt─▒r. ─░rtibat: Salih Kat─▒ 05327433232 '),(15,'Fikar KESK─░NO─ŞLU','Bas─▒n Yay─▒n Ve Halkla ─░li┼şkiler M├╝d├╝r├╝ Mecit Keskino─şlu\'nun Yengesi','2023-12-05','5 Aral─▒k 2023','Bas─▒n Yay─▒n Ve Halkla ─░li┼şkiler M├╝d├╝r├╝ Mecit Keskino─şlu\'nun Yengesi Fikar Keskino─şlu vefat etmi┼ştir. Cenazesi yar─▒n ├Â─şlen namaz─▒na m├╝teakip Nenehatun Mahallesi Ey├╝po─şlu Camii\'nden kald─▒r─▒lacakt─▒r. ─░rtibat: Mecit Keskino─şlu 05359431643'),(16,'Murat ├çOBAN\'─▒n Ablas─▒','Belediyemizin emekli personeli Murat ├çoban\'─▒n Ablas─▒','2023-11-29','29 Kas─▒m 2023','Belediyemizin emekli personeli Murat ├çoban\'─▒n ablas─▒ vefat etmi┼ştir. Cenazesi bug├╝n ├Â─şle namaz─▒na m├╝teakip Dar─▒ca\'dan kald─▒r─▒lacakt─▒r. ─░rtibat:'),(17,'Teyfik BAYRAM','Zab─▒ta M├╝d├╝rl├╝─ş├╝ G├╝venlik Personeli Olcay Bayram\'─▒n Babas─▒','2023-11-24','24 Kas─▒m 2023','Zab─▒ta M├╝d├╝rl├╝─ş├╝ G├╝venlik Personeli Olcay Bayram\'─▒n babas─▒ Teyfik Bayram vefat etmi┼ştir. Cenazesi bug├╝n ├Â─şle namaz─▒na m├╝takip memleketi Amasya\'dan kald─▒r─▒lcakt─▒r. ─░rtibat: Olcay Bayram 0546226207'),(18,'Ahmet KARDE┼Ş\'in Amcas─▒','Ruhsat M├╝d├╝rl├╝─ş├╝ Personeli Ahmet Karde┼ş\'in amcas─▒ ','2023-11-23','23 Kas─▒m 2023','Ruhsat M├╝d├╝rl├╝─ş├╝ Personeli Ahmet Karde┼ş\'in amcas─▒ vefat etmi┼ştir. Cenazesi bug├╝n ├Â─şle namaz─▒na m├╝teakip Yenimahalle Merkez Camii\'nden kald─▒r─▒lacakt─▒r. ─░rtibat: Ahmet Karde┼ş 05370308461'),(19,'Ramazan ZOR\'un Halas─▒','Bas─▒n Yay─▒n Halkla ─░li┼şkiler M├╝d├╝rl├╝─ş├╝ Personeli Ramazan Zor\'un Halas─▒','2023-11-13','13 Kas─▒m 2023','Ba─▒n Yay─▒n Halkla ─░li┼şkiler M├╝d├╝rl├╝─ş├╝ Personeli Ramazan Zor\'un halas─▒ vefat etmi┼ştir. Cenazesi yar─▒n ├Â─şlen namaz─▒na m├╝teakip ─░lyasbey Camii\'nden kald─▒r─▒lacakt─▒r. ─░rtibat: Ramazan Zor 05333360656'),(20,'Davut ┼Şahin','Et├╝t Proje M├╝d├╝rl├╝─ş├╝ Personeli ├ûmer ┼Şahin\'in Amcas─▒','2023-11-06','6 Kas─▒m 2023','Et├╝t Proje M├╝d├╝rl├╝─ş├╝ Personeli ├ûmer ┼Şahin\'in amcas─▒ Davut ┼Şahin vefat etmi┼ştir. Cenazesi bug├╝n ├Â─şle namaz─▒na m├╝teakip ─░stanbul R├╝zgarl─▒ Bah├ğe Camii\'nden kald─▒r─▒lacakt─▒r. ─░rtibat ├ûmer ┼Şahin 05387303472 '),(21,'Remzi DURAN',' Destek Hizmetleri Personeli Tenzile Deniz\'in Babas─▒','2023-11-06','6 Kas─▒m 2023','Destek Hizmetleri Personeli Tenzile Deniz\'in babas─▒ Remzi Duran vefat etmi┼ştir. Cenazesi bug├╝n ├û─şlen namaz─▒na m├╝teakip Elbizli Mahallesinde kald─▒r─▒lacakt─▒r.─░rtibat: Tenzile Deniz 05454151007'),(22,'─░smet YILMAZ','Destek Hizmetleri Personeli ─░lker Y─▒lmaz\'─▒n Babas─▒','2023-11-06','6 Kas─▒m 2023','Destek Hizmetleri Personeli ─░lker Y─▒lmaz\'─▒n babas─▒ ─░smet Y─▒lmaz vefat etmi┼ştir.Cenazesi yar─▒n ├Â─şle namaz─▒na m├╝teakip Beylikba─ş─▒ Fatih Camii\'nden kald─▒r─▒lacakt─▒r. ─░rtibat: ─░lker YILMAZ 05438092966'),(23,'Erdal G├£NEY\'─▒n Kay─▒nbiraderi','Temizlik ─░┼şleri Personeli Naz─▒m Ert├╝rk\'├╝n abisi Erdal G├╝ney\'─▒n Kay─▒nbiraderi','2023-11-06','6 Kas─▒m 2023','Temizlik ─░┼şleri Personeli Naz─▒m Ert├╝rk\'├╝n abisi Erdal G├╝ney\'─▒n kay─▒nbiraderi vefat etmi┼ştir. Cenazesi bug├╝n ├Â─şlen namaz─▒ndan sonra H├╝rriyet Mahallesi Hz.Ali Camii\'nden kald─▒r─▒lacakt─▒r.─░rtibat: Naz─▒m Ert├╝rk 05362215339-ErdalG├╝zey 05343572975'),(24,'Elmas ARSLAN','Veteriner ─░┼şleri M├╝d├╝rl├╝─ş├╝ Personeli Bar─▒┼ş Arslan\'─▒n annesi','2023-11-06','6 Kas─▒m 2023','Belediyemiz Veteriner ─░┼şleri M├╝d├╝rl├╝─ş├╝ Personeli Bar─▒┼ş Arslan\'─▒n annesi Elmas Arslan vefat etmi┼ştir. Cenazesi memleketi Giresun\'dan kald─▒r─▒lacakt─▒r. ─░rtibat: Bar─▒┼ş Arslan 05333969761'),(25,'Fuat CAN','├ûzel Kalem M├╝d├╝rl├╝─ş├╝ Personeli Filiz Can\'─▒n E┼şi','2023-11-26','26 Kas─▒m 2023','Belediyemiz ├ûzel KALEM M├╝d├╝rl├╝─ş├╝ personeli Filiz Can\'─▒n e┼şi Fuat Can vefat etmi┼ştir. Cenazesi yar─▒n ├Â─şlen namaz─▒na m├╝teakip Nur Osmaniye Camii\'nden kald─▒r─▒lacakt─▒r. ─░rtibat: Eren Can 05523429125'),(26,'Ay┼şe VAROL',' Belediyemizin Emekli Personeli ─░hsan Varol\'un e┼şi','2023-11-26','26 Kas─▒m 2023','Belediyemizin emekli personeli ─░hsan Varol\'un e┼şi Ay┼şe Varol vefat etmi┼ştir. Cenazesi ikindi namaz─▒na m├╝teakip Yavuz Selim Mahallesi Ulu Camii\'nden kald─▒r─▒lacakt─▒r. ─░rtibat: ─░hsan Varol 05453676219'),(27,'Saadettin G├╝rkan\'─▒n Kay─▒npederi','K├╝lt├╝r M├╝d├╝rl├╝─ş├╝ Personeli Saadettin G├╝rkan\'─▒n Kay─▒npederi','2023-11-26','26 Kas─▒m 2023','Belediyemizin K├╝lt├╝r M├╝d├╝rl├╝─ş├╝ Personeli Saadettin G├£RKAN\'─▒n kay─▒npederi vefat etmi┼ştir. Cenazesi memleketi Ordu\'da defnedilcektir. ─░rtibat: Saadettin G├╝rkan 05427181294'),(28,'Tuncay KUYUCU\'nun Babas─▒','Emlak ─░stimlak M├╝d├╝rl├╝─ş├╝ Personeli Tuncay Kuyucu\'nun babas─▒','2023-11-16','16 Kas─▒m 2023','Belediyemiz Emlak ─░stimlak M├╝d├╝rl├╝─ş├╝ personelimiz Tuncay Kuyucu\'nun babas─▒ vefat etmi┼ştir. Cenaze pazar g├╝n├╝ ├Â─şlen namaz─▒na m├╝teakip Mudarl─▒ k├Ây├╝nde defnedilmi┼ştir. ─░rtibat: Tuncay Kuyucu 05363270149'),(29,'Metin Ve Murat ├ç─░MEN\'in babaannesi','Fen i┼şleri Personelimiz Metin ve Murat ├çimen\'in Babaannesi ','2023-11-16','16 Kas─▒m 2023','Emekli Fen ─░┼şleri personelimiz ─░smail ├ç─░MEN\'in annesi,Fen i┼şleri Personelimiz Metin ve Murat ├çimen\'in babaannesi vefat etmi┼ştir.Cenazesi bug├╝n ikindi namaz─▒na m├╝teakip Bar─▒┼ş Mahallesi Merkez Camii\'nden kald─▒r─▒lacakt─▒r. ─░rtibat: ─░smail ├çimen 05358250415 Metin ├çimen 05378878231'),(30,'Hasan ALTINPARMAK\'─▒n Babas─▒','Temizlik ─░┼şleri M├╝d├╝rl├╝─ş├╝ Personeli Hasan Alt─▒nparmak\'─▒n Babas─▒','2023-11-16','16 Kas─▒m 2023','Temizlik ─░┼şleri M├╝d├╝rl├╝─ş├╝ Personeli Hasan Alt─▒nparmak\'─▒n babas─▒ vefat etmi┼ştir.Cenazesi bug├╝n ikindi namaz─▒na m├╝teakip ├çay─▒rova Mand─▒ra(Mescid-i Aksa)Camii-\'nden kald─▒r─▒lacakt─▒r. ─░rtibat: Hasan Alt─▒nparmak 05310132598'),(31,'Nam─▒k Demir\'in Babas─▒','Bilgi ─░┼şlem M├╝d├╝rl├╝─ş├╝ Personeli Nam─▒k Demir\'in Babas─▒','2023-09-07','7 Eyl├╝l 2023','Belediyemiz Bilgi ─░┼şlem M├╝d├╝rl├╝─ş├╝ Personeli Nam─▒k Demir\'in babas─▒ vefat etmi┼ştir. Cenazesi bug├╝n ├Â─şle namaz─▒na m├╝teakip memleketi Erzurum\'dan kald─▒r─▒lacakt─▒r. ─░rtibat: Nam─▒k Demir 05063654125');
/*!40000 ALTER TABLE `vefat_bilgileri` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `videolar`
--

DROP TABLE IF EXISTS `videolar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `videolar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `youtube_id` varchar(50) NOT NULL,
  `baslik` varchar(255) NOT NULL,
  `aciklama` text NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `sure` varchar(20) NOT NULL,
  `vitrin_baslik` varchar(255) DEFAULT NULL,
  `vitrin_aciklama` text DEFAULT NULL,
  `vitrin` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_videolar_youtube_id` (`youtube_id`),
  KEY `idx_videolar_kategori` (`kategori`),
  KEY `idx_videolar_vitrin` (`vitrin`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `videolar`
--

LOCK TABLES `videolar` WRITE;
/*!40000 ALTER TABLE `videolar` DISABLE KEYS */;
INSERT INTO `videolar` VALUES (1,'qLqYPQgUPEc','Gebze Offroad Heyecan?','Nefes kesen anlar ve ?amurlu yollar... Offroad tutkunlar? bu etkinlikte bulu?tu.','etkinlikler','15:22',NULL,NULL,0),(2,'aUQ3uIAfL-k','Geleneksel A?ure G?n?','A?ure g?n?nde personelimizle bir araya geldik.','etkinlikler','04:20',NULL,NULL,0),(3,'RhVDYrAb0xQ','Yang?n Tatbikat? E?itimi','Acil durumlara haz?rl?k kapsam?nda d?zenlenen e?itim videosu.','egitimler','18:55',NULL,NULL,0),(4,'c0vbYSFwMzU','?? Elbiseleri Da??t?m?','Yeni d?nem i? elbiselerinin da??t?m?yla ilgili duyuru.','duyurular','01:45',NULL,NULL,0),(5,'-0Wxna6PjqQ','Sokak Hayvanlar? Besleme Etkinli?i','Patili dostlar?m?z? unutmad?k, onlarla bir g?n ge?irdik.','etkinlikler','06:33',NULL,NULL,1),(6,'e65zC48s8Wc','Stresle Ba?a ??kma Y?ntemleri','?? hayat?nda stresi y?netmek i?in pratik bilgiler.','egitimler','41:12',NULL,NULL,0),(7,'YXat3fIWc7w','Kantin Fiyat D?zenlemesi','Yemekhane ve kantin fiyatlar? hakk?ndaki yeni d?zenleme.','duyurular','01:10',NULL,NULL,0),(8,'QRizu8RhGnU','Fidan Dikme Etkinli?i','Daha ye?il bir Gebze i?in personelimizle birlikte fidan diktik.','etkinlikler','09:45',NULL,NULL,0),(9,'Z2dH2UIXb8Y','Ki?isel Verilerin Korunmas? (KVKK)','KVKK kanunu kapsam?nda personelimiz i?in zorunlu e?itim.','egitimler','38:00',NULL,NULL,0),(10,'G2KNC3OAnjE','Y?ll?k ?zin Kullan?m? Hakk?nda','?nsan kaynaklar?ndan izin kullan?m? ile ilgili ?nemli duyuru.','duyurular','02:55',NULL,NULL,0),(11,'RhD1ArYsuKo','Huzurevi Ziyareti','Sosyal sorumluluk projemiz kapsam?nda ger?ekle?tirdi?imiz ziyaret.','etkinlikler','07:25',NULL,NULL,0),(12,'IEc5W0JyADU','Zaman Y?netimi ve Verimlilik','Daha verimli ?al??man?n ipu?lar? bu e?itimde.','egitimler','28:30',NULL,NULL,0),(13,'3ePuzpC2S0Q','Yeni Servis G?zergahlar? Hk.','Personel servis g?zergahlar?ndaki de?i?iklikler hakk?nda duyuru.','duyurular','04:18',NULL,NULL,0),(14,'qdPXmtKXXc4','Spor Turnuvas? Kura ?ekimi','Birimler aras? spor turnuvas? i?in kura ?ekimi heyecan?.','etkinlikler','12:50',NULL,NULL,0),(15,'uUFZvM9kqf4','Temel Ofis Programlar? E?itimi','Word, Excel ve PowerPoint kullan?m? ?zerine temel e?itim serisi.','egitimler','55:20',NULL,NULL,0),(16,'BiY2WK24UHY','Maa? Avans? Kullan?m Bilgilendirmesi','?nsan kaynaklar?ndan personelimize duyuru.','duyurular','03:05',NULL,NULL,0),(17,'xot-DBvkkq4','Gebze Kitap Fuar? Ba?lad?','Belediyemizin d?zenledi?i kitap fuar?ndan ilk g?r?nt?ler.','etkinlikler','08:12',NULL,NULL,0),(18,'ABIqjRnV5dU','Etkili ?leti?im Teknikleri Semineri','Kurum i?i ileti?imimizi g??lendirmek i?in d?zenlenen e?itim.','egitimler','33:40',NULL,NULL,0),(19,'psmlNSPRDsM','?nemli Sistem G?ncellemesi','Bilgi ??lem Daire Ba?kanl???ndan ?nemli duyuru.','duyurular','02.15',NULL,NULL,0),(20,'pAHStsCd9jo','Belediye Pikni?i 2025','Ge?ti?imiz hafta sonu d?zenledi?imiz personel pikni?inden renkli anlar.','etkinlikler','05:48',NULL,NULL,0),(21,'eUBQYWMZyH8','Bayramla?ma T?reni Duyurusu ','Geleneksel bayramla?ma t?renimiz hakk?nda bilgilendirme. T?m personelimiz davetlidir. ','duyurular','01.30',NULL,NULL,0),(22,'GWfDmGr6tlg','Yeni Personel ??in ?SG E?itimi','?? sa?l??? ve g?venli?i temelleri, t?m yeni personelimiz i?in ?nemli bir ba?lang??.','egitimler','45:10',NULL,NULL,0),(23,'D1b-CZYtCTg','Portal Kullan?m K?lavuzu','Personel portal?n?n nas?l daha etkin kullan?laca??na dair video.','duyurular','11:30',NULL,NULL,0);
/*!40000 ALTER TABLE `videolar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yardimci_linkler`
--

DROP TABLE IF EXISTS `yardimci_linkler`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yardimci_linkler` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `baslik` varchar(255) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `logo_url` varchar(255) DEFAULT NULL,
  `hedef_url` varchar(500) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_yardimci_linkler_kat_baslik_url` (`kategori`,`baslik`,`hedef_url`) USING HASH
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yardimci_linkler`
--

LOCK TABLES `yardimci_linkler` WRITE;
/*!40000 ALTER TABLE `yardimci_linkler` DISABLE KEYS */;
INSERT INTO `yardimci_linkler` VALUES (1,'OMIS','kurum-ici','../images/otomasyon/omis_7572.png','https://ebelediye.gebze.bel.tr/eBelediye/'),(2,'Ulakbel','kurum-ici','../images/otomasyon/ulakbel_5496.png','https://ulakbel.gebze.bel.tr/ulakbel#/'),(3,'─░mar Y├Ânetim Sistemi','kurum-ici','../images/otomasyon/imar-yonetim-sistemi_8038.png','https://www.gebze.bel.tr/ebelediye/'),(4,'Dijital Ar┼şiv','kurum-ici','../images/otomasyon/dijital-arsiv_415.png','https://www.gebze.bel.tr/'),(5,'Outlook','kurum-ici','../images/otomasyon/outlook_4005.png','https://outlook.live.com/'),(6,'Sosyal Yard─▒m','kurum-ici','../images/otomasyon/sosyal-yardim_3767.png','https://www.turkiye.gov.tr/ashb-sosyal-yardim-bilgileri-sorgulama'),(7,'Netcad','kurum-ici','../images/otomasyon/netcad_3888.png','https://www.netcad.com/'),(8,'E-Belediye Sistemi','kurum-ici','../images/otomasyon/ebys_8493.png','https://www.belediye.gov.tr/'),(9,'E-Belediye Evlendrme Mod├╝l├╝','kurum-ici','../images/otomasyon/e-belediye-evlendirme-modulu_3993.png','https://www.belediye.gov.tr/evlendirme-modulu'),(10,'E-Belediye Sosyal Yard─▒m Mod├╝l├╝','kurum-ici','../images/otomasyon/e-belediye-sosyal-yard-m-modulu_4432.png','https://www.belediye.gov.tr/sosyal-yardim-takip-sistemi-syts-modulu'),(11,'Gebze Belediyesi','website','../images/yardimci_linkler/web_siteleri/gebze-belediyesi.png','https://www.gebze.bel.tr/'),(12,'Kocaeli B├╝y├╝k┼şehir Belediyesi','website','../images/yardimci_linkler/web_siteleri/kocaeli-buyuksehir-belediyesi.png','https://www.kocaeli.bel.tr/'),(13,'Kocaeli Valili─şi','website','../images/yardimci_linkler/web_siteleri/kocaeli-vali.jpg','http://www.kocaeli.gov.tr/'),(14,'Gebze Kaymakaml─▒─ş─▒','website','../images/yardimci_linkler/web_siteleri/gebze-kaymakam.png','http://www.gebze.gov.tr/'),(15,'T├╝rkiye Belediyeler Birli─şi','bilgi','../images/yardimci_linkler/bilgi_portallari/turkiye-belediyeler-birligi_2430.png','https://www.tbb.gov.tr/tr'),(16,'Cumhurba┼şkanl─▒─ş─▒ Uzaktan E─şitim Kap─▒s─▒','bilgi','../images/yardimci_linkler/bilgi_portallari/cumhur.jpg','https://uzaktanegitimkapisi.cbiko.gov.tr/Giris'),(17,'BTK Akademi E─şitim Portal─▒','bilgi','../images/yardimci_linkler/bilgi_portallari/btk-akademi.jpg','https://www.btkakademi.gov.tr/'),(18,'Memurlar.Net','faydal─▒','../images/yardimci_linkler/faydali_linkler/memurlar.png','https://www.memurlar.net/'),(19,'─░lan','faydal─▒','../images/yardimci_linkler/faydali_linkler/ilan.png','https://www.ilan.gov.tr/'),(20,'Resmi Gazete','faydal─▒','../images/yardimci_linkler/faydali_linkler/resmi.png','https://www.resmigazete.gov.tr/');
/*!40000 ALTER TABLE `yardimci_linkler` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'personel_db'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-07-08 14:14:13
