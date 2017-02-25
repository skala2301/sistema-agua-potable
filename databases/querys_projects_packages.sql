
select
gp.name as  'package' , 
gp.start_date as  'package_date',
gpp.name as  'project',
gpp.privs as 'privs'
from ga_package gp 
inner join ga_project gpp on gpp.id = gp.id_project 
where gpp.id = 0;


/****************************************************************************/

select id , name from ga_project where active = 1 and privs like '%?%';

select * from ga_project;
update ga_project set privs = '3,2,4' where id = 3;

select ga_project.id as 'id' ,
ga_project.name as 'name'
from ga_project where ga_project.active = 1 and ga_project.privs like '%1%';

select  p.privs as 'privs' from ga_project p where p.id = 3;

select * FROM ga_error_handle;
SELECT * from ga_package ;
SELECT * from ga_device;
SELECT * from ga_project;
SELECT * from ga_nav;
TRUNCATE ga_package;
TRUNCATE ga_project;
TRUNCATE ga_device;


SELECT particle_id as 'particle_id' FROM ga_device gd 
INNER JOIN ga_package g  ON g.id = gd.id_package
INNER JOIN ga_project gp ON gp.id = g.id_project
where particle_id = "2f0037001247353236343033" and gp.id = 1


/***************************************************************/




		
insert into ga_metadata (`key` , `value` , `label` ) 
values ("particle_url" 
			, "https://api.particle.io/v1/devices?access_token={id_token}" 
			, "Dispositivos Particle");
			

insert into ga_metadata (`key` , `value` , `label` ) 	
values("particle_photon_get" ,
"https://api.spark.io/v1/devices/{device_id}/{device_function}/?access_token={id_token}"
, "Photon get data ");


select * from ga_metadata;
