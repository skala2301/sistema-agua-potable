-- MySQL dump 10.13  Distrib 5.7.12, for osx10.9 (x86_64)
--
-- Host: localhost    Database: scada
-- ------------------------------------------------------
-- Server version	5.6.34

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ga_company`
--

DROP TABLE IF EXISTS `ga_company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ga_company` (
  `id_company` int(11) NOT NULL AUTO_INCREMENT,
  `id_users` int(11) NOT NULL DEFAULT '0',
  `id_company_type` int(11) NOT NULL DEFAULT '0',
  `id_country` varchar(50) NOT NULL DEFAULT '0',
  `id_operator` varchar(255) DEFAULT '0',
  `name` varchar(128) NOT NULL DEFAULT '0',
  `adress` varchar(255) NOT NULL DEFAULT '0',
  `adress2` varchar(255) NOT NULL DEFAULT '0',
  `company_activity` varchar(128) NOT NULL DEFAULT '0',
  `company_description` varchar(255) NOT NULL DEFAULT '0',
  `token` varchar(255) NOT NULL DEFAULT '0',
  `active` bit(1) NOT NULL DEFAULT b'0',
  `create_date` date NOT NULL DEFAULT '0000-00-00',
  `finally_date` date NOT NULL DEFAULT '0000-00-00',
  `finally_hour` time NOT NULL DEFAULT '00:00:00',
  PRIMARY KEY (`id_company`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabla de registro de una compañia \r\nCaracteristicas\r\n\r\nid_users          = se liga con la tabla de multiples usuarios para esta empresa ga_users_company\r\nid_company  = se liga con la tabla tipo de compañia ga_company_type  \r\nid_country    = se liga con la tabla ga_countrys\r\ncompany_activity = actividad de la compañia que hace de forma explicita (no confundir con descripcion)\r\ntoken = asignacion de token unico para la compañia\r\nactive = estado de la compañia \r\nfinally_date = fecha de dado de baja copañia\r\nfinally_time = hora de baja de la compañia\r\nid_operator = el id del operador que ha manipulado la compañia , si dio de baja , edito o elimino \r\n\r\n\r\n';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ga_company`
--

