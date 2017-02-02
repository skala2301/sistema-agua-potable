<?php

/**
 * @todo meta [garrobo platform]
 * @version 1.0.2
 * @author Rolando Arriaza
 * @extends QueryBuild
 * @year 2016
 * @description
 * <code>
 *
 *      meta is a very important library to manipulate a table metadata
 *      if table metadata not exist dont use a library
 *
 *      component to table
 *
 *       CREATE TABLE `ga_metadata` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `key` VARCHAR(50) NOT NULL,
            `value` LONGTEXT NULL,
            `id_user` INT(10) UNSIGNED NULL DEFAULT '0',
            `id_rol` INT(10) UNSIGNED NULL DEFAULT '0',
        PRIMARY KEY (`id`)
    )
        COMMENT='metadata es una tabla en la cual sus valores no son estaticos , eso quiere decir que la tabla\r\nno es uso especifico asi que solo tiene unos pares de campos y la mayoria se trabajara\r\ncon variables o con cadenas cuyo patrones estan definidos aplica con JSON y XML'
        COLLATE='latin1_swedish_ci'
        ENGINE=MyISAM
        AUTO_INCREMENT=1;
 *
 *  Note the MyISAM engine is because the most querys are SELECTS

 * </code>
 *
 *
 * Comentarios :
 *
 *          --En la version 1.0.2 modifico get_meta_value
**/

class Meta extends Querybuild
{

    //instance to CI
    protected $class                = NULL;


    /***
     * protected querys to use in meta
    ****/
    protected $querys               = [
        "metas"                     => "SELECT * FROM [table] ",
        "meta_exist"                => "SELECT count(*) as 'count' FROM [table] WHERE [table].key LIKE ?",
        "meta_key"                  => "SELECT * FROM [table] WHERE [table].key LIKE '#1'",
        "meta_user"                 => "SELECT [table].value as 'data' FROM [table] WHERE [table].key LIKE ? AND [table].id_user LIKE ?",
        "meta_rol"                  => "SELECT [table].value as 'data' FROM [table] WHERE [table].key LIKE ? AND [table].id_rol LIKE ?"
    ];


    //database name with the prefix
    private $db_name   = NULL;

    //data var
    private $data      = NULL;

    //mysql prepare insert meta
    private $prepare   = [];

    //construct
    public function  __construct()
    {

        parent::__construct();

        $this->class = &get_instance();
        $this->class->load->database();
        $this->db_name = $this->class->db->dbprefix("metadata");

    }


    /**
     * @author <rolignu90>
     * @since  10-06-16
     * @return array , all metadata
    ***/
    public function get_all()
    {

         $obj = new stdClass();
         $obj->db           = $this->db_name;
         $obj->query        = $this->querys['metas'];

         $query = parent::GetQueryHandler(function() use ($obj){
             return [str_replace("[table]" , $obj->db , $obj->query ) ];
         });

         return parent::query($query->query);
    }




    /**
     * @author <rolignu90>
     * @since  10-06-16
     * @deprecated 13-10-16
     * @param $key , the key of meta
     * @param $pointer, true or false if true return the pointer
     * @return array , example : Array (
     *                              [0] => Array (
     *                              [0] => stdClass Object ( [id] => 114 [key] => smtp_protocol [value] => smtp [id_user] => [id_rol] => ) ) )
     ***/
    public function get($key , $pointer = false  )
    {

        $obj        = new stdClass();
        $obj->db    = $this->db_name;
        $obj->query = $this->querys['meta_key'];
        $obj->param = $key;

        $q = parent::GetQueryHandler(function() use ($obj){
            return [str_replace("[table]" , $obj->db , $obj->query ) , $obj->param ];
        });
        

        if(!$pointer)
        {
            $this->data[] = parent::query($q->query);
            return $this->data;
        }
        else{
            $this->data[] =  parent::query($q->query);
            return $this;
        }

    }



    /**
     * @author <rolignu90>
     * @since  10-06-16
     * @param $key , the key of meta
     * @param $multiple , True  if exist more than value with same key then return array
     * @return string , meta value
     ***/
    public function get_meta_value($key , $multiple = false )
    {
        $obj        = new stdClass();
        $obj->db    = $this->db_name;
        $obj->query = $this->querys['meta_key'];
        $obj->param = $key;

        $q = parent::GetQueryHandler(function() use ($obj){
            return [str_replace("[table]" , $obj->db , $obj->query ) , $obj->param ];
        });

        if(!$multiple)
                return $this->class->db->query($q->query)->result()[0]->value ?? null;

        $Amap = [];
        foreach($this->class->db->query($q->query)->result() as $data)
        {
            $Amap[] = $data->value;
        }

        return $Amap;
    }


