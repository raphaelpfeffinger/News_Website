-- MariaDB dump 10.19  Distrib 10.4.20-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: news
-- ------------------------------------------------------
-- Server version	10.4.20-MariaDB

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
-- Table structure for table `kategories`
--

DROP TABLE IF EXISTS `kategories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kategories` (
  `kid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kategorie` varchar(20) NOT NULL,
  PRIMARY KEY (`kid`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategories`
--

LOCK TABLES `kategories` WRITE;
/*!40000 ALTER TABLE `kategories` DISABLE KEYS */;
INSERT INTO `kategories` VALUES (35,'Musik'),(36,'Politik'),(37,'Sport'),(38,'Berühmtheiten'),(39,'Wirtschaft'),(40,'Lokal'),(41,'Essen'),(42,'Technik');
/*!40000 ALTER TABLE `kategories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news` (
  `newsID` int(11) NOT NULL AUTO_INCREMENT,
  `titel` varchar(255) NOT NULL,
  `inhalt` text DEFAULT NULL,
  `gueltigVon` date DEFAULT NULL,
  `gueltigBis` date DEFAULT NULL,
  `erstelltam` date DEFAULT NULL,
  `kid` int(10) unsigned NOT NULL,
  `link` varchar(50) DEFAULT NULL,
  `bild` varchar(255) DEFAULT NULL,
  `autor` int(11) DEFAULT NULL,
  PRIMARY KEY (`newsID`),
  KEY `fk_kategories` (`kid`),
  CONSTRAINT `fk_kategories` FOREIGN KEY (`kid`) REFERENCES `kategories` (`kid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` VALUES (1,'Veraltet 1','helloooo we love coffee','2023-05-23','2023-05-24','2023-05-31',41,'https://www.youtube.com/watch?v=dQw4w9WgXcQ','https://yt3.googleusercontent.com/G-xQ-34A-GcfZm9ByvMnFEf1TjOatTKrJ3g0XaL1kXqCbin-7hTXhQBDe3VYtcAhx59iKG9C5jA=s900-c-k-c0x00ffffff-no-rj',2),(2,'Veraltet 2','Rauchen ist nicht gut (Optional)','2023-05-16','2023-05-18','2023-05-31',38,'https://www.youtube.com/watch?v=dQw4w9WgXcQ','https://yt3.googleusercontent.com/G-xQ-34A-GcfZm9ByvMnFEf1TjOatTKrJ3g0XaL1kXqCbin-7hTXhQBDe3VYtcAhx59iKG9C5jA=s900-c-k-c0x00ffffff-no-rj',2),(3,'Quantencomputer','funktionieren nicht','2023-05-31','2023-07-09','2023-05-31',36,'https://www.google.com/search?client=opera-gx&q=ma','https://yt3.googleusercontent.com/G-xQ-34A-GcfZm9ByvMnFEf1TjOatTKrJ3g0XaL1kXqCbin-7hTXhQBDe3VYtcAhx59iKG9C5jA=s900-c-k-c0x00ffffff-no-rj',2),(4,'Kaffee','Viele Früchte und Vitamine. Aber auch Zucker','2023-05-24','2023-07-07','2023-05-31',40,'https://www.youtube.com/watch?v=dQw4w9WgXcQ','https://shop.selecta.ch/cdn/shop/products/tp_multivitamin_clustereh_3d_packshot_claim_bdcd8833-398e-4177-92d3-297803261160.jpg?v=1646314495',1);
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `Benutzername` varchar(20) NOT NULL,
  `Passwort` varchar(60) DEFAULT NULL,
  `Anrede` char(4) DEFAULT NULL,
  `Vorname` varchar(50) NOT NULL,
  `Nachname` varchar(50) NOT NULL,
  `Strasse` varchar(50) DEFAULT NULL,
  `PLZ` varchar(15) DEFAULT NULL,
  `Ort` varchar(50) DEFAULT NULL,
  `Land` varchar(50) DEFAULT NULL,
  `EMail_Adresse` varchar(30) DEFAULT NULL,
  `Telefon` int(11) DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'TestUser1','$2y$10$3cE/GXSKDjqueGmQMxKQTuqlb1F4CDQM3V4om16w4SAh0Wh7vv8p.','Dive','Max','Mustermann','Musterstrasse','69','Musterstadt','Schweiz','max.mustermann@gmail.com',77),(2,'TestUser2','$2y$10$BpeV8Hl6J/c0K5dnogobLOFlEAW61ZkOe4pxl0d3cDnjBk3R5lWq.','Herr','Raphael','Pfeffinger','Münchackerstrasse 28','4133','Pratteln','Schweiz','raphael.pfeffinger@stud.edubs.',77);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-05-31 16:59:54
