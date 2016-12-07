<?php

defined("USER_OBJECT") or define("USER_OBJECT" , 0);
defined("USER_JSON") or define("USER_JSON" , 1);
defined("USER_ARRAY") or define("USER_ARRAY" , 2);


/**
 * @author Rolando Arriaza
 * @name User
 * @access public
 * @version 1.9.3
 * @date 23-nov-2016
 * @see http://
 * @todo Clase User , esta clase se conecta con el usuario que actualmente esta en sesion
 *              es bastante importante asi que comar en cuenta que cualquier modificacion
 *              indebida puede provocar severos daños
 *
 *      Ultimas modificaciones :
 *
 *                  -- Se Alteraron dos las funciones dump_ en la cual se creo un
 *                     SP que agilizara los procesos de lado del ambiente BDD
 * ---------------------------------------------------------------------------
 *                           ULTIMAS MODIFICACIONES
 *
 *  Nombre                         Fecha              Comentario
 * <rolignu>                    <23-nov-2016>        <modificacion clase>
 *
 *
 */



class User extends  Querybuild
{

    /**
     * -------------------------------------------------------
     * private var´s zone
     * -------------------------------------------------------
    **/

    private $session_name       = NULL;

    var $instance               = NULL;

    protected $user             = NULL;

    protected $privs            = NULL;

    var $data_user              = NULL;

    var $dump_table             = NULL;

    private $table              = NULL;


    var $querys                 = [
        "parent"                => "SELECT name as 'name' FROM [table] WHERE id LIKE '#1' ",
        "child"                 => "SELECT name as 'name' FROM [table] WHERE id IN (#1)",
        "db_settings"           => array(
            "get"       => "SELECT data as 'data' FROM [table] WHERE id LIKE ?",
        ),
        "dump"                  =>  array(
               "get"        => "DELETE FROM [table] WHERE token LIKE ?", //deprecado pero no eliminado , posible eliminacion en el futuro
               "get_u"      => "DELETE FROM [table] WHERE token LIKE ? AND user_id LIKE ? ", //deprecado
               "cmp"        => "SELECT count(*) as 'count' FROM [table] WHERE token LIKE ?", //DEPRECADO
               "sp_dump"    => "CALL sp_dump_data(?,?,?)" //Nuevo stored procedure favor ver requerimientos dentro de el
        ),
        "dt"                    => array(
            "type"              => "SELECT [table].user_type as 'user_type' FROM [table] WHERE [table].id=?"
        )
    ];


    /**
     * class construct for user library
    ****/

    public function __construct()
    {

        $this->instance             = &get_instance();
        $this->session_name         = $this->instance->config->item("session_name");
        $s                          = $this->session_name;
        $this->user                 = $this->instance->session->$s ?? null;
        $this->table                = $this->instance->db->dbprefix("user");
        $this->dump_table           = $this->instance->db->dbprefix("dump");

        $this->instance->load->helper("string");
        $this->instance->load->database();
        parent::__construct();
    }


    public function get_instance() { return $this->instance; }
    
    
    public function get_user_type()
    {
        
        if ($this->get()->id() == null ) {
            return '';
        }

        $query      = str_replace("[table]", $this->table, $this->querys['dt']['type'] );
        
        try {

              $result     = $this->instance->db
                            ->query($query , [ $this->get()->id()])
                            ->result()[0]
                            ->user_type ?? '' ;
            
        } catch (Exception $ex) {
               
        }
      
      
        return $result ;
    }



    public function get_db_data($id = null , $json= false  )
    {
        $query = str_replace("[table]" , $this->table , $this->querys['db_settings']['get']);

        if($id == null)
            $id = $this->get()->id();

        return $json == false ? json_decode(parent::query($query , [$id])[0]->data) : parent::query($query , [$id])[0]->data;

    }



    public function update_password($password , $id = null )
    {
        if($id == null)
            $id = $this->get()->id();

        return parent::update([
            "password"  => $password
        ] , $this->table , ["id" => $id ]);
    }



    public function set_db_data($data , $id = null)
    {
        if($id == null)
            $id = $this->get()->id();

         if(is_object($data) || is_array($data))
             $data = json_encode($data);

        return parent::update(["data" => $data] , $this->table , ["id" => $id]);

    }


