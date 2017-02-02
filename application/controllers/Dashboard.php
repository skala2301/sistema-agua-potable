<?php

/**
 *@author: Rolando Arriaza
 *@version: 1.2.6
 *@type: system
 *@name: Controlador de dashboard
 *@description : el controlador mas importante del sistema MVA
 *@id : system
 *@Last update : 19-01-2016
 *@Garrobo system ...
 *
 * ------------------------------------------------------------------------
 *                  LO NUEVO EN LAS VERSIONES
 * ------------------------------------------------------------------------
 *
 * ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
 *
 * 1.1.0
 *      ---CREACION DE LA NUEVA INTERFAZ CoreInterfaz
 *      ---DESARROLLO DE ALGORITMOS NUEVOS
 *      ---APLICACION DE FRONT Y BACK
 *      ---SEMANTICA MEJORADA
 *
 * 1.1.1
 *
 *      --garrobo configuraciones iniciales , alistando login
 *      -- interfaz mejorada , mejora de data
 *      -- mejora de rendimiento 10 milisegundos de su predecesor
 *
 * 1.1.2
 *
 *      --  sistema asincrono e interfaz armonica con XHR para multiples peticiones
 *      --  bug fixed rutas absolutas
 *      --  bug fixed core index
 *      --  nueva instancia $ga_ para objetos del systema garrobo
 *      -- se depreco $app->action_javascript() aca y en la interfaz
 *
 * 1.1.4
 *
 *      -- se agrego shortcode
 *      -- bug en sistema de privilegios arreglado
 *
 * 1.1.5
 *
 *      -- se agrego system como parte de shortcode
 *      -- sintaxis de system tag {$funcion , valor1 , valor2 } o {$funcion, [ valor1,valor2,valor3]}
 *
 * 1.1.6 - 1.1.9
 *
 *      -- se agrego el sistema de plugin para la interfaz MVA de garrobo
 *      -- this->load->plugin()
 *
 * 1.2.0
 *
 *      -- nuevo parametro de lenguaje . se guarda dentro de SESIONES el lenguaje seleccionado
 *      -- bug fixed plivigeleges
 *      -- new garrobo functions
 *
 * 1.2.1
 *      -- Bug fixed languaje taxonomy
 *
 * 1.2.2
 *      -- Bug security session fixed
 * 1.2.3
 *      -- Nuevo query de redireccion, esto funciona cuando un usuario se le ha enviado
 *         un link que tiene como fin hacer una redireccion como por ejemplo
 *         /admin/system=hi?data=true&mail=true
 *         donde dice que se hara una redireccion cuyos parametros son booleanos
 *         si el usuario no tiene sesion activa entonces se mantendra la redireccion en cualquier ambito
 * 1.2.4
 *      -- bug fixed , sistema de accesos o privilegios | se reparo un bug en el cual se le otorgaba accesos
 *                      solo conociendo la URL
 *      -- expansion de la libreria meta
 *      -- ajustes en la libreria system
 *      -- reordenamiento de directorios
 *      -- creacion de la vista de acceso denegado para MVA y XHR
 *
 * 1.2.5
 *      -- se le agregara el sistema de privilegios por medio de invocaciones padre e hijo [on version 1.2.9]
 *      -- se agregar en el sistema de privilegios tiempo de expiracion rol para los hijos [on version 1.2.9]
 *      -- se ajustara la libreria de privileges [0--->100]
 *      -- se programara el modulo de smtp email [on version 1.2.6]
 *      -- reparacion del bug cerrar sesion de forma forzada [0-->100]
 *      -- reparacion del bug en sidebar privilegios session->admin a otra session [0-->100]
 *      -- reparacion del bug en variable de session lang (reflescar si todavia no ha caducado)
 *
 * 1.2.6
 *
 *      -- se generalizo el model de error o ga_error
 *      -- se elimino codigo deprecado en versiones anteriores
 *      -- se eliminaron variables si usar
 *
 *
 */


class Dashboard extends CI_Controller {



    //RUTA PROTEGIDA VERSION 1.0.0
    protected $route = NULL;