    /**
     * @author <rolignu90>
     * @since  10-06-16
     * @param $key , the key of meta
     * @param $pointer, true or false if true return the pointer
     * @return int : zero if not exists metadata , more them if exist
     ***/
    public function exists_meta_key($key)
    {
        $query = $this->querys['meta_exist'];
        $query = str_replace("[table]" , $this->db_name , $query);

        return $this->class->db->query($query , [$key])
                            ->result()[0]
                            ->count ?? 0;
    }



    /**
     * @author <rolignu90>
     * @since  10-06-16
     * @deprecated 10-10-16
     * @dependence $this->get()
     * @return int : zero if not exists metadata , more them if exist
     ***/
    public function count_get_meta()
    {
        $counter = 0;
        foreach ($this->data as $val )
        {
            if(sizeof($val) >= 1)
            {
                $counter++;
            }
        }

        return $counter;
    }


    /**
     * @author <rolignu90>
     * @since  10-06-16
     * @param $key , the meta key
     * @param $id_user , the id of user must be integer
     * @return mixed , more a string
     ***/
    public function get_ByUser($key , $id_user)
    {

        $query      = str_replace("[table]" , $this->db_name , $this->querys['meta_user']);
        $result     = $this->class->db->query($query , [
            $key ,
            $id_user
        ])->result();

        if(count($result) === 0 ) return NULL;

        return $result[0]->data;


    }

    /**
     * @author <rolignu90>
     * @since  10-06-16
     * @param $key , the meta key
     * @param $id_rol , the rol id of meta
     * @return mixed , more a string
     ***/
    public function get_ByRol($key , $id_rol)
    {
        $query      = str_replace("[table]" , $this->db_name , $this->querys['meta_rol']);
        $result     = $this->class->db->query($query , [
            $key ,
            $id_rol
        ])->result();

        if(count($result) === 0 ) return NULL;

        return $result[0]->data;
    }



    /**
     * @author <rolignu90>
     * @since  10-06-16
     * @param $key , the meta key
     * @param $value , mixed string data may be a json file
     * @param $id_user , integer user id optional ,
     * @param $id_rol , integer id rol optional
     * @return mixed , more a string
     ***/
    public function set_meta($key , $value , $id_user = null , $id_rol = null)
    {
         $table = $this->db_name ;

         $this->prepare[] = [
              $table . ".key"       => $key,
              $table . ".value"     => $value,
              $table . ".id_user"   => $id_user,
              $table . ".id_rol"    => $id_rol
         ];

        return $this;
    }



    /**
     * @author <rolignu90>
     * @since  10-06-16
     * @return a multiple or one insert prepare into a set_meta
     ***/
    public function insert()
    {
        if(count($this->prepare) >= 1)
        {

           $val = $this->class
                    ->db
                    ->insert_batch($this->db_name , $this->prepare);

            unset($this->prepare);
            return $val;
        }

        return false;

    }


    /**
     * @author <rolignu90>
     * @since  10-06-16
     * @param $key , the meta key
     * @param $value , mixed string data may be a json file
     * @param $id_user , integer user id optional ,
     * @param $id_rol , integer id rol optional
     * @return mixed , more a string
     ***/
    public function set_prepare_meta($key , $value , $id_user = null , $id_rol = null)
    {
        return $this->set_meta($key , $value , $id_user , $id_rol);
    }


    /**
     * @author <rolignu90>
     * @since  10-06-16
     * @return a multiple or one insert prepare into a set_meta
     ***/
    public function insert_prepare_meta()
    {
        return $this->insert();
    }


    /**
     * @author <rolignu90>
     * @since  10-06-16
     * @deprecated
     * @return a multiple or one insert prepare into a set_meta
     ***/
    public function result()
    {
        return $this->data;
    }



    public function Update_ByUser($key , $value , $id)
    {
        $table = $this->db_name;
        return $this->class->db->update( $table,  ["value" => $value] , ["id_user" => $id , "key" => $key]);
    }


}