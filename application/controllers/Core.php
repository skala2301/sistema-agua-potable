<?php

class Core extends CI_Controller
{
    
    public $version         = 1.0;
    
    public $name            = "CORE";
    
    public $sha             = "94a0426e8d3203da5468ccf0c624f93cb37601e2";
    
    protected $token        = "&";
    
    protected $star_page    = "i";
   
    public function __construct()
    {
        parent::__construct();
        
        $this->load
                ->helper(["url"]);
        
    }
    
    public function index() {


        $this->setup();
    }
    
    /**
     * @version 1.0
     * @author RoliGNU
     * @param string $params parametros de instalacion
     * @todo 
     * 
     * Funcion setup : funcion delegada del core en la cual se encarga 
     *                 de crear una nueva instalacion si esa no existe 
     *                 actualmente, se encargara de llamar la instalacion
     *                 en la vista asignada
     * 
     * 
     * parametros de instalacion predeterminados:
     * 
     *              install=clean 
     * 
     *                         le dices al algoritmo que la instalacion 
     *                         es nueva y debe de ser limpia 
     * 
     *              install=override
     * 
     *                          le dices al algoritmo que la instalacion
     *                          no esta del todo bien , que las bases de 
     *                          datos se necesitan sobre escribirse
     * 
     *             install=fail
     * 
     *                          la instalacion ha fallado totalmente
     *                          el algoritmo enviara los parametros 
     *                          anteriores para reintentar
     * 
     * ***/
    public function setup($params = "")
    {
       
        if($params != "")
        {
            
            //CORTAMOS LOS ARGUMENTOS , ESTOS TIENEN UN TOKEN &
            $arg = explode($this->token, $params);
            
            //LUEGO DE QUE LOS PARAMETROS SE HA CORTADO PROCEDEMOS A VACIAR LA VARIABLE NUEVO ARRAY
            $params = [];
            
            //VERIFICAMOS LOS ARGUMENTOS 
            //CADA AARGUMENTO SE VERIFICA CON EL TOKEN "=" NO PREDETERMINADO 
            //ESTO HARA QUE EL ARGUMENTO TENGA NOMBRE O SEA UN VALOR LINEAL
            foreach($arg as $argument)
            {
                $ex = explode("=", $argument);
                if(count($ex) <= 1)
                {
                    $params[] = $ex[0];
                }
                else
                {
                    $params[$ex[0]] = $ex[1];
                }
            }
            
            
            //VERIFICAMOS SI EXISTE EL PARAMETRO INSTALL
            //DADO CASO ESTE PARAMETRO NO EXISTE ENTONCES REDIRECCIONARA AL INICIO
            if(isset($params['install']))
            {
                switch($params['install'])
                {
                    case "clean":
                        $params['override']     = FALSE;
                        break;
                    case "override":
                        $params['override']     = TRUE; 
                        break;
                    case "fail":
                        $params['override']     = FALSE;
                        $params['fail']         = TRUE;
                        $params['inputs']       = [];
                        break;
                }


                $site = site_url();
                $params['css'] = [
                    'http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all',
                    $site . 'content/assets/global/plugins/font-awesome/css/font-awesome.min.css',
                    $site . 'content/assets/global/plugins/simple-line-icons/simple-line-icons.min.css',
                    $site . 'content/assets/global/plugins/bootstrap/css/bootstrap.min.css',
                    $site . 'content/assets/global/plugins/gritter/css/jquery.gritter.cs',
                    $site . 'content/assets/global/css/components.css',
                    $site . 'content/assets/global/css/plugins.css',
                    $site . 'content/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css',
                ];

                $params['js'] = [
                    $site . "content/assets/global/plugins/jquery.min.js",
                    $site . "content/assets/global/plugins/bootstrap/js/bootstrap.min.js",
                    $site . "content/assets/global/plugins/js.cookie.min.js",
                    $site . "content/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js",
                    $site . "content/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js",
                    $site . "content/assets/global/plugins/jquery.blockui.min.js",
                    $site . "content/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js",
                    $site . "content/assets/global/scripts/app.min.js",
                    $site . "content/assets/layouts/layout/scripts/layout.min.js",
                    $site . "content/assets/layouts/layout/scripts/demo.min.js",
                    $site . "content/assets/layouts/global/scripts/quick-sidebar.min.js"
                ];

                $this->load
                        ->view('system/setup/index' , ["params" => $params]);
                
            }
            else
            {
                redirect("$this->star_page/");
                return;
            }

           
        }
        else{
            
        }

    }
    
}
