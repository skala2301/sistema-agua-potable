-- --------------------------------------------------------
-- Host:                         localhost
-- Versión del servidor:         10.0.27-MariaDB-0ubuntu0.16.04.1 - Ubuntu 16.04
-- SO del servidor:              debian-linux-gnu
-- HeidiSQL Versión:             9.3.0.5124
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para mytrip
CREATE DATABASE IF NOT EXISTS `mytrip` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `mytrip`;

-- Volcando estructura para tabla mytrip.ga_dump
CREATE TABLE IF NOT EXISTS `ga_dump` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(255) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `expired` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

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
) ENGINE=MyISAM AUTO_INCREMENT=149 DEFAULT CHARSET=latin1 COMMENT='metadata es una tabla en la cual sus valores no son estaticos , eso quiere decir que la tabla\r\nno es uso especifico asi que solo tiene unos pares de campos y la mayoria se trabajara\r\ncon variables o con cadenas cuyo patrones estan definidos aplica con JSON y XML';

-- Volcando datos para la tabla mytrip.ga_metadata: 8 rows
/*!40000 ALTER TABLE `ga_metadata` DISABLE KEYS */;
INSERT INTO `ga_metadata` (`id`, `key`, `value`, `id_user`, `id_rol`, `type`, `label`) VALUES
	(123, 'smtp_protocol', 'smtp', NULL, NULL, 'S', NULL),
	(124, 'smtp_host', 'localhost', NULL, NULL, 'S', NULL),
	(125, 'smtp_port', '465', NULL, NULL, 'S', NULL),
	(126, 'smtp_timeout', '10', NULL, NULL, 'S', NULL),
	(127, 'smtp_user', 'root', NULL, NULL, 'S', NULL),
	(128, 'smtp_pass', '', NULL, NULL, 'S', NULL),
	(129, 'smtp_status', '0', NULL, NULL, 'S', NULL),
	(130, 'user_lang', 'en', 1, 0, 'S', NULL);
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
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1 COMMENT='navbar version 1.0 ';

