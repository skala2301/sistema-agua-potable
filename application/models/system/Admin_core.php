<?php

/**
 * @todo  ADMIN CORE 
 * @version 1.0.2
 * @author Rolando Arriaza 
 * @access public
 * @category CORE
 * @uses
 * 
 *  ADMIN CORE se encarga de controlar todo lo relacionado 
 *  con el sistema desde logueo hasta las cuentas que se manejaran 
 * 
 *  la libreria es bastante importante si no tiene conocimiento , favor no altere
 *  el codigo ya que eso podria ocacionar daños irreparabes del sistema
 * 
 * ***/



//INTERFAZ CORE MOTOR 1.0.0
get_instance()->load->interfaces("Interface");

class Admin_core extends CI_Model implements CoreInterface {

    
    protected $my_querys = [
        
        "login"             =>  "SELECT count(*) as 'count' , id as 'id' FROM [table] WHERE username LIKE ? OR email LIKE ?",
        "login_filter"      =>  "SELECT * FROM [table] WHERE id LIKE ?",
        "login_user_filter" =>  "SELECT * FROM [table] WHERE username LIKE ?"
    ];
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }


    
    public function _actionScriptDashboard() {
        
    }

    public function _actionScript() {
        
    }

    public function _css() {
        
        
        
    }

    public function _javascript() {
        
    }

    public function _privileges() {
        return NULL;
    }

    public function _title() {
        return "Home";
    }

    public function _actions() {
        
    }

    public function load_login($params = [
        "title"             => "",
        "author"            => "",
        "description"       => "",
        "copyright"         => "",
        "favicon"           => "",
        "image"             => NULL
    ]) {


        /**
         * EXISTE UNA LIBRERIA LOGIN EN LA CUAL CARGA PARAMETROS ESPECIFICOS 
         * **/
        $this->load->library("login");
        
        
        $themes                     = $this->login->get_activate_theme();
        $addons                     = $this->login->get_addons();
        
        
        $params["addons"]           = $addons;
        $params['callable']         = $_REQUEST;
        $params['file_lang']        = $this->config->item('core_lang');


        /***
         * @author <rolignu90>
         * @description : algoritmo que verifica si existe un metodo get dentro del login
        **/


        $url            = dashboard_url();
        $curl           = current_url();
        $location       = str_replace($url , "" , $curl);
        $query          = $_SERVER['QUERY_STRING'];
        $location       = $location == null && $query == null ? "" : $location . "?" . $query;

        $params['query']    = $location;

        foreach ($themes->views as $views) {
            $this->load->view($views, $params);
        }


    }
    
    
    public function get_login()
    {



         /**
          * cargamos las librerias necesarias para el logueo de data
          * **/

         $this->load->library("encryption");


         /***
          * cifrado que aceptara garrobo
          */

         $this->encryption->initialize([
             'cipher'       => 'aes-256',
             'mode'         => 'ctr',
         ]);


         $user          = $_POST['username'] ?? NULL;
         $password      = $_POST['password'] ?? NULL;
         $lang          = $_POST['lang'] ?? "es";
         $lang          = $_COOKIE['lang'] ?? $lang;


         /**
          * verificamos el usuario si existe dentro de la base de datos
          * ver arreglo $this->query
          */

        $query_build   = str_replace("[table]", $this->db->dbprefix("user"), $this->my_querys['login']);
        $result        = $this->db->query($query_build , [$user , $user])->result()[0];



         $lang_data = new stdClass();
         $lang_data->error_user     = core_lang(["login" , "errors" , "user"]) ?? NULL;
         $lang_data->error_bdd      = core_lang(["login" , "errors" , "bdd"]) ?? NULL;
         $lang_data->error_activate = core_lang(["login" , "errors" , "activate"]) ?? NULL;
         $lang_data->error_password = core_lang(["login" , "errors" , "password"]) ?? NULL;

         if($result->count == 0)
         {
             return json_encode([
                            "error"      => 1,
                            "msj"        => $lang_data->error_user // error user not found
              ]);
         }


         /**
          * id del usuario
          * **/

         $id = $result->id;


         /**
          * segunda asignacion de query si
          * ver query en $this->query
          */

         $result = $this->db->query(str_replace("[table]",
                                $this->db
                                     ->dbprefix("user"),
                                $this->my_querys['login_filter'] ) ,
                                [
                                   $id
                                ])->result()[0];


         /**
          * resultados
          * **/




         if(count($result) == 0)
         {
              return json_encode([
                            "error"      => 1,
                            "msj"        => $lang_data->error_bdd
              ]);
         }



         if($result->active == 0)
         {
             return json_encode([
                            "error"      => 1,
                            "msj"        => $result->username . " " . $lang_data->error_activate
              ]);
         }


         $password_decrypt = $this->encryption->decrypt($result->password);


         if(!strcmp($password, $password_decrypt) == 0)
         {
              return json_encode([
                            "error"      => 1,
                            "msj"        => $result->username . " " . $lang_data->error_password
              ]);
         }




         $this->db->update($this->db->dbprefix("user") , [
             "connected"            => 1
         ] , [
             "id"   => $id
         ]);


         $class = new stdClass();
         $class->username           = $result->username;
         $class->password           = $password_decrypt;
         $class->last_connect       = $result->last_connect;
         $class->active             = $result->active;

         $data                      = json_decode($result->data);
         $privs                     = json_decode($result->privileges);

         $class->data               = $data;
         $class->privs              = $privs;
         $class->email              = $result->email;
         $class->id                 = $id;

        $this->load->library("meta");

        $lang = $this->meta->get_ByUser("user_lang" , $id);

        if($lang == null){

            $this->db->insert($this->db->dbprefix("metadata") , [
                $this->db->dbprefix("metadata") . ".key"        => "user_lang",
                $this->db->dbprefix("metadata") . ".value"      => "en",
                $this->db->dbprefix("metadata") . ".id_user"    => $id
            ]);


           $class->lang = 'en';


        }else{
            $class->lang = $lang;
        }



        $this->session->set_userdata($this->config->item("session_name") , $class);


        $this->load->library("logfile" , ["id" => $id , "command" => false ]);
        $this->logfile->Add("START SESSION" , " Start Session on %datetime%");



         return json_encode([
                            "error"             => 0,
                            "msj"               => site_url("/" . $this->config->item("backend")),
                            "user"              => $user ,
                            "lang"              => $lang ,
                            "token"             => $this->user->get_temp_token($id)
              ]);

    }


    /**
     * @todo inicia todos los componentes necesarios
     *       esto pueden ser librerias , helpers y las vistas
     * @return null no debe de retornar un valor ya que no se tomara en cuenta
     */
    public function _render($params = NULL)
    {
        // TODO: Implement _render() method.
        return $this->load->view("system/dashboard/index",'', TRUE);
    }


    public function get_admin_class($user)
    {



        $this->load->library("encryption");
        $this->load->database();

        /***
         * cifrado que aceptara garrobo
         */

            $this->encryption->initialize([
                'cipher'       => 'aes-256',
                'mode'         => 'ctr',
            ]);




            $result = $this->db->query(str_replace("[table]",
                    $this->db
                    ->dbprefix("user"),
            $this->my_querys['login_user_filter'] ) ,
            [
                $user
            ])->result()[0] ?? NULL ;


            if(is_null($result)) RETURN [];

            $password_decrypt = $this->encryption->decrypt($result->password);

            $class                     = new stdClass();
            $class->username           = $result->username;
            $class->password           = $password_decrypt;
            $class->last_connect       = $result->last_connect;
            $class->active             = $result->active;

            $data                      = json_decode($result->data);
            $privs                     = json_decode($result->privileges);

            $class->data               = $data;
            $class->privs              = $privs;
            $class->email              = $result->email;
            $class->id                 = $result->id;


            $this->load->library("meta");

            $lang = $this->meta->get_ByUser("user_lang" , $result->id);
            $class->lang = $lang;

            return $class;

    }

}
