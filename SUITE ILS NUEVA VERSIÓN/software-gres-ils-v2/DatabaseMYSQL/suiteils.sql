CREATE DATABASE  IF NOT EXISTS `suiteils` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `suiteils`;
-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: suiteils
-- ------------------------------------------------------
-- Server version	8.0.40

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
-- Table structure for table `buque_fua`
--

DROP TABLE IF EXISTS `buque_fua`;
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
  `disponible_misiones_1` int DEFAULT NULL,
  `disponibilidad_mantenimiento_1` int DEFAULT NULL,
  `disponible_misiones_3` int DEFAULT NULL,
  `disponibilidad_mantenimiento_3` int DEFAULT NULL,
  `disponible_misiones_5` int DEFAULT NULL,
  `puerto_extranjero` int DEFAULT NULL,
  `disponibilidad_mantenimiento_5` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `buque_fua_buque_id_foreign` (`buque_id`),
  CONSTRAINT `buque_fua_buque_id_foreign` FOREIGN KEY (`buque_id`) REFERENCES `buques` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buque_fua`
--

LOCK TABLES `buque_fua` WRITE;
/*!40000 ALTER TABLE `buque_fua` DISABLE KEYS */;
INSERT INTO `buque_fua` VALUES (1,11,500,23,NULL,2000,NULL,23,0,5260,2000,7714,23,NULL,123,NULL,NULL,'2025-06-06 14:00:12'),(3,23,180,180,100,3000,NULL,5000,4000,4380,3000,2380,5000,3460,50,4000,NULL,'2025-08-21 13:51:24');
/*!40000 ALTER TABLE `buque_fua` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `buque_misiones`
--

DROP TABLE IF EXISTS `buque_misiones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `buque_misiones` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `buque_id` bigint unsigned NOT NULL,
  `mision_id` bigint unsigned NOT NULL,
  `porcentaje` int DEFAULT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `velocidad` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `num_motores` int DEFAULT NULL,
  `potencia` int DEFAULT NULL,
  `rpm` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `buque_misiones_buque_id_foreign` (`buque_id`),
  KEY `buque_misiones_mision_id_foreign` (`mision_id`),
  CONSTRAINT `buque_misiones_buque_id_foreign` FOREIGN KEY (`buque_id`) REFERENCES `buques` (`id`) ON DELETE CASCADE,
  CONSTRAINT `buque_misiones_mision_id_foreign` FOREIGN KEY (`mision_id`) REFERENCES `misiones` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=369 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buque_misiones`
--

LOCK TABLES `buque_misiones` WRITE;
/*!40000 ALTER TABLE `buque_misiones` DISABLE KEYS */;
INSERT INTO `buque_misiones` VALUES (360,11,2,33,NULL,'2025-06-06 14:00:12','2025-06-06 14:00:12','11 - 15',11,11,2),(361,11,3,33,NULL,'2025-06-06 14:00:12','2025-06-06 14:00:12','11',11,11,2),(362,11,4,34,NULL,'2025-06-06 14:00:12','2025-06-06 14:00:12','11',11,11,2),(366,23,6,50,NULL,'2025-08-21 13:51:24','2025-08-21 13:51:24','>20 - <28',2,80,1200),(367,23,10,30,NULL,'2025-08-21 13:51:24','2025-08-21 13:51:24','>10 - <20',1,70,1200),(368,23,16,20,NULL,'2025-08-21 13:51:24','2025-08-21 13:51:24','>28 - <35',2,90,1200);
/*!40000 ALTER TABLE `buque_misiones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `buque_sistema`
--

DROP TABLE IF EXISTS `buque_sistema`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `buque_sistema` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `buque_id` bigint unsigned NOT NULL,
  `sistema_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `buque_sistema_buque_id_foreign` (`buque_id`),
  KEY `buque_sistema_sistema_id_foreign` (`sistema_id`),
  CONSTRAINT `buque_sistema_buque_id_foreign` FOREIGN KEY (`buque_id`) REFERENCES `buques` (`id`) ON DELETE CASCADE,
  CONSTRAINT `buque_sistema_sistema_id_foreign` FOREIGN KEY (`sistema_id`) REFERENCES `sistemas_suite` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buque_sistema`
--

