<?php

class Front extends CI_Controller {

    protected $model_path       = "models";
    
    protected $error_404        =  "system/errors/404_error";
        
    protected  $routes_dir      =  ""  ;

    protected  $start           = "Main";


    public function __construct() {
        parent::__construct();
        $this->routes_dir = APPPATH . "config/MVA_ROUTES.json";
    }

    
    /**
     * 
     * @author Rolando Arriaza
     * @date 15-03-16
     * @version 1.4
     * @since 1.0
     * @todo Index es una funcion que puede controlar multiples paginas frontales
     *       la misma logica del mva pero un poco menos restringido
     * 
     *        esta logica solo se necesitan tres parametros 
     * 
     *        $call = string , este parametro hace referencia al archivo php 
     *                que desea llamar dentro de un model 
     *          
     *                 ejemplo :  models/frontend/helloworld.php 
     * 
     *        $call = "helloworld"
     * 
     *      
     *        siguiente parametro es $folder = NULL 
     *      
     *        se coloca null a un folder como defecto /models
     * 
     *        este parametro folder el igual a $folder = /frontend
     * 
     * 
     *        ultimo parametro es la accion o la funcion que se va a llamar 
     *        donde estaran las vistas en el frontend 
     * 
     *        digamos si la clase esta consstituida por 
     * 
     * 
     *        class helloworld 
     *        {
     * 
     *              public function ejecutar() { .... }
     *
     *        }
     * 
     * 
     *         entonces la accion seria $action = "ejecutar"
     * 
     * 
     *         como quedaria la URL de paso :
     * 
     *         ANTES QUE NADA LA URL TIENE UNA RUTA DEDICADA 
     *         QUE LA LLAMAREMOS "l" 
     * 
     *         SE PUEDE TRABAJAR DIRECTAMENTE CON Front (pero no lo recomiendo)
     * 
     * 
     *         la ruta quedara asi 
     * 
     *         l/helloworld/frontend/ejecutar
     * 
     * 
     *         FACIL NO !!!! 
     * 
     *          
     *         EN LA SIGUIENTE VERSION SE DESAROLLARA 
     *         RUTAS BONITAS O PRETTY ROUTES, PARA ASI LLAMAR 
     *         LA URL MAS CORTA O BONITA :) 
     * 
     * 
     *          --
     *              BUG FIXED 
     * 
     *                          COMUNICACION DE CONTROLADOR 
     *                          BUGS VARIOS DE SNETENCIA Y NOMBRE
     * 
     * 
     *      1.2 (15-03-16):
     * 
     *          -   SE AGREGO EL SISTEMA DE RUTAS 
     * 
     *                  LA CONFIGURACION DE RUTAS SE HACE EN MVA_ROUTES.JSON
     * 
     *          -   UNA RUTA SE COMPONE DE :
     *                          
     *                       "hello": "frontmain/frontend/action"
     * 
     *                          ruta   llamada    folder   action
     *
     *
     *      1.4 (08-09-2016)
     *
     *          - Bug fixed : dentro de la llamada al folfer dodne esta agregado el model del front-end
     *          - Add       : Se agrego folder por defecto del model , llamado frontend
     *          - New routes : dentro de MVA_ROUTES.json se puede agregar rutas de forma mas dinamica
     *
     *                          la sintaxis se mejor hoy es mas simple
     *
     *                                  --  "front-test":   ===> nombre corto
                                                {
                                                        "dir"     : "frontend",   ==> directorio
     *                                                  "model"   : "main",       ==> modelo
                                                        "action"  : "dothat"      ==> accion o funcion
                                                  }
     * 
     * **/
    