    //INSTALACION DE LA APLICACION DESDE LA VERSION 1.0.0
    protected $app_setup = NULL;

    //Directorio donde contiene el multilenguaje del sistema version 1.0.1
    protected $lang_file = "";

    //control front y admin
    private $controls               = [];

    //Verifica si existe la sesion es un valor booleano
    private $session_exist          = FALSE;

    //USUARIO VERSION 1.1.0
    var $user_p                     = NULL;

    //LOGIN CONTROLLER VERSION 1.0.0
    var $backend                    = NULL;

    //MAIN CONTROLLER ADD IN VERSION 1.0.2
    var $main_controller            = NULL;

    //TOKEN ADD IN VERSION 1.1
    var $token                      = NULL;

    //VARIABLE DE SESION
    var $data_session               = NULL;

    //VARIABLE DE LANG es , en , jap etc
    var $lang                       = NULL;


    public function __construct()
    {



        try {

            parent::__construct();

        } catch (Exception $ex) {


            trigger_error("Error critico en el systema de carga -->"
                . $ex->getMessage() . " [Line:]"
                . $ex->getLine());

            $this->ga_error->create_error(
                            $ex->getMessage() ,
                            "Error critico en el sistema de carga",
                            "system",
                            "Dashboard.php / __construct"
            );

            $this->error_404();
        }



        /**
         * contructor del MVA (modelo vista adaptador)
         * @author Rolando Arriaza
         * @since 1.0
         * * */
        /**
         * Librerias de inicio o necesarias
         * * */
        $this->load->helper(["setup"]);


        /**
         * Garrobo system
         **/
        $this->load->model("system/system_core", "garrobo");

        /**
         * Libreria session se coloca en autoload como por defecto
         * * */
        $this->load->library("Base_url"); // libreria de url ver libreria
        $this->load->library("System"); //libreria del sistema en general
        $this->load->library("Tools"); //libreria de herramientas
        $this->load->library("Routes"); // libreria de rutas del sistema

        //URL BASE , SUSTITUIDA POR base_url();
        $this->route = $this->base_url->GetBaseUrl();


        //AGREGAR EL TIMEZONE POR DEFECTO
        //SE NECESITA PARA SERVIDORES CUYO TIMEZONES SON UTF
        $this->tools->default_timezone();


        /**
         * Lang core file ...
         * asiganacion del archivo json de lenguaje para el core o nucleo
         * * */
        $this->lang_file = $this->config->item("core_lang");


        /**
         * Configuracion del sistema desde la version 1.6.2
         * la configuracion se caracteriza como un vector de objetos
         * * */


        $this->app_setup = ! is_null($this->config->item('app_config_encode'))
                                ? @json_decode($this->config->item('app_config_encode')) : FALSE;





        /**
         * login controller, se volvio dinamico ya que uno puede programar
         * su propio login siempre de forma de controlador. desde la version 1.6.2
         * */
        $this->backend = $this->config->item("backend");


        /**
         * Control del del sistema principal o ruta principal
         * * */
        $this->main_controller = $this->config->item("setup_")['main'];


        /**
         * token con los que se manejan los models
         * ** */
        $this->token = $this->config->item("setup_")['token'];



        /***
         * Security : if app is null or empty retun a false
         *            this return say to system is not override
        **/

        if(!$this->app_setup) {


            $this->ga_error->create_error(
                "la configuracion app_setup no se encuentra disponible"
                . "Servidor : "
                . $_SERVER['SERVER_NAME']
                . ", Documento raiz : "
                . $_SERVER['DOCUMENT_ROOT']
                . ", IP usuario : "
                . $_SERVER['REMOTE_ADDR']
                ,
                "Error, No se encuentra la variable de (app_setup)",
                "system",
                "Dashboard.php / __construct"
            );

            return false;
        }


        /**
         * app lenguaje
         * esta variable no es global en su naturaleza
         * pero puede ser super global en cualquier defecto
         *
         * $_REQUEST['lang'] = es su llamado por defecto
         *
         * dado asi encualquier metodo get o post se puede interactuar
         *
         * ejemplo en un formulario
         *
         *      <input type="hiden" name="lang" value ="es">
         *
         * el input es de valor escondido o oculto en la cual colocaremos
         * es o en como acronimo de español o ingles , es un ejemplo
         * de acuerdo al desarrollador se pueden agregar mas lenguas
         *
         * * */


        if(isset($_REQUEST['lang'])){

            backend_session_lang_set($_REQUEST['lang']);
            if(is_null(get_cookie("lang"))) $_COOKIE['lang'] = $_REQUEST['lang'];
        }
        else if(is_null(backend_session_lang())
            || backend_session_lang() !=  $this->user->get()->user_lang())
        {

            $user_lang   = $this->user->get()->user_lang();

            if(is_null($user_lang))
                $user_lang   =  $this->app_setup->language;

            backend_session_lang_set($user_lang);

        }

        $this->lang = backend_session_lang();



        $this->controls = [
            "front",
            "Front",
            "l",
            "i"
        ];


        /**
         * variable de seguridad , verifica en el constructor
         * si existe una sesion activa en la cual se podria confiar
         * al usuario activo distintos verbos
         *
         * esto ayuda a que establecimientos y metodos de salidas sean leidos
         * por usuarios externos tratando de dañar la integridad del sistema
         * **/


        $this->session_exist = $this->session->has_userdata($this->config->item("session_name"));

    }

