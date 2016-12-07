-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         5.7.14 - MySQL Community Server (GPL)
-- SO del servidor:              Win64
-- HeidiSQL Versión:             9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Volcando estructura para tabla mytrip.ga_company
CREATE TABLE IF NOT EXISTS `ga_company` (
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

-- Volcando datos para la tabla mytrip.ga_company: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `ga_company` DISABLE KEYS */;
/*!40000 ALTER TABLE `ga_company` ENABLE KEYS */;


-- Volcando estructura para tabla mytrip.ga_company_type
CREATE TABLE IF NOT EXISTS `ga_company_type` (
  `id_company_type` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `create_date` date NOT NULL,
  `id_operator` varchar(255) NOT NULL,
  PRIMARY KEY (`id_company_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COMMENT='que tipo de compañia es , publica privada , etc\r\n';

-- Volcando datos para la tabla mytrip.ga_company_type: 0 rows
/*!40000 ALTER TABLE `ga_company_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `ga_company_type` ENABLE KEYS */;


-- Volcando estructura para tabla mytrip.ga_company_users
CREATE TABLE IF NOT EXISTS `ga_company_users` (
  `id_company_users` int(11) NOT NULL AUTO_INCREMENT,
  `id_company` int(11) NOT NULL DEFAULT '0',
  `id_user` int(11) NOT NULL DEFAULT '0',
  `id_operator` varchar(255) DEFAULT '0',
  `create_date` date NOT NULL DEFAULT '0000-00-00',
  `finally_date` date DEFAULT NULL,
  `active` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`id_company_users`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COMMENT='Tabla de usuarios que pueden acceder a la compañia';

-- Volcando datos para la tabla mytrip.ga_company_users: 0 rows
/*!40000 ALTER TABLE `ga_company_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `ga_company_users` ENABLE KEYS */;


-- Volcando estructura para tabla mytrip.ga_countrys
CREATE TABLE IF NOT EXISTS `ga_countrys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iso` varchar(5) NOT NULL,
  `name` varchar(100) NOT NULL,
  `id_operator` varchar(255) DEFAULT NULL,
  `active` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COMMENT='Tabla en la cual se guardan los paises aceptados por el sistema';

-- Volcando datos para la tabla mytrip.ga_countrys: 4 rows
/*!40000 ALTER TABLE `ga_countrys` DISABLE KEYS */;
INSERT INTO `ga_countrys` (`id`, `iso`, `name`, `id_operator`, `active`) VALUES
	(9, 'SV', 'El Salvador', '182be0c5cdcd5072bb1864cdee4d3d6e', 1),
	(10, 'GT', 'Guatemala', 'a87ff679a2f3e71d9181a67b7542122c', 1),
	(11, 'CR', 'Costa Rica', 'a5771bce93e200c36f7cd9dfd0e5deaa', 1),
	(12, 'HN', 'Honduras', '66f041e16a60928b05a7e228a89c3799', 1);
/*!40000 ALTER TABLE `ga_countrys` ENABLE KEYS */;


-- Volcando estructura para tabla mytrip.ga_dump
CREATE TABLE IF NOT EXISTS `ga_dump` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(255) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `expired` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla mytrip.ga_dump: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `ga_dump` DISABLE KEYS */;
/*!40000 ALTER TABLE `ga_dump` ENABLE KEYS */;


-- Volcando estructura para tabla mytrip.ga_metadata
CREATE TABLE IF NOT EXISTS `ga_metadata` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(50) NOT NULL,
  `value` longtext,
  `id_user` int(10) unsigned DEFAULT '0',
  `id_rol` int(10) unsigned DEFAULT '0',
  `type` varchar(3) DEFAULT 'S',
  `label` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=152 DEFAULT CHARSET=latin1 COMMENT='metadata es una tabla en la cual sus valores no son estaticos , eso quiere decir que la tabla\r\nno es uso especifico asi que solo tiene unos pares de campos y la mayoria se trabajara\r\ncon variables o con cadenas cuyo patrones estan definidos aplica con JSON y XML';

-- Volcando datos para la tabla mytrip.ga_metadata: 11 rows
/*!40000 ALTER TABLE `ga_metadata` DISABLE KEYS */;
INSERT INTO `ga_metadata` (`id`, `key`, `value`, `id_user`, `id_rol`, `type`, `label`) VALUES
	(123, 'smtp_protocol', 'smtp', NULL, NULL, 'S', NULL),
	(124, 'smtp_host', 'localhost', NULL, NULL, 'S', NULL),
	(125, 'smtp_port', '465', NULL, NULL, 'S', NULL),
	(126, 'smtp_timeout', '10', NULL, NULL, 'S', NULL),
	(127, 'smtp_user', 'root', NULL, NULL, 'S', NULL),
	(128, 'smtp_pass', '', NULL, NULL, 'S', NULL),
	(129, 'smtp_status', '0', NULL, NULL, 'S', NULL),
	(130, 'user_lang', 'en', 1, 0, 'S', NULL),
	(149, 'log_file', '[{"id":"bbff6ffefabb522e3be225da17ca4d9b","data":"[START SESSION][SYSTEM]  Start Session on Sun, 06 Nov 16 22:31:40 -0600","date":"Sun, 06 Nov 2016 22:31:40 -0600"},{"id":"15ed2332fb79e90e7c21991ea03d061c","data":"[START SESSION][SYSTEM]  Start Session on Sun, 06 Nov 16 22:31:41 -0600","date":"Sun, 06 Nov 2016 22:31:41 -0600"},{"id":"d3856399086cce37b05935fc6bbd57aa","data":"[START SESSION][SYSTEM]  Start Session on Sun, 06 Nov 16 22:31:42 -0600","date":"Sun, 06 Nov 2016 22:31:42 -0600"},{"id":"89883d84c4c026685bdd401ae424cfde","data":"[START SESSION][SYSTEM]  Start Session on Mon, 07 Nov 16 20:21:57 -0600","date":"Mon, 07 Nov 2016 20:21:57 -0600"},{"id":"714fa28725859dc409f3e7dea155a6c4","data":"[End Session][SYSTEM] Rolando Antonio has cerrado sesion la fecha de Mon, 07 Nov 16 21:26:38 -0600","date":"Mon, 07 Nov 2016 21:26:38 -0600"},{"id":"a01c3cceee6f3e450797baf108df911c","data":"[START SESSION][SYSTEM]  Start Session on Mon, 07 Nov 16 21:26:43 -0600","date":"Mon, 07 Nov 2016 21:26:43 -0600"},{"id":"5bc23d60609c9c9f283af0cd8cdafa3d","data":"[End Session][SYSTEM] Rolando Antonio has cerrado sesion la fecha de Mon, 07 Nov 16 21:37:16 -0600","date":"Mon, 07 Nov 2016 21:37:16 -0600"},{"id":"952586ffd268fd649307477edcc6c7e4","data":"[START SESSION][SYSTEM]  Start Session on Mon, 07 Nov 16 21:57:58 -0600","date":"Mon, 07 Nov 2016 21:57:58 -0600"},{"id":"4de7f020d36d7b9dabd3880a6b52e877","data":"[End Session][SYSTEM] Rolando Antonio has cerrado sesion la fecha de Mon, 07 Nov 16 21:59:02 -0600","date":"Mon, 07 Nov 2016 21:59:02 -0600"},{"id":"c6edd06fe6f7d12cf765ab278ac9b98c","data":"[START SESSION][SYSTEM]  Start Session on Tue, 08 Nov 16 20:52:10 -0600","date":"Tue, 08 Nov 2016 20:52:10 -0600"},{"id":"7cec564afb281321de604aed1110de25","data":"[START SESSION][SYSTEM]  Start Session on Thu, 17 Nov 16 20:00:20 -0600","date":"Thu, 17 Nov 2016 20:00:20 -0600"},{"id":"8222ebb602824852d9e41f6ec6f0369e","data":"[START SESSION][SYSTEM]  Start Session on Fri, 18 Nov 16 18:48:28 -0600","date":"Fri, 18 Nov 2016 18:48:28 -0600"},{"id":"908a49dcd24b6a722ce4a7eb6422ada9","data":"[START SESSION][SYSTEM]  Start Session on Sat, 19 Nov 16 16:35:58 -0600","date":"Sat, 19 Nov 2016 16:35:58 -0600"},{"id":"7d5bbe68239f59c1fd7c2dd517113f7a","data":"[START SESSION][SYSTEM]  Start Session on Sat, 19 Nov 16 17:14:43 -0600","date":"Sat, 19 Nov 2016 17:14:43 -0600"},{"id":"bbd0db5bfdadccb6e76d25d566ea321a","data":"[START SESSION][SYSTEM]  Start Session on Sun, 20 Nov 16 10:38:03 -0600","date":"Sun, 20 Nov 2016 10:38:03 -0600"},{"id":"1f0876e508410cd33c94e9a5ff478d49","data":"[End Session][SYSTEM] Rolando Antonio has cerrado sesion la fecha de Sun, 20 Nov 16 15:10:53 -0600","date":"Sun, 20 Nov 2016 15:10:53 -0600"},{"id":"7c27cbf03bad686928a27f9697f7811a","data":"[START SESSION][SYSTEM]  Start Session on Sun, 20 Nov 16 15:11:05 -0600","date":"Sun, 20 Nov 2016 15:11:05 -0600"},{"id":"4a4e352ebe89ba97f6501fce0c3bb0a0","data":"[End Session][SYSTEM] Rolando Antonio has cerrado sesion la fecha de Sun, 20 Nov 16 15:11:38 -0600","date":"Sun, 20 Nov 2016 15:11:38 -0600"},{"id":"4ff7d9ced1cecec816a1cb701df50731","data":"[START SESSION][SYSTEM]  Start Session on Sun, 20 Nov 16 15:11:41 -0600","date":"Sun, 20 Nov 2016 15:11:41 -0600"},{"id":"845ebba1b6491bd0e910d913e403dec1","data":"[START SESSION][SYSTEM]  Start Session on Sun, 20 Nov 16 15:14:36 -0600","date":"Sun, 20 Nov 2016 15:14:36 -0600"},{"id":"33f72df1a4091858e89d00702386adde","data":"[START SESSION][SYSTEM]  Start Session on Sun, 20 Nov 16 15:14:36 -0600","date":"Sun, 20 Nov 2016 15:14:36 -0600"},{"id":"7d40e92b806a53da290c6a0a1ebeed69","data":"[START SESSION][SYSTEM]  Start Session on Wed, 23 Nov 16 18:53:06 -0600","date":"Wed, 23 Nov 2016 18:53:06 -0600"},{"id":"14c8fc49c881024bf9c9a9b0c634aeab","data":"[End Session][SYSTEM] Rolando Antonio has cerrado sesion la fecha de Wed, 23 Nov 16 18:55:09 -0600","date":"Wed, 23 Nov 2016 18:55:09 -0600"},{"id":"23a110416f030a6b98334b0b351983e6","data":"[START SESSION][SYSTEM]  Start Session on Wed, 23 Nov 16 18:56:12 -0600","date":"Wed, 23 Nov 2016 18:56:12 -0600"},{"id":"d3e6d888efa795717d0b60d0039f541c","data":"[START SESSION][SYSTEM]  Start Session on Wed, 23 Nov 16 18:59:08 -0600","date":"Wed, 23 Nov 2016 18:59:08 -0600"},{"id":"cdbb5cac12b69fe043d988216b21b405","data":"[End Session][SYSTEM] Rolando Antonio has cerrado sesion la fecha de Wed, 23 Nov 16 19:07:00 -0600","date":"Wed, 23 Nov 2016 19:07:00 -0600"},{"id":"c5ce63923413e76ec0617583aa7633f8","data":"[START SESSION][SYSTEM]  Start Session on Wed, 23 Nov 16 19:07:15 -0600","date":"Wed, 23 Nov 2016 19:07:15 -0600"},{"id":"3c4aa08bf9726e0c1d2b1d9ee22d298f","data":"[START SESSION][SYSTEM]  Start Session on Wed, 23 Nov 16 19:43:35 -0600","date":"Wed, 23 Nov 2016 19:43:35 -0600"},{"id":"afaf2788be58737abecd9d19f31d027d","data":"[End Session][SYSTEM] Rolando Antonio has cerrado sesion la fecha de Wed, 23 Nov 16 19:43:43 -0600","date":"Wed, 23 Nov 2016 19:43:43 -0600"},{"id":"f8972a723cd4f09a9958eeabf3ec9495","data":"[START SESSION][SYSTEM]  Start Session on Wed, 23 Nov 16 19:45:27 -0600","date":"Wed, 23 Nov 2016 19:45:27 -0600"},{"id":"8e41fbf5be0b602d3616703d0a68a03e","data":"[START SESSION][SYSTEM]  Start Session on Wed, 23 Nov 16 21:55:02 -0600","date":"Wed, 23 Nov 2016 21:55:02 -0600"},{"id":"05fb09bc4c512b69a6f1ce2a679b99da","data":"[START SESSION][SYSTEM]  Start Session on Thu, 24 Nov 16 18:27:31 -0600","date":"Thu, 24 Nov 2016 18:27:31 -0600"},{"id":"ce24e44782d46e4c1e21a57e36fd4046","data":"[START SESSION][SYSTEM]  Start Session on Fri, 25 Nov 16 17:46:48 -0600","date":"Fri, 25 Nov 2016 17:46:48 -0600"},{"id":"34ac5704624f9f16be836da843c5c7b7","data":"[START SESSION][SYSTEM]  Start Session on Sat, 26 Nov 16 09:37:06 -0600","date":"Sat, 26 Nov 2016 09:37:06 -0600"},{"id":"c2dac8a732f72fa84fad8368d5cfc37d","data":"[START SESSION][SYSTEM]  Start Session on Sun, 27 Nov 16 10:25:37 -0600","date":"Sun, 27 Nov 2016 10:25:37 -0600"}]', 1, 0, 'S', NULL),
	(150, 'log_file', '[{"id":"94af46837c1ce6fc2ee4015cc5590e2e","data":"[End Session][SYSTEM]  has cerrado sesion la fecha de Wed, 23 Nov 16 19:43:28 -0600","date":"Wed, 23 Nov 2016 19:43:28 -0600"}]', NULL, 0, 'S', NULL),
	(151, 'log_file', '[{"id":"94af46837c1ce6fc2ee4015cc5590e2e","data":"[End Session][SYSTEM]  has cerrado sesion la fecha de Wed, 23 Nov 16 19:43:28 -0600","date":"Wed, 23 Nov 2016 19:43:28 -0600"}]', NULL, 0, 'S', NULL);
/*!40000 ALTER TABLE `ga_metadata` ENABLE KEYS */;


-- Volcando estructura para tabla mytrip.ga_nav
CREATE TABLE IF NOT EXISTS `ga_nav` (
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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=latin1 COMMENT='navbar version 1.0 ';

-- Volcando datos para la tabla mytrip.ga_nav: 13 rows
/*!40000 ALTER TABLE `ga_nav` DISABLE KEYS */;
INSERT INTO `ga_nav` (`id`, `type`, `name`, `location`, `route`, `objects`, `components`, `parent`, `origins`, `active`, `privs`, `token`) VALUES
	(1, 'namespace', '{ "es" : "Menu" , "en" : "Menu"}', NULL, NULL, '{\n  \n  "icon" : "",\n  "redirect": "",\n  "target" : ""\n  \n}', '{}', '0', 'system', 1, '0', NULL),
	(2, 'sidebar', '{"es": "Inicio" , "en" : "Home" }', '', NULL, '{\r\n  \r\n  "icon" : "fa fa-home",\r\n  "redirect": "",\r\n  "target" : ""\r\n  \r\n}', '{\r\n\r\n   "alerts " : "true" \r\n}', '1', 'system', 1, '0', NULL),
	(3, 'section', 'Menu', '', NULL, '{\r\n  \r\n  "icon" : "",\r\n  "redirect": "",\r\n  "target" : ""\r\n  \r\n}', '{}', '1', 'system', 0, '0', NULL),
	(4, 'namespace', '{"es": "Administrador" , "en" : "Admin"}', NULL, NULL, '{\r\n  \r\n  "icon" : "",\r\n  "redirect": "",\r\n  "target" : ""\r\n  \r\n}', '{}', '0', 'system', 1, '1,2', NULL),
	(5, 'section', '{"es": "Usuarios" , "en" : "Users" }', NULL, NULL, '{\r\n  \r\n  "icon" : "fa fa-users",\r\n  "redirect": "",\r\n  "target" : ""\r\n  \r\n}', '{}', '4', 'system', 1, '1,2', NULL),
	(6, 'sidebar', '{"es" : "Permisos" , "en" : "permissions" }', 'system=permissions', 'permissions', '{\r\n  \r\n  "icon" : "fa fa-terminal",\r\n  "redirect": "",\r\n  "target" : ""\r\n  \r\n}', '{}', '5', 'system', 1, '1', NULL),
	(8, 'sub_menu', '{"es": "Mi perfil " , "en" : "My Profile"}', 'profile=profile', 'profile', '{\r\n  \r\n  "icon" : "icon-user",\r\n  "redirect": "",\r\n  "target" : "",\r\n "place" : "1",\r\n "divider" : "true"\r\n  \r\n}', '{}', '0', 'system', 1, '0', NULL),
	(9, 'sub_menu', '{"es": "Cerrar Sesión" , "en" : "Close Session" }', 'system=end_session', 'end_session', '{\r\n  \r\n  "icon" : "icon-key",\r\n  "redirect": "",\r\n  "target" : "",\r\n  "place" : "1"\r\n  \r\n}', '{}', '0', 'system', 1, '0', NULL),
	(10, 'sidebar', '{"es" : "Perfil" , "en" : "Profile"}', 'profile=profile', 'profile', '{\r\n  \r\n  "icon" : "icon-user",\r\n  "redirect": "",\r\n  "target" : "",\r\n "place" : "1",\r\n "divider" : "true"\r\n  \r\n}', '{}', '5', 'system', 1, '0', NULL),
	(13, 'section', '{"es": "Sistema" , "en" : "System" }', NULL, NULL, '{\r\n  \r\n  "icon" : "fa fa-cog",\r\n  "redirect": "",\r\n  "target" : ""\r\n  \r\n}', '{}', '4', 'system', 1, '1', NULL),
	(14, 'sidebar', '{"es" : "Constantes" , "en" : "Constants" }', 'system=constants', 'system_constants', '{\r\n  \r\n  "icon" : "fa fa-pencil",\r\n  "redirect": "",\r\n  "target" : "",\r\n "place" : "1",\r\n "divider" : "true"\r\n  \r\n}', '{}', '13', 'system', 1, '1', NULL),
	(15, 'sidebar', '{"es" : "Estado" , "en" : "Status" }', 'system=system_status', 'system_status', '{\r\n  \r\n  "icon" : "fa fa-code",\r\n  "redirect": "",\r\n  "target" : "",\r\n "place" : "2",\r\n "divider" : "true"\r\n  \r\n}', '{}', '13', 'system', 1, '1', NULL),
	(16, 'sidebar', '{"es" : "Configuracion Correo" , "en" : "Email config"}', 'system=email', 'email_config', '{\r\n  \r\n  "icon" : "fa fa-envelope",\r\n  "redirect": "",\r\n  "target" : "",\r\n "place" : "2",\r\n "divider" : "true"\r\n  \r\n}', '{}', '13', 'system', 1, '1', NULL),
	(23, 'sidebar', '{ "es" : "Navegacion" , "en" : "Navigation"}', 'system=navigator', 'nav', '{\r\n  \r\n  "icon" : "fa fa-bars",\r\n  "redirect": "",\r\n  "target" : "",\r\n "place" : "4",\r\n "divider" : "true"\r\n  \r\n}', '{}', '13', 'system', 1, '1', '');
/*!40000 ALTER TABLE `ga_nav` ENABLE KEYS */;


-- Volcando estructura para tabla mytrip.ga_notify
CREATE TABLE IF NOT EXISTS `ga_notify` (
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

-- Volcando datos para la tabla mytrip.ga_notify: 0 rows
/*!40000 ALTER TABLE `ga_notify` DISABLE KEYS */;
/*!40000 ALTER TABLE `ga_notify` ENABLE KEYS */;


-- Volcando estructura para tabla mytrip.ga_operator_log
CREATE TABLE IF NOT EXISTS `ga_operator_log` (
  `id_op_log` int(11) NOT NULL AUTO_INCREMENT,
  `id_operator` varchar(255) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `operator_type` int(11) DEFAULT NULL,
  `id_company` int(11) DEFAULT NULL,
  `affected_table` varchar(100) DEFAULT NULL,
  `log` text,
  PRIMARY KEY (`id_op_log`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COMMENT='Tabla de operadores en cuestion de manipulacion del sistema\r\n\r\nesta tabla realiza un log o bitacora de las manipulaciones del sistema por medio del operador\r\nclaro esta se necesitara saber \r\nla tabla afectada\r\n\r\nid_operator = se genera este id automaticamente para un filter\r\ncampo log = archivo json la cual tendra la configuracion de la manipulacion \r\nid_user = usuario que se ve afectado \r\n';

-- Volcando datos para la tabla mytrip.ga_operator_log: 0 rows
/*!40000 ALTER TABLE `ga_operator_log` DISABLE KEYS */;
INSERT INTO `ga_operator_log` (`id_op_log`, `id_operator`, `id_user`, `operator_type`, `id_company`, `affected_table`, `log`) VALUES
	(7, '072b030ba126b2f4b2374f342be9ed44', 1, 0, 0, '', '{"id_user_operator":"","table":{"table_name":"","affected_rows":"","query":""},"user":{"id_user_affected":"","users_affected":""},"company":{"id_company_affected":""},"affected":{"date":"Nov-25-2016","hour":"21:11:29","action":""},"status":{"rollback":false,"approved":true,"id_user_approved":0,"active":false},"sp":{"name":"","params":[]}}'),
	(8, '642e92efb79421734881b53e1e1b18b6', 1, 0, 0, '', '{"id_user_operator":"1","table":{"table_name":"","affected_rows":"","query":""},"user":{"id_user_affected":"","users_affected":""},"company":{"id_company_affected":""},"affected":{"date":"Nov-25-2016","hour":"21:11:32","action":""},"status":{"rollback":false,"approved":true,"id_user_approved":0,"active":false},"sp":{"name":"","params":[]}}');
/*!40000 ALTER TABLE `ga_operator_log` ENABLE KEYS */;


-- Volcando estructura para tabla mytrip.ga_pages
CREATE TABLE IF NOT EXISTS `ga_pages` (
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

-- Volcando datos para la tabla mytrip.ga_pages: 0 rows
/*!40000 ALTER TABLE `ga_pages` DISABLE KEYS */;
/*!40000 ALTER TABLE `ga_pages` ENABLE KEYS */;


-- Volcando estructura para tabla mytrip.ga_rols
CREATE TABLE IF NOT EXISTS `ga_rols` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `meta` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COMMENT='la tabla de rols es la mas sencilla solo especificamos un nombre al rol \r\ntalves algun meta agregado a ello pero nada mas ';

-- Volcando datos para la tabla mytrip.ga_rols: 3 rows
/*!40000 ALTER TABLE `ga_rols` DISABLE KEYS */;
INSERT INTO `ga_rols` (`id`, `name`, `meta`) VALUES
	(1, 'administrator', NULL),
	(2, 'guess', NULL),
	(3, 'user', NULL);
/*!40000 ALTER TABLE `ga_rols` ENABLE KEYS */;


-- Volcando estructura para tabla mytrip.ga_sessions
CREATE TABLE IF NOT EXISTS `ga_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla mytrip.ga_sessions: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `ga_sessions` DISABLE KEYS */;
INSERT INTO `ga_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
	('7b28jqnrgat5qlstsbk6s3gamnj2etja', '::1', 1480380225, _binary 0x6C616E677C733A323A22656E223B),
	('33ue42308gfl865a8at99p64qst200db', '::1', 1480380225, _binary 0x6C616E677C733A323A22656E223B),
	('90ec35qcb7gq4dbmafn69nir1vlth2hr', '::1', 1480380227, _binary 0x6C616E677C733A323A22656E223B),
	('7m8mkb6si3vqvtfdrp2nhedg5904fham', '::1', 1480380225, _binary 0x6C616E677C733A323A22656E223B),
	('0df5nekpf06p4rjn9l88kcmnj2tfvkgl', '::1', 1480380225, _binary 0x6C616E677C733A323A22656E223B),
	('eh740o06lqaq6mldj8g8s5s7213frk44', '::1', 1480380225, _binary 0x6C616E677C733A323A22656E223B),
	('46kibmphr9c6qkc48phdr3nl820819nq', '::1', 1480380227, _binary 0x6C616E677C733A323A22656E223B),
	('6rknftneko56tgfdlisb3r9m8dg22sik', '::1', 1480380227, _binary 0x6C616E677C733A323A22656E223B),
	('fkpvk0g6ihmnqd5peg48enia35n54205', '::1', 1480380227, _binary 0x6C616E677C733A323A22656E223B),
	('smjb2oo8ppip3o00u3cf63bic8sku4l9', '::1', 1480380227, _binary 0x6C616E677C733A323A22656E223B),
	('pti8o9moo6k79jmhsope6rvol030dini', '::1', 1480380227, _binary 0x6C616E677C733A323A22656E223B),
	('epcv9kckue92jt6n541lpefpfmsbke4e', '::1', 1480380227, _binary 0x6C616E677C733A323A22656E223B),
	('8c1g37l9ln5ci941fj0fshbtbc907123', '::1', 1480384402, _binary 0x6C616E677C733A323A22656E223B5F5F63695F6C6173745F726567656E65726174657C693A313438303338343430323B757365725F6D6574617C4F3A383A22737464436C617373223A313A7B733A393A22757365725F74797065223B733A303A22223B7D),
	('gdgqr6nk9tftlmeub1m44rde9enlun1a', '::1', 1480380227, _binary 0x6C616E677C733A323A22656E223B),
	('3chur4gd65i0gbp2pvgvnvl83uk7apu7', '::1', 1480387185, _binary 0x6C616E677C733A323A22656E223B5F5F63695F6C6173745F726567656E65726174657C693A313438303338373138353B757365725F6D6574617C4F3A383A22737464436C617373223A313A7B733A393A22757365725F74797065223B733A303A22223B7D),
	('2t2u3mka25g9c3o8h2enpaant66thi8h', '::1', 1480387760, _binary 0x6C616E677C733A323A22656E223B5F5F63695F6C6173745F726567656E65726174657C693A313438303338373138353B757365725F6D6574617C4F3A383A22737464436C617373223A313A7B733A393A22757365725F74797065223B733A303A22223B7D),
	('5b2bppbeamedt0n45m8sb1dplbrq4lh8', '::1', 1480395968, _binary 0x6C616E677C733A323A22656E223B),
	('indrmrfo4irsgof03tgg224509l0pnte', '::1', 1480396027, _binary 0x6C616E677C733A323A22656E223B),
	('ec1p91pe11ju4pfav1kqiked487ls05r', '::1', 1480395974, _binary 0x6C616E677C733A323A22656E223B),
	('ivjhsm5ichgf8g1as17jln1gtlo913lh', '::1', 1480395975, _binary 0x6C616E677C733A323A22656E223B),
	('9alon55cet6v04ackjuerg128oit537j', '::1', 1480395977, _binary 0x6C616E677C733A323A22656E223B),
	('2qt7u8b45gqbf2k73dqmsjf0707md9cv', '::1', 1480395975, _binary 0x6C616E677C733A323A22656E223B),
	('ajlss9r58amq1sr027t7dqeoqf3qvlj9', '::1', 1480395975, _binary 0x6C616E677C733A323A22656E223B),
	('tb3i9g9kqppfq2qehshem4arqkqfapcb', '::1', 1480395975, _binary 0x6C616E677C733A323A22656E223B);
/*!40000 ALTER TABLE `ga_sessions` ENABLE KEYS */;


-- Volcando estructura para tabla mytrip.ga_user
CREATE TABLE IF NOT EXISTS `ga_user` (
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

-- Volcando datos para la tabla mytrip.ga_user: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `ga_user` DISABLE KEYS */;
INSERT INTO `ga_user` (`id`, `id_operator`, `username`, `email`, `password`, `data`, `privileges`, `last_connect`, `active`, `connected`, `user_type`) VALUES
	(1, 'ABCD', 'admin', 'rolignu90@gmail.com', '7d7ff17eb8d7eb50d4e04c7ff096b291c0cdfa64a5d33d2ac5ef6fb253062d8ef29d7e82305db6df84f3f128bd415e9552131cfe488251c21e43c0aecf990fe0hBHnjDJeHG9ClaLf97Vc0KRyt/mC', '{"details":{"name":"Rolando Antonio","last_name":"Arriaza Marroquin","register":"2016-06-19","avatar":"TBVCj9Fd-avatar-dany dibujo.png","occupation":"Ingeniero en ciencias de la computacion","location":"El Salvador","website":"www.rolandoarriaza.com"},"last_passwords":{}}', '{\n\n    "parent" : "1",\n    "childs" : "2,3"\n  \n}', '2016-11-23 21:55:43', 1, 1, '-A'),
	(2, 'DEF', 'guess', 'rolignu90@gmail.com', '7d7ff17eb8d7eb50d4e04c7ff096b291c0cdfa64a5d33d2ac5ef6fb253062d8ef29d7e82305db6df84f3f128bd415e9552131cfe488251c21e43c0aecf990fe0hBHnjDJeHG9ClaLf97Vc0KRyt/mC', '{"details":{"name":"Invitado Antonio","last_name":"Arriaza Marroquin","register":"2016-06-19","avatar":"bIy6ZCc8-avatar-tetas-putas-desmotivaciones.jpg","occupation":"Ingeniero en sistemas","location":"El salvador","website":"www.rolandoarriaza.com"},"last_passwords":["admin","admin","admin","admin","admin","linux90"]}', '{\n\n    "parent" : "2",\n    "childs" : ""\n  \n}', '2016-11-23 21:55:46', 1, 0, '-U');
/*!40000 ALTER TABLE `ga_user` ENABLE KEYS */;


-- Volcando estructura para tabla mytrip.ga_user_type
CREATE TABLE IF NOT EXISTS `ga_user_type` (
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

-- Volcando datos para la tabla mytrip.ga_user_type: ~6 rows (aproximadamente)
/*!40000 ALTER TABLE `ga_user_type` DISABLE KEYS */;
INSERT INTO `ga_user_type` (`id_type`, `type`, `properties`, `id_operator`, `create_date`, `mod_date`, `comment`, `label`) VALUES
	(1, '-U', 1, '1', '2016-11-07 20:30:18', '2016-11-07 20:30:18', 'usuario , persona de tipo natural ', 'Usuario/User'),
	(2, '-S', 1, '1', '2016-11-07 20:30:18', '2016-11-07 20:30:18', 'sales o vendedor , persona que verifica administracion de ventas', 'Vendedor/Sales'),
	(3, '-C', 1, '1', '2016-11-07 20:30:18', '2016-11-07 20:30:18', 'company o compañia  , si el usuario no persona natural sino un ente empresarial ', 'Compañia/Company'),
	(4, '-UC', 1, '1', '2016-11-07 20:30:18', '2016-11-07 20:30:18', ' usuario y compañia , cuando la cuenta esta ligada a un usuario y a una compañia en especifico , claro si se puede ', 'Usuario tipo compañia / Company user type'),
	(5, '-A', 0, '1', '2016-11-07 20:30:18', '2016-11-07 20:30:18', ' admin , tipo de usuario administrativo ', 'Administrador/Admin'),
	(6, '-M', 1, '1', '2016-11-07 20:30:18', '2016-11-07 20:30:18', ' moderador , el moderador se encarga de velar que los usuarios sigan con el protocolo del sistema ', 'Moderador/Moderator');
/*!40000 ALTER TABLE `ga_user_type` ENABLE KEYS */;


-- Volcando estructura para procedimiento mytrip.sp_dump_data
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_dump_data`(IN  i_token VARCHAR(255),IN i_user INT(11) , IN i_type VARCHAR(5) )
BEGIN 


  /**
 * @author Rolando Arriaza
 * @name sp_dump_data
 * @access database 
 * @version 1.5
 * @date 15-nov-2016
 * @see http://
 * @todo ejecuta acciones de la tabla dump que en si funciona como un comodin de seguridad
 *			el comodin de seguridad verifica por medio de un token el estado de activacion 
 *			del usuario por medio de logueo , por ende este resultado solo se guarda en la bdd 
 *			un determinado tiempo que suele ser en milisegundos, el SP nos facilita la programacion
 *			de la logica en el BK la cual asi nos facilita el mantenimiento de esta misma
 *
 *@params  i_token = token tipo alfanumerico 
 			  i_user  = id del usuario afectado 
 			  i_type  = tipo de ejecucion que son :
													C= crear , 
													D = eliminar  , 
													CM = compara con un count 
													DL = eliminar con usuario y token 
 * ---------------------------------------------------------------------------
 *                           ULTIMAS MODIFICACIONES
 *
 *  Nombre                         Fecha              Comentario
 * <rolignu>                    <15-nov-2016>        <creacion del sp>
 * <rolignu>						  <20-nov-2016>		  <desarrollo nuevo modulo logico>
 *
 */

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

END//
DELIMITER ;


-- Volcando estructura para procedimiento mytrip.sp_operator
DELIMITER //
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




  /**
 * @author Rolando Arriaza
 * @name sp_dump_data
 * @access database 
 * @version 1.5
 * @date 15-nov-2016
 * @see http://
 * @todo procedimiento almacenado para las acciones del operador 
 			este procedimiento llevar al logica mas relevante para las 
 		   acciones de esta
 *
 * @params 
 
 
 				tipo de dato a ejecutar con e_type 
 				
 						C 		= Crear un nuevo operador log 
 						UL 	= actualizar solo el log del operador
 						S		= seleccionar el operador por medio de id_operator
 				
 * ---------------------------------------------------------------------------
 *                           ULTIMAS MODIFICACIONES
 *
 *  Nombre                         Fecha              Comentario
 * <rolignu>                    <15-nov-2016>        <creacion del sp>
 *
 */
 
 
 declare id_op_exist varchar(255);
 declare operator_key varchar(255);
 declare operator_key_status bool ;
 
 set operator_key = MD5(FLOOR( 1 + RAND( ) *60 ));
 set id_op_exist = NULL;
 set operator_key_status = false;
 
 /**
IN e_type					VARCHAR(3),
IN i_op_type				VARCHAR(4),
IN i_id_operator 			VARCHAR(255),
IN i_id_user 				INT(11),
IN i_affected_table 		VARCHAR(100),
IN i_log						TEXT 
 */
 
 
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
 
		
END//
DELIMITER ;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
