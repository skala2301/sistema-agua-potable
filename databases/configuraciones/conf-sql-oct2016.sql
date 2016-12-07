
/*
	CONFIGURACION DE MYTRIP MYSQL Y MARIADB
*/


SET sql_mode = ''; /* elimina el formato  only_full_group_by si es requerido */

/**
   Alteracion de la tabla sesiones porque CI 3.1.2 lo necesita
**/

ALTER TABLE ga_sessions CHANGE id id varchar(128) NOT NULL;
