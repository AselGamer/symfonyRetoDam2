-- MySQL dump 10.13  Distrib 8.0.35, for Linux (x86_64)
--
-- Host: localhost    Database: JuegAlmi
-- ------------------------------------------------------
-- Server version	8.0.35-0ubuntu0.22.04.1

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
-- Table structure for table `Alquiler`
--

DROP TABLE IF EXISTS `Alquiler`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Alquiler` (
  `idAlquiler` int NOT NULL AUTO_INCREMENT,
  `idTransaccion` int NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `fecha_devolucion` float DEFAULT NULL,
  `precio` float NOT NULL,
  PRIMARY KEY (`idAlquiler`),
  KEY `TransaccionAlquiler` (`idTransaccion`),
  CONSTRAINT `TransaccionAlquiler` FOREIGN KEY (`idTransaccion`) REFERENCES `Transaccion` (`idTransaccion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Alquiler`
--

LOCK TABLES `Alquiler` WRITE;
/*!40000 ALTER TABLE `Alquiler` DISABLE KEYS */;
/*!40000 ALTER TABLE `Alquiler` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Articulo`
--

DROP TABLE IF EXISTS `Articulo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Articulo` (
  `idArticulo` int NOT NULL AUTO_INCREMENT,
  `idMarca` int NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `precio` float DEFAULT NULL,
  `stock` int NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idArticulo`),
  KEY `MarcaArticulo` (`idMarca`),
  CONSTRAINT `MarcaArticulo` FOREIGN KEY (`idMarca`) REFERENCES `Marca` (`idMarca`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Articulo`
--

LOCK TABLES `Articulo` WRITE;
/*!40000 ALTER TABLE `Articulo` DISABLE KEYS */;
INSERT INTO `Articulo` VALUES (6,3,'Optimus Prime',1000000,1,'autobot1-6540e8e367ecb.png'),(8,1,'Playstation 5',500,200,'ps5-product-thumbnail-01-en-14sep21-6543657497f77.webp'),(9,4,'Nintendo Switch',300,200,'2560px-Nintendo-Switch-wJoyCons-BlRd-Standing-FL-1-654387dc9c9f2.png'),(26,1,'Playstation 4',200,300,'ps4-product-thumbnail-01-en-14sep21-1-6549fc06425bc.png'),(27,1,'Baldurs Gate 3',60,500,'baldurs-gay-6549fc46436e0.png');
/*!40000 ALTER TABLE `Articulo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `ArticuloTypeView`
--

DROP TABLE IF EXISTS `ArticuloTypeView`;
/*!50001 DROP VIEW IF EXISTS `ArticuloTypeView`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `ArticuloTypeView` AS SELECT 
 1 AS `idArticulo`,
 1 AS `ArticuloNombre`,
 1 AS `precio`,
 1 AS `stock`,
 1 AS `foto`,
 1 AS `idMarca`,
 1 AS `TipoArticulo`,
 1 AS `idTipoClase`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `Compra`
--

DROP TABLE IF EXISTS `Compra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Compra` (
  `idCompra` int NOT NULL AUTO_INCREMENT,
  `idTransaccion` int NOT NULL,
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`idCompra`),
  KEY `TransaccionCompra` (`idTransaccion`),
  CONSTRAINT `TransaccionCompra` FOREIGN KEY (`idTransaccion`) REFERENCES `Transaccion` (`idTransaccion`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Compra`
--

LOCK TABLES `Compra` WRITE;
/*!40000 ALTER TABLE `Compra` DISABLE KEYS */;
INSERT INTO `Compra` VALUES (1,1,'2023-11-13');
/*!40000 ALTER TABLE `Compra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Consola`
--

DROP TABLE IF EXISTS `Consola`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Consola` (
  `idConsola` int NOT NULL AUTO_INCREMENT,
  `idArticulo` int NOT NULL,
  `modelo` varchar(255) DEFAULT NULL,
  `cant_mandos` varchar(30) DEFAULT NULL,
  `almacenamiento` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idConsola`),
  KEY `ConsolaArticulo` (`idArticulo`),
  CONSTRAINT `ConsolaArticulo` FOREIGN KEY (`idArticulo`) REFERENCES `Articulo` (`idArticulo`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Consola`
--

LOCK TABLES `Consola` WRITE;
/*!40000 ALTER TABLE `Consola` DISABLE KEYS */;
INSERT INTO `Consola` VALUES (3,8,'Normal','1','200'),(4,9,'Normal','2','64'),(13,26,'Pro','2','200');
/*!40000 ALTER TABLE `Consola` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `DetalleTransaccion`
--

DROP TABLE IF EXISTS `DetalleTransaccion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `DetalleTransaccion` (
  `idDetalleTransaccion` int NOT NULL AUTO_INCREMENT,
  `idArticulo` int NOT NULL,
  `idTransaccion` int NOT NULL,
  `precio_total` float NOT NULL,
  PRIMARY KEY (`idDetalleTransaccion`),
  KEY `DetalleArticulo` (`idArticulo`),
  KEY `DetalleTransaccion` (`idTransaccion`),
  CONSTRAINT `DetalleArticulo` FOREIGN KEY (`idArticulo`) REFERENCES `Articulo` (`idArticulo`),
  CONSTRAINT `DetalleTransaccion` FOREIGN KEY (`idTransaccion`) REFERENCES `Transaccion` (`idTransaccion`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `DetalleTransaccion`
--

LOCK TABLES `DetalleTransaccion` WRITE;
/*!40000 ALTER TABLE `DetalleTransaccion` DISABLE KEYS */;
INSERT INTO `DetalleTransaccion` VALUES (1,8,1,500);
/*!40000 ALTER TABLE `DetalleTransaccion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `DispositivoMovil`
--

DROP TABLE IF EXISTS `DispositivoMovil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `DispositivoMovil` (
  `idDispositivoMovil` int NOT NULL AUTO_INCREMENT,
  `idArticulo` int NOT NULL,
  `almacenamiento` varchar(255) DEFAULT NULL,
  `ram` varchar(30) DEFAULT NULL,
  `tamano_pantalla` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`idDispositivoMovil`),
  KEY `DispositivoMovilArticulo` (`idArticulo`),
  CONSTRAINT `DispositivoMovilArticulo` FOREIGN KEY (`idArticulo`) REFERENCES `Articulo` (`idArticulo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `DispositivoMovil`
--

LOCK TABLES `DispositivoMovil` WRITE;
/*!40000 ALTER TABLE `DispositivoMovil` DISABLE KEYS */;
INSERT INTO `DispositivoMovil` VALUES (3,6,'5000','4000','50');
/*!40000 ALTER TABLE `DispositivoMovil` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Empleado`
--

DROP TABLE IF EXISTS `Empleado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Empleado` (
  `idEmpleado` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) NOT NULL,
  `apellido1` varchar(30) NOT NULL,
  `apellido2` varchar(30) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `gerente` tinyint(1) NOT NULL DEFAULT '0',
  `email` varchar(30) NOT NULL,
  `roles` json DEFAULT NULL,
  PRIMARY KEY (`idEmpleado`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Empleado`
--

LOCK TABLES `Empleado` WRITE;
/*!40000 ALTER TABLE `Empleado` DISABLE KEYS */;
INSERT INTO `Empleado` VALUES (4,'Asel','Asel','Asel','$2y$13$7uInFrJETXX0oMYLFKH1vO7mg3TYv81W0ECGailPRnHWSyx36izOC',1,'aselfernandez@gmail.com','[]');
/*!40000 ALTER TABLE `Empleado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `EstadoReparacion`
--

DROP TABLE IF EXISTS `EstadoReparacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `EstadoReparacion` (
  `idEstadoReparacion` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) NOT NULL,
  PRIMARY KEY (`idEstadoReparacion`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `EstadoReparacion`
--

LOCK TABLES `EstadoReparacion` WRITE;
/*!40000 ALTER TABLE `EstadoReparacion` DISABLE KEYS */;
INSERT INTO `EstadoReparacion` VALUES (1,'Enviado'),(2,'Activo'),(3,'Finalizado');
/*!40000 ALTER TABLE `EstadoReparacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Etiqueta`
--

DROP TABLE IF EXISTS `Etiqueta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Etiqueta` (
  `idEtiqueta` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idEtiqueta`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Etiqueta`
--

LOCK TABLES `Etiqueta` WRITE;
/*!40000 ALTER TABLE `Etiqueta` DISABLE KEYS */;
INSERT INTO `Etiqueta` VALUES (2,'RPG'),(3,'Aventura'),(4,'FPS');
/*!40000 ALTER TABLE `Etiqueta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `EtiquetaVideoJuego`
--

DROP TABLE IF EXISTS `EtiquetaVideoJuego`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `EtiquetaVideoJuego` (
  `idEtiquetaVideoJuego` int NOT NULL AUTO_INCREMENT,
  `idEtiqueta` int NOT NULL,
  `idVideojuego` int NOT NULL,
  PRIMARY KEY (`idEtiquetaVideoJuego`),
  KEY `EtiquetaVideoJuegoEtiqueta` (`idEtiqueta`),
  KEY `EtiquetaVideoJuegoVideoJuego` (`idVideojuego`),
  CONSTRAINT `EtiquetaVideoJuegoEtiqueta` FOREIGN KEY (`idEtiqueta`) REFERENCES `Etiqueta` (`idEtiqueta`),
  CONSTRAINT `EtiquetaVideoJuegoVideoJuego` FOREIGN KEY (`idVideojuego`) REFERENCES `VideoJuego` (`idVideojuego`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `EtiquetaVideoJuego`
--

LOCK TABLES `EtiquetaVideoJuego` WRITE;
/*!40000 ALTER TABLE `EtiquetaVideoJuego` DISABLE KEYS */;
INSERT INTO `EtiquetaVideoJuego` VALUES (30,2,10),(31,3,10);
/*!40000 ALTER TABLE `EtiquetaVideoJuego` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Marca`
--

DROP TABLE IF EXISTS `Marca`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Marca` (
  `idMarca` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`idMarca`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Marca`
--

LOCK TABLES `Marca` WRITE;
/*!40000 ALTER TABLE `Marca` DISABLE KEYS */;
INSERT INTO `Marca` VALUES (1,'Sony'),(2,'Phillips'),(3,'LG'),(4,'Nintendo');
/*!40000 ALTER TABLE `Marca` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Plataforma`
--

DROP TABLE IF EXISTS `Plataforma`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Plataforma` (
  `idPlataforma` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  PRIMARY KEY (`idPlataforma`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Plataforma`
--

LOCK TABLES `Plataforma` WRITE;
/*!40000 ALTER TABLE `Plataforma` DISABLE KEYS */;
INSERT INTO `Plataforma` VALUES (1,'PS4'),(2,'Nintendo Switch'),(3,'Xbox Series X'),(4,'PS5');
/*!40000 ALTER TABLE `Plataforma` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PlataformaConsola`
--

DROP TABLE IF EXISTS `PlataformaConsola`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `PlataformaConsola` (
  `idPlataformaConsola` int NOT NULL AUTO_INCREMENT,
  `idConsola` int NOT NULL,
  `idPlataforma` int NOT NULL,
  PRIMARY KEY (`idPlataformaConsola`),
  KEY `PlataformaConsola` (`idConsola`),
  KEY `ConsolaPlataforma` (`idPlataforma`),
  CONSTRAINT `ConsolaPlataforma` FOREIGN KEY (`idPlataforma`) REFERENCES `Plataforma` (`idPlataforma`),
  CONSTRAINT `PlataformaConsola` FOREIGN KEY (`idConsola`) REFERENCES `Consola` (`idConsola`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PlataformaConsola`
--

LOCK TABLES `PlataformaConsola` WRITE;
/*!40000 ALTER TABLE `PlataformaConsola` DISABLE KEYS */;
INSERT INTO `PlataformaConsola` VALUES (23,3,4),(24,3,1),(37,4,2),(41,13,1);
/*!40000 ALTER TABLE `PlataformaConsola` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Reparacion`
--

DROP TABLE IF EXISTS `Reparacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Reparacion` (
  `idReparacion` int NOT NULL AUTO_INCREMENT,
  `idUsuario` int NOT NULL,
  `idEmpleado` int DEFAULT NULL,
  `problema` varchar(255) NOT NULL,
  `comentario_reparacion` varchar(255) DEFAULT NULL,
  `idEstadoReparacion` int NOT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `precio` float DEFAULT NULL,
  PRIMARY KEY (`idReparacion`),
  KEY `ReparacionUsuario` (`idUsuario`),
  KEY `ReparacionEstadoReparacion` (`idEstadoReparacion`),
  KEY `idEmpleado` (`idEmpleado`),
  CONSTRAINT `Reparacion_ibfk_1` FOREIGN KEY (`idEmpleado`) REFERENCES `Empleado` (`idEmpleado`),
  CONSTRAINT `ReparacionEmpleado` FOREIGN KEY (`idEmpleado`) REFERENCES `Empleado` (`idEmpleado`),
  CONSTRAINT `ReparacionEstadoReparacion` FOREIGN KEY (`idEstadoReparacion`) REFERENCES `EstadoReparacion` (`idEstadoReparacion`),
  CONSTRAINT `ReparacionUsuario` FOREIGN KEY (`idUsuario`) REFERENCES `Usuario` (`idUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Reparacion`
--

LOCK TABLES `Reparacion` WRITE;
/*!40000 ALTER TABLE `Reparacion` DISABLE KEYS */;
INSERT INTO `Reparacion` VALUES (1,1,4,'Broken part','Replaced the damaged component',3,'2023-11-08','2023-11-10',150),(2,1,4,'Scratched disk','Reparacion Empezada',2,'2023-11-10',NULL,NULL);
/*!40000 ALTER TABLE `Reparacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Transaccion`
--

DROP TABLE IF EXISTS `Transaccion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Transaccion` (
  `idTransaccion` int NOT NULL AUTO_INCREMENT,
  `idUsuario` int NOT NULL,
  `latitud` varchar(30) DEFAULT NULL,
  `longitud` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`idTransaccion`),
  KEY `idUsuario` (`idUsuario`),
  CONSTRAINT `idUsuario` FOREIGN KEY (`idUsuario`) REFERENCES `Usuario` (`idUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Transaccion`
--

LOCK TABLES `Transaccion` WRITE;
/*!40000 ALTER TABLE `Transaccion` DISABLE KEYS */;
INSERT INTO `Transaccion` VALUES (1,1,'20','30');
/*!40000 ALTER TABLE `Transaccion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `TransaccionTypeView`
--

DROP TABLE IF EXISTS `TransaccionTypeView`;
/*!50001 DROP VIEW IF EXISTS `TransaccionTypeView`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `TransaccionTypeView` AS SELECT 
 1 AS `idTransaccion`,
 1 AS `idUsuario`,
 1 AS `latitud`,
 1 AS `longitud`,
 1 AS `TipoTransaccion`,
 1 AS `idTipoTransaccion`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `Usuario`
--

DROP TABLE IF EXISTS `Usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Usuario` (
  `idUsuario` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `nombre` varchar(30) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `apellido1` varchar(30) DEFAULT NULL,
  `apellido2` varchar(30) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `calle` varchar(30) DEFAULT NULL,
  `num_portal` varchar(30) DEFAULT NULL,
  `piso` varchar(30) DEFAULT NULL,
  `codigo_postal` varchar(255) DEFAULT NULL,
  `ciudad` varchar(30) DEFAULT NULL,
  `provincia` varchar(30) DEFAULT NULL,
  `pais` varchar(30) DEFAULT NULL,
  `roles` json DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Usuario`
--

LOCK TABLES `Usuario` WRITE;
/*!40000 ALTER TABLE `Usuario` DISABLE KEYS */;
INSERT INTO `Usuario` VALUES (1,'example@email.com','John','$2y$13$B2Br2DF8RwHQZ5Oi7T9Wb.phN/jz8qJG5/haTXHzveeYXxBCfwYxW','Doe','Smith','1234567890','123 Main Street',NULL,'2',NULL,'Example City','Example State','Example Country',NULL,NULL);
/*!40000 ALTER TABLE `Usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `VideoJuego`
--

DROP TABLE IF EXISTS `VideoJuego`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `VideoJuego` (
  `idVideojuego` int NOT NULL AUTO_INCREMENT,
  `idArticulo` int NOT NULL,
  `idPlataforma` int NOT NULL,
  PRIMARY KEY (`idVideojuego`),
  KEY `VideoJuegoArticulo` (`idArticulo`),
  KEY `VideoJuegoPlataforma` (`idPlataforma`),
  CONSTRAINT `VideoJuegoArticulo` FOREIGN KEY (`idArticulo`) REFERENCES `Articulo` (`idArticulo`),
  CONSTRAINT `VideoJuegoPlataforma` FOREIGN KEY (`idPlataforma`) REFERENCES `Plataforma` (`idPlataforma`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `VideoJuego`
--

LOCK TABLES `VideoJuego` WRITE;
/*!40000 ALTER TABLE `VideoJuego` DISABLE KEYS */;
INSERT INTO `VideoJuego` VALUES (10,27,4);
/*!40000 ALTER TABLE `VideoJuego` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Final view structure for view `ArticuloTypeView`
--

/*!50001 DROP VIEW IF EXISTS `ArticuloTypeView`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`almi`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `ArticuloTypeView` AS select `a`.`idArticulo` AS `idArticulo`,`a`.`nombre` AS `ArticuloNombre`,`a`.`precio` AS `precio`,`a`.`stock` AS `stock`,`a`.`foto` AS `foto`,`a`.`idMarca` AS `idMarca`,((case when (`c`.`idConsola` is not null) then 'Consola' when (`v`.`idVideojuego` is not null) then 'Videojuego' when (`d`.`idDispositivoMovil` is not null) then 'DispositivoMovil' else 'Unknown' end) collate utf8mb4_0900_ai_ci) AS `TipoArticulo`,(case when (`c`.`idConsola` is not null) then `c`.`idConsola` when (`v`.`idVideojuego` is not null) then `v`.`idVideojuego` when (`d`.`idDispositivoMovil` is not null) then `d`.`idDispositivoMovil` else NULL end) AS `idTipoClase` from (((`Articulo` `a` left join `Consola` `c` on((`a`.`idArticulo` = `c`.`idArticulo`))) left join `VideoJuego` `v` on((`a`.`idArticulo` = `v`.`idArticulo`))) left join `DispositivoMovil` `d` on((`a`.`idArticulo` = `d`.`idArticulo`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `TransaccionTypeView`
--

/*!50001 DROP VIEW IF EXISTS `TransaccionTypeView`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`almi`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `TransaccionTypeView` AS select `t`.`idTransaccion` AS `idTransaccion`,`t`.`idUsuario` AS `idUsuario`,`t`.`latitud` AS `latitud`,`t`.`longitud` AS `longitud`,((case when (`c`.`idCompra` is not null) then 'Compra' when (`a`.`idAlquiler` is not null) then 'Alquiler' else 'Unknown' end) collate utf8mb4_0900_ai_ci) AS `TipoTransaccion`,(case when (`c`.`idCompra` is not null) then `c`.`idCompra` when (`a`.`idAlquiler` is not null) then `a`.`idAlquiler` else NULL end) AS `idTipoTransaccion` from ((`Transaccion` `t` left join `Compra` `c` on((`t`.`idTransaccion` = `c`.`idTransaccion`))) left join `Alquiler` `a` on((`t`.`idTransaccion` = `a`.`idTransaccion`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-11-13 12:07:06