-- Volcando datos para la tabla mytrip.ga_nav: 13 rows
/*!40000 ALTER TABLE `ga_nav` DISABLE KEYS */;
INSERT INTO `ga_nav` (`id`, `type`, `name`, `location`, `route`, `objects`, `components`, `parent`, `origins`, `active`, `privs`, `token`) VALUES
	(1, 'namespace', 'Menu', NULL, NULL, '{\n  \n  "icon" : "",\n  "redirect": "",\n  "target" : ""\n  \n}', '{}', '0', 'system', 1, '0', NULL),
	(2, 'sidebar', '{"es": "Inicio" , "en" : "Home" }', '', NULL, '{\r\n  \r\n  "icon" : "fa fa-home",\r\n  "redirect": "",\r\n  "target" : ""\r\n  \r\n}', '{}', '1', 'system', 1, '0', NULL),
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
	(16, 'sidebar', '{"es" : "Configuracion Correo" , "en" : "Email config"}', 'system=email', 'email_config', '{\r\n  \r\n  "icon" : "fa fa-envelope",\r\n  "redirect": "",\r\n  "target" : "",\r\n "place" : "2",\r\n "divider" : "true"\r\n  \r\n}', '{}', '13', 'system', 1, '1', NULL);
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
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla mytrip.ga_sessions: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `ga_sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `ga_sessions` ENABLE KEYS */;

-- Volcando estructura para tabla mytrip.ga_user
CREATE TABLE IF NOT EXISTS `ga_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` text NOT NULL,
  `data` text,
  `privileges` text,
  `last_connect` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `active` int(2) DEFAULT NULL,
  `connected` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='Garrobo CMS base de datos del usuario , se definieron estas bases de datos \r\nde una forma en la que la experciendia sea ,ucho mejor. en palabras mas \r\ncristianas la base de datos debe de responder de forma rapida.';

-- Volcando datos para la tabla mytrip.ga_user: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `ga_user` DISABLE KEYS */;
INSERT INTO `ga_user` (`id`, `username`, `email`, `password`, `data`, `privileges`, `last_connect`, `active`, `connected`) VALUES
	(1, 'admin', 'rolignu90@gmail.com', '7d7ff17eb8d7eb50d4e04c7ff096b291c0cdfa64a5d33d2ac5ef6fb253062d8ef29d7e82305db6df84f3f128bd415e9552131cfe488251c21e43c0aecf990fe0hBHnjDJeHG9ClaLf97Vc0KRyt/mC', '{"details":{"name":"Rolando Antonio","last_name":"Arriaza Marroquin","register":"2016-06-19","avatar":"TBVCj9Fd-avatar-dany dibujo.png","occupation":"Ingeniero en ciencias de la computacion","location":"El Salvador","website":"www.rolandoarriaza.com"},"last_passwords":{}}', '{\n\n    "parent" : "1",\n    "childs" : "2,3"\n  \n}', '2016-10-10 20:53:00', 1, 1),
	(2, 'guess', 'rolignu90@gmail.com', '7d7ff17eb8d7eb50d4e04c7ff096b291c0cdfa64a5d33d2ac5ef6fb253062d8ef29d7e82305db6df84f3f128bd415e9552131cfe488251c21e43c0aecf990fe0hBHnjDJeHG9ClaLf97Vc0KRyt/mC', '{"details":{"name":"Invitado Antonio","last_name":"Arriaza Marroquin","register":"2016-06-19","avatar":"bIy6ZCc8-avatar-tetas-putas-desmotivaciones.jpg","occupation":"Ingeniero en sistemas","location":"El salvador","website":"www.rolandoarriaza.com"},"last_passwords":["admin","admin","admin","admin","admin","linux90"]}', '{\n\n    "parent" : "2",\n    "childs" : ""\n  \n}', '2016-10-12 23:11:27', 1, 1);
/*!40000 ALTER TABLE `ga_user` ENABLE KEYS */;

-- Volcando estructura para tabla mytrip.ga_user_type
CREATE TABLE IF NOT EXISTS `ga_user_type` (
  `id_type` int(11) NOT NULL AUTO_INCREMENT,
  `type` char(2) NOT NULL DEFAULT 'U',
  `properties` varchar(60) DEFAULT NULL,
  `user_modify` int(11) DEFAULT '0',
  `create_date` datetime NOT NULL,
  `mod_date` datetime NOT NULL,
  `comment` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='user_type : es una tabla para crear los tipos de usuario ya que mytrip [codename]\r\nse generara un tipo de usuario para entrada a los diversos sistemas como usuarios iniciales \r\nseran los siguientes :\r\n\r\n                            -U = usuario , persona de tipo natural \r\n                           -S = sales o vendedor , persona que verifica administracion de ventas\r\n                          -C = company o compañia  , si el usuario no persona natural sino un ente empresarial \r\n                         - UC = usuario y compañia , cuando la cuenta esta ligada a un usuario y a una compañia en especifico , claro si se puede \r\n                        -A = admin , tipo de usuario administrativo \r\n                        -M = moderador , el moderador se encarga de velar que los usuarios sigan con el protocolo del sistem\r\n\r\ntype = tipo de usuario que se agrega \r\nproperties = propiedades basicas \r\nuser_modify = que usuario agrego o modifico este tipo de usuario \r\ncreate_date = fecha que se crea el tipo de usuario \r\nmod_date = fecha de modificacion de este tipo de usuario ';

-- Volcando datos para la tabla mytrip.ga_user_type: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `ga_user_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `ga_user_type` ENABLE KEYS */;