    /**
     * INDEX PRINCIPAL SU RUTA ES :
     *
     *    $route['0']  = 'dashboard/index';
     *    $route['0/([a-z_-]+)'
      .                   system_token()
      .                   '([a-z_-]+)'] = 'dashboard/index/$1=$2';
     *
     *
     * VERSION 1.5.5
     *
     *          IMPLEMENTACION DE RUTAS ... O PRETTY ROUTES
     *
     *
     * * */


    public function index($model = NULL) {



        /**
         * bug fixed : if a system not override or path files not chmod +x | 777
         *              the file config can´t read, them app not initialize.
        **/

        if(!$this->app_setup)
        {
            $this->load->view("errors/html/override");
            return;
        }


        /**
         * @security session start
         * @since 10-oct-2016
         * @todo bug de seguridad reparada en la version 1.2.2
         *       este parche hace que las sesiones que no se disparan en el model admin_core
         *       genere un token , este token unico y temporal solo dura un par de segundos en lo
         *       que valida que la sesion fue correcta pero no arranco (problemas con xss)
         *       inicia una nueva sesion al usuario asignado sin necesidad de validar contraseña
         *       denuevo o que viaje esa contraseña por el verbosite , el token es como el password
         *       pero temporal, se conecta con la tabla dump o ga_dump depende del prefijo
        ***/


        $temp_token     = $this->input->get("token"); //security token
        $user_name      = $this->input->get("u"); // security username
        $token_active   = $this->user->compare_temp_token($temp_token);


        $redirect       = false;

        if($token_active >= 1)
        {

            $this->load->model("system/admin_core");
            $class                  = $this->admin_core->get_admin_class($user_name) ;
            $sess                   = $this->config->item('session_name');

            if(sizeof($class) != 0){
                $this->session->$sess   = $class;
                $redirect = true;
            }

        }

        unset($_GET['token'], $_GET['u']);


        $buid_query     = $_GET;

        $this->user->destroy_temp_token($temp_token);

        /**
         * Fin del algoritmo Session token
        **/

        
        /**Nuevas variables de carga de sesion**/
        
        if(!isset($this->session->user_meta))
        {
            $this->session->user_meta = new stdClass();
        }
        
        
        /*  
         * constantes dentro del entorno user_meta
         * **/
        
        if(!isset($this->session->user_meta->user_type) 
                || empty($this->session->user_meta->user_type))
        {
            $this->session
                    ->user_meta->user_type = $this->user->get_user_type();
        }


        if($redirect){
            $p = count($buid_query) >= 1 ?  "?" . http_build_query($buid_query) : "";
            redirect(current_url() . $p );
        }


        //version 1.0.0
        error_reporting(0); //reporte de errores reportar todos los errores
        //en la version 1.0
        ob_start(); //bufer de salida inicio


        /**
         * Documentacion acerca la logica del sistema dashboard/index
         *
         *  Rutas en las cuales se utilizaran:
         *  $route['0/([a-z_-]+)=([a-z_-]+)']   = 'dashboard/index/$1=$2';
         *  $route['0']                         = 'dashboard/index';
         *
         *  Esta funcion realiza lo que es el paradigma MVA (modelo vista adaptador)
         *  El controlador que estamos refiriendo lo transformaremos en adaptador
         *
         *  las instrucciones que pasan por el filtro son las siguientes:
         *
         *          patron : directorio/model == directorio=model == direcrorio(token)model
         *          patron : model == model
         *
         *  el primer patron es el mas importante ya que realiza una jerarquia
         *          primer nivel : directorio (donde alojas el model)
         *          segundo nivel: model (nombre del modelo)
         *
         *   ejemplo : usuario=user_name / usuario = directorio / user_name = model
         *
         */



        $route = $this->routes->Get($model);



        /**
         * Reescritura del core
         * ** */
        foreach ($this->controls as $control) {
            if ($control === $route || $control === $model) {
                $this->front();
                ob_end_flush(); //bufer de salida
                return;
            }
        }

        if ($route == NULL) {
            $route = "system=admin_core";
        }


        /**
         * INICIO DE SESION , SE PERMITIRAN TRES TIPOS DE METODOS DE TIPO VERBOSITE GET
         * POR REDIRECCION O POR LLAMADA
         *
         * primer metodo es call que se lee en $_GET['call'] esto permitira llamar a un MVA
         * segundo metodo es redirect donde permitira el systema hacer una redirecion al momento del logueo
         * tercer metodo es pasar varaibles indefinidas por el sistema
         *
         *          ejemplos:
         *
         *      primer metodo
         *
         *          /admin?call=system=admin
         *
         *      segundo metodo :
         *
         *          /admin?redirect=[MVA o url a redireccionar]
         *
         *      tercer metodo :
         *
         *          /admin?param1=&param2=&param3=
         *
         *      cualquier parametro
         *
         * ** */


        
        if (!$this->session->has_userdata($this->config->item("session_name"))) {

            $this->load->model("system/admin_core", "admin");

            $this->admin->load_login([
                "title"             => $this->app_setup->name,
                "author"            => $this->app_setup->author,
                "description"       => $this->app_setup->description,
                "copyright"         => $this->app_setup->copyright,
                "favicon"           => $this->app_setup->favicon,
                "image"             => $this->app_setup->image
            ]);



            return;
        }

        /**
         * variables iniciales
         * * */
        $dir = NULL;
        $app = NULL;

        /**
         * verificamos si la ruta es nula
         * o verificamos si es por medio de patron model
         * explode obtiene un arreglo especifico
         *
         *  $explode[0] = directorio
         *  $explode[1] = app
         */
        $explode = !is_null($route) ?
                        explode($this->token, $route):
                        explode($this->token, $model);


        try {

            /**
             * es posible que un sistema reciba entradas y salidas tanto como del cliente y el servidor
             * si enlazamos XHR y SERVER , tendremos un sistema en armonia.
             *
             * garrobo en su nucleo logra esa armonia con un poco de codigo y mucho pensamiento logico
             * aplicando el mismo patron de diseño MVA (modelo vista adaptador)
             *
             * aplicando tambien una variable y ver que lo que pasa en el server lo demas es mas simple
            ***/

            $xhr          = FALSE;   // metodo de entrada seleccionado




            /**
             * verificamos el metodo de entrada
             * linea de codigo deprecada , sustituida por is_ajax_request
             **/


            /*if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])
                && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                $xhr = TRUE;
            }*/


            /**
             * METODO DE ENTRADA SE CAMBIO POR AJAX_REQUEST DE CI
            **/
            $xhr = $this->input->is_ajax_request() ?? FALSE;


            /**
             * sabemos que debemos de controlar cada error
             * todo tipo de excepciones para que la app
             * sea segura , se ha colocado una funcion
             * llamada error_404 en la cual esta expendio al cambio
             * * */

            $model_intern       = check_model($explode); // modelo interno
            $plugin_intern      = check_plugin($explode); //checamos los plugins

            $priority           = 0;

            if(!$model_intern  && !$plugin_intern)
                $priority = -1;
            else if($plugin_intern)
                $priority = 1;
            else $priority = 0;

            if ($priority == -1) {
                if($xhr)
                {
                    $error = $this->error_404("json");

                    $output        = json_encode([
                        "view"             => $error  ,
                        "css"              => array(),
                        "js"               => array(),
                        "id"               => random_string('sha1'),
                        "title"            => "Error 404"
                    ],    JSON_HEX_TAG
                        | JSON_HEX_APOS
                        | JSON_HEX_QUOT
                        | JSON_HEX_AMP
                        | JSON_UNESCAPED_UNICODE
                    );

                    $this->output
                        ->set_content_type('application/json')
                        ->set_output($output);
                }
                else
                {
                    $this->error_404();
                }
                return;
            }



            /**
             * pasamos lo parametros correspondientes en las variables
             */

            $dir            = $explode[0] ?? NULL;      // directorio
            $app            = $explode[1] ?? NULL;      // modelo a cargar



            /**
             * Load apps to system core ...
             */

            switch ($priority)
            {
                case 0:
                    $this->load->model("$dir/$app");
                    break;
                case 1:
                    $this->load->plugin("$dir/$app");
                    break;
            }
            
            


            /**
             * verificamos si existe una interfaz
             * si la interfaz no existe entonces ni modo
             * error , ya que mva se necesita de una interfaz
             * */
            $interface = class_implements($this->$app);


            if (count($interface) == 0) {
                if($xhr)
                {
                    $error = $this->error_404("json");

                    $output        = json_encode([
                        "view"             => $error  ,
                        "css"              => array(),
                        "js"               => array(),
                        "id"               => random_string('sha1'),
                        "title"            => "Error 404"
                    ],    JSON_HEX_TAG
                        | JSON_HEX_APOS
                        | JSON_HEX_QUOT
                        | JSON_HEX_AMP
                        | JSON_UNESCAPED_UNICODE
                    );

                    $this->output
                        ->set_content_type('application/json')
                        ->set_output($output);

                }
                else
                {
                    $this->error_404();
                }
                return;
            }



            /**
             * obtenemos los privilegios correspondientes
             *
             * NULL , "" , '' , array() , -> todos los privilegios
             * BOOLEAN TRUE , FALSE  -->privilegios granted
             *
             * ** */
            $app_access = $this->$app->_privileges();



            /**
             * @version 1.1.0
             * @author Rolando Arriaza
             * @todo Privileges library
             *       libreria de privilegios dinamicos o estaticos
             * * */

            $access = $this->privileges->compute($app_access, $route)->result();



            //print_r($access);
            //return ;


            if(!$access)
            {
                if($xhr)
              {
                  $denied = $this->access_denied("json");

                  $output        = json_encode([
                      "view"             => $denied  ,
                      "css"              => array(),
                      "js"               => array(),
                      "id"               => random_string('sha1'),
                      "title"            => "Acess denied | OMG !!"
                  ],    JSON_HEX_TAG
                      | JSON_HEX_APOS
                      | JSON_HEX_QUOT
                      | JSON_HEX_AMP
                      | JSON_UNESCAPED_UNICODE
                  );

                  $this->output
                      ->set_content_type('application/json')
                      ->set_output($output);

              }
              else
              {
                  $this->access_denied("server");
              }


              return;
            }



            /**
             * variables dependientes
             * * */


            $title = $this
                    ->$app
                    ->_title();

            $app_css = $this
                    ->$app
                    ->_css();


            $app_js = $this
                    ->$app
                    ->_javascript();





            /**
             * @todo  $this->system , System.php dentro de library
             * @category Garrobo System
             * * */



            if(!$xhr) {


                $view_  = $this->shortcodes->set($this->$app->_render())->compute();

                $this->system->set_headers([
                    "title"         => $title,
                    "css_apps"      => $app_css,
                    "lang"          => $this->lang,
                    "author"        => $this->app_setup->author,
                    "description"   => $this->app_setup->description,
                    "copyright"     => $this->app_setup->copyright,
                    "favicon"       => $this->app_setup->favicon,
                    "logo"          => $this->app_setup->image,
                    "js"            => $app_js,
                    "js_apps"       => $app_js,
                    "render"        => $view_,
                    "entry"         => $app == "admin_core" ? "dashboard" : "no-dashboard"
                ]);


                $this->system->set_footers([
                    "js_apps"            => $app_js
                ]);
            }
            else {


                 $view_          = $this->shortcodes->set($this->$app->_render())->compute();
                 $output        = json_encode([
                     "view"             => $view_  ,
                     "css"              => $app_css,
                     "js"               => $app_js,
                     "id"               => random_string('sha1'),
                     "title"            => $title
                 ],    JSON_HEX_TAG
                     | JSON_HEX_APOS
                     | JSON_HEX_QUOT
                     | JSON_HEX_AMP
                     | JSON_UNESCAPED_UNICODE
                 );

                $this->output
                        ->set_content_type('application/json')
                        ->set_output($output);
            }


        } catch (Exception $ex) {
            trigger_error("Error IN:" . $ex->getMessage());
            if($xhr)
            {
                $error = $this->error_404("json");

                $output        = json_encode([
                    "view"             => $error  ,
                    "css"              => array(),
                    "js"               => array(),
                    "id"               => random_string('sha1'),
                    "title"            => "Error 404"
                ],    JSON_HEX_TAG
                    | JSON_HEX_APOS
                    | JSON_HEX_QUOT
                    | JSON_HEX_AMP
                    | JSON_UNESCAPED_UNICODE
                );

                $this->output
                    ->set_content_type('application/json')
                    ->set_output($output);

            }
            else
            {
                $this->error_404();
            }
            return;
        }



        ob_end_flush(); //bufer de salida
    }

