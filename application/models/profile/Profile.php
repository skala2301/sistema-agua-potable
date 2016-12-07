<?php

/***
 * @version 1.0.5
 * @author Rolando Arriaza
 * @todo Perfil del usuario
**/


get_instance()->load->interfaces("Interface");

class Profile  extends  CI_Model implements CoreInterface
{

    private $querys = [
        "verify"    => "SELECT count(*) as 'count' FROM [table] WHERE username LIKE ? ",
        "status"    => "SELECT data FROM [table] WHERE username LIKE ?",
        "data"      => "SELECT data FROM [table] WHERE id LIKE ?"
    ];

    private $prefix = NULL;

    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->prefix           = new stdClass();
        $this->prefix->user     = $this->db->dbprefix("user");

    }


    /**
     * @todo inicia todos los componentes necesarios
     *       esto pueden ser librerias , helpers y las vistas
     * @return null no debe de retornar un valor ya que no se tomara en cuenta
     */
    public function _render($params = NULL)
    {
        // TODO: Implement _render() method.


        $avatar     = $this->user->get()->avatar();
        $user_data  = $this->user->all();
        $privs      = $this->user->get_user_privs_names();
        $connect    = $this->user->last_connect();

        $this->load->library("tools");
        $register     = $this->tools->PrettyDate($user_data->register);
        $languages    = $this->system->get_CoreLang();
        
        /**se agrego el tipo de usuario 17-nov-2016**/
        
        $this->load->library("usertype"); //carga la libreria 
        $this->usertype->_get(); // carga los datos
        $utype       = $this
                            ->usertype
                            ->Show($this->session->user_meta->user_type);
        

        return $this->load->view("system/profile/show" , [
            "user_data"         => $user_data,
            "avatar"            => $avatar,
            "privs"             => $privs,
            "register"          => $register,
            "connect"           => $connect,
            "languages"         => $languages,
            "utype"             => $utype
        ] , TRUE);
    }

    /**
     * @todo establece todas las dependencias css dentro del header
     * @example
     *
     *  <code>
     *
     *          format 1 :
     *
     *              return array(
     * 'http://hello.css',
     *                  'http://hello2.css'
     *              );
     *
     *          format 2 :
     *
     *              return array(
     * 'http://hello.css',
     *                  '<style>p { color: red; }</style>',
     *                  'http://hello2.css'
     *              );
     *
     *          format 3 :mixed array
     *
     *          return array(
     * 'http://hello.css',
     *                  '<style>p { color: red; }</style>',
     *                  'http://hello2.css',
     *                  array('http://hello3.css','http://hello4.css'),
     *                  array(
     * array('http://hello3.css','http://hello4.css'),
     *                          array(
     *                                 '<style>p { color: red; }</style>',
     *                                  array()
     *                          )
     *                  )
     *          );
     *
     *   Ok , is AWESOME write code into array mixed ! CODE IS FUN ¡
     *
     * </code>
     *
     * @return array , devuelve un arreglo con los css
     *
     */
    public function _css()
    {
        // TODO: Implement _css() method.
        return [
            print_css([
                "content/assets/dashboard/css/profile.css",
                "content/assets/dashboard/css/faq.css",
                "content/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css",
                "content/assets/global/plugins/bootstrap-toastr/toastr.min.css"
            ] , "url")
        ];
    }

    /**
     * @todo establece todas las dependencias js dentro del footer
     *
     * como un solo ejemplo tenemos la siguiente devolucion
     *
     *  return array(
     * "<script>console.log('hola babyes');</script>",
     * array("type" => "text/javascript" , "location" => "header" , "script" => "<script>alert('hello');</script>"),
     * "http://hola.js",
     * [
     * "http://hola2.js",
     * "http://hola3.js"
     * ]
     *
     *
     *     <code>
     *             como parametros especificos dentro de un arreglo tenemos :
     *
     *         array("type" => "text/javascript" , "location" => "header" , "script" => "<script>alert('hello');</script>")
     *
     *         type        = tipo de documento de javascript , puede ser babel
     *         location    = en donde se colocara el script en el "header" o "footer"
     *         script      = lo que uno quiera puede ser url o script puro.
     *
     *     </code>
     *
     *
     * @return array , devuelve un arreglo con las direcciones de los js
     *
     */
    public function _javascript()
    {
        // TODO: Implement _javascript() method.
        return [
            print_javascript([
                "content/assets/dashboard/js/profile.js",
                "content/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js",
                "content/assets/global/plugins/jquery.sparkline.min.js",
                "content/assets/global/plugins/bootstrap-toastr/toastr.min.js"
            ] , "url")
        ];
    }

    /**
     *
     * @deprecated 1.5
     * @todo establece funciones javascript dentro de DOM init o document.ready
     * @return array , devuelve un array donde iran las funciones
     * @example  arra("funcion1();" , "var func = function(){}" , ...);
     *
     */
    public function _actionScript()
    {
        // TODO: Implement _actionScript() method.
    }

    /**
     * @todo establece el titulo dentro del header
     * @return string , solo devuelve una cadena ...
     *
     */
    public function _title()
    {
        // TODO: Implement _title() method.
        return "Perfil";
    }

    /**
     * @todo funcion que requiere el nivel de seguridad de acuerdo a los roles
     *
     * <code>
     *
     *  ok privileges funciona para darle un nivel mas de seguridad y que no utilicen
     *  alguna back-door
     *
     *  puedes agregar privilegios estaticos o con algun algoritmo de seguridad que retorne
     *  el rol que se desea analizar o computar
     *
     *  esta funcion retorna valores mixtos
     *
     *  puede retornar un string de esta forma
     *
     *      return '1,2,3,4'
     *      return 'admin,user'
     *
     *      acepta estos tokens
     *
     *          [, | & % &]
     *
     *      entonces return '1%2%3' es aceptable
     *
     *      tambien puedes devolver un arreglo no asociado
     *
     *          return array('admin' , 'user' );
     *          return array(1,2,3);
     *
     * </code>
     *
     * @return string/null/array , retorna un nivel , ninguno  o varios
     */
    public function _privileges()
    {
        // TODO: Implement _privileges() method.
        return array("0");
    }

    /**
     * aca se carga todo lo que iniciara eventualmente en el dashboard
     * por medio de un proceso en segundo plano js
     */
    public function _actionScriptDashboard()
    {
        // TODO: Implement _actionScriptDashboard() method.
    }

    /**
     * actions es una funcion interfaz en cual verifica todas la acciones del sistema
     */
    public function _actions()
    {
        // TODO: Implement _actions() method.
    }


    /**
     * @todo save the profile
     * @author Rolando Arriaza
     * @errors: only the decimal types
     * @return json mime-type
    **/
    public function save_profile( )
    {

        if(sizeof($_POST) === 0) return  json_encode([
            "message" => "No items ",
            "error"   => TRUE,
            "type"    => 0
        ]);


        $user_session   = $this->config->item("session_name");
        $user           = $this->session->$user_session;
        $objects        = new stdClass();
        $objects->table = $this->prefix->user;
        
        if($user->username  != $_POST['user'])
        {
            $objects->query     = str_replace("[table]" , $objects->table , $this->querys['verify']);
            $result             = $this->db->query($objects->query , [$_POST['user']])->result();
            $count              = $result[0]->count ?? 0;

            if($count >= 1)
            {
                return json_encode([
                    "message" => "Este nombre de usuario ya existe !!",
                    "error"   => TRUE,
                    "type"    => 1
                ]);
            }
        }

        $objects->query         = str_replace("[table]" , $objects->table , $this->querys['status']);
        $result                 = $this->db->query($objects->query , [$user->username])->result();
        $data                   = json_decode($result[0]->data ?? '{}');

        if(sizeof($data) === 0)
            return  json_encode([
                "message" => "Usuario Errado, favor intentar denuevo o reflesca la pagina <a href='/admin/profile'>Recargar</a>",
                "error"   => TRUE,
                "type"    => 2
            ]);

        $details                    = $data->details;
        $details->name              = $_POST['name'];
        $details->last_name         = $_POST['last_name'];
        $details->occupation        = $_POST['occupation'];
        $details->location          = $_POST['location'];
        $details->website           = $_POST['website'];

        $data->details              = $details;


        $success                    = $this->db->update($this->prefix->user , [
                "username"      => $_POST['user'],
                "data"          => json_encode($data)
        ] , [ "username" => $user->username]);
        

        $user->username                 = $_POST['user'];
        $user->data->details            = $data->details;
        $this->session->$user_session   = $user;


        $this->load->library("logfile");
        $this->logfile->add("Edicion profile" ,"%username% has modificado tus datos el dia %datetime%");

        return  json_encode([
            "message" => "Tus datos han sido alterados con exito",
            "error"   => $success == true ? false : true,
            "type"    => 3
        ]);
    }



    /**
     * @todo ok get a log into a profile 
     * @author Rolando Arriaza
     * @errors: only the decimal types
     * @return json mime-type
     **/
    public function log_profile()
    {
        if(!is_array($_POST)) return json_encode([]);
        $this->load->library("logfile");
        $data = $this->logfile->ReadPage( $_POST['start']  , $_POST['count']  );

        return json_encode([
           "start"          => $_POST['start'] + $_POST['count'] ?? 10,
            "count"         => $_POST['count'] ?? 10,
            "data"          => $data
        ]);
    }

    /**
     * @todo function save_avatar
     * @author Rolando Arriaza <rolignu90@gmail.com>
     * @error codes :
     *          0x00 => 0   : method post is empty
     *          0x02 => 2  : image is null | dont continue
     *          0x03 => 3  : details in user not exist
     *          0x01 => 1  : the upload is failed , check please de privileges of directories
     *          0x1000 => 4096 : everything is good !! negeric code
     * @return json mime
    **/
    public function save_avatar()
    {


        //where save the image
        $save_avatar = $this->config->item("avatar_files");


        //if not exist the directory , create
        if(!is_dir($save_avatar))
        {
            if(!@mkdir($save_avatar , 0777))
            {
                if(sizeof($_POST) === 0) return  json_encode([
                    "message"   => core_lang([ "system" , "core" , "request" , "error_create_file" ]),
                    "error"     => TRUE,
                    "type"      => 0x00
                ]);
            }
        }


        //show if exist the post method
        if(sizeof($_POST) === 0) return  json_encode([
            "message"   => core_lang([ "system" , "core" , "request" , "error_image_upload" ]),
            "error"     => TRUE,
            "type"      => 0x00
        ]);


        //get the image
        $image = isset($_POST['image']) ? explode("," , $_POST['image']) : NULL  ;


        //in case is null send a error
        if(is_null($image)) return  json_encode([
            "message"   => core_lang([ "system" , "core" , "request" , "error_image_upload" ]),
            "error"     => TRUE,
            "type"      => 0x02
        ]);



        //ok get load a library string
        $this->load->helper(["string", "file"]);


        //get a type of image
        $type     = $_POST['type'] ?? NULL;


        //is null type try to get type to another method
        if(!is_null($type))
        {
            $des        = explode("/" , $type);
            $type       = end($des);
        }


        //get a random name image
        $image_id = random_string() . "-avatar-" . $_POST['name'] ?? $type;


        //put the image , after this convert base 64 to binary
        $success = @file_put_contents($save_avatar . $image_id , base64_decode(end($image)));


        //if not success , ok dont worry sent a error
        if(!$success)
        {
            return  json_encode([
                "message"   => core_lang([ "system" , "core" , "request" , "error_image_upload" ]),
                "error"     => TRUE,
                "type"      => 0x01
            ]);
        }


        //get id user
        $id_user = $this->user->get()->id();

        //update the current avatar to the new avatar file
        $this->user->set_avatar($image_id);


        $query    = str_replace("[table]" , $this->prefix->user , $this->querys['data']);
        $get_data = $this->db->query($query , [$id_user])->result()[0]->data;

        $d = json_decode($get_data);
        $details  = $d->details ?? NULL;

        if(is_null($details))
        {
            unlink($save_avatar . $image_id);

            return  json_encode([
                "message"   => core_lang([ "system" , "core" , "request" , "error_image_upload" ]),
                "error"     => TRUE,
                "type"      => 0x03
            ]);
        }

        if(!empty($details->avatar) || !is_null($details->avatar))
        {
            @unlink($save_avatar . $details->avatar);
        }


        $details->avatar = $image_id;
        $d->details      = $details;


        $this->db->update($this->prefix->user , [
            "data"  => json_encode($d)
        ] ,[
            "id" => $id_user
        ]);

        $this->load->library("logfile");
        $this->logfile->add( "Avatar " ,"%username% " . core_lang(["log" , "profile" , "avatar"]) . " %datetime%");

        return  json_encode([
            "message"   => site_url($save_avatar . $image_id),
            "error"     => FALSE,
            "type"      => 0x1000
        ]);
        
    }


    /**
     * @todo function save_avatar
     * @author Rolando Arriaza <rolignu90@gmail.com>
     * @error codes :
     *          
     * @return json mime
     **/
    public function save_password()
    {
        
        if(count($_POST) == 0)
        {
            return json_encode([
                "message"   => core_lang([ "system" , "core" , "request" , "error_password_empty" ]),
                "error"     => TRUE,
                "type"      => 0x00
            ]);
        }

        $user_pass          = $this->user->get()->password();
        $id                 = $this->user->id();
        $last_passwords     = $this->user->all()->last_password;
        $udata              = $this->user->get_db_data();

        if(strcmp($user_pass , $_POST['oldpass']) != 0)
        {
            return json_encode([
                "message"   => core_lang([ "system" , "core" , "request" , "error_password_equals" ]),
                "error"     => TRUE,
                "type"      => 0x01
            ]);
        }



        if(count($last_passwords) != 0)
        {


            foreach($last_passwords as $pass)
            {
                if($pass === $_POST['newpass'])
                {
                    return json_encode([
                        "message"   => core_lang([ "system"
                                                    , "core"
                                                    , "request" 
                                                    , "error_password_used" ] , ["[%denied%]" => $pass]),
                        "error"     => TRUE,
                        "type"      => 0x01
                    ]);
                }
            }
            
        }


        $repass = (array) $udata->last_passwords;
        array_push($repass , $_POST['oldpass']);
        $udata->last_passwords = $repass;




        /**
         *  the library user new features
         *  of database manipulation added in its version 1.1.2 so
         *  the query makes the call data will become obsolete
        **/



        $this->load->library("encryption");

        /***
         * cifrado que aceptara garrobo
         */

        $this->encryption->initialize([
            'cipher'       => 'aes-256',
            'mode'         => 'ctr',
        ]);


        $new_pass_encrypt = $this->encryption->encrypt($_POST['newpass']);

        $ok = $this->user->update_password($new_pass_encrypt);
        
        if($ok)
        {
            $this->user->set_db_data($udata);
            return json_encode([
                "message"   => core_lang([ "system" , "core" , "request" , "success_password_change" ]),
                "error"     => FALSE,
                "type"      => 0x01
            ]);
        }

        $this->load->library("logfile");
        $this->logfile->add( "Password " ,"%username% " . core_lang(["log" , "profile" , "password" , "password_change"]) . " %datetime%");


        return json_encode([
            "message"   => core_lang([ "system" , "core" , "request" , "error_database" ]),
            "error"     => TRUE,
            "type"      => 0x02
        ]);


    }



    public function  save_advance()
    {

        if(count($_POST) == 0) return json_encode([
            "message"   => core_lang([ "system" , "core" , "request" , "error_advance" ]),
            "error"     => TRUE,
            "type"      => 0x1001
        ]);


        $this->load->library("meta");

        $id = $this->user->get()->id();

        if($id == null || empty($id))
            return json_encode([
                "message"   => core_lang([ "system" , "core" , "request" , "error_advance" ]),
                "error"     => TRUE,
                "type"      => 0x1002
            ]);



        $lang = $_POST['lang'];
        $state = $this->meta->Update_ByUser("user_lang" , $lang , $id);
        
        

        switch($state)
        {
            case TRUE:
                return json_encode([
                    "message"   => core_lang([ "system" , "core" , "request" , "success_advance" ]),
                    "error"     => FALSE,
                    "type"      => 0x1003,
                    "call"      => $lang
                ]);
                $_COOKIE['lang'] = $lang ?? "en";
                $this->user->get()->set_lang($lang);
                break;
            case FALSE:
                return json_encode([
                    "message"   => core_lang([ "system" , "core" , "request" , "error_advance" ]),
                    "error"     => TRUE,
                    "type"      => 0x1004
                ]);
                break;
        }
        

    }

}