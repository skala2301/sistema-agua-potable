/**INSERCION DE DATOS PARA LA TABLA COUNTRYS**/

INSERT INTO ga_countrys  (iso , name , id_operator , active ) 
VALUES('SV' ,'El Salvador' , MD5(FLOOR( 1 + RAND( ) *60 )) ,1);