    /**
     * @version 1.0
     * @author Rolando Arriaza
     * @todo
     *      Funcion error del servidor 500 xxx
     * * */
    public function error_500($server = "server" ) {
        $this->load->view($this->config->item("view_errors")['500_']);
    }

    /**
     * @version 1.0
     * @author Rolando Arriaza
     * @todo
     *      Funcion error del servidor 500 xxx
     * */
    public function error_404($server = "server") {
         if($server == "server")
                $this->garrobo->Error404($server);
        else
            return $this->garrobo->Error404($server);
    }


    /**
     * @version 1.0.0
     * @author Rolando Arriaza
     * @todo Access denied function
    **/
    public function access_denied($server = "server")
    {
      if($server == "server")
         $this->garrobo->denied($server);
      else
         return $this->garrobo->denied($server);
    }



    /**
     * @version 1.0.0
     * @author Rolando Arriaza
     * @param array $args
     * @todo Front end callable
    **/
    public function front(array $args = array()) {
            redirect($this->config->item("frontend")->prefix);
    }


    /**
     * Controlador de descarga de archivos
     * VERSION 1.5
     * SINCE 1.5.6
     *
     * INPUTS
     *
     * GET METHOD :
     *          -variables mediantes el metodo get
     *          - nombres:
     *
     *                      dir  = string
     *                      file = string
     *                      name = string
     *                      ext  = string
     *           ejemplo:  ?dir=files/location/directory
     *                     ?file=xhrgrd
     *                     ?name=hello.png
     *                     ?ext=png
     *      SI ?name conlleva la extension no es necesario utilizar la variable ext
     *          en el input get
     *
     * CONTROLLER METHOD:
     *
     *          similar al metodo get sus variables se representan dentro de los
     *          parametros de la funcion Download
     *
     *          Obtencion de parametros mediante Url
     *
     *          http://domain.com/Dashboard/Download/$dir/$file/$name/$extend
     *
     *          $dir = directorio donde se aloja el archivo
     *
     *                  por terminos de seguridad en url parse
     *                  el caracter "/" se remplazara por "="
     *                  entonces como quedara la ruta del archivo
     *
     *                  ruta normal files/data/provider/
     *
     *                       nueva ruta files=data=provider
     */
    public function Download( $directory = NULL, $file = NULL, $name = NULL, $extend = NULL) {


        $_dir = isset($_REQUEST['dir']) ? $_REQUEST['dir'] : $directory;
        $_file = isset($_REQUEST['file']) ? $_REQUEST['file'] : $file;
        $_name = isset($_REQUEST['name']) ? $_REQUEST['name'] : $name;
        $_extend = isset($_REQUEST['ext']) ? $_REQUEST['ext'] : $extend;



        if (is_null($_dir) && is_null($_file)) {
            return null;
        }



        $token = "=";
        $_dir = explode($token, $_dir);



        if (is_array($_dir)) {
            if (count($_dir) == 1) {
                $_dir = $_dir[0];
            } else {
                $_dir = implode("/", $_dir);
            }
        }


        $name_flag = FALSE;

        if (!$_name == NULL) {
            $name_flag = TRUE;
        }

        if (is_null($_extend)) {

            $e = explode(".", $_file);
            if (is_array($e) && count($e) > 1) {
                $_extend = $e[1];
                $_file = $e[0];
            } else if ($name_flag) {
                $e = explode(".", $_name);
                if (is_array($e) && count($e) > 1) {
                    $_extend = $e[1];
                    $_name = $e[0];
                }
            }
        }



        if ($_extend == NULL) {
            $this->output
                    ->set_output(FALSE);
            return;
        }




        $this->load->helper("url");

        $uri = base_url("$_dir/$_file.$_extend");


        header("Content-disposition: attachment; filename=" .
                $name_flag == TRUE ? $_name . "." . $_extend : $_file . "." . $_extend );


        $_extend = strtolower($_extend);

        switch ($_extend) {
            case "pdf":
                header("Content-type: application/" . $_extend);
                break;
            case "jpg":
            case "jpeg":
            case "png":
            case "gif":
                header("Content-type: image/" . $_extend);
                break;
            default :
                header("Content-type: application/octet-stream");
                break;
        }



        readfile($uri);
    }