LOCK TABLES `buque_sistema` WRITE;
/*!40000 ALTER TABLE `buque_sistema` DISABLE KEYS */;
INSERT INTO `buque_sistema` VALUES (10,11,8,NULL,NULL),(11,11,1356,NULL,NULL),(15,11,1343,NULL,NULL),(16,11,1344,NULL,NULL),(26,23,1280,NULL,NULL),(27,23,1356,NULL,NULL),(28,23,1363,NULL,NULL),(29,23,1364,NULL,NULL),(30,23,1365,NULL,NULL),(31,23,1367,NULL,NULL),(32,23,1386,NULL,NULL),(33,23,1388,NULL,NULL),(34,23,1389,NULL,NULL),(35,23,1393,NULL,NULL),(36,23,1395,NULL,NULL),(37,23,1396,NULL,NULL),(38,23,1410,NULL,NULL),(39,23,1411,NULL,NULL),(40,23,1412,NULL,NULL),(41,23,1413,NULL,NULL),(42,23,1416,NULL,NULL),(43,23,1423,NULL,NULL),(44,23,1477,NULL,NULL),(45,23,1486,NULL,NULL),(46,23,1487,NULL,NULL),(47,23,1488,NULL,NULL),(48,23,1493,NULL,NULL),(49,23,1499,NULL,NULL),(50,23,1502,NULL,NULL),(51,23,1504,NULL,NULL),(52,23,1516,NULL,NULL),(53,23,1520,NULL,NULL),(54,23,1526,NULL,NULL),(55,23,1569,NULL,NULL),(56,23,1651,NULL,NULL);
/*!40000 ALTER TABLE `buque_sistema` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `buques`
--

DROP TABLE IF EXISTS `buques`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `buques` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_casco_cotecmar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero_casco_armada` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `eslora` decimal(10,2) DEFAULT NULL,
  `manga` decimal(10,2) DEFAULT NULL,
  `puntal` decimal(10,2) DEFAULT NULL,
  `calado_metros` decimal(10,2) DEFAULT NULL,
  `altura_mastil` decimal(10,2) DEFAULT NULL,
  `altura_maxima_buque` decimal(10,2) DEFAULT NULL,
  `tipo_material_construccion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sigla_internacional_unidad` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plano_numero` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mision_organizacion` text COLLATE utf8mb4_unicode_ci,
  `operaciones_tipo` text COLLATE utf8mb4_unicode_ci,
  `estandares_calidad` text COLLATE utf8mb4_unicode_ci,
  `estandares_ambientales` text COLLATE utf8mb4_unicode_ci,
  `estandares_seguridad` text COLLATE utf8mb4_unicode_ci,
  `lugar_operaciones` text COLLATE utf8mb4_unicode_ci,
  `intensidad_operaciones` text COLLATE utf8mb4_unicode_ci,
  `redundancia` text COLLATE utf8mb4_unicode_ci,
  `tareas_operacion` text COLLATE utf8mb4_unicode_ci,
  `repuestos` text COLLATE utf8mb4_unicode_ci,
  `demanda_repuestos` text COLLATE utf8mb4_unicode_ci,
  `autonomia_horas` int DEFAULT NULL,
  `autonomia_millas_nauticas` decimal(10,2) DEFAULT NULL,
  `peso_buque` decimal(12,3) DEFAULT NULL,
  `unidad_peso` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tamano_dimension_buque` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desp_cond_1_peso_rosca` decimal(12,3) DEFAULT NULL,
  `desp_cond_2_10_consumibles` decimal(12,3) DEFAULT NULL,
  `desp_cond_3_minima_operacional` decimal(12,3) DEFAULT NULL,
  `desp_cond_4_50_consumibles` decimal(12,3) DEFAULT NULL,
  `desp_cond_5_optima_operacional` decimal(12,3) DEFAULT NULL,
  `desp_cond_6_zarpe_plena_carga` decimal(12,3) DEFAULT NULL,
  `vida_diseno_anios` int DEFAULT NULL,
  `horas_navegacion_anio` int DEFAULT NULL,
  `imagen` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `datos_sap` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `etapa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`id`),
  UNIQUE KEY `buques_nombre_unique` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buques`
--

LOCK TABLES `buques` WRITE;
/*!40000 ALTER TABLE `buques` DISABLE KEYS */;
INSERT INTO `buques` VALUES (11,'Bote Insular de Dimar','Control','12','24','Testing',10.00,10.00,10.00,10.00,10.00,10.00,'10','10','100','12','12','12','123','123','123','123','123','1231','123','123',144,NULL,NULL,NULL,NULL,10.000,10.000,10.000,10.000,10.000,10.000,21,1000,'public/buques/bCJlev23k3WiT86F7a72Pxdv7rTEPF9Ly2R4BSG9.jpg','{\"tecnico\": {\"MANGA\": \"10.00\", \"ESLORA\": \"10.00\", \"PUNTAL\": \"10.00\", \"Plano Numero\": \"100\", \"Altura Mastil\": \"10.00\", \"Peso del buque\": null, \"Unidad de peso\": null, \"Calado en Metros\": \"10.00\", \"Altura Maxima del Buque\": \"10.00\", \"Autonomia Millas Nauticas\": null, \"Desp Cond 1 Peso en Rosca\": \"10.000\", \"Sigla Internacional Unidad\": \"10\", \"Tamaño/Dimensión del buque\": null, \"Desp Cond 6 Zarpe Plena Carga\": \"10.000\", \"Tipo de Material Construccion\": \"10\", \"Desp Cond 2 10% de Consumibles\": \"10.000\", \"Desp Cond 3 Minima Operacional\": \"10.000\", \"Desp Cond 4 50% de Consumibles\": \"10.000\", \"Desp Cond 5 Optima Operacional\": \"10.000\"}, \"historico\": {\"Fuerza\": \"1\", \"Valor de Adquisición\": \"1\", \"Fecha Resolución Alta\": \"N/A\", \"Fecha Resolución Baja\": \"N/A\", \"Próxima Subida a Dique\": \"N/A\", \"Última Bajada de Dique\": \"N/A\", \"Última Subida de Dique\": \"PENDIENTE\", \"Fecha Resolución Traslado\": \"PENDIENTE\", \"Fecha Estimada de Reemplazo\": \"N/A\", \"Brigada / Flotilla / Comando\": \"1\", \"Ciclo de Vida Estimado (años)\": \"1\", \"Número de Resolución de Alta\": \"1\"}, \"logistico\": {\"Tipo de Grúa a bordo\": \"N/A\", \"Consumo kW·h (Muelle)\": \"1\", \"Capacidad de Agua (gal)\": \"PENDIENTE\", \"Cap. Víveres Secos (kg)\": \"N/A\", \"Capacidad de M.D.O (gal)\": \"N/A\", \"Capacidad de JET-A1 (gal)\": \"N/A\", \"Consumo kW·h (Navegando)\": \"N/A\", \"Capacidad Lubricante (gal)\": \"1\", \"Cap. Víveres Conserva (kg)\": \"1\", \"Capacidad de Gasolina (gal)\": \"1\", \"Capacidad de Kerosene (gal)\": \"PENDIENTE\", \"Cap. Grúa extendida 0% (ton)\": \"PENDIENTE\", \"Cap. Víveres Congelados (kg)\": \"PENDIENTE\", \"Capacidad Producción de Agua\": \"PENDIENTE\", \"Consumo Comb/h a Vel. Máxima\": \"N/A\", \"Cap. Grúa extendida 100% (ton)\": \"1\", \"Consumo Comb/h a Vel. Económica\": \"PENDIENTE\", \"Consumo Comb/milla a Vel. Máxima\": \"PENDIENTE\", \"Consumo Comb/milla a Vel. Económica\": \"1\"}}','2025-01-20 04:16:18','2025-08-17 23:54:32','Fase de Operación'),(12,'BICM','Test','2','1','Buque de investigación científica marina multifuncional, especializado principalmente en oceanografía',NULL,1.00,1.00,NULL,1.00,1.00,'1','1','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,123,3.00,1.000,'cm','1',1.000,1.000,1.000,1.000,1.000,1.000,123,123,'public/buques/RJGySG2n9KFL1E9qHBPjMbG3ym2EpvZ8V9sJcfOt.jpg','{\"tecnico\": {\"MANGA\": \"1.00\", \"ESLORA\": \"PENDIENTE\", \"PUNTAL\": \"1.00\", \"Plano Numero\": \"1\", \"Altura Mastil\": \"1.00\", \"Calado en Metros\": \"PENDIENTE\", \"Altura Maxima del Buque\": \"1.00\", \"Autonomia Millas Nauticas\": \"PENDIENTE\", \"Desp Cond 1 Peso en Rosca\": \"1.000\", \"Sigla Internacional Unidad\": \"1\", \"Desp Cond 6 Zarpe Plena Carga\": \"1.000\", \"Tipo de Material Construccion\": \"1\", \"Desp Cond 2 10% de Consumibles\": \"1.000\", \"Desp Cond 3 Minima Operacional\": \"1.000\", \"Desp Cond 4 50% de Consumibles\": \"1.000\", \"Desp Cond 5 Optima Operacional\": \"1.000\"}, \"historico\": {\"Fuerza\": \"1\", \"Valor de Adquisición\": \"PENDIENTE\", \"Fecha Resolución Alta\": \"N/A\", \"Fecha Resolución Baja\": \"PENDIENTE\", \"Próxima Subida a Dique\": \"N/A\", \"Última Bajada de Dique\": \"PENDIENTE\", \"Última Subida de Dique\": \"PENDIENTE\", \"Fecha Resolución Traslado\": \"PENDIENTE\", \"Fecha Estimada de Reemplazo\": \"N/A\", \"Brigada / Flotilla / Comando\": \"1\", \"Ciclo de Vida Estimado (años)\": \"1\", \"Número de Resolución de Alta\": \"PENDIENTE\"}, \"logistico\": {\"Tipo de Grúa a bordo\": \"PENDIENTE\", \"Consumo kW·h (Muelle)\": \"1\", \"Capacidad de Agua (gal)\": \"N/A\", \"Cap. Víveres Secos (kg)\": \"PENDIENTE\", \"Capacidad de M.D.O (gal)\": \"PENDIENTE\", \"Capacidad de JET-A1 (gal)\": \"PENDIENTE\", \"Consumo kW·h (Navegando)\": \"PENDIENTE\", \"Capacidad Lubricante (gal)\": \"1\", \"Cap. Víveres Conserva (kg)\": \"1\", \"Capacidad de Gasolina (gal)\": \"1\", \"Capacidad de Kerosene (gal)\": \"N/A\", \"Cap. Grúa extendida 0% (ton)\": \"N/A\", \"Cap. Víveres Congelados (kg)\": \"N/A\", \"Capacidad Producción de Agua\": \"N/A\", \"Consumo Comb/h a Vel. Máxima\": \"PENDIENTE\", \"Cap. Grúa extendida 100% (ton)\": \"1\", \"Consumo Comb/h a Vel. Económica\": \"N/A\", \"Consumo Comb/milla a Vel. Máxima\": \"N/A\", \"Consumo Comb/milla a Vel. Económica\": \"1\"}}','2025-01-20 04:30:14','2025-08-18 04:20:04','Fase de Operación'),(13,'Patrullera oceánica Colombiana','Investigación',NULL,NULL,'Misión General: Ejecutar operaciones navales en tiempo de paz o de guerra con el propósito de contribuir',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,123,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,123,123,'public/buques/ihogAurrA9boSVMNFZh1nYnOyPkj160nb9npytOt.jpg',NULL,'2025-01-20 04:41:52','2025-01-20 05:21:29','Fase de Operación'),(14,'Bote Arcangel II','Patrullero',NULL,NULL,'Llevar a cabo operaciones de interdicción marítima y asegurar la seguridad y control del tráfico en aaaa',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,123,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,123,123,'public/buques/01uX7yQSctD9d5rIJOZxNWmctSb4RiYrdzUQnSEN.jpg',NULL,'2025-01-20 04:43:11','2025-01-20 05:21:21','Fase de Operación'),(23,'Bote Arcangel III','Interdicción marítima','237','Pendiente','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam euismod nunc sit amet interdum finibus. Etiam convallis ex ac ex sodales, a feugiat mi iaculis. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Interdum et malesuada fames ac ante ipsum primis in faucibus. Suspendisse mattis purus tortor, id rhoncus eros ornare a. Nunc convallis dignissim lacus ac aliquam. Ut quis eleifend velit. Donec mi ligula, imperdiet at metus in, euismod dignissim libero. Nunc dui ipsum, interdum nec porttitor elementum, ornare ac neque.',NULL,NULL,NULL,NULL,NULL,NULL,'PENDIENTE','PENDIENTE','PENDIENTE',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,144,900.00,20.000,'TON','20340 X5000X5660',NULL,NULL,NULL,NULL,NULL,NULL,20,1200,'buques/i4AnpIyGiTsNIFwQDT7dlDzEE3dko6rlKN1JKkPm.jpg','{\"tecnico\": {\"MANGA\": \"PENDIENTE\", \"ESLORA\": \"PENDIENTE\", \"PUNTAL\": \"PENDIENTE\", \"Plano Numero\": \"PENDIENTE\", \"Altura Mastil\": \"PENDIENTE\", \"Calado en Metros\": \"PENDIENTE\", \"Altura Maxima del Buque\": \"PENDIENTE\", \"Autonomia Millas Nauticas\": \"PENDIENTE\", \"Desp Cond 1 Peso en Rosca\": \"PENDIENTE\", \"Sigla Internacional Unidad\": \"PENDIENTE\", \"Desp Cond 6 Zarpe Plena Carga\": \"PENDIENTE\", \"Tipo de Material Construccion\": \"PENDIENTE\", \"Desp Cond 2 10% de Consumibles\": \"PENDIENTE\", \"Desp Cond 3 Minima Operacional\": \"PENDIENTE\", \"Desp Cond 4 50% de Consumibles\": \"PENDIENTE\", \"Desp Cond 5 Optima Operacional\": \"PENDIENTE\"}, \"historico\": {\"Fuerza\": \"PENDIENTE\", \"Valor de Adquisición\": \"PENDIENTE\", \"Fecha Resolución Alta\": \"PENDIENTE\", \"Fecha Resolución Baja\": \"PENDIENTE\", \"Próxima Subida a Dique\": \"PENDIENTE\", \"Última Bajada de Dique\": \"PENDIENTE\", \"Última Subida de Dique\": \"PENDIENTE\", \"Fecha Resolución Traslado\": \"PENDIENTE\", \"Fecha Estimada de Reemplazo\": \"PENDIENTE\", \"Brigada / Flotilla / Comando\": \"PENDIENTE\", \"Ciclo de Vida Estimado (años)\": \"PENDIENTE\", \"Número de Resolución de Alta\": \"PENDIENTE\"}, \"logistico\": {\"Tipo de Grúa a bordo\": \"PENDIENTE\", \"Consumo kW·h (Muelle)\": \"PENDIENTE\", \"Capacidad de Agua (gal)\": \"PENDIENTE\", \"Cap. Víveres Secos (kg)\": \"PENDIENTE\", \"Capacidad de M.D.O (gal)\": \"PENDIENTE\", \"Capacidad de JET-A1 (gal)\": \"PENDIENTE\", \"Consumo kW·h (Navegando)\": \"PENDIENTE\", \"Capacidad Lubricante (gal)\": \"PENDIENTE\", \"Cap. Víveres Conserva (kg)\": \"PENDIENTE\", \"Capacidad de Gasolina (gal)\": \"PENDIENTE\", \"Capacidad de Kerosene (gal)\": \"PENDIENTE\", \"Cap. Grúa extendida 0% (ton)\": \"PENDIENTE\", \"Cap. Víveres Congelados (kg)\": \"PENDIENTE\", \"Capacidad Producción de Agua\": \"PENDIENTE\", \"Consumo Comb/h a Vel. Máxima\": \"PENDIENTE\", \"Cap. Grúa extendida 100% (ton)\": \"PENDIENTE\", \"Consumo Comb/h a Vel. Económica\": \"PENDIENTE\", \"Consumo Comb/milla a Vel. Máxima\": \"PENDIENTE\", \"Consumo Comb/milla a Vel. Económica\": \"PENDIENTE\"}, \"DATO_HISTOR_BUQUE\": [], \"DATO_LOGIST_BUQUE\": []}','2025-08-21 13:26:33','2025-08-22 04:00:21','Fase de Construcción');
/*!40000 ALTER TABLE `buques` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equipos_suite`
--

DROP TABLE IF EXISTS `equipos_suite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `equipos_suite` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_equipo_info` bigint unsigned DEFAULT NULL,
  `sistema_id` bigint unsigned NOT NULL,
  `codigo` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `equipos_suite_id_equipo_info_unique` (`id_equipo_info`),
  KEY `equipos_suite_sistema_id_foreign` (`sistema_id`),
  CONSTRAINT `equipos_suite_sistema_id_foreign` FOREIGN KEY (`sistema_id`) REFERENCES `sistemas_suite` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipos_suite`
--

LOCK TABLES `equipos_suite` WRITE;
/*!40000 ALTER TABLE `equipos_suite` DISABLE KEYS */;
INSERT INTO `equipos_suite` VALUES (46,166,1356,'23311','Motor propulsor ',NULL,'2025-05-13 18:32:22','2025-08-21 16:05:01'),(47,NULL,1502,'53151','Planta desalinizadora',NULL,'2025-08-21 16:05:01','2025-08-21 18:14:24');
/*!40000 ALTER TABLE `equipos_suite` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `gres_colab`
--

DROP TABLE IF EXISTS `gres_colab`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gres_colab` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `buque_id` bigint unsigned NOT NULL,
  `cargo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `entidad` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gres_colab_buque_id_foreign` (`buque_id`),
  CONSTRAINT `gres_colab_buque_id_foreign` FOREIGN KEY (`buque_id`) REFERENCES `buques` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gres_colab`
--

LOCK TABLES `gres_colab` WRITE;
/*!40000 ALTER TABLE `gres_colab` DISABLE KEYS */;
INSERT INTO `gres_colab` VALUES (14,11,'Investigador','Sebastián','Nieto Ramirez','Cotecmar','2025-01-27 18:31:52','2025-01-27 18:32:32'),(19,11,'A','A','A','A','2025-01-29 11:00:26','2025-01-29 11:00:26'),(20,11,'B','B','B','B','2025-01-29 11:00:31','2025-01-29 11:00:31'),(21,11,'C','C','C','C','2025-01-29 11:00:35','2025-01-29 11:00:35'),(22,11,'D','D','D','D','2025-01-29 11:00:39','2025-01-29 11:00:39'),(23,11,'E','E','E','E','2025-01-29 11:00:42','2025-01-29 11:00:42'),(24,11,'F','F','F','F','2025-01-29 11:00:45','2025-01-29 11:00:45'),(25,23,'Ingeniero de confiabilidad','Joan','Suarez','Cotecmar','2025-08-21 14:40:22','2025-08-21 14:40:22');
/*!40000 ALTER TABLE `gres_colab` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gres_equipo`
--

DROP TABLE IF EXISTS `gres_equipo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gres_equipo` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `buque_id` bigint unsigned NOT NULL,
  `sistema_id` bigint unsigned NOT NULL,
  `equipo_id` bigint unsigned NOT NULL,
  `mec` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diagrama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observaciones` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gres_equipo_buque_id_foreign` (`buque_id`),
  KEY `gres_equipo_sistema_id_foreign` (`sistema_id`),
  CONSTRAINT `gres_equipo_buque_id_foreign` FOREIGN KEY (`buque_id`) REFERENCES `buques` (`id`) ON DELETE CASCADE,
  CONSTRAINT `gres_equipo_sistema_id_foreign` FOREIGN KEY (`sistema_id`) REFERENCES `sistemas_suite` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gres_equipo`
--

LOCK TABLES `gres_equipo` WRITE;
/*!40000 ALTER TABLE `gres_equipo` DISABLE KEYS */;
INSERT INTO `gres_equipo` VALUES (12,11,8,45,'MEC 1','/images/diagramas/0.webp','[{\"texto\": \"Hola etc etc\", \"pregunta\": \"1\"}]','2025-05-13 18:32:39','2025-05-13 20:31:30'),(15,23,1356,614,'MEC 4','/images/diagramas/110.webp','[{\"texto\": \"aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa\", \"pregunta\": \"1\"}, {\"texto\": \"bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb\", \"pregunta\": \"2\"}]','2025-08-21 19:19:13','2025-08-25 12:35:47'),(16,23,1356,615,'MEC 1','/images/diagramas/0.webp','[]','2025-08-21 19:19:13','2025-08-22 21:18:44'),(17,23,1502,616,'MEC 2','/images/diagramas/10101.webp','[{\"texto\": \"pregunta 1 respuesta si\", \"pregunta\": \"1\"}, {\"texto\": \"pregunta 2 respuesta no\", \"pregunta\": \"2\"}, {\"texto\": \"pregunta 3 respuesta si\", \"pregunta\": \"4\"}, {\"texto\": \"pregunta 4 respuesta no\", \"pregunta\": \"5\"}, {\"texto\": \"pregunta 5 creo respuesta A\", \"pregunta\": \"7\"}]','2025-08-21 19:19:13','2025-08-22 18:46:24');
/*!40000 ALTER TABLE `gres_equipo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gres_equipos_colab`
--

DROP TABLE IF EXISTS `gres_equipos_colab`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gres_equipos_colab` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `buque_id` bigint unsigned NOT NULL,
  `cargo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `entidad` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gres_equipos_colab_buque_id_foreign` (`buque_id`),
  CONSTRAINT `gres_equipos_colab_buque_id_foreign` FOREIGN KEY (`buque_id`) REFERENCES `buques` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gres_equipos_colab`
--

LOCK TABLES `gres_equipos_colab` WRITE;
/*!40000 ALTER TABLE `gres_equipos_colab` DISABLE KEYS */;
INSERT INTO `gres_equipos_colab` VALUES (2,11,'Ing de sistemas','Brayan','Tovar','Cotecmar','2025-05-13 20:27:18','2025-05-13 20:27:18'),(3,23,'Ingeniero de procesos','Brayan','Tovar','Cotecmar','2025-08-22 19:30:11','2025-08-22 19:30:11');
/*!40000 ALTER TABLE `gres_equipos_colab` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gres_sistema`
--

DROP TABLE IF EXISTS `gres_sistema`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gres_sistema` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `buque_id` bigint unsigned NOT NULL,
  `sistema_id` bigint unsigned NOT NULL,
  `mec` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diagrama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observaciones` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gres_sistema_buque_id_foreign` (`buque_id`),
  KEY `gres_sistema_sistema_id_foreign` (`sistema_id`),
  CONSTRAINT `gres_sistema_buque_id_foreign` FOREIGN KEY (`buque_id`) REFERENCES `buques` (`id`) ON DELETE CASCADE,
  CONSTRAINT `gres_sistema_sistema_id_foreign` FOREIGN KEY (`sistema_id`) REFERENCES `sistemas_suite` (`id`) ON DELETE CASCADE,
  CONSTRAINT `gres_sistema_chk_1` CHECK (json_valid(`observaciones`))
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gres_sistema`
--

LOCK TABLES `gres_sistema` WRITE;
/*!40000 ALTER TABLE `gres_sistema` DISABLE KEYS */;
INSERT INTO `gres_sistema` VALUES (6,11,8,'1','/images/diagramas/0.webp','[]','2025-03-31 20:13:22','2025-03-31 20:13:22'),(7,11,8,'1','/images/diagramas/0.webp','[]','2025-03-31 20:13:22','2025-03-31 20:13:22'),(8,11,1356,'1','/images/diagramas/0.webp','[]','2025-04-28 15:53:55','2025-04-28 15:53:55'),(9,11,1356,'1','/images/diagramas/0.webp','[]','2025-04-28 15:53:55','2025-04-28 15:53:55'),(10,23,1356,'3','/images/diagramas/10100.webp','[{\"pregunta\":\"1\",\"texto\":\"texto de prueba\"},{\"pregunta\":\"2\",\"texto\":\"prueba texto 2 respuesta no\"},{\"pregunta\":\"4\",\"texto\":\"prueeba de texto 3 respuesta si\"},{\"pregunta\":\"5\",\"texto\":\"prueba de texto 4 respuesta no\"},{\"pregunta\":\"7\",\"texto\":\"prueba de texto 5 respuesta B\"}]','2025-08-21 14:35:18','2025-08-21 14:38:25'),(11,23,1356,'3','/images/diagramas/10100.webp','[]','2025-08-21 14:35:18','2025-08-21 14:35:18'),(12,23,1280,'1','/images/diagramas/0.webp','[]','2025-08-23 04:56:38','2025-08-25 12:26:15');
/*!40000 ALTER TABLE `gres_sistema` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupos_constructivos`
--

DROP TABLE IF EXISTS `grupos_constructivos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `grupos_constructivos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `grupos_constructivos_codigo_unique` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupos_constructivos`
--

LOCK TABLES `grupos_constructivos` WRITE;
/*!40000 ALTER TABLE `grupos_constructivos` DISABLE KEYS */;
INSERT INTO `grupos_constructivos` VALUES (1,'100','Cascos y Estructuras',NULL,NULL),(2,'200','Maquinaria y Propulsión',NULL,NULL),(3,'300','Planta Eléctrica',NULL,NULL),(4,'400','Comando y Vigilancia',NULL,NULL),(5,'500','Sistemas Auxiliares',NULL,NULL),(6,'600','Acabados y Amoblamiento',NULL,NULL),(7,'700','Armamento',NULL,NULL),(8,'800','Integración / Ingeniería',NULL,NULL);
/*!40000 ALTER TABLE `grupos_constructivos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_reset_tokens_table',1),(3,'2014_10_12_200000_add_two_factor_columns_to_users_table',1),(4,'2019_08_19_000000_create_failed_jobs_table',1),(5,'2019_12_14_000001_create_personal_access_tokens_table',1),(6,'2025_01_17_205438_create_sessions_table',1),(7,'2025_01_19_143129_create_permission_tables',2),(8,'2025_01_19_170955_create_grupos_constructivos_table',3),(9,'2025_01_19_171044_create_sistemas_suite_table',3),(10,'2025_01_19_180330_create_buques_table',4),(11,'2025_01_19_195241_create_misiones_table',5),(12,'2025_01_19_203429_create_buque_misiones_table',6),(13,'2025_01_19_235911_add_etapa_to_buques_table',7),(14,'2025_01_23_105938_create_buque_sistema_table',8),(15,'2025_01_24_145509_create_gres_sistema_table',9),(16,'2025_01_27_113346_create_gres_colab_table',10),(17,'2025_05_06_191837_add_id_equipo_info_to_equipos_suite_table',11),(18,'2025_05_29_195343_add_rpm_to_buque_mision_table',12),(19,'2025_05_29_201920_update_numero_casco_columns_in_buques_table',13),(20,'2025_05_29_211049_add_puerto_extranjero_to_buque_fua_table',14),(21,'2025_08_15_152936_add_specs_to_buques_table',15),(22,'2025_08_17_000001_add_datos_sap_and_weight_fields_to_buques_table',16);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `misiones`
--

DROP TABLE IF EXISTS `misiones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `misiones` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `misiones_nombre_unique` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `misiones`
--

LOCK TABLES `misiones` WRITE;
/*!40000 ALTER TABLE `misiones` DISABLE KEYS */;
INSERT INTO `misiones` VALUES (2,'Ayuda Humanitaria',NULL,'2025-01-20 01:07:55','2025-01-20 01:14:50'),(3,'Búsqueda y Rescate',NULL,'2025-01-20 01:08:11','2025-01-20 01:08:11'),(4,'Combate a la piratería',NULL,'2025-01-20 01:08:24','2025-01-20 01:08:24'),(5,'Combate contra el terrorismo',NULL,'2025-01-20 01:08:32','2025-01-20 01:08:32'),(6,'Interdicción Marítima',NULL,'2025-01-20 01:08:44','2025-01-20 01:08:44'),(7,'Operaciones de Desembarco',NULL,'2025-01-20 01:08:52','2025-01-20 01:08:52'),(8,'Operaciones de paz y ayuda humanitaria',NULL,'2025-01-20 01:09:02','2025-01-20 01:09:02'),(9,'Operaciones de soporte logístico',NULL,'2025-01-20 01:09:11','2025-01-20 01:09:11'),(10,'Seguridad y Control de tráfico marítimo',NULL,'2025-01-20 01:09:31','2025-01-20 01:09:31'),(11,'Soporte interdicción marítima',NULL,'2025-01-20 01:09:43','2025-01-20 01:09:43'),(12,'Soporte y colaboración a autoridades civiles en caso de disturbios y revueltas',NULL,'2025-01-20 01:09:59','2025-01-20 01:09:59'),(16,'Maxima velocidad',NULL,'2025-08-21 13:35:41','2025-08-21 13:35:41');
/*!40000 ALTER TABLE `misiones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',1),(1,'App\\Models\\User',2);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
INSERT INTO `password_reset_tokens` VALUES ('snieto@cotecmar.com','$2y$10$LE9HZHgLZAau8RaapplkEOJjYXQu65.UTlxxTrcuYSgbsX.jjU7yC','2025-01-19 19:23:46');
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
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

DROP TABLE IF EXISTS `role_has_permissions`;
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

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin','web','2025-01-19 19:32:31','2025-01-19 19:32:31'),(2,'user','web','2025-01-19 19:32:31','2025-01-19 19:32:31');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
INSERT INTO `sessions` VALUES ('0UbsjeGzFHAdxd7QXgAeqXdJUolnB86JYlrTBYca',NULL,'172.18.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVjE4eXdQQVpkaTBZNjhFZXhKbE1YQ2FFdkRkSDhiSnQxaEJNVXpVTCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyODoiaHR0cDovL2xvY2FsaG9zdDo4MDEwL2J1cXVlcyI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI4OiJodHRwOi8vbG9jYWxob3N0OjgwMTAvYnVxdWVzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1756296883),('98xzKMEyBCmfbkrFoN9KU44bmyT9ZXU0TSqFaa9N',1,'172.18.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36','YTo2OntzOjY6Il90b2tlbiI7czo0MDoiZ1BzZVFlZ1VWamdHRVJ2dXNtaDF2ZUpjTkFSVkZNOXE2WWxINUJUViI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMyOiJodHRwOi8vbG9jYWxob3N0OjgwMTAvMjMvbW9kdWxvcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoyMToicGFzc3dvcmRfaGFzaF9zYW5jdHVtIjtzOjYwOiIkMnkkMTAkc1I2QzNYN3dpUGxxR0xiUWUwVTB3ZUlnbTdTU1VhNWdUa1dyOEdqZUl4ekdXWE42LjNQQjYiO30=',1756297017);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sistemas_suite`
--

DROP TABLE IF EXISTS `sistemas_suite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sistemas_suite` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `grupo_constructivo_id` bigint unsigned NOT NULL,
  `codigo` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sistemas_suite_grupo_constructivo_id_foreign` (`grupo_constructivo_id`),
  CONSTRAINT `sistemas_suite_grupo_constructivo_id_foreign` FOREIGN KEY (`grupo_constructivo_id`) REFERENCES `grupos_constructivos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1702 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sistemas_suite`
--

LOCK TABLES `sistemas_suite` WRITE;
/*!40000 ALTER TABLE `sistemas_suite` DISABLE KEYS */;
INSERT INTO `sistemas_suite` VALUES (8,3,'311','Generación de energía para servicio del buque',NULL,'2025-01-28 00:42:21','2025-03-31 20:11:25'),(11,1,'126','Remolcador','aa','2025-02-14 20:51:05','2025-02-14 20:51:05'),(1275,1,'101','Planos estructurales y de disposición general',NULL,NULL,NULL),(1276,1,'111','Planchas del forro exterior en buques de superficie y casco resistente en submarinos',NULL,NULL,NULL),(1277,1,'112','Planchas del casco exterior de submarinos',NULL,NULL,NULL),(1278,1,'113','Doble fondo',NULL,NULL,NULL),(1279,1,'114','Apéndices del casco',NULL,NULL,NULL),(1280,1,'115','Puntales',NULL,NULL,NULL),(1281,1,'116','Estructura longitudinal en buques de superficie y casco resistente de submarinos',NULL,NULL,NULL),(1282,1,'117','Estructura transversal en buques de superficie y casco resistente de submarinos',NULL,NULL,NULL),(1283,1,'118','Estructura longitudinal y transversal del casco exterior de submarinos',NULL,NULL,NULL),(1284,1,'119','Faldillas flexibles y obturadores del sistema de sustentación',NULL,NULL,NULL),(1285,1,'121','Mamparos estructurales longitudinales',NULL,NULL,NULL),(1286,1,'122','Mamparos estructurales transversales',NULL,NULL,NULL),(1287,1,'123','Troncos y espacios cerrados',NULL,NULL,NULL),(1288,1,'124','Sistemas de protección contra torpedos en mamparos',NULL,NULL,NULL),(1289,1,'125','Tanques resistentes de submarinos',NULL,NULL,NULL),(1290,1,'126','Tanques no resistentes de submarinos',NULL,NULL,NULL),(1291,1,'131','Cubierta principal',NULL,NULL,NULL),(1292,1,'132','2ª Cubierta',NULL,NULL,NULL),(1293,1,'133','3ª Cubierta',NULL,NULL,NULL),(1294,1,'134','4ª Cubierta',NULL,NULL,NULL),(1295,1,'135','5ª Cubierta y cubiertas inferiores',NULL,NULL,NULL),(1296,1,'136','Cubierta 01 (castillo',NULL,NULL,NULL),(1297,1,'137','Cubierta 02',NULL,NULL,NULL),(1298,1,'138','Cubierta 03',NULL,NULL,NULL),(1299,1,'139','Cubierta 04',NULL,NULL,NULL),(1300,1,'140','Plataformas y pisos',NULL,NULL,NULL),(1301,1,'141','1ª Plataforma',NULL,NULL,NULL),(1302,1,'142','2ª Plataforma',NULL,NULL,NULL),(1303,1,'143','3ª Plataforma',NULL,NULL,NULL),(1304,1,'144','4ª Plataforma',NULL,NULL,NULL),(1305,1,'145','5ª Plataforma',NULL,NULL,NULL),(1306,1,'149','Pisos',NULL,NULL,NULL),(1307,1,'151','Superestructura hasta el primer nivel',NULL,NULL,NULL),(1308,1,'152','Superestructura del primer nivel',NULL,NULL,NULL),(1309,1,'153','Superestructura del segundo nivel',NULL,NULL,NULL),(1310,1,'154','Superestructura del tercer nivel',NULL,NULL,NULL),(1311,1,'155','Superestructura del cuarto nivel',NULL,NULL,NULL),(1312,1,'156','Superestructura del quinto nivel',NULL,NULL,NULL),(1313,1,'157','Superestructura del sexto nivel',NULL,NULL,NULL),(1314,1,'158','Superestructura del séptimo nivel',NULL,NULL,NULL),(1315,1,'159','Superestructura del octavo nivel y superiores',NULL,NULL,NULL),(1316,1,'161','Piezas estructurales fundidas o forjadas y conjuntos soldados equivalentes',NULL,NULL,NULL),(1317,1,'162','Chimeneas y palos-chimenea',NULL,NULL,NULL),(1318,1,'163','Tomas de mar',NULL,NULL,NULL),(1319,1,'164','Planchas blindadas',NULL,NULL,NULL),(1320,1,'165','Domos de sónar',NULL,NULL,NULL),(1321,1,'166','Alerones',NULL,NULL,NULL),(1322,1,'167','Cierres estructurales del casco',NULL,NULL,NULL),(1323,1,'168','Cierres estructurales de la superestructura',NULL,NULL,NULL),(1324,1,'169','Cierres y estructuras para fines especiales',NULL,NULL,NULL),(1325,1,'171','Palos',NULL,NULL,NULL),(1326,1,'172','Mástiles y estructuras de soporte',NULL,NULL,NULL),(1327,1,'179','Plataformas de servicio',NULL,NULL,NULL),(1328,1,'181','Polines estructurales del casco',NULL,NULL,NULL),(1329,1,'182','Polines de la planta propulsora',NULL,NULL,NULL),(1330,1,'183','Polines de la planta eléctrica',NULL,NULL,NULL),(1331,1,'184','Polines de equipos de mando y exploración',NULL,NULL,NULL),(1332,1,'185','Polines de sistemas auxiliares',NULL,NULL,NULL),(1333,1,'186','Polines de habitabilidad y equipo',NULL,NULL,NULL),(1334,1,'187','Polines de armas',NULL,NULL,NULL),(1335,1,'188','Montajes elásticos y sistemas antivibratorios',NULL,NULL,NULL),(1336,1,'191','Lastre permanente sólido o fluido y material para flotabilidad',NULL,NULL,NULL),(1337,1,'192','Pruebas de compartimentos',NULL,NULL,NULL),(1338,1,'195','Construcción de bloques (solamente adelanto)',NULL,NULL,NULL),(1339,1,'198','Líquidos de libre circulación',NULL,NULL,NULL),(1340,1,'199','Repuestos y herramientas especiales del casco',NULL,NULL,NULL),(1341,2,'211','Reservado',NULL,NULL,NULL),(1342,2,'212','Generadores nucleares de vapor',NULL,NULL,NULL),(1343,2,'213','Reactores',NULL,NULL,NULL),(1344,2,'214','Sistemas de refrigeración del reactor',NULL,NULL,NULL),(1345,2,'215','Sistema de servicio de refrigeración del reactor',NULL,NULL,NULL),(1346,2,'216','Sistemas auxiliares del reactor',NULL,NULL,NULL),(1347,2,'217','Instrumentación y control de la potencia nuclear',NULL,NULL,NULL),(1348,2,'218','Sistemas principales de blindaje',NULL,NULL,NULL),(1349,2,'219','Sistemas secundarios de blindaje',NULL,NULL,NULL),(1350,2,'221','Calderas de propulsión',NULL,NULL,NULL),(1351,2,'222','Generadores de gas',NULL,NULL,NULL),(1352,2,'223','Baterías para propulsión principal',NULL,NULL,NULL),(1353,2,'224','Pilas de combustible para propulsión principal',NULL,NULL,NULL),(1354,2,'231','Turbinas de vapor para propulsión',NULL,NULL,NULL),(1355,2,'232','Máquinas de vapor para la propulsión',NULL,NULL,NULL),(1356,2,'233','Motores propulsores de combustión interna',NULL,NULL,NULL),(1357,2,'234','Turbinas de gas para propulsión',NULL,NULL,NULL),(1358,2,'235','Propulsión eléctrica',NULL,NULL,NULL),(1359,2,'236','Sistemas de propulsión autónomos',NULL,NULL,NULL),(1360,2,'237','Dispositivos auxiliares de la propulsión',NULL,NULL,NULL),(1361,2,'238','Propulsión secundaria (submarinos)',NULL,NULL,NULL),(1362,2,'239','Propulsión de emergencia',NULL,NULL,NULL),(1363,2,'241','Engranajes reductores de la propulsión',NULL,NULL,NULL),(1364,2,'242','Acoplamientos y embragues de la propulsión',NULL,NULL,NULL),(1365,2,'243','Ejes de propulsión',NULL,NULL,NULL),(1366,2,'244','Cojinetes y chumaceras de los ejes de propulsión',NULL,NULL,NULL),(1367,2,'245','Propulsores',NULL,NULL,NULL),(1368,2,'246','Conductos y protectores en los propulsores',NULL,NULL,NULL),(1369,2,'247','Propulsión por chorro de agua',NULL,NULL,NULL),(1370,2,'248','Conductos y ventiladores del sistema de suspensión',NULL,NULL,NULL),(1371,2,'251','Sistemas de aire de combustión',NULL,NULL,NULL),(1372,2,'252','Sistemas de control de la propulsión',NULL,NULL,NULL),(1373,2,'253','Sistema de tuberías de vapor principal',NULL,NULL,NULL),(1374,2,'254','Condensadores y eyectores de aire',NULL,NULL,NULL),(1375,2,'255','Sistemas de alimentación y condensado',NULL,NULL,NULL),(1376,2,'256','Sistemas de circulación y refrigeración de agua salada',NULL,NULL,NULL),(1377,2,'257','Sistemas de alimentación de reserva y trasiego',NULL,NULL,NULL),(1378,2,'258','Sistema de purgas de vapor de alta presión',NULL,NULL,NULL),(1379,2,'259','Sistemas de exhaustación',NULL,NULL,NULL),(1380,2,'261','Sistemas de combustible',NULL,NULL,NULL),(1381,2,'262','Sistemas de lubricación de la propulsión principal',NULL,NULL,NULL),(1382,2,'263','Sistemas de lubricación de las líneas de ejes (submarinos)',NULL,NULL,NULL),(1383,2,'264','Sistema de relleno',NULL,NULL,NULL),(1384,2,'298','Fluidos de uso en la planta propulsora',NULL,NULL,NULL),(1385,2,'299','Repuestos y herramientas especiales de la planta propulsora',NULL,NULL,NULL),(1386,3,'311','Generación de energía eléctrica para servicio del buque',NULL,NULL,NULL),(1387,3,'312','Generadores de emergencia',NULL,NULL,NULL),(1388,3,'313','Baterías y medios auxiliares',NULL,NULL,NULL),(1389,3,'314','Sistemas de conversión de energía eléctrica',NULL,NULL,NULL),(1390,3,'321','Cableado de la red de fuerza',NULL,NULL,NULL),(1391,3,'322','Cableado de la red de emergencia',NULL,NULL,NULL),(1392,3,'323','Cableado de la red de accidentes',NULL,NULL,NULL),(1393,3,'324','Cuadros',NULL,NULL,NULL),(1394,3,'325','Sistemas detectores de falta de arco (AFD)',NULL,NULL,NULL),(1395,3,'331','Distribución de alumbrado',NULL,NULL,NULL),(1396,3,'332','Aparatos de alumbrado',NULL,NULL,NULL),(1397,3,'341','Aceite de lubricación de turbogeneradores',NULL,NULL,NULL),(1398,3,'342','Sistemas de apoyo a generadores Diesel',NULL,NULL,NULL),(1399,3,'343','Sistemas de apoyo a turbinas',NULL,NULL,NULL),(1400,3,'398','Fluidos de uso en la planta eléctrica',NULL,NULL,NULL),(1401,3,'399','Repuestos y herramientas especiales de la planta eléctrica',NULL,NULL,NULL),(1402,4,'4101','Pruebas internas del sistema de mando y control',NULL,NULL,NULL),(1403,4,'411','Grupo de presentación de información',NULL,NULL,NULL),(1404,4,'412','Grupo de proceso de información',NULL,NULL,NULL),(1405,4,'413','Cuadros de distribución de datos digitales (Suprimido - ver SGC 4141)',NULL,NULL,NULL),(1406,4,'414','Equipos de interconexión',NULL,NULL,NULL),(1407,4,'415','Comunicaciones de datos digitales',NULL,NULL,NULL),(1408,4,'417','Cuadros de distribución analógicos (Suprimido - ver SGC 4141)',NULL,NULL,NULL),(1409,4,'4201','Pruebas internas de los sistemas de navegación en general',NULL,NULL,NULL),(1410,4,'421','Ayudas a la navegación no-eléctricas/no electrónicas',NULL,NULL,NULL),(1411,4,'422','Ayudas eléctricas a la navegación (incluidas luces de navegación)',NULL,NULL,NULL),(1412,4,'423','Sistemas de navegación electrónicos',NULL,NULL,NULL),(1413,4,'424','Sistemas electroacústicos de navegación',NULL,NULL,NULL),(1414,4,'425','Periscopios',NULL,NULL,NULL),(1415,4,'426','Sistemas eléctricos de navegación (excepto giroscópicas)',NULL,NULL,NULL),(1416,4,'427','Sistemas de navegación inercial',NULL,NULL,NULL),(1417,4,'428','Supervisión del sistema de navegación',NULL,NULL,NULL),(1418,4,'431','Cuadros de distribución para sistemas de comunicaciones interiores',NULL,NULL,NULL),(1419,4,'432','Sistemas telefónicos',NULL,NULL,NULL),(1420,4,'433','Sistemas de órdenes generales',NULL,NULL,NULL),(1421,4,'434','Sistemas de adiestramiento y recreo',NULL,NULL,NULL),(1422,4,'435','Sistemas de tubos acústicos y neumáticos',NULL,NULL,NULL),(1423,4,'436','Sistemas de alarma',NULL,NULL,NULL),(1424,4,'437','Sistemas de indicación',NULL,NULL,NULL),(1425,4,'438','Sistemas de control integrados',NULL,NULL,NULL),(1426,4,'439','Sistemas de grabación y televisión',NULL,NULL,NULL),(1427,4,'4401','Pruebas de sistemas integrados de comunicaciones (Suprimido - ver sgc 8678)',NULL,NULL,NULL),(1428,4,'441','Sistemas radio',NULL,NULL,NULL),(1429,4,'442','Sistemas submarinos de comunicación',NULL,NULL,NULL),(1430,4,'443','Sistemas de comunicaciones visuales y fónicas',NULL,NULL,NULL),(1431,4,'444','Sistemas telemétricos',NULL,NULL,NULL),(1432,4,'445','Sistemas de facsímil y teletipo',NULL,NULL,NULL),(1433,4,'446','Sistemas de equipos de seguridad (I.F.F',NULL,NULL,NULL),(1434,4,'4501','Sistemas de distribución radar',NULL,NULL,NULL),(1435,4,'451','Sistemas radar de exploración de superficie',NULL,NULL,NULL),(1436,4,'452','Sistemas radar de exploración aérea (2C)',NULL,NULL,NULL),(1437,4,'453','Sistemas radar de exploración aérea (3C)',NULL,NULL,NULL),(1438,4,'454','Sistema radar de control de aproximación de aeronaves',NULL,NULL,NULL),(1439,4,'455','Sistemas de identificación (IFF)',NULL,NULL,NULL),(1440,4,'456','Sistemas radar multi-función',NULL,NULL,NULL),(1441,4,'457','Sistemas infrarrojos de vigilancia y seguimiento',NULL,NULL,NULL),(1442,4,'458','Sistemas de detección automática y seguimiento',NULL,NULL,NULL),(1443,4,'459','Seguimiento electrónico de vehículos espaciales',NULL,NULL,NULL),(1444,4,'461','Sónar activo de exploración',NULL,NULL,NULL),(1445,4,'462','Sónar pasivo de exploración',NULL,NULL,NULL),(1446,4,'463','Sónar multimodo de exploración',NULL,NULL,NULL),(1447,4,'464','Sistema de análisis acústico',NULL,NULL,NULL),(1448,4,'465','Sistemas de predicción de comportamiento sónar',NULL,NULL,NULL),(1449,4,'466','Sistemas de exploración multipropósito',NULL,NULL,NULL),(1450,4,'467','Sistema de control de ruidos',NULL,NULL,NULL),(1451,4,'468','Sistemas de combate en buques de superficie',NULL,NULL,NULL),(1452,4,'469','Sistemas de combate en submarinos',NULL,NULL,NULL),(1453,4,'4701','Pruebas internas del sistema de contramedidas electrónicas',NULL,NULL,NULL),(1454,4,'471','Guerra electrónica de contramedidas activas y activas/pasivas',NULL,NULL,NULL),(1455,4,'472','Contramedidas electrónicas pasivas',NULL,NULL,NULL),(1456,4,'473','Contramedidas submarinas',NULL,NULL,NULL),(1457,4,'474','Otros señuelos',NULL,NULL,NULL),(1458,4,'475','Sistemas de desmagnetización',NULL,NULL,NULL),(1459,4,'476','Sistemas de medidas contra minas',NULL,NULL,NULL),(1460,4,'4801','Pruebas del sistema interno de la dirección de tiro de artillería',NULL,NULL,NULL),(1461,4,'4802','Pruebas del sistema interno de la dirección de tiro de misiles',NULL,NULL,NULL),(1462,4,'4803','Pruebas del sistema interno de la dirección de lanzamiento de armas submarinas',NULL,NULL,NULL),(1463,4,'481','Sistemas de dirección de tiro de artillería',NULL,NULL,NULL),(1464,4,'482','Sistemas de dirección de tiro de misiles',NULL,NULL,NULL),(1465,4,'483','Sistemas de dirección de lanzamiento de armas submarinas',NULL,NULL,NULL),(1466,4,'484','Sistemas integrados de dirección de tiro',NULL,NULL,NULL),(1467,4,'489','Cuadros de distribución de sistemas de armas',NULL,NULL,NULL),(1468,4,'491','Equipos electrónicos de pruebas',NULL,NULL,NULL),(1469,4,'492','Sistemas de control de vuelo y toma instrumental',NULL,NULL,NULL),(1470,4,'493','Sistemas de proceso automático de datos (no de combate)',NULL,NULL,NULL),(1471,4,'494','Sistemas meteorológicos',NULL,NULL,NULL),(1472,4,'495','Sistemas de inteligencia para fines especiales',NULL,NULL,NULL),(1473,4,'496','Equipos auxiliares',NULL,NULL,NULL),(1474,5,'5001','Sistemas auxiliares',NULL,NULL,NULL),(1475,5,'501','Planos de disposición general de los sistemas auxiliares',NULL,NULL,NULL),(1476,5,'502','Maquinaria auxiliar',NULL,NULL,NULL),(1477,5,'503','Bombas',NULL,NULL,NULL),(1478,5,'504','Instrumentos y paneles de instrumentos',NULL,NULL,NULL),(1479,5,'505','Requisitos generales de las tuberías',NULL,NULL,NULL),(1480,5,'506','Reboses',NULL,NULL,NULL),(1481,5,'507','Designación y marcado de tuberías',NULL,NULL,NULL),(1482,5,'508','Aislamiento térmico de tuberías y maquinaria',NULL,NULL,NULL),(1483,5,'509','Aislamiento térmico del sistema de ventilación y conductos de aire',NULL,NULL,NULL),(1484,5,'5101','Control ambiental',NULL,NULL,NULL),(1485,5,'511','Sistemas de calefacción de compartimentos',NULL,NULL,NULL),(1486,5,'512','Sistemas de ventilación',NULL,NULL,NULL),(1487,5,'513','Sistemas de ventilación en los espacios de máquinas',NULL,NULL,NULL),(1488,5,'514','Sistemas de aire acondicionado',NULL,NULL,NULL),(1489,5,'515','Sistemas de regeneración de aire (submarinos)',NULL,NULL,NULL),(1490,5,'516','Sistemas de refrigeración',NULL,NULL,NULL),(1491,5,'517','Calderas auxiliares y otros generadores de calor',NULL,NULL,NULL),(1492,5,'5201','Válvulas de mar',NULL,NULL,NULL),(1493,5,'521','Sistemas de contraincendios y baldeo (agua salada)',NULL,NULL,NULL),(1494,5,'522','Sistemas de rociado',NULL,NULL,NULL),(1495,5,'523','Sistema de descontaminación',NULL,NULL,NULL),(1496,5,'524','Sistemas auxiliares de agua salada',NULL,NULL,NULL),(1497,5,'526','Imbornales y desagües de cubierta',NULL,NULL,NULL),(1498,5,'527','Otros sistemas alimentados por servicios de contraincendios',NULL,NULL,NULL),(1499,5,'528','Descargas sanitarias',NULL,NULL,NULL),(1500,5,'529','Sistemas de achique y lastrado',NULL,NULL,NULL),(1501,5,'5301','Sistemas de agua dulce',NULL,NULL,NULL),(1502,5,'531','Planta destiladora',NULL,NULL,NULL),(1503,5,'532','Sistemas de agua de refrigeración',NULL,NULL,NULL),(1504,5,'533','Sistemas de agua potable',NULL,NULL,NULL),(1505,5,'534','Sistema de vapor auxiliar y purgas dentro de cámara de máquinas',NULL,NULL,NULL),(1506,5,'535','Sistemas de vapor auxiliar y purgas fuera de la cámara de máquinas',NULL,NULL,NULL),(1507,5,'536','Sistema de refrigeración auxiliar con agua dulce',NULL,NULL,NULL),(1508,5,'541','Sistema de combustible y de compensación de combustible',NULL,NULL,NULL),(1509,5,'542','Sistemas de combustible de aviación y de uso general',NULL,NULL,NULL),(1510,5,'543','Sistema de aceites lubricantes de aviación y de uso general',NULL,NULL,NULL),(1511,5,'544','Sistema de cargas líquidas',NULL,NULL,NULL),(1512,5,'545','Sistemas de calefacción de tanques',NULL,NULL,NULL),(1513,5,'546','Sistemas de lubricación auxiliar',NULL,NULL,NULL),(1514,5,'549','Sistemas de almacenamiento y manejo de combustibles especiales',NULL,NULL,NULL),(1515,5,'5501','Sistemas de aire',NULL,NULL,NULL),(1516,5,'551','Sistemas de aire comprimido',NULL,NULL,NULL),(1517,5,'552','Gases comprimidos',NULL,NULL,NULL),(1518,5,'553','Sistemas de O2N2',NULL,NULL,NULL),(1519,5,'554','Sistemas de control de escora y soplado de tanques de lastrado',NULL,NULL,NULL),(1520,5,'555','Sistema de extinción de incendios',NULL,NULL,NULL),(1521,5,'556','Sistemas de fluidos hidráulicos',NULL,NULL,NULL),(1522,5,'557','Gases licuados de transporte',NULL,NULL,NULL),(1523,5,'558','Sistemas de tuberías especiales',NULL,NULL,NULL),(1524,5,'5601','Sistemas de control del buque',NULL,NULL,NULL),(1525,5,'561','Sistemas de gobierno y control de profundidad',NULL,NULL,NULL),(1526,5,'562','Timón',NULL,NULL,NULL),(1527,5,'563','Flotabilidad y estabilización de cota (submarinos)',NULL,NULL,NULL),(1528,5,'564','Sistema de trimado y vaciado (submarinos)',NULL,NULL,NULL),(1529,5,'565','Sistemas estabilizadores (buques de superficie)',NULL,NULL,NULL),(1530,5,'566','Timones de profundidad y aletas estabilizadoras (submarinos)',NULL,NULL,NULL),(1531,5,'567','Sistemas de sustentación de planos y arbotantes',NULL,NULL,NULL),(1532,5,'568','Sistemas de maniobra',NULL,NULL,NULL),(1533,5,'5701','Pruebas del sistema de aprovisionamiento en la mar',NULL,NULL,NULL),(1534,5,'571','Sistemas de aprovisionamiento en la mar',NULL,NULL,NULL),(1535,5,'572','Sistema de manipulación de equipos y efectos del buque',NULL,NULL,NULL),(1536,5,'573','Sistemas de manipulación de la carga',NULL,NULL,NULL),(1537,5,'574','Sistemas de aprovisionamiento vertical',NULL,NULL,NULL),(1538,5,'575','Sistema de estiba y manejo de vehículos',NULL,NULL,NULL),(1539,5,'5801','Sistemas mecánicos de maniobra',NULL,NULL,NULL),(1540,5,'581','Sistemas de maniobra y estiba de anclas',NULL,NULL,NULL),(1541,5,'582','Sistemas de amarre y remolque',NULL,NULL,NULL),(1542,5,'583','Botes y sistema de estiba y maniobra de botes',NULL,NULL,NULL),(1543,5,'584','Sistema de estiba y maniobra de embarcaciones de desembarco',NULL,NULL,NULL),(1544,5,'585','Mecanismos retráctiles y elevables',NULL,NULL,NULL),(1545,5,'586','Sistemas de apoyo de recuperación de aeronaves',NULL,NULL,NULL),(1546,5,'587','Sistemas de apoyo de lanzamiento de aeronaves',NULL,NULL,NULL),(1547,5,'588','Maniobra',NULL,NULL,NULL),(1548,5,'589','Sistemas mecánicos diversos',NULL,NULL,NULL),(1549,5,'5901','Sistemas para fines especiales',NULL,NULL,NULL),(1550,5,'591','Sistemas científicos y de ingeniería oceanográfica',NULL,NULL,NULL),(1551,5,'592','Sistemas de ayuda y protección a nadadores y buceadores',NULL,NULL,NULL),(1552,5,'593','Sistemas de control de la contaminación del medio ambiente',NULL,NULL,NULL),(1553,5,'594','Sistemas de rescate',NULL,NULL,NULL),(1554,5,'595','Sistemas de remolque',NULL,NULL,NULL),(1555,5,'596','Sistemas de maniobra para buzos y vehículos sumergibles',NULL,NULL,NULL),(1556,5,'597','Sistemas de ayuda al salvamento',NULL,NULL,NULL),(1557,5,'598','Fluidos de los sistemas auxiliares',NULL,NULL,NULL),(1558,5,'599','Repuestos y herramientas especiales de los sistemas auxiliares',NULL,NULL,NULL),(1559,6,'601','Disposición general. Planos de habitabilidad y equipo',NULL,NULL,NULL),(1560,6,'602','Señales y marcas del casco',NULL,NULL,NULL),(1561,6,'603','Marcas de calado',NULL,NULL,NULL),(1562,6,'604','Cerraduras',NULL,NULL,NULL),(1563,6,'605','Protección contra roedores e insectos',NULL,NULL,NULL),(1564,6,'698','Fluidos de uso en habitabilidad y equipo',NULL,NULL,NULL),(1565,6,'699','Repuestos y herramientas especiales de habitabilidad y equipo',NULL,NULL,NULL),(1566,6,'611','Accesorios del casco',NULL,NULL,NULL),(1567,6,'612','Candeleros',NULL,NULL,NULL),(1568,6,'613','Jarcia y lonas',NULL,NULL,NULL),(1569,6,'621','Mamparos no estructurales',NULL,NULL,NULL),(1570,6,'622','Falsos pisos y tecles',NULL,NULL,NULL),(1571,6,'623','Escalas',NULL,NULL,NULL),(1572,6,'624','Cierres no estructurales',NULL,NULL,NULL),(1573,6,'625','Portillos',NULL,NULL,NULL),(1574,6,'6301','Protección anticorrosión',NULL,NULL,NULL),(1575,6,'631','Pintura',NULL,NULL,NULL),(1576,6,'632','Revestimientos de zinc y metálicos',NULL,NULL,NULL),(1577,6,'633','Protección catódica',NULL,NULL,NULL),(1578,6,'634','Recubrimiento de cubiertas',NULL,NULL,NULL),(1579,6,'635','Aislamiento del casco',NULL,NULL,NULL),(1580,6,'636','Amortiguamiento del casco',NULL,NULL,NULL),(1581,6,'637','Revestimientos',NULL,NULL,NULL),(1582,6,'638','Locales refrigerados',NULL,NULL,NULL),(1583,6,'639','Recubrimientos antirradiación',NULL,NULL,NULL),(1584,6,'641','Alojamientos y cámara de Oficiales',NULL,NULL,NULL),(1585,6,'642','Alojamientos y comedores de Suboficiales',NULL,NULL,NULL),(1586,6,'643','Sollados y comedores de marinería',NULL,NULL,NULL),(1587,6,'644','Locales de aseo y aparatos sanitarios',NULL,NULL,NULL),(1588,6,'645','Locales de recreo',NULL,NULL,NULL),(1589,6,'651','Locales de preparación de comidas',NULL,NULL,NULL),(1590,6,'652','Enfermería',NULL,NULL,NULL),(1591,6,'653','Dentista',NULL,NULL,NULL),(1592,6,'654','Locales de uso general',NULL,NULL,NULL),(1593,6,'655','Lavandería',NULL,NULL,NULL),(1594,6,'656','Locales de eliminación de desperdicios',NULL,NULL,NULL),(1595,6,'661','Oficinas',NULL,NULL,NULL),(1596,6,'662','Mobiliario de centros de control de máquinas',NULL,NULL,NULL),(1597,6,'663','Mobiliario de centros de control electrónicos',NULL,NULL,NULL),(1598,6,'664','Trozos de seguridad interior',NULL,NULL,NULL),(1599,6,'665','Talleres',NULL,NULL,NULL),(1600,6,'671','Armarios y estibas especiales',NULL,NULL,NULL),(1601,6,'672','Pañoles y gambuzas',NULL,NULL,NULL),(1602,6,'673','Estiba de la carga',NULL,NULL,NULL),(1603,6,'681','Material de campaña',NULL,NULL,NULL),(1604,6,'682','Material de campaña colectivo',NULL,NULL,NULL),(1605,6,'691','Gestión de la pérdida de transmisión',NULL,NULL,NULL),(1606,7,'701','Disposición general de los sistemas de armas',NULL,NULL,NULL),(1607,7,'702','Instalaciones de armamento',NULL,NULL,NULL),(1608,7,'703','Manejo y estiba de armas. Generalidades',NULL,NULL,NULL),(1609,7,'798','Fluidos para sistemas de armas',NULL,NULL,NULL),(1610,7,'799','Repuestos y herramientas especiales de armas',NULL,NULL,NULL),(1611,7,'711','Cañones',NULL,NULL,NULL),(1612,7,'712','Manejo de la munición',NULL,NULL,NULL),(1613,7,'713','Estiba de la munición',NULL,NULL,NULL),(1614,7,'721','Dispositivos de lanzamiento (misiles y cohetes)',NULL,NULL,NULL),(1615,7,'722','Sistemas de manejo de misiles',NULL,NULL,NULL),(1616,7,'723','Estiba de misiles y cohetes',NULL,NULL,NULL),(1617,7,'724','Sistemas hidráulicos de misiles',NULL,NULL,NULL),(1618,7,'725','Sistemas de gas de misiles',NULL,NULL,NULL),(1619,7,'726','Compensación de misiles',NULL,NULL,NULL),(1620,7,'727','Sistemas de control de lanzamiento de misiles',NULL,NULL,NULL),(1621,7,'728','Calefacción',NULL,NULL,NULL),(1622,7,'729','Supervisión',NULL,NULL,NULL),(1623,7,'731','Dispositivos de lanzamiento de minas',NULL,NULL,NULL),(1624,7,'732','Manejo de minas',NULL,NULL,NULL),(1625,7,'733','Estiba de minas',NULL,NULL,NULL),(1626,7,'741','Dispositivos de lanzamiento de cargas de profundidad',NULL,NULL,NULL),(1627,7,'742','Manejo de cargas de profundidad',NULL,NULL,NULL),(1628,7,'743','Estiba de cargas de profundidad',NULL,NULL,NULL),(1629,7,'751','Tubos lanzatorpedos',NULL,NULL,NULL),(1630,7,'752','Manejo de torpedos',NULL,NULL,NULL),(1631,7,'753','Estiba de torpedos',NULL,NULL,NULL),(1632,7,'754','Eyección de torpedos de submarinos',NULL,NULL,NULL),(1633,7,'755','Apoyo',NULL,NULL,NULL),(1634,7,'761','Armas portátiles y dispositivos lanzadores de pirotecnia',NULL,NULL,NULL),(1635,7,'762','Manejo de armas portátiles y pirotecnia',NULL,NULL,NULL),(1636,7,'763','Estiba de armas portátiles y pirotecnia',NULL,NULL,NULL),(1637,7,'772','Manejo y estiba de la munición de transporte',NULL,NULL,NULL),(1638,7,'773','Estiba de la munición de transporte (general)',NULL,NULL,NULL),(1639,7,'782','Manejo de armas para aeronaves',NULL,NULL,NULL),(1640,7,'783','Estiba de armas para aeronaves',NULL,NULL,NULL),(1641,7,'784','Ascensores de armas para aeronaves',NULL,NULL,NULL),(1642,7,'785','Ascensores de armas para aeronaves',NULL,NULL,NULL),(1643,7,'786','Sistemas hidráulicos para armas de aeronaves',NULL,NULL,NULL),(1644,7,'791','Sistema de armas para usos especiales',NULL,NULL,NULL),(1645,7,'792','Manejo de armas especiales',NULL,NULL,NULL),(1646,7,'793','Estiba de armas especiales',NULL,NULL,NULL),(1647,7,'794','Vehículos de ruedas',NULL,NULL,NULL),(1648,7,'795','Vehículos de cadenas',NULL,NULL,NULL),(1649,7,'797','Espacios diversos para estiba de armas',NULL,NULL,NULL),(1650,8,'801','Planos de información del constructor',NULL,NULL,NULL),(1651,8,'802','Planos de contrato',NULL,NULL,NULL),(1652,8,'803','Planos estándar',NULL,NULL,NULL),(1653,8,'804','Planos tipo',NULL,NULL,NULL),(1654,8,'806','Planos de estudio',NULL,NULL,NULL),(1655,8,'807','Planos de control de la instalación',NULL,NULL,NULL),(1656,8,'808','Planos de control de interconexiones',NULL,NULL,NULL),(1657,8,'811','Gestión de la configuración (ELIMINADO - VER 8612 Y 8613)',NULL,NULL,NULL),(1658,8,'812','Control de la Configuración de buques',NULL,NULL,NULL),(1659,8,'813','Control de programación y producción',NULL,NULL,NULL),(1660,8,'814','Coste del ciclo de vida',NULL,NULL,NULL),(1661,8,'831','Planos de construcción',NULL,NULL,NULL),(1662,8,'832','Especificaciones (distintas de las de contrato)',NULL,NULL,NULL),(1663,8,'833','Cálculos de pesos',NULL,NULL,NULL),(1664,8,'834','Programas de ordenador',NULL,NULL,NULL),(1665,8,'835','Cálculos de ingeniería',NULL,NULL,NULL),(1666,8,'836','Modelos y maquetas',NULL,NULL,NULL),(1667,8,'837','Fotografías',NULL,NULL,NULL),(1668,8,'838','Coordinación diseño/ingeniería (SUPRIMIDO - VER 8612 Y 8613)',NULL,NULL,NULL),(1669,8,'839','Trazado en gálibos',NULL,NULL,NULL),(1670,8,'841','Criterios y procedimientos de pruebas e inspecciones',NULL,NULL,NULL),(1671,8,'842','Preparación de la agenda de pruebas',NULL,NULL,NULL),(1672,8,'843','Experimentación de estabilidad y trimado (SUPRIMIDO - VER 86861)',NULL,NULL,NULL),(1673,8,'844','Procedimientos y criterios de comprobación de los sistemas de combate',NULL,NULL,NULL),(1674,8,'845','Certificados estándar',NULL,NULL,NULL),(1675,8,'851','Mantenimiento',NULL,NULL,NULL),(1676,8,'852','Aparatos de medida y equipos de apoyo',NULL,NULL,NULL),(1677,8,'853','Repuestos y pertrechos (SUPRIMIDO - VER 8643)',NULL,NULL,NULL),(1678,8,'854','Transporte',NULL,NULL,NULL),(1679,8,'855','Planos y especificaciones de ingeniería',NULL,NULL,NULL),(1680,8,'856','Documentación técnica',NULL,NULL,NULL),(1681,8,'857','Instalaciones de apoyo (SUPRIMIDO - VER 8637)',NULL,NULL,NULL),(1682,8,'858','Personal y adiestramiento',NULL,NULL,NULL),(1683,8,'859','Equipos de adiestramiento',NULL,NULL,NULL),(1684,8,'860','Servicios de apoyo (título genérico)',NULL,NULL,NULL),(1685,8,'861','Apoyo a la ingeniería y diseño',NULL,NULL,NULL),(1686,8,'862','Planificación de predisponibilidad',NULL,NULL,NULL),(1687,8,'863','Preparación de los espacios de trabajo y manejo',NULL,NULL,NULL),(1688,8,'864','Servicios contractuales de apoyo a la producción (ANTES 980)',NULL,NULL,NULL),(1689,8,'865','Servicios de apoyo y producción (ANTES 980 y 993)',NULL,NULL,NULL),(1690,8,'866','Inspección y control de calidad (ANTES 841 y 986)',NULL,NULL,NULL),(1691,8,'867','Programa de pruebas a bordo (ANTES 841)',NULL,NULL,NULL),(1692,8,'868','Certificación y ensayos',NULL,NULL,NULL),(1693,8,'869','Reservado para uso futuro',NULL,NULL,NULL),(1694,8,'881','Fondos',NULL,NULL,NULL),(1695,8,'891','Seguridad',NULL,NULL,NULL),(1696,8,'892','Factores humanos',NULL,NULL,NULL),(1697,8,'893','Normalización',NULL,NULL,NULL),(1698,8,'894','Optimización',NULL,NULL,NULL),(1699,8,'895','Fiabilidad y mantenibilidad',NULL,NULL,NULL),(1700,8,'896','Gestión de la información',NULL,NULL,NULL),(1701,8,'897','Dirección del proyecto',NULL,NULL,NULL);
/*!40000 ALTER TABLE `sistemas_suite` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `role` enum('user','admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `nombres` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidos` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `id_tipo` enum('CC','CE','Pasaporte') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_num` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','Sebastian','Nieto Ramirez','snieto@cotecmar.com','$2y$10$sR6C3X7wiPlqGLbQe0U0weIgm7SSUa5gTkWr8GjeIxzGWXN6.3PB6',NULL,NULL,NULL,NULL,NULL,'sIOUAi6akGlgH5pQt5lLdJ28ngPB1TuuHCS1jCCwbrmhUmYVRO93lGW1fPhw','2025-01-18 02:04:19','2025-01-18 02:04:19'),(2,'user','Joan Martin','Suarez Loaiza','jmsuarez@cotecmar.com','$2y$10$44PO0lb1TL/pg94h.3z3QOuUf.daQdsJj.M0vIYe0Mx8OLfmZM9L2',NULL,NULL,NULL,NULL,NULL,NULL,'2025-01-19 21:05:54','2025-01-19 21:05:54');
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

-- Dump completed on 2025-08-27  7:50:55
