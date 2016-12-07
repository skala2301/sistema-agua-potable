

/**
INSERCION DE DATOS TIPOS DE USUARIOS PARA ga_user_type

    -U = usuario , persona de tipo natural 
    -S = sales o vendedor , persona que verifica administracion de ventas
    -C = company o compañia  , si el usuario no persona natural sino un ente empresarial 
    -UC = usuario y compañia , cuando la cuenta esta ligada a un usuario y a una compañia en especifico , claro si se puede 
    -A = admin , tipo de usuario administrativo 
    -M = moderador , el moderador se encarga de velar que los usuarios sigan con el protocolo del sistem

**/

INSERT INTO ga_user_type 
(
ga_user_type.`type` , 
ga_user_type.properties , 
ga_user_type.user_modify , 
ga_user_type.create_date,
ga_user_type.mod_date,
ga_user_type.`comment`
) 
VALUES 
('-U' , null , 1 , NOW() , NOW() , 'usuario , persona de tipo natural '),
('-S' , null , 1 , NOW() , NOW() , 'sales o vendedor , persona que verifica administracion de ventas'),
('-C' , null , 1 , NOW() , NOW() , 'company o compañia  , si el usuario no persona natural sino un ente empresarial '),
('-UC' , null , 1 , NOW() , NOW() , ' usuario y compañia , cuando la cuenta esta ligada a un usuario y a una compañia en especifico , claro si se puede '),
('-A' , null , 1 , NOW() , NOW() , ' admin , tipo de usuario administrativo '),
('-M' , null , 1 , NOW() , NOW() , ' moderador , el moderador se encarga de velar que los usuarios sigan con el protocolo del sistema ')