    /**
     * @author Rolando Antonio Arriaza
     * @version 1.0.0
     * @todo esta funcion controla todos los test del sistema
     *        en pocas palabras sirve para testear pequeños codigos
     *
     * valor :   http://domain/Dashboard/test       ->SIMPLE
     *           http://domain/test                 ->ROUTE
     *
     *
     * * */
    public function test() {

       //$this->load->model("system_core");
      //  echo $this->system_core->get_langs();

        //https://www.pagadito.com/auxcall/gen.php?ahac=suscriptores&email=rolo@gmail.com

       // $this->load->library("curl");

        echo phpinfo();
    }

    /**
     * @author Rolando Arriaza
     * @version 1.0
     * @copyright (c) 2016,  Garrobo Core
     * @param string $function nombre de la funcion a llamar
     * @param String $dir directorio a llamar
     * @param String $model modelo a llamar
     *
     * @todo
     *
     *       estos parametros son opcionales porque request es compatible
     *       para metodos de tipo form o xhr
     *
     * peticion por metodo get o post
     *
     *      aplicamos input de tipo hidden  los names son [ dir , model , function]
     *
     *      Si deseas copia este codigo :
     *
     *      <input type="hidden" name="dir" value="directorio" />
     *      <input type="hidden" name="model" value="modelo" />
     *      <input type="hidden" name="function" value="funcion" />
     *
     *      no se te olvide cambiar los "values"
     *
     * * */
    public function Request($function = NULL, $dir = NULL, $model = NULL) {



        /**
         * seguridad para que no entren por algun lugar
         * no autorizado, ya acepta tokens definidos para
         * formularios o webservices
         * **/


        /*
         * variable de lenguaje ...
         * * */

       // $lang           = isset($_GET['lang']) ? $_GET['lang'] : isset($_POST['lang']) ? $_POST['lang'] : $this->lang;
        $token          = isset($_REQUEST['token']) ?? NULL;



        /**
         * Verificacion de parametros que esta entrando y por donde entra.
         * las entradas pueden ser por medio de la url , get o post method
         * verificamos los parametros de inicio
         * ** */
        $dir        = is_null($dir)          || empty($dir) ? NULL : $dir;
        $model      = is_null($model)        || empty($model) ? NULL : $model;
        $function   = is_null($function)     || empty($function) ? NULL : $function;


        /**
         * todo bien hasta aca , aca verificamos por donde esta entrando la data
         * que metodo se utiliza , en dado caso salte las dos condiciones
         * el metodo es por URL
         * * */
        if (count($_POST) >= 1) {

            $dir        = isset($_POST['dir']) ? $_POST['dir'] : $dir;
            $model      = isset($_POST['model']) ? $_POST['model'] : $model;
            $function   = isset($_POST['function']) ? $_POST['function'] : $function;

        } else if (count($_GET) >= 1) {

            $dir        = isset($_GET['dir']) ? $_GET['dir'] : $dir;
            $model      = isset($_GET['model']) ? $_GET['model'] : $model;
            $function   = isset($_GET['function']) ? $_GET['function'] : $function;
        }




        /**
         * asignacion de token para procesos externos
         * estos procesos externos pueden ser formularios
         * predefinidos , sistemas webservices , apis etc
         * para configurar un token ir a config.php
         *
         * a continuacion
         *
         *      $config['tokens'] = array( "funcion" => "codigo token")
         *
         * ***/

        //$this->load->library("session");
        //print_r($_SESSION);
       //return;


        if(!is_null($token) && !empty($token))
        {
            if(!isset($this->config->item("tokens")["$function"])
                        and $this->config->item("tokens")["$function"] != $token)
            {

                $this->output->set_output(json_encode([
                "status"    => "error",
                "message"   => core_lang([
                    "system",
                    "core",
                    "request",
                    "error_message"])
            ]));
                 return;
            }
        }
        else if(!$this->session_exist )
        {
            $this->output->set_output(json_encode([
                "status"    => "error",
                "message"   => core_lang([
                    "system",
                    "core",
                    "request",
                    "error_denied"])
            ]));
            return;
        }







        /**
         * error critico en request sin funcion no hay devolucion
         * * */
        if (is_null($function)) {

            $this->output->set_output(json_encode([

                "status" => "error",
                "message" => core_lang([
                    "system",
                    "core",
                    "request",
                    "error_message_function"])
            ]));

            return;
        }





        /**
         * verificamos el model y el directorio
         * ** */
        $create_model = "";
        $model_ = "";

        if ($dir == NULL && $model != NULL) {
            $create_model = ucfirst($model);
            $model_ = $model;
        } else if ($model == NULL) {
            $create_model = ucfirst($dir);
            $model_ = $dir;
        } else if ($dir !== NULL && $model !== NULL) {
            $create_model = $dir . "/" . ucfirst($model);
            $model_ = $dir . "/" . $model;
        } else {
            $this->output->set_output(json_encode([

                "status"        => "error",
                "message"       => core_lang([
                    "system",
                    "core",
                    "request",
                    "error_message_model"])
            ]));

            return;
        }



        //Existira este modelo dentro del directorio asignado ?

        if (!file_exists(APPPATH . "models/" . $create_model . ".php")) {

            $this->output->set_output(json_encode([

                "status" => "error",
                "message" => core_lang([
                    "system",
                    "core",
                    "request",
                    "error_message_model_asign"]) . " -->" . APPPATH . "models/" . $create_model . ".php"
            ]));
            return;
        }



        $this->load->model($model_, "request");


        if (!method_exists($this->request, $function)) {
            $this->output->set_output(json_encode([

                "status" => "error",
                "message" => core_lang([
                    "system",
                    "core",
                    "request",
                    "error_message_model_asign"])
            ]));
            return;
        }


        $this->output->set_output($this
                        ->request
                        ->$function());
    }


}