LOCK TABLES `ga_company` WRITE;
/*!40000 ALTER TABLE `ga_company` DISABLE KEYS */;
/*!40000 ALTER TABLE `ga_company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ga_company_type`
--

DROP TABLE IF EXISTS `ga_company_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ga_company_type` (
  `id_company_type` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `create_date` date NOT NULL,
  `id_operator` varchar(255) NOT NULL,
  PRIMARY KEY (`id_company_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COMMENT='que tipo de compañia es , publica privada , etc\r\n';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ga_company_type`
--

LOCK TABLES `ga_company_type` WRITE;
/*!40000 ALTER TABLE `ga_company_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `ga_company_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ga_company_users`
--

DROP TABLE IF EXISTS `ga_company_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ga_company_users` (
  `id_company_users` int(11) NOT NULL AUTO_INCREMENT,
  `id_company` int(11) NOT NULL DEFAULT '0',
  `id_user` int(11) NOT NULL DEFAULT '0',
  `id_operator` varchar(255) DEFAULT '0',
  `create_date` date NOT NULL DEFAULT '0000-00-00',
  `finally_date` date DEFAULT NULL,
  `active` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`id_company_users`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COMMENT='Tabla de usuarios que pueden acceder a la compañia';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ga_company_users`
--

LOCK TABLES `ga_company_users` WRITE;
/*!40000 ALTER TABLE `ga_company_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `ga_company_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ga_dump`
--

DROP TABLE IF EXISTS `ga_dump`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ga_dump` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(255) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `expired` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ga_dump`
--

LOCK TABLES `ga_dump` WRITE;
/*!40000 ALTER TABLE `ga_dump` DISABLE KEYS */;
INSERT INTO `ga_dump` VALUES (3,'63Qbuqh0t2EFsSvGnKaC',1,'2016-12-03 09:31:20');
/*!40000 ALTER TABLE `ga_dump` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ga_error_handle`
--

DROP TABLE IF EXISTS `ga_error_handle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ga_error_handle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `type` int(11) NOT NULL,
  `value` text,
  `assigned_id` int(11) DEFAULT '0',
  `ticket` varchar(100) NOT NULL,
  `start_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `resolve_date` datetime DEFAULT NULL,
  `located` varchar(255) DEFAULT NULL,
  `level` int(11) DEFAULT '4',
  `aproved` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=864 DEFAULT CHARSET=utf8mb4 COMMENT='Garrobo error system handle \r\n\r\npara la columna aproved : { "id" : "" , "status" : "0" , "description" : ""   }';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ga_error_handle`
--

LOCK TABLES `ga_error_handle` WRITE;
/*!40000 ALTER TABLE `ga_error_handle` DISABLE KEYS */;
INSERT INTO `ga_error_handle` VALUES (44,'Se encontro un error desconocido , se genero directamente de ga_request',-1,'{\"readyState\":0,\"responseText\":\"\",\"status\":0,\"statusText\":\"error\"}',0,'INC347821960','2017-01-17 21:56:21',NULL,'system | helper | library | interfaces | controller |',0,NULL),(45,'Se encontro un error desconocido , se genero directamente de ga_request',-1,'{\"readyState\":0,\"responseText\":\"\",\"status\":0,\"statusText\":\"error\"}',0,'INC157398640','2017-01-17 21:56:54',NULL,'system | helper | library | interfaces | controller |',0,NULL),(46,'Se encontro un error desconocido , se genero directamente de ga_request',-1,'{\"readyState\":0,\"responseText\":\"\",\"status\":0,\"statusText\":\"error\"}',0,'INC459162870','2017-01-17 21:57:35',NULL,'system | helper | library | interfaces | controller |',0,NULL),(47,'Se encontro un error desconocido , se genero directamente de ga_request',-1,'{\"readyState\":0,\"responseText\":\"\",\"status\":0,\"statusText\":\"error\"}',0,'INC349286710','2017-01-17 21:59:56',NULL,'system | helper | library | interfaces | controller |',0,NULL),(48,'Se encontro un error desconocido , se genero directamente de ga_request',-1,'{\"readyState\":0,\"responseText\":\"\",\"status\":0,\"statusText\":\"error\"}',0,'INC637218540','2017-01-17 22:02:11',NULL,'system | helper | library | interfaces | controller |',0,NULL),(49,'Se encontro un error desconocido , se genero directamente de ga_request',-1,'{\"readyState\":0,\"responseText\":\"\",\"status\":0,\"statusText\":\"error\"}',0,'INC587419230','2017-01-17 22:04:53',NULL,'system | helper | library | interfaces | controller |',0,NULL),(50,'Se encontro un error desconocido , se genero directamente de ga_request',-1,'{\"readyState\":0,\"responseText\":\"\",\"status\":0,\"statusText\":\"error\"}',0,'INC852197360','2017-01-17 22:07:06',NULL,'system | helper | library | interfaces | controller |',0,NULL),(51,'Se encontro un error desconocido , se genero directamente de ga_request',-1,'{\"readyState\":0,\"responseText\":\"\",\"status\":0,\"statusText\":\"error\"}',0,'INC634215870','2017-01-17 22:08:12',NULL,'system | helper | library | interfaces | controller |',0,NULL),(52,'Se encontro un error desconocido , se genero directamente de ga_request',-1,'{\"readyState\":0,\"responseText\":\"\",\"status\":0,\"statusText\":\"error\"}',0,'INC391825460','2017-01-17 22:10:25',NULL,'system | helper | library | interfaces | controller |',0,NULL),(53,'Se encontro un error desconocido , se genero directamente de ga_request',-1,'{\"readyState\":0,\"responseText\":\"\",\"status\":0,\"statusText\":\"error\"}',0,'INC862397150','2017-01-17 22:10:25',NULL,'system | helper | library | interfaces | controller |',0,NULL),(54,'Se encontro un error desconocido , se genero directamente de ga_request',-1,'{\"readyState\":0,\"responseText\":\"\",\"status\":0,\"statusText\":\"error\"}',0,'INC943261870','2017-01-17 22:10:25',NULL,'system | helper | library | interfaces | controller |',0,NULL),(55,'Se encontro un error desconocido , se genero directamente de ga_request',-1,'{\"readyState\":0,\"responseText\":\"\",\"status\":0,\"statusText\":\"error\"}',0,'INC276953840','2017-01-17 22:15:52',NULL,'system | helper | library | interfaces | controller |',0,NULL),(56,'Se encontro un error desconocido , se genero directamente de ga_request',-1,'{\"readyState\":0,\"responseText\":\"\",\"status\":0,\"statusText\":\"error\"}',0,'INC753492610','2017-01-17 22:38:59',NULL,'system | helper | library | interfaces | controller |',0,NULL),(57,'Se encontro un error desconocido , se genero directamente de ga_request',-1,'{\"readyState\":0,\"responseText\":\"\",\"status\":0,\"statusText\":\"error\"}',0,'INC598237610','2017-01-17 22:38:59',NULL,'system | helper | library | interfaces | controller |',0,NULL),(863,'Error, No se encuentra la variable de (app_setup)',2,'la configuracion app_setup no se encuentra disponibleServidor : localhost, Documento raiz : C:/wamp64/www, IP usuario : ::1',0,'INC182975630','2017-01-19 21:31:04',NULL,'Dashboard.php / __construct',0,NULL);
/*!40000 ALTER TABLE `ga_error_handle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ga_metadata`
--

DROP TABLE IF EXISTS `ga_metadata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ga_metadata` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(50) NOT NULL,
  `value` longtext,
  `id_user` int(10) unsigned DEFAULT '0',
  `id_rol` int(10) unsigned DEFAULT '0',
  `type` varchar(3) DEFAULT 'S',
  `label` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=161 DEFAULT CHARSET=latin1 COMMENT='metadata es una tabla en la cual sus valores no son estaticos , eso quiere decir que la tabla\r\nno es uso especifico asi que solo tiene unos pares de campos y la mayoria se trabajara\r\ncon variables o con cadenas cuyo patrones estan definidos aplica con JSON y XML';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ga_metadata`
--

LOCK TABLES `ga_metadata` WRITE;
/*!40000 ALTER TABLE `ga_metadata` DISABLE KEYS */;
INSERT INTO `ga_metadata` VALUES (123,'smtp_protocol','smtp',NULL,NULL,'S',NULL,'2017-01-17 22:35:04'),(124,'smtp_host','localhost',NULL,NULL,'S',NULL,'2017-01-17 22:35:04'),(125,'smtp_port','465',NULL,NULL,'S',NULL,'2017-01-17 22:35:04'),(126,'smtp_timeout','10',NULL,NULL,'S',NULL,'2017-01-17 22:35:04'),(127,'smtp_user','root',NULL,NULL,'S',NULL,'2017-01-17 22:35:04'),(128,'smtp_pass','',NULL,NULL,'S',NULL,'2017-01-17 22:35:04'),(129,'smtp_status','0',NULL,NULL,'S',NULL,'2017-01-17 22:35:04'),(130,'user_lang','es',1,0,'S',NULL,'2017-01-17 22:35:04'),(149,'log_file','[{\"id\":\"bbff6ffefabb522e3be225da17ca4d9b\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Sun, 06 Nov 16 22:31:40 -0600\",\"date\":\"Sun, 06 Nov 2016 22:31:40 -0600\"},{\"id\":\"15ed2332fb79e90e7c21991ea03d061c\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Sun, 06 Nov 16 22:31:41 -0600\",\"date\":\"Sun, 06 Nov 2016 22:31:41 -0600\"},{\"id\":\"d3856399086cce37b05935fc6bbd57aa\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Sun, 06 Nov 16 22:31:42 -0600\",\"date\":\"Sun, 06 Nov 2016 22:31:42 -0600\"},{\"id\":\"89883d84c4c026685bdd401ae424cfde\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Mon, 07 Nov 16 20:21:57 -0600\",\"date\":\"Mon, 07 Nov 2016 20:21:57 -0600\"},{\"id\":\"714fa28725859dc409f3e7dea155a6c4\",\"data\":\"[End Session][SYSTEM] Rolando Antonio has cerrado sesion la fecha de Mon, 07 Nov 16 21:26:38 -0600\",\"date\":\"Mon, 07 Nov 2016 21:26:38 -0600\"},{\"id\":\"a01c3cceee6f3e450797baf108df911c\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Mon, 07 Nov 16 21:26:43 -0600\",\"date\":\"Mon, 07 Nov 2016 21:26:43 -0600\"},{\"id\":\"5bc23d60609c9c9f283af0cd8cdafa3d\",\"data\":\"[End Session][SYSTEM] Rolando Antonio has cerrado sesion la fecha de Mon, 07 Nov 16 21:37:16 -0600\",\"date\":\"Mon, 07 Nov 2016 21:37:16 -0600\"},{\"id\":\"952586ffd268fd649307477edcc6c7e4\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Mon, 07 Nov 16 21:57:58 -0600\",\"date\":\"Mon, 07 Nov 2016 21:57:58 -0600\"},{\"id\":\"4de7f020d36d7b9dabd3880a6b52e877\",\"data\":\"[End Session][SYSTEM] Rolando Antonio has cerrado sesion la fecha de Mon, 07 Nov 16 21:59:02 -0600\",\"date\":\"Mon, 07 Nov 2016 21:59:02 -0600\"},{\"id\":\"c6edd06fe6f7d12cf765ab278ac9b98c\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Tue, 08 Nov 16 20:52:10 -0600\",\"date\":\"Tue, 08 Nov 2016 20:52:10 -0600\"},{\"id\":\"7cec564afb281321de604aed1110de25\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Thu, 17 Nov 16 20:00:20 -0600\",\"date\":\"Thu, 17 Nov 2016 20:00:20 -0600\"},{\"id\":\"8222ebb602824852d9e41f6ec6f0369e\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Fri, 18 Nov 16 18:48:28 -0600\",\"date\":\"Fri, 18 Nov 2016 18:48:28 -0600\"},{\"id\":\"908a49dcd24b6a722ce4a7eb6422ada9\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Sat, 19 Nov 16 16:35:58 -0600\",\"date\":\"Sat, 19 Nov 2016 16:35:58 -0600\"},{\"id\":\"7d5bbe68239f59c1fd7c2dd517113f7a\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Sat, 19 Nov 16 17:14:43 -0600\",\"date\":\"Sat, 19 Nov 2016 17:14:43 -0600\"},{\"id\":\"bbd0db5bfdadccb6e76d25d566ea321a\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Sun, 20 Nov 16 10:38:03 -0600\",\"date\":\"Sun, 20 Nov 2016 10:38:03 -0600\"},{\"id\":\"1f0876e508410cd33c94e9a5ff478d49\",\"data\":\"[End Session][SYSTEM] Rolando Antonio has cerrado sesion la fecha de Sun, 20 Nov 16 15:10:53 -0600\",\"date\":\"Sun, 20 Nov 2016 15:10:53 -0600\"},{\"id\":\"7c27cbf03bad686928a27f9697f7811a\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Sun, 20 Nov 16 15:11:05 -0600\",\"date\":\"Sun, 20 Nov 2016 15:11:05 -0600\"},{\"id\":\"4a4e352ebe89ba97f6501fce0c3bb0a0\",\"data\":\"[End Session][SYSTEM] Rolando Antonio has cerrado sesion la fecha de Sun, 20 Nov 16 15:11:38 -0600\",\"date\":\"Sun, 20 Nov 2016 15:11:38 -0600\"},{\"id\":\"4ff7d9ced1cecec816a1cb701df50731\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Sun, 20 Nov 16 15:11:41 -0600\",\"date\":\"Sun, 20 Nov 2016 15:11:41 -0600\"},{\"id\":\"845ebba1b6491bd0e910d913e403dec1\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Sun, 20 Nov 16 15:14:36 -0600\",\"date\":\"Sun, 20 Nov 2016 15:14:36 -0600\"},{\"id\":\"33f72df1a4091858e89d00702386adde\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Sun, 20 Nov 16 15:14:36 -0600\",\"date\":\"Sun, 20 Nov 2016 15:14:36 -0600\"},{\"id\":\"7d40e92b806a53da290c6a0a1ebeed69\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Wed, 23 Nov 16 18:53:06 -0600\",\"date\":\"Wed, 23 Nov 2016 18:53:06 -0600\"},{\"id\":\"14c8fc49c881024bf9c9a9b0c634aeab\",\"data\":\"[End Session][SYSTEM] Rolando Antonio has cerrado sesion la fecha de Wed, 23 Nov 16 18:55:09 -0600\",\"date\":\"Wed, 23 Nov 2016 18:55:09 -0600\"},{\"id\":\"23a110416f030a6b98334b0b351983e6\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Wed, 23 Nov 16 18:56:12 -0600\",\"date\":\"Wed, 23 Nov 2016 18:56:12 -0600\"},{\"id\":\"d3e6d888efa795717d0b60d0039f541c\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Wed, 23 Nov 16 18:59:08 -0600\",\"date\":\"Wed, 23 Nov 2016 18:59:08 -0600\"},{\"id\":\"cdbb5cac12b69fe043d988216b21b405\",\"data\":\"[End Session][SYSTEM] Rolando Antonio has cerrado sesion la fecha de Wed, 23 Nov 16 19:07:00 -0600\",\"date\":\"Wed, 23 Nov 2016 19:07:00 -0600\"},{\"id\":\"c5ce63923413e76ec0617583aa7633f8\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Wed, 23 Nov 16 19:07:15 -0600\",\"date\":\"Wed, 23 Nov 2016 19:07:15 -0600\"},{\"id\":\"3c4aa08bf9726e0c1d2b1d9ee22d298f\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Wed, 23 Nov 16 19:43:35 -0600\",\"date\":\"Wed, 23 Nov 2016 19:43:35 -0600\"},{\"id\":\"afaf2788be58737abecd9d19f31d027d\",\"data\":\"[End Session][SYSTEM] Rolando Antonio has cerrado sesion la fecha de Wed, 23 Nov 16 19:43:43 -0600\",\"date\":\"Wed, 23 Nov 2016 19:43:43 -0600\"},{\"id\":\"f8972a723cd4f09a9958eeabf3ec9495\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Wed, 23 Nov 16 19:45:27 -0600\",\"date\":\"Wed, 23 Nov 2016 19:45:27 -0600\"},{\"id\":\"8e41fbf5be0b602d3616703d0a68a03e\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Wed, 23 Nov 16 21:55:02 -0600\",\"date\":\"Wed, 23 Nov 2016 21:55:02 -0600\"},{\"id\":\"05fb09bc4c512b69a6f1ce2a679b99da\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Thu, 24 Nov 16 18:27:31 -0600\",\"date\":\"Thu, 24 Nov 2016 18:27:31 -0600\"},{\"id\":\"ce24e44782d46e4c1e21a57e36fd4046\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Fri, 25 Nov 16 17:46:48 -0600\",\"date\":\"Fri, 25 Nov 2016 17:46:48 -0600\"},{\"id\":\"34ac5704624f9f16be836da843c5c7b7\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Sat, 26 Nov 16 09:37:06 -0600\",\"date\":\"Sat, 26 Nov 2016 09:37:06 -0600\"},{\"id\":\"c2dac8a732f72fa84fad8368d5cfc37d\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Sun, 27 Nov 16 10:25:37 -0600\",\"date\":\"Sun, 27 Nov 2016 10:25:37 -0600\"},{\"id\":\"45a5de404eb09aff2988a4cc07cfcf1c\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Mon, 28 Nov 16 23:10:03 -0600\",\"date\":\"Mon, 28 Nov 2016 23:10:03 -0600\"},{\"id\":\"1f8bd9b247bc71fb3bc794cd3a291106\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Thu, 01 Dec 16 20:53:47 -0600\",\"date\":\"Thu, 01 Dec 2016 20:53:47 -0600\"},{\"id\":\"55b38563424720f50f1450a0bca7d064\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Thu, 01 Dec 16 21:51:17 -0600\",\"date\":\"Thu, 01 Dec 2016 21:51:17 -0600\"},{\"id\":\"79c803d8c1cdbfc3c65bd23a66152a9b\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Sat, 03 Dec 16 09:28:20 -0600\",\"date\":\"Sat, 03 Dec 2016 09:28:20 -0600\"},{\"id\":\"a47a89855d602b6cb384e33cbfed5bcd\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Sun, 04 Dec 16 10:17:15 -0600\",\"date\":\"Sun, 04 Dec 2016 10:17:15 -0600\"},{\"id\":\"563d3af69fdc5da510a3a29bcbc27729\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Sun, 04 Dec 16 17:22:23 -0600\",\"date\":\"Sun, 04 Dec 2016 17:22:23 -0600\"},{\"id\":\"04df5519c97399a7ce7d191e0d3b3905\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Sun, 04 Dec 16 22:45:44 -0600\",\"date\":\"Sun, 04 Dec 2016 22:45:44 -0600\"},{\"id\":\"f3f3033cb0466b5cc61ad563daf96464\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Wed, 07 Dec 16 22:15:12 -0600\",\"date\":\"Wed, 07 Dec 2016 22:15:12 -0600\"},{\"id\":\"e4abf19b228815ddee1adf76dc20dead\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Thu, 08 Dec 16 22:01:15 -0600\",\"date\":\"Thu, 08 Dec 2016 22:01:15 -0600\"},{\"id\":\"61739b09158949eb16fbb004d303d36b\",\"data\":\"[End Session][SYSTEM] Rolando Antonio has cerrado sesion la fecha de Thu, 08 Dec 16 22:01:22 -0600\",\"date\":\"Thu, 08 Dec 2016 22:01:22 -0600\"},{\"id\":\"e1a2e862ce648922b24f1a33f9af23a1\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Sat, 10 Dec 16 17:00:18 -0600\",\"date\":\"Sat, 10 Dec 2016 17:00:18 -0600\"},{\"id\":\"84a5d597b93e3b82159ecdc45c2440db\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Sat, 10 Dec 16 19:19:26 -0600\",\"date\":\"Sat, 10 Dec 2016 19:19:26 -0600\"},{\"id\":\"3caa37ec014f1675bc3c7db01d24c73b\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Sun, 11 Dec 16 09:49:55 -0600\",\"date\":\"Sun, 11 Dec 2016 09:49:55 -0600\"},{\"id\":\"67b9792ab04f5d8b862d061035e3e777\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Sun, 11 Dec 16 19:17:53 -0600\",\"date\":\"Sun, 11 Dec 2016 19:17:53 -0600\"},{\"id\":\"e1945e760fed129799b57fa820dab207\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Mon, 12 Dec 16 13:50:12 -0600\",\"date\":\"Mon, 12 Dec 2016 13:50:12 -0600\"},{\"id\":\"3254bab8d390130282eed6a01d273faf\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Mon, 12 Dec 16 18:12:53 -0600\",\"date\":\"Mon, 12 Dec 2016 18:12:53 -0600\"},{\"id\":\"522ebc9af7a1c96082f248f251ae0d1d\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Mon, 19 Dec 16 22:20:24 -0600\",\"date\":\"Mon, 19 Dec 2016 22:20:24 -0600\"},{\"id\":\"4f87a661f56284c47921c575eba91912\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Wed, 21 Dec 16 20:41:56 -0600\",\"date\":\"Wed, 21 Dec 2016 20:41:56 -0600\"},{\"id\":\"17d14ff98d14cafe8250a4cf5fd5aa58\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Thu, 22 Dec 16 20:42:59 -0600\",\"date\":\"Thu, 22 Dec 2016 20:42:59 -0600\"},{\"id\":\"0d05099993842cdb3506ff2e8ff3f313\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Fri, 23 Dec 16 21:04:34 -0600\",\"date\":\"Fri, 23 Dec 2016 21:04:34 -0600\"},{\"id\":\"b16d8bf3673aa3823f9127583063da28\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Sat, 24 Dec 16 09:26:55 -0600\",\"date\":\"Sat, 24 Dec 2016 09:26:55 -0600\"},{\"id\":\"551b93dc74add87aa57fb3322410a0cb\",\"data\":\"[End Session][SYSTEM] Rolando Antonio has cerrado sesion la fecha de Sat, 24 Dec 16 09:47:27 -0600\",\"date\":\"Sat, 24 Dec 2016 09:47:27 -0600\"},{\"id\":\"978a81cf0049a3095e44640b0f4ba2d0\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Sat, 24 Dec 16 09:47:36 -0600\",\"date\":\"Sat, 24 Dec 2016 09:47:36 -0600\"},{\"id\":\"b9dfcb6f47b203b8f7b300c305e81524\",\"data\":\"[End Session][SYSTEM] Rolando Antonio has cerrado sesion la fecha de Sat, 24 Dec 16 09:56:22 -0600\",\"date\":\"Sat, 24 Dec 2016 09:56:22 -0600\"},{\"id\":\"776a776a333af3f8837aa01b1aac54aa\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Sat, 24 Dec 16 09:57:09 -0600\",\"date\":\"Sat, 24 Dec 2016 09:57:09 -0600\"},{\"id\":\"9e844587c8c1f4f28380ee96a5fcb54b\",\"data\":\"[End Session][SYSTEM] Rolando Antonio has cerrado sesion la fecha de Sat, 24 Dec 16 10:01:11 -0600\",\"date\":\"Sat, 24 Dec 2016 10:01:11 -0600\"},{\"id\":\"719a200d9ce4129fba1c14f7cc053536\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Sat, 24 Dec 16 10:03:24 -0600\",\"date\":\"Sat, 24 Dec 2016 10:03:24 -0600\"},{\"id\":\"ba56a0d54ae7a7a226121c5cafe9b5b7\",\"data\":\"[End Session][SYSTEM] Rolando Antonio has cerrado sesion la fecha de Sat, 24 Dec 16 10:03:33 -0600\",\"date\":\"Sat, 24 Dec 2016 10:03:33 -0600\"},{\"id\":\"6ecf4f883c78626d7ec596a281cd6cae\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Sat, 24 Dec 16 10:08:58 -0600\",\"date\":\"Sat, 24 Dec 2016 10:08:58 -0600\"},{\"id\":\"8a68855f374d33982533793076029fab\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Sat, 24 Dec 16 15:04:09 -0600\",\"date\":\"Sat, 24 Dec 2016 15:04:09 -0600\"},{\"id\":\"255223dd125c1259d0ba69be6209f8f4\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Sun, 25 Dec 16 17:04:37 -0600\",\"date\":\"Sun, 25 Dec 2016 17:04:37 -0600\"},{\"id\":\"32f0d52c8375ec655fbd468610d9aa8b\",\"data\":\"[End Session][SYSTEM] Rolando Antonio has cerrado sesion la fecha de Sun, 25 Dec 16 21:58:20 -0600\",\"date\":\"Sun, 25 Dec 2016 21:58:20 -0600\"},{\"id\":\"7fe5801ecb5894b055cc9acb102903d7\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Sun, 25 Dec 16 22:00:13 -0600\",\"date\":\"Sun, 25 Dec 2016 22:00:13 -0600\"},{\"id\":\"9333c42bd9e8809a1d3c27f83114e38e\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Tue, 27 Dec 16 22:00:19 -0600\",\"date\":\"Tue, 27 Dec 2016 22:00:19 -0600\"},{\"id\":\"3585b8a246eca7fec9d1b7f1edbb039d\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Thu, 29 Dec 16 20:57:11 -0600\",\"date\":\"Thu, 29 Dec 2016 20:57:11 -0600\"},{\"id\":\"64ec17136de4b9a081f2f422329e2fca\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Fri, 30 Dec 16 08:24:13 -0600\",\"date\":\"Fri, 30 Dec 2016 08:24:13 -0600\"},{\"id\":\"edac140848bff1311760ac9e2f0e13d0\",\"data\":\"[End Session][SYSTEM] Rolando Antonio has cerrado sesion la fecha de Fri, 30 Dec 16 19:54:49 -0600\",\"date\":\"Fri, 30 Dec 2016 19:54:49 -0600\"},{\"id\":\"0b1b641e4d5cf30abb079182216b8eed\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Fri, 30 Dec 16 19:54:57 -0600\",\"date\":\"Fri, 30 Dec 2016 19:54:57 -0600\"},{\"id\":\"c58dfe97b7d80e94895d4c7c99eb28b5\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Sat, 31 Dec 16 10:50:20 -0600\",\"date\":\"Sat, 31 Dec 2016 10:50:20 -0600\"},{\"id\":\"6fee03fd93f58046540859488995a2b8\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Sat, 07 Jan 17 20:58:25 -0600\",\"date\":\"Sat, 07 Jan 2017 20:58:25 -0600\"},{\"id\":\"a9dc03e22f636f5bdfd66ede54967aa0\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Sun, 08 Jan 17 10:02:07 -0600\",\"date\":\"Sun, 08 Jan 2017 10:02:07 -0600\"},{\"id\":\"fdaac95d2c3d467076c9bdd930ed6d98\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Tue, 10 Jan 17 21:15:35 -0600\",\"date\":\"Tue, 10 Jan 2017 21:15:35 -0600\"},{\"id\":\"89c8fc21fc0428e1ca8663c0fd9a642b\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Wed, 11 Jan 17 21:33:47 -0600\",\"date\":\"Wed, 11 Jan 2017 21:33:47 -0600\"},{\"id\":\"59bcb859af4216fe714d32a46894e386\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Thu, 12 Jan 17 20:30:29 -0600\",\"date\":\"Thu, 12 Jan 2017 20:30:29 -0600\"},{\"id\":\"c6648bc01c5122dc5782a8eb9fb52446\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Fri, 13 Jan 17 21:44:16 -0600\",\"date\":\"Fri, 13 Jan 2017 21:44:16 -0600\"},{\"id\":\"f303c35582bc25e62c033e48c45f7550\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Sat, 14 Jan 17 10:55:45 -0600\",\"date\":\"Sat, 14 Jan 2017 10:55:45 -0600\"},{\"id\":\"7081511c8a54ad0c98a3b747e2ad23c2\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Sat, 14 Jan 17 22:20:35 -0600\",\"date\":\"Sat, 14 Jan 2017 22:20:35 -0600\"},{\"id\":\"871a57d7f2e31198dd41603f96b72fc9\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Sat, 14 Jan 17 23:55:28 -0600\",\"date\":\"Sat, 14 Jan 2017 23:55:28 -0600\"},{\"id\":\"a7f99bdb23fecaa0a6c811521490fd2d\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Sun, 15 Jan 17 00:49:24 -0600\",\"date\":\"Sun, 15 Jan 2017 00:49:24 -0600\"},{\"id\":\"c9f4ef14c83c52f9a80139782e4cb961\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Sun, 15 Jan 17 10:28:05 -0600\",\"date\":\"Sun, 15 Jan 2017 10:28:05 -0600\"},{\"id\":\"e41f8245f6b949063acd49eff35cde26\",\"data\":\"[Avatar ][SYSTEM] Rolando Antonio Avatar has been change in  Sun, 15 Jan 17 10:52:49 -0600\",\"date\":\"Sun, 15 Jan 2017 10:52:49 -0600\"},{\"id\":\"889700446724ec6fdd83952164881632\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Tue, 17 Jan 17 20:28:52 -0600\",\"date\":\"Tue, 17 Jan 2017 20:28:52 -0600\"},{\"id\":\"65990037078ebb22c87354531013402e\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Thu, 19 Jan 17 18:41:11 -0600\",\"date\":\"Thu, 19 Jan 2017 18:41:11 -0600\"},{\"id\":\"0f9922bfefc7c58cdbe2b5c982273a06\",\"data\":\"[End Session][SYSTEM] Rolando Antonio has cerrado sesion la fecha de Thu, 19 Jan 17 18:44:00 -0600\",\"date\":\"Thu, 19 Jan 2017 18:44:00 -0600\"},{\"id\":\"48657e919ed8cf6872e827bbb98efe08\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Thu, 19 Jan 17 18:47:58 -0600\",\"date\":\"Thu, 19 Jan 2017 18:47:58 -0600\"},{\"id\":\"26e148876f88b7aa70f12fd668a15abd\",\"data\":\"[End Session][SYSTEM] Rolando Antonio has cerrado sesion la fecha de Thu, 19 Jan 17 18:48:03 -0600\",\"date\":\"Thu, 19 Jan 2017 18:48:03 -0600\"},{\"id\":\"53f4bbe48cb600af8ab73123bb33325b\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Thu, 19 Jan 17 18:48:17 -0600\",\"date\":\"Thu, 19 Jan 2017 18:48:17 -0600\"},{\"id\":\"a2ba129ba7c5df1bcf8ded983792b5e1\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Fri, 20 Jan 17 23:07:27 -0600\",\"date\":\"Fri, 20 Jan 2017 23:07:27 -0600\"},{\"id\":\"21fa93daf526d66c7bdcaf7c1acafd75\",\"data\":\"[End Session][SYSTEM] Rolando Antonio has cerrado sesion la fecha de Fri, 20 Jan 17 23:08:13 -0600\",\"date\":\"Fri, 20 Jan 2017 23:08:13 -0600\"},{\"id\":\"9ce4913dbb80bba27deb32f6263c24ae\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Fri, 20 Jan 17 23:08:17 -0600\",\"date\":\"Fri, 20 Jan 2017 23:08:17 -0600\"},{\"id\":\"8b14c60a3ce56498328d32434e52bb4d\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Sun, 22 Jan 17 11:14:37 -0600\",\"date\":\"Sun, 22 Jan 2017 11:14:37 -0600\"},{\"id\":\"e4b70dcdd0b6b585da631975878cc13c\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Sun, 22 Jan 17 22:32:25 -0600\",\"date\":\"Sun, 22 Jan 2017 22:32:25 -0600\"},{\"id\":\"a743aa1c6c348177a901169dde25cdb2\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Tue, 24 Jan 17 20:36:45 -0600\",\"date\":\"Tue, 24 Jan 2017 20:36:45 -0600\"},{\"id\":\"78ded8cde728935b725fcef037463630\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Tue, 31 Jan 17 21:12:10 -0600\",\"date\":\"Tue, 31 Jan 2017 21:12:10 -0600\"},{\"id\":\"d98473addc9f31c8d70505001ecd604b\",\"data\":\"[Avatar ][SYSTEM] Rolando Antonio Avatar has been change in  Tue, 31 Jan 17 21:20:11 -0600\",\"date\":\"Tue, 31 Jan 2017 21:20:11 -0600\"},{\"id\":\"e68a761ef5a1b5dc844d77f822100f4e\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Wed, 01 Feb 17 19:08:01 -0600\",\"date\":\"Wed, 01 Feb 2017 19:08:01 -0600\"},{\"id\":\"36eeffdb754625d255d18ea8b80c507f\",\"data\":\"[End Session][SYSTEM] Rolando Antonio has cerrado sesion la fecha de Wed, 01 Feb 17 19:08:14 -0600\",\"date\":\"Wed, 01 Feb 2017 19:08:14 -0600\"},{\"id\":\"2eab8c729f7a61963b2025a77962aa8f\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Wed, 01 Feb 17 19:40:27 -0600\",\"date\":\"Wed, 01 Feb 2017 19:40:27 -0600\"},{\"id\":\"b66645b8221334f79c42bd97e251960d\",\"data\":\"[End Session][SYSTEM] Rolando Antonio has cerrado sesion la fecha de Wed, 01 Feb 17 19:41:02 -0600\",\"date\":\"Wed, 01 Feb 2017 19:41:02 -0600\"},{\"id\":\"f8cb5776c54d69fa89d29f3470afe217\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Wed, 01 Feb 17 19:45:55 -0600\",\"date\":\"Wed, 01 Feb 2017 19:45:55 -0600\"},{\"id\":\"47713e0a5808445008ff2ce32a914c42\",\"data\":\"[End Session][SYSTEM] Rolando Antonio has cerrado sesion la fecha de Wed, 01 Feb 17 19:46:10 -0600\",\"date\":\"Wed, 01 Feb 2017 19:46:10 -0600\"},{\"id\":\"3c6fe18d44fabc74efbdc0e1770bb4f0\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Wed, 01 Feb 17 19:58:26 -0600\",\"date\":\"Wed, 01 Feb 2017 19:58:26 -0600\"},{\"id\":\"9ef2df7e8f14a5319e701da0b11a4bc5\",\"data\":\"[End Session][SYSTEM] Rolando Antonio has cerrado sesion la fecha de Wed, 01 Feb 17 20:01:40 -0600\",\"date\":\"Wed, 01 Feb 2017 20:01:40 -0600\"}]',1,0,'S',NULL,'2017-02-01 20:01:40'),(150,'log_file','[{\"id\":\"94af46837c1ce6fc2ee4015cc5590e2e\",\"data\":\"[End Session][SYSTEM]  has cerrado sesion la fecha de Wed, 23 Nov 16 19:43:28 -0600\",\"date\":\"Wed, 23 Nov 2016 19:43:28 -0600\"}]',NULL,0,'S',NULL,'2017-01-17 22:35:04'),(151,'log_file','[{\"id\":\"94af46837c1ce6fc2ee4015cc5590e2e\",\"data\":\"[End Session][SYSTEM]  has cerrado sesion la fecha de Wed, 23 Nov 16 19:43:28 -0600\",\"date\":\"Wed, 23 Nov 2016 19:43:28 -0600\"}]',NULL,0,'S',NULL,'2017-01-17 22:35:04'),(152,'user_lang','en',2,0,'S',NULL,'2017-01-17 22:35:04'),(153,'log_file','[{\"id\":\"e6e423df626d02b79512b8c8f32b9a95\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Mon, 12 Dec 16 14:47:27 -0600\",\"date\":\"Mon, 12 Dec 2016 14:47:27 -0600\"},{\"id\":\"27bb8a15a3ef5ea1aefb290ef4831e76\",\"data\":\"[START SESSION][SYSTEM]  Start Session on Sun, 15 Jan 17 00:48:41 -0600\",\"date\":\"Sun, 15 Jan 2017 00:48:41 -0600\"},{\"id\":\"6c720cdf3c6f9c1568503860062fd886\",\"data\":\"[End Session][SYSTEM] Invitado Antonio has cerrado sesion la fecha de Sun, 15 Jan 17 00:49:15 -0600\",\"date\":\"Sun, 15 Jan 2017 00:49:16 -0600\"}]',2,0,'S',NULL,'2017-01-17 22:35:04'),(154,'nav_data','namespace',0,0,'S','Navegador Tipo Namespace\r\n','2017-01-17 22:35:04'),(155,'nav_data','sidebar',0,0,'S','Navegador Tipo Sidebar\r\n','2017-01-17 22:35:04'),(156,'nav_data','section',0,0,'S','Navegador Tipo Section	\r\n','2017-01-17 22:35:04'),(157,'nav_data','sub_menu',0,0,'S','Navegador Tipo SubMenu\r\n','2017-01-17 22:35:04'),(159,'countries','[\r\n  {\r\n    \"iso\"     : \"SV\",\r\n    \"name\"    : \"El salvador\",\r\n    \"active\"  : \"1\"\r\n  },\r\n  {\r\n    \"iso\"     : \"GT\",\r\n    \"name\"    : \"Guatemala\",\r\n    \"active\"  : \"1\"\r\n  },\r\n  {\r\n    \"iso\"     : \"HN\",\r\n    \"name\"    : \"Honduras\",\r\n    \"active\"  : \"1\"\r\n  }\r\n]',0,0,'S','Paises disponibles','2017-01-17 22:35:04'),(160,'front_route',' {\r\n	\"front-test\":\r\n  	{\r\n    		\"dir\"     : \"frontend\",\r\n    		\"model\"   : \"main\",\r\n    		\"action\"  : \"dothat\"\r\n 	 }\r\n}',0,0,'S',NULL,'2017-01-19 23:10:50');
/*!40000 ALTER TABLE `ga_metadata` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ga_nav`
--

DROP TABLE IF EXISTS `ga_nav`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ga_nav` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  `name` mediumtext,
  `location` varchar(50) DEFAULT NULL,
  `route` varchar(50) DEFAULT NULL,
  `objects` text,
  `components` text,
  `parent` varchar(255) DEFAULT NULL,
  `origins` varchar(255) DEFAULT NULL,
  `active` int(11) DEFAULT '0',
  `privs` varchar(255) DEFAULT '0',
  `token` varchar(100) DEFAULT NULL,
  `operator` varchar(100) DEFAULT NULL,
  `create_date` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=latin1 COMMENT='navbar version 1.0 ';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ga_nav`
--

LOCK TABLES `ga_nav` WRITE;
/*!40000 ALTER TABLE `ga_nav` DISABLE KEYS */;
INSERT INTO `ga_nav` VALUES (1,'namespace','{\"es\":\"Menu\",\"en\":\"Menu\"}','','','{    \"icon\" : \"\",  \"redirect\": \"\",  \"target\" : \"\"  }','{}','1','system',1,'0','','1ff1de774005f8da13f42943881c655f','2017-01-14 11:49:14'),(2,'sidebar','{\"es\": \"Inicio\" , \"en\" : \"Home\" }','','','{    \"icon\" : \"fa fa-home\",  \"redirect\": \"\",  \"target\" : \"\"  }','{\"alerts\" :\"true\"}','1','system',1,'0','','3416a75f4cea9109507cacd8e2f2aefc','2017-01-14 11:49:14'),(4,'namespace','{\"es\":\"Administrador\",\"en\":\"Admin\"}','','','{    \"icon\" : \"\",  \"redirect\": \"\",  \"target\" : \"\"  }','{}','','',1,'1,2','','4e732ced3463d06de0ca9a15b6153677','2017-01-17 22:50:19'),(5,'section','{\"es\": \"Usuarios\" , \"en\" : \"Users\" }','','','{    \"icon\" : \"fa fa-users\",  \"redirect\": \"\",  \"target\" : \"\"  }','{}','4','system',1,'1,2','','d82c8d1619ad8176d665453cfb2e55f0','2017-01-14 11:49:14'),(6,'sidebar','{\"es\" : \"Permisos\" , \"en\" : \"permissions\" }','system=permissions','permissions','{    \"icon\" : \"fa fa-terminal\",  \"redirect\": \"\",  \"target\" : \"\"  }','{}','5','system',1,'1','','1f0e3dad99908345f7439f8ffabdffc4','2017-01-17 23:03:09'),(8,'sub_menu','{\"es\": \"Mi perfil \" , \"en\" : \"My Profile\"}','profile=profile','profile','{\r\n  \r\n  \"icon\" : \"icon-user\",\r\n  \"redirect\": \"\",\r\n  \"target\" : \"\",\r\n \"place\" : \"1\",\r\n \"divider\" : \"true\"\r\n  \r\n}','{}','0','system',1,'0',NULL,NULL,'2017-01-14 11:49:14'),(9,'sub_menu','{\"es\": \"Cerrar Sesión\" , \"en\" : \"Close Session\" }','system=end_session','end_session','{\r\n  \r\n  \"icon\" : \"icon-key\",\r\n  \"redirect\": \"\",\r\n  \"target\" : \"\",\r\n  \"place\" : \"1\"\r\n  \r\n}','{}','0','system',1,'0',NULL,NULL,'2017-01-14 11:49:14'),(10,'sidebar','{\"es\" : \"Perfil\" , \"en\" : \"Profile\"}','profile=profile','profile','{\r\n  \r\n  \"icon\" : \"icon-user\",\r\n  \"redirect\": \"\",\r\n  \"target\" : \"\",\r\n \"place\" : \"1\",\r\n \"divider\" : \"true\"\r\n  \r\n}','{}','5','system',1,'0',NULL,NULL,'2017-01-14 11:49:14'),(13,'section','{\"es\": \"Sistema\" , \"en\" : \"System\" }',NULL,NULL,'{\r\n  \r\n  \"icon\" : \"fa fa-cog\",\r\n  \"redirect\": \"\",\r\n  \"target\" : \"\"\r\n  \r\n}','{}','4','system',1,'1',NULL,NULL,'2017-01-14 11:49:14'),(14,'sidebar','{\"es\" : \"Constantes\" , \"en\" : \"Constants\" }','system=constants','system_constants','{\r\n  \r\n  \"icon\" : \"fa fa-pencil\",\r\n  \"redirect\": \"\",\r\n  \"target\" : \"\",\r\n \"place\" : \"1\",\r\n \"divider\" : \"true\"\r\n  \r\n}','{}','13','system',1,'1',NULL,NULL,'2017-01-31 21:23:20'),(15,'sidebar','{\"es\" : \"Estado\" , \"en\" : \"Status\" }','system=system_status','system_status','{    \"icon\" : \"fa fa-code\",  \"redirect\": \"\",  \"target\" : \"\", \"place\" : \"2\", \"divider\" : \"true\"  }','{}','13','system',1,'1','',NULL,'2017-01-14 11:49:14'),(16,'sidebar','{\"es\" : \"Configuracion Correo\" , \"en\" : \"Email config\"}','system=email','email_config','{\r\n  \r\n  \"icon\" : \"fa fa-envelope\",\r\n  \"redirect\": \"\",\r\n  \"target\" : \"\",\r\n \"place\" : \"2\",\r\n \"divider\" : \"true\"\r\n  \r\n}','{}','13','system',1,'1',NULL,NULL,'2017-01-14 11:49:14'),(23,'sidebar','{ \"es\" : \"Navegacion\" , \"en\" : \"Navigation\"}','system=navigator','nav','{    \"icon\" : \"fa fa-bars\",  \"redirect\": \"\",  \"target\" : \"\", \"place\" : \"4\", \"divider\" : \"true\"  }','{}','13','system',1,'1','','a684eceee76fc522773286a895bc8436','2017-01-14 11:49:14'),(26,'namespace','{\"es\":\"Pruebas\",\"en\":\"Test-Area\"}','','','{\"icon\":\"fa fa-exclamation-triangle\",\"redirect\":\"\",\"target\":\"\",\"place\":\"1\",\"divider\":\"false\"}','  ','','test',1,'1','e55x9b4r57s6qk2jwz5mi','a57547f4b3df3c8640c3b816e58a3c7a','2017-01-14 12:31:16'),(27,'section','{\"es\":\"Pruebas unitarias\",\"en\":\"Unit Test\"}','','','{\"icon\":\"fa fa-handshake-o\",\"redirect\":\"\",\"target\":\"\",\"place\":\"1\",\"divider\":\"true\"}','  ','26','test',1,'1','aui9u0s1kaug3izwu3di','f25111efc8c27efd5ca7236050ed6204','2017-01-14 12:32:55'),(30,'sidebar','{\"es\":\" spruebas\",\"en\":\" stest\"}','test=test','test','{\"icon\":\"fa fa-flag-o\",\"redirect\":\"\",\"target\":\"\",\"place\":\"1\",\"divider\":\"true\"}','  ','27','test',1,'1','qfi02h4m4oinmlqjv2t9','afd2d0b2b7ac89c6abfd839395b09604','2017-01-14 22:41:44');
/*!40000 ALTER TABLE `ga_nav` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ga_notify`
--

DROP TABLE IF EXISTS `ga_notify`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ga_notify` (
  `id_notify` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_rol` int(11) DEFAULT NULL,
  `id_meta` int(11) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `content` varchar(255) NOT NULL,
  `reads` text NOT NULL,
  `active` int(11) DEFAULT '1',
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `send_in_date` int(11) DEFAULT '0',
  PRIMARY KEY (`id_notify`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ga_notify`
--

LOCK TABLES `ga_notify` WRITE;
/*!40000 ALTER TABLE `ga_notify` DISABLE KEYS */;
/*!40000 ALTER TABLE `ga_notify` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ga_operator_log`
--

DROP TABLE IF EXISTS `ga_operator_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ga_operator_log` (
  `id_op_log` int(11) NOT NULL AUTO_INCREMENT,
  `id_operator` varchar(255) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `operator_type` int(11) DEFAULT NULL,
  `id_company` int(11) DEFAULT NULL,
  `affected_table` varchar(100) DEFAULT NULL,
  `log` text,
  `date` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_op_log`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb4 COMMENT='Tabla de operadores en cuestion de manipulacion del sistema\r\n\r\nesta tabla realiza un log o bitacora de las manipulaciones del sistema por medio del operador\r\nclaro esta se necesitara saber \r\nla tabla afectada\r\n\r\nid_operator = se genera este id automaticamente para un filter\r\ncampo log = archivo json la cual tendra la configuracion de la manipulacion \r\nid_user = usuario que se ve afectado \r\n';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ga_operator_log`
--

LOCK TABLES `ga_operator_log` WRITE;
/*!40000 ALTER TABLE `ga_operator_log` DISABLE KEYS */;
INSERT INTO `ga_operator_log` VALUES (60,'3416a75f4cea9109507cacd8e2f2aefc',1,0,0,'ga_nav','{\"id_user_operator\":\"1\",\"table\":{\"table_name\":\"ga_nav\",\"affected_rows\":true,\"query\":\"UPDATE GA_NAV , PARAMS(a:11:{s:4:\\u0022name\\u0022;s:33:\\u0022{\\u0022es\\u0022: \\u0022Inicio\\u0022 , \\u0022en\\u0022 : \\u0022Home\\u0022 }\\u0022;s:10:\\u0022components\\u0022;s:18:\\u0022{\\u0022alerts\\u0022 :\\u0022true\\u0022}\\u0022;s:7:\\u0022objects\\u0022;s:62:\\u0022{    \\u0022icon\\u0022 : \\u0022fa fa-home\\u0022,  \\u0022redirect\\u0022: \\u0022\\u0022,  \\u0022target\\u0022 : \\u0022\\u0022  }\\u0022;s:8:\\u0022location\\u0022;s:0:\\u0022\\u0022;s:5:\\u0022route\\u0022;s:0:\\u0022\\u0022;s:6:\\u0022parent\\u0022;s:1:\\u00221\\u0022;s:6:\\u0022active\\u0022;s:1:\\u00221\\u0022;s:4:\\u0022type\\u0022;s:7:\\u0022sidebar\\u0022;s:5:\\u0022privs\\u0022;i:0;s:7:\\u0022origins\\u0022;s:6:\\u0022system\\u0022;s:5:\\u0022token\\u0022;s:0:\\u0022\\u0022;}) , ID(2)\"},\"user\":{\"id_user_affected\":\"\",\"users_affected\":\"\"},\"company\":{\"id_company_affected\":\"\"},\"affected\":{\"date\":\"Dec-23-2016\",\"hour\":\"21:12:22\",\"action\":\"UPDATE\"},\"status\":{\"rollback\":false,\"approved\":false,\"id_user_approved\":0,\"active\":false},\"sp\":{\"name\":\"NO STORED PROCEDURE \",\"params\":[]}}','2016-12-23 21:05:22'),(62,'1f0e3dad99908345f7439f8ffabdffc4',1,0,0,'ga_nav','{\"id_user_operator\":\"1\",\"table\":{\"table_name\":\"ga_nav\",\"affected_rows\":true,\"query\":\"UPDATE GA_NAV , PARAMS(a:11:{s:4:\\u0022name\\u0022;s:43:\\u0022{\\u0022es\\u0022 : \\u0022Permisos\\u0022 , \\u0022en\\u0022 : \\u0022permissions\\u0022 }\\u0022;s:10:\\u0022components\\u0022;s:2:\\u0022{}\\u0022;s:7:\\u0022objects\\u0022;s:66:\\u0022{    \\u0022icon\\u0022 : \\u0022fa fa-terminal\\u0022,  \\u0022redirect\\u0022: \\u0022\\u0022,  \\u0022target\\u0022 : \\u0022\\u0022  }\\u0022;s:8:\\u0022location\\u0022;s:18:\\u0022system=permissions\\u0022;s:5:\\u0022route\\u0022;s:11:\\u0022permissions\\u0022;s:6:\\u0022parent\\u0022;s:1:\\u00225\\u0022;s:6:\\u0022active\\u0022;s:1:\\u00220\\u0022;s:4:\\u0022type\\u0022;s:7:\\u0022sidebar\\u0022;s:5:\\u0022privs\\u0022;s:1:\\u00221\\u0022;s:7:\\u0022origins\\u0022;s:6:\\u0022system\\u0022;s:5:\\u0022token\\u0022;s:0:\\u0022\\u0022;}) , ID(6)\"},\"user\":{\"id_user_affected\":\"\",\"users_affected\":\"\"},\"company\":{\"id_company_affected\":\"\"},\"affected\":{\"date\":\"Dec-29-2016\",\"hour\":\"23:12:35\",\"action\":\"UPDATE\"},\"status\":{\"rollback\":false,\"approved\":false,\"id_user_approved\":0,\"active\":false},\"sp\":{\"name\":\"NO STORED PROCEDURE \",\"params\":[]}}','2016-12-29 23:38:35'),(63,'4e732ced3463d06de0ca9a15b6153677',1,0,0,'ga_nav','{\"id_user_operator\":\"1\",\"table\":{\"table_name\":\"ga_nav\",\"affected_rows\":true,\"query\":\"UPDATE GA_NAV , PARAMS(a:11:{s:4:\\u0022name\\u0022;s:35:\\u0022{\\u0022es\\u0022:\\u0022Administrador\\u0022,\\u0022en\\u0022:\\u0022Admin\\u0022}\\u0022;s:10:\\u0022components\\u0022;s:4:\\u0022\\u0022{}\\u0022\\u0022;s:7:\\u0022objects\\u0022;s:52:\\u0022{    \\u0022icon\\u0022 : \\u0022\\u0022,  \\u0022redirect\\u0022: \\u0022\\u0022,  \\u0022target\\u0022 : \\u0022\\u0022  }\\u0022;s:8:\\u0022location\\u0022;s:0:\\u0022\\u0022;s:5:\\u0022route\\u0022;s:0:\\u0022\\u0022;s:6:\\u0022parent\\u0022;s:0:\\u0022\\u0022;s:6:\\u0022active\\u0022;s:1:\\u00221\\u0022;s:4:\\u0022type\\u0022;s:9:\\u0022namespace\\u0022;s:5:\\u0022privs\\u0022;s:3:\\u00221,2\\u0022;s:7:\\u0022origins\\u0022;s:0:\\u0022\\u0022;s:5:\\u0022token\\u0022;s:0:\\u0022\\u0022;}) , ID(4)\"},\"user\":{\"id_user_affected\":\"\",\"users_affected\":\"\"},\"company\":{\"id_company_affected\":\"\"},\"affected\":{\"date\":\"Jan-12-2017\",\"hour\":\"23:01:09\",\"action\":\"UPDATE\"},\"status\":{\"rollback\":false,\"approved\":false,\"id_user_approved\":0,\"active\":false},\"sp\":{\"name\":\"NO STORED PROCEDURE \",\"params\":[]}}','2017-01-12 23:09:09'),(64,'4e732ced3463d06de0ca9a15b6153677',1,0,0,'ga_nav','{\"id_user_operator\":\"1\",\"table\":{\"table_name\":\"ga_nav\",\"affected_rows\":true,\"query\":\"UPDATE GA_NAV , PARAMS(a:11:{s:4:\\u0022name\\u0022;s:35:\\u0022{\\u0022es\\u0022:\\u0022Administrador\\u0022,\\u0022en\\u0022:\\u0022Admin\\u0022}\\u0022;s:10:\\u0022components\\u0022;s:4:\\u0022\\u0022{}\\u0022\\u0022;s:7:\\u0022objects\\u0022;s:52:\\u0022{    \\u0022icon\\u0022 : \\u0022\\u0022,  \\u0022redirect\\u0022: \\u0022\\u0022,  \\u0022target\\u0022 : \\u0022\\u0022  }\\u0022;s:8:\\u0022location\\u0022;s:0:\\u0022\\u0022;s:5:\\u0022route\\u0022;s:0:\\u0022\\u0022;s:6:\\u0022parent\\u0022;s:0:\\u0022\\u0022;s:6:\\u0022active\\u0022;s:1:\\u00221\\u0022;s:4:\\u0022type\\u0022;s:9:\\u0022namespace\\u0022;s:5:\\u0022privs\\u0022;s:3:\\u00221,2\\u0022;s:7:\\u0022origins\\u0022;s:0:\\u0022\\u0022;s:5:\\u0022token\\u0022;s:0:\\u0022\\u0022;}) , ID(4)\"},\"user\":{\"id_user_affected\":\"\",\"users_affected\":\"\"},\"company\":{\"id_company_affected\":\"\"},\"affected\":{\"date\":\"Jan-12-2017\",\"hour\":\"23:01:21\",\"action\":\"UPDATE\"},\"status\":{\"rollback\":false,\"approved\":false,\"id_user_approved\":0,\"active\":false},\"sp\":{\"name\":\"NO STORED PROCEDURE \",\"params\":[]}}','2017-01-12 23:09:21'),(65,'69934c71f33b1c34c19127bc8bde293f',1,0,0,'ga_nav','{\"id_user_operator\":\"1\",\"table\":{\"table_name\":\"ga_nav\",\"affected_rows\":1,\"query\":\"INSERT GA_NAV , PARAMS(a:12:{s:4:\\u0022type\\u0022;s:7:\\u0022section\\u0022;s:4:\\u0022name\\u0022;s:27:\\u0022{\\u0022es\\u0022:\\u0022prueba\\u0022,\\u0022en\\u0022:\\u0022test\\u0022}\\u0022;s:8:\\u0022location\\u0022;s:0:\\u0022\\u0022;s:5:\\u0022route\\u0022;s:0:\\u0022\\u0022;s:7:\\u0022objects\\u0022;s:79:\\u0022{\\u0022icon\\u0022:\\u0022fa-fa example\\u0022,\\u0022redirect\\u0022:\\u0022\\u0022,\\u0022target\\u0022:\\u0022\\u0022,\\u0022place\\u0022:\\u00225\\u0022,\\u0022divider\\u0022:\\u0022true\\u0022}\\u0022;s:10:\\u0022components\\u0022;s:2:\\u0022  \\u0022;s:6:\\u0022parent\\u0022;s:1:\\u00221\\u0022;s:7:\\u0022origins\\u0022;s:4:\\u0022test\\u0022;s:6:\\u0022active\\u0022;i:1;s:5:\\u0022privs\\u0022;s:3:\\u00221,3\\u0022;s:5:\\u0022token\\u0022;s:19:\\u0022l3rzb7babvvammtpgb9\\u0022;s:8:\\u0022operator\\u0022;s:32:\\u002269934c71f33b1c34c19127bc8bde293f\\u0022;}) , ID(25)\"},\"user\":{\"id_user_affected\":\"\",\"users_affected\":\"\"},\"company\":{\"id_company_affected\":\"\"},\"affected\":{\"date\":\"Jan-14-2017\",\"hour\":\"12:01:58\",\"action\":\"INSERT OR CREATE\"},\"status\":{\"rollback\":false,\"approved\":false,\"id_user_approved\":0,\"active\":false},\"sp\":{\"name\":\"NO STORED PROCEDURE \",\"params\":[]}}','2017-01-14 12:11:58'),(66,'a684eceee76fc522773286a895bc8436',1,0,0,'ga_nav','{\"id_user_operator\":\"1\",\"table\":{\"table_name\":\"ga_nav\",\"affected_rows\":1,\"query\":\"DELETE GA_NAV , PARAMS(a:1:{s:2:\\u0022id\\u0022;s:2:\\u002225\\u0022;}) , ID(25)\"},\"user\":{\"id_user_affected\":\"\",\"users_affected\":\"\"},\"company\":{\"id_company_affected\":\"\"},\"affected\":{\"date\":\"Jan-14-2017\",\"hour\":\"12:01:43\",\"action\":\"UPDATE\"},\"status\":{\"rollback\":false,\"approved\":false,\"id_user_approved\":0,\"active\":false},\"sp\":{\"name\":\"NO STORED PROCEDURE \",\"params\":[]}}','2017-01-14 12:27:43'),(67,'a57547f4b3df3c8640c3b816e58a3c7a',1,0,0,'ga_nav','{\"id_user_operator\":\"1\",\"table\":{\"table_name\":\"ga_nav\",\"affected_rows\":1,\"query\":\"INSERT GA_NAV , PARAMS(a:12:{s:4:\\u0022type\\u0022;s:9:\\u0022namespace\\u0022;s:4:\\u0022name\\u0022;s:33:\\u0022{\\u0022es\\u0022:\\u0022Pruebas\\u0022,\\u0022en\\u0022:\\u0022Test-Area\\u0022}\\u0022;s:8:\\u0022location\\u0022;s:0:\\u0022\\u0022;s:5:\\u0022route\\u0022;s:0:\\u0022\\u0022;s:7:\\u0022objects\\u0022;s:93:\\u0022{\\u0022icon\\u0022:\\u0022fa fa-exclamation-triangle\\u0022,\\u0022redirect\\u0022:\\u0022\\u0022,\\u0022target\\u0022:\\u0022\\u0022,\\u0022place\\u0022:\\u00221\\u0022,\\u0022divider\\u0022:\\u0022false\\u0022}\\u0022;s:10:\\u0022components\\u0022;s:2:\\u0022  \\u0022;s:6:\\u0022parent\\u0022;s:0:\\u0022\\u0022;s:7:\\u0022origins\\u0022;s:4:\\u0022test\\u0022;s:6:\\u0022active\\u0022;i:1;s:5:\\u0022privs\\u0022;s:1:\\u00221\\u0022;s:5:\\u0022token\\u0022;s:21:\\u0022e55x9b4r57s6qk2jwz5mi\\u0022;s:8:\\u0022operator\\u0022;s:32:\\u0022a57547f4b3df3c8640c3b816e58a3c7a\\u0022;}) , ID(26)\"},\"user\":{\"id_user_affected\":\"\",\"users_affected\":\"\"},\"company\":{\"id_company_affected\":\"\"},\"affected\":{\"date\":\"Jan-14-2017\",\"hour\":\"12:01:16\",\"action\":\"INSERT OR CREATE\"},\"status\":{\"rollback\":false,\"approved\":false,\"id_user_approved\":0,\"active\":false},\"sp\":{\"name\":\"NO STORED PROCEDURE \",\"params\":[]}}','2017-01-14 12:31:16'),(68,'f25111efc8c27efd5ca7236050ed6204',1,0,0,'ga_nav','{\"id_user_operator\":\"1\",\"table\":{\"table_name\":\"ga_nav\",\"affected_rows\":1,\"query\":\"INSERT GA_NAV , PARAMS(a:12:{s:4:\\u0022type\\u0022;s:7:\\u0022section\\u0022;s:4:\\u0022name\\u0022;s:43:\\u0022{\\u0022es\\u0022:\\u0022Pruebas unitarias\\u0022,\\u0022en\\u0022:\\u0022Unit Test\\u0022}\\u0022;s:8:\\u0022location\\u0022;s:0:\\u0022\\u0022;s:5:\\u0022route\\u0022;s:0:\\u0022\\u0022;s:7:\\u0022objects\\u0022;s:83:\\u0022{\\u0022icon\\u0022:\\u0022fa fa-handshake-o\\u0022,\\u0022redirect\\u0022:\\u0022\\u0022,\\u0022target\\u0022:\\u0022\\u0022,\\u0022place\\u0022:\\u00221\\u0022,\\u0022divider\\u0022:\\u0022true\\u0022}\\u0022;s:10:\\u0022components\\u0022;s:2:\\u0022  \\u0022;s:6:\\u0022parent\\u0022;s:2:\\u002226\\u0022;s:7:\\u0022origins\\u0022;s:4:\\u0022test\\u0022;s:6:\\u0022active\\u0022;i:1;s:5:\\u0022privs\\u0022;s:1:\\u00221\\u0022;s:5:\\u0022token\\u0022;s:20:\\u0022aui9u0s1kaug3izwu3di\\u0022;s:8:\\u0022operator\\u0022;s:32:\\u0022f25111efc8c27efd5ca7236050ed6204\\u0022;}) , ID(27)\"},\"user\":{\"id_user_affected\":\"\",\"users_affected\":\"\"},\"company\":{\"id_company_affected\":\"\"},\"affected\":{\"date\":\"Jan-14-2017\",\"hour\":\"12:01:55\",\"action\":\"INSERT OR CREATE\"},\"status\":{\"rollback\":false,\"approved\":false,\"id_user_approved\":0,\"active\":false},\"sp\":{\"name\":\"NO STORED PROCEDURE \",\"params\":[]}}','2017-01-14 12:32:55'),(69,'4edfd5553e24983083c5b7c804bd45c2',1,0,0,'ga_nav','{\"id_user_operator\":\"1\",\"table\":{\"table_name\":\"ga_nav\",\"affected_rows\":1,\"query\":\"INSERT GA_NAV , PARAMS(a:12:{s:4:\\u0022type\\u0022;s:8:\\u0022sub_menu\\u0022;s:4:\\u0022name\\u0022;s:32:\\u0022{\\u0022es\\u0022:\\u0022Prueba \\u0022,\\u0022en\\u0022:\\u0022Test_Sub\\u0022}\\u0022;s:8:\\u0022location\\u0022;s:9:\\u0022test=test\\u0022;s:5:\\u0022route\\u0022;s:4:\\u0022test\\u0022;s:7:\\u0022objects\\u0022;s:78:\\u0022{\\u0022icon\\u0022:\\u0022fa fa-flag-o\\u0022,\\u0022redirect\\u0022:\\u0022\\u0022,\\u0022target\\u0022:\\u0022\\u0022,\\u0022place\\u0022:\\u0022\\u0022,\\u0022divider\\u0022:\\u0022false\\u0022}\\u0022;s:10:\\u0022components\\u0022;s:2:\\u0022  \\u0022;s:6:\\u0022parent\\u0022;s:0:\\u0022\\u0022;s:7:\\u0022origins\\u0022;s:4:\\u0022test\\u0022;s:6:\\u0022active\\u0022;i:1;s:5:\\u0022privs\\u0022;s:1:\\u00221\\u0022;s:5:\\u0022token\\u0022;s:20:\\u0022ok5ez9s7vrwfdedpwrk9\\u0022;s:8:\\u0022operator\\u0022;s:32:\\u00224edfd5553e24983083c5b7c804bd45c2\\u0022;}) , ID(28)\"},\"user\":{\"id_user_affected\":\"\",\"users_affected\":\"\"},\"company\":{\"id_company_affected\":\"\"},\"affected\":{\"date\":\"Jan-14-2017\",\"hour\":\"22:01:45\",\"action\":\"INSERT OR CREATE\"},\"status\":{\"rollback\":false,\"approved\":false,\"id_user_approved\":0,\"active\":false},\"sp\":{\"name\":\"NO STORED PROCEDURE \",\"params\":[]}}','2017-01-14 22:31:45'),(70,'85d068ba9ecd01c9cf4abb09d745a275',1,0,0,'ga_nav','{\"id_user_operator\":\"1\",\"table\":{\"table_name\":\"ga_nav\",\"affected_rows\":1,\"query\":\"INSERT GA_NAV , PARAMS(a:12:{s:4:\\u0022type\\u0022;s:7:\\u0022sidebar\\u0022;s:4:\\u0022name\\u0022;s:29:\\u0022{\\u0022es\\u0022:\\u0022Sprueba\\u0022,\\u0022en\\u0022:\\u0022Stest\\u0022}\\u0022;s:8:\\u0022location\\u0022;s:9:\\u0022test=test\\u0022;s:5:\\u0022route\\u0022;s:4:\\u0022test\\u0022;s:7:\\u0022objects\\u0022;s:78:\\u0022{\\u0022icon\\u0022:\\u0022fa fa-flag-o\\u0022,\\u0022redirect\\u0022:\\u0022\\u0022,\\u0022target\\u0022:\\u0022\\u0022,\\u0022place\\u0022:\\u00221\\u0022,\\u0022divider\\u0022:\\u0022true\\u0022}\\u0022;s:10:\\u0022components\\u0022;s:2:\\u0022  \\u0022;s:6:\\u0022parent\\u0022;s:2:\\u002227\\u0022;s:7:\\u0022origins\\u0022;s:4:\\u0022test\\u0022;s:6:\\u0022active\\u0022;i:1;s:5:\\u0022privs\\u0022;s:1:\\u00221\\u0022;s:5:\\u0022token\\u0022;s:20:\\u0022gcl31yqhkpqb20c6jemi\\u0022;s:8:\\u0022operator\\u0022;s:32:\\u002285d068ba9ecd01c9cf4abb09d745a275\\u0022;}) , ID(29)\"},\"user\":{\"id_user_affected\":\"\",\"users_affected\":\"\"},\"company\":{\"id_company_affected\":\"\"},\"affected\":{\"date\":\"Jan-14-2017\",\"hour\":\"22:01:43\",\"action\":\"INSERT OR CREATE\"},\"status\":{\"rollback\":false,\"approved\":false,\"id_user_approved\":0,\"active\":false},\"sp\":{\"name\":\"NO STORED PROCEDURE \",\"params\":[]}}','2017-01-14 22:40:43'),(71,'afd2d0b2b7ac89c6abfd839395b09604',1,0,0,'ga_nav','{\"id_user_operator\":\"1\",\"table\":{\"table_name\":\"ga_nav\",\"affected_rows\":1,\"query\":\"INSERT GA_NAV , PARAMS(a:12:{s:4:\\u0022type\\u0022;s:7:\\u0022sidebar\\u0022;s:4:\\u0022name\\u0022;s:32:\\u0022{\\u0022es\\u0022:\\u0022 spruebas\\u0022,\\u0022en\\u0022:\\u0022 stest\\u0022}\\u0022;s:8:\\u0022location\\u0022;s:9:\\u0022test=test\\u0022;s:5:\\u0022route\\u0022;s:4:\\u0022test\\u0022;s:7:\\u0022objects\\u0022;s:78:\\u0022{\\u0022icon\\u0022:\\u0022fa fa-flag-o\\u0022,\\u0022redirect\\u0022:\\u0022\\u0022,\\u0022target\\u0022:\\u0022\\u0022,\\u0022place\\u0022:\\u00221\\u0022,\\u0022divider\\u0022:\\u0022true\\u0022}\\u0022;s:10:\\u0022components\\u0022;s:2:\\u0022  \\u0022;s:6:\\u0022parent\\u0022;s:2:\\u002227\\u0022;s:7:\\u0022origins\\u0022;s:4:\\u0022test\\u0022;s:6:\\u0022active\\u0022;i:1;s:5:\\u0022privs\\u0022;s:1:\\u00221\\u0022;s:5:\\u0022token\\u0022;s:20:\\u0022qfi02h4m4oinmlqjv2t9\\u0022;s:8:\\u0022operator\\u0022;s:32:\\u0022afd2d0b2b7ac89c6abfd839395b09604\\u0022;}) , ID(30)\"},\"user\":{\"id_user_affected\":\"\",\"users_affected\":\"\"},\"company\":{\"id_company_affected\":\"\"},\"affected\":{\"date\":\"Jan-14-2017\",\"hour\":\"22:01:44\",\"action\":\"INSERT OR CREATE\"},\"status\":{\"rollback\":false,\"approved\":false,\"id_user_approved\":0,\"active\":false},\"sp\":{\"name\":\"NO STORED PROCEDURE \",\"params\":[]}}','2017-01-14 22:41:44'),(72,'1ff1de774005f8da13f42943881c655f',1,0,0,'ga_nav','{\"id_user_operator\":\"1\",\"table\":{\"table_name\":\"ga_nav\",\"affected_rows\":1,\"query\":\"DELETE GA_NAV , PARAMS(a:1:{s:2:\\u0022id\\u0022;s:2:\\u002229\\u0022;}) , ID(29)\"},\"user\":{\"id_user_affected\":\"\",\"users_affected\":\"\"},\"company\":{\"id_company_affected\":\"\"},\"affected\":{\"date\":\"Jan-14-2017\",\"hour\":\"22:01:05\",\"action\":\"UPDATE\"},\"status\":{\"rollback\":false,\"approved\":false,\"id_user_approved\":0,\"active\":false},\"sp\":{\"name\":\"NO STORED PROCEDURE \",\"params\":[]}}','2017-01-14 22:42:05'),(73,'6f7c5b872213e17041c3bc35429b9d21',1,0,0,'ga_nav','{\"id_user_operator\":\"1\",\"table\":{\"table_name\":\"ga_nav\",\"affected_rows\":1,\"query\":\"INSERT GA_NAV , PARAMS(a:12:{s:4:\\u0022type\\u0022;s:8:\\u0022sub_menu\\u0022;s:4:\\u0022name\\u0022;s:29:\\u0022{\\u0022es\\u0022:\\u0022pruebaA\\u0022,\\u0022en\\u0022:\\u0022testA\\u0022}\\u0022;s:8:\\u0022location\\u0022;s:9:\\u0022test=test\\u0022;s:5:\\u0022route\\u0022;s:4:\\u0022test\\u0022;s:7:\\u0022objects\\u0022;s:76:\\u0022{\\u0022icon\\u0022:\\u0022fa fa-test\\u0022,\\u0022redirect\\u0022:\\u0022\\u0022,\\u0022target\\u0022:\\u0022\\u0022,\\u0022place\\u0022:\\u00223\\u0022,\\u0022divider\\u0022:\\u0022true\\u0022}\\u0022;s:10:\\u0022components\\u0022;s:2:\\u0022  \\u0022;s:6:\\u0022parent\\u0022;s:0:\\u0022\\u0022;s:7:\\u0022origins\\u0022;s:4:\\u0022test\\u0022;s:6:\\u0022active\\u0022;i:1;s:5:\\u0022privs\\u0022;s:3:\\u00221,2\\u0022;s:5:\\u0022token\\u0022;s:19:\\u0022cn8derw81t3pyom9529\\u0022;s:8:\\u0022operator\\u0022;s:32:\\u00226f7c5b872213e17041c3bc35429b9d21\\u0022;}) , ID(31)\"},\"user\":{\"id_user_affected\":\"\",\"users_affected\":\"\"},\"company\":{\"id_company_affected\":\"\"},\"affected\":{\"date\":\"Jan-15-2017\",\"hour\":\"10:01:18\",\"action\":\"INSERT OR CREATE\"},\"status\":{\"rollback\":false,\"approved\":false,\"id_user_approved\":0,\"active\":false},\"sp\":{\"name\":\"NO STORED PROCEDURE \",\"params\":[]}}','2017-01-15 10:35:18'),(74,'38508ea08f748f0702699881a2b1a6ae',1,0,0,'ga_nav','{\"id_user_operator\":\"1\",\"table\":{\"table_name\":\"ga_nav\",\"affected_rows\":1,\"query\":\"INSERT GA_NAV , PARAMS(a:12:{s:4:\\u0022type\\u0022;s:8:\\u0022sub_menu\\u0022;s:4:\\u0022name\\u0022;s:35:\\u0022{\\u0022es\\u0022:\\u0022Prueba Sub\\u0022,\\u0022en\\u0022:\\u0022Test Sub\\u0022}\\u0022;s:8:\\u0022location\\u0022;s:9:\\u0022test=test\\u0022;s:5:\\u0022route\\u0022;s:4:\\u0022test\\u0022;s:7:\\u0022objects\\u0022;s:83:\\u0022{\\u0022icon\\u0022:\\u0022fa fa-test\\u0022,\\u0022redirect\\u0022:\\u0022\\u0022,\\u0022target\\u0022:\\u0022_blank\\u0022,\\u0022place\\u0022:\\u00223\\u0022,\\u0022divider\\u0022:\\u0022false\\u0022}\\u0022;s:10:\\u0022components\\u0022;s:2:\\u0022  \\u0022;s:6:\\u0022parent\\u0022;s:0:\\u0022\\u0022;s:7:\\u0022origins\\u0022;s:4:\\u0022test\\u0022;s:6:\\u0022active\\u0022;i:1;s:5:\\u0022privs\\u0022;s:1:\\u00221\\u0022;s:5:\\u0022token\\u0022;s:20:\\u00228ytrhr47glxl0k1vpldi\\u0022;s:8:\\u0022operator\\u0022;s:32:\\u002238508ea08f748f0702699881a2b1a6ae\\u0022;}) , ID(33)\"},\"user\":{\"id_user_affected\":\"\",\"users_affected\":\"\"},\"company\":{\"id_company_affected\":\"\"},\"affected\":{\"date\":\"Jan-17-2017\",\"hour\":\"22:01:28\",\"action\":\"INSERT OR CREATE\"},\"status\":{\"rollback\":false,\"approved\":false,\"id_user_approved\":0,\"active\":false},\"sp\":{\"name\":\"NO STORED PROCEDURE \",\"params\":[]}}','2017-01-17 22:15:28'),(75,'1f0e3dad99908345f7439f8ffabdffc4',1,0,0,'ga_nav','{\"id_user_operator\":\"1\",\"table\":{\"table_name\":\"ga_nav\",\"affected_rows\":true,\"query\":\"UPDATE GA_NAV , PARAMS(a:11:{s:4:\\u0022name\\u0022;s:43:\\u0022{\\u0022es\\u0022 : \\u0022Permisos\\u0022 , \\u0022en\\u0022 : \\u0022permissions\\u0022 }\\u0022;s:10:\\u0022components\\u0022;s:2:\\u0022{}\\u0022;s:7:\\u0022objects\\u0022;s:66:\\u0022{    \\u0022icon\\u0022 : \\u0022fa fa-terminal\\u0022,  \\u0022redirect\\u0022: \\u0022\\u0022,  \\u0022target\\u0022 : \\u0022\\u0022  }\\u0022;s:8:\\u0022location\\u0022;s:18:\\u0022system=permissions\\u0022;s:5:\\u0022route\\u0022;s:11:\\u0022permissions\\u0022;s:6:\\u0022parent\\u0022;s:1:\\u00225\\u0022;s:6:\\u0022active\\u0022;s:1:\\u00220\\u0022;s:4:\\u0022type\\u0022;s:7:\\u0022sidebar\\u0022;s:5:\\u0022privs\\u0022;s:1:\\u00221\\u0022;s:7:\\u0022origins\\u0022;s:6:\\u0022system\\u0022;s:5:\\u0022token\\u0022;s:0:\\u0022\\u0022;}) , ID(6)\"},\"user\":{\"id_user_affected\":\"\",\"users_affected\":\"\"},\"company\":{\"id_company_affected\":\"\"},\"affected\":{\"date\":\"Jan-17-2017\",\"hour\":\"22:01:06\",\"action\":\"UPDATE\"},\"status\":{\"rollback\":false,\"approved\":false,\"id_user_approved\":0,\"active\":false},\"sp\":{\"name\":\"NO STORED PROCEDURE \",\"params\":[]}}','2017-01-17 22:41:06'),(76,'4e732ced3463d06de0ca9a15b6153677',1,0,0,'ga_nav','{\"id_user_operator\":\"1\",\"table\":{\"table_name\":\"ga_nav\",\"affected_rows\":true,\"query\":\"UPDATE GA_NAV , PARAMS(a:11:{s:4:\\u0022name\\u0022;s:35:\\u0022{\\u0022es\\u0022:\\u0022Administrador\\u0022,\\u0022en\\u0022:\\u0022Admin\\u0022}\\u0022;s:10:\\u0022components\\u0022;s:2:\\u0022{}\\u0022;s:7:\\u0022objects\\u0022;s:52:\\u0022{    \\u0022icon\\u0022 : \\u0022\\u0022,  \\u0022redirect\\u0022: \\u0022\\u0022,  \\u0022target\\u0022 : \\u0022\\u0022  }\\u0022;s:8:\\u0022location\\u0022;s:0:\\u0022\\u0022;s:5:\\u0022route\\u0022;s:0:\\u0022\\u0022;s:6:\\u0022parent\\u0022;s:0:\\u0022\\u0022;s:6:\\u0022active\\u0022;s:1:\\u00221\\u0022;s:4:\\u0022type\\u0022;s:9:\\u0022namespace\\u0022;s:5:\\u0022privs\\u0022;s:3:\\u00221,2\\u0022;s:7:\\u0022origins\\u0022;s:0:\\u0022\\u0022;s:5:\\u0022token\\u0022;s:0:\\u0022\\u0022;}) , ID(4)\"},\"user\":{\"id_user_affected\":\"\",\"users_affected\":\"\"},\"company\":{\"id_company_affected\":\"\"},\"affected\":{\"date\":\"Jan-17-2017\",\"hour\":\"22:01:19\",\"action\":\"UPDATE\"},\"status\":{\"rollback\":false,\"approved\":false,\"id_user_approved\":0,\"active\":false},\"sp\":{\"name\":\"NO STORED PROCEDURE \",\"params\":[]}}','2017-01-17 22:50:19'),(77,'1f0e3dad99908345f7439f8ffabdffc4',1,0,0,'ga_nav','{\"id_user_operator\":\"1\",\"table\":{\"table_name\":\"ga_nav\",\"affected_rows\":true,\"query\":\"UPDATE GA_NAV , PARAMS(a:11:{s:4:\\u0022name\\u0022;s:43:\\u0022{\\u0022es\\u0022 : \\u0022Permisos\\u0022 , \\u0022en\\u0022 : \\u0022permissions\\u0022 }\\u0022;s:10:\\u0022components\\u0022;s:2:\\u0022{}\\u0022;s:7:\\u0022objects\\u0022;s:66:\\u0022{    \\u0022icon\\u0022 : \\u0022fa fa-terminal\\u0022,  \\u0022redirect\\u0022: \\u0022\\u0022,  \\u0022target\\u0022 : \\u0022\\u0022  }\\u0022;s:8:\\u0022location\\u0022;s:18:\\u0022system=permissions\\u0022;s:5:\\u0022route\\u0022;s:11:\\u0022permissions\\u0022;s:6:\\u0022parent\\u0022;s:1:\\u00225\\u0022;s:6:\\u0022active\\u0022;s:1:\\u00221\\u0022;s:4:\\u0022type\\u0022;s:7:\\u0022sidebar\\u0022;s:5:\\u0022privs\\u0022;s:1:\\u00221\\u0022;s:7:\\u0022origins\\u0022;s:6:\\u0022system\\u0022;s:5:\\u0022token\\u0022;s:0:\\u0022\\u0022;}) , ID(6)\"},\"user\":{\"id_user_affected\":\"\",\"users_affected\":\"\"},\"company\":{\"id_company_affected\":\"\"},\"affected\":{\"date\":\"Jan-17-2017\",\"hour\":\"23:01:09\",\"action\":\"UPDATE\"},\"status\":{\"rollback\":false,\"approved\":false,\"id_user_approved\":0,\"active\":false},\"sp\":{\"name\":\"NO STORED PROCEDURE \",\"params\":[]}}','2017-01-17 23:03:09'),(78,'c16a5320fa475530d9583c34fd356ef5',1,0,0,'ga_nav','{\"id_user_operator\":\"1\",\"table\":{\"table_name\":\"ga_nav\",\"affected_rows\":1,\"query\":\"DELETE GA_NAV , PARAMS(a:1:{s:2:\\u0022id\\u0022;s:2:\\u002233\\u0022;}) , ID(33)\"},\"user\":{\"id_user_affected\":\"\",\"users_affected\":\"\"},\"company\":{\"id_company_affected\":\"\"},\"affected\":{\"date\":\"Feb-01-2017\",\"hour\":\"19:02:10\",\"action\":\"UPDATE\"},\"status\":{\"rollback\":false,\"approved\":false,\"id_user_approved\":0,\"active\":false},\"sp\":{\"name\":\"NO STORED PROCEDURE \",\"params\":[]}}','2017-02-01 19:59:10');
/*!40000 ALTER TABLE `ga_operator_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ga_pages`
--

DROP TABLE IF EXISTS `ga_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ga_pages` (
  `id_page` int(11) NOT NULL,
  `id_user` int(11) DEFAULT '0',
  `id_rol` int(11) DEFAULT '0',
  `id_meta` int(11) DEFAULT '0',
  `name` varchar(50) NOT NULL,
  `description` varchar(50) NOT NULL,
  `url` varchar(250) NOT NULL,
  `content` mediumtext,
  `activate` int(11) DEFAULT '1',
  `create_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `modify_date` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_page`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ga_pages`
--

LOCK TABLES `ga_pages` WRITE;
/*!40000 ALTER TABLE `ga_pages` DISABLE KEYS */;
/*!40000 ALTER TABLE `ga_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ga_rols`
--

DROP TABLE IF EXISTS `ga_rols`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ga_rols` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `meta` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COMMENT='la tabla de rols es la mas sencilla solo especificamos un nombre al rol \r\ntalves algun meta agregado a ello pero nada mas ';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ga_rols`
--

LOCK TABLES `ga_rols` WRITE;
/*!40000 ALTER TABLE `ga_rols` DISABLE KEYS */;
INSERT INTO `ga_rols` VALUES (1,'administrator',NULL),(2,'guess',NULL),(3,'user',NULL);
/*!40000 ALTER TABLE `ga_rols` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ga_sessions`
--

DROP TABLE IF EXISTS `ga_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ga_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ga_sessions`
--

LOCK TABLES `ga_sessions` WRITE;
/*!40000 ALTER TABLE `ga_sessions` DISABLE KEYS */;
INSERT INTO `ga_sessions` VALUES ('b7a604706ed14a9c103bbe3fda017dcf68696e72','::1',1485998005,'__ci_last_regenerate|i:1485998005;lang|s:2:\"es\";user_meta|O:8:\"stdClass\":1:{s:9:\"user_type\";s:0:\"\";}'),('0e641b58058ea2bd44117afc7e6b6026b6523572','::1',1485998306,'__ci_last_regenerate|i:1485998306;lang|s:2:\"es\";user_meta|O:8:\"stdClass\":1:{s:9:\"user_type\";s:0:\"\";}'),('050a8a300f7427b6584559c6aa096f2de9ff746e','::1',1485998674,'__ci_last_regenerate|i:1485998674;lang|s:2:\"es\";user_meta|O:8:\"stdClass\":1:{s:9:\"user_type\";s:0:\"\";}'),('ad683ca47a129cfbc9846004f12b423196632a40','::1',1485999500,'__ci_last_regenerate|i:1485999500;lang|s:2:\"es\";user_meta|O:8:\"stdClass\":1:{s:9:\"user_type\";s:0:\"\";}'),('334fa68f0590fc44e5783d346fcaad0db436c66e','::1',1485999970,'__ci_last_regenerate|i:1485999970;lang|s:2:\"es\";user_meta|O:8:\"stdClass\":1:{s:9:\"user_type\";s:2:\"-A\";}user|O:8:\"stdClass\":9:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:5:\"admin\";s:12:\"last_connect\";s:19:\"2017-01-31 21:20:11\";s:6:\"active\";s:1:\"1\";s:4:\"data\";O:8:\"stdClass\":2:{s:7:\"details\";O:8:\"stdClass\":7:{s:4:\"name\";s:15:\"Rolando Antonio\";s:9:\"last_name\";s:17:\"Arriaza Marroquin\";s:8:\"register\";s:10:\"2016-06-19\";s:6:\"avatar\";s:30:\"Sf1xP7DQ-avatar-smartwater.png\";s:10:\"occupation\";s:39:\"Ingeniero en ciencias de la computacion\";s:8:\"location\";s:11:\"El Salvador\";s:7:\"website\";s:22:\"www.rolandoarriaza.com\";}s:14:\"last_passwords\";O:8:\"stdClass\":0:{}}s:5:\"privs\";O:8:\"stdClass\":2:{s:6:\"parent\";s:1:\"1\";s:6:\"childs\";s:3:\"2,3\";}s:5:\"email\";s:19:\"rolignu90@gmail.com\";s:2:\"id\";s:1:\"1\";s:4:\"lang\";s:2:\"es\";}'),('2f096081bd2c1834d6bf83c3fb2d27296503815e','::1',1486000703,'__ci_last_regenerate|i:1486000703;lang|s:2:\"es\";user_meta|O:8:\"stdClass\":1:{s:9:\"user_type\";s:0:\"\";}'),('d224b29014a10e29b40935ee3445679a23918358','::1',1486000900,'lang|s:2:\"es\";'),('6702e3346c6cab0467b2b05360545f095d139f03','::1',1486000900,'__ci_last_regenerate|i:1486000900;lang|s:2:\"es\";user_meta|O:8:\"stdClass\":1:{s:9:\"user_type\";s:0:\"\";}');
/*!40000 ALTER TABLE `ga_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ga_user`
--

DROP TABLE IF EXISTS `ga_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ga_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_operator` varchar(50) DEFAULT NULL,
  `username` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` text NOT NULL,
  `data` text,
  `privileges` text,
  `last_connect` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `active` int(2) DEFAULT NULL,
  `connected` int(2) DEFAULT NULL,
  `user_type` varchar(5) DEFAULT '-U',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='Garrobo CMS base de datos del usuario , se definieron estas bases de datos \r\nde una forma en la que la experciendia sea ,ucho mejor. en palabras mas \r\ncristianas la base de datos debe de responder de forma rapida.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ga_user`
--

LOCK TABLES `ga_user` WRITE;
/*!40000 ALTER TABLE `ga_user` DISABLE KEYS */;
INSERT INTO `ga_user` VALUES (1,'ABCD','admin','rolignu90@gmail.com','7d7ff17eb8d7eb50d4e04c7ff096b291c0cdfa64a5d33d2ac5ef6fb253062d8ef29d7e82305db6df84f3f128bd415e9552131cfe488251c21e43c0aecf990fe0hBHnjDJeHG9ClaLf97Vc0KRyt/mC','{\"details\":{\"name\":\"Rolando Antonio\",\"last_name\":\"Arriaza Marroquin\",\"register\":\"2016-06-19\",\"avatar\":\"Sf1xP7DQ-avatar-smartwater.png\",\"occupation\":\"Ingeniero en ciencias de la computacion\",\"location\":\"El Salvador\",\"website\":\"www.rolandoarriaza.com\"},\"last_passwords\":{}}','{\n\n    \"parent\" : \"1\",\n    \"childs\" : \"2,3\"\n  \n}','2017-01-31 21:20:11',1,1,'-A'),(2,'DEF','guess','rolignu90@gmail.com','7d7ff17eb8d7eb50d4e04c7ff096b291c0cdfa64a5d33d2ac5ef6fb253062d8ef29d7e82305db6df84f3f128bd415e9552131cfe488251c21e43c0aecf990fe0hBHnjDJeHG9ClaLf97Vc0KRyt/mC','{\"details\":{\"name\":\"Invitado Antonio\",\"last_name\":\"Arriaza Marroquin\",\"register\":\"2016-06-19\",\"avatar\":\"bIy6ZCc8-avatar-tetas-putas-desmotivaciones.jpg\",\"occupation\":\"Ingeniero en sistemas\",\"location\":\"El salvador\",\"website\":\"www.rolandoarriaza.com\"},\"last_passwords\":[\"admin\",\"admin\",\"admin\",\"admin\",\"admin\",\"linux90\"]}','{\n\n    \"parent\" : \"2\",\n    \"childs\" : \"\"\n  \n}','2016-12-12 14:47:27',1,1,'-U');
/*!40000 ALTER TABLE `ga_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ga_user_type`
--

DROP TABLE IF EXISTS `ga_user_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ga_user_type` (
  `id_type` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(4) NOT NULL DEFAULT 'U',
  `properties` int(2) DEFAULT NULL,
  `id_operator` varchar(255) DEFAULT '0',
  `create_date` datetime NOT NULL,
  `mod_date` datetime NOT NULL,
  `comment` varchar(150) DEFAULT NULL,
  `label` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id_type`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COMMENT='user_type : es una tabla para crear los tipos de usuario ya que mytrip [codename]\r\nse generara un tipo de usuario para entrada a los diversos sistemas como usuarios iniciales \r\nseran los siguientes :\r\n\r\n                            -U = usuario , persona de tipo natural \r\n                           -S = sales o vendedor , persona que verifica administracion de ventas\r\n                          -C = company o compañia  , si el usuario no persona natural sino un ente empresarial \r\n                         - UC = usuario y compañia , cuando la cuenta esta ligada a un usuario y a una compañia en especifico , claro si se puede \r\n                        -A = admin , tipo de usuario administrativo \r\n                        -M = moderador , el moderador se encarga de velar que los usuarios sigan con el protocolo del sistem\r\n\r\ntype = tipo de usuario que se agrega \r\nproperties = propiedades basicas \r\nuser_modify = que usuario agrego o modifico este tipo de usuario \r\ncreate_date = fecha que se crea el tipo de usuario \r\nmod_date = fecha de modificacion de este tipo de usuario ';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ga_user_type`
--

LOCK TABLES `ga_user_type` WRITE;
/*!40000 ALTER TABLE `ga_user_type` DISABLE KEYS */;
INSERT INTO `ga_user_type` VALUES (1,'-U',1,'1','2016-11-07 20:30:18','2016-11-07 20:30:18','usuario , persona de tipo natural ','Usuario/User'),(2,'-S',1,'1','2016-11-07 20:30:18','2016-11-07 20:30:18','sales o vendedor , persona que verifica administracion de ventas','Vendedor/Sales'),(3,'-C',1,'1','2016-11-07 20:30:18','2016-11-07 20:30:18','company o compañia  , si el usuario no persona natural sino un ente empresarial ','Compañia/Company'),(4,'-UC',1,'1','2016-11-07 20:30:18','2016-11-07 20:30:18',' usuario y compañia , cuando la cuenta esta ligada a un usuario y a una compañia en especifico , claro si se puede ','Usuario tipo compañia / Company user type'),(5,'-A',0,'1','2016-11-07 20:30:18','2016-11-07 20:30:18',' admin , tipo de usuario administrativo ','Administrador/Admin'),(6,'-M',1,'1','2016-11-07 20:30:18','2016-11-07 20:30:18',' moderador , el moderador se encarga de velar que los usuarios sigan con el protocolo del sistema ','Moderador/Moderator');
/*!40000 ALTER TABLE `ga_user_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'scada'
--
/*!50003 DROP PROCEDURE IF EXISTS `sp_dump_data` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_dump_data`(IN  i_token VARCHAR(255),IN i_user INT(11) , IN i_type VARCHAR(5) )
BEGIN 


  

	declare i_exist INT(11);
	SELECT COUNT(i.token) INTO i_exist  FROM ga_dump AS i WHERE i.token LIKE i_token;

	IF(i_type = 'C') THEN
	
				IF (i_exist > 0) THEN 
					DELETE FROM ga_dump  WHERE ga_dump.token LIKE i_token;
				END IF;
	
				IF(ROW_COUNT() > 0 ) THEN 
	
				INSERT INTO ga_dump (ga_dump.token , ga_dump.user_id , ga_dump.expired) 
						VALUES (i_token , i_user , DATE_ADD(NOW(), INTERVAL 3 MINUTE));
				END IF;
	
			
	ELSEIF (i_type = 'D') THEN
	
			DELETE FROM ga_dump WHERE ga_dump.token LIKE i_token;
	
	ELSEIF (i_type = 'DL') THEN 
	
			DELETE FROM ga_dump WHERE ga_dump.token = i_token AND ga_dump.user_id = i_user;
			
	ELSEIF (i_type = 'CM') THEN 
	
			SELECT count(*) as 'count' FROM ga_dump WHERE ga_dump.token LIKE i_token;
	 
	END IF;

			IF NOT (i_type = 'CM') THEN 
					SELECT ROW_COUNT() as 'return';
			END IF;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_operator` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_operator`(
IN e_type					VARCHAR(3),
IN i_op_type				VARCHAR(4),
IN i_id_operator 			VARCHAR(255),
IN i_id_user 				INT(11),
IN i_affected_table 		VARCHAR(100),
IN i_id_company			INT(11),
IN i_log						TEXT ,
IN e_id_op_log				INT(11)
)
BEGIN 




  
 
 
 declare id_op_exist varchar(255);
 declare operator_key varchar(255);
 declare operator_key_status bool ;
 
 set operator_key = MD5(FLOOR( 1 + RAND( ) *60 ));
 set id_op_exist = NULL;
 set operator_key_status = false;
 
 
 
 
 IF (e_type = 'C') THEN 
 
 		IF(i_id_operator != NULL OR i_id_operator != '') THEN 
 				SET operator_key = i_id_operator;
 				SET operator_key_status = true;
 		END IF;
 
 		INSERT INTO ga_operator_log 
		 (		  ga_operator_log.id_operator
		 		, ga_operator_log.id_user 
				, ga_operator_log.operator_type 
				, ga_operator_log.id_company 
				, ga_operator_log.affected_table
				, ga_operator_log.log ) 
		VALUES (     operator_key
						, i_id_user 
						, i_op_type 
						, i_id_company 
						, i_affected_table , i_log );
						
		IF(operator_key_status = true) THEN 
			SELECT ROW_COUNT() as 'count';
		ELSE 
			SELECT operator_key as 'key_returned';
		END IF ;
		
		
 ELSEIF (e_type = 'UL') THEN 
 
 		UPDATE ga_operator_log SET ga_operator_log.log = i_log
 		WHERE ga_operator_log.id_op_log = e_id_op_log;
 		
 		SELECT ROW_COUNT() as 'count';

 ELSEIF (e_type = 'S') THEN 
 		
 		SELECT * FROM ga_operator_log WHERE ga_operator_log.id_operator = i_id_operator;
  
 				
 END IF;
 
		
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-02-01 20:49:55
