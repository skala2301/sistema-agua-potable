<?php

class System {
    
    
    private $class                      = NULL;

    private $file_config                = NULL;

    protected $config_object            = NULL;

    protected $error                    = [];
    
    public function __construct() {
        $this->class            = &get_instance();
        $this->file_config      = $this->class->config->item('data_config_path');
    }

    public function set_headers(array $params = array())
    {
        
        $params['css_system'] =  print_css([
                "bootstrap",
                "fontawesome",
                "ga_format",
                "content/assets/global/plugins/simple-line-icons/simple-line-icons.min.css",
                "content/assets/global/plugins/uniform/css/uniform.default.css",
                "content/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css",
                "content/assets/global/plugins/gritter/css/jquery.gritter.css",
                "content/assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css",
                "content/assets/global/plugins/fullcalendar/fullcalendar/fullcalendar.css",
                "content/assets/global/plugins/jqvmap/jqvmap/jqvmap.css",
                "content/assets/global/css/components.css",
                "content/assets/global/css/plugins.css",
                "content/assets/layouts/layout/css/layout.css",
                "content/assets/layouts/layout/css/themes/darkblue.min.css",
                "content/assets/layouts/layout/css/custom.css",
                "content/assets/dashboard/css/ga_dashboard.css",
                "toast",
                "content/assets/global/plugins/css/components.min.css",
                "content/assets/global/plugins/css/plugins.min.css",
                "content/assets/global/plugins/ladda/ladda-themeless.min.css",
                "content/assets/global/plugins/pace/themes/pace-theme-flash.css"
             
        ], "url");


        $params['js_system'] = print_javascript([

            "content/assets/global/plugins/pace/pace.min.js",
            "jquery",
            "systemjs",
            "babel" ,
            "react" ,
            "reactdom" ,
             "render_vars",
            "toast",
            "ga_toast"

        ], "url" );
        
 

        $this->class
                ->load
                ->view("system/dashboard/header" , $params);
        
       
        
    }

    public function set_footers(array $params = array() )
    {

        $params['js_system'] = print_javascript([
            "bootstrap" ,
            "remarkable",
            "ga_",
            "boot",
            'fb-immutable'
        ], "url" );
        


        $params['js_babel'] = print_javascript([
            "ga_sidebar"//,
            //"render"
        ] , "url");


        $params['js_functions'] = print_javascript([
            "content/assets/global/plugins/js.cookie.min.js",
            "content/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js",
            "content/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js",
            "content/assets/global/plugins/jquery.blockui.min.js",
            "content/assets/global/plugins/uniform/jquery.uniform.min.js",
            "content/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js",
            "content/assets/global/scripts/app.min.js",
            "content/assets/layouts/layout/scripts/layout.min.js",
            "content/assets/layouts/layout/scripts/demo.min.js",
            "content/assets/layouts/global/scripts/quick-sidebar.min.js",
            "content/assets/global/plugins/ladda/spin.min.js",
            "content/assets/global/plugins/ladda/ladda.min.js"

        ], "url");


        $this->class
                ->load
                ->view("system/dashboard/footer" , $params);
    }
    
    public function set_navbar(array $params = array())
    {
        $this->class
                ->load
                ->view("system/dashboard/navbar" , $params);
    }

    public function set_sidebar(array $params = array())
    {
        $this->class
                ->load
                ->view("system/dashboard/sidebar" , $params);
    }



    /**
     * @deprecated 1.0.2
     * @author Rolando Arriaza
    **/
    public function  get_CoreLang() : array
    {

        $langs = [];

        $path = $this->class
                        ->config
                        ->item("setup_")['core_config'];

        if(!file_exists($path)) return  $langs;

        $content        = file_get_contents($path);
        $content        = json_decode($content)->langs;

        foreach ($content as $key => $lang)
            $langs[$key] = $lang ;

        return $langs;

    }


    /**
     * -----------------------------------------------------------------------------------------------------------------
     *
     *
     *
     *
     * #REGION System configuration case
     * @author Rolando Arriaza
     * @since Garrobo version 1.2.1
     *
     *
     *
     *
     * -----------------------------------------------------------------------------------------------------------------
    */




    /**
     * @author Rolando Arriaza
     * @version 1.0.0
     * @since 1.2.2
     * @todo preapare file config .json locale
    **/
    public function load_config($format = "object")
    {
        switch ($format)
        {
            case "object":
                $this->config_object = @json_decode(file_get_contents($this->file_config)) ?? NULL;
                break;
            case "array":
                $this->config_object = @json_decode(file_get_contents($this->file_config) , JSON_OBJECT_AS_ARRAY) ?? NULL;
                break;
        }

        if(is_null($this->config_object))
            $this->error[] = (object) [
               "code"   => 0X01,
                "msj"   => "FILE CAN'T BEEN OPEN "
            ];

        return $this;
    }


    /***
     *get all config , object stdclass
    **/
    public function get_config()
    {
        if($this->get_error_code(0X01)) return new stdClass();
        return $this->config_object;
    }



    public function set_item_config($item_key , $item_value) : bool
    {
        if($this->get_error_code(0X01)) return false;


        if(!is_array($item_key)) {
            if (isset($this->config_object->$item_key)) {
                $this->config_object->$item_key = $item_value;
            }
        }

        /*
         * for that moment don´t support array items
         * ***/

        @file_put_contents( $this->file_config ,  json_encode($this->config_object));

        return true;

    }



    
    public function set_config( $object)
    {
        return @file_put_contents($this->file_config , json_encode($object));
    }




    /**
     * get error code if exist.
    ***/
    private function  get_error_code($code) : bool
    {
        foreach($this->error as $error)
        {
            if(($error->code <=> $code ) == 0)
            {
                return TRUE;
            }
        }

        return FALSE;
    }





    
}
