CREATE DATABASE  IF NOT EXISTS `api_project` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `api_project`;
-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: localhost    Database: api_project
-- ------------------------------------------------------
-- Server version	8.0.39-0ubuntu0.22.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `profile_attributes`
--

DROP TABLE IF EXISTS `profile_attributes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `profile_attributes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `profile_id` int NOT NULL,
  `attribute` varchar(255) DEFAULT NULL,
  `ts_creation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ts_modification` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_profile_id` (`profile_id`) /*!80000 INVISIBLE */,
  KEY `idx_attribute` (`attribute`) /*!80000 INVISIBLE */,
  KEY `idx_creation` (`ts_creation`) /*!80000 INVISIBLE */,
  KEY `idx_modification` (`ts_modification`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profile_attributes`
--

LOCK TABLES `profile_attributes` WRITE;
/*!40000 ALTER TABLE `profile_attributes` DISABLE KEYS */;
INSERT INTO `profile_attributes` VALUES (1,1,'Operaio','2024-08-01 17:28:53','2024-08-03 16:21:39'),(2,1,'ATTR2','2024-08-01 17:29:01',NULL),(3,2,'ATTR3','2024-08-01 17:29:50',NULL),(6,5,'Commercialista','2024-08-03 22:46:04',NULL);
/*!40000 ALTER TABLE `profile_attributes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profiles`
--

DROP TABLE IF EXISTS `profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `profiles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT '',
  `lastname` varchar(255) DEFAULT '',
  `phone` varchar(40) DEFAULT NULL,
  `ts_creation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ts_modification` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_name` (`name`) /*!80000 INVISIBLE */,
  KEY `idx_lastname` (`lastname`) /*!80000 INVISIBLE */,
  KEY `idx_creation` (`ts_creation`) /*!80000 INVISIBLE */,
  KEY `idx_modification` (`ts_modification`),
  KEY `idx_phone` (`phone`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profiles`
--

LOCK TABLES `profiles` WRITE;
/*!40000 ALTER TABLE `profiles` DISABLE KEYS */;
INSERT INTO `profiles` VALUES (1,'Paolo','Rossi','3311002167','2024-08-01 17:28:38','2024-08-02 22:44:14'),(2,'TEST2','TESTB',NULL,'2024-08-01 17:29:33',NULL),(3,'Paolo','Rossi','3311002167','2024-08-02 22:54:25',NULL),(4,'Alberto','Strada','347005566','2024-08-03 21:42:14',NULL),(5,'Alessandro','Rossi','347554433','2024-08-03 22:43:31','2024-08-03 22:44:38');
/*!40000 ALTER TABLE `profiles` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-08-22 10:51:52