    public function index($call = "Main", $action = "index" , $folder = "frontend" ) {




        $model              = NULL;
        $error              = TRUE;
        $params             = NULL;
       // $action_name        = '';


        $routes = NULL;
        if(file_exists($this->routes_dir))
        {
            $routes = json_decode(file_get_contents($this->routes_dir));
        }


        if(sizeof($routes) != 0)
        {
            foreach($routes as $key => $value)
            {
                if(strcmp($key , $call) == 0)
                {
                    if(!is_object($value) || sizeof($value) == 0) break;

                    if(!is_array($action)) {
                        if ($action != "index" && !is_null($action)) {
                            $params = $action;
                        }
                    }else{
                        $params = $action;
                    }


                    $call       = $value->model ?? $call;
                    $action     = $value->action ?? $action;
                    $folder     = $value->dir ?? $folder;

                    break;
                }
            }
        }


        $action_name = $call;


        /**
         * verificamos si call es un frontmain 
         * dado caso sea un frontmain o frente por defecto 
         * se configurara el folder y el model.
         * 
         * 
         * en dado caso no sea por defecto se configurara el model a llamar
         * eso hace que verifique si esta dentro de un folder o no 
         * **/
        
        
        if(strtolower($call) == strtolower($this->start))
        {
            $model = "frontend" . "/" . $call ;
            $folder = "frontend";
        }
        else
        {
            $model = $folder != null ? $folder . "/"  : "" ;
            $model .= $call;
        }
        
        
   
        /**
         * cargamos recursividad de directorios 
         * aplicando la libreria FileInfo desarrollada por ROLIGNU
         * 
         * cargamos la direccion de la carpeta model.
         * **/
        
        $this->load
                ->library("FileInfo" , ["dir" => APPPATH . $this->model_path  ]);
        
        /**
         * obtenemos la data en un formato tipo array/stdclass
         * 
         * 
         * <example>
         *  stdClass Object ( 
                        [name] => Main.php 
         *              [lower_name] => frontmain.php 
                        [info] => C:\wamp64\www\portallieisoft_offline\application\models\frontend\Main.php 
                        [size] => 202 
                        [extension] => php 
                        [path] => C:\wamp64\www\portallieisoft_offline\application\models\frontend [
                        [last_update] => 1457648019 

            )
         * </example>
         * 
         * **/
        
        $paths = $this
                ->fileinfo
                ->GetFiles();
        

        $lower = strtolower($call . ".php");
        
        /**
         * algoritmo que verifica si esta dentro de los model 
         * el archivo y si ese archivo esta en su directorio 
         * correcto asi dar paso a la lectura de la accion 
         * en dado caso NO!! 404 
         * **/


        foreach($paths as $path)
        {
            if(strcmp(strtolower($lower), $path->lower_name) === 0)
            {
                
                $f =  $folder != null ?  "/" . $folder  : "";
                $d =  APPPATH . $this->model_path . $f . "/$path->name";
                
                if(file_exists($d))
                {
                    $error = false;
                }
                break;
            }
        }

        if ($error) {
            $this->Error_View($action_name);
        } else {
            
            $this->load->model($model, "container");
            if(method_exists($this->container, $action))
            {

                @$this->container->$action($params);
            }
            else
            {
                $this->Error_View($action_name);
            }
        }
    }


    public function Error_View ($name)
    {
        $this->load->view(
            $this->error_404,
            [
                "message"   => "La Pagina <b>$name</b> No esta disponible o se ha elimiando",
                "enabled"   => false,
                "request"   => "front"
            ]
        );
    }



    /**
     * @Author Rolando Arriaza
     * @version 1.0
     * @date  28-08-16
     * @param  string $route la ruta a generar
     * @param  parametros a inicializar
     **/

    public function index_routing($route, ... $params  )
    {
        $this->index($route , $params);
    }



    /**
     * @Author Rolando Arriaza
     * @version 1.0
     * @date  28-08-16
     * @param  string $dir  directorio donde se llamara la accion
     * @param  string $model model a llamar ejemplo mymodel => Mymodel.php
     * @param  string $function nombre de la funcion a llamar dentro del model asignado
    **/
    public function action ($dir , $model , $function)
    {


        /**
         * Verificacion de parametros que esta entrando y por donde entra.
         * las entradas pueden ser por medio de la url , get o post method
         * verificamos los parametros de inicio
         * ** */
        $dir        = is_null($dir)         || empty($dir) ? NULL : $dir;
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
         * error critico en request sin funcion no hay devolucion
         * * */
        if (is_null($function)) {

           /* $this->output->set_output(json_encode([

                "status" => "error",
                "message" => meta_lang($lang, [
                    "system",
                    "core",
                    "request",
                    "error_message"], $this->lang_file)
            ]));*/

            //devolucion de errrores

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
           /* $this->output->set_output(json_encode([

                "status"        => "error",
                "message"       => meta_lang($lang, [
                    "system",
                    "core",
                    "request",
                    "error_message"], $this->lang_file)
            ]));*/

            return;
        }



        //Existira este modelo dentro del directorio asignado ?

        if (!file_exists(APPPATH . "models/" . $create_model . ".php")) {

          /*  $this->output->set_output(json_encode([

                "status" => "error",
                "message" => meta_lang($lang, [
                    "system",
                    "core",
                    "request",
                    "error_message"], $this->lang_file)
            ]));*/
            return;
        }



        $this->load->model($model_, "request");


        if (!method_exists($this->request, $function)) {
          /*  $this->output->set_output(json_encode([

                "status" => "error",
                "message" => meta_lang($lang, [
                    "system",
                    "core",
                    "request",
                    "error_message"], $this->lang_file)
            ]));*/
            return;
        }


        $this->output->set_output($this
            ->request
            ->$function());
        

    }



}
