-- MySQL dump 10.13  Distrib 8.0.39, for Linux (x86_64)
--
-- Host: localhost    Database: social_media
-- ------------------------------------------------------
-- Server version	8.0.39-0ubuntu0.22.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `commentaire` (
  `id` int NOT NULL AUTO_INCREMENT,
  `contenu` text NOT NULL,
  `id_compte` int NOT NULL,
  `id_publication` int NOT NULL,
  `date_heure` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_compte` (`id_compte`),
  KEY `id_publication` (`id_publication`),
  CONSTRAINT `commentaire_ibfk_1` FOREIGN KEY (`id_compte`) REFERENCES `compte` (`id`),
  CONSTRAINT `commentaire_ibfk_2` FOREIGN KEY (`id_publication`) REFERENCES `publication` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commentaire`
--

LOCK TABLES `commentaire` WRITE;
/*!40000 ALTER TABLE `commentaire` DISABLE KEYS */;
INSERT INTO `commentaire` VALUES (1,'tsy tonga',1,1,'2024-09-24 10:38:15'),(2,'tonga',1,1,'2024-09-24 12:08:19'),(3,'tsy zany',1,1,'2024-09-24 12:21:08'),(4,'zany',1,1,'2024-09-24 12:22:26'),(5,'eto amizay',1,3,'2024-09-24 12:24:55');
/*!40000 ALTER TABLE `commentaire` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `compte`
--

DROP TABLE IF EXISTS `compte`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `compte` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `nom_utilisateur` varchar(50) NOT NULL,
  `mail` varchar(200) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom_utilisateur` (`nom_utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compte`
--

LOCK TABLES `compte` WRITE;
/*!40000 ALTER TABLE `compte` DISABLE KEYS */;
INSERT INTO `compte` VALUES (1,'RAN','Dria','dd','ran@dria.com','$2y$10$oREULCclfXuHu2rNnqUg3uhY.XIbTmaw/iim5YYHy2HH7AFuZv04S'),(2,'Us','Er','user','US@er.com','$2y$10$WzTS5sPOqtQxFYOmc54.aOabxe8c3DCqZtX34EUKJ96jcfmH/8QQ2');
/*!40000 ALTER TABLE `compte` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `publication`
--

DROP TABLE IF EXISTS `publication`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `publication` (
  `id` int NOT NULL AUTO_INCREMENT,
  `contenu` text NOT NULL,
  `id_compte` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_compte` (`id_compte`),
  CONSTRAINT `publication_ibfk_1` FOREIGN KEY (`id_compte`) REFERENCES `compte` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `publication`
--

LOCK TABLES `publication` WRITE;
/*!40000 ALTER TABLE `publication` DISABLE KEYS */;
INSERT INTO `publication` VALUES (1,'ito ny pub 1',1,'2024-09-24 05:28:12'),(2,'ito ny pub 2',1,'2024-09-24 05:30:25'),(3,'ito ny pub 3',1,'2024-09-24 05:48:42'),(4,'ito ary',2,'2024-09-24 05:55:41'),(5,'jhv<hvjv',NULL,'2024-09-24 07:52:52'),(6,'hgjh',NULL,'2024-09-24 07:53:22'),(7,'aiza',1,'2024-09-24 07:55:13');
/*!40000 ALTER TABLE `publication` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reaction`
--

DROP TABLE IF EXISTS `reaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reaction` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reaction`
--

LOCK TABLES `reaction` WRITE;
/*!40000 ALTER TABLE `reaction` DISABLE KEYS */;
/*!40000 ALTER TABLE `reaction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reaction_commentaire`
--

DROP TABLE IF EXISTS `reaction_commentaire`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reaction_commentaire` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  `id_compte` int NOT NULL,
  `id_commentaire` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_compte` (`id_compte`),
  KEY `id_commentaire` (`id_commentaire`),
  CONSTRAINT `reaction_commentaire_ibfk_1` FOREIGN KEY (`id_compte`) REFERENCES `compte` (`id`),
  CONSTRAINT `reaction_commentaire_ibfk_2` FOREIGN KEY (`id_commentaire`) REFERENCES `commentaire` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reaction_commentaire`
--

LOCK TABLES `reaction_commentaire` WRITE;
/*!40000 ALTER TABLE `reaction_commentaire` DISABLE KEYS */;
/*!40000 ALTER TABLE `reaction_commentaire` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reaction_publication`
--

DROP TABLE IF EXISTS `reaction_publication`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reaction_publication` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  `id_compte` int NOT NULL,
  `id_publication` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_compte` (`id_compte`),
  KEY `id_publication` (`id_publication`),
  CONSTRAINT `reaction_publication_ibfk_1` FOREIGN KEY (`id_compte`) REFERENCES `compte` (`id`),
  CONSTRAINT `reaction_publication_ibfk_2` FOREIGN KEY (`id_publication`) REFERENCES `publication` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reaction_publication`
--

LOCK TABLES `reaction_publication` WRITE;
/*!40000 ALTER TABLE `reaction_publication` DISABLE KEYS */;
/*!40000 ALTER TABLE `reaction_publication` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-09-24 15:29:23
