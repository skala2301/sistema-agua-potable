

DROP PROCEDURE IF EXISTS sp_metadata;

DELIMITER $$
CREATE PROCEDURE sp_metadata (
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
 		Actualizaco : NOV-2016
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
 

END$$

/*call sp_metadata('prueba_sp' , 'valor_prueba' , 'I' , 1 , 1 , 'A' , 'label del ...');*/