-- Volcando estructura para procedimiento mytrip.sp_metadata
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_metadata`(
				IN data_key VARCHAR(50),
				IN data_value LONGTEXT ,
				IN data_type VARCHAR(1),
				IN id_user INT , 
				IN id_rol INT ,
				IN i_type VARCHAR(1),
				IN i_label VARCHAR (255)
)
BEGIN 

 /**
 		Autor : Rolando Arriaza 
 		Version : 1.1.2
 		Fecha : Oct-2016
 		Actualizaco : Oct-2016
 **/
 
 /**
 data_type :
 
 	CONSULT --> C
 	UPDATE  --> U 
 	DELETE  --> D 
 	INSERT  --> I 
 	
 	Estos tipos de datos a excepcion de C => consult 
 	devuelven un valor de O o 1 si se ejecuto con exito 
 	la etiqueta o la columna se llama "return" 
 	
 */
 
 IF (data_type = 'C') THEN 
 
 	SELECT * FROM ga_metadata WHERE ga_metadata.`key` LIKE data_key;
 	
 	if(ROW_COUNT() = 0) THEN 
 			 SIGNAL SQLSTATE '45000' 
			  				SET MESSAGE_TEXT = '45000 [no se devolvieron registros]';
			 SELECT MESSAGE_TEXT AS 'error'; 
 	END IF;
 	
 ELSEIF (data_type = 'U') THEN 
 
 	UPDATE ga_metadata SET ga_metadata.value = data_value 
 			WHERE ga_metadata.key LIKE data_key;
 			
 	SELECT ROW_COUNT() as 'return';
 	
 ELSEIF (data_type = 'D') THEN 
 
 	DELETE  FROM ga_metadata WHERE ga_metadata.key = data_key;
 	
 	SELECT ROW_COUNT() as 'return';
 	
 ELSEIF (data_type = 'I') THEN 
 	 
 	 
 	 INSERT INTO ga_metadata (
	  								ga_metadata.key,
									ga_metadata.value,
									ga_metadata.id_user, 
									ga_metadata.id_rol,
									ga_metadata.type,
									ga_metadata.label
								)
	 					 VALUES (
						  			data_key , 
									data_value,
									CASE id_user WHEN 0 THEN NULL
														    ELSE id_user END,
									CASE id_rol WHEN 0 THEN NULL 
															 ELSE id_rol END,
									CASE i_type WHEN NULL THEN 'S' 
													WHEN '' THEN 'S' 
													WHEN null THEN 'S'
													ELSE i_type END ,
									i_label
							);
	 	
	 SELECT ROW_COUNT() as 'return';
 END IF;
 

END//
DELIMITER ;

-- Volcando estructura para procedimiento mytrip.sp_user_config_data
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_user_config_data`(IN i_user INT , IN i_type VARCHAR(1) )
BEGIN 

		

		/**
 				Autor : Rolando Arriaza 
 				Version : 1.0.0
 				Fecha : Oct-2016
 				Actualizaco : Oct-2016
 				
 				parametros i_user = id_usuario 
 							  i_type = tipo de informacion a desplegar 
 							  			  abajo se detalla la informacion por medio de su letra
 							  			  a desplegar 
 				
 				para los metadatas existe un type este puede diferenciar
 				de los comendos siguientes :
 				
 						S  	=> tipo de dato generado por el sistema 
 						U 		=> tipo de dato dado por el usuario 
 						C		=> tipo de dato generado por el ente , compañia o empresa
 						
 		**/

		
		
		DROP TABLE IF EXISTS user_temp;
	
	
		/*se crea una tabla temporal para mejor rendimiento en el SP*/
		CREATE TEMPORARY TABLE user_temp (
			data_id INT  NOT NULL AUTO_INCREMENT,
			data_key VARCHAR(255),
			data_value LONGTEXT,
			data_rol INT ,
			data_type VARCHAR(1),
			data_label VARCHAR(255),
			PRIMARY KEY (data_id)
		);
		
		
		/*insertamos todos los datos posibles que tenga este usuario */
		INSERT INTO user_temp (data_key , data_value, data_rol , data_type , data_label )
					SELECT 
							ga_metadata.`key` , 
							ga_metadata.value , 
							ga_metadata.id_rol,
							ga_metadata.`type`,
							ga_metadata.label
					FROM ga_metadata WHERE ga_metadata.id_user = i_user;
		
		
		IF  (i_type != '' OR  i_type != NULL  ) THEN 
			SELECT * FROM user_temp as a WHERE a.data_type LIKE i_type;
		ELSE 
			SELECT * FROM user_temp;
		END IF;
		
		
		DROP TABLE IF EXISTS user_temp;

END//
DELIMITER ;

-- Volcando estructura para procedimiento mytrip.sp_user_roles
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_user_roles`( IN id_user  INT (11) , IN id_rol INT(11))
BEGIN

declare u_exist INT ;
SELECT COUNT(ga_user.id) INTO u_exist FROM ga_user WHERE ga_user.id LIKE id_user; 


IF(u_exist > 0) THEN 
	SELECT ga_user.id as 'id_user' ,
			 ga_user.username as 'username',
			 ga_user.active as 'active',
			 ga_user.connected as 'conn_state',
			 ga_rols.name as 'rol_parent_name',
			 ga_rols.meta as 'rol_parent_meta'
	FROM ga_user
	INNER JOIN ga_rols ON ga_rols.id = id_rol
	WHERE ga_user.id LIKE id_user;

END IF;
END//
DELIMITER ;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
