use mytrip;


DROP PROCEDURE IF EXISTS sp_dump_data;

DELIMITER $$
CREATE PROCEDURE sp_dump_data (IN  i_token VARCHAR(255),IN i_user INT(11) , IN i_type VARCHAR(5) )
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

END$$

-- ejemplo de ejecucion 
-- sp_dump_data('abc' , '1' , 'C');