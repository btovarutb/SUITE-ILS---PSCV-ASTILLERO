-- MySQL dump 10.13  Distrib 8.0.40, for Linux (x86_64)
--
-- Host: localhost    Database: sistemails
-- ------------------------------------------------------
-- Server version	8.0.40

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
-- Table structure for table `buque_fua`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `buque_fua` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `buque_id` bigint unsigned NOT NULL,
  `roh_1` int DEFAULT NULL,
  `roh_3` int DEFAULT NULL,
  `roh_5` int DEFAULT NULL,
  `mant_basico_1` int DEFAULT NULL,
  `mant_intermedio_3` int DEFAULT NULL,
  `mant_basico_3` int DEFAULT NULL,
  `mant_mayor_5` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `disponible_misiones_1` decimal(10,2) DEFAULT NULL,
  `disponibilidad_mantenimiento_1` decimal(10,2) DEFAULT NULL,
  `disponible_misiones_3` decimal(10,2) DEFAULT NULL,
  `disponibilidad_mantenimiento_3` decimal(10,2) DEFAULT NULL,
  `disponible_misiones_5` decimal(10,2) DEFAULT NULL,
  `disponibilidad_mantenimiento_5` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `buque_fua_buque_id_foreign` (`buque_id`),
  CONSTRAINT `buque_fua_buque_id_foreign` FOREIGN KEY (`buque_id`) REFERENCES `buques` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buque_fua`
--

LOCK TABLES `buque_fua` WRITE;
/*!40000 ALTER TABLE `buque_fua` DISABLE KEYS */;
INSERT INTO `buque_fua` VALUES (2,71,480,NULL,NULL,1176,NULL,NULL,NULL,'2024-11-27 01:35:18','2024-12-19 17:42:20',6104.00,1176.00,7760.00,0.00,7760.00,0.00),(3,29,123,123,123,123,123,123,123,'2024-12-02 17:14:44','2024-12-04 17:13:26',8469.00,123.00,8346.00,246.00,8469.00,123.00),(4,104,12,12,12,12,12,12,12,'2024-12-04 17:16:19','2024-12-04 17:16:19',7505.00,12.00,7493.00,24.00,7505.00,12.00);
/*!40000 ALTER TABLE `buque_fua` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `buque_fuas`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `buque_fuas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buque_fuas`
--

LOCK TABLES `buque_fuas` WRITE;
/*!40000 ALTER TABLE `buque_fuas` DISABLE KEYS */;
/*!40000 ALTER TABLE `buque_fuas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `buque_misiones`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `buque_misiones` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `buque_id` bigint unsigned NOT NULL,
  `mision` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `velocidad` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `num_motores` int DEFAULT NULL,
  `potencia` decimal(5,2) DEFAULT NULL,
  `porcentaje` decimal(5,2) DEFAULT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `buque_misiones_buque_id_foreign` (`buque_id`),
  CONSTRAINT `buque_misiones_buque_id_foreign` FOREIGN KEY (`buque_id`) REFERENCES `buques` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buque_misiones`
--

LOCK TABLES `buque_misiones` WRITE;
/*!40000 ALTER TABLE `buque_misiones` DISABLE KEYS */;
INSERT INTO `buque_misiones` VALUES (57,29,'Ayuda Humanitaria','11',11,11.00,0.00,'123','2024-12-04 17:13:26','2024-12-04 17:13:26'),(58,29,'Combate contra el terrorismo','22',2,22.00,0.00,'22','2024-12-04 17:13:26','2024-12-04 17:13:26'),(59,104,'Ayuda Humanitaria','111',2,12.00,0.00,'123','2024-12-04 17:16:19','2024-12-04 17:16:19'),(100,71,'Ayuda Humanitaria','123',12,12.00,26.00,'12','2024-12-19 17:42:20','2024-12-19 17:42:20'),(101,71,'Combate a la piratería','1',1,1.00,50.00,'123','2024-12-19 17:42:20','2024-12-19 17:42:20');
/*!40000 ALTER TABLE `buque_misiones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `buque_misions`
--
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `buque_misions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buque_misions`
--

