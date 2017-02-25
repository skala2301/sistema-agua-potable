

DROP PROCEDURE IF EXISTS sp_user_config_data;

DELIMITER $$

CREATE PROCEDURE sp_user_config_data (IN i_user INT , IN i_type VARCHAR(1) )
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

END$$

call sp_user_config_data(1, '');