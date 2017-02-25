

DROP PROCEDURE IF EXISTS sp_user_roles;

DELIMITER $$

CREATE PROCEDURE sp_user_roles ( IN id_user  INT (11) , IN id_rol INT(11))
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
END$$

CALL sp_user_roles(1,1);