LOCK TABLES `buque_misions` WRITE;
/*!40000 ALTER TABLE `buque_misions` DISABLE KEYS */;
/*!40000 ALTER TABLE `buque_misions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `buque_sistema`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `buque_sistema` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `buque_id` bigint unsigned NOT NULL,
  `sistema_id` bigint unsigned NOT NULL,
  `mec` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observaciones` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `misiones` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `buque_sistema_buque_id_foreign` (`buque_id`),
  KEY `buque_sistema_sistema_id_foreign` (`sistema_id`),
  CONSTRAINT `buque_sistema_buque_id_foreign` FOREIGN KEY (`buque_id`) REFERENCES `buques` (`id`) ON DELETE CASCADE,
  CONSTRAINT `buque_sistema_sistema_id_foreign` FOREIGN KEY (`sistema_id`) REFERENCES `grupos_constructivos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `buque_sistema_chk_1` CHECK (json_valid(`observaciones`)),
  CONSTRAINT `buque_sistema_chk_2` CHECK (json_valid(`misiones`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buque_sistema`
--

LOCK TABLES `buque_sistema` WRITE;
/*!40000 ALTER TABLE `buque_sistema` DISABLE KEYS */;
/*!40000 ALTER TABLE `buque_sistema` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `buque_sistemas_buque`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `buque_sistemas_buque` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `buque_id` bigint unsigned NOT NULL,
  `sistemas_buque_id` bigint unsigned NOT NULL,
  `mec` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observaciones` text COLLATE utf8mb4_unicode_ci,
  `mision` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `buque_sistemas_buque_buque_id_foreign` (`buque_id`),
  KEY `buque_sistemas_buque_sistemas_buque_id_foreign` (`sistemas_buque_id`),
  CONSTRAINT `buque_sistemas_buque_buque_id_foreign` FOREIGN KEY (`buque_id`) REFERENCES `buques` (`id`) ON DELETE CASCADE,
  CONSTRAINT `buque_sistemas_buque_sistemas_buque_id_foreign` FOREIGN KEY (`sistemas_buque_id`) REFERENCES `sistemas_buque` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buque_sistemas_buque`
--

LOCK TABLES `buque_sistemas_buque` WRITE;
/*!40000 ALTER TABLE `buque_sistemas_buque` DISABLE KEYS */;
INSERT INTO `buque_sistemas_buque` VALUES (1,71,1,'MEC 1',NULL,'0.png','{\"pregunta1\":\"Testing Testing Testing\"}',NULL,'2024-11-06 21:10:11','2024-11-06 21:11:45'),(2,71,2,'MEC 4',NULL,'110.png',NULL,NULL,'2024-11-06 21:10:11','2024-11-28 20:43:17'),(3,71,3,'MEC 1',NULL,'1110.png',NULL,NULL,'2024-11-06 21:10:11','2024-12-04 15:46:39'),(4,71,4,'MEC 2',NULL,'111101.png',NULL,NULL,'2024-11-06 21:10:11','2024-12-04 15:49:05'),(5,71,5,'MEC 4',NULL,'110.png',NULL,NULL,'2024-11-06 21:10:11','2024-12-04 15:50:15'),(6,71,6,'MEC 4',NULL,'110.png',NULL,NULL,'2024-11-06 21:10:11','2025-01-21 20:28:58'),(7,71,7,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(8,71,8,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(9,71,9,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(10,71,10,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(11,71,11,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(12,71,12,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(13,71,13,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(14,71,14,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(15,71,15,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(16,71,16,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(17,71,17,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(18,71,18,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(19,71,19,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(20,71,20,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(21,71,21,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(22,71,22,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(23,71,23,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(24,71,24,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(25,71,25,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(26,71,26,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(27,71,27,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(28,71,28,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(29,71,29,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(30,71,30,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(31,71,31,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(32,71,32,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(33,71,33,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(34,71,34,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(35,71,35,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(36,71,36,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(37,71,37,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(38,71,38,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(39,71,39,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(40,71,40,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(41,71,41,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(42,71,42,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(43,71,43,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(44,71,44,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(45,71,45,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(46,71,46,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(47,71,47,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(48,71,48,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(49,71,49,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(50,71,50,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(51,71,51,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(52,71,52,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(53,71,53,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(54,71,54,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(55,71,55,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(56,71,56,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(57,71,57,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(58,71,58,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(59,71,59,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(60,71,60,NULL,NULL,NULL,NULL,NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(63,104,63,'MEC 1',NULL,'0.png',NULL,NULL,'2024-11-06 23:57:56','2024-11-07 00:08:15'),(64,104,64,NULL,NULL,NULL,NULL,NULL,'2024-11-06 23:58:18','2024-11-06 23:58:18'),(65,104,65,NULL,NULL,NULL,NULL,NULL,'2024-11-07 00:06:29','2024-11-07 00:06:29'),(66,104,66,NULL,NULL,NULL,NULL,NULL,'2024-11-07 00:06:29','2024-11-07 00:06:29'),(67,104,67,NULL,NULL,NULL,NULL,NULL,'2024-11-07 00:06:29','2024-11-07 00:06:29'),(68,104,68,NULL,NULL,NULL,NULL,NULL,'2024-11-07 00:06:29','2024-11-07 00:06:29'),(69,104,69,NULL,NULL,NULL,NULL,NULL,'2024-11-07 00:06:29','2024-11-07 00:06:29'),(70,104,70,NULL,NULL,NULL,NULL,NULL,'2024-11-07 00:06:29','2024-11-07 00:06:29'),(71,104,71,NULL,NULL,NULL,NULL,NULL,'2024-11-07 00:15:05','2024-11-07 00:15:05');
/*!40000 ALTER TABLE `buque_sistemas_buque` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `buque_sistemas_equipos`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `buque_sistemas_equipos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `diagrama_id` bigint unsigned DEFAULT NULL,
  `buque_id` bigint unsigned NOT NULL,
  `sistemas_equipos_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `mec` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observaciones` text COLLATE utf8mb4_unicode_ci,
  `mision` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `buque_sistemas_equipos_buque_id_foreign` (`buque_id`),
  KEY `buque_sistemas_equipos_sistemas_equipos_id_foreign` (`sistemas_equipos_id`),
  KEY `buque_sistemas_equipos_diagrama_id_foreign` (`diagrama_id`),
  CONSTRAINT `buque_sistemas_equipos_buque_id_foreign` FOREIGN KEY (`buque_id`) REFERENCES `buques` (`id`) ON DELETE CASCADE,
  CONSTRAINT `buque_sistemas_equipos_diagrama_id_foreign` FOREIGN KEY (`diagrama_id`) REFERENCES `diagramas` (`id`),
  CONSTRAINT `buque_sistemas_equipos_sistemas_equipos_id_foreign` FOREIGN KEY (`sistemas_equipos_id`) REFERENCES `sistemas_equipos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=243 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buque_sistemas_equipos`
--

LOCK TABLES `buque_sistemas_equipos` WRITE;
/*!40000 ALTER TABLE `buque_sistemas_equipos` DISABLE KEYS */;
INSERT INTO `buque_sistemas_equipos` VALUES (90,NULL,83,5,'2024-07-12 19:37:16','2024-10-18 01:12:12','MEC 1',NULL,'0.png','{\"pregunta1\":\"Esto es una prueba para 1\",\"pregunta2\":\"Esto es una prueba 2\",\"pregunta3\":\"Esto es una prueba para 2\",\"pregunta4\":\"Prueba 3\",\"pregunta5\":\"Prueba 4\",\"pregunta6\":\"Prueba 5\"}',NULL),(91,NULL,83,9,'2024-07-12 19:37:16','2024-10-18 01:11:07','MEC 1',NULL,'0.png',NULL,NULL);
/*!40000 ALTER TABLE `buque_sistemas_equipos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `buques`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `buques` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `nombre_proyecto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_buque` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion_proyecto` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `autonomia_horas` int NOT NULL,
  `horas_navegacion_anual` int DEFAULT NULL,
  `vida_diseno` int DEFAULT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `col_cargo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `col_nombre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `col_entidad` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `misiones` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  PRIMARY KEY (`id`),
  KEY `buques_user_id_foreign` (`user_id`),
  CONSTRAINT `buques_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `buques_chk_1` CHECK (json_valid(`misiones`))
) ENGINE=InnoDB AUTO_INCREMENT=170 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buques`
--

LOCK TABLES `buques` WRITE;
/*!40000 ALTER TABLE `buques` DISABLE KEYS */;
INSERT INTO `buques` VALUES (29,1,'BICM','Buque de Investigación Científico Marítima','Buque de investigación científica marina multifuncional, especializado principalmente en oceanografía. Su función primaria es realizar levantamientos hidrográficos y geofísicos del fondo marino. Además, está equipado para llevar a cabo operaciones secundarias como búsqueda y rescate, asistencia humanitaria, apoyo logístico, mantenimiento de ayudas a la navegación y protección del ambiente marino. Esta embarcación versátil combina capacidades científicas avanzadas.',2400,45,123,'buques/nbofyUnt63iQr7ETYie6Ovuu4fe8bsSqmonBnHIf.jpg','2024-05-15 21:55:37','2024-12-04 14:18:15',NULL,NULL,NULL,'[\"Ayuda Humanitaria\",\"Combate contra el terrorismo\"]'),(71,1,'Bote Insular de DIMAR','Bote Interceptor','Misión General:  Ejecutar operaciones para aumentar el control del tráfico marítimo, realizar inspecciones en zonas de fondeo, muelles, canales de acceso, bienes de uso público y litorales; así como aumentar el control de los deportes náuticos, a eventos de contaminación, apoyar las actividades de investigación científico-marina y realizar operaciones de búsqueda y rescate en coordinación con el componente operacional de Guardacostas de la ARC.',144,1000,20,'buques/LjsU40vEnSx15gdFcFDGMJjfe7PCUcxdi16NdPdm.jpg','2024-05-28 01:20:38','2024-12-19 17:42:20',NULL,NULL,NULL,'[\"Ayuda Humanitaria\",\"Combate a la pirater\\u00eda\"]'),(83,1,'Bote Arcangel II','Bote de interdicción marítima.','Llevar a cabo operaciones de interdicción marítima y asegurar la seguridad y control del tráfico en las aguas nacionales. Está equipado para realizar misiones de búsqueda y rescate, garantizando la protección de la vida humana en el mar. Además, el buque está preparado para participar en operaciones de paz y proporcionar ayuda humanitaria en situaciones de emergencia.',23,NULL,NULL,'buques/imLwEcYtdGnAQuwGdyX5HGJV6VCvwVEZmIbWcz8D.png','2024-06-17 10:50:39','2024-07-12 19:37:16',NULL,NULL,NULL,NULL),(104,1,'PATRULLERA OCEÁNICA COLOMBIANA','POC','Misión General: Ejecutar operaciones navales en tiempo de paz o de guerra con el propósito de contribuir al cumplimiento de la función constitucional de la Armada Nacional, contribuyendo a la represión de conductas delictivas en el mar, amenazas y riesgos que se presentan en las aguas jurisdiccionales colombianas, que a su vez afectan las condiciones de seguridad de los colombianos, los bienes, los activos y el medio ambiente.',2500,1231,125,'buques/ctkAIN2ALn4FyRABV1GGLcZlUMIzHpiRMpQ65jwS.jpg','2024-07-19 01:43:34','2024-12-04 17:16:19',NULL,NULL,NULL,'[\"Ayuda Humanitaria\"]');
/*!40000 ALTER TABLE `buques` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('178a5c5bf60b5e2980f67a9504831f3f','i:1;',1735245923),('178a5c5bf60b5e2980f67a9504831f3f:timer','i:1735245923;',1735245923),('7d99799802224d289aa5f578cec297d0','i:1;',1737546992),('7d99799802224d289aa5f578cec297d0:timer','i:1737546992;',1737546992);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `colaboradores`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `colaboradores` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `buque_id` bigint unsigned NOT NULL,
  `col_cargo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `col_nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `col_entidad` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `colaboradores_buque_id_foreign` (`buque_id`),
  CONSTRAINT `colaboradores_buque_id_foreign` FOREIGN KEY (`buque_id`) REFERENCES `buques` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=573 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `colaboradores`
--

LOCK TABLES `colaboradores` WRITE;
/*!40000 ALTER TABLE `colaboradores` DISABLE KEYS */;
INSERT INTO `colaboradores` VALUES (62,83,'Capitán de Corbeta','Edwin Paipa Sanabria','Cotecmar','2024-07-18 20:56:30','2024-07-18 20:56:30'),(63,83,'Auxiliar de Diseño','Joan Suarez Loaisa','Cotecmar','2024-07-18 20:56:30','2024-07-18 20:56:30'),(486,29,'Capitán de Corbeta','Edwin Paipa Sanabria','Cotecmar','2024-12-04 17:13:26','2024-12-04 17:13:26'),(487,29,'Ingeniero de Confiabilidad','Joan Suarez Loaiza','Cotecmar','2024-12-04 17:13:26','2024-12-04 17:13:26'),(488,29,'Auxiliar de Diseño','Jhonattan Llamas Reinoso','Cotecmar','2024-12-04 17:13:26','2024-12-04 17:13:26'),(569,71,'Capitán de Corberta','Edwin Paipa Sanabria','Cotecmar','2024-12-19 17:42:20','2024-12-19 17:42:20'),(570,71,'Ingeniero de Confiabilidad','Joan Suarez Loaiza Cotecmar','Cotecmar','2024-12-19 17:42:20','2024-12-19 17:42:20'),(571,71,'Ingeniero de Confiabilidad','Victor Gregorio Baca Rodriguez','Cotecmar','2024-12-19 17:42:20','2024-12-19 17:42:20'),(572,71,'Ingeniero Mecatrónico','Angel De Jesús Tuñón Cuello','Cotecmar','2024-12-19 17:42:20','2024-12-19 17:42:20');
/*!40000 ALTER TABLE `colaboradores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `diagramas`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `diagramas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ruta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `diagramas`
--

LOCK TABLES `diagramas` WRITE;
/*!40000 ALTER TABLE `diagramas` DISABLE KEYS */;
INSERT INTO `diagramas` VALUES (1,'diagramas/0.png',NULL,NULL),(2,'diagramas/100.png',NULL,NULL),(3,'diagramas/110.png',NULL,NULL),(4,'diagramas/1110.png',NULL,NULL),(5,'diagramas/10100.png',NULL,NULL),(6,'diagramas/10101.png',NULL,NULL),(7,'diagramas/10111.png',NULL,NULL),(8,'diagramas/101100.png',NULL,NULL),(9,'diagramas/101101.png',NULL,NULL),(10,'diagramas/111100.png',NULL,NULL),(11,'diagramas/111101.png',NULL,NULL),(12,'diagramas/111111.png',NULL,NULL);
/*!40000 ALTER TABLE `diagramas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupos_constructivos`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `grupos_constructivos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `grupo_constructivo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupos_constructivos`
--

LOCK TABLES `grupos_constructivos` WRITE;
/*!40000 ALTER TABLE `grupos_constructivos` DISABLE KEYS */;
INSERT INTO `grupos_constructivos` VALUES (1,'100','Casco y Estructuras','2024-08-21 21:45:59','2024-08-21 21:45:59'),(2,'200','Máquinaria y Propulsión','2024-08-21 21:45:59','2024-08-21 21:45:59'),(3,'300','Planta Eléctrica','2024-08-21 21:45:59','2024-08-21 21:45:59'),(4,'400','Comando y Vigilancia','2024-08-21 21:45:59','2024-08-21 21:45:59'),(5,'500','Sistemas Auxiliares','2024-08-21 21:45:59','2024-08-21 21:45:59'),(6,'600','Acabados y Amoblamiento','2024-08-21 21:45:59','2024-08-21 21:45:59'),(7,'700','Armamento','2024-08-21 21:45:59','2024-08-21 21:45:59');
/*!40000 ALTER TABLE `grupos_constructivos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2024_05_08_134213_add_two_factor_columns_to_users_table',1),(5,'2024_05_08_134242_create_personal_access_tokens_table',1),(6,'2024_05_08_162231_add_two_factor_confirmed_at_to_users_table',2),(7,'2024_05_15_143044_create_buques_table',3),(8,'2024_05_15_145958_add_image_to_buques_table',4),(9,'2024_05_16_151713_create_permission_tables',5),(10,'2024_05_22_134916_add_id_to_sistemas_equipos_table',6),(11,'2024_05_22_135123_create_buque_sistemas_equipos_table',7),(12,'2024_05_24_175401_add_mec_to_buque_sistemas_equipos_table',8),(13,'2024_05_27_073231_add_titulo_to_buque_sistemas_equipos_table',9),(14,'2024_05_30_044024_add_image_to_buque_sistemas_equipos_table',10),(15,'2024_06_04_021110_add_colaboradores_to_buque_sistemas_equipos_table',11),(16,'2024_06_04_024027_create_colaboradores_table',12),(17,'2024_06_04_032939_add_colaboradores_to_buques_table',13),(18,'2024_06_04_053152_drop_colaboradores_column_from_buques_table',14),(19,'2024_06_04_053322_add_colab_id_to_buques_table',15),(20,'2024_06_04_055656_remove_colab_id_from_buques_table',16),(21,'2024_06_04_055747_drop_colaboradores_table',16),(22,'2024_06_04_055805_add_colaboradores_fields_to_buques_table',16),(23,'2024_06_04_074438_remove_colaboradores_from_buque_sistemas_equipos_table',17),(24,'2024_06_04_075153_create_colaboradores_table',18),(25,'2024_06_17_055612_create_misiones_table',19),(26,'2024_06_17_140318_update_misiones_table_add_operacion',20),(27,'2024_06_20_061757_create_diagramas_table',21),(28,'2024_06_20_062137_add_diagrama_id_to_buque_sistemas_equipos_table',22),(29,'2024_07_11_210801_create_sistemas_table',23),(30,'2024_07_18_185937_add_observaciones_to_buque_sistemas_equipos_table',24),(31,'2024_07_25_183600_add_mision_to_buque_sistemas_equipos_table',25),(32,'2024_07_30_140819_add_misiones_to_buques_table',26),(33,'2024_07_30_164446_create_buque_misiones_table',27),(34,'2024_07_30_165443_create_buque_misions_table',28),(35,'2024_07_30_184214_update_potencia_column_in_buque_misiones_table',28),(36,'2024_08_21_163720_create_sistemas_table',29),(37,'2024_08_21_163842_create_buque_sistema_table',29),(38,'2024_09_30_160243_add_horas_navegacion_anual_to_buques_table',30),(39,'2024_10_11_155502_rename_sistemas_to_grupos_constructivos',31),(40,'2024_10_11_155910_create_sistemas_table',32),(41,'2024_10_16_185311_add_timestamps_to_sistemas_equipos',33),(42,'2024_10_29_165219_create_sistemas_buque_table',34),(43,'2024_10_29_192920_add_buque_id_to_sistemas_buque_table',34),(44,'2024_10_29_201519_create_buque_sistemas_buque_table',34),(45,'2024_11_25_232355_add_vida_diseno_to_buques_table',35),(46,'2024_11_25_234447_create_buque_fua_table',36),(47,'2024_11_25_234642_create_buque_fuas_table',37),(48,'2024_11_26_003930_add_mant_basico_3_to_buque_fua_table',37),(49,'2024_11_26_010614_add_disponibilidad_columns_to_buque_fua',38),(50,'2024_11_26_140301_create_tablas_fua_table',39),(51,'2024_11_26_150504_rename_horas_año_to_horas_ano_in_tablas_fua',40),(52,'2024_11_27_181257_update_velocidad_column_in_buque_misiones_table',41),(53,'2024_12_02_124438_drop_buque_misiones_table',42),(54,'2024_12_02_124604_create_buque_misiones_table',43);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `misiones`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `misiones` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `buque_id` bigint unsigned NOT NULL,
  `suboperacion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `operacion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `misiones_buque_id_foreign` (`buque_id`),
  CONSTRAINT `misiones_buque_id_foreign` FOREIGN KEY (`buque_id`) REFERENCES `buques` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `misiones`
--

LOCK TABLES `misiones` WRITE;
/*!40000 ALTER TABLE `misiones` DISABLE KEYS */;
/*!40000 ALTER TABLE `misiones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (3,'App\\Models\\User',1),(10,'App\\Models\\User',3),(10,'App\\Models\\User',8);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
INSERT INTO `password_reset_tokens` VALUES ('snieto@cotecmar.com','$2y$12$NvTkwWV5aL4hkSo1PbhcYOlZmnHCMxVvTTWUstdhX9.CxIssG4L7e','2024-05-16 00:19:46');
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (3,'Administrador','sanctum','2024-05-16 21:25:38','2024-05-16 21:25:38'),(4,'Usuario','sanctum','2024-05-16 21:25:44','2024-05-16 21:25:44'),(10,'Auxiliar de Diseño','sanctum','2024-05-16 22:20:45','2024-05-16 22:20:45');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('0l0UpkAVtjBXs14M0kKc617cspaPJXgnPSemj48D',1,'172.18.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36','YTo2OntzOjY6Il90b2tlbiI7czo0MDoiYlRTZUx4UVR2Z2pIVlEzNHZNRnVPYmh4bFU1dTRjeUVPblJNRkg0ZSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM2OiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYnVxdWVzLzcxL2VkaXQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MjE6InBhc3N3b3JkX2hhc2hfc2FuY3R1bSI7czo2MDoiJDJ5JDEyJHo5SURPY010djN4dWl4VnFCdHQzd084SzBLMmFBRS42cEpsS3pzT3pjT2IyRTlOaG1iSnh1Ijt9',1737061991),('22WgMnglSH3zcMibrhRm749R8TiUutRBkhIXY4rj',1,'172.18.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36','YTo2OntzOjY6Il90b2tlbiI7czo0MDoiSkNmM3RpZ3ZqSWNzOVhmR2dVQ3FWNTI2bnZRUnN0U3NITlZ0UEx1bCI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI4OiJodHRwOi8vbG9jYWxob3N0OjgwMDAvbHNhLzcxIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjIxOiJwYXNzd29yZF9oYXNoX3NhbmN0dW0iO3M6NjA6IiQyeSQxMiR6OUlET2NNdHYzeHVpeFZxQnR0M3dPOEswSzJhQUUuNnBKbEt6c096Y09iMkU5TmhtYkp4dSI7fQ==',1737074530),('5ewCEhNI6wTI9cikRV6tpBtk5OTNrSgJyfq2J3dU',1,'172.18.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiaUdrSWhTeHRtVzJCNmRYV1R5d0FDNEx6cnpwTkpiZ2NJZW1wRmR0WiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9idXF1ZXMvNzEvZWRpdCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoyMToicGFzc3dvcmRfaGFzaF9zYW5jdHVtIjtzOjYwOiIkMnkkMTIkejlJRE9jTXR2M3h1aXhWcUJ0dDN3TzhLMEsyYUFFLjZwSmxLenNPemNPYjJFOU5obWJKeHUiO30=',1737126250),('7Fz6zpuxWEQc1ciCV4FgaBFUkyZVU6BaeiVF8Gmw',1,'172.18.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36 Edg/132.0.0.0','YTo2OntzOjY6Il90b2tlbiI7czo0MDoieEhoUGtBNTluRXFST1lkeE5Cc3JNaGtuZG0yanRSTUtpYW51Yk5PSCI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI4OiJodHRwOi8vbG9jYWxob3N0OjgwMDAvbHNhLzcxIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjIxOiJwYXNzd29yZF9oYXNoX3NhbmN0dW0iO3M6NjA6IiQyeSQxMiR6OUlET2NNdHYzeHVpeFZxQnR0M3dPOEswSzJhQUUuNnBKbEt6c096Y09iMkU5TmhtYkp4dSI7fQ==',1737488843),('9agMUCbJZBYjTk14VDnfe2Mb47Jh8WcTNO0JgFTm',1,'172.18.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36','YTo2OntzOjY6Il90b2tlbiI7czo0MDoiT01Wa210TFlhbE1jbUhuMFN5Z29KdzYxc3l1SUhTcUJNazNqd21KdSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQyOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYnVxdWVzLzcxL2V4cG9ydC1wZGYiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MjE6InBhc3N3b3JkX2hhc2hfc2FuY3R1bSI7czo2MDoiJDJ5JDEyJHo5SURPY010djN4dWl4VnFCdHQzd084SzBLMmFBRS42cEpsS3pzT3pjT2IyRTlOaG1iSnh1Ijt9',1737491464),('CccP7jJq13fb5SfosVuxsSK2QmDPcqQseMYZ7Goy',NULL,'172.18.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiaWJpRlZKOUZsemZiSUVUNEhUWFNhY2VxQ2pySDJGajFMQVZpQU9EQiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1737461820),('Hsn7f6FYz6Pe459h5Rk4xovC6b7xbetIDGwQcVq0',1,'172.18.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36','YTo2OntzOjY6Il90b2tlbiI7czo0MDoiVklyMHNBdk5Xb1dHTzRCRzhDakFCRE9VOXRRazltdkV0UkpPRUZYMyI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM2OiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYnVxdWVzLzcxL2VkaXQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MjE6InBhc3N3b3JkX2hhc2hfc2FuY3R1bSI7czo2MDoiJDJ5JDEyJHo5SURPY010djN4dWl4VnFCdHQzd084SzBLMmFBRS42cEpsS3pzT3pjT2IyRTlOaG1iSnh1Ijt9',1737143227),('oNzJIDkSUkxcvfCh1Gr6b6VB22nskA1n9pXPgp1H',1,'172.18.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoieFVaMk16MGhiUURTaklDODYwdWlmb0g5YlMzbGlXWm1tUlV4aWdlQSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sc2EvNzEiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MjE6InBhc3N3b3JkX2hhc2hfc2FuY3R1bSI7czo2MDoiJDJ5JDEyJHo5SURPY010djN4dWl4VnFCdHQzd084SzBLMmFBRS42cEpsS3pzT3pjT2IyRTlOaG1iSnh1Ijt9',1737461872),('QNlE9VUA7CQi6MYVBvQhuZ66bSLZVWKqZjmYjI2w',1,'172.18.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36','YTo2OntzOjY6Il90b2tlbiI7czo0MDoiV1pVbHlpbnRqOVdBWGpkQXRKcGZHTXNOZTZvZFA3bHVqQzY1TnFNcSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI4OiJodHRwOi8vbG9jYWxob3N0OjgwMDAvbHNhLzcxIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjIxOiJwYXNzd29yZF9oYXNoX3NhbmN0dW0iO3M6NjA6IiQyeSQxMiR6OUlET2NNdHYzeHVpeFZxQnR0M3dPOEswSzJhQUUuNnBKbEt6c096Y09iMkU5TmhtYkp4dSI7fQ==',1737546981),('U7E0RZtcaKjYLcWgqJ6TEL4mbDwGKNDPib9bP6JA',1,'172.18.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiMVNRRE9WNEtoOVhHWnN6U1I3M3hBaFFybndDcnRkNkZYQ2VvVVpWVyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sc2EvNzEiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MjE6InBhc3N3b3JkX2hhc2hfc2FuY3R1bSI7czo2MDoiJDJ5JDEyJHo5SURPY010djN4dWl4VnFCdHQzd084SzBLMmFBRS42cEpsS3pzT3pjT2IyRTlOaG1iSnh1Ijt9',1737033983),('w4RTBGaPhRFOgP4yOFuRLj37ASFnfEjddUUcy34V',NULL,'172.18.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoieFBJM2dSYkRaZ1dTQmczNkNmYjlxWXdDV2pwOE1ySVR3anVSazJhQyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fX0=',1736954454);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sistemas`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sistemas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `cj` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sistemas_cj_unique` (`cj`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sistemas`
--

LOCK TABLES `sistemas` WRITE;
/*!40000 ALTER TABLE `sistemas` DISABLE KEYS */;
/*!40000 ALTER TABLE `sistemas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sistemas_buque`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sistemas_buque` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `buque_id` bigint unsigned NOT NULL,
  `codigo` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sistemas_buque_buque_id_foreign` (`buque_id`),
  CONSTRAINT `sistemas_buque_buque_id_foreign` FOREIGN KEY (`buque_id`) REFERENCES `buques` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sistemas_buque`
--

LOCK TABLES `sistemas_buque` WRITE;
/*!40000 ALTER TABLE `sistemas_buque` DISABLE KEYS */;
INSERT INTO `sistemas_buque` VALUES (1,71,'233','MAIN PROPULSION',NULL,'2024-11-06 20:45:03','2024-11-06 20:45:03'),(2,71,'256','CIRCULATING AND COOLING SEAWATER SYSTEM',NULL,'2024-11-06 20:45:03','2024-11-06 20:45:03'),(3,71,'261','MAIN PROPULSION FUEL TANKS',NULL,'2024-11-06 20:45:03','2024-11-06 20:45:03'),(4,71,'264','MAIN PROPULSION LUBE OIL SYSTEM',NULL,'2024-11-06 20:45:03','2024-11-06 20:45:03'),(5,71,'301','POWER DISTRIBUTION GENERAL ARRANGEMENT',NULL,'2024-11-06 20:45:03','2024-11-06 20:45:03'),(6,71,'321','AC ELECTRICAL',NULL,'2024-11-06 20:45:03','2024-11-06 20:45:03'),(7,71,'320','DC ELECTRICAL',NULL,'2024-11-06 20:45:03','2024-11-06 20:45:03'),(8,71,'341','COMMAND AND SURVEILLANCE GENERAL ARRANGEMENT',NULL,'2024-11-06 20:45:03','2024-11-06 20:45:03'),(9,71,'583','SHIPPING CRADLE',NULL,'2024-11-06 20:45:03','2024-11-06 20:45:03'),(10,71,'612','HVAC SYSTEM',NULL,'2024-11-06 20:45:03','2024-11-06 20:45:03'),(11,71,'512','ER VENTILATION SYSTEM',NULL,'2024-11-06 20:45:03','2024-11-06 20:45:03'),(12,71,'531','BILGE SYSTEM PIPING',NULL,'2024-11-06 20:45:03','2024-11-06 20:45:03'),(13,71,'533','FRESH WATER SERVICE',NULL,'2024-11-06 20:45:03','2024-11-06 20:45:03'),(14,71,'532','ER FIRE SUPPRESSION',NULL,'2024-11-06 20:45:03','2024-11-06 20:45:03'),(15,71,'593','WASTE WATER SYSTEM',NULL,'2024-11-06 20:45:03','2024-11-06 20:45:03'),(16,71,'712','HOISTING AND TRANSPORTABILITY ARRANGEMENT',NULL,'2024-11-06 20:45:03','2024-11-06 20:45:03'),(17,71,'801','ANTIDESLIZANTE',NULL,'2024-11-06 20:45:03','2024-11-06 20:45:03'),(18,71,'801','General Arrangements Drawing',NULL,'2024-11-06 20:45:03','2024-11-06 20:45:03'),(19,71,'801','BOOKLET OF GENERAL PLANS',NULL,'2024-11-06 20:45:03','2024-11-06 20:45:03'),(20,71,'995','CUNA PARA CONSTRUCCION',NULL,'2024-11-06 20:45:03','2024-11-06 20:45:03'),(21,71,'233','MAIN PROPULSION',NULL,'2024-11-06 20:55:46','2024-11-06 20:55:46'),(22,71,'256','CIRCULATING AND COOLING SEAWATER SYSTEM',NULL,'2024-11-06 20:55:46','2024-11-06 20:55:46'),(23,71,'261','MAIN PROPULSION FUEL TANKS',NULL,'2024-11-06 20:55:46','2024-11-06 20:55:46'),(24,71,'264','MAIN PROPULSION LUBE OIL SYSTEM',NULL,'2024-11-06 20:55:46','2024-11-06 20:55:46'),(25,71,'301','POWER DISTRIBUTION GENERAL ARRANGEMENT',NULL,'2024-11-06 20:55:46','2024-11-06 20:55:46'),(26,71,'321','AC ELECTRICAL',NULL,'2024-11-06 20:55:46','2024-11-06 20:55:46'),(27,71,'320','DC ELECTRICAL',NULL,'2024-11-06 20:55:46','2024-11-06 20:55:46'),(28,71,'341','COMMAND AND SURVEILLANCE GENERAL ARRANGEMENT',NULL,'2024-11-06 20:55:46','2024-11-06 20:55:46'),(29,71,'583','SHIPPING CRADLE',NULL,'2024-11-06 20:55:46','2024-11-06 20:55:46'),(30,71,'612','HVAC SYSTEM',NULL,'2024-11-06 20:55:46','2024-11-06 20:55:46'),(31,71,'512','ER VENTILATION SYSTEM',NULL,'2024-11-06 20:55:46','2024-11-06 20:55:46'),(32,71,'531','BILGE SYSTEM PIPING',NULL,'2024-11-06 20:55:46','2024-11-06 20:55:46'),(33,71,'533','FRESH WATER SERVICE',NULL,'2024-11-06 20:55:46','2024-11-06 20:55:46'),(34,71,'532','ER FIRE SUPPRESSION',NULL,'2024-11-06 20:55:46','2024-11-06 20:55:46'),(35,71,'593','WASTE WATER SYSTEM',NULL,'2024-11-06 20:55:46','2024-11-06 20:55:46'),(36,71,'712','HOISTING AND TRANSPORTABILITY ARRANGEMENT',NULL,'2024-11-06 20:55:46','2024-11-06 20:55:46'),(37,71,'801','ANTIDESLIZANTE',NULL,'2024-11-06 20:55:46','2024-11-06 20:55:46'),(38,71,'801','General Arrangements Drawing',NULL,'2024-11-06 20:55:46','2024-11-06 20:55:46'),(39,71,'801','BOOKLET OF GENERAL PLANS',NULL,'2024-11-06 20:55:46','2024-11-06 20:55:46'),(40,71,'995','CUNA PARA CONSTRUCCION',NULL,'2024-11-06 20:55:46','2024-11-06 20:55:46'),(41,71,'233','MAIN PROPULSION',NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(42,71,'256','CIRCULATING AND COOLING SEAWATER SYSTEM',NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(43,71,'261','MAIN PROPULSION FUEL TANKS',NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(44,71,'264','MAIN PROPULSION LUBE OIL SYSTEM',NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(45,71,'301','POWER DISTRIBUTION GENERAL ARRANGEMENT',NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(46,71,'321','AC ELECTRICAL',NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(47,71,'320','DC ELECTRICAL',NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(48,71,'341','COMMAND AND SURVEILLANCE GENERAL ARRANGEMENT',NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(49,71,'583','SHIPPING CRADLE',NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(50,71,'612','HVAC SYSTEM',NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(51,71,'512','ER VENTILATION SYSTEM',NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(52,71,'531','BILGE SYSTEM PIPING',NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(53,71,'533','FRESH WATER SERVICE',NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(54,71,'532','ER FIRE SUPPRESSION',NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(55,71,'593','WASTE WATER SYSTEM',NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(56,71,'712','HOISTING AND TRANSPORTABILITY ARRANGEMENT',NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(57,71,'801','ANTIDESLIZANTE',NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(58,71,'801','General Arrangements Drawing',NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(59,71,'801','BOOKLET OF GENERAL PLANS',NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(60,71,'995','CUNA PARA CONSTRUCCION',NULL,'2024-11-06 21:10:11','2024-11-06 21:10:11'),(63,104,'111','aa','aa','2024-11-06 23:57:56','2024-11-06 23:57:56'),(64,104,'113','aaa','aaa','2024-11-06 23:58:18','2024-11-06 23:58:18'),(65,104,'211','Testing2','aa','2024-11-07 00:06:29','2024-11-07 00:06:29'),(66,104,'311','Testing3','aa','2024-11-07 00:06:29','2024-11-07 00:06:29'),(67,104,'411','Testing4','','2024-11-07 00:06:29','2024-11-07 00:06:29'),(68,104,'511','Testing5','','2024-11-07 00:06:29','2024-11-07 00:06:29'),(69,104,'611','Testing6','','2024-11-07 00:06:29','2024-11-07 00:06:29'),(70,104,'711','Testing7','','2024-11-07 00:06:29','2024-11-07 00:06:29'),(71,104,'100','Prueba','aa','2024-11-07 00:15:05','2024-11-07 00:15:05'),(81,29,'111','Prueba','aa','2024-12-02 19:16:45','2024-12-02 19:16:45'),(82,29,'111','aa','aa','2024-12-04 13:28:15','2024-12-04 13:28:15'),(83,29,'111','asa','asa','2024-12-04 13:28:26','2024-12-04 13:28:26'),(84,71,'111','Prueba','a','2024-12-19 15:08:42','2024-12-19 15:08:42');
/*!40000 ALTER TABLE `sistemas_buque` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sistemas_equipos`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sistemas_equipos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `mfun` int NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2388 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sistemas_equipos`
--

LOCK TABLES `sistemas_equipos` WRITE;
/*!40000 ALTER TABLE `sistemas_equipos` DISABLE KEYS */;
INSERT INTO `sistemas_equipos` VALUES (1,1,'Estructura del casco'),(2,10,'Planos estructurales y de disposicion general'),(3,101,'Planos estructurales y de disposicion general'),(4,1011,'Planos estructurales y de disposicion general'),(5,10111,'Planos estructurales y de disposicion general'),(6,11,'Forro exterior / refuerzos estructurales'),(7,110,'Obra viva y Obra muerta'),(8,1101,'Obra viva'),(9,11011,'Obra viva'),(10,1102,'Obra muerta'),(11,11021,'Obra muerta'),(12,111,'Submarinos. Casco resistente. Buques de superficie. Forro exterior '),(13,1111,'Submarinos. Casco resistente. Buques de superficie. Forro exterior '),(14,11111,'Submarinos. Casco resistente'),(15,11112,'Buques de superficie. Forro exterior'),(16,11113,'Submarinos. Pasos del casco resistente'),(17,112,'Submarinos. Casco exterior'),(18,1121,'Submarinos. Casco exterior'),(19,11211,'Submarinos. Casco exterior'),(20,11212,'Submarinos. Pasos del casco no resistente'),(21,113,'Doble fondo'),(22,1131,'Doble fondo'),(23,11311,'Doble fondo'),(24,114,'Apendices del casco'),(25,1141,'Apendices del casco'),(26,11411,'Quillas de balance'),(27,11412,'Defensas de elementos del casco como Hélices, Propulsores, etc'),(28,115,'Puntales'),(29,1151,'Puntales'),(30,11511,'Puntales'),(31,116,'Estructura longitudinal (buques de superficie) y del casco resistente (submarinos)'),(32,1161,'Buques de superficie. Estructura longitudinal'),(33,11611,'Buques de superficie. Estructura longitudinal'),(34,1162,'Submarinos. Estructura longitudinal del casco resistente'),(35,11621,'Submarinos. Estructura longitudinal del casco resistente'),(36,117,'Estructura transversal (buques de superficie) y del casco resistente (submarinos)'),(37,1171,'Buques de superficie. Estructura transversal'),(38,11711,'Buques de superficie. Estructura transversal'),(39,1172,'Submarinos. Estructura transversal del casco resistente'),(40,11721,'Submarinos. Estructura transversal del casco resistente'),(41,118,'Submarinos. Casco exterior. Estructura longitudinal y transversal'),(42,1181,'Submarinos. Casco exterior. Estructura longitudinal y transversal'),(43,11811,'Submarinos. Casco exterior. Estructura longitudinal y transversal'),(44,119,'Aerodeslizadores (Hovercrafts). Faldillas y obturadores del sistema de sustentacion'),(45,12,'Mamparos estructurales y tanques'),(46,121,'Mamparos estructurales longitudinales'),(47,1211,'Mamparos estructurales longitudinales'),(48,12111,'Mamparos estructurales longitudinales'),(49,122,'Mamparos estructurales transversales'),(50,1221,'Submarinos. Mamparos estructurales transversales. '),(51,12211,'Submarinos. Mamparos estructurales transversales. '),(52,1222,'Buques de superficie. Mamparos estructurales transversales'),(53,12221,'Buques de superficie. Mamparos estructurales transversales'),(54,123,'Tanques, troncos y espacios cerrados'),(55,1231,'Tanques'),(56,12311,'Tanques de gas-oil'),(57,12312,'Tanques de JP-5'),(58,12313,'Tanques de agua de alimentacion de calderas'),(59,12314,'Tanques de agua potable'),(60,12315,'Tanques de aceite lubricante'),(61,12316,'Tanques de lastre'),(62,12317,'Tanques de aceite contaminado'),(63,12318,'Tanques de gasolina'),(64,12319,'Tanques de aguas residuales orgánicas'),(65,1231,'Tanques de agua nebulizada'),(66,1232,'Troncos, huecos y cofferdams'),(67,12321,'Troncos y huecos'),(68,12322,'Cofferdams'),(69,1233,'Submarinos. Troncos y espacios cerrados'),(70,12331,'Submarinos. Troncos y espacios cerrados'),(71,124,'Mamparos de proteccion contra torpedos'),(72,1241,'Mamparos de proteccion contra torpedos'),(73,12411,'Mamparos de proteccion contra torpedos'),(74,125,'Submarinos. Tanques resistentes'),(75,1251,'Submarinos. Tanques resistentes'),(76,12511,'Submarinos. Tanques resistentes'),(77,126,'Submarinos. Tanques no resistentes'),(78,1261,'Submarinos. Tanques integrados no resistentes'),(79,12611,'Submarinos. Tanques integrados no resistentes. Sección 1'),(80,12612,'Submarinos. Tanques integrados no resistentes. Sección 2'),(81,12613,'Submarinos. Tanques integrados no resistentes. Sección 3'),(82,12614,'Submarinos. Tanques integrados no resistentes. Sección 4'),(83,12615,'Submarinos. Tanques integrados no resistentes. Sección 5'),(84,1262,'Submarinos. Tanques integrados intermedios'),(85,12621,'Submarinos. Tanques integrados intermedios'),(86,13,'Cubiertas'),(87,130,'Cubiertas'),(88,1301,'Cubiertas'),(89,13011,'Cubiertas'),(90,131,'Cubierta 1 (Principal)'),(91,1311,'Cubierta 1 (Principal)'),(92,13111,'Cubierta 1 (Principal)'),(93,132,'Cubierta 2'),(94,1321,'Cubierta 2'),(95,13211,'Cubierta 2'),(96,133,'Cubierta 3'),(97,1331,'Cubierta 3'),(98,13311,'Cubierta 3'),(99,134,'Cubierta 4'),(100,1341,'Cubierta 4'),(101,13411,'Cubierta 4'),(102,135,'Cubierta 5 e inferiores'),(103,1351,'Cubierta 5 e inferiores'),(104,136,'Cubierta 01'),(105,1361,'Cubierta 01'),(106,13611,'Cubierta 01'),(107,137,'Cubierta 02'),(108,1371,'Cubierta 02'),(109,13711,'Cubierta 02'),(110,138,'Cubierta 03'),(111,1381,'Cubierta 03'),(112,13811,'Cubierta 03'),(113,139,'Cubierta 04 y superiores'),(114,1391,'Cubierta 04 y superiores'),(115,13911,'Cubierta 04 y superiores'),(116,13,'Superficies para toma de aeronaves'),(117,13,'Cubierta de vuelo'),(118,13,'Cubierta de vuelo'),(119,14,'Cubiertas intermedias no corridas'),(120,140,'Plataformas y plataformas intermedias (documental y administrativo sólo)'),(121,1401,'Plataformas y plataformas intermedias (documental y administrativo sólo)'),(122,14011,'Cubiertas intermedias no corridas (documental y administrativo sólo)'),(123,14012,'Cubiertas intermedias no corridas (documentación técnica general)'),(124,141,'1ª Plataforma'),(125,1411,'Submarinos. Plataformas y plataformas intermedias interiores'),(126,14111,'Submarinos: Plataformas y cubiertas interiores'),(127,1412,'1ª Plataforma'),(128,14121,'1ª Plataforma'),(129,142,'2ª Plataforma'),(130,1421,'2ª Plataforma'),(131,14211,'2ª Plataforma'),(132,143,'3ª Plataforma'),(133,1431,'3ª Plataforma'),(134,14311,'3ª Plataforma'),(135,144,'4ª Plataforma'),(136,1441,'4ª Plataforma'),(137,14411,'4ª Plataforma'),(138,145,'5ª Plataforma'),(139,1451,'5ª Plataforma'),(140,14511,'5ª Plataforma'),(141,149,'Plataformas intermedias'),(142,1491,'Plataformas intermedias'),(143,14911,'Plataformas intermedias'),(144,15,'Superestructura'),(145,150,'Superestructura (documental y administrativo sólo)'),(146,1501,'Superestructura (documental y administrativo sólo)'),(147,15011,'Superestructura (documental y administrativo sólo)'),(148,15012,'Superestructura (documentación técnica general)'),(149,151,'Superestructura. Hasta nivel 01'),(150,1511,'Superestructura. Submarinos'),(151,15111,'Superestructura. Submarinos'),(152,1512,'Superestructura. Hasta nivel 01'),(153,152,'Superestructura. Nivel 01'),(154,1521,'Superestructura. Nivel 01'),(155,15211,'Superestructura. Nivel 01'),(156,153,'Superestructura. Nivel 02'),(157,1531,'Superestructura. Nivel 02'),(158,15311,'Superestructura. Nivel 02'),(159,154,'Superestructura. Nivel 03'),(160,1541,'Superestructura. Nivel 03'),(161,15411,'Superestructura. Nivel 03'),(162,155,'Superestructura. Nivel 04'),(163,1551,'Superestructura. Nivel 04'),(164,15511,'Superestructura. Nivel 04'),(165,156,'Superestructura. Nivel 05'),(166,1561,'Superestructura. Nivel 05'),(167,15611,'Superestructura. Nivel 05'),(168,157,'Superestructura. Nivel 06'),(169,1571,'Superestructura. Nivel 06'),(170,15711,'Superestructura. Nivel 06'),(171,158,'Superestructura. Nivel 07'),(172,1581,'Superestructura. Nivel 07'),(173,15811,'Superestructura. Nivel 07'),(174,159,'Superestructura. Nivel 08 y superiores'),(175,1591,'Superestructura. Nivel 08 y superiores'),(176,15911,'Superestructura. Nivel 08 y superiores'),(177,16,'Estructuras especiales'),(178,161,'Piezas estructurales fundidas, forjadas o soldadas'),(179,1611,'Piezas estructurales fundidas, forjadas o soldadas'),(180,16111,'Piezas estructurales fundidas, forjadas o soldadas'),(181,1612,'Submarinos. Tubo de bocina'),(182,16121,'Submarinos. Tubo de bocina'),(183,162,'Chimeneas y palos-chimenea'),(184,1621,'Chimeneas y palos-chimenea'),(185,16211,'Chimenea y palo-chimenea Nº1'),(186,16212,'Chimenea y palo-chimenea Nº2'),(187,163,'Cajas de toma de mar'),(188,1631,'Cajas de toma de mar'),(189,16311,'Cajas de toma de mar'),(190,164,'Planchas blindadas'),(191,1641,'Planchas blindadas'),(192,16411,'Planchas blindadas'),(193,165,'Domos de sonar'),(194,1651,'Domo de sonar'),(195,16511,'Domos de sonar'),(196,16512,'Domos del sonar. Sistema de presurización'),(197,166,'Alerones y Plataformas'),(198,1661,'Alerones y Plataformas'),(199,16611,'Alerones y Plataformas'),(200,167,'Casco. Cierres estructurales'),(201,1671,'Casco. Puertas estructurales (estancas)'),(202,16711,'Casco. Puertas estancas (cierre manual)'),(203,16712,'Casco. Puertas estancas (cierre rapido)'),(204,16713,'Casco. Puertas estancas (especiales)'),(205,1672,'Casco. Escotillas y registros'),(206,16721,'Casco. Escotillas'),(207,16722,'Casco. Registros y sus tapas'),(208,168,'Superestructura. Cierres estructurales'),(209,1681,'Superestructura. Puertas estancas'),(210,16811,'Superestructura. Puertas estancas (cierre manual)'),(211,16812,'Superestructura. Puertas estancas (cierre rápido)'),(212,1682,'Superestructura. Escotillas'),(213,16821,'Superestructura. Escotillas. (Cierre manual)'),(214,1683,'Cierres estructurales de la superestructura (no estancos)'),(215,16831,'Cierres estructurales de la superestructura (no estancos)'),(216,169,'Cierres y estructuras para fines especiales'),(217,1691,'Cierres y estructuras para fines especiales'),(218,16911,'Cierres y estructuras para fines especiales'),(219,16912,'Escotillas de carga y tapas de bodega'),(220,16913,'Nicho de la RHIB nº1 (Er)'),(221,16914,'Nicho de la RHIB nº2 (Br)'),(222,17,'Palos, mastiles y sus plataformas'),(223,171,'Palos, torres y tetrápodos'),(224,1711,'Palos'),(225,17111,'Palo principal (Proa)'),(226,17112,'Bauprés'),(227,17113,'Trinquete'),(228,17114,'Mayor proel'),(229,17115,'Mayor popel'),(230,17116,'Mesana'),(231,17117,'Palo de popa'),(232,172,'Mastiles y estructuras de soporte'),(233,1721,'Mastiles'),(234,17211,'Mastiles'),(235,173,'Mástil integrado'),(236,1731,'Mástil integrado. Componentes de detección'),(237,17311,'Mástil integrado. Componentes del radar aéreo'),(238,17312,'Mástil integrado. Componentes del radar de superficie'),(239,1732,'Mástil integrado. Componentes de Comunicaciones'),(240,1733,'Mástil integrado. Componentes electro-opticos'),(241,1734,'Mástil integrado. Componentes de EW'),(242,179,'Plataformas de servicio'),(243,1791,'Plataformas de servicio'),(244,17911,'Plataformas de servicio'),(245,18,'Polines, montajes elásticos y sistemas antivibratorios'),(246,181,'Polines estructurales del casco'),(247,1811,'Polines estructurales del casco'),(248,18111,'Polines estructurales del casco'),(249,182,'Polines de la planta propulsora'),(250,1821,'Polines de la planta propulsora'),(251,18211,'Polines de la planta propulsora'),(252,183,'Polines de la planta eléctrica'),(253,1831,'Polines de la planta eléctrica'),(254,18311,'Polines de la planta eléctrica'),(255,184,'Polines para equipos de mando y exploración'),(256,1841,'Polines para equipos de mando y exploración'),(257,18411,'Polines para equipos de mando y exploración'),(258,185,'Polines de sistemas auxiliares'),(259,1851,'Polines de sistemas auxiliares'),(260,18511,'Polines de sistemas auxiliares'),(261,186,'Polines de habitabilidad y equipo'),(262,1861,'Polines de habitabilidad y equipo'),(263,18611,'Polines de habitabilidad y equipo'),(264,187,'Polines de armas'),(265,1871,'Polines de armas'),(266,18711,'Polines de armas'),(267,188,'Montajes elásticos y sistemas antivibratorios'),(268,1881,'Montajes elásticos y sistemas antivibratorios'),(269,18811,'Montajes elásticos y sistemas antivibratorios'),(270,19,'Casco. Sistemas para fines especiales'),(271,191,'Lastre permanente sólido o fluido y material para flotabilidad'),(272,1911,'Lastre permanente'),(273,19111,'Lastre permanente'),(274,1912,'Material de flotabilidad'),(275,19121,'Material de flotabilidad'),(276,192,'Pruebas de compartimentos'),(277,1921,'Pruebas de compartimentos (no tanques)'),(278,19211,'Pruebas de compartimentos (no tanques)'),(279,195,'Construccion de bloques (solamente adelanto)'),(280,1951,'Construccion de bloques (solamente adelanto)'),(281,19511,'Construccion de bloques (solamente adelanto)'),(282,196,'Pruebas de estabilidad'),(283,1961,'Pruebas de estabilidad'),(284,19611,'Pruebas de estabilidad'),(285,197,'Varadas. Entradas y salidas de dique (Antes 8634)'),(286,1971,'Varadas. Entradas y salidas de dique (Antes 8634)'),(287,19711,'Varadas. Entradas y salidas de dique (Antes 8634)'),(288,19712,'Estadías en dique'),(289,198,'Liquidos de libre circulacion'),(290,1981,'Liquidos de libre circulacion'),(291,19811,'Liquidos de libre circulacion'),(292,199,'Repuestos y herramientas especiales del casco'),(293,1991,'Repuestos y piezas diversas del casco'),(294,19911,'Repuestos y piezas diversas del casco'),(295,1992,'Herramientas especiales del casco'),(296,19921,'Herramientas especiales del casco'),(297,2,'Planta propulsora'),(298,20,'Planta propulsora. Especificaciones e informacion general'),(299,201,'Planta propulsora. Disposicion general'),(300,202,'Planta propulsora. Sistemas de control'),(301,21,'Generadores de energia (nucleares)'),(302,212,'Generadores nucleares de vapor'),(303,213,'Reactores nucleares'),(304,214,'Sistemas de refrigeracion del reactor'),(305,215,'Sistema de servicio de refrigeracion del reactor'),(306,216,'Sistemas auxiliares del reactor'),(307,217,'Instrumentacion y control de la planta nuclear'),(308,218,'Sistemas principales de blindaje'),(309,219,'Sistemas secundarios de blindaje'),(310,22,'Generadores de energía (no nucleares)'),(311,221,'Calderas de propulsion'),(312,2211,'Calderas de propulsion'),(313,22111,'Caldera de propulsion nº1'),(314,22112,'Caldera de propulsion nº2'),(315,22113,'Elementos comunes a las calderas 1 y 2'),(316,2212,'Control automatico/manual de calderas'),(317,22121,'Control automatico/manual de calderas'),(318,2213,'Sistema de soplado de calderas'),(319,22131,'Sistema de soplado de calderas'),(320,2214,'Sistemas de seguridad de calderas'),(321,22141,'Sistemas de seguridad de calderas'),(322,2215,'Sistemas de propulsión por recuperación de energía'),(323,22151,'Sistemas de propulsión por recuperación de energía'),(324,222,'Generadores de gas'),(325,2221,'Generadores de gas'),(326,22211,'AIP. Almacenamiento y distribución de oxígeno (EBB)'),(327,22212,'AIP. Almacenamiento y distribución de etanol (EBC)'),(328,22213,'AIP. Sistema de producción de hidrógeno (EBD)'),(329,22214,'AIP. Sistema de eliminación de CO2 (EBE)'),(330,22215,'AIP. Sistema de compensación de pesos Oxígeno-Etanol (EBF)'),(331,22216,'AIP. Sistema de inertización (EBG)'),(332,22217,'AIP. Control centralizado del local del AIP (EBH)'),(333,22218,'AIP. Sistema de refrigeración (EBI)'),(334,22219,'AIP. Sistema de distribución eléctrica (EBJ)'),(335,223,'Submarinos. Baterías para propulsión principal'),(336,2231,'Submarinos. Batería principal'),(337,22311,'Submarinos. Batería principal nº1'),(338,22312,'Submarinos. Batería principal nº2'),(339,2232,'Batería Principal. Sistema de deteccion de hidrogeno'),(340,22321,'Batería Principal. Sistema de deteccion de hidrogeno'),(341,2233,'Batería Principal. Sistema de ventilacion'),(342,22331,'Batería Principal. Sistema de ventilacion'),(343,2234,'Batería Principal. Sistemas auxiliares'),(344,22341,'Batería Principal. Sistema de vigilancia y control'),(345,22342,'Batería Principal. Sistema de agua destilada (ECC)'),(346,22343,'Batería Principal. Sistema de agitado de electrolito (ECD)'),(347,22344,'Batería Principal. Sistema de refrigeración (ECE)'),(348,224,'Pilas de combustible de propulsion principal'),(349,2241,'Pilas de combustible de propulsion principal'),(350,22411,'Pilas de combustible de propulsion principal'),(351,23,'Maquinaria propulsora'),(352,231,'Turbinas de vapor para propulsion'),(353,2311,'Turbinas principales de vapor para propulsion'),(354,23111,'Turbina principal de vapor de propulsion nº1'),(355,23112,'Turbina principal de vapor de propulsion nº2'),(356,232,'Maquinas de vapor para propulsion'),(357,233,'Motores diesel propulsores'),(358,2331,'Motores diesel propulsores. Principales'),(359,23311,'Motor diesel de propulsion principal nº1'),(360,23312,'Motor diesel de propulsion principal nº2'),(361,23313,'Motor diesel de propulsion principal nº3'),(362,23314,'Motor diesel de propulsion principal nº4'),(363,23315,'Motor diesel de propulsion principal nº5'),(364,23316,'Motor diesel de propulsion principal nº6'),(365,23319,'Equipos comunes a varios motores propulsores'),(366,234,'Turbinas de gas de propulsion'),(367,2341,'Turbinas de gas de propulsion principal'),(368,23411,'Turbina de gas de propulsion principal nº1'),(369,23412,'Turbina de gas de propulsion principal nº2'),(370,2342,'Turbinas de gas de propulsion principal. Sistemas de apoyo'),(371,23421,'Turbina de gas. Sistema de aire de arranque'),(372,23422,'Turbina de gas. Sistema de almacenamiento y relleno de aceite'),(373,23423,'Turbina de gas. Armario electronico independiente de control (FSEE)'),(374,23424,'Turbina de gas. Sistema de lavado'),(375,23425,'Turbina de gas. Electronica de control'),(376,235,'Propulsión electrica'),(377,2351,'Generadores principales de propulsion'),(378,23511,'Generador principal de propulsion nº1'),(379,23512,'Generador principal de propulsion nº2'),(380,23513,'Generador principal de propulsion nº3'),(381,23514,'Generador principal de propulsion nº4'),(382,2352,'MEPPs. Motores eléctricos de propulsión principal'),(383,23521,'MEPP nº1. Motor eléctrico de propulsión principal nº1'),(384,23522,'MEPP nº2. Motor electrico de propulsion principal nº2'),(385,23523,'MEPP nº3. Motor electrico de propulsion principal nº3'),(386,23524,'MEPP nº4. Motor electrico de propulsion principal nº4'),(387,236,'Sistemas de propulsion autonomos'),(388,237,'Sistemas de propulsion auxiliar'),(389,2371,'Sistemas de propulsion auxiliar'),(390,23711,'UPA nº1. Unidad de propulsión auxiliar nº1'),(391,23712,'UPA nº2. Unidad de propulsión auxiliar nº2'),(392,238,'Propulsion secundaria (submarinos)'),(393,2381,'Propulsion secundaria (submarinos)'),(394,23811,'Propulsion secundaria (submarinos)'),(395,239,'Propulsion de emergencia'),(396,2391,'Propulsión de emergencia'),(397,23911,'Propulsor de emergencia nº1 (Er o unico)'),(398,23912,'Propulsor de emergencia nº2 (Br)'),(399,24,'Sistemas de transmisión y propulsión'),(400,241,'Engranajes reductores de la propulsion'),(401,2411,'Engranajes reductores de la propulsion'),(402,24111,'Engranaje reductor nº1 (Er o unico)'),(403,24112,'Engranaje reductor nº2 (Br)'),(404,2412,'Hidroalas. Engranajes reductores de la propulsion'),(405,24121,'Hidroalas. Engranajes reductores de la propulsion'),(406,242,'Acoplamientos y embragues de la propulsion'),(407,2421,'Acoplamientos y embragues de la propulsion'),(408,24211,'Acoplamientos y embragues de la propulsion. Eje nº1 (ER o único)'),(409,24212,'Acoplamientos y embragues de la propulsion. Eje nº2 (BR)'),(410,2422,'Hidroalas. Acoplamientos de la propulsion'),(411,24221,'Hidroalas. Acoplamientos de la propulsion'),(412,243,'Ejes de propulsión'),(413,2431,'Ejes de propulsión'),(414,24311,'Eje de propulsión nº1 (ER o único)'),(415,24312,'Eje de propulsión nº2 (BR)'),(416,244,'Cojinetes y chumaceras de los ejes de propulsion'),(417,2441,'Cojinetes y chumaceras de los ejes de propulsión'),(418,24411,'Cojinetes y chumaceras del eje de propulsión Nº1 (Er o único)'),(419,24412,'Cojinetes y chumaceras del eje de propulsión Nº2 Br'),(420,245,'Propulsores'),(421,2451,'Hélices y propulsores'),(422,24511,'Helice/Propulsor (POD) nº1 (Er o unica)'),(423,24512,'Helice/Propulsor (POD) nº2 (Br)'),(424,24513,'Sistema de control de paso de helice (Para varias hélices)'),(425,246,'Conductos y protección de los propulsores'),(426,2461,'Conductos y protección de los propulsores'),(427,24611,'Conductos y protección de los propulsores'),(428,247,'Propulsion por chorro de agua'),(429,2471,'Propulsores por chorro de agua fijos al casco'),(430,24711,'Propulsor por chorro de agua nº1 (Er)'),(431,24712,'Propulsor por chorro de agua nº2 (Br)'),(432,2472,'Hidroalas. Propulsores por chorro de agua'),(433,24721,'Hidroalas. Propulsores por chorro de agua'),(434,248,'Hidroalas. Conductos y ventiladores del sistema de suspension'),(435,25,'Propulsion. Sistemas auxiliares. (excepto combustibles y lubricantes)'),(436,251,'Sistemas de aire de combustion'),(437,2511,'Ventiladores de tiro forzado'),(438,25111,'Ventiladores de tiro forzado'),(439,2512,'Ventiladores de encendido'),(440,25121,'Ventiladores de encendido'),(441,2513,'Tomas de aire de combustion, en turbinas de gas'),(442,25131,'Tomas de aire de combustion, turbina de gas nº1'),(443,25132,'Tomas de aire de combustion, turbina de gas nº2'),(444,2514,'Tomas de aire de combustion en motores diesel'),(445,25141,'Tomas de aire de combustion, motor diesel nº1 (Er Pr o unico)'),(446,25142,'Tomas de aire de combustion, motor diesel nº2 (Br Pr)'),(447,25143,'Tomas de aire de combustion, motor diesel nº3 (Er Pp)'),(448,25144,'Tomas de aire de combustion, motor diesel nº4 (Br Pp)'),(449,2515,'Tomas de aire de combustion, en calderas'),(450,25151,'Tomas de aire de combustion, en calderas'),(451,252,'Sistemas de control de la propulsion y la plataforma'),(452,2521,'Sistemas de control de la propulsion y la plataforma'),(453,25211,'Sistemas de control de la propulsion. Puesto principal'),(454,25212,'Sistemas de control de la propulsion. Puente'),(455,25213,'Sistemas de control de la propulsion. Camara Maquinas nº1'),(456,25214,'Sistemas de control de la propulsion. Camara Maquinas nº2'),(457,25215,'Sistemas de control de la propulsion. Puesto secundario'),(458,25216,'Sistemas de control de la propulsion. Puesto del CIC'),(459,25219,'SICP. Sistemas integrados de control de la plataforma (PREVISTO A 4381)'),(460,2522,'Hidroalas. Sistemas de control de la propulsion'),(461,25221,'Hidroalas. Sistemas de control de la propulsion'),(462,2523,'Submarinos. Sistemas de control de la propulsión'),(463,25231,'Submarinos. Sistemas de control de la propulsión'),(464,253,'Sistema de tuberias de vapor principal'),(465,2531,'Tuberias de vapor principal'),(466,25311,'Tuberias de vapor principal'),(467,254,'Condensadores y eyectores de aire'),(468,2541,'Condensadores y eyectores de aire principales'),(469,25411,'Condensadores y eyectores de aire principales'),(470,2542,'Condensadores y eyectores de aire auxiliares'),(471,25421,'Condensadores y eyectores de aire auxiliares'),(472,2543,'Condensadores y ventiladores de vahos'),(473,25431,'Condensadores y ventiladores de vahos'),(474,2544,'Tuberias y accesorios de condensadores y eyectores'),(475,25441,'Tuberias y accesorios de condensadores y eyectores'),(476,255,'Sistemas de alimentacion y condensado'),(477,2551,'Tuberias y accesorios del agua de alimentacion de calderas'),(478,25511,'Tuberias y accesorios del agua de alimentacion de calderas'),(479,2552,'Bombas de alimentacion principal'),(480,25521,'Bombas de alimentacion principal'),(481,2553,'Bombas de aportacion, de emergencia y de trasiego'),(482,25531,'Bombas de aportacion, de emergencia y de trasiego'),(483,2554,'Tuberias y accesorios del sistema de condensado principal y auxiliar'),(484,25541,'Tuberias y accesorios del sistema de condensado principal y auxiliar'),(485,2555,'Bombas del sistema principal de condensado'),(486,25551,'Bombas del sistema principal de condensado'),(487,2556,'Bombas del sistema auxiliar de condensado'),(488,25561,'Bombas del sistema auxiliar de condensado'),(489,2557,'Tanque desaireador'),(490,25571,'Tanque desaireador'),(491,2558,'Bombas de condensado auxiliar, bombas de refrigeración y generador de turbina'),(492,25581,'Bombas de condensado auxiliar, bombas de refrigeracion y generador de turbina'),(493,256,'Sistemas de circulación y refrigeracion por agua salada (CRAS)'),(494,2561,'CRAS. Tuberías y válvulas'),(495,25611,'CRAS. Tuberías y válvulas'),(496,2562,'CRAS. Bombas de circulacion principal'),(497,25621,'CRAS. Bombas de circulacion principal'),(498,2563,'CRAS. Bombas circulacion auxiliar'),(499,25631,'CRAS. Bombas circulacion auxiliar'),(500,2564,'CRAS. Bombas refrigeracion y de circulacion auxiliar de turbogeneradores'),(501,25641,'CRAS. Bombas de refrigeración y de circulacion auxiliar del turbogenerador nº1'),(502,2565,'CRAS. Refrigeración de agua del circuito de C.I. Tuberías'),(503,25651,'CRAS. Refrigeración con agua del circuito de C.I. Tuberías'),(504,2566,'CRAS. Refrigeración centralizada por agua salada. Válvulas y tuberías'),(505,25661,'CRAS. Refrigeración centralizada por agua salada. Válvulas y tuberías'),(506,2567,'CRAS. Refrigeración centralizada por agua salada. Bombas'),(507,25671,'CRAS. Refrigeración centralizada por agua salada. Bombas'),(508,257,'Sistemas de alimentación de reserva y trasiego'),(509,2571,'Sistema de alimentacion de reserva y trasiego. Tuberias y accesorios'),(510,25711,'Tuberias y accesorios del sistema de alimentacion de reserva y trasiego'),(511,2572,'Sistema de alimentacion de reserva y trasiego. Bombas'),(512,25721,'Bombas del sistema de alimentacion de reserva y trasiego'),(513,258,'Sistema de purgas de vapor de alta presion'),(514,2581,'Sistema de purgas de vapor de alta presion'),(515,25811,'Sistema de purgas de vapor de alta presion'),(516,259,'Propulsión. Sistema para humos de escape'),(517,2591,'Propulsión. Conductos para humos de escape'),(518,25911,'Conductos para humos de escape (MPP nº1 o unico)'),(519,25912,'Conductos para humos de escape (MPP nº2)'),(520,25913,'Conductos para humos de escape (MPP nº3)'),(521,25914,'Conductos para humos de escape (MPP nº4)'),(522,25915,'Conductos para humos de escape (TG nº1)'),(523,25916,'Conductos para humos de escape (TG nº2)'),(524,26,'Propulsión. Sistemas de apoyo. Combustibles y lubricantes'),(525,261,'Sistemas de combustible'),(526,2611,'Sistema de combustible. Tuberias y válvulas'),(527,26111,'Sistema de combustible. Tuberías y accesorios'),(528,26112,'Sistema de combustible. Válvulas motorizadas'),(529,2612,'Sistema de combustible. Bombas'),(530,26121,'Sistema de combustible. Bombas'),(531,2614,'Sistema de combustible. Calentadores'),(532,26141,'Sistema de combustible. Calentadores'),(533,262,'Propulsión. Lubricación'),(534,2621,'Propulsión. Lubricación. Tuberías y accesorios'),(535,26211,'Propulsión. Lubricación. Tuberías y accesorios'),(536,2622,'Propulsión. Lubricación. Tanques no estructurales'),(537,26221,'Propulsión. Lubricación. Tanques no estructurales'),(538,2623,'Propulsión. Lubricación. Bombas acopladas'),(539,26231,'Propulsión. Lubricación. Bombas acopladas'),(540,2624,'Propulsión. Lubricación. Bombas no acopladas'),(541,26241,'Propulsión. Lubricación. Bombas no acopladas'),(542,263,'Submarinos. Propulsión. Lubricación de las líneas de ejes'),(543,2631,'Submarinos. Propulsión. Lubricación de las líneas de ejes'),(544,26311,'Submarinos. Propulsión. Lubricación de las líneas de ejes'),(545,264,'Aceite Lubricante. Relleno, trasiego y depuración'),(546,2641,'Aceite lubricante. Tuberías de relleno, trasiego y depuración'),(547,26411,'Aceite lubricante. Tuberías de relleno, trasiego y depuración'),(548,2642,'Aceite lubricante. Bombas de relleno y trasiego'),(549,26421,'Aceite lubricante limpio. Bombas de relleno y trasiego'),(550,26422,'Aceite lubricante sucio y lodos. Bombas de trasiego'),(551,2643,'Aceite lubricante. Depuradoras'),(552,26431,'Aceite lubricante. Depuradora nº1'),(553,26432,'Aceite lubricante. Depuradora nº2'),(554,29,'Planta propulsora. Sistemas especiales'),(555,298,'Planta propulsora. Fluidos'),(556,299,'Planta propulsora. Pertrechos\n y herramientas especiales'),(557,2991,'Planta propulsora. Pertrechos'),(558,29911,'Planta propulsora. Pertrechos'),(559,2992,'Planta propulsora. Herramientas especiales'),(560,29921,'Planta propulsora. Herramientas especiales'),(561,3,'Planta eléctrica'),(562,30,'Planta Eléctrica. Especificaciones e informacion general'),(563,301,'Planta Eléctrica. Planos'),(564,302,'Motores electricos y equipos asociados'),(565,303,'Dispositivos de proteccion para circuitos eléctricos'),(566,304,'Cables electricos'),(567,305,'Designacion y rotulacion del material de electricidad'),(568,31,'Generación de energía eléctrica'),(569,311,'Generadores no de emergencia'),(570,3111,'Turbogeneradores a vapor'),(571,31111,'Turbogenerador a vapor Nº1'),(572,31112,'Turbogenerador a vapor Nº2'),(573,31113,'Turbogenerador a vapor Nº3'),(574,3112,'Generadores a motor Diesel.'),(575,31121,'Grupo Diesel-Generador nº1'),(576,31122,'Grupo Diesel-Generador nº2'),(577,31123,'Grupo Diesel-Generador nº3'),(578,31124,'Grupo Diesel-Generador nº4'),(579,31125,'Grupos Diesel-Generador. Equipos comunes'),(580,3113,'Generadores a turbina de gas'),(581,31131,'Generador a turbina de gas Nº1'),(582,31132,'Generador a turbina de gas Nº2'),(583,31133,'Generador a turbina de gas Nº3'),(584,3114,'Generadores a turbina, de frecuencia especial'),(585,31141,'Generadores a turbina, de frecuencia especial'),(586,3115,'Bombas de refrigeracion de generadores (Nuclear)'),(587,31151,'Bombas de refrigeracion de generadores (Nuclear)'),(588,312,'Generadores de emergencia o desplegables'),(589,3121,'Generadores diesel de emergencia'),(590,31211,'Grupo Diesel-Generador de emergencia nº1'),(591,31212,'Grupo Diesel-Generador de emergencia nº2'),(592,31213,'Grupo Diesel-Generador de emergencia nº3'),(593,31214,'Grupo Diesel-Generador de emergencia nº4'),(594,3122,'Generadores de emergencia a turbina de gas'),(595,31221,'Generador de emergencia a turbina de gas nº1'),(596,3123,'Generadores desplegables'),(597,31231,'Generadores desplegables'),(598,3124,'Generadores portátiles'),(599,31241,'Generadores portátiles'),(600,313,'Baterias secundarias y sus medios auxiliares'),(601,3131,'Baterias secundarias y sus medios auxiliares'),(602,31311,'Baterias secundarias'),(603,31312,'Baterias secundarias. Cargadores'),(604,31313,'Sistemas de Alimentación Ininterrumpida (SAI) (UPS)'),(605,31314,'Cargadores fijos para baterías de aeronaves'),(606,314,'Sistemas de conversión de energía eléctrica'),(607,3141,'Convertidores de frecuencia rotativos'),(608,31411,'Convertidores de frecuencia rotativos de 50 Hz'),(609,31412,'Convertidores de frecuencia rotativos de 60 Hz'),(610,31413,'Convertidores de frecuencia rotativos de 400 Hz'),(611,3142,'Convertidores de frecuencia estaticos'),(612,31421,'Convertidores de frecuencia estaticos de 50 Hz'),(613,31422,'Convertidores de frecuencia estaticos de 60 Hz'),(614,31423,'Convertidores de frecuencia estaticos de 400 Hz'),(615,3143,'Conversion de energia electrica. Sistemas especiales'),(616,31431,'Conversion de energia electrica. Sistemas especiales'),(617,3144,'Transformadores'),(618,31441,'Transformadores de la red de 50 Hz'),(619,31442,'Transformadores de la red de 60 Hz'),(620,31443,'Transformadores de la red de 400 Hz'),(621,3145,'Rectificadores de corriente.'),(622,31451,'Rectificadores de red de 24/28 VCC'),(623,31452,'Rectificadores de red de 120 VCC'),(624,31453,'Rectificadores fijos para arranque de aeronaves'),(625,315,'Sistema de Energía Integrado (IPS) '),(626,3151,'Sistema de Energía Integrado (IPS). Generadores'),(627,3152,'Sistema de Energía Integrado (IPS). Sistemas de apoyo'),(628,32,'Sistemas de distribución de fuerza'),(629,321,'Cableado de la red de fuerza'),(630,3211,'Cableado de la red de fuerza'),(631,32111,'Cableado de la red de fuerza'),(632,32112,'Cables y conexiones para corriente de tierra'),(633,3212,'Sistemas de distribución de corriente de fuerza'),(634,32121,'Sistema de distribución de CC'),(635,32122,'Sistema de distribución de corriente de 60 Hz'),(636,32123,'Sistema de distribución de corriente de 400 Hz'),(637,32124,'Sistema de distribución de CC de bajo voltaje (submarinos)'),(638,32125,'Sistema de distribución de corriente de 400 Hz para aeronaves'),(639,32126,'Sistema de distribución de corriente de 50 Hz'),(640,322,'Red electrica de emergencia. Cableado'),(641,3221,'Red electrica de emergencia. Cableado'),(642,32211,'Red electrica de emergencia. Cableado'),(643,323,'Red de accidentes. Cableado'),(644,3231,'Red de accidentes. Cableado'),(645,32311,'Red de accidentes. Cableado'),(646,324,'Cuadros, paneles, conmutadores e interruptores'),(647,3241,'Red de 60Hz. Cuadros, paneles, conmutadores e interruptores'),(648,32411,'Red de 60Hz. Cuadros electricos principales'),(649,32412,'Red de 60Hz. Centros de carga'),(650,32413,'Red de 60Hz / 440Vol. Cuadros secundarios de fuerza'),(651,32414,'Red de 60Hz / 220Vol. Cuadros secundarios de fuerza'),(652,32415,'Red de 60Hz / 115Vol. Cuadros secundarios de fuerza'),(653,32416,'Red de 60Hz. Cuadros de conexión con tierra'),(654,32417,'Red de 60Hz. Cuadros de emergencia'),(655,32418,'Red de 60Hz. Conmutadores de transferencia'),(656,32419,'Red de 60Hz. Centros de control de motores'),(657,3241,'Red de 60Hz. Cuadros de pruebas'),(658,3242,'Red de 400Hz. Cuadros, paneles, conmutadores e interruptores'),(659,32421,'Red de 400Hz. Cuadros y paneles'),(660,32422,'Red de 400Hz. Conmutadores e interruptores'),(661,3243,'Red de CC. Cuadros, paneles, conmutadores e interruptores'),(662,32431,'Red de CC. Cuadros, paneles, conmutadores e interruptores'),(663,3244,'Red de 50 Hz. Cuadros, paneles, conmutadores e interruptores'),(664,32441,'Red de 50 Hz. Cuadros y paneles'),(665,32442,'Red de 50 Hz. Conmutadores e interruptores'),(666,33,'Sistemas de alumbrado'),(667,331,'Distribución de alumbrado'),(668,3311,'Distribución de alumbrado'),(669,33111,'Distribución de alumbrado'),(670,3311,'Alumbrado de gala'),(671,332,'Aparatos de alumbrado'),(672,3321,'Aparatos de alumbrado'),(673,33211,'Aparatos del alumbrado normal interior'),(674,33212,'Aparatos del alumbrado normal exterior'),(675,33213,'Focos para alumbrado exterior'),(676,33214,'Aparatos del alumbrado de emergencia'),(677,33215,'Aparatos y luces de habitabilidad'),(678,34,'Planta eléctrica. Sistemas de apoyo'),(679,341,'Turbogeneradores. Lubricación'),(680,3411,'Turbogeneradores. Lubricación'),(681,34111,'Turbogeneradores. Lubricación'),(682,342,'Generadores diesel. Sistemas de apoyo'),(683,3421,'Generadores diesel. Sistemas de apoyo'),(684,34211,'Generadores diesel. Sistema de aire de arranque'),(685,34212,'Generadores diesel. Sistema de combustible'),(686,34213,'Generadores diesel. Sistema de lubricación'),(687,34214,'Generadores diesel. Sistema de refrigeración por agua del mar'),(688,34215,'Generadores diesel. Sistema de refrigeración por agua dulce'),(689,34216,'Generadores diesel. Sistema de aire de combustión'),(690,34217,'Generadores diesel. Sistema de gases de escape'),(691,3422,'Generadores diesel de emergencia. Sistemas de apoyo'),(692,34221,'Generadores diesel de emergencia. Sistemas de apoyo'),(693,3423,'Submarinos. Snorkel'),(694,34231,'Submarinos. Snorkel. Sistema de admisión'),(695,34232,'Submarinos. Snorkel. Sistema de gases de escape'),(696,343,'Generadores a turbina de gas. Sistemas de apoyo'),(697,3431,'Generadores a turbina de gas. Sistemas de apoyo'),(698,34311,'Generadores a turbina de gas. Sistemas de apoyo'),(699,3432,'Generadores de emergencia a turbina de gas. Sistemas de apoyo'),(700,34321,'Generadores de emergencia a turbina de gas. Sistemas de apoyo'),(701,3433,'Generadores de frecuencia especial a turbina de gas. Sistemas de apoyo'),(702,34331,'Generadores de frecuencia especial a turbina de gas. Sistemas de apoyo'),(703,39,'Planta eléctrica. Sistemas especiales'),(704,398,'Planta electrica. Fluidos'),(705,399,'Planta electrica. Pertrechos y herramientas especiales'),(706,3991,'Planta electrica. Pertrechos'),(707,39911,'Planta electrica. Pertrechos'),(708,3992,'Planta electrica. Herramientas especiales'),(709,39921,'Planta electrica. Herramientas especiales'),(710,4,'Mando, Exploración, Gestión de la Información'),(711,40,'Mando, Exploración, Gestión de la Información. Especificaciones e informacion general'),(712,401,'Mando y Exploración. Disposicion general'),(713,402,'Requisitos de seguridad'),(714,4021,'Requisitos generales de los centros reservados'),(715,403,'Seguridad del personal'),(716,4031,'Pruebas de radiaciones peligrosas'),(717,404,'Lineas de transmisión de radiofrecuencia'),(718,405,'Requisitos para instalación de antenas'),(719,406,'Puesta a tierra'),(720,4061,'Puesta a tierra'),(721,40611,'Puesta a tierra'),(722,407,'Reduccion de interferencias electromagneticas (EMI)'),(723,4071,'Investigacion de interferencias electromagneticas'),(724,40711,'Investigacion de interferencias electromagneticas'),(725,408,'Requisitos de pruebas del Sistema de Combate'),(726,409,'Requisitos generales del Sistema de Combate'),(727,41,'Mando y Control'),(728,410,'Pruebas de integracion de los sistemas de Mando y Control'),(729,4101,'Pruebas de integracion de los sistemas de Mando y Control'),(730,41011,'Pruebas de integracion de los sistemas de Mando y Control'),(731,411,'Mando y Control. Presentación de informacion'),(732,4111,'Presentacion de datos tacticos'),(733,41111,'Presentacion de datos tacticos'),(734,4112,'Presentación de datos del buque'),(735,41121,'Presentacion de datos del buque'),(736,4113,'LBTS (Land Based Test Site)'),(737,41131,'LBTS (Land Based Test Site)'),(738,412,'Sistemas de mando y control'),(739,4121,'Sistemas de mando y control táctico'),(740,41211,'Sistemas de proceso de datos tacticos'),(741,41212,'Sistemas de mando y control buque-helicóptero'),(742,41213,'Sistema de Apoyo de Fuego Táctico'),(743,41214,'Sistema de Control de Embarcaciones'),(744,41215,'Sistemas de Mando y Control de Operaciones Anfibias'),(745,4122,'Sistemas de mando y control operacional'),(746,41221,'Sistemas de mando y control operacional. Sistemas nacionales'),(747,41222,'Sistemas de mando y control operacional. Sistemas aliados'),(748,414,'Datos tácticos. Equipos de interconexion'),(749,4141,'Datos tácticos. Equipos de interconexion y cuadros de distribucion'),(750,41411,'Datos tácticos. Equipos de interconexion y cuadros de distribucion'),(751,415,'Comunicaciones Datos Digitales'),(752,4151,'Enlaces de datos tacticos (LINK)'),(753,41511,'Equipamiento LINK 4'),(754,41512,'Equipamiento LINK 11'),(755,41513,'Equipamiento LINK 16'),(756,41514,'Equipamiento Multilink'),(757,41515,'Equipamiento LINK-22'),(758,41516,'Red de datos Tácticos Joint Range Extension (JRE)'),(759,41517,'Red de datos tácticos Standard Interface for Multiple Platform Link Evaluation (SIMPLE)'),(760,416,'Sistemas de Combate'),(761,4160,'Sistemas de Combate. Pruebas de Integración'),(762,4161,'Sistemas de Combate de Buques de Superficie'),(763,41611,'Sistema de Combate TRITAN'),(764,41612,'Sistema de Combate fragatas F101-104'),(765,41613,'Sistema de Combate fragata F105'),(766,41614,'Sistema de Combate SCOMBA'),(767,41615,'Sistema de Combate fragatas FFG'),(768,41616,'Sistema de Combate fragatas F110'),(769,4162,'Sistemas de Combate de Submarinos'),(770,41621,'Sistema de Combate submarinos clase S80'),(771,42,'Sistemas de navegación'),(772,420,'Pruebas internas de los sistemas de navegacion'),(773,4201,'Pruebas internas de los sistemas de navegacion en general'),(774,42011,'Pruebas internas de los sistemas de navegacion en general'),(775,421,'Ayudas a la navegacion no-electrónicas'),(776,4211,'Ayudas a la navegacion no-electrónicas'),(777,42111,'Prismaticos e instrumentos opticos'),(778,42112,'Agujas magnéticas'),(779,42113,'Termómetros, Barógrafos, etc'),(780,42114,'Instrumentos para medida del tiempo'),(781,42115,'Cartas, publicaciones naúticas, instrumentos de dibujo'),(782,42116,'Material topografico de Infanteria de Marina'),(783,42117,'Equipos de vision nocturna'),(784,42119,'Otros equipos de ayuda a la navegacion'),(785,422,'Ayudas eléctricas a la navegación (incluye luces de navegación)'),(786,4221,'Luces: De navegacion, proyectores (no de señales), etc'),(787,42211,'Luces de navegacion'),(788,42212,'Focos y proyectores (No de señales)'),(789,42215,'Cuadros de luces de navegacion y de proyectores (no de señales)'),(790,423,'Sistemas de navegación electrónicos'),(791,4231,'Sistemas de navegación electrónicos'),(792,42311,'LORAN. (ANULADO)'),(793,42312,'Radiogoniometros (GONIO)'),(794,42313,'Radiobaliza TACAN'),(795,42314,'OMEGA. (ANULADO)'),(796,42315,'Equipos navegacion por satelite (GPS)'),(797,42316,'TRISPONDER. Sistema de navegación de precisión'),(798,4232,'Sistemas de navegación anticolisión'),(799,42321,'Sistemas anticolision'),(800,4233,'Sistemas integrados de navegacion'),(801,42331,'Sistema integrado de navegacion'),(802,424,'Sistemas electroacústicos de navegación'),(803,4241,'Sondadores'),(804,42411,'Sondadores de casco'),(805,42412,'Sondadores portátiles'),(806,4242,'Sistemas de navegacion acusticos'),(807,42421,'Sistemas de navegacion acusticos'),(808,425,'Periscopios'),(809,4251,'Periscopios'),(810,42511,'Periscopio nº1 (Observacion)'),(811,42512,'Periscopio nº2 (Ataque)'),(812,426,'Sistemas eléctricos de navegación'),(813,4261,'Giroscópicas'),(814,42611,'Giroscópica nº1'),(815,42612,'Giróscopica nº2'),(816,42613,'Giróscopica nº3'),(817,42618,'Indicadores de datos de navegación'),(818,42619,'Repetidores de giroscopica, taximetros'),(819,4262,'Sistemas electricos de navegacion (excepto giroscopicas y sondador)'),(820,42621,'OSMOS. Simulador de movimientos del buque propio '),(821,42622,'Sistema de la corredera'),(822,42623,'Mesas trazadoras'),(823,42624,'Sistema de indicacion de balance y cabezada'),(824,4263,'Submarinos. Sistemas medidores de cota'),(825,42631,'Submarinos. Sistemas medidores de cota'),(826,427,'Sistemas de navegacion inercial'),(827,4271,'Sistemas de navegacion inercial'),(828,42711,'Sistemas de navegacion inercial'),(829,4272,'Sistema de alineacion para navegacion inercial de aeronaves'),(830,42721,'Sistema de alineacion para navegacion inercial de aeronaves'),(831,428,'Sistemas de control, supervision y apoyo a la navegacion'),(832,4281,'Sistemas de control, supervision y apoyo a la navegacion'),(833,42811,'ECDIS. Sistemas de cartografía digital civil'),(834,42812,'WECDIS. Sistemas de cartografia digital militar'),(835,42813,'AIS. Sistema de Identificación Automática de Buques'),(836,42814,'Software comercial de ayuda y control de la Navegación'),(837,42815,'DIANA. Sistema de Distribución de Datos de Navegacion'),(838,4282,'GMDSS. Sistema Maritimo Global de Seguridad y Accidentes'),(839,42821,'GMDSS. Sistema Maritimo Global de Seguridad y Accidentes'),(840,43,'Comunicaciones interiores y Redes de Area Local'),(841,431,'Cuadros de distribución de comunicaciones interiores'),(842,4311,'Cuadros de distribución de comunicaciones interiores'),(843,43111,'Cuadros de distribución de comunicaciones interiores'),(844,4312,'Sistema de datos multiples a bordo'),(845,43121,'Sistema de datos multiples a bordo'),(846,432,'Sistemas telefónicos'),(847,4321,'Sistemas telefónicos'),(848,43211,'Sistemas telefónicos de dial'),(849,43212,'Redes de teléfonos autoexcitados'),(850,43213,'Sistemas de circuitos de llamada'),(851,43214,'Sistema integrado de comunicacion telefonica'),(852,43215,'Sistemas telefonicos de campaña (Inf Marina)'),(853,43216,'Tendidos telefonicos'),(854,433,'Sistemas de órdenes generales e intercomunicadores'),(855,4331,'Sistemas de órdenes generales e intercomunicadores'),(856,43311,'Red de órdenes generales (1MC)'),(857,43312,'Sistemas de intercomunicadores e interfonos'),(858,43315,'Circuito 5MC'),(859,43316,'Circuito 6MC'),(860,43317,'Circuito 75MC'),(861,434,'Sistemas de adiestramiento y recreo'),(862,4341,'Sistemas audiovisuales de adiestramiento y recreo'),(863,43411,'Sistemas audiovisuales de adiestramiento y recreo'),(864,43413,'Sistemas de TV via satelite'),(865,435,'Sistemas de tubos acústicos y neumáticos'),(866,4351,'Sistemas de tubos acústicos y neumáticos'),(867,43511,'Tubos acústicos'),(868,43512,'Tubos neumáticos'),(869,436,'Sistemas de alarma, seguridad y aviso'),(870,4361,'Sistemas de alarma, seguridad y aviso (SASA)'),(871,43611,'SASA de la Propulsión y gobierno'),(872,43612,'SASA de Hombre al Agua'),(873,43613,'SASA de las Frigoríficas'),(874,43614,'SASA de sentinas e inundaciones'),(875,43615,'Sistemas de vigilancia anti-intrusos'),(876,43616,'Sistemas de detección y alarma de incendios'),(877,43618,'Sistemas de alarma de gases explosivos'),(878,4362,'Sistemas de diagnosis dirigidos al Mantenimiento Basado en la Condición (MBC)'),(879,43621,'Sistemas de diagnosis dirigidos al MBC'),(880,437,'Sistemas de indicacion, ordenes y medida'),(881,4371,'Circuitos de indicacion, ordenes y medida'),(882,43711,'Circuito de ordenes a maquinas (Telegrafo de maquinas)'),(883,43712,'Circuito indicador de angulo de timon'),(884,43713,'Circuito revoluciones y angulo de helice'),(885,43714,'Circuito indicador de la hora'),(886,4372,'Sistemas indicadores de nivel de tanques'),(887,43721,'Sistemas indicadores de nivel de tanques'),(888,4373,'Sistemas de indicacion de viento'),(889,43731,'Sistemas de indicacion de viento'),(890,438,'Sistemas de control y presentación consolidados'),(891,4381,'Sistemas integrados de control de la plataforma'),(892,43811,'Sistemas Integrados de Control de la Plataforma (SICP)'),(893,4382,'Submarinos. Sistemas de control del rumbo y la cota'),(894,43821,'Submarinos. Sistemas de control del rumbo y la cota'),(895,4383,'Submarinos. Sistema de control de estacionario'),(896,43831,'Sistema de control de estacionario (submarinos)'),(897,4384,'Submarinos. Control de compensacion de misiles'),(898,43841,'Submarinos. Control de compensacion de misiles'),(899,4385,'Submarinos. Sistema de apoyo de armas estrategicas'),(900,43851,'submarinos. Sistema de apoyo de armas estrategicas'),(901,439,'Sistemas de vigilancia interior y exterior'),(902,4391,'CCTV. Circuito cerrado de television'),(903,43911,'CCTV. Circuito cerrado de television'),(904,4392,'Sistemas de grabacion de audio'),(905,43921,'Sistemas de grabacion de audio'),(906,43,'Redes de Area Local (LANs)'),(907,43,'Redes de Area Local'),(908,43,'Redes de Area Local'),(909,44,'Comunicaciones exteriores'),(910,441,'Sistemas radio'),(911,4411,'Antenas de comunicaciones'),(912,44111,'Antenas de hilo'),(913,44112,'Antenas de látigo'),(914,44113,'Antenas de paraguas'),(915,44114,'Antenas de martillo'),(916,44115,'Antenas de bastón'),(917,44116,'Antenas de campo para Infanteria de Marina'),(918,44117,'Antenas Omnidireccionales'),(919,44118,'Antenas Radomo'),(920,44119,'Submarinos. Antenas de hilo largables'),(921,4411,'Submarinos. Antenas multifunción'),(922,4412,'Sintonizadores-multiacopladores de antena'),(923,44121,'Sintonizadores-multiacopladores de antena de LF/MF'),(924,44122,'Sintonizadores-multiacopladores de antena de HF'),(925,44123,'Sintonizadores-multiacopladores de antena de VHF/UHF'),(926,4413,'Transmisores de comunicaciones'),(927,44131,'Transmisores de MF (300KHz-3MHz)'),(928,44132,'Transmisores de HF (3MHz-30MHz)'),(929,44133,'Transmisores de socorro'),(930,4414,'Receptores de comunicaciones'),(931,44141,'Receptores de VLF/LF (10KHz-300KHz)'),(932,44142,'Receptores de MF/HF (300KHz-30MHz)'),(933,44143,'Receptores de VHF (30MHz-300MHz)'),(934,44144,'Receptores de UHF (300MHz-3000 MHz)'),(935,4415,'Transceptores de comunicaciones'),(936,44151,'Transceptores VLF/LF (10KHz-300KHz)'),(937,44152,'Transceptores MF/HF (300KHz-30MHz)'),(938,44153,'Transceptores VHF/UHF (30MHz-3000 MHz) de uso general'),(939,44154,'Transceptores UHF ECCM, LINK'),(940,44155,'Transceptores VHF IMM (156-162 MHz)'),(941,44156,'Transceptores VHF/UHF Aviacion'),(942,44157,'Radiotelefonos'),(943,44158,'Sistema TETRAPOL'),(944,44159,'Sistema de comunicaciones para la cubierta de vuelo'),(945,4416,'Controles remotos y otros dispositivos de comunicaciones'),(946,44161,'Controles remotos de comunicaciones'),(947,44162,'Sistemas de interconexion de comunicaciones'),(948,44163,'Terminales de Comunicaciones'),(949,44169,'MODEMs y otros dispositivos de comunicaciones'),(950,4417,'Sistemas de comunicaciones por satélite'),(951,44171,'Sistema de comunicaciones por satélite (CIVIL)'),(952,44172,'Sistema de comunicaciones por satélite (MILITAR)'),(953,4418,'Sistemas de supervisión de calidad de emisiones'),(954,44181,'Sistemas de supervision de calidad de emisiones'),(955,4419,'Sistemas de distribución y proceso de mensajes'),(956,44191,'Sistemas de distribución y proceso de mensajes'),(957,441,'ICCS. Sistemas Integrados de Control de Comunicaciones'),(958,441,'ICCS. Sistemas Integrados de Control de Comunicaciones'),(959,442,'Sistemas de comunicaciones submarinas'),(960,4421,'Sistema de comunicaciones submarinas'),(961,44211,'Telefono Submarino nº1'),(962,44212,'Telefono Submarino nº2'),(963,44213,'Telefono Submarino nº3'),(964,443,'Sistemas de comunicaciones visuales y fonicas'),(965,4431,'Sistemas de comunicación visual o sonora'),(966,44311,'Banderas (incluye banderas de señales)'),(967,44312,'Sistemas de comunicaciones fónicas'),(968,44313,'Sistemas de comunicacion por infrarrojos'),(969,44314,'Proyectores y luces de señales'),(970,44315,'Infanteria de Marina. Material de señalizacion'),(971,444,'Sistemas de telemetria'),(972,445,'Sistemas de facsímil y teletipo'),(973,4451,'Sistemas de facsimil y teletipo'),(974,44511,'Sistemas de teletipo'),(975,44512,'Sistemas de facsímil'),(976,446,'Sistemas de criptografia'),(977,4461,'Equipos de criptografia'),(978,44611,'Equipos cripto del IFF'),(979,44612,'Equipos cripto del LAMPS'),(980,44613,'Equipos cripto (datos)'),(981,44614,'Equipos cripto (voz)'),(982,44619,'Equipos diversos de Cifra'),(983,4462,'Normas e Inspecciones TEMPEST'),(984,44621,'Normas e Inspecciones TEMPEST'),(985,45,'Sistemas de exploracion de superficie y aire'),(986,450,'Sistemas de distribucion radar'),(987,4501,'Sistemas de distribucion radar'),(988,45011,'Sistemas de distribucion radar'),(989,451,'Radares de exploracion de superficie y de navegación'),(990,4511,'Radares de exploracion de superficie'),(991,45111,'Radar de exploracion de superficie nº1'),(992,45112,'Radar de exploracion de superficie nº2'),(993,45113,'Repetidores de radar'),(994,45114,'Radares de Infanteria de Marina'),(995,4512,'Radares de navegacion'),(996,45121,'Radar de navegacion nº1'),(997,45122,'Radar de navegacion nº2'),(998,45123,'Radar de navegación nº3'),(999,452,'Radares de exploracion aerea (2 Dimensiones)'),(1000,4521,'Radar de exploracion aerea (2 Dimensiones)'),(1001,45211,'Radar de exploracion aerea (2 Dimensiones)'),(1002,453,'Sistemas radar de exploracion aerea (3 Dimensiones)'),(1003,4531,'Radar de exploracion aerea (3 Dimensiones)'),(1004,45311,'Radar de exploracion aerea (3 Dimensiones)'),(1005,454,'Radares para control de aproximacion de aeronaves'),(1006,4541,'Radar de control de aproximacion de aeronaves'),(1007,45411,'Radar de control de aproximacion de aeronaves'),(1008,455,'Sistemas de identificación (IFF)'),(1009,4551,'Sistemas de identificación (IFF)'),(1010,45511,'Sistemas de identificación (IFF)'),(1011,456,'Sistemas radar de multiples modos/funciones'),(1012,4561,'Radares multifuncion'),(1013,4561,'Radar multifuncion SPY-1A'),(1014,4561,'Radar multifuncion SPY-1D'),(1015,457,'Sistemas de vigilancia y seguimiento por infrarrojos (FLIR)'),(1016,4571,'Sistemas de vigilancia y seguimiento por infrarrojos (FLIR)'),(1017,45711,'Sistemas de vigilancia y seguimiento por infrarrojos (FLIR)'),(1018,458,'Sistemas de deteccion y seguimiento automatico'),(1019,4581,'Sistemas de deteccion y seguimiento automatico'),(1020,45811,'Sistemas de deteccion y seguimiento automatico'),(1021,459,'Seguimiento de vehiculos espaciales'),(1022,46,'Sistemas de exploración submarina'),(1023,460,'Sistemas de exploración submarina. Generalidades'),(1024,4609,'Acústica submarina. Generalidades'),(1025,46091,'Acústica submarina. Generalidades'),(1026,461,'Sonares activos de exploración'),(1027,4611,'Sonares activos de casco'),(1028,46111,'Sonar activo de casco nº1'),(1029,46112,'Sonar activo de casco nº2'),(1030,4612,'Sonar activo remolcado'),(1031,46121,'Sonar activo remolcado'),(1032,462,'Sonares pasivos de exploración'),(1033,4621,'Sonares pasivos de casco'),(1034,46211,'Sonar pasivo de casco nº1'),(1035,46212,'Submarinos. Sonar pasivo de casco nº2'),(1036,46213,'Submarinos. Sonar pasivo de casco nº3'),(1037,4622,'Sonares pasivos remolcados'),(1038,46221,'Sonar pasivo remolcado. TACTAS'),(1039,46222,'Sonar pasivo remolcado. (Submarinos)'),(1040,4623,'Submarinos. Telemetros acusticos'),(1041,46231,'Submarinos. Telemetro acustico nº1'),(1042,46232,'Submarinos. Telemetro acustico nº2'),(1043,463,'Sonar de exploracion multimodo'),(1044,4631,'Sonar de exploracion multimodo'),(1045,46311,'Sonar de exploracion multimodo'),(1046,4639,'Sonar multimodo portátil'),(1047,46391,'Sonar multimodo portátil'),(1048,464,'Sistemas de analisis acustico'),(1049,4641,'Sistemas de analisis acustico'),(1050,46411,'Sistemas de analisis acustico'),(1051,46415,'Magnetofones de clasificacion'),(1052,465,'Sistemas de predicción de comportamiento sonar'),(1053,4651,'Batitermografos/Baticelerimetros'),(1054,46511,'Batitermografos'),(1055,46512,'Baticelerímetros'),(1056,4652,'Sistemas de prediccion de alcance sonar'),(1057,46521,'Sistemas de prediccion de alcance sonar'),(1058,466,'Sistemas de exploracion multiproposito'),(1059,4661,'LAMPS. Equipo embarcado'),(1060,46611,'LAMPS. Equipo embarcado'),(1061,467,'Sistema de control de ruidos'),(1062,4671,'Sistema de control de ruidos'),(1063,46711,'Sistema de control de ruidos'),(1064,47,'Contramedidas'),(1065,470,'Pruebas internas del sistema de contramedidas electronicas'),(1066,4701,'Pruebas internas del sistema de contramedidas electronicas'),(1067,471,'Contramedidas electronicas. Activas y activo/pasivas combinadas'),(1068,4711,'Contramedidas electrónicas activas'),(1069,47111,'Contramedidas electronicas activas'),(1070,47112,'Contramedidas electronicas activas de comunicaciones'),(1071,47119,'Contramedidas activas especiales'),(1072,4712,'Contramedidas electrónicas activo-pasivas combinadas'),(1073,47121,'Contramedidas activo-pasivas'),(1074,47122,'Contramedidas activo-pasivas de comunicaciones'),(1075,47129,'Contramedidas activo-pasivas especiales'),(1076,472,'Contramedidas electrónicas pasivas'),(1077,4721,'Contramedidas electrónicas pasivas'),(1078,47211,'Contramedidas electrónicas pasivas'),(1079,47212,'Contramedidas pasivas de comunicaciones'),(1080,473,'Contramedidas submarinas'),(1081,4731,'Señuelos anti-torpedos'),(1082,47311,'Señuelo anti-torpedos'),(1083,47312,'Submarinos. Señuelo anti-torpedos'),(1084,474,'Señuelos de contramedidas electrónicas'),(1085,4741,'Señuelos de contramedidas y sus lanzadores (SRBOC) (CDLS)'),(1086,47411,'Señuelos de contramedidas y sus lanzadores (SRBOC) (CDLS)'),(1087,475,'Contramedidas magnéticas y eléctricas'),(1088,4751,'Contramedidas magnéticas y eléctricas'),(1089,47511,'Sistemas de desmagnetización'),(1090,47512,'Sistemas de contramedidas eléctricas'),(1091,476,'Sistemas contra minas (MCM) y explosivos (EOD)'),(1092,4761,'Sistemas de rastreo de minas'),(1093,47611,'Sistemas de rastreo de minas'),(1094,4762,'Sistemas de caza de minas'),(1095,47621,'Sistemas de caza de minas'),(1096,4765,'Sistemas para desactivación de explosivos y munición (EOD)'),(1097,47651,'EOD. Medios de protección'),(1098,47652,'EOD. Medios de almacenamiento y transporte'),(1099,47653,' EOD. Medios de acceso y remoción'),(1100,47654,'EOD. Medios detección y localización'),(1101,47655,'EOD. Medios de ataque'),(1102,47656,'EOD. Medios de análisis y recogida de evidencias'),(1103,47659,'EOD. Pertrechado y herramientas especiales'),(1104,48,'Direcciones de Tiro'),(1105,480,'Pruebas internas de direcciones de tiro'),(1106,4801,'Pruebas internas de direcciones de tiro'),(1107,48011,'Pruebas internas de direcciones de tiro de artilleria'),(1108,48012,'Pruebas internas de direcciones de tiro de misiles'),(1109,48013,'Pruebas internas de direcciones de tiro de armas submarinas'),(1110,481,'Direcciones de tiro de artilleria'),(1111,4811,'Direccion de tiro de artilleria'),(1112,48111,'Direccion de tiro de artilleria'),(1113,48113,'Direccion de tiro de artilleria MEROKA 2A (PDA)'),(1114,48114,'Direccion de tiro de artilleria MEROKA 2A3 (Fragatas DEG y FFG)'),(1115,48115,'Direccion de tiro de artilleria MEROKA 2B'),(1116,48116,'Direcciones de tiro de Infanteria de Marina'),(1117,48117,'Dirección de Tiro de artillería DORNA'),(1118,482,'Direcciones de tiro de misiles'),(1119,4821,'Direccion de tiro de misiles'),(1120,48211,'Direccion de tiro de misiles'),(1121,48215,'Dirección de tiro de misiles HARPOON'),(1122,48216,'Direccion de tiro de misiles de ataque a tierra'),(1123,483,'Direcciones de lanzamiento de armas submarinas'),(1124,4831,'Direccion de lanzamiento antisubmarino'),(1125,48311,'Direccion de lanzamiento antisubmarino'),(1126,4832,'Submarinos. Direccion de lanzamiento de torpedos'),(1127,48321,'Submarinos. Direccion de lanzamiento de torpedos'),(1128,484,'Sistemas integrados de direccion de tiro'),(1129,4841,'Sistemas integrados de direccion de tiro'),(1130,48411,'Sistemas integrados de direccion de tiro'),(1131,489,'Cuadros de distribución de sistemas de armas'),(1132,4891,'Cuadros de distribución de sistemas de armas'),(1133,48911,'Cuadros de distribución de sistemas de armas'),(1134,49,'Mando y Exploración. Sistemas especiales'),(1135,491,'Equipos electronicos de prueba, comprobacion y supervision'),(1136,4911,'Equipos electronicos de prueba, comprobacion y supervision'),(1137,49111,'Amperimetros, Voltimetros, Ohmimetros, Multimetros y Polimetros'),(1138,49112,'Osciloscopios'),(1139,49113,'Analizadores de ondas/espectros/frecuencímetros/osciladores'),(1140,49114,'Generadores de señal, de funciones'),(1141,49115,'Fuentes de alimentacion'),(1142,49116,'Medidores de potencia,de modulacion, de distorsion, watimetros'),(1143,49117,'Acopladores, Adaptadores y Atenuadores'),(1144,49118,'Comprobadores de resistencias, valvulas, transistores, CIs y tarjetas electronicas'),(1145,49119,'Comprobadores de sincronos. Puentes de impedancias'),(1146,4911,'Contadores, estroboscopios'),(1147,4911,'Pequeños conectores y acopladores'),(1148,492,'Sistemas de control de vuelo y toma instrumental'),(1149,4921,'Sistemas de luces de ayuda a la toma'),(1150,49211,'Sistema de luces de ayuda a la toma visual (portaaviones)'),(1151,49212,'Sistemas de ayuda a la toma por lentes fresnel (FLOLS)'),(1152,49213,'Sistema de ayuda a la toma por lentes fresnel mejorado MK-13 (IFLOLS)'),(1153,49214,'Sistema de television de ayuda a la toma (PLAT)'),(1154,49215,'Sistema del puesto del Oficial de señales de toma (LSO)'),(1155,49216,'Sistema de ayuda a la toma. Visual y manual (MOVLAS)'),(1156,49217,'Sistemas de luces para ayuda a la toma (No portaaviones)'),(1157,4926,'Sistemas de luces para ayuda a la toma (buques con capacidad aerea)'),(1158,49261,'Sistemas de luces para ayuda a la toma (buques con capacidad aerea)'),(1159,49262,'Sistema de ayuda visual. Linea de luces de popa (LRLS)'),(1160,49263,'EODAS (Electro-Optical Deck Aproaching System)'),(1161,49264,'Sistema de barra estabilizada de horizonte artificial'),(1162,4927,'Sistemas de luces para ayuda a la toma (buques de desembarco)'),(1163,49271,'Sistemas de luces para ayuda a la toma (buques de desembarco)'),(1164,493,'Sistemas de proceso de datos (no operativos)'),(1165,4931,'Sistemas de gestion de informacion'),(1166,49311,'Sistemas de gestion administrativa'),(1167,49312,'Sistemas de gestion del personal y material'),(1168,4932,'Sistemas de supervisión'),(1169,49321,'Sistemas de supervisión'),(1170,49322,'Software para la gestión y analisis del ambiente electromagnetico'),(1171,494,'Sistemas meteorologicos'),(1172,4941,'Sistemas meteorologicos'),(1173,49411,'Receptores de facsimil meteorologico'),(1174,49412,'Sistemas y aparatos meteorológicos (No mecánicos)'),(1175,49413,'Sistemas y aparatos meteorologicos (Mecánicos)'),(1176,495,'Sistemas de inteligencia'),(1177,4951,'Sistemas integrados de inteligencia operativa (SIIO)'),(1178,49511,'SIIO. Subsistema de INTeligencia Humana (HUMINT)'),(1179,49512,'SIIO. Subsistema de INTeligencia de IMagenes (IMINT)'),(1180,49513,'SIIO. Subsistema de INTeligencia de SEñales (SIGINT)'),(1181,49514,'SIIO. Subsistema de INTeligencia de RADares (RADINT)'),(1182,49515,'SIIO. Subsistema de INTeligencia ACUSTica (ACOUSTINT)'),(1183,49516,'SIIO. Subsistema de INTeligencia de RF/Pulsos EM (RF/EMPINT)'),(1184,49517,'SIIO. Subsistema de INTeligencia de InfraRojos (IRINT)'),(1185,4952,'Inteligencia Naval. Sistemas de proceso'),(1186,49521,'Inteligencia Naval. Sistemas de proceso'),(1187,4953,'Centro de apoyo táctico'),(1188,49531,'Centro de apoyo tactico'),(1189,4954,'Espacios del buque para el análisis de señales'),(1190,49541,'Espacios del buque para el análisis de señales'),(1191,4956,'Inteligencia tactica (TACINTEL)'),(1192,49561,'Inteligencia tactica (TACINTEL)'),(1193,496,'Simuladores (Embarcados y en tierra)'),(1194,4961,'Simuladores embarcados'),(1195,4962,'Simuladores en tierra'),(1196,49621,'Simuladores de navegación (En tierra)'),(1197,49622,'Simuladores de plataforma (En tierra)'),(1198,49623,'Simuladores tácticos (En tierra)'),(1199,49624,'Simuladores de Seguridad Interior (En Tierra)'),(1200,49625,'Simuladores de Vuelo (Plataforma) (En tierra)'),(1201,49626,'Similadores de vuelo (Tácticos) (En tierra)'),(1202,49627,'Simuladores de Tiro de Armas Terrestres'),(1203,498,'Fluidos utilizados en sistemas de Mando y Control'),(1204,499,'Pertrechos y herramientas especiales (Mando y Control)'),(1205,4991,'Pertrechos para equipos de mando y control'),(1206,49911,'Pertrechos para equipos de mando y control'),(1207,4992,'Herramientas especiales (Mando y Control)'),(1208,4993,'Modulos de ayuda al mantenimiento (MAMs)'),(1209,49931,'Modulos de ayuda al mantenimiento (MAMs)'),(1210,5,'Sistemas auxiliares'),(1211,50,'Sistemas auxiliares. Generalidades'),(1212,501,'Sistemas auxiliares. Planos de disposición general.'),(1213,502,'Maquinaria auxiliar'),(1214,503,'Bombas'),(1215,504,'Instrumentos y paneles de instrumentos'),(1216,505,'Tuberías'),(1217,506,'Reboses, atmosféricos y sondas'),(1218,507,'Denominación y marcado de maquinaria y tuberías'),(1219,508,'Aislamiento térmico de tuberias y maquinaria'),(1220,5081,'Aislamiento térmico de tuberías y maquinaria. Desmontaje'),(1221,509,'Aislamiento térmico de conductos de ventilación y aire acondicionado'),(1222,51,'Control ambiental'),(1223,510,'Control ambiental. Generalidades y requisitos'),(1224,511,'Sistemas de calefaccion de compartimentos'),(1225,5111,'Sistemas de calefacción de compartimentos'),(1226,51111,'Calentadores de conducto. Elemento calentador'),(1227,51112,'Calentadores de conducto. Paneles de control'),(1228,51113,'Calentadores de torre'),(1229,51114,'Calentadores de toalla'),(1230,51115,'Unidades de calefacción con ventilador'),(1231,512,'Sistemas de ventilacion (no en locales de máquinas) '),(1232,5121,'Sistemas de ventilacion (no en locales de maquinas)'),(1233,51211,'Ventilacion (no en locales de maquinas). Ventiladores'),(1234,51212,'Ventilación (no en locales de maquinas). Válvulas'),(1235,51213,'Ventilacion (no en locales de maquinas). Conductos y accesorios'),(1236,51214,'Sistemas de Ventilacion en cocinas'),(1237,513,'Sistemas de ventilación (en locales de máquinas)'),(1238,5131,'Ventilacion (en locales de maquinas)'),(1239,51311,'Ventilacion (en locales de maquinas). Ventiladores'),(1240,51312,'Ventilacion (en locales de maquinas). Valvulas'),(1241,51313,'Ventilacion (en locales de maquinas). Conductos y accesorios'),(1242,51314,'Ventilacion (en locales de maquinas). Enfriadores y calentadores'),(1243,51317,'Ventilacion (en locales de maquinas). Valvulas motorizadas'),(1244,51318,'Ventilacion (en locales de maquinas). Valvulas motorizadas. Paneles de control'),(1245,5132,'Submarinos. Sistema de ventilación'),(1246,51321,'Submarinos. Sistema de ventilación'),(1247,514,'Sistemas de aire acondicionado'),(1248,5141,'Distribución de agua refrigerada'),(1249,51411,'Distribución de agua refrigerada'),(1250,5142,'Plantas de aire acondicionado'),(1251,51421,'Plantas de aire acondicionado'),(1252,5143,'Unidades autonomas de aire acondicionado'),(1253,51431,'Unidades autonomas de aire acondicionado'),(1254,5144,'Sistema de ciudadela (NBQ)'),(1255,515,'Sistemas de regeneracion de la atmosfera'),(1256,5151,'Sistemas de eliminacion de H2, CO y CO2'),(1257,51511,'Sistema de eliminacion de H2'),(1258,51512,'Sistema de eliminacion de CO'),(1259,51513,'Sistema de eliminacion de CO2'),(1260,5152,'Sistema principal de oxigeno'),(1261,51521,'Sistema principal de oxigeno'),(1262,5153,'Sistemas de analisis de atmosfera'),(1263,51531,'Análisis de atmosfera. Sistemas fijos'),(1264,51532,'Análisis de atmosfera. Sistemas portatiles'),(1265,5154,'Sistemas de generación de oxígeno'),(1266,51541,'Sistemas de generación de oxígeno'),(1267,516,'Sistemas de refrigeración'),(1268,5161,'Refrigeración, servicio propio'),(1269,51611,'Refrigeración, servicio propio'),(1270,5162,'Refrigeración de la carga'),(1271,51621,'Refrigeración de la carga'),(1272,517,'Otros generadores de calor'),(1273,5171,'Sistema de agua caliente'),(1274,51711,'Sistema de agua caliente. Calderas'),(1275,51712,'Sistema de agua caliente. Válvulas'),(1276,51713,'Sistema de agua caliente. Tuberías y accesorios.'),(1277,51714,'Sistema de agua caliente. Bombas'),(1278,5172,'Sistemas de calor residual'),(1279,51721,'Sistemas de calor residual'),(1280,52,'Sistemas de agua salada'),(1281,521,'Sistemas de contraincendios por agua salada'),(1282,5211,'Colector de C.I.'),(1283,52111,'Colector de C.I. Tuberías '),(1284,52112,'Colector de C.I. Valvulas '),(1285,52113,'Colector de C.I. Accesorios'),(1286,5212,'Bombas principales de C.I.'),(1287,52121,'Bombas principales de C.I.'),(1288,5214,'Bombas auxiliares de C.I.'),(1289,52141,'Bombas auxiliares de C.I.'),(1290,522,'Sistemas de rociado (SPRINKLER)'),(1291,5221,'Sistema de rociado en locales de armas'),(1292,52211,'Sistema de rociado en locales de armas'),(1293,5222,'Sistemas de rociado en locales no de armas'),(1294,52221,'Sistemas de rociado en locales no de armas)'),(1295,523,'Sistema de descontaminacion por agua (WASHDOWN)'),(1296,5231,'Sistema de descontaminacion por agua (WASHDOWN)'),(1297,52311,'Sistema de descontaminacion por agua (WASHDOWN). Tubería y accesorios'),(1298,52312,'Sistema de descontaminacion por agua (WASHDOWN). Válvulas'),(1299,524,'Sistemas de agua salada para maquinaria auxiliar'),(1300,5241,'Sistemas de agua salada para maquinaria auxiliar'),(1301,52411,'Sistemas de agua salada para maquinaria auxiliar. Tuberías, válvulas y accesorios'),(1302,52413,'Sistemas de agua salada para maquinaria auxiliar. Bombas'),(1303,5243,'Sistemas de agua salada para servicio sanitario'),(1304,52431,'Sistemas de agua salada para servicio sanitario'),(1305,525,'Valvulas de toma y descarga al mar'),(1306,5251,'Valvulas de toma y descarga al mar'),(1307,52511,'Valvulas de toma y descarga al mar. Manuales'),(1308,52512,'Valvulas de toma y descarga al mar. Motorizadas'),(1309,526,'Desagües de cubierta'),(1310,5261,'Imbornales y desagues de cubierta'),(1311,52611,'Imbornales y desagües de cubierta'),(1312,528,'Descargas sanitarias'),(1313,5281,'Descargas sanitarias'),(1314,52811,'Descargas sanitarias. Tuberías y válvulas'),(1315,52815,'Descargas sanitarias. Grupos hidróforos'),(1316,5282,'Descargas sanitarias (submarinos)'),(1317,52821,'Descargas sanitarias (submarinos)'),(1318,529,'Sistemas de achique y lastrado'),(1319,5291,'Sistema de achique y lastrado. Válvulas y tuberías'),(1320,52911,'Sistema de achique y lastrado. Válvulas y tuberías'),(1321,52913,'Sistema de achique y lastrado. Eyectores'),(1322,52914,'Sistema de achique y lastrado. Accesorios'),(1323,5292,'Sistema de achique y lastrado. Bombas y controladores'),(1324,52921,'Sistema de achique y lastrado. Bombas y controladores'),(1325,5293,'Buques anfibios. Sistema de lastrado y deslastrado. Tuberias'),(1326,52931,'Buques anfibios. Sistema de lastrado y deslastrado. Tuberias'),(1327,5294,'Buques anfibios. Sistema de lastrado y deslastrado. Bombas, válvulas y accesorios'),(1328,52941,'Buques anfibios. Sistema de lastrado y deslastrado. Bombas'),(1329,52942,'Buques anfibios. Sistema de lastrado y deslastrado. Válvulas'),(1330,52943,'Buques anfibios. Sistema de lastrado y deslastrado. Accesorios'),(1331,5295,'Buques anfibios. Sistema de lastrado y deslastrado. Estaciones de control.'),(1332,52951,'Buques anfibios. Sistema de lastrado y deslastrado. Estaciones de control.'),(1333,5296,'Compresores de deslastrado por aire'),(1334,52961,'Compresores de deslastrado por aire'),(1335,53,'Sistemas de agua dulce'),(1336,531,'Plantas desaladoras de agua del mar'),(1337,5311,'Planta destiladora tipo expansion'),(1338,53111,'Planta destiladora tipo expansion'),(1339,5312,'Planta destiladora por vapor'),(1340,53121,'Planta destiladora por vapor'),(1341,5313,'Planta destiladora por recuperacion de calor'),(1342,53131,'Planta destiladora por recuperacion de calor nº1'),(1343,53132,'Planta destiladora por recuperacion de calor nº2'),(1344,5314,'Planta destiladora de tubo sumergido'),(1345,53141,'Planta destiladora de tubo sumergido'),(1346,5315,'Plantas de ósmosis inversa'),(1347,53151,'Planta de ósmosis inversa Nº1'),(1348,53152,'Planta de ósmosis inversa Nº2'),(1349,53153,'Planta de ósmosis inversa nº3 '),(1350,53154,'Planta de ósmosis inversa nº4'),(1351,53155,'Planta de ósmosis inversa nº5'),(1352,53156,'Planta de ósmosis inversa nº6'),(1353,5316,'Planta destiladora (tipo canasta)'),(1354,53161,'Planta destiladora de tipo canasta'),(1355,532,'Sistemas de agua para refrigeracion'),(1356,5321,'Sistemas de agua refrigerada/desmineralizada para equipos electronicos'),(1357,53211,'Sistemas de agua refrigerada/desmineralizada para equipos electronicos'),(1358,533,'Sistemas de agua potable y destilada'),(1359,5331,'Sistema de agua potable'),(1360,53311,'Sistema de agua potable. Bombas'),(1361,53313,'Sistema de agua potable. Válvulas, Tuberías y accesorios'),(1362,53314,'Sistema de agua potable. Calentadores'),(1363,53315,'Sistema de agua potable. Grupos hidróforos'),(1364,53316,'Sistema de agua potable. Esterilización y sanitización'),(1365,5331,'Fuentes de agua fría (Vacas)'),(1366,5332,'Sistema de agua destilada/técnica'),(1367,53321,'Sistema de agua destilada/técnica. Bombas'),(1368,53322,'Sistema de agua destilada/técnica. Valvulas'),(1369,53323,'Sistema de agua destilada/técnica. Tuberías y accesorios'),(1370,53325,'Sistema de agua destilada/tecnica. Grupos hidroforos'),(1371,53329,'Submarinos. Sistema de agua destilada para refrigeracion de baterias'),(1372,534,'Vapor auxiliar en camaras de máquinas'),(1373,5341,'Vapor auxiliar en camaras de maquinas. Tuberia y controles'),(1374,53411,'Vapor auxiliar en camaras de maquinas. Tuberia y controles'),(1375,53412,'Vapor auxiliar en camaras de máquinas. Evacuacion de atmosfericos y obturadores'),(1376,53413,'Vapor auxiliar en camaras de máquinas. Sistema de perdidas de obturadores'),(1377,5344,'Sistema de evacuacion/ de vapor auxiliar'),(1378,53441,'Sistema de evacuacion/escape de vapor auxiliar'),(1379,5345,'Sistema colector de purgas de agua dulce'),(1380,53451,'Sistema colector de purgas de agua dulce'),(1381,5346,'Sistema de purga de contaminado'),(1382,53461,'Sistema de purga de contaminado'),(1383,5347,'Sistema de purgas de vapor de baja presion'),(1384,53471,'Sistema de purgas de vapor de baja presion'),(1385,535,'Vapor auxiliar no en espacios de maquinas'),(1386,5351,'Vapor auxiliar no en espacios de maquinas'),(1387,53511,'Vapor auxiliar no en espacios de maquinas'),(1388,536,'Sistema de refrigeración auxiliar con agua dulce'),(1389,5361,'Refrigeración auxiliar con agua dulce'),(1390,53611,'Refrigeración auxiliar con agua dulce'),(1391,5362,'Refrigeracion por agua dulce de equipos electronicos'),(1392,53621,'Refrigeracion por agua dulce de equipos electronicos'),(1393,54,'Sistemas de combustibles y lubricantes'),(1394,541,'Sistema de combustible (de compensación o no)'),(1395,5411,'Sistema de relleno y trasiego de combustible  (de compensación o no)'),(1396,54111,'Sistema de relleno y trasiego de combustible (no de compensación)'),(1397,54112,'Sistema de relleno y trasiego de combustible (de compensacion)'),(1398,54113,'Relleno y trasiego de combustible. Válvulas motorizadas (A EXTINGUIR)'),(1399,54114,'Relleno y trasiego de combustible. Válvulas manuales (A EXTINGUIR)'),(1400,5412,'Bombas de trasiego y depuradoras de combustible'),(1401,54121,'Bombas de trasiego de combustible'),(1402,54122,'Depuradoras de combustible'),(1403,5413,'Submarinos. Sistemas de combustible y de compenso'),(1404,54131,'Submarinos. Sistemas de combustible y de compenso'),(1405,542,'Sistemas de combustible de aviacion u otros (no de buques)'),(1406,5421,'Servicio de JP-5'),(1407,54211,'Servicio de JP-5. Tuberia y accesorios'),(1408,54212,'Servicio de JP-5. Bombas'),(1409,54213,'Servicio de JP-5. Depuradoras'),(1410,5422,'Servicio de JP-5. Bombas y depuradoras (PENDIENTE ANULACION)'),(1411,54221,'Servicio de JP-5. Bombas (PENDIENTE ANULACION)'),(1412,5423,'Tuberia y manejo del MOGAS'),(1413,54231,'Tuberia y manejo del MOGAS'),(1414,543,'Sistema de aceites lubricantes de aviacion u  otros (no de buques)'),(1415,5431,'Sistema de lubricacion de aviacion u  otros (no de buques)'),(1416,54311,'Sistema de lubricacion de aviacion u  otros (no de buques)'),(1417,544,'Sistema de liquidos de transporte'),(1418,5441,'Sistemas para manejo de combustibles y aceites (de transporte)'),(1419,54411,'Manejo de gas-oil (de transporte)'),(1420,54412,'Manejo de JP-5 (de transporte)'),(1421,54413,'Manejo de MOGAS (de transporte)'),(1422,54414,'Manejo de AVGAS (de transporte)'),(1423,54415,'Manejo de aceites (de transporte)'),(1424,5442,'Bombas y controladores para combustibles y aceites'),(1425,54421,'GAS-OIL. Bombas y controladores'),(1426,54422,'JP-5. Bombas y controladores'),(1427,54423,'MOGAS. Bombas y controladores'),(1428,54424,'AVGAS. Bombas y controladores'),(1429,54425,'Aceite lubricante. Bombas y controladores'),(1430,545,'Sistemas de calefaccion de tanques'),(1431,5451,'Tanques. Sistema de calefaccion'),(1432,54511,'Tanques de aceite. Sistema de calefaccion'),(1433,54512,'Tanques de gas-oil. Sistema de calefaccion'),(1434,54519,'Tanques de otros fluidos. Sistema de calefaccion'),(1435,546,'Sistemas de lubricación auxiliar'),(1436,5461,'Sistemas de lubricación auxiliar'),(1437,54611,'Submarinos. Sistema de engrase centralizado.'),(1438,549,'Combustibles y lubricantes especiales. Almacenamiento y manejo'),(1439,5491,'Combustibles y lubricantes especiales. Almacenamiento y manejo'),(1440,54911,'Combustibles y lubricantes especiales. Almacenamiento y manejo'),(1441,55,'Sistemas de aire, gas y fluidos diversos'),(1442,550,'Sistemas de aire, gas y fluidos diversos'),(1443,5501,'Sistemas de aire, gas y fluídos diversos'),(1444,55011,'Sistemas de aire, gas y fluidos diversos'),(1445,551,'Sistemas de aire comprimido'),(1446,5511,'Sistema de aire de alta presión'),(1447,55111,'Sistema de aire de alta presión'),(1448,5512,'Sistemas de aire de baja y media presión'),(1449,55121,'Sistemas de aire de baja y media presión'),(1450,55129,'Prairie Masker'),(1451,5513,'Sistema de aire seco'),(1452,55131,'Sistema de aire seco'),(1453,5515,'Compresores de aire'),(1454,55151,'Compresores de aire de alta presión'),(1455,55152,'Compresores de aire de media presión'),(1456,55153,'Compresores de aire de baja presión'),(1457,55154,'Compresores de aire (portatiles)'),(1458,5516,'Turbina Gas. Aire de sangría'),(1459,55163,'Turbina Gas. Aire de sangría para arranque'),(1460,55164,'Turbina Gas. Aire de sangría para antihielo'),(1461,5517,'Submarinos. Sistemas de aire para lanzamiento de torpedos'),(1462,55171,'Submarinos. Sistemas de aire para lanzamiento de torpedos'),(1463,5518,'Submarinos. Sistema de aire de control'),(1464,55181,'Submarinos. Sistema de aire de control'),(1465,5519,'Sistema de aire de respiración de emergencia'),(1466,55191,'Sistema de aire de respiracion de emergencia'),(1467,552,'Sistemas de gases comprimidos. Otros'),(1468,5521,'Sistemas de gases comprimidos. Otros'),(1469,55211,'Sistemas de gases comprimidos. Otros'),(1470,553,'Sistemas de Oxigeno o Nitrogeno'),(1471,5531,'Sistemas de almacenaje y distribucion de Oxigeno o Nitrogeno'),(1472,55311,'Sistemas de almacenaje y distribucion de oxigeno'),(1473,55312,'Sistema de almacenaje y distribución de nitrógeno'),(1474,5532,'Compresores de Oxigeno o Nitrogeno'),(1475,55321,'Compresores de Oxigeno o Nitrogeno (Alta presion)'),(1476,55322,'Compresores de Oxigeno o Nitrogeno (Baja presion)'),(1477,554,'Submarinos. Control de escora y soplado de lastres'),(1478,5541,'Submarinos. Sistema de soplado de lastres (Normal)'),(1479,55411,'Submarinos. Sistema de soplado de lastres (Normal)'),(1480,5542,'Submarinos. Control de escora y soplado de lastres (Emergencia)'),(1481,55421,'Submarinos. Control de escora y soplado de lastres (Emergencia)'),(1482,5543,'Submarinos. Sistema de soplado de lastres (Baja presion)'),(1483,55431,'Submarinos. Sistema de soplado de lastres (Baja presion)'),(1484,5544,'Submarinos. Soplado ártico'),(1485,55441,'Submarinos. Soplado ártico'),(1486,555,'Sistemas de extinción de incendios'),(1487,5551,'Sistemas de niebla, espuma y AFFF'),(1488,55511,'Sistemas de niebla, espuma y AFFF en espacios de máquinas'),(1489,55512,'Sistemas de niebla, espuma y AFFF no en espacios de máquinas'),(1490,55513,'Estaciones de suministro y trasiego de niebla, espuma y AFFF'),(1491,5552,'Extincion de incendios con polvo seco'),(1492,55521,'Extincion de incendios con polvo seco. Equipos portátiles'),(1493,55522,'Extincion de incendios con polvo seco. Sistemas fijos'),(1494,5553,'Sistemas de extinción de incendios con CO2 o HALON'),(1495,55531,'Sistemas de extinción de incendios con CO2'),(1496,55532,'Sistemas de extincion de incendios con HALON'),(1497,5554,'Sistemas de sofocacion de incendios con vapor'),(1498,55541,'Sistemas de sofocacion de incendios con vapor'),(1499,5555,'Sistemas de extinción de incendios con agua dulce'),(1500,55551,'Sistemas de extinción de incendios con agua dulce'),(1501,5556,'Sistemas de extincion de incendios en freidoras'),(1502,55561,'Sistemas de extincion de incendios en freidoras'),(1503,5557,'Sistemas de extincion de incendios por agentes dobles'),(1504,55571,'Sistemas de extincion de incendios por agentes dobles'),(1505,5558,'Otros sistemas de extincion de incendios'),(1506,55581,'Sistemas de extincion de incendios por Hexafluoruro de Azufre (SF6)'),(1507,5559,'Sistemas de extincion de incendios con nitrógeno'),(1508,55591,'Sistemas de extincion de incendios con nitrógeno'),(1509,556,'Sistemas de fluidos hidráulicos'),(1510,5561,'Sistema de potencia hidráulica del buque'),(1511,55611,'Sistema de potencia hidráulica del buque'),(1512,5562,'Submarinos. Sistema hidráulico exterior'),(1513,55621,'Submarinos. Sistema hidráulico exterior'),(1514,557,'Gases licuados (de transporte o para uso propio)'),(1515,5571,'Gases licuados (de transporte o para uso propio)'),(1516,55711,'Gases licuados. Tuberías y accesorios'),(1517,55712,'Gases licuados. Tanques'),(1518,558,'Sistemas de tuberias especiales'),(1519,5581,'Sistemas de tuberias especiales'),(1520,55811,'Sistemas de tuberias especiales'),(1521,56,'Sistemas de control del buque'),(1522,561,'Sistemas de gobierno y control de cota'),(1523,5611,'Sistema de gobierno'),(1524,56111,'Sistema de gobierno'),(1525,5612,'Submarinos. Planta hidráulica de rumbo y cota'),(1526,56121,'Submarinos. Planta hidráulica de rumbo y cota'),(1527,5613,'Submarinos. Sistema de control de rumbo y cota'),(1528,56131,'Submarinos. Sistema de control de rumbo y cota'),(1529,562,'Timones'),(1530,5621,'Timones'),(1531,56211,'Timón nº1 (ER) o único'),(1532,56212,'Timón nº2 (Br)'),(1533,563,'Submarinos. Flotabilidad y estabilización de cota'),(1534,5631,'Submarinos. Flotabilidad y estabilización de cota'),(1535,56311,'Submarinos. Sistema de tanques de regulación'),(1536,5632,'Sistema de medida de capacidad y profundidad'),(1537,56321,'Sistema de medida de capacidad y profundidad'),(1538,5633,'Submarinos. Sistema de estabilización de cota'),(1539,56331,'Submarinos. Sistema de estabilización de cota'),(1540,564,'Submarinos. Sistema de achique y trimado'),(1541,5641,'Submarinos. Sistemas de achique y trimado (Principal y Auxiliar)'),(1542,56411,'Submarinos. Sistemas de achique y trimado (Principal y Auxiliar)'),(1543,5642,'Submarinos. Sistemas de achique por gravedad y por soplado'),(1544,56421,'Submarinos. Sistemas de achique por gravedad y por soplado'),(1545,5646,'Submarinos. Sistemas de achique de la condensación'),(1546,56461,'Submarinos. Sistemas de achique de la condensación'),(1547,565,'Sistemas estabilizadores (Buques de superficie)'),(1548,5651,'Aletas estabilizadoras (Buques de superficie)'),(1549,56511,'Aleta estabilizadora nº1'),(1550,56512,'Aleta estabilizadora nº2'),(1551,56513,'Aleta estabilizadora nº3'),(1552,56514,'Aleta estabilizadora nº4'),(1553,56515,'Aletas estabilizadoras. Sistemas comunes'),(1554,566,'Submarinos. Timones de buceo y aletas estabilizadoras'),(1555,5661,'Submarinos. Timones de buceo y aletas estabilizadoras'),(1556,56611,'Submarinos. Timones de buceo de proa'),(1557,56612,'Submarinos. Timones de buceo de popa'),(1558,56613,'Submarinos. Aletas estabilizadoras'),(1559,567,'Hidroalas. Sistemas de sustentacion'),(1560,5671,'Hidroalas. Sistemas de sustentacion'),(1561,56711,'Hidroalas. Sistemas de sustentacion'),(1562,568,'Sistemas de maniobra'),(1563,5681,'Sistemas de empuje transversal'),(1564,56811,'Sistemas de empuje transversal'),(1565,57,'Sistemas de aprovisionamiento'),(1566,570,'Pruebas del sistema de aprovisionamiento en la mar'),(1567,5701,'Pruebas del sistema de aprovisionamiento en la mar'),(1568,57011,'Pruebas del sistema de aprovisionamiento en la mar'),(1569,571,'Maniobra de aprovisionamiento en la mar'),(1570,5711,'Chigres de aprovisionamiento en la mar'),(1571,57111,'Aprovisionamiento en la mar. Chigres de carga'),(1572,57112,'Aprovisionamiento en la mar. Chigres del amantillo'),(1573,57113,'Aprovisionamiento en la mar. Chigres del andarivel'),(1574,57114,'Aprovisionamiento en la mar. Chigres de halar'),(1575,57115,'Aprovisionamiento en la mar. Chigres del cable'),(1576,57116,'Aprovisionamiento en la mar. Chigres de manguera y recogida'),(1577,5712,'Dispositivos de aprovisionamiento en la mar a tension constante'),(1578,57121,'Dispositivos de aprovisionamiento en la mar a tension constante'),(1579,5713,'Bloques de transferencia, pastecas y cancamos deslizantes'),(1580,57131,'Bloques de transferencia, pastecas y cancamos deslizantes'),(1581,5714,'Aprovisionamiento y petroleo en la mar'),(1582,57141,'Aprovisionamiento en la mar. Pescantes y maniobra'),(1583,57142,'Petroleo en la mar. Pescantes y maniobra'),(1584,5715,'Estaciones de aprovisionamiento en la mar'),(1585,57151,'Estaciones de aprovisionamiento en la mar'),(1586,572,'Manipulacion de equipos y efectos del buque'),(1587,5721,'Equipos de manipulacion de efectos del buque'),(1588,57211,'Equipos de manipulacion de efectos del buque, fijos'),(1589,57212,'Equipos de manipulacion de efectos del buque, portatiles'),(1590,573,'Sistemas para manejo de carga'),(1591,5731,'Ascensores de carga o montacargas'),(1592,57311,'Ascensores de carga o montacargas'),(1593,5732,'Cintas transportadoras para carga'),(1594,57321,'Cintas transportadoras para carga vertical'),(1595,57322,'Cintas transportadoras para palets'),(1596,5733,'Manejo de la carga bajo cubierta'),(1597,57331,'Monorrailes'),(1598,57332,'Transportadores de palets'),(1599,57333,'Transportadores de rodillos'),(1600,57334,'Gruas puente'),(1601,5734,'Carretillas elevadoras'),(1602,57341,'Carretillas elevadoras de horquilla'),(1603,57342,'Carretillas elevadoras de contenedores'),(1604,5735,'Chigres de manejo de carga'),(1605,57351,'Chigres de manejo de carga'),(1606,5736,'Pescantes, maniobra y dispositivos de manejo de carga'),(1607,57361,'Pescantes, maniobra y dispositivos de manejo de carga'),(1608,574,'Sistemas de aprovisionamiento vertical (VERTREP)'),(1609,5741,'Sistemas de aprovisionamiento vertical (VERTREP)'),(1610,57411,'Estacion VERTREP nº1'),(1611,57412,'Estacion VERTREP nº2'),(1612,575,'Sistema de estiba y manejo de vehiculos'),(1613,5751,'Sistema de estiba y manejo de vehiculos'),(1614,57511,'Sistema de estiba y manejo de vehiculos'),(1615,58,'Sistemas para maniobra'),(1616,581,'Sistemas de maniobra y estiba de anclas'),(1617,5811,'Maniobra y estiba de anclas'),(1618,58111,'Anclas'),(1619,58112,'Elementos para maniobra de anclas'),(1620,582,'Sistemas de amarre y remolque'),(1621,5821,'Sistemas de amarre y remolque'),(1622,58211,'Elementos para maniobra de Amarre'),(1623,58212,'Elementos para maniobra de Remolque'),(1624,583,'Embarcaciones menores y Sistemas de Salvamento'),(1625,5831,'Manejo y estiba de botes'),(1626,58311,'Manejo y estiba de botes'),(1627,5832,'Equipo de salvamento (excepto botes)'),(1628,58321,'Balsas salvavidas inflables (en contenedor)'),(1629,58322,'Chalecos salvavidas'),(1630,58323,'Maniobra hombre al agua (AEL)'),(1631,58329,'Otros sistemas de salvamento en la mar'),(1632,5833,'Botes menores'),(1633,58331,'Botes Inflables Rígidos (RHIBs)'),(1634,58332,'Botes neumaticos (Hasta 5 mts eslora)'),(1635,58334,'Botes, Botes Hidrográficos y Balleneras'),(1636,58335,'Motores fueraborda'),(1637,58339,'Faluas embarcadas'),(1638,5834,'Embarcaciones de desembarco'),(1639,58341,'Embarcaciones de desembarco (LCVP)'),(1640,58342,'Embarcaciones de desembarco (LCPL)'),(1641,5835,'Embarcaciones para buceadores'),(1642,58351,'Lanchas para transporte de buceadores'),(1643,584,'Sistemas de estiba y maniobra de embarcaciones de desembarco'),(1644,5841,'Portas y escotillas mecanicas'),(1645,58411,'Portas de proa'),(1646,58412,'Portas de popa'),(1647,5842,'Puertas mecanicas'),(1648,58421,'Puertas mecanicas'),(1649,5843,'Rampas de costado'),(1650,58431,'Rampa de costado nº1'),(1651,58432,'Rampa de costado nº2'),(1652,5844,'Plataformas giratorias'),(1653,58441,'Plataformas giratorias'),(1654,5845,'Rampas interiores'),(1655,58451,'Rampa interior nº1'),(1656,58452,'Rampa interior nº2'),(1657,585,'Mecanismos izables y retráctiles'),(1658,5851,'Periscopios. Mecanismos'),(1659,58511,'Periscopio de observación. Mecanismos'),(1660,58512,'Periscopio de ataque. Mecanismos'),(1661,5852,'Submarinos. Mástiles y sus mecanismos'),(1662,58521,'Submarinos. Mástiles de comunicaciones'),(1663,58523,'Submarinos. Mástil radar y sus mecanismos'),(1664,58524,'Submarinos. Mástil de EW y sus mecanismos'),(1665,58525,'Submarinos. Mástil de antena múltiple'),(1666,58528,'Sistemas comunes a varios tipos de mástiles'),(1667,588,'Maniobra, estiba y servicio de aeronaves'),(1668,5881,'Ascensores de aeronaves'),(1669,58811,'Ascensor de aeronaves nº1'),(1670,58812,'Ascensor de aeronaves nº2'),(1671,5882,'Maniobra y apoyo de aeronaves'),(1672,58821,'Sistemas de apoyo y traslado de helicópteros sobre cubierta'),(1673,58822,'Maniobra y apoyo de aeronaves. Accesorios'),(1674,5883,'Hangares de aeronaves'),(1675,58831,'Hangares de aeronaves. Puertas de acceso y de division'),(1676,58832,'Hangares de aeronaves. Cortinas'),(1677,58833,'Hangares de aeronaves. Gruas y aparejos de izado'),(1678,58834,'Hangares de aeronaves. Plataformas para mantenimiento'),(1679,58835,'Hangares de aeronaves. Instalaciones'),(1680,58838,'Hangares retráctiles o telescópicos'),(1681,5884,'Tren Amarillo'),(1682,58841,'Tren Amarillo 1. Grupos de arranque'),(1683,58842,'Tren amarillo 2. Carros portabotellas'),(1684,58843,'Tren Amarillo 3. Vehículos para armas'),(1685,58844,'Tren Amarillo 4. Tractores-remolcadores'),(1686,58845,'Tren Amarillo 5. Mulas mecánicas'),(1687,58846,'Tren Amarillo 6. Equipos contraincendios'),(1688,58847,'Tren Amarillo 7. Crash-Crane'),(1689,58848,'Tren Amarillo 8. Taller tren Amarillo//material apoyo aeronaves'),(1690,58849,'Tren Amarillo 9. Material diverso'),(1691,5885,'Material y vestuario para personal de apoyo al vuelo'),(1692,58851,'Material y vestuario para personal de apoyo al vuelo'),(1693,589,'Sistemas mecánicos diversos'),(1694,5891,'Grúas giratorias'),(1695,58911,'Grúas giratorias'),(1696,5892,'Gruas puente y polipastos'),(1697,58921,'Gruas puente y polipastos'),(1698,5893,'Ascensores de personal'),(1699,58931,'Ascensores de personal'),(1700,5894,'Escaleras mecanicas'),(1701,58941,'Escaleras mecanicas'),(1702,5895,'Sistemas de la porta y rampa de popa'),(1703,58951,'Rampa de popa'),(1704,58952,'Porta de popa'),(1705,58953,'Porta de popa. Sistema hidraulico'),(1706,58954,'Porta de popa. Sistema de control'),(1707,5896,'Sistemas de portas y rampas de costado'),(1708,58961,'Rampa movil'),(1709,58962,'Portas de costado'),(1710,58963,'Plataforma abisagrada'),(1711,58964,'Portas de costado. Sistema hidraulico'),(1712,58965,'Portas de costado. Sistema de control'),(1713,59,'Sistemas para fines especiales'),(1714,591,'Sistemas cientificos y oceanográficos'),(1715,5911,'Sistemas cientificos y oceanográficos'),(1716,59111,'Sistemas cientificos y oceanográficos'),(1717,59112,'Sistemas de toma de datos oceanográficos'),(1718,59113,'Sistemas para investigación sísmica'),(1719,59114,'Maniobra de equipos científicos'),(1720,59115,'Sondas científicas'),(1721,592,'Sistemas para Unidades Especiales (Buceadores, Paracaidistas, etc)'),(1722,5921,'Instalaciones de apoyo a buceadores'),(1723,59211,'Instalaciones de apoyo a buceadores'),(1724,59212,'Buceo. Compresores para relleno de botellas (aire)'),(1725,59213,'Buceo. Sistemas para relleno de botellas (mezclas)'),(1726,59217,'Sistemas hiperbáricos'),(1727,59219,'Submarinos. Esclusa de Salvamento. Uso para buceadores'),(1728,5922,'Material de Buceo'),(1729,59221,'Buceo. Equipos y material de buceo'),(1730,5923,'Paracaidismo. Material'),(1731,59231,'Paracaidas'),(1732,59232,'Paracaidismo. Complementos'),(1733,593,'Sistemas de control de la contaminación'),(1734,5931,'Sistemas anti-contaminación por residuos sanitarios'),(1735,59311,'Sistema de tratamiento de aguas residuales'),(1736,59312,'Sistema de evacuación de residuos sanitarios'),(1737,5932,'Sistemas anti-contaminacion por residuos oleosos'),(1738,59321,'Sistemas anti-contaminacion por residuos oleosos'),(1739,5933,'Sistemas anti-contaminacion por residuos solidos e industriales'),(1740,59331,'Sistemas anti-contaminacion por residuos solidos secos'),(1741,59333,'Sistemas anti-contaminacion por residuos organicos'),(1742,59334,'Incineradores de basuras'),(1743,5934,'Submarinos. Sistemas de eliminación de basuras'),(1744,59341,'Submarinos. Sistemas de eliminación de basuras'),(1745,5935,'Sistemas de lucha contra la contaminación marina'),(1746,59351,'Sistemas de lucha contra la contaminación marina'),(1747,594,'Submarinos. Sistemas de rescate, supervivencia y salvamento'),(1748,5941,'Submarinos. Sistemas de rescate, supervivencia y salvamento'),(1749,59411,'Sistema de localización submarino hundido'),(1750,59412,'Esclusas de salvamento'),(1751,59413,'Sistema de aire de salvamento'),(1752,59414,'Submarinos. Sistemas individuales de escape'),(1753,59415,'Submarinos. Sistemas de aligeramiento rapido'),(1754,595,'Sistemas de maniobra, largado y remolque de sistemas submarinos'),(1755,5951,'Sistemas para maniobra, largado y remolque de sistemas acusticos'),(1756,59511,'Sistemas para maniobra, largado y remolque de sistemas acusticos'),(1757,5952,'Sistemas para maniobra, largado y remolque del sonar remolcado'),(1758,59521,'Sistemas para maniobra, largado y remolque del sonar remolcado'),(1759,5953,'Submarinos. Lanzadores interiores'),(1760,59531,'Submarinos. Lanzadores interiores'),(1761,5954,'Lanzadores exteriores (submarinos)'),(1762,59541,'Lanzadores exteriores (submarinos)'),(1763,596,'Sistemas de maniobra para buzos y vehiculos sumergibles'),(1764,5961,'Sistemas de maniobra para buzos y vehículos sumergibles'),(1765,59611,'Sistemas de maniobra para buzos'),(1766,59612,'Sistemas de maniobra para vehículos sumergibles'),(1767,597,'Sistemas de ayuda al salvamento de submarinos'),(1768,5971,'Sistemas de apoyo al salvamento y supervivencia de submarinos'),(1769,59711,'Sistemas de apoyo al salvamento y supervivencia de submarinos'),(1770,598,'Sistemas Auxiliares. Fluidos'),(1771,599,'Sistemas Auxiliares. Repuestos, herramientas especiales.'),(1772,5991,'Sistemas Auxiliares. Repuestos, herramientas especiales.'),(1773,59911,'Sistemas Auxiliares. Repuestos'),(1774,59912,'Sistemas Auxiliares. Herramientas especiales'),(1775,5992,'Sistemas Auxiliares. Herramientas especiales'),(1776,59921,'Sistemas Auxiliares. Herramientas especiales'),(1777,6,'Habitabilidad y equipamiento general'),(1778,60,'Habitabilidad y equipamiento general'),(1779,601,'Disposicion general. Planos de habitabilidad y equipamiento'),(1780,602,'Señales y marcas del casco'),(1781,6021,'Placas identificadoras (Del fabricante)'),(1782,603,'Marcas de calado'),(1783,604,'Cerraduras, llaves y rótulos'),(1784,605,'Proteccion contra roedores e insectos'),(1785,61,'Accesorios del buque'),(1786,611,'Accesorios del casco'),(1787,6111,'Accesorios del casco'),(1788,61111,'Accesorios del casco'),(1789,6112,'Submarinos. Cáncamos y dispositivos de izado'),(1790,61121,'Submarinos. Cáncamos y dispositivos de izado'),(1791,612,'Candeleros, pasamanos, cabos salvavidas, redes de seguridad'),(1792,6121,'Candeleros, pasamanos y cabos salvavidas'),(1793,61211,'Candeleros, pasamanos y cabos salvavidas'),(1794,6122,'Redes de seguridad'),(1795,61221,'Redes de seguridad de la cubierta de vuelo'),(1796,613,'Jarcia, lonas y fundas'),(1797,6131,'Jarcia, lonas y fundas'),(1798,61311,'Jarcia y drizas'),(1799,61312,'Toldos y fundas'),(1800,62,'Compartimentacion no estructural'),(1801,621,'Mamparos no estructurales'),(1802,6211,'Mamparos no estructurales'),(1803,62111,'Mamparos no estructurales'),(1804,622,'Falsos pisos y tecles'),(1805,6221,'Falsos pisos y tecles'),(1806,62211,'Falsos pisos y tecles en los espacios de máquinas'),(1807,62212,'Falsos pisos y tecles fuera de los espacios de máquinas'),(1808,623,'Escalas'),(1809,6231,'Escalas, excepto la escala real'),(1810,62311,'Escalas en espacios de máquinas'),(1811,62312,'Escalas fuera de espacios de máquinas. (Excepto la escala real)'),(1812,62313,'Planchas y escalas de personal'),(1813,62314,'Escala de práctico'),(1814,6232,'Escala real'),(1815,62321,'Escala real'),(1816,624,'Cierres no estructurales'),(1817,6241,'Cierres no estructurales'),(1818,62411,'Cierres no estructurales en espacios de máquinas'),(1819,62412,'Cierres no estructurales fuera de los espacios de máquinas'),(1820,625,'Portillos y ventanas'),(1821,6251,'Portillos y ventanas'),(1822,62511,'Portillos y ventanas'),(1823,63,'Recubrimientos y protecciones'),(1824,631,'Pintura'),(1825,6311,'Pintado de interiores'),(1826,63111,'Pintado de sentinas'),(1827,63112,'Pintado (en locales de máquinas)'),(1828,63113,'Pintado (no en locales de máquinas)'),(1829,6312,'Pintado exterior'),(1830,63121,'Pintado de zonas exteriores'),(1831,6313,'Chorreado y pintado de la obra viva en buques de superficie'),(1832,63131,'Chorreado y pintado de la obra viva (Buques de superficie)'),(1833,6314,'Chorreado y pintado de la obra muerta en buques de superficie'),(1834,63141,'Chorreado y pintado de la obra muerta en buques de superficie'),(1835,6315,'Submarinos. Pintado de tanques exteriores y estructurales'),(1836,63151,'Submarinos. Pintado de tanques exteriores y estructurales'),(1837,632,'Revestimientos metálicos'),(1838,6321,'Revestimientos de zinc'),(1839,63211,'Revestimientos de zinc'),(1840,63212,'Galvanizado'),(1841,6322,'Revestimientos de aluminio en spray'),(1842,63221,'Revestimientos de aluminio'),(1843,6323,'Revestimientos y chapas metalicas de proposito especial'),(1844,63231,'Revestimientos metálicos'),(1845,63232,'Chapas metalicas para fines especiales'),(1846,633,'Protección catódica'),(1847,6331,'Protección catódica por ánodos de sacrificio'),(1848,63311,'Protección catódica por ánodos de sacrificio'),(1849,6332,'Protección catódica por corrientes impresas'),(1850,63321,'Protección catódica servicios de agua salada'),(1851,63322,'Protección catódica del casco/apéndices'),(1852,634,'Recubrimiento de cubiertas'),(1853,6341,'Recubrimiento de cubiertas'),(1854,63411,'Recubrimiento de cubiertas'),(1855,6342,'Recubrimiento antideslizante de cubiertas'),(1856,63421,'Recubrimiento antideslizante de cubiertas de hangar y de vuelo'),(1857,63422,'Recubrimiento antideslizante de cubiertas (no de vuelo)'),(1858,635,'Aislamiento del casco'),(1859,6351,'Aislamiento del casco'),(1860,63511,'Aislamiento del casco'),(1861,636,'Amortiguamiento del casco'),(1862,6361,'Amortiguamiento del casco'),(1863,63611,'Amortiguamiento del casco'),(1864,637,'Revestimientos y recubrimientos'),(1865,6371,'Revestimientos y recubrimientos'),(1866,63711,'Revestimientos y recubrimientos'),(1867,63712,'Falsos techos'),(1868,638,'Locales refrigerados'),(1869,6381,'Locales refrigerados para provisiones uso propio'),(1870,63811,'Cámaras y locales refrigerados uso propio'),(1871,63819,'Contenedores frigoríficos'),(1872,6382,'Locales refrigerados para la carga'),(1873,63821,'Locales refrigerados para la carga'),(1874,639,'Nuclear. Recubrimientos antirradiacion'),(1875,6391,'Nuclear. Recubrimientos antirradiacion y recipientes blindados'),(1876,63911,'Nuclear. Recubrimientos antirradiacion y recipientes blindados'),(1877,64,'Zonas de habitabilidad'),(1878,641,'Oficiales. Alojamientos y cámara'),(1879,6411,'Oficiales. Alojamientos'),(1880,64111,'Oficiales. Camarotes'),(1881,64112,'Comandante. Camarote (Previsto 64111)'),(1882,64114,'Oficiales Generales. Camarote (Previsto 64111)'),(1883,6412,'Oficiales. Cámaras'),(1884,64121,'Oficiales. Cámara y repostería'),(1885,64124,'Comandante. Camara y reposteria (Previsto 64121)'),(1886,64126,'Oficiales Generales. Cámara (Previsto 64121)'),(1887,642,'Suboficiales. Alojamientos y comedores'),(1888,6421,'Suboficiales. Alojamientos'),(1889,64211,'Suboficiales. Camarotes'),(1890,6422,'Suboficiales. Comedor'),(1891,64221,'Suboficiales. Comedor'),(1892,643,'Marinería. Sollados y comedores'),(1893,6431,'Marinería. Sollados'),(1894,64311,'Cabos 1º. Sollados'),(1895,64312,'Marinería. Sollados'),(1896,6432,'Marinería. Comedores'),(1897,64321,'Marinería. Comedores'),(1898,64322,'Cabos 1º. Comedores'),(1899,644,'Locales de aseo y su equipamiento'),(1900,6441,'Locales de aseo y su equipamiento'),(1901,64411,'Locales de aseo y su equipamiento'),(1902,645,'Locales de formacion, recreo y descanso'),(1903,6451,'Locales de formacion, recreo y descanso'),(1904,64511,'Bibliotecas y salas de estudio'),(1905,64512,'Gimnasios'),(1906,64513,'Capilla y efectos religiosos'),(1907,65,'Locales de servicio'),(1908,651,'Locales de preparación de comidas'),(1909,6511,'Locales de preparación de comidas'),(1910,65111,'Cocinas'),(1911,65112,'Autoservicio'),(1912,65113,'Panaderia'),(1913,65115,'Cantinas'),(1914,652,'Espacios y material sanitario'),(1915,6521,'Enfermeria. Mobiliario y equipos'),(1916,65211,'Enfermeria. Mobiliario y equipos'),(1917,65212,'Sala de consultas'),(1918,65213,'Quirofano/Sala de curas'),(1919,65214,'Sala de Rayos X'),(1920,65215,'Sistema de telemedicina'),(1921,65216,'Estaciones de descontaminación'),(1922,65217,'Fuentes lavaojos (Fijas y portátiles)'),(1923,65218,'Otros espacios médicos'),(1924,6522,'Dentista. Local y equipos'),(1925,65221,'Dentista. Local y equipos'),(1926,654,'Locales de uso general y su mobiliario y equipos'),(1927,6541,'Locales de uso general y su mobiliario y equipos'),(1928,65411,'Peluqueria'),(1929,65412,'Cartería'),(1930,65413,'Tienda'),(1931,65414,'Calabozo'),(1932,65415,'Capilla'),(1933,655,'Lavanderia y tintoreria'),(1934,6551,'Lavandería y tintorería'),(1935,65511,'Lavadoras'),(1936,65512,'Secadoras'),(1937,65513,'Maquinas de planchar'),(1938,65519,'Efectos de lavanderia, tintoreria y sastreria'),(1939,656,'Locales de eliminacion de desperdicios'),(1940,6561,'Locales de eliminacion de desperdicios'),(1941,65611,'Locales de eliminacion de desperdicios'),(1942,66,'Locales de trabajo'),(1943,661,'Oficinas'),(1944,6611,'Oficinas'),(1945,66111,'Oficina de 2ª Comandancia y Detall'),(1946,66112,'Oficina de Máquinas'),(1947,66113,'Oficinas de Aprovisionamiento'),(1948,66114,'Centro de Informacion y Combate (CIC)'),(1949,66115,'Oficina de Comandancia'),(1950,66116,'Oficina de Armas y Sistema de Combate'),(1951,66117,'Oficina de Operaciones/Control del Buque'),(1952,66118,'Oficina de Habilitacion'),(1953,66119,'Remolques y contenedores de oficina'),(1954,6611,'Locales Radio y CECOMs'),(1955,6611,'Local del Oficial de Guardia'),(1956,6611,'Local del Suboficial de Guardia'),(1957,6611,'Local del Cuerpo de Guardia'),(1958,6611,'Salas de Juntas'),(1959,6611,'Despachos de uso genérico'),(1960,662,'Centros de control de máquinas y su mobiliario'),(1961,6621,'Centros de control de máquinas y su mobiliario'),(1962,66211,'Centros de control de máquinas y su mobiliario'),(1963,663,'Centros de equipos electrónicos y su mobiliario'),(1964,6631,'Centros de equipos electrónicos y su mobiliario'),(1965,66311,'Centros de equipos electrónicos y su mobiliario'),(1966,664,'Central y Trozos de Seguridad Interior y su material.'),(1967,6641,'Material de Seguridad Interior'),(1968,66411,'Mangueras de C.I. y sus complementos'),(1969,66413,'Equipos respiratorios y de comprobación de la atmósfera'),(1970,66414,'Motobombas portatiles'),(1971,66415,'Equipos de soldadura y corte'),(1972,66416,'Bombas sumergibles y eyectores de achique'),(1973,66417,'Efectos de apuntalamiento y parcheo'),(1974,66418,'Vestuario de S.I.'),(1975,66419,'Efectos diversos de Seguridad Interior'),(1976,6641,'Guerra NBQ. Equipos y efectos'),(1977,665,'Talleres y laboratorios (incluye herramientas y equipos)'),(1978,6651,'Talleres y laboratorios de CMyE'),(1979,66511,'Talleres mecánicos'),(1980,66512,'Talleres de electricidad'),(1981,66513,'Talleres de carpintería'),(1982,66514,'Talleres y equipos de soldadura'),(1983,6652,'Talleres y laboratorios de electronica'),(1984,66521,'Talleres y laboratorios de electronica'),(1985,6653,'Talleres y laboratorios de aeronaves'),(1986,66531,'Talleres y laboratorios de aeronaves'),(1987,6654,'Talleres y laboratorios de armas'),(1988,66541,'Talleres y laboratorios de armas'),(1989,6655,'Talleres de Infanteria de Marina'),(1990,66551,'Talleres para vehiculos de Infanteria de Marina'),(1991,6656,'Talleres y laboratorios de equipos de buceo'),(1992,66561,'Talleres de equipos de buceo autónomo'),(1993,66562,'Talleres de equipos de buceo de gran profundidad'),(1994,66563,'Talleres de equipos de buceo de guerra '),(1995,6657,'Laboratorios cientificos'),(1996,66571,'Laboratorios cientificos'),(1997,67,'Locales de estiba'),(1998,671,'Armarios y estibas especiales y su contenido'),(1999,6711,'Armarios y estibas especiales y su contenido'),(2000,67111,'Ropa de agua y chaquetones de mar'),(2001,67112,'Ropa especial contra el frio'),(2002,67114,'Material y ropa de deportes'),(2003,67116,'Material para la Patrulla de Vigilancia en Tierra'),(2004,672,'Pañoles y despensas'),(2005,6721,'Pañoles'),(2006,67211,'Pañoles de Maniobra'),(2007,67212,'Pañoles de Derrota'),(2008,67213,'Pañoles de Maquinas'),(2009,67214,'Pañoles de Electricidad'),(2010,67215,'Pañol de Buceo'),(2011,67216,'Pañoles de Pinturas'),(2012,67217,'Pañol de Liquidos Inflamables'),(2013,67218,'Pañoles de Aprovisionamiento'),(2014,67219,'Pañol de Guerra NBQ'),(2015,6721,'Pañol de Aviacion'),(2016,6721,'Pañoles de Habitabilidad'),(2017,6721,'Pañoles de Limpieza'),(2018,6721,'Pañol del Condestable'),(2019,6722,'Despensas y pañoles de viveres'),(2020,67221,'Pañoles de vÍveres'),(2021,67222,'Pañoles de bebidas'),(2022,673,'Estiba de la carga'),(2023,6731,'Estiba de la carga'),(2024,67311,'Estiba de la carga'),(2025,68,'Material y equipamiento de combate'),(2026,681,'Material de campaña'),(2027,6811,'Material de campaña individual'),(2028,68111,'Material de campaña individual'),(2029,6811,'Vestuario para clima frio'),(2030,6812,'Material de campaña colectivo'),(2031,68121,'Remolques-caravana de campaña'),(2032,68124,'Tiendas, sillas y mesas de campaña'),(2033,68125,'Redes'),(2034,6813,'Material de zapadores'),(2035,68131,'Material de zapadores'),(2036,6814,'Material de escalada'),(2037,68141,'Material de escalada'),(2038,683,'Material Infanteria de Marina individual (No de campaña)'),(2039,6831,'Material Infanteria de Marina individual (No de campaña)'),(2040,68311,'Material Infanteria de Marina individual (No de campaña)'),(2041,69,'Sistemas para usos especiales'),(2042,699,'Habitabilidad y equipamiento general. Repuestos y herramientas especiales'),(2043,6991,'Habitabilidad y equipamiento general. Pertrechos diversos'),(2044,69911,'Habitabilidad y equipamiento general. Pertrechos'),(2045,69913,'Habitabilidad y equipamiento general. Herramientas especiales'),(2046,69914,'Habitabilidad y equipamiento general. Fluidos'),(2047,7,'Armas'),(2048,70,'Generalidades de armas'),(2049,701,'Disposición general de los sistemas de armas'),(2050,702,'Instalaciones de armas'),(2051,703,'Manejo y estiba de armas. Generalidades'),(2052,71,'Cañones y municiones'),(2053,711,'Cañones y montajes'),(2054,7111,'Cañones y montajes'),(2055,71111,'Cañon nº1'),(2056,71112,'Cañon nº2'),(2057,71113,'Cañon nº3'),(2058,71114,'Cañon nº4'),(2059,71115,'Cañon 40mm nº1'),(2060,71116,'Cañon 40mm nº2'),(2061,71117,'Cañon 40mm nº3'),(2062,7112,'Ametralladoras de 20mm'),(2063,71121,'Ametralladora de 20mm nº1'),(2064,71122,'Ametralladora de 20mm nº2'),(2065,7113,'Cañones antimisiles'),(2066,71131,'Montaje MEROKA 2A'),(2067,71132,'Montajes MEROKA 2A3 y 2B (Fragatas FFG)'),(2068,7114,'Cañones de 25mm'),(2069,71141,'Cañón de 25mm Nº1'),(2070,71142,'Cañon de 25mm Nº2'),(2071,712,'Manejo de la municion de artilleria'),(2072,7121,'Manejo de la municion de artilleria'),(2073,71211,'Manejo de la municion de artilleria'),(2074,713,'Estiba de la municion propia'),(2075,7131,'Estiba de la munición propia'),(2076,71311,'Estiba de la munición propia de calibre 20mm y superior'),(2077,71312,'Estiba de la munición propia de calibre menor de 20mm (Armas portátiles)'),(2078,719,'Sistemas para alineación y pruebas de los sistemas de armas'),(2079,7191,'Sistemas para la alineacion y pruebas de armas'),(2080,71911,'Equipos para la alineacion y pruebas de armas'),(2081,72,'Misiles y cohetes'),(2082,721,'Misiles y cohetes. Dispositivos de lanzamiento'),(2083,7211,'Sistemas de lanzamiento de misiles'),(2084,72111,'Sistemas de lanzamiento de misiles'),(2085,72112,'Sistemas de lanzamiento de misiles de Infanteria de Marina'),(2086,7212,'Sistemas de lanzamiento de cohetes ASW/SUW'),(2087,72121,'Sistemas de lanzamiento de cohetes ASW/SUW'),(2088,7213,'Sistemas combinados de lanzamiento, estiba y manejo de misiles y cohetes ASW/SUW'),(2089,72131,'Lanzadores HARPOON (En canasta)'),(2090,72132,'Lanzadores verticales de misiles'),(2091,7214,'Submarinos. Tubos de misiles'),(2092,72141,'Submarinos. Tubos de carga de misiles'),(2093,72142,'Submarinos. Tubos de lanzamiento de misiles'),(2094,7215,'Submarinos. Sistema de lanzamiento vertical'),(2095,72151,'Submarinos. Sistema de lanzamiento vertical'),(2096,722,'Sistemas de manejo de misiles, cohetes y capsulas de guiado'),(2097,7221,'Manejo de misiles'),(2098,72211,'Manejo de misiles'),(2099,7222,'Manejo de cohetes ASW/SUW'),(2100,72221,'Manejo de cohetes ASW/SUW'),(2101,7223,'Submarinos. Manejo de misiles y capsulas de guiado'),(2102,72231,'Submarinos. Manejo de misiles y capsulas de guiado'),(2103,723,'Estiba de misiles y cohetes'),(2104,7231,'Estiba de misiles'),(2105,72311,'Estiba de misiles'),(2106,7232,'Estiba de cohetes ASW/SUW'),(2107,72321,'Estiba de cohetes ASW/SUW'),(2108,724,'Sistemas hidráulicos de misiles'),(2109,7241,'Sistemas hidráulicos de misiles'),(2110,72411,'Sistemas hidráulicos de misiles'),(2111,725,'Submarinos. Sistemas de gas para misiles'),(2112,7251,'Submarinos. Sistemas de gas para misiles'),(2113,72511,'Submarinos. Sistemas de gas para misiles'),(2114,7252,'Submarinos. Sistema de deshumidificacion y secado de misiles'),(2115,72521,'Submarinos. Sistema de deshumidificacion y secado de misiles'),(2116,726,'Compensacion de misiles'),(2117,7261,'Sistema de agua de compensacion de misiles'),(2118,72611,'Sistema de agua de compensacion de misiles'),(2119,727,'Sistemas de control de lanzamiento de misiles'),(2120,7271,'Sistemas de control de lanzamiento de misiles'),(2121,72711,'Sistemas de control de lanzamiento de misiles'),(2122,728,'Calefacción, refrigeración y control de temperatura de misiles'),(2123,7281,'Calefaccion, refrigeracion y control de temperatura de misiles'),(2124,72811,'Calefaccion, refrigeracion y control de temperatura de misiles'),(2125,729,'Supervisión, pruebas y alineación de misiles'),(2126,7291,'Submarinos. Control ambiental de misiles '),(2127,72911,'Submarinos. Control ambiental de misiles '),(2128,7292,'Submarinos. Equipo de pruebas y alistamiento de misiles'),(2129,72921,'Submarinos. Equipo de pruebas y alistamiento de misiles'),(2130,7293,'Instrumentacion de pruebas'),(2131,72931,'Instrumentacion de pruebas permanente'),(2132,72932,'Instrumentacion de pruebas temporal'),(2133,7294,'Submarinos. Alineacion optica y electrica de misiles'),(2134,72941,'Submarinos. Alineacion optica y electrica de misiles'),(2135,73,'Minas y sistemas contraminas'),(2136,731,'Minas. Dispositivos de lanzamiento'),(2137,7311,'Dispositivos de lanzamiento de minas'),(2138,73111,'Dispositivos de lanzamiento de minas'),(2139,732,'Minas. Manejo'),(2140,7321,'Manejo de minas'),(2141,73211,'Manejo de minas'),(2142,733,'Minas. Estiba'),(2143,7331,'Estiba de minas'),(2144,73311,'Estiba de minas'),(2145,735,'Sistemas de contraminado'),(2146,7351,'Rastras contraminas'),(2147,73511,'Rastras mecanicas'),(2148,73512,'Rastras magnéticas'),(2149,73513,'Rastras acústicas'),(2150,73514,'Rastras combinadas'),(2151,74,'Cargas de profundidad'),(2152,741,'Cargas de profundidad. Dispositivos de lanzamiento'),(2153,7411,'Dispositivos de lanzamiento de cargas de profundidad'),(2154,74111,'Dispositivos de lanzamiento de cargas de profundidad'),(2155,742,'Cargas de profundidad. Manejo'),(2156,7421,'Manejo de cargas de profundidad'),(2157,74211,'Manejo de cargas de profundidad'),(2158,743,'Cargas de profundidad. Estiba'),(2159,7431,'Estiba de cargas de profundidad'),(2160,74311,'Estiba de cargas de profundidad'),(2161,75,'Torpedos. Tubos, manejo, estiba y lanzamiento'),(2162,751,'Tubos lanzatorpedos'),(2163,7511,'Submarinos. Tubos lanzatorpedos'),(2164,75111,'Submarinos. Tubo lanzatorpedos nº1'),(2165,75112,'Submarinos. Tubo lanzatorpedos nº2'),(2166,75113,'Submarinos. Tubo lanzatorpedos nº3'),(2167,75114,'Submarinos. Tubo lanzatorpedos nº4'),(2168,75115,'Submarinos. Tubo lanzatorpedos nº5'),(2169,75116,'Submarinos. Tubo lanzatorpedos nº6'),(2170,75119,'Submarinos. Elementos comunes a varios TLT'),(2171,7512,'Tubos lanzatorpedos (Buques de superficie)'),(2172,75121,'Buques de superficie. Tubos lanzatorpedos'),(2173,752,'Manejo de torpedos'),(2174,7521,'Manejo de torpedos'),(2175,75211,'Manejo de torpedos. Material fijo'),(2176,75212,'Manejo de torpedos. Material móvil'),(2177,75213,'Manejo de torpedos. Accesorios'),(2178,753,'Estiba de torpedos'),(2179,7531,'Estiba de torpedos'),(2180,75311,'Estiba de torpedos'),(2181,754,'Submarinos. Eyección de torpedos'),(2182,7541,'Submarinos. Eyección de torpedos'),(2183,75411,'Submarinos. Eyección de torpedos'),(2184,755,'Apoyo, pruebas y alineacion de torpedos'),(2185,7551,'Torpedos. Material para su apoyo'),(2186,75511,'Torpedos. Material para su apoyo'),(2187,7552,'Torpedos. Material para pruebas'),(2188,75521,'Torpedos. Material para pruebas'),(2189,7553,'Submarinos. Alineacion de torpedos'),(2190,75531,'Submarinos. Alineacion de torpedos'),(2191,76,'Armas portátiles (Calibre inferior a 20 mm) y pirotecnia'),(2192,761,'Armas portátiles (Calibre inferior a 20 mm) y lanzadores de pirotecnia'),(2193,7611,'Armas portátiles (Calibre inferior a 20 mm) y lanzadores de pirotecnia'),(2194,76111,'Ametralladoras de 12,7 a 7,63mm'),(2195,76112,'Ametralladoras de 7,62mm a 5,57mm'),(2196,76113,'Ametralladoras de 5,56mm y calibres inferiores'),(2197,76114,'Fusiles de asalto'),(2198,76115,'Subfusiles ametralladores'),(2199,76116,'Pistolas y revolveres'),(2200,76117,'Escopetas de postas'),(2201,76118,'Fusiles especiales'),(2202,76119,'Lanzadores de pirotecnia'),(2203,7611,'Cañones de saludo'),(2204,7611,'Fusiles lanzacabos'),(2205,7611,'Armas portátiles. Pertrechos'),(2206,762,'Manejo de armas portátiles y pirotecnia'),(2207,7621,'Manejo de armas portátiles y pirotecnia'),(2208,763,'Estiba de armas portátiles y de pirotecnia'),(2209,7631,'Estiba de armas portátiles y pirotecnia'),(2210,76311,'Estiba de armas portátiles'),(2211,76312,'Material pirotécnico y su estiba'),(2212,764,'Equipos y material de Protección y su estiba'),(2213,7641,'Equipos y material de Protección y su estiba'),(2214,76411,'Material de los Equipos de Protección'),(2215,76412,'Material del Trozo de Desembarco'),(2216,76413,'Material del Trozo de Visita y Registro'),(2217,77,'Manejo y estiba de la munición de transporte'),(2218,772,'Municion de transporte. Manejo y estiba'),(2219,7721,'Municion de transporte. Manejo'),(2220,77211,'Municion de transporte. Manejo'),(2221,7722,'Municion de transporte. Estiba'),(2222,77221,'Municion de transporte. Estiba'),(2223,774,'Ascensores de municion'),(2224,7741,'Ascensores de municion'),(2225,77411,'Ascensores de municion'),(2226,78,'Armas de aeronaves'),(2227,782,'Armas de aeronaves. Manejo '),(2228,7821,'Armas de aeronaves. Equipos para su manejo'),(2229,78211,'Armas de aeronaves. Equipos para su manejo'),(2230,783,'Armas de aeronaves. Estibas'),(2231,7831,'Armas de aeronaves. Estibas'),(2232,78311,'Armas de aeronaves. Estibas'),(2233,784,'Armas de aeronaves. Ascensores'),(2234,7841,'Armas de aeronaves. Ascensores'),(2235,78411,'Armas de aeronaves. Ascensor Nº1'),(2236,78412,'Armas de aeronaves. Ascensor Nº2'),(2237,79,'Sistemas de armas especiales'),(2238,791,'Sistemas de armas especiales'),(2239,7911,'Sistema de contraminado con control remoto (ROV)'),(2240,79111,'Sistema de contraminado con control remoto (ROV) PLUTO PLUS'),(2241,79112,'Sistema de contraminado con control remoto (ROV) MINESNIPER'),(2242,792,'Manejo de armas especiales'),(2243,7921,'Ascensores de armas especiales'),(2244,79211,'Ascensores de armas especiales'),(2245,7922,'Equipos de manejo de armas especiales'),(2246,79221,'Equipos de manejo de armas especiales'),(2247,7923,'Submarinos. Control de armas'),(2248,79231,'Submarinos. Control de armas'),(2249,793,'Estiba de armas especiales'),(2250,7931,'Estiba de armas especiales'),(2251,79311,'Estiba de armas especiales'),(2252,794,'Vehiculos de Infanteria de Marina (Anfibios)'),(2253,7941,'Vehiculos de ruedas (Anfibios)'),(2254,79411,'Vehiculos de combate de infantería (VCI)'),(2255,79412,'Camiones (Anfibios)'),(2256,79414,'Vehiculos de alta movilidad táctica'),(2257,7942,'Vehiculos de cadenas (Anfibios)'),(2258,79422,'Vehiculos de cadenas (Anfibios)'),(2259,7943,'Vehiculos especiales (Anfibios)'),(2260,795,'Vehiculos de Infanteria de Marina (No anfibios)'),(2261,7951,'Vehiculos de ruedas (No Anfibios)'),(2262,79511,'Vehiculos de ruedas ligeros (No Anfibios) hasta 3 Ton'),(2263,79512,'Vehiculos de ruedas pesados (No Anfibios) mas de 3 Ton'),(2264,79513,'Camiones cisterna'),(2265,79514,'Camiones especiales'),(2266,79515,'Mulas mecanicas'),(2267,7952,'Vehiculos de cadenas (No Anfibios)'),(2268,79521,'Vehiculos de cadenas (No Anfibios)'),(2269,7953,'Remolques'),(2270,79531,'Remolques de carga general ligeros (hasta 750Kg)'),(2271,79532,'Remolques de carga general medios (de 750 a 1000Kg)'),(2272,79533,'Remolques de carga general pesados (más de 1000Kg)'),(2273,79534,'Remolques cisterna'),(2274,79535,'Remolques especiales'),(2275,7954,'Maquinaria de zapadores'),(2276,79541,'Maquinaria de zapadores'),(2277,7959,'Vehículos especiales'),(2278,79591,'Horquillas elevadoras'),(2279,79592,'Excavadoras y zanjadoras'),(2280,79593,'Cabezas tractoras y remolques gondola/batea'),(2281,79594,'Maquinas barredoras'),(2282,79595,'Motocicletas'),(2283,79596,'Ambulancias'),(2284,796,'Armas de Infanteria de Marina'),(2285,7961,'Cañones de Infanteria de Marina'),(2286,79611,'Cañones de Infanteria de Marina'),(2287,7962,'Obuses remolcados'),(2288,79621,'Obuses remolcados'),(2289,7963,'Obuses autopropulsados'),(2290,79631,'Obuses autopropulsados'),(2291,79632,'Vehiculos de municionamiento para obuses'),(2292,7964,'Carros de combate'),(2293,79644,'Carros de combate'),(2294,79645,'Carros de recuperacion'),(2295,7965,'Armas portatiles de Infanteria de Marina'),(2296,79651,'Morteros'),(2297,79652,'Lanzagranadas'),(2298,797,'Espacios diversos para estiba de armas'),(2299,7971,'Espacios diversos para estiba de armas'),(2300,79711,'Espacios diversos para estiba de armas'),(2301,798,'Fluidos para sistemas de armas'),(2302,799,'Repuestos y herramientas especiales de armas'),(2303,7991,'Repuestos especiales de armas'),(2304,79911,'Repuestos de armas'),(2305,7992,'Herramientas especiales para armas'),(2306,79921,'Herramientas especiales para armas'),(2307,233,'MAIN PROPULSION'),(2308,256,'CIRCULATING AND COOLING SEAWATER SYSTEM'),(2309,261,'MAIN PROPULSION FUEL TANKS'),(2310,264,'MAIN PROPULSION LUBE OIL SYSTEM'),(2311,301,'POWER DISTRIBUTION GENERAL ARRANGEMENT'),(2312,321,'AC ELECTRICAL'),(2313,320,'DC ELECTRICAL'),(2314,401,'COMMAND AND SURVEILLANCE GENERAL ARRANGEMENT'),(2315,583,'Shipping Cradle'),(2316,512,'HVAC SYSTEM'),(2317,513,'ER VENTILATION SYSTEM'),(2318,529,'BILGE SYSTEM PIPING'),(2319,533,'FRESH WATER SERVICE'),(2320,555,'ER FIRE SUPPRESSION'),(2321,593,'WASTE WATER SYSTEM'),(2322,583,'HOISTING AND TRANSPORTABILITY ARRANGEMENT'),(2323,600,'Antideslizante'),(2324,801,'General Arrangements Drawing'),(2325,801,'BOOKLET OF GENERAL PLANS'),(2326,995,'CUNA PARA CONSTRUCCION'),(2327,233,'MAIN PROPULSION'),(2328,256,'CIRCULATING AND COOLING SEAWATER SYSTEM'),(2329,261,'MAIN PROPULSION FUEL TANKS'),(2330,264,'MAIN PROPULSION LUBE OIL SYSTEM'),(2331,301,'POWER DISTRIBUTION GENERAL ARRANGEMENT'),(2332,321,'AC ELECTRICAL'),(2333,320,'DC ELECTRICAL'),(2334,401,'COMMAND AND SURVEILLANCE GENERAL ARRANGEMENT'),(2335,583,'Shipping Cradle'),(2336,512,'HVAC SYSTEM'),(2337,513,'ER VENTILATION SYSTEM'),(2338,529,'BILGE SYSTEM PIPING'),(2339,533,'FRESH WATER SERVICE'),(2340,555,'ER FIRE SUPPRESSION'),(2341,593,'WASTE WATER SYSTEM'),(2342,583,'HOISTING AND TRANSPORTABILITY ARRANGEMENT'),(2343,600,'Antideslizante'),(2344,801,'General Arrangements Drawing'),(2345,801,'BOOKLET OF GENERAL PLANS'),(2346,995,'CUNA PARA CONSTRUCCION'),(2347,0,'aaaaa'),(2348,233,'MAIN PROPULSION'),(2349,256,'CIRCULATING AND COOLING SEAWATER SYSTEM'),(2350,261,'MAIN PROPULSION FUEL TANKS'),(2351,264,'MAIN PROPULSION LUBE OIL SYSTEM'),(2352,301,'POWER DISTRIBUTION GENERAL ARRANGEMENT'),(2353,321,'AC ELECTRICAL'),(2354,320,'DC ELECTRICAL'),(2355,401,'COMMAND AND SURVEILLANCE GENERAL ARRANGEMENT'),(2356,583,'SHIPPING CRADLE'),(2357,301,'HVAC SYSTEM'),(2358,512,'ER VENTILATION SYSTEM'),(2359,531,'BILGE SYSTEM PIPING'),(2360,533,'FRESH WATER SERVICE'),(2361,571,'ER FIRE SUPPRESSION'),(2362,593,'WASTE WATER SYSTEM'),(2363,661,'HOISTING AND TRANSPORTABILITY ARRANGEMENT'),(2364,701,'ANTIDESLIZANTE'),(2365,801,'GENERAL ARRANGEMENTS DRAWING'),(2366,801,'BOOKLET OF GENERAL PLANS'),(2367,995,'CUNA PARA CONSTRUCCION'),(2368,233,'MAIN PROPULSION'),(2369,256,'CIRCULATING AND COOLING SEAWATER SYSTEM'),(2370,261,'MAIN PROPULSION FUEL TANKS'),(2371,264,'MAIN PROPULSION LUBE OIL SYSTEM'),(2372,301,'POWER DISTRIBUTION GENERAL ARRANGEMENT'),(2373,321,'AC ELECTRICAL'),(2374,320,'DC ELECTRICAL'),(2375,401,'COMMAND AND SURVEILLANCE GENERAL ARRANGEMENT'),(2376,583,'SHIPPING CRADLE'),(2377,301,'HVAC SYSTEM'),(2378,512,'ER VENTILATION SYSTEM'),(2379,531,'BILGE SYSTEM PIPING'),(2380,533,'FRESH WATER SERVICE'),(2381,571,'ER FIRE SUPPRESSION'),(2382,593,'WASTE WATER SYSTEM'),(2383,661,'HOISTING AND TRANSPORTABILITY ARRANGEMENT'),(2384,701,'ANTIDESLIZANTE'),(2385,801,'GENERAL ARRANGEMENTS DRAWING'),(2386,801,'BOOKLET OF GENERAL PLANS'),(2387,995,'CUNA PARA CONSTRUCCION');
/*!40000 ALTER TABLE `sistemas_equipos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tablas_fua`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tablas_fua` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `buque_id` bigint unsigned NOT NULL,
  `vida_diseño` int DEFAULT NULL,
  `horas_ano` int DEFAULT NULL,
  `horas_mant_año` int DEFAULT NULL,
  `horas_disp_año` int DEFAULT NULL,
  `max_mis_año` int DEFAULT NULL,
  `mis_plan_mant` int DEFAULT NULL,
  `dias_op_año` int DEFAULT NULL,
  `dias_mision` int DEFAULT NULL,
  `dias_nav_mision` int DEFAULT NULL,
  `horas_op_mision` int DEFAULT NULL,
  `horas_op_año` int DEFAULT NULL,
  `horas_nav_mision` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tablas_fua_buque_id_foreign` (`buque_id`),
  CONSTRAINT `tablas_fua_buque_id_foreign` FOREIGN KEY (`buque_id`) REFERENCES `buques` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tablas_fua`
--

LOCK TABLES `tablas_fua` WRITE;
/*!40000 ALTER TABLE `tablas_fua` DISABLE KEYS */;
INSERT INTO `tablas_fua` VALUES (2,71,20,8760,1176,7104,49,7,42,6,5,144,1000,120,'2024-11-27 01:35:18','2024-12-19 17:42:20'),(3,29,123,8760,123,8514,4,0,2,100,99,2400,45,2376,'2024-12-02 17:14:44','2024-12-04 17:13:26'),(4,104,125,8760,12,8736,3,0,51,104,103,2500,1231,2476,'2024-12-04 17:16:19','2024-12-04 17:16:19');
/*!40000 ALTER TABLE `tablas_fua` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint unsigned DEFAULT NULL,
  `profile_photo_path` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Sebastian Nieto Ramirez','snieto@cotecmar.com',NULL,'$2y$12$z9IDOcMtv3xuixVqBtt3wO8K0K2aAE.6pJlKzsOzcOb2E9NhmbJxu',NULL,NULL,NULL,'pRRkBQRh1IoJai6N9PzEeKztPRXQRL7o8ZoOoQwK8dmfqhmQVdaNs4qmovdd',NULL,'profile-photos/zu9FMBHmVTloLNrOrbzr9mJ5ebQN1ypN96eGHFHh.png','2024-05-08 20:43:48','2024-05-16 23:20:26'),(2,'Test User','test@example.com','2024-05-09 02:09:39','$2y$12$a5nL01uqoDrOBgLsY6OeYudFrjI0fnEyd/qAzHfynnbdZFubNit6e',NULL,NULL,NULL,'8nHIbuA5DR',NULL,NULL,'2024-05-09 02:09:39','2024-05-09 02:09:39'),(3,'Joan Martin Suarez Loaiza','jmsuarez@cotecmar.com',NULL,'$2y$12$QpYZTy8pBG08AWb7tWxYWueuQtzM4dj/jrXP7Puh1eRAYQIueeauy',NULL,NULL,NULL,NULL,NULL,NULL,'2024-05-16 20:26:36','2024-05-16 21:30:58'),(8,'Jhonattan de Jesus Llamas Reinoso','jllamas@cotecmar.com',NULL,'$2y$12$ZvqH.1aY46qDXax16wf3/.jV.MD.giDRr5E5Hk78q00YnWl9ayR2O',NULL,NULL,NULL,NULL,NULL,NULL,'2024-05-16 22:20:40','2024-05-16 22:20:40');
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

-- Dump completed on 2025-01-23 13:28:08