    /**
     * @todo obtiene la sesion del usuario en formatos distintos
     * @type const | int  tipo de salida
     * @return object | array | json
    **/
    public function get_user_session($type = USER_OBJECT  )
    {

         if(is_null($this->user)) return null;

         switch ($type)
         {
             case USER_OBJECT :
                 return  $this->user;
             case USER_JSON :
                 return json_encode($this->user);
             case USER_ARRAY:
                 return  (array) $this->user;
         }
    }

    public function set_avatar($avatar){
        $ext = $this->session_name;
        $this->instance
                ->session
                ->$ext
                ->data
                ->details
                ->avatar = $avatar;

        return $this;
    }

    public function set_lang($lang)
    {
        $ext = $this->session_name;

        $this->instance
            ->session
            ->$ext
            ->lang = $lang;

        return $this;
    }

    public function get()
    {
        $data                                   = $this->get_user_session();


        $this->data_user                        = new stdClass();
        $this->data_user->username              = $data->username ?? NULL;
        $this->data_user->password              = $data->password ?? NULL;
        $this->data_user->name                  = $data->data->details->name ?? null;
        $this->data_user->last_name             = $data->data->details->last_name ?? null;
        $this->data_user->register              = $data->data->details->register ?? null;
        $this->data_user->avatar                = $data->data->details->avatar ?? null;
        $this->data_user->last_password         = $data->data->last_passwords ?? null;
        $this->data_user->occupation            = $data->data->details->occupation ?? NULL;
        $this->data_user->location              = $data->data->details->location ?? NULL;
        $this->data_user->website               = $data->data->details->website ?? NULL;
        $this->data_user->email                 = $data->email ?? NULL;
        $this->data_user->id                    = $data->id ?? NULL;
        $this->data_user->lang                  = $data->lang ?? "en";
        
        return $this;
    }

    public function all()
    {
        return $this->data_user;
    }

    public function id() { return $this->data_user->id ;}

    public function email() { return $this->data_user->email;}

    public function occupation() { return $this->data_user->occupation; }

    public function location() { return $this->data_user->location; }

    public function website() { return $this->data_user->website;}

    public function user(){ return $this->data_user->username; }

    public function  password(){return $this->data_user->password;}

    public function  name(){return $this->data_user->name;}

    public function last_name(){return $this->data_user->last_name;}

    public function pretty_names()
    {
        $form       = '';
        $name       = $this->name();
        $last       = $this->last_name();

        $name       = explode(" " , $name);
        if(count($name) >= 2)
        {
            $form = $name[0] . " " . strtoupper($name[1]{0}) . "." ;
        }
        else{
            $form = $name[0];
        }

        $last       = explode(" " , $last);
        $form      .= " " . $last[0];

        return $form;

    }

    public function register()
    {
        $this->data_user->register;
    }

    public function avatar()
    {
        $avatar             = $this->data_user->avatar;
        $url                = site_url();

        $file_avatar        = $file_avatar = $this->class->config->item("avatar_files");
        $file_avatar        = str_replace("./" , "" , $file_avatar );

        $system_images      = $this->class->config->item('system_images');
        $dump_image         = $this->class->config->item('dump_image');



        if(is_null($avatar) || empty($avatar)) return $url . $system_images .  $dump_image;
        else {
            return $url . $file_avatar . $avatar;
        }

    }

    public function last_password()
    {
        $this->data_user->last_password;
    }

    public function user_lang()
    {
        if(is_null($this->user)) return null;
        return  $this->data_user->lang;
    }


    /**
     * @author Rolando Arriaza <rolignu90@mail.com>
     * @todo funcion que obtiene los privilegios actuales del usuario
     *       esta escrita en php 7 contruyendo clases anonimas para
     *       verificacion de privilegios
     * @param bool $all , true = si desea que no retorne el puntero , false si retorna el puntero
     * @return $this | object si retorna $this se podran utilizar get_parent y get_childs de forma directa
     *                  sino se puede utilizar pero se hacen dos llamados al objeto
     * @version 1.1.0
    **/

