USE mytrip;


DROP PROCEDURE IF EXISTS sp_operator;

DELIMITER $$

CREATE PROCEDURE sp_operator(
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
 
		
END$$


CALL sp_operator('C', '', null, '', '', '', '','')

