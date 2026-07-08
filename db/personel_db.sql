<<<<<<< HEAD
﻿-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: personel_db
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB
=======
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 03 Tem 2026, 14:07:20
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

>>>>>>> 112b37f5f7eedd448db79abf5191316023500533

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
<<<<<<< HEAD
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
=======

--
-- Veritabanı: `personel_db`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `anasayfa_duyurular`
--

CREATE TABLE `anasayfa_duyurular` (
  `id` int(11) NOT NULL,
  `baslik` varchar(255) NOT NULL,
  `aciklama` text NOT NULL,
  `resim` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `anasayfa_duyurular`
--

INSERT INTO `anasayfa_duyurular` (`id`, `baslik`, `aciklama`, `resim`) VALUES
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
-- Tablo için tablo yapısı `anketler`
--

CREATE TABLE `anketler` (
  `id` int(11) NOT NULL,
>>>>>>> 112b37f5f7eedd448db79abf5191316023500533
  `baslik` varchar(255) NOT NULL,
  `aciklama` text DEFAULT NULL,
  `kategori` varchar(50) NOT NULL,
  `resim_url` varchar(500) DEFAULT NULL,
  `baslangic_tarihi` date DEFAULT NULL,
  `bitis_tarihi` date DEFAULT NULL,
  `katilim_sayisi` int(11) DEFAULT 0,
  `hedef_katilim` int(11) DEFAULT 0,
<<<<<<< HEAD
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
=======
  `favori` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `anketler`
--

INSERT INTO `anketler` (`id`, `baslik`, `aciklama`, `kategori`, `resim_url`, `baslangic_tarihi`, `bitis_tarihi`, `katilim_sayisi`, `hedef_katilim`, `favori`) VALUES
(1, 'Personel Memnuniyet Anketi 2024', 'Görev yapan personele yönelik genel değerlendirme formu. İş memnuniyeti ve çalışma koşulları değerlendirmesi.', 'active', 'https://img.freepik.com/free-photo/business-graphs-charts-tablet_23-2147819730.jpg', '2024-10-09', '2024-11-15', 45, 120, 1),
(2, 'Eğitim İhtiyaç Analizi', 'Personel gelişimi için gerekli eğitim alanlarının belirlenmesi amacıyla hazırlanan değerlendirme anketi.', 'completed', 'https://img.freepik.com/free-photo/education-concept-with-graduation-cap-books_23-2147819868.jpg', '2024-09-01', '2024-09-30', 98, 120, 0),
(3, 'İş Ortamı Değerlendirme', 'Çalışma ortamı, ekipman yeterliliği ve fiziksel koşulların değerlendirilmesi anketi.', 'expired', 'https://img.freepik.com/free-photo/workplace-productivity-concept_23-2147819745.jpg', '2024-08-15', '2024-09-15', 67, 120, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `dokumanlar`
--

CREATE TABLE `dokumanlar` (
  `id` int(11) NOT NULL,
>>>>>>> 112b37f5f7eedd448db79abf5191316023500533
  `sayfa_tipi` varchar(50) NOT NULL,
  `baslik` varchar(255) NOT NULL,
  `aciklama` text DEFAULT NULL,
  `kategori_adi` varchar(150) DEFAULT NULL,
  `alt_tip` varchar(50) DEFAULT NULL,
  `resim_url` varchar(255) DEFAULT NULL,
  `dosya_url` varchar(500) DEFAULT NULL,
  `video_url` varchar(500) DEFAULT NULL,
<<<<<<< HEAD
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
=======
  `tarih` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `dokumanlar`
--

INSERT INTO `dokumanlar` (`id`, `sayfa_tipi`, `baslik`, `aciklama`, `kategori_adi`, `alt_tip`, `resim_url`, `dosya_url`, `video_url`, `tarih`) VALUES
(1, 'duyuru', 'DİL EĞİTİM MODELLERİNDE GEÇERLİ %50 İNDİRİM!', 'KURUMUMUZ PERSONELİ VE 1. DERECE YAKINLARINA ÖZEL AMERICAN VIP DİL OKULLARINDA GEÇERLİ %50 İNİDİRİM ANLAŞMASI İMZALANDI.', 'İnsan Kaynakları', 'insan', '../images/d-l-e-t-m-modeller-nde-gecerl-50-nd-r-m_4469.jpg', NULL, NULL, '2023-10-04'),
(2, 'duyuru', 'Gebze\'de Zabıta Haftası Kutlandı', 'Gebze Belediye Başkanı Zinnur Büyükgöz, her yıl 1-7 Eylül tarihleri arasında kutlanan Zabıta Haftası münasebetiyle zabıta personelleriyle bir araya geldi.', 'İnsan Kaynakları', 'insan', '../images/gebze-de-zab-ta-haftas-kutland_5157 (1).jpg', NULL, NULL, '2023-10-04'),
(3, 'duyuru', 'GEBZE\'DE EK ZAM PROTOKOLÜ İMZALANDI', 'Gebze Belediyesi, bünyesinde görev yapan tüm işçilerin maaşlarına %20 zam müjdesini verdi. Ek zam protokolü Gebze Belediye Başkanı Zinnur BÜYÜKGÖZ ve Hizmet-İş ve Özgüven-Sen Sendikası yetkilileri arasında imzalandı.', 'İnsan Kaynakları', 'insan', '../images/gebze-de-ek-zam-protokolu-mzalandi_4681.jpg', NULL, NULL, '2023-10-04'),
(4, 'duyuru', 'Gebze\'nin Filosu Büyüyor;', 'Gebze\'nin mahallelerine daha kaliteli hizmet verebilmek adına makine ve araç filosuna yeni takviyeler yapılmasını sağlayan Gebze Belediye Başkanı Zinnur Büyükgöz, belediyenin öz kaynaklarıyla satın alınan 100 yeni aracı filoya kazandırdı.', 'İnsan Kaynakları', 'insan', '../images/gebze-nin-filosu-buyuyor_2355.jpg', NULL, NULL, '2023-10-04'),
(5, 'duyuru', 'Daha Sağlıklı Personel İçin', 'Gebze Belediyesi bünyesinde görev yapan tüm personellerimiz ve 1. derece yakınları (anne, baba, eş ve çocuk ) anlaşmalı sağlık kurumlarında indirimli fiyatlardan faydalanabilme olanağına sahip olacaklardır.', 'İnsan Kaynakları', 'insan', '../images/daha-saazlikli-ba-r-personel-a-a-a-n_7523.jpg', NULL, NULL, '2023-10-04'),
(6, 'duyuru', 'Parola Güvenlik Politika Geçişi', 'T.C. Cumhurbaşkanlığı Dijital Dönüşüm Ofisi Başkanlığı koordinasyonunda başlatılan \"Bilgi ve İletişim Güvenliği Rehberi\" uyum süreci doğrultusunda gerçekleştireceğimiz \"Güvenli Parola Politikası\" geçişi kapsamında, bilgisayar oturumu açma parolaları değişecektir.', 'Bilgi İşlem', 'bilgi', '../images/parola-guvenlik-politikasi-duyurusu_2090.jpg', NULL, NULL, '2023-10-04'),
(7, 'dokuman', 'Aile Bildirim Formu', 'Personelin medeni durumu, eş, çocuk ve bakmakla yükümlü olduğu aile bireylerine ilişkin bilgileri bildirmek veya güncellemek amacıyla kullanılan resmi form.', 'Dökümanlar', 'document', '', '../images/dokumanlar/a-le-durum-b-ld-r-r-formu_7664 (1).xlsx', NULL, '2023-10-04'),
(8, 'dokuman', 'Mal Bildirim Formu', 'Kamu görevlilerinin kendileri, eşleri ve velayetleri altındaki çocuklarına ait taşınır ve taşınmaz mallar ile diğer mal varlığı unsurlarını 3628 sayılı Kanun gereğince beyan etmek amacıyla kullanılan form.', 'Dökümanlar', 'document', '', '../images/dokumanlar/mal-b-ld-r-m-formu_501.doc', NULL, '2025-01-08'),
(9, 'dokuman', 'Personel İlişki Kesme Formu', 'Kurumdan ayrılan personelin zimmetli eşyalarının teslimi ve ilgili birimlerle ilişiğinin resmi olarak kesilmesi amacıyla kullanılan form.', 'Dökümanlar', 'document', '', '../images/dokumanlar/personel-l-k-kesme-formu_9657.docx', NULL, '2024-12-20'),
(10, 'mevzuat', 'Resmi Yazışma Kuralları', 'Kamu kurum ve kuruluşlarında kullanılması esas ve her kamu görevlisi tarafından bilinmesi gereken resmi yazışmalar hakkında mevzuat hükümleri.', 'Genel Mevzuatlar', 'genel', '', '#', NULL, '2023-10-04'),
(11, 'mevzuat', 'Kamu İhale Sözleşmeleri Kanunu', 'Kanun Numarası : 4735 Kabul Tarihi : 5/1/2002 Yayımlandığı Resmî Gazete : Tarih : 22/1/2002 Sayı : 24648 Yayımlandığı Düstur : Tertip : 5 Cilt : 42', 'Genel Mevzuatlar', 'genel', '', '#', NULL, '2023-10-04'),
(12, 'mevzuat', 'İmar Kanunu', 'Kanun Numarası : 3194 Kabul Tarihi : 3/5/1985 Yayımlandığı R. Gazete : Tarih :9/5/1985 Sayı: 18749 Yayımlandığı Düstur : Tertip : 5 Cilt : 24 Sayfa : 378', 'Genel Mevzuatlar', 'genel', '', '#', NULL, '2023-10-04'),
(13, 'mevzuat', 'Kişisel Verilerin Korunması Kanunu', 'Kanun Numarası : 6698 Kabul Tarihi : 24/3/2016 Yayımlandığı Resmî Gazete : Tarih : 7/4/2016 Sayı : 29677 Yayımlandığı Düstur : Tertip : 5 Cilt : 57', 'Genel Mevzuatlar', 'genel', '', '#', NULL, '2023-10-04'),
(14, 'mevzuat', 'Devlet Memurları Kanunu', 'Kanun Numarası : 657 Kabul Tarihi : 14/7/1965 Yayımlandığı Resmî Gazete : Tarih : 23/7/1965 Sayı : 12056 Yayımlandığı Düstur : Tertip : 5 Cilt : 4 Sayfa : 3044', 'Memur Mevzuatları', 'memur', '', '#', NULL, '2023-10-04'),
(15, 'mevzuat', 'Devlet Memurlarına Verilecek Hastalık Raporları ile Hastalık ve Refakat İznine\n İlişkin Usul ve Esaslar Hakkında Yönetmenlik', 'Bakanlar Kurulu Kararının Tarihi : 22/8/2011 No : 2011/2226 Dayandığı Kanunun Tarihi : 14/7/1965 No : 657 Yayımlandığı R.Gazetenin Tarihi : 29/10/2011 No : 28099 Yayımlandığı Düsturun Tertibi : 5 Cilt : 51', 'Memur Mevzuatları', 'memur', '', '#', NULL, '2023-10-04'),
(16, 'mevzuat', 'Memurlar ve Diğer Kamu Görevlilerinin Yargılanması Hakkında Kanun', 'Kanun Numarası : 4483 Kabul Tarihi : 2/12/1999 Yayımlandığı Resmî Gazete : Tarih : 4/12/1999 Sayı : 23896 Yayımlandığı Düstur : Tertip : 5 Cilt : 39', 'Memur Mevzuatları', 'memur', '', '#', NULL, '2023-10-04'),
(17, 'mevzuat', 'Mahalli İdareler Disiplin Amirleri Yönetmenliği', 'MAHALLİ İDARELER DİSİPLİN AMİRLERİ YÖNETMELİĞİ', 'Memur Mevzuatları', 'memur', '', '#', NULL, '2023-10-04'),
(18, 'mevzuat', 'Sözleşmeli Personel Çalıştırılmasına İlişkin Esaslar', 'Bakanlar Kurulu Kararının; Tarihi ve No\'su : 6/6/1978-7/15754 Dayandığı Kanun : 28/2/1978-2143 Yayımlandığı Resmi Gazete : 28/6/1978-16330 9/5/2020 tarihli ve 31122 sayılı Resmî Gazete\'de yayımlanan 8/5/2020 tarihli ve 2506 sayılı Cumhurbaşkanı Kararı uyarınca bu Yönetmelik Cumhurbaşkanlığı Yönetmeliği bölümüne eklenmiştir.', 'Sözleşmeli Mevzuatlar', 'sozlesmeli', '', '#', NULL, '2023-10-04'),
(19, 'mevzuat', 'Sözleşmeli Personele Ek Ödeme Yapılmasına Dair Karar', 'Bakanlar Kurulu Kararının Tarihi: 3/1/2012 Sayısı: 2012/2665 Yayımlandığı Resmi Gazete Tarihi:10/1/2012 Sayısı: 28169', 'Sözleşmeli Mevzuatlar', 'sozlesmeli', '', '#', NULL, '2023-10-04'),
(20, 'mevzuat', 'İş Kanunu', 'Kanun Numarası : 4857 Kabul Tarihi : 22/5/2003 Yayımlandığı Resmî Gazete : Tarih : 10/6/2003 Sayı : 25134 Yayımlandığı Düstur : Tertip : 5 Cilt : 42', 'İşçi Mevzuatları', 'isci', '', '#', NULL, '2023-10-04'),
(21, 'egitim', 'Yaşam Enerjisini Yükseltme Yolları', 'Yaşam Enerjisini Yükseltme Yolları', 'Eğitimler', 'training', '', NULL, NULL, '2023-10-04'),
(22, 'egitim', 'Belediye Şirketleri', 'Belediye Şirketleri', 'Eğitimler', 'training', '', NULL, NULL, '2024-12-20'),
(23, 'egitim', 'Belediyelerin Sosyal Yardım ve Hizmetleri', 'Belediyelerin Sosyal Yardım ve Hizmetleri', 'Eğitimler', 'training', '', NULL, NULL, '2024-12-20'),
(24, 'egitim', 'Bilgi Edinme Hakkı', 'Bilgi Edinme Hakkı', 'Eğitimler', 'training', '', NULL, NULL, '2024-12-20'),
(25, 'egitim', 'Kırsal Mahalle ve Kırsal Yerleşik Alan Yönetmeliği', 'Kırsal Mahalle ve Kırsal Yerleşik Alan Yönetmeliği', 'Eğitimler', 'training', '', NULL, NULL, '2024-12-20'),
(26, 'egitim', 'Kamulaştırma', 'Kamulaştırma', 'Eğitimler', 'training', '', NULL, NULL, '2024-12-20'),
(27, 'egitim', 'Yeni Zabıta Yönetmeliği', 'Yeni Zabıta Yönetmeliği', 'Eğitimler', 'training', '', NULL, NULL, '2024-12-20'),
(28, 'protokol', 'Gebze Merkez Prime Hastanesi', 'Gebze Merkez Prime Hastanesi İle Gebze Belediyesi Personelleri Ve Birinci Derece Yakınlarına Yönelik % 20 Oranında İndirim Anlaşması İmzalanmıştır.', 'Protokoller', 'protocol', '', NULL, NULL, '2023-10-04'),
(29, 'protokol', 'Darıca Hospitalpark Hastanesi', 'Darıca Hospıtalpark Hastanesi İle Gebze Belediyesi Personelleri Ve Birinci Derece Yakınlarına Yönelik % 30 Oranında İndirim Anlaşması İmzalanmıştır.', 'Protokoller', 'protocol', '', NULL, NULL, '2023-10-04'),
(30, 'protokol', 'Özel Ülker Ağız ve Diş Sağlığı Polikliniği', 'Personellerimizin ve 1. derece yakınlarının (anne, baba, eş ve çocuklar) diş sağlığına katkıda bulunmak adına çevre Polikliniklerimizle muayene, tetkik ve tedavilerde indirim anlaşmaları imzalanmıştır.', 'Protokoller', 'protocol', '', NULL, NULL, '2023-10-04'),
(31, 'protokol', 'Özel Dentriva Ağız ve Diş Sağlığı Polikliniği', 'Personellerimizin ve 1. derece yakınlarının (anne, baba, eş ve çocuklar) diş sağlığına katkıda bulunmak adına çevre Polikliniklerimizle muayene, tetkik ve tedavilerde indirim anlaşmaları imzalanmıştır.', 'Protokoller', 'protocol', '', NULL, NULL, '2023-10-04'),
(32, 'protokol', 'Özel Arapçeşme Ağız ve Diş Sağlığı Polikliniği', 'Personellerimizin ve 1. derece yakınlarının (anne, baba, eş ve çocuklar) diş sağlığına katkıda bulunmak adına çevre Polikliniklerimizle muayene, tetkik ve tedavilerde indirim anlaşmaları imzalanmıştır.', 'Protokoller', 'protocol', '', NULL, NULL, '2023-10-04'),
(33, 'protokol', 'Şimşekdent Ağız ve Diş Sağlığı Polikliniği', 'Personellerimizin ve 1. derece yakınlarının (anne, baba, eş ve çocuklar) diş sağlığına katkıda bulunmak adına çevre Polikliniklerimizle muayene, tetkik ve tedavilerde indirim anlaşmaları imzalanmıştır.', 'Protokoller', 'protocol', '', NULL, NULL, '2023-10-04');

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
(10, '3 Aralık Dünya Engelliler Günü Personel Etkinliği', 'Personelimize yönelik dijital dönüşüm ve teknoloji kullanımı eğitimi başarıyla tamamlandı...', '2023-12-03', '2023-12-03', 312, 'pasif', '../images/3-aralik-dunya-engell-ler-gunu-personel-yeme_9554.jpg'),
(11, 'Stajyer Öğrenci Oryantasyonu ', 'Şehir merkezindeki altyapı geliştirme ve modernizasyon çalışmaları hızla devam ediyor...', '2025-11-29', '2025-12-15', 423, 'pasif', '../images/stajyer-o-renci-oryantasyonu_2177.jpg'),
(12, '24 Kasım Öğretmenler Günü Etkinliği', 'Sokak hayvanlarının sağlık kontrolü ve bakım programı kapsamında çalışmalar sürdürülüyor...', '2023-11-24', '2023-11-24', 186, 'pasif', '../images/24-kas-m-o-retmenler-gunu_2947.jpg'),
(13, 'Müdürlükler Arası Spor Turnuvası', 'Kent genelindeki park ve yeşil alanların bakım ve düzenleme çalışmaları tamamlandı...', '2023-08-21', '2023-09-30', 278, 'pasif', '../images/futbol-turnuvasi_9646.jpg'),
(14, 'Personel Piknik Programı', 'Kent genelindeki park ve yeşil alanların bakım ve düzenleme çalışmaları tamamlandı...', '2023-07-22', '2023-07-22', 278, 'pasif', '../images/personel-p-kn-k-programi_9118.jpg'),
(15, 'Personel Bayramlaşma Programı', 'Kent genelindeki park ve yeşil alanların bakım ve düzenleme çalışmaları tamamlandı...', '2023-06-23', '2023-06-25', 278, 'pasif', '../images/personel-bayramla-ma-programi_5965.jpg'),
(16, 'Personel İftar Programı', 'Kent genelindeki park ve yeşil alanların bakım ve düzenleme çalışmaları tamamlandı...', '2023-04-10', '2023-05-15', 278, 'pasif', '../images/personel-ftar-program_109.jpg');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `etkinlikler_duyurular`
--

CREATE TABLE `etkinlikler_duyurular` (
  `id` int(11) NOT NULL,
  `sayfa_tipi` varchar(50) NOT NULL,
  `baslik` varchar(255) NOT NULL,
  `aciklama` text DEFAULT NULL,
  `kategori_adi` varchar(150) DEFAULT NULL,
  `alt_tip` varchar(50) DEFAULT NULL,
  `resim_url` varchar(255) DEFAULT NULL,
  `dosya_url` varchar(500) DEFAULT NULL,
  `video_url` varchar(500) DEFAULT NULL,
  `tarih` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `etkinlikler_duyurular`
--

INSERT INTO `etkinlikler_duyurular` (`id`, `sayfa_tipi`, `baslik`, `aciklama`, `kategori_adi`, `alt_tip`, `resim_url`, `dosya_url`, `video_url`, `tarih`) VALUES
(1, 'duyuru', 'DİL EĞİTİM MODELLERİNDE GEÇERLİ %50 İNDİRİM!', 'KURUMUMUZ PERSONELİ VE 1. DERECE YAKINLARINA ÖZEL AMERICAN VIP DİL OKULLARINDA GEÇERLİ %50 İNİDİRİM ANLAŞMASI İMZALANDI.', 'İnsan Kaynakları', 'insan', '../images/d-l-e-t-m-modeller-nde-gecerl-50-nd-r-m_4469.jpg', NULL, NULL, '2023-10-04'),
(2, 'duyuru', 'Gebze\'de Zabıta Haftası Kutlandı', 'Gebze Belediye Başkanı Zinnur Büyükgöz, her yıl 1-7 Eylül tarihleri arasında kutlanan Zabıta Haftası münasebetiyle zabıta personelleriyle bir araya geldi.', 'İnsan Kaynakları', 'insan', '../images/gebze-de-zab-ta-haftas-kutland_5157 (1).jpg', NULL, NULL, '2023-10-04'),
(3, 'duyuru', 'GEBZE\'DE EK ZAM PROTOKOLÜ İMZALANDI', 'Gebze Belediyesi, bünyesinde görev yapan tüm işçilerin maaşlarına %20 zam müjdesini verdi. Ek zam protokolü Gebze Belediye Başkanı Zinnur BÜYÜKGÖZ ve Hizmet-İş ve Özgüven-Sen Sendikası yetkilileri arasında imzalandı.', 'İnsan Kaynakları', 'insan', '../images/gebze-de-ek-zam-protokolu-mzalandi_4681.jpg', NULL, NULL, '2023-10-04'),
(4, 'duyuru', 'Gebze\'nin Filosu Büyüyor;', 'Gebze\'nin mahallelerine daha kaliteli hizmet verebilmek adına makine ve araç filosuna yeni takviyeler yapılmasını sağlayan Gebze Belediye Başkanı Zinnur Büyükgöz, belediyenin öz kaynaklarıyla satın alınan 100 yeni aracı filoya kazandırdı.', 'İnsan Kaynakları', 'insan', '../images/gebze-nin-filosu-buyuyor_2355.jpg', NULL, NULL, '2023-10-04'),
(5, 'duyuru', 'Daha Sağlıklı Personel İçin', 'Gebze Belediyesi bünyesinde görev yapan tüm personellerimiz ve 1. derece yakınları (anne, baba, eş ve çocuk ) anlaşmalı sağlık kurumlarında indirimli fiyatlardan faydalanabilme olanağına sahip olacaklardır.', 'İnsan Kaynakları', 'insan', '../images/daha-saazlikli-ba-r-personel-a-a-a-n_7523.jpg', NULL, NULL, '2023-10-04'),
(6, 'duyuru', 'Parola Güvenlik Politika Geçişi', 'T.C. Cumhurbaşkanlığı Dijital Dönüşüm Ofisi Başkanlığı koordinasyonunda başlatılan \"Bilgi ve İletişim Güvenliği Rehberi\" uyum süreci doğrultusunda gerçekleştireceğimiz \"Güvenli Parola Politikası\" geçişi kapsamında, bilgisayar oturumu açma parolaları değişecektir.', 'Bilgi İşlem', 'bilgi', '../images/parola-guvenlik-politikasi-duyurusu_2090.jpg', NULL, NULL, '2023-10-04');

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

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `haber_galeri`
--

CREATE TABLE `haber_galeri` (
  `id` int(11) NOT NULL,
  `haber_id` int(11) NOT NULL DEFAULT 1,
  `resim_url` varchar(255) NOT NULL,
  `sira` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `haber_galeri`
--

INSERT INTO `haber_galeri` (`id`, `haber_id`, `resim_url`, `sira`) VALUES
(1, 1, '../images/off-road-foto/gebze-de-off-road-heyecan_120.jpg', 1),
(2, 1, '../images/off-road-foto/gebze-de-off-road-heyecan_2075.jpg', 2),
(3, 1, '../images/off-road-foto/gebze-de-off-road-heyecan_2143.jpg', 3),
(4, 1, '../images/off-road-foto/gebze-de-off-road-heyecan_3569.jpg', 4),
(5, 1, '../images/off-road-foto/gebze-de-off-road-heyecan_3911.jpg', 5),
(6, 1, '../images/off-road-foto/gebze-de-off-road-heyecan_4046.jpg', 6),
(7, 1, '../images/off-road-foto/gebze-de-off-road-heyecan_4564.jpg', 7),
(8, 1, '../images/off-road-foto/gebze-de-off-road-heyecan_4975.jpg', 8),
(9, 1, '../images/off-road-foto/gebze-de-off-road-heyecan_5429.jpg', 9);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kaynaklar`
--

CREATE TABLE `kaynaklar` (
  `id` int(11) NOT NULL,
>>>>>>> 112b37f5f7eedd448db79abf5191316023500533
  `baslik` varchar(255) NOT NULL,
  `aciklama` text NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `alt_kategori` varchar(50) DEFAULT NULL,
  `ikon` varchar(50) DEFAULT 'fa-file-signature',
  `dosya_yolu` varchar(255) NOT NULL,
  `resmi_sayfa` varchar(500) DEFAULT NULL,
  `boyut` varchar(50) NOT NULL,
<<<<<<< HEAD
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
=======
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

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `personeller`
--

CREATE TABLE `personeller` (
  `id` int(11) NOT NULL,
  `ad` varchar(100) NOT NULL,
  `soyad` varchar(100) NOT NULL,
  `dogum_tarihi` date NOT NULL,
  `foto_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `personeller`
--

INSERT INTO `personeller` (`id`, `ad`, `soyad`, `dogum_tarihi`, `foto_url`) VALUES
(1, 'Tümay', 'AKSAN', '1995-08-21', '../images/dogum_gunu/37604190820-tumay-aksan_3957.jpg'),
(2, 'Yavuz', 'AĞAÇ', '1992-08-21', '../images/dogum_gunu/32980582726-yavuz-a-ac_5843.jpg'),
(3, 'Zeynep', 'YILMAZ', '1995-08-21', '../images/dogum_gunu/manzara.jpg'),
(4, 'Fatih', 'SULTAN MEHMET', '1990-08-21', '../images/dogum_gunu/Fatih.jpg');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sizden_gelenler`
--

CREATE TABLE `sizden_gelenler` (
  `id` int(11) NOT NULL,
>>>>>>> 112b37f5f7eedd448db79abf5191316023500533
  `baslik` varchar(255) NOT NULL,
  `ozet` text NOT NULL,
  `kategori_slug` varchar(100) NOT NULL,
  `kategori_adi` varchar(150) NOT NULL,
  `tarih` date NOT NULL,
  `goruntulenme` int(11) DEFAULT 0,
  `gorsel_yolu` varchar(255) DEFAULT NULL,
<<<<<<< HEAD
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
=======
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

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `vefat_bilgileri`
--

CREATE TABLE `vefat_bilgileri` (
  `id` int(11) NOT NULL,
>>>>>>> 112b37f5f7eedd448db79abf5191316023500533
  `vefat_eden_adi` varchar(255) NOT NULL,
  `iliski_pozisyon` text NOT NULL,
  `vefat_tarihi` date NOT NULL,
  `vefat_tarihi_metin` varchar(50) NOT NULL,
<<<<<<< HEAD
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
=======
  `cenaze_mesaji` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `vefat_bilgileri`
--

INSERT INTO `vefat_bilgileri` (`id`, `vefat_eden_adi`, `iliski_pozisyon`, `vefat_tarihi`, `vefat_tarihi_metin`, `cenaze_mesaji`) VALUES
(1, 'Sedat TÜRKKAN', 'Destek Hizmetleri Müdürlüğü personeli Ali Türkkan\'ın Babası ', '2024-12-21', '21 Aralık 2024', 'Destek Hizmetleri Müdürlüğü personeli Ali Türkkan\'ın babası Sedat Türkkan Vefat etmiştir.Cenazesi Yarın öğlen namazına müteakip Gebze Kargalı Köyü Camii\'nden kaldırılacaktır. İrtibat: Ali Türkkan 05312611643'),
(2, 'Emine AYDIN GÜL', 'Temizlik İşleri Müdürlüğü personeli Fahrettin Aydın\'ın kardeşi', '2024-12-21', '21 Aralık 2024', 'Temizlik İşleri Müdürlüğü personeli Fahrettin Aydın\'ın kardeşi Emine Aydın Gül vefat etmiştir.Cenazesi bugün öğlen namazına müteakip Darıca Fevzi Çakmak Mahallesi Camii\'nden kaldırılacaktır. İrtibat:05356598417'),
(3, 'Cevat ALTINTAŞ Annesi', 'Teftiş Kurulu Müdürü Cevat Altıntaş\'ın annesi', '2024-12-21', '21 Aralık 2024', 'Teftiş Kurulu Müdürü Cevat Altıntaş\'ın annesi vefat etmiştir.Cenazesi yarın öğlen namazına müteakip Trabzon,Sürmene Petekli Mahallesi Camii\'nden kaldırılacaktır. İrtibat:05337219067'),
(4, 'Nevzat TAŞKIN', 'Kültür Ve Sosyal İşler Müdürlüğü Personeli Engin Taşkın\'ın abisi', '2024-01-15', '15 Ocak 2024', 'Kültür Ve Sosyal İşler Müdürlüğü Personeli Engin Taşkın\'ın abisi Nevzat Taşkın vefat etmiştir. Cenazesi bugün öğlen namazına müteakip memleketi Yalova\'dan kaldırılcaktır.İrtibat: Engin Taşkın 05327823276'),
(5, 'Yavuz HORASAN Babası', 'İşletme ve İştirakler Müdürlüğü Personeli Yavuz Horasın\'ın babası ', '2024-01-15', '15 Ocak 2024', 'İşletme ve İştirakler Müdürlüğü Personeli Yavuz Horasın\'ın babası vefat etmiştir. Cenazesi bugün ikindi namazına müteakip Tokat Turhal\'dan kaldırılcaktır. İrtibat: Yavuz Horasan 05335423041'),
(6, 'Mehmet tevfik ŞAHİN', 'Destek Hizmetleri Müdürlüğü personeli Haluk Şahin\'in abisi', '2023-12-26', '26 Aralık 2023', 'Destek Hizmetleri Müdürlüğü personeli Haluk Şahin\'in abisi Mehmet Teşvik Şahin vefat etmiştir. Cenazesi öğlen namazına müteakip Eskişehir Günyüzü\'nde kaldırılacaktır. İrtibat: Haluk Şahin 05326311898'),
(7, 'Yusuf BİTMEZ', 'Emekli Belediye Başkan Danışmanımız Şakir Bitmez\'in babası', '2023-12-25', '25 Aralık 2023', 'Emekli Belediye Başkan Danışmanımız Şakir Bitmez\'in babası Yusuf Bitmez vefat etmiştir.Cenazesi bugün ikindi namazına müteakip Pendik Yayalar Mahallesi Mehmet Akif Ersoy Camii\'nden kaldırılacaktır.'),
(8, 'Erdoğan POLAT', 'Park Ve Bahçeler Müdürlüğü Personeli Tarık Polat\'ın amcası', '2023-12-20', '20 Aralık 2023', 'Park Ve Bahçeler Müdürlüğü Personeli Tarık Polat\'ın amcası Erdoğan Polat vefat etmiştir.Cenazesi bugün ikindi namazına müteakip Çayırova Bedir Camii\'nden kaldırılacaktır. İrtibat: Tarık Polat 05072524854'),
(9, 'Enver YAZICI\'NIN Kayınvalidesi', 'Kültür Müdürlüğü Personeli Enver Yazıcı\'nın kayınvalidesi', '2023-12-20', '20 Aralık 2023', 'Kültür Müdürlüğü Personeli Enver Yazıcı\'nın kayınvalidesi vefat etmiştir. Cenazesi bugün Cuma namazına müteakip Eskihisar Akşemseddin Camii\'nden kaldırılacaktır. İrtibat: Enver Yazıcı 05423454169'),
(10, 'Hafız Bahattin YİĞİT', 'Güvenlik Personellerimiz Adnan Yiğit ve Fuat Yiğit\'in babası', '2023-12-15', '15 Aralık 2023', 'Güvenlik Personellerimiz Adnan Yiğit ve Fuat Yiğit\'in babası Hafız Bahattin Yiğit vefat etmiştir. Cenazesi Cumartesi öğlen namazına müteakip Hürriyet Mahallesi Hz.Osman Camiin\'den kaldırılacaktır. İrtibat: Adnan Yiğit 05333502447-Fuat Yiğit 05421867958'),
(11, 'İsmail BİNGÖL Babası', 'Temizlik İşleri Müdürlüğü Personeli İsmail Bingöl\'ün babası', '2023-12-12', '12 Aralık 2023', 'Temizlik İşleri Müdürlüğü Personeli İsmail Bingöl\'ün babası vefat etmiştir. Cenazesi bugün öğlen namazına müteakip kaldırılacaktır. İrtibat: İsmail Bingöl 05354091358'),
(12, 'Cengiz AĞAÜZÜM', 'Belediyemizin Emekli Personeli Cengiz Ağaüzüm', '2023-12-12', '12 Aralık 2023', 'Belediyemizin Emekli Personeli Cengiz Ağaüzüm vefat etmiştir. Cenazesi bugün ikindi namazına müteakip Yıldız Camii\'nden kaldırılacaktır.İrtibat: Engin Ağaüzüm 05343033746'),
(13, 'Nuray Dal', 'Etüt Proje Müdürlüğü Personeli Günay Çatak\'ın ablası', '2023-12-12', '12 Aralık 2023', 'Etüt Proje Müdürlüğü Personeli Günay Çatak\'ın ablası Nury Dal vefat etmiştir. Cenazesi yarın öğlen namazına müteakip Aydın İli Çine İlçesinden kaldırılacaktır.'),
(14, 'Ali Osman İŞÇİ', 'Emlak ve İstimlak Müdürlüğü Personeli Salih Katı\'nın Kayınpederi', '2023-12-12', '12 Aralık 2023', 'Emlak ve İstimlak Müdürlüğü Personeli Salih Katı\'nın Kayınpederi Ali Osman İşçi vefat etmiştir. Cenazesi bugün öğle namazına müteakip Darıa Emek Mahallesi Merkez Camii\'nden kaldırılacaktır. İrtibat: Salih Katı 05327433232 '),
(15, 'Fikar KESKİNOĞLU', 'Basın Yayın Ve Halkla İlişkiler Müdürü Mecit Keskinoğlu\'nun Yengesi', '2023-12-05', '5 Aralık 2023', 'Basın Yayın Ve Halkla İlişkiler Müdürü Mecit Keskinoğlu\'nun Yengesi Fikar Keskinoğlu vefat etmiştir. Cenazesi yarın öğlen namazına müteakip Nenehatun Mahallesi Eyüpoğlu Camii\'nden kaldırılacaktır. İrtibat: Mecit Keskinoğlu 05359431643'),
(16, 'Murat ÇOBAN\'ın Ablası', 'Belediyemizin emekli personeli Murat Çoban\'ın Ablası', '2023-11-29', '29 Kasım 2023', 'Belediyemizin emekli personeli Murat Çoban\'ın ablası vefat etmiştir. Cenazesi bugün öğle namazına müteakip Darıca\'dan kaldırılacaktır. İrtibat:'),
(17, 'Teyfik BAYRAM', 'Zabıta Müdürlüğü Güvenlik Personeli Olcay Bayram\'ın Babası', '2023-11-24', '24 Kasım 2023', 'Zabıta Müdürlüğü Güvenlik Personeli Olcay Bayram\'ın babası Teyfik Bayram vefat etmiştir. Cenazesi bugün öğle namazına mütakip memleketi Amasya\'dan kaldırılcaktır. İrtibat: Olcay Bayram 0546226207'),
(18, 'Ahmet KARDEŞ\'in Amcası', 'Ruhsat Müdürlüğü Personeli Ahmet Kardeş\'in amcası ', '2023-11-23', '23 Kasım 2023', 'Ruhsat Müdürlüğü Personeli Ahmet Kardeş\'in amcası vefat etmiştir. Cenazesi bugün öğle namazına müteakip Yenimahalle Merkez Camii\'nden kaldırılacaktır. İrtibat: Ahmet Kardeş 05370308461'),
(19, 'Ramazan ZOR\'un Halası', 'Basın Yayın Halkla İlişkiler Müdürlüğü Personeli Ramazan Zor\'un Halası', '2023-11-13', '13 Kasım 2023', 'Baın Yayın Halkla İlişkiler Müdürlüğü Personeli Ramazan Zor\'un halası vefat etmiştir. Cenazesi yarın öğlen namazına müteakip İlyasbey Camii\'nden kaldırılacaktır. İrtibat: Ramazan Zor 05333360656'),
(20, 'Davut Şahin', 'Etüt Proje Müdürlüğü Personeli Ömer Şahin\'in Amcası', '2023-11-06', '6 Kasım 2023', 'Etüt Proje Müdürlüğü Personeli Ömer Şahin\'in amcası Davut Şahin vefat etmiştir. Cenazesi bugün öğle namazına müteakip İstanbul Rüzgarlı Bahçe Camii\'nden kaldırılacaktır. İrtibat Ömer Şahin 05387303472 '),
(21, 'Remzi DURAN', ' Destek Hizmetleri Personeli Tenzile Deniz\'in Babası', '2023-11-06', '6 Kasım 2023', 'Destek Hizmetleri Personeli Tenzile Deniz\'in babası Remzi Duran vefat etmiştir. Cenazesi bugün Öğlen namazına müteakip Elbizli Mahallesinde kaldırılacaktır.İrtibat: Tenzile Deniz 05454151007'),
(22, 'İsmet YILMAZ', 'Destek Hizmetleri Personeli İlker Yılmaz\'ın Babası', '2023-11-06', '6 Kasım 2023', 'Destek Hizmetleri Personeli İlker Yılmaz\'ın babası İsmet Yılmaz vefat etmiştir.Cenazesi yarın öğle namazına müteakip Beylikbağı Fatih Camii\'nden kaldırılacaktır. İrtibat: İlker YILMAZ 05438092966'),
(23, 'Erdal GÜNEY\'ın Kayınbiraderi', 'Temizlik İşleri Personeli Nazım Ertürk\'ün abisi Erdal Güney\'ın Kayınbiraderi', '2023-11-06', '6 Kasım 2023', 'Temizlik İşleri Personeli Nazım Ertürk\'ün abisi Erdal Güney\'ın kayınbiraderi vefat etmiştir. Cenazesi bugün öğlen namazından sonra Hürriyet Mahallesi Hz.Ali Camii\'nden kaldırılacaktır.İrtibat: Nazım Ertürk 05362215339-ErdalGüzey 05343572975'),
(24, 'Elmas ARSLAN', 'Veteriner İşleri Müdürlüğü Personeli Barış Arslan\'ın annesi', '2023-11-06', '6 Kasım 2023', 'Belediyemiz Veteriner İşleri Müdürlüğü Personeli Barış Arslan\'ın annesi Elmas Arslan vefat etmiştir. Cenazesi memleketi Giresun\'dan kaldırılacaktır. İrtibat: Barış Arslan 05333969761'),
(25, 'Fuat CAN', 'Özel Kalem Müdürlüğü Personeli Filiz Can\'ın Eşi', '2023-11-26', '26 Kasım 2023', 'Belediyemiz Özel KALEM Müdürlüğü personeli Filiz Can\'ın eşi Fuat Can vefat etmiştir. Cenazesi yarın öğlen namazına müteakip Nur Osmaniye Camii\'nden kaldırılacaktır. İrtibat: Eren Can 05523429125'),
(26, 'Ayşe VAROL', ' Belediyemizin Emekli Personeli İhsan Varol\'un eşi', '2023-11-26', '26 Kasım 2023', 'Belediyemizin emekli personeli İhsan Varol\'un eşi Ayşe Varol vefat etmiştir. Cenazesi ikindi namazına müteakip Yavuz Selim Mahallesi Ulu Camii\'nden kaldırılacaktır. İrtibat: İhsan Varol 05453676219'),
(27, 'Saadettin Gürkan\'ın Kayınpederi', 'Kültür Müdürlüğü Personeli Saadettin Gürkan\'ın Kayınpederi', '2023-11-26', '26 Kasım 2023', 'Belediyemizin Kültür Müdürlüğü Personeli Saadettin GÜRKAN\'ın kayınpederi vefat etmiştir. Cenazesi memleketi Ordu\'da defnedilcektir. İrtibat: Saadettin Gürkan 05427181294'),
(28, 'Tuncay KUYUCU\'nun Babası', 'Emlak İstimlak Müdürlüğü Personeli Tuncay Kuyucu\'nun babası', '2023-11-16', '16 Kasım 2023', 'Belediyemiz Emlak İstimlak Müdürlüğü personelimiz Tuncay Kuyucu\'nun babası vefat etmiştir. Cenaze pazar günü öğlen namazına müteakip Mudarlı köyünde defnedilmiştir. İrtibat: Tuncay Kuyucu 05363270149'),
(29, 'Metin Ve Murat ÇİMEN\'in babaannesi', 'Fen işleri Personelimiz Metin ve Murat Çimen\'in Babaannesi ', '2023-11-16', '16 Kasım 2023', 'Emekli Fen İşleri personelimiz İsmail ÇİMEN\'in annesi,Fen işleri Personelimiz Metin ve Murat Çimen\'in babaannesi vefat etmiştir.Cenazesi bugün ikindi namazına müteakip Barış Mahallesi Merkez Camii\'nden kaldırılacaktır. İrtibat: İsmail Çimen 05358250415 Metin Çimen 05378878231'),
(30, 'Hasan ALTINPARMAK\'ın Babası', 'Temizlik İşleri Müdürlüğü Personeli Hasan Altınparmak\'ın Babası', '2023-11-16', '16 Kasım 2023', 'Temizlik İşleri Müdürlüğü Personeli Hasan Altınparmak\'ın babası vefat etmiştir.Cenazesi bugün ikindi namazına müteakip Çayırova Mandıra(Mescid-i Aksa)Camii-\'nden kaldırılacaktır. İrtibat: Hasan Altınparmak 05310132598'),
(31, 'Namık Demir\'in Babası', 'Bilgi İşlem Müdürlüğü Personeli Namık Demir\'in Babası', '2023-09-07', '7 Eylül 2023', 'Belediyemiz Bilgi İşlem Müdürlüğü Personeli Namık Demir\'in babası vefat etmiştir. Cenazesi bugün öğle namazına müteakip memleketi Erzurum\'dan kaldırılacaktır. İrtibat: Namık Demir 05063654125');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `videolar`
--

CREATE TABLE `videolar` (
  `id` int(11) NOT NULL,
>>>>>>> 112b37f5f7eedd448db79abf5191316023500533
  `youtube_id` varchar(50) NOT NULL,
  `baslik` varchar(255) NOT NULL,
  `aciklama` text NOT NULL,
  `kategori` varchar(100) NOT NULL,
<<<<<<< HEAD
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
=======
  `sure` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `videolar`
--

INSERT INTO `videolar` (`id`, `youtube_id`, `baslik`, `aciklama`, `kategori`, `sure`) VALUES
(1, 'qLqYPQgUPEc', 'Gebze Offroad Heyecanı', 'Nefes kesen anlar ve çamurlu yollar... Offroad tutkunları bu etkinlikte buluştu.', 'etkinlikler', '15:22'),
(2, 'aUQ3uIAfL-k', 'Geleneksel Aşure Günü', 'Aşure gününde personelimizle bir araya geldik.', 'etkinlikler', '04:20'),
(3, 'RhVDYrAb0xQ', 'Yangın Tatbikatı Eğitimi', 'Acil durumlara hazırlık kapsamında düzenlenen eğitim videosu.', 'egitimler', '18:55'),
(4, 'c0vbYSFwMzU', 'İş Elbiseleri Dağıtımı', 'Yeni dönem iş elbiselerinin dağıtımıyla ilgili duyuru.', 'duyurular', '01:45'),
(5, '-0Wxna6PjqQ', 'Sokak Hayvanları Besleme Etkinliği', 'Patili dostlarımızı unutmadık, onlarla bir gün geçirdik.', 'etkinlikler', '06:33'),
(6, 'e65zC48s8Wc', 'Stresle Başa Çıkma Yöntemleri', 'İş hayatında stresi yönetmek için pratik bilgiler.', 'egitimler', '41:12'),
(7, 'YXat3fIWc7w', 'Kantin Fiyat Düzenlemesi', 'Yemekhane ve kantin fiyatları hakkındaki yeni düzenleme.', 'duyurular', '01:10'),
(8, 'QRizu8RhGnU', 'Fidan Dikme Etkinliği', 'Daha yeşil bir Gebze için personelimizle birlikte fidan diktik.', 'etkinlikler', '09:45'),
(9, 'Z2dH2UIXb8Y', 'Kişisel Verilerin Korunması (KVKK)', 'KVKK kanunu kapsamında personelimiz için zorunlu eğitim.', 'egitimler', '38:00'),
(10, 'G2KNC3OAnjE', 'Yıllık İzin Kullanımı Hakkında', 'İnsan kaynaklarından izin kullanımı ile ilgili önemli duyuru.', 'duyurular', '02:55'),
(11, 'RhD1ArYsuKo', 'Huzurevi Ziyareti', 'Sosyal sorumluluk projemiz kapsamında gerçekleştirdiğimiz ziyaret.', 'etkinlikler', '07:25'),
(12, 'IEc5W0JyADU', 'Zaman Yönetimi ve Verimlilik', 'Daha verimli çalışmanın ipuçları bu eğitimde.', 'egitimler', '28:30'),
(13, '3ePuzpC2S0Q', 'Yeni Servis Güzergahları Hk.', 'Personel servis güzergahlarındaki değişiklikler hakkında duyuru.', 'duyurular', '04:18'),
(14, 'qdPXmtKXXc4', 'Spor Turnuvası Kura Çekimi', 'Birimler arası spor turnuvası için kura çekimi heyecanı.', 'etkinlikler', '12:50'),
(15, 'uUFZvM9kqf4', 'Temel Ofis Programları Eğitimi', 'Word, Excel ve PowerPoint kullanımı üzerine temel eğitim serisi.', 'egitimler', '55:20'),
(16, 'BiY2WK24UHY', 'Maaş Avansı Kullanım Bilgilendirmesi', 'İnsan kaynaklarından personelimize duyuru.', 'duyurular', '03:05'),
(17, 'xot-DBvkkq4', 'Gebze Kitap Fuarı Başladı', 'Belediyemizin düzenlediği kitap fuarından ilk görüntüler.', 'etkinlikler', '08:12'),
(18, 'ABIqjRnV5dU', 'Etkili İletişim Teknikleri Semineri', 'Kurum içi iletişimimizi güçlendirmek için düzenlenen eğitim.', 'egitimler', '33:40'),
(19, 'psmlNSPRDsM', 'Önemli Sistem Güncellemesi', 'Bilgi İşlem Daire Başkanlığından önemli duyuru.', 'duyurular', '02.15'),
(20, 'pAHStsCd9jo', 'Belediye Pikniği 2025', 'Geçtiğimiz hafta sonu düzenlediğimiz personel pikniğinden renkli anlar.', 'etkinlikler', '05:48'),
(21, 'eUBQYWMZyH8', 'Bayramlaşma Töreni Duyurusu ', 'Geleneksel bayramlaşma törenimiz hakkında bilgilendirme. Tüm personelimiz davetlidir. ', 'duyurular', '01.30'),
(22, 'GWfDmGr6tlg', 'Yeni Personel İçin İSG Eğitimi', 'İş sağlığı ve güvenliği temelleri, tüm yeni personelimiz için önemli bir başlangıç.', 'egitimler', '45:10'),
(23, 'D1b-CZYtCTg', 'Portal Kullanım Kılavuzu', 'Personel portalının nasıl daha etkin kullanılacağına dair video.', 'duyurular', '11:30');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yardimci_linkler`
--

CREATE TABLE `yardimci_linkler` (
  `id` int(11) NOT NULL,
  `baslik` varchar(255) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `logo_url` varchar(255) DEFAULT NULL,
  `hedef_url` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `yardimci_linkler`
--

INSERT INTO `yardimci_linkler` (`id`, `baslik`, `kategori`, `logo_url`, `hedef_url`) VALUES
(1, 'OMIS', 'kurum-ici', '../images/otomasyon/omis_7572.png', 'https://ebelediye.gebze.bel.tr/eBelediye/'),
(2, 'Ulakbel', 'kurum-ici', '../images/otomasyon/ulakbel_5496.png', 'https://ulakbel.gebze.bel.tr/ulakbel#/'),
(3, 'İmar Yönetim Sistemi', 'kurum-ici', '../images/otomasyon/imar-yonetim-sistemi_8038.png', 'https://www.gebze.bel.tr/ebelediye/'),
(4, 'Dijital Arşiv', 'kurum-ici', '../images/otomasyon/dijital-arsiv_415.png', 'https://www.gebze.bel.tr/'),
(5, 'Outlook', 'kurum-ici', '../images/otomasyon/outlook_4005.png', 'https://outlook.live.com/'),
(6, 'Sosyal Yardım', 'kurum-ici', '../images/otomasyon/sosyal-yardim_3767.png', 'https://www.turkiye.gov.tr/ashb-sosyal-yardim-bilgileri-sorgulama'),
(7, 'Netcad', 'kurum-ici', '../images/otomasyon/netcad_3888.png', 'https://www.netcad.com/'),
(8, 'E-Belediye Sistemi', 'kurum-ici', '../images/otomasyon/ebys_8493.png', 'https://www.belediye.gov.tr/'),
(9, 'E-Belediye Evlendrme Modülü', 'kurum-ici', '../images/otomasyon/e-belediye-evlendirme-modulu_3993.png', 'https://www.belediye.gov.tr/evlendirme-modulu'),
(10, 'E-Belediye Sosyal Yardım Modülü', 'kurum-ici', '../images/otomasyon/e-belediye-sosyal-yard-m-modulu_4432.png', 'https://www.belediye.gov.tr/sosyal-yardim-takip-sistemi-syts-modulu'),
(11, 'Gebze Belediyesi', 'website', '../images/yardimci_linkler/web_siteleri/gebze-belediyesi.png', 'https://www.gebze.bel.tr/'),
(12, 'Kocaeli Büyükşehir Belediyesi', 'website', '../images/yardimci_linkler/web_siteleri/kocaeli-buyuksehir-belediyesi.png', 'https://www.kocaeli.bel.tr/'),
(13, 'Kocaeli Valiliği', 'website', '../images/yardimci_linkler/web_siteleri/kocaeli-vali.jpg', 'http://www.kocaeli.gov.tr/'),
(14, 'Gebze Kaymakamlığı', 'website', '../images/yardimci_linkler/web_siteleri/gebze-kaymakam.png', 'http://www.gebze.gov.tr/'),
(15, 'Türkiye Belediyeler Birliği', 'bilgi', '../images/yardimci_linkler/bilgi_portallari/turkiye-belediyeler-birligi_2430.png', 'https://www.tbb.gov.tr/tr'),
(16, 'Cumhurbaşkanlığı Uzaktan Eğitim Kapısı', 'bilgi', '../images/yardimci_linkler/bilgi_portallari/cumhur.jpg', 'https://uzaktanegitimkapisi.cbiko.gov.tr/Giris'),
(17, 'BTK Akademi Eğitim Portalı', 'bilgi', '../images/yardimci_linkler/bilgi_portallari/btk-akademi.jpg', 'https://www.btkakademi.gov.tr/'),
(18, 'Memurlar.Net', 'faydalı', '../images/yardimci_linkler/faydali_linkler/memurlar.png', 'https://www.memurlar.net/'),
(19, 'İlan', 'faydalı', '../images/yardimci_linkler/faydali_linkler/ilan.png', 'https://www.ilan.gov.tr/'),
(20, 'Resmi Gazete', 'faydalı', '../images/yardimci_linkler/faydali_linkler/resmi.png', 'https://www.resmigazete.gov.tr/');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `anasayfa_duyurular`
--
ALTER TABLE `anasayfa_duyurular`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `anketler`
--
ALTER TABLE `anketler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `dokumanlar`
--
ALTER TABLE `dokumanlar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `duyurular`
--
ALTER TABLE `duyurular`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `etkinlikler`
--
ALTER TABLE `etkinlikler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `etkinlikler_duyurular`
--
ALTER TABLE `etkinlikler_duyurular`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `haberler`
--
ALTER TABLE `haberler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `haber_galeri`
--
ALTER TABLE `haber_galeri`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `kaynaklar`
--
ALTER TABLE `kaynaklar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `personeller`
--
ALTER TABLE `personeller`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `sizden_gelenler`
--
ALTER TABLE `sizden_gelenler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `vefat_bilgileri`
--
ALTER TABLE `vefat_bilgileri`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `videolar`
--
ALTER TABLE `videolar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `yardimci_linkler`
--
ALTER TABLE `yardimci_linkler`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `anasayfa_duyurular`
--
ALTER TABLE `anasayfa_duyurular`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Tablo için AUTO_INCREMENT değeri `anketler`
--
ALTER TABLE `anketler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `dokumanlar`
--
ALTER TABLE `dokumanlar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Tablo için AUTO_INCREMENT değeri `duyurular`
--
ALTER TABLE `duyurular`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Tablo için AUTO_INCREMENT değeri `etkinlikler`
--
ALTER TABLE `etkinlikler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Tablo için AUTO_INCREMENT değeri `etkinlikler_duyurular`
--
ALTER TABLE `etkinlikler_duyurular`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Tablo için AUTO_INCREMENT değeri `haberler`
--
ALTER TABLE `haberler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Tablo için AUTO_INCREMENT değeri `haber_galeri`
--
ALTER TABLE `haber_galeri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Tablo için AUTO_INCREMENT değeri `kaynaklar`
--
ALTER TABLE `kaynaklar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Tablo için AUTO_INCREMENT değeri `personeller`
--
ALTER TABLE `personeller`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `sizden_gelenler`
--
ALTER TABLE `sizden_gelenler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Tablo için AUTO_INCREMENT değeri `vefat_bilgileri`
--
ALTER TABLE `vefat_bilgileri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Tablo için AUTO_INCREMENT değeri `videolar`
--
ALTER TABLE `videolar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Tablo için AUTO_INCREMENT değeri `yardimci_linkler`
--
ALTER TABLE `yardimci_linkler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
>>>>>>> 112b37f5f7eedd448db79abf5191316023500533