    public function privileges($all = true )
    {

        @$privs = (new class($this->user->privs){

            var $privs ;

            var $trait  = NULL;

            protected $class = NULL;

            public  function __construct($privs)
            {
                $this->trait = new stdClass();
                $this->privs = $privs;
                $this->class = &get_instance();
                $this->class->load->database();
            }

            public function parent()
            {

                $table = $this->class
                                ->db
                                ->dbprefix("rols");


                $rol_exists = $this
                                    ->class
                                    ->db
                                    ->query("SELECT count(*) as 'count' FROM $table WHERE id LIKE ?" , [$this->privs->parent])
                                    ->result()[0]
                                    ->count;

                $this->trait
                     ->parent = count($rol_exists) >= 1 ? $this->privs->parent : NULL;

                return $this;
            }

            public function child()
            {

                $table = $this->class
                    ->db
                    ->dbprefix("rols");

                if (is_string($this->privs->childs))
                {
                    if(empty($this->privs->childs))
                    {
                        $this->trait->childs = null;
                    }
                    else
                    {

                        $rol_exists = $this
                            ->class
                            ->db
                            ->query("SELECT count(*) as 'count' FROM $table WHERE id IN (?)" , [$this->privs->childs])
                            ->result()[0]
                            ->count;

                        $this->trait
                            ->childs = count($rol_exists) >= 1 ?  $this->privs->childs : NULL;
                    }
                }

                return $this;
            }

            public function get()
            {
                return $this->trait;
            }



        })->parent()->child()->get();

        $this->privs = $privs;

        if($all)
            return $privs;
        else
            return $this;

    }


    /**
     * @version 1.1.0
     * @todo obtiene el entero del privilegio padre
     * @return int
    ***/
    public function get_parent()
    {
        return $this->privs->parent;
    }

    /**
     * @version 1.1.0
     * @todo obtiene un arreglo de los privilegios hijos
     * return array
    **/
    public function get_childs($format = 1)
    {
        switch ($format)
        {
            case 1:
                return $this->privs->childs;
            case 0:
                return explode("," , $this->privs->childs);
        }
    }



    public function get_user_privs_names()
    {

        $this->privileges();
        $object                 = new stdClass();
        $object->parent         = $this->get_parent();
        $object->child          = $this->get_childs();
        $object->query          = $this->querys['parent'];
        $object->qchild         = $this->querys['child'];
        $object->table          = $this->instance->db->dbprefix("rols");

        $query_parent = parent::GetQueryHandler(function() use ($object){
            return [str_replace("[table]" , $object->table  , $object->query ) ,$object->parent];
        });

        $query_child  = parent::GetQueryHandler(function() use ($object){
            if($object->child == NULL || count($object->child) == 0)
                $object->child = 0;

            return [
                str_replace("[table]" , $object->table  , $object->qchild ),
                $object->child
            ];
        });

        $result = new stdClass();
        $result->parent = parent::query($query_parent->query);
        $result->child  = parent::query($query_child->query);

        return $result;

    }


    public function last_connect()
    {
        return $this->user->last_connect;
    }


    /**
     * @Region Temp tokens
     * @description Esta region es sobre los token temporales al momento
     *              de iniciar el logueo del sistema como medida de seguridad
     *
     ****/


    public function get_temp_token($user_id)
    {
        $token = random_string('alnum' , 20);
        $this->instance->load->database();

        //DEPRECADO en version  1.1.4
       /* $this->instance->db->insert($this->dump_table , [
            "token"         => $token,
            "user_id"       => $user_id
        ]);*/

        $query = $this->querys['dump']['sp_dump'];

        $this->instance
            ->db
            ->query(
                 $query,
                [$token , $user_id , 'C'])
            ->result();

        return $token;
    }


    public function destroy_temp_token($token , $user_id = null)
    {
        /* se depreco este algoritmo pero no se elimino , se remplazo por un sp**/

       /* $params = [];

        $params[] = $token;
        if(is_null($user_id))
        {
            $query = $this->querys['dump']['get'];
        }
        else{
            $query = $this->querys['dump']['get_u'];
            $params[] = $user_id;
        }

        $query = str_replace("[table]" , $this->dump_table , $query);
        return $this->instance->db->query($query , $params );*/

        $query = $this->querys['dump']['sp_dump'];
        $call_type      = is_null($user_id) ? 'D' : 'DL';


        $this->instance
            ->db
            ->query(
                 $query,
                [$token , $user_id , $call_type])
            ->result();

        return $token;
    }


    public function compare_temp_token($token)
    {

       // $query = $this->querys['dump']['cmp'];
       // $query = str_replace("[table]" , $this->dump_table , $query);
      //  $result = $this->instance->db->query($query , [$token])->result()[0]->count;
      //  return $result;


        $query = $this->querys['dump']['sp_dump'];
        return  $this->instance
            ->db
            ->query(
                $query,
                [$token , null  , 'CM'])
            ->result();

    }

}