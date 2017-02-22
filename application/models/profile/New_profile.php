<?php


class New_profile extends CI_Model implements CoreInterface
{


    protected $user_table = "user";


    public function __construct()
    {
        parent::__construct();
        $this->load->model("profile/profile_functions");
    }

    /**
     * @todo inicia todos los componentes necesarios
     *       esto pueden ser librerias , helpers y las vistas
     * @return null no debe de retornar un valor ya que no se tomara en cuenta
     *
     * @example  to load view
     *
     *          return $this->load->view('view file' , $params , TRUE);
     *
     *          OR
     *
     *          return $this->load->view('view file' , '' , TRUE);
     *
     * Don´t forget the return  and the boolean TRUE
     *
     */
    public function _render($params = NULL)
    {
        // TODO: Implement _render() method.

        $rols = $this->profile_functions->get_rols();

        return  $this->load->view('system/profile/new_user' , [
            "rols" => $rols
        ] ,TRUE);
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
        return "Nuevo usuario";
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


    public function check_user()
    {

        $this->load->model("profile/profile_functions");

        $user   = $_POST['user'] ?? NULL;
        $email  = $_POST['email'] ?? NULL;

        $report = [];

        if(!is_null($user)){
            $exist = $this->profile_functions->exist_user($user);
            $report['user'] = $exist;
        }else{
            $report['user'] = true ;
        }

        if(!is_null($email))
        {
            $exist = $this->profile_functions->get_users_email($email);
            $report['email'] = $exist >= 1 ? true : false ;
        }
        else{
            $report['email'] = true;
        }

       return json_encode($report);

    }


    public function save()
    {

        $data = $this->input->post("data") ?? null ;
        $rol  = $this->input->post("rol") ?? 0;

        if(is_null($data))
            return json_encode([
                "status"        => false ,
                "msj"           => "No existen datos a registrar"
            ]);


        $values = null ;
        parse_str($data , $values);
        $values = (object) $values;


        $this->load->library("encryption");
        $this->load->helper(["string"]);
        $this->load->library("messages");

        $this->encryption->initialize([
            'cipher'       => 'aes-256',
            'mode'         => 'ctr',
        ]);



        $password_              = random_string();
        $password_encrypt       = $this->encryption->encrypt($password_);

        $names = " " . $values->name . " " . $values->last_name;

        /*Array
        (
            [name] => pruebaA
            [last_name] => prueba2
            [user] => pp248
            [occupation] => TESTER QA
            [email] => rolsignu90@gmail.com
        )*/

       // print_r($rol);
       // return ;

        $privs              = new stdClass();
        $privs->parent      = $rol;
        $privs->childs      = "";



        /**
         *
         * {
                "details": {
                "name": "Administrador ",
                "last_name": "Smart Water ",
                "register": "2016-06-19",
                "avatar": "3SbInzFt-avatar-smart.png",
                "occupation": "Supervisor",
                "location": "El Salvador",
                "website": "www.smartwatersv.com"
                },
                "last_passwords": {}
            }
         *
        **/

        $date = new DateTime("now");
        $data = new stdClass();
        $data->details = new stdClass();
        $data->details->name            = $values->name;
        $data->details->last_name       = $values->last_name;
        $data->details->register        = $date->format("Y-m-d");
        $data->details->avatar          = "";
        $data->details->location        = "El Salvador";
        $data->details->website         = "No tengo sitio web :(";
        $data->last_passwords           = new stdClass();


        $result = $this->profile_functions->new_user([
            "id_operator"       => random_string(),
            "username"          => $values->user,
            "email"             => $values->email,
            "password"          => $password_encrypt,
            "privileges"        => json_encode($privs),
            "data"              => json_encode($data),
            "active"            => 1,
            "user_type"         => "-U"
        ]);



        if($result == 0 ){
            return json_encode([
                "status"        => false ,
                "msj"           => "Ocurro un error al momento de procesar este usuario , intentar denuevo"
            ]);
        }


        $this->messages
            ->emailFrom()
            ->email_subject("Contraseña para el sistema SMART WATER  ")
            ->email_to($values->email)
            ->email_body($this->email_body($password_ , $names , $values->user))
            ->email_send();


        return json_encode([
            "status"        => true ,
            "msj"           => "El usuario " . $values->user . " se ha creado con exito "
        ]);
        
    }


    protected function email_body ($password , $name , $user ){

        $ci = &get_instance();
        $ci->load->helper("url");

        $url    = site_url();

        return    "<body>"
                . "<h2>Hola $name </h2>"
                . "<p></p>"
                . "<P>Tu usuario es $user</P>"
                . "<p>Tu contraseña es <b>$password</b></p>"
                . "<p></p>"
                . "<a href='$url' >ingresa aqui </a>";

    }



}